<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 22/03/2025
 * Descricao: ... para Lembretes
 */
include './pagina/mensagens/trait_menscons.php';
include './pagina/mensagens/classe_lembr.php';
$lmb = new Lembr();
//Para recarregar apos logado
$lmb->set_resp($resp);
//Carregar atribuicoes
$lmb->carAtrib($resp);

//Ajustes de variaveis
if (isset($_GET['codlmb'])) {
    $lmb->set_codLmb($_GET['codlmb']);
}

if (isset($_POST['salvarLmb'])) {
    $lmb->set_codLmb($_POST['codlmb']);
    $lmb->set_tituLmb($_POST['titulo']);
    $lmb->set_textoLmb($_POST['texto']);
    $lmb->set_remtLmb($_POST['remt']);
    $lmb->set_destLmb($_POST['dest']);
    $lmb->set_situLmb($_POST['situacao']);
    $dataAgendada = $_POST['dataagd'];
    $lmb->set_dataAgd($dataAgendada);
    $msg = $lmb->lembreSalvar();
}

//preparar calendario
include $dirChave . 'classe_calendario.php';
$mes = date('m');
$ano = date('Y');
$cld = new Calendario(intval($mes), intval($ano));
$lmb->arrayLmb = $cld->arrayDia;
$lmb->lembreMes($mes, $ano);
$cld->arrayDia = $lmb->arrayLmb;

switch ($pag) {
    case "edit":
        $dados = $lmb->lembrEdit($lmb->get_codLmb());
        include './pagina/lembretes/includes/lembrete_edit.inc.php';
        break;
    case "nova":
        $dados = $lmb->lembrEdit($lmb->get_codLmb());
        include './pagina/lembretes/includes/lembrete_edit.inc.php';
        break;
    default :
        
}

# $complemento = $lmb->lembrSwitch($pag);
include './pagina/lembretes/includes/switch.inc.php';
echo $lmb->lembrList($complemento, $pag, $pagList);
$capt = "Calend&aacute;rio " . $lmb->mesExtBR($mes) . " de " . $ano;
echo $cld->exibe_calendario($capt);
echo "<hr>";
# echo $lmb->lembrOpcoes();
include './pagina/lembretes/includes/rodape.inc.php';
?>