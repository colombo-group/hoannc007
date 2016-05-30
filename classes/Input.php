<?php

/**
 * Lớp thực hiện thao tác làm việc vơi dữ liệu đầu vào.
 * @author Nguyễn Công Hoan
 * @copyright CongHoan Team
 * @category classes
 */
	class Input {
		/**
		* Thực hiện kiểm biến đó có tồn tại hay không.
		*
		* @param string $type Loại phương thức kiểm tra "post" hoặc "get".
		* @return bool
		*/
		public static function exists($type = 'post') {
			switch ($type) {
				case 'post':
					return (!empty($_POST)) ? true : false;
					break;
				case 'get':
					return (!empty($_GET)) ? true : false;
					break;
				default:
					return false;
					break;
			}
		}
		/**
		* Thực hiện lấy dữ liệu biến.
		*
		* @param string $item Tên biến trong POST hoặc GET. 
		* @return string 
		*/
		public static function get($item) {
			if (isset($_POST[$item])) {
				return $_POST[$item];
			} else if (isset($_GET[$item])) {
				return $_GET[$item];
			}
			return '';
		}
	}
?>