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
 *   id = "instant_lunch_menu",
 *   label = @Translation(" Commerce Instant Lunch Menu "),
 *   category = @Translation("layoutscommerce"),
 *   path = "layouts/sections",
 *   template = "layoutscommerce_instant_lunch_menu",
 *   library = "layoutscommerce/layoutscommerce_instant_lunch_menu",
 *   default_region = "i_l_menu_title",
 *   regions = {
 *      "i_l_menu_title" = {
 *          "label" = @Translation("i_l_menu_title "),
 *      },
 *      "i_l_menu_description" = {
 *          "label" = @Translation("i_l_menu_description"),
 *      },
 *      "i_l_menu_image" = {
 *          "label" = @Translation("i_l_menu_image "),
 *      },
 *      "i_l_menu_date_text" = {
 *          "label" = @Translation("i_l_menu_date_text "),
 *      },
 *      "i_l_menu_date" = {
 *          "label" = @Translation("i_l_menu_date "),
 *      }
 *   }
 * )
 *
 */
class LayoutsCommerceIntantLunchMenu extends FormatageModelsSection {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/sections/layoutscommerce_instant_lunch_menu.png");
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
      'infos' => [
        'builder-form' => true,
        'info' => [
          'title' => 'Texte information',
          'loader' => 'static'
        ],
        'fields' => [
          'i_l_menu_title' => [
            'text_html' => [
              'label' => 'Titre',
              'value' => '<span class="il-colored">Traiteur plateaux repas</span> pour entreprises'
            ]
          ],
          'i_l_menu_description' => [
            'text_html' => [
              'label' => 'Description',
              'value' => 'C’est la fin de la livraison traditionnelle du plateau repas froid en entreprise, avec
                                    Instant-Lunch,
                                    faites vous livrer
                                    un plateau repas chaud pour vous et vos collaborateurs.<strong>Nous vous proposons un menu
                                        complet avec</strong>
                                    une
                                    entrée, un plat et
                                    un dessert. Le tout confectionné maison et avec amour par notre brigade.

                                    Cette dernière élabore six menus différents chaque semaine afin de proposer une cuisine riche,
                                    saine,
                                    variée et surtout
                                    authentique et engagée, livrée chaude et entièrement recyclable ou réutilisable pour un déjeuner
                                    responsable !

                                    Découvrez et profitez dès maintenant du menu qui vous ressemble le plus et qui saura séduire vos
                                    papilles avec notre
                                    offre traiteur plateaux repas…'
            ]
          ],
          'i_l_menu_image' => [
            'img_bg' => [
              'label' => 'BG img for menu'
            ]
          ],
          'i_l_menu_date_text' => [
            'text_html' => [
              'label' => 'Date text',
              'value' => 'Retrouvez nos menus de la semaine ci-dessous : '
            ]
          ],
          'i_l_menu_date' => [
            'text_html' => [
              'label' => 'Date',
              'value' => 'du 18 au 24 juillet'
            ]
          ]
        ]
      ]
    ];
  }
  
}