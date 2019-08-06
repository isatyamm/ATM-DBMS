<?php
	session_start();
	if(!isset($_SESSION['card_no'])){
		header("location: index.php");
		die();
	}if(isset($_POST['amount'])){
		require('db.php');
		$card_no = $_SESSION['card_no'];
		$amount = $_POST['amount'];
		$atm = $_SESSION['atm'];
		$transaction_id = uniqid();
		mysqli_autocommit($conn,FALSE);
		
		$sql = "SELECT Balance FROM users where Card_no = $card_no";  /// Check for enough bal.
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);
		if($row['Balance']<$amount){
			$_SESSION['msg'] = "Sorry, Not Enough Balance.";
			mysqli_free_result($result);
			mysqli_close($conn);
			header("location: status.php");
			die();
		}else{
		$sql = "UPDATE banks AS b,users AS u,atm_center AS atm 
		 SET
		 b.Balance=b.Balance-$amount,
		 atm.balance = atm.balance-$amount,
		 u.Balance=u.Balance-$amount 
		 WHERE u.Card_no=$card_no AND 
		 b.Bank_ID=u.Bank_ID AND
		 atm.Center_id = $atm";
		$result = mysqli_query($conn, $sql);
		if($result){
			$sql = "INSERT INTO atm_logs(Trans_id,Atm_center,card_no,amount,type,status) VALUES('$transaction_id','$atm',$card_no,$amount,'Withdraw','Success')";
			$result = mysqli_query($conn, $sql);
			if($result){
				$_SESSION['msg'] = "Please Collect your Money.!";
			}
		}else{
			$sql = "INSERT INTO atm_logs(Trans_id,Atm_center,card_no,amount,type,status) VALUES('$transaction_id','$atm',$card_no,$amount,'Withdraw','Failed')";
			$result = mysqli_query($conn, $sql);
			if($result){
				$_SESSION['msg'] = "Sorry, Error in Withdrawing!";
			}
		}
		mysqli_commit($conn);
		echo $_SESSION['msg'];
		mysqli_free_result($result);
		mysqli_close($conn);
		header("location: status.php");
		die();
		}
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ATM</title>
<link href="CSS/withdraw.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
        <p>Hello, <?php echo $_SESSION['name'] ?> !</p>
    </div>
    <a id="continue" href="menu.php">Back</a>
    <a id="cancel" href="logout.php">Cancel Transaction</a>
    <center>
	<form method="POST" action="">
    <br>
	<input id="amount" placeholder="Enter Amount" name="amount" type="number" maxlength="5" min="100" max="10000"/>
    <br>
	<input id="submit" name "submit" type="submit" value="Proceed" />
	</form>
    </center>

</body>
</html>
