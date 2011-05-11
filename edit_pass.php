<div id="div_edit_pass">
<?php 
include("bd.php");
$oldpass = $_POST["op"];
$newpass = $_POST["np"];
$rnewpass = $_POST["rnp"];

session_start();
$id_u = $_SESSION["id_u"];
$result = mysql_query("SELECT password FROM users WHERE id_u = '$id_u' ");
$myrow = mysql_fetch_array($result);

if ($myrow["password"]==$oldpass) {
	if ($newpass==$rnewpass) {
		$res = mysql_query("UPDATE users SET password='$newpass' WHERE id_u = '$id_u' ");
		if ($res) {
			echo "<script type='text/javascript'>	$('#main_div').prepend('<div id=\"dialog-message\" title=\"Изменение пароля\"><span class=\"ui-icon ui-icon-circle-check\" style=\"float:left; margin:0 7px 20px 0;\"></span> Ваш пароль успешно изменен. </div>');
	
	$( '#dialog:ui-dialog' ).dialog( 'destroy' );			
	$( '#dialog-message' ).dialog({
					minWidth: 200,
					resizable: false,
					modal: false,
					buttons: {
						Ok: function() {
							$('#oldpass, #newpass, #rnewpass').attr('value', '');
							$( this ).dialog( 'close' );
							$('#edit_pass').slideUp(500);
						}
					}
	}); </script>";	
		}
		else {
			echo "<script type='text/javascript'>	$('#main_div').prepend('<div id=\"dialog-message\" title=\"Ошибка!\"><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span> Неизвестная ошибка. Пароль не изменен! </div>');
	
	$( '#dialog:ui-dialog' ).dialog( 'destroy' );			
	$( '#dialog-message' ).dialog({
					minWidth: 400,
					resizable: false,
					modal: true,
					buttons: {
						Ok: function() {
							$('#oldpass, #newpass, #rnewpass').attr('value', '');
							$( this ).dialog( 'close' );
						}
					}
	}); </script>";	
			
		}
	}
	else {
		echo "<script type='text/javascript'>	$('#main_div').prepend('<div id=\"dialog-message\" title=\"Ошибка!\"><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span> Новый пароль и его подтверждение не совпадают! <br> <br> Проверьте правильность ввода и повторите попытку еще раз. </div>');
	
	$( '#dialog:ui-dialog' ).dialog( 'destroy' );			
	$( '#dialog-message' ).dialog({
					minWidth: 400,
					resizable: false,
					modal: true,
					buttons: {
						Ok: function() {
							$('#oldpass, #newpass, #rnewpass').attr('value', '');
							$( this ).dialog( 'close' );
						}
					}
	}); </script>";	
	}
	
}
else {
echo "<script type='text/javascript'>	$('#main_div').prepend('<div id=\"dialog-message\" title=\"Ошибка!\"><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span> Текущий пароль неверен! <br> <br> Проверьте правильность ввода и повторите попытку еще раз. </div>');
	
	$( '#dialog:ui-dialog' ).dialog( 'destroy' );			
	$( '#dialog-message' ).dialog({
					minWidth: 380,
					resizable: false,
					modal: true,
					buttons: {
						Ok: function() {
							$('#oldpass, #newpass, #rnewpass').attr('value', '');
							$( this ).dialog( 'close' );
						}
					}
	}); </script>";
}

?>
</div>