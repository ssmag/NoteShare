<?php	
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");
	
	function acceptableImageType($imageFileType) {
		 if (strcmp($imageFileType,"jpg")==0 or strcmp($imageFileType,"png")==0
		 or strcmp($imageFileType,"jpeg")==0 or strcmp($imageFileType,"gif")==0) {
		 	return 1;
		 } else {
		 	return 0;
		 }
	}

		function acceptableNoteType($imageFileType) {
		 if (strcmp($imageFileType,"pdf")==0) {
		 	return 1;
		 } else {
		 	return 0;
		 }
	}


    function downloadFile($path) {
        ignore_user_abort(false);
        set_time_limit(0); // disable the time limit for this script
        $filename = substr($path,strlen(NOTE_PATH));
        $filepath = substr($path,0,strlen(NOTE_PATH));
        $filename = substr($filename,strpos($filename,"/"+1));
        
        $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $filename); // simple file name validation
        $dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $filepath.$dl_file;
         
        if ($fd = fopen ($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                case "pdf":
                header("Content-type: application/pdf");
                header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
                break;
                // add more headers for other content types here
                default;
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
                break;
            }
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose ($fd);
        exit;
    }


?>