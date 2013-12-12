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
    <a href="view_allprof.php?l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="view_allprof.php?l=eng"><img src="img/en.png" width="14" height="10"></a>';
}
include("lang/".$_SESSION['l'].".php"); ?>
<style type="text/css">
	<? include "style.css" ?>
</style>

<title><?=$l['allprof']?></title>


<?php
include ("db.php");
include ("aut.php");
include ("header.php");
$result = $db->prepare("SELECT * FROM users");
$result->execute();
$myrow = $result->fetch(PDO::FETCH_ASSOC);

do{
	echo '
        <table cellpadding="5">
        <tr>
            <td>
            <img class="img" alt=" " src='.$myrow["avatar"].'>
            </td>    
		</tr>
        <tr>
            <td> 
            '.$l['uname'].': <a href="view_prof.php?id='.$myrow["id"].'&l='.$_SESSION['l'].'">'.$myrow["username"].'</a><br> 
            '.$l['dreg'].': '.$myrow["date"].'<br>
            '.$l['dlog'].': '.$myrow["ldate"].'<br>
            </td>
        </tr>
             </table>';
             if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){
    echo '<a href="redact_reg.php?l='.$_SESSION['l'].'&id='.$myrow["id"].'">'.$l['chp'].'</a>  
          <a href="delete_prof.php?l='.$_SESSION['l'].'&id='.$myrow["id"].'">'.$l['delp'].'</a>';
     }
}
while ($myrow = $result->fetch(PDO::FETCH_ASSOC));

?>	

</body>
</html>