/*  
  JS login
  JavaScript pré-processamento do formulario login.class.php

  Sistema:  Kanban
  Autor:    Rogério Eduardo Pereira
  Data:		Sep 1, 2014w
*/
function executaLogin()
{
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			usuario:	$('#usuario').val(),
			senha:		$('#senha').val(),
			action:		'login'
		},
		success: function(data) 
		{
			top.location='?class=kanban';
		}
	});
}