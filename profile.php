<?php 
	session_start(); 
	include("bd.php");
	$id_r = $_SESSION['id_r'];
	$result = mysql_query("SELECT name FROM roles WHERE `id_r` = '$id_r'");
	$myrow = mysql_fetch_array($result);
?>
<script type="text/javascript"> 
	b_edit_pass(); 
	profile_tabs();
</script>
<div id="profile_tabs">
	<ul>
    	<li> <a href="#t1"> Регистр. информация </a></li>
        <li> <a href="#t2"> Дата и время </a></li>
    </ul>
    
    <div id="t1">
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
    </div>
    
    <div id="t2">
    	Часовой пояс:
       
    </div>
</div>

<script type="text/javascript"> $('#edit_pass').hide(0); </script>