<?php session_start(); ?>
<?php
if(isset($_POST['user']) && isset($_POST['pass'])){
	
	$user = $_POST['user'];
	$pass = md5($_POST['pass']);
	require('db.php');
	$sql = "SELECT * FROM admin WHERE Username = '$user' AND Password = '$pass'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) == 1){
		$_SESSION['admin_user'] = $user;
		$_SESSION['admin_pass'] = $pass;
		header("location:admin_control.php");
		die();
	}
	else{
			mysqli_close($conn);
			mysqli_free_result($result);
			header("location: admin.php?admin_err=err");
			die();
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link href="CSS/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<center>
    <p id="heading">Admin Login</p>
	<div id="container">
	<form action="" method="POST">
    	<input id="user" placeholder="Username" autocomplete="off" type="text" name="user" /><br /><br /><br><br>
        <input id="pass" placeholder="Password" type="password" name="pass"/><br />
        <input id="button" name="submit" type="submit" value="LOG IN"/>
    </form>
    <p>
		<?php
			if(isset($_GET['admin_err']) && $_GET['admin_err']='err'){
				echo 'Sorry, wrong credentials.';
        	}
		?> 
    </p>
    </div>
    </center>
</body>
</html>
