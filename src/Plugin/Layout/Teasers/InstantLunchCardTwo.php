<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers;


/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "instant_lunch_card_two",
 *   label = @Translation(" Instant Lunch card two"),
 *   category = @Translation("instantlunch"),
 *   path = "layouts/teasers",
 *   template = "instantlunch-card-two",
 *   library = "layoutscommerce/instantlunch-card-two",
 *   regions = {
 *     "images" = {
 *       "label" = @Translation(" Images "),
 *     },
 *     "title" = {
 *       "label" = @Translation(" Titre "),
 *     }
 *   }
 * )
 */
class InstantLunchCardTwo extends FormatageModelsTeasers {
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/teasers/il-card-two.png");
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
          'loader' => 'static'
        ],
        'fields' => [
          'images' => [
            'text_html' => [
              'label' => 'images',
              'value' => '<a href="#">
                            <img src="https://i0.wp.com/instant-lunch.store/wp-content/uploads/2022/06/curry-vert-riz-le%CC%81gumes-produits.jpg?fit=800%2C800&ssl=1"
                                 alt="">
                        </a>'
            ]
          ],
          'title' => [
            'text_html' => [
              'label' => 'title',
              'value' => '<a href="#">Le menu du jardine</a>'
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}