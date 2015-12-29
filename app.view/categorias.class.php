<?php

/*
 * 	Classe  categorias
 * 	Exibe todas as categorias, opções para alterar, cadastrar e excluir
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Sep 1, 2014
 */

/*
 * Classe categorias
 */
class categorias
{
	/*
	 * Variaveis
	 */
	private $collectionCategorias;
	private $control;

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
			$this->control				= new controladorCategoria;
			$this->collectionCategorias	= $this->control->getCategorias();
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
			class='formularioCategorias' 
			id='formularioCategorias'
			name="categorias" 
			method="post" 
			action="app.control/ajax.php"
		>
			<input type="hidden" id="action" name="action"/>
			<fieldset>
				<legend>Categorias</legend>
				<table class='tabela-categorias'>
					<?php
						foreach ($this->collectionCategorias as $categoria)
						{
							echo
								"
									<!--{$categoria->nome}-->
									<tr>
										<td>
											<input type='radio' name='radioCategoria' id='radioCategoria' value='$categoria->codigo'>
										</td>
										<td>
											{$categoria->nome}
										</td>
										<td>
											<div style='background-color: {$categoria->cor}; width: 50px'>&nbsp;</div>
										</td>
										<td style='text-align: center;'>
											<input type='checkbox' name='categoriasApagar[]' class='chkCategoriasApagar' value='{$categoria->codigo}'>
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
							<input type='button' value='Nova'		onclick='novaCategoria()'>
							<input type='button' value='Alterar'	onclick='alteraCategoria()'>

							<?php
								if(count($this->collectionCategorias) > 0)
									echo "<input type='button' value='Apagar' onclick='apagaCategorias()'>";
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