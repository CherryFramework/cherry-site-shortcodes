<?php
/**
 * Cherry Button Shortcode.
 *
 * @package   Cherry_Team
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

/**
 * Class for Button shortcode.
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
	 * Shortcodes.
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
		$name = $this->get_name();

		if ( ! empty( $name ) && ! in_array( $name, self::$shortcodes ) ) {

			add_shortcode( $name, array( $this, 'do_shortcode' ) );
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
