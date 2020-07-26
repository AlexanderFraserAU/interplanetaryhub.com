<?php
  require_once 'core/init.php';

  if (Input::exists()) { //Perhaps this code should go in "Link.php" but that would cause the database to be searched every time a link is created. Maybe create a new file for it
    $_db = Database::getInstance();
    $searchTerms = explode(' ', Input::get('search')); //Remove all spaces from array
    for ($i=0; $i < count($searchTerms); $i++) {
      if (!$searchTerms[$i] == "") {
        $databaseResults[] = $_db->search('links', array("name", "hash", "file_extension", "created"), $searchTerms[$i], "%%");
      }
    }
    foreach ($databaseResults as $$databaseResult) {

    }
    // for ($i=0; $i < ; $i++) {
    //   $links[] = new Link($i, "results_search", Input::get('search'));
    // }


  }
 ?>
