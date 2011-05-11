$(document).ready(function() {
	
}); //End of Ready

function run_button() {
$("#user_menu li a").click(function(stopLink){
		stopLink.preventDefault();
		var at = $(this).attr('href');
		$("#right_div").load(at);
		$('#main_page').html("<li><a href='start.php' id='start_page'>Главная</a></li><script>run_button();</script>");
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
		$('#main_page').html("<li><a href='start.php' id='start_page'>Главная</a></li><script>run_button();</script>");
	});
	
	$('#bexit').click(function(){
		$('#first_left').hide('slide', 200);
		$('#first_left').load('exit.php', function(){
			$('#first_left').load('enter_menu.php', function(){
				$('#first_left').show('slide', 200);
				$('#right_div').load('start.php');
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
