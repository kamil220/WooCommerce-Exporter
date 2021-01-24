<?php
/**
 * Page class
 *
 * @package WPDesk\WoocommerceExporter
 */

namespace WPDesk\WoocommerceExporter\Services\ExportPage;

/**
 * Add WooCommerce Exporter page
 *
 * @package WPDesk\WoocommerceExporter\Services\ExportPage
 * @author Kamil Łazarz
 */
class Page {

	const WOOCOMMERCE_EXPORTER_MENU_SLUG       = 'wpdesk-woocommerce-exporter';
	const WOOCOMMERCE_EXPORTER_MENU_CAPABILITY = 'manage_options';


	/**
	 * Adds export page submenu.
	 * Have to be called from admin_menu action.
	 *
	 * @return void
	 */
	public function handle_add_page_submenu_item() {
		add_submenu_page(
			'wpdesk-helper',
			__( 'WooCommerce Exporter', 'woocommerce-exporter' ),
			__( 'WooCommerce Exporter', 'woocommerce-exporter' ),
			self::WOOCOMMERCE_EXPORTER_MENU_CAPABILITY,
			self::WOOCOMMERCE_EXPORTER_MENU_SLUG,
			[ $this, 'handle_render_woocommerce_exporter_page' ]
		);
	}

	/**
	 * Add WooCommerce Exporter Page template
	 *
	 * @todo Add template loader
	 *
	 * @return void
	 */
	public function handle_render_woocommerce_exporter_page() {
		require_once __DIR__ . '/Views/Panel.php';
	}
}
