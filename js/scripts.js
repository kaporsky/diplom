$(document).ready(function() {
	
}); //End of Ready

function run_button() {
$("#user_menu li a").click(function(stopLink){
		stopLink.preventDefault();
		var at = $(this).attr('href');
		//$("#right_div").load(at);
		window.location.hash = at;
		$("#right_div").load(at);	
		
	/*	$('#main_page').html("<li><a href='start.php' id='start_page'>Главная</a></li><script>run_button();</script>"); */
	});
}

function load_page() {
	var pg = window.location.hash;
	var pg = pg.replace('#','');
	if(pg=='') {
		$('#right_div').load('start.php');	
	} else {
		$.get(pg, function(p){
			$('#right_div').html('').prepend(p);									
		})
	}
}


function links_for_get() {
	$('a').click(function(stopLink){
		stopLink.preventDefault();
		var hr = $(this).attr('href');
		window.location.hash = hr;
		$.get(hr, function(p){
			$('#right_div').html('').prepend(p);									
		});
		
	});
}

//----------------------------------------function var button for enter menu---------------------------------

function var_button() {
	$('#benter').button();
	$('#remember').button({
		icons: {
			primary: "ui-icon-disk"
		},
		text: false
	});	
}
//-------------------------------------------------------------------------------------------------------------

//------------------------------------------------Button for profile_menu--------------------------------------
function button_profile() {
	$('#bexit').button();
	$('a').click(function(stopLink){
		stopLink.preventDefault();
		var l = $(this).attr('href');
		$('#right_div').load(l);
		/*$('#main_page').html("<li><a href='start.php' id='start_page'>Главная</a></li><script>run_button();</script>");*/
	});
	
	$('#bexit').click(function(){
		$('#first_left').hide('slide', 200);
		$('#first_left').load('exit.php', function(){
			$('#first_left').load('enter_menu.php', function(){
				$('#first_left').show('slide', 200);
				$('#right_div').load('start.php');
				$('#menu').load('menu.php');
			});										   
		});						   
	});
}
//-------------------------------------------------------------------------------------------------------------

//-----------------------------------------Function for click Enter---------------------------------------------
function click_enter() {
	$('#benter').click(function(){
		$('#first_left').hide('slide',200, function(){
			var lo = $('#login').attr('value');
			var pas = $('#password').attr('value');
			var r = $('#remember').attr('checked');
			$.post('enter.php', {login:lo, password:pas, remember:r}, function(data){
				$('#main_div').prepend(data);														   
			});
		});
	});
}
//----------------------------------------------------------------------------------------------------------------

//--------------------------------------------Dialog Autorization Error---------------------------------------
function error_autorization() {
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$('#main_div').append('<div id=\"dialog-message\" title=\"Ошибка авторизации!\"><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 20px 0;\"></span> Логин и/или пароль не верны! <br> <br> Проверьте правильность ввода логина и пароля и повторите попытку еще раз. </div>');
	
	$( '#dialog:ui-dialog' ).dialog( 'destroy' );			
	$( '#dialog-message' ).dialog({
					minWidth: 450,
					resizable: false,
					modal: true,
					buttons: {
						Ok: function() {
							$('#login, #password').attr('value', "");
							$( this ).dialog( 'close' );
							$('#first_left').show('slide', 200);
						}
					}
	});
}
//--------------------------------------------------------------------------------------------------------------

//--------------------------------------------Dialog error edit password----------------------------------------

//--------------------------------------------------------------------------------------------------------------

//----------------------------------------------function enter--------------------------------------------------
function enter() {
	$('#first_left').load('profile_menu.php', function(){
			$(this).show('slide', 200);											   
		});
	
}
//--------------------------------------------------------------------------------------------------------------

//-----------------------------------------------Button Edit Password-------------------------------------------
function b_edit_pass() {
	$('#button_pass').button();
	$('#edit_pass').hide(0);
	$('#b_edit_pass').toggle(function(){
		$('#edit_pass').slideDown(500);
	},
	function(){
		$('#edit_pass').slideUp(500);	
	});
	
	$('#button_pass').click(function(){
		var oldpass = $('#oldpass').attr('value');
		var newpass = $('#newpass').attr('value');
		var rnewpass = $('#rnewpass').attr('value');
		$.post('edit_pass.php', {op:oldpass, np:newpass, rnp:rnewpass}, function(data) {
			$('#main_div').prepend(data);																
		});
	});
}
//--------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------click_logo-----------------------------------------
function click_logo() {
	$('#header img').click(function(){	
		$('#right_div').load('start.php');
	});
}
//--------------------------------------------------------------------------------------------------------------


//--------------------------------------------------------select NEWS-------------------------------------------
function select_news() {
	
	$('#news table').click(function(){
		var t = $(this).attr('id');
		$.post("select_news.php", {id_post_news:t}, function(news){
		$('#right_div').html('').prepend(news);
		});
	});
	
}
//--------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------select last NEWS-------------------------------------------
function select_last_news() {
	
	$('#last_news div').click(function(){
		var t = $(this).attr('id');
		$.post("select_news.php", {id_post_news:t}, function(news){
		$('#right_div').html('').prepend(news);
		});
	});
	
}
//--------------------------------------------------------------------------------------------------------------

function slide_forums () {
	$('.podforums').hide(0);
	$('.forums').toggle(function(){
		$(this).children('img').attr('src','images/Minus.png');
		$(this).next('div').slideDown(500);
	},
	function(){
		$(this).children('img').attr('src','images/Plus.png');
		$(this).next('div').slideUp(500);	
	});
	
}

function click_forum () {
	$('.podforums').children('div').click(function(){
		var f = $(this).attr('id');
		$.post("forums/selected_forum.php", {id_forum:f}, function(forum){
			$('#right_div').html('').prepend(forum);
		});
	
	
	});
}

function click_theme () {
	$('#t_themes_1 a').click(function(stopLink){
		stopLink.preventDefault();	
		var t = $(this).attr('href');
		var name_u_f = $('#id_n_t').attr('value');
		var pidf = $('#pidforum').attr('value');
		$.post('forums/theme.php', {id_theme:t, n_u_f:name_u_f, id_forum:pidf}, function(theme){
			$('#right_div').html('').prepend(theme);
		});
	});
}

function open_txtarea () {
	$('#div_new_msg button').button();
	
	$('#send_msg').click(function(){
		var msg_txt = $('#text_message').attr('value');
		var theme_id = $('#theme_id').attr('value');
		var uf_id = $('#n_u_f').attr('value');
		$.post('forums/add_msg.php', {txt_msg:msg_txt, id_theme:theme_id, n_u_f:uf_id}, function(message){
			$('#right_div').html('').prepend(message);	
		});
	});
	
	$('#b_prewiev_msg').click(function(){
		var msg_txt = $('#text_message').attr('value');
		$.post('forums/preview_msg.php', {txt_msg:msg_txt}, function(message2){
			$('#right_div').html('').prepend(message2);	
		});
	});
}

function open_smiles() {
	$('#smiles_div').dialog({ position: 'top', width:580, height:520  }).load('forums/smiles.php');
}

function toolbar() {
	$('#b_smiles').click(function(){
		open_smiles();
	});
}


function insertAtCursor(myField, myValue) {   
  //  Для MSIE   
  if (document.selection) {   
    myField.focus();   
    sel = document.selection.createRange();   
    sel.text = myValue;   
  }   
  // Для нормальных браузеров   
  else if (myField.selectionStart || myField.selectionStart == '0') {   
    var startPos = myField.selectionStart;   
    var endPos = myField.selectionEnd;   
    myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);   
  }   
  // Для остальных ;)   
  else {   
    myField.value += myValue;   
  }   
}  

function select_smile() {
	$('#smiles_div > img').click(function(){
		var s_id = $(this).attr('id');
		var pole = document.getElementById('text_message');
		insertAtCursor(pole, "["+s_id+"]");
	});
}

function odd_element() {
	$('.table_msg:odd').attr('class','table_msg2');
}

function select_page() {
	$('.select_page').click(function(stopLink){
		stopLink.preventDefault();							 
		var page = $(this).attr('id');	
		var id_t1 = $('#id_t').attr('value');
		var n_u_f1 = $('#n_u_f').attr('value');
		var pidf = $('#pidforum').attr('value');
		$.post('forums/theme.php', {n_page:page, n_u_f:n_u_f1, id_theme:id_t1, id_forum:pidf}, function(page){
			$('#right_div').html('').prepend(page);	
		});
	});
}

function profile_tabs() {
	$('#profile_tabs').tabs();
}

function message_tabs() {
	$('#message_tabs').tabs();	
}


function post_return_theme() {
		var p = $('#r_n_page').attr('value');
		var idtr = $('#return_id_theme').attr('value');
		var ruf = $('#return_id_uf').attr('value');
		$.post('forums/theme.php', {n_page:p, id_theme:idtr, n_u_f:ruf}, function(page){
			$('#right_div').html('').prepend(page);	
		});
}

function return_theme() {

	t = setTimeout("post_return_theme()", 10000);

	
	$('#return_theme').click(function(stopLink){
		stopLink.preventDefault();
		b_return_t = 15;
		post_return_theme();
		clearTimeout(t);
	});
}

function forum_refresh() {
	$('.forum_refresh').click(function(stopLink){
		stopLink.preventDefault();
		$('#right_div').load('forum.php');
	});
}

function podforum_refresh() {
	$('#podforum_refresh').click(function(stopLink){
		stopLink.preventDefault();
		var pidf = $('#pidforum').attr('value');
		$.post('forums/selected_forum.php', {id_forum:pidf}, function(page){
			$('#right_div').html('').prepend(page);	
		});
	});
}

function quote() {
	$('.b_quote').click(function(stopLink){
		stopLink.preventDefault();
		var pole = document.getElementById('text_message');
		var code_m = $(this).attr('code_msg');
		var author = $(this).attr('author');
		insertAtCursor(pole, "[quote="+author+"]"+code_m+"[/quote]");
	});
}