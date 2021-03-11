<?php
/**
 * The template for displaying hero blocks
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package    WordPress
 * @subpackage Timber
 * @since      Timber 0.1
 */

$context = Timber::context();
$context['hero']['heading'] = get_field( 'hero_heading' );
$context['hero']['description'] = get_field( 'hero_description' );
$context['hero']['button'] = get_field( 'hero_button' );
$context['hero']['image'] = get_field( 'hero_image' );

$templates = array(
  'views/_patterns/03-organisms/sections/section-hero.twig',
);
Timber::render( $templates, $context );
