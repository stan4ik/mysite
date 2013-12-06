<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php session_start()?>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>regestration</title>
</head>

<body>

Regestration new user  <br>
<form method="post" action="reg.php" enctype="multipart/form-data" >
Enter name: <br>  
    <input type="text" name="name" maxlength="10" />
    <br>
Enter lastname: <br>
    <input type="text" name="lastname" maxlength="10" />
    <br>
Enter username: <br>  
    <input type="text" name="username" maxlength="10" required />
    <br>
Enter login: <br>
	<input type="text" name="login" maxlength="20" required />
	<br>
Enter mail:	<br>
	<input text="text" name="mail" maxlength="50" required />
	<br>
Enter password: <br>
	<input type="password" name="password" maxlength="10" required />
	<br>
Repeat password: <br>
	<input type="password" name="r_password" maxlength="10" required />
	<br>
Avatar:<br>
    <input type="file" name="filename" id="filename">
    <br>
	<input type="submit" name="submit" value="registr" required/>

</form> 
<?php
include ("db.php");

if (isset($_POST['submit'])){
	$err = array();
    $path = "img/";
$name = ($_POST['name']);
$lastname = ($_POST['lastname']);
$username = ($_POST['username']);
$login = ($_POST['login']);
$mail  = ($_POST['mail']);
$password = ($_POST['password']);
$r_password = ($_POST['r_password']);
$date = date('Y-m-d');
$role = "user";

	if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login'])) 
    { 
    	$err[] = "error";
        echo "<p>Username can only consist of letters of the alphabet and numbers</p>"; 
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 20) 
    { 
    	$err[] = "error";
        echo "<p>Username must be at least 3 characters and no more than 30</p>"; 
    }
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
    {
    	$err[] = "error";
    	echo "E-Mail wrong. E-mail should look user@somehost.com";
    }  
    if(isset($_POST['filename']) and !preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_POST['filename']))
    {
        $err = "error";
        echo "Wrong format of img";
    }
    if ($_FILES['filename']['size'] >  2 * 1024 * 1024){
        $err = "error";
        echo "Avatar must be less than 2 mb <br>";
    }
    if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
    {
    move_uploaded_file($_FILES["filename"]["tmp_name"], $path.$_FILES["filename"]["name"]);
    } 

    if    (!isset($_POST['filename']) or empty($_POST['filename']) or $_POST['filename'] =='')
            {
            
            $avatar    = $path."standart.gif";
            } 
            else {$avatar = $path.$_POST['filename'];}

    $query_check_user = "SELECT COUNT(id)  FROM users WHERE login='".$_POST['login']."'";
    $result = $db->query($query_check_user)->fetchColumn();
    
    if (!empty($result))
    {
    	$err[] = "error";
    	echo "Login already used";
    }
    $query_check_user = "SELECT COUNT(id)  FROM users WHERE mail='".$_POST['mail']."'";
    $result = $db->query($query_check_user)->fetchColumn();
    
    if (!empty($result))
    {
        $err[] = "error";
        echo "E-mail already used";
    }

	if ($password != $r_password)
	{
		$err = "error";
		echo "password must much";
	}
	if (count($err) == 0)
	{
$query = $db->prepare("INSERT INTO users (username, login, mail, password, name, lastname, avatar, `date`,role) value (:username, :login, :mail, :password, :name, :lastname, :avatar, :date, :role)");
$query->bindParam(':username',$username);
$query->bindParam(':login',$login);
$query->bindParam(':mail',$mail);
$query->bindParam(':password',$password);
$query->bindParam(':name',$name);
$query->bindParam(':lastname',$lastname);
$query->bindParam(':avatar',$avatar);
$query->bindParam(':date',$date);
$query->bindParam(':role',$role);
$query->execute();
	}
							}
else{
echo "<br>You are not registered";
}

if (isset($query)){
    $st = $db->query("SELECT id, login, role FROM users WHERE login = '$login'");
    $user_data = $st->fetch(PDO::FETCH_ASSOC);
    $_SESSION['id'] = $user_data['id'];
    $_SESSION['name'] = $user_data['login'];
    $_SESSION['role'] = $user_data['role'];
header("location:index.php");
}


?>

</body>
</html>
