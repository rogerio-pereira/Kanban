<?php 
	session_start();
	header("Content-Type:text/html; charset=UTF-8",true) 
?>

<?php
/*
 * 	Classe  controladorLogin
 * 	#RESUMO DA CLASSE#
 * 	
 * 	Sistema:	Kanban
 * 	Autor:		Rogério Eduardo Pereira
 * 	Data:		Sep 1, 2014
 */

/*
 * Classe login
 */
class controladorLogin
{
	/*
	 * Variaveis
	 */
	private $controladorUsuario;
	private $usuarioBD;
	private $usuario;
	private $senha;
	
	public function getUsuario()
	{
		return $this->usuario;
	}
	public function getSenha()
	{
		return $this->senha;
	}
	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}
	public function setSenha($senha)
	{
		$this->senha = md5($senha.'K4/\/b@n');
	}
	

	/*
	 * Método construtor
	 */
	public function __construct()
	{		
		new session();
		$this->controladorUsuario	= new controladorUsuario();
		$this->usuario				= NULL;
	}
	
	/*
	 * Método login
	 * Realiza o login
	 */
	public function login()
	{
		$this->usuarioBD  = $this->controladorUsuario->getUsuarioByUser2($this->getUsuario());
		
		if($this->compara())
		{
			$_SESSION['usuario'] = $this->usuarioBD;
			
			return true;
		}
		else
			return false;
	}
	
	/*
	 * Método compara
	 * Compara usuario e senha
	 */
	private function compara()
	{	
		if  (
				($this->usuario == $this->usuarioBD->usuario) &&
				($this->senha   == $this->usuarioBD->senha)
			)
		{
			return true;
		}
		else
			return false;
	}
}
?>