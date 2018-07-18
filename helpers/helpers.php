<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * AVA Studio
 *
 * @since   1.0
 */
if ( ! function_exists( 'ava' ) ) {
	/**
	 * AVA Studio Object
	 * @since 1.0
	 * @return AVA_Studio
	 */
	function ava() {
		return AVA_Studio::instance();
	}
}

if ( ! function_exists( 'ava_options' ) ) {
	/**
	 * Get all options
	 *
	 * @param string $option Option name
	 *
	 * @since 1.0
	 * @return mixed
	 */
	function ava_options($option=null) {
		if (!empty($option))
			return ava()->options()->get($option);
		else
			return ava()->options();
	}
}

if ( ! function_exists( 'ava_shortcodes' ) ) {
	/**
	 * Get all shortcodes
	 *
	 * @since 1.0
	 * @return array
	 */
	function ava_studio_shortcodes() {
		return ava()->shortcodes();
	}
}

if ( ! function_exists( 'ava_params' ) ) {
	/**
	 * Get all shortcodes
	 *
	 * @since 1.0
	 * @return array
	 */
	function ava_params() {
		return ava()->params();
	}
}




