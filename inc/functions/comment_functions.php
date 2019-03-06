<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");

	function getComments($discussionId) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT *
								  FROM comments
								  WHERE discussion_id = ?
								  ORDER BY timestamp DESC");

			$stmt->bindParam(1, $discussionId,PDO::PARAM_STR);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Error: " . $e;
		}

		$comments_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $comments_array;
	}

	function postComment($discussionId, $commenterId, $comment) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("INSERT INTO comments
								 (discussion_id, commenter_id, comment_text) 
								 VALUES (?,?,?)");
			$stmt->bindParam(1, $discussionId,PDO::PARAM_STR);
			$stmt->bindParam(2, $commenterId,PDO::PARAM_STR);
			$stmt->bindParam(3, $comment,PDO::PARAM_STR);

			$stmt->execute();
			$count = $stmt -> rowCount();
		} catch (PDOException $e) {
			echo "Error: " . $e;
		}

		if ($count > 0) return 1;
		else return 0;
	}

?>