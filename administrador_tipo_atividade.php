<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome_tipo_atividade']) && $_POST['nome_tipo_atividade'] != ""):
    $Tipo_Atividade = new Tipo_Atividade($_POST['nome_tipo_atividade']);
    $Tipo_Atividade->cadastrarTipo_Atividade();
    unset($Tipo_Atividade);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_tipo_atividade = $_GET['id_tipo_atividade'];
    foreach ($ids_tipo_atividade as $id_tipo_atividade):
        /* Instanciando um objeto temporario */
        $Tipo_Atividade = new Tipo_Atividade ();
        if ($Tipo_Atividade->selecionarTipo_Atividade($id_tipo_atividade)):
            $Tipo_Atividade->deletarTipo_Atividade();
            /* Deletando o objeto */
            unset($Tipo_Atividade);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Tipo_Atividades</h1>

<div class="box">
    <span class="titulo">Cadastrar Tipo_Atividade</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome_tipo_atividade" /></p>
        <p>É validado pelo professor? </p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Tipo_Atividade</span> 

    <?php
    $retorno_tipo_atividade = new Tipo_Atividade();
    $retorno = $retorno_tipo_atividade->listarTipo_Atividade();
    if (!$retorno):
        echo "Não foi localizado nenhum Tipo_Atividade cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Tipo_Atividade</td>
                    <td>Nome</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="curso <?php echo $valores['id_tipo_atividade']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_tipo_atividade[]" value="<?php echo $valores['id_tipo_atividade']; ?>" /></td>
                        <td class="id_tipo_atividade"><?php echo $valores['id_tipo_atividade']; ?></td>
                        <td class="nome"><?php echo $valores['nome_tipo_atividade']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_tipo_atividade[]=<?php echo $valores['id_tipo_atividade']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>