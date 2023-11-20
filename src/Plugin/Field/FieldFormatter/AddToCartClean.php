<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_product\Plugin\Field\FieldFormatter\AddToCartFormatter;

/**
 * Plugin implementation of the 'commerce_add_to_cart' formatter.
 *
 * @FieldFormatter(
 *   id = "layoutscommerce_add_to_cart",
 *   label = @Translation("Add to cart form, flat by layoutscommerce"),
 *   field_types = {
 *     "entity_reference",
 *   },
 * )
 */
class AddToCartClean extends AddToCartFormatter {
  
  /**
   *
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);
    return $elements;
  }
  
}