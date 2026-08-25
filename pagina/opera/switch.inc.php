<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Dezembro/2021
 * Descricao: Switch para atividades operacionais
 */

include './pagina/opera/trait_operacons.php';
include './pagina/opera/classe_opera.php';
$opr = new Opera();
//Para recarregar apos logado
$opr->set_resp($resp);
//Carregar atribuicoes
$opr->carAtrib($resp);

if (isset($_GET['codopr'])) {
    $codopera = $_GET['codopr'];
}  else {
    $codopera = "";
}
switch ($setor) {
    case "opera":
        //Ajustes de variaveis
        if (isset($_GET['codopr'])) {
            $opr->set_codOpera($_GET['codopr']);
        }
        if (isset($_GET['tag'])) {
            $opr->set_tag($_GET['tag']);
        }
        if (isset($_POST['pesq'])) {
            $cad->set_pesq($_POST['pesq']);
        }
        echo "<div class=\"titulo\">PROJETOS EM ANDAMENTO</div>";
        if (isset($_POST["salvar"])) {
            $opr->set_codOpera($_POST['codopera']);
            $opr->set_tag($_POST['tag']);
            $opr->set_nomeOpera($_POST['nome']);
            $opr->set_respOpera($_POST['resp']);
            $opr->set_descr($_POST['descr']);
            $opr->set_situOpera($_POST['situacao']);
            $opr->operaSalvar();
        }

        $complemento = "";
        switch ($pag) {
            case 'edit':
                $complemento = " AND opera.tag = '" . $opr->get_tag() . "'
                                 AND opera.cod =" . $opr->get_codOpera();
                include './pagina/opera/includes/opera_edit.inc.php';
                $complemento = "";
                break;
            case 'detal':
                $complemento = " AND opera.tag = '" . $opr->get_tag() . "'
                                 AND opera.cod =" . $opr->get_codOpera();
                echo $opr->operaDetal();
                $complemento = "";
                echo "<hr>";
                break;
            case 'list':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 AND situacao IN('ativo', 'concluida') ";
                break;
            case 'list_all':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 AND situacao IN('ativo', 'concluida', 'cancelada') ";
                break;
            case 'list_adm':
                $complemento = " AND situacao IN('ativo', 'concluida', 'cancelada')";
                break;
            default :
                $complemento = " AND situacao NOT IN ('temporario')";
        }

        // echo $opr->operaLista($complemento, $opr->get_acao());
        include './pagina/opera/includes/opera_lista.inc.php';
        include './pagina/opera//includes/opera_opcoes.inc.php';
        break;
    case "tarfopera":
        if (isset($_GET['codTarefa'])) {
            $opr->set_codTarf($_GET['codTarefa']);
        }
        if (isset($_GET['codoper'])) {
            $opr->set_codOpera($_GET['codoper']);
            $opr->set_respOpera($_SESSION['resp']);
        }
        if (isset($_POST["salvartarf"])) {
            // fixar o responsavel da tarefa como o logado pois eh este que esta salvando
            $opr->set_respTarf($_SESSION['resp']);
            $opr->set_horaIni($_POST['horaini']);
            $opr->set_docTarf($_POST['doc']);
            $opr->set_statusTarf($_POST['situacao']);
            $opr->set_codTarf($_GET['codTarefa']);
            //Verificacoes
            if ($_POST['situacao'] == "concluido") {
                if ($_POST['horafim'] == "0:00" || $_POST['horafim'] == "") {
                    $opr->set_horaFim("CURTIME()");
                } else {
                    $horaFim = "'" . $_POST['horafim'] . "'";
                    $opr->set_horaFim($horaFim);
                }
            } else {
                if ($_POST['horafim'] == "") {
                    $opr->set_horaFim("'00:00'");
                } else {
                    $horaFim = "'" . $_POST['horafim'] . "'";
                    $opr->set_horaFim($horaFim);
                }
            }

            $opr->tarfSalvar();
        }
        echo $opr->tarfCab();
        $complemento = "";
        $str = "";
        $limit = FALSE;
        switch ($pag) {
            case 'edit':
                $str = $opr->tarfEdit();
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 # AND cod= " . $opr->get_codTarf();
                $limit = TRUE;
                break;
            case 'list':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 AND situacao IN('andamento', 'concluida') ";
                break;
            case 'list_all':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 AND situacao IN('andamento', 'concluida', 'cancelada') ";
                break;
            case 'list_adm':
                $complemento = " ";
                break;
        }
        echo $str;
        echo $opr->tarfLista($complemento, $limit);
        echo "<hr>";
        echo $opr->tarfOpcoes();
        break;
}
