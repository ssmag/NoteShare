<head>
	<?php
		require_once("../inc/config.php");
		include(ROOT_PATH . "inc/db.php");
		include(ROOT_PATH . "inc/functions/note_functions.php");
		include(ROOT_PATH . "inc/functions/permission_functions.php");
		include(ROOT_PATH . "objects/note_object.php");
		include(ROOT_PATH . "inc/header.php");
    	$page_title = "Profile";
		$page="notes.php";
		if (!isset($_SESSION)) session_start();
	?>
</head>

<body>	
	<br>
	<br>
	<br>
	<?php 
		include(ROOT_PATH . "inc/nav.php");

		$notes = getNotes(); 
		if (isset($_GET["user_id"])) {
			$notes = getNotesFromUser($_GET["user_id"]);
		}
		if (!(isset($_GET["user_id"])) && isset($_SESSION["active_user"])) {
			$_GET["user_id"] = $_SESSION["active_user"];
		}

		if (privateView()) {
			$note_title = "My Notes";
		} else {
			$note_title = getFirstNameFromId($_GET["user_id"]) . "'s Notes";
		}
?>
			
		<div class="container">
			<div class="row">
				<br>
				<br>
				<br>
<?php echo '		<h2>' . $note_title . '</h2>'; ?>

						<?php 
						  	$i=1;
							  foreach ($notes as $note) {
							  	if ($i == 3)
								  	echo '<div class="row">';
							  	
							  	$note_id = $note["note_id"];
								echo '<div class="box col-md-4 note-box">';
							  		noteObject($note_id);
							  	echo '</div>';

							  	if ($i == 3) {
							  		echo '</div>';
							  		$i=0;
							  	}

							  	$i++;
							  }

						?>
			</div>
		</div>
	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>	
</body>