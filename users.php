<?php 
	include("bd.php");
	$result = mysql_query("SELECT * FROM users");
	$count_users = mysql_num_rows($result);
?>
<div id="users" class="right">
<center> Пользователи </center> <br />
<?php 
	echo "Количество зарегестрированных пользователей = ", $count_users;
?>
</div>