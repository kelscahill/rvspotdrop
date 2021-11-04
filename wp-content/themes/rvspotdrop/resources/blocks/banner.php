<?php
/**
 * The template for displaying banner blocks
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package    WordPress
 * @subpackage Timber
 * @since      Timber 0.1
 */

$context = Timber::context();
$context['banner']['kicker'] = get_field( 'banner_kicker' );
$context['banner']['heading'] = get_field( 'banner_heading' );
$context['banner']['description'] = get_field( 'banner_description' );
$context['banner']['button'] = get_field( 'banner_button' );
$context['banner']['image'] = get_field( 'banner_image' );
$context['banner']['anchor'] = get_field( 'banner_html_anchor' );

$templates = array(
	'views/_patterns/03-organisms/sections/section-banner.twig',
);
Timber::render( $templates, $context );
