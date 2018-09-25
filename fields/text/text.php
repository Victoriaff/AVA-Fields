<?php
if (!defined( 'ABSPATH' )) {
	die( '-1' );
}

if (!class_exists( 'AVA_Field_Text' )) {
	class AVA_Field_Text extends AVA_Fields_Field
	{
		public $type = 'text';


		public function __construct(AVA_Fields_Container $container, AVA_Fields_Section $section, $id, $params) {
			parent::__construct( $container, $section, $id, $params );

			//$this->add_class('avafl-text');
		}

		public function build() {
            $this->html = '<input type="text" name="' . $this->id . '" id="' . $this->id . '" value="' . esc_attr( $this->get_value($this->id) ) . '" ' . $this->get_attrs() . '>';
		}

	}
}

