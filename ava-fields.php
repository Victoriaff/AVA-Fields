<?php
/*
Plugin Name: AVA Fields
Plugin URI: http://fields.ava-team.com
Description: Just add live to your pages
Version: 1.0.0
Author: AVA-Team.com
Author URI: http://ava-team.com
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

//dump('AVA_Fields');

if ( ! class_exists( 'AVA_Fields' ) ) {
	class AVA_Fields {

		/**
		 * Modules and objects instances list
		 * @since 1.0
		 * @var array
		 */
		public $factory = array();

		
		/**
		 * Fields containers
		 */
		public $containers = array();

		/**
		 * Core singleton class
		 */
		private static $instance;

		
		/**
		 * Class constructor
		 *
		 * @since  1.0
		 */
		private function __construct() {

			// Load assets
			add_action( 'init', array( $this, 'loaded' ) );

			// Load assets
			add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

			add_action( 'admin_menu', array( $this, 'admin_menu' ) );

			/** Ajax hooks */
			add_action( 'wp_ajax_avaf-save', array( 'AVA_Fields_Options', 'save' ) );
			add_action( 'wp_ajax_nopriv_avaf-save', array( 'AVA_Fields_Options', 'save' ) );
		}
		
		public function init() {

			require_once $this->dir('ava-fields') . 'classes/access.php';

			require_once $this->dir('ava-fields') . 'classes/containers/container.php';
			require_once $this->dir('ava-fields') . 'classes/containers/custom.php';

			require_once $this->dir('ava-fields') . 'classes/section.php';
			require_once $this->dir('ava-fields') . 'classes/options.php';
			require_once $this->dir('ava-fields') . 'classes/field.php';
			require_once $this->dir('ava-fields') . 'classes/utils.php';


			//$this->factory['options']   = new AVA_Fields_Options();
			//$this->factory['params'] = new AVA_Studio_Params();
			//$this->factory['shortcodes'] = new AVA_Studio_Shortcodes();
			//$this->factory['view'] = new AVA_Studio_View();
			//$this->factory['pages'] = new AVA_Studio_Pages();

			// Init hook
			do_action( 'ava-fields/init' );
		}

		/**
		 * Load fields ...
		 *
		 */
		public function loaded() {
			do_action( 'ava-fields/loaded' );
		}

		
		/**
		 * Create new container
		 *
		 * @param $config
		 */
		public function make( $params ) {
			
			/*
			if ( !empty($params['access']) ) {
				$ac = new AVA_Fields_Access( $params['access'] );
			}
			*/
			if ( empty( $params['container']['type'] ) ) return;
			
			$container_class = 'AVA_Fields_' . $params['container']['type']. '_Container';
			
			// Create container
			if ( class_exists($container_class)) {
				$container = new $container_class( $params );

				if ( $container ) {
					$this->containers[ $params['container']['id'] ] = $container;
				}

				return $container;
			}

		}
		
		
		public function admin_menu() {
			
			add_menu_page( 'AVA Fields', 'AVA Fields', 'manage_options', 'ava-fields' );
			
			add_action( 'toplevel_page_ava-fields', function () {
				
				//dd($this->containers);

				$html = '';

				foreach ( $this->containers as $container_id => $container ) {
					//dump($obj_container);
					
					$html .= $container->render();
					
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
				require_once $file;
			}
			// Load classes
			foreach (glob( plugin_dir_path( __FILE__ ) . 'classes/*.php' ) as $file) {
				require_once $file;
			}

		}
		*/
		
		
		/*
		public function mainPageSlug() {
			return 'ava-fields-about';
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
			return $this->containers[ $container_id ];
		}
		
		public function section( $container_id, $section_id ) {
			return $this->containers[ $container_id ][ $section_id ];
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
		public function load_assets() {
			//wp_register_style( 'ava-fields-params', $this->url('ava-fields') . 'assets/css/params.css', time() );
			//wp_enqueue_style( 'ava-fields-params' );
			
			//wp_register_script( 'ava-fields-admin', $this->url('ava-fields') . 'assets/js/params.js', array( 'jquery' ), time(), true );
			//wp_enqueue_script( 'ava-fields-admin' );

			wp_register_style( 'ava-fields', $this->url('assets') . 'css/styles.css', array(), $this->version() );
			wp_enqueue_style( 'ava-fields' );

			wp_register_style( 'bootstrap-grid', $this->url('assets') . 'css/bootstrap-grid.css', array(), $this->version() );
			wp_enqueue_style( 'bootstrap-grid' );

			wp_register_script( 'ava-fields', $this->url('ava-fields') . 'assets/js/scripts.js', array( 'jquery' ), time(), true );
			wp_enqueue_script( 'ava-fields' );
		}

		public function dir( $type ) {
			switch ( $type ) {
				case 'ava-fields':
					return __DIR__ . '/';
					break;
				case 'assets':
					return $this->dir( 'ava-fields' ) . 'assets/';
					break;
				case 'fields':
					return $this->dir( 'ava-fields' ) . 'fields/';
					break;
				case 'icons':
					return $this->dir( 'ava-fields' ) . 'assets/images/icons/';
					break;

			}
		}

		public function url( $type ) {
				switch ( $type ) {

				case 'ava-fields':
					return plugin_dir_url( __FILE__ );
					break;
				case 'assets':
					return  plugin_dir_url( __FILE__ ) . 'assets/';
					break;
				case 'icons':
					return  plugin_dir_url( __FILE__ ) . 'assets/images/icons/';
					break;
			}
		}

		public function version() {
			return '1.0';
		}
	}
}


if ( ! function_exists( 'AVA_Fields' ) ) {
	function AVA_Fields() {
		return AVA_Fields::instance();
	}
}
AVA_Fields()->init();








