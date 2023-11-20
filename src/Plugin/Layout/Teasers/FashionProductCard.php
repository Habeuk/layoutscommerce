<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "fashion_product_card",
 *   label = @Translation("Fashion product Card"),
 *   category = @Translation("Commerce-Teaser"),
 *   path = "layouts/teasers",
 *   template = "fashion-product-card",
 *   library = "layoutscommerce/fashion-product-card",
 *   regions = {
 *     "image" = {
 *       "label" = @Translation(" Image "),
 *     },
 *     "badge" = {
 *       "label" = @Translation(" Badge "),
 *     },
 *     "wishlist" = {
 *       "label" = @Translation(" Wishlist "),
 *     },
 *     "title" = {
 *       "label" = @Translation(" Title "),
 *     },
 *     "price" = {
 *       "label" = @Translation(" Price "),
 *     },
 *     "availability" = {
 *       "label" = @Translation(" Availability "),
 *     }
 *   }
 * )
 */
class FashionProductCard extends FormatageModelsTeasers {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/teasers/fashion-product-card.png");
    // $this->currency_formatter = $CurrencyFormatter;
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::build()
   */
  public function build(array $regions) {
    // TODO Auto-generated method stub
    $build = parent::build($regions);
    FormatageModelsThemes::formatSettingValues($build);
    return $build;
  }
  
  function defaultConfiguration() {
    return [
      'load_libray' => false,
      'infos' => [
        'builder-form' => true,
        'info' => [
          'title' => 'Card information',
          'loader' => 'dynamic'
        ],
        'fields' => [
          'image' => [
            'text_html' => [
              'label' => 'image',
              'value' => ''
            ]
          ],
          'badge' => [
            'text' => [
              'label' => 'Badge',
              'value' => ''
            ]
          ],
          'wishlist' => [
            'text_html' => [
              'label' => 'Wishlist',
              'value' => ''
            ]
          ],
          'title' => [
            'text' => [
              'label' => 'Title',
              'value' => ''
            ]
          ],
          'price' => [
            'text' => [
              'label' => 'Price',
              'value' => ''
            ]
          ],
          'availability' => [
            'text' => [
              'label' => 'Availability',
              'value' => ''
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}
