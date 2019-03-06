<br>
<br>
<br>
<br>


<?php
		
	require_once("../inc/functions/file_management_functions.php");

	if (isset($_POST["submit"])) {
		
		$id = $_SESSION["active_user"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$major = $_POST["major"];
		$minor = $_POST["minor"];
		$year = $_POST["year"];
		$oldfilepath = IMAGE_PATH . $_FILES["profile_image_input"]["name"];
		$newfilepath = IMAGE_PATH . "user_" . $id . "_image.png";
		$filetype = substr($oldfilepath,strrpos($oldfilepath,".")+1);
				
		if (isset($_FILES["profile_image_input"])) {
			include("../uploadimage.php");
		}

		if ($oldfilepath == IMAGE_PATH) {
			$newfilepath = "";
			if ($page == "createprofile.php") {
				newUserProfile($id,$fname,$lname,$major,$minor,$year,$newfilepath);
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . BASE_URL . 'index.php">';
			} else if ($page == "edit_profile.php") {
				updateUserProfile($id,$fname,$lname,$major,$minor,$year,$newfilepath);
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . BASE_URL . 'profiles/user_profile.php">';
			}
		}

		if (acceptableImageType($filetype)) {

			if ($page == "createprofile.php") {
				newUserProfile($id,$fname,$lname,$major,$minor,$year,$newfilepath);
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . BASE_URL . 'index.php">';
			} else if ($page == "edit_profile.php") {
				updateUserProfile($id,$fname,$lname,$major,$minor,$year,$newfilepath);
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . BASE_URL . 'user_profile.php">';
			}

			$oldfilepath = ROOT_PATH . "document_root/user_profile_images/" . $_FILES["profile_image_input"]["name"];

			$newfilepath = ROOT_PATH . "document_root/user_profile_images/" . "user_" . $id . "_image.png";

			rename($oldfilepath,$newfilepath);
		}
	}

?>