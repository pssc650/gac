<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['curso']) && $_POST['curso'] != ""):
    $curso_semestre = new Curso_Semestre($_POST['curso'], $_POST['semestre'], $_POST['min_horas']);
    $curso_semestre->cadastrarCurso_Semestre();
    unset($curso_semestre);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_curso_semestre = $_GET['id_curso_semestre'];
    foreach ($ids_curso_semestre as $id_curso_semestre):
        /* Instanciando um objeto temporario */
        $curso_semestre = new Curso_Semestre ();
        if ($curso_semestre->selecionarCurso_Semestre($id_curso_semestre)):
            $curso_semestre->deletarCurso_Semestre();
            /* Deletando o objeto */
            unset($curso_semestre);
        endif;

    endforeach;
endif;
?>

<h1>Administrador de Curso Semestres</h1>

<div class="box">
    <span class="titulo">Cadastrar Curso Semestre</span> 
    <form method="post">
        <p>Curso:
            <select name="curso">
                <option></option>
                <?php
                $curso = new Curso();
                $resultado = $curso->listarCurso();
                if (!$resultado):
                    ?>
                    <option value="">Cadastre Curso</option>
                    <?php
                else:
                    foreach ($resultado as $valores):
                        ?>
                        <option value="<?php echo $valores['id_curso']; ?>"><?php echo $valores['nome_curso']; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </p>
        <p>Semestre:
            <select name="semestre">
                <option></option>
                <?php
                $semestre = new Semestre();
                $resultado = $semestre->listarSemestre();
                if (!$resultado):
                    ?>
                    <option value="">Cadastre Semestres</option>
                    <?php
                else:
                    foreach ($resultado as $valores):
                        ?>
                        <option value="<?php echo $valores['id_semestre']; ?>"><?php echo $valores['nome_semestre']; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </p>
        <p>Digite o minimo de Horas que o Aluno tem que Completar: <input type="text" name="min_horas" /> Ex. 10 ou 80</p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Curso_Semestre</span> 

    <?php
    $retorno_curso_semestre = new Curso_Semestre();
    $retorno = $retorno_curso_semestre->listarCurso_Semestre();
    if (!$retorno):
        echo "Não foi localizado nenhum Curso Semestre cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Curso_Semestre</td>
                    <td>Curso</td>
                    <td>Semestre</td>
                    <td>Quantidade Minima de Horas</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="Curso_Semestre <?php echo $valores['id_curso_semestre']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_curso_semestre[]" value="<?php echo $valores['id_curso_semestre']; ?>" /></td>
                        <td class="id_curso_semestre"><?php echo $valores['id_curso_semestre']; ?></td>
                        <td class="curso">
                            <?php
                            $curso = new Curso();
                            $curso->selecionarCurso($valores['id_curso']);
                            echo $curso->nome_curso;
                            unset($curso);
                            ?>
                        </td>
                        <td class="semestre">
                            <?php
                            $semestre = new Semestre();
                            $semestre->selecionarSemestre($valores['id_semestre']);
                            echo $semestre->nome_semestre;
                            unset($semestre);
                            ?>
                        </td>
                        <td class="min_horas">
                            <?php
                            echo $valores['min_horas'];
                            ?>
                        </td>
                        <td class="deletar"><a href="?acao=deletar&id_curso_semestre[]=<?php echo $valores['id_curso_semestre']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>