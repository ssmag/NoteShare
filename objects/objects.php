<?php
	require_once("config.php");
	require_once(ROOT_PATH . "inc/header.php");
	require_once(ROOT_PATH . "inc/db_functions/get_functions.php");

function discussionObject($discussionId,$page) {
	if ($page == "discussion_board.php") {
		$image_size = "col-sm-2";
		$image_width = "100px";
		$image_height = "100px";
		$topic_size = "col-sm-1";
		$label_size = "col-sm-1";
		$info_size = "col-sm-10";
	} else if ($page == "fields/field.php" || $page == "index.php") {
		$image_size = "col-sm-2";
		$image_width = "50px";
		$image_height = "50px";
		$topic_size = "col-sm-1";
		$label_size = "col-sm-3";
		$info_size = "col-sm-7";

		echo "<style>";
			echo ".discussion-object {";
			echo "	width: 500px !important;";
			echo "	max-height: 500px;";
			echo "	float: left;";
			echo "	position: relative;";
			echo "}";
		echo "</style>";
	}

	?>
	<div class="row">
		<div class="container box discussion-object">
			<div class="row">
				<?php
					$uploaderId = getDiscussionUploaderId($discussionId);
					$user_profile_path = BASE_URL . "user_profile.php?user_id=" . $uploaderId;
					$user_image = getImageFromId($uploaderId);
					$discussion = getDiscussion($discussionId);
							
					echo '<div class="' . $image_size . '">';
					echo '<a href="' . $user_profile_path . ' ">';
					echo '<img src="' . $user_image . '" width="' . $image_width . '" height="' . $image_height . '"></img>';
					echo '</a>';
					echo '</div>';
					
				
					echo '<div class="' . $info_size . '">';
					?>
						<div class='row'>
							<?php echo '<label class="' . $label_size . '" for="topic"> Topic: </label>'; ?>
							<div name="topic" id="topic">
							<?php echo '<a class="discussion_url" href="' . BASE_URL . 'discussion.php?discussion_id=' . $discussionId . '">'; ?>
							<?php 
								echo $discussion["discussion_topic"];
							?>
							</a>
	
							</div>
						</div>
							<?php $discussion_major_id = $discussion["discussion_major_id"];
							if ($discussion_major_id != null) { ?>
								<div class="row">
									<?php if ($page != 'fields/field.php') {
										echo '<label class="' . $label_size . '" for="field"> Field: </label>'; 
									?>
										<div name="field" id="field">
										<?php
											$discussion_major = getMajorFromId($discussion_major_id);
											$discussion_major_name = $discussion_major["major_name"]; 
											echo '<a href="fields/field.php?field_id=' . $discussion_major_id . '">' . $discussion_major_name . '</a>';
										
										?>
										</div>
										<div class="bottom">
											<div class="hint">
												<?php echo '<a class="discussion_url" href="' . BASE_URL . 'discussion.php?discussion_id=' . $discussionId . '">Show More...</a>'; ?>
											</div>
										</div>
										<?php } ?>
								</div>
					 <?php } ?>
					</div>
				</a>
			</div>
		</div>
	</div>
	<?php } ?>


	<?php function noteObject($noteId) { ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-1">
				<?php 
					$uploaderId = getNoteUploaderId($noteId);
					$user_profile_path = BASE_URL . "user_profile.php?user_id=" . $uploaderId;
					$user_image = getImageFromId($uploaderId);
					$note = getNote($noteId);
	
					echo '<a href="' . $user_profile_path . ' ">';
					echo '<img src="' . $user_image . '"></img>';
					echo '</a>';
				?>
			</div>
			<div class="col-sm-11">
				<label for="topic">Topic: </label>
				<div name="topic" id="topic">
					<?php 
						echo $note["note_topic"]
					?>
				</div>
			</div>
		</div>
			<?php $note_major_id = $note["note_major_id"];
			if ($note_major_id != null) { ?>
			<div class="row">
				<label class="col-sm-1" for="field">Field: </label>
				<div class="col-sm-11" name="field" id="field">
				<?php $note_major = getMajorFromId($note_major_id);
					  $note_major_name = $note_major["major_name"]; 
					  echo $note_major_name; ?>
				</div>
			</div>
	 <?php } ?>
				<div class="row">
			<?php $note_course_id = $note["note_course_id"];
			if ($note_course_id != null) { ?>
				<label class="col-sm-1" for="field">Field: </label>
				<div class="col-sm-11" name="field" id="field">
				<?php $note_course = getCourseFromId($note_course_id);
					  $note_course_name = $note_course["course_name"]; 
					  echo $note_course_name;
			} ?>
			</div>
		</div>
	</div>
	<?php } ?>


	<?php function majorObject($majorId) {
	 $major = getMajorFromId($majorId); ?>
	<div class="container box">
		<div class="row">
			<div class="">
				<label class="col-sm-1" for="field">Field: </label>
				<?php echo '<a href="fields/field.php?field_id=' . $major["major_id"] . '"><div name="field" id="field">';
					  echo $major["major_name"];
					  echo '</div></a>'; ?>
			</div>
			<div class="col-sm-11">
			</div>
		</div>
		<br>
		<br>
		
		<div class="row">
			<label class="col-sm-1">Courses: </label>
		</div>
		<?php 
			$courses = getCoursesOfMajor($majorId);
			$i=$j=0;
			foreach ($courses as $course) {
				$i++;
				if ($i > 3) { $i = 3; }
			}

			foreach ($courses as $course) { 
				$j++;
				
				if ($i<=$j) { 
		?>

				<div class="row">
						
					<?php	echo '<a href="course.php?course_id=' . $course["course_id"] . '"><div class="col-sm-4" name="coursename" id="coursename">';
						echo $course["course_name"]; 
						echo '</div></a>' 

					?>
				</div>	
		<?php 	}
			}
		?>
	</div>
	<?php } 

	function commentSection($discussionId) { ?>
		<?php	if (isset($_SESSION["active_user"])) { ?>
			<div class="row">
				<form class="form-horizontal" id="new_comment" name="new_comment" method="POST">
						<div class="form-group form-horizontal col-sm-8">
							<label class="control-label" for="comment">Leave your comment below: </label>
							<input class="form-control" type="text" name="comment" id="comment" required/>
							<input class="btn" type="submit" name="submit" id="submit" value="Post"></input>
						</div>
				</form>
			</div>
		<?php } ?>

		<?php 
			$comments = getComments($discussionId); 

			foreach ($comments as $comment) { 
				var_dump($comment);
				$commenterId = $comment["commenter_id"];
				$user_image = getImageFromId($commenterId); 
				$now = date('m/d/Y h:i:s a', time());
				$now = date_create_from_format('m/d/Y h:i:s a', $now);
				var_dump($now);
				$comment_timestamp = $comment["comment_timestamp"];
				$comment_time = date_create_from_format('Y-m-d H:i:s.u', $comment_timestamp);
				var_dump($comment_timestamp);
				$diff = date_diff($now,$comment_time);

				if ($diff->d == 0) {
					if ($diff->d == 0) {
						if ($diff->h == 0) {
							$time_interval = "minutes";
							$time_value = $diff->i;
						} else {
							$time_interval = "hours";
							$time_value = $diff->h;
						}
					} else {
						$time_interval = "days";
						$time_value = $diff->d;
					}
				} else {
					$time_interval = "years";
					$time_value = $diff->y;
				}
		?>		
						<div class="comments row chat-bubble">
		<?php	
				echo '<img src="' . $user_image . '" class= "col-sm-2" width="100px" height="100px"></img>'; 
				echo '<div class="col-sm-8">' . $comment["comment_text"] . '</div>';
				echo '<div class="row">Posted ' . $time_value . ' ' . $time_interval . ' ago. </div>';
				echo "<br>";
				echo $time_interval;
				echo "<br>";
				printf('%d years, %d days, %d hours, %d minutes',$diff->y, $diff->d, $diff->h, $diff->i);
		?>
				</div>

	<?php }
	 }	?>