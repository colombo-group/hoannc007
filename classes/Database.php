<?php
	/**
	 * Lớp thực hiện thao tác làm việc với cơ sở dữ liệu.
	 *
	 * @author Nguyễn Công Hoan
	 * @copyright CongHoan Team
	 * @category classes
	*/
	class Database {
		/**
		 * @var string|null $_instance Tên một thể hiện của lớp.
		 */
		private static $_instance = null;
		/**
		 * @var string $_pdo
		 * @var string $_query
		 * @var bool|null $_error
		 * @var string $_results
		 * @var interger|0 $_count
		*/
		private $_pdo,
				$_query,
				$_error = false,
				$_results,
				$_count = 0;
		/**
		 * Hàm khởi tạo mặc định kết nối với cơ sở dữ liệu
		*/
		private function __construct() {
			try {
				$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		/**
		* 
		*/

		public static function getInstance() {
			if (!isset(self::$_instance)) {
				self::$_instance = new Database();
			}
			return self::$_instance;
		}
		/**
		* Hàm thực hiện câu truy vấn sql.
		*
		* @param string $sql Cấu truy vấn sql cần thực hiện.
		* @param array $params Danh sách các tham số.
		* @return $this
		*/
		public function query($sql, $params = array()) {
			$this->_error = false;
			if ($this->_query = $this->_pdo->prepare($sql)) {
				$x = 1;
				if (count($params)) {
					foreach ($params as $param) {
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}

				if ($this->_query->execute()) {
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count	= $this->_query->rowCount();
				} else {
					$this->_error = true;
				}
			}

			return $this;
		}
		/**
		* Hàm thực hiện các loại lệnh trong câu truy vấn sql.
		*
		* @param string $action Loại lệnh thực hiện.
		* @param string $table Tên bảng cơ sở dữ liệu.
		* @param array $where
		* @return mixed
		*/
		public function action($action, $table, $where = array()) {
			if (count($where) === 3) {	//Allow for no where
				$operators = array('=','>','<','>=','<=','<>');

				$field		= $where[0];
				$operator	= $where[1];
				$value		= $where[2];

				if (in_array($operator, $operators)) {
					$sql = "{$action} FROM {$table} WHERE ${field} {$operator} ?";
					if (!$this->query($sql, array($value))->error()) {
						return $this;
					}
				}
			}
			return false;
		}
		/**
		* Thực hiện lấy dữ liệu từ bảng với điều kiện.
		*
		* @param string $table Tên bảng cơ sở dữ liệu.
		* @param string $where Câu truy vấn điều kiện.
		* @return mixed
		*/
		public function get($table, $where) {
			return $this->action('SELECT *', $table, $where); //ToDo: Allow for specific SELECT (SELECT username)
		}

		/**
		* Hàm thực hiện câu lệnh xóa trong cơ sở dữ liệu.
		*
		* @param string $table Tên bảng cơ sở dữ liêu.
		* @param string $where Câu truy vấn điều kiện
		* @return mixed
		*/
		public function delete($table, $where) {
			return $this->action('DELETE', $table, $where);
		}

		/**
		 * Hàm thực hiện chèn thêm mới trường dữ liệu trong cơ sở dữ liệu.
		 *
		 * @param string $table Tên bảng cơ sở dữ liệu.
		 * @param array $fields Danh sách các trường dữ liệu thêm mới.
		 * @return bool
		*/

		public function insert($table, $fields = array()) {
			if (count($fields)) {
				$keys 	= array_keys($fields);
				$values = null;
				$x 		= 1;

				foreach ($fields as $field) {
					$values .= '?';
					if ($x<count($fields)) {
						$values .= ', ';
					}
					$x++;
				}

				$sql = "INSERT INTO {$table} (`".implode('`,`', $keys)."`) VALUES({$values})";

				if (!$this->query($sql, $fields)->error()) {
					return true;
				}
			}
			return false;
		}
		/**
		 * Hàm thực hiện cập nhật dữ liệu trong cơ sở dữ liệu.
		 *
		 * @param string $table Tên bảng cơ sở dữ liêu.
		 * @param number $id Khóa của dòng dữ liệu.
		 * @param array $fields Danh sách các trường dữ liêu.
		 * @return bool
		*/
		public function update($table, $id, $fields = array()) {
			$set 	= '';
			$x		= 1;

			foreach ($fields as $name => $value) {
				$set .= "{$name} = ?";
				if ($x<count($fields)) {
					$set .= ', ';
				}
				$x++;
			}

			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
			
			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
			return false;
		}
		/**
		* Hàm thực hiện lấy kết quả dữ liệu.
		*
		* @return mixed
		*/
		public function results() {
			return $this->_results;
		}

		/**
		 * Hàm thực hiện lấy kết quả đầu tiên của dữ liệu.
		 *
		 * @return mixed
		*/
		public function first() {
			return $this->_results[0];
		}

		/**
		 * Hàm thực hiện lấy thông báo lỗi.
		 *
		 * @return string
		*/
		public function error() {
			return $this->_error;
		}

		/**
		 * Hàm thực hiện lấy số bản ghi.
		 *
		 * return number
		*/
		public function count() {
			return $this->_count;
		}
	}
?>