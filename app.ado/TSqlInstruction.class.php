<?php

    /*
     *  Classe TSqlInstruction
     *  Esta classe provê os métodos em comum entre todas instruções
     *  SQL (SELECT, INSERT, DELETE, UPDATE)
     */
    
    abstract class TSqlInstruction
    {
        protected $sql;         //Armazena a instrução SQL
        protected $criteria;    //Armazena o objeto critério
        protected $entity;      //Nome do Banco de Dados
        
        /*
         *  Método setEntity()
         *  Define o nome da entidade (tabela) manipulada pela instrução SQL
         *  @param $entity = tabela
         */
        final public function addEntity($entity)
        {
            $this->entity[] = $entity;
        }
        
        /*
         *  Método getEntity()
         *  Retorna o nome da entidade (tabela)
         */
        final public function getEntity()
        {
            return $this->entity;
        }
        
        /*
         *  Método setCriteria
         *  Define um critério de seleção dos dados através da composição de um objeto
         *  do tipo TCriteria, que oferece uma interface para definição de critérios
         *  @param $criteria = objeto do tipo TCriteria
         */
        public function setCriteria(TCriteria $criteria)
        {
            $this->criteria = $criteria;
        }
        
        /*
         *  Método getInstruction
         *  Declarando-o como <abstract> obrigamos sua declaração nas classes filhas,
         *  uma vez declarado que seu comportamento será distinto em cada uma delas,
         *  configurando polimorfismo
         */
        abstract function getInstruction();
    }
    
?>