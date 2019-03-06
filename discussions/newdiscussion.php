<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
		include(ROOT_PATH . "inc/functions/file_management_functions.php");
		include(ROOT_PATH . "inc/functions/major_functions.php");
		include(ROOT_PATH . "inc/functions/course_functions.php");
		include(ROOT_PATH . "inc/functions/discussion_functions.php");
		$page_title = "New Discussion";
		$page="newdiscussion.php";
		session_start();
		if (!isset($_SESSION["active_user"])) {
			header('Location: ' . BASE_URL . "havetobeloggedin.php");
			die();
		}
	?>
</head>

<body>
	<?php include(ROOT_PATH . "inc/nav.php"); ?>

	<?php 
	

		if (isset($_SESSION["related_note"])) {
			$related_note = $_SESSION["related_note"];
		} else {
			$related_note = 0;
		}

		if (isset($_POST["submit"])) {
			if (!isset($_POST["fields"]) && !isset($_POST["courses"])) {
				echo "<script type='text/javascript'>";
				echo "alert('You must indicate either the field or the course of the topic!')";
				echo "</script>";
				
			} else {
				$field="";
				$course="";
				$submitted="";
				if (!isset($_POST["fields"])) {
					$topic = $_POST["topic"];
					$course = $_POST["courses"];
					$submitted = submitDiscussionWithCourse($topic,$course, $related_note);
				} else if (!isset($_POST["courses"])) {
					$topic = $_POST["topic"];
					$field = $_POST["fields"];
					$submitted = submitDiscussionWithField($topic,$field, $related_noted);
				}

				if ($submitted) { ?>
					<script type="text/javascript">
						alert("Discussion posted");
					</script>

					<?php echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . BASE_URL . 'discussions/discussion.php?discussion_id=' . $_POST["discussion_id"] . ' ">';
				}
			}
		}
	?>		

	<div class="container">
		<h2>New Discussion</h2>

		<form class="form-horizontal" id="new_discussion" name="new_discussion" method="POST">
			<div class="form-group">
				<label class="control-label col-sm-1" for="topic">*Topic: </label>
				<div class="col-sm-11">
					<textarea rows="3" cols="50" id="topic" name="topic" class="form-control" maxlength="700" required></textarea>
					<div id="textcounter-container"><strong id="textcounter">700</strong> characters left.</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-1" for="fields">Field: </label>
				<div class="col-sm-3">
					<select class="form-control" id="fields" name="fields">
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
					<select class="form-control" id="courses" name="courses">
						<option value="" disabled selected>Select...</option>
							<?php /***FETCHING COURSES FROM DB***/
								$courses= getCourses();
								foreach ($courses as $course)
									echo '<option value = "' . $course["course_id"] . '">' . $course["course_name"] . '</option>';
							?>
					</select>
				</div>
			</div>
			<input class="btn btn-success" type="submit" id="submit" name="submit" value="Post"/>
		</form>
		
		<form id="hidden_field_form" name="hidden_field_form" method="POST">
			<input type="hidden" name="hidden_course" id="hidden_course"/>
			<input type="hidden" name="hidden_field" id="hidden_field"/>
			<input type="submit" name="submit_hidden_field" id="submit_hidden_field" style="display: none"/input>
		</form>
	</div>
	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>	
</body>