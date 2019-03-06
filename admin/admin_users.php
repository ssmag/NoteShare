<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/functions/user_functions.php");
		include(ROOT_PATH . "inc/functions/major_functions.php");
		$page_title = "Search Results";
		$page="admin_user.php";
		session_start();
	?>
</head>

<body>
	<br>
	<br>
	<br>
	<?php include(ROOT_PATH . "inc/nav.php"); ?>
	
<?  
	if (!isset($_SESSION["admin"])) {
		header("Location: ../index.php");
		die();
    } 
?>
	<div class="container">
		<table class="table table-bordered">
	    <thead>
	      <tr>
	        <th>First Name</th>
	        <th>Last Name</th>
	        <th>Major</th>
	        <th>Minor</th>
	        <th>Year</th>
	        <th>Profile Picture</th>
	      </tr>
	    </thead>

	    <tbody>
<?php
		$users = getUsers();

		foreach ($users as $user) {
			$fname = $user["user_fname"];
			$lname = $user["user_lname"];

			$major_id = $user["user_major"];
			$major = getMajorFromId($major_id);
			$major_name = $major["major_name"];

			$minor_id = $user["user_minor"];
			$minor = getMajorFromId($minor_id);
			$minor_name = $major["major_name"];

			$year = $user["user_year"];

			$image = $user["profile_image_path"];

			$nameinputstring1='';
			$lnameinputstring1="";
			$inputstring2='';
			$buttoncolour="btn-primary";
			$buttonvalue="Edit";

			if (isset($_GET["edit"])) {
				$nameinputstring1='<input type="text" name="newName" id="newName" value="';
				$lnameinputstring1='<input type="text" name="newLName" id="newLName" value="';
				$buttoncolour="btn-info";
				$buttonvalue="Submit";
				$inputstring2='"';
			}


			if (isset($_GET["edit"])) {
				if ($_GET["edit"] == "Submit") {
					$newName = $_GET["newName"];
					$newLName = $_GET["newLName"];
					$newMajor = $_GET["major"];
					$newMinor = $_GET["minor"];
					$newYear = $_GET["year"];
					$userId = $_GET["user_id"];

				updateUserProfile($userId, $newName, $newLName, $newMajor, $newMinor, $newYear, $image);
				/*header("Location: admin_users.php");
				die();*/
				}
			}

			if (isset($_GET["delete"])) {
				deleteUser($_GET["user_id"]);
			}


?>			
	      <tr>	
<?php 	

			echo '<form class="edit-delete" id="edit-delete" method="GET" name="edit-delete">';
			echo '<td>' . $nameinputstring1 . $fname . $inputstring2 . '</td>';
			echo '<td>' . $lnameinputstring1 . $lname . $inputstring2 .'</td>';
			if (isset($_GET["edit"])) { ?>
				<td>
					<select class="form-control" name="major" required>
						<?php
							/***FETCHING MAJORS FROM DB***/
							$majors= getMajors();
							foreach ($majors as $major) {
								if (!$major["major_id"] != $major_id /*getStudentMajorById($user_id)*/){
									echo '<option value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
								} else {
									echo '<option value = "' . $major_id . '">' . $major_name. '" selected></option>';
								}
							}
						?>
					</select>
				</td>
				<td>	
					<select class="form-control" name="minor" required>
						<?php
							/***FETCHING MAJORS FROM DB***/
							$majors= getMajors();
							foreach ($majors as $major) {
								if (!$major["major_id"] != $minor_id /*getStudentMajorById($user_id)*/){
									echo '<option value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
								} else {
									echo '<option value = "' . $minor_id . '">' . $minor_name . '  selected></option>';
								}
							}
						?>
					</select>
				</td>	
				<td>
					<select class="form-control" name="year" required>
					  <option value="Freshman">Freshman</option>
					  <option value="Sophomore">Sophomore</option>
					  <option value="Junior">Junior</option>
					  <option value="Senior">Senior</option>
					  <option value="NA">N/A</option>
					</select>
				</td>
	<?php	} else {
				echo "<td>" . $major_name . "</td>";
				echo "<td>" . $minor_name . "</td>";
				echo "<td>" . $year . "</td>";
			}
			echo '<td><img width="50px" height="50px" src="' . $image . '"></img></td>';
			echo '<td><input type="submit" class="edit btn ' . $buttoncolour . '" name="edit" value="' . $buttonvalue . '"></input></td>';
			echo '<td><input type="submit" class="edit btn btn-danger" name="delete" value="Delete"></input></td>';
			echo '<input type="hidden" name="user_id" value="' . $user["user_id"] . '"/>';
			echo '</form>';
?>
	      </tr>
<?php 		
		}
?>
	    </tbody>
	  </table>
	</div>

	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>
</body>