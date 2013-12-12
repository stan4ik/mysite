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
    <a href="reg.php?l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="reg.php?l=eng"><img src="img/en.png" width="14" height="10"></a>';
}

include("lang/".$_SESSION['l'].".php"); ?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<script type="text/javascript">
    function Validate(obj) {
var username=obj.username.value;
var pass=obj.password.value;
var passagain=obj.r_password.value;
var mail=obj.mail.value;
var login=obj.login.value;
var errors="";
if (username=="" || pass=="" || passagain=="" || mail=="" || login=="")
{
alert("Enter all lines");
return false;
}
if (pass!=passagain)
{
errors+="Password must much\n";
}
if (pass.length<3)
{
errors+="Password too short\n";
}
var reg = /^\w+@\w+\.\w{2,4}$/i;
if (!reg.test(mail))
{
errors+="Wrong E-mail\n";
}
if(errors=="")
return true;
else
{
alert(errors);
return false;
}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?=$l['reg']?></title>

</head>
<body>

<?php
include ("db.php");
include("header.php");
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

     if(isset($_POST['filename']) and !preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_POST['filename']))
    {
        $err = "error";
        echo $l['err4'];
    }
    if ($_FILES['filename']['size'] >  2 * 1024 * 1024){
        $err = "error";
        echo $l['err5'];
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

    $query_check_user = "SELECT id FROM users WHERE login='".$login."'";
    $check = $db->query($query_check_user)->fetchColumn();
    
    if (!empty($check))
    {
    	$err[] = "error";
    	echo $l['err6'];
    }
    $query_check_user = "SELECT id FROM users WHERE mail='".$mail."'";
    $check = $db->query($query_check_user)->fetchColumn();
    
    if (!empty($check))
    {
        $err[] = "error";
        echo $l['err7'];
    }

	
	if (count($err) == 0){

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

if (isset($query)){
    $st = $db->query("SELECT id, login, role FROM users WHERE login = '$login'");
    $user_data = $st->fetch(PDO::FETCH_ASSOC);
    $_SESSION['id'] = $user_data['id'];
    $_SESSION['name'] = $user_data['login'];
    $_SESSION['role'] = $user_data['role'];
header("location:index.php?l=".$_SESSION['l']."");
}

echo '<br>
'.$l['label'].'  <br>
<form method="post" OnSubmit="return Validate(this);" action="reg.php" enctype="multipart/form-data" >
'.$l['name'].': <br>  
    <input type="text" name="name" maxlength="10" />
    <br>
'.$l['lname'].': <br>
    <input type="text" name="lastname" maxlength="10" />
    <br>
'.$l['uname'].': <br>  
    <input type="text" name="username" maxlength="10"  />
    <br>
'.$l['log'].': <br>
    <input type="text" name="login" maxlength="20"  />
    <br>
'.$l['mail'].': <br>
    <input text="text" name="mail" maxlength="50"  />
    <br>
'.$l['pass'].': <br>
    <input type="password" name="password" maxlength="10"  />
    <br>
'.$l['repass'].': <br>
    <input type="password" name="r_password" maxlength="10"  />
    <br>
'.$l['ava'].':<br>
    <input type="file" name="filename" id="filename">
    <br>
    <input type="submit" name="submit" value="'.$l['re'].'" required/>
</form> '


?>

</body>
</html>
