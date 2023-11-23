<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection;

/**
 *
 * Custom layout for Layoutscommmerce module
 *
 * @Layout(
 *   id = "commerce_vertical_banner",
 *   label = @Translation(" Commerce Vertical Banner"),
 *   category = @Translation("layoutscommerce"),
 *   path = "layouts/teasers",
 *   template = "commerce-vertical-banner",
 *   library = "layoutscommerce/commerce-vertical-banner",
 *   default_region = "image",
 *   regions = {
 *      "image" = {
 *          "label" = @Translation("Image "),
 *      },
 *      "link" = {
 *          "label" = @Translation("Link "),
 *      },
 *      "button" = {
 *          "label" = @Translation("Button "),
 *      },
 *      "category" = {
 *          "label" = @Translation("Category "),
 *      },
 *      "description" = {
 *          "label" = @Translation("Description "),
 *      },
 *      "subtitle" = {
 *          "label" = @Translation("Sub title "),
 *      },
 *      "title" = {
 *          "label" = @Translation("Title "),
 *      }
 *   }
 * )
 *
 */
class VerticalBanner extends FormatageModelsSection {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/teasers/commerce-vertical-banner.png");
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
          'button' => [
            'text_html' => [
              'label' => 'Button',
              'value' => ''
            ]
          ],
          'category' => [
            'text_html' => [
              'label' => 'Category',
              'value' => ''
            ]
          ],
          'description' => [
            'text_html' => [
              'label' => 'Description',
              'value' => ''
            ]
          ],
          'subtitle' => [
            'text_html' => [
              'label' => 'Subtitle',
              'value' => ''
            ]
          ],
          'title' => [
            'text_html' => [
              'label' => 'Title',
              'value' => ''
            ]
          ],
        ]
      ]
    ];
  }
  
}