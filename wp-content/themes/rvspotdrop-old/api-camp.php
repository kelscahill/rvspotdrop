<?php
require_once("../../../wp-load.php");
global $wpdb;
/**
 * REST API Brands controller
 *
 * Handles requests to the /brands endpoint.
 *
 * @package  WooCommerce/API
 * @since    2.6.0
 */
$charset_collate = $wpdb->get_charset_collate();
  
  $wpdb->query( "DROP TABLE IF EXISTS `{$wpdb->base_prefix}campground`" );
  $sql = "CREATE TABLE `{$wpdb->base_prefix}campground` (
  id INT(11) NOT NULL AUTO_INCREMENT ,
  user_id VARCHAR(20) NOT NULL,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  campLocation VARCHAR(20) NOT NULL,
  preferredLocation TEXT NOT NULL,
  serviceRequirements VARCHAR(20) NOT NULL,
  rigLength VARCHAR(20) NOT NULL,
  rigType VARCHAR(20) NOT NULL,
  yearOfRig VARCHAR(20) NOT NULL,
  petFriendly VARCHAR(20) NOT NULL,
  adultOnly VARCHAR(10) NOT NULL,
  createDate DATETIME NOT NULL,
  PRIMARY KEY (id))";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

