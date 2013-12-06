<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start()?>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>signin</title>
</head>
<body>
<?php	
include ('db.php');
include('aut.php');
include("header.php");
include('view.php');

$result = $db->prepare("SELECT * FROM data ");
$result->execute();
$count = $result->rowCount();

if ($count > 10){
for ($i=0;$i<=5;$i++)
		{
echo "<a href='index.php?pg=$i' target='_self'>$i</a>&nbsp";
		}	
}		
?>

</body>
</html>
