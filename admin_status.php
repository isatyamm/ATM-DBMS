<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="CSS/status.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
        <p>Hello, <?php echo $_SESSION['admin_user'] ?> !</p>
    </div>
    <a id="continue" href="admin_control.php">Back</a>
    <a id="cancel" href="logout.php">Cancel Transaction</a>
    <center>
	<p id="status">
	<?php
		if(isset($_SESSION['admin_msg'])){
			echo $_SESSION['admin_msg'];
			?>
            <br>
			<?php
		}else{
			echo "Something Happened..!   Redirecting Now.";
			header("refresh:2;url=admin.php");
			die();
		}
	?> 
    </p>
    </center>
</body>
</html>