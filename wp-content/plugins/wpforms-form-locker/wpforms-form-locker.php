<?php
/**
 * Plugin Name:       WPForms Form Locker
 * Plugin URI:        https://wpforms.com
 * Description:       Create Form Locker with WPForms.
 * Requires at least: 4.9
 * Requires PHP:      5.5
 * Author:            WPForms
 * Author URI:        https://wpforms.com
 * Version:           2.0.2
 * Text Domain:       wpforms-form-locker
 * Domain Path:       languages
 *
 * WPForms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WPForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WPForms. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check addon requirements.
 *
 * @since 2.0.0
 */
function wpforms_form_locker_required() {

	// Load translated strings.
	load_plugin_textdomain( 'wpforms-form-locker', false, \dirname( \plugin_basename( WPFORMS_FORM_LOCKER_FILE ) ) . '/languages/' );

	/**
	 * Require PHP 5.5+.
	 */
	if ( version_compare( PHP_VERSION, '5.5', '<' ) ) {

		add_action( 'admin_init', 'wpforms_form_locker_deactivate' );
		add_action( 'admin_notices', 'wpforms_form_locker_deactivate_msg' );
	} elseif (
		// WPForms Pro is required.
		! function_exists( 'wpforms' ) ||
		! wpforms()->pro ||
		version_compare( wpforms()->version, '1.6.8', '<' )
	) {
		add_action( 'admin_init', 'wpforms_form_locker_deactivate' );
		add_action( 'admin_notices', 'wpforms_form_locker_fail_wpforms_version' );
	} else {
		wpforms_form_locker();
	}
}
add_action( 'wpforms_loaded', 'wpforms_form_locker_required' );

/**
 * Deactivate plugin.
 *
 * @since 1.0.0
 */
function wpforms_form_locker_deactivate() {

	deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * Display notice after deactivation.
 *
 * @since 1.0.0
 */
function wpforms_form_locker_deactivate_msg() {

	echo '<div class="notice notice-error"><p>';
	printf(
		wp_kses( /* translators: %s - WPForms.com documentation page URL. */
			__( 'The WPForms Form Locker plugin has been deactivated. Your site is running an outdated version of PHP that is no longer supported and is not compatible with the Form Locker addon. <a href="%s" target="_blank" rel="noopener noreferrer">Read more</a> for additional information.', 'wpforms-form-locker' ),
			[
				'a' => [
					'href'   => [],
					'rel'    => [],
					'target' => [],
				],
			]
		),
		'https://wpforms.com/docs/supported-php-version/'
	);
	echo '</p></div>';

	if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification
	}
}

/**
 * Admin notice for minimum WPForms version.
 *
 * @since 2.0.0
 */
function wpforms_form_locker_fail_wpforms_version() {

	echo '<div class="notice notice-error"><p>';
	esc_html_e( 'The WPForms Form Locker plugin has been deactivated, because it requires WPForms v1.6.8 or later to work.', 'wpforms-form-locker' );
	echo '</p></div>';

	// phpcs:disable
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
	// phpcs:enable

}

// Plugin constants.
define( 'WPFORMS_FORM_LOCKER_VERSION', '2.0.2' );
define( 'WPFORMS_FORM_LOCKER_FILE', __FILE__ );

/**
 * Get the instance of the plugin main class,
 * which actually loads all the code.
 *
 * @since 1.0.0
 *
 * @return \WPFormsLocker\Loader
 */
function wpforms_form_locker() {

	require_once __DIR__ . '/vendor/autoload.php';

	return \WPFormsLocker\Loader::get_instance();
}
