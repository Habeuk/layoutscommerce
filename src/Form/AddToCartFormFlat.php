<?php

namespace Drupal\layoutscommerce\Form;

use Drupal\commerce_cart\Form\AddToCartForm;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 * @author stephane
 *        
 */
class AddToCartFormFlat extends AddToCartForm {
  
  /**
   *
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $actions['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add to cart'),
      '#submit' => [
        '::submitForm'
      ],
      '#attributes' => [
        'class' => [
          'button--add-to-cart',
          'p-0',
          'm-0',
          'h-auto',
          'text-primary'
        ]
      ]
    ];
    
    return $actions;
  }
  
}