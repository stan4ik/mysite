<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start()?>
<html>
<head>
<style type="text/css">
    <? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>viev news</title>
</head>

<body>
<?php
include("db.php");
include("aut.php");
include("header.php");
$id = $_GET['id'];
include "db.php";
$res = $db->prepare("SELECT * FROM `data` WHERE id=$id");
$res->execute();
$myrow = $res->fetchAll();
echo "  <table cellpadding='5'>
         <tr>
         <td><h4>".$myrow[0]["title"]."</h4><br>".$myrow[0]["text"]."</td>
         </tr>

         <tr>
         <td class='text'>".$myrow[0]["author"]." / ".$myrow[0]["date"]."</td>
    
             <br>
        </table>  ";
        if (isset($_SESSION["role"]) and ($_SESSION["role"] == 'redactor' or $_SESSION["role"] == 'admin')){
printf ('<a href="redact.php?id=%s" target="_blanc">change</a>
         <a href="delete.php?id=%s" target="_self">delete</a>
         <br><br><br>',$myrow[0]['id'],$myrow[0]['id']); 
        }     
?>


</body>
</html>
