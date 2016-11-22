<?php
/**
 * Plugin Tools.
 *
 * @package    Cherry_Site_Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Cherry_Site_Tools.
 *
 * @since 1.0.0
 */
class Cherry_Site_Tools {

	public function __construct() {}

	/**
	 * Hex to rgb converter.
	 *
	 * @since  1.0.0
	 * @param  string $hex Hex color.
	 * @return array
	 */
	public static function hex_to_rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );

		if ( 3 == strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		return array( $r, $g, $b );
	}

	/**
	 * Escaping for HTML classes.
	 *
	 * @since  1.0.0
	 * @param  array  $atts
	 * @param  string $class
	 * @return string
	 */
	public static function esc_class( $classes, $atts = array(), $prefixed = true ) {

		if ( $prefixed ) {
			array_walk( $classes, array( 'self', '_add_css_prefix' ) );
		}

		if ( ! empty( $atts['class'] ) ) {
			$classes[] = $atts['class'];
		}

		$classes = array_map( 'esc_attr', $classes );
		$classes = array_filter( $classes );

		return ! empty( $classes ) ? join( $classes, ' ' ) : '';
	}

	/**
	 * Callback-function that add prefix for CSS classes.
	 *
	 * @since 1.0.0
	 * @param string &$class
	 * @param int    $index
	 */
	public static function _add_css_prefix( &$class, $index ) {
		$class = Cherry_Main_Shortcode::get_css_prefix() . $class;
	}
}
