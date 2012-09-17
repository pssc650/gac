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
class Aula {

    //put your code here

    public $id_aula;
    public $id_turma;
    public $id_professor;
    public $id_disciplina;

    public function __construct($id_turma = "", $id_professor = "", $id_disciplina = "") {
        $this->id_turma = $id_turma;
        $this->id_professor = $id_professor;
        $this->id_disciplina = $id_disciplina;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarAula() {
        if ($this->id_turma == "" && $this->id_professor == $id_professor && $this->id_disciplina == ""):
            Alerta::alertarUsuario("Seleciona uma Turma, PROFESSOR e uma Disciplina.");
            return false;
        endif;

        if ($this->verificarExiste()):
            Alerta::alertarUsuario("Aula ja cadastrada.", 0);
        else:
            //INSERT INTO `aulas` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `aulas` ( `id_turma`, `id_professor`, `id_disciplina`) VALUES ( '$this->id_turma', '$this->id_professor', '$this->id_disciplina')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Aula Cadastrada com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Aulas.");
                return false;
            endif;
        endif;
    }

    function verificarExiste() {
        //Localiza o Aula e set Variaveis
        $query = "SELECT id_aula FROM `aulas` WHERE `id_turma` = $this->id_turma AND `id_professor` = $this->id_professor AND  `id_disciplina` = $this->id_disciplina ";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarAula($id_turma = "") {
        /* Seleciono todos usuarios */
        if ($id_turma != ""):
            $query = "SELECT id_aula, id_turma, id_professor, id_disciplina FROM `aulas` WHERE id_turma = '$id_turma' ORDER BY id_aula ASC";
        else:
            $query = "SELECT id_aula, id_turma, id_professor, id_disciplina FROM `aulas` ORDER BY id_aula ASC";
        endif;


        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_aula = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_aula[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_aula;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarAula($id_aula) {
        //Localiza o Aula e set Variaveis
        $query = "SELECT id_aula, id_turma, id_professor, id_disciplina FROM `aulas` WHERE `id_aula` = '$id_aula'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do Aula */
            $aula = mysql_fetch_array($resultado);
            $this->id_aula = $aula['id_aula'];
            $this->id_turma = $aula['id_turma'];
            $this->id_professor = $aula['id_professor'];
            $this->id_disciplina = $aula['id_disciplina'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarAula() {
        $query = "DELETE FROM `aulas` WHERE `aulas`.`id_aula` = $this->id_aula";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Aula com o id: $this->id_aula foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Aula, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
