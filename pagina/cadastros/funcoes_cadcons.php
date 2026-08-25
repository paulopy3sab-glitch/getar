<?php

/**
 * Definicao das consultas para o cadastro em MySQL
 */

/**
 * Consulta para habilitar atribuicao
 * @return string
 */
function cad_cons01($resp) {
    $consulta = "SELECT codatrib
                   FROM getar_atrib
                  WHERE nick = '" . $resp . "'";

    return $consulta;
}

/**
 * Valida usuario e senha para logon
 * @return string
 */
function cad_cons02($nick, $senha) {
    $consulta = "SELECT codcad,
                        nick,
                   FROM getar_control
                  WHERE nick  ='" . $nick . "'
                        AND hashsl = PASSWORD('" . $senha . "')";
    return $consulta;
}

function cad_cons02xxx($nick, $senha) {
    $consulta = "SELECT cad.cod,
                        sn.nick,
                        cad.clasf
                   FROM getar_control AS sn,
                        getar_cad AS cad
                  WHERE sn.codcad= cad.cod
                        AND cad.situacao = 'ativo'
                        AND sn.nick  ='" . $nick . "'
                        AND sn.frase = PASSWORD('" . $senha . "')";
    return $consulta;
}

/**
 * registra logon no banco
 * @return string
 */
function cad_cons03($nick, $fusoHora) {
    $consulta = "INSERT INTO getar_reglog (nick, datalog, horaini, horafim) VALUES ('" . $nick . "', CURDATE(), $fusoHora, '00:00:00')";
    return $consulta;
}

/**
 * Registra data e ip do logon
 * @param type $ip
 * @param type $nick
 * @return string
 */
function cad_cons04($ip, $nick) {
    $consulta = "UPDATE getar_control SET datalog= CURDATE(), ip= '" . $ip . "' WHERE nick= '" . $nick . "'";
    return $consulta;
}

/**
 * Registra a hora do logof
 * @param type $resp
 * @return string
 */
function cad_cons05($resp, $fusoHora) {
    $consulta = "UPDATE getar_reglog SET horafim = " . $fusoHora . ", situacao= 'inativo' WHERE nick = '" . $resp . "' AND situacao= 'ativo'";
    #$consulta = "UPDATE getar_reglog SET horafim = NOW(), situacao= 'inativo' WHERE nick = '" . $resp . "' AND situacao= 'ativo'";
    return $consulta;
}

?>
