<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");

	function getDiscussions() {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $results= $db->query("SELECT *
	                              FROM discussions
	                              ORDER BY timestamp DESC");
	    } catch (PDOException $e) {
	        echo "error selecting discussions" . $e;
        }

	    $discussions_array = $results->fetchAll(PDO::FETCH_ASSOC);
	    return $discussions_array;
	}

	function getDiscussionOfNote($noteId) {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt= $db->prepare("SELECT *
	                              FROM discussions
	                              WHERE related_note=?");

	        $stmt->bindParam(1,$noteId,PDO::PARAM_STR);

	        $stmt->execute();
	    } catch (PDOException $e) {
	        echo "error selecting discussions" . $e;
        }

	    $discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $discussions;
	}

	function noteHasDiscussion($noteId) {
		if (getDiscussionOfNote($noteId)==null) {
			return false;
		} else {
			return true;
		}
	}


		/*************WIP***********/
	function getTrendingDiscussions() { 
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $results= $db->query("SELECT *
	                              FROM discussions
	                              ORDER BY timestamp DESC");
	    } catch (PDOException $e) {
	        echo "error selecting discussions" . $e;
        }

	    $discussions_array = $results->fetchAll(PDO::FETCH_ASSOC);
	    return $discussions_array;
	}

	function getDiscussionsByMajor($majorId) {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt= $db->prepare("SELECT *
                               FROM discussions
                               WHERE discussion_major_id = ?
                               ORDER BY timestamp ASC");
	        $stmt->bindParam(1,$majorId,PDO::PARAM_STR);
	        $stmt->execute();
	    } catch (PDOException $e) {
	        echo "error selecting discussions" . $e;
        }

	    $discussions_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $discussions_array;
	}

	function getDiscussion($discussionId) {
			require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt= $db->prepare("SELECT *
	                              FROM discussions
	                              WHERE discussion_id = ?");

	        $stmt->bindParam(1,$discussionId, PDO::PARAM_STR);

	        $stmt->execute();
	    } catch (PDOException $e) {
	        echo "error selecting discussions" . $e;
        }

	    $discussions_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
	   
	   	foreach ($discussions_array as $discussion) {
	   		return $discussion;
	   	}
	}

	function getDiscussionFromUserId($userId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT *
								   FROM discussions
								   WHERE uploader_id = ?");

			$stmt->bindParam(1, $id, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding discussion" . $e;
		}

		$discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($discussions as $discussion) {
			return $discussion;
		}
	}

	function getDiscussionsFromUserId($userId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT * 
								  FROM `discussions` 
								  WHERE discussion_uploader = ?;");

			$stmt->bindParam(1, $userId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding discussion" . $e;
		}

		$discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $discussions;
	}
	function getDiscussionIdByTopic($topic) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT discussion_id
								  FROM discussions
								  WHERE discussion_topic = ?");
			$stmt->bindParam(1, $topic, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding discussion" . $e;
		}

		$discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($discussions as $discussion)
			return $discussion["discussion_id"];
	}

		function getDiscussionUploaderId($discussionId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT discussion_uploader
								  FROM discussions
								  WHERE discussion_id = ?");

			$stmt->bindParam(1, $discussionId, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding uploader" . $e;
		}

		$uploaders = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($uploaders as $uploader)
			return $uploader["discussion_uploader"];
	}


	function getAllDiscussions() {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT discussion_id
								  FROM discussions
								  WHERE discussion_topic = ?");

			$stmt->bindParam(1, $topic, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding discussion" . $e;
		}

		$discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($discussions as $discussion)
			return $discussion["discussion_id"];
	}


	function submitDiscussionWithCourse($topic, $course, $related_note) {
		require(ROOT_PATH . "inc/db.php");

		$uploader = $_SESSION["active_user"];
		$major = getMajorFromCourse($course);

		try {
			$stmt = $db->prepare("INSERT INTO `discussions`
								  (`discussion_topic`, `discussion_major_id`, `discussion_course_id`,`discussion_uploader`,`related_note`)
								  VALUES (?,?,?,?,?)");

			$stmt->bindParam(1, $topic, PDO::PARAM_STR);
			$stmt->bindParam(2, $major, PDO::PARAM_STR);
			$stmt->bindParam(3, $course, PDO::PARAM_STR);
			$stmt->bindParam(4, $uploader, PDO::PARAM_STR);
			$stmt->bindParam(5, $related_note, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt -> rowCount();

			if ($count > 0) {
				$_POST["discussion_id"] = getDiscussionIdByTopic($topic);
				return 1;
			} else return 0;

		} catch (PDOException $e) {
			echo "Error posting discussion " . $e;
		}
	}

	function submitDiscussionWithField($topic, $field, $related_note) {
		require(ROOT_PATH . "inc/db.php");

		$uploader = $_SESSION["active_user"];

		try {
			$stmt = $db->prepare("INSERT INTO `discussions`
								  (`discussion_topic`, `discussion_major_id`, `discussion_uploader`, `related_note`)
								  VALUES (?,?,?,?)");

			$stmt->bindParam(1, $topic, PDO::PARAM_STR);
			$stmt->bindParam(2, $field, PDO::PARAM_STR);
			$stmt->bindParam(3, $uploader, PDO::PARAM_STR);
			$stmt->bindParam(4, $related_note, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt -> rowCount();

			if ($count > 0) {
				$_POST["discussion_id"] = getDiscussionIdByTopic($topic);
				return 1;
			} else return 0;

		} catch (PDOException $e) {
			echo "Error posting discussion " . $e;
		}
	}

	function deleteDiscussion($discussionId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("DELETE FROM `discussions` 
								    WHERE discussion_id = ?");
			$stmt->bindParam(1, $discussionId, PDO::PARAM_STR);

			$stmt->execute();
			$count = $stmt->rowCount();
			
			return $count;
		} catch (PDOException $e) {
			echo "Error Posting discussion" . $e;
		}
	}
?>