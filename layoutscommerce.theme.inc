  <?php
  use Drupal\formatage_models\FormatageModelsThemes;
  
  /**
   *
   * @param array $vars
   */
  function template_preprocess_layoutscommerce_product_teaser_view_style(&$vars) {
    FormatageModelsThemes::ViewsGetValues($vars);
  }
  
  /**
   *
   * @param array $vars
   */
  function template_preprocess_layoutscommerce_attribute_items(&$vars) {
    //
  }
  
  /**
   *
   * @param array $vars
   */
  function template_preprocess_layoutscommerce_comments(&$vars) {
    //
  }