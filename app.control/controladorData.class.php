<?php

/*
 * 	Classe  controladorData
 * 	Converte a data de MySql Para formato brasileiro e vice-versa
 * 	
 * 	Sistema:	Kanban
 * 	Autor:	Rogério Eduardo Pereira
 * 	Data:	Aug 28, 2014
 */

/*
 * Classe ControladorData
 */
class controladorData
{
	/*
	 * Variaveis
	 */
	private $data;

	/*
	 * Método construtor
	 */
	public function __construct()
	{
		
	}
	
	/*
	* Método converteData
	* Converte uma data Sql par Brasileiro
	* Converte data Brasileiro para sql
	* @param $data = Data a ser convertida
	*/
	public function converteData($data)
	{
	   $array		= array();
	   $convertido	= NULL;

	   //Data no formato Brasileiro
	   if(strstr($data, '/'))
	   {
		   $array      = explode('/', $data);
		   $convertido    = $array[2] . '-' . $array[1] . '-' . $array[0];
	   }
	   //Data SQL
	   if(strstr($data, '-'))
	   {
		   $array      = explode('-', $data);
		   $convertido    = $array[2] . '/' . $array[1] . '/' . $array[0];
	   }
	   return $convertido;
	}
}
?>