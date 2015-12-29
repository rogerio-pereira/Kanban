<?php

/*
 * 	Arquivo  PupulaBanco
 * 	#RESUMO DA CLASSE#
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Aug 27, 2014
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
	
class PopulaBanco
{
	
	private $prioridade;
	private $categoriacont;
	private $usuariocont;

	public function __construct() 
	{
		//Situação
		TTransaction2::open('my_bd_site');
		
		$situacaonew = new kanban_situacao2;
		$situacaonew->nome = 'Situação 5';
		$situacaonew-> ordem = 5;
		$situacaonew->store();
		
		TTransaction2::close();
		
		
		//Usuario
		TTransaction2::open('my_bd_site');

		for($i=0; $i<3; $i++)
		{
			$usuario = new kanban_usuario2();
			$usuario->nome = 'usu_'.$i;
			$usuario->usuario  = 'usu_'.$i;
			$usuario->senha = 'usu_'.$i;

			if($i == 0)
				$usuario->cor = '#ff0000';
			else if($i == 1)
				$usuario->cor = '#00ff00';
			else if($i == 2)
				$usuario->cor = '#0000ff';

			$usuario->store();
		}
		
		TTransaction2::close();
		
		
		//Categorias
		TTransaction2::open('my_bd_site');

		for($i=0; $i<5; $i++)
		{
			$categoria = new kanban_tarefas_categoria2();

			$categoria->nome	= 'categoria_'.$i;

			if($i == 0)
				$categoria->cor = '#ff0000';
			else if($i == 1)
				$categoria->cor = '#00ff00';
			else if($i == 2)
				$categoria->cor = '#0000ff';
			else if($i == 3)
				$categoria->cor = '#ffff00';
			else if($i == 4)
				$categoria->cor = '#00ffff';

			$categoria->store();
		}
		
		TTransaction2::close();
		
		
		//Tarefas
		TTransaction2::open('my_bd_site');

		for($i =0; $i< 1000; $i++)
		{
			if($this->prioridade == 4)
				$this->prioridade = 0;
			if($this->usuariocont == 4)
				$this->usuariocont = 0;
			if($this->categoriacont == 5)
				$this->categoriacont = 0;

			$tarefa = new kanban_tarefas2();

			$tarefa->nome			= 'tar_'.$i;
			$tarefa->criacao		= '2014-08-27';
			$tarefa->prioridade		= $this->prioridade;
			$tarefa->descricao		= 'descrição tarefa '.$i;
			$tarefa->categoria		= $this->categoriacont;
			$tarefa->usuario		= $this->usuariocont;
			$this->categoriacont++;
			$this->usuariocont++;
			$this->prioridade++;

			if($i <= 500)
				$tarefa->situacao = 1;
			else if(($i > 500) && ($i <= 750))
				$tarefa->situacao = 2;
			else if(($i>750) && ($i <= 850))
				$tarefa->situacao = 3;
			else if(($i>850) && ($i <= 950))
				$tarefa->situacao = 4;
			else
				$tarefa->situacao = 5;

			$tarefa->store();
		}
		
		TTransaction2::close();
		
		
		//Subtarefas
		TTransaction2::open('my_bd_site');

		for($i=0; $i<1000; $i++)
		{
			$subtarefa					= new kanban_tarefas_subtarefas2();
			$subtarefa->codigo_tarefa	= $i+1;
			$subtarefa->nome			= "sub-tar {$i}_1";
			$subtarefa->concluido		= true;

			$subtarefa->store();


			$subtarefa					= new kanban_tarefas_subtarefas2();
			$subtarefa->codigo_tarefa	= $i+1;
			$subtarefa->nome			= "sub-tar {$i}_2";
			$subtarefa->concluido		= true;

			$subtarefa->store();



			$subtarefa					= new kanban_tarefas_subtarefas2();
			$subtarefa->codigo_tarefa	= $i+1;
			$subtarefa->nome			= "sub-tar {$i}_3";
			$subtarefa->concluido		= false;

			$subtarefa->store();



			$subtarefa					= new kanban_tarefas_subtarefas2();
			$subtarefa->codigo_tarefa	= $i+1;
			$subtarefa->nome			= "sub-tar {$i}_4";
			$subtarefa->concluido		= false;

			$subtarefa->store();		
		}
		
		
		TTransaction2::close();
		
		echo 'OK';
	}
}
new PopulaBanco();
?>