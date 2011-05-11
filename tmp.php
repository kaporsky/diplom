<link href="css/styles.css" rel="stylesheet" type="text/css" />
<?php 
include("bd.php");    //цитата с именем
$tttt = "[quote=sdd][quote=sdd][quote=sdd][quote=a][quote=assd][quote=kacnep]asdasda[/quote][/quote][/quote][/quote][/quote][/quote]";

$pattern = "\[quote=([^]]*)\](.*)\[/quote\]";
$replace = "<b>\\1 писал(а):</b> <br><div class='quote_div'>\\2 </div>";

echo $tttt, "<br> <br> <br> <br>";

$pattern = "\[quote=([^]]*)\](.*)\[/quote\]";
$replace = "<b>\\1 писал(а):</b> <br><div class='quote_div'>\\2 </div>";
$r=0;
while (ereg($pattern, $tttt, $regs)) {
	if ($r<=5) {
		$r++;
		$b='true';
	} else {
		$b='false';
		break;
	}
}

 ?>
 
 
