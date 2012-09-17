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
class Sala {

    //put your code here
    public $id_sala;
    public $id_turma;
    public $id_periodo;
    public $identificador;
    public $bd;

    public function __construct($id_turma = "", $id_periodo = "") {
        $this->id_turma = $id_turma;
        $this->id_periodo = $id_periodo;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarSala() {
        if ($this->id_turma == "" || $this->id_periodo == ""):
            Alerta::alertarUsuario("Selecione a Curso e o Semestre para cadastrar a Sala.");
            return false;
        endif;
        //INSERT INTO `salas` ( `nome`) VALUES ( 'teste');
        $query = "INSERT INTO `salas` (`id_turma`,`id_periodo`, `identificador`) VALUES ( '$this->id_turma', '$this->id_periodo', '" . $this->gerarIdentificador() . "')";
        if ($this->bd->executarQuery($query)):
            Alerta::alertarUsuario("Sala Cadastrado com Sucesso.", 1);
            return true;
        else:
            Alerta::alertarUsuario("Não foi possível cadastrar o Sala.");
            return false;
        endif;
    }

    function gerarIdentificador() {
        /*
         * Monto um Array de letras
         */
        $letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        // Seleciono do banco pra verificar se ja existe uma sala dessa turma em especifico
        $query = "SELECT identificador FROM salas WHERE id_turma = '$this->id_turma' AND id_periodo = '$this->id_periodo' ORDER BY identificador DESC";
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
            //Caso ele não encontre nenhuma sala cadastrada ele vai dar o identificador como A
            return "A";
        endif;
    }

    function listarSala($id_turma = "") {
        if ($id_turma != ""):
            /* Seleciono todos usuarios */
            $query = "SELECT id_sala, id_turma, id_periodo, identificador FROM `salas` WHERE id_turma = $id_turma ORDER BY id_sala ASC";
        else:
            /* Seleciono todos usuarios */
            $query = "SELECT id_sala, id_turma, id_periodo, identificador FROM `salas` ORDER BY id_sala ASC";
        endif;

        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_sala = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_sala[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_sala;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarSala($id_sala) {
        //Localiza o Sala e set Variaveis
        $query = "SELECT id_sala, id_turma, id_periodo, identificador FROM `salas` WHERE `id_sala` = '$id_sala'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do Sala */
            $sala = mysql_fetch_array($resultado);
            $this->id_sala = $sala['id_sala'];
            $this->id_turma = $sala['id_turma'];
            $this->id_periodo = $sala['id_periodo'];
            $this->identificador = $sala['identificador'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarSala() {
        $query = "DELETE FROM `salas` WHERE `salas`.`id_sala` = $this->id_sala";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Sala com o id: $this->id_sala foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Sala, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
