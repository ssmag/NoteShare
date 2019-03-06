<head>
	<?php
		require_once("/inc/config.php");
		include(ROOT_PATH . "inc/db.php");

		include(ROOT_PATH . "inc/header.php");
    include(ROOT_PATH . "inc/functions/note_functions.php");
    include(ROOT_PATH . "inc/functions/major_functions.php");
   	$page_title = "Login";
		$page="index.php";
		session_start();
	?>
</head>

<body>
  <?php include(ROOT_PATH . "inc/nav.php")?>
    <br>
    <br>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-md-2">
          <?php 
            if (isset($_SESSION["active_user"])) {
              include("columns/user_profile_column.php");
            } else {
          ?>
              <div class="col-md-1">
                <h2>Fields</h2>
                  <?php
                      $majors = getMajors();
                      foreach ($majors as $major) { ?>
                  <div>
                    <?php echo "<a href='fields/field.php?field_id=" . $major["major_id"] . "'>" .  $major["major_name"] . "</a>"; ?>
                  </div>  
                    <?php }
                    ?>
                    <br>
                  </div>
          <?php } ?>

        </div>
        <div class="col-md-4">
          <h2><a href="notes/notes.php">Notes</a></h2>
          <br>
          <div class="row">
            <?php $notes = getPopularNotes(); 
              foreach ($notes as $note) { 
                $uploader_id = $note["note_uploader"];
                if (isset($note["note_major"])) {
                  $note_major = getMajorFromId($note["note_major"]);
                  $note_major_name = $note_major["major_name"];
                }
            ?>
                  <div class="row">
                    <div class="col-sm-2">
                      <?php echo '<a href="notes/note.php?note_id=' . $note["note_id"] . '">' ?>
                        <img src="document_root/note.png" width="50px" height="50px"></img>
                      </a>
                    </div>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php echo $note["note_topic"]; ?>
                    </div>
                    <?php if (isset($note_major_name)) { ?>
                        <div class="row">
                          <?php 
                            echo '<a href="fields/field.php?field_id=' . $note["note_major"] . '">';
                            echo $note_major_name; 
                            echo '</a>';
                          ?>
                        </div>
                    <?php } ?>
                    <div class="row">
                      <?php 
                        echo '<a href="profiles/user_profile.php?user_id=' . $uploader_id . '">';
                        echo getFullNameFromId($uploader_id);
                        echo '<a>'; 
                      ?>
                    </div>
                  </div>
                  </div>
                  <br>
            <?php  } ?>


          </div>


          <p><a class="btn btn-default" href="notes/notes.php" role="button">See More &raquo;</a></p>
        </div>
        <div class="col-md-5">
          <?php include("discussion_board.php"); ?>
        
      </div>


	<footer>
		<?php include(ROOT_PATH . "inc/footer.php"); ?>
	</footer>
</body>