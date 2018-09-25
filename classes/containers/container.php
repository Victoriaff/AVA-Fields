<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Container' ) ) {
	class AVA_Fields_Container {

		public $id;

		public $params;

		public $default = array(
			'appearance' => array(
				'nav_style' => 'vertical',

			)
		);

		public $sections;

		public $html;

		public $options;


		public function __construct( $params ) {

			// Set default values
			$params = AVA_Fields_Utils::params_default( $params, $this->default );

			$this->id = $params['container']['id'];

			$this->params = $params;


			$this->options = new AVA_Fields_Options( $params );
			
			//dump($this->options);
		}

		public function add_section( $id, $params ) {

			$section = new AVA_Fields_Section( $this, $id, $params );

			if ( $section ) {
				$this->sections[ $id ] = $section;
			}

			return $section;
		}


		public function render() {

			$this->html = '<div class="avaf avaf-container avaf-'.$this->params['container']['type'].'" data-container="' . esc_attr( $this->id ).'" data-option_name="' . esc_attr( $this->params['options']['option_name'] ).'">';

			$this->html .= $this->get_header();


			$active_section = $this->get_active_section();
			
			// Navigation menu & sections
			$this->html .= '<div class="avaf-nav-sections ' . esc_attr( $this->params['appearance']['nav_style'] ) . '">';
			
				// Navigation menu
				$this->html .= '<div class="avaf-nav">';
	
				foreach ( $this->sections as $section_id => $section ) {
	
					$active_class = ( $active_section == $section->id ? 'active' : '' );
	
					$this->html .= '<a class="avaf-nav-item ' . esc_attr( $active_class ) . '" href="#' . esc_attr( $section->id ) . '" data-section="' . esc_attr( $section->id ) . '">';
	
					if ( ! empty( $section->params['icon'] ) ) {
						$this->html .= '<img class="avaf-nav-icon" src="' . esc_url( $section->params['icon'] ) . '">';
					}
					$this->html .= '<span>' . $section->params['title'] . '</span>';
					$this->html .= '</a>';
				}
				$this->html .= '</div>';
				// end Navigation menu
	
	
				// Sections
				$this->html .= '<div class="avaf-sections">';
				
				foreach ( $this->sections as $section_id => $section ) {
					

					$this->html .= $section->render( array(
							'active' => $active_section
						)
					);

				}
				$this->html .= '</div>';
				// end Section
			
			$this->html .= '</div>';
			// end Navigation menu & sections

			// Control panel
			$this->html .= '<div class="avaf-control">';
			$this->html .= '<button class="avaf-button avaf-button-primary avaf-save" data-container="' . esc_attr( $this->id ) . '">'.__('Save Changes', '{domain}').'</button>';
			$this->html .= '<button class="avaf-button avaf-reset-section" data-container="' . esc_attr( $this->id ) . '">'.__('Reset Section', '{domain}').'</button>';
			$this->html .= '<button class="avaf-button avaf-reset" data-container="' . esc_attr( $this->id ) . '">'.__('Reset All', '{domain}').'</button>';
			$this->html .= '</div>';

			
			$this->html .= '<div class="avaf-preloader">'.__('Saving', '{domain}').'...<br><svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="160px" height="20px" viewBox="0 0 128 16" xml:space="preserve"><rect x="0" y="0" width="100%" height="100%" fill="#FFFFFF" /><path fill="#949494" fill-opacity="0.42" d="M6.4,4.8A3.2,3.2,0,1,1,3.2,8,3.2,3.2,0,0,1,6.4,4.8Zm12.8,0A3.2,3.2,0,1,1,16,8,3.2,3.2,0,0,1,19.2,4.8ZM32,4.8A3.2,3.2,0,1,1,28.8,8,3.2,3.2,0,0,1,32,4.8Zm12.8,0A3.2,3.2,0,1,1,41.6,8,3.2,3.2,0,0,1,44.8,4.8Zm12.8,0A3.2,3.2,0,1,1,54.4,8,3.2,3.2,0,0,1,57.6,4.8Zm12.8,0A3.2,3.2,0,1,1,67.2,8,3.2,3.2,0,0,1,70.4,4.8Zm12.8,0A3.2,3.2,0,1,1,80,8,3.2,3.2,0,0,1,83.2,4.8ZM96,4.8A3.2,3.2,0,1,1,92.8,8,3.2,3.2,0,0,1,96,4.8Zm12.8,0A3.2,3.2,0,1,1,105.6,8,3.2,3.2,0,0,1,108.8,4.8Zm12.8,0A3.2,3.2,0,1,1,118.4,8,3.2,3.2,0,0,1,121.6,4.8Z"/><g><path fill="#000000" fill-opacity="1" d="M-42.7,3.84A4.16,4.16,0,0,1-38.54,8a4.16,4.16,0,0,1-4.16,4.16A4.16,4.16,0,0,1-46.86,8,4.16,4.16,0,0,1-42.7,3.84Zm12.8-.64A4.8,4.8,0,0,1-25.1,8a4.8,4.8,0,0,1-4.8,4.8A4.8,4.8,0,0,1-34.7,8,4.8,4.8,0,0,1-29.9,3.2Zm12.8-.64A5.44,5.44,0,0,1-11.66,8a5.44,5.44,0,0,1-5.44,5.44A5.44,5.44,0,0,1-22.54,8,5.44,5.44,0,0,1-17.1,2.56Z"/><animateTransform attributeName="transform" type="translate" values="23 0;36 0;49 0;62 0;74.5 0;87.5 0;100 0;113 0;125.5 0;138.5 0;151.5 0;164.5 0;178 0" calcMode="discrete" dur="1170ms" repeatCount="indefinite"/></g></svg></div>';

			$this->html .= '</div>';

			return $this->html;

		}

		public function get_header() {

			$html = '';
			if ( ! empty( $this->params['container']['title'] ) || ! empty( $this->params['container']['subtitle'] ) ) {
				$html = '<div class="avaf-header">';

				$html .= '<div class="avaf-title">' . $this->params['container']['title'] . '</div>';
				$html .= '<div class="avaf-subtitle">' . $this->params['container']['subtitle'] . '</div>';

				$html .= '</div>';
			}

			return $html;
		}


		public function get_active_section() {
			return 'general';
		}


	}
}

