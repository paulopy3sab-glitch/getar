<?php

/*
 * Funcoes para conexao ao bando de dados MySQL
 * Usando forma atualizada mysqli_xxx;
 */

/**
 * Gravar SQL de INSERTE E UPDATE para posterior sincronismo em banco externo
 * @global type $conexao
 * @global type $gravaSQL
 * @global type $localBackup
 * @param type $consulta
 * @return string
 */
function executaSQL($consulta) {
    global $conexao, $msg;

    $resultado = mysqli_query($conexao, $consulta);
    if ($resultado) {
        $msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
    } else {
        $consulta = "# " . mysqli_error($conexao) . "\n " . $consulta;
        $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
        // enviar mensgem para all_admin
        $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
        mensAllAdmin($texto);
    }
    gravaSQL($consulta);

    return $msg;
}

/**
 * para insercao de registros novos retornando o id gerado
 * @global type $conexao
 * @param string $consulta
 * @return int id gerado
 */
function executaIdSQL($consulta) {
    global $conexao, $msg;

    $resultado = mysqli_query($conexao, $consulta);
    if ($resultado) {
        $msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
    } else {
        $consulta = "# " . mysqli_error($conexao) . "\n " . $consulta;
        $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
        // enviar mensgem para all_admin
        $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
        mensAllAdmin($texto);
    }
    gravaSQL($consulta);

    $cod = mysqli_insert_id($conexao);

    return $cod;
}

/**
 * Grava SQL em arquivos js_ onde muda o loca de gravacao e o CSS do retorno
 * @global type $conexao
 * @global type $gravaSQL
 * @global type $arqSincro
 * @global type $localBackup
 * @param string $consulta
 * @return string
 */
function executaJs_SQL($consulta) {
    global $conexao, $msg;

    $resultado = mysqli_query($conexao, $consulta);
    if ($resultado) {
        $msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
    } else {
        $consulta = "# " . mysqli_error($conexao) . "\n " . $consulta;
        $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
        // enviar mensgem para all_admin
        $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
        mensAllAdmin($texto);
    }
    gravaSQL($consulta);

    return $msg;
}

/**
 * Apenas grava a consulta SQL em arquivo
 * @global type $gravaSQL
 * @global type $localBackup
 * @param type $consulta
 */
function gravaSQL($consulta) {
    global $gravaSQL, $arqSincro, $localBackup;

    if ($gravaSQL) {// gravar a SQL num arquivo texto .SQL
        $fp = fopen($localBackup . $arqSincro, "a+");
        $gravaConsulta = "\n # " . $_SESSION['resp'] . " - " . date('d-m-Y H:i') . "[Modo Extruturado]\n" . $consulta . ";";
        $escreve = fwrite($fp, $gravaConsulta);
        fclose($fp);
    }
}

/**
 * Para simples consulta. Podendo se adaptar para outros bancos (Oracle, MariaDb)
 * @global type $conexao
 * @param string $consulta
 * @return array tipo $dados
 */
function consultaSQL($consulta) {
    global $conexao, $msg;

    $resultado = mysqli_query($conexao, $consulta);
    if ($resultado) {
        //$msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
    } else {
        $consulta = "# " . mysqli_error($conexao) . "\n " . $consulta;
        $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
        // enviar mensgem para all_admin
        $texto = "ERRO AO CONSULTAR DADOS!!\n" . $consulta;
        mensAllAdmin($texto);
    }
    gravaSQL($consulta);
    $dados = mysqli_fetch_array($resultado);

    return $dados;
}

/**
 * retorna para o array resultado da consulta
 * @global type $conexao
 * @param type $consulta
 * @return type
 */
function retornoSQL($consulta) {
    global $conexao;

    $resultado = mysqli_query($conexao, $consulta);
    if ($resultado) {
        //$msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
    } else {
        $consulta = "# " . mysqli_error($conexao) . "\n " . $consulta;
        $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
        // enviar mensgem para all_admin
        $texto = "ERRO AO PESQUISAR DADOS!!\n" . $consulta;
        mensAllAdmin($texto);
    }
    gravaSQL($consulta);

    return $resultado;
}

/**
 * retorna o numero de linhas do SELECT
 * @param type $resultado
 * @return type
 */
function rowsSQL($resultado) {

    $rows = mysqli_num_rows($resultado);

    return $rows;
}

/**
 * retorna array do SELECT
 * @param type $resultado
 * @return type
 */
function arraySQL($resultado) {

    $array = mysqli_fetch_array($resultado);

    return $array;
}

/**
 * Envia mensagem do erro para all_admin
 * @param type $texto
 */
function mensAllAdmin($texto) {
    global $conexao, $erroMail, $smtpFrom, $dest_email, $TITULO_PAG;

    // grava a mensagem no banco
    $texto = html_texto($texto);
    $consulta = "INSERT INTO getar_mens (dest, remt, data, titulo, texto, situ)
                                  VALUES('all_admin', '" . $_SESSION['resp'] . "', CURDATE(), 'Erro de Sistema', '" . $texto . "', 'enviada')";
    mysqli_query($conexao, $consulta);

    // envia email
    if ($erroMail) {
        $mail = conecMailer();

        $mail->From = $smtpFrom; // Email de quem envia o email
        $mail->FromName = "Contato SCHW"; // Nome de quem envia o email
        $mail->AddAddress($dest_email); // Email de quem recebe
        $mail->AddReplyTo($smtpFrom, "Contato SCHW"); // E-mail e nome para retorno

        $mail->WordWrap = 50; // Definir quebra de linha
        $mail->IsHTML(false);

        $mail->Subject = "Erro GETAR: " . $TITULO_PAG; // Assunto
        $texto = "Ola!<br><br>
          Foi enviada a seguinte mensagem na area administrativa do Getar:<br>
          Enviada: " . date('d/m/Y') . "<br>
              <pre>" . $texto . "</pre>";
        $mail->Body = $texto;
        $comentario = "";
        $mail->AltBody = $comentario . "\n" . "Enviada: " . date("d/m/Y");

        if (!$mail->Send()) { // Envia o email
            $msgMens = "<b style=\"color: red;\">A Mensagem nao foi enviada </b>
                Erro reportado: " . $mail->ErrorInfo . "<br>";
        } else {
            $msgMens = "<b>A mensagem foi enviada com sucesso.<br>
                Em breve retornaremos sua solicita&ccedil;&atilde;o/contato<br>";
        }
    }
}

/**
 * Estanciar classe PHPMailer
 * @global type $pastaPHPMailer
 * @global type $smtpServer
 * @global type $smtpAuth
 * @global type $smtpUser
 * @global type $smtpPassword
 * @return \PHPMailer
 */
function conecMailer() {
    global $pastaPHPMailer, $smtpServer, $smtpAuth, $smtpUser, $smtpPassword;
    require($pastaPHPMailer . "class.phpmailer.php");

    $mail = new PHPMailer();

    $mail->IsSMTP(); // evia por SMTP
    $mail->Host = $smtpServer; // SMTP servers
    $mail->SMTPAuth = $smtpAuth; // Caso o servidor SMTP precise de autenticacao
    $mail->Username = $smtpUser; // SMTP username
    $mail->Password = $smtpPassword; // SMTP password

    return $mail;
}

/**
 * Aviso que tem mais linhas a serem listadas
 * @param type $conta
 * @return string
 */
function prim20($conta) {
    $str = "";
    if ($conta > 19) {
        $str = "<b style=\"color: blue;\">Listando primeiras 20 linhas</b>";
    }
    return $str;
}

?>
