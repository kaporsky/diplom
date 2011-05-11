<script type="text/javascript"> click_theme(); </script>
<?php 
include("../bd.php");
$p_id_forum = $_POST["id_forum"];

$nf = mysql_query("SELECT name_u_forum FROM under_forums WHERE `id_u_forum` = '$p_id_forum'");
$name_u_f = mysql_fetch_row($nf);
$result = mysql_query("SELECT * FROM themes WHERE `id_u_forum` = '$p_id_forum'");
?>
<div class="forum_header"><a href='#' class="forum_refresh">Список форумов</a> → <?php echo "<a href='#'>", $name_u_f[0],"</a>"; ?> </div>
<table id='table_themes' align="center" width="570">
<tr id='header_themes' height="20">
	<td id='name_themes'>Название темы</td>
	<td id='author_themes'>Автор</td>
	<td id='messages'>Сообщ.</td>
	<td id='last_msg' width="100">Посл. сообщ.</td>
</tr>
<?php
while ($m = mysql_fetch_array($result)) {
	$author_id = $m['id_u'];
	$t = mysql_query("SELECT login FROM users WHERE `id_u`='$author_id'");
	$m_author = mysql_fetch_row($t);
	$author = $m_author[0];
	
	/* $last_u_id = $m['last_id_u'];
	$t = mysql_query("SELECT login FROM users WHERE `id_u`='$last_u_id'");
	$m_last_message = mysql_fetch_row($t);
	$last_message = $m_last_message[0]; */
	$id_t = $m['id_theme'];
	$zlu = mysql_query("SELECT id_u FROM msg_themes WHERE `id_theme`='$id_t' ORDER BY `id_msg` DESC LIMIT 1", $db);
	$alm = mysql_fetch_row($zlu);
	$last_u_id = $alm[0];
	$t = mysql_query("SELECT login FROM users WHERE `id_u`='$last_u_id'");
	$m_last_message = mysql_fetch_row($t);
	$last_message = $m_last_message[0];
		
	$rr = mysql_query("SELECT * FROM msg_themes WHERE `id_theme`='$id_t'");
	$count_msg = mysql_num_rows($rr);
	
	printf("
		  <tr>
			<td id='t_themes_1'><a href='%s'>%s</a></td>
			<td id='t_themes_2'>%s</td>
			<td id='t_themes_3'>%s</td>
			<td id='t_themes_4'>%s</td>
		  </tr>", $id_t, $m['name_theme'], $author, $count_msg, $last_message);
}
?>
</table>
<input name="name_theme" id="id_n_t" type="hidden" value="<?php echo $name_u_f[0]; ?>">
<input name="pidforum" type="hidden" value="<?php echo $p_id_forum; ?>" id="pidforum">
<script type="text/javascript"> 
forum_refresh(); 
podforum_refresh();
</script>