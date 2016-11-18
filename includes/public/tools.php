<?php
/**
 * Tools.
 *
 * @package   Cherry_Team
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class cherry-shortcodes tools.
 *
 * @since 1.0.0
 */
class Cherry_Shortcodes_Tools {

	function __construct() {}

	/**
	 * Hex to rgb converter.
	 *
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
		$rgb = array( $r, $g, $b );

		return $rgb;
	}

	/**
	 * Escaping for HTML classes.
	 *
	 * @since  1.0.0
	 * @param  array  $atts
	 * @param  string $class
	 * @return string
	 */
	public static function esc_class( $atts, $class = '' ) {
		$classes = array();

		if ( ! empty( $class ) ) {
			$classes[] = $class;
		}

		if ( ! empty( $atts['class'] ) ) {
			$classes[] = $atts['class'];
		}

		$classes = array_map( 'esc_attr', $classes );
		$classes = array_filter( $classes );

		return ! empty( $classes ) ? join( $classes, ' ' ) : '';
	}
}
