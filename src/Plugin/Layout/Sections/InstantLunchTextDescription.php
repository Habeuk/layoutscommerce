<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Sections;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection;
/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "instant_lunch_text_desc",
 *   label = @Translation(" Instant lunch text desc"),
 *   category = @Translation("instantlunch"),
 *   path = "layouts/sections",
 *   template = "instant_lunch_text_desc",
 *   library = "layoutscommerce/instant_lunch_text_desc",
 *   default_region = "description",
 *   regions = {
 *     "section_title" = {
 *       "label" = @Translation("section_title "),
 *     },
 *     "lien_plus" = {
 *       "label" = @Translation("lien_plus "),
 *     },
 *     "section_desc" = {
 *       "label" = @Translation("section_desc")
 *     }
 *   }
 * )
 */
class InstantLunchTextDescription extends FormatageModelsSection {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/sections/il-text-desc.png");
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
          'section_desc' => [
            'text_html' => [
              'label' => ' description',
              'value' => ' C’est la fin de la livraison traditionnelle du plateau repas froid en entreprise, avec
                        Instant-Lunch,
                        faites vous livrer
                        un plateau repas chaud pour vous et vos collaborateurs.<strong>Nous vous proposons un
                            menu
                            complet avec</strong> une
                        entrée, un plat et C’est la fin de la livraison traditionnelle du plateau repas froid en
                        entreprise, avec
                        Instant-Lunch,
                        faites vous livrer'
            ]
          ],
          'lien_plus' => [
            'text_html' => [
              'label' => 'text Lire plus',
              'value' => 'Lire plus'
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}