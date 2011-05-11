<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
session_start();
include("class.upload_0.31/class.upload.php");
$handle = new upload($_FILES['avatara'], 'ru_RU');
if ($handle->uploaded){
    $handle->file_new_name_body   = $_SESSION['id_u'];
    $handle->image_resize         = true;
    $handle->image_x              = 100;
    $handle->image_y              = 100;
    $handle->image_min_width      = 50;
    $handle->image_min_height     = 50;
    $handle->file_max_size        = 1024*50;
    $handle->image_convert        = 'jpg';
    $handle->jpeg_quality         = 90;
    $handle->file_overwrite       = true;
    $handle->process($_SERVER['DOCUMENT_ROOT'].'images/user_avatars/');
    if ($handle->processed) {
        $handle->clean();
    }else{
        echo '<h1><font color="#cc0000">error</font></h1>' . $handle->error;
    };
};
?>
</body>
</html>
