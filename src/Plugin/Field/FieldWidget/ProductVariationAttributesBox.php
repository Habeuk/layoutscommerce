<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_price\CurrencyFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_product\Plugin\Field\FieldWidget\ProductVariationAttributesWidget;
use Stephane888\Debug\debugLog;

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
      $attribute_values = (array) NestedArray::getValue($form_state->getUserInput(), $parents);
      $selected_variation = $this->variationAttributeMapper->selectVariation($variations, $attribute_values);
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
    
    /**
     *
     * @var \Drupal\commerce_price\Price $price
     */
    
    foreach ($this->variationAttributeMapper->prepareAttributes($selected_variation, $variations) as $field_name => $attribute) {
      /**
       *
       * @var \Drupal\commerce_product\PreparedAttribute $attribute
       */
      $options = [];
      $values = $attribute->getValues();
      $variations = $this->getAttributesFromVariations($variations, $field_name);
      
      foreach ($values as $k => $value) {
        if (!empty($variations[$k]))
          $price = $variations[$k]->getPrice();
        else
          $price = $selected_variation->getPrice();
        
        //
        $render_attributes = [
          '#theme' => 'layoutscommerce_attribute_items',
          '#price' => $this->currency_formatter->format($price->getNumber(), $price->getCurrencyCode()),
          '#items' => $value,
          '#currency' => $price->getCurrencyCode()
        ];
        // $options[$k] = $this->renderer->render($render_attributes);
        $options[$k] = $render_attributes;
      }
      // dump($options);
      // dump($attribute->getElementType());
      $attribute_element = [
        // le type doit etre "radios", configurer cela au niveau des attributes
        // : /admin/commerce/product-attributes
        '#type' => $attribute->getElementType(),
        // '#title' => $attribute->getLabel(),
        '#options' => $options,
        '#required' => $attribute->isRequired(),
        '#default_value' => $selected_variation->getAttributeValueId($field_name),
        '#limit_validation_errors' => [],
        '#attributes' => [
          'class' => [
            'product-pricer'
          ],
          'title' => $attribute->getLabel()
        ],
        '#wrapper_attributes' => [
          'class' => [
            'product-pricer'
          ]
        ],
        '#ajax' => [
          'callback' => [
            get_class($this),
            'ajaxRefresh'
          ],
          'wrapper' => $form['#wrapper_id'],
          // Prevent a jump to the top of the page.
          'disable-refocus' => TRUE
        ]
      ];
      // Convert the _none option into #empty_value.
      if (isset($attribute_element['#options']['_none'])) {
        if (!$attribute_element['#required']) {
          $attribute_element['#empty_value'] = '';
        }
        unset($attribute_element['#options']['_none']);
      }
      // Optimize the UX of optional attributes:
      // - Hide attributes that have no values.
      // - Require attributes that have a value on each variation.
      if (empty($attribute_element['#options'])) {
        $attribute_element['#access'] = FALSE;
      }
      if (!isset($element['attributes'][$field_name]['#empty_value'])) {
        $attribute_element['#required'] = TRUE;
      }
      
      $element['attributes'][$field_name] = $attribute_element;
    }
    
    return $element;
  }
  
}