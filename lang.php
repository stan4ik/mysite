<?php
echo '
<a href="index.php?l=ua">UA</a>
<a href="index.php?l=eng">ENG</a>';

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
include("lang/".$_SESSION['l'].".php");
?>