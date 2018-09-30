<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Field_Select' ) ) {
	class AVA_Field_Select extends AVA_Fields_Field {
		public $type = 'select';


		public function __construct( $container_id, $section_id, $id, $params ) {
			parent::__construct( $container_id, $section_id, $id, $params );

			$this->add_handler( $this->field_dir . 'assets/handler.js' );
		}

		public function build() {

			$this->html = '<select name="' . $this->id . '" id="' . $this->id . '"' . $this->get_attrs() . '>';

			if ( ! $this->params['validate']['required'] ) {
				$this->html .= '<option value=""></option>';
			}

			foreach ( $this->params['options'] as $value => $text ) {
				$selected = $this->get_value( $this->id ) == $value ? ' selected' : '';

				$this->html .= '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . wp_kses_post( $text ) . '</option>';
			}
			$this->html .= '</select>';

		}

	}
}

