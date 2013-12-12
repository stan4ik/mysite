<?php session_start();
$id = $_GET['id'];

if (empty($_GET['l'])){
    $_SESSION['l'] = 'eng';
}
else{
switch ($_GET['l']) {
    case 'ua': $_SESSION['l'] = $_GET['l'];
        break;
    case 'eng': $_SESSION['l'] = $_GET['l'];
        break;
}
}
if ($_SESSION['l'] == 'eng'){
echo '
    <a href="redact.php?id='.$id.'&l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="radact.php?id='.$id.'&l=eng"><img src="img/en.png" width="14" height="10"></a>';
}
include("lang/".$_SESSION['l'].".php"); ?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?=$l['enew']?></title>
</head>

<body>

<?php

include ("db.php");
include("header.php");
if ($_SESSION['l'] == 'ua'){
    $sql = 'SELECT * FROM `uadata` WHERE id='.$id.'';
}
else {
    $sql = 'SELECT * FROM `data` WHERE id='.$id.'';
}

$quer = $db->query($sql);
$data = $quer->fetch(PDO::FETCH_ASSOC);

echo '
<form name="form1" method="post" action="">
<p>
'.$l['title'].' <br>
<input type="text" name="title" id="title" value="'.$data['title'].'">
</p>
<p>
'.$l['author'].' <br>
<input name="author" type="text" id="author" value="'.$data['author'].'" >
</p>
'.$l['date'].' <br>
<input name="date"  type="text" id="date" value="'.$data['date'].'">
<br>
<p>
'.$l['desc'].' <br>
<textarea style="width:650px; height:260px;"  name="text"  cols="80">'.$data['text'].'</textarea>
</p>
<input type="submit" class="buttons" name="change"  id="submit" value="'.$l['but2'].'">
<br>';

if(isset($_POST['change'])){
if (isset($_POST['title']))		{$title = mysql_real_escape_string($_POST['title']); if ($title == '') {unset($title);}}
if (isset($_POST['date']))		{$date = mysql_real_escape_string($_POST['date']); if ($date == '') {unset($date);}}
if (isset($_POST['text']))		{$text = mysql_real_escape_string($_POST['text']); if ($text == '') {unset($text);}}
if (isset($_POST['author']))	{$author = mysql_real_escape_string($_POST['author']); if ($author == '') {unset($author);}}
if ($_POST['title']!="" && $_POST['date']!="" && $_POST['author']!="" ){
    if ($_SESSION['l'] == 'eng'){
        $sql = "UPDATE data  SET title = :title, `date` = :date, `text` = :text, author = :author WHERE id=$id";
    }
    if ($_SESSION['l'] == 'ua'){
        $sql = "UPDATE uadata  SET title = :title, `date` = :date, `text` = :text, author = :author WHERE id=$id";
    }
$query = $db->prepare($sql);
$query->bindParam(':title', $title);
$query->bindParam(':date', $date);
$query->bindParam(':text', $text);
$query->bindParam(':author', $author);
$query->execute();
if ($query) {
	header ("location:view_once.php?l=".$_SESSION['l']."&id=".$id."");
}

 else{
print ("news not changed");
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
