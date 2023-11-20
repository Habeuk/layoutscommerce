<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "advantage",
 *   label = @Translation("Advantage teaser"),
 *   category = @Translation("Commerce-Teaser"),
 *   path = "layouts/teasers",
 *   template = "advantage",
 *   library = "layoutscommerce/advantage",
 *   regions = {
 *     "icon" = {
 *       "label" = @Translation(" Icon "),
 *     },
 *     "title" = {
 *       "label" = @Translation(" Title "),
 *     },
 *     "subtitle" = {
 *       "label" = @Translation(" Subtitle "),
 *     }
 *   }
 * )
 */
class Advantage extends FormatageModelsTeasers {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/teasers/advantage.png");
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
          'icon' => [
            'text_html' => [
              'label' => 'Icon',
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
            'text_html' => [
              'label' => 'Subtitle',
              'value' => ''
            ]
          ],
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}
