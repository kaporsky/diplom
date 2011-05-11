<?php 
	session_start(); 
	include("bd.php");
	$id_r = $_SESSION['id_r'];
	$result = mysql_query("SELECT name FROM roles WHERE `id_r` = '$id_r'");
	$myrow = mysql_fetch_array($result);
?>
<script type="text/javascript"> b_edit_pass(); </script>
<div id="profile" class="right">
<center> <h3> Настройка профиля </h3> </center>
Логин: <?php echo $_SESSION["login"]; ?> <br />
Права: <?php echo $myrow["name"]; ?> <br />

<div id="b_edit_pass"> Изменить пароль </div>
<div id="edit_pass">

<table width="20" border="0">
  <tr>
    <td>Текущий пароль:</td>
    <td><input name="" type="password" id="oldpass"></td>
  </tr>
  <tr>
    <td>Новый пароль:</td>
    <td><input name="" type="password" id="newpass"></td>
  </tr>
  <tr>
    <td>Подтверждение нового пароля:</td>
    <td><input name="" type="password" id="rnewpass"></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"> <button id="button_pass"> Изменить </button> </td>
  </tr>
</table>     	
</div>
<script type="text/javascript"> $('#edit_pass').hide(0); </script>
<br />
Часовой пояс:
<select name="timezone" size="1">
	<?php
    	$tz = timezone_identifiers_list();
		$j = count($tz)-1;
		$default_tz=231;
		for($i=1; $i<=$j; $i++) {
			if($i==$default_tz) {
				printf("<option value='%s' selected='selected'>%s</option>", $i, $tz[$i]);
			} else {
				printf("<option value='%s'>%s</option>", $i, $tz[$i]);
			}
		}
	?>
</select>
</div>