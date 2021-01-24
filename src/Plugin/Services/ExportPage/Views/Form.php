<?php
/**
 * WooCommerce Exporter Form template
 *
 * @package WPDesk\WoocommerceExporter
 */

/* For security reason */
if ( ! \defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form class="woocommerce-exporter-form" method="post" action="#">
	<?php
		/**
		 * Add WordPress nonce for security reason
		 */
		\wp_nonce_field( 'woocommerce-exporter_export-form' );

		/**
		 * Add hook which allows to extend the form fields
		 *
		 * @hook wpdesk_woocommerce_exporter_form_fields
		 * @notice Personally I prefer following notation WPDesk\WoocommerceExporter\Services\ExportPage\Form\Fields
		 */
		\do_action( 'wpdesk_woocommerce_exporter_form_fields' );


		/**
		 * Add WordPress submit button
		 */
		\submit_button( __( 'Export to CSV', 'woocommerce-exporter' ) );
	?>
</form>
