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
    <a href="view_prof.php?id='.$id.'&l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="view_prof.php?id='.$id.'&l=eng"><img src="img/en.png" width="14" height="10"></a>';
}
include("lang/".$_SESSION['l'].".php"); ?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?=$l['prof']?></title>
</head>

<body>

<?php
include ("header.php");
include ("db.php");
$result = $db->prepare("SELECT * FROM users where id='$id'");
$result->execute();
$myrow = $result->fetch(PDO::FETCH_ASSOC);

	echo '<img class="img" alt=" " src='.$myrow["avatar"].'>



		<table cellpadding="5">
        <tr class="t" >
            <td> 
            '.$l['name'].': '.$myrow["name"].'<br> 
            '.$l['lname'].': '.$myrow["lastname"].' <br>
            '.$l['dreg'].': '.$myrow["date"].'<br>
            '.$l['dlog'].': '.$myrow["ldate"].'<br>
            </td>
        </tr>';
        if (isset($_SESSION['role']) and ($_SESSION['role'] == 'redactor' or 'admin' or 'user')){
        echo  '<tr>
                    <td>
                    '.$l['mail'].': '.$myrow["mail"].'
                    </td>
               	</tr>';
        }
echo   '</table>';
             if (isset($_SESSION['role']) and ($_SESSION['role'] == 'admin' or $myrow['id'] == $_SESSION['id'])){
    echo '<a href="redact_reg.php?l='.$_SESSION['l'].'&id='.$myrow["id"].'">'.$l['chp'].'</a>  
         <a href="delete_prof.php?l='.$_SESSION['l'].'&id='.$myrow["id"].'">'.$l['delp'].'</a>';
     }
?>	

</body>
</html>