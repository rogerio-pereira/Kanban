<?php header("Content-Type:text/html; charset=UTF-8",true) ?>

<?php

/*
 * 	Classe  usuario
 * 	Formulario para cadastro/Alteração de Usuario
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Sep 1, 2014
 */

error_reporting(E_WARNING);

/*
 *  Funcao Autoload
 *  Carraga a classe quando for instanciada
 */
function __autoload($classe)
{
    $pastas = array('../app.widgets', '../app.ado', '../app.config', '../app.model', '../app.control','../app.view');
    foreach ($pastas as $pasta)
    {
        if (file_exists("{$pasta}/{$classe}.class.php"))
        {
            include_once "{$pasta}/{$classe}.class.php";
        }
    }
}

/*
 * Classe usuario
 */
class usuario
{
	/*
	 * Variaveis
	 */
	private $codigo;
	private $usuario;
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
			$this->codigo				= $_GET['codigo'];
		
			$this->controlador	= new controladorUsuario();
			$this->usuario		= $this->controlador->getUsuario2($this->codigo);
			$this->show();
		}
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
					<meta charset='UTF-8' />						
				</head>
				<body>
					<form 
						method='post' 
						class='formularioUsuario' 
						id='formularioUsuarios'
						name="usuario" 
						method="post" 
						action="app.control/ajax.php"
					>
						<input type="hidden" id="action" name="action"/>
						<fieldset>
							<legend>Usuario</legend>
							<table>
								<!--Nome-->
								<tr>
									<td class='obrigatorio'>
										<label for='nome'>Nome</label>
									</td>
									<td colspan='2'>
										<input 
											type='text' 
											id='nome' 
											name='nome' 
											maxlength='100' 
											placeholder='Nome do Usuario' 
											value='<?php echo $this->usuario->nome; ?>'
										>	
									</td>
								</tr>
								<!--Codigo-->
								<tr>
									<td width='15%'>
										<label for='codigo'>Código:</label>
									</td>
									<td>
										<input 
											type='number' 
											name='codigo' 
											id='codigo' 
											min='1' 
											max='18446744073709551615' 
											readonly
											placeholder="NOVO"
											value='<?php echo $this->usuario->codigo; ?>'
										>
									</td>
								</tr>
								<!--Usuario-->
								<tr>
									<td class='obrigatorio'>
										<label for='usuario'>Usuario</label>
									</td>
									<td colspan='2'>
										<input 
											type='text' 
											id='usuario' 
											name='usuario' 
											maxlength='15' 
											placeholder='Login do Usuário' 
											value='<?php echo $this->usuario->nome; ?>'
										>	
									</td>
								</tr>
								<?php
									if($this->codigo == NULL)
									{
										echo 
											"
												<!--Senha-->
												<tr>
													<td class='obrigatorio'>
														<label for='senha'>Senha</label>
													</td>
													<td colspan='2'>
														<input 
															type='password' 
															id='senha' 
															name='senha' 
															placeholder='Senha do Usuário' 
														>	
													</td>
												</tr>
											";
									}
								?>
								<!--Cor-->
								<tr>
									<td>
										<label for='cor'>Cor</label>
									</td>
									<td colspan='2'>
										<input 
											type='color' 
											name='cor' 
											id='cor'
											value='<?php echo $this->usuario->cor; ?>'
										>
									</td>
								</tr>
								<tr>
									<td colspan='2' style='text-align: center'>
										<input type='button' value='Salvar'	onclick='validaUsuario()'>
									</td>
								</tr>
							</table>
						</fieldset>
					</form>
			</body>
		</html>
		<?php
	}
}

new usuario;
?>