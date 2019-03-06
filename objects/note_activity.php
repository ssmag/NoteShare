<?php 
	require_once(ROOT_PATH . "inc/functions/user_functions.php");

	function noteActivity($activity, $page) {
		if ($page=="field.php") {

			$image_size = "col-sm-3";
			$image_width = "50px";
			$image_height = "50px";
			$topic_size = "col-sm-8";

		} else if ($page == "user_profile.php") {

			$image_size = "col-sm-2";
			$image_width = "100px";
			$image_height = "100px";
			$topic_size = "col-sm-1";
		
		}

		if (privateView()) 
			$user = "You";
		else
			$user = null;
		if (isset($activity["note_uploader"]))
			$uploader_id = $activity["note_uploader"];
		else if (isset($_GET["user_id"]))
			$uploader_id = $_GET["user_id"];
		else
		$uploader_id = $_SESSION["active_user"];
		$uploaderImage = getImageFromId($uploader_id);
		$username = getFullNameFromId($uploader_id);
		$course_message = "";
		$course_id = $activity["note_course"];
		$course = getCourseFromId($course_id)["course_name"];
		$timestamp = date_create_from_format('Y-m-d H:i:s',$activity["timestamp"]);
		$time = getTimeDifference($timestamp);
		$time_message = $time . " ago";
		$note_id = $activity["note_id"];
		$linked_note = "<a href='" . BASE_URL . "notes/note.php?note_id=" . $note_id . "'>note</a>";
		$activity_message = $username . " posted a " . $linked_note . " " . $course_message . $time_message; 

		if ($page != "course.php" && $course != null) {
			$course_message = "on " . $course . " ";
		} 

		?>
		<div class="row">
		<?php echo "<div class='" . $image_size . "'>";
	  
	    if ($page != "user_profile.php") 
	  		echo "<a href='" . ROOT_PATH . "profiles/user_profile?user_id=" . $uploader_id . "'>";

	    echo "<img src='" . BASE_URL . "/document_root/note.png' width='" . $image_width . "' height='" . $image_height . "'></img>";

	    if ($page != "user_profile.php")
	  	  		echo "</a>";
	  
	  	echo "</div>";
		echo "<div class='col-sm-8'>";
	  	echo $activity_message;
	  	echo "</div> ";
	  	echo "</div>";  ?>

<?php
	  	echo "<br>";

 } 
?>