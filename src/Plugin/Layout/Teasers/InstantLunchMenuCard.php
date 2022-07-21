<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Teasers;

use Drupal\layoutscommerce\Plugin\Layout\LayoutscommerceTeaser;
use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;

/**
 * A very advanced custom layout.
 *
 * @Layout(
 *   id = "instant_lunch_menu_card",
 *   label = @Translation(" Instant Lunch menu card "),
 *   category = @Translation("instantlunch"),
 *   path = "layouts/teasers",
 *   template = "instantlunch-menu-card",
 *   library = "layoutscommerce/instantlunch-menu-card",
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
 *     "menu_desc_title" = {
 *       "label" = @Translation(" menu_desc_title ")
 *     },
 *     "menu_desc_content" = {
 *       "label" = @Translation(" menu_desc_content ")
 *     },
 *     "desc_img_title" = {
 *       "label" = @Translation(" desc_img_title ")
 *     },
 *    "desc_img_content" = {
 *       "label" = @Translation(" desc_img_content ")
 *     },
 *     "add_to_cart" = {
 *       "label" = @Translation("add_to_cart")
 *     }
 *   }
 * )
 */
class InstantLunchMenuCard extends LayoutscommerceTeaser {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
    // TODO Auto-generated method stub
    parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
    $this->pluginDefinition->set('icon', drupal_get_path('module', 'layoutscommerce') . "/icones/teasers/il-menu-card.png");
    // $this->currency_formatter = $CurrencyFormatter;
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
    $this->LayoutCommerceProductVariation->getRenderField($build['title'], $build);
    $this->LayoutCommerceProductVariation->getRenderAddToCart($build['title'], $build, 'add_to_cart', $build['add_to_cart']);
    return $build;
  }
  
  function defaultConfiguration() {
    return [
      'load_libray' => false,
      'infos' => [
        'builder-form' => true,
        'info' => [
          'title' => 'Card information',
          'loader' => 'static'
        ],
        'fields' => [
          'images' => [
            'text_html' => [
              'label' => 'images',
              'value' => '<a href="#">
                            <img src="https://i0.wp.com/instant-lunch.store/wp-content/uploads/2022/06/curry-vert-riz-le%CC%81gumes-produits.jpg?fit=800%2C800&ssl=1"
                                 alt="">
                        </a>'
            ]
          ],
          'title' => [
            'text_html' => [
              'label' => 'title',
              'value' => '<a href="#">Le menu du jardine</a>'
            ]
          ],
          'price' => [
            'text_html' => [
              'label' => 'prix',
              'value' => '18.98€ HT'
            ]
          ],
          'menu_desc_title' => [
            'text_html' => [
              'label' => 'menu_desc_title',
              'value' => 'livré chaud'
            ]
          ],
          'menu_desc_content' => [
            'text_html' => [
              'label' => 'menu_desc_content',
              'value' => ' <div class="ilc-ul__item">
                                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512">
                                                <path
                                                      d="M100.4 112.3L.5101 491.7c-1.375 5.625 .1622 11.6 4.287 15.6c4.127 4.125 10.13 5.744 15.63 4.119l379.1-105.1C395.3 231.4 276.5 114.1 100.4 112.3zM127.1 416c-17.62 0-32-14.38-32-31.1c0-17.62 14.39-32 32.01-32c17.63 0 32 14.38 32 31.1C160 401.6 145.6 416 127.1 416zM175.1 271.1c-17.63 0-32-14.38-32-32c0-17.62 14.38-31.1 32-31.1c17.62 0 32 14.38 32 31.1C208 257.6 193.6 271.1 175.1 271.1zM272 367.1c-17.62 0-32-14.38-32-31.1c0-17.62 14.38-32 32-32c17.63 0 32 14.38 32 32C304 353.6 289.6 367.1 272 367.1zM158.9 .1406c-16.13-1.5-31.25 8.501-35.38 24.12L108.7 80.52c187.6 5.5 314.5 130.6 322.5 316.1l56.88-15.75c15.75-4.375 25.5-19.62 23.63-35.87C490.9 165.1 340.8 17.39 158.9 .1406z" />
                                            </svg></span>
                                        <div class="text">Quiche poulet poivrons</div>
                                    </div>
                                    <div class="ilc-ul__item">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                      d="M481.9 270.1C490.9 279.1 496 291.3 496 304C496 316.7 490.9 328.9 481.9 337.9C472.9 346.9 460.7 352 448 352H64C51.27 352 39.06 346.9 30.06 337.9C21.06 328.9 16 316.7 16 304C16 291.3 21.06 279.1 30.06 270.1C39.06 261.1 51.27 256 64 256H448C460.7 256 472.9 261.1 481.9 270.1zM475.3 388.7C478.3 391.7 480 395.8 480 400V416C480 432.1 473.3 449.3 461.3 461.3C449.3 473.3 432.1 480 416 480H96C79.03 480 62.75 473.3 50.75 461.3C38.74 449.3 32 432.1 32 416V400C32 395.8 33.69 391.7 36.69 388.7C39.69 385.7 43.76 384 48 384H464C468.2 384 472.3 385.7 475.3 388.7zM50.39 220.8C45.93 218.6 42.03 215.5 38.97 211.6C35.91 207.7 33.79 203.2 32.75 198.4C31.71 193.5 31.8 188.5 32.99 183.7C54.98 97.02 146.5 32 256 32C365.5 32 457 97.02 479 183.7C480.2 188.5 480.3 193.5 479.2 198.4C478.2 203.2 476.1 207.7 473 211.6C469.1 215.5 466.1 218.6 461.6 220.8C457.2 222.9 452.3 224 447.3 224H64.67C59.73 224 54.84 222.9 50.39 220.8zM372.7 116.7C369.7 119.7 368 123.8 368 128C368 131.2 368.9 134.3 370.7 136.9C372.5 139.5 374.1 141.6 377.9 142.8C380.8 143.1 384 144.3 387.1 143.7C390.2 143.1 393.1 141.6 395.3 139.3C397.6 137.1 399.1 134.2 399.7 131.1C400.3 128 399.1 124.8 398.8 121.9C397.6 118.1 395.5 116.5 392.9 114.7C390.3 112.9 387.2 111.1 384 111.1C379.8 111.1 375.7 113.7 372.7 116.7V116.7zM244.7 84.69C241.7 87.69 240 91.76 240 96C240 99.16 240.9 102.3 242.7 104.9C244.5 107.5 246.1 109.6 249.9 110.8C252.8 111.1 256 112.3 259.1 111.7C262.2 111.1 265.1 109.6 267.3 107.3C269.6 105.1 271.1 102.2 271.7 99.12C272.3 96.02 271.1 92.8 270.8 89.88C269.6 86.95 267.5 84.45 264.9 82.7C262.3 80.94 259.2 79.1 256 79.1C251.8 79.1 247.7 81.69 244.7 84.69V84.69zM116.7 116.7C113.7 119.7 112 123.8 112 128C112 131.2 112.9 134.3 114.7 136.9C116.5 139.5 118.1 141.6 121.9 142.8C124.8 143.1 128 144.3 131.1 143.7C134.2 143.1 137.1 141.6 139.3 139.3C141.6 137.1 143.1 134.2 143.7 131.1C144.3 128 143.1 124.8 142.8 121.9C141.6 118.1 139.5 116.5 136.9 114.7C134.3 112.9 131.2 111.1 128 111.1C123.8 111.1 119.7 113.7 116.7 116.7L116.7 116.7z" />
                                            </svg>
                                        </span>
                                        <div class="text">Pancom gliffe salé</div>
                                    </div>
                                    <div class="ilc-ul__item">
                                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 448 512">
                                                <path
                                                      d="M96.06 288.3H351.9L252.6 493.8C250.1 499.2 246 503.8 240.1 507.1C235.9 510.3 230 512 224 512C217.1 512 212.1 510.3 207 507.1C201.1 503.8 197.9 499.2 195.4 493.8L96.06 288.3zM386.3 164C392.1 166.4 397.4 169.9 401.9 174.4C406.3 178.8 409.9 184.1 412.3 189.9C414.7 195.7 415.1 201.1 416 208.3C416 214.5 414.8 220.8 412.4 226.6C409.1 232.4 406.5 237.7 402 242.2C397.6 246.6 392.3 250.2 386.5 252.6C380.7 255 374.4 256.3 368.1 256.3H79.88C67.16 256.3 54.96 251.2 45.98 242.2C37 233.2 31.97 220.1 32 208.3C32.03 195.5 37.1 183.4 46.12 174.4C55.14 165.4 67.35 160.4 80.07 160.4H81.06C80.4 154.9 80.06 149.4 80.04 143.8C80.04 105.7 95.2 69.11 122.2 42.13C149.2 15.15 185.8 0 223.1 0C262.1 0 298.7 15.15 325.7 42.13C352.7 69.11 367.9 105.7 367.9 143.8C367.9 149.4 367.6 154.9 366.9 160.4H367.9C374.2 160.4 380.5 161.6 386.3 164z" />
                                            </svg></span>
                                        <div class="text">salade césar</div>
                                    </div>'
            ]
          ],
          'desc_img_title' => [
            'text_html' => [
              'label' => 'desc_img_title',
              'value' => 'Inclus'
            ]
          ],
          'desc_img_content' => [
            'text_html' => [
              'label' => 'desc_img_content',
              'value' => '<img 
                                  src="https://i0.wp.com/instant-lunch.store/wp-content/uploads/2022/01/IsntantLunch_Picto_EauPainSet-02.png?resize=65%2C65&ssl=1" alt="">
                                    <img src="https://i0.wp.com/instant-lunch.store/wp-content/uploads/2022/01/IsntantLunch_Picto_EauPainSet-02.png?resize=65%2C65&ssl=1"
                                         alt="">
                                    <img src="https://i0.wp.com/instant-lunch.store/wp-content/uploads/2022/01/IsntantLunch_Picto_EauPainSet-02.png?resize=65%2C65&ssl=1"
                       alt="">'
            ]
          ],
          'add_to_cart' => [
            'text_html' => [
              'label' => 'title add to cart',
              'value' => '<a href="#"> Ajouter au panier </a>'
            ]
          ]
        ]
      ]
    ] + parent::defaultConfiguration();
  }
  
}