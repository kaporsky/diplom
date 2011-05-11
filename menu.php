<script type="text/javascript" src="js/menu.js"> </script>
<script type="text/javascript"> run_button(); </script>
<?php 
	session_start();
	if (isset($_SESSION["id_r"])) {
	$id_r = $_SESSION["id_r"];
	}
?>
<div id="user_menu">
<ul id="jsddm">
	<div id="main_page"></div>
    <li><a href="news.php">Новости</a></li>
	<li><a href="forum.php">Форум</a></li>
	<li><a href="chat.php">Чат</a></li>
    
    
	<li><a href='cabinets.php'>Кабинеты преподавателей</a>
		<?php
		if (isset($id_r) and $id_r==3) {
		echo " 
        <ul>
			<li> <a href=''>Мой кабинет</a> </li>
		</ul>"; } ?>
	</li>
	
	<?php
	if (isset($id_r) and $id_r==1) {
	echo " 
	
	<li><a href='admin_panel.php'>Панель администратора</a>
		<ul>
			<li> <a href='users.php'>Пользователи</a> </li>
			<li> <a href='new_users'>Редактирование новостей</a> </li>
		</ul>
	</li>";
	}
	?>
</ul>
</div>