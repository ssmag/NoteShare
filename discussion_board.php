<head>
	<?php
		require_once("/inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
    	require_once(ROOT_PATH . "inc/functions/discussion_functions.php");
    	require_once(ROOT_PATH . "objects/discussion_object.php");
		$page_title = "Profile";
		if (!isset($page)) $page="discussion_board.php";
		if (!isset($_SESSION)) session_start();
	?>
</head>

<body>

	<?php 

		include(ROOT_PATH . "inc/nav.php"); 
		if (!(isset($_GET["user_id"])) && isset($_SESSION["active_user"]))
			$_GET["user_id"] = $_SESSION["active_user"];

		if (isset($_GET["user_id"]))
			$discussions = getDiscussionsFromUserId($_GET["user_id"]);

		if (isset($_GET["field_id"])) 
			$discussions = getDiscussionsByMajor($_GET["field_id"]);

		if ($page == "index.php")
			$discussions = getDiscussions();

		if ($page == "discussion_board.php") {
			$discussions = getDiscussions();
		}

	?>
			<?php if ($page != "index.php") { ?>
				<div class="container">
			<?php } ?>

				<?php if ($page != "discussion_board.php")  { 
					echo "<a href='" . BASE_URL . "discussion_board.php'>";
				}
				?>
					<h2>Discussion Board</h2>
				<?php if ($page != "discussion_board.php") 
					echo "</a>";
				?>
				<?php 	$i = 0;
   					  	foreach ($discussions as $discussion) {
   					  		if ($page=="index.php") $i++;

						  	$discussion_id = $discussion["discussion_id"];
						  	discussionObject($discussion_id,$page);
						  	if ($i>=4) break;
						}
					?>
			<?php if ($page !="index.php") { ?>
			</div>
			<?php } ?>
	<?php if ($discussions != null) { ?>
	    <p><a class="btn btn-default" href="discussion_board.php" role="button">See More &raquo;</a></p>
			</div>
		</div>
	<?php } ?>



	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>	
</body>