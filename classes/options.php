<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Options' ) ) {
	class AVA_Fields_Options {

		public $options;
		public $default = array(
			'storage' => 'db',
			'save_as'     => 'array' // array | row, default - array
		);

		public function __construct( $params ) {

			$this->options = AVA_Fields_Utils::params_default( $params['options'], $this->default );

			if ( $this->options['save_as'] == 'array' ) {
				$this->options['options'] = get_option( $this->options['option_name'] );
			} else {

			}
			//dump($this->options);
		}

		public static function save() {

			$response = array(
				'result' => 'ok',
				'_REQUEST' => $_REQUEST
			);

			$option_name = $_REQUEST['option_name'];
            $response['$option_name'] = $option_name;

            $option_value = $_REQUEST['options'];
            $response['$option_value'] = $option_value;

            $options = (array)get_option($option_name);
			$options = array_merge($options, $option_value);

			update_option($option_name, $options);

			wp_send_json($response);
			exit;
		}


		public function get( $field, $deafult = '' ) {

			// Get from Array
			if ( $this->options['save_as'] == 'array' ) {
				if ( ! empty( $this->options['options'][ $field ] ) ) {
					return $this->options['options'][ $field ];
				} else if ( ! empty( $deafult ) ) {
					return $deafult;
				} else {
					return '';
				}
			}

			// Get from Row
			/*
			if ( $this->save_as == 'row' ) {
				$key = $this->option_name . '|' . $field;

				return get_option( $key );
			}
			*/
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

