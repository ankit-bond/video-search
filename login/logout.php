<?php 
	session_start();
	session_destroy();
	$extra = 'Login1.php';
	header( "Location:$extra");
?>
