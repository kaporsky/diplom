<?php 
session_start();
if (isset($_POST["n_page"])) {
	$n_page=($_POST["n_page"]*10)-10;
	$p = $_POST["n_page"];
} else {
	$n_page=0;
	$p = 1;
}

/* session_start(); 
if (isset($_SESSION["id_u"]) && $_SESSION["id_u"] != "") {
	$id_it_u = $_SESSION["id_u"];
} else {
	echo "ПЛОХО";
} */

include("../bd.php");
if (isset($_POST["id_forum"])){
$p_id_forum = $_POST["id_forum"];
}
$id_t = $_POST["id_theme"];
$n_u_f = $_POST["n_u_f"];
date_default_timezone_set('Asia/Irkutsk');
$z_col =  mysql_query("SELECT * FROM msg_themes WHERE `id_theme` = '$id_t'");
$sum_z = mysql_num_rows($z_col);
$col_page = ceil($sum_z/10);

$str_num_page="";
for($i=1; $i<=$col_page; $i++) {
	if ($i==$p) {
	
		if ($i==$col_page) {
			$str_num_page = $str_num_page."<b>$i</b>";
		} else {
			$str_num_page = $str_num_page."<b>$i</b>, ";
		}
		
	} else {
		
		if ($i==$col_page) {
			$str_num_page = $str_num_page."<a href=page$i id='$i' class='select_page'>$i</a>  ";
		} else {
			$str_num_page = $str_num_page."<a href=page$i id='$i' class='select_page'>$i</a>, ";
		}
		
	}
}

$r = mysql_query("SELECT *, DATE_FORMAT(msg_post_date, '%d.%m.%Y %H:%i:%s') as d_msg FROM msg_themes WHERE `id_theme` = '$id_t' LIMIT $n_page, 10");

$rr = mysql_query("SELECT name_theme FROM themes WHERE `id_theme` = '$id_t'");
$mm = mysql_fetch_row($rr);
?>
<div>
<div class="forum_header">
	<a href="#" class="forum_refresh">Список форумов</a> → <?php echo " <a href='#' id='podforum_refresh'>",$n_u_f, "</a>"; ?> 
</div>

<table width="590" border="1" id="theme_header">
  <tr>
    <td><h3 id="h3_name_theme"> <?php echo $mm['0']; ?> </h3></td>
    <td id="pages">Страницы: <?php echo $str_num_page; ?></td>
  </tr>
</table>

<?php
$i=0;
while ($msg = mysql_fetch_array($r)) {
$id_u2 = $msg["id_u"];
$rrr = mysql_query("SELECT login FROM users WHERE `id_u` = '$id_u2'");
$author = mysql_fetch_row($rrr);

$tttt = htmlspecialchars($msg['text_msg']); // замена специальных символов

$tttt = strip_tags($tttt);  // проверка на тэги php и html

$tttt = str_replace("\n","<br>",$tttt); //переносы
$tttt = str_replace(" ","&nbsp;&nbsp;",$tttt); // пробелы

$pattern = "\[quote=([^]]*)\](.*)\[/quote\]"; //цитата
$replace = "<b>\\1 писал(а):</b> <br><div class='quote_div'>\\2 </div>";
$iii = 1;
while (ereg($pattern, $tttt)) {
	$iii++;
	if ($iii>=7) { 
		$tttt = $ttttt;
		break;
	} else {
		$tttt = ereg_replace($pattern, $replace, $tttt);
		$ttttt = $tttt;
	}
}

$pattern = "\[([0-9]{1,3})\]";                   //смайлы
$replace = "<img src=images/smiles/\\1.gif>";
$tttt = ereg_replace($pattern, $replace, $tttt);

if (isset($_SESSION["id_r"]))
{
	$c_id_r = $_SESSION["id_r"];
	if($c_id_r==1){
		$delete = "<a href=#><img src='images/delete.png' title='Удалить'></a>";
		$edit = "<a href=#><img src='images/edit.png' title='Редактировать'></a>";
    } else {
		$delete = "";
		$edit = "";
	}
} else {
	$delete = "";
	$edit = "";
}

if (strlen($author[0])>11) {
	$l = strlen($author[0])-8;
	$author[0]=substr_replace($author[0], "...", 8, $l);
} 

printf("
<table width='590' class='table_msg' cellspacing='0'>
  <tr>
    <td rowspan='2' valign='top' align='left' class='l_msg'>%s</td>
    <td class='msg_t_b'><span class='time_msg'>%s</span><div class='msg_head'><a href='%s' class='b_quote' code_msg='%s' author='%s'><img src='images/quote.png' title='Цитировать'></a>%s%s</td>
	
  </tr>
  <tr>
    <td width='450' height='150' valign='top' class='txt_msg'><div class='msg_txt_div'>%s</div></td>
  </tr>
  <tr>
    <td align='center'><a href='#up' id='theme_up'>В начало</a></td>
    <td class='t_msg_buttom'><a href='#'><img src='images/profile.png' title='Профиль'></a><a href='#'><img src='images/msg.png' title='ЛС'></a></td>
  </tr>
</table>", $author['0'], $msg['d_msg'], $msg['id_msg'], $msg['text_msg'], $author['0'], $edit, $delete, $tttt);
}
?>
<input name="id_t" type="hidden" value="<?php echo $id_t; ?>" id="id_t">
<input name="n_u_f" type="hidden" value="<?php echo $n_u_f; ?>" id="n_u_f">
<input name="pidforum" type="hidden" value="<?php echo $p_id_forum; ?>" id="pidforum">
<div id="pages2">Страницы: <?php echo $str_num_page; ?></div>
<div id="msg_div">
<center>
<!--<a id="new_msg">
Написать сообщение
</a> -->
<div id="div_new_msg">
<span id="toolbar" class="ui-widget-header ui-corner-all">
<button id="b_smiles">Смайлики</button>
<button> U </button>
<button> I </button>
<button> B </button>
<button> Спойлер </button>
</span>
<div id="smiles_div" title="Смайлики">
</div>
<br />
<textarea name="text_message" cols="50" rows="5" id='text_message'></textarea> <br /> <br />
<?php printf("<input name='theme_id' id='theme_id' type='hidden' value='%s'>", $id_t); ?>
<button id="send_msg">Отправить</button> <button id="b_prewiev_msg">Предв. просмотр</button> <br>
</div>
</center>
</div>
</div>
<script type="text/javascript"> 
odd_element(); 
open_txtarea();
forum_refresh();
toolbar(); 
select_page();
podforum_refresh();
quote();
</script>