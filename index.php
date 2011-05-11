<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<a name="up"></a>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Диплом</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script> 
<script type="text/javascript" src="js/scripts.js"></script> 

</head>

<body>
<div id="main_div">

<script type="text/javascript"> 
	click_logo(); 
</script>


<div id="header">	
	<img src="images/logo.jpg"></div>

<div id="menu">
	<script type="text/javascript"> 
		$('#menu').load('menu.php');
    </script>   
</div>
<br />

<div id="left_div">
	
    <div id="for_height">	
        <div id="first_left">
        <?php include("check_autorization.php"); ?>   
        </div>	
	</div>
        
    <div id="second_left">
    	<script type="text/javascript"> 
		$('#second_left').load('last_news.php');
   		</script>   	
    </div>
</div>

<div id="right_div">
	<script type="text/javascript"> 
		$('#right_div').load('start.php');
    </script>   	
</div>
</div>
</body>
</html>
