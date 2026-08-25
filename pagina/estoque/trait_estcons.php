<?php

/*
 * Description
 * Consultas para apoio do gerenciamento do estouqe em MySQL
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Novembro/2020
 * Revisoes:
 * 19/11/2016: pregis
 *     consulstas iniciais
 */

trait Testcons {

    /**
     * Para salvar alteracoes de um produto
     * @return string
     */
    public function est_Cons01() {
        $consulta = "UPDATE estoque
                        SET numest= '" . $this->get_numEstq() . "',
                            nossonum= '" . $this->get_nossoNum() . "',
                            descr= '" . $this->get_descr() . "',
                            descrtec= '" . $this->get_descrTec() . "',
                            datasheet= '" . $this->get_datasheet() . "',
                            und= '" . $this->get_und() . "',
                            qtd= " . $this->get_qtd() . ",
                            clasf= '" . $this->get_codClasf() . "',
                            situacao= '" . $this->get_situ() . "',
                            qtdmin= " . $this->get_qtdMin() . ",
                            valorcusto= " . $this->get_valorCusto() . ",
                            valorvenda= " . $this->get_valorVenda() . ",
                            moeda= '" . $this->get_moeda() . "',
                            peso= " . $this->get_peso() . ",
                            local= " . $this->get_codLocal() . ",
                            catg= " . $this->get_codCatg() . ",
                            subcatg= " . $this->get_codSubCatg() . "
                        WHERE cod=" . $this->get_codEst();

        return $consulta;
    }

    /**
     * Para retistar um retirada avulso
     * @return string
     */
    public function ret_Cons01() {
        $consulta = "INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo)
                         VALUES(NOW(), " . $this->get_codEst() . ", '" . $_SESSION['resp'] . "', " . $this->get_qtd() . ", '" . $this->get_und() . "', '" . $this->get_motv() . "')";

        return $consulta;
    }

    /**
     * Para criar um cabecalho de um pedido
     * @return string
     */
    public function pedido_Cons01() {
        $consulta = "INSERT INTO estpedidocab (codforn, codcli, resp, tipo, ospro, dtped, situ)
                         VALUES(" . $this->get_codForn() . ", " . $this->get_codCli() . ", '" . $_SESSION['resp'] . "', '" . $this->get_tipoPed() . "', 0, CURDATE(), 'espera')";

        return $consulta;
    }

    /**
     * Para gravar o acompanhemento do pedido
     * ou auteracoes do mesmo
     * @param type $complemento
     * @return string
     */
    public function pedido_Cons02($complemento) {
        $consulta = "UPDATE estpedidocab SET
                            nomeped='" . $this->get_nomePed() . "',
                            situ= '" . $this->get_situPed() . "',
                            ospro='" . $this->get_ospro() . "'
                            " . $complemento . "
                      WHERE cod= " . $this->get_codPed();

        return $consulta;
    }

    /**
     * Consultar se o item ja esta pedido
     * @return string
     */
    public function pedido_Cons03() {
        $consulta = "SELECT COUNT(*) nmitem, qt, coditem FROM estpedidoitem WHERE codped=" . $this->get_codPed() . " AND codest=" . $this->get_codEst();

        return $consulta;
    }

    /**
     * incrementa a quantidade
     * @param type $codItem
     * @param type $qtd
     * @return string
     */
    public function pedido_Cons04($codItem, $qtd) {
        $consulta = "UPDATE estpedidoitem SET qt= " . $qtd . ", custo= " . $this->get_valorCusto() . ", situ= '" . $this->get_situItem() . "' WHERE coditem=" . $codItem;

        return $consulta;
    }

    /**
     * Insere item no pedido
     * @return string
     */
    public function pedido_Cons05() {
        $consulta = "INSERT INTO estpedidoitem (codped, codest, qt, custo, situ)
                                 VALUES(" . $this->get_codPed() . ", " . $this->get_codEst() . ",  " . $this->get_qtd() . ",  " . $this->get_valorCusto() . ", '" . $this->get_situItem() . "')";

        return $consulta;
    }

    /**
     * Exluir um item de um pedido
     * @return string
     */
    public function pedido_Cons06() {
        $consulta = "DELETE FROM estpedidoitem WHERE codped= " . $this->get_codPed() . " AND codest= " . $this->get_codEst() . " LIMIT 1";

        return $consulta;
    }

    /**
     * Consulta para detalhar os itens de um pedido
     * @param type $complemento
     * @return string
     */
    public function pedido_Cons07($complemento) {
        $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            pd.codest,
                            pd.qt,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            " . $complemento . "
                     ORDER BY codpedido, descr";

        return $consulta;
    }

    /**
     * Para listagem de produtos
     * @date: 24/09/2021
     * Criacao
     * @date: 03/06/2024
     * CASE para a clasficacao
     * 17/05/205
     * importado de trait-estoque.php, modo estruturado
     * @param type $complemento
     * @param type $numest
     * @return string
     */
    function estq_consLista01($complemento, $numest) {
        $str = "  SELECT est.cod,
                    est.nossonum,
                    est.descr,
                    est.descrtec,
                    CASE
                       WHEN est.und IN('pc', 'und') THEN ROUND(qtd, 0)
                       WHEN est.und IN('m', 'ml', 'Kg') THEN ROUND(qtd, 3)
                    END qtd,
                    est.und,
                    (SELECT nome FROM getar_cad WHERE cod= est.fabr) fabr,
                    (SELECT etq FROM estlocal WHERE cod = est.local) etqlocal,
                    (SELECT descr FROM estcatg WHERE cod = est.catg) descrcatg,
                    (SELECT descr FROM estsubcatg WHERE cod = est.subcatg) descrsubcatg,                    
                    CASE
                        WHEN est.clasf ='ne' THEN 'N&atilde;o Estocavel'
                        WHEN est.clasf = 'colec' THEN 'Colecionavel'
                        ELSE est.clasf
                    END clasf,
                    est.situacao
               FROM estoque est
              WHERE est.situacao != 'temporario'
                    AND est.numest = " . $numest . "
               " . $complemento . "
              LIMIT 20";

        return $str;
    }

}

?>
