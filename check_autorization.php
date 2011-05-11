<?php 
	include("bd.php");
	if (  ( isset($_COOKIE[shifr("id_u")]) and  $_COOKIE[shifr("id_u")] != "" )  and  ( isset($_COOKIE[shifr("login")]) and $_COOKIE[shifr("login")] != "" ) )
	{
		$c_id_u = $_COOKIE[shifr("id_u")];
		$c_login = $_COOKIE[shifr("login")];
		$r = mysql_query("SELECT * FROM users WHERE md5(sha1(md5(`id_u`))) = '$c_id_u' ");
		if ($r) {
			$mass = mysql_fetch_array($r);
			if ($c_login = shifr($mass["login"])) {
				$result = mysql_query("SELECT id_r from roles_of_users WHERE md5(sha1(md5(`id_u`))) = '$c_id_u'");
				$row = mysql_fetch_array($result);
				session_start();
				session_register('id_u', 'login', 'id_r');
				$id_u = $mass["id_u"];	
				$login = $mass["login"];
				$id_r = $row["id_r"];
				echo "<script type='text/javascript'> $('#first_left').load('profile_menu.php'); </script>";
			}
		}
		
		
	}
	else
	{
		session_start();
		if (isset($_SESSION["id_u"])) {
			echo "<script type='text/javascript'> $('#first_left').load('profile_menu.php'); </script>";
		}
		else {
			echo "<script type='text/javascript'> $('#first_left').load('enter_menu.php'); </script>";
		}	
	}

?>