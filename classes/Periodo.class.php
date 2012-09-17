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
class Periodo {

    //put your code here

    public $id_periodo;
    public $nome_periodo;

    public function __construct($nome_periodo= "") {
        $this->nome_periodo = $nome_periodo;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarPeriodo() {
        if ($this->nome_periodo == ""):
            Alerta::alertarUsuario("Digite o nome da Periodo.");
            return false;
        endif;

        if ($this->existePeriodo()):
            Alerta::alertarUsuario("Esse periodo já esta cadastrado.", 0);
        else:
            //INSERT INTO `periodos` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `periodos` ( `nome_periodo`) VALUES ( '$this->nome_periodo')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Periodo Cadastrada com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Periodos.", 0);
                return false;
            endif;
        endif;
    }

    function existePeriodo() {
        //Localiza o Periodo e set Variaveis
        $query = "SELECT id_periodo FROM `periodos` WHERE nome_periodo = '$this->nome_periodo'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarPeriodo() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_periodo, nome_periodo FROM `periodos` ORDER BY id_periodo ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_periodo = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_periodo[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_periodo;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarPeriodo($id_periodo) {
        //Localiza o Periodo e set Variaveis
        $query = "SELECT id_periodo, nome_periodo FROM `periodos` WHERE `id_periodo` = '$id_periodo'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do Periodo */
            $periodo = mysql_fetch_array($resultado);
            $this->id_periodo = $periodo['id_periodo'];
            $this->nome_periodo = $periodo['nome_periodo'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarPeriodo() {
        $query = "DELETE FROM `periodos` WHERE `periodos`.`id_periodo` = $this->id_periodo";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Periodo $this->nome_periodo com o id: $this->id_periodo foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Periodo, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
