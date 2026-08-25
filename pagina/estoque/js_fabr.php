<?php
/* 
 * Para Listar em um combo todas as subcatergorias 
 */
session_start();

include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-conex.php';

// correcoes
$localBackup = "../../DocsGetar/Backup/";

$consulta = "SELECT cod, nome FROM getar_cad WHERE clasf = 'b' AND nome LIKE '".$_GET["str"]."%' LIMIT 3";
$resultado = retornoSQL($consulta);

//$codest= "";
$codest=$_SESSION['codest'];
$atualizacao = "";
while ($dados= arraySQL($resultado)){
    $atualizacao .= "<small><a href=\"index.php?st=estoque&pag=slvfabr&codestq=".$codest."&codfabr=".$dados['cod']."\">".$dados['nome']."</a></small> <br />";
    //$atualizacao .= "<small>".$dados["nome"]."</small> <br />";
}
echo "document.getElementById('divFabr').innerHTML='".$atualizacao."';"

?>
