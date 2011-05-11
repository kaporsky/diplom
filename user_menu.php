<script type="text/javascript"> 
	var_button();
	logout();
</script>
<div id="user_menu">
<?php 
$c_id_u = $_COOKIE["id_u"];
include("bd.php");
mysql_select_db("ksi");
$result = mysql_query("SELECT * FROM users WHERE sha1(md5(`id_u`)) = '$c_id_u' ");
$myrow = mysql_fetch_array($result);
?>
    <div id="right_info">
	<font color="#999999"> <?php  echo $myrow['login']; ?> </font>
    &nbsp;
    <button id="bprofile"> Профиль </button>
    
    <button id="bexit"> Выход </button>
    &nbsp; &nbsp;
    </div>
</div>