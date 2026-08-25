<?php


$conexao = mysql_connect("localhost", "root", "sardo312");

mysql_select_db("schw_teste");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Teste em Curso</title>
    </head>
    <body>
<?php
$consulta = "SELECT cod,
                    descr,
                        CASE
                           WHEN und IN('pc', 'und') THEN ROUND(qtd, 0)
                           WHEN und IN('m', 'ml', 'Kg') THEN ROUND(qtd, 3)
                        END qtd,
                    und,
                    (SELECT etq FROM estlocal WHERE cod = est.local) etqlocal,
                    (SELECT descr FROM estcatg WHERE cod = est.catg) descrcatg,
                    (SELECT descr FROM estsubcatg WHERE cod = est.subcatg) descrsubcatg,
                    clasf,
                    situacao
               FROM estoque est
               WHERE situacao != 'temporario'
                ORDER BY cod DESC
                LIMIT 20";
$resultado = mysql_query($consulta, $conexao) or print mysql_error();
?>
        <table width="100%" border="1">
            <caption>lista de produtos</caption>
            <thead>
            <tr>
                <th>C&oacute;digo</td>
                <th>Descri&ccedil;&atilde;o</td>
                <th>Quantidade</td>
                <th>Local</td>
                <th>Categoria</td>
                <th>Clasifica&ccedil;&atilde;o</td>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($dados = mysql_fetch_array($resultado)) {
                
                $style = "";
                if ($dados["situacao"] == "inativo") {
                    $style = " style=\"text-decoration:line-through;\"";
                }
                ?>
                <tr>
                    <th>
                        <?php echo $dados["cod"];?>
                            <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["cod"] ?>">
                                <img src="../imagens/editar.gif" alt="" border="no">
                            </a>
                    </th>
                    <td>
                        <?php echo $dados["descr"]; ?>
                    </td>
                    <td>&nbsp;<?php echo $dados["qtd"] ?> <?php echo $dados["und"] ?></td>
                    <td>&nbsp;<?php echo $dados["etqlocal"] ?></td>
                    <td>&nbsp;<?php echo $dados["descrcatg"] ?> - <?php echo $dados["descrsubcatg"] ?></td>
                    <td>&nbsp;
                        <?php
                        if ($dados["clasf"] == "novo") {
                            echo "novo";
                        } elseif ($dados["clasf"] == "colec") {
                            echo "colecionavel";
                        } else {
                            echo "usado";
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </body>
</html>
