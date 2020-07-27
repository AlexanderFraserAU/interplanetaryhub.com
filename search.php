<?php
  require_once 'core/init.php';

  if (Input::exists()) { //Perhaps this code should go in "Link.php" but that would cause the database to be searched every time a link is created. Maybe create a new file for it
    $searchEngine = new SearchEngine();
    $searchTerms = explode(' ', Input::get('search')); //Remove all spaces from array
    try {
      $results = $searchEngine->search($searchTerms);
      //Make $results paletable for ajax
      return $results;
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }
 ?>
