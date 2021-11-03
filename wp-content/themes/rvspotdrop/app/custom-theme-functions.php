<?php
/**
 *
 * @file
 * Register custom theme functions.
 *
 * @package WordPress
 */

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
 * Add excerpt to pages.
 */
add_post_type_support( 'page', 'excerpt' );

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
 * Send an email when a user updates their profile.
 */
// function user_profile_update( $user_id ) {
//   $site_url = get_bloginfo('wpurl');
//   $user_info = get_userdata( $user_id );
//   $to = 'hello@rvspotdrop.com';
//   $subject = $user_info->display_name . " updated their " . implode(', ', $user_info->roles) . " profile on RVSpotDrop";
//   $message = $user_info->display_name . " (" . $user_info->user_email . ") has updated their " . implode(', ', $user_info->roles) . " profile on " . $site_url . ". You can review their profile <a href='" . $site_url . "/wp-admin/user-edit.php?user_id=" . $user_id . "'>here</a>.";
//   wp_mail( $to, $subject, $message);
// }
// add_action( 'profile_update', 'user_profile_update', 10, 2);


/**
 * Custom shortcode to display WPForms form entries in table view.
 *
 * Basic usage: [wpforms_entries_table id="FORMID"].
 *
 * Possible shortcode attributes:
 * id (required)  Form ID of which to show entries.
 * user           User ID, or "current" to default to current logged in user.
 * fields         Comma separated list of form field IDs.
 * number         Number of entries to show, defaults to 30.
 *
 * @link https://wpforms.com/developers/how-to-display-form-entries/
 *
 * Realtime counts could be delayed due to any caching setup on the site
 *
 * @param array $atts Shortcode attributes.
 *
 * @return string
 */
add_shortcode('wpforms_entries_table', 'wpf_entries_table');
function wpf_entries_table($atts) {
  // Pull ID shortcode attributes.
  $atts = shortcode_atts([
    'id' => '',
    'user' => '',
    'fields' => '',
    'number' => '',
    'type' => 'all' // all, unread, read, or starred.
   ], $atts);
  // Check for an ID attribute (required) and that WPForms is in fact
  // installed and activated.
  if (empty($atts['id']) || !function_exists('wpforms')) {
    return;
  }
  // Get the form, from the ID provided in the shortcode.
  $form = wpforms()->form->get(absint($atts['id']));
  // If the form doesn't exists, abort.
  if (empty($form)) {
    return;
  }
  // Pull and format the form data out of the form object.
  $form_data = !empty($form->post_content) ? wpforms_decode($form->post_content) : '';
  // Check to see if we are showing all allowed fields, or only specific ones.
  $form_field_ids = isset($atts['fields']) && $atts['fields'] !== '' ? explode(',', str_replace(' ', '', $atts['fields'])) : [];
  // Setup the form fields.
  if (empty($form_field_ids)) {
    $form_fields = $form_data['fields'];
  } else {
    $form_fields = [];
    foreach($form_field_ids as $field_id) {
      if (isset($form_data['fields'][$field_id])) {
        $form_fields[$field_id] = $form_data['fields'][$field_id];
      }
    }
  }
  if (empty($form_fields)) {
    return;
  }
  // Here we define what the types of form fields we do NOT want to include,
  // instead they should be ignored entirely.
  $form_fields_disallow = apply_filters('wpforms_frontend_entries_table_disallow', ['divider', 'html', 'pagebreak', 'captcha']);
  // Loop through all form fields and remove any field types not allowed.
  foreach($form_fields as $field_id => $form_field) {
    if (in_array($form_field['type'], $form_fields_disallow, true)) {
      unset($form_fields[$field_id]);
    }
  }
  $entries_args = ['form_id' => absint($atts['id']), ];
  // Narrow entries by user if user_id shortcode attribute was used.
  if (!empty($atts['user'])) {
    if ($atts['user'] === 'current' && is_user_logged_in()) {
      $entries_args['user_id'] = get_current_user_id();
    } else {
      $entries_args['user_id'] = absint($atts['user']);
    }
  }
  // Number of entries to show. If empty, defaults to 30.
  if (!empty($atts['number'])) {
    $entries_args['number'] = absint($atts['number']);
  }
  // Get all entries for the form, according to arguments defined.
  // There are many options available to query entries. To see more, check out
  // the get_entries() function inside class-entry.php (https://a.cl.ly/bLuGnkGx).
  $entries = wpforms()->entry->get_entries($entries_args);
  if (empty($entries)) {
    return '<p>No entries found.</p>';
  }

  ob_start();
  echo '<table class="o-table--responsive">';
  echo '<thead><tr>';
  // Loop through the form data so we can output form field names in
  // the table header.
  foreach($form_fields as $form_field) {
    // Output the form field name/label.
    echo '<th>';
    echo esc_html(sanitize_text_field($form_field['label']));
    echo '</th>';
  }
  echo '</tr></thead>';
  echo '<tbody>';
  // Now, loop through all the form entries.
  foreach($entries as $index => $entry) {
    echo '<tr>';
    // Entry field values are in JSON, so we need to decode.
    $entry_fields = json_decode($entry->fields, true);
    $entry_date = date("F j, Y",strtotime($entry->date));
    foreach($form_fields as $key => $form_field) {
      if ($key === array_key_first($form_fields)) {
        echo '<td data-label="Entry" class="js-toggle-parent">'.$entry_date.'</td>';
        echo '<td data-label="'.esc_html(sanitize_text_field($form_field['label'])).'">';
      } else {
        echo '<td data-label="'.esc_html(sanitize_text_field($form_field['label'])).'">';
      }
      foreach($entry_fields as $entry_field) {
        if (absint($entry_field['id']) === absint($form_field['id'])) {
          echo apply_filters('wpforms_html_field_value', wp_strip_all_tags($entry_field['value']), $entry_field, $form_data, 'entry-frontend-table');
          break;
        }
      }
      echo '</td>';
    }
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
  $output = ob_get_clean();
  return $output;
}

/**
 * Updated user post meta on form submit.
 */
add_action( 'template_redirect', 'update_user_profile' );
function update_user_profile() {
  global $current_user;
  if (isset($_POST['first_name'])) {
    update_user_meta( $current_user->ID, 'first_name', $_POST['first_name']);
  }
  if (isset($_POST['last_name'])) {
    update_user_meta( $current_user->ID, 'last_name', $_POST['last_name']);
  }
  if (isset($_POST['user_email'])) {
    update_user_meta( $current_user->ID, 'user_email', $_POST['user_email']);
  }
  if (isset($_POST['phone'])) {
    update_user_meta( $current_user->ID, 'phone', $_POST['phone']);
  }
  if (isset($_POST['gender'])) {
    update_user_meta( $current_user->ID, 'gender', $_POST['gender']);
  }
  if (isset($_POST['birthday'])) {
    update_user_meta( $current_user->ID, 'birthday', $_POST['birthday']);
  }
  if (isset($_POST['equipment_type'])) {
    update_user_meta( $current_user->ID, 'equipment_type', $_POST['equipment_type']);
  }
  if (isset($_POST['equipment_year'])) {
    update_user_meta( $current_user->ID, 'equipment_year', $_POST['equipment_year']);
  }
  if (isset($_POST['equipment_length'])) {
    update_user_meta( $current_user->ID, 'equipment_length', $_POST['equipment_length']);
  }
  if (isset($_POST['rv_slide_outs'])) {
    update_user_meta( $current_user->ID, 'rv_slide_outs', $_POST['rv_slide_outs']);
  }
  if (isset($_POST['service_requirements'])) {
    update_user_meta( $current_user->ID, 'service_requirements', $_POST['service_requirements']);
  }
  if (isset($_POST['important_features'])) {
    update_user_meta( $current_user->ID, 'important_features', $_POST['important_features']);
  }
  // Partner Signup Fields
  if (isset($_POST['position_title'])) {
    update_user_meta( $current_user->ID, 'position_title', $_POST['position_title']);
  }
  if (isset($_POST['rv_park_name'])) {
    update_user_meta( $current_user->ID, 'rv_park_name', $_POST['rv_park_name']);
  }
  if (isset($_POST['rv_park_address'])) {
    update_user_meta( $current_user->ID, 'rv_park_address', $_POST['rv_park_address']);
  }
  if (isset($_POST['rv_park_website'])) {
    update_user_meta( $current_user->ID, 'rv_park_website', $_POST['rv_park_website']);
  }
  if (isset($_POST['rv_park_facebook_url'])) {
    update_user_meta( $current_user->ID, 'rv_park_facebook_url', $_POST['rv_park_facebook_url']);
  }
  if (isset($_POST['rv_park_instagram_handle'])) {
    update_user_meta( $current_user->ID, 'rv_park_instagram_handle', $_POST['rv_park_instagram_handle']);
  }
  if (isset($_POST['rv_park_description'])) {
    update_user_meta( $current_user->ID, 'rv_park_description', $_POST['rv_park_description']);
  }
  if (isset($_POST['long_term_stays'])) {
    update_user_meta( $current_user->ID, 'long_term_stays', $_POST['long_term_stays']);
  }
  if (isset($_POST['nightly_rate'])) {
    update_user_meta( $current_user->ID, 'nightly_rate', $_POST['nightly_rate']);
  }
  if (isset($_POST['direct_booking_link'])) {
    update_user_meta( $current_user->ID, 'direct_booking_link', $_POST['direct_booking_link']);
  }
  if (isset($_POST['available_services'])) {
    update_user_meta( $current_user->ID, 'available_services', $_POST['available_services']);
  }
  if (isset($_POST['rig_types_welcome'])) {
    update_user_meta( $current_user->ID, 'rig_types_welcome', $_POST['rig_types_welcome']);
  }
  if (isset($_POST['rig_age_limit'])) {
    update_user_meta( $current_user->ID, 'rig_age_limit', $_POST['rig_age_limit']);
  }
  if (isset($_POST['age_limit'])) {
    update_user_meta( $current_user->ID, 'age_limit', $_POST['age_limit']);
  }
  if (isset($_POST['maximum_rig_length'])) {
    update_user_meta( $current_user->ID, 'maximum_rig_length', $_POST['maximum_rig_length']);
  }
  if (isset($_POST['park_features'])) {
    update_user_meta( $current_user->ID, 'park_features', $_POST['park_features']);
  }
  if (isset($_POST['other_park_features'])) {
    update_user_meta( $current_user->ID, 'other_park_features', $_POST['other_park_features']);
  }
  if (isset($_POST['rv_spot_type'])) {
    update_user_meta( $current_user->ID, 'rv_spot_type', $_POST['rv_spot_type']);
  }
  if (isset($_POST['rv_full_time_spots'])) {
    update_user_meta( $current_user->ID, 'rv_full_time_spots', $_POST['rv_full_time_spots']);
  }
  if (isset($_POST['rv_park_pet_friendly'])) {
    update_user_meta( $current_user->ID, 'rv_park_pet_friendly', $_POST['rv_park_pet_friendly']);
  }
  if (isset($_POST['rv_park_pet_restrictions'])) {
    update_user_meta( $current_user->ID, 'rv_park_pet_restrictions', $_POST['rv_park_pet_restrictions']);
  }
  if (isset($_POST['rv_park_pet_restriction_details'])) {
    update_user_meta( $current_user->ID, 'rv_park_pet_restriction_details', $_POST['rv_park_pet_restriction_details']);
  }
  if (isset($_POST['rv_park_family_friendly'])) {
    update_user_meta( $current_user->ID, 'rv_park_family_friendly', $_POST['rv_park_family_friendly']);
  }
  if (isset($_POST['guest_age_restrictions'])) {
    update_user_meta( $current_user->ID, 'guest_age_restrictions', $_POST['guest_age_restrictions']);
  }
  if (isset($_POST['age_restrictions'])) {
    update_user_meta( $current_user->ID, 'age_restrictions', $_POST['age_restrictions']);
  }
  if (isset($_POST['other_details'])) {
    update_user_meta( $current_user->ID, 'other_details', $_POST['other_details']);
  }
}

/**
 * Redirect wp-login.php to Login page.
 */
add_action('init', 'prevent_wp_login');
function prevent_wp_login() {
  global $pagenow;
  $action = (isset($_GET['action'])) ? $_GET['action'] : '';
  if ( $pagenow == 'wp-login.php' && ( ! $action || ( $action && ! in_array($action, array('logout', 'lostpassword', 'rp', 'resetpass'))))) {
    $page = '/login';
    wp_redirect($page);
    exit();
  }
}

/**
 * Display table of payment transaction details from Authorize.net/Stripe/PayPal shortcode.
 *
 * @link https://wpforms.com/developers/how-to-display-table-of-payment-transaction-details/
 *
 */
function wpf_dev_transactions_table( $atts ) {
  $atts = shortcode_atts( array(
    'fields' => false,
    'id'     => '',
  ), $atts, 'wpf_transactions' );
  if (
    ! is_super_admin() ||
    empty( $atts['id'] )
  ) {
    return;
  }
  $form_data = wpforms()->form->get(
    $atts['id'],
    array( 'content_only' => true )
  );
  $payments = wpforms_has_payment( 'form', $form_data );
  if ( ! $payments ) {
    return;
  }
  $entries = wpforms()->entry->get_entries(
    array(
      'form_id' => $atts['id'],
    )
  );
  if ( empty( $entries ) ) {
    return;
  }
  if ( $atts['fields'] ) {
    $ids = explode( ',', $atts['fields'] );
  } else {
    $ids = false;
  }
  ob_start();
  echo '<table width="100%" style="font-size:11px !important;">';
  foreach ( $entries as $entry ) {
    if ( 'payment' !== $entry->type ) {
      continue;
    }
    $fields = json_decode( $entry->fields, true );
    $meta   = json_decode( $entry->meta, true );
    echo '<tr>';
      if ( ! empty( $ids ) ) {
        foreach ( $ids as $id ) {
          echo '<td>' . sanitize_text_field( $fields[ $id] [ 'value' ] ) . '</td>';
        }
      }
      echo '<td><a href="' . admin_url( 'admin.php?page=wpforms-entries&view=details&entry_id=' . $entry->entry_id ) . '">' . sanitize_text_field( $meta['payment_total'] ) . '</a></td>';
      echo '<td>' . sanitize_text_field( ucfirst( $entry->status ) ) . '</td>';
      echo '<td>' . sanitize_text_field( $meta['payment_transaction'] ) . '</td>';
      if ( 'stripe' === $meta['payment_type'] ) {
        echo '<td>Stripe</td>';
      } elseif ( 'paypal_standard' === $meta['payment_type'] ) {
        echo '<td>PayPal</td>';
      } elseif ( 'authorize_net' === $meta['payment_type'] ) {
        echo '<td>Authorize.net</td>';
      }
      echo '<td>' . sanitize_text_field( $entry->date ) . '</td>';
    echo '</tr>';
  }
  echo '</table>';
  return ob_get_clean();
}
add_shortcode( 'wpforms_transactions', 'wpf_dev_transactions_table' );
