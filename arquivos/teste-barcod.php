<?php
$barcod= "";
$libform= FALSE;
if(isset($_GET['codigo'])){
    $barcod= $_GET['codigo'];
    $libform= TRUE;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta name="viewport" content="width=device-width, user-scalable=1">
        <title>GETAR - Lendo Codigo de Barras</title>
    </head>
    <body>
        
        <p>Desmarcar: Recuperar mais informa&ccedil;&otilde;es ...</p>
        <p>Quando usar pela primeita vez marcar: Usar sempre ...<br>
        Se precisar retornar procure em: Configura&ccedil;&otilde;es -> Gerenciador de Aplicativos -> Todos</p>
        <form action="#" method="get">
            C&oacute;digo de barras
            (<a href="http://zxing.appspot.com/scan?ret=http://www.schw.com.br/getarschw/arquivos/teste.php?codigo={CODE}">Leitor</a>):
            <input type="text" name="cod" value="<?php echo $barcod; ?>" />
        </form>
    </body>
</html>
