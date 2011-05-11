<script type="text/javascript"> button_profile(); </script>
<div id="profile_menu">
<center>
<table width="20" border="0">
  <tr>
  
    <td>
    	<img src="images/admin.jpg">
    	<center>
		<?php 
			session_start();
			echo $_SESSION["login"], "<br />";
		?>		
        </center>	
    </td>
    
    <td>
        <a href="profile.php"> Профиль </a> <br> <br>
        <a href="messages.php"> Сообщения </a> <br> <br>	
        <button id="bexit">Выход</button>
    </td>
    
  </tr>
</table>
</center>
</div>