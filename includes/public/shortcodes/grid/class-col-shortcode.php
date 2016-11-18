<?php
/**
 * Cherry Col Shortcode.
 *
 * @package   Cherry_Team
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

/**
 * Class for Col shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Col_Shortcode {

	/**
	 * Shortcode name.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public static $name = 'cherry_col';

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
			'col-xs'        => '',
			'col-sm'        => '',
			'col-md'        => '',
			'col-lg'        => '',
			'col-xl'        => '',
			'col-xs-offset' => '',
			'col-sm-offset' => '',
			'col-md-offset' => '',
			'col-lg-offset' => '',
			'col-xl-offset' => '',
			'col-xs-push'   => '',
			'col-sm-push'   => '',
			'col-md-push'   => '',
			'col-lg-push'   => '',
			'col-xs-push'   => '',
			'col-xs-pull'   => '',
			'col-sm-pull'   => '',
			'col-md-pull'   => '',
			'col-lg-pull'   => '',
			'col-xl-pull'   => '',
		);

		/**
		 * Parse the arguments.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/shortcode_atts
		 */
		$atts = shortcode_atts( $defaults, $atts, $shortcode );

		$classes = array();

		foreach ( $atts as $key => $value ) {
			if ( ! empty( $value ) ) {
				$classes[] = $key . '-' . $value;
			}
		}

		$classes_attr = ( ! empty( $classes ) ) ? implode( ' ', $classes ) : '';

		$html = sprintf(
			'<div class="%1$s">%2$s</div>',
			esc_attr( $classes_attr ),
			do_shortcode( $content )
		);

		return $html;
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

Cherry_Col_Shortcode::get_instance();
