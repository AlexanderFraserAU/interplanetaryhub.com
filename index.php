<?php
require_once 'core/init.php';
if (Session::exists('home')) {
  echo Session::flash('home');
}



$user = new User();
if ($user->isLoggedIn()) {
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="javascript/script.js" type="text/javascript">
    </script>
<body>
  <div class="logo">Logo</div>
  <div class="nav">Nav
    <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>
    <ul>
      <li><a href="update.php">Update Details</a></li>
      <li><a href="changepassword.php">Change Password</a></li>
      <li><a href="logout.php">Logout</a></li>
      <li><a href="createlink.php">Create Link</a></li>
    </ul>
  </div>
  <main>
    <div class="featured" id="featured">Featured
    </div>
    <div class="search">
      <div class="filterbox">

      </div>
      <input type="text" class="searchbar" placeholder="What are you looking for..."></input>
      <div class="results" id="results">
      </div>
    </div>
  </main>
  <div class="footer">Footer</div>
</body>

<?php
	} else {
		echo "<p>You need to <a href='login.php'>login</a> or <a href='register.php'>register</a></p>";
	}
?>
