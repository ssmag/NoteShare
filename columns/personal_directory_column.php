<div class="directory-column">
	<div class="box">
		<div class="row">
			<?php echo '<a href="' . BASE_URL . 'fields/field.php?field_id=' . getUserMajorFromId($user_id). '">My Field</a>'; ?>
		</div>
		<div class="row">
			<?php echo '<a href="' . BASE_URL . 'notes/notes.php?user_id=' . $user_id . '">My Notes</a>'; ?>
		</div>
		<div class="row">
			<?php echo '<a href="' . BASE_URL . 'discussion_board.php?user_id=' . $user_id . '">My Discussions</a>'; ?>
		</div>
	</div>

	<div class="directory-links">
		<div class="row">
			<?php echo '<a href="' . BASE_URL . 'notes/newnote.php">Upload Note</a>'; ?>
		</div>
		<div class="row">
			<?php echo '<a href="' . BASE_URL . 'discussions/newdiscussion.php">Start Discussion</a>'; ?>
		</div>
		
	</div>	
</div>