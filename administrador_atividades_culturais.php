<?php
include "includes/header.php";
$sessao->verificarNivel(1);
?>


<?php
if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'aceitar'):
    $ids_atividade = $_GET['id_atividade'];
    foreach ($ids_atividade as $id_atividade):
        /* Instanciando um objeto temporario */
        $atividade = new Atividade ();
        if ($atividade->selecionarAtividade($id_atividade)):
            $atividade->aceitarAtividade();
            /* Deletando o objeto */
            unset($atividade);
        endif;

    endforeach;
endif;
if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'recusar'):
    $ids_atividade = $_GET['id_atividade'];
    foreach ($ids_atividade as $id_atividade):
        /* Instanciando um objeto temporario */
        $atividade = new Atividade ();
        if ($atividade->selecionarAtividade($id_atividade)):
            $atividade->recusarAtividade();
            /* Deletando o objeto */
            unset($atividade);
        endif;

    endforeach;
endif;
?>

<h1>Gerenciador de Atividades</h1>

<div class="box">
    <span class="titulo">Lista de Atividade Culturais</span> 

    <?php
    $atividade = new Atividade();
    $retorno = $atividade->listarAtividadeProfessor("", "0", "0");
    if (!$retorno):
        echo "Não foi localizado nenhum Atividade cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Atividade</td>
                    <td>Aula</td>
                    <td>Id do Aluno</td>
                    <td>Nome do Aluno</td>
                    <td>Descricao</td>
                    <td>Horas</td>
                    <td>Arquivo</td>
                    <td>Visto</td>
                    <td>Aceitar Atividade</td>
                    <td>Recusar Atividade</td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="curso <?php echo $valores['id_atividade']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_atividade[]" value="<?php echo $valores['id_atividade']; ?>" /></td>
                        <td class="id_atividade"><?php echo $valores['id_atividade']; ?></td>
                        <td class="id_aula">
                            <?php
                            $aula = new Aula();
                            $aula->selecionarAula($valores['id_aula']);
                            $professor = new Professor();
                            $disciplina = new Disciplina();

                            $disciplina->selecionarDisciplina($aula->id_disciplina);
                            $professor->selecionarProfessor($aula->id_professor);

                            echo $professor->nome_professor . " - " . $disciplina->nome_disciplina;
                            ?>
                        </td>
                        <td class="id_aluno"><?php echo $valores['id_aluno']; ?></td>
                        <td class="nome"><?php echo $valores['nome_atividade']; ?></td>
                        <td class="descricao"><?php echo $valores['descricao_atividade']; ?></td>
                        <td class="horas"><?php echo $valores['horas']; ?></td>
                        <td class="nome_arquivo"><a href="arquivos/<?php echo $valores['nome_arquivo']; ?>"><?php echo $valores['nome_arquivo']; ?></a></td>
                        <td class="visto">
                            <?php
                            if ($valores['visto'] == 1):
                                ?>
                                <span class="vistada">Atividade Vistada</span>
                                <?php
                            elseif ($valores['visto'] == 0):
                                ?>
                                <span class="nao_vistada">Atividade não Vistada</span>
                                <?php
                            else:
                                ?>
                                <span class="nao_vistada">Atividade não aceita, verificar com aluno</span>
                            <?php
                            endif;
                            ?>
                        </td>
                        <td class=""><a href="?acao=aceitar&id_atividade[]=<?php echo $valores['id_atividade']; ?>"><span class="ativar"></span></a></td>
                        <td class=""><a href="?acao=recusar&id_atividade[]=<?php echo $valores['id_atividade']; ?>"><span class="desativar"></span></a></td>


                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Aceitar"  name="acao"/><input type="submit" value="Recusar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>