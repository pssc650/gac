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
class Aluno extends Usuario {

    //put your code here

    public $id_aluno;
    public $nome_aluno;
    public $id_turma;

    function __construct($id_aluno = "", $nome_aluno = "", $id_turma = "", $login = "", $senha = "", $nivel = 3, $status = "") {
        $this->aluno = $id_aluno;
        $this->nome_aluno = $nome_aluno;
        $this->id_turma = $id_turma;

        $this->login = $login;
        $this->senha = $senha;
        $this->nivel = $nivel;
        $this->status = $status;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrar() {
        $cadastro_usuario = $this->cadastrarUsuario();
        $this->id_aluno = Banco::ultimoId();

        if ($cadastro_usuario):
            $query = "INSERT INTO `alunos` ";
            $query .= "(`id_aluno`, `nome_aluno`, `id_turma`) ";
            $query .= "VALUES ( '$this->id_aluno', '$this->nome_aluno', '$this->id_turma')";
            if ($this->bd->executarQuery($query)):
                return true;
            else:
                return false;
            endif;
        else:
            return false;
        endif;
    }

    function selecionarAluno($id_aluno) {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_aluno, nome_aluno, id_turma FROM `alunos` WHERE `id_aluno` = '$id_aluno'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $aluno = mysql_fetch_array($resultado);
            $this->id_aluno = $aluno['id_aluno'];
            $this->nome_aluno = $aluno['nome_aluno'];
            $this->id_turma = $aluno['id_turma'];
            $this->selecionarUsuario($this->id_aluno);
            return true;
        else:
            return false;
        endif;
    }

    function atualizarAluno() {
        
    }

    function listarAluno() {
        $bd = Banco::instanciarBanco();
        /* Seleciono todos usuarios */
        $query = "SELECT id_aluno, nome_aluno, id_turma FROM `alunos` ORDER BY id_aluno ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_Aluno = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_Aluno[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_Aluno;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function deletarAluno() {
        $query = "DELETE FROM `alunos` WHERE `alunos`.`id_aluno` = $this->id_aluno";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            return true;
        else
            return false;
    }

    function getNome() {
        return $this->nome_aluno;
    }

}

?>
