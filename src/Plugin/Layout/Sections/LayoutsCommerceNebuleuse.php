<?php

namespace Drupal\layoutscommerce\Plugin\Layout\Sections;

use Drupal\bootstrap_styles\StylesGroup\StylesGroupManager;
use Drupal\formatage_models\FormatageModelsThemes;
use Drupal\formatage_models\Plugin\Layout\Sections\FormatageModelsSection;

/**
 *
 * Custom layout for Layoutscommmerce module
 *
 * @Layout(
 *   id = "nebuleuse_product",
 *   label = @Translation(" Nebuleuse Product section "),
 *   category = @Translation("layoutscommerce"),
 *   path = "layouts/sections",
 *   template = "layoutscommerce_nebuleuse_product",
 *   library = "layoutscommerce/layoutscommerce_nebuleuse_product",
 *   default_region = "gallery",
 *   regions = {
 *      "main_gallery" = {
 *          "label" = @Translation("Product gallery"),
 *      },
 *      "thumb_gallery" = {
 *          "label" = @Translation("Thumbnail gallery"),
 *      },
 *      "Title" = {
 *          "label" = @Translation("Product title"),
 *      },
 *      "manufacturer" = {
 *          "label" = @Translation("Product manufacturer"),
 *      },
 *      "rating" = {
 *          "label" = @Translation("Product rating"),
 *      },
 *      "sup_info" = {
 *          "label" = @Translation("More product's informations"),
 *      },
 *      "status" = {
 *          "label" = @Translation("Product availability"),
 *      },
 *      "attributes" = {
 *          "label" = @Translation("Product Attributes"),
 *      },
 *      "add_to_cart" = {
 *          "label" = @Translation("Add to cart button"),
 *      },
 *      "add_to_wish_list" = {
 *          "label" = @Translation("Add to wish list button"),
 *      },
 *      "properties" = {
 *          "label" = @Translation("Product Properties"),
 *      }
 *   }
 * )
 *
 */
class LayoutsCommerceNebuleuse extends FormatageModelsSection {

	/**
	 *
	 * {@inheritdoc}
	 * @see \Drupal\formatage_models\Plugin\Layout\FormatageModels::__construct()
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, StylesGroupManager $styles_group_manager) {
		// TODO Auto-generated method stub
		parent::__construct($configuration, $plugin_id, $plugin_definition, $styles_group_manager);
		$this->pluginDefinition->set('icon', $this->pathResolver->getPath('module', 'layoutscommerce') . "/icones/sections/layoutscommerce_nebuleuse.png");
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
		return $build;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function defaultConfiguration() {
		return parent::defaultConfiguration() + [
			'load_libray' => false,
			'left-classes' => "col-md-6",
			'right-classes' => "col-md-6",
			'infos' => [
				'builder-form' => true,
				'info' => [
					'title' => 'Contenu',
					'loader' => 'dynamic'
				],
				'fields' => [
					'main_gallery' => [
						'text_html' => [
							'label' => 'Gallery',
							'value' => ''
						]
					],
					'thumb_gallery' => [
						'text_html' => [
							'label' => 'thumbnail navigator',
							'value' => ''
						]
					],
					'manufacturer' => [
						'text_html' => [
							'label' => 'manufacturer'
						]
					],
					'rating' => [
						'text_html' => [
							'label' => 'rating',
						]
					],
					'sup_info' => [
						'text_html' => [
							'label' => 'more informations',
						]
					],
					'status' => [
						'text_html' => [
							'label' => 'product status'
						]
					],
					'attributes' => [
						'text_html' => [
							'label' => 'product\'s attributes'
						]
					],
					'add_to_cart' => [
						'text_html' => [
							'label' => 'add to cart button'
						]
					],
					'add_to_wish_list' => [
						'text_html' => [
							'label' => 'add to wish list button'
						]
					],
					'properties' => [
						'text_html' => [
							'label' => 'product\' properties'
						]
					]
				]
			]
		];
	}
}
