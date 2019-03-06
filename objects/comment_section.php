<?php
	require_once("config.php");
	require_once(ROOT_PATH . "inc/header.php");
	include(ROOT_PATH . "inc/functions/comment_functions.php");
	
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
			<?php } 

					/*if (isset($_POST)) {

					}*/



			?>

			<?php

				$comments = getComments($discussionId); 
				foreach ($comments as $comment) {
					$commenterId = $comment["commenter_id"];
					$user_image = getImageFromId($commenterId); 
					$now = date('m/d/Y h:i:s a', time());
					$now = date_create_from_format('m/d/Y h:i:s a', $now);
					$timestamp = $comment["timestamp"];
					$comment_time = date_create_from_format('Y-m-d H:i:s.u', $timestamp);
					$diff = date_diff($now,$comment_time);
					//$diff->h = $diff->h - 1 ;

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
					<div class="comments chat-bubble">
						<?php	
							echo '<div class="col-sm-2">';
							echo '<a href="' . ROOT_PATH . 'profiles/user_profile.php?user_id=' . $commenterId . '"><img src="' . $user_image . '" width="100px" height="100px"></img></a>';
							echo '<div>' .  getFullNameFromId($commenterId)  . '</div>';
							echo '</div>';
							echo '<div class="col-sm-5">' . $comment["comment_text"] . '</div>';
							echo '	<div class="row">Posted ' . $time_value . ' ' . $time_interval . ' ago.';

							if (isset($_SESSION["active_user"])) {
								if ($commenterId == $_SESSION["active_user"]) {
															echo '	<button class="btn btn-md btn-danger" data-toggle="modal" data-target="#deleteCommentModal">X</button>';
														}
							}

							echo "</div>";
							echo "<br>";
							echo "<br>";
							
						?>
					</div>

					<div class="modal fade" id="deleteCommentModal" tabindex="0" role="dialog">
				  		<div class="modal-dialog" role="document">
				    		<div class="modal-content">
				      			<div class="modal-body">
				        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							    	<p>Are you sure you want to delete this comment?</p>
							    </div>
							    <div class="modal-footer">
							    	<form method="POST">
									    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							    		<input type="submit" class="btn btn-danger" id="delete_discussion" name="delete_discussion" value="Delete Comment"/input>
							    	</form>
							    </div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->




		<?php }
		 }	?>