<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Banco
 *
 * @author Gabriel
 */
class Banco {

    private static $instacia_banco;
    private $servidor;
    private $banco;
    private $usuario;
    private $senha;
    private $conexao;

    private function __construct() {
        /*
         * Caso seja no servido de Hospedagem ele vai deixar uma confg
         * Caso seja localhost ele vai ter outra cfg
         */
        switch ($_SERVER['HTTP_HOST']):
        case "gabrielmatsuoka.net":
                $this->servidor = "localhost";
                $this->banco = "gac";
                $this->usuario = "root";
                $this->senha = "gabr1241992iel";
                break;
	    case "gabrielmatsuoka.co.cc":
                $this->servidor = "localhost";
                $this->banco = "gac";
                $this->usuario = "root";
                $this->senha = "gabr1241992iel";
                break;
            default:
                $this->servidor = "localhost";
                $this->banco = "gac";
                $this->usuario = "root";
                $this->senha = "";
        endswitch;
        $this->conectarBanco();
    }

    public static function instanciarBanco() {
        /* Forçamos a ter apenas uma instancia de Banco, logo temos apenas uma conexao aberta */
        if (!isset(self::$instacia_banco)) {
            self::$instacia_banco = new self;
        }

        return self::$instacia_banco;
    }

    private function conectarBanco() {
        //Efetuando conexão ao banco
        $this->conexao = mysql_connect($this->servidor, $this->usuario, $this->senha);

        if ($this->conexao):
            return true;
        else:
            return false;
        endif;
    }

    private function selecionarBanco() {
        //Selecionando Banco de dados
        mysql_select_db($this->banco, $this->conexao) or die('Query failed: ' . mysql_error());
    }

    public function executarQuery($query) {
        $this->selecionarBanco();
        $executar = mysql_query($query) or die('Query failed: ' . mysql_error());

        return $executar;
    }

    public function teveRetorno($query) {
        //verifica se a query teve retorno maior doque 0 registros, caso tenha retorna true se não false.
        if (mysql_num_rows($query) > 0)
            return true;
        else
            return false;
    }

    public function getBanco() {
        return $this->banco;
    }
    
    public static function ultimoId(){
        return mysql_insert_id();
    }

}

?>
