function janela(url) {
    newwindow = window.open(url, 'name', 'height=320, width=640');
}

function valFormCarneNv() {
    d = document.formCarneNovo;
    //validar agente
    if (d.codcad.value === "0") {
        alert("Selecione um Credor/Pagador!");
        d.codcad.focus();
        return false;
    }
    
    //validar valor contratado
    if (d.valortot.value === "") {
        alert("O campo Valor contratado deve ser preenchido!");
        d.valortot.focus();
        return false;
    }
    
    //validar objeto
    if (d.objeto.value === "") {
        alert("O campo objeto deve ser preenchido!");
        d.objeto.focus();
        return false;
    }
    
    //validar numero de parcelas
    if (d.numparc.value === "") {
        alert("O campo Numero de Parcelas deve ser preenchido!");
        d.numparc.focus();
        return false;
    }
    
    //validar observacao 
    if (d.obs.value === "") {
        alert("Favor documentar esta movimentacao financeira!");
        d.obs.focus();
        return false;
    }
    
    //validar contra senha 
    if (d.contra.value === "") {
        alert("O campo Senha de Validacao deve ser preenchido!");
        d.contra.focus();
        return false;
    }
    
    return true;
}
