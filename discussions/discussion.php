<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/functions/file_management_functions.php");
		include(ROOT_PATH . "inc/functions/discussion_functions.php");
		include(ROOT_PATH . "inc/functions/course_functions.php");
		include(ROOT_PATH . "inc/functions/major_functions.php");
		include(ROOT_PATH . "objects/comment_section.php");
		$page_title = "New Discussion";
		$page="discussion.php";
		if (!isset($_SESSION)) session_start();
	?>
</head>

<body>
	<?php include(ROOT_PATH . "inc/nav.php"); ?>
	<br>
	<br>
	<br>
	<?php
		if (isset($_POST["delete_discussion"])) {
	
			$discussion = getDiscussion($_GET["discussion_id"]);
			deleteDiscussion($_GET["discussion_id"]);
			
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . BASE_URL . 'index.php">';
		}

		if (isset($_POST["submit"])) {
			postComment($_GET["discussion_id"], $_SESSION["active_user"], $_POST["comment"]);
		}
	?>
	
	<br>
	<div class="container">
			<?php echo '<a href="' . BASE_URL . 'discussion_board.php"><button type="button" class="btn btn-default" aria-label="Left Align">'; ?>
					<span class="glyphicon glyphicon-backward" aria-hidden="true"> Discussion Board</span> 
				</button></a>
		<div class="box">
			<?php
				$discussion = getDiscussion($_GET["discussion_id"]);
				$discussion_major = getMajorFromId($discussion["discussion_major_id"]);
				$discussion_uploader = getFullNameFromId($discussion["discussion_uploader"]);
			?>
	
			<div class="row">
				<label class="col-sm-2 title" for="topic">Topic: </label>
				<div class="col-sm-8" name="topic" id="topic">
					<?php echo $discussion["discussion_topic"]; ?>
				</div>
			<?php if (isset($_SESSION["active_user"])) {
					if ($_SESSION["active_user"] == $discussion_uploader) { ?>
						<div class="col-sm-2">
							<button class="btn btn-md btn-danger" data-toggle="modal" data-target="#deleteDiscussionModal">X</button>
						</div>
					<?php }
					} ?>
			</div>
	
			<?php 
				if ($discussion["discussion_major_id"] != "") {
					$discussion_major = getMajorFromId($discussion["discussion_major_id"]);
	
					echo '<div class="row">';
					echo '	<label class="col-sm-2 title" for="major">Field: </label>'; 
					echo '	<div class="col-sm-10" name="major" id="major">';
					echo '<a href="' . BASE_URL . 'fields/field.php?field_id=' . $discussion_major["major_id"] . '"> ' . $discussion_major["major_name"] . ' </a>';
					echo '	</div>';
					echo '</div>';
					
	
				}
			?>
	
			<?php 
				if ($discussion["discussion_course_id"] != "") {
					$discussion_course = getCourseFromId($discussion["discussion_course_id"]);
			?>		

					<div class="row">
						<label class="col-sm-2 title" for="course">Course: </label>
						<div class="col-sm-10" name="course" id="course">
							<?php echo $discussion_course["course_name"]; ?>
						</div>
					</div>
			<?php
				}
			?>
	
			<div class="row">
				<label class="col-sm-2 title" for="uploader">Uploader: </label>
				<div class="col-sm-10" name="uploader" id="uploader">
					<?php echo '<a href="' . BASE_URL . 'profiles/user_profile.php?user_id=' . $discussion['discussion_uploader'] . '">' . $discussion_uploader . ' </a>'; ?>
				</div>
			</div>
	
		</div>
			<div class="comment-section">
					<?php commentSection($_GET["discussion_id"]); ?>
			</div>	
	</div>	

	<footer>
		<?php include(ROOT_PATH . "inc/footer.php")?>
	</footer>

	<div class="modal fade" id="deleteDiscussionModal" tabindex="0" role="dialog">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-body">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    	<p>Are you sure you want to delete this post?</p>
			    </div>
			    <div class="modal-footer">
			    	<form method="POST">
					    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			    		<input type="submit" class="btn btn-danger" id="delete_discussion" name="delete_discussion" value="Delete Discussion"/input>
			    	</form>
			    </div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>