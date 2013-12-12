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
    <a href="redact_reg.php?id='.$id.'&l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="redact_reg.php?id='.$id.'&l=eng"><img src="img/en.png" width="14" height="10"></a>';
}
include("lang/".$_SESSION['l'].".php"); ?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?=$l['ep']?></title>
</head>

<body>

<?php
include ("db.php");
include("header.php");

$err = array();
if (isset($_POST['redact'])){
	 
		$path = "img/";
		if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
			$err = "error";
    	echo $l['err3'];
    	}
    	if ($_POST['password'] != $_POST['r_password']){
		$err = "error";
		echo $l['err9'];
		}
    	if (count($err) == 0){

	if (!empty($_POST['name']))			{$redact = $db->prepare("UPDATE users SET name = :name WHERE id=:id");
										 $redact->bindParam(':name',$_POST['name']);
										 $redact->bindParam(':id',$_GET['id']);
										 $redact->execute();}
	if (!empty($_POST['lastname']))		{$redact = $db->prepare("UPDATE users SET lastname = :lastname WHERE id=:id");
										 $redact->bindParam(':lastname',$_POST['lastname']);
										 $redact->bindParam(':id',$_GET['id']);
										 $redact->execute();}
	if (!empty($_POST['mail']))			{$redact = $db->prepare("UPDATE users SET mail = :mail WHERE id=:id");
										 $redact->bindParam(':mail',$_POST['mail']);
										 $redact->bindParam(':id',$_GET['id']);
										 $redact->execute();}
	if (!empty($_POST['password']))		{$redact = $db->prepare("UPDATE users SET password = :password WHERE id=:id");
										 $redact->bindParam(':password',$_POST['password']);
										 $redact->bindParam(':id',$_GET['id']);
										 $redact->execute();} 
	if (!empty($_FILES['filename']['name'])){ $ava = $path.$_FILES['filename']['name'];
										$redact = $db->prepare("UPDATE users SET avatar = :avatar WHERE id=:id");
										 $redact->bindParam(':avatar', $ava);
										 $redact->bindParam(':id', $_GET['id']);
										 $redact->execute();}
	if (!empty($_POST['role']))			{$redact = $db->prepare("UPDATE users SET role = :role WHERE id=:id");
										 $redact->bindParam(':role',$_POST['role']);
										 $redact->bindParam(':id',$_GET['id']);
										 $redact->execute();}
	}									 
	if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
    {
    move_uploaded_file($_FILES["filename"]["tmp_name"], "img/".$_FILES["filename"]["name"]);
    }
}

if (isset($redact)){
header("location: view_prof.php?id=$id");
}

$id = $_GET['id'];
$quer = $db->query("SELECT * FROM users WHERE id=$id");
$quer->execute();
$myrow = $quer->fetch(PDO::FETCH_ASSOC);

echo '
<form method="post" action="" enctype="multipart/form-data" >
'.$l['name'].': <br>  
    <input type="text" name="name" maxlength = "10" value = "'.$myrow['name'].'" >
    <br>
'.$l['lname'].': <br>
	<input type="text" name="lastname" maxlength="10" value="'.$myrow['lastname'].'" >
	<br>
'.$l['mail'].':	<br>
	<input text="text" name="mail" maxlength="50" value="'.$myrow['mail'].'" >
	<br>
'.$l['pass'].': <br>
	<input type="password" name="password" maxlength="10" >
	<br>
'.$l['repass'].': <br>
	<input type="password" name="r_password" maxlength="10" >
	<br>';
	
if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){

echo '
		'.$l['role'].':<br>
		<input text="text" name="role" value="'.$myrow['role'].'" ><br>';
	}
echo '
'.$l['ava'].':<br>
	<input type="file" name="filename" >
	<br>
	<input type="submit" name="redact" value="'.$l['but3'].'" >
</form>'
?>
</body>
</html>
