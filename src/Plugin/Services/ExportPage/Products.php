<?php
/**
 * Products controller
 */

namespace WPDesk\WoocommerceExporter\Services\ExportPage;

use WPDesk\WoocommerceExporter\Services\ExportPage\Models\Product;

/**
 * Class Products
 *
 * @package WPDesk\WoocommerceExporter\Services\ExportPage
 * @author Kamil Łazarz
 */
class Products
{
	/**
	 * Get product for export
	 *
	 * @param array $args post query args
	 * @return array
	 */
	public function get_products( $args = [] ) {

		$args = shortcode_atts( [
			'post_type' => 'product',
			'posts_per_page' => -1,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_status'	=> 'any'
		], $args );

		return $this->get_products_models( $args );
	}

	/**
	 * Get woocommerce product and prepare data
	 *
	 * @param $args
	 * @return array
	 */
	private function get_products_models( $args ) {

		$woo_products = get_posts( $args );
		$products = [];

		if( empty( $woo_products ) ) {
			return [];
		}

		foreach ( $woo_products as $product ) {
			$product = new \WC_Product_Variable( $product );
			$variations = $product->get_children();
			$products[] = new Product( $product );

			if( !empty( $variations ) ){
				foreach ( $variations as $variation ) {
					$variation = new \WC_Product_Variation( $variation );
					$products[] = new Product( $variation, $product );
				}
			}
		}

		return $products;
	}
}
