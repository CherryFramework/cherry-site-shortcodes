<?php
/**
 * Cherry Icon Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Icon shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Icon_Shortcode extends Cherry_Main_Shortcode {

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
		$this->name = 'icon';

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
			'id'      => uniqid(),
			'icon'    => 'fa fa-wordpress',
			'image'   => '',
			'size'    => '',
			'color'   => '',
			'opacity' => '',
			'href'    => '#',
			'padding' => '',
			'class'   => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();
		$class      = $css_prefix . 'icon';
		$classes    = array( 'icon' );

		$icon = sprintf(
			'<span class="%1$s__symbol %2$s"></span>',
			esc_attr( $class ),
			$atts['icon']
		);

		if ( ! empty( $atts['image'] ) ) {
			$image = wp_get_attachment_image_src( $atts['image'], 'full' );

			$icon = sprintf(
			'<img class="%1$s__image" src="%2$s" alt="">',
				esc_attr( $class ),
				esc_url( $image[0] )
			);

			$classes[] = 'icon--image';
		}

		$format = '<div id="%1$s" class="%2$s"><a href="%4$s" class="%3$s__link">%5$s</a></div>';

		if ( empty( $atts['href'] ) ) {
			$format = '<div id="%1$s" class="%2$s">%5$s</div>';
		}

		$result = sprintf(
			$format,
			esc_attr( $css_prefix . 'icon-'. $atts['id'] ),
			Cherry_Site_Tools::esc_class( $classes, $atts ),
			esc_attr( $class ),
			esc_url( $atts['href'] ),
			$icon
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
		$css_prefix  = $this->get_css_prefix();
		$styles      = array();
		$icon_styles = array();

		if ( ! empty( $atts['padding'] ) ) {
			$divider_styles['padding'] = $atts['padding'];
		}

		if ( ! empty( $atts['color'] ) ) {
			$rgb     = Cherry_Site_Tools::hex_to_rgb( $atts['color'] );
			$opacity = intval( $atts['opacity'] ) / 100;
			$styles['color'] = sprintf( 'rgba(%1$s, %2$s, %3$s, %4$s);', $rgb[0], $rgb[1], $rgb[2], $opacity );
		}

		if ( ! empty( $styles ) && is_array( $styles ) ) {

			$selector = '#' . $css_prefix . 'icon-' . $atts['id'];

			if ( ! empty( $atts['href'] ) ) {
				$selector .= ' .' . $css_prefix . 'icon__link';
			}

			cherry_site_shortcodes()->dynamic_css->add_style(
				esc_attr( $selector ),
				$styles
			);
		}

		if ( ! empty( $atts['size'] ) ) {
			$icon_styles['font-size'] = $atts['size'];
		}

		if ( ! empty( $icon_styles ) && is_array( $icon_styles ) ) {
			cherry_site_shortcodes()->dynamic_css->add_style(
				esc_attr( '#' . $css_prefix . 'icon-'. $atts['id'] . ' .' . $css_prefix . 'icon__symbol' ),
				$icon_styles
			);
		}
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

Cherry_Icon_Shortcode::get_instance();
