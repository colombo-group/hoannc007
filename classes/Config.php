<?php
	/**
	* Lớp thực hiện thao tác làm việc với cấu hình.
	*@author Nguyen Cong Hoan
	*@method bool 
	* @category classes
	*/
	class Config {
		/**
		* 
		* Lấy giá trị từ biến toàn cục cấu hình. 
		*
		* @param string $path Tên index lần lượt của giá trị trong mảng config cần lấy ra.
		* @return string|false Nếu tồn tại index trả về giá trị của nó, nếu không tồn tại trả về là false.
		*/
		public static function get($path = null) {
			if ($path) {
				$config = $GLOBALS['config'];

				$path	= explode('/', $path);

				foreach ($path as $bit) {
					if (isset($config[$bit])) {
						$config = $config[$bit];
					}
				}

				return $config;
			}
			
			return false;
		}
	}
?>