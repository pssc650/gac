<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['Curso_Semestre']) && $_POST['Curso_Semestre'] != ""):
    $turma = new Turma($_POST['Curso_Semestre'], $_POST['periodo'], $_POST['ano']);
    $turma->cadastrarTurma();
    unset($turma);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_turma = $_GET['id_turma'];
    foreach ($ids_turma as $id_turma):
        /* Instanciando um objeto temporario */
        $turma = new Turma ();
        if ($turma->selecionarTurma($id_turma)):
            $turma->deletarTurma();
            /* Deletando o objeto */
            unset($turma);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Turmas</h1>

<div class="box">
    <span class="titulo">Cadastrar Turma</span> 
    <form method="post">
        <p>Curso_Semestre:
            <select name="Curso_Semestre">
                <option></option>
                <?php
                $curso_semestre = new Curso_Semestre();
                $resultado = $curso_semestre->listarCurso_Semestre();
                if (!$resultado):
                    ?>
                    <option value="">Cadastre Curso</option>
                    <?php
                else:
                    foreach ($resultado as $valores):
                        ?>
                        <option value="<?php echo $valores['id_curso_semestre']; ?>">
                            <?php
                            $curso_semestre = new Curso_Semestre();
                            $curso_semestre->selecionarCurso_Semestre($valores['id_curso_semestre']);

                            $curso = new Curso();
                            $semestre = new Semestre();
                            $curso->selecionarCurso($curso_semestre->id_curso);
                            $semestre->selecionarSemestre($curso_semestre->id_semestre);

                            echo $curso->nome_curso . " - " . $semestre->nome_semestre;

                            unset($curso_semestre);
                            unset($curso);
                            unset($semestre);
                            ?>
                        </option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </p>
        <p>Periodo:
            <select name="periodo">
                <option></option>
                <?php
                $periodo = new Periodo();
                $resultado = $periodo->listarPeriodo();
                if (!$resultado):
                    ?>
                    <option value="">Cadastre Periodo</option>
                    <?php
                else:
                    foreach ($resultado as $valores):
                        ?>
                        <option value="<?php echo $valores['id_periodo']; ?>"><?php echo $valores['nome_periodo']; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </p>
        <p>Ano: 
            <select name="ano">
                <option></option>
                <?php
                for ($x = 2012; $x < 2020; $x++):
                    ?>
                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                    <?php
                endfor;
                ?>
            </select>
        </p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Turmas</span> 

    <?php
    $turma = new Turma();
    $retorno_turma = $turma->listarTurma();
    if (!$retorno_turma):
        echo "Não foi localizado nenhum Turma cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Turma</td>
                    <td>Periodo</td>
                    <td>Identificador</td>
                    <td>Id Curso_Semestre</td>
                    <td>Curso</td>
                    <td>Semestre</td>
                    <td>Ano</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno_turma as $valores):
                    ?>
                    <tr class="Turma <?php echo $valores['id_turma']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_turma[]" value="<?php echo $valores['id_turma']; ?>" /></td>
                        <td class="id_turma"><?php echo $valores['id_turma']; ?></td>
                        <td class="periodo">
                            <?php
                            $periodo = new Periodo();
                            $periodo->selecionarPeriodo($valores['id_periodo']);
                            echo $periodo->nome_periodo;
                            ?>
                        </td>
                        <td class="identificador"><?php echo $valores['identificador']; ?></td>
                        <td class="id_curso_semestre"><?php echo $valores['id_curso_semestre']; ?></td>
                        <?php
                        $curso_semestre = new Curso_Semestre();
                        $curso_semestre->selecionarCurso_Semestre($valores['id_curso_semestre']);

                        $curso = new Curso();
                        $semestre = new Semestre();
                        $curso->selecionarCurso($curso_semestre->id_curso);
                        $semestre->selecionarSemestre($curso_semestre->id_semestre);
                        ?>
                        <td class="curso"><?php echo $curso->nome_curso; ?></td>
                        <td class="semestre"><?php echo $semestre->nome_semestre; ?></td>
                        <td class="ano"><?php echo $valores['ano']; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_turma[]=<?php echo $valores['id_turma']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>