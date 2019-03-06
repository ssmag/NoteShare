<?php
    require_once("/inc/config.php");

    include(ROOT_PATH . "inc/header.php");
    require_once(ROOT_PATH . "inc/functions/file_management_functions.php");

    //IF FORM IS SUBMITTED EXECUTE THE INSERT
    $check="";
    if (isset($_POST["submit"]) && $_FILES["note_file_input"]["name"] != "") {
        if ($_FILES["note_file_input"]["tmp_name"]!="") {
            $check = filesize($_FILES["note_file_input"]["tmp_name"]);
        }   

        $target_file = $target_dir . basename($_FILES["profile_image_input"]["name"]);
        $target_dir = NOTE_PATH . $_SESSION["active_user"];
          
        if (!file_exists($target_dir);
                mkdir($target_dir);
        
        $uploadOK = 1;

        if ($check != false) {
          
        $uploadOK = 1;
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('File is not an image.');";
            echo "</script>";
            $uploadOK = 0;
            return;
        } 
        
        $fileType = substr($check["mime"],strrpos($check["mime"],"/")+1);

       if(!acceptableNoteType($fileType)) {
            echo "<script type='text/javascript'>";
            echo "alert('Sorry only pdf files are allowed.');";
            echo "</script>";
            $uploadOK = 0;
            return;
        }


        // Check file size
        if ($_FILES["profile_image_input"]["size"] > 500000) {
            $uploadOK = 0;
            return;
        }
        
        // Check if $uploadOk is set to 0 by an error
        
        if ($uploadOK == 0) {
            echo "<script type='text/javascript'>";
            echo "alert('Sorry, your file was not uploaded.')";
            echo "</script>";
            return;
         // if everything is ok, try to upload file
        } else {
            if (!move_uploaded_file($_FILES["profile_image_input"]["tmp_name"], $target_file)) {
                echo "TARGET FILE: " . $target_file ;
                echo "<script type='text/javascript'>";
                echo "alert('Sorry, there was an error uploading your file.')";
                echo "</script>";
            }
        }
    }
?>