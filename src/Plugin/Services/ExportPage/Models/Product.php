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

	const SEPARATOR_SIGN = '|';

	/**
	 * Product id
	 *
	 * @var int $id
	 */
	public $id;

	/**
	 * Product name
	 *
	 * @var string $name
	 */
	public $name;

	/**
	 * Product categories
	 *
	 * @var string $categories
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
	 * @param WC_Product      $product WooCommerce product model.
	 * @param NULL|WC_Product $parent WooCommerce parent product model.
	 */
	public function __construct( WC_Product $product, WC_Product $parent = null ) {

		$this->name       = $this->get_name( $product, $parent );
		$this->categories = $this->get_categories( $product->get_category_ids() );

		$this->id            = $product->get_id();
		$this->regular_price = $product->get_regular_price();
		$this->price         = $product->get_price();
		$this->sku           = $product->get_sku();

	}

	/**
	 * Get product name after adjustment
	 * Replace slash into pipe for variation product
	 *
	 * @param WC_Product      $product WooCommerce product model.
	 * @param NULL|WC_Product $parent WooCommerce parent product model.
	 * @return string
	 */
	private function get_name( WC_Product $product, WC_Product $parent = null ) {

		if ( ! $parent ) {
			return $product->get_name();
		}

		return str_replace(
			$parent->get_name() . ' - ',
			$parent->get_name() . self::SEPARATOR_SIGN,
			$product->get_name()
		);
	}

	/**
	 * Get categories names with separator
	 *
	 * @param array $categories_ids product categories ids.
	 * @return string
	 */
	private function get_categories( array $categories_ids ) {

		$categories = [];

		foreach ( $categories_ids as $category_id ) {
			$term = get_term( $category_id, 'product_cat', OBJECT );

			if ( ! isset( $term->name ) ) {
				continue;
			}

			$categories[] = $term->name;
		}

		return implode( self::SEPARATOR_SIGN, $categories );
	}
}
