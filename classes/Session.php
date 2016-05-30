<?php
	/**
	 * Lớp thực hiện thao tác làm việc với Session.
	 *
	 * @author Nguyễn Công Hoan
	 * @copyright CongHoan Team
	 * @category classes
	*/
	class Session {
		/**
		 * Hàm thực hiện kiểm tra tên biến có tồn tại không.
		 *
		 * @param string $name Tên biến Session.
		 * @return bool
		 */
		public static function exists($name) {
			return (isset($_SESSION[$name])) ? true : false;
		}

		/**
		 * Hàm thực hiện thiết lập giá trị của Session.
		 *
		 * @param $name Tên biến thiết lập.
		 * @param $value Giá trị được thiết lập cho biến.
		 * @return mixed
		 */
		public static function put($name, $value) {
			return $_SESSION[$name] = $value;
		}

		/**
		 * Hàm thực hiện lấy giá trị theo tên biến.
		 *
		 * @param string $name Tên biến cần lấy.
		 * @return mixed
		 */
		public static function get($name) {
			return $_SESSION[$name];
		}

		/**
		 * Hàm thực hiện hủy bỏ session.
		 *
		 * @param $name Tên biến cần hủy b.ỏ
		 * @return void
		 */
		public static function delete($name) {
			if (self::exists($name)) {
				unset($_SESSION[$name]);
			}
		}

		/**
		 * Hàm thực hiện thiết lập session cho flash.
		 *
		 * @param string $name Tên biến.
		 * @param string $string
		 * @return mixed
		 */
		public static function flash($name, $string = '') {
			if (self::exists($name)) {
				$session = self::get($name);
				self::delete($name);
				return $session;
			} else {
				self::put($name, $string);
			}
		}
	}	
?>