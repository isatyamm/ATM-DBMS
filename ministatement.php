<?php
	session_start();
	if(!isset($_SESSION['card_no'])){
		header("location: logout.php");
		die();
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ATM</title>
<link href="CSS/ministatement.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="header">
        <p>Hello, <?php echo $_SESSION['name'] ?> !</p>
    </div>
    <a id="continue" href="menu.php">Back</a>
    <a id="cancel" href="logout.php">Cancel Transaction</a>
    <center>
	<h3>Showing the last 5 Successful Transactions.</h3>
	<table>
    	<th>Transaction ID</th>
    	<th>Time</th>
        <th>Amount</th>
        <th>Type</th>
     <!-- <th>Balance</th> -->
        <?php
			require('db.php');
			$card_no = $_SESSION['card_no'];
			$sql = "SELECT * FROM
			(SELECT * FROM atm_logs WHERE card_no=$card_no AND status='Success' ORDER BY Timestamp DESC LIMIT 5) AS v ORDER BY Timestamp ASC";
			$result = mysqli_query($conn, $sql);
			if($result){
				while($row = mysqli_fetch_array($result)){
					echo "<tr>";
						echo '<td>'.$row['Trans_id'].'</td>';
						echo '<td>'.$row['Timestamp'].'</td>';
						echo '<td>'.$row['amount'].'</td>';
						echo '<td>'.$row['type'].'</td>';
	//					echo '<td>'.$row['balance'].'</td>';
					echo "</tr>";
				}
			}
			mysqli_close($conn);
		?>
    </table>
    </center>
</body>
</html>