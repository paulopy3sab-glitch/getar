<?php
include ('funcoes_estoque.php');

if (isset($_GET['codestq'])) {
    $codestq = $_GET['codestq'];
} else {
    $codestq = "";
}
if (isset($_GET['codcatg'])) {
    $codCatg = $_GET['codcatg'];
} else {
    $codCatg = "";
}
if (isset($_GET['codsubcatg'])) {
    $codSubCatg = $_GET['codsubcatg'];
} else {
    $codSubCatg = "";
}
if (isset($_GET['codped'])) {
    $codPed = $_GET['codped'];
} else {
    $codPed = "";
}
$pag = $_GET['pag'];
$blcList = FALSE; // Bloquear listagem
$complemento = " AND situacao != 'inativo' ";
$comExtra = "semIcom";
switch ($pag) {
    case 'detal':
        include ("estoque-detal.inc.php");
        $complemento .= "AND cod= '" . $codestq . "'";
        break;
    case 'list_u':
        $complemento .= " ORDER BY cod DESC";
        $comExtra = "&pag=list_u";
        break;
    case 'list_i':
        $complemento = " AND situacao = 'inativo'
                         ORDER BY cod DESC"; // repare que este eh o unico que mata o complemento padrao
        $comExtra = "&pag=list_i";
        break;
    case 'list_catg':
        $complemento .= " AND est.catg = " . $codCatg . "
                         ORDER BY est.descr";
        $comExtra = "&pag=list_catg&codcatg=" . $codCatg;
        break;
    case 'list_subcatg':
        $complemento .= " AND est.catg = " . $codCatg . "
                         AND est.subcatg = " . $codSubCatg . "
                         ORDER BY est.descr";
        $comExtra = "&pag=list_subcatg&codcatg=" . $codCatg . "&codsubcatg=" . $codSubCatg;
        break;
    case 'pesq':
        $complemento .= " AND descr LIKE '" . $_REQUEST['string'] . "%' ORDER BY descr";
        break;
    case 'list_ped':
        echo pedidosListaImpress($codPed);
        $blcList=TRUE;
        break;
    case 'list_pedTd':
        echo pedidoLPrev();
        $complemento .= " ORDER BY cod DESC LIMIT 1";
        break;
    case 'ped_detal':
        echo pedidoDetal($codPed);
        $complemento .= " ORDER BY cod DESC LIMIT 1";
        break;
    case 'list_compra':
        echo pedidosCompra();
        $complemento .= " ORDER BY cod DESC LIMIT 1";
        break;
}

if($blcList == FALSE){
echo "<div align=\"center\" class=\"titulo\">ESTOQUE - Listagem Geral.</div><br>";
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
               " . $complemento;
$resultado = mysqli_query($conexao, $consulta);
?>
<table width="100%">
    <tr>
        <td class='sub-titulo'>C&oacute;digo</td>
        <td class='sub-titulo'>Descri&ccedil;&atilde;o</td>
        <td class='sub-titulo'>Quantidade</td>
        <td class='sub-titulo'>Local</td>
        <td class='sub-titulo'>Categoria</td>
        <td class='sub-titulo'>Clasifica&ccedil;&atilde;o</td>
    </tr>
    <?php
    while ($dados = mysqli_fetch_array($resultado)) {
        $style = "";
        if ($dados["situacao"] == "inativo") {
            $style = " style=\"text-decoration:line-through;\"";
        }
        ?>
        <tr <?php echo $style; ?> class="<?php echo corLinha(); ?>" onmouseover="this.className = 'corLinhaAtiva'" onmouseout="this.className = '<?php echo corLinha(0); ?>'">
            <td>
                <?php
                if (atrib("3")) {
                    echo $dados["cod"];
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
</table>
<?php
}
?>
