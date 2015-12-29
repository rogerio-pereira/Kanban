<?php

    /*
     *  Classe Tcriteria
     *  Essa classe provê uma interface utilizada para definir critérios
     */ 
    class TCriteria extends TExpression
    {
        private $expressions;   //Armazea a lista de expressões
        private $operators;     //Armazena a lista de operadores
        private $properties;    //Propriedades do critério
        
        /*
         *  Método __contrusct()
         */
        function __construct()
        {
            $this->expressions  = array();
            $this->operators    = array();
        }
        
        /*
         *  Método add()
         *  Adiciona uma expressão ao critério
         *  @param $expression  = expressão (objeto TExpression)
         *  @param $operator    = operador lógico de comparação 
         */
        public function add(TExpression $expression, $operator = self::AND_OPERATOR)
        {
            //Na primeira vez, não precisamos do operador lógico para concatenar
            if(empty($this->expressions))
            {
                $operator = NULL;
            }
            
            
            //Agrega o resultado da expressão à lista de expressões
            $this->expressions[]    = $expression;
            $this->operators[]      = $operator;
        }
        
        /*
         *  Método dump()
         *  Retorna a expressão final
         */
        public function dump()
        {
            //Concatena a lista de expressões
            if(is_array($this->expressions))
            {
                if(count($this->expressions) > 0)
                {
                    $result = '';
                
                    foreach($this->expressions as $i => $expression)
                    {
                        $operator = $this->operators[$i];
                        
                        //Concatena o operador com a respectiva expressão
                        $result .= $operator . $expression->dump() . ' ';
                    }
                    
                    $result = trim($result);
                    return "({$result})";
                }
            }
        }
        
        /*
         *  Método setProperty()
         *  Define o valor a da uma propriedade
         *  @param $property    = propriedade
         *  @param $value       = valor
         */
        public function setProperty($property, $value)
        {
            if(isset($value))
            {
                $this->properties[$property] = $value;
            }
            else
            {
                $this->properties[$property] = NULL;
            }
        }
        
        /*
         *  Método getProperty()
         *  Retorna o valor de uma propriedade
         *  @param $property = propriedade
         */
        public function getProperty($property)
        {
            if(isset($this->properties[$property]))
            {
                return $this->properties[$property];
            }
        }
    }
?>