<?php

    /*
     *  Classe TTransaction
     *  Esta classe prove os mщtodos necessarios para manipular transaчуoes
     *  Atomicidade
     *  Consistencia
     *  Isolamento
     *  Durabilidade
     */
    final class TTransaction2
    {
        private static $conn;   //Conexуo Ativa
        private static $logger; //Objeto de LOG
        
        /*
         *  Mщtodo __construct
         *  Estс declarado como private para impedir que se crie instancias de TTransaction
         */
        private function __construct()
        {
            
        }
        
        /*
         *  Mщtodo open()
         *  Abre uma transaчуo e uma conexуo ao Banco de Dados
         *  @param $database = nome do banco de dados
         */
        public static function open($database)
        {
            //Abre uma conexуo e armazena na propriedade estatica $conn
            if(empty(self::$conn))
            {
                self::$conn = TConnection2::open($database);
                //Inicia transaчуo
                self::$conn->beginTransaction();
                //Desliga o log do SQL
                self::$logger = NULL;
            }
        }
        
        /*
         *  Mщtodo get()
         *  retorna a conexуo ativa da transaчуo
         */
        public static function get()
        {
            //Retorna a conexуo ativa
            return self::$conn;
        }
        
        /*
         *  Metodo rollback()
         *  Desfaz todas operaчѕes realizadas na transaчуo
         */
        public static function rollback()
        {
            if(self::$conn)
            {
                //Desfaz as operaчѕes realizadas durante a transaчуo
                self::$conn->rollBack();
                self::$conn = NULL;
            }
        }
        
        /*
         *  Mщtodo close()
         *  Aplica todas as operaчѕes realizadas e fecha a transaчуo
         */
        public static function close()
        {
            if(self::$conn)
            {
                //Aplica as operaчѕes realizadas durante a transaчуo
                self::$conn->commit();
                self::$conn = NULL;
            }
        }
        
        /*
         *  Mщtodo setLogger()
         *  Armazena uma mensagem no arquivo de LOG
         *  Baseada a estratщgia ($logger) atual
         */
        public static function setLogger(TLogger $logger)
        {
            self::$logger = $logger;
        }
        
        /*
         *  Mщtodo log()
         *  Armazena uma mensagem no arquivo de LOG
         *  Baseada na estratщgia ($logger) atual
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