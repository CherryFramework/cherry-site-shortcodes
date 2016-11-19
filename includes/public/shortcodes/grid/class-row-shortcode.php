<?php
/**
 * Cherry Row Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Row shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Row_Shortcode extends Cherry_Main_Shortcode {

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
		$this->name = 'cherry_row';

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
			'full_width' => 'no',
			'class'      => '',
		);

		$atts = $this->shortcode_atts( $defaults, $atts );

		if ( filter_var( $atts['full_width'], FILTER_VALIDATE_BOOLEAN ) ) {
			$result = sprintf(
				'<div class="%1$s">%2$s</div>',
				Cherry_Shortcodes_Tools::esc_class( array( 'row' ), $atts ),
				do_shortcode( $content )
			);

		} else {
			$result = sprintf(
				'<div class="container"><div class="%1$s">%2$s</div></div>',
				Cherry_Shortcodes_Tools::esc_class( array( 'row' ), $atts ),
				do_shortcode( $content )
			);
		}

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

Cherry_Row_Shortcode::get_instance();
