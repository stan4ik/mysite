<?php
session_start();
include("db.php");
$id = $_GET['id'];
	$del = $db->query("DELETE FROM users WHERE id=$id");
	$del->execute();
unset($_SESSION['name']);
unset($_SESSION['role']);
unset($_SESSION['id']);
session_destroy();					
header ("location:index.php");						
?>
