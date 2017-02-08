<?php
/**
 * Sets up the admin functionality for the plugin.
 *
 * @package   Cherry_Shortcodes_Admin
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2014 Cherry Team
 */

class Cherry_Shortcodes_Admin {

	/**
	 * Holds the instances of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Sets up needed actions/filters for the admin to initialize.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {

		// Shortcode insert module registration
		add_action( 'after_setup_theme', array( $this, 'shortcode_registration' ), 10 );
	}

	/**
	 * Shortcode registration
	 *
	 * @return void
	 */
	public function shortcode_registration() {
		cherry_site_shortcodes()->get_core()->init_module( 'cherry5-insert-shortcode', array() );

		//$utility = cherry_site_shortcodes()->get_core()->modules['cherry-utility']->utility;

		cherry5_register_shortcode(
				array(
					'title'       => esc_html__( 'General Shortcodes', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Base cherry shortcode collection', 'cherry-site-shortcodes' ),
					'icon'        => '<span class="dashicons dashicons-admin-generic"></span>',
					'slug'        => 'cherry-shortcodes',
					'shortcodes'  => array(

						array(
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
						),

					),
				)
			);

		// Grid Shortcodes list
		cherry5_register_shortcode(
				array(
					'title'       => esc_html__( 'Grid Shortcodes', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Grid cherry shortcode collection. Using BootStrap4 base grid', 'cherry-site-shortcodes' ),
					'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
					'slug'        => 'cherry-grid-shortcodes',
					'shortcodes'  => array(

						array(
							'title'       => esc_html__( 'Row', 'cherry-site-shortcodes' ),
							'description' => esc_html__( 'Shortcode is used for inserting row wrapper', 'cherry-site-shortcodes' ),
							'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
							'slug'        => 'cherry_row',
							'enclosing'   => true,
							'options'     => array(),
						),
						array(
							'title'       => esc_html__( 'Inner Row', 'cherry-site-shortcodes' ),
							'description' => esc_html__( 'Shortcode is used for inserting inner row wrapper', 'cherry-site-shortcodes' ),
							'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
							'slug'        => 'cherry_inner_row',
							'enclosing'   => true,
							'options'     => array(),
						),
						array(
							'title'       => esc_html__( 'Column', 'cherry-site-shortcodes' ),
							'description' => esc_html__( 'Shortcode is used for inserting grid column', 'cherry-site-shortcodes' ),
							'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
							'slug'        => 'cherry_col',
							'enclosing'   => true,
							'options'     => array(
								'col-xs' => array(
									'type'             => 'select',
									'title'            => esc_html__( 'Column xs layout', 'cherry-site-shortcodes' ),
									'description'      => esc_html__( 'Select column layout for extra small devices', 'cherry-site-shortcodes' ),
									'multiple'         => false,
									'filter'           => true,
									'value'            => array( '' ),
									'options_callback' => array( $this, 'get_device_column_cases' ),
									'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
								),
								'col-sm' => array(
									'type'             => 'select',
									'title'            => esc_html__( 'Column sm layout', 'cherry-site-shortcodes' ),
									'description'      => esc_html__( 'Select column layout for small devices', 'cherry-site-shortcodes' ),
									'multiple'         => false,
									'filter'           => true,
									'value'            => array( '' ),
									'options_callback' => array( $this, 'get_device_column_cases' ),
									'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
								),
								'col-md' => array(
									'type'             => 'select',
									'title'            => esc_html__( 'Column md layout', 'cherry-site-shortcodes' ),
									'description'      => esc_html__( 'Select column layout for medium devices', 'cherry-site-shortcodes' ),
									'multiple'         => false,
									'filter'           => true,
									'value'            => array( '' ),
									'options_callback' => array( $this, 'get_device_column_cases' ),
									'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
								),
								'col-lg' => array(
									'type'             => 'select',
									'title'            => esc_html__( 'Column lg layout', 'cherry-site-shortcodes' ),
									'description'      => esc_html__( 'Select column layout for large devices', 'cherry-site-shortcodes' ),
									'multiple'         => false,
									'filter'           => true,
									'value'            => array( '' ),
									'options_callback' => array( $this, 'get_device_column_cases' ),
									'placeholder'      => esc_html__( 'Select value', 'cherry-site-shortcodes' ),
								),
								'col-xl' => array(
									'type'             => 'select',
									'title'            => esc_html__( 'Column xl layout', 'cherry-site-shortcodes' ),
									'description'      => esc_html__( 'Select column layout for extra large devices', 'cherry-site-shortcodes' ),
									'multiple'         => false,
									'filter'           => true,
									'value'            => array( '' ),
									'options_callback' => array( $this, 'get_device_column_cases' ),
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
							),
						),
						array(
							'title'       => esc_html__( 'Inner column', 'cherry-site-shortcodes' ),
							'description' => esc_html__( 'Shortcode is used for inserting inner grid column', 'cherry-site-shortcodes' ),
							'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
							'slug'        => 'cherry_inner_col',
							'enclosing'   => true,
							'options'     => array(),
						),

					),//end shortcode list
				)
			);
	}

	/**
	 * Get device column cases.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public function get_device_column_cases() {
		return array(
			''  => esc_html__( 'Skip xs value', 'cherry-site-shortcodes' ),
			'1'  => '1/12',
			'2'  => '2/12',
			'3'  => '3/12',
			'4'  => '4/12',
			'5'  => '5/12',
			'6'  => '6/12',
			'7'  => '7/12',
			'8'  => '8/12',
			'9'  => '9/12',
			'10' => '10/12',
			'11' => '11/12',
			'12' => esc_html__( 'Fullwidth column', 'cherry-site-shortcodes' ),
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

/**
 * Returns instanse of main theme configuration class.
 *
 * @since  1.0.0
 * @return object
 */
function cherry_shortcodes_admin() {
	return Cherry_Shortcodes_Admin::get_instance();
}

cherry_shortcodes_admin();
