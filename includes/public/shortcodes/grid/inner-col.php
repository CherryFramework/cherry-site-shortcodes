<?php
/**
 * Cherry Inner Col Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Inner Col shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Inner_Col_Shortcode extends Cherry_Col_Shortcode {

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
		$this->name = 'inner_col';

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
			'title'       => esc_html__( 'Inner Column', 'cherry-site-shortcodes' ),
			'description' => esc_html__( 'Shortcode is used for inserting grid column', 'cherry-site-shortcodes' ),
			'icon'        => '<span class="dashicons dashicons-screenoptions"></span>',
			'slug'        => 'cherry_inner_col',
			'enclosing'   => true,
			'options'     => parent::get_column_shortcode_settings(),
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

Cherry_Inner_Col_Shortcode::get_instance();
