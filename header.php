
<div class="hov">
		<a class="hov"href="index.php?l=<?=$_SESSION['l'] ?>"> <?=$l['gen']?>  </a>
		
		<a class="hov" href="view_allprof.php?l=<?=$_SESSION['l'] ?>"><?=$l['allp']?></a>

		
	
<?php
if (isset($_SESSION['role']) and ($_SESSION['role'] == 'admin' or $_SESSION["role"] == 'redactor')){
	echo '<a class="hov" href="add.php?l='.$_SESSION['l'].'">'.$l['addn'].'</a></div>';	
}
?>
</div>