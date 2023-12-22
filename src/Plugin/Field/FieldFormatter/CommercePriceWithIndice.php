<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldFormatter;

use Drupal\commerce_order\Plugin\Field\FieldFormatter\PriceCalculatedFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\commerce\Context;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;

/**
 * Plugin implementation of the 'commerce_price_calculated' formatter.
 *
 * @FieldFormatter(
 *   id = "layoutscommerce_price_with_duration",
 *   label = @Translation("Calculate with duration ( 35€/mois )"),
 *   field_types = {
 *     "commerce_price"
 *   }
 * )
 */
class CommercePriceWithIndice extends PriceCalculatedFormatter {
  
  /**
   *
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'duration_value' => "/ Per Course",
      'content_class' => 'align-items-start d-flex',
      'symbol_class' => 'h5 font-weight-bold mb-0',
      'price_class' => '',
      'duration_class' => 'h6 mb-0'
    ] + parent::defaultSettings();
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['duration_value'] = [
      '#type' => 'textfield',
      '#title' => 'Duration value',
      "#default_value" => $this->getSetting('duration_value'),
      '#description' => "Permet d'ajouter un prefixe à la suite du prix"
    ];
    $form['content_class'] = [
      '#type' => 'textfield',
      '#title' => 'content_class',
      "#default_value" => $this->getSetting('content_class')
    ];
    $form['symbol_class'] = [
      '#type' => 'textfield',
      '#title' => 'symbol_class',
      "#default_value" => $this->getSetting('symbol_class')
    ];
    $form['price_class'] = [
      '#type' => 'textfield',
      '#title' => 'price_class',
      "#default_value" => $this->getSetting('price_class')
    ];
    $form['duration_class'] = [
      '#type' => 'textfield',
      '#title' => 'Duration value',
      "#default_value" => $this->getSetting('duration_class')
    ];
    return $form + parent::settingsForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    if (!$items->isEmpty()) {
      $context = new Context($this->currentUser, $this->currentStore->getStore(), NULL, [
        'field_name' => $items->getName()
      ]);
      
      /** @var \Drupal\commerce\PurchasableEntityInterface $purchasable_entity */
      $purchasable_entity = $items->getEntity();
      $adjustment_types = array_filter($this->getSetting('adjustment_types'));
      $result = $this->priceCalculator->calculate($purchasable_entity, 1, $context, $adjustment_types);
      $calculated_price = $result->getCalculatedPrice();
      $currency_code = $calculated_price->getCurrencyCode();
      //
      $options = $this->getFormattingOptions();
      $currency = \Drupal::entityTypeManager()->getStorage('commerce_currency')->load($currency_code)->getSymbol();
      // class
      $content_class = new Attribute();
      $content_class->addClass($this->getSetting('content_class'));
      $symbol_class = new Attribute();
      $symbol_class->addClass($this->getSetting('symbol_class'));
      $price_class = new Attribute();
      $price_class->addClass($this->getSetting('price_class'));
      $duration_class = new Attribute();
      $duration_class->addClass($this->getSetting('duration_class'));
      
      $elements[0] = [
        '#theme' => 'layoutscommerce_price_calculated',
        '#calculated_price' => $this->currencyFormatter->format($calculated_price->getNumber(), $currency_code, $options),
        '#purchasable_entity' => $purchasable_entity,
        '#currency_code' => $currency,
        '#duration' => $this->getSetting('duration_value'),
        '#content_class' => $content_class,
        '#symbol_class' => $symbol_class,
        '#price_class' => $price_class,
        '#duration_class' => $duration_class,
        '#cache' => [
          'tags' => $purchasable_entity->getCacheTags(),
          'contexts' => Cache::mergeContexts($purchasable_entity->getCacheContexts(), [
            'languages:' . LanguageInterface::TYPE_INTERFACE,
            'country'
          ])
        ]
      ];
    }
    return $elements;
  }
  
}