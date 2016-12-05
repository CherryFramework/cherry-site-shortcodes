<?php
/**
 * Cherry Col Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Col shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Col_Shortcode extends Cherry_Main_Shortcode {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Avaliable col classes.
	 *
	 * @var array
	 */
	private $col_class = array(
		'col-xs',
		'col-sm',
		'col-md',
		'col-lg',
		'col-xl',
		'col-xs-offset',
		'col-sm-offset',
		'col-md-offset',
		'col-lg-offset',
		'col-xl-offset',
		'col-xs-push',
		'col-sm-push',
		'col-md-push',
		'col-lg-push',
		'col-xs-push',
		'col-xs-pull',
		'col-sm-pull',
		'col-md-pull',
		'col-lg-pull',
		'col-xl-pull',
	);

	/**
	 * Constructor method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->name = 'col';

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
			'class'         => '',
		);

		$atts = $this->shortcode_atts( $defaults, $atts );

		$css_prefix = $this->get_css_prefix();
		$classes    = array( $css_prefix . 'col' );

		foreach ( $this->col_class as $key ) {
			if ( ! empty( $atts[ $key ] ) ) {
				$classes[] = $key . '-' . $atts[ $key ];
			}
		}

		$result = sprintf(
			'<div class="%1$s">%2$s</div>',
			Cherry_Site_Tools::esc_class( $classes, $atts, false ),
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

Cherry_Col_Shortcode::get_instance();
