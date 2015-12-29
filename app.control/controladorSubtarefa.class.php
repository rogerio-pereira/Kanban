<?php

/*
 * 	Classe  controladorSubtarefas
 * 	#RESUMO DA CLASSE#
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Aug 28, 2014
 */

/*
 * Classe controladorSubtarefas
 */
class controladorSubtarefa
{
	/*
	 * Variaveis
	 */
	private $repository;
	private $collectionSubTarefas;
	private $subTarefa;
	
	private $codigo;
	private $codigoTarefa;
	private $nomeSubTarefa;
	private $concluido;
	
	private $codigos;
	
	
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
	
	
	public function getCodigoTarefa()
	{
		return $this->codigoTarefa;
	}
	public function setCodigoTarefa($codigoTarefa)
	{
		$this->codigoTarefa = $codigoTarefa;
	}
	
	public function getNomeSubTarefa()
	{
		return $this->nomeSubTarefa;
	}
	public function setNomeSubTarefa($nomeSubTarefa)
	{
		$this->nomeSubTarefa = $nomeSubTarefa;
	}
	
	public function getConcluido()
	{
		if(isset($this->concluido))
			return $this->concluido;
		else
			return 0;
	}
	public function setConcluido($concluido)
	{
		$this->concluido = $concluido;
	}
	
	
	
	
	public function getCodigos()
	{
		return $this->codigos;
	}
	public function setCodigos($codigos)
	{
		$this->codigos = $codigos;
	}
	

	/*
	 * Método construtor
	 */
	public function __construct()
	{
		$this->repository			= NULL;
		$this->collectionSubTarefas = NULL;
		$this->subTarefa			= NULL;
	}
	
	/*
	 *	Método getSubtarefas
	 *	Obtem todas as subtarefas de acordo com o codigo da tarefa
	 */
	public function getSubtarefas($codigoTarefa)
	{
		$this->collectionSubTarefas = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->setProperty(new TFilter('codigo_tarefa', '=', $codigoTarefa));
		$criteria->setProperty('order', 'codigo ASC');
		
		$this->repository = new TRepository();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_tarefas_subtarefas');
		
		$this->collectionSubTarefas = $this->repository->load($criteria);
		
		TTransaction::close();
		
		return $this->collectionSubTarefas;
	}
	
	/*
	 *	Método getSubtarefas2
	 *	Obtem todas as subtarefas de acordo com o codigo da tarefa
	 *	Usado em Iframes
	 */
	public function getSubtarefas2($codigoTarefa)
	{
		$this->collectionSubTarefas = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo_tarefa', '=', $codigoTarefa));
		$criteria->setProperty('order', 'codigo ASC');
		
		$this->repository = new TRepository2();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_tarefas_subtarefas');
		
		$this->collectionSubTarefas = $this->repository->load($criteria);
		
		TTransaction2::close();
		
		return $this->collectionSubTarefas;
	}
	
	/*
	 *	Método apagaSubTarefas
	 *	Obtem todas as subtarefas de acordo com o codigo da tarefa
	 */
	public function apagaSubTarefas($codigoTarefa)
	{
		try
		{
			$this->collectionSubTarefas = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			//TABELA exposition_gallery
			$criteria	= new TCriteria;
			$criteria->add(new TFilter('codigo_tarefa', '=', $codigoTarefa));
			//$criteria->setProperty('order', 'codigo ASC');

			$this->repository = new TRepository();

			$this->repository->addEntity('kanban_tarefas_subtarefas');

			$this->collectionSubTarefas = $this->repository->delete($criteria);
			
			TTransaction2::close();
			
			return true;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaSubTarefas2
	 *	Obtem todas as subtarefas de acordo com o codigo da tarefa
	 *	Usado em Iframes
	 */
	public function apagaSubTarefas2($codigoTarefa)
	{
		Try
		{
			$this->collectionSubTarefas = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			//TABELA exposition_gallery
			$criteria	= new TCriteria;
			$criteria->add(new TFilter('codigo_tarefa', '=', $codigoTarefa));
			//$criteria->setProperty('order', 'codigo ASC');

			$this->repository = new TRepository2();

			$this->repository->addEntity('kanban_tarefas_subtarefas');

			$this->collectionSubTarefas = $this->repository->delete($criteria);

			TTransaction2::close();
			
			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaSubTarefa
	 *	Obtem a terefa com o codigo especifico;
	 */
	public function apagaSubTarefa($codigo)
	{
		try
		{
			$this->subTarefa = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			$this->subTarefa = new kanban_tarefas_subtarefas();
			$result = $this->subTarefa->delete($codigo);

			TTransaction::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaSubTarefa2
	 *	Obtem a terefa com o codigo especifico;
	 */
	public function apagaSubTarefa2($codigo)
	{
		try
		{
			$this->subTarefa = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$this->subTarefa = new kanban_tarefas_subtarefas2();
			$result = $this->subTarefa->delete($codigo);

			TTransaction2::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarSubTarefas
	 *	Salva todas as subtarefas
	 *		Define todas como não concluidas e depois salva uma por uma que foi concluida
	 */
	public function salvarSubTarefas()
	{
		try
		{
			$this->collectionSubTarefas = NULL;
			
			$this->subTarefa			= new kanban_tarefas_subtarefas();
		
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');
			
			//TABELA exposition_gallery
			$criteria	= new TCriteria;
			$criteria->add(new TFilter('codigo_tarefa', '=', $this->codigoTarefa));
			//$criteria->setProperty('order', 'codigo ASC');
			
			$this->repository = new TRepository();

			$this->repository->addColumn('*');
			$this->repository->addEntity('kanban_tarefas_subtarefas');

			$this->collectionSubTarefas = $this->repository->load($criteria);
			
			foreach ($this->collectionSubTarefas as $subtarefas)
			{
				$this->subTarefa->codigo		= $subtarefas->codigo;
				$this->subTarefa->codigo_tarefa = $subtarefas->codigo_tarefa;
				$this->subTarefa->nome			= $subtarefas->nome;
				$this->subTarefa->concluido		= '0';
				
				if(count($this->codigos) > 0)
				{
					foreach ($this->codigos as $codSubTar)
					{
						if($subtarefas->codigo == $codSubTar)
						{
							$this->subTarefa->concluido = '1';
							break;
						}
					}
				}
				
				$result = $this->subTarefa->store();
			}

			TTransaction::close();
			
			return true;
		} 
		catch (Exception $ex) 
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarSubTarefas2
	 *	Salva todas as subtarefas
	 *		Define todas como não concluidas e depois salva uma por uma que foi concluida
	 */
	public function salvarSubTarefas2()
	{
		try
		{
			$this->collectionSubTarefas = NULL;
			
			$this->subTarefa			= new kanban_tarefas_subtarefas2();
		
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');
			
			//TABELA exposition_gallery
			$criteria	= new TCriteria;
			$criteria->add(new TFilter('codigo_tarefa', '=', $this->codigoTarefa));
			//$criteria->setProperty('order', 'codigo ASC');
			
			$this->repository = new TRepository2();

			$this->repository->addColumn('*');
			$this->repository->addEntity('kanban_tarefas_subtarefas');

			$this->collectionSubTarefas = $this->repository->load($criteria);
			
			foreach ($this->collectionSubTarefas as $subtarefas)
			{
				$this->subTarefa->codigo		= $subtarefas->codigo;
				$this->subTarefa->codigo_tarefa = $subtarefas->codigo_tarefa;
				$this->subTarefa->nome			= $subtarefas->nome;
				$this->subTarefa->concluido		= '0';
				
				if(count($this->codigos) > 0)
				{
					foreach ($this->codigos as $codSubTar)
					{
						if($subtarefas->codigo == $codSubTar)
						{
							$this->subTarefa->concluido = '1';
							break;
						}
					}
				}
				
				$result = $this->subTarefa->store();
			}

			TTransaction2::close();
			
			return true;
		} 
		catch (Exception $ex) 
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarSubTarefa
	 *	Insere/Atualiza a subtarefa
	 */
	public function salvarSubTarefa()
	{
		try
		{
			$this->subTarefa				= new kanban_tarefas_subtarefas();
			
			$this->subTarefa->codigo		= $this->getCodigo();
			$this->subTarefa->codigo_tarefa	= $this->getCodigoTarefa();
			$this->subTarefa->nome			= $this->getNomeSubTarefa();
			$this->subTarefa->concluido		= $this->getConcluido();
			
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			$result = $this->subTarefa->store();

			TTransaction::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarSubTarefa2
	 *	Insere/Atualiza a subtarefa
	 */
	public function salvarSubTarefa2()
	{
		try
		{
			$this->subTarefa				= new kanban_tarefas_subtarefas2();
			
			$this->subTarefa->codigo		= $this->getCodigo();
			$this->subTarefa->codigo_tarefa	= $this->getCodigoTarefa();
			$this->subTarefa->nome			= $this->getNomeSubTarefa();
			$this->subTarefa->concluido		= $this->getConcluido();
			
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$result = $this->subTarefa->store();

			TTransaction2::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
}
?>