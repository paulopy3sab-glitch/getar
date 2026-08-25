<?php

/*
 * Arquivo para o calendario de OS programadas
 * @date
 * 15/06/2024
 * @author
 * Paulo Regis
 */

//preparar calendario
include $dirChave . 'classe_calendario.php';
$mes = date('m');
$ano = date('Y');
$cld = new Calendario(intval($mes), intval($ano));
$arrayOS = $cld->arrayDia;

//Pesquisar todas aberta por mes e ano do ano atual
$consulta = " SELECT DISTINCT(DATE_FORMAT(inicio, '%m')) mes,
                             DATE_FORMAT(inicio, '%Y') ano
                        FROM ordem
                       WHERE situ IN('aberta', 'programada')
                             AND DATE_FORMAT(inicio, '%Y') = DATE_FORMAT(CURDATE(), '%Y')
                       ORDER BY mes ASC";
$resultado = retornoSQL($consulta);
while ($dados = arraySQL($resultado)) {
    $mes = $dados['mes'];
    $ano = $dados['ano'];
    $cld->recal($mes, $ano);
    $cld->arrayDia = OSMes($mes, $ano);
    $capt = "Calend&aacute;rio " . mesExtBR($mes) . " de " . $ano;
    echo $cld->exibe_calendario($capt);
}

//Pesquisar todas aberta por mes e ano dos proximos anos
$consulta = " SELECT DISTINCT(DATE_FORMAT(inicio, '%m')) mes,
                             DATE_FORMAT(inicio, '%Y') ano
                        FROM ordem
                       WHERE situ IN('aberta', 'programada')
                             AND DATE_FORMAT(inicio, '%Y') != DATE_FORMAT(CURDATE(), '%Y')
                       ORDER BY mes ASC";
$resultado = retornoSQL($consulta);
while ($dados = arraySQL($resultado)) {
    $mes = $dados['mes'];
    $ano = $dados['ano'];
    $cld->recal($mes, $ano);
    $cld->arrayDia = OSMes($mes, $ano);
    $capt = "Calend&aacute;rio " . mesExtBR($mes) . " de " . $ano;
    echo $cld->exibe_calendario($capt);
}
?>