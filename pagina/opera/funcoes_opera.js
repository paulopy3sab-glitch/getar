/* 
 * Autor: Paulo Regis
 * Data Criacao: 13/12/2021
 * Descricao: apoio as atividades operacionais
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


