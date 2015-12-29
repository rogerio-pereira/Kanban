<?php

    /*
     *  Classe TSqlUpdate
     *  Esta classe provê meios para manipulação de uma instrução UPDATE do banco de dados
     */
    final class TSqlUpdate extends TSqlInstruction
    {
        private $columnValues;
        
        /*
         *  Método setRowData()
         *  Atribui valores à determinadas colunas no banco de dados que serão modificados
         *  @param $column  = Coluna da tabela
         *  @param $value   = Valor a ser armazenado
         */
        public function setRowData($column, $value)
        {
            //Verifica se é um dado escalar (string, inteiro, etc...)
            if(is_scalar($value))
            {
                if(is_string($value) and (!empty($value)))
                {
                    //Adiciona \ em aspas
                    $value = addslashes($value);
                    
                    //Caso seja uma string
                    $this->columnValues[$column] = "'$value'";
                }
                else if(is_bool($value))
                {
                    //Caso seja um boolean
                    $this->columnValues[$column] = $value ? 'TRUE' : 'FALSE';
                }
                else if($value !== '')
                {
                    //Caso seja outro tipo de dado
                    $this->columnValues[$column] = $value;
                }
                else
                {
                    //Caso seja NULL
                    $this->columnValues[$column] = "NULL";
                }
            }
        }
        
        /*
         *  Método getInstruction()
         *  Retorna a instrução de UPDATE em forma de string
         */
        public function getInstruction()
        {
            //Monta a string de UPDATE
            $this->sql = "UPDATE {$this->entity[0]}";
            
            //Monta os pares: coluna=valor,...
            if($this->columnValues)
            {
                foreach($this->columnValues as $column => $value)
                {
                    $set[] = "{$column} = {$value}";
                }
            }
            
            $this->sql .= ' SET ' . implode(', ', $set);
            
            //Retorna a clausula WHERE do objeto $this->criteria
            if($this->criteria)
            {
                $this->sql .= ' WHERE ' . $this->criteria->dump();
            }
            
            return $this->sql;
        }
    }
    
?>