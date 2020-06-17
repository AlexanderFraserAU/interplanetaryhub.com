<?php
  class Link {
    private $_db;

    public function __construct() {
      $this->_db 			= Database::getInstance();
    }

    public function create($fields = array()) {
      if (!$this->_db->insert('links', $fields)) {
				throw new Exception("There was a problem creating your link");
			}
    }

  }
?>
