<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Options' ) ) {
	class AVA_Fields_Options {
		public $options;

		public $option_name;

		public $save_as;


		public function __construct( $params ) {

			//dd(get_option('acf_version'));

			$this->option_name = $params['db']['option_name'];

			$this->save_as = ! empty( $params['db']['save_as'] ) && in_array( $params['db']['save_as'], array(
				'array',
				'row'
			) ) ? $params['db']['save_as'] : 'array';

			if ( $this->save_as == 'array' ) {
				$this->options = get_option( $this->option_name );
			} else {

			}
		}

		/**
		 * Save data
		 */
		public static function save2() {
			dump('save');

			//add_action( 'ava_fields_init', array( 'AVA_Fields_Options', 'save2' ) );
			//do_action('ava_fields_init');
		}


		public static function save() {

			//dump(unserialize($data));
			//parse_str($_REQUEST['data'], $data);

			$response = array(
				'result' => 'ok'
			);

			$option_name = $_REQUEST['option_name'];
            $response['$option_name'] = $option_name;

            $option_value = (array)json_decode(stripslashes($_REQUEST['data']));
            $response['$option_value'] = $option_value;

			update_option($option_name, $option_value);

			//$response['data'] = json_decode($_REQUEST);
			//$response['sections'] = ava_fields()->containers;

			//dump($data);
			//dump($response);

			wp_send_json($response);
			exit;
		}


		public function get( $field, $deafult = '' ) {

			//dump($section);
			//dump($field);
			//dd($this->options[ $section ][ $field ]);

			// Get from Array
			if ( $this->save_as == 'array' ) {
				if ( ! empty( $this->options[ $field ] ) ) {
					return $this->options[ $field ];
				} else if ( ! empty( $deafult ) ) {
					return $deafult;
				} else {
					return '';
				}
			}

			// Get from Row
			if ( $this->save_as == 'row' ) {
				$key = $this->option_name . '|' . $field;

				return get_option( $key );
			}


		}

		/*
		public function update($option, $data) {
			$el = explode( '.', $option );
			$options =& self::$options;

			foreach ($el as $key => $option) {

				if (isset( $options[$option] )) {
					if ($key < count( $el ) - 1) $options =& $options[$option];
				} else {
					if ($key < count( $el ) - 1) {
						$options =& $options[$option];
					} else {
						$options[$option] = $data;
						return $this;
					}
				}
			}
			$options[$option] = $data;

			return $this;
		}

		public function store($option, $data) {
			$this->update( $option, $data );
			$opt = explode( '.', $option )[0];
			$this->save( $opt );
		}


		public function save($option = null) {
			if (!$option) {
				foreach (self::$options as $option)
					update_option( 'ava_studio_' . $option, self::$options[$option] );
			} else
				update_option( 'ava_studio_' . $option, isset( self::$options[$option] ) ? self::$options[$option] : [] );
		}

		public function remove($option) {
			if (isset( self::$options[$option] )) unset( self::$options[$option] );
			delete_option( 'ava_studio_' . $option );
		}
		*/

	}
}

