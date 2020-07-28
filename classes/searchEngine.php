<?php //Add exception errors //Batman Dark
  class SearchEngine {
    private $_db,
            $_comparedIds = array(0), //Array of comapred ID's
            $_resultsIds = array(0); //Maybe redundant/unused

    public function __construct() {
      $this->_db 			= Database::getInstance();
    }

    public function search($searchTerms) {
      $databaseResults = array();
      for ($i=0; $i < count($searchTerms); $i++) {
        if (strlen($searchTerms[$i]) < 30) { //If the word is smaller than 30 chars its most likely its not a hash
          $databaseResults[] = $this->_db->search('links', array("name", "file_extension", "created"), $searchTerms[$i], "%%");
          $databaseResults[$i] = $databaseResults[$i]->results();
        }
        else {
          $databaseResults[] = $this->_db->search('links', array("name", "hash", "file_extension", "created"), $searchTerms[$i], "%%");
          $databaseResults[$i] = $databaseResults[$i]->results();
        }
      }
      $tallyedResults = $this->tallyResults($databaseResults);
      $talleyedResultsDuplicateFree = $this->removeDuplicates($tallyedResults);
      $tallyedResultsInOrder = $this->orderResults($talleyedResultsDuplicateFree);
      return $tallyedResultsInOrder;
    }

    public function tallyResults($databaseResults = array()) { //Compares if there are duplicate entries. IF thier are they get a point
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
          }
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
      for ($i=0; $i < count($tallyedResults); $i++) { //Orders by search score first
        $searchScoreLargestIndex = 0;
        for ($a=0; $a < count($tallyedResults); $a++) {
          if ($tallyedResults[$a]->searchScore > $tallyedResults[$searchScoreLargestIndex]->searchScore) {
            $searchScoreLargestIndex = $a;
          }
        }
        $tallyedResultsInOrder[$i] = $tallyedResults[$searchScoreLargestIndex]; //Keeps searchScore Avaliable as searchScoreSave
        $tallyedResults[$searchScoreLargestIndex]->searchScoreSave = $tallyedResults[$searchScoreLargestIndex]->searchScore;
        $tallyedResults[$searchScoreLargestIndex]->searchScore = -1;
      }
      $resultsScores = array();
      for ($i=0; $i < count($tallyedResultsInOrder); $i++) { // Deal with / by 0
        if ($tallyedResultsInOrder[$i]->upvotes == 0 && $tallyedResultsInOrder[$i]->downvotes == 0) {
          $resultsScores[] = 1;
        }
        else if ($tallyedResultsInOrder[$i]->upvotes == 0) {
          $resultsScores[] = 1 / $tallyedResultsInOrder[$i]->downvotes - 0.0001; //The 0.01 gives those who only have downvotes a slight disadvantage over those with no votes
        }
        else if ($tallyedResultsInOrder[$i]->downvotes == 0) {
          $resultsScores[] = $tallyedResultsInOrder[$i]->upvotes / 1 + 0.0001; //The 0.01 gives those who only have upvotes an advantage
        }
        else {
          $resultsScores[] = $tallyedResultsInOrder[$i]->upvotes / $tallyedResultsInOrder[$i]->downvotes;
        }
      }
      for ($i=0; $i < count($tallyedResultsInOrder); $i++) { //Order results according to search score and votes
        if ($tallyedResultsInOrder[$i+1] != null) {
          if ($tallyedResultsInOrder[$i]->searchScoreSave == $tallyedResultsInOrder[$i+1]->searchScoreSave) {
            if ($resultsScores[$i] < $resultsScores[$i+1]) {
              //Swap the resultsScore
              $swap = $resultsScores[$i];
              $resultsScores[$i] = $resultsScores[$i+1];
              $resultsScores[$i+1] = $swap;
              //Swap the results
              $swap = $tallyedResultsInOrder[$i];
              $tallyedResultsInOrder[$i] = $tallyedResultsInOrder[$i+1];
              $tallyedResultsInOrder[$i+1] = $swap;
              $i=0;
            }
          }
        }
      }
      return $tallyedResultsInOrder;
    }

  }
 ?>
