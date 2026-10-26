<?php
echo '<title>Gerenciamento | Loja - Hollow Knight</title>';
echo '<link rel="stylesheet" href="../style.css">';
echo '<meta charset="UTF-8">';
echo '<script src="../script.js"></script>';
include '../conexao.php';
$sucesso = false;
if(isset($_POST['txt_nome'])) {
    $nome = $_POST['txt_nome'];
    $categoria = $_POST['txt_categoria'];
    $descricao = $_POST['txt_descricao'];
    $preco_com = str_replace(',', '.', $_POST['txt_preco_com']);
    $preco_ven = str_replace(',', '.', $_POST['txt_preco_ven']);   
    $quantidade = $_POST['txt_qnt'];
    $nome_imagem = $_FILES['img_prod']['name'];
    $arquivo_temporario = $_FILES['img_prod']['tmp_name'];
    $pasta_destino = "../imagens/" . basename($nome_imagem);
    if(move_uploaded_file($arquivo_temporario, $pasta_destino)) {
        $caminho_imagem = "../imagens/" . $nome_imagem;
        $sql = mysql_query("INSERT INTO produtos (nome_produto, categoria, descricao, preco_compra, preco_venda, qnt_estoque, imagem) 
                            VALUES ('$nome', '$categoria', '$descricao', '$preco_com', '$preco_ven', '$quantidade', '$caminho_imagem')");        
        if($sql) {
            $sucesso = true;
        }
    }
}
?>

<html lang="pt-BR">
    <body class="pagina-gerenciamento">
        <div class="caixa-novo-prod">
            <h2 class="titulo">Novo Produto</h2>
            <form class="formulario-novo-prod" action="" method="POST" enctype="multipart/form-data">
                <div class="grupo-linha">
                    <div class="grupo-input">
                        <label>Nome do Produto</label>
                        <input type="text" name="txt_nome" required>
                    </div>
                    <div class="grupo-input">
                        <label>Categoria</label>
                        <select name="txt_categoria">
                            <option>Action Figures</option>
                            <option>Roupas</option>
                            <option>Canecas</option>
                        </select>
                    </div>
                    <div class="grupo-input">
                        <label>Descrição</label>
                        <input type="text" name="txt_descricao" required>
                    </div>
                </div>
                <div class="grupo-linha">
                    <div class="grupo-input">
                        <label>Preço de Compra</label>
                        <input type="text" name="txt_preco_com" required>
                    </div>
                    <div class="grupo-input">
                        <label>Preço de Venda</label>
                        <input type="text" name="txt_preco_ven" required>
                    </div>
                    <div class="grupo-input">
                        <label>Quantidade no Estoque</label>
                        <input type="number" name="txt_qnt" required>
                    </div>
                </div>
                <div class="grupo-input">
                    <label>Imagem do Produto</label>
                    <input type="file" name="img_prod" required>
                </div>
                <div class="container-botoes-novo-produto">
                    <button type="submit" class="botao-basico">Cadastrar Produto</button>
                    <a href="login.php" class="link">Voltar Para Login</a>
                </div>
            </form>
        </div>
        <div id="modal-produto-cadastrado" class="modal-overlay" <?php if($sucesso) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Sucesso!</h3>
                <p>Produto Cadastrado com sucesso!</p>
                <button class="botao-basico" onclick="fecharModalProd()">OK</button>
            </div>
        </div>
    </body>
</html>