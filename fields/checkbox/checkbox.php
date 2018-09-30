<?php
if (!defined( 'ABSPATH' )) {
	die( '-1' );
}

if (!class_exists( 'AVA_Field_Checkbox' )) {
	class AVA_Field_Checkbox extends AVA_Fields_Field
	{
		public $type = 'checkbox';


		public function __construct($container_id, $section_id, $id, $params) {
			parent::__construct( $container_id, $section_id, $id, $params );

			$this->add_handler( $this->field_dir . 'assets/handler.js' );
		}

		public function build() {
			$checked = $this->get_value($this->id) == 'yes' ? ' checked':'';

            $this->html = '<input type="checkbox" name="' . $this->id . '" id="' . $this->id . '" ' . $this->get_attrs() . $checked . '>';
			$this->html .= '<label for="' . $this->id . '">'.wp_kses_post($this->params['texts']['label']).'</label>';
		}

	}
}

