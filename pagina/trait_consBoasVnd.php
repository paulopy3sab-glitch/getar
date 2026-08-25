<?php
/**
 * Consultas SQL para banco MySQL
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data Criacao: Agosto/2016
 * Revisoes:
 */
trait ConsBoasVnd {

    /**
     * Para listagem de parcelas abertas e vencidas
     * @return string
     */
    public function listaParc() {
        $consulta = "SELECT pr.cod codpar,
                            cad.nome descr,
                            date_format(pr.datavnc, '%d/%m/%Y') datapar,
                            ROUND(pr.valorpar, 2) valorpar,
                            pr.situacao
                       FROM getar_cad cad,
                            conta_carne cn,
                            conta_carnepar pr
                       WHERE cn.codcad = cad.cod
                             AND pr.codcarne = cn.cod
                             AND pr.situacao IN('aberta', 'atrasada')
                             AND pr.datavnc < CURDATE()";
        
        return $consulta;
    }

}

?>
