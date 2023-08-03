<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\layoutscommerce\Plugin\Layout\LayoutscommerceTeaser;
use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "layoutscommerce_model_withmoreinfos",
 *   label = @Translation(" Model with more infos "),
 *   category = @Translation("instantlunch"),
 *   path = "layouts/teasers",
 *   template = "layoutscommerce-model-withmoreinfos",
 *   library = "layoutscommerce/layoutscommerce-model-withmoreinfos",
 *   regions = {
 *     "images" = {
 *       "label" = @Translation(" Images "),
 *     },
 *     "title" = {
 *       "label" = @Translation(" Titre "),
 *     },
 *     "small_decription" = {
 *       "label" = @Translation(" Small description ")
 *     },
 *     "price" = {
 *       "label" = @Translation(" price ")
 *     },
 *     "description" = {
 *       "label" = @Translation(" description ")
 *     },
 *     "add_to_cart" = {
 *       "label" = @Translation("add_to_cart")
 *     }
 *   }
 * )
 */
class LayoutscommerceModelWithMoreInfos extends LayoutscommerceTeaser {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/teasers/il-menu-card.png");
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
    // $this->LayoutCommerceProductVariation->getRenderField($build['title'],
    // $build);
    // $this->LayoutCommerceProductVariation->getRenderAddToCart($build['title'],
    // $build, 'add_to_cart', $build['add_to_cart']);
    return $build;
  }
  
  function defaultConfiguration() {
    return [
      'region_css_title' => 'h4 font-weight-bold',
      'region_css_price' => 'h3 font-weight-bold align-items-start d-flex',
      'region_css_add_to_cart' => 'btn d-block btn-info th-btn th-btn-secondary'
    ] + parent::defaultConfiguration();
  }
  
}