<?php
session_start();

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 06/12/2016
 * Descricao: para impressao de recibos de pagamento
 * Revisoes:
 * 
 */
//Para exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

/**
 * Controle do logon no sistema
 */
if (!isset($_SESSION['resp'])) {
    $_SESSION['resp'] = "visitante";
    $_SESSION['datalog'] = date("d/m/Y");
}
$resp = $_SESSION['resp'];

// trabalhando em POO
include '../../config/trait_personal.php';
include '../../config/classe_config.php';
include '../../funcoes/trait_geral.php';
include '../../funcoes/classe_conex.php';

include '../../pagina/financas/trait_financacons.php';
include '../../pagina/financas/classe_financa.php';
include '../../config/classe_pfinanca.php';
$fnc = new Pfinanca;
//Para recarregar apos logado
$fnc->set_resp($resp);
$fnc->set_localBackup("../../DocsGetar/Backup/");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $fnc->get_tituloPag(); ?></title>
    </head>
    <body>
        <?php
        $dados = $fnc->consParc($_GET['codpar']);
        include '../../funcoes/classe_extenso.php';
        $ext = new Monetary;
        ?>

        <table width="100%">
            <tr>
                <td>
                    <img src="../../config/logo-schw-rt-old_02.png" width="174" height="72" alt="logo-schw-rt-old_02"/>
                </td>
                <td>
                    <h1>RECIBO</h1>
                </td>
                <td>
                    N&order;.:
                    <?php echo $dados['carnenum'] . "-" . $dados['parnum']; ?>
                </td>
                <td>
                    <h1>R$ <?php echo $dados['valorpar']; ?></h1>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Recebemos de:<br />
                    <h3><b><?php echo $dados['nome']; ?></b></h3>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Endere&ccedil;o:<br  />
                    <h3><b><?php echo $dados['endr']; ?></b></h3>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    A import&acirc;ncia de:<br />
                    <h3><b><?php echo $ext->numberToExt($dados['valorpar']); ?></b></h3>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Referente a<br />
                    <?php echo $dados['obs']; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    SCHW Informatica ME<br />
                    Rua Raymundo Nonato de Castro, 748<br />
                    CNPJ: 94.384.476/0001-17
                </td>
                <td colspan="2" align="center">
                    <?php
                    if ($dados['diapag'] == "") {
                        $dia= date('d');
                        $mes= date('m');
                        $ano= date('Y');
                    } else {
                        $dia = $dados['diapag'];
                        $mes = $fnc->mesExtBR($dados['mespag']);
                        $ano = $dados['anopag'];
                    }
                    ?>
                    <p><?php echo $fnc->cidPadr; ?>, <?php echo $dia; ?> de <?php echo $mes; ?> de <?php echo $ano; ?>.</p>
                    <?php
                    if (isset($_GET['ass'])) {
                        echo "<img src = \"../../imagens/ass_" . $resp . ".png\" style = \"width: 240px;\" /><br />";
                    } else {
                        echo "<pre>_______________________________________</pre>";
                    }

                    $arrayResp = $fnc->nomeResp();
                    echo $arrayResp[1];
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
