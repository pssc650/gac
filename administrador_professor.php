<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome']) && $_POST['nome'] != ""):
    $professor = new Professor("", $_POST['nome'], $_POST['login'], $_POST['senha'], $_POST['nivel']);
    if ($professor->cadastrar()):
        Alerta::alertarUsuario("Professor cadastrado com sucesso.", 1);
    else:
        Alerta::alertarUsuario("Não foi possível cadastrar Professor.", 0);
    endif;
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_professor = $_GET['id_professor'];
    foreach ($ids_professor as $id_professor):
        /* Instanciando um objeto temporario */
        $professor = new Professor();
        if ($professor->selecionarProfessor($id_professor)):
            $professor->deletarUsuario();
        endif;

        /* Deletando o objeto */
        unset($professor);
    endforeach;
endif;
?>
<h1>Administrador de Professor</h1>

<div class="box">
    <span class="titulo">Cadastrar Professor</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome" /></p>
        <p>Login: <input type="text" name="login" /></p>
        <p>Senha: <input type="text" name="senha" /></p>
        <p>        
            <input type="radio" name="nivel" value="2" CHECKED/> Professor Validador
            <input type="radio" name="nivel" value="1" /> Professor Administrador

        </p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Professor</span> 

    <?php
    $retorno_professor = new Professor();
    $retorno = $retorno_professor->listarProfessor();
    if (!$retorno):
        echo "Não foi localizado nenhum Professor cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Professor</td>
                    <td>Nome</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="curso <?php echo $valores['id_professor']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_professor[]" value="<?php echo $valores['id_professor']; ?>" /></td>
                        <td class="id_professor"><?php echo $valores['id_professor']; ?></td>
                        <td class="nome"><?php echo $valores['nome_professor']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_professor[]=<?php echo $valores['id_professor']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>