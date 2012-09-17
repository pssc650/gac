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
class Turma {

    //put your code here
    public $id_turma;
    public $id_curso_semestre;
    public $id_periodo;
    public $identificador;
    public $ano;
    public $bd;

    public function __construct($id_curso_semestre = "", $id_periodo = "", $ano = "") {
        $this->id_curso_semestre = $id_curso_semestre;
        $this->id_periodo = $id_periodo;
        $this->ano = $ano;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarTurma() {
        if ($this->id_curso_semestre == "" || $this->id_periodo == ""):
            Alerta::alertarUsuario("Selecione a Curso e o Semestre para cadastrar a Turma.");
            return false;
        endif;
        //INSERT INTO `turmas` ( `nome`) VALUES ( 'teste');
        $query = "INSERT INTO `turmas` (`id_curso_semestre`,`id_periodo`, `identificador`, `ano`) VALUES ( '$this->id_curso_semestre', '$this->id_periodo', '" . $this->gerarIdentificador() . "', '$this->ano')";
        if ($this->bd->executarQuery($query)):
            Alerta::alertarUsuario("Turma Cadastrado com Sucesso.", 1);
            return true;
        else:
            Alerta::alertarUsuario("Não foi possível cadastrar o Turma.");
            return false;
        endif;
    }

    function gerarIdentificador() {
        /*
         * Monto um Array de letras
         */
        $letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        // Seleciono do banco pra verificar se ja existe uma Turma dessa Curso_Semestre em especifico
        $query = "SELECT identificador FROM Turmas WHERE id_curso_semestre = '$this->id_curso_semestre' AND id_periodo = '$this->id_periodo' ORDER BY identificador DESC";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            $identificador = mysql_fetch_array($resultado);
            // Percorro o array de letras pra verificar se ja existe, caso seja ele vai pegar a proxima letra
            for ($x = 0; $x < 26; $x++):
                if ($letras[$x] == $identificador['identificador']):
                    // Retorna a letra que será registra
                    return $letras[$x + 1];
                endif;
            endfor;

        else:
            //Caso ele não encontre nenhuma Turma cadastrada ele vai dar o identificador como A
            return "A";
        endif;
    }

    function listarTurma($id_curso_semestre = "") {
        if ($id_curso_semestre != ""):
            /* Seleciono todos usuarios */
            $query = "SELECT id_turma, id_curso_semestre, id_periodo, identificador, ano FROM `turmas` WHERE id_curso_semestre = $id_curso_semestre ORDER BY id_turma ASC";
        else:
            /* Seleciono todos usuarios */
            $query = "SELECT id_turma, id_curso_semestre, id_periodo, identificador, ano FROM `turmas` ORDER BY id_turma ASC";
        endif;

        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_turma = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_turma[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_turma;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarTurma($id_turma) {
        //Localiza o Turma e set Variaveis
        $query = "SELECT id_turma, id_curso_semestre, id_periodo, identificador, ano FROM `turmas` WHERE `id_turma` = '$id_turma'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do Turma */
            $turma = mysql_fetch_array($resultado);
            $this->id_turma = $turma['id_turma'];
            $this->id_curso_semestre = $turma['id_curso_semestre'];
            $this->id_periodo = $turma['id_periodo'];
            $this->identificador = $turma['identificador'];
            $this->ano = $turma['ano'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarTurma() {
        $query = "DELETE FROM `turmas` WHERE `turmas`.`id_turma` = $this->id_turma";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Turma com o id: $this->id_turma foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Turma, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
