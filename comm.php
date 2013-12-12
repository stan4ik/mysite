<?php
$result = $db->prepare("SELECT * FROM vote WHERE login = :log and newsid = :id");
$result->bindParam(':log', $_SESSION['name']);
$result->bindParam(':id', $id);
$result->execute();
$all = $result->fetch(PDO::FETCH_ASSOC);

if (isset($all['vote'])){  
	 echo "<div style='margin-left: 30px;'>";
    echo '<br><br>Thank you for vote<br>
    Your vote is:  '.$all['vote'].'<br>
    <form method="post" action="">
    <input type=submit name="uv" value="Vote again">
    </form>';
    echo "</div>";

}
else{

echo '
<form METHOD="POST" action="">
<table><TR><TD>
<TABLE>
<TR><TD><INPUT type=radio name="v" VALUE=1>1</TD></TR>
<TR><TD><INPUT type=radio name="v" VALUE=2>2</TD></TR>
<TR><TD><INPUT type=radio name="v" VALUE=3>3</TD></TR>
<TR><TD>
<INPUT TYPE=Submit name="vote" VALUE="Vote">
</TD></TR>
</table>
</form>';

}
?>