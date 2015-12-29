<?php

/*
 * 	Classe  situacoes
 * 	Exibe todas as situações, opções para alterar, cadastrar e excluir
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Sep 1, 2014
 */

/*
 * Classe situacao
 */
class situacoes
{
	/*
	 * Variaveis
	 */
	private $collectionSituacao;
	private $controlador;

	/*
	 * Método construtor
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
			$this->controlador			= new controladorSituacao;
			$this->collectionSituacao	= $this->controlador->getSituacoes();
		}
	}
	
	/*
	 * Método show
	 * Exibe as informações na tela
	 */
	public function show()
	{
	?>
		<form 
			method='post' 
			class='formularioSituacoes' 
			id='formularioSituacoes'
			name="situacoes" 
			method="post" 
			action="app.control/ajax.php"
		>
			<input type="hidden" id="action" name="action"/>
			<input type="hidden" id="situacaoCodigo" name="subTarefaCod"/>
				<fieldset>
					<legend>Situações</legend>
					<table class='tabela-situacoes'>
						<?php
							foreach ($this->collectionSituacao as $situacao)
							{
								echo
									"
										<!--{$situacao->nome}-->
										<tr>
											<td>
												<input type='radio' name='radioSituacao' id='radioSituacao' value='$situacao->codigo'>
											</td>
											<td>
												{$situacao->nome}
											</td>
											<td>
												{$situacao->ordem}
											</td>
											<td style='text-align: center;'>
												<input type='checkbox' name='situacoesApagar[]' class='chkSituacoesApagar' value='{$situacao->codigo}'>
											</td>
										</tr>
									";
							}
						?>
						<tr>
							<td colspan='4'>
								<hr>
							</td>
						</tr>
						<tr>
							<td colspan='4' style='text-align: center'>
								<input type='button' value='Nova'		onclick='novaSituacao()'>
								<input type='button' value='Alterar'	onclick='alteraSituacao()'>
								
								<?php
									if(count($this->collectionSituacao) > 0)
										echo "<input type='button' value='Apagar' onclick='apagaSituacoes()'>";
								?>
							</td>
						</tr>
					</table>
				</fieldset>
		</form>
	<?php
	}
}
?>