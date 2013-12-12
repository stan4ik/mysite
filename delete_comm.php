<?php
session_start();
include("db.php");
$id = $_GET['id'];
 if ($_SESSION['l'] == 'eng'){
            $t = 'comm';
        }
        else {$t = 'uacomm';}
	$del = $db->query("DELETE FROM $t WHERE id=$id");
	$del->execute();
	header("location:view_once.php?l=".$_SESSION['l']."&id=".$_SESSION['id']."");					
						
?>
