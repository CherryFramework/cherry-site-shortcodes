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
	 * Grid shortcodes settings.
	 *
	 * @var array
	 */
	public $grid_shortcodes_settings = array();

	/**
	 * Base shortcodes settings.
	 *
	 * @var array
	 */
	public $base_shortcodes_settings = array();

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
		//$utility = cherry_site_shortcodes()->get_core()->modules['cherry-utility']->utility;

		// Grid Shortcodes list
		cherry5_register_shortcode(
				array(
					'title'       => esc_html__( 'Grid Shortcodes', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Grid cherry shortcode collection. Using BootStrap4 base grid', 'cherry-site-shortcodes' ),
					'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
					'slug'        => 'cherry-grid-shortcodes',
					'shortcodes'  => $this->grid_shortcodes_settings,
				)
		);

		// Base Shortcodes list
		cherry5_register_shortcode(
				array(
					'title'       => esc_html__( 'Basic Shortcodes', 'cherry-site-shortcodes' ),
					'description' => esc_html__( 'Base cherry shortcode collection', 'cherry-site-shortcodes' ),
					'icon'        => '<span class="dashicons dashicons-admin-generic"></span>',
					'slug'        => 'cherry-shortcodes',
					'shortcodes'  => $this->base_shortcodes_settings,
				)
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
