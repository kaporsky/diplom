

<?php 
	
	
	$size = getimagesize("images/logo.jpg");
	for ($i=0; $i<4; $i++) {
		echo $size[$i], "<br />";
	}
		
	$s = filesize("images/logo.jpg");
	echo $s;
	
		
?>

