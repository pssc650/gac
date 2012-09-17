<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome_semestre']) && $_POST['nome_semestre'] != ""):
    $semestre = new Semestre($_POST['nome_semestre']);
    $semestre->cadastrarSemestre();
    unset($semestre);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_semestre = $_GET['id_semestre'];
    foreach ($ids_semestre as $id_semestre):
        /* Instanciando um objeto temporario */
        $semestre = new Semestre ();
        if ($semestre->selecionarSemestre($id_semestre)):
            $semestre->deletarSemestre();
            /* Deletando o objeto */
            unset($semestre);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Semestres</h1>

<div class="box">
    <span class="titulo">Cadastrar Semestre</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome_semestre" /></p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Semestre</span> 

    <?php
    $retorno_semestre = new Semestre();
    $retorno = $retorno_semestre->listarSemestre();
    if (!$retorno):
        echo "Não foi localizado nenhum Semestre cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Semestre</td>
                    <td>Nome</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="Semestre <?php echo $valores['id_semestre']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_semestre[]" value="<?php echo $valores['id_semestre']; ?>" /></td>
                        <td class="id_semestre"><?php echo $valores['id_semestre']; ?></td>
                        <td class="nome"><?php echo $valores['nome_semestre']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_semestre[]=<?php echo $valores['id_semestre']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>