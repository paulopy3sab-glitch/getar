<?php

/*
 * Descricao:
 * Switch para Plano de Custos
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * @date: 22/04/2025
 * 
 * Revisions:
 */

$complemento = "";
switch ($pag) {
    case "edit":
        $codCad = $_GET['codcad'];
        $consulta = "SELECT cad.cod,
                                    cad.nome,
                                    ctl.nick,
                                    ctl.custohora
                               FROM getar_control ctl,
                                    getar_cad cad
                              WHERE cad.cod= ctl.codcad
                                    AND cad.cod=" . $codCad;
        $resultado = retornoSQL($consulta);
        $dados = arraySQL($resultado);
        include './pagina/planocustos/includes/custohora_edit.inc.php';
        $complemento = " AND situacao NOT IN ('temporario')";
        break;
}
?>
