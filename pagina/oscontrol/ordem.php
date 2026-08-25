<?php

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data de criacao: Marco/2017
 * Descricao: Definicao das consultas para o vendas em MySQL
 * Revisoes:
 * 12/05/2025
 * Continuando os trabalhos para passar para POO
 */
$msgObs = "";
$msgFila = "";

//salvar uma OS
if (isset($_POST["acao"])) {
    $fila = 0;

    $codOS = $_POST['codos'];
    $OS->set_codOS($_POST['codos']);
    $retorno = $_POST['retorno'];
    $situ = $_POST['situ'];
    if (isset($_POST['fila'])) {
        $fila = $_POST['fila'];
        if ($fila == NULL) {
            $fila = 0;
        }
    }
    $codcli = $_POST['codcli'];
    $resp = $_POST['resp'];
    $codEqp = $_POST['codeqp'];
    $OS->set_codEqp($_POST['codeqp']);
    $situequip = $_POST['situequip'];

    # Verificando possivel erros
    if ($fila > 0) {
        $consulta = "SELECT COUNT(*) nm FROM ordem WHERE fila =" . $fila . " AND cod NOT IN(" . $codOS . ")";
        $dadosPesq = consultaSQL($consulta);
        if ($dadosPesq['nm'] > 1) {
            $msgFila = "Jah exita uma OS com esse numero de fila:" . $fila;
            $fila = 0;
        }
    }
    if ($situ != 'aberta') {
        $fila = 0;
    }

    if ($_POST['valcb'] <> "") {
        $valcb = $_POST['valcb'];
    } else {
        $valcb = 0;
    }
    $fatu = $_POST['fatu'];
    $recla = $_POST['recla'];
    $encr = $_POST['encr'];
    $serv = $_POST['serv'];

    $dataIni = $_POST['dataini'];
    if (isset($_POST['datafcd'])) {
        $data_fcd = "'" . $_POST['datafcd'] . "'";
    } else {
        if ($situ == "fechada") {
            $data_fcd = "CURDATE()";
        } else {
            $data_fcd = "'2001:01:01'";
        }
    }
    if (isset($_POST['saida'])) {
        $data_sd = "'" . $_POST['saida'] . "'";
    } else {
        $data_sd = "CURDATE()";
    }
    //$OS->osSalvar();
    $consulta = "UPDATE ordem SET resp='" . $resp . "',
                        situequip='" . $situequip . "',
                        codcli='" . $codcli . "',
                        inicio='" . $dataIni . "',";
    if (!$data_fcd == "") {
        $consulta.= "   datafcd=" . $data_fcd . ",";
    }
    if (!$data_sd == "") {
        $consulta.= "   saida=" . $data_sd . ",";
    }
    $consulta.= "       fatu = '" . $fatu . "',
                        valcb = " . $valcb . ",
                        recla='" . $recla . "',
                        encr='" . $encr . "',
                        serv='" . $serv . "',
                        fila= " . $fila . ",
                        retorno='" . $retorno . "',
                        situ='" . $situ . "'
                  WHERE cod= " . $codOS;
    $msg = executaSQL($consulta);

    //registrando log        
    $str = "OS Editada: " . $OS->get_codOS() . ".\n";
    $str .= "Codigo Eqp: " . $OS->get_codEqp() . ".\n";
    $OS->gravaLog($str);

    if ($_POST['texto'] <> "") {
        $texto = $_POST['texto'];
        $consulta = "SELECT codobs FROM ordem_obs WHERE codord =" . $codOS;
        $dadosPesq = consultaSQL($consulta);

        /* $resultado = mysqli_query($consulta, $conexao) or print mysqli_error();
          $dadosPesq = mysqli_fetch_assoc($resultado); */
        if (isset($dadosPesq['codobs'])) {
            $consulta = "UPDATE ordem_obs SET texto = '" . $texto . "' WHERE codobs=" . $dadosPesq['codobs'];
        } else {
            $consulta = "INSERT INTO ordem_obs (codord, texto) VALUES(" . $codOS . ", '" . $texto . "')";
        }
        $msgObs = executaSQL($consulta);
    }
}

//salvar uma tarefa
if (isset($_POST['enviarTarefa'])) {
    $codtarf = $_POST['codtarf'];
    # $OS->set_codTarf($_POST['codtarf']);
    $codOS = $_POST['codos'];
    $OS->set_codOS($_POST['codos']);
    $horaini = $_POST['horaini'];
    $horafim = $_POST['horafim'];
    if ($horafim == "") {
        $horafim = "00:00:00";
    }
    $descr = html_texto($_POST['descr']);
    $situ = $_POST['situ'];

    $consulta = "UPDATE ordem_tarf SET descr = '" . html_texto($descr) . "', horaini = '" . $horaini . "', horafim = '" . $horafim . "', situ = '" . $situ . "' WHERE cod=" . $codtarf;
    $msgTarefa = executaSQL($consulta);

    //registrando log        
    $str = "Tarf. Editada: " . $codtarf . ".\n";
    $str .= "OS: " . $OS->get_codOS() . ".\n";
    $OS->gravaLog($str);
}

// criar uma tarefa nova
if (isset($_GET['tarnv'])) {
    $codOS = $_GET['codos'];
    /* $consulta = "INSERT INTO ordem_tarf (codos, tecn, dataexec, horaini, horafim, descr, situ)
      VALUES(" . $codOS . ", '" . $_SESSION['resp'] . "', CURDATE(), (SELECT SUBTIME(NOW(), '0 " . $fusoHora . ":00:00')), '00:00', 'Descrição da tarefa técnica', 'andamento')"; */
    $consulta = "INSERT INTO ordem_tarf (codos, tecn, dataexec, horaini, horafim, descr, situ)
                     VALUES(" . $codOS . ", '" . $_SESSION['resp'] . "', CURDATE(), NOW(), '00:00', 'Descrição da tarefa técnica', 'andamento')";
    $msgTarefa = executaSQL($consulta);
}

//Reprogramar um grupo de OSs por data
if (isset($_POST['repro_os'])) {
    $diaatual = $_POST['diaAtual'];
    $mesatual = $_POST['mesAtual'];
    $anoatual = $_POST['anoAtual'];

    $dianovo = $_POST['diaNovo'];
    $mesnovo = $_POST['mesNovo'];
    $anonovo = $_POST['anoNovo'];

    $consulta = "UPDATE ordem SET inicio='" . $anonovo . "-" . $mesnovo . "-" . $dianovo . "' WHERE inicio='" . $anoatual . "-" . $mesatual . "-" . $diaatual . "' AND situ NOT IN('fechada', 'cancelada', 'espera')";
    $msg = executaSQL($consulta);
    $_GET['pag'] = "list";
}

//
if (isset($_GET['codos'])) {

    $codOS = $_GET['codos'];
    if ($codOS == "000") {
        /** esta sendo procurada uma tarefe someente
         * procurara OS desta tarefe
         * Ex.; em umas sucata registrou um retirada de um componente na TARF7095
         */
        $codtarf = $_GET['codtarf'];
        $codOS = $OS->pegaCodOS($codtarf);
    }
    $OS->set_codOS($codOS);
} else {# Pq o codigo da OS pode vir vazio???
    $codOS = "";
    $OS->set_codOS("");
}

//
if (isset($_GET['codeqp'])) {
    $codEqp = $_GET['codeqp'];
} else {
    $codEqp = "";
}
if (isset($_GET['codtarf'])) {
    $codTarf = $_GET['codtarf'];
} else {
    $codTarf = "";
}

if (isset($_GET['strpesq'])) {
    $strpesq = $_GET['strpesq'];
}

$pag = $_GET['pag'];
$complemento = "";
switch ($pag) {
    case 'edit':
        $dados = $OS->ordemEdit();
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com c&oacute;digo: </b><small>" . $codOS . "</small>";
        } else {
            if ($OS->atrib("11")) {
                include './pagina/oscontrol/includes/ordem_cad.inc.php';
            }
        }
        $complemento = " AND ord.cod= '" . $codOS . "'";
        break;
    case 'cad':
        $OS->set_codEqp($codEqp);
        $OS->set_respOS($_SESSION['resp']);
        $codOS = $OS->ordemNova();
        $dados = $OS->ordemEdit();
        include './pagina/oscontrol/includes/ordem_cad.inc.php';
        $complemento = " AND ord.cod= '" . $codOS . "'";
        break;
    case 'relato':
        include './pagina/oscontrol/includes/ordem_relato.inc.php';
        $complemento = " AND ord.cod = (SELECT cod FROM ordem ORDER BY cod DESC LIMIT 1) ";
        break;
    case 'list_rlt':
        $mesRelato = $_POST['mesRelato'];
        $anoRelato = $_POST['anoRelato'];
        $complemento = " AND ord.cod IN (SELECT DISTINCT codos FROM ordem_tarf WHERE DATE_FORMAT(dataexec, '%m/%Y') = '" . $mesRelato . "/" . $anoRelato . "')
                         AND ord.situ = ('fechada')";
        break;
    case 'detal':
        include ("ordem_detal.inc.php");
        $complemento = " AND ord.cod= '" . $codOS . "'";
        break;
    case 'list_npag':
        $complemento = " AND ord.situ = 'fechada'
                         AND ord.fatu = 'aberta'";
        break;
    case 'list_eqp':
        $complemento = " AND ord.codeqp = " . $codEqp;
        break;
    case 'list':
        $complemento = " AND ord.situ IN ('aberta', 'espera', 'programada')";
        break;
    case 'listprop':
        $complemento = " AND cad.nome LIKE '" . $strpesq . "%'";
        break;
    case 'listdd':
        $validado = TRUE;
        if ($_GET['dia']) {
            $dia = $_GET['dia'];
        } else {
            $validado = FALSE;
        }
        if ($_GET['mes']) {
            $mes = $_GET['mes'];
        } else {
            $validado = FALSE;
        }
        if ($_GET['ano']) {
            $ano = $_GET['ano'];
        } else {
            $validado = FALSE;
        }
        $complemento = " AND DATE_FORMAT(ord.inicio, '%d/%m/%Y') = '" . $dia . "/" . $mes . "/" . $ano . "'
                         AND ord.situ IN('aberta', 'programada') ";
        break;
    case 'list_all':
        $complemento = "";
        break;
    case 'list_prog':
        include './pagina/oscontrol/calenda.inc.php';
        $complemento = " AND ord.cod= (SELECT cod FROM ordem WHERE situ= 'aberta' ORDER BY cod DESC LIMIT 1)";
        break;
    case 'list_trab':
        include './pagina/oscontrol/ostrab.inc.php';
        $complemento = " AND ord.cod= (SELECT cod FROM ordem WHERE situ= 'aberta' ORDER BY cod DESC LIMIT 1)";
        break;
    default :
        $complemento = " AND ord.situ IN ('aberta', 'espera')";
        break;
}
$resultado = $OS->ordemList($complemento);

# configurando para listagem no smartphone se necessaio
if (!isset($mobile)) {
    $mobile = FALSE;
}
if ($mobile) {
    include './pagina/oscontrol/includes/m-lista.inc.php';
    include './pagina/oscontrol/includes/ordem_opcoes.inc.php';
} else {
    include './pagina/oscontrol/includes/ordem_lista.inc.php';
    include './pagina/oscontrol/includes/ordem_opcoes.inc.php';
}
?>