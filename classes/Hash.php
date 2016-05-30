<?php
	/**
	 * Lớp thực hiện thao tác làm việc với hàm băm.
	 *
	 * @author Nguyễn Công Hoan
	 * @copyright CongHoan Team
	 * @category classes
	*/
	class Hash {
		/**
		 * Hàm thực hiện băm đoạn ký tự nhập vào.
		 *
		 * @param $string Đoạn ký tự cần băm.
		 * @param string $salt Muối trộn thêm trong hàm băm.
		 * @return string
		 */
		public static function make($string, $salt = '') {
			return hash('sha256', $string.$salt);
		}

		/**
		 * Hàm thực hiện tạo muối.
		 *
		 * @param $length Độ dài của muối.
		 * @return string
		 */
		public static function salt($length) {
			return mcrypt_create_iv($length);
		}

		/**
		 * @return string
		 */
		public static function unique() {
			return self::make(uniqid());
		}
	}
?>