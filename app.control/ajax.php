<?php 
	session_start();
	header("Content-Type:text/html; charset=UTF-8",true) 
?>

<?php
/*
 * 	Arquivo  ajax
 * 	Destino de todos os fomrularios
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Aug 29, 2014
 */

    //Autoload
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
	
	error_reporting(E_WARNING);
	
	//Obtem informação do que sera feito através do campo hiddens
	$request = $_POST['action'];
	
	//Login
	if($request == 'login')
	{		
		$controlador	= new controladorLogin();
		
		$controlador->setUsuario( $_POST['usuario']);
		$controlador->setSenha($_POST['senha']);
		
		$retorno = $controlador->login();
		
		if($retorno == true)
		{
			return true;
		}
		else
		{
			session_destroy();
			echo "
					<script>
						alert('Falha ao fazer login');
					</script>
				";
		}
	}
	
	//Login
	else if($request == 'alteraSenha')
	{		
		$controlador	= new controladorAlterarSenha();
		
		$controlador->setSenhaAtual($_POST['senhaAtual']);
		$controlador->setSenhaNova($_POST['senhaNova']);
		
		if($controlador->compara() == true)
		{
			if($controlador->altera())
				echo "
					<script>
						alert('Senha alterada com sucesso!');
					</script>
				";
			else
				echo "
					<script>
						alert('Falha ao alterar Senha!');
					</script>
				";
		}
		else
			echo "
					<script>
						alert('Senha inválida!');
					</script>
				";
	}
	
	//Insere Subtarefa
	else if($request == 'insereSubtarefa')
	{		
		$controlador	= new controladorSubtarefa();
		
		$controlador->setCodigoTarefa($_POST['codigo']);
		$controlador->setNomeSubTarefa( $_POST['nomeSubtarefa']);
		
		$controlador->salvarSubTarefa2();
		
		$collectionSubtarefa = $controlador->getSubtarefas2($_POST['codigo']);
		
		echo 
			"
				<tr>
					<td colspan='2' style='text-align: center'>
						<input type='button' value='Inserir' onclick='insereSubtarefa();'>
					</td>
				</tr>
			";
		
		foreach ($collectionSubtarefa as $subtarefa)
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

		if(count($collectionSubtarefa) > 0)
			echo	"
						<tr>
							<td>
							</td>
							<td style='text-align: center;'>
								<input type='button' value='Apagar' onclick='apagaSubTarefa()'>
							</td>
						</tr>
					";
	}
	
	//Apaga Subtarefa
	else if($request == 'apagaSubTarefa')
	{		
		$codigos = $_POST['subTarefasApagar'];
		$apagado  = 0;
		
		$controladorSubtarefas	= new controladorSubtarefa();
		
		foreach ($codigos as $codigo)
		{
			$controladorSubtarefas->apagaSubTarefa2($codigo);
		}
		
		$collectionSubtarefa = $controladorSubtarefas->getSubtarefas2($_POST['codigo']);
		
		echo 
			"
				<tr>
					<td colspan='2' style='text-align: center'>
						<input type='button' value='Inserir' onclick='insereSubtarefa();'>
					</td>
				</tr>
			";
		
		foreach ($collectionSubtarefa as $subtarefa)
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

		if(count($collectionSubtarefa) > 0)
			echo	"
						<tr>
							<td>
							</td>
							<td style='text-align: center;'>
								<input type='button' value='Apagar' onclick='apagaSubTarefa()'>
							</td>
						</tr>
					";
	}
	
	//SalvarTarefa
	else if($request == 'salvarTarefa')
	{
		$controladorTarefa		= new controladorTarefa();
		$controladorSubtarefas	= new controladorSubtarefa();
		
		$controladorTarefa->setCodigo($_POST['codigo']);
		$controladorTarefa->setNome($_POST['nome']);
		$controladorTarefa->setCriacao($_POST['criacao']);
		$controladorTarefa->setCategoria($_POST['categoria']);
		$controladorTarefa->setPrioridade($_POST['prioridade']);
		$controladorTarefa->setLink($_POST['link']);
		$controladorTarefa->setDescricao($_POST['descricao']);
		$controladorTarefa->setSituacao($_POST['situacao']);
		$controladorTarefa->setUsuario($_POST['usuario']);
		$controladorTarefa->setData_inicio($_POST['dataInicio']);
		$controladorTarefa->setTempo_estimado($_POST['tempoEstimado']);
		$controladorTarefa->setData_conclusao($_POST['dataConclusao']);
		$controladorTarefa->setConcluido($_POST['concluido']);
		
		$controladorSubtarefas->setCodigoTarefa($_POST['codigo']);
		$controladorSubtarefas->setCodigos($_POST['subTarefaItem']);
		
		if($controladorSubtarefas->salvarSubTarefas2() == true)
		{
			if($controladorTarefa->salvarTarefa2() == true)
				return true;
			else
				return false;
		}
		else
			return true;
	}	
	
	//Apaga Tarefa
	else if($request == 'apagaTarefa')
	{
		$codigo = $_POST['codigo'];
		
		$controladorSubtarefas	= new controladorSubtarefa();
		$controladorTarefa		= new controladorTarefa();
		
		if($controladorSubtarefas->apagaSubTarefas2($codigo) == true)
		{
			if($controladorTarefa->apagaTarefa2($codigo) == true)
				return true;
			else
				return false;
		}
		else
			return false;
	}
	
	//Salva Situações
	else if($request == 'salvarSituacao')
	{
		$controlador = new controladorSituacao;
		
		$controlador->setCodigo($_POST['codigo']);
		$controlador->setNome($_POST['nome']);
		$controlador->setOrdem($_POST['ordem']);
		
		
		if($controlador->salvarSituacao2() == true)
		{
				return true;
		}
		else
		{
			echo "<script> alert('Impossivel salvar Situação');</script>";
			
			return false;
		}
	}
	
	//Apaga Situacoes
	else if($request == 'apagaSituacoes')
	{		
		$codigos = $_POST['codigos'];
		$apagado  = 0;
		
		$controlador	= new controladorSituacao();
		
		foreach ($codigos as $codigo)
		{
			$controlador->apagaSituacoes2($codigo);
		}
		
		$collectionSituacoes = $controlador->getSituacoes2();
				
		foreach ($collectionSituacoes as $situacao)
		{
			echo
				"
					<!--{$situacao->nome}-->
					<tr>
						<td>
							<input type='radio' name='radioSituacao' id='radioSituacao' value='$situacao->codigo'>
						</td>
						<td>
							{$situacao->nome}
						</td>
						<td>
							{$situacao->ordem}
						</td>
						<td style='text-align: center;'>
							<input type='checkbox' name='situacoesApagar[]' class='chkSituacoesApagar' value='{$situacao->codigo}'>
						</td>
					</tr>
				";
		}

		echo "
				<tr>
					<td colspan='4'>
						<hr>
					</td>
				</tr>
				<tr>
					<td colspan='4' style='text-align: center'>
						<input type='button' value='Nova'		onclick='novaSituacao()'>
						<input type='button' value='Alterar'	onclick='alteraSituacao()'>
				";
				
		if(count($collectionSituacoes) > 0)
			echo "<input type='button' value='Apagar' onclick='apagaSituacoes()'>";
		
		echo "
					</td>
				</tr>
			";
	}
	
	//Salva Categoria
	else if($request == 'salvarCategoria')
	{		
		$controlador = new controladorCategoria();
		
		$controlador->setCodigo($_POST['codigo']);
		$controlador->setNome($_POST['nome']);
		$controlador->setCor($_POST['cor']);
		
		if($controlador->salvarCategoria2() == true)
		{
			return true;
		}
		else
		{
			echo "<script> alert('Impossivel salvar Categoria');</script>";
			
			return false;
		}
	}
	
	//Apaga Categorias
	else if($request == 'apagaCategorias')
	{		
		$codigos = $_POST['codigos'];
		$apagado  = 0;
		
		$controlador	= new controladorCategoria();
		
		foreach ($codigos as $codigo)
		{
			$controlador->apagaCategorias2($codigo);
		}
		
		$collectionCategorias = $controlador->getCategorias2();
				
		foreach ($collectionCategorias as $categoria)
		{
			echo
				"
					<!--{$categoria->nome}-->
					<tr>
						<td>
							<input type='radio' name='radioCategoria' id='radioCategoria' value='$categoria->codigo'>
						</td>
						<td>
							{$categoria->nome}
						</td>
						<td>
							<div style='background-color: {$categoria->cor}; width: 50px'>&nbsp;</div>
						</td>
						<td style='text-align: center;'>
							<input type='checkbox' name='categoriasApagar[]' class='chkCategoriasApagar' value='{$categoria->codigo}'>
						</td>
					</tr>
				";
		}

		echo "
				<tr>
					<td colspan='4'>
						<hr>
					</td>
				</tr>
				<tr>
					<td colspan='4' style='text-align: center'>
						<input type='button' value='Nova'		onclick='novaCategoria()'>
						<input type='button' value='Alterar'	onclick='alteraCategoria()'>
				";
				
		if(count($collectionCategorias) > 0)
			echo "<input type='button' value='Apagar' onclick='apagaCategorias()'>";
		
		echo "
					</td>
				</tr>
			";
	}
	
	//Salva Usuario
	else if($request == 'salvarUsuario')
	{
		
		$controlador = new controladorUsuario();
		
		$controlador->setCodigo($_POST['codigo']);
		$controlador->setNome($_POST['nome']);
		$controlador->setUser($_POST['usuario']);
		$controlador->setSenha($_POST['senha']);
		$controlador->setCor($_POST['cor']);
		
		if($controlador->salvarUsuario2() == true)
		{
			return true;
		}
		else
		{
			echo "<script> alert('Impossivel salvar Usuário');</script>";
			
			return false;
		}
	}
?>