<head>
	<?php
		require_once("../inc/config.php");

		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/functions/user_functions.php");
		include(ROOT_PATH . "inc/functions/file_management_functions.php");
		include(ROOT_PATH . "inc/functions/major_functions.php");
		$page_title = "Create Profile";
		$page="createprofile.php";
		session_start();
	?>
	 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<?php include("profileupdate.php");	?>

<body>
    <?php include(ROOT_PATH . "inc/nav.php"); ?>


	<div class="container">
		<h1>Set up your profile</h1>

		<form class="form-horizontal" id="update_profile" name="update_profile" enctype="multipart/form-data" method="POST">
			<div class="form-group">
				<div class="control-label col-sm-2">
					<label>
						<img class="upload-file" src="../document_root/upload_image.png" width="200" height="200" id="image_preview"/>
						<input class="btn" type="file" name="profile_image_input" class="file_input" id="profile_image_input" style="display:none" >
					</label>
				</div>
			</div>
			<div class="form-group">
				<div class="control-label col-sm-2">
					<label class="control-label" for="fname">*First Name: </label>
				</div>
				<div class="col-sm-3">
					<input class="form-control" type="text" id="fname" name="fname" required/>
				</div>
			</div>
			<div class="form-group">
				<div class="control-label col-sm-2">
					<label for="lname">*Last Name: </label>
				</div>
				<div class="col-sm-3">
					<input class="form-control" type="text" id="lname" name="lname" required/>
				</div>
			</div>
			<div class="form-group">	
				<div class="control-label col-sm-2">
					<label class="control-label" for="major">*Major: </label>
				</div>
				<div class="col-sm-3">
					<select class="form-control" name="major" required>
						<option value="">Select...</option>
						<?php /***FETCHING MAJORS FROM DB***/
							$majors= getMajors();
							foreach ($majors as $major)
								echo '<option value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="control-label col-sm-2">
					<label class="control-label" for="minor">Minor: </label>
				</div>
				<div class="col-sm-3">
					<select class="form-control" name="minor">
						<option value="">Select...</option>
						<option value="">None</option>
						<?php /***FETCHING MAJORS FROM DB***/
							$majors= getMajors();
							foreach ($majors as $major)
								echo '<option value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
						?>
					</select>
				</div>
			</div>
				
			<div class="form-group">
				<div class="control-label col-sm-2">
					<label class="control-label" for="year">*Year:</label>
				</div>
				<div class="col-sm-3">
					<select class="form-control" name="year" required>
					  <option value="">Select...</option>
					  <option value="Freshman">Freshman</option>
					  <option value="Sophomore">Sophomore</option>
					  <option value="Junior">Junior</option>
					  <option value="Senior">Senior</option>
					</select>
				</div>
			</div>
			
			<input class="btn btn-success" type="submit" id="submit" name="submit" value="Done"/>

		</form>
		<footer>
			<?php include(ROOT_PATH . "inc/footer.php"); ?>
		</footer>
	</div>
</body>