<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_price\CurrencyFormatter;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "layoutscommerce_teaser",
 *   label = @Translation(" Teaser commerce manomano 2022 "),
 *   category = @Translation("Formatage Models : Teaser"),
 *   path = "layouts/teasers",
 *   template = "layoutscommerce-teaser",
 *   library = "layoutscommerce/layoutscommerce-teaser",
 *   default_region = "titre",
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
 *   }
 * )
 */
class LayoutscommerceTeaser extends FormatageModelsTeasers {
  /**
   *
   * @var CurrencyFormatter
   */
  protected $currency_formatter;
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/teasers/layoutscommerce-teaser.png");
    // $this->currency_formatter = $CurrencyFormatter;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->currency_formatter = $container->get('commerce_price.currency_formatter');
    return $instance;
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
    $this->addPriceInRegion($build['title'], $build);
    return $build;
  }
  
  /**
   * On ne parvient pas encore a recuperé la variation par defaut pour un
   * produit injecté via view et LB.
   * Probleme de conexte les champs provenant de
   * commerce_product_variation, nont pas de recupere.
   * Par defaut, il essaie le contexte dans l'url.
   */
  protected function addPriceInRegion($fiedProduct, &$build) {
    $fiedProduct = reset($fiedProduct);
    
    if (!empty($fiedProduct['content']['#object'])) {
      /**
       *
       * @var Product $fiedProduct
       */
      $product = $fiedProduct['content']['#object'];
      $product_id = $product->id();
      // Si l'id du produit existe on le surcharge.
      if ($product_id) {
        $productVariation = $product->getDefaultVariation();
        if ($productVariation) {
          /**
           *
           * @var \Drupal\commerce_price\Price $price
           */
          $price = $productVariation->getPrice();
          $build['price'][] = [
            '#type' => 'html_tag',
            '#tag' => 'div',
            '#value' => $price ? $this->currency_formatter->format($price->getNumber(), $price->getCurrencyCode()) : ''
          ];
        }
      }
    }
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers::defaultConfiguration()
   */
  public function defaultConfiguration() {
    return [
      'css' => ''
    ] + parent::defaultConfiguration();
  }
  
}