<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['Curso_Semestre']) && $_POST['Curso_Semestre'] != ""):
    $lista_disciplina = new Lista_Disciplina($_POST['Curso_Semestre'], $_POST['disciplina']);
    $lista_disciplina->cadastrarLista_Disciplina();
    unset($lista_disciplina);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_curso_semestre = $_GET['id_curso_semestre'];
    $ids_disciplina = $_GET['id_disciplina'];
    $lista_disciplina = array();

    $quantidade_array = count($ids_curso_semestre);
    for ($x = 0; $x < $quantidade_array; $x++):
        $lista_disciplina[$x]['id_curso_semestre'] = $ids_curso_semestre[$x];
        $lista_disciplina[$x]['id_disciplina'] = $ids_disciplina[$x];
    endfor;

    foreach ($lista_disciplina as $valores):
        /* Instanciando um objeto temporario */
        $lista_disciplina = new Lista_Disciplina ();
        if ($lista_disciplina->selecionarLista_Disciplina($valores['id_curso_semestre'], $valores['id_disciplina'])):
            $lista_disciplina->deletarLista_Disciplina();
        endif;
        /* Deletando o objeto */
        unset($lista_disciplina);

    endforeach;
endif;
?>

<h1>Administrador de Lista_Disciplinas</h1>

<div class="box">
    <span class="titulo">Cadastrar Lista_Disciplina</span> 
    <form method="post" action="?">
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
            <select name="disciplina">
                <option></option>
                <?php
                $disciplina = new Disciplina();
                $resultado = $disciplina->listarDisciplina();
                if (!$resultado):
                    ?>
                    <option value="">Cadastre Disciplina</option>
                    <?php
                else:
                    foreach ($resultado as $valores):
                        ?>
                        <option value="<?php echo $valores['id_disciplina']; ?>"><?php echo $valores['nome_disciplina']; ?></option>
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
    <span class="titulo">Lista de Lista_Disciplinas</span> 

    <?php
    $lista_disciplina = new Lista_Disciplina();
    $retorno_lista_disciplina = $lista_disciplina->listarLista_Disciplina();
    if (!$retorno_lista_disciplina):
        echo "Não foi localizado nenhum Lista_Disciplina cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Curso_Semestre</td>
                    <td>Curso</td>
                    <td>Semestre</td>
                    <td>Disciplina</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno_lista_disciplina as $valores):
                    ?>
                    <tr class="Lista_Disciplina <?php echo $valores['id_curso_semestre']; ?>">
                        <td class="checkbox">
                            <input type="checkbox" name="id_curso_semestre[]" value="<?php echo $valores['id_curso_semestre']; ?>" />
                            <input type="hidden" name="id_disciplina[]" value="<?php echo $valores['id_disciplina']; ?>" />
                        </td>
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
                        <td class="disciplina">
                            <?php
                            $disciplina = new Disciplina();
                            $disciplina->selecionarDisciplina($valores['id_disciplina']);
                            echo $disciplina->nome_disciplina;
                            ?>
                        </td>
                        <td class="deletar"><a href="?acao=deletar&id_curso_semestre[]=<?php echo $valores['id_curso_semestre']; ?>&id_disciplina[]=<?php echo $valores['id_disciplina']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>