<?php header("Content-Type:text/html; charset=UTF-8",true) ?>

<?php 
/*  
    Index
    Carrega o template e a pagina de acordo com o parametros class obtido via GET
    
    Sistema:    Kanban
    Autor:      Rogério Eduardo Pereira
    Data:       22/08/2014
*/

/*
 *  Funcao Autoload
 *  Carraga a classe quando for instanciada
 */
function __autoload($classe)
{
    $pastas = array('app.widgets', 'app.ado', 'app.config', 'app.model', 'app.control','app.view');
    foreach ($pastas as $pasta)
    {
        if (file_exists("{$pasta}/{$classe}.class.php"))
        {
            include_once "{$pasta}/{$classe}.class.php";
        }
    }
}

/*
 *  Classe TApllication
 *  Aplicacao Principal
 */
class TApplication
{
    /*
     *  Funcao run
     *  Carrega conteudo da pagina
     */
    static public function run()
    {
        new session;
        
        //Suprimir Warnings
		//error_reporting(E_WARNING);
		
		if(!isset($_SESSION['usuario']))
		{
			if ($_GET['class'])
				echo "
						<script>
							top.location='./';
						</script>
					";
			
			$pagina 	= new login;
			$pagina->show();
		}
		else
		{
			$template = new template;
			ob_start();
			$template->show();
			$template = ob_get_contents();
			ob_get_clean();

			$content = '';
			/*
			 *  Se tiver parametros na URL, carrega a classe
			 */
			if ($_GET)
			{
				$class = $_GET['class'];
				if (class_exists($class))
				{
					$pagina = new $class;
					ob_start();
					$pagina->show();
					$content = ob_get_contents();
					ob_end_clean();
				}
			}
			/*
			 * Caso nao tenha parametros na URL, carreaga padrao
			 */
			else
			{
				$pagina 	= new kanban;
				ob_start();
				$pagina->show();
				$content 	= ob_get_contents();
				ob_end_clean();				
			}
			/*
			 *  Susbstitui a string #CONTENT# do template para a pagina principal
			 */
			$site = str_replace('#CONTENT#', $content, $template);
			
			echo $site;
		}
    }
}
//new ContaVisitas();
TApplication::run();
?>

