<?php session_start(); ?>
<?php
if(isset($_POST['atm'])){
	$_SESSION['atm'] = $_POST['atm'];
	header("location:user.php");
	die();

}
?>
<html>
<head>
	<title>The Mall</title>
    <link rel="stylesheet" type="text/css" href="CSS/index.css"/>
</head>
<body>
	<div id="header">
    	<center>
    	<p>SELECT ATM CENTERS</p>
        </center>
    </div>
	<center>
	<div id="container">
    <form action="" method="post">

		<input class="radio" type="radio" name="atm" value="1">STATE BANK OF INDIA<br><br>
		<input class="radio" type="radio" name="atm" value="2">VIJAYA BANK<br><br>
		<input class="radio" type="radio" name="atm" value="3">ICICI BANK<br><br>
    	<input id="button" type="submit" value="SELECT">
    </form>
    </div>
    </center>
</body>
</html>