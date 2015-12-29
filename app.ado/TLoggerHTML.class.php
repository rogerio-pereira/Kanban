<?php

    /*
     *  classe TloggerHTML
     *  implementa o algoritmo de LOG em HTML
     */
    class TLoggerHTML extends TLogger
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
            $text = "<p>\n";
            $text .= "  <b>$time</b> : \n";
            $text .= "  <i>$message</i> <br> \n";
            $text .= "</p>\n";
            
            //Adiciona no final do arquivo
            $handler = fopen($this->filename, 'a');
            fwrite($handler, $text);
            fclose($handler);
        }
    }    
?>