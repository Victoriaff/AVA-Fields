<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Field_Radio' ) ) {
	class AVA_Field_Radio extends AVA_Fields_Field {
		public $type = 'radio';


		public function __construct( $container_id, $section_id, $id, $params ) {
			parent::__construct( $container_id, $section_id, $id, $params );

			$this->add_handler( $this->field_dir . 'assets/handler.js' );
		}

		public function build() {

			$this->html = '';

			foreach ( $this->params['options'] as $value => $text ) {
				$checked = $this->get_value( $this->id ) == $value ? ' checked' : '';

				$unique_id = $this->get_unique_id( $value );

				$this->html .= '<input type="radio" name="' . $this->id . '[]" id="' . $unique_id . '" value="' . esc_attr( $value ) . '"' . $this->get_attrs() . $checked . '>';
				$this->html .= '<label for="' . $unique_id . '">' . wp_kses_post( $text ) . '</label>';
			}

		}

	}
}

