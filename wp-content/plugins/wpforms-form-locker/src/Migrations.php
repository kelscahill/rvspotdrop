<?php

namespace WPFormsLocker;

/**
 * Class Migrations.
 *
 * @since 2.0.0
 */
class Migrations {

	/**
	 * WP option name to store the migration version.
	 *
	 * @since 2.0.0
	 */
	const OPTION_NAME = 'wpforms_form_locker_version';

	/**
	 * Have we migrated?
	 *
	 * @since 2.0.0
	 *
	 * @var bool
	 */
	private $is_migrated = false;

	/**
	 * Class init.
	 *
	 * @since 2.0.0
	 */
	public function init() {

		$this->maybe_migrate();
		$this->update_version();
	}

	/**
	 * Run the migration if needed.
	 *
	 * @since 2.0.0
	 */
	public function maybe_migrate() {

		// Retrieve the last known version.
		$version = get_option( self::OPTION_NAME );

		if ( empty( $version ) ) {
			$version = '1.0.0';
		}

		$this->migrate( $version );
	}

	/**
	 * Run the migrations for a specific version.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version Version to run the migrations for.
	 */
	private function migrate( $version ) {

		if ( version_compare( $version, '1.3', '<' ) ) {
			$this->v13_upgrade();
		}
	}

	/**
	 * If upgrade has occurred, update version options in database.
	 *
	 * @since 2.0.0
	 */
	public function update_version() {

		if ( ! $this->is_migrated ) {
			return;
		}

		update_option( self::OPTION_NAME, WPFORMS_FORM_LOCKER_VERSION );
	}

	/**
	 * Do all the required migrations for WPForms Form Locker v1.3.
	 *
	 * @since 2.0.0
	 */
	private function v13_upgrade() {

		if ( ! wpforms_form_locker()->email_storage->table_exists() ) {
			wpforms_form_locker()->email_storage->create_table();
		}

		// Update Password locker old options.
		$this->password_option_upgrade();

		$this->is_migrated = true;
	}

	/**
	 * Migrate Password locker option.
	 *
	 * @since 2.0.0
	 */
	private function password_option_upgrade() {

		$forms = wpforms()->form->get( '', [ 'cap' => false ] );

		if ( empty( $forms ) ) {
			return;
		}

		$password = [
			'form_locker_verification'      => 1,
			'form_locker_verification_type' => 'password',
			'form_locker_password_enable'   => '',
		];

		foreach ( $forms as $form ) {
			$form_data = wpforms_decode( $form->post_content );

			if ( empty( $form_data['settings']['form_locker_password_enable'] ) ) {
				continue;
			}

			$form_data['settings'] = array_replace_recursive( $form_data['settings'], $password );
			wpforms()->form->update( $form->ID, $form_data, [ 'cap' => false ] );
		}
	}
}
