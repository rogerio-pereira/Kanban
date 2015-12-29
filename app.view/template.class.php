<?php

/*	
	Classe template
	Exibe o template principal

	Sistema:	Kanban
	Autor: 		Rogério Eduardo Pereira
	Data: 		22/08/2014
*/
class template
{
	/*
		Variaveis
	*/


	/*
		Método construtor
	*/
	public function __construct()
	{
		new session();
        
		if(!isset($_SESSION['usuario']))
		{
			echo "
				<script>
					top.location='../?class=login';
				</script>
			";
		}
	}


	/*
		Método show
		Exibe as informações da página
	*/
	public function show()
	{
	?>
		<!DOCTYPE HTML>
		<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
			<head>
				<title>		Kanban 		</title>
			
				<!--Meta Tags-->
				<meta name="description" content=	"">
				<meta name="keywords" content=	"">
				<meta charset='UTF-8' />
				
				<!--FavIcon-->
				<link rel="shortcut icon" type="image/x-icon" href="app.view/img/favicon.ico"/>
				
				<!--Acentos-->
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				
				<!--Fontes-->
				
				<!--CSS-->
				<link rel="stylesheet" href="app.view/css/template.css">
				<link rel="stylesheet" href="app.view/css/menu.css">
				<link rel="stylesheet" href="app.view/css/kanban.css">
				<link rel="stylesheet" href="app.view/css/colorbox.css">
				<link rel="stylesheet" href="app.view/css/formulario.css">
				<link rel="stylesheet" href="app.view/css/tarefa.css">
				<link rel="stylesheet" href="app.view/css/situacao.css">
				
				<!--JQuery-->
				<script type="text/javascript" src="app.view/js/jquery.js"></script>
				<script type="text/javascript" src="app.view/js/jquery.colorbox.js"></script>
				
				<!--JavaScript-->
				<script type="text/javascript" src="app.view/js/popup.js"></script>
				<script type="text/javascript" src="app.view/js/kanban.js"></script>
				<script type="text/javascript" src="app.view/js/formulario.js"></script>
				<script type="text/javascript" src="app.view/js/tarefa.js"></script>
				<script type="text/javascript" src="app.view/js/situacao.js"></script>
				<script type="text/javascript" src="app.view/js/categoria.js"></script>
				<script type="text/javascript" src="app.view/js/usuario.js"></script>
				<script type="text/javascript" src="app.view/js/login.js"></script>
				<script type="text/javascript" src="app.view/js/alterarSenha.js"></script>
			</head>
			<body>
				<!--HEADER-->
				<header class='template_header'>
					<!--NAV-->
					<nav class='menu_principal'>
						<!--MENU-->
						<div id="mbmcpebul_wrapper" style="max-width: 354px;">
							<ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
							  	<li class="first_button">
							  		<div class="buttonbg gradient_button gradient40" style="width: 94px;">
							  			<div class="arrow">
							  				<a href="?class=kanban">Kanban<br /></a>
							  			</div>
							  		</div>
									<ul class="gradient_menu gradient29">
							    		<li class="gradient_menuitem gradient29 first_item last_item">
							    			<a href="?class=situacoes" title="">Situação</a>
							    		</li>
									</ul>
								</li>
							  	<li>
							  		<div class="buttonbg gradient_button gradient40">
							  			<div class="arrow">
											<a href='app.view/tarefa.class.php' class='ajax' title='Tarefa Nova'  onClick='toTop()'>
												Tarefas
											</a>
							  			</div>
							  		</div>
							    	<ul class="gradient_menu gradient29">
							    		<li class="gradient_menuitem gradient29 first_item last_item">
							    			<a href="?class=categorias" title="">Categoria</a>
							    		</li>
							    	</ul>
							    </li>
							  	<li>
							  		<div class="buttonbg gradient_button gradient40" style="width: 99px;">
							  			<div class="arrow">
							  				<a href="?class=usuarios">Usuarios<br /></a>
							  			</div>
							  		</div>
							    	<ul class="gradient_menu gradient29">
								    	<li class="gradient_menuitem gradient29 first_item last_item">
								    		<a href="?class=trocarSenha" title="">Trocar Senha</a>
								    	</li>
							    	</ul>
							    </li>
							  	<li class="last_button">
							  		<div class="buttonbg gradient_button gradient40" style="width: 70px;">
							  			<a href="?class=logoff" class="button_4">Logoff<br /></a>
							  		</div>
							  	</li>
							</ul>
						</div>
						<!--FIM MENU-->
					</nav>
				</header>

				<!--Section-->
				<section class='content'>
					#CONTENT#
				</section>

				<!--Footer-->
				<footer class='rodape'>
					<span>&copy; Copyright 2014 - Rogério Eduardo Pereira</span>
				</footer>
			</body>
		</html>
	<?php
	}
}
?>