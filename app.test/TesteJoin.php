<?php
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


	//RECUPERA CONEXAO BANCO DE DADOS
	TTransaction2::open('my_bd_site');

	//TABELA exposition_gallery
	$criteria	= new TCriteria;
	$criteria->add(new TFilter('kanban_tarefas.categoria',	'=', 'kanban_tarefas_categoria.codigo'));
	$criteria->add(new TFilter('kanban_tarefas.usuario',	'=', 'kanban_usuario.codigo'));
	//$criteria->setProperty('order', 'categoria ASC');
	//$criteria->setProperty('limit', '3');

	// instancia a instrução de SELECT
	$sql = new TSqlSelect;
	$sql->addColumn('kanban_tarefas.codigo');
	$sql->addColumn('kanban_tarefas.nome');
	$sql->addColumn('kanban_tarefas.criacao');
	$sql->addColumn('kanban_tarefas.prioridade');
	$sql->addColumn('kanban_tarefas_categoria.nome');
	$sql->addColumn('kanban_tarefas_categoria.cor');
	$sql->addColumn('kanban_usuario.nome');
	$sql->addColumn('kanban_usuario.cor');

	$sql->setEntity('kanban_tarefas');
	$sql->setEntity('kanban_tarefas_categoria');
	$sql->setEntity('kanban_usuario');

	//  atribui o critério passado como parâmetro
	$sql->setCriteria($criteria);
	
	
		echo $sql->getInstruction();
	
	// obtém transação ativa
	if ($conn = TTransaction2::get())
	{	
		// registra mensagem de log
		TTransaction2::log($sql->getInstruction());

		// executa a consulta no banco de dados
		$result = $conn->Query($sql->getInstruction());
		$results = array();

		if ($result)
		{ 	
			// percorre os resultados da consulta, retornando um objeto
			while ($row = $result->fetchObject())
			{
				// armazena no array $this->results;
				$results[] = $row;
			}
		}
	}
	TTransaction2::close();

	var_dump($results);
?>