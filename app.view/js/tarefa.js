/*  
  JS tarefa
  JavaScript pré-processamento do formulario tarefa.class.php

  Sistema:  Kanban
  Autor:    Rogério Eduardo Pereira
  Data:     30/08/2014
*/

//Insere Subtarefas
function insereSubtarefa()
{
	if($('#codigo').val() != '')
	{
		$.ajax
		({
			type: "POST",
			url: "app.control/ajax.php",
			data: 
			{
				codigo : $('#codigo').val(),
				nomeSubtarefa:  prompt('Digite o nome da Subtarefa'),
				action: 'insereSubtarefa'
			},
			success: function(data) 
			{
				$('.tabela-subtarefas').html(data);
			}
		});
	}
	else
		alert('Salve primeiro a tarefa para depois inserir uma nova Subtarefa');
}

//Apaga Subtarefa
function apagaSubTarefa()
{
	var arrCod = [];
	$(".chkSubTarefa:checked").each(function() {
		arrCod.push($(this).val());
	});
	
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigo :			$('#codigo').val(),
			subTarefasApagar:	arrCod,
			action:				'apagaSubTarefa'
		},
		success: function(data) 
		{
			$('.tabela-subtarefas').html(data);
		}
	});
}

//salva Tarefa
function salvaTarefa()
{
	var arrCod = [];
	$(".subTarefaItem:checked").each(function() {
		arrCod.push($(this).val());
	});

	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigo:			$('#codigo').val(),
			nome:			$('#nome').val(),
			criacao:		$('#criacao').val(),
			categoria:		$('#categoria').val(),
			prioridade:		$('#prioridade').val(),
			link:			$('#link').val(),
			descricao:		$('#descricao').val(),
			situacao:		$('#situacao').val(),
			usuario:		$('#usuarioCombo').val(),
			dataInicio:		$('#dataInicio').val(),
			tempoEstimado:	$('#tempoEstimado').val(),
			dataConclusao:	$('#dataConclusao').val(),
			concluido:		$('#concluido').val(),
			subTarefaItem:	arrCod,
			action:			'salvarTarefa'
		},
		success: function(data) 
		{
			top.location='?class=kanban';
		}
	});
}

//Apaga Tarefa
function apagaTarefa()
{
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigo :			$('#codigo').val(),
			action:				'apagaTarefa'
		},
		success: function(data) 
		{
			top.location='?class=kanban';
		}
	});
}

function validaTarefa()
{
	var valida;
	valida = true;
	
	if ($('#nome').val() == '')
	{
		alert('Digite um nome');
		$('#nome').focus();
		return;
	}
	else if ($('#criacao').val() == '')
	{
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		
		if(dd<10){dd='0'+dd} 
		if(mm<10){mm='0'+mm} 
		today = yyyy+'-'+mm+'-'+dd;  
		
		$('#criacao').val(today);
	}
	else if($('#situacao').val() == '')
	{
		alert('Seleciona a situação');
		$('#situacao').focus();
		return;
	}
	
	if (valida = true)
		salvaTarefa();		
}