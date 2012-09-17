<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sessoes
 *
 * @author Gabriel
 */
class Sessoes {

    //put your code here

    function __construct() {
        if (!isset($_SESSION)) {
            session_start(); // Inicia a sessão caso não exista sessao
        }
    }

    function logar($objetoUsuario) {
        $_SESSION['objetoUsuario'] = $objetoUsuario;
        header("location: index.php");
    }

    function deslogar() {
        /* Destruindo objeto Usuario */
        unset($_SESSION['objetoUsuario']);

        session_start(); // Inicia a sessão
        session_destroy(); // Destrói a sessão limpando todos os valores salvos
    }

    function verificarLogado() {
        if (!isset($_SESSION)) {
            session_start(); // Inicia a sessão caso não exista sessao
        }
        /* Verifica se existe objeto usuario, se não existir redireciona para pagina de login */
        if (!isset($_SESSION['objetoUsuario'])):
            header("location: logar.php");
            exit;
        endif;
    }
    
    function verificarNivel($nivel){
        $usuario = $_SESSION['objetoUsuario'];
        if($usuario->nivel != $nivel):
            header("location: index.php");
        endif;
    }

}

?>
