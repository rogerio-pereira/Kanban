<?php

    /*
     *  Classe TSqlInsert
     *  Esta classe provê meios para aipulação de uma instrução de INSERT no banco de dados
     */
    final class TSqlInsert extends TSqlInstruction
    {
        private $columnValues;
        
        /*
         *  Método setRowData()
         *  Atribui valores à determinadas colunas no banco de dados que serão inseridas
         *  @param $column  = Coluna da tabela
         *  @param @value   = Valor a ser armazenado
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
         *  Método setCriteria()
         *  Não existe no contexto desta classe, logo, irá lançar um erro se for executado
         */
        public function setCriteria(TCriteria $criteria)
        {
            //Lança o erro
            throw new Exception("Cannot call setCriteria from " . __CLASS__);
        }
        
        /*
         *  Método getInstruction()
         *  Retorna a instrução de INSERT em forma de string
         */
        public function getInstruction()
        {
            $this->sql  = "INSERT INTO {$this->entity[0]} (";
            //Monta uma string contendo os nomes de colunas
            $colunas    = implode(', ', array_keys($this->columnValues));
            //Monta uma string contendo os valores
            $values     = implode(', ', array_values($this->columnValues));
            //Concatena tudo
            $this->sql .= $colunas . ')';
            $this->sql .= " VALUES ({$values})";
            return $this->sql;
        }
    }
    
?>