<?php

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data de criacao: Setembto/2016
 * Descricao: Metodos com as consultas MySQL para mensagens e lembretes
 * Revisoes:
 */
trait Tmenscons {

    /**
     * inserir lembrete novo
     * @return string
     */
    public function cons01() {
        $consulta = "INSERT INTO getar_lembre (datacad, situ)
                                   VALUES(CURDATE(), 'temporario')";

        return $consulta;
    }

    /**
     * retorna dados de um lembrete
     * @param type $codLmb
     * @return string
     */
    public function cons02($codLmb) {
        $consulta = "SELECT cod,
                            titulo,
                            dest,
                            remt,
                            DATE_FORMAT(datacad, '%d/%m/%Y') datacad,
                            dataagd,
                            texto,
                            situ
                      FROM getar_lembre
                      WHERE cod=" . $codLmb;

        return $consulta;
    }

    /**
     * nicks ativos com seus nomes
     * @return string
     */
    public function cons03() {
        $consulta = "SELECT ctl.nick,
                           cad.nome
                     FROM  getar_control ctl,
                           getar_cad cad
                     WHERE ctl.codcad = cad.cod
                           AND cad.situacao = 'ativo'";

        return $consulta;
    }

    /**
     * Para salvar alteracoes no lembrete
     * @return string
     */
    public function cons04() {

        $consulta = "UPDATE getar_lembre SET
                            titulo='" . $this->get_tituLmb() . "',
                            dest='" . $this->get_destLmb() . "',
                            remt='" . $this->get_remtLmb() . "',
                            dataagd='" . $this->get_dataagd() . "',
                            texto='" . $this->get_textoLmb() . "',
                            situ= '" . $this->get_situLmb() . "'
                      WHERE cod=" . $this->get_codLmb();

        return $consulta;
    }

    /**
     * listagem de lembretes
     * @param type $complemento
     * @return string
     */
    public function cons05($complemento) {
        $consulta = "SELECT cod,
                            titulo,
                            remt,
                            dest,
                            date_format(dataagd, '%d/%m/%Y') dataagd,
                            CASE 
                                WHEN date_format(dataagd, '%w') = '0' THEN 'Domingo'
                                WHEN date_format(dataagd, '%w') = '1' THEN 'Segunda'
                                WHEN date_format(dataagd, '%w') = '2' THEN 'Terca'
                                WHEN date_format(dataagd, '%w') = '3' THEN 'Quarta'
                                WHEN date_format(dataagd, '%w') = '4' THEN 'Quinta'
                                WHEN date_format(dataagd, '%w') = '5' THEN 'Sexta'
                                WHEN date_format(dataagd, '%w') = '6' THEN 'Sabado'
                            END AS diasem,
                            dataagd dtAgOrd,
                            SUBSTRING(texto, 1,40) texto,
                            situ
                       FROM getar_lembre
                      WHERE situ != 'temporario'
                            " . $complemento . "
                   ORDER BY dtAgOrd ASC";

        return $consulta;
    }

    /**
     * Detalha uma mensagens enviada
     * @return string
     */
    public function cons06() {
        $consulta = "SELECT cod,
                            titulo,
                            texto,
                            dest,
                            date_format(data, '%d/%m/%Y') AS data,
                            remt
                       FROM getar_mens
                      WHERE cod= " . $this->get_codMens();
        
        return $consulta;
    }

   
}

?>
