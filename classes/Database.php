<?php
	class Database {
		private static $_instance = null;
		private $_pdo,
				$_query,
				$_error = false,
				$_results,
				$_count = 0;

		private function __construct() {
			try {
				$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
				//$this->_pdo = new PDO("mysql:host=localhost;dbname=interplanetaryhub;charset=utf8mb4", "interplanetaryhub", "Warlus123!");
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		public static function getInstance() {
			if (!isset(self::$_instance)) {
				self::$_instance = new Database();
			}
			return self::$_instance;
		}

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

		public function action($action, $table, $where = array()) {
			if (count($where) === 3) {	//Allow for no where
				$operators = array('=','>','<','>=','<=','<>');

				$field		= $where[0];
				$operator	= $where[1];
				$value		= $where[2];

				if (in_array($operator, $operators)) {
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
					if (!$this->query($sql, array($value))->error()) {
						return $this;
					}
				}
			}
			return false;
		}

		public function get($table, $where) {
			return $this->action('SELECT *', $table, $where); //ToDo: Allow for specific SELECT (SELECT username)
		}

		public function delete($table, $where) {
			return $this->action('DELETE', $table, $where);
		}

		public function getInOrder($table, $order, $orderType) { // Get a table ordered by something // May want to get rid of $where //May want to add a $limit
			return $this->actionInOrder('SELECT *', $table, $order, $orderType);
		}

		public function actionInOrder($action, $table, $order, $orderType) {
			$sql = "{$action} FROM {$table} ORDER BY ? {$orderType}";
			if (!$this->query($sql, array($order))->error()) {
				return $this;
			}
			return false;
		}

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

		public function update($table, $id, $fields = array(), $set='') {
			$x		= 1;

			if ($set=='') {
				foreach ($fields as $name => $value) {
					$set .= "{$name} = ?";
					if ($x<count($fields)) {
						$set .= ', ';
					}
					$x++;
				}
			}

			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
			return false;
		}

		public function increment($table, $id, $field) {
				$this->update($table, $id, array(), "{$field}={$field}+1");
		}

		public function search($table, $fields = array(), $searchKey, $searchMethod) { //Search method only works for %% curently
			$x		= 1;
			$terms;

			foreach ($fields as $column) {
				$terms .= "{$column} LIKE '%{$searchKey}%'";
				if ($x<count($fields)) {
					$terms .= " OR ";
				}
				$x++;
			}

			$sql = "SELECT * FROM {$table} WHERE {$terms}";

			if (!$this->query($sql, $fields)->error()) {
				return $this;
			}
			return false;
		}

		public function results() {
			return $this->_results;
		}

		public function index($index) {
			return $this->_results[$index];
		}

		public function error() {
			return $this->_error;
		}

		public function count() {
			return $this->_count;
		}
	}
?>
