<?php
/*
 *	Classe  controladorCategoria
 *	Controla a Classe Categoria
 *	
 *	Sistema:	Kanban
 *	Autor:		Rogério Eduardo Pereira
 *	Data:		Aug 28, 2014
 */

/*
 * Classe controladorCategoria
 */
class controladorCategoria 
{
	/*
	 * Variaveis
	 */
	private $repository;
	private $categoria;
	
	private $codigo;
	private $nome;
	private $cor;
	
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getCor()
	{
		return $this->cor;
	}
	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setCor($cor)
	{
		$this->cor = $cor;
	}
	

	/*
	 * Método construtor
	 */
	public function __construct()
	{
		$this->repository	= NULL;
		$this->categoria	= NULL;
	}

	public function zeraRepository()
	{
		$this->repository = NULL;
	}
	
	/*
	 *	Método getCategorias
	 *	Obtem todas as tarefas da situação selecionda
	 */
	public function getCategorias()
	{
		$this->collectionTarefas = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		//$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'nome');
		
		$this->repository = new TRepository();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_tarefas_categoria');
		
		$this->collectionTarefas = $this->repository->load($criteria);
		
		TTransaction::close();
		
		return $this->collectionTarefas;
	}
	
	/*
	 *	Método getCategorias2
	 *	Obtem todas as tarefas da situação selecionda
	 *	Usado em Iframes
	 */
	public function getCategorias2()
	{
		$this->collectionTarefas = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		//$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'nome');
		
		$this->repository = new TRepository2();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_tarefas_categoria');
		
		$this->collectionTarefas = $this->repository->load($criteria);
		
		TTransaction2::close();
		
		return $this->collectionTarefas;
	}
	
	
	/*
	 *	Método getCategoria
	 *	Obtem todas as situações da tabela
	 */
	public function getCategoria($codigo)
	{
		$this->categoria = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->categoria = new kanban_tarefas_categoria();
		$result = $this->categoria->load($codigo);
		
		TTransaction::close();
		
		return $result;
	}
	
	/*
	 *	Método getCategoria
	 *	Obtem todas as situações da tabela
	 *	Usado em Iframes
	 */
	public function getCategoria2($codigo)
	{
		$this->categoria = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->categoria = new kanban_tarefas_categoria2();
		$result = $this->categoria->load($codigo);
		
		TTransaction2::close();
		
		return $result;
	}
	
	/*
	 *	Método salvarCategoria
	 *	Insere/Atualiza a situação
	 */
	public function salvarCategoria()
	{
		try
		{
			$this->categoria = new kanban_tarefas_categoria();
			
			$this->categoria->codigo		= $this->getCodigo();
			$this->categoria->nome			= $this->getNome();
			$this->categoria->cor			= $this->getCor();
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			$result = $this->categoria->store();

			TTransaction::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarCategoria2
	 *	Insere/Atualiza a situação
	 *	Usado em IFRAMES
	 */
	public function salvarCategoria2()
	{
		try
		{
			$this->categoria = new kanban_tarefas_categoria2();
			
			$this->categoria->codigo		= $this->getCodigo();
			$this->categoria->nome			= $this->getNome();
			$this->categoria->cor			= $this->getCor();
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$result = $this->categoria->store();

			TTransaction2::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaCategorias
	 *	Apaga as categorias com o codigo especifico;
	 */
	public function apagaCategorias($codigo)
	{
	try
		{
			$this->categoria = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			$this->categoria = new kanban_tarefas_categoria();
			$this->categoria->delete($codigo);

			TTransaction::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaCategorias2
	 *	Apaga as categorias com o codigo especifico;
	 *	Usado em IFRAME
	 */
	public function apagaCategorias2($codigo)
	{
	try
		{
			$this->categoria = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$this->categoria = new kanban_tarefas_categoria2();
			$this->categoria->delete($codigo);

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