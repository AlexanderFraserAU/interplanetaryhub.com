<?php
  require_once 'core/init.php';

  if (Input::exists()) { //Perhaps this code should go in "Link.php" but that would cause the database to be searched every time a link is created. Maybe create a new file for it
    $searchEngine = new SearchEngine();
    $searchTerms = explode(' ', Input::get('search'));
    unset($searchTerms[count($searchTerms) - 1]); //removes the space from the last spot in the array
    try {
      $results = $searchEngine->search($searchTerms);
      echo json_encode($results); //Make it so that data that does not need to be sent is not sent
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }
 ?>
