<?php
include "includes/header.php";
$sessao->verificarNivel(1);
?>


<?php
?>

<h1>Relatorio de Horas - Atividades dos Alunos</h1>

<div class="box">
    <span class="titulo">Lista de Alunos</span> 

    <?php
    $retorno_atividade = new Atividade();
    $retorno = $retorno_atividade->listarAlunosHorasAtividades();
    if (!$retorno):
        echo "Não foi localizado nenhum Atividade cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">

                    <td>Id Aluno</td>
                    <td>Nome Aluno</td>
                    <td>Turma</td>
                    <td>Horas Minima desse Semestre</td>
                    <td>Total de Horas</td>


                </tr>

                <?php
                foreach ($retorno as $valores):
                    $aluno = new Aluno;
                    $aluno->selecionarAluno($valores['id_aluno']);
                    
                    $aula = new Aula();
                    $aula->selecionarAula($valores['id_aula']);
                    
                    $turma = new Turma();
                    $curso_semestre = new Curso_Semestre();
                    $curso = new Curso();
                    $semestre = new Semestre();
                    $periodo = new Periodo();

                    $turma->selecionarTurma($aula->id_turma);

                    $curso_semestre->selecionarCurso_Semestre($turma->id_curso_semestre);
                    $curso->selecionarCurso($curso_semestre->id_curso);
                    $semestre->selecionarSemestre($curso_semestre->id_semestre);
                    $periodo->selecionarPeriodo($turma->id_periodo);
                    ?>
                    <tr class="curso <?php echo $valores['id_atividade']; ?>">
                        <td>
                            <?php
                            echo $aluno->id_aluno;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $aluno->nome_aluno;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $curso->nome_curso . " - " . $semestre->nome_semestre . " - " . $periodo->nome_periodo . " - " . $turma->identificador . " - " . $turma->ano;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $curso_semestre->min_horas;
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($valores['total_horas'] >= $curso_semestre->min_horas):
                                ?>
                            <span class="vistada"><?php echo $valores['total_horas']; ?></span>
                                <?php
                            else:
                                ?>
                            <span class="nao_vistada"><?php echo $valores['total_horas']; ?></span>
                            <?php
                            endif;
                            ?>
                        </td>       
                    </tr>
                        <?php endforeach; ?>
            </table>
           
        </form>
<?php endif; ?>

</div><!-- end .box-->
    <?php include"includes/footer.php" ?>