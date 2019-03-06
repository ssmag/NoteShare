<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/functions/user_functions.php");
		include(ROOT_PATH . "inc/functions/permission_functions.php");
		$page_title = "Sign Up";
		$page="signup.php";
		session_start();
	?>
</head>

<body>
	<?php
 		include(ROOT_PATH . "inc/nav.php");

		if (isset($_POST["signup_submit"])) {

			$email = $_POST["email"];
			$password1 = password_hash($_POST["password1"],PASSWORD_BCRYPT);
			$password2 = password_hash($_POST["password2"],PASSWORD_BCRYPT);

			if (!userExists($email)) {
				newUser($email, $password1);
				$_SESSION["active_user"] = getIdFromEmail($email);
				
				if (validEmail($email)) {
					if ($POST["password1"] == $POST["password2"]) {
						echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../profiles/createprofile.php">';
					} else {
						echo '<script type="text/javascript">';
						echo '	alert("This e-mail address is invalid. Please try another one.");	';
						echo '</script>';
					}
				}

			} else {
				echo '<script type="text/javascript">';
				echo '	alert("This e-mail has already been used. Please try a different e-mail address.");	';
				echo '</script>';
			}
			
			unset($_POST);
		}
	?>

	<br>
	<br>
	<div class="container col-md-2 col-md-offset-4">
	
		<h1>Sign Up</h1>
	
		<form class="form-horizontal" id="signup" name="signup" method="POST">
			<div class="form-group">
				<label class="control-label" for="email">*E-mail: </label>
				<input class="form-control" name="email" id="email" type="email">
			</div>
				
			<div class="form-group">
				<label class="control-label" for="password1">*Password: </label>
				<input class="form-control" name="password1" id="password1" type="password">
			</div>
				
			<div class="form-group">
				<label class="control-label" for="password2">*Verify Password: </label>
				<input class="form-control" name="password2" id="password2" type="password">
			</div>
				
			<div class="form-group">
				<p class="notice" id="passwordmismatchalert">Your passwords are not matching</p>
				<input class="btn btn-success" id="signup_submit" name="signup_submit" type="submit" value="Sign Up"></input>
				<p class="notice">*Required fields</p>
			</div>
		</form>
	</div>

	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>
</body>