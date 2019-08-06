<?php session_start();
	if(isset($_SESSION['card_no'])){
		header("location: menu.php");
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
		document.getElementById("button").disabled = true;
		document.getElementById("div_pin").style.visibility = "visible";
		f_val = f.value;
		if(f_val.length==19){
			document.getElementById("div_pin").style.opacity = '1';
			document.getElementById("button").disabled = false;
		}else{
			document.getElementById("div_pin").style.opacity = '0';
		}
    	if(f_val){
			val = f_val.length;
			if((val==4 || val==9 || val==14) && event.keyCode!=8 && event.keyCode!=46)  // 8=backspace, 14=deldete
				f.value = f_val+"-";
		}
	}
</script>

<link href="CSS/user.css" rel="stylesheet" type="text/css">
</head>

<body>
	<center>
    <div id="container">
	<form method="POST" action="checkpin.php">
	<input id="card_no" name="card_no" placeholder="Enter Card Number" autocomplete="off" maxlength="19" onKeyUp="dash(this)"/>
    <div id="div_pin">
        <input id="pin" name="pin" placeholder="Enter PIN" type="password" maxlength="4"/>
    	<br>
		<input id="button" type="submit" value="NEXT" disabled/>
    </div>
    <p>
		<?php
			if(isset($_GET['err']) && $_GET['err']='err'){
				echo 'Sorry, you have entered a wrong PIN.';
        	}
		?> 
    </p>
	</form>
    </div>
    </center>
</body>

</html>
