<?php

/*
 * Para Listar em um combo todas as subcatergorias 
 */
session_start();

include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-conex.php';

// correcoes
$localBackup = "../../DocsGetar/Backup/";

$consulta = "SELECT cod, nome FROM getar_cad WHERE clasf = 'r' AND nome LIKE '" . $_GET["str"] . "%' LIMIT 3";
$resultado = retornoSQL($consulta);

//$codest= "";
$codest = $_SESSION['codest'];
if(isset($_SESSION['codped'])){
    $codPed = $_SESSION['codped'];
}
$atualizacao = "";
while ($dados = arraySQL($resultado)) {
    if ($codest <> "") {
        $atualizacao .= "<small><a href=\"index.php?st=estoque&pag=slvforn&codestq=" . $codest . "&codforn=" . $dados['cod'] . "\">" . $dados['nome'] . "</a></small> <br />";
    } else {
        $atualizacao .= "<small><a href=\"index.php?st=pedido&pag=slvped&codped=" . $codPed . "&codforn=" . $dados['cod'] . "\">" . $dados['nome'] . "</a></small> <br />";
    }
}
echo "document.getElementById('divForn').innerHTML='".$atualizacao."';"
?>
