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
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>
<ul>
  <li><a href="update.php">Update Details</a></li>
  <li><a href="changepassword.php">Change Password</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>
<body>
    <header>
        <nav>
            <div class="center">
                <a href="index.html" class="centre-links">Home</a>
                <a href="#about" class="centre-links">About</a>
                <a href="#contact" class="centre-links">Contact us</a>
            </div>
            <div class="floated-links">
                <a href="signup.php" class="centre-links">Signup</a>
                <a href="login.php" class="centre-links">Login</a>
            </div>
        </nav>
        <div class="main-title">
            <h1>Webscape</h1>
            <p>Find the web developer for you...</p>
            <a href="signup.php"><strong>Signup now!!</strong></a>
        </div>
    </header>
    <main>
        <div class="wrapper">
            <div id="about">
                <h2>About Webscape</h2>
                <img src="" alt="">
                <p></p>
            </div>
            <div id="contact">

            </div>
        </div>
    </main>
    <footer>
        <p>2020 &copy All Rights Reserved. <a href="#" class="footer-links">Privacy Policy</a> | <a href="#" class="footer-links">Terms of Use</a> | <a href="#" class="footer-links">License</a> | <a href="#" class="footer-links">Support</a></p>
    </footer>
</body>
</html>

<?php
	} else {
		echo "<p>You need to <a href='login.php'>login</a> or <a href='register.php'>register</a></p>";
	}
?>
