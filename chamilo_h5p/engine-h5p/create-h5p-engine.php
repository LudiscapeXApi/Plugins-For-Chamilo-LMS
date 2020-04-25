
<center>
	<a href="create-h5p-engine.php?mode=Generate" >Generate</a>
</center>

<script>
	setTimeout(function(){
		location.reload();
	},5000);
</script>

<?php

	include("functions.php");
	
	$hjs  = file_get_contents('js/wordsmatch.js');
	
	$fp = fopen('../resources/js/interface.js','w');
	fwrite($fp,$hjs);
	fclose($fp);

?>

