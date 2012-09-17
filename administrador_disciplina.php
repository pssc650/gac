<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome_disciplina']) && $_POST['nome_disciplina'] != ""):
    $disciplina = new Disciplina($_POST['nome_disciplina']);
    $disciplina->cadastrarDisciplina();
    unset($disciplina);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_disciplina = $_GET['id_disciplina'];
    foreach ($ids_disciplina as $id_disciplina):
        /* Instanciando um objeto temporario */
        $disciplina = new Disciplina ();
        if ($disciplina->selecionarDisciplina($id_disciplina)):
            $disciplina->deletarDisciplina();
            /* Deletando o objeto */
            unset($disciplina);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Disciplinas</h1>

<div class="box">
    <span class="titulo">Cadastrar Disciplina</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome_disciplina" /></p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Disciplina</span> 

    <?php
    $retorno_disciplina = new Disciplina();
    $retorno = $retorno_disciplina->listarDisciplina();
    if (!$retorno):
        echo "Não foi localizado nenhum Disciplina cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Disciplina</td>
                    <td>Nome</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="curso <?php echo $valores['id_disciplina']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_disciplina[]" value="<?php echo $valores['id_disciplina']; ?>" /></td>
                        <td class="id_disciplina"><?php echo $valores['id_disciplina']; ?></td>
                        <td class="nome"><?php echo $valores['nome_disciplina']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_disciplina[]=<?php echo $valores['id_disciplina']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>