<?php
session_start();
echo '<title>Meu Carrinho | Loja - Hollow Knight</title>';
echo '<link rel="stylesheet" href="../style.css">';
echo '<meta charset="UTF-8">';
echo '<script src="../script.js"></script>';
include '../conexao.php';
$sucesso = false;
$id_usuario = $_SESSION['id_usuario'];
$sql_busca_carrinho = mysql_query("SELECT id_carrinho FROM carrinhos WHERE id_usuario = '$id_usuario'");
if (mysql_num_rows($sql_busca_carrinho) > 0) {
    $carrinho_info = mysql_fetch_assoc($sql_busca_carrinho);
    $id_carrinho = $carrinho_info['id_carrinho'];
    $_SESSION['id_carrinho'] = $id_carrinho;
} else {
    mysql_query("INSERT INTO carrinhos (id_usuario, qnt_itens, total) VALUES ('$id_usuario', 0, 0.00)");
    $id_carrinho = mysql_insert_id();
    $_SESSION['id_carrinho'] = $id_carrinho;
}
if(isset($_POST['remover_carrinho'])) {
    $id_produto = $_POST['id_produto'];
    $sql_qnt = mysql_query("SELECT qnt_produto FROM itens_carrinho WHERE id_carrinho = '$id_carrinho' AND id_produto = '$id_produto'");
    $qnt_info = mysql_fetch_assoc($sql_qnt);
    $qnt_removida = $qnt_info['qnt_produto'];
    mysql_query("DELETE FROM itens_carrinho WHERE id_carrinho = '$id_carrinho' AND id_produto = '$id_produto'");
    $sql_totais = mysql_query("SELECT SUM(qnt_produto) as total_itens, SUM(subtotal) as valor_total FROM itens_carrinho WHERE id_carrinho = '$id_carrinho'");
    $totais = mysql_fetch_assoc($sql_totais);
    $total_itens = ($totais['total_itens'] !== null) ? $totais['total_itens'] : 0;
    $valor_total = ($totais['valor_total'] !== null) ? $totais['valor_total'] : 0.00;
    mysql_query("UPDATE carrinhos SET qnt_itens = '$total_itens', total = '$valor_total' WHERE id_carrinho = '$id_carrinho'");
    mysql_query("UPDATE produtos SET qnt_estoque = qnt_estoque + '$qnt_removida' WHERE id_produto = '$id_produto'");
    $sucesso = true;
}
?>

<html lang="pt-BR">
    <body>
        <div class="banner-topo">
            <img src="../imagens/logo.png" class="logo-banner">
            <img src="../imagens/casinha.png" class="casa" onclick="verLoja()">
        </div>
        <div class="pagina-carrinho <?php echo !isset($_POST['remover_carrinho']) ? 'animar' : ''; ?>">
            <h2>Meu Carrinho</h2>
            <div class="container-carrinho">
                <?php
                    $sql_carrinho = mysql_query("SELECT * FROM itens_carrinho WHERE id_carrinho = '$id_carrinho'");
                    if(mysql_num_rows($sql_carrinho) > 0) {
                        echo '<div class="container-flex">';
                        while($prod = mysql_fetch_assoc($sql_carrinho)) {
                            $id_prod = $prod['id_produto'];
                            $sql_img_produto = mysql_query("SELECT imagem FROM produtos WHERE id_produto = '$id_prod'");
                            $img_info = mysql_fetch_assoc($sql_img_produto);
                            $caminho_imagem = $img_info['imagem'];
                            echo '<div class="card-produto">';
                            echo '    <form class="formulario-carrinho" method="POST" action="">';
                            echo '        <input type="hidden" name="id_produto" value="' . $prod['id_produto'] . '">';
                            echo '        <img src="' . $caminho_imagem . '" class="img-produto">';
                            echo '        <p><strong>Quantidade: </strong>' . $prod['qnt_produto'] . ' unidade(s)</p>';
                            echo '        <p><strong>Subtotal: </strong>R$' . $prod['subtotal'] . '</p>';
                            echo '        <button type="submit" name="remover_carrinho" class="botao-basico">Remover do Carrinho</button>';
                            echo '    </form>';
                            echo '</div>';
                        }
                        echo '</div>';
                        $sql_itens = mysql_query("SELECT * FROM carrinhos WHERE id_carrinho = '$id_carrinho'");
                        $itens_info = mysql_fetch_assoc($sql_itens);
                        $qnt_itens = $itens_info['qnt_itens'];
                        $preco_total = $itens_info['total'];
                        echo '<div class="carrinho-info">';
                        echo '    <p><strong>Quantidade de Itens: </strong>' . $qnt_itens . ' itens</p>';
                        echo '    <p><strong>Valor Total: </strong>R$' . $preco_total . '</p>';
                        echo '</div>';
                    } else {
                        echo '<p class="msg-carrinho">Nenhum item em seu carrinho!</p>';
                    } 
                ?>
            </div>
            <div id="modal-sucesso-remover" class="modal-overlay" <?php if($sucesso) { echo 'style="display: flex;"'; } ?>>
            <div class="modal-caixa">
                <h3>Sucesso!</h3>
                <p>Produto removido do seu carrinho.</p>
                <button class="botao-basico" onclick="fecharModalScsRem()">OK</button>
            </div>
        </div>
    </body>    
</html>