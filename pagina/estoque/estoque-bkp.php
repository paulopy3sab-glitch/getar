<?php
/**
 * 
 */
$pedidos = FALSE;
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
$pag = $_GET['pag'];
$blcPag = FALSE; // Bloquear paginacao
$complemento = " AND situacao != 'inativo' ";
$comExtra = "&pag=list";
// Dados principais do produto
$msg = "";
if (isset($_POST["salvarProd"])) {
    //Entrada de variaveis
    $est->set_codEst($_POST['cod']);
    $est->set_numEst($_POST['numest']);
    $est->set_nossoNum($_POST['nossonum']);
    $est->set_descr($_POST['descr']);
    $est->set_descrTec($_POST['descrtec']);
    $est->set_datasheet($_POST['datasheet']);
    $est->set_und($_POST['und']);
    $qtd = formatarValorMySQL($_POST['qtd']);
    $est->set_qtd($qtd);
    $peso = formatarValorMySQL($_POST['peso']);
    $est->set_peso($peso);
    $est->set_situ($_POST['situacao']);
    $est->set_foto($_POST['foto']);
    $qtdMin = formatarValorMySQL($_POST['qtdmin']);
    $est->set_qtdMin($qtdMin);
    $valorCusto = formatarValorMySQL($_POST['valorcusto']);
    $est->set_valorCusto($valorCusto);
    $valorVenda = formatarValorMySQL($_POST['valorvenda']);
    $est->set_valorVenda($valorVenda);
    $est->set_moeda($_POST['moeda']);
    $est->set_codClasf($_POST['clasf']);
    $est->set_codLocal($_POST['local']);
    $est->set_codCatg($_POST['catg']);
    $est->set_codSubCatg($_POST['subcatg']);
    $est->estSalvar();
    $msg = $est->msgEst;

    # gravar ou editar uma observacao para o produto
    if (isset($_POST['texto'])) {
        $texto = $_POST['texto'];
        $consulta = "SELECT cod, texto FROM estobs WHERE codestq =" . $est->get_codEst();
        $dados = consultaSQL($consulta);

        if ($dados['cod'] <> "") {
            $consulta = "UPDATE estobs SET texto = '" . $texto . "' WHERE cod=" . $dados['cod'];
        } else {
            $consulta = "INSERT INTO estobs (codestq, texto) VALUES(" . $est->get_codEst() . ", '" . $texto . "')";
        }

        # apagando uma observacao
        if ($texto == ".") {
            $consulta = "DELETE FROM estobs WHERE cod=" . $dados['cod'];
        }
        $msgObs = executaSQL($consulta);
    }
    //registrando log        
    $str = "Produto Editado: " . $est->get_descr() . ".\n";
    $str .= "Codigo GETAR " . $est->get_codEst() . ".\n";
    $est->gravaLog($str);
}

switch ($pag) {
    case 'slvfabr':
        $codfabr = $_GET['codfabr'];
        $codestq = $_GET['codestq'];
        $consulta = "UPDATE estoque
                    SET fabr= '" . $codfabr . "'
                    WHERE cod=" . $codestq;
        $msg = executaSQL($consulta);
        include './pagina/estoque/includes/estoque-cad.inc.php';
        $complemento .= "AND cod= '" . $codestq . "'";
        break;
    case 'slvforn':
        $codforn = $_GET['codforn'];
        $codestq = $_GET['codestq'];
        $consulta = "INSERT INTO fornecedor (codestq, codforn) VALUES(" . $codestq . ", " . $codforn . ")";
        $msgForn = executaSQL($consulta);
        include './pagina/estoque/includes/estoque-cad.inc.php';
        $complemento .= "AND cod= '" . $codestq . "'";
        break;
    case 'excforn':
        $codforn = $_GET['codforn'];
        $codestq = $_GET['codestq'];
        $consulta = "DELETE FROM fornecedor WHERE codestq= " . $codestq . " AND codforn = " . $codforn . " LIMIT 1";
        $resultado = executaSQL($consulta);
        include './pagina/estoque/includes/estoque-cad.inc.php';
        $complemento .= "AND cod= '" . $codestq . "'";
        break;
    case 'relatoest';
        include './pagina/estoque/estoque_relato.inc.php';
        break;
    case 'balanco';
        include './pagina/estoque/balanco.inc.php';
        break;
}
//Cadastrar retiradas
$msgRetira = "";
if (isset($_POST['motivo'])) {
    $est->set_codEst($_POST['codEstq']);
    $qtd = formatarValorMySQL($_POST['qtd']);
    $est->set_qtd($qtd);
    $und = formatarValorMySQL($_POST['und']);
    $est->set_und($und);
    $est->set_motv($_POST['motivo']);
    $est->retSalvar();
    $msgRetira = $est->msgRet;
}
//Inserir item em pedido aberto
$msgItem = "";
if (isset($_POST['inserirItem'])) {
    $est->set_codPed($_POST['codped']);
    $est->set_codEst($_POST['codestq']);
    $qtd = formatarValorMySQL($_POST['qt']);
    $est->set_qtd($qtd);
    $custo = formatarValorMySQL($_POST['custo']);
    $est->set_valorCusto($custo);

    if (isset($_POST['situ'])) {
        $est->set_situItem($_POST['situ']);
    } else {
        $est->set_situItem("");
    }
    $msgItem = $est->pedidoSalvarItem();
}

//Excluir um item de pedido        
if (isset($_GET['acao'])) {
    $est->set_codPed($_GET['codped']);
    $est->set_codEst($_GET['codestq']);

    $msgItem = $est->pedidoExclItem();
}
# ********
$complemento = "";
$msgRetira = "";
switch ($pag) {
    case 'edit':
        include './pagina/estoque/includes/estoque-cad.inc.php';
        $complemento .= "AND cod= '" . $codestq . "'";
        break;
    case 'detal':
        include ("estoque-detal.inc.php");
        $complemento .= "AND cod= '" . $codestq . "'";
        break;
    case 'cad':
        include './pagina/estoque/includes/estoque-cad.inc.php';
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
    case 'excl':
        excluir();
        break;
    case 'pesq':
        $complemento .= " AND descr LIKE '" . $_POST['string'] . "%'
                          OR descrtec LIKE '" . $_REQUEST['string'] . "%'
                        ORDER BY descr";
        $blcPag = TRUE; // Bloquear paginacao
        break;
    default :
        $complemento .= " ORDER BY cod DESC LIMIT 1";
        $blcPag = TRUE; // Bloquear paginacao
        break;
}
?>
<div id="listagem">
    <?php    
    $msgList = "Listagem Geral.";
    if (!isset($mobile)) {
        $mobile = FALSE;
    }
    if ($mobile) {
        include 'm-estoque-lista.inc.php';
    } else {
        include 'estoque-lista.inc.php';
    }

    if ($outroEstoque) {
        $consulta = "SELECT cod,
                    descr,
                    descrtec,
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
                    AND numest NOT IN( " . $numest . ")
               " . $complemento;
        $resultado = retornoSQL($consulta);

        if (rowsSQL($resultado) > 1) {
            $msgList = "Listagem Geral Outros Estoque.";
            include 'estoque-lista.inc.php';
        }
        ?>

    <?php } ?>
</div>
<hr>
<?php
include './pagina/estoque/includes/estoque_opcoes.inc.php';
?>