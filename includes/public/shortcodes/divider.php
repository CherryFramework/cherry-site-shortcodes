<?php
/**
 * Cherry Divider Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Divider shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Divider_Shortcode extends Cherry_Main_Shortcode {

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
		$this->name = 'divider';

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
		cherry_shortcodes_admin()->base_shortcodes_settings[] = array(
			'title'       => esc_html__( 'Divider', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used to display the divider', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-minus"></span>',
			'slug'        => 'cherry_divider',
			'enclosing'   => false,
			'options'     => array(
				'width' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Divider width', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for divider width(%)', 'cherry-site-shortcodes' ),
					'max_value'   => 100,
					'min_value'   => 0,
					'value'       => 100,
				),
				'height' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Divider height', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for divider height(px)', 'cherry-site-shortcodes' ),
					'max_value'   => 100,
					'min_value'   => 1,
					'value'       => 1,
				),
				'style' => array(
					'type'          => 'select',
					'title'         => esc_html__( 'Border Style', 'cherry-site-shortcodes' ),
					'description'   => esc_html__( 'Select border style(css border styles)', 'cherry-site-shortcodes' ),
					'filter'        => true,
					'value'         => 'solid',
					'options'       => array(
						'solid'  => esc_html__( 'Solid', 'cherry-site-shortcodes' ),
						'dotted' => esc_html__( 'Dotted', 'cherry-site-shortcodes' ),
						'dashed' => esc_html__( 'Dashed', 'cherry-site-shortcodes' ),
						'double' => esc_html__( 'Double', 'cherry-site-shortcodes' ),
						'groove' => esc_html__( 'Groove', 'cherry-site-shortcodes' ),
						'ridge'  => esc_html__( 'Ridge', 'cherry-site-shortcodes' ),
						'inset'  => esc_html__( 'Inset', 'cherry-site-shortcodes' ),
						'outset' => esc_html__( 'Outset', 'cherry-site-shortcodes' ),
					),
					'placeholder'   => esc_html__( 'Select style', 'cherry-site-shortcodes' ),
				),
				'color' => array(
					'type'        => 'colorpicker',
					'title'       => esc_html__( 'Border color', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Define color for divider', 'cherry-site-shortcodes' ),
					'value'       => '#000',
				),
				'opacity' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Divider opacity', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for divider opacity(%)', 'cherry-site-shortcodes' ),
					'max_value'   => 100,
					'min_value'   => 0,
					'value'       => 100,
				),
				'padding_top' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Divider top padding', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for divider top padding(px)', 'cherry-site-shortcodes' ),
					'max_value'   => 500,
					'min_value'   => 0,
					'value'       => 25,
				),
				'padding_bottom' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Divider bottom padding', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for divider bottom padding(px)', 'cherry-site-shortcodes' ),
					'max_value'   => 500,
					'min_value'   => 0,
					'value'       => 25,
				),
				'class' => array(
					'type'        => 'text',
					'title'       => esc_html__( 'Custom class', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Assign cusstom class for for section', 'cherry-site-shortcodes' ),
					'value'       => '',
					'placeholder' => esc_html__( 'Input class', 'cherry-site-shortcodes' ),
					'class'       => '',
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
			'id'             => uniqid(),
			'width'          => '',
			'height'         => '',
			'style'          => '',
			'color'          => '',
			'opacity'        => '',
			'padding_top'    => '25',
			'padding_bottom' => '25',
			'class'          => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();

		$result = sprintf(
			'<div id="%1$s" class="%2$s"><span class="%3$s__item"></span></div>',
			esc_attr( $css_prefix . 'divider-' . $atts['id'] ),
			Cherry_Site_Tools::esc_class( array( 'divider' ), $atts ),
			esc_attr( 'cherry-divider' )
		);

		$this->generate_dynamic_styles( $atts );

		return apply_filters( 'cherry_shortcode_result', $result, $atts, $shortcode );
	}

	/**
	 * Generate dynamic CSS styles for shortcode instance.
	 *
	 * @since  1.0.0
	 * @param  array $atts
	 * @return void
	 */
	public function generate_dynamic_styles( $atts ) {
		$css_prefix = $this->get_css_prefix();
		$styles     = array();

		if ( ! empty( $atts['padding_top'] ) ) {
			$styles['padding-top'] = $atts['padding_top'] . 'px';
		}

		if ( ! empty( $atts['padding_bottom'] ) ) {
			$styles['padding-bottom'] = $atts['padding_bottom'] . 'px';
		}

		if ( ! empty( $styles ) && is_array( $styles ) ) {
			cherry_site_shortcodes()->dynamic_css->add_style(
				esc_attr( '#' . $css_prefix . 'divider-'. $atts['id'] ),
				$styles
			);
		}

		// Clear.
		$styles = array();

		if ( ! empty( $atts['width'] ) ) {
			$styles['width'] = $atts['width'] . '%';
		}

		if ( ! empty( $atts['style'] ) ) {
			$styles['border-top-style'] = $atts['style'];
		}

		if ( ! empty( $atts['height'] ) ) {
			$styles['border-top-width'] = $atts['height'] . 'px';
		}

		if ( ! empty( $atts['color'] ) ) {
			$rgb     = Cherry_Site_Tools::hex_to_rgb( $atts['color'] );
			$opacity = intval( $atts['opacity'] ) / 100;
			$styles['border-top-color'] = sprintf( 'rgba(%1$s, %2$s, %3$s, %4$s);', $rgb[0], $rgb[1], $rgb[2], $opacity );
		}

		if ( ! empty( $styles ) && is_array( $styles ) ) {
			cherry_site_shortcodes()->dynamic_css->add_style(
				esc_attr( '#' . $css_prefix . 'divider-' . $atts['id'] . ' .'. $css_prefix . 'divider__item' ),
				$styles
			);
		}
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

Cherry_Divider_Shortcode::get_instance();
