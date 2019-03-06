<head>
	<?php
		require_once("/inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
    	include(ROOT_PATH . "inc/db_functions/get_functions.php");
    	include(ROOT_PATH . "objects/objects.php");
		$page_title = "Profile";
		$page="fields.php";
		session_start();
	?>
</head>

<body>
	<?php 
		include(ROOT_PATH . "inc/nav.php"); 
		if (!(isset($_GET["user_id"])) && isset($_SESSION["active_user"])) {
			$_GET["user_id"] = $_SESSION["active_user"];
		}
 	?>		
		<div class="container">
			<div class="row">
				<h2>Fields</h2>
					<?php 
						if (isset($_GET["field_id"])) {
							$major = getMajorFromId($_GET["field_id"]);	
						majorObject($major["major_id"]);
						  	
						} else {
							$majors = getMajors();
							foreach ($majors as $major) {
								$major_id = $major["major_id"];
							  	majorObject($major_id);
							}
						}
					?>
			</div>
		</div>

	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>	
</body>