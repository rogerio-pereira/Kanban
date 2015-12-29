<?php

/*
 * 	Classe  controladorSituacao
 * 	Controla a classe Situtação
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Aug 29, 2014
 */

/*
 * Classe controladorSituacao
 */
class controladorSituacao
{
	/*
	 * Variaveis
	 */
	
	private $repository;
	private $collectionSituacoes;
	private $situacao;
	
	private $codigo;
	private $nome;
	private $ordem;		
	
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getOrdem()
	{
		return $this->ordem;
	}
	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setOrdem($ordem)
	{
		$this->ordem = $ordem;
	}
	

	/*
	 * Método construtor
	 */
	public function __construct()
	{
		$this->repository	= NULL;
		$this->situacao		= NULL;
	}
	
	/*
	 *	Método getSituacoes
	 *	Obtem todas as situações
	 */
	public function getSituacoes()
	{
		$this->collectionSituacoes = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		//$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'ordem ASC');
		
		$this->repository = new TRepository();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_situacao');
		
		$this->collectionSituacoes = $this->repository->load($criteria);
		
		TTransaction::close();
		
		return $this->collectionSituacoes;
	}
	
	/*
	 *	Método getSituacoes2
	 *	Obtem todas as situações
	 *	Usado em Iframes
	 */
	public function getSituacoes2()
	{
		$this->collectionSituacoes = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		//$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'ordem ASC');
		
		$this->repository = new TRepository2();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_situacao');
		
		$this->collectionSituacoes = $this->repository->load($criteria);
		
		TTransaction2::close();
		
		return $this->collectionSituacoes;
	}
	
	/*
	 *	Método getSituacao
	 *	Obtem a situacao com o codigo especifico;
	 */
	public function getSituacao($codigo)
	{
		$this->situacao = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->situacao = new kanban_situacao();
		$result = $this->situacao->load($codigo);
		
		TTransaction::close();
		
		return $result;
	}
	
	/*
	 *	Método getSituacao2
	 *	Obtem a situacao com o codigo especifico;
	 *	Usado em Iframes
	 */
	public function getSituacao2($codigo)
	{
		$this->situacao = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->situacao = new kanban_situacao2();
		$result = $this->situacao->load($codigo);
		
		TTransaction2::close();
		
		return $result;
	}
	
	/*
	 *	Método salvarSituacao
	 *	Insere/Atualiza a situação
	 */
	public function salvarSituacao()
	{
		try
		{
			$this->situacao = new kanban_situacao();
			
			$this->situacao->codigo			= $this->getCodigo();
			$this->situacao->nome			= $this->getNome();
			$this->situacao->ordem			= $this->getOrdem();
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			$result = $this->situacao->store();

			TTransaction::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método salvarSituacao2
	 *	Insere/Atualiza a situação
	 *	Usado em IFRAMES
	 */
	public function salvarSituacao2()
	{
		try
		{
			$this->situacao = new kanban_situacao2();
			
			$this->situacao->codigo			= $this->getCodigo();
			$this->situacao->nome			= $this->getNome();
			$this->situacao->ordem			= $this->getOrdem();
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$result = $this->situacao->store();

			TTransaction2::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaSituacoes
	 *	Obtem a terefa com o codigo especifico;
	 */
	public function apagaSituacoes($codigo)
	{
	try
		{
			$this->situacao = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction::open('my_bd_site');

			$this->situacao = new kanban_situacao();
			$this->situacao->delete($codigo);

			TTransaction::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método apagaSituacoes2
	 *	Obtem a terefa com o codigo especifico;
	 *	Usado em IFRAME
	 */
	public function apagaSituacoes2($codigo)
	{
	try
		{
			$this->situacao = NULL;

			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$this->situacao = new kanban_situacao2();
			$this->situacao->delete($codigo);

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