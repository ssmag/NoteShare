<?php
	require_once("config.php");
	require_once(ROOT_PATH . "inc/header.php");
	require_once(ROOT_PATH . "inc/functions/major_functions.php");
	require_once(ROOT_PATH . "inc/functions/discussion_functions.php");
	
	function discussionObject($discussionId,$page) {
		if ($page == "discussion_board.php") {
			$image_size = "col-sm-2";
			$image_width = "100px";
			$image_height = "100px";
			$topic_size = "col-sm-1";
			$label_size = "col-sm-1";
			$info_size = "col-sm-10";
		} else if ($page == "field.php" || $page == "index.php" || $page == "search.php") {
			$image_size = "col-sm-2";
			$image_width = "50px";
			$image_height = "50px";
			$topic_size = "col-sm-1";
			$label_size = "col-sm-3";
			$info_size = "col-sm-6";

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
					$user_profile_path = BASE_URL . "profiles/user_profile.php?user_id=" . $uploaderId;
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
							<?php echo '<a class="discussion_url" href="' . BASE_URL . 'discussions/discussion.php?discussion_id=' . $discussionId . '">'; ?>
							<?php 
								echo $discussion["discussion_topic"];
							?>
							</a>
	
							</div>
						</div>
							<?php $discussion_major_id = $discussion["discussion_major_id"];
							if ($discussion_major_id != null) { ?>
								<div class="row">
									<?php if ($page != 'field.php') {
										echo '<label class="' . $label_size . '" for="field"> Field: </label>'; 
									?>
										<div name="field" id="field">
										<?php
											$discussion_major = getMajorFromId($discussion_major_id);
											$discussion_major_name = $discussion_major["major_name"]; 
											echo '<a href="' . BASE_URL . 'fields/field.php?field_id=' . $discussion_major_id . '">' . $discussion_major_name . '</a>';
										
										?>
										</div>
										<div class="bottom">
											<div class="hint">
												<?php echo '<a class="discussion_url" href="' . BASE_URL . 'discussions/discussion.php?discussion_id=' . $discussionId . '">Show More...</a>'; ?>
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
