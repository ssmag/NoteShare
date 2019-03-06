<?php
require_once("config.php");
require_once(ROOT_PATH . "inc/header.php");
require_once(ROOT_PATH . "inc/functions/note_functions.php");
require_once(ROOT_PATH . "inc/functions/course_functions.php");
require_once(ROOT_PATH . "inc/functions/major_functions.php");

function noteObject($noteId) { ?>
	<?php 
		$note = getNote($noteId);
		
		$uploaderId = $note["note_uploader"];
		$user_profile_path = BASE_URL . "profiles/user_profile.php?user_id=" . $uploaderId;
		$note_course_id = $note["note_course"];
	   	$note_course = getCourseFromId($note_course_id);
		$note_course_name = $note_course["course_name"];
		$note_uploader = getFullNameFromId($uploaderId);
		$note_major_id = $note["note_major"];
		$major_url = BASE_URL . "fields/fields/field.php?field_id=" . $note_major_id;
	?>
	<div class="row">
		<?php 
			  echo '<a href="' . BASE_URL . 'notes/note.php?note_id=' . $noteId . '">';
			  echo '<img width="200" height="200"src="' . BASE_URL . 'document_root/note.png"></img></a>' 
		?>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<label for="topic">Topic: </label>
		</div>
		<div  class="col-sm-8" name="topic" id="topic">
			<?php echo $note["note_topic"];?>
		</div>
	</div>

	<?php if ($note_major_id != 0) { ?>
		<div class="row">
			<label class="col-sm-3" for="field">Field: </label>
			<div class="col-sm-8" name="field" id="field">
			<?php $note_major = getMajorFromId($note_major_id);
				  $note_major_name = $note_major["major_name"]; 
				  echo '<a href="' . $major_url .'">';
				  echo $note_major_name; 
				  echo '</a>'; ?>
			</div>
		</div>
	 <?php }
		if ($note_course_id != 0) { ?>
			<div class="row">
				<label class="col-sm-3" for="course">Course: </label>
				<div class="col-sm-8" name="course" id="course">
					<?php echo $note_course_name; ?>
				</div>
			</div>
	  <?php } ?>
	<div class="row">
		<label class="col-sm-3" for="uploader">Uploader: </label>
		<div class="col-sm-8" name="uploader" id="uploader">
			<?php 
				echo '<a href="' . $user_profile_path .'">';
			    echo $note_uploader; 
				echo '</a';
			?>
		</div>
	</div>
</div>
<?php } 

function noteSearchObject($noteId) {

	$image_size = "col-sm-2";
	$image_width = "50px";
	$image_height = "50px";
	$topic_size = "col-sm-1";
	$label_size = "col-sm-3";
	$info_size = "col-sm-6";

?>

	<style>
		.discussion-object {
			width: 500px !important;
			max-height: 500px;
			float: left;
			position: relative;
		}
	</style>

	<div class="row">
		<div class="container box discussion-object">
			<div class="row">
				<?php
					$uploaderId = getNoteUploader($noteId);
					$note = getNote($noteId);
					
					$note_major_id = $note["note_major"];		
					$note_major = getMajorFromId($note_major_id);
					$note_major_name = $note_major["major_name"]; 


					echo '<div class="' . $image_size . '">';
					echo '<a href="' . BASE_URL . 'notes/note.php?note_id=' . $noteId . '">';
					echo '<img src="' . BASE_URL . 'document_root/note.png" width="' . $image_width . '" height="' . $image_height . '"></img>';

					echo '</a>';
					echo '</div>';
					
				
					echo '<div class="' . $info_size . '">';
					?>
						<div class='row'>
							<?php echo '<label class="' . $label_size . '" for="topic"> Topic: </label>'; ?>
							<div name="topic" id="topic">
							<?php echo '<a class="discussion_url" href="' . BASE_URL . 'notes/note.php?note_id=' . $noteId . '">'; ?>
							<?php 
								echo $note["note_topic"];
							?>
							</a>
	
							</div>
						</div>
							<?php $note_major_id = $note["note_major"];
							if ($note_major_id != null) { ?>
								<div class="row">
									<?php if ($note_major != null) {
										echo '<label class="' . $label_size . '" for="field"> Field: </label>'; 
									?>
										<dif name="field" id="field">
										<?php
											$note_major = getMajorFromId($note_major_id);
											$note_major_name = $note_major["major_name"]; 
											echo '<a href="' . BASE_URL . 'fields/field.php?field_id=' . $note_major_id . '">' . $note_major_name . '</a>';
										
										?>
										</div>
										<div class="bottom">
											<div class="hint">
												<?php echo '<a class="note_url" href="' . BASE_URL . 'notes/note.php?note_id=' . $noteId . '">Show More...</a>'; ?>
											</div>
										</div>
										<?php }?>
								</div>
					 <?php } ?>
					</div>
				</a>
			</div>
		</div>
	</div>
	<?php } ?>
