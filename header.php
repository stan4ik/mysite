<table>
<tr>
	<td width="90px">
		<a class="cl"href="index.php">GENERAL  </a>
	</td>
	<td width="140px" >
		<a class="cl" href="view_allprof.php">ALL PROFILES</a>
	</td>
<?php
echo "<td width='100px'>";
if (isset($_SESSION['role']) and $_SESSION['role'] == 'admin'){
	echo '<a class="cl" href="add.php">ADD NEWS</a>';	
}
if (isset($_SESSION['role']) and $_SESSION['role'] == 'redactor'){
	echo '<a class="cl" href="add.php">ADD NEWS</a>';
}
echo "</td>";

?>
</tr>
</table>