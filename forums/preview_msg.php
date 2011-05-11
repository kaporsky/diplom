<?php 
$text_msg = $_POST["txt_msg"];
?>
<div class="right">
<br />
<?php
printf("
<textarea name='text_msg' cols='50' rows='5'>
%s
</textarea>", $text_msg);
?>
</div>