<?php
if (!defined( 'ABSPATH' )) {
	die( '-1' );
}

if (!class_exists( 'AVA_Field_Textarea' )) {
	class AVA_Field_Textarea extends AVA_Fields_Field
	{
		public $type = 'textarea';
		
		public function __construct(AVA_Fields_Container $container, AVA_Fields_Section $section, $id, $params) {
			parent::__construct( $container, $section, $id, $params );
		}

		public function build() {
			$this->html = '<textarea name="' . $this->id . '" data-option="' . $this->id . '" ' . $this->get_attrs() . '>'.wp_kses_post( $this->get_value($this->id) ) . '</textarea>';
		}
	}
}

