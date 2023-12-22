<?php

namespace Drupal\layoutscommerce\Services;

use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_price\CurrencyFormatter;

/**
 *
 * @author stephane
 * @deprecated
 */
class LayoutscommerceProductVariation {
  /**
   *
   * @var ProductVariation
   */
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
   * Permet d'obtenir le rendu du champs prix de la product variation.
   * //
   * * Cette logique est deprecit car il faut passer par le champs de rendu afin
   * d'obtenir les champs sur la variations.
   * (example, prix, titre de la variation et autres).
   *
   * @deprecated
   */
  function getRenderField($fiedProduct, array &$build, $field_variation = 'price') {
    if ($this->getVariant($fiedProduct)) {
      if ($field_variation == 'price') {
        /**
         *
         * @var \Drupal\commerce_price\Price $price
         */
        $price = $this->product_variation->getPrice();
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
  
  /**
   * Permet d'obtenir le rendu du champs prix de la product variation.
   * Compliquer d'obtenir le formulaire, on va juste transferer les données de
   * references du produit et laisser JS, faire le reste du TAF.
   * //
   * * Cette logique est deprecit car il faut passer par le champs de rendu afin
   * d'obtenir les champs sur la variations.
   * (example, prix, titre de la variation et autres).
   *
   * @deprecated
   */
  function getRenderAddToCart($fiedProduct, array &$build, $region_name = 'icon_add_to_cart', $regionContent = null) {
    if ($this->getVariant($fiedProduct)) {
      // dump($build[$region_name]['#attributes']);
      /**
       * La clée 'custom-add-to-cart' permet de proteger les attributes dans le
       * renu.
       * cela evite les doublons d'attibutes.
       */
      $build[$region_name]['custom-add-to-cart'] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#attributes' => [
          'data-procuct-variant-id' => $this->product_variation->id(),
          'class' => [
            'commerceformatage-button-add-to-cart'
          ]
        ],
        [
          '#type' => 'html_tag',
          '#tag' => 'i',
          '#attributes' => [
            'class' => [
              'fas',
              'fa-cart-plus'
            ]
          ]
        ],
        $regionContent,
        [
          '#type' => 'html_tag',
          '#tag' => 'i',
          '#attributes' => [
            'class' => [
              'fas',
              'fa-spinner',
              'loading',
              'd-none'
            ]
          ]
        ]
      ];
    }
  }
  
  /**
   *
   * @param array $fiedProduct
   * @return boolean
   */
  protected function getVariant($fiedProduct) {
    $fiedProduct = reset($fiedProduct);
    if (!empty($fiedProduct['content']['#object'])) {
      
      /**
       *
       * @var Product $product
       */
      $product = $fiedProduct['content']['#object'];
      if ($product) {
        $this->product_variation = $product->getDefaultVariation();
        // dump($this->product_variation);
        if ($this->product_variation)
          return true;
        else {
          \Drupal::messenger()->addWarning(' Le produit "' . $product->getTitle() . '(' . $product->id() . ')" ' . " n'a pas de variation");
        }
      }
      else
        \Drupal::messenger()->addWarning('impossible de terminer le produit ...');
    }
    return false;
  }
  
}

