<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Sections;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection;

/**
 *
 * Custom layout for Layoutscommmerce module
 *
 * @Layout(
 *   id = "brand",
 *   label = @Translation(" Commerce Brand Section"),
 *   category = @Translation("layoutscommerce"),
 *   path = "layouts/sections",
 *   template = "brand",
 *   library = "layoutscommerce/brand",
 *   default_region = "image",
 *   regions = {
 *      "image" = {
 *          "label" = @Translation("Image "),
 *      },
 *      "link" = {
 *          "label" = @Translation("Link "),
 *      }
 *   }
 * )
 *
 */
class Brand extends FormatageModelsSection {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/sections/brtand.png");
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
  
  /**
   *
   * {@inheritdoc}
   *
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'load_libray' => false,
      'region_image_css' => '',
      'region_link_css' => '',
      'infos' => [
        'builder-form' => true,
        'info' => [
          'title' => 'Texte information',
          'loader' => 'static'
        ],
        'fields' => [
          'Image' => [
            'text_html' => [
              'label' => 'Image',
              'value' => ''
            ]
          ],
          'link' => [
            'text_html' => [
              'label' => 'Link',
              'value' => ''
            ]
          ],
        ]
      ]
    ];
  }
  
}