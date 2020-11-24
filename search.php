
<?php
  require_once 'core/init.php';

  if (Input::exists()) { //Perhaps this code should go in "Link.php" but that would cause the database to be searched every time a link is created. Maybe create a new file for it
    $searchEngine = new SearchEngine();
    $fileTypeFilter = Input::get('fileType');
    $searchTerms = explode(' ', Input::get('search'));
    unset($searchTerms[count($searchTerms) - 1]); //removes the space from the last spot in the array
    try {
        $results = $searchEngine->search($searchTerms);
        if ($fileTypeFilter == "other") { //This is temp, "other" does not do anything atm
          echo json_encode($results);
        }
        if ($fileTypeFilter != "any") {
          $resultsLength = count($results);
          for ($i=0; $i < $resultsLength; $i++) {
            $fileType = explode('.', $results[$i]->file_extension);
            if (!in_array($fileType[count($fileType) - 1], Config::get("filetypes")[$fileTypeFilter])) {
              unset($results[$i]);
            }
          }
        }
        echo json_encode($results); //Make it so that data that does not need to be sent is not sen --- ???
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }
 ?>
