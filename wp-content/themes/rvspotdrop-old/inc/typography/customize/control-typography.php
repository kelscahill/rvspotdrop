<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class rvspotdrop_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'rvspotdrop' ),
				'family'      => esc_html__( 'Font Family', 'rvspotdrop' ),
				'size'        => esc_html__( 'Font Size',   'rvspotdrop' ),
				'weight'      => esc_html__( 'Font Weight', 'rvspotdrop' ),
				'style'       => esc_html__( 'Font Style',  'rvspotdrop' ),
				'line_height' => esc_html__( 'Line Height', 'rvspotdrop' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'rvspotdrop' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'rvspotdrop-ctypo-customize-controls' );
		wp_enqueue_style(  'rvspotdrop-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'rvspotdrop' ),
        'Abril Fatface' => __( 'Abril Fatface', 'rvspotdrop' ),
        'Acme' => __( 'Acme', 'rvspotdrop' ),
        'Anton' => __( 'Anton', 'rvspotdrop' ),
        'Architects Daughter' => __( 'Architects Daughter', 'rvspotdrop' ),
        'Arimo' => __( 'Arimo', 'rvspotdrop' ),
        'Arsenal' => __( 'Arsenal', 'rvspotdrop' ),
        'Arvo' => __( 'Arvo', 'rvspotdrop' ),
        'Alegreya' => __( 'Alegreya', 'rvspotdrop' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'rvspotdrop' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'rvspotdrop' ),
        'Bangers' => __( 'Bangers', 'rvspotdrop' ),
        'Boogaloo' => __( 'Boogaloo', 'rvspotdrop' ),
        'Bad Script' => __( 'Bad Script', 'rvspotdrop' ),
        'Bitter' => __( 'Bitter', 'rvspotdrop' ),
        'Bree Serif' => __( 'Bree Serif', 'rvspotdrop' ),
        'BenchNine' => __( 'BenchNine', 'rvspotdrop' ),
        'Cabin' => __( 'Cabin', 'rvspotdrop' ),
        'Cardo' => __( 'Cardo', 'rvspotdrop' ),
        'Courgette' => __( 'Courgette', 'rvspotdrop' ),
        'Cherry Swash' => __( 'Cherry Swash', 'rvspotdrop' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'rvspotdrop' ),
        'Crimson Text' => __( 'Crimson Text', 'rvspotdrop' ),
        'Cuprum' => __( 'Cuprum', 'rvspotdrop' ),
        'Cookie' => __( 'Cookie', 'rvspotdrop' ),
        'Chewy' => __( 'Chewy', 'rvspotdrop' ),
        'Days One' => __( 'Days One', 'rvspotdrop' ),
        'Dosis' => __( 'Dosis', 'rvspotdrop' ),
        'Droid Sans' => __( 'Droid Sans', 'rvspotdrop' ),
        'Economica' => __( 'Economica', 'rvspotdrop' ),
        'Fredoka One' => __( 'Fredoka One', 'rvspotdrop' ),
        'Fjalla One' => __( 'Fjalla One', 'rvspotdrop' ),
        'Francois One' => __( 'Francois One', 'rvspotdrop' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'rvspotdrop' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'rvspotdrop' ),
        'Great Vibes' => __( 'Great Vibes', 'rvspotdrop' ),
        'Handlee' => __( 'Handlee', 'rvspotdrop' ),
        'Hammersmith One' => __( 'Hammersmith One', 'rvspotdrop' ),
        'Inconsolata' => __( 'Inconsolata', 'rvspotdrop' ),
        'Indie Flower' => __( 'Indie Flower', 'rvspotdrop' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'rvspotdrop' ),
        'Julius Sans One' => __( 'Julius Sans One', 'rvspotdrop' ),
        'Josefin Slab' => __( 'Josefin Slab', 'rvspotdrop' ),
        'Josefin Sans' => __( 'Josefin Sans', 'rvspotdrop' ),
        'Kanit' => __( 'Kanit', 'rvspotdrop' ),
        'Lobster' => __( 'Lobster', 'rvspotdrop' ),
        'Lato' => __( 'Lato', 'rvspotdrop' ),
        'Lora' => __( 'Lora', 'rvspotdrop' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'rvspotdrop' ),
        'Lobster Two' => __( 'Lobster Two', 'rvspotdrop' ),
        'Merriweather' => __( 'Merriweather', 'rvspotdrop' ),
        'Monda' => __( 'Monda', 'rvspotdrop' ),
        'Montserrat' => __( 'Montserrat', 'rvspotdrop' ),
        'Muli' => __( 'Muli', 'rvspotdrop' ),
        'Marck Script' => __( 'Marck Script', 'rvspotdrop' ),
        'Noto Serif' => __( 'Noto Serif', 'rvspotdrop' ),
        'Open Sans' => __( 'Open Sans', 'rvspotdrop' ),
        'Overpass' => __( 'Overpass', 'rvspotdrop' ),
        'Overpass Mono' => __( 'Overpass Mono', 'rvspotdrop' ),
        'Oxygen' => __( 'Oxygen', 'rvspotdrop' ),
        'Orbitron' => __( 'Orbitron', 'rvspotdrop' ),
        'Patua One' => __( 'Patua One', 'rvspotdrop' ),
        'Pacifico' => __( 'Pacifico', 'rvspotdrop' ),
        'Padauk' => __( 'Padauk', 'rvspotdrop' ),
        'Playball' => __( 'Playball', 'rvspotdrop' ),
        'Playfair Display' => __( 'Playfair Display', 'rvspotdrop' ),
        'PT Sans' => __( 'PT Sans', 'rvspotdrop' ),
        'Philosopher' => __( 'Philosopher', 'rvspotdrop' ),
        'Permanent Marker' => __( 'Permanent Marker', 'rvspotdrop' ),
        'Poiret One' => __( 'Poiret One', 'rvspotdrop' ),
        'Quicksand' => __( 'Quicksand', 'rvspotdrop' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'rvspotdrop' ),
        'Raleway' => __( 'Raleway', 'rvspotdrop' ),
        'Rubik' => __( 'Rubik', 'rvspotdrop' ),
        'Rokkitt' => __( 'Rokkitt', 'rvspotdrop' ),
        'Russo One' => __( 'Russo One', 'rvspotdrop' ),
        'Righteous' => __( 'Righteous', 'rvspotdrop' ),
        'Slabo' => __( 'Slabo', 'rvspotdrop' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'rvspotdrop' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'rvspotdrop'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'rvspotdrop' ),
        'Sacramento' => __( 'Sacramento', 'rvspotdrop' ),
        'Shrikhand' => __( 'Shrikhand', 'rvspotdrop' ),
        'Tangerine' => __( 'Tangerine', 'rvspotdrop' ),
        'Ubuntu' => __( 'Ubuntu', 'rvspotdrop' ),
        'VT323' => __( 'VT323', 'rvspotdrop' ),
        'Varela Round' => __( 'Varela Round', 'rvspotdrop' ),
        'Vampiro One' => __( 'Vampiro One', 'rvspotdrop' ),
        'Vollkorn' => __( 'Vollkorn', 'rvspotdrop' ),
        'Volkhov' => __( 'Volkhov', 'rvspotdrop' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'rvspotdrop' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'rvspotdrop' ),
			'100' => esc_html__( 'Thin',       'rvspotdrop' ),
			'300' => esc_html__( 'Light',      'rvspotdrop' ),
			'400' => esc_html__( 'Normal',     'rvspotdrop' ),
			'500' => esc_html__( 'Medium',     'rvspotdrop' ),
			'700' => esc_html__( 'Bold',       'rvspotdrop' ),
			'900' => esc_html__( 'Ultra Bold', 'rvspotdrop' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'' => esc_html__( 'No Fonts Style', 'rvspotdrop' ),
			'normal'  => esc_html__( 'Normal', 'rvspotdrop' ),
			'italic'  => esc_html__( 'Italic', 'rvspotdrop' ),
			'oblique' => esc_html__( 'Oblique', 'rvspotdrop' )
		);
	}
}
