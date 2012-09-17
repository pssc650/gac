<?php
include "includes/header.php";
$sessao->verificarNivel(0);
?>


<?php
if (isset($_POST['nome']) && $_POST['nome'] != ""):
    $aluno = new Aluno("", $_POST['nome'], $_POST['id_turma'], $_POST['login'], $_POST['senha']);
    if ($aluno->cadastrar()):
        Alerta::alertarUsuario("Aluno cadastrado com sucesso.", 1);
    else:
        Alerta::alertarUsuario("Não foi possível cadastrar aluno.", 0);
    endif;
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_aluno = $_GET['id_aluno'];
    foreach ($ids_aluno as $id_aluno):
        /* Instanciando um objeto temporario */
        $aluno = new Aluno ();
        if ($aluno->selecionarAluno($id_aluno)):
            $aluno->deletarUsuario();
        endif;

        /* Deletando o objeto */
        unset($aluno);
    endforeach;
endif;
?>
<h1>Administrador de Alunos</h1>

<div class="box">
    <span class="titulo">Cadastrar Aluno</span> 
    <form method="post">
        <p>Nome: <input type="text" name="nome" /></p>
        <p>Turma: 
            <select name="id_turma">
                <option></option>
                <?php
                $turma = new Turma();
                $retorno_turma = $turma->listarTurma();
                foreach ($retorno_turma as $valores):
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
                    ?>
                    <option value="<?php echo $turma->id_turma; ?>"><?php echo $curso->nome_curso . " - " . $semestre->nome_semestre . " - " . $periodo->nome_periodo . " - " . $turma->identificador . " - " .$turma->ano; ?> </option>
                    <?php
                endforeach;
                ?>
            </select>
        </p>
        <p>Login: <input type="text" name="login" /></p>
        <p>Senha: <input type="text" name="senha" /></p>
        <p><input type="submit" value="Cadastrar" /></p>
    </form>
</div><!-- end .box-->

<div class="box">
    <span class="titulo">Lista de Aluno</span> 

    <?php
    $retorno_aluno = new Aluno();
    $retorno = $retorno_aluno->listarAluno();
    if (!$retorno):
        echo "Não foi localizado nenhum Aluno cadastro.";
    else:
        ?>
        <form method="get">
            <table class="lista_dados">
                <tr class="cabecalho">
                    <td></td>
                    <td>Id Aluno</td>
                    <td>Nome</td>
                    <td>Turma</td>
                    <td></td>

                </tr>

                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="curso <?php echo $valores['id_aluno']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_aluno[]" value="<?php echo $valores['id_aluno']; ?>" /></td>
                        <td class="id_aluno"><?php echo $valores['id_aluno']; ?></td>
                        <td class="nome"><?php echo $valores['nome_aluno']; ?></td>                       
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

                        <td class="deletar"><a href="?acao=deletar&id_aluno[]=<?php echo $valores['id_aluno']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Deletar"  name="acao"/>
        </form>
    <?php endif; ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>