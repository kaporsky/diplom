<script type="text/javascript"> select_last_news(); </script>
<div id="last_news">
<center> Последние новости </center>
<?php 
	include("bd.php");
	$r = mysql_query("SELECT * FROM news ORDER BY `id_news` DESC LIMIT 3", $db);
	
	while ($n = mysql_fetch_array($r)) {
		printf("
		<div id='%s'>
		<font color=blue>%s</font> <br />
		%s
		</div>", $n["id_news"], $n["name_news"], $n["title_news"]);
	}
	
?>
</div>