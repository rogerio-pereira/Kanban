<?php header("Content-Type:text/html; charset=UTF-8",true) ?>

<?php

/*
 * 	Classe  situacao
 * Formulario para cadastro/Alteração de Situações
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
 * Classe situacao
 */
class situacao
{
	/*
	 * Variaveis
	 */
	private $codigo;
	private $situacao;
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
			$codigo				= $_GET['codigo'];
		
			$this->controlador	= new controladorSituacao;
			$this->situacao		= $this->controlador->getSituacao2($codigo);
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
						class='formularioSituacao' 
						id='formularioSituacao'
						name="situacao" 
						method="post" 
						action="app.control/ajax.php"
					>
						<input type="hidden" id="action" name="action"/>
						<fieldset>
							<legend>Situação</legend>
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
											maxlength='25' 
											placeholder='Nome da Situação' 
											value='<?php echo $this->situacao->nome; ?>'
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
											value='<?php echo $this->situacao->codigo; ?>'
										>
									</td>
								</tr>
								<!--Ordem-->
								<tr>
									<td>
										<label for='ordem'>Ordem</label>
									</td>
									<td colspan='2'>
										<input 
											type='number' 
											name='ordem' 
											id='ordem' 
											min='1' 
											placeholder="Ordem no Kanban"
											value='<?php echo $this->situacao->ordem; ?>'
										>
									</td>
								</tr>
								<tr>
									<td colspan='2' style='text-align: center'>
										<input type='button' value='Salvar'	onclick='validaSituacao()'>
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

new situacao();
?>