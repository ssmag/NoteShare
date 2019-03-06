<?php
	require_once("../inc/config.php");
	require_once(ROOT_PATH . "inc/header.php");
	require_once(ROOT_PATH . "inc/functions/major_functions.php");
 
 	function majorObject($majorId) {
	 	$major = getMajorFromId($majorId); ?>
		<div class="container box">
			<div class="row">
				<div class="">
					<label class="col-sm-1" for="field">Field: </label>
					<?php echo '<a href="fields/field.php?field_id=' . $major["major_id"] . '"><div name="field" id="field">';
						  echo $major["major_name"];
						  echo '</div></a>'; ?>
				</div>
				<div class="col-sm-11">
				</div>
			</div>
			<br>
			<br>
			
			<div class="row">
				<label class="col-sm-1">Courses: </label>
			</div>
			<?php 
				$courses = getCoursesOfMajor($majorId);
				$i=$j=0;
				foreach ($courses as $course) {
					$i++;
					if ($i > 3) { $i = 3; }
				}

				foreach ($courses as $course) { 
					$j++;
					
					if ($i<=$j) { 
			?>

					<div class="row">
							
						<?php	echo '<a href="course.php?course_id=' . $course["course_id"] . '"><div class="col-sm-4" name="coursename" id="coursename">';
								echo $course["course_name"]; 
								echo '</div></a>';
						?>
					</div>	
			<?php 	}
				}
			?>
		</div>
		<?php } 