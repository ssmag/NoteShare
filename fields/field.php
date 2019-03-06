<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
    	include(ROOT_PATH . "inc/functions/major_functions.php");
		$page_title = "Profile";
		$page="field.php";
		if (!isset($_SESSION)) session_start();
	?>
</head>

<body>
	<?php include(ROOT_PATH . "inc/nav.php"); 
		  $field = getMajorFromId($_GET["field_id"]);
		  $field_name = $field["major_name"];
	?>
	<br>
	<br>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-3 pre-scrollable box">
				<?php include("../columns/field_activity_column.php"); ?> 
			</div>
			
		<div class="col-md-6 pre-scrollable box discussion-container">
			<?php include("../discussion_board.php"); ?>
		</div>

		<div class="col-md-3">
			<?php /*include("field_directory.php");*/ ?>
		</div>
		</div>
	</div>
	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>	
</body>