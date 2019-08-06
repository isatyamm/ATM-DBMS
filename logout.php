<?php
session_start();
session_unset(); // Unset all session varables.
if(session_destroy()) // Destroying All Sessions
{
	header("Location: index.php"); // Redirecting To Home Page
	die();
}
?>