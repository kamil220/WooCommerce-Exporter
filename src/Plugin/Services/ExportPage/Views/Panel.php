<?php
/**
 * WooCommerce Exporter Panel template
 *
 * @package WPDesk\WoocommerceExporter
 */

/* For security reason */
if ( ! \defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap">
	<h1>
		<?php esc_html_e( 'WooCommerce Exporter', 'woocommerce-exporter' ); ?>
	</h1>

	<p class="mb0">
		<?php esc_html_e( 'WooCommerce Exporter is a simple plugin to export each WooCommerce product into a CSV file. The tool exports all products even with draft status or with zero stock quantity.', 'woocommerce-exporter' ); ?>
	</p>
	<!--	p.mb0-->

	<?php require_once __DIR__ . '/Form.php'; ?>

</div>
<!--wrap-->
