<?php
/**
 * Cherry Main Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Main shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Main_Shortcode {

	/**
	 * Shortcode name.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $name;

	/**
	 * The array of shortcodes registered with plugin.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public static $shortcodes = array();

	/**
	 * Constructor method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_shortcode' ) );
	}

	/**
	 * Register shortcode.
	 *
	 * @since 1.0.0
	 */
	public function register_shortcode() {
		$prefix = $this->get_tag_prefix();
		$name   = $this->get_name();
		$tag    = $prefix . $name;

		if ( ! empty( $name ) && ! in_array( $tag, self::$shortcodes ) ) {

			add_shortcode( $tag, array( $this, 'do_shortcode' ) );
			self::$shortcodes[] = $name;
		}
	}

	/**
	 * The shortcode callback function.
	 *
	 * @since  1.0.0
	 * @param  array  $atts      The user-inputted arguments.
	 * @param  string $content   The enclosed content (if the shortcode is used in its enclosing form).
	 * @param  string $shortcode The shortcode tag.
	 * @return string
	 */
	public function do_shortcode( $atts, $content = null, $shortcode ) {
		return '';
	}

	/**
	 * Parse the shortcode arguments.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
	 *
	 * @since  1.0.0
	 * @param  array $defaults
	 * @param  array $atts
	 * @return array
	 */
	public function shortcode_atts( $defaults, $atts ) {
		$name     = $this->get_name();
		$defaults = apply_filters( $name . '_shortcode_defaults', $defaults );

		/**
		 * Parse the arguments.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
		 */
		return shortcode_atts( $defaults, $atts, $name );
	}

	/**
	 * Retrieve a shortcode tag prefix.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public static function get_tag_prefix() {
		/**
		 * Filters a shortcode prefix.
		 *
		 * @since 1.0.0
		 * @param string $prefix
		 */
		return apply_filters( 'cherry_site_shortcodes_tag_prefix', 'cherry_' );
	}

	/**
	 * Retrieve a prefix for CSS-class.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public static function get_css_prefix() {
		$prefix     = self::get_tag_prefix();
		$css_prefix = str_replace( '_', '-', $prefix );

		/**
		 * Filters a prefix for CSS-class.
		 *
		 * @since 1.0.0
		 * @param string $css_prefix
		 */
		return apply_filters( 'cherry_site_shortcodes_css_prefix', $css_prefix );
	}

	/**
	 * Retrieve a shortcode name.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_name() {
		/**
		 * Filters a shortcode name.
		 *
		 * @since 1.0.0
		 * @param string $this->name Shortcode name.
		 */
		return apply_filters( $this->name . '_shortcode_name', $this->name );
	}
}
