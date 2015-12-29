/*  
  JS alterarSenha
  JavaScript pré-processamento do formulario tarefa.class.php

  Sistema:  Kanban
  Autor:    Rogério Eduardo Pereira
  Data:     03/09/2014
*/

function validaAlterarSenha()
{
	var valida;
	valida = true;
	
	if ($('#senhaAtual').val() == '')
	{
		alert('Digite a Senha Atual!');
		$('#senhaAtual').focus();
		return;
	}
	else if ($('#senhaNova').val() !=  $('#confirmacao').val())
	{
		alert('Senha nova diferente da Confirmação!');
		
		$('#senhaNova').val('');
		$('#confirmacao').val('');
		
		$('#senhaNova').focus();
		
		return;
	}
	
	if (valida = true)
		alterarSenha();		
}

function alterarSenha()
{
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			senhaAtual:	$('#senhaAtual').val(),
			senhaNova:	$('#senhaNova').val(),
			action:		'alteraSenha'
		},
		success: function(data) 
		{
			$('.retorno').html(data);
			top.location='?class=kanban';
		}
	});
}
