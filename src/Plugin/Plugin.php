<?php
/**
 * Plugin main class.
 *
 * @package WPDesk\WoocommerceExporter
 */

namespace WPDesk\WoocommerceExporter;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use WoocommerceExporterVendor\WPDesk_Plugin_Info;
use WoocommerceExporterVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin;
use WoocommerceExporterVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use WoocommerceExporterVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
use Symfony\Component\EventDispatcher\Tests\Service;

/**
 * Main plugin class. The most important flow decisions are made here.
 *
 * @package WPDesk\WoocommerceExporter
 */
class Plugin extends AbstractPlugin implements LoggerAwareInterface, HookableCollection {
	use LoggerAwareTrait;
	use HookableParent;

	const WOOCOMMERCE_EXPORTER_MENU_PRIORITY = 30;

	/**
	 * Export page class adds submenu into admin dashboard
	 *
	 * @var Services\ExportPage\Page
	 */
	protected $export_page;

	/**
	 * Plugin constructor.
	 *
	 * @param WPDesk_Plugin_Info $plugin_info Plugin info.
	 */
	public function __construct( WPDesk_Plugin_Info $plugin_info ) {
		parent::__construct( $plugin_info );
		$this->setLogger( new NullLogger() );

		$this->plugin_url       = $this->plugin_info->get_plugin_url();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();

		$this->export_page = new Services\ExportPage\Page();

	}

	/**
	 * Initializes plugin external state.
	 *
	 * The plugin internal state is initialized in the constructor and the plugin should be internally consistent after creation.
	 * The external state includes hooks execution, communication with other plugins, integration with WC etc.
	 *
	 * @return void
	 */
	public function init() {
		parent::init();
	}

	/**
	 * Integrate with WordPress and with other plugins using action/filter system.
	 *
	 * @return void
	 */
	public function hooks() {
		parent::hooks();

		$this->add_export_page();
	}

	/**
	 * Append JS scripts in WordPress. This is a hook function. Do not execute directly.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'woocommerce-exporter', $this->plugin_url . '/src/Plugin/Services/ExportPage/Assets/export.js', [ 'jquery' ], '1.0.0', true );
		wp_localize_script(
			'woocommerce-exporter',
			'wpdesk',
			[
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'plugin_url' => $this->plugin_url,
			]
		);
	}

	/**
	 * Add page if helper exists
	 *
	 * @return void
	 */
	private function add_export_page() {
		\add_action(
			'admin_menu', function () {
				$this->export_page->handle_add_page_submenu_item();
			}, self::WOOCOMMERCE_EXPORTER_MENU_PRIORITY
		);

		add_action(
			'init', function() {
				$this->export_page->handle_ajax_woocommerce_exporter_page();
			}
		);
	}
}
