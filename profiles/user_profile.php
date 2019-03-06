<head>
	<br>
	<br>
	<br>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/header.php");
    	include(ROOT_PATH . "inc/functions/major_functions.php");
		$page_title = "Profile";
		$page="user_profile.php";
		session_start();
	?>
</head>

<body>

	<?php 
		include(ROOT_PATH . "inc/nav.php"); 
		if (!(isset($_GET["user_id"]))) {
			$_GET["user_id"] = $_SESSION["active_user"];
		}
	?>
	<br>
	<br>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<?php include(ROOT_PATH . "columns/user_profile_column.php");?> 
			</div>
			
			<div class="col-md-8 pre-scrollable box">
				<?php
					if (privateView()) {
						$activity_title = "My Activity";
					} else {
						$activity_title = getFirstNameFromId($_GET["user_id"]) . "'s Activity";
					}

				 	echo "<h2>" . $activity_title . "</h2>"; 
				 	
				 	include(ROOT_PATH . "activity/activity_frame.php");
				 ?>

			</div>

			<div class="col-md-2">
				<?php 
					if (privateView()) {
						include(ROOT_PATH . "columns/personal_directory_column.php");
					}
				?>
			</div>
		</div>
	</div>


	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>	
</body>