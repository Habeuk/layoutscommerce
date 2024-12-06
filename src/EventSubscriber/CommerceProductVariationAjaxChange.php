<?php

namespace Drupal\layoutscommerce\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\commerce_product\Event\ProductEvents;
use Drupal\commerce_product\Event\ProductVariationAjaxChangeEvent;
use Drupal\more_fields\Ajax\CustomCommand;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 *
 * @author stephane
 *        
 */
class CommerceProductVariationAjaxChange implements EventSubscriberInterface {
  
  /**
   * The product variation.
   *
   * @var \Drupal\commerce_product\Entity\ProductVariationInterface
   */
  protected $productVariation;
  
  /**
   * The ajax response.
   *
   * @var \Drupal\Core\Ajax\AjaxResponse
   */
  protected $response;
  
  /**
   * The view mode.
   *
   * @var string
   */
  protected $viewMode;
  
  function AddBasicEventReponse(ProductVariationAjaxChangeEvent $event) {
    $this->productVariation = $event->getProductVariation();
    $this->response = $event->getResponse();
    $this->viewMode = $event->getViewMode();
    $config = \Drupal::config('layoutscommerce.ajax_load_view_product_variant')->getRawData();
    if (!empty($config['load_displays_1']['selecteur']) && !empty($config['load_displays_1']['view_mode'])) {
      $productVariation = \Drupal::entityTypeManager()->getViewBuilder("commerce_product_variation")->view($this->productVariation, $config['load_displays_1']['view_mode']);
      $this->response->addCommand(new ReplaceCommand($config['load_displays_1']['selecteur'], $productVariation));
    }
    if (!empty($config['load_displays_2']['selecteur']) && !empty($config['load_displays_2']['view_mode'])) {
      $productVariation = \Drupal::entityTypeManager()->getViewBuilder("commerce_product_variation")->view($this->productVariation, $config['load_displays_2']['view_mode']);
      $this->response->addCommand(new ReplaceCommand($config['load_displays_2']['selecteur'], $productVariation));
    }
    
    // On doit retirer ceci et les elements annexes apres le tutos.
    // $this->response->addCommand(new CustomCommand('This is a custom AJAX
    // command! by hbk KKKKK'));
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      ProductEvents::PRODUCT_VARIATION_AJAX_CHANGE => [
        'AddBasicEventReponse'
      ]
    ];
  }
}