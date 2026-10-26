<?php
session_start();
echo '<title>Login | Loja - Hollow Knight</title>';
echo '<link rel="stylesheet" href="../style.css">';
echo '<meta charset="UTF-8">';
echo '<script src="../script.js"></script>';
include '../conexao.php';
$erro_login = false;
$login = "";

if(isset($_POST['txt_login'])) {
    $login = $_POST['txt_login'];
    $senha = $_POST['txt_senha'];
    $sql = mysql_query("SELECT * FROM usuarios WHERE (nome_usuario = '$login' OR email = '$login') AND senha = '$senha'");
    if(mysql_num_rows($sql) > 0) {
        $usuario = mysql_fetch_assoc($sql);
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
        $id_usuario = $_SESSION['id_usuario'];
        if($id_usuario == 1) {
            header("Location: gerenciamento.php");
            exit;
        } else {
            header("Location: loja.php");
            exit;   
        }
    } else {
        $erro_login = true;
    }
}
?>

<html lang="pt-BR">
    <body class="pagina-login <?php echo !isset($_POST['txt_login']) ? 'animar' : ''; ?>">
        <div class="caixa-login">
            <h2 class="titulo">Fazer Login</h2>
            <form class="formulario-login" action="" method="POST">
                <div class="container-input">
                    <img src="../imagens/knight1.png" class="sticker">
                    <div class="grupo-input">
                        <label>Nome de Usuário ou Email</label>
                        <input type="text" name="txt_login" value="<?php echo $login; ?>" required>
                    </div>
                </div>
                <div class="container-input">
                    <img src="../imagens/knight2.png" class="sticker">
                    <div class="grupo-input">
                        <label>Senha</label>
                        <input type="password" name="txt_senha" required>
                    </div>
                </div>
                <div class="container-botoes-login">
                    <button type="submit" class="botao-basico">Fazer Login</button>
                    <a href="cadastro.php" class="link">Fazer Cadastro</a>
                </div>
            </form>
        </div>
        <div id="modal-erro-login" class="modal-overlay" <?php if($erro_login) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Atenção!</h3>
                <p>Usuário/E-mail ou senha incorretos!</p>
                <button class="botao-basico" onclick="fecharModalLog()">OK</button>
            </div>
        </div>
    </body>
</html>