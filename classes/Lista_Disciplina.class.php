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
class Lista_Disciplina {

    //put your code here
    public $id_curso_semestre;
    public $id_disciplina;
    public $bd;

    public function __construct($id_curso_semestre = "", $id_disciplina = "") {
        $this->id_curso_semestre = $id_curso_semestre;
        $this->id_disciplina = $id_disciplina;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarLista_Disciplina() {
        if ($this->id_curso_semestre == "" || $this->id_disciplina == ""):
            Alerta::alertarUsuario("Selecione a Curso e o Disciplina para cadastrar a Lista_Disciplina.");
            return false;
        endif;
        if ($this->verificarExiste()):
            Alerta::alertarUsuario("Disciplina cadastrada ja consta na lista da Curso_Semestre", 0);
        else:
            //INSERT INTO `lista_disciplinas` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `lista_disciplinas` (`id_curso_semestre`, `id_disciplina`) VALUES ( '$this->id_curso_semestre', '$this->id_disciplina')";
            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Lista_Disciplina Cadastrado com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Lista_Disciplina.");
                return false;
            endif;
        endif;
    }

    function verificarExiste() {
        $query = "SELECT id_curso_semestre FROM `lista_disciplinas` WHERE `id_curso_semestre` = '$this->id_curso_semestre' AND `id_disciplina` = '$this->id_disciplina'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarLista_Disciplina($id_curso_semestre = "") {
        if ($id_curso_semestre != ""):
            /* Seleciono todas as disciplinas de uma Curso_Semestre especifica */
            $query = "SELECT id_curso_semestre, id_disciplina FROM `lista_disciplinas` WHERE id_curso_semestre = $id_curso_semestre ORDER BY id_curso_semestre ASC";
        else:
            /* Seleciono seleciono todas as disciplinas e Curso_Semestres */
            $query = "SELECT id_curso_semestre, id_disciplina FROM `lista_disciplinas` ORDER BY id_curso_semestre ASC";
        endif;


        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_lista_disciplina = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_lista_disciplina[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_lista_disciplina;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarLista_Disciplina($id_curso_semestre, $id_disciplina) {
        //Localiza o Lista_Disciplina e set Variaveis
        $query = "SELECT id_curso_semestre, id_disciplina FROM `lista_disciplinas` WHERE `id_curso_semestre` = '$id_curso_semestre' AND `id_disciplina` = '$id_disciplina'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do Lista_Disciplina */
            $Lista_Disciplina = mysql_fetch_array($resultado);
            $this->id_curso_semestre = $Lista_Disciplina['id_curso_semestre'];
            $this->id_disciplina = $Lista_Disciplina['id_disciplina'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarLista_Disciplina() {
        $query = "DELETE FROM `lista_disciplinas` WHERE `lista_disciplinas`.`id_curso_semestre` = $this->id_curso_semestre AND `lista_disciplinas`.`id_disciplina` = $this->id_disciplina ";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Lista_Disciplina com o id da Curso_Semestre: $this->id_curso_semestre e id da disciplina: $this->id_disciplina foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Lista_Disciplina, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
