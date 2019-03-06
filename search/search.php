<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/functions/search_functions.php");
		include(ROOT_PATH . "objects/note_object.php");
		include(ROOT_PATH . "objects/discussion_object.php");
		include(ROOT_PATH . "objects/user_object.php");
		include(ROOT_PATH . "objects/major_object.php");
		include(ROOT_PATH . "inc/header.php");
		$page_title = "Search Results";
		$page="search.php";
		session_start();
	?>
</head>


<body>
	<br>
	<br>
	<br>
	<?php include(ROOT_PATH . 'inc/nav.php'); ?>
	<div class="container">
		<h1 class="h1">Search Results</h1>

		<?php 
			$query = $_GET["query"];
			$searchresults=simpleSearchQueryResults($query);
			foreach ($searchresults as $result) {
				if (isset($result["note_id"])) {
					//treat like a note
					noteSearchObject($result["note_id"],$page);
					
			} else if (isset($result["discussion_id"])) {
					discussionObject($result["discussion_id"],$page);
			} else if (isset($result["user_id"])) {
					userObject($result["user_id"]);
			} else if (isset($result["course_id"])) {
			} else if (isset($result["major_id"])) {
					majorObject($result["major_id"]);
				}
			}
		?>
	</div>
	<footer>
		<?php include(ROOT_PATH . 'inc/footer.php'); ?>
	</footer>
</body>