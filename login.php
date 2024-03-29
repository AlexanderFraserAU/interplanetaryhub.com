

<?php
	require_once 'core/init.php';
	if (Input::exists()) {
		if (Token::check(Input::get('token'))) {
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username'	=> array(
					'fieldName'	=> 'Username',
					'required' 	=> true
				),
				'password'	=> array(
					'fieldName'	=> 'Password',
					'required' 	=> true
				)
			));

			if ($validation->passed()) {
				$user 		= new User();
				$remember 	= (Input::get('remember') === 'on') ? true : false;

				$login 		= $user->login(Input::get('username'),Input::get('password'), $remember);

				if ($login) {
					Redirect::to('index.php');
				} else {
					echo "Sorry we could not log you in";
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
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"/>
	</div>
	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password"/>
	</div>
	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember"/> Remember Me
		</label>
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
	<input type="submit" value="Login"/>
</form>
