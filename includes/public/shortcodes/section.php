<?php
/**
 * Cherry Section Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Section shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Section_Shortcode extends Cherry_Main_Shortcode {

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
		$this->name = 'section';

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
			'title'       => esc_html__( 'Section', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used to display the content section', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-align-center"></span>',
			'slug'        => 'cherry_section',
			'enclosing'   => true,
			'options'     => array(
				'background_type' => array(
					'type'          => 'radio',
					'title'         => esc_html__( 'Background type', 'cherry-site-shortcodes' ),
					'description'   => esc_html__( 'Choose background type for section', 'cherry-site-shortcodes' ),
					'value'         => 'fill-color',
					'display_input' => false,
					'options'       => array(
						'fill-color' => array(
							'label' => esc_html__( 'Fill color', 'cherry-site-shortcodes' ),
						),
						'image' => array(
							'label' => esc_html__( 'Image', 'cherry-site-shortcodes' ),
						),
					),
				),
				'background_color' => array(
					'type'        => 'colorpicker',
					'title'       => esc_html__( 'Background fill color', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Description color picker.', 'cherry-site-shortcodes' ),
					'value'       => '',
				),
				'background_opacity' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Background opacity', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for background opacity(Fill color mode)', 'cherry-site-shortcodes' ),
					'max_value'   => 100,
					'min_value'   => 0,
					'value'       => 100,
				),
				'background_image' => array(
					'type'               => 'media',
					'title'              => esc_html__( 'Background image', 'cherry-site-shortcodes' ),
					'description'        => esc_html__( 'Select background image using media library', 'cherry-site-shortcodes' ),
					'value'              => '',
					'multi_upload'       => false,
					'library_type'       => 'image',
					'upload_button_text' => esc_html__( 'Choose image', 'cherry-site-shortcodes' ),
				),
				'background_size' => array(
					'type'          => 'radio',
					'title'         => esc_html__( 'Background size', 'cherry-site-shortcodes' ),
					'description'   => esc_html__( 'Choose background size for section image background', 'cherry-site-shortcodes' ),
					'value'         => 'cover',
					'display_input' => false,
					'options'       => array(
						'cover' => array(
							'label' => esc_html__( 'Cover', 'cherry-site-shortcodes' ),
						),
						'cover-left' => array(
							'label' => esc_html__( 'Cover left', 'cherry-site-shortcodes' ),
						),
						'cover-right' => array(
							'label' => esc_html__( 'Cover right', 'cherry-site-shortcodes' ),
						),
					),
				),
				'padding_top' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Padding top', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for padding-top property', 'cherry-site-shortcodes' ),
					'max_value'   => 500,
					'min_value'   => 0,
					'value'       => 0,
				),
				'padding_bottom' => array(
					'type'        => 'slider',
					'title'       => esc_html__( 'Padding bottom', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Select value for padding-bottom property', 'cherry-site-shortcodes' ),
					'max_value'   => 500,
					'min_value'   => 0,
					'value'       => 0,
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
			'id'                 => uniqid(),
			'background_type'    => 'fill-color',
			'background_color'   => '',
			'background_opacity' => '100',
			'background_image'   => '',
			'background_size'    => 'cover',
			'padding_top'        => '',
			'padding_bottom'     => '',
			'class'              => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();
		$classes    = array( 'section', 'section--' . $atts['background_size'] );

		$result = sprintf(
			'<section id="%2$ssection-%1$s" class="%3$s">%4$s</section>',
			esc_attr( $atts['id'] ),
			esc_attr( $css_prefix ),
			Cherry_Site_Tools::esc_class( $classes, $atts ),
			do_shortcode( $content )
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
		$styles = array();

		switch ( $atts['background_type'] ) {
			case 'fill-color':

				if ( ! empty( $atts['background_color'] ) ) {
					$rgb     = Cherry_Site_Tools::hex_to_rgb( $atts['background_color'] );
					$opacity = intval( $atts['background_opacity'] ) / 100;
					$styles['background-color'] = sprintf( 'rgba(%1$s, %2$s, %3$s, %4$s);', $rgb[0], $rgb[1], $rgb[2], $opacity );
				}
				break;

			case 'image':

				if ( ! empty( $atts['background_image'] ) ) {
					$image = wp_get_attachment_image_src( $atts['background_image'], 'full' );
					$styles['background-image'] = sprintf( 'url(%1$s);', esc_url( $image[0] ) );
				}
				break;

			default:
				break;
		}

		if ( ! empty( $atts['padding_top'] ) ) {
			$styles['padding-top'] = $atts['padding_top'] . 'px';
		}

		if ( ! empty( $atts['padding_bottom'] ) ) {
			$styles['padding-bottom'] = $atts['padding_bottom'] . 'px';
		}

		if ( empty( $styles ) || ! is_array( $styles ) ) {
			return;
		}

		cherry_site_shortcodes()->dynamic_css->add_style(
			sprintf( '#cherry-section-%1$s', $atts['id'] ),
			$styles
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

Cherry_Section_Shortcode::get_instance();
