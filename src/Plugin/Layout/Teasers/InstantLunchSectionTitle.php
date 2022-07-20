<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\layoutscommerce\Plugin\Layout\LayoutscommerceTeaser;
use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "instant_lunch_section_title",
 *   label = @Translation(" Instant Lunch section title"),
 *   category = @Translation("instantlunch"),
 *   path = "layouts/teasers",
 *   template = "instantlunch-section-title",
 *   library = "instantlunch/instantlunch-section-title",
 *   regions = {
 *     "big_title" = {
 *       "label" = @Translation(" big_title "),
 *     },
 *     "title" = {
 *       "label" = @Translation(" Titre "),
 *     },
 *     "desc" = {
 *       "label" = @Translation(" desc "),
 *     }
 *   }
 * )
 */
class InstantLunchSectionTitle extends LayoutscommerceTeaser {
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/teasers/il-section-title.png");
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
    $this->LayoutCommerceProductVariation->getRenderField($build['title'], $build);
    $this->LayoutCommerceProductVariation->getRenderAddToCart($build['title'], $build);
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
          'big_title' => [
            'text_html' => [
              'label' => 'biggest title',
              'value' => '<a href="#">Le menu du jardine</a>'
            ]
          ],
          'title' => [
            'text_html' => [
              'label' => 'title',
              'value' => '<a href="#">Le menu du jardine</a>'
            ]
          ],
          'desc' => [
            'text_html' => [
              'label' => 'description',
              'value' => ' '
            ]
          ],
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}