<?php 
include("bd.php");

for($i=1; $i<=199; $i++){
	$j="";
	$j="images/smiles/$i.gif";
	mysql_query("INSERT INTO smiles(url_smile) VALUES ('$j')", $db);
}
?>