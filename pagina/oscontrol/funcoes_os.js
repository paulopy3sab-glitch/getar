/* 
 * Funcoes especificas para operacoes no cadastro OSs e equipamentos
 * Autor: Paulo Regis
 * 9/01/2018
 */

function validaForm() {
    d = document.formulario;

    //validar responsavel
    if (d.resp.value === "") {
        alert("Selecione um responsavel pelo pedido!");
        d.resp.focus();
        return false;
    }

    //validar comentario
    tamObservacao = d.doc.value.length;
    if (!(tamObservacao >= 9)) {
        alert("Escreva um pouco mais!");
        d.doc.focus();
        return false;
    }

    // Se tudo certo
    return true;
}

/**
 * Exibir o fieldset da edicao do cliente proprietario
 * @returns {undefined}
 */
function exibeCliProp(){
    document.getElementById('clipprop').style.display= "block";
}

/**
 * Exibir o fieldset da programacao da fila da OS
 * @returns {undefined}
 */
function exibeFilaOS(){
    document.getElementById('filaos').style.display= "block";
}

/**
 * 
 * @returns {undefined}
 */
function exibeFilaAtual(){
    document.getElementById('filaatu').style.display= "block";
}
