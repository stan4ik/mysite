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
include ("db.php");
$id = $_GET['id'];
$result = $db->prepare("SELECT * FROM users where id='$id'");
$result->execute();
$myrow = $result->fetch(PDO::FETCH_ASSOC);

	echo '<img class="img" alt=" " src='.$myrow["avatar"].'>



		<table cellpadding="5">
        <tr class="t" >
            <td> 
            Name: '.$myrow["name"].'<br> 
            Lastname: '.$myrow["lastname"].' <br>
            Date regestration: '.$myrow["date"].'<br>
            Last login: '.$myrow["ldate"].'<br>
            </td>
        </tr>';
        if (isset($_SESSION['role']) and ($_SESSION['role'] == 'redactor' or 'admin' or 'user')){
        echo  '<tr>
                    <td>
                    Your e-mail: '.$myrow["mail"].'
                    </td>
               	</tr>';
        }
echo   '</table>';
             if (isset($_SESSION['role']) and ($_SESSION['role'] == 'admin' or $myrow['id'] == $_SESSION['id'])){
    echo '<a href="redact_reg.php?id='.$myrow["id"].'">Redact profile</a>  
         <a href="delete_prof.php?id='.$myrow["id"].'">Delete profile</a>';
     }
?>	

</body>
</html>