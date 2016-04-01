<?php

namespace Sukohi\CodeceptionAutoFill {

	class CodeceptionAutoFill {

		private $_acceptance_tester;

		public function SetScenario($path) {

			$I = null;
			require_once $path;
			$this->_acceptance_tester = $I;

		}

		public function jsCode() {

			$fill_js = '';
			$form_values = $this->_acceptance_tester->getFormValues();

			if(empty($form_values)) {

				throw new \Exception('No data to fill found.');

			}

			foreach ($form_values as $value_obj) {

				$fill_js .= "\t\t\t\t". $this->getFillJs($value_obj) ."\n";

			}

			$stud = file_get_contents(__DIR__ .'/views/js.stud');
			return str_replace('{{ fill_js }}', $fill_js, $stud);

		}

		private function getFillJs($value_obj) {

			$selector = $this->getSelector($value_obj->selector);

			if($value_obj->type == 'checkOption') {

				return $selector .".prop('checked', true)";

			} else if($value_obj->type == 'uncheckOption') {

				return $selector .".prop('checked', false)";

			} else if($value_obj->type == 'selectOption') {

				return $selector .".val(['". $value_obj->value ."'])";

			}

			return $selector .".val('". $value_obj->value ."')";

		}

		private function getSelector($selector) {

			if(strpos($selector, '#') !== false ||
				strpos($selector, '.') !== false ||
				strpos($selector, '>') !== false ||
				strpos($selector, ',') !== false
			) {

				return "$('". $selector ."')";

			}

			return "$('[name=". $selector ."]')";

		}

		public static function js($path) {

			$auto_fill = new CodeceptionAutoFill();
			$auto_fill->SetScenario($path);
			return $auto_fill->jsCode();

		}

	}

}

namespace {

	class AcceptanceTester
	{

		private $_form_values;

		public function __call($name, $arguments)
		{

			$target_names = [
				'fillField',
				'selectOption',
				'checkOption',
				'uncheckOption',
			];

			if (in_array($name, $target_names)) {

				$value_obj = new \stdClass;
				$value_obj->type = $name;
				$value_obj->selector = $arguments[0];
				$value_obj->value = isset($arguments[1]) ? $arguments[1] : null;
				$this->_form_values[] = $value_obj;

			} else if($name == 'submitForm') {

				foreach ($arguments[1] as $key => $value) {

					$value_obj = new \stdClass;
					$value_obj->type = 'fillField';
					$value_obj->selector = $arguments[0] .' [name='. $key .']' ;
					$value_obj->value = $value;
					$this->_form_values[] = $value_obj;

				}

			}

		}

		public function getFormValues()
		{

			return $this->_form_values;

		}

	}

}