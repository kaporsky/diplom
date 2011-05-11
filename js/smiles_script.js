function InsertTextarea(startdata, enddata, textarea) { 
 r = document.getElementById(textarea); 
 if (!r) { 
 alert("Error in set text! No message window.."); 
 } 
 else 
 { 
 r.focus(); 
 var r = document.selection.createRange(); 
 r.text= startdata + r.text + enddata; 
 r.select(); 
 } 
}

function select_smile() {
	$('#smiles_div img').click(function(){
		var s_id = $(this).attr('id');
		InsertTextarea("", "*s_id", "text_message");
	});
}