<?php
/* 
 * Para Listar em um combo todas as subcatergorias 
 */
session_start();

include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-conex.php';

// correcoes
$localBackup = "../../DocsGetar/Backup/";

$consulta = "SELECT cod, descr, descrtec FROM estoque WHERE descrtec LIKE '".$_GET["str"]."%' LIMIT 10";
$resultado = retornoSQL($consulta);

$atualizacao = "";
while ($dados= arraySQL($resultado)){
    $atualizacao .= "<small><a href=\"index.php?st=estoque&pag=edit&codestq=".$dados['cod']."\">".$dados["descr"]."-".$dados["descrtec"]."</a></small> <br />";
}

echo "document.getElementById('divDescrTec').innerHTML='".$atualizacao."';"

?>
