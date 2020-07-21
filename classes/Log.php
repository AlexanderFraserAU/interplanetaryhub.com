<?php
  class Log { // Maybe disolve this into each section. For example move createLink to Link.php
    private $_db;

    public function __construct() {
      $this->_db 			= Database::getInstance();
    }

    public function createLink($fields = array()) {
      if (!$this->_db->insert('activity_log', $fields)) {
				throw new Exception("There was a problem logging the creation of your link");
			}
    }

    public function vote($fields = array()) {
      if (!$this->_db->insert('activity_log', $fields)) {
				throw new Exception("There was a problem logging the creation of your link");
			}
    }
  } // Maybe add 'activity_type' => in each section, for example vote() is 'activity_type' => 2
 ?>
