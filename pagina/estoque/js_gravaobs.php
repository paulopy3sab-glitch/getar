<?php
/* 
 * Para gravar observacoes dos produtos
 * Autor: Paulo Regis
 * 9/11/2015
 */

session_start();
include ("../../config/conex.inc.php");
include '../../funcoes/funcoes-geral.php';
include("../../funcoes/funcoes-conex.php");

// Ajuste forcado
$localBackup="../../".$localBackup;

$codEstq = $_GET['cod'];
$codObs = $_GET['codob'];
$texto = $_GET['txt'];
if ($codObs <> "") {
    $consulta = "UPDATE estobs SET texto = '" . $texto . "' WHERE cod=" . $codObs;
} else {
    $consulta = "INSERT INTO estobs (codestq, texto) VALUES(" . $codEstq . ", '" . $texto . "')";
}
$msgObs = executaJs_SQL($consulta);

echo "document.getElementById('msgObs').innerHTML='".$msgObs."';"
?>