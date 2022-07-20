<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Sections;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection;


/**
 * 
 * Custom layout for layoutscommerce module : card btn
 * @Layout(
 *   id = "instant_lunch_card_btn",
 *   label = @Translation(" Instant lunch Card Btn "),
 *   category = @Translation("layoutscommerce"),
 *   path = "layouts/sections",
 *   template = "instant_lunch_card_btn",
 *   library = "layoutscommerce/instant_lunch_card_btn",
 *   default_region = "lunch_card_btn_text",
 *   regions = {
 *      "lunch_card_btn_text" = {
 *          "label" = @Translation("lunch_card_btn_text"),     
 *      }
 *   }
 * )
 */

class LayoutscommerceInstantLunchCardBtn extends FormatageModelsSection 
{
    /**
    *
    * {@inheritdoc}
    * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
    */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
        // TODO Auto-generated method stub
        parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
        $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/sections/layoutscommerce_instant_lunch_card_btn.png");
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
                    'lunch_card_btn_text' => [
                        'url' => [
                            'label' => 'Texte pour bouton',
                            'value' => [
                                'text' => 'Commander pour les semaines à venir',
                                'href' => '#',
                                'class' => ''
                            ]
                        ]
                    ],
                ]
            ],
        ];
    }
}