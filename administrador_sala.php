<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['turma']) && $_POST['turma'] != ""):
    $sala = new Sala($_POST['turma'], $_POST['periodo']);
    $sala->cadastrarSala();
    unset($sala);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_sala = $_GET['id_sala'];
    foreach ($ids_sala as $id_sala):
        /* Instanciando um objeto temporario */
        $sala = new Sala ();
        if ($sala->selecionarSala($id_sala)):
            $sala->deletarSala();
            /* Deletando o objeto */
            unset($sala);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Salas</h1>

<div class="box">
    <span class="titulo">Cadastrar Sala</span> 
    <form method="post">
        <p>Turma:
            <select name="turma">
                <option></option>
                <?php
                $turma = new Turma();
                $resultado = $turma->listarTurma();
                if (!$resultado):
                    ?>
                    <option value="">Cadastre Curso</option>
                    <?php
                else:
                    foreach ($resultado as $valores):
                        ?>
                        <option value="<?php echo $valores['id_turma']; ?>">
                            <?php
                                $turma = new Turma();
                                $turma->selecionarTurma($valores['id_turma']);

                                $curso = new Curso();
                                $semestre = new Semestre();
                                $curso->selecionarCurso($turma->id_curso);
                                $semestre->selecionarSemestre($turma->id_semestre);

                                echo $curso->nome_curso . " - " . $semestre->nome_semestre;

                                unset($turma);
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
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Salas</span> 

    <?php
    $sala = new Sala();
    $retorno_Sala = $sala->listarSala();
    if (!$retorno_Sala):
        echo "Não foi localizado nenhum Sala cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Sala</td>
                    <td>Periodo</td>
                    <td>Identificador</td>
                    <td>Id Turma</td>
                    <td>Curso</td>
                    <td>Semestre</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno_Sala as $valores):
                    ?>
                    <tr class="Sala <?php echo $valores['id_sala']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_sala[]" value="<?php echo $valores['id_sala']; ?>" /></td>
                        <td class="id_sala"><?php echo $valores['id_sala']; ?></td>
                        <td class="periodo">
                            <?php
                                $periodo = new Periodo();
                                $periodo->selecionarPeriodo($valores['id_periodo']);
                                echo $periodo->nome_periodo;
                            ?>
                        </td>
                        <td class="identificador"><?php echo $valores['identificador']; ?></td>
                        <td class="id_turma"><?php echo $valores['id_turma']; ?></td>
                        <?php
                            $turma = new Turma();
                            $turma->selecionarTurma($valores['id_turma']);

                            $curso = new Curso();
                            $semestre = new Semestre();
                            $curso->selecionarCurso($turma->id_curso);
                            $semestre->selecionarSemestre($turma->id_semestre);
                        ?>
                        <td class="curso"><?php echo $curso->nome_curso; ?></td>
                        <td class="semestre"><?php echo $semestre->nome_semestre; ?></td>
                        <td class="deletar"><a href="?acao=deletar&id_sala[]=<?php echo $valores['id_sala']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>