<?php
/**
 * Plugin main class.
 *
 * @package WPDesk\PluginTemplate
 */

namespace WPDesk\PluginTemplate;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use PluginTemplateVendor\WPDesk_Plugin_Info;
use PluginTemplateVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin;
use PluginTemplateVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use PluginTemplateVendor\WPDesk\PluginBuilder\Plugin\HookableParent;

/**
 * Main plugin class. The most important flow decisions are made here.
 *
 * @package WPDesk\PluginTemplate
 */
class Plugin extends AbstractPlugin implements LoggerAwareInterface, HookableCollection {
	use LoggerAwareTrait;
	use HookableParent;

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
	}
}
