<?php
	include(ROOT_PATH . "inc/functions/permission_functions.php");

	$user_id;
	
	if (isset($_GET["user_id"])) {
		$user_id = $_GET["user_id"];
	} else {
		$user_id = $_SESSION["active_user"];
	}

	echo "<a href='" . BASE_URL . "profiles/user_profile.php?user_id=" . $user_id . "'>";
	echo "<img width='150px' height='150px' src='" . getImageFromId($user_id) . "'></img></a>";
	echo "<a href='" . BASE_URL . "profiles/user_profile.php?user_id=" . $user_id . "'><h3>" . getFullNameFromId($user_id) . "</h3></a>";

	if (($page == "user_profile.php") && privateView()) {
		echo "<a href='edit_profile.php'><h5>Edit Profile</h5></a>";
	}

	if ($page == "index.php") { ?>

		<div class="col-md-1">
          <h2>Fields</h2>
          <?php
          	$majors = getMajors();
          	foreach ($majors as $major) { ?>
				<div>
        	<?php echo "<a href='fields/field.php?field_id=" . $major["major_id"] . "'>" .  $major["major_name"] . "</a>"; ?>
				</div>	
          <?php	}
          ?>
          <br>
        </div>
<?php
	}
?>


<div class="1">
	

</div>

<div>
	<?php if ($page == "profiles/user_profile.php" && privateView()) { ?>
		
		
	<?php }
			#PROMPT TO FOLLOW A USER OR NOT
		/*$prompt;
		if ($page = "profiles/user_profile.php" && !privateView()) {
			if (userIsFollowed()) {
				$prompt = "Unfollow User";
			}	else {
				$prompt = "Follow User";
			}
	
			echo "<form method='POST' action='follow_user.php'>";
			echo "	<input class='btn blue-btn' type='submit' name='follow'>" . $prompt . "</input>";
			echo "</form>";
		} */
	?>
</div>