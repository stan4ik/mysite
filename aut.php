<?php
if (isset($_SESSION['name']))
	{
	echo ' <table class="f">
	<tr><td><a  class="f" href="view_prof.php?id='.$_SESSION['id'].'" target="_blank">'.$_SESSION["name"].'</a></td></tr>
	<tr><td><form class="f" method="post" action=""/>
	<input type="submit" name="logout" value="'.$l['logout'].'"/>
	</form></td></tr>
	</table>';
	}

else {
	include("log.php");
	}
if (isset($_POST['logout'])){

unset($_SESSION['name']);
unset($_SESSION['role']);
unset($_SESSION['id']);
session_destroy();
header("location:index.php?l=".$_SESSION['l']."");
}
?>