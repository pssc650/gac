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
class Semestre {

    //put your code here

    public $id_semestre;
    public $nome_semestre;

    public function __construct($nome_semestre= "") {
        $this->nome_semestre = $nome_semestre;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarSemestre() {
        if ($this->nome_semestre == ""):
            Alerta::alertarUsuario("Digite o nome da Semestre.");
            return false;
        endif;
        //INSERT INTO `semestres` ( `nome`) VALUES ( 'teste');
        $query = "INSERT INTO `semestres` ( `nome_semestre`) VALUES ( '$this->nome_semestre')";

        if ($this->bd->executarQuery($query)):
            Alerta::alertarUsuario("Semestre Cadastrada com Sucesso.", 1);
            return true;
        else:
            Alerta::alertarUsuario("Não foi possível cadastrar o Semestres.");
            return false;
        endif;
    }

    function listarSemestre() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_semestre, nome_semestre FROM `semestres` ORDER BY id_semestre ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_semestre = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_semestre[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_semestre;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarSemestre($id_semestre) {
        //Localiza o Semestre e set Variaveis
        $query = "SELECT id_semestre, nome_semestre FROM `semestres` WHERE `id_semestre` = '$id_semestre'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do Semestre */
            $semestre = mysql_fetch_array($resultado);
            $this->id_semestre = $semestre['id_semestre'];
            $this->nome_semestre = $semestre['nome_semestre'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarSemestre() {
        $query = "DELETE FROM `semestres` WHERE `semestres`.`id_semestre` = $this->id_semestre";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Semestre $this->nome_semestre com o id: $this->id_semestre foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Semestre, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
