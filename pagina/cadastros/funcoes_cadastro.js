function janela(url) {
    newwindow = window.open(url, 'name', 'height=320, width=640');
}

function validaForm() {
    d = document.formCadastro;
    //validar nome
    if (d.nome.value === "") {
        alert("O campo nome deve ser preenchido!");
        d.hora_fim.focus();
        return false;
    }
    /*
     if (d.email.value == "" && d.clasf.value != "g"){
     alert("O campo E-mail deve ser preenchido!");
     d.email.focus();
     return false;
     } else if (d.email.value != ""){
     //validar email(verificao de endereco eletronico)
     parte1 = d.email.value.indexOf("@");
     parte2 = d.email.value.indexOf(".");
     parte3 = d.email.value.length;
     if (!(parte1 >= 3 && parte2 >= 6 && parte3 >= 9)) {
     alert ("O campo E-mail deve ser conter um endereco eletronico!");
     d.email.focus();
     return false;
     }
     }
     */
    return true;
}

/**
 * Atualiza o select dos estados conforme o select do pais
 * @param {type} cod
 * @returns {undefined}
 */
function atualDivEstado(cod) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/cadastros/js_estado.php?cod=' + cod);
    head.appendChild(eScript);
}