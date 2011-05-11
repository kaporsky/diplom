<?php 
$db = mysql_connect("localhost", "kasper", "kasper636");
mysql_select_db("ksi", $db);
mysql_set_charset('utf8');
function shifr($qq)
{
	$qq = md5(sha1(md5($qq)));	
	return $qq;
}
?>