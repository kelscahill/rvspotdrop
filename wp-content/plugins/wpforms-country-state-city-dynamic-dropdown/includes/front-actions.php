<?php
class tc_wp_front_actions {
	public function __construct(){
	 add_action( 'wp_enqueue_scripts',array($this,'tc_csca_wp_embedCssJs'));
add_action('wp_ajax_csca_wp_countries',array($this,'csca_wp_countries'));
add_action("wp_ajax_nopriv_csca_wp_countries", array($this,"csca_wp_countries"));
add_action('wp_ajax_csca_wp_states',array($this,'csca_wp_states'));
add_action("wp_ajax_nopriv_csca_wp_states", array($this,"csca_wp_states"));
add_action('wp_ajax_csca_wp_cities',array($this,'csca_wp_cities'));
add_action("wp_ajax_nopriv_csca_wp_cities", array($this,"csca_wp_cities"));		
	}
public function tc_csca_wp_embedCssJs() {
	wp_enqueue_script( 'tc_csca-wp-country-auto-script', TC_CSCA_WP_URL . 'assets/js/script.js', array( 'jquery' ) );
	wp_localize_script( 'tc_csca-wp-country-auto-script', 'tc_csca_wp_auto_ajax', array( 'ajax_url' => admin_url('admin-ajax.php'),'nonce'=>wp_create_nonce('tc_csca_wp_ajax_nonce')) );
	}
public function csca_wp_countries() {
        check_ajax_referer( 'tc_csca_wp_ajax_nonce', 'nonce_ajax' );	
		global $wpdb;
		$countries = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->base_prefix."countries order by name asc") );
		echo json_encode($countries);
		wp_die();
	}
public function csca_wp_states() {
		check_ajax_referer( 'tc_csca_wp_ajax_nonce', 'nonce_ajax' );	
		global $wpdb;
		if(isset($_POST["cnt"]))
		{
		$cid=sanitize_text_field($_POST["cnt"]);
		}
		$states = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->base_prefix."state where country_id=%1s order by name asc", $cid) );
		echo json_encode($states);
		wp_die();
}
	public function csca_wp_cities() {
		check_ajax_referer( 'tc_csca_wp_ajax_nonce', 'nonce_ajax' );	
		global $wpdb;
		if(isset($_POST["sid"]))
		{
		$sid=sanitize_text_field($_POST["sid"]);
		}
		$cities = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->base_prefix."city where state_id=%1s order by name asc", $sid) );
		echo json_encode($cities);
		wp_die();
}
}
new tc_wp_front_actions();