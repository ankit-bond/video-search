<?php
session_start();
$q =  $_SESSION["username"];

$host = "localhost";
$database = "data1";
$user = "root";
$pass = "ankit";

$w = $_GET['val'];

$conn = mysql_connect($host,$user,$pass);
$data = mysql_select_db($database, $conn);

$t = $_GET['set'];
$_SESSION['history'] = $t;
$sql = "update table1 set history = '$t' where username = '$q'";
$z = mysql_query($sql);

header("Location: hist.php");

?>