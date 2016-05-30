<?php
	/**
	* Lớp chứa các thao tác làm việc với Cookies.
	*
	* @author Nguyễn Công Hoan
	* @copyright CongHoan Team
	* @category classes
	*/
	class Cookie {
		/**
		* Hàm thực hiện kiểm tra sự tồn tại của cookie.
		*
		* @param string $name Tên cookie cần kiểm tra.
		* @return bool True nếu tồn tại, False nếu không tồn tại.
		*/
		public static function exists($name) {
			return (isset($_COOKIE[$name])) ? true : false;
		}

		/**
		* Hàm thực hiện lấy dữ liệu cookie.
		*
		* @param string $name Tên cookie cần lấy dữ liệu.
		* @return mixed 
		*/
		public static function get($name) {
			return $_COOKIE[$name];
		}

		/**
		* Hàm thực hiện thiết lập biến cookie.
		*
		* @param string $name Tên cookie sẽ thiết lập.
		* @param string $value Giá trị của biến cookie.
		* @param number $expiry Khoảng thời gian sống của cookie.
		* @return bool
		*/
		public static function put($name, $value, $expiry) {
			if (setcookie($name, $value, time()+$expiry, '/')) {
				return true;
			}
			return false;
		}
		/**
		* Hàm thực hiện xóa cookie
		*
		* @param string $name Tên cookie cần xóa.
		* @return void
		*/
		public static function delete($name) {
			self::put($name, '', time()-1);
		}
	}
?>