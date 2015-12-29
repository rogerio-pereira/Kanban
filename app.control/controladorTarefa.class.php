<?php

/*	
	Classe controladorTarefa
	Controla  a Tarefas
	
	Sistema:	Kanban
	Autor: 		Rogério Eduardo Pereira
	Data: 		23/08/2014
*/
class controladorTarefa
{
	/*
		Variaveis
	*/
	private $repository;
	private $collectionSituacao;
	private $collectionTarefas;
	private $tarefa;
	
	private $codigo;
	private $nome;
	private $criacao;
	private $categoria;
	private $prioridade;	
	private $link;
	private $descricao;
	private $situacao;
	private $usuario;
	private $data_inicio;
	private $tempo_estimado;
	private $data_conclusao;
	private $concluido;
	
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getCriacao()
	{
		return $this->criacao;
	}
	public function getCategoria()
	{
		return $this->categoria;
	}
	public function getPrioridade()
	{
		return $this->prioridade;
	}
	public function getLink()
	{
		return $this->link;
	}
	public function getDescricao()
	{
		return $this->descricao;
	}
	public function getSituacao()
	{
		return $this->situacao;
	}
	public function getUsuario()
	{
		return $this->usuario;
	}
	public function getData_inicio()
	{
		return $this->data_inicio;
	}
	public function getTempo_estimado()
	{
		return $this->tempo_estimado;
	}
	public function getData_conclusao()
	{
		return $this->data_conclusao;
	}
	public function getConcluido()
	{
		return $this->concluido;
	}
	
	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setCriacao($criacao)
	{
		$this->criacao = $criacao;
	}
	public function setCategoria($categoria)
	{
		$this->categoria = $categoria;
	}
	public function setPrioridade($prioridade)
	{
		$this->prioridade = $prioridade;
	}
	public function setLink($link)
	{
		$this->link = $link;
	}
	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}
	public function setSituacao($situacao)
	{
		$this->situacao = $situacao;
	}
	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}
	public function setData_inicio($data_inicio)
	{
		$this->data_inicio = $data_inicio;
	}
	public function setTempo_estimado($tempo_estimado)
	{
		$this->tempo_estimado = $tempo_estimado;
	}
	public function setData_conclusao($data_conclusao)
	{
		$this->data_conclusao = $data_conclusao;
	}
	public function setConcluido($concluido)
	{
		$this->concluido = $concluido;
	}
	

	/*
		Método construtor
	*/
	public function __construct()
	{
		$this->repository			= NULL;
		$this->collectionSituacao	= NULL;
		$this->collectionTarefas	= NULL;
		$this->tarefa				= NULL;
	}
	
	public function zeraRepository()
	{
		$this->repository = NULL;
	}

	/*
	 *	Método getSituacoes
	 *	Obtem todas as situações da tabela
	 */
	public function getSituacoes()
	{
		$this->collectionSituacao = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->setProperty('order', 'ordem ASC');
		
		$this->repository = new TRepository();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_situacao');
		
		$this->collectionSituacao = $this->repository->load($criteria);
		
		TTransaction::close();
		
		return $this->collectionSituacao;
	}
	
	/*
	 *	Método getTarefas
	 *	Obtem todas as tarefas da situação selecionda
	 */
	public function getTarefas($situacao)
	{
		$this->collectionTarefas = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'prioridade DESC, categoria, criacao, nome');
		
		$this->repository = new TRepository();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_tarefas');
		
		$this->collectionTarefas = $this->repository->load($criteria);
		
		TTransaction::close();
		
		return $this->collectionTarefas;
	}
	
	/*
	 *	Método getTarefas2
	 *	Obtem todas as tarefas da situação selecionda
	 */
	public function getTarefas2($situacao)
	{
		$this->collectionTarefas = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'prioridade DESC, categoria, criacao, nome');
		
		$this->repository = new TRepository();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_tarefas');
		
		$this->collectionTarefas = $this->repository->load($criteria);
		
		TTransaction2::close();
		
		return $this->collectionTarefas;
	}
	
	/*
	 *	Método getTarefa
	 *	Obtem a terefa com o codigo especifico;
	 */
	public function getTarefa($codigo)
	{
		$this->tarefa = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->tarefa = new kanban_tarefas();
		$result = $this->tarefa->load($codigo);
		
		TTransaction::close();
		
		return $result;
	}
	
	/*
	 *	Método getTarefa
	 *	Obtem a terefa com o codigo especifico;
	 *	Usado em Iframes
	 */
	public function getTarefa2($codigo)
	{
		$this->tarefa = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->tarefa = new kanban_tarefas2();
		$result = $this->tarefa->load($codigo);
		
		TTransaction2::close();
		
		return $result;
	}
	
	/*
	 *	Método apagaTarefa
	 *	Obtem a terefa com o codigo especifico;
	 */
	public function apagaTarefa($codigo)
	{
		try
		{
			$this->tarefa = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			$this->tarefa = new kanban_tarefas();
			$result = $this->tarefa->delete($codigo);

			TTransaction::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaTarefa2
	 *	Obtem a terefa com o codigo especifico;
	 */
	public function apagaTarefa2($codigo)
	{
		try
		{
			$this->tarefa = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$this->tarefa = new kanban_tarefas2();
			$result = $this->tarefa->delete($codigo);

			TTransaction2::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarTarefa
	 *	Insere/Atualiza a tarefa
	 */
	public function salvarTarefa()
	{
		try
		{
			$this->tarefa = new kanban_tarefas2();
			
			$this->tarefa->codigo			= $this->getCodigo();
			$this->tarefa->nome				= $this->getNome();
			$this->tarefa->criacao			= $this->getCriacao();
			$this->tarefa->categoria		= $this->getCategoria();
			$this->tarefa->prioridade		= $this->getPrioridade();
			$this->tarefa->link				= $this->getLink();
			$this->tarefa->descricao		= $this->getDescricao();
			$this->tarefa->situacao			= $this->getSituacao();
			$this->tarefa->usuario			= $this->getUsuario();
			$this->tarefa->data_inicio		= $this->getData_inicio();
			$this->tarefa->tempo_estimado	= $this->getTempo_estimado();
			$this->tarefa->data_conclusao	= $this->getData_conclusao();
			$this->tarefa->concluido		= $this->getConcluido();
			
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$result = $this->tarefa->store();

			TTransaction2::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarTarefa2
	 *	Insere/Atualiza a tarefa
	 */
	public function salvarTarefa2()
	{
		try
		{
			$this->tarefa = new kanban_tarefas2();
			
			$this->tarefa->codigo			= $this->getCodigo();
			$this->tarefa->nome				= $this->getNome();
			$this->tarefa->criacao			= $this->getCriacao();
			$this->tarefa->categoria		= $this->getCategoria();
			$this->tarefa->prioridade		= $this->getPrioridade();
			$this->tarefa->link				= $this->getLink();
			$this->tarefa->descricao		= $this->getDescricao();
			$this->tarefa->situacao			= $this->getSituacao();
			$this->tarefa->usuario			= $this->getUsuario();
			$this->tarefa->data_inicio		= $this->getData_inicio();
			$this->tarefa->tempo_estimado	= $this->getTempo_estimado();
			$this->tarefa->data_conclusao	= $this->getData_conclusao();
			$this->tarefa->concluido		= $this->getConcluido();
			
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$result = $this->tarefa->store();

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