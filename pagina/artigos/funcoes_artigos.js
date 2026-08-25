/* 
 * autor: Paulo Regis
 * descricao: apoio javascript aos artigos
 * Criacao: 09/08/2016
 * Revisoes:
 */

function atualDivLinha(codLinha) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/artigos/js_linha.php?codLinha=' + codLinha);
    head.appendChild(eScript);
}

function janela(url) {
    newwindow = window.open(url, 'name', 'height=300,width=400');
}
