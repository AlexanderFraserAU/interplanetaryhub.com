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
            $this->_data  = $data->index(0);
            if ($data->count()) {
              $this->_data  = $data->index(0);
            }
            break;
          case "results_initial":
            $newLinks = $this->_db->getInOrder('new_links', 'created', 'ASC');
            if ($newLinks->count()) {
              $newLink = $newLinks->index($number);
              $data 	= $this->_db->get('links', array('id', '=', $newLink->id));
              if ($data->count()) {
                $this->_data  = $data->index(0);
              }
            }
            break;
          case "results_search":

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
        $this->_data  = $data->index(0);
        //Maybe move functions such as newLink() and $log->createLink() here
      }
    }

    public function newLink($fields = array()) {
      if (!$this->_db->insert('new_links', $fields)) {
        die("There was a problem creating your link"); // throw new Exception("There was a problem creating your link");
			}
      $newLinks = $this->_db->getInOrder('new_links', 'created', 'DESC'); // ASC / DESC
      if ($newLinks->count()) {
        $oldLink = $newLinks->index(0);
        $this->_db->delete('new_links', array('id', '=', $oldLink->id));
      }
    }

    public function find($link = null) {
      if ($link) {
				$fields = (is_numeric($link)) ? 'id' : 'name';	//Numbers in link issues
				$data 	= $this->_db->get('links', array($fields, '=', $link));

				if ($data->count()) {
					$this->_data = $data->index(0);
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
