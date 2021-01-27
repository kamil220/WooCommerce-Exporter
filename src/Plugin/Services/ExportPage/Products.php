<?php
/**
 * Products controller
 *
 * @package WPDesk\WoocommerceExporter
 */

namespace WPDesk\WoocommerceExporter\Services\ExportPage;

use WPDesk\WoocommerceExporter\Services\ExportPage\Models\Product;

/**
 * Class Products
 *
 * @package WPDesk\WoocommerceExporter\Services\ExportPage
 * @author Kamil Łazarz
 */
class Products {
	/**
	 * Get product for export
	 *
	 * @param array $args post query args.
	 * @return array
	 */
	public function get_products( $args = [] ) {

		$args = wp_parse_args(
			$args,
			[
				'post_type'      => 'product',
				'posts_per_page' => 50,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'post_status'    => 'any',
			]
		);

		return $this->get_products_models( $args );
	}

	/**
	 * Get woocommerce product and prepare data
	 *
	 * @param array $args get posts arguments.
	 * @return array
	 */
	private function get_products_models( $args = [] ) {

		$woo_products = get_posts( $args );
		$products     = [];

		if ( empty( $woo_products ) ) {
			return [];
		}

		foreach ( $woo_products as $product ) {
			$product    = new \WC_Product_Variable( $product );
			$variations = $product->get_children();
			$products[] = new Product( $product );

			if ( ! empty( $variations ) ) {
				foreach ( $variations as $variation ) {
					$variation  = new \WC_Product_Variation( $variation );
					$products[] = new Product( $variation, $product );
				}
			}
		}

		return $products;
	}
}
