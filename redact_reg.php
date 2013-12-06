<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start()?>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Change profile</title>
</head>

<body>

<?php
include ("db.php");

if (isset($_POST['redact'])){
	 
		$id = $_GET['id'];
		$path = "img/";
		$err = array();
		if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
			$err = "error";
    	echo "E-Mail wrong. E-mail should look user@somehost.com";
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
	if (!empty($_POST['password']) and $_POST['password'] == $_POST['r_password'])		
										{$redact = $db->prepare("UPDATE users SET password = :password WHERE id=:id");
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

else {
echo "<br>Changes have not been saved";
	}

if (isset($redact)){
header("location: view_prof.php?id=$id");
}

$id = $_GET['id'];
$quer = $db->query("SELECT * FROM users WHERE id=$id");
$quer->execute();
$myrow = $quer->fetch(PDO::FETCH_ASSOC);

printf ('
<form method="post" action="" enctype="multipart/form-data" >
 
Enter name: <br>  
    <input type="text" name="name" maxlength = "10" value = "%s" >
    <br>
Enter lastname: <br>
	<input type="text" name="lastname" maxlength="10" value="%s" >
	<br>
Change mail:	<br>
	<input text="text" name="mail" maxlength="50" value="%s" >
	<br>
Enter new password: <br>
	<input type="password" name="password" maxlength="10" >
	<br>
Repeat new password: <br>
	<input type="password" name="r_password" maxlength="10" >
	<br>',$myrow['name'], $myrow['lastname'], $myrow['mail']);
	
if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){
		printf ('
		Role:<br>
		<input text="text" name="role" value="%s" ><br>',$myrow['role']);
	}
echo '
Avatar:<br>
	<input type="file" name="filename" >
	<br>
	<input type="submit" name="redact" value="redact" >
</form>'
?>
</body>
</html>
