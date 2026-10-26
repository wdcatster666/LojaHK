<?php
echo '<title>Cadastro | Loja - Hollow Knight</title>';
echo '<link rel="stylesheet" href="../style.css">';
echo '<meta charset="UTF-8">';
echo '<script src="../script.js"></script>';
include '../conexao.php';
$erro_email = false;
$erro_usuario = false;
$erro_senha = false;
$sucesso = false;
$nome = "";
$email = "";
$senha = "";
$senha2 = "";

if(isset($_POST['txt_usuario'])) {
    $nome = $_POST['txt_usuario'];
    $email = $_POST['txt_email'];
    $senha = $_POST['txt_senha'];
    $senha2 = $_POST['txt_senha2'];
    $sql_email = mysql_query("SELECT * FROM usuarios WHERE email = '$email'");
    $sql_usuario = mysql_query("SELECT * FROM usuarios WHERE nome_usuario = '$nome'");
    if(mysql_num_rows($sql_email) > 0) {
        $erro_email = true;
    } else if(mysql_num_rows($sql_usuario) > 0) {
        $erro_usuario = true;      
    } else if($senha != $senha2) {
        $erro_senha = true;
    } else {
        $sql = mysql_query("INSERT INTO usuarios (nome_usuario, email, senha)
                            VALUES ('$nome', '$email', '$senha')");
        $sucesso = true;
    }
}
?>

<html lang="pt-BR">
    <body class="pagina-cadastro <?php echo !isset($_POST['txt_usuario']) ? 'animar' : ''; ?>">
        <div class="caixa-cadastro">
            <h2 class="titulo">Novo Usuário</h2>
            <form class="formulario-cadastro" action="" method="POST">
                <div class="container-input">
                    <div class="container-sticker">
                        <img src="../imagens/nail.png" class="sticker">
                    </div>
                    <div class="grupo-input">
                        <label>Nome de Usuário</label>
                        <input type="text" name="txt_usuario" minlength="3" maxlength="24" value="<?php echo $nome; ?>" required>
                    </div>
                </div>
                <div class="container-input">
                    <div class="container-sticker">
                        <img src="../imagens/spell1.png" class="sticker">
                    </div>
                    <div class="grupo-input">
                        <label>Email</label>
                        <input type="text" name="txt_email" value="<?php echo $email; ?>" required>
                    </div>
                </div>
                <div class="container-input">
                    <div class="container-sticker">
                        <img src="../imagens/spell2.png" class="sticker">
                    </div>
                    <div class="grupo-input">
                        <label>Senha</label>
                        <input type="password" name="txt_senha" minlength="8" maxlength="16" value="<?php echo $senha; ?>" required>
                    </div>
                </div>
                <div class="container-input">
                    <div class="container-sticker">
                        <img src="../imagens/spell3.png" class="sticker">
                    </div>
                    <div class="grupo-input">
                        <label>Confirmar Senha</label>
                        <input type="password" name="txt_senha2" minlength="8" maxlength="16" value="<?php echo $senha2; ?>" required>
                    </div>
                </div>
                <div class="container-botoes-cadastro">
                    <button type="submit" class="botao-basico">Cadastrar-Se</button>
                    <a href="login.php" class="link">Fazer Login</a>
                </div>
            </form>
        </div>
        <div id="modal-erro-email" class="modal-overlay" <?php if($erro_email) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Atenção!</h3>
                <p>E-mail inválido ou já cadastrado!</p>
                <button class="botao-basico" onclick="fecharModalCad()">OK</button>
            </div>
        </div>
        <div id="modal-erro-usuario" class="modal-overlay" <?php if($erro_usuario) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Atenção!</h3>
                <p>Esse nome de usuário já está em uso! Escolha outro nome.</p>
                <button class="botao-basico" onclick="fecharModalCad()">OK</button>
            </div>
        </div>
        <div id="modal-erro-senha" class="modal-overlay" <?php if($erro_senha) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Atenção!</h3>
                <p>As senhas não são iguais!</p>
                <button class="botao-basico" onclick="fecharModalCad()">OK</button>
            </div>
        </div>
        <div id="modal-cadastrado" class="modal-overlay" <?php if($sucesso) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Sucesso!</h3>
                <p>Cadastro realizado com sucesso!</p>
                <button class="botao-basico" onclick="irParaLogin()">OK</button>
            </div>
        </div>
    </body>
</html>