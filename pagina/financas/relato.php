<?php
session_start();

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 06/12/2016
 * Descricao: para impressao de recibos de pagamento
 * Revisoes:
 * 
 */
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
        <h1>Relatorio de Pagamentos</h1>
        <?php
        $dataIni = $_POST['anoini'] . "-" . $_POST['mesini'] . "-" . $_POST['diaini'];
        $dataFim = $_POST['anofim'] . "-" . $_POST['mesfim'] . "-" . $_POST['diafim'];
        echo $fnc->conscRelato($dataIni, $dataFim);
        ?>

        <table>
            <tr>
                <td>
                    <form action="#">
                        <input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
                    </form>
                </td>
                <td>
                    <form action="relatoemail.php" method="get">
                        <input type="hidden" name="dtini" value="<?php echo $dataIni; ?>" />
                        <input type="hidden" name="dtfim" value="<?php echo $dataFim; ?>" />
                        <input type="submit" name="email" value="Email">
                    </form>
                </td>
                <td>
                    <form action="#">
                        <input type="button" name="fechar" value="Fechar" onclick="window.close();">
                    </form>
                </td>
            </tr>
        </table>

    </body>
</html>
