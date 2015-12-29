<?php 
	session_start();
	header("Content-Type:text/html; charset=UTF-8",true) 
?>

<?php

/*
 * 	Classe  controladorAlterarSenha
 * 	#RESUMO DA CLASSE#
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Sep 3, 2014
 */

/*
 * Classe controladorAlterarSenha
 */
class controladorAlterarSenha
{
	/*
	 * Variaveis
	 */
	private $controladorUsuario;
	private $usuario;
	private $senhaAtual;
	private $senhaNova;
	
	public function getSenhaAtual()
	{
		return $this->senhaAtual;
	}
	public function getSenhaNova()
	{
		return $this->senhaNova;
	}
	public function setSenhaAtual($senhaAtual)
	{
		$this->senhaAtual = $senhaAtual;
	}
	public function setSenhaNova($senhaNova)
	{
		$this->senhaNova = $senhaNova;
	}
	

	/*
	 * Método construtor
	 */
	public function __construct()
	{
		$this->controladorUsuario	= new controladorUsuario();
		
		$this->usuario				= $_SESSION['usuario'];
		$this->senhaAtual			= NULL;
		$this->senhaNova			= NULL;	
	}
	
	/*
	 * Método compara
	 * Compara a senha nova com a senha atual
	 */
	public function compara()
	{
		if(md5($this->getSenhaAtual().'K4/\/b@n') == $this->usuario->senha)
			return true;
		else
			return false;
	}
	
	public function altera()
	{
		$this->controladorUsuario->setSenha($this->getSenhaNova());
		
		if($this->controladorUsuario->alteraSenha() == true)
			return true;
		else
			return false;
	}
}
?>