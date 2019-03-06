<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");

	
	function getActivityOfUser($userId) {
		require(ROOT_PATH . "inc/db.php");
		$activity_array = [];

		try {
			$stmt = $db->prepare("SELECT discussion_id, timestamp 
								  FROM comments
								  WHERE commenter_id = ?");

			$stmt->bindParam(1, $userId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting comment" . $e;
		}

		$comment_data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($comment_data_array as $comment_data) {
				array_unshift($comment_data, "comment");
				array_push($activity_array, $comment_data);
		}


		try {
			$stmt = $db->prepare("SELECT discussion_id, discussion_course_id, discussion_uploader, timestamp 
								  FROM discussions
								  WHERE discussion_uploader = ?");

			$stmt->bindParam(1, $userId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting comment" . $e;
		}

		$discussion_data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($discussion_data_array as $discussion_data) {
			array_unshift($discussion_data,"discussion");
			array_push($activity_array, $discussion_data);
		}



		try {
			$stmt = $db->prepare("SELECT note_id, note_course, note_major, timestamp 
								  FROM notes
								  WHERE note_uploader = ?");

			$stmt->bindParam(1, $userId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting comment" . $e;
		}

		$note_data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($note_data_array as $note_data) {
				array_unshift($note_data, "note");
				array_push($activity_array, $note_data);
		}

		//usort($activity_array,"timestamp");

		
		return $activity_array;

		
		
	}


	function getActivityOfMajor($majorId) {
		require(ROOT_PATH . "inc/db.php");
		$activity_array = [];

		
		try {
			$stmt = $db->prepare("SELECT discussion_id, discussion_course_id, discussion_uploader, timestamp 
								  FROM discussions
								  WHERE discussion_major_id = ?");

			$stmt->bindParam(1, $majorId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting comment" . $e;
		}

		$discussion_data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($discussion_data_array as $discussion_data) {
			array_unshift($discussion_data,"discussion");
			array_push($activity_array, $discussion_data);
		}



		try {
			$stmt = $db->prepare("SELECT note_id, note_course, note_major, note_uploader, timestamp 
								  FROM notes
								  WHERE note_major = ?");

			$stmt->bindParam(1, $majorId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting comment" . $e;
		}

		$note_data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($note_data_array as $note_data) {
				array_unshift($note_data, "note");
				array_push($activity_array, $note_data);
		}

		//usort($activity_array,"timestamp");

		
		return $activity_array;

		
		
	}

	function getActivityOfCourse($courseId) {
		require(ROOT_PATH . "inc/db.php");
		$activity_array = [];

		try {
			$stmt = $db->prepare("SELECT discussion_id, discussion_course_id, timestamp 
								  FROM discussions
								  WHERE discussion_course_id = ?");

			$stmt->bindParam(1, $courseId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting comment" . $e;
		}

		$discussion_data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($discussion_data_array as $discussion_data) {
			array_unshift($discussion_data,"discussion");
			array_push($activity_array, $discussion_data);
		}

		try {
			$stmt = $db->prepare("SELECT note_id, note_uploader, note_major, timestamp 
								  FROM notes
								  WHERE note_course = ?");

			$stmt->bindParam(1, $courseId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting comment" . $e;
		}

		$note_data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($note_data_array as $note_data) {
				array_unshift($note_data, "note");
				array_push($activity_array, $note_data);
		}

		//usort($activity_array,"timestamp");

		return $activity_array;		
	}


	function getTimeDifference($timestamp) {
		$now = date('m/d/Y h:i:s a', time());
		$now = date_create_from_format('m/d/Y h:i:s a', $now);
		$diff = date_diff($now,$timestamp);

		if ($diff->y == 0 &&
			$diff->d == 0 &&
			$diff->h == 0) {
			$time_interval = "minutes";
			$time_value = $diff->i;
		} else if ($diff->y == 0 && $diff->d == 0) {
			$time_interval = "hours";
			$time_value = $diff->h;
		} else if ($diff->y == 0) {
			$time_interval = "days";
			$time_value = $diff->d;
		} else {
			$time_interval = "years";
			$time_value = $diff->y;
		}
		
		
		return $time_value . " " . $time_interval;
	}


