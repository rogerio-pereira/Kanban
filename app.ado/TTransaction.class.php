<?php

    /*
     *  Classe TTransaction
     *  Esta classe prove os métodos necessarios para manipular transaçãoes
     *  Atomicidade
     *  Consistencia
     *  Isolamento
     *  Durabilidade
     */
    final class TTransaction
    {
        private static $conn;   //Conexão Ativa
        private static $logger; //Objeto de LOG
        
        /*
         *  Método __construct
         *  Está declarado como private para impedir que se crie instancias de TTransaction
         */
        private function __construct()
        {
            
        }
        
        /*
         *  Método open()
         *  Abre uma transação e uma conexão ao Banco de Dados
         *  @param $database = nome do banco de dados
         */
        public static function open($database)
        {
            //Abre uma conexão e armazena na propriedade estatica $conn
            if(empty(self::$conn))
            {
                self::$conn = TConnection::open($database);
                //Inicia transação
                self::$conn->beginTransaction();
                //Desliga o log do SQL
                self::$logger = NULL;
            }
        }
        
        /*
         *  Método get()
         *  retorna a conexão ativa da transação
         */
        public static function get()
        {
            //Retorna a conexão ativa
            return self::$conn;
        }
        
        /*
         *  Metodo rollback()
         *  Desfaz todas operações realizadas na transação
         */
        public static function rollback()
        {
            if(self::$conn)
            {
                //Desfaz as operações realizadas durante a transação
                self::$conn->rollBack();
                self::$conn = NULL;
            }
        }
        
        /*
         *  Método close()
         *  Aplica todas as operações realizadas e fecha a transação
         */
        public static function close()
        {
            if(self::$conn)
            {
                //Aplica as operações realizadas durante a transação
                self::$conn->commit();
                self::$conn = NULL;
            }
        }
        
        /*
         *  Método setLogger()
         *  Armazena uma mensagem no arquivo de LOG
         *  Baseada a estratégia ($logger) atual
         */
        public static function setLogger(TLogger $logger)
        {
            self::$logger = $logger;
        }
        
        /*
         *  Método log()
         *  Armazena uma mensagem no arquivo de LOG
         *  Baseada na estratégia ($logger) atual
         */
        public static function log($message)
        {
            //Verifica se existe um logger
            if(self::$logger)
            {
                self::$logger->write($message);
            }
        }
    }
    
?>