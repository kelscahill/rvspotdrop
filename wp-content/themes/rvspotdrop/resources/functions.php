<?php
/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
  $title = $title ?: __('Sage &rsaquo; Error', 'sage');
  $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
  $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
  wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7', phpversion(), '>=')) {
  $sage_error(__('You must be using PHP 7 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('5.0.0', get_bloginfo('version'), '>=')) {
  $sage_error(__('You must be using WordPress 5.0.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
  if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
    $sage_error(
      __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
      __('Autoloader not found.', 'sage')
    );
  }
  require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
  $file = "../app/{$file}.php";
  if (!locate_template($file, true, true)) {
      $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
  }
}, ['helpers', 'setup', 'filters', 'admin', 'timber']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
  'add_filter',
  ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
  array_fill(0, 4, 'dirname')
);
Container::getInstance()
  ->bindIf('config', function () {
    return new Config([
      'assets' => require dirname(__DIR__).'/config/assets.php',
      'theme' => require dirname(__DIR__).'/config/theme.php',
      'view' => require dirname(__DIR__).'/config/view.php',
    ]);
  }, true);

/**
 * Allow SVG's through WP media uploader
 */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
}

/**
 * ACF Save json files
 */
function my_acf_json_save_point($path) {
  $path = get_stylesheet_directory() . '/acf-json';
  return $path;
}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

/**
 * Register custom block types.
 */
function register_custom_block_types() {
  if ( function_exists( 'acf_register_block_type' ) ) {
    // Register a banner block.
    acf_register_block_type(
      array(
        'name'            => 'banner',
        'title'           => 'Banner',
        'description'     => 'A custom banner block.',
        'category'        => 'custom',
        'icon'            => 'id',
        'keywords'        => array( 'banner', 'section' ),
        'render_template' => 'blocks/banner.php',
        'mode'            => 'edit',
        'supports'        => array(
          'mode' => false,
        ),
      )
    );
    // Register a hero block.
    acf_register_block_type(
      array(
        'name'            => 'hero',
        'title'           => 'Hero',
        'description'     => 'A custom hero block.',
        'category'        => 'custom',
        'icon'            => 'schedule',
        'keywords'        => array( 'hero', 'banner'),
        'render_template' => 'blocks/hero.php',
        'mode'            => 'edit',
        'supports'        => array(
          'mode' => false,
        ),
      )
    );
    // Register a cards block.
    acf_register_block_type(
      array(
        'name'            => 'cards',
        'title'           => 'Cards',
        'description'     => 'A custom cards block.',
        'category'        => 'custom',
        'icon'            => 'screenoptions',
        'keywords'        => array( 'cards', 'blocks'),
        'render_template' => 'blocks/cards.php',
        'mode'            => 'edit',
        'supports'        => array(
          'mode' => false,
        ),
      )
    );
  }
}
add_action( 'init', 'register_custom_block_types' );

/*
 * Restrict non logged users to certain pages.
 */
add_action('template_redirect','my_non_logged_redirect');
function my_non_logged_redirect() {
  if ((is_page('campground-request') || is_page('campground-availability') ) && !is_user_logged_in() ) {
    wp_redirect( home_url() );
    die();
  }
}

/*
 * Remove fields from user profiles.
 */
function filter_user_contact_methods( $methods ) {
  // To remove a method
  unset( $methods['myspace'] );
  unset( $methods['linkedin'] );
  unset( $methods['soundcloud'] );
  unset( $methods['pinterest'] );
  unset( $methods['tumblr'] );
  unset( $methods['youtube'] );
  unset( $methods['wikipedia'] );
  unset( $methods['twitter'] );
  unset( $methods['facebook'] );
  unset( $methods['instagram'] );
  unset( $methods['website'] );

  return $methods;
}
add_filter( 'user_contactmethods', 'filter_user_contact_methods' );

/**
 * Modify WPForms Date/Time field date picker to accept a range of dates.
 *
 * @link https://wpforms.com/developers/allow-date-range-or-multiple-dates-in-date-picker/
 *
 */
function wpf_dev_date_picker_range() {
  ?>
    <script type="text/javascript">
      window.wpforms_datepicker = {
        mode: "range"
      }
    </script>
  <?php
}
add_action( 'wpforms_wp_footer', 'wpf_dev_date_picker_range' );

/**
 * Turn checkbox values into an array.
 *
 * @link https://wpforms.com/developers/how-to-store-checkbox-values-as-arrays-with-post-submissions/
 *
 */

function wpforms_dev_user_registration_process_meta( $field_value, $meta_key, $field_id, $fields, $form_data ) {
  // Turn checkbox value into an array
  $keys = array(
    'preferred_camping_locations_canada',
    'preferred_camping_locations_usa',
    'available_services',
    'rig_types_welcome',
    'park_features',
    'rv_spot_type',
    'age_restrictions',
    'nightly_rate',
    'service_requirements',
    'rv_slide_outs',
    'important_features',
    'campground_features',
    'locations_of_interest'
  );

  foreach ( $keys as $key ) {
    if ( $meta_key === $key ) {
      $field_value = explode( "\n", $field_value );
    }
  }

  return $field_value;
}
add_filter( 'wpforms_user_registration_process_meta', 'wpforms_dev_user_registration_process_meta', 10, 5 );

/**
 * Filters form notification email footer content.
 *
 * @link https://wpforms.com/developers/how-to-remove-or-change-email-notification-footer-text/
 *
 * @param  array $footer
 * @return string
 */
function wpf_dev_email_footer_text( $footer ) {
    $footer = sprintf( __( '<div style="background-color: #f33f4b; color: #fcfcfc; padding: 20px; margin-left: -19px; margin-right: -19px; margin-top: -21px;">
      <div style="display: inline-flex; align-items: center; justify-content: center;">
        <a style="padding: 10px;" target="_blank" href="https://www.facebook.com/rvspotdrop"><img alt="Facebook" border="0" hspace="0" vspace="0" style="vertical-align:top;" target="_blank" src="https://img.mailinblue.com/new_images/rnb/theme4/rnb_ico_fb.png"></a>
        <a style="padding: 10px;" target="_blank" href="https://www.instagram.com/rvspotdrop"><img alt="Instagram" border="0" hspace="0" vspace="0" style="vertical-align:top;" target="_blank" src="https://img.mailinblue.com/new_images/rnb/theme4/rnb_ico_ig.png"></a>
      </div>
      <div style="display: block; text-align: center; padding-top: 10px;">
        <p style="color: #fcfcfc;"><a href="https://rvspotdrop.com" style="color: #fcfcfc; text-decoration: none;"><strong>RVSpotDrop</strong></a> | 18036 96 AVE, Edmonton, AB</p>
        <p style="color: #fcfcfc;"><a href="mailto:hello@rvspotdrop.com" style="color: #fcfcfc;">hello@rvspotdrop.com</a></p>
        <p style="color: #fcfcfc;">You\'ve received this email because you submitted a form on <a href="https://rvspotdrop.com" style="color: #fcfcfc;">rvspotdrop.com</a></p>
      </div>
    </div>', 'wpforms' ), esc_url( home_url() ), wp_specialchars_decode( get_bloginfo( 'name' ) ) );
    return $footer;
}
add_filter( 'wpforms_email_footer_text', 'wpf_dev_email_footer_text' );

function only_allow_5($valid, $value, $field, $input) {
  if (count($value) > 5) {
    $valid = 'Only Select 5';
  }
  return $valid;
}
add_filter('acf/validate_value/name=locations_of_interest', 'only_allow_5', 20, 4);

/**
 * Limit the number of form entries per month for form_id 836.
 */
add_action( 'wpforms_frontend_output', function ( $form_data ) {
  // Only display on form 836.
  if ( absint( $form_data['id'] ) !== 836 ) {
    return;
  }

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
  $result = absint( 2 - $entries_count );

  // Display results container.
  if ($result == 0) {
    echo '<div class="o-limit-reached">Sorry, you\'ve hit the maximum number of 2 requests for the month. You will be able to submit 2 more requests next month. Please check back on the 1st! If you have any questions, please reach out to <a href="mailto:hello@rvspotdrop.com">hello@rvspotdrop.com</a>.</div>';
  } elseif ($result == 1) {
    echo '<em>You have ' . esc_html( $result ) . ' request left for the month of '.date('F', strtotime('this month')).'.</em>';
  } else {
    echo '<em>You have ' . esc_html( $result ) . ' requests left for the month of '.date('F', strtotime('this month')).'.</em>';
  }
}, 7 );
