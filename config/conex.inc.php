<?php
global  $dirChave;
$dirChave= "./funcoes/";
global  $dirPChave;
$dirPChave= "./config/";

global $cidPadr;
global $estPadr;
$cidPadr = "Sombrio";
$estPadr = "Santa Catarina";

// para as funcoes ainda trabalhando no modo extruturado
global $conexao;
//Conexao local
$conexao = mysqli_connect("localhost", "root", "sardo312", "getarteste");
# $conexao = mysqli_connect("localhost", "dbgetar", "m@te1128", "getarteste");
mysqli_set_charset($conexao, "utf8");
global $bdRaiz;
$bdRaiz = "";

// Definindo o numero do estoque
global $numest;
$numest = 1; # eletronica
# $numest = 2; # mecanica
global $nomeest;
$nomeest= "Eletronica";
# $nomeest= "Mecanica";
# parametro: definir se cadastra um produto esgotado num pedido
global $prodEsgotado;
$prodEsgotado= FALSE;

/**
 * Configuracao de cliente
 */
global $TITULO_PAG;
$TITULO_PAG = ".: SAB Telecom - GETAR :.";

/**
 * Configuracoes de backup e sincronismo
 */
global $gravaSQL;
//Para o banco quente: FALSE;
//para o banco de teste: TRUE
$gravaSQL = TRUE;

/* Artigo (vao continuar a serem configuravei pois se vai usar o mesmo modulo
 *  no site padrao PLUS
 */
global $tabArtgCh;
global $tabArtgRv;
global $tabArtgFt;
global $tabArtgFtImg;
global $tabArtgLn;
$tabArtgCh = "getar_artgch";
$tabArtgRv = "getar_artg01";
$tabArtgFt = "getar_artg02";
$tabArtgLn = "getar_linha";
$tabArtgFtImg = "getar_artgft";

/***
***Configuracao FTP
*/
global $loginFTP;
global $senhaFTP;
global $serverFTP;
global $diretorioFTP;
//Para Ycorm
$loginFTP = "schwcomb";
$senhaFTP = "salm37teca5";
$serverFTP = "188.93.231.39";
$diretorioFTP = "/public_html/getarschw/docs_getar/";

/*
 * Diretorios
 * Para os arquivos que trabalham sem o index.php recarregar no arquivo valores acertados
 */
global $localBackup;
global $pastaDocs;
global $pastaFCK;
//global $pastaShadowBox;
global $pastaPHPMailer;
// Local para backup em servidor local
$localBackup = "./DocsGetar/Backup/";// cuidar nos js_XXX.php
//  Pasta para copiar fotos dos artigos
//$pastaFotos= "fotos";
//Local para documentos, imagens e datasheet
# $pastaDocs= "./DocsGetar/";// cuidar nos js_XXX.php
$pastaDocs= "../SABTelecom/";// cuidar nos js_XXX.php
//Local FCKeditor
$pastaFCK= "../getarsab/fckeditor266/";
//Para o envio de e-mails
$pastaPHPMailer = "../phpmailer/";// cuidar nos js_XXX.php
//$pastaShadowBox = "../../shadowbox/";//Nao utilizavel

/**
 * Gerando nome automatico para o aquivo de gravacao de SQLs
 */
global $arqSincro;
$nmData= date('ymdh');
$arqSincro = "sincro".$nmData.".sql";

/**
 * Definando fuso horario para servidores com fuso horario diferente do usuario
 * Ex.: Eu operando no Brasil e o servidor ser da Yconr em Portugal
 */
global $fusoHora;
$fusoHora= "0";

//mensagens e lembretes
global $tabMensagens;
global $tabLembretes;
$tabMensagens = "getar_mens";
$tabLembretes = "getar_lembre";

// configurar servidor de e-mail
global $erroMail;
global $smtpServer;
global $smtpAuth;
global $smtpUser;
global $smtpPassword;
global $smtpFrom;
global $dest_email;

$erroMail = FALSE;
// Envio pelo servidor Ycorm
$smtpServer = "mail.schw.com.br"; // SMTP servers
$smtpAuth= FALSE;//Caso o servidor SMTP precise de autenticacao
$smtpUser = "contato"; // SMTP username
$smtpPassword = "salm37teca5"; // SMTP password
$smtpFrom = "contato@schw.com.br"; // Nome de quem envia o email
$dest_email = "webmaster@schw.com.br";// Destinatario de e-mail para avisos do gestor

?>