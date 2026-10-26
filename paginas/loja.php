<?php
session_start();
echo '<title>Loja - Hollow Knight</title>';
echo '<link rel="stylesheet" href="../style.css">';
echo '<meta charset="UTF-8">';
echo '<script src="../script.js"></script>';
include '../conexao.php';
$sucesso = false;
if (isset($_POST['adicionar_carrinho'])) {
    $id_produto = $_POST['id_produto'];
    $id_usuario = $_SESSION['id_usuario'];
    $sql_carrinho = mysql_query("SELECT * FROM carrinhos WHERE id_usuario = '$id_usuario'");
    if (mysql_num_rows($sql_carrinho) > 0) {
        $carrinho = mysql_fetch_assoc($sql_carrinho);
        $id_carrinho = $carrinho['id_carrinho'];
    } else {
        mysql_query("INSERT INTO carrinhos (id_usuario, qnt_itens, total) VALUES ('$id_usuario', 0, 0.00)");
        $id_carrinho = mysql_insert_id();
    }
    $sql_prod = mysql_query("SELECT preco_venda FROM produtos WHERE id_produto = '$id_produto'");
    $prod_info = mysql_fetch_assoc($sql_prod);
    $preco_venda = $prod_info['preco_venda'];
    $sql_item = mysql_query("SELECT * FROM itens_carrinho WHERE id_carrinho = '$id_carrinho' AND id_produto = '$id_produto'");   
    if (mysql_num_rows($sql_item) > 0) {
        $item_atual = mysql_fetch_assoc($sql_item);
        $nova_qnt = $item_atual['qnt_produto'] + 1;
        $novo_subtotal = $nova_qnt * $preco_venda;       
        mysql_query("UPDATE itens_carrinho SET qnt_produto = '$nova_qnt', subtotal = '$novo_subtotal' WHERE id_carrinho = '$id_carrinho' AND id_produto = '$id_produto'");
    } else {
        $subtotal = $preco_venda * 1;
        mysql_query("INSERT INTO itens_carrinho (id_carrinho, id_produto, qnt_produto, subtotal) VALUES ('$id_carrinho', '$id_produto', 1, '$subtotal')");
    }
    $sql_totais = mysql_query("SELECT SUM(qnt_produto) as total_itens, SUM(subtotal) as valor_total FROM itens_carrinho WHERE id_carrinho = '$id_carrinho'");
    $totais = mysql_fetch_assoc($sql_totais);
    $total_itens = $totais['total_itens'];
    $valor_total = $totais['valor_total'];
    mysql_query("UPDATE carrinhos SET qnt_itens = '$total_itens', total = '$valor_total' WHERE id_carrinho = '$id_carrinho'");
    mysql_query("UPDATE produtos SET qnt_estoque = qnt_estoque - 1 WHERE id_produto = '$id_produto'");
    $_SESSION['id_carrinho'] = $id_carrinho;
    $sucesso = true;
}
?>

<html lang="pt-BR">
    <body>
        <div class="banner-topo">
            <img src="../imagens/logo.png" class="logo-banner">
            <img src="../imagens/carrinho.png" class="carrinho" onclick="verCarrinho()">
        </div>
        <div class="pagina-loja <?php echo !isset($_POST['adicionar_carrinho']) ? 'animar' : ''; ?>">
            <h2>Olá, <?php echo $_SESSION['nome_usuario'] ?>!</h2>
            <div class="grupo-categoria">
                <p>Action Figures</p>
                <div class="container-categoria">
                    <?php
                        $sql_action = mysql_query("SELECT * FROM produtos WHERE categoria = 'Action Figures'");
                        if(mysql_num_rows($sql_action) > 0) {
                            while($prod = mysql_fetch_assoc($sql_action)) {
                                echo '<div class="card-produto">';
                                echo '    <img src="' . $prod['imagem'] . '" class="img-produto">';
                                echo '    <div class="info-produto">';
                                echo '        <p>' . $prod['nome_produto'] . '</p>';
                                echo '        <p>R$' . $prod['preco_venda'] . '</p>';
                                echo '    </div>';
                                echo '    <button class="botao-basico" onclick="abrirModal(' . $prod['id_produto'] . ')">Ver Detalhes</button>';
                                echo '</div>';
                                echo '<div id="modal-produto-' . $prod['id_produto'] . '" class="modal-overlay" style="display: none;">';
                                echo '    <div class="modal-caixa">';
                                echo '        <form class="formulario-compra" method="POST" action="">';
                                echo '            <input type="hidden" name="id_produto" value="' . $prod['id_produto'] . '">';
                                echo '            <img class="img-modal" src="' . $prod['imagem'] . '">';
                                echo '            <h3 class="nome-modal">' . $prod['nome_produto'] . '</h3>';
                                echo '            <p class="descricao">' . $prod['descricao'] . '</p>';
                                echo '            <p class="preco-modal"><strong>Preço:</strong> R$' . $prod['preco_venda'] . '</p>';
                                echo '            <p class="estoque-modal"><strong>Quantidade no Estoque:</strong> ' . $prod['qnt_estoque'] . ' unidades</p>';
                                echo '            <button type="submit" name="adicionar_carrinho" class="botao-basico">Adicionar ao Carrinho</button>';
                                echo '        </form>';
                                echo '        <button class="botao-secundario" onclick="fecharModal(' . $prod['id_produto'] . ')">Fechar Detalhes</button>';
                                echo '    </div>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="grupo-categoria">
                <p>Roupas</p>
                <div class="container-categoria">
                    <?php
                        $sql_action = mysql_query("SELECT * FROM produtos WHERE categoria = 'Roupas'");
                        if(mysql_num_rows($sql_action) > 0) {
                            while($prod = mysql_fetch_assoc($sql_action)) {
                                echo '<div class="card-produto">';
                                echo '    <img src="' . $prod['imagem'] . '" class="img-produto">';
                                echo '    <div class="info-produto">';
                                echo '        <p>' . $prod['nome_produto'] . '</p>';
                                echo '        <p>R$' . $prod['preco_venda'] . '</p>';
                                echo '    </div>';
                                echo '    <button class="botao-basico" onclick="abrirModal(' . $prod['id_produto'] . ')">Ver Detalhes</button>';
                                echo '</div>';
                                echo '<div id="modal-produto-' . $prod['id_produto'] . '" class="modal-overlay" style="display: none;">';
                                echo '    <div class="modal-caixa">';
                                echo '        <form class="formulario-compra" method="POST" action="">';
                                echo '            <input type="hidden" name="id_produto" value="' . $prod['id_produto'] . '">';
                                echo '            <img class="img-modal" src="' . $prod['imagem'] . '">';
                                echo '            <h3 class="nome-modal">' . $prod['nome_produto'] . '</h3>';
                                echo '            <p class="descricao">' . $prod['descricao'] . '</p>';
                                echo '            <p class="preco-modal"><strong>Preço:</strong> R$' . $prod['preco_venda'] . '</p>';
                                echo '            <p class="estoque-modal"><strong>Quantidade no Estoque:</strong> ' . $prod['qnt_estoque'] . ' unidades</p>';
                                echo '            <button type="submit" name="adicionar_carrinho" class="botao-basico">Adicionar ao Carrinho</button>';
                                echo '        </form>';
                                echo '        <button class="botao-secundario" onclick="fecharModal(' . $prod['id_produto'] . ')">Fechar Detalhes</button>';                                
                                echo '    </div>';
                                echo '</div>';
                            }
                        }  
                    ?>
                </div>
            </div>
            <div class="grupo-categoria">
                <p>Canecas</p>
                <div class="container-categoria">
                    <?php
                        $sql_action = mysql_query("SELECT * FROM produtos WHERE categoria = 'Canecas'");
                        if(mysql_num_rows($sql_action) > 0) {
                            while($prod = mysql_fetch_assoc($sql_action)) {
                                echo '<div class="card-produto">';
                                echo '    <img src="' . $prod['imagem'] . '" class="img-produto">';
                                echo '    <div class="info-produto">';
                                echo '        <p>' . $prod['nome_produto'] . '</p>';
                                echo '        <p>R$' . $prod['preco_venda'] . '</p>';
                                echo '    </div>';
                                echo '    <button class="botao-basico" onclick="abrirModal(' . $prod['id_produto'] . ')">Ver Detalhes</button>';
                                echo '</div>';
                                echo '<div id="modal-produto-' . $prod['id_produto'] . '" class="modal-overlay" style="display: none;">';
                                echo '    <div class="modal-caixa">';
                                echo '        <form class="formulario-compra" method="POST" action="">';
                                echo '            <input type="hidden" name="id_produto" value="' . $prod['id_produto'] . '">';
                                echo '            <img class="img-modal" src="' . $prod['imagem'] . '">';
                                echo '            <h3 class="nome-modal">' . $prod['nome_produto'] . '</h3>';
                                echo '            <p class="descricao">' . $prod['descricao'] . '</p>';
                                echo '            <p class="preco-modal"><strong>Preço:</strong> R$' . $prod['preco_venda'] . '</p>';
                                echo '            <p class="estoque-modal"><strong>Quantidade no Estoque:</strong> ' . $prod['qnt_estoque'] . ' unidades</p>';
                                echo '            <button type="submit" name="adicionar_carrinho" class="botao-basico">Adicionar ao Carrinho</button>';
                                echo '        </form>';
                                echo '        <button class="botao-secundario" onclick="fecharModal(' . $prod['id_produto'] . ')">Fechar Detalhes</button>';
                                echo '    </div>';
                                echo '</div>';
                            }
                        }   
                    ?>
                </div>
            </div>
            <div id="modal-sucesso-carrinho" class="modal-overlay" <?php if($sucesso) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Sucesso!</h3>
                <p>Produto adicionado ao carrinho!</p>
                <button class="botao-basico" onclick="fecharModalScsCar()">OK</button>
            </div>
        </div>
        </div>
    </body>
</html>