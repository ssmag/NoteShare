<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
	    include(ROOT_PATH . "inc/functions/note_functions.php");
	    include(ROOT_PATH . "inc/functions/major_functions.php");
	   	$page_title = "Login";
		$page="admin.php";
		session_start();
	?>
</head>
<?php if (!isset($_SESSION["admin"])) {
		header("Location: ../index.php");
		die();
	  } else {
?>
	<body>
		<br>
		<br>
		<br>

		<?php include(ROOT_PATH . "inc/nav.php"); ?>


		


	<!-- 	<div class="container">
			
			<div class="col-md-4">
				<a href="admin_users.php">
					<button class="btn btn-info">Users</button>
				</a>
			</div>
			<div class="col-md-4">
				<a href="admin_courses.php">
					<button class="btn btn-info">Courses</button>
				</a>
			</div>
			<div class="col-md-4">
				<a href="admin_fields.php">
					<button class="btn btn-info">Fields</button>
				</a>
			</div>
			<div class="col-md-4">
				<a href="admin_notes.php">
					<button class="btn btn-info">Notes</button>
				</a>
			</div>
			<div class="col-md-4">
				<a href="admin_comments.php">
					<button class="btn btn-info">Comments</button>
				</a>
			</div>
			<div class="col-md-4">
				<a href="admin_discussions.php">
					<button class="btn btn-info">Discussions</button>
				</a>
			</div>
		</div> -->



	</body>

	<footer>
		<?php include(ROOT_PATH . 'inc/footer.php'); ?>
	</footer>

<?php } ?>