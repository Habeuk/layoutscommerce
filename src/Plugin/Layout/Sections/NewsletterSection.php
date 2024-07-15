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
 *   id = "commerce_newsletter_section",
 *   label = @Translation(" Commerce Newsletter Section"),
 *   category = @Translation("layoutscommerce"),
 *   path = "layouts/sections",
 *   template = "commerce-newsletter",
 *   library = "layoutscommerce/commerce-newsletter",
 *   default_region = "title",
 *   regions = {
 *      "title" = {
 *          "label" = @Translation("Title "),
 *      },
 *      "subtitle" = {
 *          "label" = @Translation("SubTitle"),
 *      },
 *      "image" = {
 *          "label" = @Translation("Image"),
 *      },
 *      "form" = {
 *          "label" = @Translation("Form"),
 *      }
 *   }
 * )
 *
 */
class NewsletterSection extends FormatageModelsSection {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/sections/commerce-newsletter.png");
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
      'region_title_css' => '',
      'region_subtitle_css' => '',
      'region_form_css' => '',
      'infos' => [
        'builder-form' => true,
        'info' => [
          'title' => 'Texte information',
          'loader' => 'static'
        ],
        'fields' => [
          'title' => [
            'text_html' => [
              'label' => 'Title',
              'value' => ''
            ]
          ],
          'image' => [
            'text_html' => [
              'label' => 'Image',
              'value' => ''
            ]
          ],
          'form' => [
            'text_html' => [
              'label' => 'Form',
              'value' => ''
            ]
          ],
          'subtitle' => [
            'text_html' => [
              'label' => 'Subtitle',
              'value' => ''
            ]
          ],
        ]
      ]
    ];
  }
  
}