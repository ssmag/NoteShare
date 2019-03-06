<?php
	
	session_start();
	require_once("inc/config.php");
	include(ROOT_PATH . "inc/functions/user_functions.php");

	var_dump(getUsers());
?>