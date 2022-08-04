<?php

namespace Drupal\layoutscommerce\Plugin\Field\FieldFormatter;

use Drupal\comment\Plugin\Field\FieldFormatter\CommentDefaultFormatter;
use Drupal\comment\Plugin\Field\FieldType\CommentItemInterface;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\layoutgenentitystyles\Services\LayoutgenentitystylesServices;

/**
 * Provides a default comment formatter.
 *
 * @FieldFormatter(
 *   id = "comment_nutribe_formatter",
 *   module = "comment",
 *   label = @Translation(" Comment list format Nutribe "),
 *   field_types = {
 *     "comment"
 *   },
 *   quickedit = {
 *     "editor" = "disabled"
 *   }
 * )
 */
class CommentNutribeFormatter extends CommentDefaultFormatter {
  
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
    return new static($plugin_id, $plugin_definition, $configuration['field_definition'], $configuration['settings'], $configuration['label'], $configuration['view_mode'], $configuration['third_party_settings'], $container->get('current_user'), $container->get('entity_type.manager'), $container->get('entity.form_builder'), $container->get('current_route_match'), $container->get('entity_display.repository'), $container->get('layoutgenentitystyles.add.style.theme'));
  }
  
  /**
   * Constructs a new CommentDefaultFormatter.
   *
   * @param string $plugin_id
   *        The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *        The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *        The definition of the field to which the formatter is associated.
   * @param array $settings
   *        The formatter settings.
   * @param string $label
   *        The formatter label display setting.
   * @param string $view_mode
   *        The view mode.
   * @param array $third_party_settings
   *        Third party settings.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *        The current user.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *        The entity type manager.
   * @param \Drupal\Core\Entity\EntityFormBuilderInterface $entity_form_builder
   *        The entity form builder.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *        The route match object.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entity_display_repository
   *        The entity display repository.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, AccountInterface $current_user, EntityTypeManagerInterface $entity_type_manager, EntityFormBuilderInterface $entity_form_builder, RouteMatchInterface $route_match, EntityDisplayRepositoryInterface $entity_display_repository, LayoutgenentitystylesServices $LayoutgenentitystylesServices) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings, $current_user, $entity_type_manager, $entity_form_builder, $route_match, $entity_display_repository);
    $this->LayoutgenentitystylesServices = $LayoutgenentitystylesServices;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [ // Implement default settings.
      'comment_empty' => 'Soyez le ou la  premier(e) à donner votre avis sur ce produit !'
    ] + parent::defaultSettings();
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];
    $elements['comment_empty'] = [
      '#title' => $this->t('Comments empty'),
      '#type' => 'text_field',
      '#element_validate' => [
        [
          $this,
          'libraryCallback'
        ]
      ],
      '#default_value' => $this->getSetting('comment_empty')
    ];
    $form = [
      $elements
    ] + parent::settingsForm($form, $form_state);
    
    return $form;
  }
  
  public function libraryCallback(&$element, FormStateInterface $form_state, &$complete_form) {
    // Ajoute la configuration à l'enregistrement du champs.
    $this->LayoutgenentitystylesServices->addStyleFromModule("layoutscommerce/comment-nutribe-formatter", 'comment_nutribe_formatter', 'default');
  }
  
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);
    $comments = [
      '#type' => 'html_tag',
      '#tag' => 'h3',
      '#value' => $this->getSetting("comment_empty")
    ];
    if (!empty($elements[0]['comments']))
      $comments = $elements[0]['comments'];
    //
    $comment_type = null;
    $comment_display_mode = null;
    $comment_form = null;
    $cache = [];
    if (!empty($elements[0]['#comment_type'])) {
      $comment_type = $elements[0]['#comment_type'];
      $comment_display_mode = $elements[0]['#comment_display_mode'];
      $comment_form = $elements[0]['comment_form'];
      $cache = $elements['#cache'];
    }
    return [
      '#theme' => 'layoutscommerce_comments',
      '#cache' => $cache,
      '#comment_type' => $comment_type,
      '#comment_display_mode' => $comment_display_mode,
      '#avis' => '',
      '#notes' => '',
      '#comments' => $comments,
      '#comment_form' => $comment_form
    ];
  }
  
}