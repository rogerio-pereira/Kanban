<?php

    /*
     *  Classe TLogger
     *  Esta classe provê uma interface abstrata para a definição de algoritmos de LOG
     */
    abstract class TLogger
    {
        protected $filename; //Local do arquivo de LOG
        
        /*
         *  Método __contruct()
         *  Instancia um novo logger
         *  @param $filename = local do arquivo de LOG
         */
        public function __construct($filename)
        {
            $this->filename = $filename;
            
            //Reseta o conteudo do arquivo
            file_put_contents($filename, '');
        }
        
        //Define o método write como obrigatório
        abstract function write($message);
    }
    
?>