<?php
/**
 * Cherry svg image Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for svg image shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Svg_Image_Shortcode extends Cherry_Main_Shortcode {

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
		$this->name = 'svg_image';

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
			'title'       => esc_html__( 'SVG Image', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used to display the SVG image', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-image"></span>',
			'slug'        => 'cherry_svg_image',
			'enclosing'   => false,
			'options'     => array(
				'image' => array(
					'type'               => 'media',
					'title'              => esc_html__( 'Image', 'cherry-site-shortcodes' ),
					'description'        => esc_html__( 'Select icon image using media library', 'cherry-site-shortcodes' ),
					'value'              => '',
					'multi_upload'       => false,
					'library_type'       => 'image',
					'upload_button_text' => esc_html__( 'Choose image', 'cherry-site-shortcodes' ),
				),
				'class' => array(
					'type'        => 'text',
					'title'       => esc_html__( 'Custom class', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Assign cusstom class for image', 'cherry-site-shortcodes' ),
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
			'id'      => uniqid(),
			'image'   => '',
			'class'   => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();
		$class      = $css_prefix . 'svg-image';
		$classes    = array( 'svg-image' );

		$svg_image = Cherry_Site_Tools::get_svg_by_attachment_id( $atts['image'] );

		$result = sprintf(
			'<div id="%1$s" class="%2$s">%3$s</div>',
			esc_attr( $css_prefix . 'svg-image'. $atts['id'] ),
			Cherry_Site_Tools::esc_class( $classes, $atts ),
			$svg_image
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

Cherry_Svg_Image_Shortcode::get_instance();
