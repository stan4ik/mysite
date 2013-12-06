<?php
if (isset($_GET['pg']))
	{
	$count = $_GET['pg'];
	$off = $count * 10;


$result = $db->prepare("SELECT * FROM data ORDER BY id DESC LiMIT $off, 10");
$result->execute();
$myrow = $result->fetch(PDO::FETCH_ASSOC);
	}
else
	{
	$result = $db->prepare("SELECT * FROM data ORDER BY id DESC LiMIT 10 ");
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

	echo "<table cellpadding='5'>
        <tr class='t' >
         <td> <h4>".$myrow["title"]."</h4>".$myrow["text"]." <br> </td>
        </tr>

        <tr>
         <td class='text'>".$myrow["author"]." / ".$myrow["date"]."</td>
       	</tr>
             </table>";
	printf ('	
		<a href="view_once.php?id=%s"target="_blanc">Read more</a>
		<br><br><br>',$myrow['id']);

	}
	while ($myrow = $result->fetch(PDO::FETCH_ASSOC));
}						
?>