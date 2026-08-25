<?php

/*
 * Descricao:
 * Modulo para gerencias custos
 * Atualmente focado no custo hora dos tecnicos trabalhando em OSs.
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * @date: 22/04/2025
 * 
 * Revisions:
 * 
 */
if (isset($_POST["salvaCusto"])) {
    $custoHora = $_POST['custohora'];
    $nick = $_POST['nick'];
    $consulta = "UPDATE getar_control SET custohora = " . $custoHora . " WHERE nick='" . $nick . "'";
    $msg = executaSQL($consulta);
}

include './pagina/planocustos/switch.inc.php';
include './pagina/planocustos/includes/custos_list.inc.php';
include './pagina/planocustos/includes/custos_opcoes.inc.php';
?>

