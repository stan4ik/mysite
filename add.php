<?php session_start();

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
    <a href="add.php?l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="add.php?l=eng"><img src="img/en.png" width="14" height="10"></a>';
}

include("lang/".$_SESSION['l'].".php"); ?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
    <style type="text/css">
        <? include "style.css" ?>
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title><?=$l['addnew']?></title>
</head>

<body>
<?php
include("db.php");
include("header.php");

if (isset($_POST['go_add'])) {
    if (isset($_POST['title'])) {
        $title = ($_POST['title']);
        if ($title == '') {
            unset($title);
        }
    }
    if (isset($_POST['date'])) {
        $date = ($_POST['date']);
        if ($date == '') {
            unset($date);
        }
    }
    if (isset($_POST['text'])) {
        $text = ($_POST['text']);
        if ($text == '') {
            unset($text);
        }
    }
    if (isset($_POST['author'])) {
        $author = ($_POST['author']);
        if ($author == '') {
            unset($author);
        }
    }
    if (isset($_POST['uatitle'])) {
        $uatitle = ($_POST['uatitle']);
        if ($title == '') {
            unset($title);
        }
    }
    if (isset($_POST['uadate'])) {
        $uadate = ($_POST['uadate']);
        if ($date == '') {
            unset($date);
        }
    }
    if (isset($_POST['uatext'])) {
        $uatext = ($_POST['uatext']);
        if ($text == '') {
            unset($text);
        }
    }
    if (isset($_POST['uaauthor'])) {
        $uaauthor = ($_POST['uaauthor']);
        if ($author == '') {
            unset($author);
        }
    }
    if ($_POST['title'] != "" && $_POST['date'] != "" && $_POST['author'] != "" && $_POST['uatitle'] != "" && $_POST['uadate'] != "" && $_POST['uaauthor'] != "") {
       
        $queryua = $db->prepare('INSERT INTO uadata (title, `date`, `text`,author) value (:title, :date, :text, :author)');
        $queryua->bindParam(':title', $uatitle);
        $queryua->bindParam(':date', $uadate);
        $queryua->bindParam(':text', $uatext);
        $queryua->bindParam(':author', $uaauthor);
        $queryua->execute();

        $query = $db->prepare('INSERT INTO data (title, `date`, `text`,author) value (:title, :date, :text, :author)');
        $query->bindParam(':title', $title);
        $query->bindParam(':date', $date);
        $query->bindParam(':text', $text);
        $query->bindParam(':author', $author);
        $query->execute();
        if ($query) {
            $str = $db->query('SELECT * FROM data ORDER BY id DESC LIMIT 1');
            $id = $str->fetch(PDO::FETCH_ASSOC);
            header("location:view_once.php?l=".$_SESSION['l']."&id=".$id['id']."");
        } else {
            print ("news not added");
            $dar = mysql_error();
            echo $dar;
        }
    } else {
        print ("<p>not added info</p>");
    }
}
echo '
<form name="form1" method="post" action="">
<table cellpadding = 20>
<tr>
    <td style = "width = 50%">
    <p>
        Title <br>
        <input type="text" name="title" id="title">
    </p>

    <p>
        Author <br>
        <input name="author" type="text" id="author">
    </p>
    Date <br>
    <input name="date" type="text" id="date">
    <br>

    <p>
        Description <br>
        <textarea style="width:400px; height:260px;" name="text" cols="80"></textarea>
    </p>
    </td>

    <td>
    <p>
        Заголовок <br>
        <input type="text" name="uatitle" id="title">
    </p>

    <p>
        Автор <br>
        <input name="uaauthor" type="text" id="author">
    </p>
    Дата <br>
    <input name="uadate" type="text" id="date">
    <br>

    <p>
        Текст новини <br>
        <textarea style="width:400px; height:260px;" name="uatext" cols="80"></textarea>
    </p>
    </td>
</tr>
    </table>
    <input type="submit" class="buttons" name="go_add" id="submit" value="'.$l['but1'].'">
    <br>
    </form>'
?>


</body>
</html>
