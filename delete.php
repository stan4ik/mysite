<?php
include("db.php");
$id = $_GET['id'];
	$del = $db->query("DELETE FROM data WHERE id=$id");
	$del->execute();
	$delua = $db->query("DELETE FROM uadata WHERE id=$id");
	$delua->execute();					
header ("location:index.php?l=".$_SESSION['l']."");						
?>
