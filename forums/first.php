<?php 
include("../bd.php");
$result = mysql_query("SELECT * FROM themes");
?>
<div class="right">
<center> Первый подфорум </center>
<table id='table_themes' align="center">
<tr id='header_themes'>
	<td id='name_themes'>Название темы</td>
	<td id='author_themes'>Автор</td>
	<td id='messages'>Сообщ.</td>
	<td id='last_msg'>Посл. сообщ.</td>
</tr>
<?php
while ($m = mysql_fetch_array($result)) {
	$author_id = $m['id_u'];
	$t = mysql_query("SELECT login FROM users WHERE `id_u`='$author_id'");
	$m_author = mysql_fetch_row($t);
	$author = $m_author[0];
	
	$last_u_id = $m['last_id_u'];
	$t = mysql_query("SELECT login FROM users WHERE `id_u`='$last_u_id'");
	$m_last_message = mysql_fetch_row($t);
	$last_message = $m_last_message[0];
	
	printf("
		  <tr>
			<td id='t_themes_1'>%s</td>
			<td id='t_themes_2'>%s</td>
			<td id='t_themes_3'>%s</td>
			<td id='t_themes_4'>%s</td>
		  </tr>", $m['name_theme'], $author, $m['message_count'], $last_message);
}
?>
</table>

<div>