<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldFormatter;

use Drupal\commerce_price\Plugin\Field\FieldFormatter\PriceCalculatedFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\commerce\Context;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Language\LanguageInterface;

/**
 * Plugin implementation of the 'commerce_price_calculated' formatter.
 *
 * @FieldFormatter(
 *   id = "layoutscommerce_price_with_duration",
 *   label = @Translation("Price Calculate with duration"),
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
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    if (!$items->isEmpty()) {
      $context = new Context($this->currentUser, $this->currentStore->getStore(), NULL, [
        'field_name' => $items->getName()
      ]);
      
      /** @var \Drupal\commerce\PurchasableEntityInterface $purchasable_entity */
      $purchasable_entity = $items->getEntity();
      $resolved_price = $this->chainPriceResolver->resolve($purchasable_entity, 1, $context);
      $number = $resolved_price->getNumber();
      $currency_code = $resolved_price->getCurrencyCode();
      $options = $this->getFormattingOptions();
      $currency = \Drupal::entityTypeManager()->getStorage('commerce_currency')->load($currency_code)->getSymbol();
      $elements[0] = [
        '#theme' => 'layoutscommerce_price_calculated',
        '#calculated_price' => $this->currencyFormatter->format($number, $currency_code, $options),
        '#purchasable_entity' => $purchasable_entity,
        '#currency_code' => $currency,
        '#duration' => '/ Per Course',
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