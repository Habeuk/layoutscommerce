<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\layoutscommerce\Plugin\Layout\LayoutscommerceTeaser;
use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "instant_lunch_hori_menu_card",
 *   label = @Translation(" Instant Lunch menu hori card "),
 *   category = @Translation("instantlunch"),
 *   path = "layouts/teasers",
 *   template = "instantlunch-hori-menu-card",
 *   library = "layoutscommerce/instantlunch-hori-menu-card",
 *   regions = {
 *     "images" = {
 *       "label" = @Translation(" Images "),
 *     },
 *     "title" = {
 *       "label" = @Translation(" Titre "),
 *     },
 *     "price" = {
 *       "label" = @Translation(" price ")
 *     },
 *     "decouvrir_text" = {
 *       "label" = @Translation(" decouvrir_text ")
 *     },
 *    "button_options" = {
 *       "label" = @Translation(" button_options ")
 *     },
 *     "add_to_cart" = {
 *       "label" = @Translation("add_to_cart")
 *     }
 *   }
 * )
 */
class InstantLunchHoriMenuCard extends LayoutscommerceTeaser {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/teasers/hori-menu-card.png");
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
    // if (!empty($build['add_to_cart'][0])){
    // /**
    // * On force ce cas, afin d'avoir un autre model d'ajout au panier car
    // celui
    // * par defaut presente un seul style.
    // *
    // * @var array $add
    // */
    
    // $this->LayoutCommerceProductVariation->getRenderAddToCart($build['title'],
    // $build, 'add_to_cart', $build['add_to_cart']);
    // }
    $add = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => 'Ajouter au panier'
    ];
    $this->LayoutCommerceProductVariation->getRenderAddToCart($build['title'], $build, 'add_to_cart', $add);
    
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
          ],
          'price' => [
            'text_html' => [
              'label' => 'prix',
              'value' => '18.98€ HT'
            ]
          ],
          'decouvrir_text' => [
            'text_html' => [
              'label' => 'decouvrir text',
              'value' => 'Découvrir le produit'
            ]
          ],
          'button_options' => [
            'text_html' => [
              'label' => 'titre button options',
              'value' => '<a href="#">Choix des options</a>'
            ]
          ],
          'add_to_cart' => [
            'text_html' => [
              'label' => 'title add to cart',
              'value' => '<a href="#">Ajouter au panier</a>'
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}