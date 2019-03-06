<?php 
	require_once("config.php");
	include(ROOT_PATH . "inc/db.php");

	function privateView() {
		if (isset($_GET["user_id"]) && isset($_SESSION["active_user"])) {
			if ($_GET["user_id"] == $_SESSION["active_user"]) return 1;
			else return 0; 
		}
	}

?>