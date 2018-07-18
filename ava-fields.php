<?php
/*
Plugin Name: AVA Fields
Plugin URI: http://ava-fields.ava-team.com
Description: Just add live to your pages
Version: 1.0.0
Author: WP-Magic.com
Author URI: http://wp-magic.com
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'AVA_FILEDS_VERSION' ) ) {
	define( 'AVA_FIELDS_VERSION', '1.0.0' );
}
if ( ! defined( 'AVA_FIELDS_DIR' ) ) {
	define( 'AVA_FIELDS_DIR', __DIR__ );
}
if ( ! defined( 'AVA_FIELDS_ASSETS_DIR' ) ) {
	define( 'AVA_FIELDS_ASSETS_DIR', __DIR__ . '/assets/' );
}
if ( ! defined( 'AVA_FIELDS_ASSETS_URI' ) ) {
	define( 'AVA_FIELDS_ASSETS_URI', plugin_dir_url( __FILE__ ) . 'assets/' );
}

if ( ! defined( 'AVA_FIELDS_FIELDS_DIR' ) ) {
	define( 'AVA_FIELDS_FIELDS_DIR', __DIR__ . '/fields/' );
}
if ( ! defined( 'AVA_FIELDS_ICONS_DIR' ) ) {
	define( 'AVA_FIELDS_ICONS_DIR', __DIR__ . '/assets/images/icons/' );
}
if ( ! defined( 'AVA_FIELDS_ICONS_URI' ) ) {
	define( 'AVA_FIELDS_ICONS_URI', plugin_dir_url( __FILE__ ) . 'assets/images/icons/' );
}

include_once AVA_FIELDS_DIR . '/classes/access.php';

include_once AVA_FIELDS_DIR . '/classes/containers/container.php';
include_once AVA_FIELDS_DIR . '/classes/containers/custom.php';

include_once AVA_FIELDS_DIR . '/classes/section.php';
include_once AVA_FIELDS_DIR . '/classes/options.php';
include_once AVA_FIELDS_DIR . '/classes/field.php';
include_once AVA_FIELDS_DIR . '/classes/utils.php';


if ( ! class_exists( 'AVA_Fields' ) ) {
	class AVA_Fields {
		
		
		/**
		 * Core singleton class
		 * @var self - pattern realization
		 */
		private static $instance;
		
		/**
		 * Modules and objects instances list
		 * @since 4.2
		 * @var array
		 */
		private $factory = array();
		
		private $filesystem;
		
		
		// Fields containers
		private static $containers;
		
		
		/**
		 * Class constructor
		 *
		 * @since  1.0
		 */
		private function __construct() {
			
			//global $wp_filesystem;
			//dd($wp_filesystem);
			
			//WP_Filesystem()
			//$this->filesystem =
			/** Load core files */
			//$this->load();
			
			
		}
		
		public function init() {
			
			//$this->factory['options']   = new AVA_Studio_Options($this->options);
			//$this->factory['params'] = new AVA_Studio_Params();
			//$this->factory['shortcodes'] = new AVA_Studio_Shortcodes();
			//$this->factory['view'] = new AVA_Studio_View();
			//$this->factory['pages'] = new AVA_Studio_Pages();
			
			// Enqueue scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 5 );
			
			//add_action( 'wp_register_scripts', array($this, 'enqueue_scripts'), 5 );
			
			
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			
			/** Ajax hooks */
			add_action( 'wp_ajax_avaf-save', array( 'AVA_Fields_Options', 'save' ) );
			add_action( 'wp_ajax_nopriv_avaf-save', array( 'AVA_Fields_Options', 'save' ) );
			
			//dump('init');
			
			// init hook
			do_action( 'ava_fields/init' );
		}
		
		
		/**
		 * Create new container
		 *
		 * @param $config
		 */
		public static function make( $params ) {
			
			/*
			if ( !empty($params['access']) ) {
				$ac = new AVA_Fields_Access( $params['access'] );
			}
			*/
			if ( empty( $params['container']['type'] ) ) return;
			
			$container_class = 'AVA_' . $params['container']['type']. '_Container';
			
			// Create container
			if ( class_exists($container_class)) {
				$container = new $container_class( $params );
				
				if ( $container ) {
					self::$containers[ $params['container']['id'] ] = $container;
				}
				return $container;
			}

		}
		
		
		public function admin_menu() {
			
			add_menu_page( 'AVA Fields', 'AVA Fields', 'manage_options', 'ava-fields' );
			
			add_action( 'toplevel_page_ava-fields', function () {
				
				//dd(self::$containers);
				
				foreach ( self::$containers as $container_id => $container ) {
					//dump($obj_container);
					
					$html = $container->render();
					
					//dump($html);
				}
				
				echo $html;
				
			} );
			
			
		}
		
		public function test() {
			return 'testeee';
		}
		
		
		/*
		public function load() {
			// Load helpers
			foreach (glob( plugin_dir_path( __FILE__ ) . 'helpers/*.php' ) as $file) {
				include_once $file;
			}
			// Load classes
			foreach (glob( plugin_dir_path( __FILE__ ) . 'classes/*.php' ) as $file) {
				include_once $file;
			}

		}
		*/
		
		
		/*
		public function mainPageSlug() {
			return 'ava-studio-about';
		}

		public function adminInit() {
		}
		*/
		
		
		/*


		public function admin_footer() {
			wp_enqueue_script( 'wpm-functions', wmpew_asset_url( 'js/wpm-functions.js' ), array( 'jquery' ), time(), true );
			wp_enqueue_script( 'wpmew-callbacks', wmpew_asset_url( 'js/wpmew-callbacks.js' ), array( 'jquery' ), time(), true );
			wp_enqueue_script( 'wpm-form', wmpew_asset_url( 'js/wpm-form.js' ), array( 'jquery' ), time(), true );

			wp_enqueue_style( 'wpm-form-css', wmpew_asset_url( 'css/wpm-form.css' ), null, time() );
		}
		*/
		
		public function enqueue_scripts() {
			wp_register_style( 'avaf-styles', AVA_FIELDS_ASSETS_URI . 'css/styles.css', array(), AVA_FIELDS_VERSION );
			wp_enqueue_style( 'avaf-styles' );
			
			wp_register_style( 'avaf-bootstrap-grid', AVA_FIELDS_ASSETS_URI . 'css/bootstrap-grid.css', array(), AVA_FIELDS_VERSION );
			wp_enqueue_style( 'avaf-bootstrap-grid' );
			
			wp_register_script( 'avaf-script', AVA_FIELDS_ASSETS_URI . 'js/script.js', array( 'jquery' ), time(), true );
			wp_enqueue_script( 'avaf-script' );
			
		}
		
		/**
		 * Get the instane of WMP_EW
		 *
		 * @return self
		 */
		public static function instance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}
			
			return self::$instance;
		}
		
		/**
		 * Cloning disabled
		 */
		private function __clone() {
		}
		
		/**
		 * Serialization disabled
		 */
		private function __sleep() {
		}
		
		/**
		 * De-serialization disabled
		 */
		private function __wakeup() {
		}
		
		public function container( $container_id ) {
			return self::$containers[ $container_id ];
		}
		
		public function section( $container_id, $section_id ) {
			return self::$containers[ $container_id ][ $section_id ];
		}
		
		
		/*

		public function options() {
			if (!isset( $this->factory['options'] )) {
				do_action( 'ava_studio_before_init_options' );
				//require_once $this->getPath( 'CORE_DIR', 'class-ew-options.php' );
				$this->factory['options'] = new AVA_Studio_Options();
				do_action( 'ava_studio_init_settings' );
			}

			return $this->factory['options'];
		}

		public function params() {
			return $this->factory['params'];
		}
		*/
		
		
		public function pages() {
			return $this->factory['pages'];
		}
		
		/** Enqueue scripts & styles */
		public function enqueueScripts() {
			wp_register_style( 'ava-studio-params', AVA_FIELDS_PLUGIN_URL . '/admin/assets/css/params.css', time() );
			wp_enqueue_style( 'ava-studio-params' );
			
			wp_register_script( 'ava-studio-admin', AVA_FIELDS_PLUGIN_URL . '/admin/assets/js/params.js', array( 'jquery' ), time(), true );
			wp_enqueue_script( 'ava-studio-admin' );
		}
		
		
		/**
		 * Sets version of the VC in DB as option `vc_version`
		 *
		 * @since 1.0
		 * @access protected
		 *
		 * @return void
		 */
		/*
		protected function setVersion() {
			$version = get_option( 'ava_studio_version' );
			if (!is_string( $version ) || version_compare( $version, AVA_FIELDS_VERSION ) !== 0) {
				add_action(  'wpmew_after_init', array(
					vc_settings(),
					'rebuild',
				) );
				update_option( 'ava_studio_version', AVA_FIELDS_VERSION );
			}
		}
		*/
		
		
	}
}


if ( ! function_exists( 'ava_fields' ) ) {
	function ava_fields() {
		return AVA_Fields::instance();
	}
	ava_fields()->init();
}






