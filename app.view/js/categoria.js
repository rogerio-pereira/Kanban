/*  
  JS categoria
  JavaScript pré-processamento do formulario categorias.class.php e categoria.class.php

  Sistema:  Kanban
  Autor:    Rogério Eduardo Pereira
  Data:     30/08/2014
*/
function novaCategoria()
{
	toTop();
	$.colorbox({ 
					href: 'app.view/categoria.class.php',
					'ajax':true, 
					'title':'Nova Categoria',
					'width':'300px'});
}

function alteraCategoria()
{
	toTop();
	var codigo = $('input[name=radioCategoria]:checked').val();
	
	$.colorbox({ 
					href: 'app.view/categoria.class.php?codigo='+codigo,
					'ajax':true, 
					'title':'Alterar Categoria '+codigo,
					'width':'300px'});
}

function validaCategoria()
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
		salvarCategoria();		
}

function salvarCategoria()
{
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigo:		$('#codigo').val(),
			nome:		$('#nome').val(),
			cor:		$('#cor').val(),
			action:		'salvarCategoria'
		},
		success: function(data) 
		{
			top.location='?class=categorias';
		}
	});
}

function apagaCategorias()
{
	var arrCod = [];
	$(".chkCategoriasApagar:checked").each(function() {
		arrCod.push($(this).val());
	});
	
	$.ajax
	({
		type: "POST",
		url: "app.control/ajax.php",
		data: 
		{
			codigos:		arrCod,
			action:		'apagaCategorias'
		},
		success: function(data) 
		{
			$('.tabela-categorias').html(data);
			alert('As tarefas que estavam nas categorias apagadas agora estão sem catogoria');
		}
	});	
}