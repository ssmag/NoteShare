<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");

	
	function getNotes() {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $results= $db->query("SELECT *
	                              FROM notes
	                              ORDER BY timestamp ASC");
	    } catch (PDOException $e) {
	        echo "error selecting notes" . $e;
        }

	    $notes_array = $results->fetchAll(PDO::FETCH_ASSOC);
	    return $notes_array;
	}

	function getNoteByNotePath($path) {
		require(ROOT_PATH . "inc/db.php");
		    
		    try {
		        $stmt= $db->prepare("SELECT *
		                             FROM notes
		                             WHERE note_filepath=?");

		        $stmt->bindParam(1, $path, PDO::PARAM_STR);

		        $stmt->execute();

		    } catch (PDOException $e) {
		        echo "error selecting notes" . $e;
	        }

		    $notes_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    return $notes_array[0];
	}

	function getNote($noteId) {
		require(ROOT_PATH . "inc/db.php");
		    
		    try {
		        $stmt= $db->prepare("SELECT *
		                             FROM notes
		                             WHERE note_id=?
		                             ORDER BY timestamp ASC");

		        $stmt->bindParam(1, $noteId, PDO::PARAM_STR);

		        $stmt->execute();

		    } catch (PDOException $e) {
		        echo "error selecting notes" . $e;
	        }

		    $notes_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    return $notes_array[0];
	}

	function getNoteUploader($noteId) {
		$note = getNote($noteId);

		return $note['note_uploader'];
	}

	function getNotesFromUser($uploaderId) {
		require(ROOT_PATH . "inc/db.php");
		    
		    try {
		        $stmt= $db->prepare("SELECT *
		                             FROM notes
		                             WHERE note_uploader=?
		                             ORDER BY timestamp ASC");

		        $stmt->bindParam(1, $uploaderId, PDO::PARAM_STR);

		        $stmt->execute();

		    } catch (PDOException $e) {
		        echo "error selecting notes" . $e;
	        }

		    $notes_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    return $notes_array;
	}

	function getFileNameFromId($noteId) {
	require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt= $db->prepare("SELECT note_filepath
	                             FROM notes
	                             WHERE note_id=?");

	        $stmt->bindParam(1, $noteId, PDO::PARAM_STR);

	        $stmt->execute();

	    } catch (PDOException $e) {
	        echo "error selecting notes" . $e;
        }

	    $notes_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    
	   	return $notes_array[0]["note_filepath"];
	    
	}




	function addNote($note_topic, $note_major, $note_course, $note_filepath, $note_uploader) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("INSERT INTO `notes`(`note_topic`, `note_major`, `note_course`, `note_filepath`, `note_uploader`) 
								  VALUES (?,?,?,?,?)");

			$stmt->bindParam(1, $note_topic, PDO::PARAM_STR);
			$stmt->bindParam(2, $note_major, PDO::PARAM_STR);
			$stmt->bindParam(3, $note_course, PDO::PARAM_STR);
			$stmt->bindParam(4, $note_filepath, PDO::PARAM_STR);
			$stmt->bindParam(5, $note_uploader, PDO::PARAM_STR);

			$stmt->execute();

	        $count = $stmt->rowCount();



		} catch (PDOException $e) {
			echo $e;
		}

		$note = getNoteByNotePath($note_filepath);

		return $note["note_id"];
	}

	function numberOfExistingNotes() {
		require(ROOT_PATH . "inc/db.php"); 

		try {
			$results= $db->query("SELECT COUNT(*)
								  FROM notes where 1");
		} catch (PDOException $e) {
			echo $e;
		}

		$amountOfNotes = $results->fetchAll(PDO::FETCH_ASSOC);

		return $amountOfNotes[0]["COUNT(*)"];
	}

	function likeNote($userId,$noteId) {
		require(ROOT_PATH . "inc/db.php");

		$currentLikes = countLikes($noteId);
		$newLikes = $currentLikes+1;
		try {
			$stmt = $db->prepare("UPDATE notes
								  SET likes=?
								  WHERE note_id=?");

			$stmt->bindParam(1,$newLikes,PDO::PARAM_STR);
			$stmt->bindParam(2,$noteId,PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "Error" . $e;
		}

		try {
			$stmt = $db->prepare("INSERT INTO `likes`(`user_id`, `note_id`) 
								   VALUES (?,?)");

			$stmt->bindParam(1,$userId,PDO::PARAM_STR);
			$stmt->bindParam(2,$noteId,PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "Error " . $e;
		}
	}

	function unLikeNote($userId,$noteId) {
		require(ROOT_PATH . "inc/db.php");

		$likes = countLikes($noteId);
		$newLikes = $likes-1;
		try {
			$stmt = $db->prepare("UPDATE notes
								  SET likes=?
								  WHERE note_id=?");

			$stmt->bindParam(1,$newLikes,PDO::PARAM_STR);
			$stmt->bindParam(2,$noteId,PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "Error" . $e;
		}

		try {
			$stmt = $db->prepare("DELETE FROM `likes` 
								  WHERE `likes`.`user_id` = ?
								  AND `likes`.`note_id` = ?");

			$stmt->bindParam(1,$userId,PDO::PARAM_STR);
			$stmt->bindParam(2,$noteId,PDO::PARAM_STR);

			$stmt->execute();

			$count = $stmt->rowCount();
		} catch (PDOException $e) {
			echo "Error " . $e;
		}
	}

	function countLikes($noteId) {
		require(ROOT_PATH . "inc/db.php");

		$stmt = $db->prepare("SELECT *
		    				  FROM likes
							  WHERE note_id=?");

		$stmt->bindParam(1,$noteId);
		$stmt->execute();

		$count = $stmt->rowCount();

		return $count;
	}

	function userLikes($userId,$noteId) {
		require(ROOT_PATH . "inc/db.php");

		$stmt = $db->prepare("SELECT *
							  FROM likes
							  WHERE user_id=? and note_id=?");

		$stmt->bindParam(1,$userId,PDO::PARAM_STR);
		$stmt->bindParam(2,$noteId,PDO::PARAM_STR);

		$stmt->execute();

		$count = $stmt->rowCount();

		if ($count != 0) return true;
		else return false;
	}

	function getPopularNotes() {
		require(ROOT_PATH . "inc/db.php");
	
		try {
			$results = $db->query("SELECT *
								  FROM notes
								  ORDER BY likes DESC");

		
		} catch (PDOException $e) {
			echo $e;
		}

	    $notes_array = $results->fetchAll(PDO::FETCH_ASSOC);

	    $i=0;
	    $popular_notes=[];
	    foreach ($notes_array as $note) {
	    	if ($i <= 4) {
	    		array_push($popular_notes,$note);
	    	}
	    	$i++;
	    }

	    return $popular_notes;
	}

	


