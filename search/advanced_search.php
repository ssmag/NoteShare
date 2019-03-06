<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
    include(ROOT_PATH . "inc/functions/major_functions.php");
		$page_title = "Login";
		$page="advanced_search.php";
		session_start();
	?>
</head>

<body>
	<?php include(ROOT_PATH . 'inc/nav.php'); ?>
	<div class="container">
		<h2>Advanced Search</h2>
		<form class="form-horizontal" method="GET" action="search.php">
			<div class="form-group">
				<div class="control-label col-sm-1">
					<label for="topic">Topic: </label>
				</div>
				<div class="col-sm-3">
					<input class="form-control" id="topic" name="topic" type="text"/>
				</div>
			</div>

			<div class="form-group">
				<div class="control-label col-sm-1">
					<label for="field">Field: </label>
				</div>
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
				<div class="control-label col-sm-1">
					<label for="course">Course: </label>
				</div>
				<div class="col-sm-3">
					<input class="form-control" id="course" name="course" type="text"/>
				</div>
			</div>

			<div class="form-group">
				<div class="control-label col-sm-1">
					<label for="uploader">Uploader: </label>
				</div>
				<div class="col-sm-3">
						<input class="form-control" id="uploader" name="uploader" type="text"/>
				</div>
			</div>

			<button class="btn btn-success" type="submit" id="submit" name="submit" value="Post">
				<b>Search </b><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
			</button>
		</form>	
	</div>
	<footer>
		<?php include('../inc/footer.php'); ?>
	</footer>
</body>