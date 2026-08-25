/**
 * Funcoes para apoio aos lembretes e mensagens
 * 
 */

/**
 * 
 * @returns {Boolean}
 */
function validaForm() {
    d = document.formLembr;
    // validar destinatario
    if (d.dest.value === ""){
        alert("Selecione um destinatario para esta tarefa");
        return false;
    }
    return true;
}

