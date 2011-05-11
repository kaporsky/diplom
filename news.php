<script type="text/javascript"> select_news(); </script>
<div id="news" class="right">
<center> <h3> Новости </h3> </center>
<?php 
include("bd.php");
$r = mysql_query("SELECT * FROM news ORDER BY `id_news` DESC", $db);
while ($n = mysql_fetch_array($r)) {
$id_a = $n["id_u"];
$q_a = mysql_query("SELECT login FROM users WHERE `id_u`='$id_a' ", $db);
$author = mysql_fetch_array($q_a);
printf("
<table id='%s'>
<tr>
<td>", $n["id_news"]);
if(isset($n["img_news"]) && $n["img_news"]!="") {
printf("<img src='%s'>", $n["img_news"]); }
printf(" 
<h4> %s </h4> <br>
%s <br />
<p id='news_author'>Автор: %s<p>
</td>
</tr>
</table>", $n["name_news"], $n["title_news"], $author["login"]);
}
?>
</div>