<?php
if(isset($_POST['enter'])){

	$e_login = ($_POST['e_login']);
	$e_password = ($_POST['e_password']);

	$st = $db->query("SELECT * FROM users WHERE login = '$e_login'");
	$user_data = $st->fetch(PDO::FETCH_ASSOC);
	$id = $user_data['id'];
	$ldate = date('Y-m-d H:i:s');
	
	if ($user_data['password'] == $e_password){
	$redact = $db->prepare("UPDATE users SET ldate = '$ldate' WHERE id=$id");
	$redact->execute();
	
	$_SESSION['id'] = $user_data['id'];
	$_SESSION['name'] = $e_login;
	$_SESSION['role'] = $user_data['role'];

	if (isset($_SESSION['role']) and $_SESSION['role'] == 'block'){
		echo "Your profile blocked";
		exit();
	}	
	}	
else{
echo"<p>wrong login or password</p>";
}
}
if (isset($_POST['logout'])){

unset($_SESSION['name']);
unset($_SESSION['role']);
unset($_SESSION['id']);
session_destroy();
}

if(isset($_SESSION['name'],$id)){
include('aut.php');
}
else{
	echo '
<form  class="f" method="post" action="">
<input type="text" name="e_login" placeholder="login" required /><br>
<input type="password" name="e_password" placeholder="password" required /><br>
<input type="submit" name="enter" value="'.$l['login'].'" required/>
<a href="reg.php" taget="_blank">'.$l['re'].'</a>
</form>' ;

}
?>