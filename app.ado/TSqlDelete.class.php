<?php

    /*
     *  Classe TSqlDelete
     *  Esta classse provê meios para manipulação de uma instrução de DELETE no banco de dados
     */
    final class TSqlDelete extends TSqlInstruction
    {
        /*
         *  Método getInstruction
         *  Retorna a instrução DELETE em forma de string
         */
        public function getInstruction()
        {
            //Monta a string de DELETE
            $this->sql = "DELETE FROM {$this->entity[0]}";
            
            //Retorna a clausula WHERE do objeto $this->criteria
            if($this->criteria)
            {
                $expression = $this->criteria->dump();
                
                if($expression)
                {
                    $this->sql .= ' WHERE ' . $expression;
                }
            }
            
            return $this->sql;
        }
    }
    
?>