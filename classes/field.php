<?php
if (!defined( 'ABSPATH' )) {
	die( '-1' );
}

if (!class_exists( 'AVA_Fields_Field' )) {
	abstract class AVA_Fields_Field
	{
		public $type;

		public $id;
		
		public $container_id;
		
		public $section_id;

		public $params;

		public $html;

		public $value;

		public function __construct($container_id, $section_id, $id, $params) {

			//$this->type = $params['type'];

			$this->id = $id;
			
			$this->container_id = $container_id;

			$this->section_id = $section_id;

			$this->params = $params;

			$this->value = $this->value();
		}

		public function value() {
			$value = $this->container()->options->get($this->section_id, $this->id, $this->params['value']);
			return $value;
		}

		public function get_name_attr() {
			return esc_attr( $this->section_id . '['.$this->id.']');
		}

		public function get_id_attr() {
			return esc_attr( 'avaf-'.$this->section_id . '-'.$this->id);
		}

		public function render() {

			$this->html = '';
			$this->build();

			$html = '<div class="avaf-group" data-group="'.esc_attr($this->id).'">';

				// label
				$html .= $this->get_label();

				// field
				$html .= '<div class="avaf-field avaf-field-'.esc_attr($this->type).' col col-sm-10">';
					$html .= $this->get_before();
					$html .= $this->html;
					$html .= $this->get_after();
					$html .= $this->get_desc();
				$html .= '</div>';

			$html .= '</div>';

			return $html;
		}

		// Get field label
		public function get_label() {
			$html = '<label class="avaf-label col col-sm-2" for="avaf-'. esc_attr($this->id).'">';
			if (!empty( $this->params['texts']['title'] )) $html .= $this->params['texts']['title'];
			if (!empty( $this->params['texts']['subtitle'] )) $html .= '<small style="">'.$this->params['texts']['subtitle'].'</small>';
			$html .= '</label>';

			return $html;
		}

		public function add_class($class) {
			if (!empty($this->params['attrs']['class']))
				$this->params['attrs']['class'] = $class.' '.$this->params['attrs']['class'];
			else
				$this->params['attrs']['class'] = $class;
		}


		// Get attributes
		public function get_attrs() {
			if (empty($this->params['attrs']) && !is_array($this->params['attrs'])) return '';

			$attrs = array();
			foreach($this->params['attrs'] as $key=>$value) {
				$attrs[] = esc_attr($key).' = "'.esc_attr($value).'"';
			}
			return implode(' ', $attrs);
		}

		// Get field description
		public function get_desc() {
			if (empty($this->params['texts']['desc'])) return '';

			return '<div class="avaf-desc">' . $this->params['texts']['desc'] . '</div>';
		}

		// Get text before
		public function get_before() {
			if (empty($this->params['texts']['before'])) return '';

			return '<span class="avaf-before">' . $this->params['texts']['before'] . '</span>';
		}

		// Get text after
		public function get_after() {
			if (empty($this->params['texts']['after'])) return '';

			return '<span class="avaf-after">' . $this->params['texts']['after'] . '</span>';
		}
		
		// Get container object
		public function container() {
			return ava_fields()->container( $this->container_id );
		}
		
		// Get section object
		public function section() {
			return ava_fields()->section( $this->container_id, $this->section_id );
		}

		abstract public function build();


	}
}

