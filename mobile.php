<?php
	session_start();
	if(!isset($_SESSION['card_no'])){
		header("location: index.php");
		die();
	}if(isset($_POST['mobile'])){
		require('db.php');
		$card_no = $_SESSION['card_no'];
		$mobile = $_POST['mobile'];
		$sql = "UPDATE users SET mobile = $mobile WHERE Card_no=$card_no";
		$result = mysqli_query($conn, $sql);
		if($result){
			$_SESSION['msg'] = "Mobile Registered Successfully.!";
		}else{
			$_SESSION['msg'] = "Sorry, Cannot update your Mobile Number!";
		}
		mysqli_free_result($result);
		mysqli_close($conn);
		header("location: status.php");
		die();
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ATM</title>
<script type="text/javascript">
	function check(mob)
	{
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").style.backgroundColor = "#878787"
		mobile = mob.value;
		if(mobile.length == 10){
			document.getElementById("submit").value = "Register"
			document.getElementById("submit").disabled = false;
			document.getElementById("submit").style.backgroundColor = "#009688"
		}else if(mobile.length > 10){
			document.getElementById("submit").value = "Enter valid no."
			document.getElementById("submit").style.backgroundColor = "red"
		}
	}
</script>
<link href="CSS/mobile.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
        <p>Hello, <?php echo $_SESSION['name'] ?> !</p>
        
    </div>
    <a id="continue" href="menu.php">Back</a>
    <a id="cancel" href="logout.php">Cancel Transaction</a>
    <center>
	<form method="POST" action="">
	<input id="mobile" name="mobile" placeholder="Enter Mobile Number" autocomplete="off" type="number" onKeyUp="check(this)"/>
    <br><br>
	<input id="submit" name "submit" type="submit" value="Register" disabled/>
	</form>
    </center>
</body>
</html>
