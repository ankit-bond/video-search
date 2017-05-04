<?php
session_start();
$q =  $_SESSION["username"];
$hi = $_SESSION["history"];
$wer = $_SESSION["cw"];
$we = "#";
$pq = $_GET['varname'];
if($wer <> $we)
{
	$wqw = exec("python3 change3.py $wer $pq");
}
$_SESSION["cw"] = $pq;
$host = "localhost";
$database = "data1";
$user = "root";
$pass = "ankit";

$w = $_GET['val'];

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
	<title>Information</title>
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
    	<li><a href="hist.php" style="color:#fdfefe;"><span class="glyphicon"></span>History</a></li>
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

<?php
$val = $_GET['varname']; //$val takes video unique id
if($val <> '')
{
	$result1 = exec("python3 data.py $val");
	$result2 = exec("python3 change1.py $val");
	$result3 = exec("python3 change2.py $val");
	// var_dump($result1);
	// echo gettype($result);
	$pie = explode("#####", $result1);
	$data1 = json_decode($pie[0],true);

	$kk = $data1['videoInfo']['snippet']['title'];
	$dd = $data1['videoInfo']['id'];
	if($hi == 0)
	{
		$new1 = "Select * from table2 where username = '$q' and type = 1 and qlink='$dd'";
		$cc = mysql_query($new1);
		$cc1 = mysql_fetch_array($cc);
		if($cc1)
		{
			$n2 = "Delete from table2 where username = '$q' and type = 1 and qlink='$dd'";
			$c2 = mysql_query($n2);
		}
		$sql = "Insert into table2 (username,type,query,page,qlink) values ('$q',1,'$kk','$w','$dd')";
		$c = mysql_query($sql);
	}

	echo '<div class=wrapper>';
	echo '<table id="acrylic" class="table" style="border: solid;">';//margin-left: 10px;margin-right: 10px;max-width: 1500px;
	echo "<thead><tr>
				<th colspan=2>Video Information:</th>
			</tr></thead>";
	echo '<thead><tr>
				<th>Thumbnail</th>
				<th>Information</th>
			</tr></thead>';
	//echo '<td rowspan=11><img src="',$data1['videoInfo']['snippet']['thumbnails']['high']['url'],'" style="width:300px;height:200px;"></td>';
	echo '<td rowspan=10>
		<iframe width="900" height="500" src="https://www.youtube.com/embed/',$data1['videoInfo']['id'],'" frameborder="0" allowfullscreen></iframe></td>';
	echo "<tr><td>Title: ",$data1['videoInfo']['snippet']['title'],"</td></tr>";
	echo "<tr><td>Unique video Id: ",$data1['videoInfo']['id'],"</td></tr>";
	foreach ($data1['videoInfo']['statistics'] as $w => $e) {
		//echo "<tr><td>",$e," ",$w,"</td></tr>" ;
		if($w == "likeCount")
			$lc = $e;
		if($w == "viewCount")
			$vc = $e;
		if($w == "dislikeCount")
			$dc = $e;
		if($w == "favoriteCount")
			$fc = $e;
		if($w == "commentCount")
			$cc = $e;
	}
	
	echo "<tr><td>Channel Title: ",$data1['videoInfo']['snippet']['channelTitle'],"</td></tr>";
	echo "<tr><td>Channel Id: ",$data1['videoInfo']['snippet']['channelId'],"</td></tr>";
	echo "<tr>
	<td>Views: ",$vc,"</td></tr>
	<tr><td>Likes: ",$lc,"</td></tr>
	<tr><td>Favourites: ",$fc,"</td></tr>
	<tr><td>Dislikes: ",$dc,"</td></tr>
	<tr><td>Comments: ",$cc,"</td></tr>	";
	$len = count($data1['videoInfo']['snippet']['tags']);
	echo "<tr><td colspan=2>Tags: &nbsp";
	for($i = 0; $i < $len; $i++)
	{
		$ch = str_replace(" ","+",$data1['videoInfo']['snippet']['tags'][$i]);
		echo '<a href=a.php?query=',$ch,'&page=1>',$data1['videoInfo']['snippet']['tags'][$i],'</a> &nbsp&nbsp ';
	}
	echo "</td></tr>";
	?>

		<tr><td colspan="2">
			<div class=container>Description:<br><?php echo $data1['videoInfo']['snippet']['localized']['description'] ?></div>
		</td></tr>
		<?php
	// echo "<pre>";
	// print_r($data1);
	// echo "</pre>";
	echo '</table></div>';
}
if($val <> '')
{
	$result = exec("python3 neo4j.py $val");
	$pieces = explode("#####", $result);
	// $data = json_decode($pieces[$j + 1],true);
	$j = count($pieces);
	$k = min(10,$j);
	if(!($pieces[0] == ''))
	{
		echo '<div class=wrapper>';
		echo '<table id="acrylic" class="table" style="border: solid;">';
		echo "<thead><tr>
				<th colspan=5>Related Videos:</th>
			</tr></thead>";
		echo '<thead><tr>
				<th>Thumbnail</th>
				<th>Title</th>
				<th>Channel Title</th>
				<th>Views</th>
				<th>Likes</th>
			</tr></thead>';
		for($i = 0; $i < $k; $i++)
		{
			$data = json_decode($pieces[$i],true);
			$var = $data['p']['id'];
			echo '<tr>';
				echo '<td><img src="',$data['p']['thumbnail'],'" style="width:200px;height:100px;"></td>';
				echo '<td><a href=111.php?val=',$i+1,'&varname=',$var,'>',$data['p']['title'],'</a></td>';
				echo '<td>',$data['p']['channelTitle'],'</td>';
				echo '<td>',$data['p']['viewCount'],'</td>';
				echo '<td>',$data['p']['likeCount'],'</td>';
			echo '</tr>';
		}
		echo '</table></div>';
	}	
}
?>

	<form method="get" action="111.php">
	    <input type="hidden" name="varname" value="var">
	</form>

</body>
</html>