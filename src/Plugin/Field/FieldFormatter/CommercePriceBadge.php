<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\commerce\Context;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\commerce_order\Plugin\Field\FieldFormatter\PriceCalculatedFormatter;

/**
 * Plugin implementation of the 'commerce_price_calculated' formatter.
 *
 * @FieldFormatter(
 *   id = "layoutscommerce_price_badge",
 *   label = @Translation("Badge amout|percent of calculate price"),
 *   description = @Translation("Allows you to display the crossed out price, the percentage or the reduction if the value exists"),
 *   field_types = {
 *     "commerce_price"
 *   }
 * )
 */
class CommercePriceBadge extends PriceCalculatedFormatter {
  
  /**
   *
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'type_dispplay' => "default_price",
      'value_class' => ''
    ] + parent::defaultSettings();
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['type_dispplay'] = [
      '#type' => 'select',
      '#title' => 'type_dispplay',
      "#default_value" => $this->getSetting('type_dispplay'),
      '#options' => [
        'default_price' => 'Default price',
        'amount_reduce' => 'Amount reduce',
        'percent_reduce' => 'Percent reduce'
      ]
    ];
    $form['value_class'] = [
      '#type' => 'textfield',
      '#title' => 'price_class',
      "#default_value" => $this->getSetting('value_class')
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
      $calculated_price_number = (int) $calculated_price->getNumber();
      $default_price = $result->getBasePrice();
      $default_price_number = (int) $default_price->getNumber();
      $value = NULL;
      if ($calculated_price_number < $default_price_number) {
        $options = $this->getFormattingOptions();
        $type_dispplay = $this->getSetting('type_dispplay');
        if ($type_dispplay == 'default_price') {
          $value = $this->currencyFormatter->format($default_price->getNumber(), $default_price->getCurrencyCode(), $options);
        }
        elseif ($type_dispplay == 'amount_reduce') {
          $value = $this->currencyFormatter->format($calculated_price_number - $default_price_number, $default_price->getCurrencyCode(), $options);
        }
        elseif ($type_dispplay == 'percent_reduce') {
          $percent = (($calculated_price_number - $default_price_number) / $default_price_number) * 100;
          $value = round($percent, 0) . '%';
        }
      }
      
      //
      $value_class = new Attribute();
      $value_class->addClass($this->getSetting('value_class'));
      
      $elements[0] = [
        '#theme' => 'layoutscommerce_badge',
        '#value' => $value,
        '#value_class' => $value_class,
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