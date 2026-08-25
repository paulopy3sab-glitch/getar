<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 20/04/2023
 * Descricao: Gerenciamento de contas a pagar e receber
 */

include './pagina/financas/trait_financacons.php';
include './pagina/financas/classe_financa.php';
include './config/classe_pfinanca.php';
$fnc = new Pfinanca;
//Para recarregar apos logado
$fnc->set_resp($resp);
//Carregar atribuicoes
$fnc->carAtrib($resp);

//Ajustes de variaveis
if (isset($_GET['codcarne'])) {
    $fnc->set_codCarne($_GET['codcarne']);
}
if (isset($_GET['codpar'])) {
    $fnc->set_codParc($_GET['codpar']);
}
if (isset($_GET['mes'])) {
    $fnc->set_mesPesq($_GET['mes']);
}
if (isset($_GET['tipo'])) {
    $fnc->set_tipoCarne($_GET['tipo']);
}
if (isset($_POST['anoini'])) {
    $dataIni = $_POST['anoini'] . "-" . $_POST['mesini'] . "-" . $_POST['diaini'];
    $fnc->set_dataIni($dataIni);
    $dataFim = $_POST['anofim'] . "-" . $_POST['mesfim'] . "-" . $_POST['diafim'];
    $fnc->set_dataFim($dataFim);
}

//salvar um carne novo
if (isset($_POST["salvarCarne"])) {// Vai gerar parcelamentos automaticamente
    $fnc->set_codCarne($_POST['codcarne']);
    $fnc->set_codCtCo($_POST['codctco']);
    $fnc->set_codClasf($_POST['codclasf']);
    $fnc->set_objeto($_POST['objeto']);
    $fnc->set_obsCarne($_POST['obs']);
    $fnc->set_codCad($_POST['codcad']);
    $fnc->set_valorTot($_POST['valortot']);
    $fnc->set_numParc($_POST['numparc']);
    if (isset($_POST['juros'])) {
        $fnc->set_jurosParc($_POST['juros']);
    }
    $fnc->carneSalvar($_POST['contra']);
}

//Gravando edicao de um carne
if (isset($_POST['editarCarne'])) {
    $fnc->set_codCarne($_POST['codcarne']);
    $fnc->set_codCtCo($_POST['codctco']);
    $fnc->set_codClasf($_POST['codclasf']);
    $fnc->set_obsCarne($_POST['obs']);
    $fnc->set_situCarne($_POST['situcarne']);
    if ($fnc->contraTst($_POST['contra'])) {
        $fnc->carneAtual();
    } else {
        $msg = "<b style=\"color: red;\">Contra Senha Invalida</b>";
        $fnc->set_msg($msg);
    }
}
//Pagando ou editando uma parcela
if (isset($_POST['editparc'])) {
    # atualizando o cabecalho da conta pagar/receber
    if (isset($_POST['codcarne'])) {
        $fnc->set_codCtCo($_POST['codctco']);
        $fnc->set_codClasf($_POST['codclasf']);
        $fnc->set_codCarne($_POST['codcarne']);
        $fnc->contaSlEdit();
    }  else {
        $fnc->set_codCtCo($_POST['codctco']);
    }

    $fnc->set_situParc($_POST['situpar']);
    $fnc->set_tipoCarne($_POST['tipo']);

    $diaVnc = $_POST['diavnc'];
    $mesVnc = $_POST['mesvnc'];
    $anoVnc = $_POST['anovnc'];
    $dataVncParc = $anoVnc . "-" . $mesVnc . "-" . $diaVnc;
    $fnc->set_dataVncParc($dataVncParc);

    $obs = $_POST['obs'];
    $obsAnt = $_POST['obsant'];
    //Preparar a documentacao para a observacao
    $observacao = $_SESSION['resp'] . " (" . date('d/m/y') . "): " . $obs . "\n" . $obsAnt;
    $fnc->set_obsParc($observacao);

    $fnc->set_valorParc($_POST['valorpar']);
    if ($fnc->contraTst($_POST['contra'])) {
        if ($_POST['situpar'] == "paga") {
            $fnc->parcelaSlPagar();
        } else {
            $fnc->parcelaSlEdit();
        }
    } else {
        $msg = "<b style=\"color: red;\">Contra Senha Invalida</b>";
        $fnc->set_msg($msg);
    }
}

echo "<div class=\"titulo\">Contas Pagar e Receber</div>";
switch ($pag) {
    case "listvenc":
        //Ajustes de variaveis
        if (isset($_GET['codcarne'])) {
            $fnc->set_codCarne($_GET['codcarne']);
        }
        if (isset($_GET['codpar'])) {
            $fnc->set_codParc($_GET['codpar']);
        }
        if (isset($_GET['mes'])) {
            $fnc->set_mesPesq($_GET['mes']);
        }
        if (isset($_GET['tipo'])) {
            $fnc->set_tipoCarne($_GET['tipo']);
        }
        if (isset($_POST['anoini'])) {
            $dataIni = $_POST['anoini'] . "-" . $_POST['mesini'] . "-" . $_POST['diaini'];
            $fnc->set_dataIni($dataIni);
            $dataFim = $_POST['anofim'] . "-" . $_POST['mesfim'] . "-" . $_POST['diafim'];
            $fnc->set_dataFim($dataFim);
        }

        $complemento = " AND pr.situacao = 'aberta'
                         AND pr.datavnc < CURDATE()";
        break;
    case 'carnenv':// Para criar um carne novo
        //echo $fnc->carneNovo($fnc->get_tipoCarne());
        $dados = $fnc->carneNovo();
        # echo $fnc->carneEdit();
        if ($fnc->get_erro()) {
            echo "<table width=\"100%\">
                    <tr>
                        <td height=\"420\" align=\"middle\">
                            <b style=\"color: red\">Nenhum registro para o codigo " . $fnc->get_codCarne() . "</b>
                        </td>
                    </tr>
                  </table>";
        } else {
            include './pagina/financas/includes/carne_novo.inc.php';
        }
        $complemento = " AND cn.cod=  " . $fnc->get_codCarne();
        break;
    case 'edit':
        $dados = $fnc->carneEdit();
        include './pagina/financas/includes/carne_edit.inc.php';
        $complemento = " AND cn.cod= " . $fnc->get_codCarne();
        break;
    case 'editpar':
        $dados = $fnc->parcelaEdit($fnc->get_codParc());
        include './pagina/financas/includes/fatura_edit.inc.php';
        $complemento = " AND pr.cod = " . $fnc->get_codParc();
        break;
    case 'detalpar':
        echo $fnc->parcelaDetal($fnc->get_codParc());
        $complemento = " AND pr.cod = " . $fnc->get_codParc();
        break;
    case 'pagar':
        $dados= $fnc->parcelaPagar($fnc->get_codParc());
        include './pagina/financas/includes/fatura_pagar.inc.php';
        $complemento = " AND pr.cod = " . $fnc->get_codParc();
        break;
    case 'rlper': // relatorio por periodo
        echo $fnc->parcelaRlPer();
        break;
    case 'rlpag': // relatorio de parcelas pagas
        echo $fnc->parcelaRlPag();
        break;
    case 'listabt':
        $complemento = " AND pr.situacao NOT IN('paga', 'cancelada') ";
        break;
    case 'listmes':
        $complemento = " AND pr.situacao NOT IN ('paga', 'cancelada')
                         AND MONTH(pr.datavnc) = '" . $fnc->get_mesPesq() . "'
                         AND YEAR(pr.datavnc) = YEAR(CURDATE())";
        break;
    case 'list':
        $complemento = "";
        break;
    case 'listper':
        $complemento = " AND pr.situacao NOT IN ('cancelada')
                         AND pr.datavnc BETWEEN '" . $fnc->get_dataIni() . "'
                         AND '" . $fnc->get_dataFim() . "'";
        break;
    case 'listcom':
        $complemento = " AND pr.situacao = 'comprev'";
        break;
    case 'listsem':
        $complemento = " AND pr.situacao = 'semprev'";
        break;
    case 'listpend':
        $complemento = " AND pr.situacao = 'pend'";
        break;
    case 'listhoje':
        $complemento = " AND pr.situacao NOT IN ('cancelada')
                         AND pr.datavnc = CURDATE()";
        break;
    default:
        $complemento = " AND pr.situacao NOT IN ('cancelada')
                         AND pr.datavnc = CURDATE()";
}
echo "<hr>";
$resultado = $fnc->carneList($complemento);
include './pagina/financas/includes/fatura_lista.inc.php';
echo "<hr>";
include './pagina/financas/includes/fatura_opcoes.inc.php';
