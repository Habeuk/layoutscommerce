<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Plugin implementation of the 'commerce_gallery_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "commerce_gallery_formatter",
 *   label = @Translation("Commerce gallery formatter"),
 *   field_types = {
 *     "image"
 *   }
 * )
 */
class CommerceGalleryFormatter extends FormatterBase {


  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * Constructs a new ProductImageFormatter object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The field definition for this instance.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings settings.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityFieldManagerInterface $entity_field_manager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->entityFieldManager = $entity_field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_field.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      // Implement default settings.
      'titystyles_view' => 'more_fields/restrained-field',
      'variation' => null,
      'attribute' => null,
      'gallery_field' => null,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = [
      // Implement settings form.
      'layoutgenentitystyles_view' => [
        '#type' => 'hidden',
        "#value" => $this->getSetting("layoutgenentitystyles_view"),
      ],
    ];

    //Choix du champ attribute

    // Récupération du type et du bundle.
    $field_definition = $this->fieldDefinition;
    $entity_type = $field_definition->getTargetEntityTypeId(); // type de l'entité.
    $bundle = $field_definition->getTargetBundle(); // bundle de l'entité;

    $fields = $this->entityFieldManager->getFieldDefinitions($entity_type, $bundle);
    // Get the variations fields
    $variations = $fields["variations"];
    $variations_settings  = $variations->getItemDefinition()->getSettings();
    // Get variation type and bundle
    $entity_type = $variations_settings["target_type"]; //for variations this time
    $bundle_list = $variations_settings["handler_settings"]["target_bundles"];

    // Options of the form field that is being handled
    $options = [];
    foreach ($bundle_list as $bundle) {
      $options[$bundle] = $bundle;
    }
    //If a bundle has never been selected then select the first in the list
    $setting_bundle = $this->getSetting('variation');
    $variation_bundle = isset($setting_bundle) ? $this->getSetting('variation') : reset($options);
    $element["variation"] = [
      '#type' => 'select',
      '#title' => $this->t('Variation'),
      '#options' => $options,
      '#default_value' => $variation_bundle
    ];

    $fields = $this->entityFieldManager->getFieldDefinitions($entity_type, $variation_bundle);
    $filtered_fields = $this->getFieldOfType($fields, 'commerce_product_attribute_value');
    $options = [];
    foreach ($filtered_fields as $field) {
      $temp_settings = $field->getItemDefinition()->getSettings();
      $bundle = reset($temp_settings['handler_settings']['target_bundles']);
      $options[$bundle] = $bundle;
    }
    $setting_attribute = $this->getSetting('attribute_bundle');
    $attribute_bundle = isset($setting_attribute) ? $setting_attribute : reset($options);
    $element['attribute'] = [
      '#type' => 'select',
      '#title' => $this->t("Attribute"),
      '#options' => $options,
      '#default_value' => $attribute_bundle
    ];

    // Get Attribute field list
    $fields = $this->entityFieldManager->getFieldDefinitions('commerce_product_attribute_value', $attribute_bundle);
    $options = [];
    foreach ($fields as $key => $field) {
      if ($field->getType() == 'image') {
        $options[$field->get('label')] = $field->get('field_name');
      }
    }

    $setting_gallery = $this->getSetting('gallery_field');
    $element['gallery_field'] = [
      '#type' => 'select',
      '#title' => $this->t("Gallery field"),
      '#options' => $options,
      '#default_value' => isset($setting_gallery) ? $setting_gallery : reset($options)
    ];
    // dump($element);
    return $element + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    // dump($items->getEntity()Drupal\Core\Field\BaseFieldDefinition ;

    foreach ($items as $delta => $item) {
      dump($item);
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }

  /**
   * Get all the field of a given type referenced
   * @param array &fields
   * @param string &field_type
   */
  protected function getFieldOfType($fields, $field_type) {
    $result = [];
    foreach ($fields as $field) {
      if ($field->getType() == "entity_reference" && $field->getItemDefinition()->getSettings()["target_type"] == $field_type) {
        $result[] = $field;
      }
    }
    return $result;
  }
}
