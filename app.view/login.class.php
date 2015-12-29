<?php

/*
 * 	Classe  login
 * 	#RESUMO DA CLASSE#
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Sep 1, 2014
 */

/*
 * Classe login
 */
class login
{
	/*
	 * Variaveis
	 */

	/*
	 * Método construtor
	 */
	public function __construct()
	{
		new session();
	}
	/*
	 * Método show
	 * Exibe as informações na tela
	 */
	public function show()
	{
	?>
	<!DOCTYPE HTML>
		<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
			<head>
				<title>
					Kanban - Login
				</title>
			
				<!--FavIcon-->
				<link rel="shortcut icon" type="image/x-icon" href="app.view/img/favicon.ico"/>
				
				<!--Acentos-->
				<meta http-equiv="content-type" content="text/html; charset=utf-8" />
				
				<!--Fontes-->
				
				<!--CSS-->
				<link rel="stylesheet" href="app.view/css/formulario.css">
				<link rel="stylesheet" href="app.view/css/login.css">
					
				<!--JQuery-->
				<script type="text/javascript" src="app.view/js/jquery.js"></script>
				
				<!--JavaScript-->
				<script type="text/javascript" src="app.view/js/login.js"></script>
			</head>
			<body>
				<div class='contentLogin'>
					<form 
						class="loginForm"
						name="login"
						id="login"
						method="post"
					>
						<h1>Login</h1>
						<input 
							type='text' 
							id='usuario' 
							name='usuario'  
							placeholder='Login' 
						><br>
						<input 
							type='password' 
							id='senha' 
							name='senha' 
							placeholder='Senha'
						>	<br><br>
						<input type="hidden" id="action" name="action"/>
						<input name='botaoLogin' type='button' id='botaoLogin' value='Login' onclick='executaLogin()'/>
					  </form>
				</div>
			</body>
		</html>
		<?php
	}
}
?>