  <?php   
   require_once(ROOT_PATH . "inc/functions/user_functions.php");  

  ?>

  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
        <?php
        $current_user_id="";
            echo '<a class="navbar-brand" href="' . BASE_URL . 'index.php">NoteShare</a>';
            if (isset($_SESSION["active_user"]))
              $current_user_id = $_SESSION["active_user"];

            if (userHasProfile($current_user_id) && !($page == "index.php" || $page == "user_profile.php" || $page == "edit_profile.php")) {
              echo '<a href="' . BASE_URL . 'profiles/user_profile.php">';
              echo '  <img class="navbar-brand" src="' . getImageFromId($current_user_id) . '"/>';
              echo '  <p class="navbar-brand"> ' . getFullNameFromId($current_user_id) . '</p>';
              echo '</a>';
            }
        ?>
        </div> 
        <div id="navbar" class="navbar-collapse collapse">
        <?php  echo '<a href="' . BASE_URL . 'about.php">About Us</a>'; ?>
          <?php if (isset($_SESSION["admin"]) && $page != "admin.php") {
                    echo '<button data-toggle="modal" data-target="#adminModal" class="btn">Admin Panel</button>';
                }
                echo '<form class="navbar-form navbar-right" method="GET" action="' . BASE_URL . "search/search.php" .'">' ?>
            <div class="form-group">
              <?php if ($page != "advanced_search.php") { ?>
                <input type="text" placeholder="Search" id="query" name="query" class="form-control" required>
              <?php } ?>
            </div>
            <div id="navbar" class="navbar-right">          
              <?php 

                $authentication_url;
                $authentication_text;
                if (isset($_SESSION["active_user"])) {
                  $authentication_url = "logout.php";
                  $authentication_text = "Logout";
                } else {
                  $authentication_url = "login.php";
                  $authentication_text = "Login/Sign Up";
                }
                  echo '<a href="' . BASE_URL . 'authentication/' . $authentication_url . '">' . $authentication_text . ' </a>'; 
                ?>
            </div>
            <?php if ($page != "advanced_search.php") { ?>
              <button type="submit" class="btn btn-success glyphicon glyphicon-search"></button>
            <?php } ?>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <div class="modal fade" id="adminModal" tabindex="0" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-body">
                <div class="col-md-4">
<?php echo    '<a href="' . BASE_URL . 'admin/admin_users.php">'; ?>
                <button class="btn btn-info">Users</button>
              </a>
            </div>
            <div class="col-md-4">
<?php echo    '<a href="' . BASE_URL . 'admin/admin_courses.php">'; ?>
                <button class="btn btn-info">Courses</button>
              </a>
            </div>
            <div class="col-md-4">
<?php echo    '<a href="' . BASE_URL . 'admin/admin_fields.php">'; ?>
                <button class="btn btn-info">Fields</button>
              </a>
            </div>
            <div class="col-md-4">
<?php echo    '<a href="' . BASE_URL . 'admin/admin_notes.php">'; ?>
                <button class="btn btn-info">Notes</button>
              </a>
            </div>
            <div class="col-md-4">
<?php echo    '<a href="' . BASE_URL . 'admin/admin_comments.php">'; ?>
                <button class="btn btn-info">Comments</button>
              </a>
            </div>
            <div class="col-md-4">
<?php echo    '<a href="' . BASE_URL . 'admin/admin_discussions.php">'; ?>
                <button class="btn btn-info">Discussions</button>
              </a>
            </div>
          </div>
            <div class="modal-footer">
              Cancel
            </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->