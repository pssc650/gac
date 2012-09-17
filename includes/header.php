<?php
include_once "classes/AutoLoad.php";

$sessao = new Sessoes();
$sessao->verificarLogado();
$usuario = $_SESSION['objetoUsuario'];
?>

<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/chico-min-0.11.css" type="text/css" />
        <script type='text/javascript' src="js/jquery.js"></script>
        <script type='text/javascript' src="js/funcoes.js"></script>
    </head>
    <body>
        <div id="container">

            <div id="alerta">  
            </div><!-- #alerta -->

            <div id="header">
                <div id="logo">
                    <img src="images/symbol_cinza.png">
                </div>
                <div id="status">
                    <span class="nome_usuario"></span><?php echo $usuario->getNome(); ?> | <a href="deslogar.php">Deslogar</a>
                </div><!-- end #status -->
            </div><!-- end #header -->

            <?php
            switch ($usuario->nivel) :

                case 0:
                    include "includes/menu_administrador.php";
                    break;
                case 1:
                    include "includes/menu_professor_administrador.php";
                    break;
                case 2:
                    include "includes/menu_professor_validador.php";
                    break;
                case 3:
                    include "includes/menu_aluno.php";
                    break;
            endswitch;
            ?>

            <div id="content">