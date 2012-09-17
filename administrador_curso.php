<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome_curso']) && $_POST['nome_curso'] != ""):
    $curso = new Curso($_POST['nome_curso']);
    $curso->cadastrarCurso();
    unset($curso);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_curso = $_GET['id_curso'];
    foreach ($ids_curso as $id_curso):
        /* Instanciando um objeto temporario */
        $curso = new Curso ();
        if ($curso->selecionarCurso($id_curso)):
            $curso->deletarCurso();
            /* Deletando o objeto */
            unset($curso);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Cursos</h1>

<div class="box">
    <span class="titulo">Cadastrar Curso</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome_curso" /></p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Curso</span> 

    <?php
    $retorno_curso = new Curso();
    $retorno = $retorno_curso->listarCurso();
    if (!$retorno):
        echo "Não foi localizado nenhum Curso cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Curso</td>
                    <td>Nome</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="curso <?php echo $valores['id_curso']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_curso[]" value="<?php echo $valores['id_curso']; ?>" /></td>
                        <td class="id_curso"><?php echo $valores['id_curso']; ?></td>
                        <td class="nome"><?php echo $valores['nome_curso']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_curso[]=<?php echo $valores['id_curso']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>