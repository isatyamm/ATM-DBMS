<?php
require('db.php');
session_start();// Starting Session

// Storing Session
$user_check=$_SESSION['card_no'];

// SQL Query To Fetch Complete Information Of User
$ses_sql=mysql_query("select Card_no from cards where Card_no=$user_check", $conn);
$row = mysql_fetch_assoc($ses_sql);
$login_session =$row['Card_no'];
if(!isset($login_session)){
	mysql_close($conn); // Closing Connection
	header('Location: index.php'); // Redirecting To Home Page
	die();
}
?>