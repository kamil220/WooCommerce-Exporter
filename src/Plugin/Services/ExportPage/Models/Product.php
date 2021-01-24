<?php
/**
 * Product Entity
 *
 * @package WPDesk\WoocommerceExporter
 */

namespace WPDesk\WoocommerceExporter\Services\ExportPage\Models;

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
	 * @var float $price
	 */
	public $price;

	/**
	 * Regular product price
	 *
	 * @var float $regular_price
	 */
	public $regular_price;
}
