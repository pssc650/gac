<?php
include 'includes/header.php';
$sessao->verificarNivel(0);
?>

<?php
if (isset($_POST['login']) && $_POST['login'] != ""):
    $usuario = new Usuario($_POST['login'], $_POST['senha'], "0");
    if ($usuario->cadastrarUsuario()):
        Alerta::alertarUsuario("Usuario cadastrado com sucesso.", 1);
    else:
        Alerta::alertarUsuario("Não foi possível cadastrar o Usuario.", 0);
    endif;
    unset($usuario);
endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'deletar'):
    $ids_usuario = $_GET['id_usuario'];
    foreach ($ids_usuario as $id_usuario):
        /* Instanciando um objeto temporario */
        $usuario_temp = new Usuario ();
        if ($usuario_temp->selecionarUsuario($id_usuario)):
            $usuario_temp->deletarUsuario();
        endif;

        /* Deletando o objeto usuario */
        unset($usuario_temp);
    endforeach;

endif;

if (isset($_GET['acao']) && strtolower($_GET['acao']) == 'status'):
    $ids_usuario = $_GET['id_usuario'];
    foreach ($ids_usuario as $id_usuario):
        /* Instanciando um objeto temporario */
        $usuario_temp = new Usuario ();
        if ($usuario_temp->selecionarUsuario($id_usuario)):
            $usuario_temp->alterarStatus();
        endif;
        
        /* Deletando o objeto usuario */
        unset($usuario_temp);
    endforeach;
endif;
?>

<h1>Administrador de Usuarios</h1>

<div class="box">
    <span class="titulo">Cadastrar Usuarios Administrador</span> 
    <form method="post" action="?">
        <p>Login: <input type="text" name="login" /></p>
        <p>Senha: <input type="text" name="senha" /></p>
        <input type="hidden" name="status" value="1" />
        <p><input type="submit" value="Cadastrar" class="ch-btn ch-btn-tiny" /></p>
    </form>
</div><!-- end .box-->


<div class="box">
    <span class="titulo">Lista de Usuarios</span> 

    <?php
    $retorno_usuario = new Usuario();
    $retorno = $retorno_usuario->listarUsuario();
    if (!$retorno):
        echo "Não foi localizado nenhum usuario cadastro.";
    else:
        ?>
        <form method="get">
            <table class="ch-datagrid">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Id Usuario</th>
                        <th scope="col">Login</th>
                        <th scope="col">Senha</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Status</th>
                        <th scope="col">Alterar Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php
                foreach ($retorno as $valores):
                    ?>
                    <tr class="usuario <?php echo $valores['id_usuario']; ?>">
                        <td class="checkbox"><input type="checkbox" name="id_usuario[]" value="<?php echo $valores['id_usuario']; ?>" /></td>
                        <td class="id_usuario"><?php echo $valores['id_usuario']; ?></td>
                        <td class="login"><?php echo $valores['login']; ?></td>
                        <td class="senha"><?php echo $valores['senha']; ?></td>
                        <td class="nivel"><?php echo $valores['nivel']; ?></td>
                        <td class="status">
                            <?php
                            if ($valores['status'] == 1):
                                echo "Ativo";
                            else:
                                echo "Desativado";
                            endif;
                            ?></td>
                        <td class="alterar_status">
                            <?php if ($valores['status'] == 1): ?>
                                <a href="?acao=status&id_usuario[]=<?php echo $valores['id_usuario']; ?>"><span class="ativar"></span></a>  
                            <?php else: ?>
                                <a href="?acao=status&id_usuario[]=<?php echo $valores['id_usuario']; ?>"><span class="desativar"></span></a>


                            <?php endif; ?></td>
                        <td class="deletar-td"><a href="?acao=deletar&id_usuario[]=<?php echo $valores['id_usuario']; ?>" class="deletar"></a></td>

                    </tr>
                <?php endforeach; ?>
            </table>
            Ações em Massa: <input type="submit" value="Status" name="acao" class="ch-btn ch-btn-tiny"/> <input type="submit" value="Deletar" name="acao" class="ch-btn ch-btn-tiny"/>
        </form>
    <?php endif;
    ?>

</div><!-- end .box-->
<?php include"includes/footer.php" ?>