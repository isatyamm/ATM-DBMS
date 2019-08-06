<?php session_start(); ?>
<?php
if(!isset($_SESSION['card_no'])){
	header("location: index.php");
	die();
}
else{
	?>
    <!doctype html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>ATM</title>
	    <link href="CSS/menu.css" rel="stylesheet" type="text/css">
	</head>
	<body>
    	<div id="header">
        	<p>Hello, <?php echo $_SESSION['name'];?> !</p>
            
            <p id="bank_name"><?php echo $_SESSION['bank_name']." ATM"; ?></p>
            
        </div>
    	<div id="menu">
        	<div id="left">
        		<ul>
            		<li><a href="chkbal.php">Check Balance</a></li>
        			<li><a href="ministatement.php">Mini Statement</a></li>
        			<li><a href="mobile.php">Mobile Registration</a></li>
        			<li><a href="changepin.php">Change PIN</a></li>
            	</ul>
        	</div>
    		<div id="right">
        		<ul>
            	    <li><a href="withdraw.php">Withdraw</a></li>
        			<li><a href="deposit.php">Deposit</a></li>
        			<li><a href="transfer.php">Transfer</a></li>
        			<li><a href="logout.php">Cancel Transaction</a></li>
            	</ul>
        	</div>
        </div>
        
	</body>
	</html>
    <?php
	// Time-out for session expiry
	header("refresh:60;url=logout.php");
	die();
}
?>