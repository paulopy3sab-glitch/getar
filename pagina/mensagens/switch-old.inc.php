<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: Switch para gerenciamento de lembretes e mensagens
 */

include './pagina/mensagens/trait_menscons.php';
include './pagina/mensagens/classe_lembr.php';
$lmb = new Lembr();
//Para recarregar apos logado
$lmb->set_resp($resp);
//Carregar atribuicoes
$lmb->carAtrib($resp);

//Ajustes de variaveis
if (isset($_GET['codmens'])) {
    $lmb->set_codMens($_GET['codmens']);
}

if (isset($_POST['postarNova'])) {
    $lmb->set_destMens($_POST['dest']);
    $lmb->set_texto(html_texto($_POST['texto']));
    $lmb->mensPostar();
}

if (isset($_GET['codmens'])) {
    $lmb->set_codMens($_GET['codmens']);
}
$pag = $_GET['pag'];

if ($pag == 'inativa') {
    $lmb->mensInativa();
    $pag = $_GET['ulist'];
}

if ($pag == 'excl') {
    $lmb->mensExcl();
    $pag = "list_recb";
}
if ($pag == "nova") {
    echo $lmb->mensEdit();
}
if ($pag == "exib") {
    echo $lmb->mensExib($lmb->get_codMens());
}
$complemento = $lmb->mensSwitch($pag);
echo $lmb->mensList($complemento, $pag, $pagList);
echo "<hr>";
# echo $lmb->mensOpcoes();
include './pagina/mensagens/includes/rodape.inc.php';




