<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/functions/user_functions.php");
		$page_title = "Login";
		$page="login.php";
		session_start();
	?>
</head>

<?php

	if (isset($_SESSION["active_user"])) {
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="/index.php">';
	}

	if (isset($_POST["submit"])) {
		$email = $_POST["email"];
		$password = $_POST["password"];
		if (userExists($email)) {
			if (verifyUser($email,$password) == 1) {
				$_SESSION["active_user"] = getIdFromEmail($email);
				if (isAdmin($email)) {
					$_SESSION["admin"] = 1;
				}
				//start session with logged in user and go to main page
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . BASE_URL . 'index.php">';

			} else {
				echo "<script type='text/javascript'>";
				echo "	alert('Your password is incorrect. Please try again.')";
				echo "</script>";
			}
		} else {
			echo "<script type='text/javascript'>";
			echo "	alert('The e-mail address you gave us could not be found. Please try again.')";
			echo "</script>";
		}


	}

?>

<br>
<br>
<body>
 	<?php include(ROOT_PATH . "inc/nav.php"); ?>

	<div class="container col-md-2 col-md-offset-4">

		<h1>Login</h1>
		
		<form class="form-horizontal" id="login" name="login" method="POST">
			<div class="form-group">
				<label class="control-label" for="email">E-mail: </label>
				<input class="form-control" type="email" name="email" id="email"/>
			</div>
			
			<div class="form-group">
				<label class="control-label" for="password">Password: </label>
				<input class="form-control" type="password" name="password" id="password"/>
			</div>
			
			<div class="form-group">
				<input class="btn btn-success" type="submit" id="submit" name="submit" value="Login"/>
				<button class="btn" type="button" id="submit" name="submit" value="Sign Up" onclick="window.location='signup.php'">Sign Up</button>
			</div>
		</form>
	</div>

	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>
</body>