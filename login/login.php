<?php

session_start();
	
$host = "localhost";
$database = "data1";
$user = "root";
$pass = "ankit";

$conn = mysql_connect($host,$user,$pass);

	$data = mysql_select_db($database, $conn);
	$name = $_POST["user"];
	$pass = $_POST["pass"];
	$pass1 = md5($pass);

	$query = "Select * from table1 where username = '$name' and password = '$pass1'";
	$z = mysql_query($query);
	$x = mysql_fetch_array($z);

	if($x)
	{
		$_SESSION["username"] = $name;
		$_SESSION["history"] = $x["history"];
		$_SESSION["cw"] = "#";
		// echo $_SESSION["username"];
		// $host  = $_SERVER['HTTP_HOST'];
		// $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = '../a.php';
		header("Location:$extra");
		echo "Welcome ",$name;
		die();
	}
	else
	{
		$extra = 'Login1.php?err=1';
		header("Location:$extra");
		die();
	}
	
?>