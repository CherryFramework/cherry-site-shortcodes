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
		$this->name = 'row';

		parent::__construct();

		if ( is_admin() ) {
			add_action( 'after_setup_theme', array( $this, 'shortcode_registration' ), 9 );
		}
	}

	/**
	 * Define fields settings.
	 *
	 * @return viod
	 */
	public function shortcode_registration() {
		cherry_shortcodes_admin()->grid_shortcodes_settings[] = array(
			'title'       => esc_html__( 'Row', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used for inserting row wrapper', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
			'slug'        => 'cherry_row',
			'enclosing'   => true,
			'options'     => array(
				'full_width' => array(
					'type'         => 'switcher',
					'title'        => esc_html__( 'Make this row fullwidth', 'cherry-site-shortcodes' ),
					'description'  => esc_html__( 'Enable this option to extend the width of this row to the edge of the browser window.', 'cherry-site-shortcodes' ),
					'value'        => 'false',
				),
				'class' => array(
					'type'        => 'text',
					'title'       => esc_html__( 'Custom class', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Assign custom class to the row', 'cherry-site-shortcodes' ),
					'value'       => '',
					'placeholder' => esc_html__( 'Input class', 'cherry-site-shortcodes' ),
					'class'       => '',
					'label'       => '',
				),
			),
		);
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
			$format = '<div class="%1$s">%2$s</div>';
		} else {
			$format = '<div class="container"><div class="%1$s">%2$s</div></div>';
		}

		$result = sprintf(
			$format,
			Cherry_Site_Tools::esc_class( array( 'row' ), $atts, false ),
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

Cherry_Row_Shortcode::get_instance();
