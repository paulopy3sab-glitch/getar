<?php
/* 
 * Para Listar em um combo todas as subcatergorias 
 */
session_start();

include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-conex.php';

// correcoes
$localBackup = "../../DocsGetar/Backup/";

$consulta = "SELECT cod, descr FROM estsubcatg WHERE codcatg = ".$_GET["cod"]." ORDER BY descr";
$resultado = retornoSQL($consulta);

$atualizacao = '<select name="subcatg" id="subcatg" ><option value="0">Selecione</option>';
while ($dados= arraySQL($resultado)){
    $atualizacao .= '<option value="'.$dados["cod"].'">'.$dados["descr"].'</option>';
}
$atualizacao .= '</select>';

echo "document.getElementById('divSubCateg').innerHTML='".$atualizacao."';"

?>
