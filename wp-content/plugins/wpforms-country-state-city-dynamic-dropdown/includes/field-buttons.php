<?php
class wp_field_buttons {
	public function __construct(){
add_action( "wp_ajax_wpforms_new_field_select_country", array($this,'csca_country_field_new'),5 );	
add_action( "wp_ajax_wpforms_new_field_select_state", array($this,'csca_state_field_new'),5 );
add_action( "wp_ajax_wpforms_new_field_select_city", array($this,'csca_city_field_new'),5 );
	}	
public function csca_country_field_new() {
	check_ajax_referer( 'wpforms-builder', 'nonce' );
	    $pid=sanitize_text_field($_POST['id']);
		$field_type     = sanitize_text_field( $_POST['type'] );
		$field_id       = wpforms()->form->next_field_id($pid);
		$field          = array(
			'id'          => $field_id,
			'type'        => $field_type,
			'label'       => 'Country',
			'description' => '',
		);
	ob_start();
	$this1=new WPForms_Field_Select_country();
	$this1->field_preview( $field );
	$prev     = ob_get_clean();
	$preview  = sprintf( '<div class="wpforms-field wpforms-field-%s %s %s" id="wpforms-field-%d" data-field-id="%d" data-field-type="%s">', $field_type, $field_required, $field_class, $field['id'], $field['id'], $field_type );
		if ( apply_filters( 'wpforms_field_new_display_duplicate_button', true, $field ) ) {
			$preview .= sprintf( '<a href="#" class="wpforms-field-duplicate" title="%s"><i class="fa fa-files-o" aria-hidden="true"></i></a>', esc_attr__( 'Duplicate Field', 'wpforms-lite' ) );
		}
		$preview .= sprintf( '<a href="#" class="wpforms-field-delete" title="%s"><i class="fa fa-trash"></i></a>', esc_attr__( 'Delete Field', 'wpforms-lite' ) );
		$preview .= sprintf( '<span class="wpforms-field-helper">%s</span>', esc_html__( 'Click to edit. Drag to reorder.', 'wpforms-lite' ) );
		$preview .= $prev;
		$preview .= '</div>';
	$class    = apply_filters( 'wpforms_builder_field_option_class', '', $field );
		$options  = sprintf( '<div class="wpforms-field-option wpforms-field-option-%s %s" id="wpforms-field-option-%d" data-field-id="%d">', sanitize_html_class( $field['type'] ), wpforms_sanitize_classes( $class ), (int) $field['id'], (int) $field['id'] );
		$options .= sprintf( '<input type="hidden" name="fields[%d][id]" value="%d" class="wpforms-field-option-hidden-id">', $field['id'], $field['id'] );
		$options .= sprintf( '<input type="hidden" name="fields[%d][type]" value="%s" class="wpforms-field-option-hidden-type">', $field['id'], esc_attr( $field['type'] ) );
		ob_start();
		$this1->field_options( $field );
		$options .= ob_get_clean();
		$options .= '</div>';
			wp_send_json_success(
			array(
				'form_id' => (int) $_POST['id'],
				'field'   => $field,
				'preview' => $preview,
				'options' => $options,
			)
		);
}
	
public function csca_state_field_new() {
	check_ajax_referer( 'wpforms-builder', 'nonce' );	
		$pid=sanitize_text_field($_POST['id']);
		$field_type     = sanitize_text_field( $_POST['type'] );
		$field_id       = wpforms()->form->next_field_id($pid);
		$field          = array(
			'id'          => $field_id,
			'type'        => $field_type,
			'label'       => 'State',
			'description' => '',
		);
	ob_start();
	$this1=new WPForms_Field_Select_state();
	$this1->field_preview( $field );
	$prev     = ob_get_clean();
	$preview  = sprintf( '<div class="wpforms-field wpforms-field-%s %s %s" id="wpforms-field-%d" data-field-id="%d" data-field-type="%s">', $field_type, $field_required, $field_class, $field['id'], $field['id'], $field_type );
		if ( apply_filters( 'wpforms_field_new_display_duplicate_button', true, $field ) ) {
			$preview .= sprintf( '<a href="#" class="wpforms-field-duplicate" title="%s"><i class="fa fa-files-o" aria-hidden="true"></i></a>', esc_attr__( 'Duplicate Field', 'wpforms-lite' ) );
		}
		$preview .= sprintf( '<a href="#" class="wpforms-field-delete" title="%s"><i class="fa fa-trash"></i></a>', esc_attr__( 'Delete Field', 'wpforms-lite' ) );
		$preview .= sprintf( '<span class="wpforms-field-helper">%s</span>', esc_html__( 'Click to edit. Drag to reorder.', 'wpforms-lite' ) );
		$preview .= $prev;
		$preview .= '</div>';
	$class    = apply_filters( 'wpforms_builder_field_option_class', '', $field );
		$options  = sprintf( '<div class="wpforms-field-option wpforms-field-option-%s %s" id="wpforms-field-option-%d" data-field-id="%d">', sanitize_html_class( $field['type'] ), wpforms_sanitize_classes( $class ), (int) $field['id'], (int) $field['id'] );
		$options .= sprintf( '<input type="hidden" name="fields[%d][id]" value="%d" class="wpforms-field-option-hidden-id">', $field['id'], $field['id'] );
		$options .= sprintf( '<input type="hidden" name="fields[%d][type]" value="%s" class="wpforms-field-option-hidden-type">', $field['id'], esc_attr( $field['type'] ) );
		ob_start();
		$this1->field_options( $field );
		$options .= ob_get_clean();
		$options .= '</div>';
			wp_send_json_success(
			array(
				'form_id' => (int) $_POST['id'],
				'field'   => $field,
				'preview' => $preview,
				'options' => $options,
			)
		);
}

public function csca_city_field_new() {
	check_ajax_referer( 'wpforms-builder', 'nonce' );	
		$pid=sanitize_text_field($_POST['id']);
		$field_type     = sanitize_text_field( $_POST['type'] );
		$field_id       = wpforms()->form->next_field_id($pid);
		$field          = array(
			'id'          => $field_id,
			'type'        => $field_type,
			'label'       => 'City',
			'description' => '',
		);
	ob_start();
	$this1=new WPForms_Field_Select_city();
	$this1->field_preview( $field );
	$prev     = ob_get_clean();
	$preview  = sprintf( '<div class="wpforms-field wpforms-field-%s %s %s" id="wpforms-field-%d" data-field-id="%d" data-field-type="%s">', $field_type, $field_required, $field_class, $field['id'], $field['id'], $field_type );
		if ( apply_filters( 'wpforms_field_new_display_duplicate_button', true, $field ) ) {
			$preview .= sprintf( '<a href="#" class="wpforms-field-duplicate" title="%s"><i class="fa fa-files-o" aria-hidden="true"></i></a>', esc_attr__( 'Duplicate Field', 'wpforms-lite' ) );
		}
		$preview .= sprintf( '<a href="#" class="wpforms-field-delete" title="%s"><i class="fa fa-trash"></i></a>', esc_attr__( 'Delete Field', 'wpforms-lite' ) );
		$preview .= sprintf( '<span class="wpforms-field-helper">%s</span>', esc_html__( 'Click to edit. Drag to reorder.', 'wpforms-lite' ) );
		$preview .= $prev;
		$preview .= '</div>';
	$class    = apply_filters( 'wpforms_builder_field_option_class', '', $field );
		$options  = sprintf( '<div class="wpforms-field-option wpforms-field-option-%s %s" id="wpforms-field-option-%d" data-field-id="%d">', sanitize_html_class( $field['type'] ), wpforms_sanitize_classes( $class ), (int) $field['id'], (int) $field['id'] );
		$options .= sprintf( '<input type="hidden" name="fields[%d][id]" value="%d" class="wpforms-field-option-hidden-id">', $field['id'], $field['id'] );
		$options .= sprintf( '<input type="hidden" name="fields[%d][type]" value="%s" class="wpforms-field-option-hidden-type">', $field['id'], esc_attr( $field['type'] ) );
		ob_start();
		$this1->field_options( $field );
		$options .= ob_get_clean();
		$options .= '</div>';
			wp_send_json_success(
			array(
				'form_id' => (int) $_POST['id'],
				'field'   => $field,
				'preview' => $preview,
				'options' => $options,
			)
		);
}	
}
new wp_field_buttons();
?>