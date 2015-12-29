<?php

/*	
	Classe kanban
	Exibe o Kanban
	
	Sistema:	Kanban
	Autor: 		Rogério Eduardo Pereira
	Data: 		22/08/2014
*/
class kanban
{
	/*
		Variaveis
	*/
	private $controladorSituacao;
	private $controladorTarefa;
	private $controladorData;
	private $controladorCategoria;
	private $controladorUsuario;
	
	private $collectionSituacao;
	private $collectionTarefas;
	private $collectionTarefasCodigo;
	
	private $dataCriacao;
	private $categoria;
	private $usuario;


	/*
		Método construtor
	*/
	public function __construct()
	{	
		new session();
        
		if(!isset($_SESSION['usuario']))
		{
			echo "
				<script>
					top.location='../?class=login';
				</script>
			";
		}
		else
		{
			$this->controladorSituacao		= new controladorSituacao();
			$this->controladorTarefa		= new controladorTarefa();
			$this->controladorData			= new controladorData();
			$this->controladorCategoria		= new controladorCategoria();
			$this->controladorUsuario		= new controladorUsuario();

			$this->collectionSituacao		= $this->controladorSituacao->getSituacoes();
			$this->collectionTarefas		= NULL;
			$this->collectionTarefasCodigo	= NULL;
		}
	}


	/*
		Método show
		Exibe as informações da página
	*/
	public function show()
	{
		/*<div class='situacao-content'>
			<ul class='situacao-list'>
				<li class='situacao-box'>	
					<div class='situacao-titulo'>
						<h1>Situação<h1>	
					</div>
					
					<div class='tarefa'>
						<h1>Tarefa<h1>
						<div class='tarefa-desc'>
							Criação<br>
							Categoria<br>
							Usuario<br>
							Prioridade
						</div>
					</div>
				</li>			
			</ul>
		</div>
            
		<!--<script>
			
			//Esconde todos os box
			$(".tarefa-desc").hide();

			//BOX
			$(".tarefa").hover(function()
			{
				$(".tarefa-desc").toggle(150);
			});
  
		</script>*/
		
		//Inicia Div e Lista
		echo	"
					<div class='situacao-content'>
						<ul class='situacao-list'>
				";
		foreach ($this->collectionSituacao as $situacao) 
		{
			//Inicia cada situação (item de lista
			echo	"
							<li class='situacao-box'>	
								<div class='situacao-titulo'>
									<h1>{$situacao->nome}<h1>	
								</div>
					";
									
			//Busca todas as tarefas da situação
			$this->collectionTarefas = $this->controladorTarefa->getTarefas($situacao->codigo);
			
			//Percorre todas as tarefas
			foreach ($this->collectionTarefas as $tarefa)
			{
				$corCategoria	= '#f2ffb3';
				$usuario		= 'Não definido';
				$corUsuario		= ''	;
				$prioridade		= "<span style='background-color: #00BFFF; color: #272822; padding: 0px 15px 0px 15px;'>Prioridade Não Definida</span>";
				
				
				//Busca Categoria
				$this->categoria = $this->controladorCategoria->getCategoria($tarefa->categoria);
				
				//Busca Usuario
				$this->usuario	= $this->controladorUsuario->getUsuario($tarefa->usuario);
				
				//Converte Data de Criação
				$this->dataCriacao = $this->controladorData->converteData($tarefa->criacao);
				
				
				
				if($tarefa->prioridade == 3)
					$prioridade = "<span style='background-color: red; color: #e4e0e0; padding: 0px 30px 0px 30px;'>Alta</span>";
				else if($tarefa->prioridade == 2)
					$prioridade = "<span style='background-color: yellow; color: #272822; padding: 0px 30px 0px 30px;'>Média</span>";
				else if($tarefa->prioridade == 1)
					$prioridade = "<span style='background-color: green; color: #e4e0e0; padding: 0px 30px 0px 30px;'>Baixa</span>";
					
				
				
				if(isset($tarefa->categoria))
					if($this->categoria->cor != NULL)
						$corCategoria = $this->categoria->cor;
					
				
				if(isset($tarefa->usuario))
				{
					if($this->usuario->cor != NULL)
						$usuario = "<span style='background-color: {$this->usuario->cor}; padding: 0px 15px 0px 15px;'>{$this->usuario->nome}</span>";
					else
						$usuario = $this->usuario->nome;
				}
				
				//echo $corCategoria;
				
				$this->collectionTarefasCodigo[] = $tarefa->codigo;
				
				echo	"
							<a href='app.view/tarefa.class.php?cod={$tarefa->codigo}' class='ajax' title='Tarefa Cod: {$tarefa->codigo}' onClick='toTop()'>
								<div class='tarefa' id='tarefa_{$tarefa->codigo}' style='background-color: {$corCategoria};'>
									<h1>{$tarefa->nome}<h1>
									<div class='tarefa-desc' id='tarefa-desc_{$tarefa->codigo}'>
										Criação: &nbsp;&nbsp;&nbsp;&nbsp;{$this->dataCriacao}<br>
										Usuario: &nbsp;&nbsp;&nbsp;&nbsp;{$usuario}<br>
										Prioridade: {$prioridade}
									</div>
								</div>
							</a>
						";
				
			}
			//Termina o item da Lista
			echo	'		</li>';
		}
		//Termina Lista e Div principal
		echo	'
						</ul>
					</div>
				';
		
		//Script para esconder as informações das Tarefas
		echo '<script>';
		
		foreach ($this->collectionTarefasCodigo as $codigo)
		{
			echo "$('#tarefa-desc_{$codigo}').hide();";
		}
		
		foreach ($this->collectionTarefasCodigo as $codigo)
		{
			echo"
					$('#tarefa_{$codigo}').hover(function()
					{
						$('#tarefa-desc_{$codigo}').toggle(200);
					});
				";
		}
		
		echo '</script>';
	}
}
?>