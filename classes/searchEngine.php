<?php //Add exception errors
  class SearchEngine {
    private $_db,
            $_comparedIds = array(0), //Array of comapred ID's
            $_resultsIds = array(0);

    public function __construct() {
      $this->_db 			= Database::getInstance();
    }

    public function search($searchTerms) {
      $databaseResults = array();
      for ($i=0; $i < count($searchTerms); $i++) {
        if (!$searchTerms[$i] == "") {
          $databaseResults[] = $this->_db->search('links', array("name", "hash", "file_extension", "created"), $searchTerms[$i], "%%");
          $databaseResults[$i] = $databaseResults[$i]->results();
        }
      }
      $tallyedResults = $this->tallyResults($databaseResults);
      $talleyedResultsDuplicateFree = $this->removeDuplicates($tallyedResults);
      $tallyedResultsInOrder = $this->orderResults($talleyedResultsDuplicateFree);
      return $tallyedResultsInOrder;
    }

    public function tallyResults($databaseResults = array()) {
      if (false) { //Do a check if there is only one result
        return $databaseResults;
      }
      for ($a=0; $a < count($databaseResults); $a++) { //Database result Main
        for ($b=0; $b < count($databaseResults[$a]); $b++) { //Specific database result
          $needle = $databaseResults[$a][$b]->id; //Neddle in haystack? Makes it 15x faster
          $flipped_haystack = array_flip($this->_comparedIds);  //https://www.php.net/manual/en/function.in-array.php
          if (isset($flipped_haystack[$needle])) { //Checks if value has already been checked to avoid duplicates //if (in_array($databaseResults[$a][$b]->id, $this->_comparedIds[])) { may also work
            continue; //The reason for not using a ! is because that was not working
          }
          $this->_comparedIds[] = $databaseResults[$a][$b]->id; //Adds ID into array
          $databaseResults[$a][$b]->searchScore = 0; //Initialise results search score
          for ($c=0; $c < count($databaseResults); $c++) { //Database result comparison
            if (!$a == $c) { //Makes sure results arent compared with themselves
              for ($d=0; $d < count($databaseResults[$c]); $d++) { //Specific result to compare
                if ($databaseResults[$a][$b]->id == $databaseResults[$c][$d]->id) { //Compares results ID's
                  $databaseResults[$a][$b]->searchScore += 1; //Increases search score
                }
              }
            }
          } //Batman Dark
        }
      }
      return $databaseResults;
    }

    public function removeDuplicates($tallyedResults = array()) { //Puts all in one array and removes duplicates
      $duplicateFree = array();
      for ($a=0; $a < count($tallyedResults); $a++) {
        for ($b=0; $b < count($tallyedResults[$a]); $b++) {
          $needle = $tallyedResults[$a][$b]->id; //Neddle in haystack? Makes it 15x faster //May make it slower
          $flipped_haystack = array_flip($this->$_resultsIds);  //https://www.php.net/manual/en/function.in-array.php
          if (isset($flipped_haystack[$needle])) {
            continue;
          }
          $this->$_resultsIds[] = $tallyedResults[$a][$b]->id;
          $duplicateFree[] = $tallyedResults[$a][$b];
        }
      }
      return $duplicateFree;
    }

    public function orderResults($tallyedResults = array()) { //Orders by search score and votes
      $tallyedResultsInOrder = array();
      for ($i=0; $i < count($tallyedResults); $i++) {
        $searchScoreLargestIndex = 0;
        for ($a=0; $a < count($tallyedResults); $a++) {
          if ($tallyedResults[$a]->searchScore > $tallyedResults[$searchScoreLargestIndex]->searchScore) {
            $searchScoreLargestIndex = $a;
          }
        }
        $tallyedResultsInOrder[$i] = $tallyedResults[$searchScoreLargestIndex];
        $tallyedResults[$searchScoreLargestIndex]->searchScore = -1;
      }
      return $tallyedResultsInOrder;
    }

  }

 ?>
