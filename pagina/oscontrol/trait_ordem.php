<?php

/*
 * Description
 * Consultas para apoio OSs em MySQL.
 * 
 * Baseado no arquivo funcoes_oscons.php que não estavam no padrao POO
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 15/05/2025
 * Revisoes:
 */

trait Tordem {

    /**
     * listagem normal
     * @param type $complemento
     */
    function os_cons1($complemento) {
        $consulta = "SELECT ord.cod,
                        cad.nome cliente,
                        eqp.descr,
                        eqp.marca,
                        eqp.modelo,
                        DATE_FORMAT(ord.entd, '%d/%m/%Y') entrada,
                        DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
                        CASE
                            WHEN fila = 0 THEN 9999
                            WHEN fila > 0 THEN fila
                        END fila,
                        (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
                        '' hashtag,
                        ord.entd,
                        ord.fatu,
                        ord.retorno,
                        ord.situ
                   FROM ordem ord,
                        equipo eqp,
                        getar_cad cad
                   WHERE ord.codeqp = eqp.cod
                         AND ord.codcli = cad.cod
                         " . $complemento . "
                 ORDER BY fila ASC, situ ASC, inicio ASC";

        return $consulta;
    }

    /**
     * Consulta basica para equipamento
     * @return string
     */
    function os_cons3($complemento) {
        $consulta = " SELECT eqp.cod codeqp,                
                        cad.nome cliente,
                        eqp.descr,
                        eqp.marca,
                        eqp.modelo,
                        ord.cod codos,
                        ord.situ situos,
                        eqp.situ situeqp
                   FROM equipo eqp,
                        getar_cad cad,
                        ordem ord
                  WHERE eqp.codcli = cad.cod
                        AND eqp.cod = ord.codeqp
                        # AND eqp.situ NOT IN('sucata')
                        # AND ord.situ NOT IN('cancelada')
                        AND eqp.situ NOT IN('temporario')
                        ".$complemento."
                  LIMIT 20";

        return $consulta;
    }

    /**
     * Pesquisa por string no modelo
     * @return string
     */
    function os_cons4($string) {
        $consulta = " SELECT eqp.cod codeqp,
                        eqp.descr descr,
                        eqp.marca marca,
                        eqp.modelo modelo,
                        eqp.situ situeqp,
                        cad.nome cliente,
                        ord.cod codos,
                        ord.situ situos
                   FROM equipo eqp,
                        getar_cad cad,
                        ordem ord
                  WHERE eqp.codcli = cad.cod
                        AND eqp.cod = ord.codeqp
                        AND eqp.modelo LIKE '" . $string . "%'";

        return $consulta;
    }

    /**
     * Consulta para edição de uma OS
     * @param type $codOS
     * @return string
     */
    function os_cons5($codOS) {
        $consulta = "    SELECT cod codos,
                        (SELECT trf.cod FROM ordem_tarf trf WHERE trf.codos = ord.cod AND trf.situ= 'andamento' LIMIT 1) codtarf, # utima tarefa aberta
                        (SELECT GROUP_CONCAT(cod ORDER BY cod DESC) FROM ordem WHERE codeqp = ord.codeqp AND cod NOT IN(" . $codOS . ")) osante, # OSs anteriores 
                        (SELECT GROUP_CONCAT(CONCAT(cod, '-', fila, '-', DATE_FORMAT(inicio, '%d/%m/%Y')) ORDER BY fila ASC) FROM ordem WHERE fila NOT IN(0)) filaos, # fila das OSs 
                        codcli,
                        resp,
                        (SELECT nome 
                           FROM getar_cad cad
                          WHERE codcli = cad.cod) cliente,
                        valcb,
                        fatu,
                        vndacs,
                        DATE_FORMAT(entd, '%d/%m/%Y') entd,
                        DATE_FORMAT(saida, '%d') diasd,
                        DATE_FORMAT(saida, '%m') messd,
                        DATE_FORMAT(saida, '%Y') anosd,
                        saida,
                        DATE_FORMAT(datafcd, '%d') diafcd,
                        DATE_FORMAT(datafcd, '%m') mesfcd,
                        DATE_FORMAT(datafcd, '%Y') anofcd,
                        datafcd,
                        inicio,
                        fila,
                        (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
                        (SELECT MAX(fila)+ 10 FROM ordem) proxfila,
                        (SELECT CONCAT(ord1.cod, '-', DATE_FORMAT(ord1.inicio, '%d/%m/%Y')) FROM ordem ord1 WHERE ord1.fila = (SELECT MAX(ord2.fila) FROM ordem ord2)) osproxfila,
                        (SELECT CONCAT(eq.descr, ' - ', eq.marca, ' - ', eq.modelo, ' - ', (SELECT nome FROM getar_cad WHERE cod = eq.codcli))
                           FROM equipo eq
                          WHERE eq.cod = codeqp) equipamento,
                        codeqp,
                        situequip,
                        (SELECT eqp.situ FROM equipo eqp WHERE eqp.cod = ord.codeqp) sucata,
                        recla,
                        encr,
                        serv,
                        retorno,
                        situ
                   FROM ordem ord
                  WHERE cod=" . $codOS;

        return $consulta;
    }

    /**
     * Consulta para procurar um tag na observacao
     * @return type
     */
    function os_cons6($complemento) {
        $consulta = "SELECT ord.cod,
                    cad.nome cliente,
                    ord.retorno,
                    ord.fila,
                    (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
                    DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
                    DATE_FORMAT(ord.entd, '%d/%m/%Y') entrada,                    
                    REGEXP_SUBSTR(obs.texto, '#[a-z]+') hashtag,
                    cad.nome nome,
                    eqp.descr descr,
                    eqp.marca marca,
                    eqp.modelo modelo,
                ord.situ
               FROM ordem ord,
                    ordem_obs obs,
                    getar_cad cad,
                    equipo eqp
              WHERE ord.cod = obs.codord
                    AND ord.codcli = cad.cod
                    AND ord.codeqp = eqp.cod
                    " . $complemento . "
              ORDER BY fila";

        return $consulta;
    }

}

?>
