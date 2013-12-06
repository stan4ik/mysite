<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title></title>
</head>
<body>
<?php
include("db.php");
$id = $_GET['id'];
	$del = $db->query("DELETE FROM data WHERE id=$id");
	$del->execute();					
header ("location:index.php");						
?>
</body>
</html>