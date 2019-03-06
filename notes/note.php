<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/functions/note_functions.php");
		include(ROOT_PATH . "inc/functions/discussion_functions.php");
		include(ROOT_PATH . "inc/functions/file_management_functions.php");
		$page_title = "New Discussion";
		$page="note.php";
		if (!isset($_SESSION)) session_start();
		echo '<br>';
		echo '<br>';
		echo '<br>';
		echo '<br>';

		$note_id = $_GET["note_id"];
		$note_filename = getFileNameFromId($note_id);
		$note = getNote($note_id);
		echo '<h2 style="text-align:center">' . $note["note_topic"] . '</h2>';

		/*if (isset($_POST["download"])) {
			downloadFile($note_filename);
		}*/

		if (isset($_POST["like"])) {
			unset($_POST);
			likeNote($_SESSION["active_user"], $note_id);
			unset($_POST);
		}

		if (isset($_POST["unlike"])) {
			unset($_POST);
			unLikeNote($_SESSION["active_user"], $note_id);
			unset($_POST);
		}

//		echo userLikes($_SESSION["active_user"], $note_id);
	?>


	
</head>
<body>
	<?php include(ROOT_PATH . "inc/nav.php"); ?>
	<div class="container">
				<?php 	echo '<div class="row">';
						echo '<iframe style="text-align: center" width="1000px" height="600px" src="' . $note_filename . '"></iframe>'; 
						echo '</div>';
				?>
				<div class="col-md-1">
						<?php if (isset($_SESSION["active_user"])) { ?>
							<form method="POST" enctype="multipart/form-data">
								<?php if (userLikes($_SESSION["active_user"],$note_id)) {
										echo '<button type="submit" class="glyphicon glyphicon-thumbs-up span btn" name="unlike" id="like" value="unlike"/>  ' . countLikes($note_id);
									  } else { 
										echo '<button type="submit" class="glyphicon glyphicon-thumbs-up span btn btn-primary" name="like" id="like" value="like"/>   ' . countLikes($note_id);
									  } 
								?>
							</form>
											 		
						<?php } ?>
					</div>
					<?php 
						if (isset($_SESSION["active_user"])) {
							if (!noteHasDiscussion($note_id)) { ?>
							<div class="row pull-down">
							<?php echo '<a href="' . BASE_URL . 'discussions/newdiscussion.php">Start Discussion</a>'; ?>
								</div>
							<?php } ?>
							</div>
							<?php $_SESSION["related_note"] = $note_id;
						} else {
							$discussion = getDiscussionOfNote($note_id);
							$discussion_id = $discussion[0]["discussion_id"];
							echo '<div class="row">';
								include(ROOT_PATH . "discussions/discussion.php?discussion_id=" . $discussion_id );
							echo '</div>';
						}
						?>
				
	</div>
	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>
</body>