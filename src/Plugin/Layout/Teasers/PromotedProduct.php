<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "promoted_product",
 *   label = @Translation("Promoted Product"),
 *   category = @Translation("Commerce-Teaser"),
 *   path = "layouts/teasers",
 *   template = "promoted-product",
 *   library = "layoutscommerce/promoted-product",
 *   regions = {
 *     "image" = {
 *       "label" = @Translation(" Image "),
 *     },
 *     "price" = {
 *       "label" = @Translation(" Price "),
 *     },
 *     "oldPrice" = {
 *       "label" = @Translation(" Old price "),
 *     },
 *     "title" = {
 *       "label" = @Translation(" Title "),
 *     },
 *     "subtitle" = {
 *       "label" = @Translation(" Subtitle "),
 *     },
 *     "description" = {
 *       "label" = @Translation(" Description "),
 *     }
 *   }
 * )
 */
class PromotedProduct extends FormatageModelsTeasers {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/teasers/promoted-product.png");
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
          'price' => [
            'text' => [
              'label' => 'Price',
              'value' => ''
            ]
          ],
          'oldPrice' => [
            'text_html' => [
              'label' => 'Old price',
              'value' => ''
            ]
          ],
          'title' => [
            'text' => [
              'label' => 'Title',
              'value' => ''
            ]
          ],
          'subtitle' => [
            'text' => [
              'label' => 'Subtitle',
              'value' => ''
            ]
          ],
          'description' => [
            'text' => [
              'label' => 'Description',
              'value' => ''
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}
