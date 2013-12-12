<?php
		if ($_SESSION['l'] == 'ua'){
    $sql = 'SELECT * FROM `uadata` ORDER BY id DESC LiMIT $off, 10';
    $sqll = 'SELECT * FROM uadata ORDER BY id DESC LiMIT 10'; 
}
else {
    $sql = 'SELECT * FROM `data` ORDER BY id DESC LiMIT $off, 10';
    $sqll = 'SELECT * FROM data ORDER BY id DESC LiMIT 10';
}

if (isset($_GET['pg'])){
		$count = $_GET['pg'];
		$off = $count * 10;
$result = $db->prepare($sql);
$result->execute();
$myrow = $result->fetch(PDO::FETCH_ASSOC);
	}
else{
	$result = $db->prepare($sqll);
	$result->execute();
	$myrow = $result->fetch(PDO::FETCH_ASSOC);
	}
if (isset ($myrow["title"])){
	$row = count($myrow);
	do 
	{
	$myrow["text"] = substr($myrow["text"], 0, 150);

	if (strlen($myrow["text"])==150){
	$myrow["text"] .="...";}
	echo "<div class='new'>";
	echo "
        <h3>".$myrow["title"]."</h3>".$myrow["text"]."<br> 
      
      ".$myrow["author"]." / ".$myrow["date"]."<br>";
	echo '	
		<a href="view_once.php?l='.$_SESSION['l'].'&id='.$myrow['id'].'"target="_blanc">'.$l['read'].'</a>
		<br><br><br>';
	echo "</div>";

	}
	while ($myrow = $result->fetch(PDO::FETCH_ASSOC));
}						
?>