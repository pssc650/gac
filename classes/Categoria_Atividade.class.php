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
class Categoria_Atividade {

    //put your code here

    public $id_categoria_atividade;
    public $nome_categoria_atividade;
    public $id_tipo_atividade;
    public $resumo;
    public $visto;
    public $max_horas;
    public $hora_fixa;

    public function __construct($nome_categoria_atividade= "", $id_tipo_atividade = "", $resumo = "", $visto = "", $max_horas = "", $hora_fixa = 0) {
        $this->nome_categoria_atividade = $nome_categoria_atividade;
        $this->id_tipo_atividade = $id_tipo_atividade;
        $this->resumo = $resumo;
        $this->visto = $visto;
        $this->max_horas = $max_horas;
        $this->hora_fixa = $hora_fixa;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarCategoria_Atividade() {
        if ($this->nome_categoria_atividade == ""):
            Alerta::alertarUsuario("Digite o nome da Categoria_Atividade.");
            return false;
        endif;

        if ($this->existeCategoria_Atividade()):
            Alerta::alertarUsuario("Essa Categoria_Atividade já foi cadastrada.", 0);
        else:

            //INSERT INTO `cursos` ( `nome`) VALUES ( 'teste');
            $query = "INSERT INTO `categoria_atividades` ";
            $query .= "( `nome_categoria_atividade`, `id_tipo_atividade`, `resumo`, `visto`, `max_horas`, `hora_fixa`) ";
            $query .= "VALUES ( '$this->nome_categoria_atividade', '$this->id_tipo_atividade', '$this->resumo', '$this->visto', '$this->max_horas', '$this->hora_fixa')";

            if ($this->bd->executarQuery($query)):
                Alerta::alertarUsuario("Categoria_Atividade Cadastrada com Sucesso. ", 1);
                return true;
            else:
                Alerta::alertarUsuario("Não foi possível cadastrar o Categoria_Atividades.");
                return false;
            endif;
        endif;
    }

    function existeCategoria_Atividade() {
        //Localiza o curso e set Variaveis


        $query = "SELECT id_categoria_atividade FROM `categoria_atividades` WHERE nome_categoria_atividade = '$this->nome_categoria_atividade'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            return true;
        else:
            return false;
        endif;
    }

    function listarCategoria_Atividade() {
        /* Seleciono todos usuarios */
        $query
                = "SELECT id_categoria_atividade, nome_categoria_atividade, id_tipo_atividade, resumo, visto, max_horas, hora_fixa FROM `categoria_atividades` ORDER BY id_categoria_atividade ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_categoria_atividade = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_categoria_atividade[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_categoria_atividade;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function selecionarCategoria_Atividade($id_categoria_atividade) {
        //Localiza o curso e set Variaveis
        $query = "SELECT id_categoria_atividade, nome_categoria_atividade, id_tipo_atividade, resumo, visto, max_horas, hora_fixa FROM `categoria_atividades` WHERE `id_categoria_atividade` = '$id_categoria_atividade'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do curso */
            $categoria_atividade = mysql_fetch_array($resultado);
            $this->id_categoria_atividade = $categoria_atividade['id_categoria_atividade'];
            $this->nome_categoria_atividade = $categoria_atividade['nome_categoria_atividade'];
            $this->id_tipo_atividade = $categoria_atividade['id_tipo_atividade'];
            $this->resumo = $categoria_atividade['resumo'];
            $this->visto = $categoria_atividade['visto'];
            $this->max_horas = $categoria_atividade['max_horas'];
            $this->hora_fixa = $categoria_atividade['hora_fixa'];
            return true;
        else:
            return false;
        endif;
    }

    function deletarCategoria_Atividade() {
        $query = "DELETE FROM `categoria_atividades` WHERE `categoria_atividades`.`id_categoria_atividade` = $this->id_categoria_atividade";
        $resultado = $this->bd->executarQuery($query);
        if ($resultado)
            Alerta::alertarUsuario("Categoria_Atividade $this->nome_categoria_atividade com o id: $this->id_categoria_atividade foi deletado com sucesso.", 1);
        else
            Alerta::alertarUsuario("Não foi possível deletar Categoria_Atividade, entre em contato com Administrador.");

        return $resultado;
    }

}

?>
