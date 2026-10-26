function fecharModalLog() {
    document.getElementById("modal-erro-login").style.display = "none";
}

function fecharModalCad() {
    document.getElementById("modal-erro-email").style.display = "none";
    document.getElementById("modal-erro-usuario").style.display = "none";
    document.getElementById("modal-erro-senha").style.display = "none";   
}

function irParaLogin() {
    window.location = "login.php";
}

function fecharModalProd() {
    document.getElementById("modal-produto-cadastrado").style.display = "none";
}

function verCarrinho() {
    window.location = "carrinho.php";
}

function abrirModal(id) {
    document.getElementById("modal-produto-" + id).style.display = "flex";
}

function fecharModal(id) {
    document.getElementById("modal-produto-" + id).style.display = "none";
}

function fecharModalScsCar() {
    document.getElementById("modal-sucesso-carrinho").style.display = "none";
}

function fecharModalScsRem() {
    document.getElementById("modal-sucesso-remover").style.display = "none";
}

function verLoja() {
    window.location = "loja.php";
}