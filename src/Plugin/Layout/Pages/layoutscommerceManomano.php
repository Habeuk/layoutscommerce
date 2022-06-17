<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Pages;

use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\Plugin\Layout\Pages\FormatageModelsPages;

/**
 * A page by TMC with layout
 *
 * @Layout(
 *  id = "layoutscommerce_manomano",
 *  label = @Translation(" Commerce manomano 2022"),
 *  category = @Translation("layoutscommerce"),
 *  path = "layouts/pages",
 *  template = "layoutscommerce-manomano",
 *  library = "layoutscommerce/layoutscommerce-manomano",
 *  regions = {
 *      "title" = {
 *          "label" = @Translation("title"),
 *      },
 *      "list_content" = {
 *          "label" = @Translation("list_content"),
 *      },
 *      "images" = {
 *          "label" = @Translation("images"),
 *      },
 *      "contents" = {
 *          "label" = @Translation("contents"),
 *      },
 *      "price" = {
 *          "label" = @Translation(" price "),
 *      },
 *      "qty" = {
 *          "label" = @Translation(" qty "),
 *      },
 *      "add_card" = {
 *          "label" = @Translation(" add_card "),
 *      },
 *      "titleblock1" = {
 *          "label" = @Translation(" titleblock1 "),
 *      }, *
 *      "in_stock" = {
 *          "label" = @Translation(" in_stock "),
 *      },
 *      "shipping" = {
 *          "label" = @Translation(" shipping "),
 *      },
 *      "garentie" = {
 *          "label" = @Translation(" garentie "),
 *      },
 *      "retour" = {
 *          "label" = @Translation(" Retour "),
 *      },
 *      "titleblock2" = {
 *          "label" = @Translation(" titleblock2 "),
 *      },
 *      "options" = {
 *          "label" = @Translation(" options de livraison "),
 *      }
 *  }
 * )
 */
class layoutscommerceManomano extends FormatageModelsPages {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/pages/layoutscommerce-manomano.png");
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
    if (!empty($build['in_stock']))
      $this->checkHaveStock($build['in_stock'], $build);
    return $build;
  }
  
  /**
   * Permet determiner si on un stock ou pas.
   */
  protected function checkHaveStock($in_stock, &$build) {
    foreach ($in_stock as $k => $stock) {
      if (!empty($stock['#theme'])) {
        if (!empty($stock['content']['#object'])) {
          // Comment determiner la stock restant à partir de l'object @var
          // \Drupal\commerce_product\Entity\ProductVariation $productVariation
          /**
           *
           * @var \Drupal\commerce_product\Entity\ProductVariation $productVariation
           */
          $productVariation = $stock['content']['#object'];
          // if ($productVariation->hasField($stock['content']['#field_name']))
          // {
          // //
          // dump($productVariation->get($stock['content']['#field_name'])->getValue());
          // }
          // dump($productVariation->get($stock['content']['#field_name']));
          // $elements = Element::children($stock['content']);
          // dump($elements);
          /**
           * Methode basique en attendant le ressoudre autrement.
           */
          if (isset($stock['content'][0]['#value'])) {
            $build['#settings']['product_has_stock'] = (int) $stock['content'][0]['#value'];
          }
        }
        else {
          $this->messenger()->addWarning('Impossible de determiner le status du stock');
        }
      }
    }
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection::defaultConfiguration()
   */
  public function defaultConfiguration() {
    return [
      'css' => 'container',
      'product_has_stock' => 0,
      'sf1' => [
        'builder-form' => true,
        'info' => [
          'title' => 'Contenu',
          'loader' => 'static'
        ],
        'fields' => [
          'titleblock1' => [
            'text' => [
              'label' => 'titre',
              'value' => "Bon à savoir"
            ]
          ],
          'titleblock2' => [
            'text' => [
              'label' => 'titre',
              'value' => "Options de livraison"
            ]
          ],
          'options' => [
            'text_html' => [
              'label' => 'options de livraison',
              'value' => '<ul class="puce-check">
                            <li> À domicile le 11/06/2022 pour toute commande passée avant 17 h <span> - Livraison gratuite</span></li>
                            <li>À domicile le 10/06/2022 pour toute commande passée avant 17 h</li>
                            <li>En point relais le 10/06/2022 pour toute commande passée avant 10 h<span> - Livraison gratuite</span></li>
                            <li>En point relais le 10/06/2022 pour toute commande passée avant 15 h</li>
                          </ul>'
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}