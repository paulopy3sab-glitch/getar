<?php
session_start();

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: indeterminada
 * Descricao: Para imprimir artigos
 * Revisoes:        
 */
//Para exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

global $dirChave;
global $dirPChave;
$dirChave = "./funcoes/"; // reconfigurado em conex.inc.php
$dirPChave = "./config/"; // reconfigurado em conex.inc.php

// arquvos de configuracao
include './config/conex.inc.php';
// apenas para continar trabalhando no modo extruturado
include './funcoes/funcoes.php';
include $dirChave . 'funcoes-geral.php';
include $dirChave . 'funcoes-conex.php';
?>
<html>
    <head>
        <title>GETAR - Verssao Impressao</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <img src="Mouse-SCHW.jpg" width="32" height="24" alt="Mouse-SCHW"/>
        <?php echo $TITULO_PAG; ?>
        <?php
        $codartg = $_GET['codartg'];
        $consulta = "SELECT modelo FROM getar_artgch WHERE cod=" . $codartg;
        $dados = consultaSQL($consulta);
        
        switch ($dados['modelo']) {
            case 'rv':
                $consulta = "SELECT titulo, imagem, intro, texto, fonte FROM getar_artg01 WHERE codartg=" . $codartg;
                $dados = consultaSQL($consulta);
                ?>
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2" id="titulo" class="titulo"><?php echo $dados['titulo']; ?></td>
                    </tr>
                    <tr>
                        <td id="imagem">
                            <?php
                            $imagen_ilu = $dados['imagem'];
                            if ($imagen_ilu <> "-") {
                                ?>
                                <img id="img" src="<?php echo $pastaDocs; ?>fotos/<?php echo $imagen_ilu ?>" style="width: 100px">
                                &nbsp;
                                <?php
                            }
                            ?>
                        </td>
                        <td valign="top" class="txt" id="intro">
                            <?php
                            echo $dados['intro'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="texto" class="txt">
                            <?php echo $dados['texto']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="fonte" class="autor">
                            <?php echo $dados['fonte']; ?>
                        </td>
                    </tr>
                </table>        
                <?php
                break;
            case 'ft':
                $consulta = "SELECT titulo, intro, amplia, rodape FROM getar_artg02 WHERE codartg=" . $codartg;
                $dados = consultaSQL($consulta);
                ?>
                <table width="100%" border="0">
                    <tr>
                        <td colspan="3" id="titulo" class="titulo">
                            <?php echo devolve_texto($dados['titulo']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" id="titulo" class="txt">
                            <?php echo devolve_texto($dados['intro']); ?>
                        </td>
                    </tr>
                    <tr>
                        <?php
                        $consulta = "SELECT imagem, descr FROM " . $tabArtgFtImg . " WHERE codartg='$codArtg'";
                        $resultado = mysqli_query($conexao, $consulta);
                        $num_img = 0;
                        $foto_linha = 0;
                        while ($fotoArtg = mysqli_fetch_array($resultado)) {
                            $foto = $fotoArtg['imagem'];
                            $descr = devolve_texto($fotoArtg['descr']);
                            ?>
                            <td align="center" valign="top">
                                <?php
                                //Imprimir ou nao foto
                                if ($foto <> "-") {
                                    if ($dados['amplia']) {//Ativar ou nao visu ampliacao
                                        echo "<a href=\"#\" onclick=\"janelaAmplia('" . $foto . "','" . $descr . "')\">";
                                    } else {
                                        echo "<a href=\"#\">";
                                    }
                                    ?>
                                    <img id="<?php echo "foto" . $num_img ?>" src="fotos/<?php echo $foto ?>" border="0" style="height: 120px;"></a><br>
                                    <?php
                                }
                                else { //Para nao ocorrer erro na hora de dimencionar uma foto vazia
                                    ?>
                                    <img id="<?php echo "foto" . $num_img ?>" src="fotos/moldura.jpg" border="0">
                                    <?php
                                }
                                ?>
                                <span class="chamada">
                                    <?php
                                    echo $descr;
                                    ?>
                                </span>
                                <?php
                                $foto_linha++;
                                if ($foto_linha == 3) {
                                    echo "</td><tr>"; //Quebra linha na 3 celula
                                    $foto_linha = 0;
                                } else {
                                    echo "</td>"; //Fecha somente a celula
                                }
                                $num_img++;
                            }
                            ?>
                    </tr>
                    <tr>
                        <td colspan="3" id="fonte" class="autor">
                            <?php echo $dados['rodape']; ?>
                        </td>
                    </tr>
                </table>
                <?php
                break;
            case 'fck':
                $consulta = "SELECT texto FROM getar_artg01 WHERE codartg=" . $codartg;
                $dados = consultaSQL($consulta);
                ?>
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2" id="texto" class="txt"><?php echo devolve_texto($dados['texto']); ?></td>
                    </tr>
                </table>
                <?php
                break;
        }
        ?>
    </body>
</html>
