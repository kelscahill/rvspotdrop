<?php
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_country = $wpdb->prefix . 'countries';
	$table_state = $wpdb->prefix . 'state';
	$table_city = $wpdb->prefix . 'city';
$country_create = "CREATE TABLE IF NOT EXISTS $table_country (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$state_create="CREATE TABLE IF NOT EXISTS $table_state (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `country_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;";
$city_create="CREATE TABLE IF NOT EXISTS $table_city (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `state_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;";
	include_once TC_CSCA_WP_PATH.'includes/countries-sql.php';
	include_once TC_CSCA_WP_PATH.'includes/states-sql.php';
	include_once TC_CSCA_WP_PATH.'includes/cities-sql.php';
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	if(!get_option('tc_auto_wp_plugin'))
	{
	update_option('tc_auto_wp_plugin','installed');
	}
	if(get_option('tc_auto_wp_plugin')=='installed')
	{
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}countries");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}state");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}city");
	dbDelta($country_create);
	dbDelta($state_create);
	dbDelta($city_create);
	dbDelta($country_insert);
    dbDelta($state_insert);
	dbDelta($city_insert);
	update_option('tc_auto_wp_plugin','activated');
	update_option('tc_auto_wp_plugin_version',TC_CSCA_WP_VERSION);
	}
?>