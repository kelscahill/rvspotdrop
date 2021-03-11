<?php
/*
Plugin Name: WPForms Country State City Dropdown
Description: Add country, state and city auto drop down for WPForms. State will auto populate in SELECT field according to selected country and city will auto populate according to selected state.
Version: 1.0
Author: Trusty Plugins
Author URI: http://trustyplugins.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: tc_csca_wpforms
*/
// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No tircks please!' );

class TC_CSCA_WP_Plugin{

	public function __construct(){
		add_action( 'plugins_loaded', array( $this, 'tc_wp_load_plugin_data' ) );
	}
	public function tc_wp_load_plugin_data() {
		$this->tc_load_plugin_textdomain();
		if(class_exists('WPForms')){
			$this->tc_plugin_constants();
			require_once TC_CSCA_WP_PATH . 'includes/autoload.php';
			add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts_and_styles' ) );
		}else{
			add_action( 'admin_notices', array( $this, 'tc_admin_error_notice' ) );
		}
	}

	public function tc_load_plugin_textdomain() {
	 load_plugin_textdomain( 'tc_csca_wpforms', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/*
		register admin notice if WPForms Plugin is not active.
	*/

	public function tc_admin_error_notice(){
		$message = sprintf( esc_html__( 'The %1$sCountry State City Dropdown WPForms%2$s plugin requires %1$sWPForms%2$s plugin active to run properly. Please install %1$sWPForms%2$s and %1$sreactivate%2$s this plugin.', 'tc_csca' ),'<strong>', '</strong>');
		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );

	}

	/*
		set plugin constants
	*/
	public function tc_plugin_constants(){

		if ( ! defined( 'TC_CSCA_WP_PATH' ) ) {
			define( 'TC_CSCA_WP_PATH', plugin_dir_path( __FILE__ ) );
		}
		if ( ! defined( 'TC_CSCA_WP_URL' ) ) {
			define( 'TC_CSCA_WP_URL', plugin_dir_url( __FILE__ ) );
		}
		if ( ! defined( 'TC_CSCA_WP_VERSION' ) ) {
			define( 'TC_CSCA_WP_VERSION', '1.0');
		}
	}
	/*
	Enqueue Scripts For ADMIN
	*/
	public function add_admin_scripts_and_styles( $hook ) {
	    wp_enqueue_style( 'tc-csca-wp-custom-admin-style', TC_CSCA_WP_URL . 'assets/css/admin.css');
			}
}

// Instantiate the plugin class.
$tc_csca_plugin = new TC_CSCA_WP_Plugin();
register_activation_hook( __FILE__, 'tc_wp_create_db' );
function tc_wp_create_db() {
}
?>