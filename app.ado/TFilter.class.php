<?php
   
   /*
     *  Classe TFilter
     *  Esta classe provê uma interface para definições de fitros de seleção
     */
    class TFilter extends TExpression
    {
        private $variable;  //Variável
        private $operator;  //Operador
        private $value;     //Valor
        
        /*
         *  Método __contruct()
         *  Instancia um novo Filtro
         *  @param $variable    = variável;
         *  @param $operator    = operador (<,>)
         *  @param $value       = valor a ser comparado
         */
        public function __construct($variable, $operator, $value)
        {
            //Armazena as propriedades
            $this->variable = $variable;
            $this->operator = $operator;
            
            //Trasnforma o valor de acordo com certas regras
            //Antes de atribuir à proprieade $this->value
            $this->value    = $this->transform($value);
        }
        
        /*
         *  Método transform()
         *  Recebe um valor a faz as modificações necessárias
         *  para ele se interceptado pelo banco de dados
         *  podendo ser um integer/string/boolean ou array
         *  @param $value = valor a ser transformado
         */
        private function transform($value)
        {
            //Caso seja um array
            if(is_array($value))
            {
                //Percorre os valores
                foreach($value as $x)
                {
                    //Se for inteiro
                    if(is_integer($x))
                    {
                        $foo[] = $x;
                    }
                    //Se for string
                    else if (is_string($x))
                    {
                        //Se for string, adiciona aspas
                        $foo[] = "'$x'";
                    }
                }
                
                //Converte o array em string separada por ","
                $result = '(' . implode(',' , $foo) . ')';
            }
            
            //Caso seja uma string
            else if(is_string($value))
            {
                /*
				 * Verifica se tem ponto na string
				 *		Se tiver esta comparando duas tabelas
				 */
				if(strpos($value, '.') == FALSE)
				{
					//Adiciona aspas
					$result = "'$value'";
				}
				else
				{
					//Adiciona string normal
					$result = $value;
				}
            }
            
            //Caso seja um valor nulo
            else if(is_null($value))
            {
                //Armazena NULL
                $result = 'NULL';
            }
            
            //Caso seja booleano
            else if(is_bool($value))
            {
                //Armazena TRUE ou FALSE
                $result = $value ? 'TRUE' : 'FALSE';
            }
            
            //Nenhum caso acima
            else
            {
                $result = $value;
            }
            
            return $result;
        }
        
        /*
         *  Método dump()
         *  Retorna o filtro em forma de expressão
         */
        public function dump()
        {
            //Concatena a expressão
            return "{$this->variable} {$this->operator} {$this->value}";
        }
    }
?>