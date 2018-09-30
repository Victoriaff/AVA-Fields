<?php
if (!defined( 'ABSPATH' )) {
	die( '-1' );
}

if (!class_exists( 'AVA_Field_Textarea' )) {
	class AVA_Field_Textarea extends AVA_Fields_Field
	{
		public $type = 'textarea';

		public function __construct($container_id, $section_id, $id, $params) {
			parent::__construct( $container_id, $section_id, $id, $params );

			$this->add_handler( $this->field_dir . 'assets/handler.js' );

		}

		public function build() {
			$this->html = '<textarea name="' . $this->id . '" data-option="' . $this->id . '" ' . $this->get_attrs() . '>'.wp_kses_post( $this->get_value($this->id) ) . '</textarea>';
		}
	}
}

