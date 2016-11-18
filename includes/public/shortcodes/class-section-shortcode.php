<?php
/**
 * Cherry Section Shortcode.
 *
 * @package   Cherry_Team
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

/**
 * Class for Section shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Section_Shortcode {

	/**
	 * Shortcode name.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public static $name = 'cherry_section';

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Sets up our actions/filters.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Register shortcode on 'init'.
		add_action( 'init', array( $this, 'register_shortcode' ) );
	}

	/**
	 * Registers the [$this->name] shortcode.
	 *
	 * @since 1.0.0
	 */
	public function register_shortcode() {
		/**
		 * Filters a shortcode name.
		 *
		 * @since 1.0.0
		 * @param string $this->name Shortcode name.
		 */
		$tag = apply_filters( self::$name . '_shortcode_name', self::$name );

		add_shortcode( $tag, array( $this, 'do_shortcode' ) );
	}

	/**
	 * The shortcode function.
	 *
	 * @since  1.0.0
	 * @param  array  $atts      The user-inputted arguments.
	 * @param  string $content   The enclosed content (if the shortcode is used in its enclosing form).
	 * @param  string $shortcode The shortcode tag, useful for shared callback functions.
	 * @return string
	 */
	public function do_shortcode( $atts, $content = null, $shortcode = '' ) {
		// Set up the default arguments.
		$defaults = array(
			'id'                 => uniqid(),
			'background_type'    => 'fill-color',
			'background_color'   => '#fff',
			'background_opacity' => '100',
			'background_image'   => '',
			'background_size'    => 'cover',
			'padding_top'        => '',
			'padding_bottom'     => '',
			'class'              => '',
		);

		/**
		 * Parse the arguments.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
		 */
		$atts = shortcode_atts( $defaults, $atts, $shortcode );

		$html = sprintf(
			'<section id="cherry-section-%1$s" class="cherry-section %2$s %3$s">%4$s</section>',
			esc_attr( $atts['id'] ),
			esc_attr( $atts['background_size'] ),
			esc_attr( $atts['class'] ),
			do_shortcode( $content )
		);

		$this->generate_dynamic_styles( $atts );

		return $html;
	}

	/**
	 * Generate dynamic CSS styles for popup instance.
	 *
	 * @return void
	 */
	public function generate_dynamic_styles( $section_atts ) {

		$container_styles = array();

		switch ( $section_atts['background_type'] ) {
			case 'fill-color':
				$rgb_array = Cherry_Shortcodes_Tools::hex_to_rgb( $section_atts['background_color'] );
				$opacity = intval( $section_atts['background_opacity'] ) / 100;
				$container_styles['background-color'] = sprintf( 'rgba(%1$s,%2$s,%3$s,%4$s);', $rgb_array[0], $rgb_array[1], $rgb_array[2], $opacity );
			break;
			case 'image':
				$image_data = wp_get_attachment_image_src( $section_atts['background_image'], 'full' );
				$container_styles['background-image'] = sprintf( 'url(%1$s);', $image_data[0] );
			break;
		}

		if ( ! empty( $section_atts['padding_top'] ) ) {
			$container_styles['padding-top'] = $section_atts['padding_top'];
		}

		if ( ! empty( $section_atts['padding_bottom'] ) ) {
			$container_styles['padding-bottom'] = $section_atts['padding_bottom'];
		}

		cherry_site_shortcodes()->dynamic_css->add_style(
			sprintf( '#cherry-section-%1$s', $section_atts['id'] ),
			$container_styles
		);
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

}

Cherry_Section_Shortcode::get_instance();
