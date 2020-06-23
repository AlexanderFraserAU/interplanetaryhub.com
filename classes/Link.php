<?php
  class Link {
    private $_db,
            $_data,
            $_type;

    public function __construct($number = null, $type = null) {
      $this->_db 			= Database::getInstance();

      if ($type) {
        switch ($type) {
          case 'featured':
            $data 	= $this->_db->get('featured_links', array('id', '=', $number));
            $this->_data  = $data->first();
            if ($data->count()) {
              $this->_data  = $data->first();
            }
            break;
          case "results_initial":
            $data 	= $this->_db->get('links', array('id', '=', $number));
            if ($data->count()) {
              $this->_data  = $data->first();
            }
            break;
          default:
            // code...
            break;
        }
      }
    }

    public function create($fields = array()) {
      if (!$this->_db->insert('links', $fields)) {
        die("There was a problem creating your link"); // throw new Exception("There was a problem creating your link");
			}
      $data 	= $this->_db->get('links', array('hash', '=', $fields['hash']));
      if ($data->count()) {
        $this->_data  = $data->first();
      }
    }

    public function find($link = null) {
      if ($link) {
				$fields = (is_numeric($link)) ? 'id' : 'name';	//Numbers in link issues
				$data 	= $this->_db->get('links', array($fields, '=', $link));

				if ($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
    }

    public function getFeatured() {
      return;
    }

    public function getResults() {
      return;
    }

    public function data() {
      return $this->_data;
    }

  }
?>
