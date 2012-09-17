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
class Professor extends Usuario {

    //put your code here

    public $id_professor;
    public $nome_professor;

    function __construct($id_professor = "", $nome_professor = "", $login = "", $senha = "", $nivel = "", $status = "") {
        $this->aluno = $id_professor;
        $this->nome_professor = $nome_professor;

        $this->login = $login;
        $this->senha = $senha;
        $this->nivel = $nivel;
        $this->status = $status;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrar() {
        $cadastro_usuario = $this->cadastrarUsuario();
        $this->id_professor = Banco::ultimoId();

        if ($cadastro_usuario):
            $query = "INSERT INTO `professores` ";
            $query .= "(`id_professor`, `nome_professor`) ";
            $query .= "VALUES ( '$this->id_professor', '$this->nome_professor')";
            if ($this->bd->executarQuery($query)):
                return true;
            else:
                return false;
            endif;
        else:
            return false;
        endif;
    }

    function selecionarProfessor($id_professor) {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_professor, nome_professor FROM `professores` WHERE `id_professor` = '$id_professor'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $professor = mysql_fetch_array($resultado);
            $this->id_professor = $professor['id_professor'];
            $this->nome_professor = $professor['nome_professor'];
            $this->selecionarUsuario($this->id_professor);
            return true;
        else:
            return false;
        endif;
    }

    function atualizarProfessor() {
        
    }

    function listarProfessor() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_professor, nome_professor FROM `professores` ORDER BY id_professor ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_rofessor = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_rofessor[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_rofessor;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function deletarProfessor() {
        $query = "DELETE FROM `professores` WHERE `professores`.`id_professor` = $this->id_professor";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            return true;
        else
            return false;
    }

    function getNome() {
        return $this->nome_professor;
    }

}

?>
