/*  
  JS situacao
  JavaScript pré-processamento do formulario situacoes.class.php e situacao.class.php

  Sistema:  Kanban
  Autor:    Rogério Eduardo Pereira
  Data:     30/08/2014
*/
//Insere Subtarefas
function novaSituacao()
{
	toTop();
	$.colorbox({ 
					href: 'app.view/situacao.class.php',
					'ajax':true, 
					'title':'Nova Situação',
					'width':'300px'});
}

function alteraSituacao()
{
	toTop();
	var codigo = $('input[name=radioSituacao]:checked').val();
	
	$.colorbox({ 
					href: 'app.view/situacao.class.php?codigo='+codigo,
					'ajax':true, 
					'title':'Alterar Situação '+codigo,
					'width':'300px'});
}

function validaSituacao()
{
	var valida;
	valida = true;
	
	if ($('#nome').val() == '')
	{
		alert('Digite um nome');
		$('#nome').focus();
		return;
	}
	
	if (valida = true)
		salvarSituacao();		
}

function salvarSituacao()
{
	alert("dasdads");
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigo:		$('#codigo').val(),
			nome:		$('#nome').val(),
			ordem:		$('#ordem').val(),
			action:		'salvarSituacao'
		},
		success: function(data) 
		{
			top.location='?class=situacoes';
		}
	});
}

function apagaSituacoes()
{
	var arrCod = [];
	$(".chkSituacoesApagar:checked").each(function() {
		arrCod.push($(this).val());
	});
	
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigos:		arrCod,
			action:		'apagaSituacoes'
		},
		success: function(data) 
		{
			$('.tabela-situacoes').html(data);
			alert('Se alguma situação não foi apagada é porque existem tarefas nela!');
		}
	});	
}