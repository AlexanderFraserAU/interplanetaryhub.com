<?php
    // QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss1
  require_once 'core/init.php';
  $user = new User();

  if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
  }

  if (Input::exists()) {
		if (Token::check(Input::get('token'))) {
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'hashname'	=> array(
					'fieldName'	=> 'Name',
					'required' 	=> true,
					'min'		=> 2,
					'max'		=> 50
				),
        'hash'    => array(
          'fieldName' => 'Hash',
          'required' => true,
          'unique' => 'links',
          'min'		=> 45,
					'max'		=> 47
        ),
        'file' => array(
          'fieldName' => 'File',
          'required' => true,
          'min'		=> 2,
					'max'		=> 99
        )
			));

			if ($validation->passed()) {
				$link = new Link();
        $log = new Log();
				try {
					$link->create(array(
						'name' => Input::get('hashname'),
            'hash' => Input::get('hash'),
            'file_extension' => Input::get('file'),
            'created' => date('Y-m-d H:i:s'),
            'user_id' => $user->data()->id
					));
          $link->newLink(array(
            'link_id' => $link->data()->id,
            'created' => $link->data()->created
          ));
          $log->createLink(array(
            'user_id' => $user->data()->id,
            'activity_type' => 1,
            'activity_reference' => $link->data()->id,
            'created' => $user->data()->created
          ));
					Session::flash('home','Your link has been created');
					Redirect::to('index.php');
				} catch (Exception $e) {
					die($e->getMessage());
				}
			} else {
				foreach ($validation->errors() as $error) {
					echo $error, '<br>';
				}
			}
		}
	}

?>
<form action="" method="post">
	<div class="field">
		<label for="hashname">Name</label>
		<input type="text" name="hashname" id="hashname" value="<?php echo escape(Input::get('hashname')); ?>" autocomplete="off"/>
	</div>
	<div class="field">
		<label for="hash">Hash</label>
		<input type="text" name="hash" id="hash" autocomplete="off"/>
	</div>
  <div class="field">
		<label for="file">File</label>
		<input type="text" name="file" id="file" autocomplete="off"/>
	</div>
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
	<input type="submit" value="Create"/>
</form>
