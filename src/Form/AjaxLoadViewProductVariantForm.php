<?php
declare(strict_types = 1);

namespace Drupal\layoutscommerce\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure layoutscommerce settings for this site.
 */
final class AjaxLoadViewProductVariantForm extends ConfigFormBase {
  
  /**
   *
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'layoutscommerce_ajax_load_view_product_variant';
  }
  
  /**
   *
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [
      'layoutscommerce.ajax_load_view_product_variant'
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('layoutscommerce.ajax_load_view_product_variant')->getRawData();
    $form['load_displays_1'] = [
      '#type' => 'fieldset',
      '#title' => $this->t(" Definie le selecteur et le modele d'affichage "),
      '#tree' => TRUE
    ];
    $form['load_displays_1']['selecteur'] = [
      "#type" => 'textfield',
      '#title' => $this->t('selecteur'),
      '#default_value' => isset($config['load_displays_1']['selecteur']) ? $config['load_displays_1']['selecteur'] : null
    ];
    $form['load_displays_1']['view_mode'] = [
      "#type" => 'textfield',
      '#title' => $this->t('selecteur'),
      '#default_value' => isset($config['load_displays_1']['view_mode']) ? $config['load_displays_1']['view_mode'] : null
    ];
    $form['load_displays_2'] = [
      '#type' => 'fieldset',
      '#title' => $this->t(" Definie le selecteur et le modele d'affichage "),
      '#tree' => TRUE
    ];
    $form['load_displays_2']['selecteur'] = [
      "#type" => 'textfield',
      '#title' => $this->t('selecteur'),
      '#default_value' => isset($config['load_displays_2']['selecteur']) ? $config['load_displays_2']['selecteur'] : null
    ];
    $form['load_displays_2']['view_mode'] = [
      "#type" => 'textfield',
      '#title' => $this->t('selecteur'),
      '#default_value' => isset($config['load_displays_2']['view_mode']) ? $config['load_displays_2']['view_mode'] : null
    ];
    return parent::buildForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    // if ($form_state->getValue('example') === 'wrong') {
    // $form_state->setErrorByName(
    // 'message',
    // $this->t('The value is not correct.'),
    // );
    // }
    // @endcode
    parent::validateForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $config = $this->config('layoutscommerce.ajax_load_view_product_variant');
    $config->set('load_displays_1', $form_state->getValue('load_displays_1'));
    $config->set('load_displays_2', $form_state->getValue('load_displays_2'));
    $config->save();
    parent::submitForm($form, $form_state);
  }
}
