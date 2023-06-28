<?php 
	session_start();

	unset($_SESSION['none']);
	header('Location: index.php');
?>
