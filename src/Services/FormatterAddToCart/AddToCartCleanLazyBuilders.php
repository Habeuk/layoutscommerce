<?php

namespace Drupal\layoutscommerce\Services\FormatterAddToCart;

/**
 *
 * @author stephane
 *        
 */
class AddToCartCleanLazyBuilders extends AddToCartDefaultLazyBuilders {
  /**
   * Permet de definir la maniere donc le formulaire commerce_order_item doit
   * s'afficher.
   *
   * @var string
   */
  protected $view_mode_commerce_order_item = 'add_to_cart_flat';
  
}