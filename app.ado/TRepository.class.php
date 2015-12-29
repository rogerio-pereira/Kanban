<?php

	final class TRepository
	{
	
		private $class;
		private $columns;
		private $entity;
	
		function __construct()
		{
			
		}
		
		/*
         *  Método addColumn
         *  Adiciona uma coluna a ser retornada pelo SELECT
         *  @param $column = Coluna da Tabela
         */
        public function addColumn($column)
        {
            //Adiciona coluna no array
            $this->columns[] = $column;
        }
		
		/*
         *  Método setEntity()
         *  Define o nome da entidade (tabela) manipulada pela instrução SQL
         *  @param $entity = tabela
         */
        final public function addEntity($entity)
        {
            $this->entity[] = $entity;
        }
		
		function load(TCriteria $criteria)
		{
			$sql = new TSqlSelect;
			
			//Colunas
			if(count($this->columns) == 1)
				$sql->addColumn($this->columns[0]);
			else
				foreach ($this->columns as $coluna)
					$sql->addColumn($coluna);
			
			
			//Entidade
			if(count($this->entity) == 1)
				$sql->addEntity($this->entity[0]);
			else
				foreach ($this->entity as $entidade)
					$sql->addEntity($entidade);
			
			
			//Criteria
			$sql->setCriteria($criteria);
						
			if ($conn = TTransaction::get()) 
			{	
				$result = $conn->query($sql->getInstruction());
				$results= array();
				
				if ($result)
				{
					while($row = $result->fetchObject(get_class($this)))
					{
						$results[] = $row;
					}
				}
				
				return $results;
			}
			else 
			{
				throw new Exception('Não há transação ativa!');
			}
		}
		
		/*
		 * m�todo delete()
		 * Exclui um conjunto de objetos (collection) da base de dados
		 * atrav�s de um crit�rio de sele��o
		 * @param $crteria = objeto do tipo TCriteria
		 */
		function delete(TCriteria $criteria)
		{
			$sql = new TSqlDelete;
			$sql->addEntity($this->entity[0]);
			$sql->setCriteria($criteria);
			
			if ($conn = TTransaction::get()) 
			{				
				$result = $conn->exec($sql->getInstruction());
				
				return $result;
			}
			else 
			{
				throw new Exception('Não há transação ativa!');
			}	
		}
		
		/*
		 * método count()
		 */
		function count(TCriteria $criteria)
		{
		
			$sql = new TSqlSelect;
			$sql->addColumn(' count(*) ');
			$sql->addEntity($this->entity[0]);
			$sql->setCriteria($criteria);
			
			if ($conn = TTransaction::get()) 
			{
				$result = $conn->query($sql->getInstruction());
				
				if ($result)
				{
					$row = $result->fetch();
				}
				
				return $row[0];
			}
			else 
			{
				throw new Exception('Não há transação ativa!');
			}	
		}
	}
?>