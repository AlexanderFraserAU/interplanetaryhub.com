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
          if (vote == "2") {
            let currentVote = $(".upvotemodal").html();
            parseInt(currentVote) + 1;
            $(".upvotemodal").empty();
            $(".upvotemodal").html(currentVote);
            }
          else if (vote == "3") {
            let currentVote = $(".downvotemodal").html();
            parseInt(currentVote) + 1;
            $(".downvotemodal").empty();
            $(".downvotemodal").html(currentVote);
          }
          $.post("vote.php", { // Make it so that the page does not reload
            vote: vote,
            token: token,
            link_hash: link_hash
          });
        });
        $(".searchbar").keyup(function() {
          let search = $(".searchbar").val();
          if (search.charAt(search.length-1) == " ") {
            $.post("search.php", {
              search: search
            }, function(data, status) {
              $(".result").remove();
              let results = JSON.parse(data)
              for (var i = 0; i < results.length; i++) {
                addResult(i, "results", results[i].name, results[i].hash, results[i].file_extension, results[i].upvotes, results[i].downvotes);
              }
            });
          }
        });
      });
    </script>
<body>
Batman Dark
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
      <form id="hashModalForm">
        <input class="token" type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
        <button class="votebutton" type="input" value="2">upvote</button>
        <button class="votebutton" type="input" value="3">downvote</button>
    </div>
  </div>
</body>

<?php
	} else {
		echo "<p>You need to <a href='login.php'>login</a> or <a href='register.php'>register</a></p>";
	}
?>
