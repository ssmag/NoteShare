<head>	
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/header.php");
    	include(ROOT_PATH . "inc/functions/user_functions.php");
    	include(ROOT_PATH . "inc/functions/major_functions.php");
		$page_title = "Edit Profile";
		$page="edit_profile.php";
		session_start();

		$user_id = $_SESSION["active_user"];
	?>
</head>
	
<body>
	<?php include("profileupdate.php"); ?>
	<?php include(ROOT_PATH . "inc/nav.php"); ?>

	<div class="container">
		<br>
		<br>
		<br>
		<h2>Edit Profile</h2>
		<form class="form-horizontal" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label>
					<?php 
						echo "<img class='upload-file' src='" . getImageFromId($user_id) . "' width='200' height='200' id='image_preview'/>"; ?>
						<input class='btn' type='file' name='profile_image_input' class='file_input' id='profile_image_input' style='display:none'> 
				</label>
			</div>

			<div class="form-group">
				<div class="control-label col-sm-2">
					<label for="fname">*First Name: </label>
				</div>
				<div class="col-sm-3">
					<?php 
						$fname = getFirstNameFromId($user_id);
						echo '<input class="form-control" id="fname" name="fname" type="text" placeholder="' . $fname . '" value="' . $fname . '" required/>';
					?>
				</div>
			</div>

			<div class="form-group">
				<div class="control-label col-sm-2">
					<label for="lname">*Last Name: </label>
				</div>
				<div class="col-sm-3">
				<?php 
					$lname = getLastNameFromId($user_id);
					echo '<input class="form-control" id="lname" name="lname" type="text" placeholder="' . $lname . '" value="' . $lname . '" required/>';
				?>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-label col-sm-2">
					<label for="major">*Major: </label>
				</div>
				<div class="col-sm-3">
					<select class="form-control" name="major" required>
						<?php
							/***FETCHING MAJORS FROM DB***/
							$majors= getMajors();
							foreach ($majors as $major) {
								if (!$major["major_id"] == 1 /*getStudentMajorById($user_id)*/){
									echo '<option value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
								} else {
									echo '<option selected="selected" value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
								}
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="control-label col-sm-2">
					<label for="minor">Minor: </label>
				</div>
				<div class="col-sm-3">
					<select class="form-control" name="minor">
					<option value="">Select...</option>
					<option value="">None</option>
					<?php /***FETCHING MAJORS FROM DB***/
						$majors= getMajors();
						foreach ($majors as $major) {
							if (!$major["major_id"] == 1 /*getStudentMinorById($user_id)*/) {
								echo '<option value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
							} else {
								echo '<option selected="selected" value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
							}
						}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="control-label col-sm-2">
					<label for="year">*Year:</label>
				</div>
				<div class="col-sm-3">
					<select class="form-control" name="year" required>
					  <option value="Freshman">Freshman</option>
					  <option value="Sophomore">Sophomore</option>
					  <option value="Junior">Junior</option>
					  <option value="Senior">Senior</option>
					  <option value="NA">N/A</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="control-label col-sm-2">
					<label class="control-label" for="course">Courses: </label>
				</div>

				<div class="col-sm-3">
					<input class="form-control course-field" type="text" name="course" id="course-1" data-provide="typeahead" autocomplete="off"/>
				</div>
				<div class="col-sm-3" id="buttons div class">
					<button class="btn" id="courses_button" name="courses_button" type="button" value="1">Add More</button>
				</div>
			</div>
				<input class="btn btn-success" type="submit" id="submit" name="submit" value="Update"/>
		</form>

		<footer>
			<?php include(ROOT_PATH . "inc/footer.php"); ?>

		</footer>
		</form>
	</div>
</body>