<?php
  require_once 'core/init.php';
  $user = new User();

  if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
  }

  if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
      $link = new Link();
      $type = Input::get('vote');
      if (true) { //Check if user has already voted
        $log = new Log();
        try {
          $link->vote($type, Input::get('link_hash'));
          $log->vote(array( //Make this work
            'user_id' => $user->data()->id,
            'activity_type' => $type,
            'activity_reference' => $link->data()->id,
            'created' => date('Y-m-d H:i:s') //May now be working, but may not be exsactly the same as the vote was created
          ));
        } catch (Exception $e) {
          die($e->getMessage());
        }
      }
    }
  }
