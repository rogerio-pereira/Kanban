<?php

    /*
     *  Classe TSqlSelect
     *  Esta classe provê meios para manipulação de uma instrução de SELECT no banco de dados
     */
    final class TSqlSelect extends TSqlInstruction
    {
        private $columns;   //array de colunas a serem retornadas
        
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
         *  Método getInstruction()
         *  Retorna a instrução de SELECT em forma de string
         */
        public function getInstruction()
        {
            //Monta a instrução de SELECT
            $this->sql =    'SELECT ';
            //Monta uma string com os nomes das colunas
			if(count($this->columns) == 1)
				$this->sql .=   $this->columns[0];
			else
				$this->sql .=   implode(',', $this->columns);
			
            //Adiciona cláusula FROM o nome da tabela
			if(count($this->entity) == 1)
				$this->sql .=  ' FROM ' . $this->entity[0];
			else
				$this->sql .=  ' FROM ' . implode(',', $this->entity);
            
            //Obtem cláusula WHERE do objeto criteria
            if($this->criteria)
            {
                $expression = $this->criteria->dump();
                if($expression)
                {
                    $this->sql .= ' WHERE ' .$expression;
                }
                
                //Obtém as propriedades do critério
                $order  = $this->criteria->getProperty('order');
                $limit  = $this->criteria->getProperty('limit');
                $offset = $this->criteria->getProperty('offset');
                
                //Obtém a ordenação do SELECT
                if($order)
                {
                    $this->sql .= ' ORDER BY ' . $order;
                }
                //Obtém o limite
                if($limit)
                {
                    $this->sql .= ' LIMIT ' . $limit;
                }
                //Obtém o offset
                if($offset)
                {
                    $this->sql .= ' OFFSET ' . $offset;
                }
            }
            
            return $this->sql;
        }
    }
    
?>