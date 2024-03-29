<?php

namespace WPFormsLocker\Lockers;

use WPForms\Helpers\Transient;

/**
 * Lock a form if a new entry exceeds an admin-defined user entry limit by IP or email.
 *
 * @since 2.0.0
 */
class UserEntryLimit {

	/**
	 * Current form information.
	 *
	 * @var array $form_data
	 *
	 * @since 1.0.0
	 */
	public $form_data;

	/**
	 * Init.
	 *
	 * @since 2.0.0
	 */
	public function init() {

		$this->hooks();
	}

	/**
	 * Locker hooks.
	 *
	 * @since 2.0.0
	 */
	public function hooks() {

		add_filter( 'wpforms_frontend_load', [ $this, 'display_form' ], 10, 2 );
		add_filter( 'wpforms_process_initial_errors', [ $this, 'submit_form' ], 10, 2 );
	}

	/**
	 * Set current form information for internal use.
	 *
	 * @since 2.0.0
	 *
	 * @param array $form_data Form information.
	 */
	protected function set_form_data( $form_data ) {

		$this->form_data = $form_data;
	}

	/**
	 * On form submit actions.
	 *
	 * @since 2.0.0
	 *
	 * @param array $errors    Form submit errors.
	 * @param array $form_data Form information.
	 *
	 * @return array
	 */
	public function submit_form( $errors, $form_data ) {

		$this->set_form_data( $form_data );

		if ( $this->is_locked( true ) ) {
			$form_id = ! empty( $this->form_data['id'] ) ? $this->form_data['id'] : 0;

			$errors[ $form_id ]['form_locker'] = 'user_entry_limit';
			$errors[ $form_id ]['header']      = $this->get_locked_message();
		}

		return $errors;
	}

	/**
	 * On form display actions.
	 *
	 * @since 2.0.0
	 *
	 * @param bool  $load_form Indicates whether a form should be loaded.
	 * @param array $form_data Form information.
	 *
	 * @return bool
	 */
	public function display_form( $load_form, $form_data ) {

		$this->set_form_data( $form_data );

		if ( ! $this->is_locked() ) {
			return $load_form;
		}

		add_action( 'wpforms_frontend_not_loaded', [ $this, 'locked_html' ], 10, 2 );

		return false;
	}

	/**
	 * Locked form HTML.
	 *
	 * @since 2.0.0
	 */
	public function locked_html() {

		$message = $this->get_locked_message();

		if ( $message ) {
			printf( '<div class="form-locked-message">%s</div>', wp_kses_post( wpautop( $message ) ) );
		}
	}

	/**
	 * Check if the form has a locker configured.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	protected function has_locker() {

		if ( empty( $this->form_data['settings']['form_locker_user_entry_limit_enable'] ) ) {
			return false;
		}

		if (
			empty( $this->form_data['settings']['form_locker_user_entry_restrict_by_email'] ) &&
			empty( $this->form_data['settings']['form_locker_user_entry_restrict_by_ip'] )
		) {
			return false;
		}

		return true;
	}

	/**
	 * Fixed entry limit.
	 *
	 * @since 2.0.2
	 *
	 * @return int
	 */
	private function get_total_entries_limit() {

		return ! empty( $this->form_data['settings']['form_locker_user_entry_limit_enable'] ) ? (int) $this->form_data['settings']['form_locker_user_entry_limit'] : 0;
	}

	/**
	 * Check if form is locked by entries count.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $check_all Should we check by Email and IP address.
	 *
	 * @return bool
	 */
	private function is_locked( $check_all = false ) {

		if ( ! $this->has_locker() ) {
			return false;
		}

		$total_user_entries_limit = $this->get_total_entries_limit();
		$ip_entries               = 0;
		$email_entries            = 0;

		if ( wpforms_is_collecting_ip_allowed() && ! empty( $this->form_data['settings']['form_locker_user_entry_restrict_by_ip'] ) ) {
			$ip_entries = $this->get_total_by_ip();

			if ( count( $ip_entries ) >= $total_user_entries_limit ) {
				return true;
			}
		}

		if ( $check_all && ! empty( $this->form_data['settings']['form_locker_user_entry_restrict_by_email'] ) ) {
			$email_entries = $this->get_total_by_email();

			if ( count( $email_entries ) >= $total_user_entries_limit ) {
				return true;
			}
		}

		// Limit by IP and Email is the same time.
		if ( is_array( $ip_entries ) && is_array( $email_entries ) ) {
			$total_user_entries = array_merge( $ip_entries, $email_entries );
			$total_user_entries = array_unique( array_filter( $total_user_entries ) );

			if ( count( $total_user_entries ) >= $total_user_entries_limit ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get entries filtered by given email.
	 *
	 * @since 2.0.2
	 *
	 * @return array
	 */
	private function get_total_by_email() {

		global $wpdb;

		$table_name = wpforms()->entry_fields->table_name;
		$field_id   = ! empty( $this->form_data['settings']['form_locker_user_entry_email_field'] ) ? $this->form_data['settings']['form_locker_user_entry_email_field'] : 0;
		$email      = ! empty( $_POST['wpforms']['fields'][ $this->form_data['settings']['form_locker_user_entry_email_field'] ] ) ? sanitize_email( wp_unslash( $_POST['wpforms']['fields'][ $this->form_data['settings']['form_locker_user_entry_email_field'] ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

		$select = "SELECT entry_id FROM {$table_name}";

		$where[] = $wpdb->prepare( 'AND form_id = %d', $this->form_data['id'] );
		$where[] = $wpdb->prepare( 'AND field_id = %s', $field_id );
		$where[] = $wpdb->prepare( 'AND value = %s', $email );

		return $this->get_query_results( $select, $where );
	}

	/**
	 * Get entries where IP is the same as current.
	 *
	 * @since 2.0.2
	 *
	 * @return array
	 */
	private function get_total_by_ip() {

		if ( ! wpforms_is_collecting_ip_allowed( $this->form_data ) ) {
			return [];
		}

		global $wpdb;

		$table_name = wpforms()->entry->table_name;
		$ip_address = wpforms_get_ip();

		$select = "SELECT entry_id FROM {$table_name}";

		// Use only complete entries.
		$where[] = $wpdb->prepare( 'AND form_id = %d AND status = ""', $this->form_data['id'] );
		$where[] = $wpdb->prepare( 'AND ip_address = %s', $ip_address );

		return $this->get_query_results( $select, $where );
	}

	/**
	 * Combine the query and the where clauses, and make the request.
	 *
	 * @since 2.0.2
	 *
	 * @param string $select Initial version of the SQL query - its SELECT part.
	 * @param array  $where  Variable part, different for IP and Email checks.
	 *
	 * @return array
	 */
	private function get_query_results( $select, $where ) {

		global $wpdb;

		if ( ! empty( $this->form_data['settings']['form_locker_user_entry_email_duration'] ) ) {
			$where[] = 'AND date > (NOW() - INTERVAL 1 ' . sanitize_key( $this->form_data['settings']['form_locker_user_entry_email_duration'] ) . ')';
		}

		if ( ! empty( $where ) ) {
			$select .= ' WHERE 1=1 ' . implode( ' ', $where );
		}

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.DirectDatabaseQuery.NoCaching
		return $wpdb->get_col( $select );
	}

	/**
	 * Get user entry locked form message from an admin area.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	private function get_locked_message() {

		return ! empty( $this->form_data['settings']['form_locker_user_entry_message_limited'] )
			? $this->form_data['settings']['form_locker_user_entry_message_limited']
			: '';
	}
}
