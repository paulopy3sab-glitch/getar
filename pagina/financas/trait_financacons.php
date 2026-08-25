<?php

/**
 * Description of trait_fnccons
 * Consultas para contas a pagar e receber em MySQL
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Setembro/2016
 * Revisoes:
 */
trait Fnccons {

    /**
     * consulta para listagem de parcelas de carnes simultaneas
     * @param type $complemento
     * @return string
     */
    public function fnc_cons01($complemento) {
        $consulta = "    SELECT pr.cod codpar,
                                pr.parnum,
                                cad.nome,
                                cn.cod codcarne,
                                cn.tipo,
                                date_format(pr.datavnc, '%d/%m/%Y') datavnc,
                                ROUND(pr.valorpar, 2) valorpar,
                                pr.situacao
                           FROM getar_cad cad,
                                conta_carne cn,
                                conta_carnepar pr
                           WHERE cn.codcad = cad.cod
                                 AND pr.codcarne = cn.cod" . $complemento."
                                 ORDER BY pr.datavnc ASC";

        return $consulta;
    }
    
    /**
     * Consulta para listagem geral das C/C
     * @return string
     */
    public function fnc_cons02(){
        $consulta = "SELECT nm.cod,
                            nm.nome,
                            (SELECT cod
                                FROM peratu
                               WHERE codctco= nm.cod
                                     AND situacao = 'ativo'
                               LIMIT 1) codper,# codigo do periodo ativo
                             (SELECT COUNT(*)
                                FROM peratu
                               WHERE codctco= nm.cod
                                     AND situacao = 'ativo') nmper,# numero de periodos ativos
                             (SELECT nome
                                FROM peratu
                               WHERE codctco= nm.cod
                                     AND situacao = 'ativo'
                               LIMIT 1) peratu,# periodo ativo
                             nm.moeda,  
                             nm.situacao
                       FROM getar_contanome nm";
        
        return $consulta;
    }

}

?>
