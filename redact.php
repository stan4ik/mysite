<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	session_start()
?>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>change new</title>
</head>

<body>

<?php

include ("db.php");
include("aut.php");
include("header.php");

$id = $_GET['id'];
$quer = $db->query("SELECT * FROM data WHERE id=$id");
$data = $quer->fetchAll();

printf ('
<form name="form1" method="post" action="">
<p>
News name <br>
<input type="text" name="title" id="title" value="%s">
</p>
<p>
News author <br>
<input name="author" type="text" id="author" value="%s" >
</p>
News date <br>
<input name="date"  type="text" id="date" value="%s">
<br>
<p>
News description<br>
<textarea style="width:650px; height:260px;"  name="text"  cols="80">%s</textarea>
</p>
<input type="submit" class="buttons" name="change"  id="submit" value="change data">
<br>',$data[0]['title'],$data[0]['author'],$data[0]['date'],$data[0]['text']);

if(isset($_POST['change'])){
if (isset($_POST['title']))		{$title = mysql_real_escape_string($_POST['title']); if ($title == '') {unset($title);}}
if (isset($_POST['date']))		{$date = mysql_real_escape_string($_POST['date']); if ($date == '') {unset($date);}}
if (isset($_POST['text']))		{$text = mysql_real_escape_string($_POST['text']); if ($text == '') {unset($text);}}
if (isset($_POST['author']))	{$author = mysql_real_escape_string($_POST['author']); if ($author == '') {unset($author);}}
if ($_POST['title']!="" && $_POST['date']!="" && $_POST['author']!="" ){
$query = $db->prepare("UPDATE data  SET title = '$title', 
										`date` = '$date', 
										`text` = '$text', 
										author = '$author' WHERE id=$id");
$query->execute();
if ($query) {
	header ("location:view_once.php?id=$id");
}

 else{
print ("news not changed");
$dar=mysql_error();
echo $dar;
}
}
else{
print ("<p>not added info</p>");
}
}

?>


</form>
</body>
</html>
