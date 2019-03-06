<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");


	function simpleSearchQueryResults($query) {
		$search_results = [];
		$note_search_results = searchForNotes($query);
		$discussion_search_results = searchForDiscussions($query);
		$user_search_results = searchForUsers($query);
		$course_search_results = searchForCourses($query);
		$major_search_results = searchForMajors($query);

		foreach ($note_search_results as $note_search_result)
			array_push($search_results,$note_search_result);
		
		foreach ($discussion_search_results as $discussion_search_result)
			array_push($search_results,$discussion_search_result);

		foreach ($user_search_results as $user_search_result)
			array_push($search_results,$user_search_result);

		foreach ($course_search_results as $course_search_result)
			array_push($search_results,$course_search_result);

		foreach ($major_search_results as $major_search_result)
			array_push($search_results,$major_search_result);


		return $search_results;
	}

	function searchForNotes($query) {
		require(ROOT_PATH . "inc/db.php");
	    
	    $query = strtoupper($query);

	    try {
	        $stmt= $db->prepare("SELECT *
	                             FROM notes
	                             WHERE UPPER(note_topic) LIKE ?");

	        $query = "%" . $query . "%";

	        $stmt->bindParam(1, $query, PDO::PARAM_STR);

	        $stmt->execute();

	    } catch (PDOException $e) {
	        echo "error fetching results" . $e;
        }

	    $resultsarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultsarray;
	}

	function searchForDiscussions($query) {
		require(ROOT_PATH . "inc/db.php");
	    
	    $query = strtoupper($query);

	    try {
	        $stmt= $db->prepare("SELECT *
	                             FROM discussions
	                             WHERE UPPER(discussion_topic) LIKE ?");

	        $query = "%" . $query . "%";

	        $stmt->bindParam(1, $query, PDO::PARAM_STR);

	        $stmt->execute();

	    } catch (PDOException $e) {
	        echo "error fetching results" . $e;
        }

	    $resultsarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultsarray;
	}

	function searchForCourses($query) {
		require(ROOT_PATH . "inc/db.php");
	    
	    $query = strtoupper($query);

	    try {
	        $stmt= $db->prepare("SELECT *
	                             FROM courses
	                             WHERE UPPER(course_name) LIKE ?");

	        $query = "%" . $query . "%";

	        $stmt->bindParam(1, $query, PDO::PARAM_STR);

	        $stmt->execute();

	    } catch (PDOException $e) {
	        echo "error fetching results" . $e;
        }

	    $resultsarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultsarray;
	}

	function searchForMajors($query) {
		require(ROOT_PATH . "inc/db.php");
	    
	    $query = strtoupper($query);

	    try {
	        $stmt= $db->prepare("SELECT *
	                             FROM majors
	                             WHERE UPPER(major_name) LIKE ?");

	        $query = "%" . $query . "%";

	        $stmt->bindParam(1, $query, PDO::PARAM_STR);

	        $stmt->execute();

	    } catch (PDOException $e) {
	        echo "error fetching results" . $e;
        }

	    $resultsarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultsarray;
	}

	function searchForUsers($query) {
		require(ROOT_PATH . "inc/db.php");
	    
	    $query = strtoupper($query);

	    try {
	        $stmt= $db->prepare("SELECT *
	                             FROM user_profiles
	                             WHERE UPPER(user_fname) LIKE ? OR
	                             	   UPPER(user_lname) LIKE ?");

	        $query = "%" . $query . "%";

	        $stmt->bindParam(1, $query, PDO::PARAM_STR);
	        $stmt->bindParam(2, $query, PDO::PARAM_STR);

	        $stmt->execute();

	    } catch (PDOException $e) {
	        echo "error fetching results" . $e;
        }

	    $resultsarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $resultsarray;
	}

?>