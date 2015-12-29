<?php

/*
 * 	Classe  usuarios
 * 	Exibe todas os usuarios, opções para alterar, cadastrar
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Sep 1, 2014
 */

/*
 * Classe usuarios
 */
class usuarios
{
	/*
	 * Variaveis
	 */
	private $collectionUsuario;
	private $controlador;

	/*
	 * Método construtor
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
		else
		{
			$this->controlador			= new controladorUsuario();
			$this->collectionUsuario	= $this->controlador->getUsuarios();
		}
	}
	
	/*
	 * Método show
	 * Exibe as informações na tela
	 */
	public function show()
	{
	?>
		<form 
			method='post' 
			class='formularioUsuarios' 
			id='formularioUsuarios'
			name="usuarios" 
			method="post" 
			action="app.control/ajax.php"
		>
			<input type="hidden" id="action" name="action"/>
				<fieldset>
					<legend>Usuarios</legend>
					<table class='tabela-usuarios'>
						<?php
							foreach ($this->collectionUsuario as $usuario)
							{
								echo
									"
										<!--{$usuario->nome}-->
										<tr>
											<td>
												<input type='radio' name='radioUsuario' id='radioUsuario' value='$usuario->codigo'>
											</td>
											<td>
												{$usuario->nome}
											</td>
											<td>
												{$usuario->usuario}
											</td>
											<td>
												<div style='background-color: {$usuario->cor}; width: 50px'>&nbsp;</div>
											</td>
										</tr>
									";
							}
						?>
						<tr>
							<td colspan='5'>
								<hr>
							</td>
						</tr>
						<tr>
							<td colspan='5' style='text-align: center'>
								<input type='button' value='Novo'		onclick='novoUsuario()'>
								<input type='button' value='Alterar'	onclick='alteraUsuario()'>
							</td>
						</tr>
					</table>
				</fieldset>
		</form>
	<?php
	}
}
?>