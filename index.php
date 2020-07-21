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
    <script src="javascript/script.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- Obscure all javascript!-->
    <script>
      $(document).ready(function() {
        $(".votebutton").click(function() {
          let vote = $(this).val();
          let token = $(this).parent().find(".token").val();
          let link_hash = $(this).parent().find(".link_hash").val();
          $.post("vote.php", {
            vote: vote,
            token: token,
            link_hash: link_hash
          });
        });
      });
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
      <input type="text" class="searchbar" placeholder="What are you looking for..."></input>
      <div class="resultinfo">This will contain the type of fesults i.e. History, newest, search results (You have recieved 10,100 results in 2 seconds)</div>
      <div class="results" id="results">
      </div>
    </div>
  </main>
  <div class="footer">Footer</div>

  <!-- Modal -->
  <div id="hashModal" class="modal">

    <!-- Modal content -->
    <div id="hashModalContent" class="modal-content">
      <span class="close">&times;</span>
      <form method="post" id="hashModalForm">
        <input class="token" type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
        <button class="votebutton" type="input" value="2">upvote</button>
        <button class="votebutton" type="input" value="3">downvote</button>
    </div>

  </div>
</body>

<?php
  try {
    // for ($i=1; $i < 3; $i++) { //Featured
    //   $location = "featured";
    //   $link = new Link($i, $location);
    //   echo "<script> addResult({$i}, {$location}, {$link->data()->name}, {$link->data()->hash}, {$link->data()->upvotes}, {$link->data()->downvotes}) </script>";
    // }
    echo "<script>";
    for ($i=0; $i <= 5; $i++) { //Results
      $location = "results_initial";
      $link = new Link($i, $location);
      $location = explode('_', $location);
      $location = $location[0]; $location = '"' . $location . '"';
      $data = json_decode(json_encode($link->data()), 1);
      $name = $data['name']; $name = '"' . $name . '"';
      $hash = $data['hash']; $hash = '"' . $hash . '"';
      $file = $data['file_extension']; $file = '"' . $file . '"';
      $upvotes = $data['upvotes']; $downvotes = $data['downvotes'];
      echo "addResult({$i}, {$location}, {$name}, {$hash}, {$file}, {$upvotes}, {$downvotes});";
    }
    echo "</script>";
  } catch (Exception $e) {
    die($e->getMessage());
  }
	} else {
		echo "<p>You need to <a href='login.php'>login</a> or <a href='register.php'>register</a></p>";
	}
?>
