<?php 
include "bd.php";
$result = mysql_query("SELECT * FROM forums");
?>
<div id="forum">
<div class="forum_header">
	<a href='#' class="forum_refresh">Список форумов</a>
</div>

<?php 
	while ($myrow = mysql_fetch_array($result)) {
		$id_forum = $myrow["id_forum"];
		$result2 = mysql_query("SELECT * FROM under_forums WHERE `id_forum` = '$id_forum'");
		echo "<div class='forums'><img src='images/Plus.png'> ", $myrow['forum_name'], "</div>", "<div class='podforums'>" ; 
		
		while ($myrow2 = mysql_fetch_array($result2)) {
			echo "<div id='", $myrow2['id_u_forum'], "'>", $myrow2['name_u_forum'], "</div>";	
		}
		echo "</div>";
	}
?> 
</div>
<script type="text/javascript"> 
	slide_forums(); 
	click_forum ();
	forum_refresh();
</script>