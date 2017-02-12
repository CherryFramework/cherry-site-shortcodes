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
	);

	/**
	 * Constructor method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->name = 'col';

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
			'title'       => esc_html__( 'Column', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used for inserting grid column', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
			'slug'        => 'cherry_col',
			'enclosing'   => true,
			'options'     => $this->get_column_shortcode_settings(),
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
			'class'         => '',
		);

		$atts = $this->shortcode_atts( $defaults, $atts );

		$css_prefix = $this->get_css_prefix();
		$classes    = array( $css_prefix . 'col' );

		foreach ( $this->col_class as $key ) {
			if ( ! empty( $atts[ $key ] ) || 'skip' !== $atts[ $key ] ) {
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
	 * Define column shortcode option fields.
	 *
	 * @return array
	 */
	public function get_column_shortcode_settings() {
		$column_shortcode_settings = array(
			'device_layout_column' => array(
				'type'        => 'component-tab-horizontal',
				'title'       => esc_html__( 'Column layouts', 'cherry-site-shortcodes' ),
				'description' => esc_html__( 'Define columns mobile-first flexbox grid system for building layouts.', 'cherry-site-shortcodes' ),
			),
			'mobile_layout_column' => array(
				'type'        => 'settings',
				'parent'      => 'device_layout_column',
				'title'       => esc_html__( 'Mobile', 'cherry-site-shortcodes' ),
				'description' => esc_html__( 'Define column for mobile layout', 'cherry-site-shortcodes' ),
			),
			'tablet_layout_column' => array(
				'type'        => 'settings',
				'parent'      => 'device_layout_column',
				'title'       => esc_html__( 'Tablet', 'cherry-site-shortcodes' ),
				'description' => esc_html__( 'Define column for tablet layout', 'cherry-site-shortcodes' ),
			),
			'laptop_layout_column' => array(
				'type'        => 'settings',
				'parent'      => 'device_layout_column',
				'title'       => esc_html__( 'Laptop', 'cherry-site-shortcodes' ),
				'description' => esc_html__( 'Define column for laptop layout', 'cherry-site-shortcodes' ),
			),
			'desktop_layout_column' => array(
				'type'        => 'settings',
				'parent'      => 'device_layout_column',
				'title'       => esc_html__( 'Desktop', 'cherry-site-shortcodes' ),
				'description' => esc_html__( 'Define column for desktop layout', 'cherry-site-shortcodes' ),
			),
			'col-xs' => array(
				'type'             => 'select',
				'parent'           => 'mobile_layout_column',
				'title'            => esc_html__( 'Extra small mobile column layout', 'cherry-site-shortcodes' ),
				'description'      => esc_html__( 'Select column layout for extra small devices', 'cherry-site-shortcodes' ),
				'multiple'         => false,
				'filter'           => true,
				'value'            => array( '' ),
				'options'          => $this->get_device_column_cases(),
				'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
			),
			'col-sm' => array(
				'type'             => 'select',
				'parent'           => 'mobile_layout_column',
				'title'            => esc_html__( 'Small mobile column layout', 'cherry-site-shortcodes' ),
				'description'      => esc_html__( 'Select column layout for small devices', 'cherry-site-shortcodes' ),
				'multiple'         => false,
				'filter'           => true,
				'value'            => array( '' ),
				'options'          => $this->get_device_column_cases(),
				'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
			),
			'col-md' => array(
				'type'             => 'select',
				'parent'           => 'tablet_layout_column',
				'title'            => esc_html__( 'Tablet column layout', 'cherry-site-shortcodes' ),
				'description'      => esc_html__( 'Select column layout for medium devices', 'cherry-site-shortcodes' ),
				'multiple'         => false,
				'filter'           => true,
				'value'            => array( '' ),
				'options'          => $this->get_device_column_cases(),
				'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
			),
			'col-lg' => array(
				'type'             => 'select',
				'parent'           => 'laptop_layout_column',
				'title'            => esc_html__( 'Laptop column layout', 'cherry-site-shortcodes' ),
				'description'      => esc_html__( 'Select column layout for large devices', 'cherry-site-shortcodes' ),
				'multiple'         => false,
				'filter'           => true,
				'value'            => array( '' ),
				'options'          => $this->get_device_column_cases(),
				'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
			),
			'col-xl' => array(
				'type'             => 'select',
				'parent'           => 'desktop_layout_column',
				'title'            => esc_html__( 'Desktop column layout', 'cherry-site-shortcodes' ),
				'description'      => esc_html__( 'Select column layout for extra large devices', 'cherry-site-shortcodes' ),
				'multiple'         => false,
				'filter'           => true,
				'value'            => array( '' ),
				'options'          => $this->get_device_column_cases(),
				'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
			),
			'class' => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Custom class', 'cherry-site-shortcodes' ),
				'description' => esc_html__( 'Assign custom class to the column', 'cherry-site-shortcodes' ),
				'value'       => '',
				'placeholder' => esc_html__( 'Input class', 'cherry-site-shortcodes' ),
				'class'       => '',
				'label'       => '',
			),
		);

		return $column_shortcode_settings;
	}

	/**
	 * Get device column cases.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public function get_device_column_cases() {
		return array(
			'skip' => esc_html__( 'Skip', 'cherry-site-shortcodes' ),
			'1'    => esc_html__( '1 grid of 12', 'cherry-site-shortcodes' ),
			'2'    => esc_html__( '2 grid of 12', 'cherry-site-shortcodes' ),
			'3'    => esc_html__( '3 grid of 12', 'cherry-site-shortcodes' ),
			'4'    => esc_html__( '4 grid of 12', 'cherry-site-shortcodes' ),
			'5'    => esc_html__( '5 grid of 12', 'cherry-site-shortcodes' ),
			'6'    => esc_html__( '6 grid of 12', 'cherry-site-shortcodes' ),
			'7'    => esc_html__( '7 grid of 12', 'cherry-site-shortcodes' ),
			'8'    => esc_html__( '8 grid of 12', 'cherry-site-shortcodes' ),
			'9'    => esc_html__( '9 grid of 12', 'cherry-site-shortcodes' ),
			'10'   => esc_html__( '10 grid of 12', 'cherry-site-shortcodes' ),
			'11'   => esc_html__( '11 grid of 12', 'cherry-site-shortcodes' ),
			'12'   => esc_html__( 'Fullwidth column', 'cherry-site-shortcodes' ),
		);
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
