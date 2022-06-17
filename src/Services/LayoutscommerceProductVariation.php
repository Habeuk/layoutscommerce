<?php

namespace Drupal\layoutscommerce\Services;

use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_price\CurrencyFormatter;

class LayoutscommerceProductVariation {
  protected $product_variation = null;
  
  /**
   *
   * @var CurrencyFormatter
   */
  protected $currency_formatter;
  
  function __construct(CurrencyFormatter $CurrencyFormatter) {
    $this->currency_formatter = $CurrencyFormatter;
  }
  
  /**
   * Permet d'obtenir le rendu d'un champs product variation.
   */
  function getRenderField($fiedProduct, array &$build, $field_variation = 'price') {
    if (!$this->product_variation) {
      $fiedProduct = reset($fiedProduct);
      if (!empty($fiedProduct['content']['#object'])) {
        /**
         *
         * @var Product $fiedProduct
         */
        $product = $fiedProduct['content']['#object'];
        $product_id = $product->id();
        // price field;
        if ($product_id) {
          $productVariation = $product->getDefaultVariation();
          if ($productVariation) {
            //
            if ($field_variation == 'price') {
              /**
               *
               * @var \Drupal\commerce_price\Price $price
               */
              $price = $productVariation->getPrice();
              $build['price'][] = [
                '#type' => 'html_tag',
                '#tag' => 'div',
                '#value' => $this->currency_formatter->format($price->getNumber(), $price->getCurrencyCode())
              ];
            }
            else {
              //
            }
          }
        }
      }
    }
  }
  
}

