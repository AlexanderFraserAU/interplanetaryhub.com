<?php
  class Log {
    private $_db;

    public function __construct() {
      $this->_db 			= Database::getInstance();
    }

    public function createLink($fields = array()) {
      if (!$this->_db->insert('activity_log', $fields)) {
				throw new Exception("There was a problem logging the creation of your link");
			}
    }
  }
 ?>
