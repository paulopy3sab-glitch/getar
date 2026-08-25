<?php
/* 
 * Para atualizar o local onde esta guardado o componente/produto
 */
session_start();

include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-conex.php';

// correcoes
$localBackup = "../../DocsGetar/Backup/";

$consulta = "SELECT descr FROM estlocal WHERE cod = ".$_GET["loc"];
$dados = consultaSQL($consulta);
$atualizacao = "<i style=\"color: blue; font-size: x-small\">".$dados["descr"]."</i>";

echo "document.getElementById('divEtqLocal').innerHTML='".$atualizacao."';"

?>
