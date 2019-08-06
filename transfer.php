<?php
	session_start();
	if(!isset($_SESSION['card_no'])){
		header("location: index.php");
		die();
	}
	if(isset($_POST['amount']) && isset($_POST['new_card'])){
		$card_no = $_SESSION['card_no'];
		$amount = $_POST['amount'];
		$new_card = $_POST['new_card'];
		$atm = $_SESSION['atm'];
		$new_card = str_replace('-', '', $_POST['new_card']);
		$transaction_id = uniqid();
		if($card_no == $new_card){
			$_SESSION['msg'] = "Sorry, Use Deposit from Menu to Deposit Cash to your account (You can't transfer amount to your account)";
			header("location: status.php");
			die();
		}
		require('db.php');
		mysqli_autocommit($conn,FALSE);
		$sql = "SELECT Card_no FROM cards WHERE Card_no=$new_card";   /// check for new card.
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)==0){
			$_SESSION['msg'] = "Card doesn't exist.";
		}else{
			$sql = "SELECT Balance FROM users where Card_no = $card_no";  /// Check for enough bal.
			$result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_array($result);
			if($row['Balance']<$amount){
				$_SESSION['msg'] = "Sorry, Not Enough Balance.";
				mysqli_free_result($result);
				mysqli_close($conn);
				header("location: status.php");
				die();
			}
			else{
				$sql = "UPDATE users AS u,banks AS b
				SET u.Balance = u.Balance-$amount,b.Balance = b.Balance-$amount
				WHERE u.Card_no = $card_no AND b.Bank_ID = u.Bank_ID";	// update sender's account balances.
				$result_1 = mysqli_query($conn, $sql);
				
				$sql = "UPDATE users AS u,banks AS b
				SET u.Balance = u.Balance+$amount,b.Balance = b.Balance+$amount
				WHERE u.Card_no = $new_card AND b.Bank_ID = u.Bank_ID";	// update reciever's account balances.
				$result_2 = mysqli_query($conn, $sql);
				
				if($result_1 && $result_2){
					$sql = "INSERT INTO atm_logs(Trans_ID,atm_center,Card_No,Amount,Type,Status) VALUES('$transaction_id',$atm,$card_no,$amount,'Transfer - Out','Success')";
					$result_1 = mysqli_query($conn, $sql);
					$sql = "INSERT INTO atm_logs(Trans_ID,atm_center,Card_No,Amount,Type,Status) VALUES('$transaction_id',$atm,$new_card,$amount,'Transfer - In','Success')";
					$result_2 = mysqli_query($conn, $sql);
					if($result_1 && $result_2){
						$_SESSION['msg'] = "Money Transfered Successfully.!";
					}
				}else{
					$sql = "INSERT INTO atm_logs(Trans_ID,atm_center,Card_No,Amount,Type,Status) VALUES('$transaction_id',$atm,$card_no,$amount,'Transfer - Out','Failed')";
					$result_1 = mysqli_query($conn, $sql);
					$sql = "INSERT INTO atm_logs(Trans_ID,atm_center,Card_No,Amount,Type,Status) VALUES('$transaction_id',$atm,$new_card,$amount,'Transfer - In','Failed')";
					$result_2 = mysqli_query($conn, $sql);
					if($result_1 && $result_2){
						$_SESSION['msg'] = "Sorry, Error in Transferring!";
					}
				}
			}
		}
		mysqli_commit($conn);
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
	function dash(f)
	{	
		f_val = f.value;
		if(f_val.length == 19){
			document.getElementById("submit").disabled = false;
		}
    	if(f_val){
			val = f_val.length;
			if((val==4 || val==9 || val==14) && event.keyCode!=8 && event.keyCode!=46)  // 8=backspace, 14=deldete
				f.value = f_val+"-";
		}
	}
</script>

<link href="CSS/transfer.css" rel="stylesheet" type="text/css">
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
	<input id="new_card" placeholder="Enter the card no to transfer" name="new_card" type="text" maxlength="19" onKeyUp="dash(this)"/>
    <br>
	<input id="amount" placeholder="Enter the amount to transfer" name="amount" type="number" maxlength="5"/>
    <br>
	<input id="submit" name "submit" type="submit" value="Proceed" disabled/>
	</form>
    </center>
</body>
</html>
