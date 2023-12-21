<?php

namespace Drupal\layoutscommerce\Plugin\Layout;

use Drupal\layoutscommerce\Services\LayoutscommerceProductVariation;
use Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 * @author stephane
 *        
 */
class LayoutscommerceTeaser extends FormatageModelsTeasers {
  /**
   *
   * @deprecated
   * @var LayoutscommerceProductVariation
   */
  protected $LayoutCommerceProductVariation = null;
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->LayoutCommerceProductVariation = $container->get('layoutscommerce.product_variation');
    return $instance;
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers::defaultConfiguration()
   */
  public function defaultConfiguration() {
    return [
      // @deprecated à supprimer à la prochaine version.
      'force_use_code_render_pv' => true
    ] + parent::defaultConfiguration();
  }
  
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    // @deprecated à supprimer à la prochaine version.
    $form['force_use_code_render_pv'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Force à utiliser le code pour le rendu des champs de variations.'),
      '#default_value' => $this->configuration['force_use_code_render_pv'],
      '#description' => "La logique utilisé pour recuperer les champs de variations n'est pas bonne, il faut utiliser le rendu de l'entité. 
       <br> <strong>NB reconfigurer les champs de variations de produits et desactivées ce dernier.<strong>"
    ];
    return $form;
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\Teasers\FormatageModelsTeasers::submitConfigurationForm()
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['force_use_code_render_pv'] = $form_state->getValue('force_use_code_render_pv');
  }
  
}