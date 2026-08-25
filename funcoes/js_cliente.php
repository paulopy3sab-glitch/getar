<?php

/* 
 * Para Listar clientes ao digitar o nome
 */
session_start();
//Para exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

include '../config/conex.inc.php';
include '../'.$dirChave . 'funcoes-conex.php';

global $bdRaiz;
global $localBackup;

// correcoes
$localBackup = "../DocsGetar/Backup/";

$consulta = "    SELECT cod,
                        nome
                   FROM getar_cad
                  WHERE cod NOT IN(1, 2)
                        AND clasf = 'c'
                        and situacao = 'ativo'
                        AND nome LIKE '".$_GET["str"]."%' LIMIT 3";
$resultado = retornoSQL($consulta);

$cabAtul= "J&aacute cadastrado:<br />";
$atualizacao = "";
while ($dados= arraySQL($resultado)){
    $atualizacao .= $cabAtul."<a href=\"".$_SESSION['link']."&codcli=".$dados["cod"]."\">".$dados["nome"]."</a> <br />";
    $cabAtul="";
}

echo "document.getElementById('divNome').innerHTML='".$atualizacao."';"
?>
