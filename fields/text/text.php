<?php
if (!defined( 'ABSPATH' )) {
	die( '-1' );
}

if (!class_exists( 'AVA_Field_Text' )) {
	class AVA_Field_Text extends AVA_Fields_Field
	{
		public $type = 'text';


		public function __construct($container_id, $section_id, $id, $params) {
			parent::__construct( $container_id, $section_id, $id, $params );

			$this->add_handler( $this->field_dir . 'assets/handler.js' );
		}

		public function build() {
            $this->html = '<input type="text" name="' . $this->id . '" id="' . $this->id . '" value="' . esc_attr( $this->get_value($this->id) ) . '" ' . $this->get_attrs() . '>';
		}

	}
}

