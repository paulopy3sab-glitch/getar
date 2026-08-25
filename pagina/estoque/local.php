<?php
if (isset($_POST["salvar"])) {
    $codLocal = $_POST['codlocal'];
    $etq = $_POST['etq'];
    $categ = $_POST['categ'];
    $quadra = $_POST['quadra'];
    $descr = $_POST['descr'];
    $situacao = $_POST['situacao'];

    $consulta = "UPDATE estlocal SET etq= '" . $etq . "', descr='" . $descr . "', categ=" . $categ . ", quadra=" . $quadra . ",  situacao='" . $situacao . "' WHERE cod=" . $codLocal;
    $msg = executaSQL($consulta);
}


if (isset($_GET['cod'])) {
    $codLocal = $_GET['cod'];
    $complemento = " AND loc.cod = " . $codLocal;
} else {
    $codLocal = "";
    $complemento = "";
}

$pag = $_GET['pag'];
switch ($pag) {
    case 'novo':
        echo localEdit("");
        break;
    case 'edit':
        echo localEdit($codLocal);
        break;
    default :
}
?>
<!-- 
** LISTAGEM
-->
<?php echo localList($complemento); ?>