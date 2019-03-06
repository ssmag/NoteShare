<?php
	require_once("../inc/config.php");
	require_once(ROOT_PATH . "inc/db.php");

	require_once(ROOT_PATH . "inc/header.php");
	require_once(ROOT_PATH . "inc/functions/activity_functions.php");
	require_once(ROOT_PATH . "inc/functions/permission_functions.php");
	require_once(ROOT_PATH . "objects/discussion_object.php");
	require_once(ROOT_PATH . "objects/note_object.php");
	require_once(ROOT_PATH . "objects/discussion_activity.php");
	require_once(ROOT_PATH . "objects/note_activity.php");
	$page_title = "Profile";
	if (!isset($_SESSION)) session_start();

	if ($page=="field.php") {

		$image_size = "col-sm-2";
		$image_width = "50px";
		$image_height = "50px";
		$topic_size = "col-sm-1";
		$label_size = "col-sm-3";
		$info_size = "col-sm-6";

		//generate activity of field
		if (isset($_GET["field_id"]))
			$activity_array = getActivityOfMajor($_GET["field_id"]);

	} else if ($page == "course.php") {
		//generate activity of course
	} else if ($page == "user_profile.php") {

		$image_size = "col-sm-2";
		$image_width = "100px";
		$image_height = "100px";
		$topic_size = "col-sm-1";
		$label_size = "col-sm-1";
		$info_size = "col-sm-10";

		if (isset($_GET["user_id"])) {
			$user_id = $_GET["user_id"];
		} else {
			$user_id = $_SESSION["active_user"];
		}

		$activity_array = getActivityOfUser($user_id);

	}

	foreach ($activity_array as $activity) {
		$activity_type = $activity[0];
		
		if ($activity_type == "discussion") {
			discussionActivity($activity,$page);
		} else if ($activity_type == "note") {
			noteActivity($activity,$page);
		} else if ($activity_type == "comment") {
			//commentActivity($activity);
		}
	}

	


?>

