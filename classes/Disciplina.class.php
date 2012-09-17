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
class Disciplina {

    //put your code here

    public $id_disciplina;
    public $nome_disciplina;

    public function __construct($nome_disciplina= "") {
        $this->nome_disciplina = $nome_disciplina;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarDisciplina() {
        if ($this->nome_disciplina == ""):
            Alerta::alertarUsuario("Digite o nome da Disciplina.");
            return false;
        endif;

        if ($this->existeDisciplina()):
            Alerta::alertarUsuario("Essa Disciplina já foi cadastrada.", 0);
        else:

            //INSERT INTO `cursos` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `disciplinas` ( `nome_disciplina`) VALUES ( '$this->nome_disciplina')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Disciplina Cadastrada com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Disciplinas.");
                return false;
            endif;
        endif;
    }

    function existeDisciplina() {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_disciplina FROM `disciplinas` WHERE nome_disciplina = '$this->nome_disciplina'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarDisciplina() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_disciplina, nome_disciplina FROM `disciplinas` ORDER BY id_disciplina ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_disciplina = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_disciplina[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_disciplina;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarDisciplina($id_disciplina) {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_disciplina, nome_disciplina FROM `disciplinas` WHERE `id_disciplina` = '$id_disciplina'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $curso = mysql_fetch_array($resultado);
            $this->id_disciplina = $curso['id_disciplina'];
            $this->nome_disciplina = $curso['nome_disciplina'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarDisciplina() {
        $query = "DELETE FROM `disciplinas` WHERE `disciplinas`.`id_disciplina` = $this->id_disciplina";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Disciplina $this->nome_disciplina com o id: $this->id_disciplina foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Disciplina, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
