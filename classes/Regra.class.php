<?php

include_once "AutoLoad.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aluno
 *
 * @author Gabriel
 */
class Regra {

    //put your code here

    public $id_regra;
    public $nome_regra;

    public function __construct($nome_regra= "") {
        $this->nome_regra = $nome_regra;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarRegra() {
        if ($this->nome_regra == ""):
            Alerta::alertarUsuario("Digite o nome da Regra.");
            return false;
        endif;

        if ($this->existeRegra()):
            Alerta::alertarUsuario("Essa Regra já foi cadastrada.", 0);
        else:

            //INSERT INTO `cursos` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `regras` ( `nome_regra`) VALUES ( '$this->nome_regra')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Regra Cadastrada com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Regras.");
                return false;
            endif;
        endif;
    }

    function existeRegra() {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_regra FROM `regras` WHERE nome_regra = '$this->nome_regra'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarRegra() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_regra, nome_regra FROM `regras` ORDER BY id_regra ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_regra = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_regra[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_regra;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarRegra($id_regra) {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_regra, nome_regra FROM `regras` WHERE `id_regra` = '$id_regra'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $curso = mysql_fetch_array($resultado);
            $this->id_regra = $curso['id_regra'];
            $this->nome_regra = $curso['nome_regra'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarRegra() {
        $query = "DELETE FROM `regras` WHERE `regras`.`id_regra` = $this->id_regra";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Regra $this->nome_regra com o id: $this->id_regra foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Regra, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
