<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: gerenciamento de C/C Contas Corrente
 */

include './pagina/financas/trait_financacons.php';
include './pagina/financas/classe_financa.php';
include './config/classe_pfinanca.php';
$fnc = new Pfinanca;
//Para recarregar apos logado
$fnc->set_resp($resp);
//Carregar atribuicoes
$fnc->carAtrib($resp);
/**
 * Pegar o nick da conta padrao
 */
if (!isset($_SESSION['codconta'])) {
    $_SESSION['codconta'] = $fnc->contaFixa(1);
} else {
    $fnc->contaFixa($_SESSION['codconta']);
}

if (isset($_POST['salvarlanca'])) {
    $fnc->set_codLanca($_POST['codlanca']);
    $fnc->set_descrLanca($_POST['descr']);
    $fnc->set_codClasf($_POST['codclasf']);
    $dataLanca = $_POST['datalanca'];
    //Validando a data de lancamento
    $consulta = "  SELECT COUNT(*) nm
                    FROM peratu 
                   WHERE '" . $dataLanca . "' BETWEEN dataini AND datafim
                         AND codctco = " . $fnc->get_codCtCo() . "
                         AND situacao = 'ativo'";
    $dadosPesq = consultaSQL($consulta);

    $fnc->set_dataLanca($dataLanca);
    $fnc->set_valorCred($_POST['cred']);
    $fnc->set_valorDeb($_POST['debt']);
    $fnc->set_situLanca($_POST['situacao']);
    $fnc->set_obsLanca($_POST['obs']);
    if ($dadosPesq['nm']) {
        $fnc->lancaSalvar();
    } else {
        $msg = "<b style=\"color: red\">Erro!! Fora do intervalo ativo</b>";
        $fnc->set_msg($msg);
    }
}

if (isset($_GET['codctco'])) {
    $codCtCo = $_GET['codctco'];
    $fnc->set_codCtCo($_GET['codctco']);
} else {
    $codCtCo = ""; // para nova conta corrente
}
if (isset($_POST['salvarCtNm'])) {
    $fnc->set_nomeConta($_POST['nome']);
    $fnc->set_descrConta($_POST['descr']);
    $fnc->set_moeda($_POST['moeda']);
    $fnc->set_situConta($_POST['situacao']);
    $fnc->contaSalvar();
}

if (isset($_GET['codctco'])) {
    $fnc->set_codCtCo($_GET['codctco']);
}
if (isset($_GET['codclasf'])) {
    $fnc->set_codClasf($_GET['codclasf']);
}
if (isset($_POST['salvarClasf'])) {
    $fnc->set_codClasf($_POST['codclasf']);
    $fnc->set_nomeClasf($_POST['nome']);
    $fnc->set_descrClasf($_POST['descr']);
    $fnc->set_situClasf($_POST['situacao']);
    $fnc->clasfSalvar();
}

if (isset($_POST['salvarPeriodo'])) {
    $fnc->set_codPer($_POST['codPer']);
    $fnc->set_nomePer($_POST['nome']);
    $fnc->set_codCtCo($_POST['codCtCo']);
    $fnc->set_dataIniPer($_POST['dataini']);
    $fnc->set_dataFimPer($_POST['datafim']);
    $fnc->set_situPer($_POST['situ']);
    $fnc->periodoSalvar();
}

switch ($pag) {
    case "listcor":
        echo "<div class=\"titulo\">Conta Corrente Ativas</div>";
        #$complemento = $fnc->contaSwith($pag);
        $complemento = " AND nm.situacao NOT IN('temporario', 'inativo') 
                         AND per.situacao = 'ativo' ";
        echo $fnc->contaList($complemento);
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;
    case "listccnome":
        echo "<div class=\"titulo\">CONTA CORRENTE</div>";
        $resultado = retornoSQL($fnc->fnc_cons02());
        include './pagina/financas/includes/conta_lista.inc.php';
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;
    case "defcor":
        $_SESSION['codconta'] = $_GET['codctco'];
        $fnc->contaFixa($_SESSION['codconta']);
        echo "<b style=\"color: blue;\">Conta Corrente Difinida: " . $fnc->get_nomeConta() . "</b>";
        echo "<div class=\"titulo\">CONTA CORRENTE</div>";
        $complemento = $fnc->lancaSwitch($pag);
        echo $fnc->lancaList($complemento);
        include './pagina/financas/includes/lanca_opcoes.inc.php';
        break;
    case "editcor":
        echo $fnc->contaNomeEdit($codCtCo);
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;

    // Classificacoes
    case "listclasf":
        echo "<div class=\"titulo\">CONTA CORRENTE</div>";
        # $complemento = $fnc->clasfSwitch($pag);
        $complemento = " AND cl.situacao NOT IN('temporario') ";
        echo $fnc->plancoContas();
        include './pagina/financas/includes/plano_opcoes.inc.php';
        break;
    case "editclasf":
        echo $fnc->clasfEdit();
        include './pagina/financas/includes/plano_opcoes.inc.php';
        $complemento = " AND cl.cod = " . $fnc->get_codClasf();
        echo $fnc->plancoContas($complemento);
        break;

    // Periodos
    case "editper":
        $codPer = $_GET['cod'];
        if ($codPer == "") {
            # criar um temporario
            $codCtCo = $_GET['codctco'];
            $consulta = "INSERT INTO peratu (nome, codctco, dataini, datafim, situacao) 
                                    VALUES ('', " . $codCtCo . ", CURDATE(), CURDATE(), 'temporario')";
            $codPer = executaIdSQL($consulta);
        }
        $fnc->set_codPer($codPer);
        $dados = $fnc->periodoEdit();
        include './pagina/financas/includes/periodo_edit.inc.php';
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;
    case "listperativo":
        $complemento = " AND per.situacao= 'ativo'";
        echo $fnc->periodoList($complemento);
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;
    case "listperant":
        $complemento = " AND ctn.cod = " . $fnc->get_codCtCo();
        echo $fnc->periodoList($complemento);
        include './pagina/financas/includes/lanca_opcoes.inc.php';
        break;
    case "listperlanca":
        $complemento = $fnc->lancaSwitch($pag) . $_GET['cod'];
        echo $fnc->lancaList($complemento);
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;

    // Lancamentos
    case "editlanca":
        $fnc->set_codLanca($_GET['codlanca']);
        $dados = $fnc->lancaEdit();
        include './pagina/financas/includes/lanca_edit.inc.php';
        include './pagina/financas/includes/lanca_opcoes.inc.php';
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;
    case "listlanca":
        $complemento = $fnc->lancaSwitch($pag);
        echo $fnc->lancaList($complemento);
        include './pagina/financas/includes/lanca_opcoes.inc.php';
        include './pagina/financas/includes/conta_opcoes.inc.php';
        break;
    case "relato":
        # relatorios
        /*         * echo "<div>
          <fieldset>
          <legend>Relat&oacute;rios Pagamentos e Contas</legend>";
          echo "  </fieldset>
          </div>";* */

        include 'pagina/financas/conta_relato.inc.php';
        break;
}
