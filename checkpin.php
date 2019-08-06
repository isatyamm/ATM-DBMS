<?php session_start(); ?>
<?php
require('db.php');
if (isset($_POST['submit'])) {
	if (empty($_POST['card_no']) || empty($_POST['pin'])) {
		header("location: index.php");
		die();
	}
}
else{
	$card_no = $_POST['card_no'];
	$card_no = str_replace('-', '', $card_no);
	$pin = $_POST['pin'];
	$sql = "SELECT DATE(Expiry)>=CURDATE() AS exp FROM cards where Card_no = '$card_no' and pin = '$pin'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	if($row['exp']!=1 && mysqli_num_rows($result) == 1){
		?>
        <center>
        	<span style="color:red; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; margin-top:270px; display:block; font-weight:bold; font-size:30px">Card Expired.</span>
        </center>
        <?php
		mysqli_close($conn);
		mysqli_free_result($result);
		header("refresh:2;url=logout.php");
		die();
	}else{
		if (mysqli_num_rows($result) == 1) {
	    	$_SESSION["card_no"] = $card_no;
			$sql = "SELECT Username FROM users where Card_no = '$card_no'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$_SESSION['name'] = $row['Username'];
			$atm = $_SESSION['atm'];
			$sql = "SELECT bank_name FROM atm_center WHERE Center_id = $atm";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$_SESSION['bank_name'] = $row['bank_name'];
			echo 'processing...';
			mysqli_close($conn);
			mysqli_free_result($result);
			header("refresh:1;url=menu.php");
			die();
		}else {
			mysqli_close($conn);
			mysqli_free_result($result);
			header("location: user.php?err=err");
			die();
		}
	}
}
?>