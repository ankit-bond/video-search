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
	$cpass = $_POST["cpass"];

	$query = "Select * from table1 where username = '$name'";
	$z = mysql_query($query);
	$x = mysql_fetch_array($z);

	if($x)
	{
		// echo "Username already taken.";
		$extra = 'signup.php?err=1';
		header("Location:$extra");
	}
	else
	{
		if($pass <> $cpass)
		{
			// echo "Passwords don't match.";
			$extra = 'signup.php?err=2';
			header("Location:$extra");
		}	
		else
		{
			$pass1 = md5($pass);
			$sql = "Insert into table1 (username,password) values ('$name','$pass1')";
			$c = mysql_query($sql);
			$_SESSION["username"] = $name;
			$_SESSION["history"] = 0;
			$_SESSION["cw"] = "#";

			if($c)
			{
				// echo "Registered with username ", $name;
				// $host  = $_SERVER['HTTP_HOST'];
				// $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$extra = '../a.php';
				header("Location:$extra");
				die();
			}
		}
	}

	
?>