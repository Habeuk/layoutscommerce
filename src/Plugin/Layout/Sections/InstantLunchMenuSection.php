<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Sections;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\layoutscommerce\Plugin\Layout\LayoutscommerceSection;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "instant_lunch_menu_section",
 *   label = @Translation(" Instant lunch text desc"),
 *   category = @Translation("instantlunch"),
 *   path = "layouts/sections",
 *   template = "instant_lunch_menu_section",
 *   library = "layoutscommerce/instant_lunch_menu_section",
 *   default_region = "description",
 *   regions = {
 *     "section_title" = {
 *       "label" = @Translation("section_title "),
 *     },
 *     "section_big_title" = {
 *       "label" = @Translation("section_big_title "),
 *     },
 *     "section_content" = {
 *       "label" = @Translation("lien_plus "),
 *     },
 *     "section_desc" = {
 *       "label" = @Translation("section_desc")
 *     }
 *   }
 * )
 */
class InstantLunchMenuSection extends LayoutscommerceSection {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/sections/menu-card-section.png");
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
          'title' => 'Texte information',
          'loader' => 'static'
        ],
        'fields' => [
          'section_title' => [
            'text_html' => [
              'label' => 'Title',
              'value' => '  Un service
                        qui répond <span class="il-colored">à vos exigences</span>'
            ]
          ],
          'section_big_title' => [
            'text_html' => [
              'label' => 'big title',
              'value' => '  Un service
                        qui répond à vos exigences'
            ]
          ],
          'section_desc' => [
            'text_html' => [
              'label' => ' description',
              'value' => ' C’est la fin de la livraison traditionnelle du plateau repas froid en entreprise, avec
                        Instant-Lunch.
                       '
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}