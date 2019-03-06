<?php 
	require_once(ROOT_PATH . "inc/functions/user_functions.php");

	function discussionActivity($activity, $page) {
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
		

		$uploaderId = $activity["discussion_uploader"];
		$user = getFullNameFromId($uploaderId); 
		$uploaderImage = getImageFromId($uploaderId);
		$course_message = "";
		$course_id = $activity["discussion_course_id"];
		$course = getCourseFromId($course_id);
		$course_name = $course["course_name"];
		$timestamp = date_create_from_format('Y-m-d H:i:s',$activity["timestamp"]);
		$time = getTimeDifference($timestamp);
		$time_message = $time . " ago";
		$discussion_id = $activity["discussion_id"];
		$linked_topic = "<a href='" . BASE_URL . "discussions/discussion.php?discussion_id=" . $discussion_id . "'>topic</a>";
		

		if ($page != "course.php" && $course != null) {
			$course_message = "on " . $course_name . " ";
		}
		$activity_message = $user . " posted a " . $linked_topic . " " . $course_message . $time_message; 

?>
	<div class="row">
<?php echo "<div class='" . $image_size . "'>";
	  
	  if ($page != "user_profile.php") 
	  	echo "<a href='" . ROOT_PATH . "profiles/user_profile?user_id=" . $uploaderId . "'>";

	  echo "<img src='" . $uploaderImage . "' width='" . $image_width . "' height='" . $image_height . "'></img>";

	  if ($page != "user_profile.php")
	  	  	echo "</a>";
	  
	  echo "</div>"; 

	  echo "<div class='col-sm-8'>";
	  echo $activity_message;
	  echo "</div> ";
?>
	 </div>
	 <br>


		
<?php
	}
?>