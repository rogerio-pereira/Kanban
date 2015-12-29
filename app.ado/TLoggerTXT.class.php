<?php

    /*
     *  classe TLoggerTXT
     *  implementa o algoritmo de LOG em HTML
     */
    class TLoggerTXT extends TLogger
    {
        /*
         *  Método write
         *  Escreve uma mensagem no arquivo de LOG
         *  @param $message = mensagem a ser escrita
         */
        public function write($message)
        {
            date_default_timezone_set('America/Sao_Paulo');
            $time = date("Y-m-d H:i:s");
            //Monta a String
            $text = "$time :: $message\n";
            
            //Adiciona no final do arquivo
            $handler = fopen($this->filename, 'a');
            fwrite($handler, $text);
            fclose($handler);
        }
    }    
?>