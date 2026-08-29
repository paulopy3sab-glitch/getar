<?php
/*
 * @autor: Paulo Regis 
 * @date: 24/09/2021
 * @object: Auxiliar a listagem e aliviar o pesso do código fonte de
 * estoque.php
 */

$consulta = $est->estq_consLista01($complemento, $numest);
$pagina = 1;

/* if (!$blcPag) {
  if (isset($_GET['pagina'])) {
  $pagina = $_GET['pagina'];
  }
  $resultado = gerapaginacao($consulta, $pagina, "");
  } else {
  $resultado = retornoSQL($consulta);
  }
 */

$resultado = retornoSQL($consulta);
$msgList = "Listagem Geral.";
?>
<table width="100%">
    <caption>ESTOQUE - <?php echo $msgList; ?>.</caption>
    <thead>
        <tr>
            <th>C&oacute;digo</th>
            <th>Descri&ccedil;&atilde;o</th>
            <th>Quantidade</th>
            <th>Local</th>
            <th>Categoria</th>
            <th>Clasifica&ccedil;&atilde;o</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conta = 0;
        while ($dados = arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr class="<?php echo corLinha(); ?>" <?php echo $style; ?>>
                <th>
                    <?php
                    if ($dados["nossonum"] != "") {
                        echo $dados["nossonum"];
                    } else {
                        echo "GT" . $dados["cod"];
                    }
                    ?>
                </th>
                <td>
                    <?php
                    echo $dados["descr"];
                    if ($dados["fabr"] != "") {
                        echo "(" . $dados["fabr"] . ")";
                    } else {
                        echo "";
                    }
                    if ($dados["descrtec"] != "") {
                        echo " - " . $dados["descrtec"];
                    }
                    if (atrib("21")) {
                        ?>
                        <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["cod"] ?>">
                            <img src="imagens/editar.gif" alt="" border="no">
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="index.php?st=estoque&pag=detal&codestq=<?php echo $dados["cod"] ?>">
                            <img src="imagens/editar.gif" alt="" border="no">
                        </a>
                        <?php
                    }
                    ?>
                </td>
                <td>&nbsp;<?php echo $dados["qtd"] ?> <?php echo $dados["und"] ?></td>
                <td>&nbsp;<?php echo $dados["etqlocal"] ?></td>
                <td>&nbsp;<?php echo $dados["descrcatg"] ?> - <?php echo $dados["descrsubcatg"] ?></td>
                <td>&nbsp;
                    <?php
                    if ($dados["clasf"] == "ne") {
                        echo "N&atilde;o Estocavel";
                    } elseif ($dados["clasf"] == "colec") {
                        echo "colecionavel";
                    } else {
                        echo $dados["clasf"];
                    }
                    ?>
                </td>
            </tr>
            <?php
            $conta++;
        }
        ?>
    </tbody>
    <tr>
        <td colspan="5">
            <?php #echo geraindicespaginas($pagina, "index.php?st=estoque" . $comExtra . "&"); ?>
            &nbsp;
        </td>
    </tr>
</table>
<?php
echo prim20($conta);
?>