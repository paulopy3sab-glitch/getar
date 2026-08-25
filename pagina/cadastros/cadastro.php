<?php
/*
 *  * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: Para aliviar o codigo da index.php
 */


if (isset($_GET['codcad'])) {
    $cad->set_codCad($_GET['codcad']);
}

if (isset($_POST["salvarCad"])) {
    //Entrada de variaveis
    $cad->set_codCad($_POST['cod']);
    $cad->set_nome($_POST['nome']);
    //montagem da data nascimento
    $dia_nasc = $_POST['dia_nasc'];
    $mes_nasc = $_POST['mes_nasc'];
    $ano_nasc = $_POST['ano_nasc'];
    $dataNasc = $ano_nasc . "-" . $mes_nasc . "-" . $dia_nasc;
    $cad->set_dataNasc($dataNasc);
    //montagem de cliente desde
    $dia_desde = $_POST['dia_desde'];
    $mes_desde = $_POST['mes_desde'];
    $ano_desde = $_POST['ano_desde'];
    $dataDesde = $ano_desde . "-" . $mes_desde . "-" . $dia_desde;
    $cad->set_dataDesde($dataDesde);
    $cad->set_contato($_POST['cont']);
    $cad->set_emailCorp($_POST['emailcorp']);
    $cad->set_ie($_POST['ie']);
    $cad->set_cpcn($_POST['cpcn']);
    $cad->set_cnpj($_POST['cnpj']);
    $cad->set_endr($_POST['endr']);
    $cad->set_numero($_POST['numero']);
    $cad->set_complemento($_POST['complemento']);
    $cad->set_bairro($_POST['bairro']);
    $cad->set_cidade($_POST['cidade']);
    $cad->set_pais($_POST['pais']);
    $cad->set_estado($_POST['estado']);
    $cad->set_cep($_POST['cep']);
    $cad->set_clasf($_POST['clasf']);
    $cad->set_situCad($_POST['situacao']);
    $cad->cadSalvar();
}
if (isset($_POST['fonesalvar'])) {
    $cad->set_codTel($_POST['codfone']);
    $cad->set_numTel($_POST['numero']);
    $cad->set_descrTel($_POST['descr']);
    $cad->foneSalvar();
}
if (isset($_POST['emailsalvar'])) {
    $cad->set_codEml($_POST['codemail']);
    $cad->set_endrEml($_POST['endremail']);
    $cad->set_descrEml($_POST['descremail']);
    $cad->emailSalvar();
}
if (isset($_POST['sitesalvar'])) {
    $cad->set_codSite($_POST['codsite']);
    $cad->set_endrSite($_POST['endr']);
    $cad->set_descrSite($_POST['descr']);
    $cad->siteSalvar();
}
if (isset($_POST['salvaringr'])) {
    $cad->set_nick($_POST['nick']);
    $salvarIngr = TRUE;
    if ($_POST['novolog']) {
        if ($cad->ingressoVerificar()) {
            $cad->set_nick("");
            echo " <span class='titulo'>Dados do logon</span><br>";
            echo $cad->ingressoEdit();
            $pag = "listunc";
            $salvarIngr = FALSE;
        }
    }
    if ($salvarIngr) {
        echo $cad->ingressoSalvar($_POST['novolog'], $_POST['frase'], $_POST['frase2']);
    }
}
if (isset($_POST['salvarcontra'])) {//contra senha para financeiro
    $cad->set_nick($_POST['nick']);
    echo $cad->ingressoContra($_POST['contra'], $_POST['contra2']);
}

?>
<div class="titulo">CADASTRO 
    <?php
    if ($cad->atrib("2")) {
        echo "- CLIENTES ";
    }
    if ($cad->atrib("21")) {
        echo "- FORNECEDORES - FABRICANTES ";
    }
    if ($cad->atrib("31")) {
        echo "- T&Eacute;CNICOS ";
    }
    ?>
</div>
<?php
# somente para Vendas, ver linha 381 de index.php
/*if (isset($_GET['relato'])) {
    echo $cad->relatoIntro();
    echo $cad->relatoMenu();
    switch ($_GET['relato']) {
        case 'geral':
            echo $cad->relatoList();
            break;
        default :
            echo $cad->relatoResumo();
            break;
    }
}*/
# ****

if ($cad->atrib('2')) {
    //$complemento = "";
} else {
    $complemento = " AND clasf NOT IN('a') ";
}
//para pesquisas
if (isset($_POST['string'])) {
    $cad->set_pesq($_POST['string']);
}
# $complemento .= $cad->cadSwitch($pag);
include './pagina/cadastros/includes/switch.inc.php';
if ($pag == "listingr") {# listar ingressos no sistemas
    # passar para "atribuicoes
    $complemento = "";
    if (isset($_GET['nick'])) {
        $complemento = " AND nick='" . $_GET['nick'] . "' ";
    }
    echo $cad->ingressoList($complemento, $pag, $pagList);
} else {# se não listar os cadastrados
    $resultado = $cad->cadList($complemento, $pag, $pagList);
    include './pagina/cadastros/includes/cad_list.inc.php';
}
echo "<hr>";
echo $cad->cadOpcoes();
