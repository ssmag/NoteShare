<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");


	function getCourses() {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $results= $db->query("SELECT *
	                              FROM courses
	                              ORDER BY course_name ASC");
	    } catch (PDOException $e) {
	        echo "error selecting majors" . $e;
        }

	    $courses_array = $results->fetchAll(PDO::FETCH_ASSOC);
	    return $courses_array;
	}

	function JSONEncodeCourses() {
		$courses = getCourses();
		$coursenames=[];
		foreach ($courses as $course) {
			$coursenames[] = $course["course_name"];
		}
		$JSONArray = json_encode($coursenames);
		$file = fopen(ROOT_PATH . "courses/courses.json","w") or die("Unable to open file"); 
		fwrite($file, $JSONArray);
		fclose($file);
	}


	function getCoursesOfMajor($majorId) {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt= $db->prepare("SELECT *
	                              FROM courses
	                              WHERE course_major = ?
	                              ORDER BY course_name ASC");

	        $stmt->bindParam(1, $majorId, PDO::PARAM_STR);
	        $stmt->execute();

	        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

	        return $courses;
	    } catch (PDOException $e) {
	        echo "error selecting majors" . $e;
        }
	}

	function getCourseFromId($courseId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT *
								  FROM courses
								  WHERE course_id = ?");

			$stmt->bindParam(1, $courseId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding course" . $e;
		}

		$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($courses as $course)
			return $course;
	}

?>