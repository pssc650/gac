<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['id_turma']) && isset($_POST['id_professor']) && isset($_POST['id_disciplina'])):
    if ($_POST['id_turma'] == "" || $_POST['id_professor'] == "" || $_POST['id_disciplina'] == ""):
        Alerta::alertarUsuario("Selecione uma Turma, PROFESSOR e uma DISCIPLINA.", 0);
    else:
        $aula = new Aula($_POST['id_turma'], $_POST['id_professor'], $_POST['id_disciplina']);
        $aula->cadastrarAula();
        unset($aula);
    endif;
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_aula = $_GET['id_aula'];
    foreach ($ids_aula as $id_aula):
        /* Instanciando um objeto temporario */
        $aula = new Aula ();
        if ($aula->selecionarAula($id_aula)):
            $aula->deletarAula();
            /* Deletando o objeto */
            unset($aula);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Aulas</h1>

<div class="box">
    <span class="titulo">Cadastrar Aula</span> 
    <div class="box">
        <span class="titulo">Selecione uma Curso_Semestre</span> 
        Selecione uma Curso_Semestre para listar todas as suas Turmas e suas Disciplinas:
        <form method="post">
            <p>Curso_Semestres:
                <select name="id_curso_semestre">
                    <option></option>
                    <?php
                    $curso_semestre = new Curso_Semestre();
                    $retorno = $curso_semestre->listarCurso_Semestre();

                    foreach ($retorno as $valores):
                        ?>
                        <option value="<?php echo $valores['id_curso_semestre']; ?>">
                            <?php
                            $curso = new Curso();
                            $semestre = new Semestre();

                            $curso->selecionarCurso($valores['id_curso']);
                            $semestre->selecionarSemestre($valores['id_semestre']);

                            echo $curso->nome_curso . " - " . $semestre->nome_semestre;
                            ?>
                        </option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </p>
            <p><input type="submit" value="Selecionar" /></p>
        </form>
    </div><!-- end .box-->
    <?php
    if (isset($_POST['id_curso_semestre']) && $_POST['id_curso_semestre'] == ""):
        Alerta::alertarUsuario("Selecione uma Curso_Semestre", 0);
    elseif (isset($_POST['id_curso_semestre'])):

        $turma = new Turma();
        $lista_disciplina = new Lista_Disciplina();
        $professor = new Professor();

        $retorno_professor = $professor->listarProfessor();
        $retorno_lista_disciplina = $lista_disciplina->listarLista_Disciplina($_POST['id_curso_semestre']);
        $retorno_turma = $turma->listarTurma($_POST['id_curso_semestre']);
        ?>
        <div class="box">
            <span class="titulo">Selecione uma Curso_Semestre</span> 
            <?php
            if (!is_array($retorno_turma)):
                echo 'Curso_Semestre selecionada não possui Turmas, <a hef="administrador_turmas.php"> CADASTRE AQUI. </a>';

            elseif (!is_array($retorno_lista_disciplina)):
                echo 'Curso_Semestre selecionada não possui Disciplinas, <a href="administrador_lista_disciplina.php"> CADASTRE AQUI. </a>';
            else:
                ?>
                Selecione uma Turma, Disciplina e Professor para Criar uma AULA.
                <form method="post">
                    <p>Turma:
                        <select name="id_turma">
                            <option></option>
                            <?php
                            foreach ($retorno_turma as $valores):
                                ?>
                                <option value="<?php echo $valores['id_turma']; ?>">
                                    <?php
                                    $turma = new Turma();
                                    $curso_semestre = new Curso_Semestre();
                                    $curso = new Curso();
                                    $semestre = new Semestre();
                                    $periodo = new Periodo();

                                    $turma->selecionarTurma($valores['id_turma']);
                                   
                                    $curso_semestre->selecionarCurso_Semestre($turma->id_curso_semestre);
                                    $curso->selecionarCurso($curso_semestre->id_curso);
                                    $semestre->selecionarSemestre($curso_semestre->id_semestre);
                                    $periodo->selecionarPeriodo($turma->id_periodo);
                                    echo $curso->nome_curso . " - " . $semestre->nome_semestre . " - " . $periodo->nome_periodo . " - " . $turma->identificador . " - " . $turma->ano;
                                    ?>

                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </p>

                    <p>Professor:
                        <select name="id_professor">
                            <option></option>
                            <?php
                            foreach ($retorno_professor as $valores):
                                ?>
                                <option value="<?php echo $valores['id_professor'] ?>">
                                    <?php
                                    echo $valores['nome_professor'];
                                    ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </p>
                    <p>Disciplinas:
                        <select name="id_disciplina">
                            <option></option>
                            <?php
                            foreach ($retorno_lista_disciplina as $valores):
                                ?>
                                <option value="<?php echo $valores['id_disciplina']; ?>">
                                    <?php
                                    $disciplina = new Disciplina();
                                    $disciplina->selecionarDisciplina($valores['id_disciplina']);
                                    echo $disciplina->nome_disciplina;
                                    ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </p>
                    <p><input type="submit" value="Cadastrar" /></p>
                </form>
            </div><!-- end .box-->
        <?php
        endif;

    endif;
    ?>




</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Aula</span> 

    <?php
    $retorno_aula = new Aula();
    $retorno = $retorno_aula->listarAula();
    if (!$retorno):
        echo "Não foi localizado nenhuma Aula cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Aula</td>
                    <td>Turma</td>
                    <td>Professor</td>
                    <td>Disciplina</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="Aula <?php echo $valores['id_aula']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_aula[]" value="<?php echo $valores['id_aula']; ?>" /></td>
                        <td class="id_aula"><?php echo $valores['id_aula']; ?></td>
                        <td class="Turma">
                            <?php
                            $turma = new Turma();
                            $curso_semestre = new Curso_Semestre();
                            $curso = new Curso();
                            $semestre = new Semestre();
                            $periodo = new Periodo();

                            $turma->selecionarTurma($valores['id_turma']);
                            $curso_semestre->selecionarCurso_Semestre($turma->id_curso_semestre);
                            $curso->selecionarCurso($curso_semestre->id_curso);
                            $semestre->selecionarSemestre($curso_semestre->id_semestre);
                            $periodo->selecionarPeriodo($turma->id_periodo);
                            echo $curso->nome_curso . " - " . $semestre->nome_semestre . " - " . $periodo->nome_periodo . " - " . $turma->identificador . " - " .$turma->ano;
                            ?>
                        </td>
                        <td class="professor">
                            <?php
                            $professor = new Professor();
                            $professor->selecionarProfessor($valores['id_professor']);
                            echo $professor->nome_professor;
                            ?>
                        </td>
                        <td class="disciplina">
                            <?php
                            $disciplina = new Disciplina();
                            $disciplina->selecionarDisciplina($valores['id_disciplina']);
                            echo $disciplina->nome_disciplina;
                            ?>
                        </td>
                        <td class="deletar"><a href="?acao=deletar&id_aula[]=<?php echo $valores['id_aula']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif; ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>