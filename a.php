<?php
session_start();
$q =  $_SESSION["username"];
$hi = $_SESSION["history"];
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
	<title>Video Search</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<style type="text/css">
	</style>
</head>

<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <p class="navbar-text" style="color:#fdfefe;"><a href="a.php">Welcome</a> <?php echo $q ?></p>
    </div>
    <ul class="nav navbar-nav navbar-right">
		<li><a href="hist.php" style="color:#fdfefe;"><span class="glyphicon"></span>History</a></li>
  		<li><a href="login/logout.php" style="color:#fdfefe;"><span class="glyphicon"></span>Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container" align="right">
	<form method="GET" action="">
		<input class="search1" type="text" name="query" placeholder="Search" required>
		<input class="button1" type="submit" value="Search">
		<input class="page" type="number" name="page" value="1">		
	</form>
</div>

<?php
$y = $_GET["page"];
if(!empty($_GET["query"]))
{
	$ch = $_GET["query"];
	$val = str_replace(" ","+",$ch);
	if($hi == 0)
	{
		$new = "Select * from table2 where username = '$q' and type = 0 and query = '$ch' and page = '$y'";
		$cc = mysql_query($new);
		$cc1 = mysql_fetch_array($cc);
		if($cc1)
		{
			$n2 = "Delete from table2 where username = '$q' and type = 0 and query = '$ch' and page = '$y'";
			$c2 = mysql_query($n2);
		}
		$sql = "Insert into table2 (username,type,query,page) values ('$q',0,'$ch','$y')";
		$c = mysql_query($sql);
	}
	$result = exec("python3 index.py $val");
	// var_dump($result);
	// echo gettype($result);
	$pieces = explode("#####", $result);
	$j = count($pieces);
	$x = 10*$y;
	$k = min($x,$j);
	// for($i = 0; $i < $k; $i++)
	// {
	// 	$data = json_decode($pieces[$i],true);
	// 	echo "<pre>";
	// 	print_r($data);
	// 	echo "</pre>";
	// }
	if(!empty($_GET["query"]))
	{
		if($pieces[0] == '')
		{
			echo "<h3 style='color:#fdfefe' align=center>No Results</h3>";
			echo "<h3 style='color:#fdfefe' align=center>Did you mean: ";
			$ppp = explode(" ",$ch);
			$lp = count($ppp);
			for($i = 0; $i < $lp; $i++)
			{
				$tmp = exec("python spell.py $ppp[$i]");
				$ap[$i] = $tmp;
			}
			$fp = implode("+",$ap);
			$fp1 = implode(" ",$ap);
			echo "<a style='color:yellow;' href=a.php?query=",$fp,"&page=1>",$fp1,"</a></h3>";
		}
		else
		{
		echo "<h3 style='color:#fdfefe' align=center>Total ",$j," Results</h3>";

?>
			<div class="wrapper">
			<table id="acrylic" class="table" style="border: solid;">
			<thead>
			<tr>
				<th colspan="5">Search Results for &nbsp'<?php echo $ch ?>' :</th>
			</tr>
			</thead>
			<thead>
			<tr>
				<th>Thumbnail</th>
				<th>Title</th>
				<th>Channel Title</th>
				<th>Views</th>
				<th>Likes</th>
			</tr>
			</thead>
<?php
			for($i = $x-10; $i < $k; $i++)
			{
				$data = json_decode($pieces[$i],true);
				$var = $data['videoInfo']['id'];
?>
				<tr>
					<td><img src="<?php echo $data['videoInfo']['snippet']['thumbnails']['high']['url']?>" style="width:200px;height:100px;"></td>
					<td><a href="111.php?val=<?php echo $i+1 ?>&varname= <?php echo $var ?>" ><?php echo $data['videoInfo']['snippet']['title']?></a></td>
					<td><?php echo $data['videoInfo']['snippet']['channelTitle']?></td>
					<td><?php echo $data['videoInfo']['statistics']['viewCount'];?></td>
					<td><?php echo $data['videoInfo']['statistics']['likeCount'];?></td>
				</tr>
<?php 		} 
?>
		</table>
		</div>
<?php
				if($j > 10)
				{
					echo "<div align=center><b style='color:#fdfefe'>Page</b>";
					for($z = 0;$z < $j/10; $z++)
					{
?>
					<div class="pagination">
<?php
						if($_GET["page"] <> $z+1)
						{
							echo '<a href=?query=',$val,'&page=',$z+1,'> ',$z+1,'</a>';
						}
						else
						{
							echo '<a style="color:#fdfefe"> ',$z+1,'</a>';
						}
?>
					</div>				
<?php
					}
					echo "</div>";					
				}
		}
	}
}
?>

	<form method="get" action="111.php">
	    <input type="hidden" name="varname" value="var">
	</form>

</body>
</html>