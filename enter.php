<?php 
$login=$_POST["login"];
$password=$_POST["password"];
$remember=$_POST["remember"];
include("bd.php");
$db = mysql_connect("localhost", "kasper", "kasper636");
mysql_select_db("ksi", $db);
$result = mysql_query("SELECT * FROM users WHERE login = '$login'", $db);
$myrow = mysql_fetch_array($result);
if ($myrow != true)
{
  	echo"		
		<script type='text/javascript'>
			error_autorization();
		</script>";   
}
else
{
	if ($password==$myrow["password"])
	{   
		$id_u_t = $myrow["id_u"];
		$resulttt = mysql_query("SELECT id_r from roles_of_users WHERE `id_u` = '$id_u_t'");
		$row = mysql_fetch_array($resulttt);
/* 		echo $myrow["id_u"], "<br>";
		echo $myrow["login"], "<br>";
		echo $row["id_r"], "<br>";
		echo $myrow["id_tz"], "<br>";
		 */
		if ($remember=='true')
		{
			$t = time()+172800;
			setcookie( shifr("id_u"),  shifr($myrow["id_u"]), $t);
			setcookie( shifr("login"), shifr($myrow["login"]), $t);
			
			session_start();
			session_register('id_u', 'login', 'id_r', 'tz');
			$id_u = $myrow["id_u"];	
			$login = $myrow["login"];
			$id_r = $row["id_r"];
			$tz = $myrow["id_tz"];
			
			echo "<script type='text/javascript'> enter(); $('#menu').load('menu.php'); </script>";
		}
		else
		{
			session_start();
			session_register('id_u', 'login', 'id_r', 'tz');
			$id_u = $myrow["id_u"];	
			$login = $myrow["login"];
			$id_r = $row["id_r"];
			$tz = $myrow["id_tz"];
		    echo "<script type='text/javascript'> enter(); $('#menu').load('menu.php'); </script>";
		}
	}
	else
	{ echo "	<script type='text/javascript'>
					error_autorization();
				</script>";
 	
	}
}
?>
