<?php

/* 
 * Para Listar em um combo todas as subcatergorias 
 */
session_start();

global  $dirChave;
include ("../../config/conex.inc.php");

include '../../'.$dirChave.'funcoes-conex.php';
include '../../'.$dirChave.'funcoes-geral.php';

global $bdRaiz;
global $localBackup;
global $pastaPHPMailer;

// correcoes
$localBackup = "../../DocsGetar/Backup/";
$pastaPHPMailer = "../../../phpmailer/";

if($bdRaiz == ""){
    $consulta = "SELECT nick FROM getar_control WHERE nick LIKE '".$_GET["str"]."%' LIMIT 2";
}else{
    $consulta= "SELECT nick FROM getar_control WHERE nick LIKE '".$_GET["str"]."%'
                UNION(SELECT nick FROM ".$bdRaiz."getar_control WHERE nick LIKE '".$_GET["str"]."%')
                LIMIT 2";
}
$resultado = retornoSQL($consulta);

$atualizacao = "";
while ($dados= arraySQL($resultado)){
    $atualizacao .= "<small>".$dados["nick"]."</small> <br />";
}

echo "document.getElementById('divNick').innerHTML='".$atualizacao."';"
?>
