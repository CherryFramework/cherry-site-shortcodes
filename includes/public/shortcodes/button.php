<?php
/**
 * Cherry Button Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Button shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Button_Shortcode extends Cherry_Main_Shortcode {

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
		$this->name = 'button';

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
			'title'       => esc_html__( 'Button', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used to display the button', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-admin-links"></span>',
			'slug'        => 'cherry_button',
			'enclosing'   => true,
			'options'     => array(
				'href' => array(
					'type'        => 'text',
					'title'       => esc_html__( 'Icon link href', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Assign link href', 'cherry-site-shortcodes' ),
					'value'       => '#',
					'placeholder' => esc_html__( 'Input href', 'cherry-site-shortcodes' ),
					'class'       => '',
				),
				'icon' => array(
					'type'        => 'iconpicker',
					'parent'      => 'ui_elements',
					'title'       => esc_html__( 'Icon Picker', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Description icon picker.', 'cherry-site-shortcodes' ),
					'value'       => 'fa-wordpress',
					'icon_data'   => array(
						'icon_set'    => 'cherryWidgetFontAwesome',
						'icon_css'    => esc_url( CHERRY_SITE_SHORTCODES_URI . 'assets/css/font-awesome.min.css' ),
						'icon_base'   => 'fa',
						'icon_prefix' => 'fa-',
						'icons'       => $this->get_icons_set(),
					),
				),
				'icon_position' => array(
					'type'          => 'select',
					'title'         => esc_html__( 'Icon position', 'cherry-site-shortcodes' ),
					'description'   => esc_html__( 'Select icon position', 'cherry-site-shortcodes' ),
					'filter'        => true,
					'value'         => 'left',
					'options'       => array(
						'left'  => esc_html__( 'Left', 'cherry-site-shortcodes' ),
						'right' => esc_html__( 'Right', 'cherry-site-shortcodes' ),
					),
					'placeholder'   => esc_html__( 'Select position', 'cherry-site-shortcodes' ),
				),
				'class' => array(
					'type'        => 'text',
					'title'       => esc_html__( 'Custom class', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Assign cusstom class for icon', 'cherry-site-shortcodes' ),
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
			'href'          => '#',
			'icon'          => '',
			'icon_position' => 'left',
			'class'         => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();
		$icon       = '';
		$classes    = array( 'button' );

		if ( ! empty( $atts['icon'] ) ) {

			$classes[] = 'button--icon-' . $atts['icon_position'];
			$icon = sprintf(
				'<span class="%2$sbutton__icon %1$s"></span>',
				esc_attr( 'fa ' . $atts['icon'] ),
				esc_attr( $css_prefix )
			);
		}

		$format = '<a href="%1$s" class="%2$s">%3$s<span class="%4$sbutton__text">%5$s</span></a>';

		if ( 'right' == $atts['icon_position'] ) {
			$format = '<a href="%1$s" class="%2$s"><span class="%4$sbutton__text">%5$s</span>%3$s</a>';
		}

		$result = sprintf(
			$format,
			esc_url( $atts['href'] ),
			Cherry_Site_Tools::esc_class( $classes, $atts ),
			$icon,
			esc_attr( $css_prefix ),
			do_shortcode( $content )
		);

		return apply_filters( 'cherry_shortcode_result', $result, $atts, $shortcode );
	}

	/**
	 * Get icons set
	 *
	 * @return array
	 */
	private function get_icons_set() {
		ob_start();

		include CHERRY_SITE_SHORTCODES_DIR . 'assets/fonts/icons.json';

		$json = ob_get_clean();
		$result = array();
		$icons = json_decode( $json, true );

		foreach ( $icons['icons'] as $icon ) {
			$result[] = $icon['id'];
		}

		return $result;
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

Cherry_Button_Shortcode::get_instance();
