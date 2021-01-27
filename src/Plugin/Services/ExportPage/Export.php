<?php
/**
 * Export class
 *
 * @package WPDesk\WoocommerceExporter
 */

namespace WPDesk\WoocommerceExporter\Services\ExportPage;

use \League\Csv\Writer;
use \League\Csv\CannotInsertRecord;
use \League\Csv\Exception;

/**
 * Add WooCommerce Exporter page
 *
 * @package WPDesk\WoocommerceExporter\Services\ExportPage
 * @author Kamil Łazarz
 */
class Export {

	/**
	 * CSV Builder
	 *
	 * @var mixed $writer
	 */
	protected $writer;

	/**
	 * How many product should be handled in one query
	 */
	const PRODUCT_PER_QUERY = 50;

	/**
	 * Export constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_woocommerce_importer_export_form', [ $this, 'handle_export_form' ] );
	}

	/**
	 * Prepare CSV file to writing data
	 *
	 * @param string $name name of file which will generated.
	 * @return string $path relative path to csv file
	 */
	public function build_csv( $name = 'temp' ) {

		$path = sprintf( '/ExporterFiles/%s.csv', $name );

		$this->writer = Writer::createFromPath( __DIR__ . $path, 'w+' );
		$this->writer->setOutputBOM( Writer::BOM_UTF8 );

		try {
			$this->writer->addStreamFilter( 'convert.iconv.ISO-8859-15/UTF-8' );
		} catch ( Exception $e ) {
			wp_die( 'An error occurred while adding the stream filter.' );
		}

		return $path;
	}

	/**
	 * Add header to CSV file
	 *
	 * @param array $columns Headers for CSV file.
	 */
	public function add_header( array $columns ) {

		$this->check();

		try {
			$this->writer->insertOne( $columns );
		} catch ( CannotInsertRecord $e ) {
			wp_die( 'An error occurred while adding the header' );
		}

	}

	/**
	 * Add records to CSV
	 *
	 * @param array $records products.
	 */
	public function add_records( array $records ) {

		$this->check();

		$this->writer->insertAll( $records );
	}

	/**
	 * WordPress ajax export
	 */
	public function handle_export_form() {

		if ( ! ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'woocommerce-exporter_export-form' ) ) ) {
			wp_send_json_success(
				[
					'response' => 'error',
					'message'  => __( 'Wrong nonce key.', 'woocommerce-exporter' ),
				]
			);
		}

		$file_path = $this->build_csv( 'temp' );

		$this->add_header(
			[
				__( 'Product name', 'woocommerce-exporter' ),
				__( 'Categories', 'woocommerce-exporter' ),
				__( 'SKU', 'woocommerce-exporter' ),
				__( 'Price', 'woocommerce-exporter' ),
				__( 'Regular Price', 'woocommerce-exporter' ),
			]
		);

		$this->export();

		wp_send_json_success(
			[
				'response'  => 'success',
				'file_path' => '/src/Plugin/Services/ExportPage' . $file_path,
			]
		);
	}

	/**
	 * Check, that all rules are met
	 */
	private function check() {
		if ( ! $this->writer ) {
			$this->writer_not_exists();
		}
	}

	/**
	 * Display error when the writer does not exists
	 */
	private function writer_not_exists() {
		wp_die( 'Writer does not exist, run build_csv method first.' );
	}

	/**
	 * Export product into CSV file
	 */
	public function export() {

		$this->check();

		$service = new Products();

		$page = 0;
		$args = [
			'posts_per_page' => self::PRODUCT_PER_QUERY,
			'offset'         => $page * self::PRODUCT_PER_QUERY,
		];

		$products      = $service->get_products( $args );
		$exported_data = [];

		while ( ! empty( $products ) ) {

			foreach ( $products as $product ) {
				$exported_data[] = $product->get_export_array();
			}

			$page++;
			$args['offset'] = $page * self::PRODUCT_PER_QUERY;
			$products       = $service->get_products( $args );
		}

		$this->add_records( $exported_data );
	}
}
