<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Custom_Container' ) ) {
	class AVA_Fields_Custom_Container extends AVA_Fields_Container {

		public function __construct( $params ) {
			
			parent::__construct( $params );

		}

	}
}

