<?php
/*
 * Descricao: listagem personalizada de documentos
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data Criacao: 13/10/2016
 * Fonte: http://php.net/manual/en/function.readdir.php
 * Revisoes:
 * 
 */

include '../../config/trait_personal.php';
include '../../config/classe_config.php';
include '../../funcoes/trait_geral.php';
include '../../funcoes/classe_conex.php';

$conex = new Conex();
//ajustando variavel de backup
$novo_local = "../../" . $conex->get_localBackup();
$conex->set_localBackup($novo_local);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $conex->get_tituloPag(); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../../css/style.css" rel="stylesheet" type="text/css">
        <link href="../../css/tabela.css" rel="stylesheet" type="text/css">
        <link href="../../css/formulario.css" rel="stylesheet" type="text/css">
        <!--personalizacoes do cliente -->
        <link href="../../config/pstyle.css" rel="stylesheet" type="text/css">
        
        <link rel="icon" href="../../Mouse-SCHW.jpg" type="image/x-icon" />
        <link rel="shortcut icon" href="../../Mouse-SCHW.jpg" type="image/x-icon" />
    </head>

    <body>
        <div id="principal">
            <div id="cabecalho">
                <div id="logo">
                    <?php echo $conex->cabecalho("../../"); ?>
                </div>
                <div id="cablinks">
                    <span>GETAR Vers&atilde;o: 3.2.0</span> -&nbsp;
                    <span><?php echo $conex->get_resp(); ?></span>                    
                    &nbsp;- <a href="../../index.php?acao=logof">Sair</a>
                </div>
            </div>
            <div id="conteudo">
            <table style="width: 48%;">
                <caption>Entradas de Registro de Atividades e outros</caption>
                <thead>
                    <tr>
                        <th>Arquivos</th>
                        <th>Tamanho</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            if ($handle = opendir('.')) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && $entry != "index.php") {
                        ?>
                    <tr class="<?php echo $conex->corLinha(); ?>">
                        <th>
                            <img src="<?php echo $entry; ?>" style="width: 90px;" /><br/>
                            <?php
                            echo "<a href=\"".$entry."\" target=\"_blank\">".$entry."</a><br />\n";
                            ?>
                        </th>
                        <td class="txt"><?php echo filesize($entry); ?></td>
                        <td class="txt"><?php echo date('d/m/Y h:i',filectime($entry)); ?></td>
                    </tr>
                        <?php
                    }
                }
                closedir($handle);
            }
            ?>
            </tbody>
            </table>
        </div>
    </div>
</body>
</html>