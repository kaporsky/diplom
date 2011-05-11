 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
Смайлики
</title>
<style> 
	#smiles_div img:hover {
		border:1px solid #0066FF;
		cursor:pointer;
	}
</style>
<script type="text/javascript"> select_smile(); </script>
</head>

<body>
<div id="smiles_div">
<?php 
include("../bd.php");
$result = mysql_query("SELECT * FROM smiles");
for($i=1; $i<=199; $i++){
	$smiles = mysql_fetch_array($result);
	printf("<img src='%s' id='%s'>", $smiles["url_smile"], $smiles["id_smile"]);
}
?>
</div>
</body>
</html>
