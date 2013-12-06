<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start()?>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>add news</title>
</head>

<body>
<?php
ini_set('display_errors', 'On');
include ("db.php");
include("header.php");

if(isset($_POST['go_add'])){
if (isset($_POST['title']))		{$title = ($_POST['title']); if ($title == '') {unset($title);}}
if (isset($_POST['date']))		{$date = ($_POST['date']); if ($date == '') {unset($date);}}
if (isset($_POST['text']))		{$text = ($_POST['text']); if ($text == '') {unset($text);}}
if (isset($_POST['author']))	{$author = ($_POST['author']); if ($author == '') {unset($author);}}
if (isset($_POST['id']))		{$id = ($_POST['id']);}
if ($_POST['title']!="" && $_POST['date']!="" && $_POST['author']!="" )
														{
$query = $db->prepare("INSERT INTO data (title, `date`, `text`,author) value (:title, :date, :text, :author)");
$query->bindParam(':title',$title);
$query->bindParam(':date',$date);
$query->bindParam(':text',$text);
$query->bindParam(':author',$author);
$query->execute();
if ($query) {
   $str = $db->query("SELECT * FROM data ORDER BY id DESC LIMIT 1");
   $id = $str->fetchAll();
   header ("location:view_once.php?id={$id[0]['id']}");
			}

 else
 	{
print ("news not added");
$dar=mysql_error();
echo $dar;
	}
														}
else
	{
print ("<p>not added info</p>");
	}
							}
?>
<form name="form1" method="post" action="">
<p>
News name <br>
<input type="text" name="title" id="title">
</p>
<p>
News author <br>
<input name="author" type="text" id="author"  >
</p>
News date <br>
<input name="date"  type="text" id="date">
<br>
<p>
News description<br>
<textarea style="width:650px; height:260px;"  name="text"  cols="80" ></textarea>
</p>
<input type="submit" class="buttons" name="go_add"  id="submit" value="Add news">
<br>



</form>
</body>
</html>
