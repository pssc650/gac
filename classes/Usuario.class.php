<?php

include_once "AutoLoad.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Gabriel
 */
class Usuario {

    //put your code here

    public $id_usuario;
    public $login;
    public $senha;
    public $nivel; //Nivel de acesso do usuario Root, Professor ou Aluno
    public $status; //verifica se ele esta ativo ou nao
    public $bd;

    function __construct($login = "", $senha = "", $nivel = "", $status = "") {
        $this->login = $login;
        $this->senha = $senha;
        $this->nivel = $nivel;
        $this->status = $status;
        $this->bd = Banco::instanciarBanco();
    }

    function cadastrarUsuario() {
        $query = "INSERT INTO `usuarios` ";
        $query .= "( `login`, `senha`, `nivel`, `status`) ";
        $query .= "VALUES ( '$this->login', '$this->senha', '$this->nivel', '1')";

        if ($this->bd->executarQuery($query)):
            return true;
        else:
            return false;
        endif;
    }

    function selecionarUsuario($id_usuario) {
        //Localiza o usuario e set as configurações
        $query = "SELECT id_usuario, login, senha, nivel, status FROM `usuarios` WHERE `id_usuario` = '$id_usuario'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):
            /* Setando dados do usuario */
            $usuario = mysql_fetch_array($resultado);
            $this->login = $usuario['login'];
            $this->senha = $usuario['senha'];
            $this->nivel = $usuario['nivel'];
            $this->status = $usuario['status'];
            $this->id_usuario = $usuario['id_usuario'];
            return true;
        else:
            return false;
        endif;
    }

    function atualizarUsuario() {
        
    }

    function listarUsuario() {
        /* Seleciono todos usuarios */
        $query = "SELECT id_usuario, login, senha, nivel, status FROM `usuarios` ORDER BY id_usuario ASC";
        $resultado = $this->bd->executarQuery($query);

        /* Verifica se a query teve retorno */
        if ($this->bd->teveRetorno($resultado)):

            /*
             * A query teve retorno:
             * Transformo em Array os dados e do return
             */

            /* Instacio as variaveis */
            $array_usuario = array();
            $x = 0;

            /* Faço um while em quanto tem resultado */
            while ($campo = mysql_fetch_array($resultado)):
                /* faço um foreach para montar o array pegando o indice e o valor */
                foreach ($campo as $key => $value):
                    /* monto o array, colocando aposicao atual, indice e o valor */
                    $array_usuario[$x][$key] = $value;
                endforeach;
                /* somo a posicao */
                $x++;
            endwhile;

            return $array_usuario;
        else:

            /*
             * A query não teve retorno:
             * Retorno False, para ser tratado qm chamou, no caso dar uma msg de alerta
             */

            return false;
        endif;
    }

    function alterarStatus() {
        if ($this->status == 1):
            //UPDATE `usuario` SET `status` = '0' WHERE `usuario`.`id_usuario` =43;
            $query = "UPDATE `usuarios` SET `status` = '0' WHERE `usuarios`.`id_usuario` = '$this->id_usuario'";
            $msg = "Usuario $this->login com o id: $this->id_usuario foi Desativado com sucesso.";
        else:
            $query = "UPDATE `usuarios` SET `status` = '1' WHERE `usuarios`.`id_usuario` = '$this->id_usuario'";
            $msg = "Usuario $this->login com o id: $this->id_usuario foi Ativado com sucesso.";
        endif;
        /* Executando query */
        $resultado = $this->bd->executarQuery($query);

        if (!$resultado)
            Alerta::alertarUsuario("Não foi possível alterar status do usuario.");
        else
            Alerta::alertarUsuario($msg, 1);

        return $resultado;
    }

    function deletarUsuario() {
        Alerta::alertarUsuario("Usuario " . strtoupper($this->getNome()) . " deletado com sucesso.", 1);
        $query = "DELETE FROM `usuarios` WHERE `usuarios`.`id_usuario` = '$this->id_usuario'";
        $resultado = $this->bd->executarQuery($query);
        switch ($this->nivel):
            case 1:
            case 2:
                $professor = new Professor();
                if ($professor->selecionarProfessor($this->id_usuario)):
                    $professor->deletarProfessor();
                endif;
                unset($professor);
                break;
            case 3:
                $aluno = new Aluno();
                if ($aluno->selecionarAluno($this->id_usuario)):
                    $aluno->deletarAluno();
                endif;
                unset($aluno);
                break;
        endswitch;

        return true;
    }

    function validarLoginSenha() {
        $query = "SELECT * FROM `usuarios` WHERE `login` = '$this->login' AND `senha` = '$this->senha'";
        $resultado = $this->bd->executarQuery($query);
        if ($this->bd->teveRetorno($resultado)):

            /* Convertendo dados para array */
            $usuario = mysql_fetch_array($resultado);

            /* Setando valores do usuario */
            $this->nivel = ($usuario['nivel']);
            $this->id_usuario = ($usuario['id_usuario']);
            $this->status = ($usuario['status']);

            if ($this->status != 1):
                Alerta::alertarUsuario("Usuario Desativado, Entre em contato com a Diretoria.");
                return false;
            endif;

            return true;
        else:
            /* Mensagem de Error para Login e senha Invalidos */
            Alerta::alertarUsuario("Usuario ou Senha digitados são Invalidos.");
            return false;
        endif;
    }

    function getNome() {
        return $this->login;
    }

}

?>
