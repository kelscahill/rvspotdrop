<?php
class WPForms_Field_Select_country extends WPForms_Field {

	/**
	 * Choices JS version.
	 *
	 * @since 1.6.3
	 */
	const CHOICES_VERSION = '9.0.1';

	/**
	 * Classic (old) style.
	 *
	 * @since 1.6.1
	 *
	 * @var string
	 */
	const STYLE_CLASSIC = 'classic';

	/**
	 * Modern style.
	 *
	 * @since 1.6.1
	 *
	 * @var string
	 */
	const STYLE_MODERN = 'modern';

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function init() {
//	var_dump("dasad");
		// Define field type information.
		$this->name     = esc_html__( 'Country Dropdown', 'wpforms-lite' );
		$this->type     = 'select_country';
		$this->icon     = 'fa-caret-square-o-down';
		$this->order    = 1;
		$this->defaults = array(
			1 => array(
				'label'   => esc_html__( 'Select Country', 'wpforms-lite' ),
				'value'   => '',
				'default' => '',
			),
			
		);

		// Define additional field properties.
		add_filter( 'wpforms_field_properties_' . $this->type, array( $this, 'field_properties' ), 5, 3 );

		// Form frontend CSS enqueues.
		add_action( 'wpforms_frontend_css', array( $this, 'enqueue_frontend_css' ) );

		// Form frontend JS enqueues.
		add_action( 'wpforms_frontend_js', array( $this, 'enqueue_frontend_js' ) );
		
	}

	/**
	 * Define additional field properties.
	 *
	 * @since 1.5.0
	 *
	 * @param array $properties Field properties.
	 * @param array $field      Field settings.
	 * @param array $form_data  Form data and settings.
	 *
	 * @return array
	 */
	public function field_properties( $properties, $field, $form_data ) {

		// Remove primary input.
		unset( $properties['inputs']['primary'] );

		// Define data.
		$form_id  = absint( $form_data['id'] );
		$field_id = absint( $field['id'] );
		$choices  = $field['choices'];
		$dynamic  = wpforms_get_field_dynamic_choices( $field, $form_id, $form_data );

		if ( $dynamic ) {
			$choices              = $dynamic;
			$field['show_values'] = true;
		}

		// Set options container (<select>) properties.
		$properties['input_container'] = array(
			'class' => array(),
			'data'  => array(),
			'id'    => "wpforms-{$form_id}-field_{$field_id}",
			'attr'  => array(
				'name' => "wpforms[fields][{$field_id}]",
			),
		);

		// Set properties.
		foreach ( $choices as $key => $choice ) {

			// Used for dynamic choices.
			$depth = isset( $choice['depth'] ) ? absint( $choice['depth'] ) : 1;

			$properties['inputs'][ $key ] = array(
				'container' => array(
					'attr'  => array(),
					'class' => array( "choice-{$key}", "depth-{$depth}" ),
					'data'  => array(),
					'id'    => '',
				),
				'label'     => array(
					'attr'  => array(
						'for' => "wpforms-{$form_id}-field_{$field_id}_{$key}",
					),
					'class' => array( 'wpforms-field-label-inline' ),
					'data'  => array(),
					'id'    => '',
					'text'  => $choice['label'],
				),
				'attr'      => array(
					'name'  => "wpforms[fields][{$field_id}]",
					'value' => isset( $field['show_values'] ) ? $choice['value'] : $choice['label'],
				),
				'class'     => array(),
				'data'      => array(),
				'id'        => "wpforms-{$form_id}-field_{$field_id}_{$key}",
				'required'  => ! empty( $field['required'] ) ? 'required' : '',
				'default'   => isset( $choice['default'] ),
			);
		}

		// Add class that changes the field size.
		if ( ! empty( $field['size'] ) ) {
			$properties['input_container']['class'][] = 'wpforms-field-' . esc_attr( $field['size'] );
		}

		// Required class for pagebreak validation.
		if ( ! empty( $field['required'] ) ) {
			$properties['input_container']['class'][] = 'wpforms-field-required';
		}

		// Add additional class for container.
		if (
			! empty( $field['style'] ) &&
			in_array( $field['style'], array( self::STYLE_CLASSIC, self::STYLE_MODERN ), true )
		) {
			$properties['container']['class'][] = "wpforms-field-select-style-{$field['style']}";
		}

		return $properties;
	}

	/**
	 * Field options panel inside the builder.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field Field settings.
	 */
	public function field_options( $field ) {

		/*
		 * Basic field options.
		 */

		// Options open markup.
		$this->field_option(
			'basic-options',
			$field,
			array(
				'markup' => 'open',
			)
		);

		// Label.
		$this->field_option( 'label', $field );

		// Choices.
		$this->field_option( 'choices', $field );

		// Description.
		$this->field_option( 'description', $field );

		// Required toggle.
		$this->field_option( 'required', $field );

		// Options close markup.
		$this->field_option(
			'basic-options',
			$field,
			array(
				'markup' => 'close',
			)
		);

		/*
		 * Advanced field options.
		 */

		// Options open markup.
		$this->field_option(
			'advanced-options',
			$field,
			array(
				'markup' => 'open',
			)
		);

		// Size.
		$this->field_option( 'size', $field );

		// Placeholder.
		$this->field_option( 'placeholder', $field );

		// Hide label.
		$this->field_option( 'label_hide', $field );

		// Custom CSS classes.
		$this->field_option( 'css', $field );
		
		// Options close markup.
		$this->field_option(
			'advanced-options',
			$field,
			array(
				'markup' => 'close',
			)
		);
	}

	/**
	 * Field preview inside the builder.
	 *
	 * @since 1.0.0
	 * @since 1.6.1 Added a `Modern` style select support.
	 *
	 * @param array $field Field settings.
	 */
	public function field_preview( $field ) {
//var_dump('ok');
		$args = array();

		// Label.
		$this->field_preview_option( 'label', $field );

		// Prepare arguments.
		$args['modern'] = false;

		if (
			! empty( $field['style'] ) &&
			self::STYLE_MODERN === $field['style']
		) {
			$args['modern'] = true;
			$args['class']  = 'choicesjs-select';
		}

		// Choices.
		$this->field_preview_option( 'choices', $field, $args );

		// Description.
		$this->field_preview_option( 'description', $field );
	}

	/**
	 * Field display on the form front-end.
	 *
	 * @since 1.0.0
	 * @since 1.5.0 Converted to a new format, where all the data are taken not from $deprecated, but field properties.
	 * @since 1.6.1 Added a multiple select support.
	 *
	 * @param array $field      Field data and settings.
	 * @param array $deprecated Deprecated array of field attributes.
	 * @param array $form_data  Form data and settings.
	 */
	public function field_display( $field, $deprecated, $form_data ) {

		$container         = $field['properties']['input_container'];
		$field_placeholder = ! empty( $field['placeholder'] ) ? $field['placeholder'] : '';
		$is_multiple       = ! empty( $field['multiple'] );
		$is_modern         = ! empty( $field['style'] ) && self::STYLE_MODERN === $field['style'];

		if ( ! empty( $field['required'] ) ) {
			$container['attr']['required'] = 'required';
		}

		// If it's a multiple select.
		if ( $is_multiple ) {
			$container['attr']['multiple'] = 'multiple';

			// Change a name attribute.
			if ( ! empty( $container['attr']['name'] ) ) {
				$container['attr']['name'] .= '[]';
			}
		}

		// Add a class for Choices.js initialization.
		if ( $is_modern ) {
			$container['class'][] = 'choicesjs-select';

			// Add a size-class to data attribute - it is used when Choices.js is initialized.
			if ( ! empty( $field['size'] ) ) {
				$container['data']['size-class'] = 'wpforms-field-row wpforms-field-' . sanitize_html_class( $field['size'] );
			}
		}

		$choices     = $field['properties']['inputs'];
		$has_default = false;

		// Check to see if any of the options were selected by default.
		foreach ( $choices as $choice ) {
			if ( ! empty( $choice['default'] ) ) {
				$has_default = true;
				break;
			}
		}

		// Fake placeholder for Modern style.
		if ( $is_modern && empty( $field_placeholder ) ) {
			$first_choices     = reset( $choices );
			$field_placeholder = $first_choices['label']['text'];
		}

		// Preselect default if no other choices were marked as default.
		printf(
			'<select %s>',
			wpforms_html_attributes( $container['id'], $container['class'], $container['data'], $container['attr'] )
		);

		// Optional placeholder.
		if ( ! empty( $field_placeholder ) ) {
			printf(
				'<option value="" class="placeholder" disabled %s>%s</option>',
				selected( false, $has_default || $is_multiple, false ),
				esc_html( $field_placeholder )
			);
		}

		// Build the select options.
		foreach ( $choices as $key => $choice ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $choice['attr']['value'] ),
				selected( true, ! empty( $choice['default'] ), false ),
				esc_html( $choice['label']['text'] )
			);
		}

		echo '</select>';
	}

	/**
	 * Format and sanitize field.
	 *
	 * @since 1.0.2
	 * @since 1.6.1 Added a support for multiple values.
	 *
	 * @param int          $field_id     Field ID.
	 * @param string|array $field_submit Submitted field value (selected option).
	 * @param array        $form_data    Form data and settings.
	 */
	public function format( $field_id, $field_submit, $form_data ) {

		$field    = $form_data['fields'][ $field_id ];
		$dynamic  = ! empty( $field['dynamic_choices'] ) ? $field['dynamic_choices'] : false;
		$multiple = ! empty( $field['multiple'] );
		$name     = sanitize_text_field( $field['label'] );
		$value    = [];

		// Convert submitted field value to array.
		if ( ! is_array( $field_submit ) ) {
			$field_submit = array( $field_submit );
		}

		$value_raw = wpforms_sanitize_array_combine( $field_submit );

		$data = array(
			'name'      => $name,
			'value'     => '',
			'value_raw' => $value_raw,
			'id'        => absint( $field_id ),
			'type'      => $this->type,
		);

		if ( 'post_type' === $dynamic && ! empty( $field['dynamic_post_type'] ) ) {

			// Dynamic population is enabled using post type (like for a `Checkboxes` field).
			$value_raw                 = implode( ',', array_map( 'absint', $field_submit ) );
			$data['value_raw']         = $value_raw;
			$data['dynamic']           = 'post_type';
			$data['dynamic_items']     = $value_raw;
			$data['dynamic_post_type'] = $field['dynamic_post_type'];
			$posts                     = array();

			foreach ( $field_submit as $id ) {
				$post = get_post( $id );

				if ( ! is_wp_error( $post ) && ! empty( $post ) && $data['dynamic_post_type'] === $post->post_type ) {
					$posts[] = esc_html( $post->post_title );
				}
			}

			$data['value'] = ! empty( $posts ) ? wpforms_sanitize_array_combine( $posts ) : '';

		} elseif ( 'taxonomy' === $dynamic && ! empty( $field['dynamic_taxonomy'] ) ) {

			// Dynamic population is enabled using taxonomy (like for a `Checkboxes` field).
			$value_raw                = implode( ',', array_map( 'absint', $field_submit ) );
			$data['value_raw']        = $value_raw;
			$data['dynamic']          = 'taxonomy';
			$data['dynamic_items']    = $value_raw;
			$data['dynamic_taxonomy'] = $field['dynamic_taxonomy'];
			$terms                    = array();

			foreach ( $field_submit as $id ) {
				$term = get_term( $id, $field['dynamic_taxonomy'] );

				if ( ! is_wp_error( $term ) && ! empty( $term ) ) {
					$terms[] = esc_html( $term->name );
				}
			}

			$data['value'] = ! empty( $terms ) ? wpforms_sanitize_array_combine( $terms ) : '';

		} else {

			// Normal processing, dynamic population is off.

			// If show_values is true, that means values posted are the raw values
			// and not the labels. So we need to get the label values.
			if ( ! empty( $field['show_values'] ) && '1' == $field['show_values'] ) {

				foreach ( $field_submit as $item ) {
					foreach ( $field['choices'] as $choice ) {
						if ( $item === $choice['value'] ) {
							$value[] = $choice['label'];
							break;
						}
					}
				}

				$data['value'] = ! empty( $value ) ? wpforms_sanitize_array_combine( $value ) : '';

			} else {
				$data['value'] = $value_raw;
			}
		}

		// Backward compatibility: for single dropdown save a string, for multiple - array.
		if ( ! $multiple && is_array( $data ) && ( 1 === count( $data ) ) ) {
			$data = reset( $data );
		}

		// Push field details to be saved.
		wpforms()->process->fields[ $field_id ] = $data;
	}

	/**
	 * Form frontend CSS enqueues.
	 *
	 * @since 1.6.1
	 *
	 * @param array $forms Forms on the current page.
	 */
	public function enqueue_frontend_css( $forms ) {

		$has_modern_select = false;

		foreach ( $forms as $form ) {
			if ( $this->is_field_style( $form, self::STYLE_MODERN ) ) {
				$has_modern_select = true;

				break;
			}
		}

		if ( $has_modern_select || wpforms()->frontend->assets_global() ) {
			$min = \wpforms_get_min_suffix();

			wp_enqueue_style(
				'wpforms-choicesjs',
				WPFORMS_PLUGIN_URL . "assets/css/choices{$min}.css",
				array(),
				self::CHOICES_VERSION
			);
		}
	}

	/**
	 * Form frontend JS enqueues.
	 *
	 * @since 1.6.1
	 *
	 * @param array $forms Forms on the current page.
	 */
	public function enqueue_frontend_js( $forms ) {

		$has_modern_select = false;

		foreach ( $forms as $form ) {
			if ( $this->is_field_style( $form, self::STYLE_MODERN ) ) {
				$has_modern_select = true;

				break;
			}
		}

		if ( $has_modern_select || wpforms()->frontend->assets_global() ) {
			$this->enqueue_choicesjs_once( $forms );
		}
	}

	/**
	 * Whether the provided form has a dropdown field with a specified style.
	 *
	 * @since 1.6.1
	 *
	 * @param array  $form  Form data.
	 * @param string $style Desired field style.
	 *
	 * @return bool
	 */
	protected function is_field_style( $form, $style ) {

		$is_field_style = false;

		if ( empty( $form['fields'] ) ) {

			return $is_field_style;
		}

		foreach ( (array) $form['fields'] as $field ) {

			if (
				! empty( $field['type'] ) &&
				$field['type'] === $this->type &&
				! empty( $field['style'] ) &&
				sanitize_key( $style ) === $field['style']
			) {
				$is_field_style = true;
				break;
			}
		}

		return $is_field_style;
	}

	/**
	 * Get field name for ajax error message.
	 *
	 * @since 1.6.3
	 *
	 * @param string $name  Field name for error triggered.
	 * @param array  $field Field settings.
	 * @param array  $props List of properties.
	 * @param string $error Error message.
	 *
	 * @return string
	 */
	public function ajax_error_field_name( $name, $field, $props, $error ) {

		if ( ! isset( $field['type'] ) || 'select' !== $field['type'] ) {
			return $name;
		}
		if ( ! empty( $field['multiple'] ) ) {
			$input = isset( $props['inputs'] ) ? end( $props['inputs'] ) : [];

			return isset( $input['attr']['name'] ) ? $input['attr']['name'] . '[]' : '';
		}

		return $name;
	}	
	
    public function field_option( $option, $field, $args = array(), $echo = true ) {

		switch ( $option ) {

			/**
			 * Basic Fields.
			 */

			/*
			 * Basic Options markup.
			 */
			case 'basic-options':
				$markup = ! empty( $args['markup'] ) ? $args['markup'] : 'open';
				$class  = ! empty( $args['class'] ) ? esc_html( $args['class'] ) : '';
				if ( 'open' === $markup ) {
					$output  = sprintf( '<div class="wpforms-field-option-group wpforms-field-option-group-basic" id="wpforms-field-option-basic-%d">', $field['id'] );
					$output .= sprintf( '<a href="#" class="wpforms-field-option-group-toggle">%s <span>(ID #%d)</span> <i class="fa fa-angle-down"></i></a>', $this->name, $field['id'] );
					$output .= sprintf( '<div class="wpforms-field-option-group-inner %s">', $class );
				} else {
					$output = '</div></div>';
				}
				break;

			/*
			 * Field Label.
			 */
			case 'label':
				$value   = ! empty( $field['label'] ) ? esc_attr( $field['label'] ) : '';
				$tooltip = esc_html__( 'Enter text for the form field label. Field labels are recommended and can be hidden in the Advanced Settings.', 'wpforms-lite' );
				$output  = $this->field_element( 'label', $field, array( 'slug' => 'label', 'value' => esc_html__( 'Label', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output .= $this->field_element( 'text',  $field, array( 'slug' => 'label', 'value' => $value ), false );
				$output  = $this->field_element( 'row',   $field, array( 'slug' => 'label', 'content' => $output ), false );
				break;

			/*
			 * Field Description.
			 */
			case 'description':
				$value   = ! empty( $field['description'] ) ? esc_attr( $field['description'] ) : '';
				$tooltip = esc_html__( 'Enter text for the form field description.', 'wpforms-lite' );
				$output  = $this->field_element( 'label',    $field, array( 'slug' => 'description', 'value' => esc_html__( 'Description', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output .= $this->field_element( 'textarea', $field, array( 'slug' => 'description', 'value' => $value ), false );
				$output  = $this->field_element( 'row',      $field, array( 'slug' => 'description', 'content' => $output ), false );
				break;

			/*
			 * Field Required toggle.
			 */
			case 'required':
				$default = ! empty( $args['default'] ) ? $args['default'] : '0';
				$value   = isset( $field['required'] ) ? $field['required'] : $default;
				$tooltip = esc_html__( 'Check this option to mark the field required. A form will not submit unless all required fields are provided.', 'wpforms-lite' );
				$output  = $this->field_element( 'checkbox', $field, array( 'slug' => 'required', 'value' => $value, 'desc' => esc_html__( 'Required', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output  = $this->field_element( 'row',      $field, array( 'slug' => 'required', 'content' => $output ), false );
				break;

			/*
			 * Field Meta (field type and ID).
			 */
			case 'meta':
				$output  = sprintf( '<label>%s</label>', 'Type' );
				$output .= sprintf( '<p class="meta">%s <span class="id">(ID #%d)</span></p>', $this->name, $field['id'] );
				$output  = $this->field_element( 'row', $field, array( 'slug' => 'meta', 'content' => $output ), false );
				break;

			/*
			 * Code Block.
			 */
			case 'code':
				$value   = ! empty( $field['code'] ) ? esc_textarea( $field['code'] ) : '';
				$tooltip = esc_html__( 'Enter code for the form field.', 'wpforms-lite' );
				$output  = $this->field_element( 'label',    $field, array( 'slug' => 'code', 'value' => esc_html__( 'Code', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output .= $this->field_element( 'textarea', $field, array( 'slug' => 'code', 'value' => $value ), false );
				$output  = $this->field_element( 'row',      $field, array( 'slug' => 'code', 'content' => $output ), false );
				break;

			/*
			 * Choices.
			 */
			case 'choices':
				$values     = ! empty( $field['choices'] ) ? $field['choices'] : $this->defaults;
				$label      = ! empty( $args['label'] ) ? esc_html( $args['label'] ) : esc_html__( 'Choices', 'wpforms-lite' );
				$class      = array();
				$field_type = $this->type;

				if ( ! empty( $field['multiple'] ) ) {
					$field_type = 'checkbox';
				}

				if ( ! empty( $field['show_values'] ) ) {
					$class[] = 'show-values';
				}
				if ( ! empty( $field['dynamic_choices'] ) ) {
					$class[] = 'wpforms-hidden';
				}
				if ( ! empty( $field['choices_images'] ) ) {
					$class[] = 'show-images';
				}

				// Field label.
				$lbl = $this->field_element(
					'label',
					$field,
					array(
						'slug'          => 'choices',
						'value'         => $label,
						'tooltip'       => esc_html__( 'Add choices for the form field.', 'wpforms-lite' ),
						'after_tooltip' => '<a href="#" class="toggle-bulk-add-display"><i class="fa fa-download"></i> <span>' . esc_html__( 'Bulk Add', 'wpforms-lite' ) . '</span></a>',
					),
					false
				);

				// Field contents.
				$fld = sprintf(
					'<ul data-next-id="%s" class="choices-list %s" data-field-id="%d" data-field-type="%s">',
					max( array_keys( $values ) ) + 1,
					wpforms_sanitize_classes( $class, true ),
					$field['id'],
					$this->type
				);
				foreach ( $values as $key => $value ) {
					$default   = ! empty( $value['default'] ) ? $value['default'] : '';
					$base      = sprintf( 'fields[%s][choices][%s]', $field['id'], $key );
					$image     = ! empty( $value['image'] ) ? $value['image'] : '';
					$image_btn = '';

					$fld .= '<li data-key="' . absint( $key ) . '">';
					$fld .= sprintf(
						'<input type="%s" name="%s[default]" class="default" value="1" %s>',
						'checkbox' === $field_type ? 'checkbox' : 'radio',
						$base,
						checked( '1', $default, false )
					);
					$fld .= '<span class="move"><i class="fa fa-bars"></i></span>';
					$fld .= sprintf(
						'<input type="text" name="%s[label]" value="%s" class="label">',
						$base,
						esc_attr( $value['label'] )
					);
					$fld .= '<a class="add" href="#"><i class="fa fa-plus-circle"></i></a><a class="remove" href="#"><i class="fa fa-minus-circle"></i></a>';
					$fld .= sprintf(
						'<input type="text" name="%s[value]" value="%s" class="value">',
						$base,
						esc_attr( ! isset( $value['value'] ) ? '' : $value['value'] )
					);
					$fld .= '<div class="wpforms-image-upload">';
					$fld .= '<div class="preview">';
					if ( ! empty( $image ) ) {
						$fld .= sprintf(
							'<a href="#" title="%s" class="wpforms-image-upload-remove"><img src="%s"></a>',
							esc_attr__( 'Remove Image', 'wpforms-lite' ),
							esc_url_raw( $image )
						);

						$image_btn = ' style="display:none;"';
					}
					$fld .= '</div>';
					$fld .= sprintf(
						'<button class="wpforms-btn wpforms-btn-md wpforms-btn-light-grey wpforms-btn-block wpforms-image-upload-add" data-after-upload="hide"%s>%s</button>',
						$image_btn,
						esc_html__( 'Upload Image', 'wpforms-lite' )
					);
					$fld .= sprintf(
						'<input type="hidden" name="%s[image]" value="%s" class="source">',
						$base,
						esc_url_raw( $image )
					);
					$fld .= '</div>';
					$fld .= '</li>';
				}
				$fld .= '</ul>';

				// Field note: dynamic status.
				$source  = '';
				$type    = '';
				$dynamic = ! empty( $field['dynamic_choices'] ) ? esc_html( $field['dynamic_choices'] ) : '';

				if ( 'post_type' === $dynamic && ! empty( $field[ 'dynamic_' . $dynamic ] ) ) {
					$type   = esc_html__( 'post type', 'wpforms-lite' );
					$pt     = get_post_type_object( $field[ 'dynamic_' . $dynamic ] );
					$source = '';
					if ( null !== $pt ) {
						$source = $pt->labels->name;
					}
				} elseif ( 'taxonomy' === $dynamic && ! empty( $field[ 'dynamic_' . $dynamic ] ) ) {
					$type   = esc_html__( 'taxonomy', 'wpforms-lite' );
					$tax    = get_taxonomy( $field[ 'dynamic_' . $dynamic ] );
					$source = '';
					if ( false !== $tax ) {
						$source = $tax->labels->name;
					}
				}

				$note = sprintf(
					'<div class="wpforms-alert-warning wpforms-alert-small wpforms-alert %s">',
					! empty( $dynamic ) && ! empty( $field[ 'dynamic_' . $dynamic ] ) ? '' : 'wpforms-hidden'
				);

				$note .= sprintf(
					/* translators: %1$s - source name; %2$s - type name. */
					esc_html__( 'Choices are dynamically populated from the %1$s %2$s.', 'wpforms-lite' ),
					'<span class="dynamic-name">' . $source . '</span>',
					'<span class="dynamic-type">' . $type . '</span>'
				);
				$note .= '</div>';

				// Final field output.
				$output = $this->field_element(
					'row',
					$field,
					array(
						'slug'    => 'choices',
						'content' => $lbl . $fld . $note,
					),
					false
				);
				break;

			/*
			 * Choices for payments.
			 */
			case 'choices_payments':
				$values     = ! empty( $field['choices'] ) ? $field['choices'] : $this->defaults;
				$class      = array();
				$input_type = in_array( $field['type'], array( 'payment-multiple', 'payment-select' ), true ) ? 'radio' : 'checkbox';

				if ( ! empty( $field['choices_images'] ) ) {
					$class[] = 'show-images';
				}

				// Field label.
				$lbl = $this->field_element(
					'label',
					$field,
					array(
						'slug'    => 'choices',
						'value'   => esc_html__( 'Items', 'wpforms-lite' ),
						'tooltip' => esc_html__( 'Add choices for the form field.', 'wpforms-lite' ),
					),
					false
				);

				// Field contents.
				$fld = sprintf(
					'<ul data-next-id="%s" class="choices-list %s" data-field-id="%d" data-field-type="%s">',
					max( array_keys( $values ) ) + 1,
					wpforms_sanitize_classes( $class, true ),
					$field['id'],
					$this->type
				);
				foreach ( $values as $key => $value ) {
					$default   = ! empty( $value['default'] ) ? $value['default'] : '';
					$base      = sprintf( 'fields[%s][choices][%s]', $field['id'], $key );
					$image     = ! empty( $value['image'] ) ? $value['image'] : '';
					$image_btn = '';

					$fld .= '<li data-key="' . absint( $key ) . '">';
					$fld .= sprintf(
						'<input type="%s" name="%s[default]" class="default" value="1" %s>',
						$input_type,
						$base,
						checked( '1', $default, false )
					);
					$fld .= '<span class="move"><i class="fa fa-bars"></i></span>';
					$fld .= sprintf(
						'<input type="text" name="%s[label]" value="%s" class="label">',
						$base,
						esc_attr( $value['label'] )
					);
					$fld .= sprintf(
						'<input type="text" name="%s[value]" value="%s" class="value wpforms-money-input" placeholder="%s">',
						$base,
						esc_attr( $value['value'] ),
						wpforms_format_amount( 0 )
					);
					$fld .= '<a class="add" href="#"><i class="fa fa-plus-circle"></i></a><a class="remove" href="#"><i class="fa fa-minus-circle"></i></a>';
					$fld .= '<div class="wpforms-image-upload">';
					$fld .= '<div class="preview">';
					if ( ! empty( $image ) ) {
						$fld .= sprintf(
							'<a href="#" title="%s" class="wpforms-image-upload-remove"><img src="%s"></a>',
							esc_attr__( 'Remove Image', 'wpforms-lite' ),
							esc_url_raw( $image )
						);

						$image_btn = ' style="display:none;"';
					}
					$fld .= '</div>';
					$fld .= sprintf(
						'<button class="wpforms-btn wpforms-btn-md wpforms-btn-light-grey wpforms-btn-block wpforms-image-upload-add" data-after-upload="hide"%s>%s</button>',
						$image_btn,
						esc_html__( 'Upload Image', 'wpforms-lite' )
					);
					$fld .= sprintf(
						'<input type="hidden" name="%s[image]" value="%s" class="source">',
						$base,
						esc_url_raw( $image )
					);
					$fld .= '</div>';
					$fld .= '</li>';
				}
				$fld .= '</ul>';

				// Final field output.
				$output = $this->field_element(
					'row',
					$field,
					array(
						'slug'    => 'choices',
						'content' => $lbl . $fld,
					),
					false
				);
				break;

			/*
			 * Choices Images.
			 */
			case 'choices_images':
				// Field note: Image tips.
				$note  = sprintf(
					'<div class="wpforms-alert-warning wpforms-alert-small wpforms-alert %s">',
					! empty( $field['choices_images'] ) ? '' : 'wpforms-hidden'
				);
				$note .= esc_html__( 'Images are not cropped or resized. For best results, they should be the same size and 250x250 pixels or smaller.', 'wpforms-lite' );
				$note .= '</div>';

				// Field contents.
				$fld = $this->field_element(
					'checkbox',
					$field,
					array(
						'slug'    => 'choices_images',
						'value'   => isset( $field['choices_images'] ) ? '1' : '0',
						'desc'    => esc_html__( 'Use image choices', 'wpforms-lite' ),
						'tooltip' => esc_html__( 'Check this option to enable using images with the choices.', 'wpforms-lite' ),
					),
					false
				);

				// Final field output.
				$output = $this->field_element(
					'row',
					$field,
					array(
						'slug'    => 'choices_images',
						'class'   => ! empty( $field['dynamic_choices'] ) ? 'wpforms-hidden' : '',
						'content' => $note . $fld,
					),
					false
				);
				break;

			/*
			 * Choices Images Style.
			 */
			case 'choices_images_style':
				// Field label.
				$lbl = $this->field_element(
					'label',
					$field,
					array(
						'slug'    => 'choices_images_style',
						'value'   => esc_html__( 'Image Choice Style', 'wpforms-lite' ),
						'tooltip' => esc_html__( 'Select the style for the image choices.', 'wpforms-lite' ),
					),
					false
				);

				// Field contents.
				$fld = $this->field_element(
					'select',
					$field,
					array(
						'slug'    => 'choices_images_style',
						'value'   => ! empty( $field['choices_images_style'] ) ? esc_attr( $field['choices_images_style'] ) : 'modern',
						'options' => array(
							'modern'  => esc_html__( 'Modern', 'wpforms-lite' ),
							'classic' => esc_html__( 'Classic', 'wpforms-lite' ),
							'none'    => esc_html__( 'None', 'wpforms-lite' ),
						),
					),
					false
				);

				// Final field output.
				$output = $this->field_element(
					'row',
					$field,
					array(
						'slug'    => 'choices_images_style',
						'content' => $lbl . $fld,
						'class'   => ! empty( $field['choices_images'] ) ? '' : 'wpforms-hidden',
					),
					false
				);
				break;

			/**
			 * Advanced Fields.
			 */

			/*
			 * Default value.
			 */
			case 'default_value':
				$value   = ! empty( $field['default_value'] ) || ( isset( $field['default_value'] ) && '0' === (string) $field['default_value'] ) ? esc_attr( $field['default_value'] ) : '';
				$tooltip = esc_html__( 'Enter text for the default form field value.', 'wpforms-lite' );
				$toggle  = '<a href="#" class="toggle-smart-tag-display" data-type="other"><i class="fa fa-tags"></i> <span>' . esc_html__( 'Show Smart Tags', 'wpforms-lite' ) . '</span></a>';
				$output  = $this->field_element( 'label', $field, array( 'slug' => 'default_value', 'value' => esc_html__( 'Default Value', 'wpforms-lite' ), 'tooltip' => $tooltip, 'after_tooltip' => $toggle ), false );
				$output .= $this->field_element( 'text',  $field, array( 'slug' => 'default_value', 'value' => $value ), false );
				$output  = $this->field_element( 'row',   $field, array( 'slug' => 'default_value', 'content' => $output ), false );
				break;

			/*
			 * Size.
			 */
			case 'size':
				$value   = ! empty( $field['size'] ) ? esc_attr( $field['size'] ) : 'medium';
				$class   = ! empty( $args['class'] ) ? esc_html( $args['class'] ) : '';
				$tooltip = esc_html__( 'Select the default form field size.', 'wpforms-lite' );
				$options = array(
					'small'  => esc_html__( 'Small', 'wpforms-lite' ),
					'medium' => esc_html__( 'Medium', 'wpforms-lite' ),
					'large'  => esc_html__( 'Large', 'wpforms-lite' ),
				);
				$output  = $this->field_element( 'label',  $field, array( 'slug' => 'size', 'value' => esc_html__( 'Field Size', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output .= $this->field_element( 'select', $field, array( 'slug' => 'size', 'value' => $value, 'options' => $options ), false );
				$output  = $this->field_element( 'row',    $field, array( 'slug' => 'size', 'content' => $output, 'class' => $class ), false );
				break;

			/*
			 * Advanced Options markup.
			 */
			case 'advanced-options':
				$markup = ! empty( $args['markup'] ) ? $args['markup'] : 'open';
				if ( 'open' === $markup ) {
					$override = apply_filters( 'wpforms_advanced_options_override', false );
					$override = ! empty( $override ) ? 'style="display:' . $override . ';"' : '';
					$output   = sprintf( '<div class="wpforms-field-option-group wpforms-field-option-group-advanced wpforms-hide" id="wpforms-field-option-advanced-%d" %s>', $field['id'], $override );
					$output  .= sprintf( '<a href="#" class="wpforms-field-option-group-toggle">%s <i class="fa fa-angle-right"></i></a>', esc_html__( 'Advanced Options', 'wpforms-lite' ) );
					$output  .= '<div class="wpforms-field-option-group-inner">';
				} else {
					$output = '</div></div>';
				}
				break;

			/*
			 * Placeholder.
			 */
			case 'placeholder':
				$value   = ! empty( $field['placeholder'] ) ? esc_attr( $field['placeholder'] ) : '';
				$tooltip = esc_html__( 'Enter text for the form field placeholder.', 'wpforms-lite' );
				$output  = $this->field_element( 'label', $field, array( 'slug' => 'placeholder', 'value' => esc_html__( 'Placeholder Text', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output .= $this->field_element( 'text',  $field, array( 'slug' => 'placeholder', 'value' => $value ), false );
				$output  = $this->field_element( 'row',   $field, array( 'slug' => 'placeholder', 'content' => $output ), false );
				break;

			/*
			 * CSS classes.
			 */
			case 'css':
				$toggle  = '';
				$value   = ! empty( $field['css'] ) ? esc_attr( $field['css'] ) : '';
				$tooltip = esc_html__( 'Enter CSS class names for the form field container. Class names should be separated with spaces.', 'wpforms-lite' );
				if ( 'pagebreak' !== $field['type'] ) {
					$toggle = '<a href="#" class="toggle-layout-selector-display"><i class="fa fa-th-large"></i> <span>' . esc_html__( 'Show Layouts', 'wpforms-lite' ) . '</span></a>';
				}
				// Build output.
				$output  = $this->field_element( 'label', $field, array( 'slug' => 'css', 'value' => esc_html__( 'CSS Classes', 'wpforms-lite' ), 'tooltip' => $tooltip, 'after_tooltip' => $toggle ), false );
				$output .= $this->field_element( 'text', $field, array( 'slug' => 'css', 'value' => 'csca_wp_country'), false );
				$output  = $this->field_element( 'row', $field, array( 'slug' => 'css', 'content' => $output ), false );
				break;

			/*
			 * Hide Label.
			 */
			case 'label_hide':
				$value   = isset( $field['label_hide'] ) ? $field['label_hide'] : '0';
				$tooltip = esc_html__( 'Check this option to hide the form field label.', 'wpforms-lite' );
				// Build output.
				$output = $this->field_element( 'checkbox', $field, array( 'slug' => 'label_hide', 'value' => $value, 'desc' => esc_html__( 'Hide Label', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output = $this->field_element( 'row',  $field, array( 'slug' => 'label_hide', 'content' => $output ), false );
				break;

			/*
			 * Hide Sub-Labels.
			 */
			case 'sublabel_hide':
				$value   = isset( $field['sublabel_hide'] ) ? $field['sublabel_hide'] : '0';
				$tooltip = esc_html__( 'Check this option to hide the form field sub-label.', 'wpforms-lite' );
				// Build output.
				$output = $this->field_element( 'checkbox', $field, array( 'slug' => 'sublabel_hide', 'value' => $value, 'desc' => esc_html__( 'Hide Sub-Labels', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output = $this->field_element( 'row', $field, array( 'slug' => 'sublabel_hide', 'content' => $output ), false );
				break;

			/*
			 * Input Columns.
			 */
			case 'input_columns':
				$value   = ! empty( $field['input_columns'] ) ? esc_attr( $field['input_columns'] ) : '';
				$tooltip = esc_html__( 'Select the layout for displaying field choices.', 'wpforms-lite' );
				$options = array(
					''       => esc_html__( 'One Column', 'wpforms-lite' ),
					'2'      => esc_html__( 'Two Columns', 'wpforms-lite' ),
					'3'      => esc_html__( 'Three Columns', 'wpforms-lite' ),
					'inline' => esc_html__( 'Inline', 'wpforms-lite' ),
				);
				$output  = $this->field_element( 'label', $field, array( 'slug' => 'input_columns', 'value' => esc_html__( 'Choice Layout', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output .= $this->field_element( 'select', $field, array( 'slug' => 'input_columns', 'value' => $value, 'options' => $options ), false );
				$output  = $this->field_element( 'row', $field, array( 'slug' => 'input_columns', 'content' => $output ), false );
				break;

			/*
			 * Dynamic Choices.
			 */
			case 'dynamic_choices':
				$value   = ! empty( $field['dynamic_choices'] ) ? esc_attr( $field['dynamic_choices'] ) : '';
				$tooltip = esc_html__( 'Select auto-populate method to use.', 'wpforms-lite' );
				$options = array(
					''          => esc_html__( 'Off', 'wpforms-lite' ),
					'post_type' => esc_html__( 'Post Type', 'wpforms-lite' ),
					'taxonomy'  => esc_html__( 'Taxonomy', 'wpforms-lite' ),
				);
				$output  = $this->field_element( 'label', $field, array( 'slug' => 'dynamic_choices', 'value' => esc_html__( 'Dynamic Choices', 'wpforms-lite' ), 'tooltip' => $tooltip ), false );
				$output .= $this->field_element( 'select', $field, array( 'slug' => 'dynamic_choices', 'value' => $value, 'options' => $options ), false );
				$output  = $this->field_element( 'row', $field, array( 'slug' => 'dynamic_choices', 'content' => $output ), false );
				break;

			/*
			 * Dynamic Choices Source.
			 */
			case 'dynamic_choices_source':
				$output = '';
				$type   = ! empty( $field['dynamic_choices'] ) ? esc_attr( $field['dynamic_choices'] ) : '';

				if ( ! empty( $type ) ) {

					$type_name = '';
					$items     = array();

					if ( 'post_type' === $type ) {

						$type_name = esc_html__( 'Post Type', 'wpforms-lite' );
						$items     = get_post_types(
							array(
								'public' => true,
							),
							'objects'
						);
						unset( $items['attachment'] );

					} elseif ( 'taxonomy' === $type ) {

						$type_name = esc_html__( 'Taxonomy', 'wpforms-lite' );
						$items     = get_taxonomies(
							array(
								'public' => true,
							),
							'objects'
						);
						unset( $items['post_format'] );
					}

					/* translators: %s - dynamic source type name. */
					$tooltip = sprintf( esc_html__( 'Select %s to use for auto-populating field choices.', 'wpforms-lite' ), $type_name );
					/* translators: %s - dynamic source type name. */
					$label   = sprintf( esc_html__( 'Dynamic %s Source', 'wpforms-lite' ), $type_name );
					$options = array();
					$source  = ! empty( $field[ 'dynamic_' . $type ] ) ? esc_attr( $field[ 'dynamic_' . $type ] ) : '';

					foreach ( $items as $key => $item ) {
						$options[ $key ] = $item->labels->name;
					}

					// Field option label.
					$option_label = $this->field_element(
						'label',
						$field,
						array(
							'slug'    => 'dynamic_' . $type,
							'value'   => $label,
							'tooltip' => $tooltip,
						),
						false
					);

					// Field option select input.
					$option_input = $this->field_element(
						'select',
						$field,
						array(
							'slug'    => 'dynamic_' . $type,
							'options' => $options,
							'value'   => $source,
						),
						false
					);

					// Field option row (markup) including label and input.
					$output = $this->field_element(
						'row',
						$field,
						array(
							'slug'    => 'dynamic_' . $type,
							'content' => $option_label . $option_input,
						),
						false
					);
				} // End if().
				break;
		}

		if ( ! $echo ) {
			return $output;
		}

		if ( in_array( $option, array( 'basic-options', 'advanced-options' ), true ) ) {

			if ( 'open' === $markup ) {
				do_action( "wpforms_field_options_before_{$option}", $field, $this );
			}

			if ( 'close' === $markup ) {
				do_action( "wpforms_field_options_bottom_{$option}", $field, $this );
			}

			echo $output; // WPCS: XSS ok.

			if ( 'open' === $markup ) {
				do_action( "wpforms_field_options_top_{$option}", $field, $this );
			}

			if ( 'close' === $markup ) {
				do_action( "wpforms_field_options_after_{$option}", $field, $this );
			}
		} else {
			echo $output; // WPCS: XSS ok.
		}
	}

public function field_preview_option( $option, $field, $args = array(), $echo = true ) {

		$output       = '';
		$class        = ! empty( $args['class'] ) ? wpforms_sanitize_classes( $args['class'] ) : '';
		$allowed_tags = wpforms_builder_preview_get_allowed_tags();

		switch ( $option ) {

			case 'label':
				$label  = isset( $field['label'] ) && ! empty( $field['label'] ) ? esc_html( $field['label'] ) : '';
				$output = sprintf( '<label class="label-title %s"><span class="text">%s</span><span class="required">*</span></label>', $class, $label );
				break;

			case 'description':
				$description = isset( $field['description'] ) && ! empty( $field['description'] ) ? wp_kses( $field['description'], $allowed_tags ) : '';
				$description = strpos( $class, 'nl2br' ) !== false ? nl2br( $description ) : $description;
				$output      = sprintf( '<div class="description %s">%s</div>', $class, $description );
				break;

			case 'choices':
				$fields_w_choices = array( 'checkbox', 'gdpr-checkbox', 'select','select_country', 'payment-select', 'radio', 'payment-multiple', 'payment-checkbox' );

				$values  = ! empty( $field['choices'] ) ? $field['choices'] : $this->defaults;
				$dynamic = ! empty( $field['dynamic_choices'] ) ? $field['dynamic_choices'] : false;
				$total   = 0;

				/*
				 * Check to see if this field is configured for Dynamic Choices,
				 * either auto populating from a post type or a taxonomy.
				 */
				
			

				// Build output.
				if ( ! in_array( $field['type'], $fields_w_choices, true ) ) {
					break;
				}

				switch ( $field['type'] ) {
					case 'checkbox':
					case 'gdpr-checkbox':
					case 'payment-checkbox':
						$type = 'checkbox';
						break;

					case 'select':
					case 'payment-select':
						case 'select_country':
						$type = 'select';
						break;
						
					default:
						$type = 'radio';
						break;
						
				}

				$list_class  = array( 'primary-input' );
				$with_images = empty( $field['dynamic_choices'] ) && ! empty( $field['choices_images'] );

				if ( $with_images ) {
					$list_class[] = 'wpforms-image-choices';
					$list_class[] = 'wpforms-image-choices-' . sanitize_html_class( $field['choices_images_style'] );
				}

				if ( ! empty( $class ) ) {
					$list_class[] = $class;
				}

				// Special rules for <select>-based fields.
				if ( 'select' === $type ) {
					$multiple    = ! empty( $field['multiple'] ) ? ' multiple' : '';
					$placeholder = ! empty( $field['placeholder'] ) ? $field['placeholder'] : '';

					$output = sprintf(
						'<select class="%s"%s disabled>',
						wpforms_sanitize_classes( $list_class, true ),
						$multiple
					);

					// Optional placeholder.
					if ( ! empty( $placeholder ) ) {
						$output .= sprintf(
							'<option value="" class="placeholder">%s</option>',
							esc_html( $placeholder )
						);
					}

					// Build the select options.
					foreach ( $values as $key => $value ) {

						$default  = isset( $value['default'] ) ? (bool) $value['default'] : false;
						$selected = ! empty( $placeholder ) && empty( $multiple ) ? '' : selected( true, $default, false );

						$label = isset( $value['label'] ) ? trim( $value['label'] ) : '';
						/* translators: %d - Choice item number. */
						$label  = $label !== '' ? $label : sprintf( esc_html__( 'Choice %d', 'wpforms-lite' ), (int) $key );
						$label .= ! empty( $field['show_price_after_labels'] ) && isset( $value['value'] ) ? ' - ' . wpforms_format_amount( wpforms_sanitize_amount( $value['value'] ), true ) : '';

						$output .= sprintf(
							'<option value="%2$s" %1$s>%2$s</option>',
							$selected,
							esc_html( $label )
						);
					}

					$output .= '</select>';
				} else {
					// Normal checkbox/radio-based fields.
					$output = sprintf(
						'<ul class="%s">',
						wpforms_sanitize_classes( $list_class, true )
					);

					foreach ( $values as $key => $value ) {

						$default     = isset( $value['default'] ) ? $value['default'] : '';
						$selected    = checked( '1', $default, false );
						$input_class = array();
						$item_class  = array();

						if ( ! empty( $value['default'] ) ) {
							$item_class[] = 'wpforms-selected';
						}

						if ( $with_images ) {
							$item_class[] = 'wpforms-image-choices-item';
						}

						$output .= sprintf(
							'<li class="%s">',
							wpforms_sanitize_classes( $item_class, true )
						);

						$label = isset( $value['label'] ) ? trim( $value['label'] ) : '';
						/* translators: %d - Choice item number. */
						$label  = $label !== '' ? $label : sprintf( esc_html__( 'Choice %d', 'wpforms-lite' ), (int) $key );
						$label .= ! empty( $field['show_price_after_labels'] ) && isset( $value['value'] ) ? ' - ' . wpforms_format_amount( wpforms_sanitize_amount( $value['value'] ), true ) : '';

						if ( $with_images ) {

							if ( in_array( $field['choices_images_style'], array( 'modern', 'classic' ), true ) ) {
								$input_class[] = 'wpforms-screen-reader-element';
							}

							$output .= '<label>';

							$output .= sprintf(
								'<span class="wpforms-image-choices-image"><img src="%s" alt="%s"%s></span>',
								! empty( $value['image'] ) ? esc_url( $value['image'] ) : WPFORMS_PLUGIN_URL . 'assets/images/placeholder-200x125.png',
								esc_attr( $value['label'] ),
								! empty( $value['label'] ) ? ' title="' . esc_attr( $value['label'] ) . '"' : ''
							);

							if ( 'none' === $field['choices_images_style'] ) {
								$output .= '<br>';
							}

							$output .= sprintf(
								'<input type="%s" class="%s" %s disabled>',
								$type,
								wpforms_sanitize_classes( $input_class, true ),
								$selected
							);

							$output .= '<span class="wpforms-image-choices-label">' . wp_kses( $label, $allowed_tags ) . '</span>';

							$output .= '</label>';

						} else {
							$output .= sprintf(
								'<input type="%s" %s disabled>%s',
								$type,
								$selected,
								wp_kses( $label, $allowed_tags )
							);
						}

						$output .= '</li>';
					}

					$output .= '</ul>';
				}

				/*
				 * Dynamic population is enabled and contains more than 20 items,
				 * include a note about results displayed.
				 */
				if ( $total > 20 ) {
					$output .= '<div class="wpforms-alert-dynamic wpforms-alert wpforms-alert-warning">';
					$output .= sprintf(
						wp_kses(
							/* translators: %d - total amount of choices. */
							__( 'Showing the first 20 choices.<br> All %d choices will be displayed when viewing the form.', 'wpforms-lite' ),
							array(
								'br' => array(),
							)
						),
						$total
					);
					$output .= '</div>';
				}
				break;
		}

		if ( ! $echo ) {
			return $output;
		}

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

new WPForms_Field_Select_country();
?>