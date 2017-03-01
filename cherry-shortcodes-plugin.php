<?php
/**
 * Plugin Name: Cherry Site Shortcodes
 * Plugin URI:  http://www.cherryframework.com/
 * Description: A plugin for WordPress.
 * Version:     1.0.0
 * Author:      Cherry Team
 * Text Domain: blank-plugin
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 *
 * @package    Cherry_Site_Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Cherry_Site_Shortcodes` doesn't exists yet.
if ( ! class_exists( 'Cherry_Site_Shortcodes' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Cherry_Site_Shortcodes {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var object
		 */
		private static $instance = null;

		/**
		 * A reference to an instance of cherry framework core class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var object
		 */
		private $core = null;

		/**
		 * A reference to an instance of dynamic_css module.
		 *
		 * @since 1.0.0
		 * @access public
		 * @var null
		 */
		public $dynamic_css = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// Set the constants needed by the plugin.
			$this->constants();

			// Load the functions files.
			$this->includes();

			// Load the installer core.
			add_action( 'after_setup_theme', require( trailingslashit( dirname( __FILE__ ) ) . 'cherry-framework/setup.php' ), 0 );

			// Load the core functions/classes required by the rest of the plugin.
			add_action( 'after_setup_theme', array( $this, 'get_core' ), 1 );

			// Laad the modules.
			add_action( 'after_setup_theme', array( 'Cherry_Core', 'load_all_modules' ), 2 );

			// Initialization of modules.
			add_action( 'after_setup_theme', array( $this, 'init_modules' ), 3 );

			// Internationalize the text strings used.
			add_action( 'plugins_loaded', array( $this, 'lang' ), 1 );

			// Load the admin files.
			add_action( 'plugins_loaded', array( $this, 'admin' ), 2 );

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 10 );

			// Load public-facing StyleSheets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 11 );

			// Load public-facing JavaScripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 11 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );

			// Apply custom formatter function.
			add_filter( 'the_content', array( $this, 'clean_shortcodes' ) );
		}

		/**
		 * Defines constants for the plugin.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function constants() {

			/**
			 * Set the version number of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SITE_SHORTCODES_VERSION', '1.0.0' );

			/**
			 * Set constant path to the plugin directory.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SITE_SHORTCODES_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin URI.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_SITE_SHORTCODES_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}

		/**
		 * Loads files from the '/includes' folder.
		 *
		 * @since 1.0.0
		 */
		public function includes() {
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/tools.php' );

			$this->shortcodes();
		}

		/**
		 * Loads shortcodes.
		 *
		 * @since 1.0.0
		 */
		public function shortcodes() {
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/class-cherry-main-shortcode.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/grid/row.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/grid/inner-row.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/grid/col.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/grid/inner-col.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/button.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/section.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/inner-section.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/divider.php' );
			require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/public/shortcodes/icon.php' );
		}

		/**
		 * Loads the core functions. These files are needed before loading anything else in the
		 * plugin because they have required functions for use.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public function get_core() {

			/**
			 * Fires before loads the plugin's core.
			 *
			 * @since 1.0.0
			 */
			do_action( 'cherry_site_shortcodes_core_before' );

			global $chery_core_version;

			if ( null !== $this->core ) {
				return $this->core;
			}

			if ( 0 < sizeof( $chery_core_version ) ) {
				$core_paths = array_values( $chery_core_version );
				require_once( $core_paths[0] );
			} else {
				die( 'Class Cherry_Core not found' );
			}

			$this->core = new Cherry_Core( array(
				'base_dir' => CHERRY_SITE_SHORTCODES_DIR . 'cherry-framework',
				'base_url' => CHERRY_SITE_SHORTCODES_DIR . 'cherry-framework',
				'modules'  => array(
					'cherry-js-core' => array(
						'autoload' => true,
					),
					'cherry-toolkit' => array(
						'autoload' => false,
					),
					'cherry-utility' => array(
						'autoload' => false,
					),
					'cherry-dynamic-css' => array(
						'autoload' => false,
					),
					'cherry-ui-elements' => array(
						'autoload' => false,
					),
					'cherry-interface-builder' => array(
						'autoload' => false,
					),
					'cherry-handler' => array(
						'autoload' => false,
					),
					'cherry5-insert-shortcode' => array(
						'autoload' => false,
					),
				),
			) );

			return $this->core;
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function init_modules() {
			$this->dynamic_css = $this->get_core()->init_module( 'cherry-dynamic-css' );

			$this->get_core()->init_module( 'cherry5-insert-shortcode', array() );
		}

		/**
		 * Loads admin files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function admin() {

			if ( is_admin() ) {
				require_once( CHERRY_SITE_SHORTCODES_DIR . 'includes/admin/class-shortcodes-admin.php' );
			}
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'cherry-site-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Register assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {
			// Register stylesheets.
			wp_register_style( 'font-awesome', CHERRY_SITE_SHORTCODES_URI . 'assets/css/font-awesome.min.css', array(), '4.6.3' );
			wp_register_style( 'cherry-site-shortcodes-styles', CHERRY_SITE_SHORTCODES_URI . 'assets/css/min/main.min.css', array(), CHERRY_SITE_SHORTCODES_VERSION, 'all' );
			wp_register_style( 'cherry-site-shortcodes-element-styles', CHERRY_SITE_SHORTCODES_URI . 'assets/css/min/elements.min.css', array(), CHERRY_SITE_SHORTCODES_VERSION, 'all' );
			wp_register_style( 'cherry-site-shortcodes-grid-styles', CHERRY_SITE_SHORTCODES_URI . 'assets/css/min/grid.min.css', array(), CHERRY_SITE_SHORTCODES_VERSION, 'all' );

			// Register JavaScripts.
			wp_register_script( 'cherry-site-shortcodes-script', CHERRY_SITE_SHORTCODES_URI . 'assets/js/cherry-site-shortcodes.js', array( 'jquery', 'cherry-js-core' ), CHERRY_SITE_SHORTCODES_VERSION, true );
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {
			$avaliable_styles = apply_filters(
				'cherry-site-shortcodes-avaliable-styles',
				array(
					'awesome' => 'font-awesome',
					'main'    => 'cherry-site-shortcodes-styles',
					'grid'    => 'cherry-site-shortcodes-grid-styles',
					'element' => 'cherry-site-shortcodes-element-styles',
				)
			);

			if ( ! empty( $avaliable_styles ) ) {
				foreach ( $avaliable_styles as $style_id => $style ) {
					wp_enqueue_style( $style );
				}
			}
		}

		/**
		 * Enqueue public-facing JavaScripts.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'cherry-site-shortcodes-script' );
		}

		/**
		 * On plugin activation.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function activation() {}

		/**
		 * On plugin deactivation.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function deactivation() {}

		/**
		 * Custom formatter function.
		 *
		 * @since  1.0.0
		 *
		 * @param  string  $content
		 * @return string           Formatted content with clean shortcodes content
		 */
		public function clean_shortcodes( $content ) {
			$array = array(
				'<p>['    => '[',
				']</p>'   => ']',
				']<br />' => ']',
			);

			$content = strtr( $content, $array );

			return $content;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
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
}

if ( ! function_exists( 'cherry_site_shortcodes' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_site_shortcodes() {
		return Cherry_Site_Shortcodes::get_instance();
	}
}

cherry_site_shortcodes();
