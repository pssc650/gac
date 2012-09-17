<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome_periodo']) && $_POST['nome_periodo'] != ""):
    $periodo = new Periodo($_POST['nome_periodo']);
    $periodo->cadastrarPeriodo();
    unset($periodo);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_periodo = $_GET['id_periodo'];
    foreach ($ids_periodo as $id_periodo):
        /* Instanciando um objeto temporario */
        $periodo = new Periodo ();
        if ($periodo->selecionarPeriodo($id_periodo)):
            $periodo->deletarPeriodo();
            /* Deletando o objeto */
            unset($periodo);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Periodos</h1>

<div class="box">
    <span class="titulo">Cadastrar Periodo</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome_periodo" /></p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Periodo</span> 

    <?php
    $retorno_periodo = new Periodo();
    $retorno = $retorno_periodo->listarPeriodo();
    if (!$retorno):
        echo "Não foi localizado nenhum Periodo cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Periodo</td>
                    <td>Nome</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="Periodo <?php echo $valores['id_periodo']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_periodo[]" value="<?php echo $valores['id_periodo']; ?>" /></td>
                        <td class="id_periodo"><?php echo $valores['id_periodo']; ?></td>
                        <td class="nome"><?php echo $valores['nome_periodo']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_periodo[]=<?php echo $valores['id_periodo']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>