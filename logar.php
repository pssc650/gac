<?php
include "classes/AutoLoad.php";

if (isset($_POST['login']) && $_POST['login'] != ""):

    $usuario = new Usuario(addslashes($_POST['login']), addslashes($_POST['senha']));

    if ($usuario->validarLoginSenha()):

        switch ($usuario->nivel):
            case 0:
                break;
            case 1:
            case 2:
                $professor = new Professor();
                $professor->selecionarProfessor($usuario->id_usuario);
                $professor->selecionarUsuario($usuario->id_usuario);
                unset($usuario);
                $usuario = $professor;
                break;
            case 3:
                $aluno = new Aluno();
                $aluno->selecionarAluno($usuario->id_usuario);
                $aluno->selecionarUsuario($usuario->id_usuario);
                unset($usuario);
                $usuario = $aluno;
                break;
        endswitch;
        $sessao = new Sessoes();
        $sessao->logar($usuario);

    endif;


endif;
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
        <div id="box_logar">
            <div id="alerta" class="alerta_logar">  
            </div><!-- #alerta -->
            <div class="logo">
                 <img src="images/symbol_cinza.png">
            </div>
            <div id="logar">
                Acesso ao Administrador
                <form method="post">
                
                    <table>
                        <tr>
                            <td class="text-td">Login:</td>
                            <td class="input-td"><input type="text" name="login" /></td>
                        </tr>
                        <tr>
                            <td class="text-td">Senha:</td>
                            <td class="input-td"><input type="password" name="senha" /></td>
                        </tr>
                    </table>
                    <input type="submit" value="Logar" class="ch-btn-skin ch-btn-small"/>
                </form>
            </div>

            <div id="footer">

            </div><!-- end #footer-->
        </div><!-- end #container-->


        <?php
        Alerta::alertaMostrar();
        ?>
    </body>
</html>
