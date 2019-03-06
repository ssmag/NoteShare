<?php
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");

	
	function isAdmin($email) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT *
								  FROM users
								  WHERE user_email=?
								  AND is_admin=1");

			$stmt->bindParam(1,$email);

			$stmt->execute();
		} catch (PDOException $e)  {
			echo "Error in finding administrators: " . $e;
		}

		$count = $stmt->rowCount();

		if ($count == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	function getUsers() {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $results= $db->query("SELECT *
	                              FROM user_profiles");

	    } catch (PDOException $e) {
	        echo "error selecting majors" . $e;
	    }

	    $users_array = $results->fetchAll(PDO::FETCH_ASSOC);
	    return $users_array;
	}



	function getIdFromEmail($userEmail) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT user_id
								   FROM users
								   WHERE user_email = ?");

			$stmt->bindParam(1, $userEmail, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error selecting user id" . $e;
		}

		$users_array= $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($users_array as $user) {
			return $user["user_id"];
		}
	}


	function getImageFromId($id) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT profile_image_path
								   FROM user_profiles
								   WHERE user_id = ?");

			$stmt->bindParam(1, $id, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding profile image path" . $e;
		}

		$user_profiles_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($user_profiles_array as $user_profile) {
			return $user_profile["profile_image_path"];
		}
	}

	

	function getFullNameFromId($id) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT user_fname, user_lname
								   FROM user_profiles
								   WHERE user_id = ?");

			$stmt->bindParam(1, $id, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding user's name" . $e;
		}

		$user_profiles_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($user_profiles_array as $user_profile) {
			$name_array[0] = $user_profile["user_fname"];
			$name_array[1] =  $user_profile["user_lname"];
			
			$full_name = $name_array[0] . " " . $name_array[1];
		}

		return $full_name;
	}

	function getFirstNameFromId($id) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT user_fname	
								  FROM user_profiles
								  WHERE user_id = ?");

			$stmt->bindParam(1, $id, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding user's name" . $e;
		}

		$user_profiles_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($user_profiles_array as $user_profile) {
			$user_fname = $user_profile["user_fname"];
		}

		return $user_fname;
	}

	function getLastNameFromId($id) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("SELECT user_lname	
								  FROM user_profiles
								  WHERE user_id = ?");

			$stmt->bindParam(1, $id, PDO::PARAM_STR);

			$stmt->execute();
		} catch (PDOException $e) {
			echo "error finding user's name" . $e;
		}

		$user_profiles_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($user_profiles_array as $user_profile) {
			$user_fname = $user_profile["user_lname"];
		}

		return $user_fname;
	}


	function userExists($user) {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $results= $db->query("SELECT user_email
	                              FROM users");
	    } catch (PDOException $e) {
	        echo "error selecting user" . $e;
        }

	    $user_emails_array = $results->fetchAll(PDO::FETCH_ASSOC);
	    
	    foreach($user_emails_array as $user_email) {
	    	if ($user_email["user_email"] == $user) return true;
	    }
	}

	function verifyUser($email,$password) {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt= $db->prepare("SELECT user_email, user_password
	                             FROM users
	                             WHERE user_email = ?");
	        $stmt->bindParam(1, $email, PDO::PARAM_STR);
	       	
	        $stmt->execute();
	        $count = $stmt->rowCount();
	       	
	    } catch (PDOException $e) {
	        echo "error selecting user" . $e;
        }

	    $users_array = $stmt->fetchAll(PDO::FETCH_ASSOC);	  
	    $valid = password_verify($password,$users_array[0]["user_password"]);
	    if ($valid && $count > 0) {
	    	return true;
	    } else {
	    	return false;
	    }
	}	
	
	function validEmail($email) {
		return filter_var($email,FILTER_VALIDATE_EMAIL);
	}	


	function newUser($userEmail,$userPassword) {
		require(ROOT_PATH . "inc/db.php");

		try {
			$stmt = $db->prepare("INSERT INTO users(user_email,user_password) VALUES (?,?)");
	        $stmt->bindParam(1, $userEmail, PDO::PARAM_STR);
	        $stmt->bindParam(2, $userPassword, PDO::PARAM_STR);
	        $stmt->execute();
	        $count = $stmt->rowCount();

	        if ($count>0) return "User added ";
	        else return "Error adding user.";

   		} catch (PDOException $e) {
        	echo "some insert error..." ;
		}	
	}

	function newUserProfile($userId, $userFirstName, $userLastName, $userMajor, $userMinor, $userYear, $userImageFilePath) {
		require(ROOT_PATH . "inc/db.php");

		if ($userImageFilePath == "") {
			$userImageFilePath = IMAGE_PATH . "default_image.png";
		}
				
		try {
			$stmt = $db->prepare("INSERT INTO user_profiles(user_id,user_fname,user_lname,user_major,user_minor,user_year,profile_image_path)
								  VALUES (?,?,?,?,?,?,?)");
	        $stmt->bindParam(1, $userId, PDO::PARAM_STR);
	        $stmt->bindParam(2, $userFirstName, PDO::PARAM_STR);
	        $stmt->bindParam(3, $userLastName, PDO::PARAM_STR);
	        $stmt->bindParam(4, $userMajor, PDO::PARAM_STR);
	        $stmt->bindParam(5, $userMinor, PDO::PARAM_STR);
	        $stmt->bindParam(6, $userYear, PDO::PARAM_STR);
	        $stmt->bindParam(7, $userImageFilePath, PDO::PARAM_STR);
	        $stmt->execute();
	        $count = $stmt->rowCount();

	        if ($count>0) return "User profile created ";
	        else return "Error creating profile.";

   		} catch (PDOException $e) {
        	echo "some insert error..." ;
		}	
	}

	function getImageFilePathByUserId($userId) {
		require(ROOT_PATH . "inc/db.php");
		try  {
			$stmt = $db->prepare("SELECT profile_image_path
								  FROM user_profiles
								  WHERE user_id = ?");
			$stmt->bindParam(1, $userId, PDO::PARAM_STR);

			$stmt->execute();

	    	$array = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $array[0]["profile_image_path"];
		} catch (PDOException $e) {
			echo "Error return code: " . $e;
		}
	}

	function updateUserProfile($userId, $userFirstName, $userLastName, $userMajor, $userMinor, $userYear, $userImageFilePath) {
		require(ROOT_PATH . "inc/db.php");

		if ($userImageFilePath == "") {
			$userImageFilePath = getImageFilePathByUserId($userId);
		}
		
		try {
			$stmt = $db->prepare("UPDATE `user_profiles` 
								  SET `user_fname`=?,`user_lname`=?,
							      `user_major`=?,`user_minor`=?,`user_year`=?,
							      `profile_image_path`=?
				 				  WHERE `user_id`=?");
	        $stmt->bindParam(1, $userFirstName, PDO::PARAM_STR);
	        $stmt->bindParam(2, $userLastName, PDO::PARAM_STR);
	        $stmt->bindParam(3, $userMajor, PDO::PARAM_STR);
	        $stmt->bindParam(4, $userMinor, PDO::PARAM_STR);
	        $stmt->bindParam(5, $userYear, PDO::PARAM_STR);
	        $stmt->bindParam(6, $userImageFilePath, PDO::PARAM_STR);
	        $stmt->bindParam(7, $userId, PDO::PARAM_STR);
	        $stmt->execute();
	        $count = $stmt->rowCount();

	        if ($count>0) return "User profile updated ";
	        else return "Error updating profile.";

   		} catch (PDOException $e) {
        	echo "some insert error..." ;
		}	
	}


	function userHasProfile($userId) {
		require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt = $db->prepare("SELECT *
	                              FROM user_profiles
	                              WHERE user_id = ?");
	        $stmt->bindParam(1,$userId, PDO::PARAM_STR);
	        $stmt->execute();
	        $count = $stmt->rowCount();

	        if ($count>0) return 1;
	        else return 0;
	    } catch (PDOException $e) {
	        echo "error finding user profile" . $e;
        }
    }    

    function deleteUser($userId) {
    	require(ROOT_PATH . "inc/db.php");
	    
	    try {
	        $stmt = $db->prepare("DELETE FROM `user_profiles` 
	        					  WHERE `user_profiles`.`user_id` = ?");
	        $stmt->bindParam(1,$userId, PDO::PARAM_STR);
	        $stmt->execute();
	        $count = $stmt->rowCount();
	    } catch (PDOException $e) {
	        echo "error finding user profile" . $e;
        }

	    try {
	        $stmt = $db->prepare("DELETE FROM `users` 
	        					  WHERE `users`.`user_id` = 50");
	        $stmt->bindParam(1,$userId, PDO::PARAM_STR);
	        $stmt->execute();
	        $count = $stmt->rowCount();
	    } catch (PDOException $e) {
	        echo "error finding user profile" . $e;
        }

        unlink(IMAGE_PATH . "user_" . $userId . "_image.png");
    }
?>