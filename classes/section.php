<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Section' ) ) {
	class AVA_Fields_Section {

		public $id;
		public $container_id;
		public $params;
		public $fields;
		public $html;

		/**
		 * Constructor.
		 *
		 * @param $params
		 */
		public function __construct( $container_id, $id, $params ) {
			global $wp_filesystem;

			$this->container_id = $container_id;
			$this->id        = $id;
			$this->params    = $params;


			if ( ! empty( $params['fields'] && is_array( $params['fields'] ) ) ) {

				foreach ( $params['fields'] as $id => $field_params ) {

					if ( preg_match( '/^[a-z0-9_]+$/', $field_params['type'] ) ) {
						$class_name = 'AVA_Field_' . $field_params['type'];

						if ( ! class_exists( $class_name ) ) {

							$file = AVA_Fields()->dir('fields') .  $field_params['type'] . '/' . $field_params['type'] . '.php';

							if ( file_exists( $file ) ) {
								require_once( $file );
							}
						}

						// Add field
						if ( class_exists( $class_name ) ) {

							$field = new $class_name( $this->container_id, $this->id, $id, $field_params );
							if ( $field ) {
								$this->fields[ $id ] = $field;
							}
						}
					}
				}

			}
		}

		public function render( $args ) {

			$classes = array();

			if ( $args['active'] == $this->id ) {
				$classes[] = 'active';
			}

			$this->html = '<div class="avaf-section ' . esc_attr( implode( ' ', $classes ) ) . '" data-section="' . esc_attr( $this->id ) . '">';

            $this->html .= '<form class="avaf-form" data-nonce="de9b85ac62" enctype="multipart/form-data">';

			foreach ( $this->fields as $field_id => $field ) {
				$this->html .= $field->render();
			}

            $this->html .= '</form>';

			$this->html .= '</div>';

			return $this->html;

		}

		public function this() {
			return $this;
		}


	}
}

