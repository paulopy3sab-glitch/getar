<?php

/**
 * Arquivo para o calendario de OS trabalhadas por dia
 * @date
 * 15/06/2024
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 **/

//preparar calendario
include $dirChave . 'classe_calendario.php';
$mes = date('m');
$ano = date('Y');
$cld = new Calendario(intval($mes), intval($ano));
$arrayOS = $cld->arrayDia;

//Pesquisar todas aberta por mes e ano do ano atual
$consulta = " SELECT DISTINCT(DATE_FORMAT(trf.dataexec, '%m')) mes,
                      DATE_FORMAT(trf.dataexec, '%Y') ano,
                      trf.dataexec inicio # para ordenar
                 FROM ordem ord,
                      ordem_tarf trf
                WHERE ord.cod = trf.codos
                      AND trf.situ = 'concluida'
                      AND DATE_FORMAT(trf.dataexec, '%m/%Y') = DATE_FORMAT(CURDATE(), '%m/%Y')
             ORDER BY inicio ASC";
$resultado = retornoSQL($consulta);
//while ($dados = arraySQL($resultado)) {
$dados = arraySQL($resultado);
    $mes = $dados['mes'];
    $ano = $dados['ano'];
    $cld->recal($mes, $ano);
    $cld->arrayDia = OSTrabMes($mes, $ano);
    $capt = "Calend&aacute;rio " . mesExtBR($mes) . " de " . $ano;
    echo $cld->exibe_calendario($capt);
//}
?>
