<?php include("bd.php"); ?>

<script type="text/javascript">
	$('#main_page').html("");
	$('#tmp_b').click(function(){
	$('#right_div').load('tmp.php');
	});
</script>
<div id="start" class="right">
<div>
	<p id="test">	
    <button id="tmp_b"> Temp.php </button> 

    <?php 
		date_default_timezone_set('Asia/Irkutsk');
		echo "<h2>", date('d-m-Y H:i:s'), "</h2><br>"; 
	?>
    
	start start start <br>
	start start start <br>
    start start start <br>
	start start start <br>
	start start start <br>
	start start start <br>
	start start start <br>
	start start start фыы <br>
	start start start <br>
	start start start <br>
	start start start <br>
	start start start <br>
	start start start <br> 
    </p>
</div>
</div>