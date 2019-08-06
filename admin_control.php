<?php session_start(); ?>
<?php
if(isset($_SESSION['admin_user']) && isset($_SESSION['admin_pass'])){
	require('db.php');
	
	if(isset($_POST['atm_amt']) && isset($_POST['atms'])){
		$center = $_POST['atms'];
		$amount = $_POST['atm_amt'];
		$sql = "UPDATE atm_center AS atm SET Balance=Balance+$amount WHERE Center_id = $center";
		$result = mysqli_query($conn,$sql);
		if($result){
			$_SESSION['admin_msg'] = "Rs ".$amount." /- deposited Succesfully.!";
			header("location:admin_status.php");
			die();
		}else{
			$_SESSION['admin_msg'] = "Cash not deposited in selected ATM";
			header("location:admin_status.php");
			die();
		}
	}
		
}else{
	header("location:index.php");
	die();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin</title>
<link href="CSS/admin_control.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
    	
    </div>
    <a id="cancel" href="logout.php">Logout</a>
    <center>
	<div id="container">
    <form action="" method="post">
    <br>
	<select name="atms" id="atms">
    	<option selected>Select ATM Branch</option>
		<option value="1">SBI</option>
		<option value="2">VIJAYA BANK</option>
		<option value="3">ICICI</option>
	</select><br>
    <input id="amount" placeholder="Amount" type="number" min="10000" max="100000" name="atm_amt" /><br>
	<input id="button" type="submit" name="change" value="Refill" />
	</form>
    </div>
    </center>
</body>

</html>