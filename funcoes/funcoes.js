/**
 * 
 * @author Paulo Regis
 * Descricao: apoio geral a todo o sitema GETAR
 * Data Criacao: por volta de 2008
 * Revisoes: pregis: 15/08/2016
 *           comentarios
 */

function exibe(str) {
    document.getElementById(foto_).style.width = "0px";
    str = "foto-" + valida.select_foto.value;
    document.getElementById(str).style.width = "100px";
    foto_ = str;
}

function emotion(img) {
    txt = document.getElementById("texto").value;
    document.getElementById("texto").value = txt + "<img src=" + img + ">";
}

function acaopopup(documento) {
    window.opener.location.href = documento;
    javascript:window.close();
}

function janela(url) {
    newwindow = window.open(url, 'name', 'height=200,width=400');
}

function janela_edit(url) {
    newwindow = window.open(url, 'name', 'height=300,width=400');
}

function oculta() {
    document.getElementById("botao").style.visibility = "hidden";
}

function aguarde() {
    document.getElementById("carregando").style.display = "block";
}

/**
 * Abre um poppup pequeno para uma acao
 * @param {type} url
 * @returns {undefined}
 */
function janelaPq(url) {
    newwindow = window.open(url, 'name', 'height=200,width=400');
}

/**
 * Retorna a data atual
 * @returns {undefined}
 */
function hoje(){
    
}

/**
 * Preenche campo com o horario local
 * @param {type} campo id do campo a ser trabalhado
 * @param {type} data valor ja contigo no campo
 * @returns {undefined}
 */
function agora(campo, data){
    now = new Date;
    var hora = now.getHours() + ":" + now.getMinutes();
    if(data === ''){// somente se o campo esta vazio
        document.getElementById(campo).value = hora;
    }
}

/**
 * Para registrar logoff na tabela getar_reglog
 * @returns {undefined}
 */
function logoff(){
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'funcoes/js_logoff.php');
    head.appendChild(eScript);
}

function atualDivFoto(cod, img) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'js_exclfoto.php?codft=' + cod + '&img=' + img);
    head.appendChild(eScript);
}

/**
 * Listagem rapida de cliente
 * @param {type} str
 * @returns {undefined}
 */
function atualDivNome(str){
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', './funcoes/js_cliente.php?str=' + str);
    head.appendChild(eScript);
}
