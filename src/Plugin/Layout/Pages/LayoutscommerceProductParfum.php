<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Pages;

use Drupal\Core\Form\FormStateInterface;
use Drupal\formatage_models\FormatageModelsThemes;
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
 *      "caracteristiques" = {
 *          "label" = @Translation("Caracteristiques"),
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
  protected $image_icon_url = "/icones/pages/layoutscommerce-product-parfumn.png";
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection::buildConfigurationForm()
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $form['config_product'] = [
      '#type' => 'details',
      '#title' => 'Configuration de la page produit',
      '#open' => false
    ];
    $form['config_product']['content_left'] = [
      '#type' => 'textfield',
      '#title' => 'content left',
      '#default_value' => isset($this->configuration['config_product']['content_left']) ? $this->configuration['config_product']['content_left'] : 'col-md-12 col-xm-12 col-lg-6',
      '#maxlength' => 256
    ];
    $form['config_product']['content_right'] = [
      '#type' => 'textfield',
      '#title' => 'content right',
      '#default_value' => isset($this->configuration['config_product']['content_right']) ? $this->configuration['config_product']['content_right'] : 'col-md-12 col-xm-12 col-lg-6',
      '#maxlength' => 256
    ];
    return $form;
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::build()
   */
  public function build(array $regions) {
    // TODO Auto-generated method stub
    $build = parent::build($regions);
    
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
   * @see \Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection::submitConfigurationForm()
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['config_product'] = $form_state->getValue('config_product');
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection::defaultConfiguration()
   */
  public function defaultConfiguration() {
    return [
      'css' => '',
      'region_css_marque' => 'text-center',
      'config_product' => [
        'content_left' => 'col-md-12 col-xm-12 col-lg-6 mb-5 m-md-0',
        'content_right' => 'col-md-12 col-xm-12 col-lg-6'
      ]
    ] + parent::defaultConfiguration();
  }
  
}