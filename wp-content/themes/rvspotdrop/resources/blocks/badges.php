<?php
/**
 * The template for displaying cards blocks
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package    WordPress
 * @subpackage Timber
 * @since      Timber 0.1
 */

$context = Timber::context();
$context['badges']['heading'] = get_field( 'badges_heading' );
$context['badges']['description'] = get_field( 'badges_description' );
$context['badges']['items'] = get_field( 'badges' );

$templates = array(
	'views/_patterns/03-organisms/sections/section-badges.twig',
);
Timber::render( $templates, $context );