<div id="select_news" class="right">
<?php 
include("bd.php");
$id_news = $_POST["id_post_news"];

$res = mysql_query("SELECT * FROM news WHERE id_news='$id_news'");
$n = mysql_fetch_array($res);
$id_a = $n["id_u"];
$q_a = mysql_query("SELECT login FROM users WHERE `id_u`='$id_a' ", $db);
$author = mysql_fetch_array($q_a);

echo "
<table border='0'>
  <tr>
    <td>";
	if(isset($n["img_news"]) && $n["img_news"]!="") { 
	printf ("
	<img src='%s' vspace=0 hspace=0>", $n["img_news"]); } 
	printf ("
	<h4> %s </h4>
%s 
<p id='news_author'>Автор: %s</p>
	</td>
  </tr>
</table>
", $n["name_news"], $n["text_news"], $author["login"]);

?>
</div>