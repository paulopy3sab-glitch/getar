<?php
/* 
 * Para Listar em um combo todas as subcatergorias 
 */
session_start();

include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-conex.php';

// correcoes
$localBackup = "../../DocsGetar/Backup/";

$consulta = "SELECT cod, nome FROM getar_estado WHERE getar_pais_id_pais = ".$_GET["cod"]." ORDER BY nome";
$resultado = retornoSQL($consulta);

$atualizacao = '<select name="codest" id="codest" ><option value="0">Selecione</option>';
while ($dados= arraySQL($resultado)){
    $atualizacao .= '<option value="'.$dados["cod"].'">'.$dados["nome"].'</option>';
}
$atualizacao .= '</select>';

echo "document.getElementById('divEstado').innerHTML='".$atualizacao."';"

?>
