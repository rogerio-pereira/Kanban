<?php

    /*
     *  Classe TExpression
     *  Classe abstrata para gerenciar expressões
     */
    abstract class TExpression
    {
        //Operadores Lógicos
        const AND_OPERATOR  = 'AND ';
        const OR_OPERATOR   = 'OR ';
        
        //Marca método dump como obrigatório
        abstract public function dump();
    }
    
?>