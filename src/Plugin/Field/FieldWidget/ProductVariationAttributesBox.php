<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_price\CurrencyFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_product\Plugin\Field\FieldWidget\ProductVariationAttributesWidget;
use Drupal\commerce_product\Entity\ProductInterface;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_product\Event\ProductEvents;
use Drupal\commerce_product\Event\ProductVariationAjaxChangeEvent;
use Drupal\commerce_product\Ajax\UpdateProductUrlCommand;

/**
 * Plugin implementation of the 'commerce_product_variation_attributes' widget.
 *
 * @FieldWidget(
 *   id = "product_variation_attributes_box",
 *   label = @Translation("Product variation attributes box"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class ProductVariationAttributesBox extends ProductVariationAttributesWidget {
  use TraitRenderAttributes;
  /**
   * Regroupe les variation en function de l'id de attribut.
   * Facilite la recherche.
   *
   * @var array
   */
  private $variationsByAttributesIds = [];
  
  /**
   * Renderer service.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;
  
  /**
   *
   * @var CurrencyFormatter
   */
  protected $currency_formatter;
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->renderer = $container->get('renderer');
    $instance->currency_formatter = $container->get('commerce_price.currency_formatter');
    return $instance;
  }
  
  /**
   * --
   */
  private function getAttributesFromVariations(array $variations, $field_name) {
    if (empty($this->variationsByAttributesIds[$field_name]))
      foreach ($variations as $variation) {
        /** @var \Drupal\commerce_product\Entity\ProductVariationInterface $variation */
        $this->variationsByAttributesIds[$field_name][$variation->getAttributeValueId($field_name)] = $variation;
      }
    return $this->variationsByAttributesIds[$field_name];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $form_state->get('product');
    $variations = $this->loadEnabledVariations($product);
    if (count($variations) === 0) {
      // Nothing to purchase, tell the parent form to hide itself.
      $form_state->set('hide_form', TRUE);
      $element['variation'] = [
        '#type' => 'value',
        '#value' => 0
      ];
      return $element;
    }
    elseif (count($variations) === 1) {
      /** @var \Drupal\commerce_product\Entity\ProductVariationInterface $selected_variation */
      $selected_variation = reset($variations);
      // If there is 1 variation but there are attribute fields, then the
      // customer should still see the attribute widgets, to know what they're
      // buying (e.g a product only available in the Small size).
      /**
       * S'il y a 1 variation mais qu'il y a des champs d'attributs, le client
       * doit toujours voir les widgets d'attributs, pour savoir ce qu'il achète
       * (par exemple, un produit uniquement disponible en petite taille)
       */
      if (empty($this->attributeFieldManager->getFieldDefinitions($selected_variation->bundle()))) {
        $element['variation'] = [
          '#type' => 'value',
          '#value' => $selected_variation->id()
        ];
        $price = $selected_variation->getPrice();
        $element['attributes'][] = [
          '#theme' => 'layoutscommerce_attribute_items',
          '#price' => $this->currency_formatter->format($price->getNumber(), $price->getCurrencyCode()),
          '#items' => '',
          '#currency' => $price->getCurrencyCode()
        ];
        return $element;
      }
      // else {
      // dump($selected_variation->bundle());
      // dump($this->attributeFieldManager->getFieldDefinitions($selected_variation->bundle()));
      // }
    }
    
    // Build the full attribute form.
    $wrapper_id = Html::getUniqueId('commerce-product-add-to-cart-form');
    $form += [
      '#wrapper_id' => $wrapper_id,
      '#prefix' => '<div id="' . $wrapper_id . '">',
      '#suffix' => '</div>'
    ];
    
    // If an operation caused the form to rebuild, select the variation from
    // the user's current input.
    /**
     *
     * @var \Drupal\commerce_product\Entity\ProductVariation
     */
    $selected_variation = NULL;
    if ($form_state->isRebuilding()) {
      $parents = array_merge($element['#field_parents'], [
        $items->getName(),
        $delta,
        'attributes'
      ]);
      $userInputs = $form_state->getUserInput();
      if (!empty($userInputs['purchased_entity'][0]['merge_commerce_product_variation_id'])) {
        // (Langues pas pris en change.)
        $selected_variation = ProductVariation::load($userInputs['purchased_entity'][0]['merge_commerce_product_variation_id']);
      }
      else {
        $attribute_values = (array) NestedArray::getValue($form_state->getUserInput(), $parents);
        $selected_variation = $this->variationAttributeMapper->selectVariation($variations, $attribute_values);
      }
    }
    // Otherwise fallback to the default.
    if (!$selected_variation) {
      /** @var \Drupal\commerce_order\Entity\OrderItemInterface $order_item */
      $order_item = $items->getEntity();
      if ($order_item->isNew()) {
        $selected_variation = $this->getDefaultVariation($product, $variations);
      }
      else {
        $selected_variation = $order_item->getPurchasedEntity();
      }
    }
    
    $element['variation'] = [
      '#type' => 'value',
      '#value' => $selected_variation->id()
    ];
    // Set the selected variation in the form state for our AJAX callback.
    $form_state->set('selected_variation', $selected_variation->id());
    
    $element['attributes'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'attribute-widgets'
        ]
      ]
    ];
    $options = [];
    // On liste les variations avec les options comme label.
    foreach ($variations as $variation) {
      /**
       *
       * @var \Drupal\commerce_product\Entity\ProductVariation $variation
       */
      $price = $variation->getPrice();
      $attributes = $this->AttributesRenders($variation->getAttributeValues(), 'product-pricer__item_size');
      $render_attributes = [
        '#theme' => 'layoutscommerce_attribute_items',
        '#price' => $this->currency_formatter->format($price->getNumber(), $price->getCurrencyCode()),
        '#items' => $attributes,
        '#currency' => $price->getCurrencyCode()
      ];
      $options[$variation->id()] = $render_attributes;
    }
    /**
     * Ce champs melange + attributs.
     */
    $element['merge_commerce_product_variation_id'] = [
      '#type' => 'radios',
      '#title' => '',
      '#options' => $options,
      '#required' => true,
      '#default_value' => $selected_variation->id(),
      '#limit_validation_errors' => [],
      '#attributes' => [
        'class' => [
          'product-pricer'
        ]
      ],
      '#wrapper_attributes' => [
        'class' => [
          'product-pricer'
        ]
      ],
      '#ajax' => [
        'callback' => [
          get_class($this),
          'ajaxSelectProductVariant'
        ],
        'wrapper' => $form['#wrapper_id'],
        // Prevent a jump to the top of the page.
        'disable-refocus' => TRUE
      ]
    ];
    return $element;
  }
  
  /**
   * #ajax callback: Replaces the rendered fields on variation change.
   *
   * Assumes the existence of a 'selected_variation' in $form_state.
   */
  public static function ajaxSelectProductVariant(array $form, FormStateInterface $form_state) {
    $purchased_entity = $form_state->getValue('purchased_entity');
    /** @var \Drupal\Core\Render\MainContent\MainContentRendererInterface $ajax_renderer */
    $ajax_renderer = \Drupal::service('main_content_renderer.ajax');
    $request = \Drupal::request();
    $route_match = \Drupal::service('current_route_match');
    /** @var \Drupal\Core\Ajax\AjaxResponse $response */
    $response = $ajax_renderer->renderResponse($form, $request, $route_match);
    if (!empty($purchased_entity[0]['merge_commerce_product_variation_id'])) {
      $variation = ProductVariation::load($purchased_entity[0]['merge_commerce_product_variation_id']);
    }
    else
      $variation = ProductVariation::load($form_state->get('selected_variation'));
    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $form_state->get('product');
    if ($variation->hasTranslation($product->language()->getId())) {
      $variation = $variation->getTranslation($product->language()->getId());
    }
    /** @var \Drupal\commerce_product\ProductVariationFieldRendererInterface $variation_field_renderer */
    $variation_field_renderer = \Drupal::service('commerce_product.variation_field_renderer');
    $view_mode = $form_state->get('view_mode');
    $variation_field_renderer->replaceRenderedFields($response, $variation, $view_mode);
    // Update Product URL to include variation query parameter.
    $response->addCommand(new UpdateProductUrlCommand($variation->id()));
    
    // Allow modules to add arbitrary ajax commands to the response.
    $event = new ProductVariationAjaxChangeEvent($variation, $response, $view_mode);
    $event_dispatcher = \Drupal::service('event_dispatcher');
    $event_dispatcher->dispatch($event, ProductEvents::PRODUCT_VARIATION_AJAX_CHANGE);
    
    return $response;
  }
  
}