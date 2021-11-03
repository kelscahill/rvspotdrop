<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

/* Template Name: Dashboard Template */
$context = Timber::get_context();
$post = new TimberPost();
$context['user_logged_in'] = is_user_logged_in();
$context['post'] = $post;
$context['posts'] = false;

// Set the default timezone.
date_default_timezone_set("America/Edmonton");
$this_month = date('Y-m-d H:i:s', strtotime('this month'));
$entries_count = wpforms()->entry->get_entries(
  array(
    'form_id' => '836',
    'user_id' => get_current_user_id(),
    'date' => $this_month
  ), true
);
$context['campground_request_entries'] = absint( 2 - $entries_count );

Timber::render(array(
  '05-pages/template-dashboard.twig'
), $context);