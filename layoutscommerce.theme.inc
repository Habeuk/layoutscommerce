  <?php
  use Drupal\formatage_models\FormatageModelsThemes;
  
  function template_preprocess_layoutscommerce_product_teaser_view_style(&$vars) {
    FormatageModelsThemes::ViewsGetValues($vars);
  }