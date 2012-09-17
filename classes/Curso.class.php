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
class Curso {

    //put your code here

    public $id_curso;
    public $nome_curso;

    public function __construct($nome_curso= "") {
        $this->nome_curso = $nome_curso;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarCurso() {
        if ($this->nome_curso == ""):
            Alerta::alertarUsuario("Digite o nome da Curso.");
            return false;
        endif;
        //INSERT INTO `cursos` ( `nome`) VALUES ( 'teste');
        $query = "INSERT INTO `cursos` ( `nome_curso`) VALUES ( '$this->nome_curso')";

        if ($this->bd->executarQuery($query)):
            Alerta::alertarUsuario("Curso Cadastrada com Sucesso.", 1);
            return true;
        else:
            Alerta::alertarUsuario("Não foi possível cadastrar o Cursos.");
            return false;
        endif;
    }

    function listarCurso() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_curso, nome_curso FROM `cursos` ORDER BY id_curso ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_curso = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_curso[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_curso;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarCurso($id_curso) {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_curso, nome_curso FROM `cursos` WHERE `id_curso` = '$id_curso'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $curso = mysql_fetch_array($resultado);
            $this->id_curso = $curso['id_curso'];
            $this->nome_curso = $curso['nome_curso'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarCurso() {
        $query = "DELETE FROM `cursos` WHERE `cursos`.`id_curso` = $this->id_curso";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Curso $this->nome_curso com o id: $this->id_curso foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Curso, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
