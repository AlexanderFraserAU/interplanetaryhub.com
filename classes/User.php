<?php
	class User {
		private $_db,
				$_data,
				$_sessionName,
				$_cookieName,
				$_isLoggedIn;

		public function __construct($user = null) {
			$this->_db = Database::getInstance();
			$this->_sessionName = Config::get('session/sessionName'); //Config::get('session/sessionName');
			$this->_cookieName = Config::get('remember/cookieName'); //Config::get('remember/cookieName');

			if (!$user) {
				if (Session::exists($this->_sessionName)) {
					$user = Session::get($this->_sessionName);

					if ($this->find($user)) {
						$this->_isLoggedIn = true;
					} else {
						self::logout();
					}
				}
			} else {
				$this->find($user);
			}
		}

		public function update($fields = array(), $id = null) {

			if (!$id && $this->isLoggedIn()) {
				$id = $this->data()->id;
			}

			if (!$this->_db->update('users', $id, $fields)) {
				throw new Exception("There was a problem updating your details");
			}
		}

		public function create($fields = array()) {
			if (!$this->_db->insert('users', $fields)) {
				throw new Exception("There was a problem creating your account");
			}
		}

		public function find($user = null) {
			if ($user) {
				$fields = (is_numeric($user)) ? 'id' : 'username';	//Numbers in username issues
				$data 	= $this->_db->get('users', array($fields, '=', $user));

				if ($data->count()) {
					$this->_data = $data->index(0);
					return true;
				}
			}
			return false;
		}

		public function login($username = null, $password = null, $remember = false) {
			if (!$username && !$password && $this->exists()) {
				Session::put($this->_sessionName, $this->data()->id);
			} else {
				$user = $this->find($username);
				if ($user) {
					if ($this->data()->password === Hash::make($password,base64_decode($this->data()->salt))) { //Base64_decode because it was put like that into database
						Session::put($this->_sessionName, $this->data()->id);
						if ($remember) {
							$hash = Hash::unique();
							$hashCheck = $this->_db->get('users_session', array('user_id','=',$this->data()->id));

							if (!$hashCheck->count()) {
								$this->_db->insert('users_session', array(
									'user_id' 	=> $this->data()->id,
									'HASH' 		=> $hash
								));
							} else {
								$hash = $hashCheck->index(0)->hash;
							}
							//setcookie($this->_cookieName, $hash, config::get('remember/cookieExpiry'));
							Cookie::put($this->_cookieName, $hash, Config::get('remember/cookieExpiry')); //Config::get('remember/cookieExpiry')
						}
						return true;
					}
				}
			}
			return false;
		}

		public function hasPermission($key) {
			$group = $this->_db->get('groups', array('id', '=', $this->data()->userGroup));
			if ($group->count()) {
				$permissions = json_decode($group->index(0)->permissions,true);

				if ($permissions[$key] == true) {
					return true;
				}
			}
			return false;
		}

		public function exists() {
			return (!empty($this->_data)) ? true : false;
		}

		public function logout() {
			$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
			Session::delete($this->_sessionName);
			Cookie::delete($this->_cookieName);
		}

		public function data() {
			return $this->_data;
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}
	}
?>
