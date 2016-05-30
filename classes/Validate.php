<?php
	/**
	* Lớp thực hiện thao tác kiểm tra dữ liệu đầu vào.
	* @author Nguyễn Công Hoan
	* @copyright CongHoan Team
	* @category classes
	*/
	class Validate {
		/**
		 * @var bool $_passed Trạng thái kiểm tra có qua hay không.
		 * @var array $_errors Danh sách các lỗi khi thực hiện kiểm tra.
		 * @var $_db
		 */
		private $_passed = false,
				$_errors = array(),
				$_db = null;

		/**
		 * Hàm khởi tạo lớp.
		 *
		 */
		public function __construct() {
			$this->_db = Database::getInstance();
		}

		/**
		 * Hàm thực hiện kiểm tra dữ liệu vào.
		 *
		 * @param $source Nguồn cần kiểm tra.
		 * @param array $items Danh sách các loại luật cần kiểm tra.
		 * @return $this
		 */
		public function check($source, $items = array()) {
			foreach ($items as $item => $rules) {
				foreach ($rules as $rule => $rule_value) {
					$value 	= trim($source[$item]);
					$item 	= escape($item);
					
					if ($rule === 'required' && empty($value)) {
						$this->addError("{$item} is required");	//ToDo: Pick up 'name' value
					} else if (!empty($value)) {
						switch ($rule) {
							case 'min':
								if (strlen($value) < $rule_value) {
									$this->addError("{item} must be a minimum of {$rule_value} characters");
								}
								break;
							case 'max':
								if (strlen($value) > $rule_value) {
									$this->addError("{item} must be no longer than {$rule_value} characters");
								}
								break;
							case 'matches':
								if ($value != $source[$rule_value]) {
									$this->addError("{$rule_value} must match {$item}");
								}
								break;
							case 'unique':
								$check = $this->_db->get($rule_value,array($item, '=' , $value));
								if ($check->count()) {
									$this->addError("{$item} already exists");
								}
								break;
						}
					}
				}
			}

			if (empty($this->_errors)) {
				$this->_passed = true;
			}

			return $this;
		}

		/**
		 * Hàm thực hiện thêm lỗi mới vào danh sách lỗi.
		 * @param string $error Tên lỗi cần thông báo.
		 * @return void
		 */
		private function addError($error) {
			$this->_errors[] = $error;
		}

		/**
		 * Hàm thực hiện lấy danh sách các lỗi gặp phải.
		 * @return array
		 */
		public function errors() {
			return $this->_errors;
		}

		/**
		 * Hàm thực hiện kiểm tra trạng thái có vượt qua hay không.
		 * @return bool
		 */
		public function passed() {
			return $this->_passed;
		}
	}
?>