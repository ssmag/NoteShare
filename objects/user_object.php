<?php
	require_once("config.php");
	require_once(ROOT_PATH . "inc/header.php");
	require_once(ROOT_PATH . "inc/functions/major_functions.php");
	require_once(ROOT_PATH . "inc/functions/discussion_functions.php");
	
	function userObject($userId) {
			$image_size = "col-sm-2";
			$image_width = "50px";
			$image_height = "50px";
			$topic_size = "col-sm-1";
			$label_size = "col-sm-3";
			$info_size = "col-sm-6"; ?>

			<style>
				.discussion-object {
					width: 500px !important;
					max-height: 500px;
					float: left;
					position: relative;
				}
			</style>
		
	<div class="row">
		<div class="container box user-object col-sm-5">
			<div class="row">
				<?php
					$user_profile_path = BASE_URL . "profiles/user_profile.php?user_id=" . $userId;
					$user_image = getImageFromId($userId);
					$user_name = getFullNameFromId($userId);

					echo '<div class="' . $image_size . '">';
					echo '<a href="' . $user_profile_path . ' ">';
					echo '<img src="' . $user_image . '" width="' . $image_width . '" height="' . $image_height . '"></img>';
					echo '</a>';
					echo '</div>';
					
				
					echo '<div class="col-sm-6">'; 
					echo $user_name;
					echo '</div>'
				?>
			</div>		
		</div>	
	</div>
	<?php } ?>
