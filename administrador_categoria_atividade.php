<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome_categoria_atividade']) && $_POST['nome_categoria_atividade'] != ""):
    $categoria_atividade = new Categoria_Atividade($_POST['nome_categoria_atividade'], $_POST['id_tipo_atividade'], $_POST['resumo'], $_POST['visto'], $_POST['max_horas'], $_POST['hora_fixa']);
    $categoria_atividade->cadastrarCategoria_Atividade();
    unset($categoria_atividade);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_categoria_atividade = $_GET['id_categoria_atividade'];
    foreach ($ids_categoria_atividade as $id_categoria_atividade):
        /* Instanciando um objeto temporario */
        $categoria_atividade = new Categoria_Atividade ();
        if ($categoria_atividade->selecionarCategoria_Atividade($id_categoria_atividade)):
            $categoria_atividade->deletarCategoria_Atividade();
            /* Deletando o objeto */
            unset($categoria_atividade);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Categoria_Atividades</h1>

<div class="box">
    <span class="titulo">Cadastrar Categoria_Atividade</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome_categoria_atividade" /></p>
        <p>Tipo de Atividade:  
            <select name="id_tipo_atividade">
                <option></option>
                <?php
                $tipo_atividade = new Tipo_Atividade();
                $retorno_tipo_atividade = $tipo_atividade->listarTipo_Atividade();
                foreach ($retorno_tipo_atividade as $valores):
                    ?>
                    <option value="<?php echo $valores['id_tipo_atividade']; ?>"><?php echo $valores['nome_tipo_atividade']; ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </p>
        <p>Precisa de Resumo? <input type="radio" name="resumo" value="Sim">Sim <input type="radio" name="resumo" value="Não">Não</p>
        <p>Precisa de Visto? <input type="radio" name="visto" value="Sim">Sim <input type="radio" name="visto" value="Não">Não</p>
        <p>Quantidade de Horas Maxima: <input type="text" name="max_horas" /> Ex: 10 ou 10%</p>
         <p>Hora Fixa: <input type="text" name="hora_fixa" /> * Caso não tenha hora fixa deixe em branco, caso tenha preencha. Ex: 10</p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Categoria_Atividade</span> 

    <?php
    $retorno_categoria_atividade = new Categoria_Atividade();
    $retorno = $retorno_categoria_atividade->listarCategoria_Atividade();
    if (!$retorno):
        echo "Não foi localizado nenhum Categoria_Atividade cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Categoria_Atividade</td>
                    <td>Nome</td>
                    <td>Id Tipo Atividade</td>
                    <td>Nome Tipo Atividade</td>
                    <td>Precisa de Resumo?</td>
                    <td>Precisa de Visto?</td>
                    <td>Maximo de Horas</td>
                    <td>Hora Fixa</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    $tipo_atividade = new Tipo_Atividade();
                    $tipo_atividade->selecionarTipo_Atividade($valores['id_tipo_atividade']);
                    ?>
                    <tr class="curso <?php echo $valores['id_categoria_atividade']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_categoria_atividade[]" value="<?php echo $valores['id_categoria_atividade']; ?>" /></td>
                        <td class="id_categoria_atividade"><?php echo $valores['id_categoria_atividade']; ?></td>
                        <td class="nome"><?php echo $valores['nome_categoria_atividade']; ?></td>
                        <td class="tipo_atividade">
                            <?php
                            echo $tipo_atividade->id_tipo_atividade;
                            ?>
                        </td>
                        <td class="Nome_atividade">
                            <?php
                            echo $tipo_atividade->nome_tipo_atividade;
                            ?>
                        </td>
                        <td class="resumo"><?php echo $valores['resumo']; ?></td>
                        <td class="visto"><?php echo $valores['visto']; ?></td>
                        <td class="max_horas"><?php echo $valores['max_horas']; ?></td>
                        <td class="hora_fixa"><?php echo $valores['hora_fixa']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_categoria_atividade[]=<?php echo $valores['id_categoria_atividade']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>