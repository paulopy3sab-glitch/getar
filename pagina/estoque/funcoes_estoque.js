/**
 * Funcoes especificas para operacoes no cadastro estoque
 * Autor: Paulo Regis
 * 9/11/2015
 * 
 * Novas funcoes em 
 * 23/09/2020
 * atvDivForn, atvDivFabr, limpDivForn
 * 
 */
var a = false;

/**
 * 
 * @param {type} cod
 * @returns {undefined}
 */
function atualDivSubCateg(cod) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/estoque/js_subcateg.php?cod=' + cod);
    head.appendChild(eScript);
}

/**
 * 
 * @param {type} str
 * @returns {undefined}
 */
function atualDivDescr(str) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/estoque/js_descr.php?str=' + str);
    head.appendChild(eScript);
}

/**
 * 
 * @param {type} str
 * @returns {undefined}
 */
function atualDivDescrTec(str) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/estoque/js_descrtec.php?str=' + str);
    head.appendChild(eScript);
}

/*
 * Cadastro pratico de fabricantes
 * @param {type} str
 * @returns {undefined}
 */
function atualDivFabr(str) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/estoque/js_fabr.php?str=' + str);
    head.appendChild(eScript);
}

/*
 * Cadastro pratico de fornecedores
 * @param {type} str
 * @returns {undefined}
 */
function atualDivForn(str) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/estoque/js_forn.php?str=' + str);
    head.appendChild(eScript);
}

function atvDivForn() {
    document.getElementById('inpforn').disabled= false; 
    if(a){
        document.getElementById('formCadastro').submit();
        a= false;
    }
}

function atvDivFabr(){
    document.getElementById('inpfabr').disabled= false; 
    if(a){
        document.getElementById('formCadastro').submit();
        a= false;
    }
}

function limpDivForn() {
    document.getElementById('divForn').innerHTML='';
    // document.getElementById('divForn').innerHTML = a;  
}

function blqForn(){
    //
    document.getElementById('divForn').innerHTML='';
    document.getElementById('divFabr').innerHTML='';
    
    //
    document.getElementById('inpforn').disabled= true; 
    document.getElementById('inpfabr').disabled= true; 
    a = true;
}
/**
 * 
 * @param {type} cod
 * @returns {undefined}
 */
function atualDivLocal(cod) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    eScript.setAttribute('src', 'pagina/estoque/js_local.php?loc=' + cod);
    head.appendChild(eScript);
}

function gravaObs(cod, codob) {
    var head = document.getElementsByTagName('head').item(0);
    var eScript = document.createElement('script');
    
    d = document.formCadObs;
    var txtObs = d.texto.value;
    eScript.setAttribute('src', 'pagina/estoque/js_gravaobs.php?cod=' + cod + '&codob=' + codob + '&txt=' + txtObs);
    head.appendChild(eScript);
}

/**
 * 
 * @returns {Boolean}
 */
function validaForm(){ 
    d = document.formCadastro;
    //validar nome
    if (d.descr.value === ""){
        alert("O campo descricao deve ser preenchido!");
        d.hora_fim.focus();
        return false;
    }

    return true;
}