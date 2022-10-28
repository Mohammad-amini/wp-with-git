<?php
/*
   Plugin name: SEP gateway for Woocommerce
   Plugin URI: http://mojtaba.dev
   Description: Official Saman electronic payment gateway for Woocommerce
   Version: 3.0.0
   Author: Mojtaba Darvishi
   Author URI: http://mojtaba.dev
   Text Domain: sepwg
   Domain Path: /languages
*/

/**
 * Main SEP Gateway Class.
 *
 * @class SEP_WC_Main
 * @version    3.0.0
 */
class SEP_WC_Main {

	/**
	 * The single instance of the class.
	 *
	 * @var SEP_WC_Main
	 */
	protected static $_instance = null;

	/**
	 * Name of plugin in wordpress admin area
	 * @var
	 */
	private $name;


	/**
	 * Description of plugin in wordpress admin area
	 * @var
	 */
	private $description;


	/**
	 * SEP_WC_Main constructor.
	 */
	public function __construct() {
		$this->define_constants();
		//$this->includes();
		$this->init_hooks();

		$this->name        = __( 'SEP gateway for Woocommerce', 'sepwg' );
		$this->description = __( 'Official Saman electronic payment gateway for Woocommerce', 'sepwg' );
	}

	/**
	 * Hook into actions and filters.
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'localization' ) );
		add_action( 'plugins_loaded', array( $this, 'includes' ) );
		add_filter( 'woocommerce_payment_gateways', array( $this, 'add_gateway' ) );
	}

	/**
	 * Make plugin translatable
	 */
	public function localization() {
		$plugin_rel_path = plugin_basename( SEPWG_PATH ) . '/languages';
		load_plugin_textdomain( 'sepwg', false, $plugin_rel_path );
	}

	/**
	 *
	 * Add plugin gateway class to woocommerce gateways
	 *
	 * @param $gateways
	 *
	 * @return array
	 */
	public function add_gateway( $gateways ) {
		$gateways[] = 'WC_SEP_Gateway';

		return $gateways;
	}

	/**
	 * Main Gateway Instance.
	 *
	 * Ensures only one instance of SEP Gateway is loaded or can be loaded.
	 *
	 * @static
	 * @return SEP_WC_Main Gateway - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	/**
	 * Define SEP Constants.
	 */
	private function define_constants() {
		$this->define( 'SEPWG_URL', plugin_dir_url( __FILE__ ) );
		$this->define( 'SEPWG_PATH', plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string $name
	 * @param string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		/**
		 * Gateway Class.
		 */
		include_once( SEPWG_PATH . 'includes/class-gateway.php' );

	}

}

function get_instance_sep_gateway() {
	return SEP_WC_Main::instance();
}

get_instance_sep_gateway();
