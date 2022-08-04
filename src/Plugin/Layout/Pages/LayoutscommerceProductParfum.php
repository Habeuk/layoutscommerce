<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Pages;

use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\layoutscommerce\Plugin\Layout\LayoutscommercePage;

/**
 * A page by TMC with layout
 *
 * @Layout(
 *  id = "layoutscommerce_product_parfumn",
 *  label = @Translation(" product_parfumn "),
 *  category = @Translation("layoutscommerce"),
 *  path = "layouts/pages",
 *  template = "layoutscommerce-product-parfumn",
 *  library = "layoutscommerce/layoutscommerce-product-parfumn",
 *  regions = {
 *      "marque" = {
 *          "label" = @Translation("Marque"),
 *      },
 *      "categories" = {
 *          "label" = @Translation("categories"),
 *      },
 *      "icones" = {
 *          "label" = @Translation("icones"),
 *      },
 *      "images" = {
 *          "label" = @Translation("images"),
 *      },
 *      "titre" = {
 *          "label" = @Translation(" titre "),
 *      },
 *      "sub_title" = {
 *          "label" = @Translation(" sub_title "),
 *      },
 *      "sub_title2" = {
 *          "label" = @Translation(" sub_title2 "),
 *      },
 *      "resume_avis" = {
 *          "label" = @Translation(" resume_avis "),
 *      }, *
 *      "form_add_to_cart" = {
 *          "label" = @Translation(" form_add_to_cart "),
 *      },
 *      "block_infos1" = {
 *          "label" = @Translation(" block_infos1 "),
 *      },
 *      "block_infos2" = {
 *          "label" = @Translation(" block_infos2 "),
 *      },
 *      "products_add" = {
 *          "label" = @Translation(" products_add "),
 *      }
 *  }
 * )
 */
class LayoutscommerceProductParfum extends LayoutscommercePage {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/pages/layoutscommerce-product-parfumn.png");
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::build()
   */
  public function build(array $regions) {
    // TODO Auto-generated method stub
    $build = parent::build($regions);
    
    //
    // if (!empty($build['form_add_to_cart'][0]))
    // $this->LayoutCommerceProductVariation->getRenderAddToCart($build['title'],
    // $build, 'form_add_to_cart', $build['form_add_to_cart']);
    FormatageModelsThemes::formatSettingValues($build);
    // dump($build['form_add_to_cart']);
    return $build;
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection::defaultConfiguration()
   */
  public function defaultConfiguration() {
    return [
      'css' => '',
      'region_css_marque' => 'text-center'
    ] + parent::defaultConfiguration();
  }
  
}