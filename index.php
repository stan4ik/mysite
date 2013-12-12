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
    <a href="index.php?l=ua"><img src="img/ua.png" width="14" height="10"></a>';
}
else {
    echo '
    <a href="index.php?l=eng"><img src="img/en.png" width="14" height="10"></a>';
}
include("lang/".$_SESSION['l'].".php");
 ?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
<style type="text/css">
	<? include "style.css" ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?=$l['index']?></title>
</head>
<body>
<?php
include('db.php');	
include('aut.php');
include("header.php");
include('view.php');

$result = $db->prepare("SELECT * FROM data ");
$result->execute();
$count = $result->rowCount();

if ($count > 10){
	$o = round($count/10);
for ($i=0;$i<=$o;$i++)
		{
echo "<a href='index.php?l=".$_SESSION['l']."&pg=$i' target='_self'>$i</a>&nbsp";
		}	
}		
?>

</body>
</html>
