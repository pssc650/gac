<?php
include "includes/header.php";
$sessao->verificarNivel(3);
?>


<?php
if (isset($_POST['nome_atividade']) && $_POST['nome_atividade'] != ""):
    $arquivo = new Arquivo($_FILES['nome_arquivo']);
    if ($arquivo->uploadArquivo()):
        $atividade = new Atividade($_POST['id_aula'], $usuario->id_aluno, $_POST['id_categoria_atividade'], $_POST['nome_atividade'], $_POST['descricao_atividade'], $_POST['horas'], $arquivo->nome_arquivo);
        $atividade->cadastrarAtividade();
        unset($atividade);
    endif;

endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_atividade = $_GET['id_atividade'];
    foreach ($ids_atividade as $id_atividade):
        /* Instanciando um objeto temporario */
        $atividade = new Atividade ();
        if ($atividade->selecionarAtividade($id_atividade)):
            $atividade->deletarAtividade();
            /* Deletando o objeto */
            unset($atividade);
        endif;

    endforeach;
endif;
?>

<h1>Gerenciador de Atividades</h1>

<div class="box">
    <div class="box">
        <span class="titulo">Selecione uma Categoria</span> 
        <form method="post" enctype="multipart/form-data">
            <p>Categoria da Atividade: 
                <select name="id_categoria_atividade">
                    <option></option>
                    <?php
                    $categoria_atividade = new Categoria_Atividade();
                    $retorno_categoria_atividade = $categoria_atividade->listarCategoria_Atividade();

                    foreach ($retorno_categoria_atividade as $valores):
                        ?>
                        <option value="<?php echo $valores['id_categoria_atividade']; ?>"><?php echo $valores['nome_categoria_atividade']; ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </p>
            <p><input type="submit" value="Selecionar" /></p>
        </form>
    </div><!-- end .box-->

    <?php
    if (isset($_POST['id_categoria_atividade']) && $_POST['id_categoria_atividade'] != ""):
        $categoria_atividade = new Categoria_Atividade();
        $categoria_atividade->selecionarCategoria_Atividade($_POST['id_categoria_atividade']);
        ?>

        <div class="box">
            <span class="titulo">Cadastrar Atividade</span> 
            <form method="post" enctype="multipart/form-data">
                <?php
                if ($categoria_atividade->visto == "Sim"):
                    ?>
                    <p>Aula:
                        <select name="id_aula">
                            <option></option>                
                            <?php
                            $aula = new Aula();
                            $retorno_aula = $aula->listarAula($usuario->id_turma);
                            foreach ($retorno_aula as $valores):
                                $professor = new Professor();
                                $disciplina = new Disciplina();

                                $disciplina->selecionarDisciplina($valores['id_disciplina']);
                                $professor->selecionarProfessor($valores['id_professor']);
                                ?>

                                <option value="<?php echo $valores['id_aula']; ?>">
                                    <?php
                                    echo $professor->nome_professor . " - " . $disciplina->nome_disciplina;
                                    ?>
                                </option>
                                <?php
                            endforeach;
                            ?>        
                        </select>
                    </p>
                    <?php
                else :
                    ?>
                    <input type="hidden" name="id_aula" value="">
                <?php
                endif;
                ?>

                <p>
                    Nome: 
                    <input type="text" name="nome_atividade" />
                </p>

                <p>Descrição:</p>
                <p><textarea name="descricao_atividade" cols="30" rows="5"></textarea>

                </p>
                <p>Quantidade de Horas:

                    <?php if ($categoria_atividade->hora_fixa != 0):
                        ?>
                        <input type="text" name="horas" value=" <?php echo $categoria_atividade->hora_fixa; ?>" readonly>
                        <?php
                    else:
                        ?>
                        <input type="text" name="horas" value="">
                    <?php
                    endif;
                    ?>
                </p>
                <p>Categoria Seleciona: <strong><?php echo $categoria_atividade->nome_categoria_atividade; ?></strong></p>
                <p>Selecione o Resumo ou Comprovante da Atividade: </p>
                <p><input type="file" name="nome_arquivo" ></p>
                <p><input type="hidden" name="id_categoria_atividade" value="<?php echo $_POST['id_categoria_atividade'] ?>">
                    <input type="submit" value="Cadastrar" /></p>
            </form>
        </div><!-- end .box-->
    </div><!-- end .box-->    
    <?php
endif;
?>

<div class="box">
    <span class="titulo">Lista de Atividade</span> 

    <?php
    $retorno_atividade = new Atividade();
    $retorno = $retorno_atividade->listarAtividade($usuario->id_aluno);
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
                    <td>Categoria</td>
                    <td>Nome</td>
                    <td>Descricao</td>
                    <td>Arquivo</td>
                    <td>Visto</td>
                    <td>Horas</td>
                    <td></td>

                </tr>

                <?php
                $total_horas = "";
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
                        <td class="categoria_atividade">
                            <?php
                            $categoria_atividade = new Categoria_Atividade();
                            $categoria_atividade->selecionarCategoria_Atividade($valores['id_categoria_atividade']);
                            echo $categoria_atividade->nome_categoria_atividade;
                            ?>
                        </td>
                        <td class="nome"><?php echo $valores['nome_atividade']; ?></td>
                        <td class="descricao"><?php echo $valores['descricao_atividade']; ?></td>

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
                                <span class="nao_vistada">Atividade não aceita, verifique com professor</span>
                            <?php
                            endif;
                            ?>
                        </td>
                        <td class="horas">
                            <?php
                            $total_horas +=$valores['horas'];
                            echo $valores['horas'];
                            ?>
                        </td>
                        <?php
                        if ($valores['visto'] == 0):
                            ?>
                            <td class="deletar">
                                <a href="?acao=deletar&id_atividade[]=<?php echo $valores['id_atividade']; ?>" class="deletar"></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Total Horas:</strong></td>
                    <td><strong><?php echo $total_horas; ?></strong></td>
                    <td></td>

                </tr>
            </table>
            <!--Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>-->
        </form>
    <?php endif; ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>