<?php
/**
 * Product Entity
 *
 * @package WPDesk\WoocommerceExporter
 */

namespace WPDesk\WoocommerceExporter\Services\ExportPage\Models;

use WC_Product;

/**
 * WooCommerce Exporter Product model
 *
 * @package WPDesk\WoocommerceExporter\Services\ExportPage
 * @author Kamil Łazarz
 */
class Product {
	/**
	 * Product name
	 *
	 * @var string $name
	 */
	public $name;

	/**
	 * Product categories
	 *
	 * @var array $categories
	 */
	public $categories;

	/**
	 * Product SKU
	 *
	 * @var string $sku
	 */
	public $sku;

	/**
	 * Product price after discount
	 *
	 * @var string $price
	 */
	public $price;

	/**
	 * Regular product price
	 *
	 * @var string $regular_price
	 */
	public $regular_price;

	/**
	 * Product constructor
	 *
	 * @param WC_Product $product WooCommerce product model.
	 */
	public function __construct( WC_Product $product ) {

		$this->name = $product->get_name();
		$this->regular_price = $product->get_regular_price();
		$this->price = $product->get_price();
		$this->sku = $product->get_sku();
		$this->categories = $product->get_category_ids();

	}
}
