<?php
/**
 * Cherry Button Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Button shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Button_Shortcode extends Cherry_Main_Shortcode {

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
		$this->name = 'button';

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
			'href'          => '#',
			'icon'          => '',
			'icon_position' => 'left',
			'class'         => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();
		$icon       = '';
		$classes    = array( 'button' );

		if ( ! empty( $atts['icon'] ) ) {

			$classes[] = 'button--icon-' . $atts['icon_position'];
			$icon = sprintf(
				'<span class="%2$sbutton__icon %1$s"></span>',
				esc_attr( $atts['icon'] ),
				esc_attr( $css_prefix )
			);
		}

		$format = '<a href="%1$s" class="%2$s">%3$s<span class="%4$sbutton__text">%5$s</span></a>';

		if ( 'right' == $atts['icon_position'] ) {
			$format = '<a href="%1$s" class="%2$s"><span class="%4$sbutton__text">%5$s</span>%3$s</a>';
		}

		$result = sprintf(
			$format,
			esc_url( $atts['href'] ),
			Cherry_Site_Tools::esc_class( $classes, $atts ),
			$icon,
			esc_attr( $css_prefix ),
			do_shortcode( $content )
		);

		return apply_filters( 'cherry_shortcode_result', $result, $atts, $shortcode );
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

Cherry_Button_Shortcode::get_instance();
