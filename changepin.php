<?php
	session_start();
	if(!isset($_SESSION['card_no'])){
		header("location: index.php");
		die();
	}
	if(isset($_POST['old']) && isset($_POST['new'])){
		require('db.php');
		$card_no = $_SESSION['card_no'];
		$old = ($_POST['old']);
		$new = ($_POST['new']);
		$sql = "SELECT pin FROM cards where card_no = '$card_no' and pin = '$old'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result);
			if($row['pin'] == $old){
				$sql = "UPDATE cards set pin='$new' where card_no = '$card_no' and pin = '$old'";
				$result = mysqli_query($conn, $sql);
				if($result){
					$_SESSION['msg'] = "PIN changed Successfully.!";
				}else{
					$_SESSION['msg'] = $new;
					$_SESSION['msg'] = "PIN Change FAILED..!";
				}
				mysqli_close($conn);
				header("location: status.php");
				die();
			}
			
		}else {
			mysqli_close($conn);
			header("location: logout.php");
			die();
		}
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ATM</title>
<script type="text/javascript">
	function check()
	{
		document.getElementById("status").style.color = "red";
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").style.backgroundColor = "#878787"
		old = document.getElementById("old").value;
		val1 = document.getElementById("new1").value;
		val2 = document.getElementById("new2").value;
		if(!old && !val1 && !val2){
			document.getElementById("status").innerHTML = "";
		}
		else if((val1 == old) || (val2 == old)){
			document.getElementById("status").innerHTML = "Same as OLD PIN";
		}
		else if(val1 != val2){
			document.getElementById("status").innerHTML = "Pins doesn't match.";
		}
		else if(!val1 || !val2){
			document.getElementById("status").innerHTML = "New PIN is Empty";
		}
		else{
			document.getElementById("status").innerHTML = "Good to go.";
			document.getElementById("status").style.color = "green";
			document.getElementById("submit").disabled = false;
			document.getElementById("submit").style.backgroundColor = "#009688"
		}
	}
</script>
<link href="CSS/changepin.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
        <p>Hello, <?php echo $_SESSION['name'] ?> !</p>
        
    </div>
    <a id="continue" href="menu.php">Back</a>
    <a id="cancel" href="logout.php">Cancel Transaction</a>
    <center>
	<form method="POST" action=""><br>
	<input id="old" name="old" placeholder="Enter OLD PIN" type="password" maxlength="4" onKeyUp="check()"/>
    <br>
	<input id="new1" name="new" placeholder="Enter NEW PIN" type="password" maxlength="4" onKeyUp="check()"/>
	<input id="new2" name="new" placeholder="Re-Enter NEW PIN" type="password" maxlength="4" onKeyUp="check()"/>
    <br>
    <p id="status"></p>
    <br>
	<input id="submit" name "submit" type="submit" value="CHANGE PIN" disabled />
	</form>
    </center>
</body>

</html>
