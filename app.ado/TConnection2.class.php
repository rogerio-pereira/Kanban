<?php

/*
 *  Classe TConnection
 *  Gerencia conexões com o banco de dados através de arquivos de configuracao (*.ini)
 */
final class TConnection2
{
    /*
     *  Método __contruct()
     *  Não existirão instancias de TConnection, por isso estamos marcando-o como private
     */
    private function __construct() 
    {
        
    }
    
    /*
     *  Método open()
     *  Recebe o nome do banco de dados e instancia o objeto PDO correspondente
     */
    public static function open($name)
    {
        //Verifica se existe arquivo de configuração para este banco de dados
        if(file_exists("../app.config/{$name}.ini"))
        {
            //Le o arquivo INI e retorna um array
            $db = parse_ini_file("../app.config/{$name}.ini");
        }
        else
        {
            //Se nao existir lança um erro
            throw new Exception("Arquivo '$name' não encontrado");
        }
        
        //Le as informações contidas no arquivo
        $user = isset($db['user']) ? $db['user'] : NULL;
        $pass = isset($db['pass']) ? $db['pass'] : NULL;
        $name = isset($db['name']) ? $db['name'] : NULL;
        $host = isset($db['host']) ? $db['host'] : NULL;
        $type = isset($db['type']) ? $db['type'] : NULL;
        $port = isset($db['port']) ? $db['port'] : NULL;
        
        //Descobre qual o tipo (driver) de banco de dados a ser utilizado
        switch($type)
        {
            //Postgress
            case 'pgsql':
                $port = $port ? $port : '5432';
                //Não pode quebrar linhas nos parametros
                $conn = new PDO("pgsql:dbname={$name};user={$user};password={$pass};host=$host;port={$port}");
                break;
            //Mysql
            case 'mysql':
                $port = $port ? $port : '3306';
                //Não pode quebrar linhas nos parametros
                $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}",$user,$pass);
                break;
            //Sqlite
            case 'sqlite':
                //Não pode quebrar linhas nos parametros
                $conn = new PDO("sqlite:{$name}");
                break;
            //Ibase
            case 'ibase':
                //Não pode quebrar linhas nos parametros
                $conn = new PDO("firebird:dbname={$name}", $user,$pass);
                break;
            //Oci8
            case 'oci8':
                //Não pode quebrar linhas nos parametros
                $conn = new PDO("oci:dbname={$name}",$user,$pass);
                break;
            //Microsoft Sql
            case 'mssql':
                //Não pode quebrar linhas nos parametros
                $conn = new PDO("mssql:host={$host},1433;dbname={$name}",$user,$pass);
                break;
        }
        
        //Define para que o PDO lance exceções a ocorrência de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        //Retorna o objeto instanciado
        return $conn;
    }
}

?>