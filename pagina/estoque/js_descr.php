<?php
/* 
 * Para Listar em um combo todas as subcatergorias 
 */
session_start();

include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-conex.php';

// correcoes
$localBackup = "../../DocsGetar/Backup/";

$consulta = "SELECT descr FROM estoque WHERE descr LIKE '".$_GET["str"]."%' LIMIT 3";
$resultado = retornoSQL($consulta);

$atualizacao = "";
while ($dados= arraySQL($resultado)){
    $atualizacao .= "<small>".$dados["descr"]."</small> <br />";
}

echo "document.getElementById('divDescr').innerHTML='".$atualizacao."';"

?>
