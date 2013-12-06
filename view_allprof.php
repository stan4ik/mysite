<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start()?>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Profile</title>
</head>

<body>

<?php
include ("header.php");
include ("aut.php");
include ("db.php");
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
        <tr class="t" >
            <td> 
            Username: <a href="view_prof.php?id='.$myrow["id"].'">'.$myrow["username"].'</a><br> 
            Date regestration: '.$myrow["date"].'<br>
            Last login: '.$myrow["ldate"].'<br>
            </td>
        </tr>
             </table>';
             if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){
    echo '<a href="redact_reg.php?id='.$myrow["id"].'">Redact profile</a>  
         <a href="delete_prof.php?id='.$myrow["id"].'">Delete profile</a>';
     }
}
while ($myrow = $result->fetch(PDO::FETCH_ASSOC));

?>	

</body>
</html>