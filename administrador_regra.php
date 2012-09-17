<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php

if (isset($_POST['nome_regra']) && $_POST['nome_regra'] != ""):
    $Regra = new Regra($_POST['nome_regra']);
    $Regra->cadastrarRegra();
    unset($Regra);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_regra = $_GET['id_regra'];
    foreach ($ids_regra as $id_regra):
        /* Instanciando um objeto temporario */
        $Regra = new Regra ();
        if ($Regra->selecionarRegra($id_regra)):
            $Regra->deletarRegra();
            /* Deletando o objeto */
            unset($Regra);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Regras</h1>

<div class="box">
    <span class="titulo">Cadastrar Regra</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome_regra" /></p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Regra</span> 

    <?php
    $retorno_regra = new Regra();
    $retorno = $retorno_regra->listarRegra();
    if (!$retorno):
        echo "Não foi localizado nenhum Regra cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Regra</td>
                    <td>Nome</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="curso <?php echo $valores['id_regra']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_regra[]" value="<?php echo $valores['id_regra']; ?>" /></td>
                        <td class="id_regra"><?php echo $valores['id_regra']; ?></td>
                        <td class="nome"><?php echo $valores['nome_regra']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_regra[]=<?php echo $valores['id_regra']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>