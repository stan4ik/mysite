<?php session_start();
$id = $_GET['id'];
$_SESSION['id'] = $_GET['id'];

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
    <a href="view_once.php?id='.$id.'&l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="view_once.php?id='.$id.'&l=eng"><img src="img/en.png" width="14" height="10"></a>';
}
include("lang/".$_SESSION['l'].".php"); ?>
<!DOCTYPE HTML PUBLIC>
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
include("header.php");

// VOTE

if (isset($_POST['vote'])){
    $vot = $_POST['v'];
    $idnews = $_GET['id'];
    $log = $_SESSION['name'];

    $q = $db->prepare('INSERT INTO vote (newsid, vote, login) value (:id, :vote, :login)');
    $q->bindParam(':id', $idnews);
    $q->bindParam(':vote', $vot);
    $q->bindParam(':login', $log);
    $q->execute();
}
if (isset($_POST['uv'])){
    $del = $db->prepare("DELETE FROM vote WHERE login=:log and newsid = :id");
    $del->bindParam(':log', $_SESSION['name']);
    $del->bindParam(':id', $id);
    $del->execute();
}
if (isset($_POST['rv'])){
    $d = $db->prepare("DELETE FROM vote WHERE newsid = :id");
    $d->bindParam(':id', $id);
    $d->execute();
}

$r = $db->prepare("SELECT vote FROM vote WHERE newsid = :id");
$r->bindParam(':id', $id);
$r->execute();
$c = $r->rowCount();
$sum = 0;

while ($a = $r->fetchColumn()) {
    $i = $a;
    $sum = $sum+$i;
}
if ($sum !== 0){
$rat = round($sum/$c,2);
}


if ($_SESSION['l'] == 'ua'){
    $sql = 'SELECT * FROM `uadata` WHERE id='.$id.'';
}
else {
    $sql = 'SELECT * FROM `data` WHERE id='.$id.'';
}
$res = $db->prepare($sql);
$res->execute();
$myrow = $res->fetch(PDO::FETCH_ASSOC);


echo " <div class='new'>
        <h3>".$myrow["title"]."</h3>";
        if (isset($rat) and isset($rat)){
        echo "<div class='text'> Votes: ".$c."  Rating: ".$rat."</div>";
        }
        else {echo "<div class='text'>No votes</div>";}


echo   "".$myrow["text"]."<br>
        ".$myrow["author"]." / ".$myrow["date"]."<br> ";
        if (isset($_SESSION["role"]) and ($_SESSION["role"] == 'redactor' or $_SESSION["role"] == 'admin')){
        echo '<a href="redact.php?l='.$_SESSION['l'].'&id='.$myrow['id'].'" target="_blanc">'.$l['edit'].'</a>
              <a href="delete.php?l='.$_SESSION['l'].'&id='.$myrow['id'].'" target="_self">'.$l['del'].'</a>';
        }
        if (isset($_SESSION["role"]) and $_SESSION["role"] == 'admin'){
            echo'<form method="post" action="">
                 <input type=submit name="rv" value="Reset vote">
                 </form>'; 
        }
echo "</div>";


// VIEW VOTE 
if (isset($_SESSION["role"]) and ($_SESSION["role"] == 'admin' or 'user' or 'redactor')){
    include"comm.php";
}


//COMMENTS
echo "<br><br><h3 style='text-shadow: rgb(194, 194, 194) 0px 2px 3px;'>Comments:</h3>";
if (isset($_POST['comm'])){
    
    if (isset($_POST['commtext'])) {
        $commtext = ($_POST['commtext']);
        if ($commtext == '') {
            unset($commtext);
        }
}
if (isset($_POST['commtitle'])) {
        $commtitle = ($_POST['commtitle']);
        if ($commtitle == '') {
            $commtitle = substr($_POST['commtext'], 0, 15);
            $p = strrpos($commtitle, ' ');
            $commtitle = substr($_POST["commtext"], 0, $p);
        }
    }
        $date = date('Y-m-d H:i:s');
        $name = $_SESSION['name'];
        $idnew = $_GET['id'];

    if ($_POST['commtext'] != ""){
        if ($_SESSION['l'] == 'eng'){
            $t = 'comm';
        }
        else {$t = 'uacomm';}

        $q = $db->prepare('INSERT INTO '.$t.' (title, `text`, `date`, name, idnew) value (:title, :text, :date, :name, :idnew)');
        $q->bindParam(':title', $commtitle);
        $q->bindParam(':text', $commtext);
        $q->bindParam(':date', $date);
        $q->bindParam(':name', $name);
        $q->bindParam(':idnew', $idnew);
        $q->execute();
    } 

}

 // VIEW COMENT
if (isset($_GET['pg'])){
        $count = $_GET['pg'];
        $off = $count * 10;

if ($_SESSION['l'] == 'eng'){
            $t = 'comm';
        }
        else {$t = 'uacomm';}
$r = $db->prepare("SELECT * FROM $t WHERE idnew = $id ORDER BY id LIMIT $off, 10 ");
$r->execute();
$m = $r->fetch(PDO::FETCH_ASSOC);
}
else{
    if ($_SESSION['l'] == 'eng'){
            $t = 'comm';
        }
        else {$t = 'uacomm';}
$r = $db->prepare("SELECT * FROM $t WHERE idnew = $id ORDER BY id LIMIT 10");
$r->execute();
$m = $r->fetch(PDO::FETCH_ASSOC);
}
if (!empty($m)){
do {

$res = $db->prepare("SELECT id FROM users WHERE login = :log");
$res->bindParam(':log',$m['name']);
$res->execute();
$i = $res->fetchColumn();
echo '
     <table cellpadding="5" style="width: 450px">
        <tr>
         <td><a href="view_prof.php?id='.$i.'">'.$m["name"].'</a><div class="text">'.$m["date"].'</div> <br> </td>
        </tr>

        <tr>
         <td>'.$m["title"].' <br> '.$m["text"].'</td>
        </tr>
    </table>';
    if (isset($_SESSION["role"]) and $_SESSION["role"] == 'admin'){
        echo '<a href="delete_comm.php?l='.$_SESSION['l'].'&id='.$m['id'].'" target="_self">'.$l['del'].'</a>';

    }
 echo  '<hr width="400px" align="left" ></hr>';
}
while ($m = $r->fetch(PDO::FETCH_ASSOC));
}


if (isset($_SESSION['role']) and ($_SESSION['role'] == 'redactor' or 'admin' or 'user')){
     echo "<div style='margin-left: 30px;'>";
        echo  '
<form method="post" action="">
title <br>
<input type="tex" name="commtitle"/><br>
text <br>
<textarea style="width:200px; height:100px;" name="commtext" cols="80"></textarea> <br> 
<input type="submit" class="buttons" name="comm" id="submit" value="comment">  
</form>';
echo "</div>";
}

 if ($_SESSION['l'] == 'eng'){
            $t = 'comm';
        }
        else {$t = 'uacomm';}
$rr = $db->prepare("SELECT * FROM $t WHERE idnew = $id");
$rr->execute();
$count = $rr->rowCount();
if ($count > 10){
    $o = round($count/10);
for ($i=0;$i<=$o;$i++)
        {
echo "<a href='view_once.php?l=".$_SESSION['l']."&id=".$_GET['id']."&pg=$i' target='_self'>$i</a>&nbsp";
        }
        }   
?>

</body>
</html>
