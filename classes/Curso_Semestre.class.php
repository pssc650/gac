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
class Curso_Semestre {

    //put your code here

    public $id_curso_semestre;
    public $id_curso;
    public $id_semestre;
    public $min_horas;
    public $bd;

    public function __construct($id_curso = "", $id_semestre = "", $min_horas = "") {
        $this->id_curso = $id_curso;
        $this->id_semestre = $id_semestre;
        $this->min_horas = $min_horas;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarCurso_Semestre() {
        if ($this->id_curso == "" || $this->semestre = ""):
            Alerta::alertarUsuario("Selecione a Curso e o Semestre para cadastrar a Curso_Semestre.");
            return false;
        endif;

        if ($this->existeCurso_Semestre()):
            Alerta::alertarUsuario("Ja existe essa Curso_Semestre cadastrada.", 0);
        else:
            //INSERT INTO `curso_semestres` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `curso_semestres` (`id_curso`,`id_semestre`,`min_horas`) VALUES ( '$this->id_curso', '$this->id_semestre', '$this->min_horas')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Curso_Semestre Cadastrado com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Curso_Semestre.");
                return false;
            endif;
        endif;
    }

    function existeCurso_Semestre() {
        //Localiza o Curso_Semestre e set Variaveis
        $query = "SELECT id_curso FROM `curso_semestres` WHERE id_curso = $this->id_curso AND id_semestre = $this->id_semestre";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarCurso_Semestre() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_curso_semestre, id_curso, id_semestre, min_horas FROM `curso_semestres` ORDER BY id_curso_semestre ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_curso_semestre = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_curso_semestre[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_curso_semestre;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarCurso_Semestre($id_curso_semestre) {
        //Localiza o Curso_Semestre e set Variaveis
        $query = "SELECT id_curso_semestre, id_curso, id_semestre, min_horas FROM `curso_semestres` WHERE `id_curso_semestre` = '$id_curso_semestre'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do Curso_Semestre */
            $curso_semestre = mysql_fetch_array($resultado);
            $this->id_curso_semestre = $curso_semestre['id_curso_semestre'];
            $this->id_curso = $curso_semestre['id_curso'];
            $this->id_semestre = $curso_semestre['id_semestre'];
            $this->min_horas = $curso_semestre['min_horas'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarCurso_Semestre() {
        $query = "DELETE FROM `curso_semestres` WHERE `curso_semestres`.`id_curso_semestre` = $this->id_curso_semestre";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Curso_Semestre com o id: $this->id_curso_semestre foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Curso_Semestre, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
