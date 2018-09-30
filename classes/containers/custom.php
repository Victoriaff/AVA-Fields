<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Custom_Container' ) ) {
	class AVA_Fields_Custom_Container extends AVA_Fields_Container {

		public $schema = array(

			'container' => array(
				'type'     => array('custom'),
				'id'       => '{id}',
				'title'    => '{string|empty}',
				'subtitle' => '{string|empty}',
			),
			'menu' => array(
				'parent'     => '{string|empty}',
				'post_type'  => '{string|empty}',
				'menu_title' => '{string|empty}',
				'menu_slug'  => '{slug|empty}',
			),

			'options' => array(
				'option_name' => '{slug}'
			),

			'access' => array(
				'user_capability' => 'manage_options',

				'user_id' => array(
					'value'  => 1,
					'except' => true
				),

				'user_role'        => 'administrator',

				// post_meta
				'post_format'      => '',
				'post_id'          => '',
				'post_level'       => '',
				'post_ancestor_id' => '',
				'post_template'    => '',
				'post_term'        => '',
				'post_type'        => '',

				// term_meta
				'term'             => '',
				'term_parent'      => '',
				'term_level'       => '',
				'term_ancestor'    => '',
				'term_taxonomy'    => '',

				// theme_options
				'blog_id'          => '',
			),

			'settinigs' => array(
				'nav_style' => array('horizontal', 'vertical'),
				'style' => '',
				'position' => '',
			)
		);

		public function __construct( $params ) {
			
			parent::__construct( $params );

		}

	}
}

