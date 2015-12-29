<?php
/*
 * 	Classe  controladorUsuario
 * 	Controla a Classe Usuario
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Aug 28, 2014
 */

/*
 * Classe controladorUsuario
 */
class controladorUsuario
{

	
	/*
	 * Variaveis
	 */
	private $repository;
	private $usuario;
	private $collectionUsuario;
	
	private $codigo;
	private $nome;
	private $user;
	private $senha;
	private $cor;
	
	public function getUsuarioBD()
	{
		return $this->usuario;
	}
	public function setUsuarioBD($usuario)
	{
		$this->usuario = $usuario;
	}
	
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getUser()
	{
		return $this->user;
	}
	public function getSenha()
	{
		return $this->senha;
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
	public function setUser($user)
	{
		$this->user = $user;
	}
	public function setSenha($senha)
	{
		$this->senha = md5($senha.'K4/\/b@n');
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
		$this->usuario		= NULL;
	}

	public function zeraRepository()
	{
		$this->repository = NULL;
	}
	
	/*
	 *	Método getUsuarios
	 *	Obtem todos os usuarios
	 */
	public function getUsuarios()
	{
		$this->collectionUsuario = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		//$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'nome');
		
		$this->repository = new TRepository();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_usuario');
		
		$this->collectionUsuario = $this->repository->load($criteria);
		
		return $this->collectionUsuario;
	}
	
	/*
	 *	Método getUsuarios2
	 *	Obtem todos os usuarios
	 */
	public function getUsuarios2()
	{
		$this->collectionUsuario = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		//$criteria->add(new TFilter('situacao', '=', $situacao));
		$criteria->setProperty('order', 'nome');
		
		$this->repository = new TRepository2();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_usuario');
		
		$this->collectionUsuario = $this->repository->load($criteria);
		
		return $this->collectionUsuario;
	}
	
	/*
	 *	Método getUsuario
	 *	Obtem o usuario
	 */
	public function getUsuario($codigo)
	{
		$this->usuario = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->usuario = new kanban_usuario();
		$result = $this->usuario->load($codigo);
		
		return $result;
	}
	
	/*
	 *	Método getUsuario
	 *	Obtem o usuario
	 *	Usado em Iframes
	 */
	public function getUsuario2($codigo)
	{
		$this->usuario = NULL;
		$result;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('codigo', '=', $codigo));
		//$criteria->setProperty('order', 'ordem ASC');
		
		$this->usuario = new kanban_usuario2();
		$result = $this->usuario->load($codigo);
		
		return $result;
	}
	
	/*
	 *	Método getUsuarioByUser
	 *	Obtem o usuario
	 *	Usado em Iframes
	 */
	public function getUsuarioByUser($usuario)
	{
		$this->collectionUsuario = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('usuario', '=', $usuario));
		//$criteria->setProperty('order', 'nome');
		
		$this->repository = new TRepository2();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_usuario');
		
		$this->collectionUsuario = $this->repository->load($criteria);
		
		TTransaction::close();
		
		return $this->collectionUsuario[0];
	}
	
	/*
	 *	Método getUsuarioByUser2
	 *	Obtem o usuario
	 *	Usado em Iframes
	 */
	public function getUsuarioByUser2($usuario)
	{
		$this->collectionUsuario = NULL;
		
		//RECUPERA CONEXAO BANCO DE DADOS
		TTransaction2::open('my_bd_site');

		//TABELA exposition_gallery
		$criteria	= new TCriteria;
		$criteria->add(new TFilter('usuario', '=', $usuario));
		//$criteria->setProperty('order', 'nome');
		
		$this->repository = new TRepository2();
		
		$this->repository->addColumn('*');
		$this->repository->addEntity('kanban_usuario');
		
		$this->collectionUsuario = $this->repository->load($criteria);
		
		TTransaction2::close();
		
		return $this->collectionUsuario[0];
	}
	
	/*
	 *	Método salvarUsuario2
	 *	Insere/Atualiza a situação
	 *	Usado em IFRAMES
	 */
	public function salvarUsuario2()
	{
		try
		{
			$this->usuario = new kanban_usuario2();
			
			$this->usuario->codigo		= $this->getCodigo();
			$this->usuario->nome		= $this->getNome();
			$this->usuario->usuario		= $this->getUser();
			if($this->getCodigo() == '')
				$this->usuario->senha	= $this->getSenha();
			$this->usuario->cor			= $this->getCor();
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$result = $this->usuario->store();

			TTransaction2::close();

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	/*
	 *	Método alteraSenha
	 *	Altera a senha do Usuario
	 *	Usado em IFRAMES
	 */
	public function alteraSenha()
	{
		try
		{
			$this->usuario = new kanban_usuario2();
			
			$this->usuario->codigo		= $_SESSION['usuario']->codigo;
			$this->usuario->nome		= $_SESSION['usuario']->nome;
			$this->usuario->usuario		= $_SESSION['usuario']->usuario;
			$this->usuario->senha		= $this->getSenha();
			$this->usuario->cor			= $_SESSION['usuario']->cor;
			
			//RECUPERA CONEXAO BANCO DE DADOS
			TTransaction2::open('my_bd_site');

			$result = $this->usuario->store();
			
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