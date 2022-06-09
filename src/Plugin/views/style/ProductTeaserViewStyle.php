<?php

namespace Drupal\layoutscommerce\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\core\form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\layoutgenentitystyles\Services\LayoutgenentitystylesServices;

/**
 * Style plugin to render a list of years and months
 * in reverse chronological order linked to content.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "product_teaser_view_style",
 *   title = @Translation(" Product Teaser ViewStyle "),
 *   help = @Translation("Render default model"),
 *   theme = "layoutscommerce_product_teaser_view_style",
 *   display_types = { "normal" }
 * )
 */
class ProductTeaserViewStyle extends StylePluginBase {
  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * @var bool
   */
  protected $usesFields = TRUE;
  
  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;
  
  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;
  
  /**
   *
   * @var LayoutgenentitystylesServices
   */
  protected $LayoutgenentitystylesServices;
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->LayoutgenentitystylesServices = $container->get('layoutgenentitystyles.add.style.theme');
    return $instance;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['view_layouts_options'] = [
      'default' => null,
      'title' => [],
      'images' => [],
      'price' => []
    ];
    return $options;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $labels = $this->displayHandler->getFieldLabels(TRUE);
    /**
     * add section
     */
    $form['view_layouts_options'] = [
      '#type' => 'details',
      '#title' => 'Mappes les champs ci-dessous.',
      "#tree" => true,
      '#open' => true
    ];
    $form['view_layouts_options']['title'] = [
      '#type' => 'checkboxes',
      '#title' => 'Titre',
      '#options' => $labels,
      '#default_value' => (!empty($this->options['view_layouts_options']['title'])) ? $this->options['view_layouts_options']['title'] : []
    ];
    $form['view_layouts_options']['images'] = [
      '#type' => 'checkboxes',
      '#title' => 'images',
      '#options' => $labels,
      '#default_value' => (!empty($this->options['view_layouts_options']['images'])) ? $this->options['view_layouts_options']['images'] : []
    ];
    $form['view_layouts_options']['price'] = [
      '#type' => 'checkboxes',
      '#title' => 'price',
      '#options' => $labels,
      '#default_value' => (!empty($this->options['view_layouts_options']['price'])) ? $this->options['view_layouts_options']['price'] : []
    ];
  }
  
}