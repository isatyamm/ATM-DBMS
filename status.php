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
        <p>Hello, <?php echo $_SESSION['name'] ?> !</p>
        
    </div>
    <a id="continue" href="menu.php">Back</a>
    <a id="cancel" href="logout.php">Cancel Transaction</a>
    <center>
	<p id="status">
	<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			?>
            <br>
			<?php
		}else{
			echo "Something Happened..!   Redirecting Now.";
			header("refresh:2;url=index.php");
			die();
		}
	?> 
    </p>
    </center>
</body>
</html>