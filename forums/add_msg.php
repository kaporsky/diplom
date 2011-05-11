<?php 
$text_msg = $_POST["txt_msg"];
$id_theme = $_POST["id_theme"];
$n_u_f = $_POST["n_u_f"];
$pattern = "\[quote=([^]]*)\](.*)\[/quote\]";
$replace = "<b>\\1 писал(а):</b> <br><div class='quote_div'>\\2 </div>";
$r=0;


session_start();
include("../bd.php");
date_default_timezone_set('Asia/Irkutsk');
?>
<div class="right">
<?php 
$d = date('Y-m-d H:i:s');

if (isset($_SESSION["id_u"]) && $_SESSION["id_u"]!="") {
	$id_u = $_SESSION["id_u"];
	
	while (ereg($pattern, $text_msg)) {
		if ($r<=5) {
			$r++;
			$bol='true';
		} else {
			$bol='false';
			break;
		}
	}
	
	if ($bol=='true'){
	$b = mysql_query("INSERT INTO msg_themes(id_theme, id_u, text_msg, msg_post_date) VALUES ('$id_theme', '$id_u', '$text_msg', '$d')", $db);
	if ($b) {
		$z_col =  mysql_query("SELECT * FROM msg_themes WHERE `id_theme` = '$id_theme'");
		$sum_z = mysql_num_rows($z_col);
		$n_page = ceil($sum_z/10);
		echo "<center>Ваше сообщение успешно добавлено. <br /> Через 10 секунд вы будете перемещены обратно в тему, <br /> если этого не произошло или вы не хотите ждать, то нажмите <a href='#' id='return_theme'>сюда</a>.</center> <script type='text/javascript'> return_theme(); </script>";
	} else {
		echo "Ошибка отправки сообщения!";
	}
	} else {
		echo "Вложенных цитат должно быть не больше 5!";
	}

} else {
	echo "Для отправки сообщений необходимо авторизоваться!";
}
?>
<input name="r_theme_id" type="hidden" id="return_id_theme" value="<?php echo $id_theme; ?>">
<input name="r_uf_id" type="hidden" id="return_id_uf" value="<?php echo $n_u_f; ?>">
<input name="r_n_page" type="hidden" id="r_n_page" value="<?php echo $n_page; ?>">
</div>