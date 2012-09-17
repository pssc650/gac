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
class Atividade {

    //put your code here

    public $id_atividade;
    public $id_aula;
    public $id_aluno;
    public $id_categoria_atividade;
    public $nome_atividade;
    public $descricao_atividade;
    public $horas;
    public $nome_arquivo;
    public $visto;

    public function __construct($id_aula = "", $id_aluno = "", $id_categoria_atividade = "", $nome_atividade= "", $descricao_atividade = "", $horas="", $nome_arquivo = "", $visto="") {

        $this->id_aula = $id_aula;
        $this->id_aluno = $id_aluno;
        $this->id_categoria_atividade = $id_categoria_atividade;
        $this->nome_atividade = $nome_atividade;
        $this->descricao_atividade = $descricao_atividade;
        $this->horas = $horas;
        $this->nome_arquivo = $nome_arquivo;
        $this->visto = $visto;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarAtividade() {
        if ($this->nome_atividade == ""):
            Alerta::alertarUsuario("Digite o nome da Atividade.");
            return false;
        elseif ($this->horas == ""):
            Alerta::alertarUsuario("Digite as horas da Atividade.");
            return false;
        endif;

        if ($this->existeAtividade()):
            Alerta::alertarUsuario("Essa Atividade já foi cadastrada.", 0);
        else:

            //INSERT INTO `cursos` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `atividades` ";
            $query .= "( `id_aula`,`id_aluno`,`id_categoria_atividade`, `nome_atividade`, `descricao_atividade`, `horas`, `nome_arquivo`, `visto`) ";
            $query .= "VALUES ( '$this->id_aula','$this->id_aluno','$this->id_categoria_atividade','$this->nome_atividade', '$this->descricao_atividade', '$this->horas', '$this->nome_arquivo', '0')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Atividade Cadastrada com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Atividades.");
                return false;
            endif;
        endif;
    }

    function existeAtividade() {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_atividade FROM `atividades` WHERE nome_atividade = '$this->nome_atividade'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarAtividade($id_aluno = "", $id_aula = "") {
        if ($id_aluno != ""):
            $query = "SELECT `id_atividade`,`id_aluno`, `id_aula`, `id_categoria_atividade`, `nome_atividade`, `descricao_atividade`, `horas`, `nome_arquivo`, `visto` FROM `atividades` WHERE id_aluno = '$id_aluno' ORDER BY id_atividade ASC";
        elseif ($id_aula != ""):
            $query = "SELECT `id_atividade`,`id_aluno`, `id_aula`, `id_categoria_atividade`,  `nome_atividade`, `descricao_atividade`, `horas`, `nome_arquivo`, `visto` FROM `atividades` WHERE id_aula = '$id_aula' ORDER BY id_atividade ASC";
        else:
            $query = "SELECT `id_atividade`,`id_aluno`, `id_aula`, `id_categoria_atividade`,  `nome_atividade`, `descricao_atividade`, `horas`, `nome_arquivo`, `visto` FROM `atividades` ORDER BY id_atividade ASC";
        endif;

        /* Seleciono todos usuarios */
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_atividade = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_atividade[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_atividade;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function listarAtividadeProfessor($id_professor = "", $visto = "", $id_aula = "") {
        if ($visto != "" AND $id_aula != ""):
            $query = "SELECT a.id_turma ,a.id_professor ,a.id_disciplina ,b.id_atividade ,b.id_aluno ,a.id_aula, b.id_categoria_atividade ,b.nome_atividade ,b.descricao_atividade ,b.horas ,b.nome_arquivo, b.visto FROM aulas a, atividades b WHERE b.id_aula = '" . $id_aula . "' AND visto = '" . $visto . "' GROUP BY b.id_aula";

        elseif ($visto != ""):
            $query = "SELECT a.id_turma ,a.id_professor ,a.id_disciplina ,b.id_atividade ,b.id_aluno ,a.id_aula, b.id_categoria_atividade ,b.nome_atividade ,b.descricao_atividade ,b.horas ,b.nome_arquivo, b.visto FROM aulas a, atividades b WHERE a.id_professor = '" . $id_professor . "' AND a.id_aula = b.id_aula AND visto = '" . $visto . "'";
        else:
            $query = "SELECT a.id_turma ,a.id_professor ,a.id_disciplina ,b.id_atividade ,b.id_aluno ,a.id_aula, b.id_categoria_atividade ,b.nome_atividade ,b.descricao_atividade ,b.horas ,b.nome_arquivo, b.visto FROM aulas a, atividades b WHERE a.id_professor = '" . $id_professor . "' AND a.id_aula = b.id_aula";
        endif;

        /* Seleciono todos usuarios */
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_atividade = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_atividade[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_atividade;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function listarAlunosHorasAtividades() {

        $query = "SELECT sum(horas) total_horas, a.id_aluno, b.id_aula FROM alunos a, atividades b WHERE a.id_aluno = b.id_aluno AND b.visto = 1 GROUP BY a.id_aluno";

        /* Seleciono todos usuarios */
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_atividade = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_atividade[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_atividade;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarAtividade($id_atividade) {
        //Localiza o curso e set Variaveis
        $query = "SELECT `id_atividade`,`id_aluno`,`id_aula`, `id_categoria_atividade`,  `nome_atividade`, `descricao_atividade`, `horas`, `nome_arquivo`, `visto` FROM `atividades` WHERE `id_atividade` = '$id_atividade'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $curso = mysql_fetch_array($resultado);
            $this->id_atividade = $curso['id_atividade'];
            $this->id_aula = $curso['id_aula'];
            $this->id_aluno = $curso['id_aluno'];
            $this->id_categoria_atividade = $curso['id_categoria_atividade'];
            $this->nome_atividade = $curso['nome_atividade'];
            $this->descricao_atividade = $curso['descricao_atividade'];
            $this->horas = $curso['horas'];
            $this->nome_arquivo = $curso['nome_arquivo'];
            $this->visto = $curso['visto'];
            return true;
        else:
            return false;
        endif;
    }

    function aceitarAtividade() {
        $query = "UPDATE `atividades` SET `visto` = '1' WHERE `atividades`.`id_atividade` = '" . $this->id_atividade . "'";
        if ($this->bd->executarQuery($query)):
            Alerta::alertarUsuario("Atividade Aceita.", 1);
            return true;
        else:
            Alerta::alertarUsuario("Não foi possível aceitar a Atividade");
            return false;
        endif;
    }

    function recusarAtividade() {
        $query = "UPDATE `atividades` SET `visto` = '2' WHERE `atividades`.`id_atividade` = '" . $this->id_atividade . "'";
        if ($this->bd->executarQuery($query)):
            Alerta::alertarUsuario("Atividade Recusada.", 1);
            return true;
        else:
            Alerta::alertarUsuario("Não foi possível recusar a Atividade");
            return false;
        endif;
    }

    function deletarAtividade() {
        $query = "DELETE FROM `atividades` WHERE `atividades`.`id_atividade` = $this->id_atividade";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Atividade $this->nome_atividade com o id: $this->id_atividade foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Atividade, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
