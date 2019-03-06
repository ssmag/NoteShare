<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");

	function getMajors() {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $results= $db->query("SELECT *
	                              FROM majors
	                              ORDER BY major_name ASC");
	    } catch (PDOException $e) {
	        echo "error selecting majors" . $e;
        }

	    $majors_array = $results->fetchAll(PDO::FETCH_ASSOC);
	    return $majors_array;
	}

	function getMajorFromCourse($courseId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT course_major
								  FROM courses
								  WHERE course_id = ?");

			$stmt->bindParam(1, $courseId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding user's field" . $e;
		}

		$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($courses as $course)
			return $course["course_major"];
	}

	function getMajorFromId($majorId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT *
								  FROM majors
								  WHERE major_id = ?");

			$stmt->bindParam(1, $majorId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding major" . $e;
		}

		$majors = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($majors as $major) {
			return $major;
		}
	}

	function getUserMajorFromId($userId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT user_major
								  FROM user_profiles
								  WHERE user_id = ?");

			$stmt->bindParam(1, $userId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding user's field" . $e;
		}

		$user_majors = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($user_majors as $user_major)
			return $user_major["user_major"];
	}


?>
