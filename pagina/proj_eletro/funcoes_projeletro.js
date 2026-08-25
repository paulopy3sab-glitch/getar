/* 
 * Autor: Paulo Regis
 * Data Criacao: 20/07/2016
 * Descricao: apoio aos projetos de programacao
 * Revisoes:
 */
function validaFormTarf() {
    d = document.formTarefa;
    //validar nome
    if (d.hora_fim.value === "" && d.status.value === "c") {
        alert("O campo Hora Fim deve ser preenchido!");
        d.hora_fim.focus();
        return false;
    }
    return true;
}

function validaFormPed() {
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

