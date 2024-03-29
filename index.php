<?php

require_once 'core/init.php';
if (Session::exists('home')) {
  echo Session::flash('home');
}
//setcookie('HASH', 'test', time() + 604800, '/'); //asgfashjastfash
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/test.css">
    <script src="javascript/script.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        $("#searchbar").keyup(function() {
          let search = $("#searchbar").val();
          if (search.charAt(search.length-1) == " ") {
            let fileType = $("#file-type-options input[type='radio']:checked").val();
            $.post("search.php", {
              search: search,
              fileType: fileType
            }, function(data, status) {
              $(".result").remove();
              let results = JSON.parse(data);
              for (var i = 0; i < results.length; i++) {
                addResult(i, "results", results[i].name, results[i].hash, results[i].file_extension, results[i].username, results[i].created, results[i].upvotes, results[i].downvotes);
              }
            });
          }
        });
      });
    </script>
<body>
  <div id="header">
    <svg id="solar-system" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 972.34 569.59"><defs><style>.cls-1{fill:blue;}.cls-1,.cls-10,.cls-11,.cls-5,.cls-6,.cls-7,.cls-8,.cls-9{stroke:#000;stroke-miterlimit:10;}.cls-1,.cls-10,.cls-5,.cls-7{stroke-width:2px;}.cls-2,.cls-7{fill:#f15a24;}.cls-3,.cls-5{fill:#3cf;}.cls-4{fill:#f9ca11;}.cls-11,.cls-6{fill:#fff;}.cls-8{fill:#39b54a;}.cls-11,.cls-8,.cls-9{stroke-width:0.5px;}.cls-9{fill:gray;}.cls-10{fill:#f9cc11;}</style></defs><ellipse class="cls-1" cx="682.11" cy="521.6" rx="435.74" ry="160.24" transform="translate(-368.51 156.05) rotate(-28.15)"/><circle class="cls-2" cx="290.47" cy="709.19" r="87.36" transform="translate(-619.51 185.66) rotate(-45)"/><circle class="cls-3" cx="864.19" cy="87.36" r="87.36"/><ellipse class="cls-4" cx="474.9" cy="272.76" rx="218.95" ry="212.37"/><path class="cls-5" d="M1059.2,401.79c28.32-52.05,4.41-87,4.41-87" transform="translate(-203.11 -227.45)"/><path class="cls-6" d="M356.93,765.88" transform="translate(-203.11 -227.45)"/><path class="cls-7" d="M362.72,767.11c-63.08-13-66.13-32.58-64.81-39.94" transform="translate(-203.11 -227.45)"/><ellipse class="cls-8" cx="1019.24" cy="340.72" rx="33.9" ry="59.65" transform="translate(-243.3 293.7) rotate(-28.15)"/><ellipse class="cls-8" cx="1102.11" cy="257.95" rx="22.34" ry="45.1" transform="translate(124.56 855.98) rotate(-60)"/><circle class="cls-9" cx="942.89" cy="73.9" r="29.21"/><path class="cls-10" d="M646.55,715.06c102-42.71,142.8-67.85,238.12-131" transform="translate(-203.11 -227.45)"/><ellipse class="cls-11" cx="294.88" cy="630.44" rx="8.43" ry="33.86" transform="translate(-560.55 645.64) rotate(-85.34)"/><ellipse class="cls-11" cx="1115.8" cy="376.86" rx="33.86" ry="8.43" transform="translate(-196.54 545.17) rotate(-38.3)"/><ellipse class="cls-11" cx="283.04" cy="792.13" rx="4.09" ry="27.71" transform="translate(-732.59 782.38) rotate(-85.34)"/></svg>
    <div id="header-subgird">
      <a href="#" id="name">Interplanetaryhub.com</a>
      <?php
      $user = new User();
      if (!$user->isLoggedIn()) {
      ?>
      <a style="font-size: 180%" href="login.php" id="signin" class="header-button">Sign-in</a>
      <a style="font-size: 180%" href="register.php" id="signup" class="header-button">Sign-up</a>
      <?php
      } else {
        ?>
        <div id="create" class="header-button">
          <a style="text-decoration: none" href="createlink.php">Create-Link</a>
        </div>
        <div id="signin" class="header-button">
          <a style="text-decoration: none" href="profile.php?user=<?php echo escape($user->data()->username); ?>">User-Profile</a>
        </div>
        <a id="signup" class="header-button" href="logout.php">Log-out</a>
        <?php
      }
      ?>
      <input type="text" id="searchbar" placeholder="Search for a file..."></input>
    </div>
  </div>
  <main>
    <div id="file-type">
      <div id="file-tpe-word">
        File Type
      </div>
      <form id="file-type-options">
        <label>
          <input type="radio" id="any" name="file-type-radio" value="any" checked="checked">
          <span>Any</span>
        </label>
        <label>
          <input type="radio" id="video" name="file-type-radio" value="video">
          <span>Video</span>
        </label>
        <label>
          <input type="radio" id="webpage" name="file-type-radio" value="webpage">
          <span>Webpage</span>
        </label>
        <label>
          <input type="radio" id="image" name="file-type-radio" value="image">
          <span>Image</span>
        </label>
        <label>
          <input type="radio" id="audio" name="file-type-radio" value="audio">
          <span>Audio</span>
        </label>
        <label>
          <input type="radio" id="document" name="file-type-radio" value="document">
          <span>Document</span>
        </label>
        <label>
          <input type="radio" id="other" name="file-type-radio" value="other">
          <span>Other</span>
        </label>
      </form>
    </div>
    <div id="results">
      <div id="filter-by-box">
        <div id="filter-by">
          <!-- Filter by: -->
          <div id="relevance-selector">
              <!-- Relevance ^ -->
          </div>
        </div>
      </div>
    </div>
    <div id="loginModal" class="modal">
      <div id="loginModalContent" class="modal-content">
        <span class="close">&times;</span>
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
      </div>
    </div>
    <div id="hashModal" class="modal">
      <div id="hashModalContent" class="modal-content">
        <span class="close">&times;</span>
        <form id="hashModalForm">
          <input class="token" type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
          <button class="votebutton" type="input" value="2">upvote</button>
          <button class="votebutton" type="input" value="3">downvote</button>
      </div>
    </div>
  </main>
</body>
