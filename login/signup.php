<?php

session_start();
// echo $_SESSION["username"];
if(isset($_SESSION["username"]))
{
	header("Location:../a.php");
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up</title>
    <link rel="stylesheet" type="text/css" href="1.css">
    <style type="text/css">
    </style>
</head>

<body>
<div class="card card-container">
<p align="center">Sign up</p>
<?php
	$z = $_GET['err'];
	if($z == 1)
	{
		echo '<p align=center style="color:red;">Username is already taken</p>';
	}
	if($z == 2)
	{
		echo "<p align=center style='color:red;'>Passwords don't match</p>";
	}
 ?>
	<form class="form-signin" method="post" action="sign.php">
		<span id="reauth-email" class="reauth-email"></span>			
			<input type="text" name="user" id="inputname" class="form-control" placeholder="Username" pattern="[a-zA-Z0-9]+" required>
			<input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" pattern="[a-zA-Z0-9]+" required>		
			<input type="password" name="cpass" id="inputPassword" class="form-control" placeholder="Confirm Password" pattern="[a-zA-Z0-9]+" required>
			<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign up</button>			
		<p align="center">Already have an account &nbsp<a href="Login1.php">Login</a></p>
	</form>
</div>

</body>
</html>