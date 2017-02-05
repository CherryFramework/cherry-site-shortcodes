<?php
/**
 * Cherry Section Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Section shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Section_Shortcode extends Cherry_Main_Shortcode {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Constructor method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->name = 'section';

		parent::__construct();
	}

	/**
	 * The shortcode callback function.
	 *
	 * @since  1.0.0
	 * @param  array  $atts
	 * @param  string $content
	 * @param  string $shortcode
	 * @return string
	 */
	public function do_shortcode( $atts, $content = null, $shortcode ) {

		// Set up the default arguments.
		$defaults = array(
			'id'                 => uniqid(),
			'background_type'    => 'fill-color',
			'background_color'   => '',
			'background_opacity' => '100',
			'background_image'   => '',
			'background_size'    => 'cover',
			'padding_top'        => '',
			'padding_bottom'     => '',
			'class'              => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();
		$classes    = array( 'section', 'section--' . $atts['background_size'] );

		$result = sprintf(
			'<section id="%2$ssection-%1$s" class="%3$s">%4$s</section>',
			esc_attr( $atts['id'] ),
			esc_attr( $css_prefix ),
			Cherry_Site_Tools::esc_class( $classes, $atts ),
			do_shortcode( $content )
		);

		$this->generate_dynamic_styles( $atts );

		return apply_filters( 'cherry_shortcode_result', $result, $atts, $shortcode );
	}

	/**
	 * Generate dynamic CSS styles for shortcode instance.
	 *
	 * @since  1.0.0
	 * @param  array $atts
	 * @return void
	 */
	public function generate_dynamic_styles( $atts ) {
		$styles = array();

		switch ( $atts['background_type'] ) {
			case 'fill-color':

				if ( ! empty( $atts['background_color'] ) ) {
					$rgb     = Cherry_Site_Tools::hex_to_rgb( $atts['background_color'] );
					$opacity = intval( $atts['background_opacity'] ) / 100;
					$styles['background-color'] = sprintf( 'rgba(%1$s, %2$s, %3$s, %4$s);', $rgb[0], $rgb[1], $rgb[2], $opacity );
				}
				break;

			case 'image':

				if ( ! empty( $atts['background_image'] ) ) {
					$image = wp_get_attachment_image_src( $atts['background_image'], 'full' );
					$styles['background-image'] = sprintf( 'url(%1$s);', esc_url( $image[0] ) );
				}
				break;

			default:
				break;
		}

		if ( ! empty( $atts['padding_top'] ) ) {
			$styles['padding-top'] = $atts['padding_top'] . 'px';
		}

		if ( ! empty( $atts['padding_bottom'] ) ) {
			$styles['padding-bottom'] = $atts['padding_bottom'] . 'px';
		}

		if ( empty( $styles ) || ! is_array( $styles ) ) {
			return;
		}

		cherry_site_shortcodes()->dynamic_css->add_style(
			sprintf( '#cherry-section-%1$s', $atts['id'] ),
			$styles
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
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

Cherry_Section_Shortcode::get_instance();
