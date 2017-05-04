<?php
session_start();
$q =  $_SESSION["username"];
$_SESSION["cw"] = "#";

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

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>History</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
	<style type="text/css">
	.dropdown {
		position: relative;
   		display: inline-block;
		}		
	</style>
</head>

<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <p class="navbar-text" style="color:#fdfefe;"><a href="a.php">Welcome</a> <?php echo $q ?></p>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login/logout.php" style="color:#fdfefe;"><span class="glyphicon"></span>Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container" align="right">
	<form method="GET" action="a.php">
		<input class="search1" type="text" name="query" placeholder="Search" required>
		<input class="button1" type="submit" value="Search">
		<input class="page" type="number" name="page" value="1">		
	</form>
</div>
<div align="center">
<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">History Status
    <span class="caret"></span></button>
    <ul class="dropdown-menu" align="center">
      <li><a href="set.php?set=0">Resume History</a></li>
      <li><a href="set.php?set=1">Pause History</a></li>
    </ul>
</div>
</div>

<?php
	$sql = "Select * from table2 where username = '$q' ORDER BY dt DESC ";
	$z = mysql_query($sql);
	if(mysql_num_rows($z) <> 0)
	{
?>

<div class="wrapper">
			<table id="acrylic" class="table" style="border: solid;">
			<thead>
			<tr>
				<th>History:</th>
				<th><form action="del.php"><button style="color: orange;">Clear History</button></form></th>
			</tr>
			</thead>
			<thead>
			<tr>
				<th>Timestamp</th>
				<th>Action</th>
			</tr>
			</thead>
<?php
				while($row = mysql_fetch_assoc($z))
				{					
?>
				<tr>
				<th>
<?php
				echo $row['dt'];
				if($row['type'] == 0)
				{					
					echo "</th><th><a href=a.php?query=",str_replace(" ","+",$row['query']),"&page=",$row['page'],">You searched for '",$row['query'],"'. You were on Page ",$row['page'],".</a>";
				}
				if($row['type'] == 1)
				{					
					echo "</th><th><a href=111.php?val=1&varname=",$row['qlink'],">You viewed information regarding this video: ' ",$row['query']," '.</a>";
				}
?>
				</th>
				</tr>
<?php
				}
?>
			</table>
			</div>

<?php
	}
	else
	{
		echo "<h3 style='color:#fdfefe' align=center>No History. You haven't executed any action yet.</h3>";
	}
?>

</body>
</html>