<?php
	/**
	* Lớp thực hiện thao tác làm việc với token.
	* @author Nguyễn Công Hoan
	* @copyright CongHoan Team
	* @category classes
	*/
	class Token {
		/**
		 * Hàm thực hiện tạo token.
		 *
		 * @return mixed
		 */
		public static function generate() {
			return Session::put(Config::get('session/tokenName'), md5(uniqid()));
		}

		/**
		 * Hàm thực hiện kiểm tra token.
		 *
		 * @param $token Giá trị token cần kiểm tra.
		 * @return bool
		 */
		public static function check($token) {
			$tokenName = Config::get('session/tokenName');

			if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
				Session::delete($tokenName);
				return true;
			} else {
				return false;
			}
		}
	}
?>