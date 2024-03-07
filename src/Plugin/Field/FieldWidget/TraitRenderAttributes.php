<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldWidget;

use Drupal\commerce_product\Entity\ProductAttributeValue;

/**
 *
 * @author stephane
 *        
 */
trait TraitRenderAttributes {
  
  function AttributeRender(ProductAttributeValue $attribute) {
    return \Drupal::entityTypeManager()->getViewBuilder('commerce_product_attribute_value')->view($attribute);
  }
  
  function AttributesRenders(array $attributes, $class = null) {
    $results = [];
    foreach ($attributes as $attribute) {
      /**
       *
       * @var ProductAttributeValue $attribute
       */
      $attributeR = $this->AttributeRender($attribute);
      $attributeR['#attributes']['title'] = $attribute->bundle() . ": " . $attribute->label();
      if ($class)
        $attributeR['#attributes']['class'][] = $class;
      $results[] = $attributeR;
    }
    return $results;
  }
  
}
