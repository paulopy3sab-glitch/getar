<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: Switch para gerenciamento de lembretes e mensagens
 * 
 * 23/03/2025
 *     herdado de ./mensagens/switch.inc.php, abandonado por padranizacao de extrutura
 */

include './pagina/mensagens/trait_menscons.php';
include './pagina/mensagens/classe_lembr.php';
$lmb = new Lembr();
//Para recarregar apos logado
$lmb->set_resp($resp);
//Carregar atribuicoes
$lmb->carAtrib($resp);

if (isset($_POST['editarNova'])) {
    $lmb->set_codMens($_POST['codmens']);
    $lmb->set_tituMens($_POST['titulo']);
    $lmb->set_texto($_POST['texto']);
    # $lmb->set_remtMens($_POST['remt']);
    $lmb->set_remtEmail($_POST['remtemail']);
    $lmb->set_destMens($_POST['dest']);
    $lmb->set_destEmail($_POST['destemail']);
    $lmb->set_situMens('rascunho');
    $msg = $lmb->mensSalvar();
}

if (isset($_POST['postarNova'])) {
    $lmb->set_destMens($_POST['dest']);
    $lmb->set_texto(html_texto($_POST['texto']));
    $lmb->mensPostar();
}

//Ajustes de variaveis
if (isset($_GET['codmens'])) {
    $lmb->set_codMens($_GET['codmens']);
}
$pag = $_GET['pag'];
include './pagina/mensagens/includes/switch.inc.php';
# $complemento = $lmb->mensSwitch($pag);
echo $lmb->mensList($complemento, $pag, $pagList);
echo "<hr>";
# echo $lmb->mensOpcoes();
include './pagina/mensagens/includes/opcoes.inc.php';
?>