/*  
  JS categoria
  JavaScript pré-processamento do formulario usuarios.class.php e usuario.class.php

  Sistema:  Kanban
  Autor:    Rogério Eduardo Pereira
  Data:     30/08/2014
*/
function novoUsuario()
{
	toTop();
	$.colorbox({ 
					href: 'app.view/usuario.class.php',
					'ajax':true, 
					'title':'Novo Usuário',
					'width':'300px'});
}

function alteraUsuario()
{
	toTop();
	var codigo = $('input[name=radioUsuario]:checked').val();
	
	$.colorbox({ 
					href: 'app.view/usuario.class.php?codigo='+codigo,
					'ajax':true, 
					'title':'Alterar Usuario '+codigo,
					'width':'300px'});
}

function validaUsuario()
{
	var valida;
	valida = true;
	
	if ($('#nome').val() == '')
	{
		alert('Digite um nome');
		$('#nome').focus();
		return;
	}
	else if ($('#usuario').val() == '')
	{
		alert('Digite um login');
		$('#usuario').focus();
		return;
	}
	else if($('#codigo').val() == '')
	{
		if ($('#senha').val() == '')
		{
			alert('Digite uma Senha');
			$('#senha').focus();
			return;
		}
	}
	
	if (valida = true)
		salvarUsuario();		
}

function salvarUsuario()
{
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigo:		$('#codigo').val(),
			nome:		$('#nome').val(),
			usuario:	$('#usuario').val(),
			senha:		$('#senha').val(),
			cor:		$('#cor').val(),
			action:		'salvarUsuario'
		},
		success: function(data) 
		{
			top.location='?class=usuarios';
		}
	});
}