<?php
	session_start();
	require('db.php');
	if(!isset($_SESSION['card_no'])){
		header("location: index.php");
		die();
	}
?>
<!doctype html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>ATM</title>
    <link href="CSS/chkbal.css" rel="stylesheet" type="text/css">
	</head>
	<body>
    	<div id="header">
        	<p><?php echo $_SESSION['name'] ?></p>
            
        </div>
        <a id="continue" href="menu.php">Continue Transaction</a>
        <a id="cancel" href="logout.php">Cancel Transaction</a>
		<?php
		$card_no = $_SESSION['card_no'];
		$sql = "Select Balance from users where Card_no = $card_no";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result);
	    	?>
            <center>
            <img id="image" src="Images/withdraw.png"/>
        	<p id="bal">
        	Your Current Balance is :  
            <span id="amount">
            	Rs
        		<?php
					echo $row['Balance'];
				?>
       		/-
            </span>
        	</p>
            </center>
      </body>
      </html>
      <?php
		} else {
			header("location: logout.php");
			die();
		}
		mysqli_free_result($result);
		mysqli_close($conn);
?>