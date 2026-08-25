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
//redifinir parametros
$fnc->pastaPHPMailer="../../".$fnc->pastaPHPMailer;
$fnc->set_localBackup("../../DocsGetar/Backup/");
//Para recarregar apos logado
$fnc->set_resp($resp);
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
        $dataIni = $_GET['dtini'];
        $dataFim = $_GET['dtfim'];
        $relato= $fnc->conscRelato($dataIni, $dataFim);
        echo $relato;
        ?>
        <?php
        require($fnc->pastaPHPMailer . "class.phpmailer.php");
        $mail2 = new PHPMailer();
        $mail2->IsSMTP(); // envia por SMTP
        $mail2->Host = $fnc->get_smtpServer(); // SMTP servers
        $mail2->SMTPAuth = $fnc->get_smtpAuth(); // Caso o servidor SMTP precise de autenticacao
        $mail2->Username = $fnc->get_smtpUser(); // SMTP username
        $mail2->Password = $fnc->get_smtpPassword(); // SMTP password
        $mail2->From = $fnc->get_smtpFrom(); // Nome de quem envia o email

        $cc_email = "";
        $arrayResp=$fnc->nomeResp();
        $mail2->From = $fnc->get_smtpFrom(); // Email de quem envia o email
        $mail2->FromName = $arrayResp[1]; // Nome de quem envia o email
        $mail2->AddAddress($fnc->get_dest_relato()); // Email e nome de quem receber
        $mail2->AddReplyTo($arrayResp[2], $arrayResp[1]); // E-mail de retorno
        if ($cc_email <> "") {
            $mail2->AddCC($cc_email);
        }

        $mail2->WordWrap = 50; // Definir quebra de linha
        //$mail2->IsHTML(false);

        $mail2->Subject = "Relatorio Parcela "; // Assunto
        $texto = "Ola!<br>" . $arrayResp[1] . " (" . $arrayResp[2] . ") enviou o seguinte relatorio<br>";
        $texto .= "<hr>" . $relato . "<hr>" . "Enviada: " . date('d/m/Y');
        $mail2->Body = $texto;
        $mail2->AltBody = $relato . "\n" . "Enviada: " . date('d/m/Y');

        if (!$mail2->Send()) { // Envia o email
            echo "A Mensagem nao foi enviada <br />";
            echo "Erro reportado: " . $mail2->ErrorInfo;
        } else {
            echo "<br>O relatorio foi enviado com sucesso.<br>";
        }
        
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
