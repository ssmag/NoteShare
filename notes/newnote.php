<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/functions/major_functions.php");
		include(ROOT_PATH . "inc/functions/course_functions.php");
		include(ROOT_PATH . "inc/functions/note_functions.php");
		$page_title = "New Note";
		$page="newnote.php";
		session_start();
	?>
</head>

<body>
	<?php include(ROOT_PATH . "inc/nav.php"); ?>
	<br>
	<br>
	<br>

	<?php
		if (isset($_POST["submit"])) {

			$note_topic = $_POST["topic"];

			if (isset($_POST["fields"])) {
				$note_major = $_POST["fields"];
			} else {
				$note_major = "";
			}

			if (isset($_POST["courses"])) {
				$note_course = $_POST["courses"];
			} else {
				$note_course = "";
			}
			$note_filepath = BASE_URL . "document_root/user_notes/" . $_SESSION["active_user"] . "/note_" . $_SESSION["active_user"] . "_" . time() . ".pdf";
			$note_uploader = $_SESSION["active_user"];


			$noteId = addNote($note_topic, $note_major, $note_course, $note_filepath, $note_uploader);
			include("uploadnote.php");
			header("Location: newnote?note_id=" . $noteId . ".php");
			die();

		}

	?>
	
	<div class="container">
		<h2>New Note</h2>

		<form class="form-horizontal" id="new_note" name="new_note" enctype="multipart/form-data" method="POST">
		
			<div class="form-group">
				<label class="control-label col-sm-1" for="topic">*Topic: </label>
				<div class="col-sm-11">
					<textarea rows="3" cols="50" class="form-control" name="topic" maxlength="1000" required></textarea>
					<div id="textcounter-container"><strong id="textcounter">1000</strong> characters left.</div>
				</div>
			</div>
			

			<div class="form-group">
				<label class="control-label col-sm-1" for="fields">Field: </label>
				<div class="col-sm-3">
					<select class="form-control" name="fields">
						<option value="" disabled selected>Select...</option>
						<?php /***FETCHING MAJORS FROM DB***/
							$majors= getMajors();
							foreach ($majors as $major)
								echo '<option value = "' . $major["major_id"] . '">' . $major["major_name"] . '</option>';
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-1" for="courses">Course: </label>
				<div class="col-sm-3">
					<select class="form-control" name="courses">
						<option value="" disabled selected>Select...</option>
							<?php /***FETCHING COURSES FROM DB***/
								$courses= getCourses();
								foreach ($courses as $course)
									echo '<option value = "' . $course["course_id"] . '">' . $course["course_name"] . '</option>';
							?>
					</select>
				</div>
			</div>

						<input class="btn btn-default btn-file file_input" type="file" name="note_file_input" id="note_file_input" >
			<div class="form-group">
			</div>
			<input class="btn btn-success" type="submit" id="submit" name="submit" value="Upload Note"/>

		</form>
	</div>
	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>	
</body>