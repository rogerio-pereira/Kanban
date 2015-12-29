<?php header("Content-Type:text/html; charset=UTF-8",true) ?>

<?php
/*
 * 	Classe  tarefa
 * 	Pagina individual de cada tarefa
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Aug 28, 2014
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
 * Classe tarefa
 */
class tarefa
{
	/*
	 * Variaveis
	 */
	private $controladorTarefa;
	private $controladorSubtarefas;
	private $controladorUsuario;
	private $controladorCategoria;
	private $controladorSituacao;
	
	private $codigo;
	
	private $tarefa;
	private $collectionSubTarefa;
	private $usuario;
	private $categoria;
	
	private $collectionCategoria;
	private $collectionUsuario;
	private $collectionSituacao;

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
			$this->controladorTarefa		= new controladorTarefa();
			$this->controladorSubtarefas	= new controladorSubtarefa();
			$this->controladorCategoria		= new controladorCategoria();
			$this->controladorUsuario		= new controladorUsuario();
			$this->controladorSituacao		= new controladorSituacao();

			$this->codigo					= $_GET['cod'];

			$this->tarefa					= $this->controladorTarefa->getTarefa2($this->codigo);
			$this->collectionSubTarefa		= $this->controladorSubtarefas->getSubtarefas2($this->codigo);
			$this->categoria				= $this->controladorCategoria->getCategoria2($this->tarefa->categoria);
			$this->usuario					= $this->controladorUsuario->getUsuario2($this->tarefa->usuario);

			$this->collectionCategoria		= $this->controladorCategoria->getCategorias2();
			$this->collectionSituacao		= $this->controladorSituacao->getSituacoes2();
			$this->collectionUsuario		= $this->controladorUsuario->getUsuarios2();

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
					class='formularioTarefa' 
					id='formularioTarefa'
					name="Tarefa" 
					method="post" 
					action="app.control/ajax.php"
				>
					<input type="hidden" id="action" name="action"/>
					<input type="hidden" id="subTarefaCod" name="subTarefaCod"/>
					<!--Seção Tarefas-->
					<fieldset id='tarefa'>
						<legend>Tarefa</legend>
						<table class='tabela-tarefa'>
							<!--Titulo-->
							<tr>
								<td colspan='2'>
									<input 
										type='text' 
										id='nome' 
										name='nome' 
										maxlength='50' 
										placeholder='Nome da Tarefa' 
										value='<?php echo $this->tarefa->nome; ?>'
									>	
								</td>
							</tr>
							<!--Codigo-->
							<tr>
								<td width='35%'>
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
										value='<?php echo $this->tarefa->codigo; ?>'
									>
								</td>
							</tr>
							<!--Criação-->
							<tr>
								<td class='obrigatorio'>
									<label for='criacao'>Criação:</label>
								</td>
								<td>
									<input 
										type='date' 
										name='criacao' 
										id='criacao'
										placeholder="Data de Criação"
										value="<?php echo $this->tarefa->criacao; ?>"
									>
								</td>
							</tr>
							<!--Categoria-->
							<tr>
								<td>
									<label for='categoria'>Categoria:</label>
								</td>
								<td>
									<select name='categoria' id='categoria'>
										<option value='' disabled selected>Selecione uma Categoria</option>
										<option value="" ></option>
										<?php
											foreach ($this->collectionCategoria as $categoria)
											{
												if($this->tarefa->categoria == $categoria->codigo)
													echo "<option value='{$categoria->codigo}' selected>{$categoria->nome}</option>";
												else
													echo "<option value='{$categoria->codigo}'>{$categoria->nome}</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<!--Prioridade-->
							<tr>
								<td>
									<label for='prioridade'>Prioridade:</label>
								</td>
								<td>
									Baixa 
										<input 
											type='range' 
											name='prioridade' 
											id='prioridade' 
											min='1' 
											max='3'  
											step='1' 
											value='<?php echo $this->tarefa->prioridade; ?>'
										> 
										Alta
								</td>
							</tr>
							<!--LINK-->
							<tr>
								<td>
									<label for='link'>Link</label>
								</td>
								<td>
									<input 
										type='url' 
										name='link' 
										id='link' 
										maxlength='100' 
										placeholder='Link' 
										value='<?php echo $this->tarefa->link; ?>'
									>
								</td>
							</tr>
							<!--Situação-->
							<tr>
								<td class='obrigatorio'>
									<label for='situacao'>Situação</label>
								</td>
								<td>
									<select name='situacao' id='situacao'>
										<option value='' selected disabled>Selecione uma Situacao</option>
										<option value="" ></option>
										<?php
											foreach ($this->collectionSituacao as $situacao)
											{
												if($this->tarefa->situacao == $situacao->codigo)
													echo "<option value='{$situacao->codigo}' selected>{$situacao->nome}</option>";
												else
													echo "<option value='{$situacao->codigo}'>{$situacao->nome}</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<!--Descrição-->
							<tr>
								<td colspan='2'>
									Descrição
								</td>
							</tr>
							<tr>
								<td colspan='2'>
									<textarea 
										name='descricao' 
										id='descricao' 
										cols='35' 
										rows='5' 
										placeholder='Descrição detalhada da tarefa'
									><?php echo $this->tarefa->descricao; ?></textarea>
								</td>
							</tr>
						</table>
					</fieldset>
					<br>
					<!--Seção Execução-->
					<fieldset id='usuario'>
						<legend>Execução</legend>
						<table class='tabela-execucao'>
							<!--Usuario-->
							<tr>
								<td width='35%'>
									<label for='usuario'>Usuario:</label>
								</td>
								<td>
									<select name='usuarioCombo' id='usuarioCombo'>
										<option value='' selected disabled>Selecione uma Usuário</option>
										<option value=""></option>
										<?php
											foreach ($this->collectionUsuario as $usuario)
											{
												if($this->tarefa->usuario == $usuario->codigo)
													echo "<option value='{$usuario->codigo}' selected>{$usuario->nome}</option>";
												else
													echo "<option value='{$usuario->codigo}'>{$usuario->nome}</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<!--Data Inicio-->
							<tr>
								<td>
									<label for='dataInicio'>Data Início:</label>
								</td>
								<td>
									<input 
										type='date' 
										name='dataInicio' 
										id='dataInicio'
										placeholder="Data de Início"
										value="<?php echo $this->tarefa->data_inicio; ?>"
									>
								</td>
							</tr>
							<!--Tempo Estimado-->
							<tr>
								<td>
									<label for='tempoEstimado'>Tempo Estimado:</label>
								</td>
								<td>
									<input 
										type='time' 
										name='tempoEstimado' 
										id='tempoEstimado'
										placeholder="Tempo Estimado"
										value="<?php echo $this->tarefa->tempo_estimado; ?>"
									>
								</td>
							</tr>
							<!--Data Conclusão-->
							<tr>
								<td>
									<label for='dataConclusao'>Data Conclusão:</label>
								</td>
								<td>
									<input 
										type='date' 
										name='dataConclusao' 
										id='dataConclusao'
										placeholder="Data de Conclusão"
										value="<?php echo $this->tarefa->data_conclusao; ?>"
									>
								</td>
							</tr>
							<!--Concluido-->
							<tr>
								<td colspan="2">
									<?php
										if($this->tarefa->concluido == true)
											echo "<input type='checkbox' name='concluido' id='concluido' checked>Concluído";
										else
											echo "<input type='checkbox' name='concluido' id='concluido'>Concluído";
									?>
								</td>
							</tr>
						</table>
					</fieldset>
					<br>
					<fieldset id='subtarefas'>
						<legend>Subtarefas</legend>
						<table class='tabela-subtarefas'>
							<tr>
								<td colspan='2' style="text-align: center">
									<input type='button' value='Inserir' onclick="insereSubtarefa();">
								</td>
							</tr>
						<?php
							foreach ($this->collectionSubTarefa as $subtarefa)
							{
								if($subtarefa->concluido == true)
									echo "
											<tr>
												<td>
													<input type='checkbox' name='subTarefaItem[]' id='subtarefa_{$subtarefa->codigo}' class='subTarefaItem' value='$subtarefa->codigo' checked>
													<label for='subtarefa_{$subtarefa->codigo}'>{$subtarefa->nome}</label><br>
												</td>
												<td style='text-align: center;' width='10%'>
													<input type='checkbox' name='subTarefasApagar[]' class='chkSubTarefa' value='{$subtarefa->codigo}'>
												</td>
											</tr>
										";
								else
									echo "
											<tr>
												<td>
													<input type='checkbox' name='subTarefaItem[]' id='subtarefa_{$subtarefa->codigo}' class='subTarefaItem' value='$subtarefa->codigo'>
													<label for='subtarefa_{$subtarefa->codigo}'>{$subtarefa->nome}</label><br>
												</td>
												<td style='text-align: center;' width='10%'>
													<input type='checkbox' name='subTarefasApagar[]' class='chkSubTarefa' value='{$subtarefa->codigo}'>
												</td>
											</tr>
										";
							}
							
							if(count($this->collectionSubTarefa) > 0)
								echo	"
											<tr>
												<td>
												</td>
												<td style='text-align: center;'>
													<input type='button' value='Apagar' onclick='apagaSubTarefa()'>
												</td>
											</tr>
										";
						?>
							
						</table>
						<div id='conteudo'></div>
					</fieldset>
					<br>
					<div id='botoes'>
						<input type='button' value='Salvar' onclick="validaTarefa()">
						<input type='button' value='Apagar' onclick="apagaTarefa()">
					</div>
				</form>
			</body>
		</html>
	<?php
	}
}

new tarefa();
?>