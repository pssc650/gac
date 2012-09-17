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
class Tipo_Atividade {

    //put your code here

    public $id_tipo_atividade;
    public $nome_tipo_atividade;

    public function __construct($nome_tipo_atividade= "") {
        $this->nome_tipo_atividade = $nome_tipo_atividade;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarTipo_Atividade() {
        if ($this->nome_tipo_atividade == ""):
            Alerta::alertarUsuario("Digite o nome da Tipo_Atividade.");
            return false;
        endif;

        if ($this->existeTipo_Atividade()):
            Alerta::alertarUsuario("Essa Tipo_Atividade já foi cadastrada.", 0);
        else:

            //INSERT INTO `cursos` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `tipo_atividades` ( `nome_tipo_atividade`) VALUES ( '$this->nome_tipo_atividade')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Tipo_Atividade Cadastrada com Sucesso.", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Tipo_Atividades.");
                return false;
            endif;
        endif;
    }

    function existeTipo_Atividade() {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_tipo_atividade FROM `tipo_atividades` WHERE nome_tipo_atividade = '$this->nome_tipo_atividade'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarTipo_Atividade() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_tipo_atividade, nome_tipo_atividade FROM `tipo_atividades` ORDER BY id_tipo_atividade ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_tipo_atividade = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_tipo_atividade[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_tipo_atividade;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarTipo_Atividade($id_tipo_atividade) {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_tipo_atividade, nome_tipo_atividade FROM `tipo_atividades` WHERE `id_tipo_atividade` = '$id_tipo_atividade'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $tipo_atividade = mysql_fetch_array($resultado);
            $this->id_tipo_atividade = $tipo_atividade['id_tipo_atividade'];
            $this->nome_tipo_atividade = $tipo_atividade['nome_tipo_atividade'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarTipo_Atividade() {
        $query = "DELETE FROM `tipo_atividades` WHERE `tipo_atividades`.`id_tipo_atividade` = $this->id_tipo_atividade";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Tipo_Atividade $this->nome_tipo_atividade com o id: $this->id_tipo_atividade foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Tipo_Atividade, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
