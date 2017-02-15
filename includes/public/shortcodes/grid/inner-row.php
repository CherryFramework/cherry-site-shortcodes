<?php
/**
 * Cherry Inner Row Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Inner Row shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Inner_Row_Shortcode extends Cherry_Row_Shortcode {

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
		$this->name = 'inner_row';

		Cherry_Main_Shortcode::__construct();

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
			'title'       => esc_html__( 'Inner Row', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used for inserting inner row wrapper', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-editor-table"></span>',
			'slug'        => 'cherry_inner_row',
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

Cherry_Inner_Row_Shortcode::get_instance();
