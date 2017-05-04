<?php
session_start();
$q =  $_SESSION["username"];

$host = "localhost";
$database = "data1";
$user = "root";
$pass = "ankit";

$conn = mysql_connect($host,$user,$pass);
$data = mysql_select_db($database, $conn);

if(is_null($q))
{
	header("Location: login/Login1.php");
}

$sql = "delete from table2 where username = '$q'";
$z = mysql_query($sql);

header("Location: hist.php");

?>