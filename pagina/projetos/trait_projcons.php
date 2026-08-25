<?php

/**
 * Description
 * Consultas para apoio de projetos de programacao em MySQL
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Agosto/2016
 * Revisoes:
 * 22/09/2016: pregis
 *     troca do nome para padrao das traits: Tprojcons
 */
trait Tprojcons {

    /**
     * Listagem de pedidos para um projeto
     * @param type $codproj
     * @param type $complemento
     * @return string
     */
    public function proj_cons01($complemento) {
        $consulta = "SELECT ped.cod,
                            SUBSTRING(ped.titulo, 1, 22) AS titulo,
                            proj.cod codproj,
                            proj.tag,
                            proj.nome,
                            date_format(ped.dataini, '%d/%m/%Y') dataini,
                            (SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))), '%H:%i') FROM getar_tarefas trf WHERE codped= ped.cod AND trf.situacao != 'x') AS tothora,
                            CASE
                                WHEN `prior` = 'urgente' THEN 'Urgente'
                                WHEN `prior` = 'baixa' THEN 'Alta'
                                WHEN `prior` = 'media' THEN 'M&eacute;dia'
                                WHEN `prior` = 'baixa' THEN 'Baixa'
                            END prioridade,
                            ped.doc,
                            CASE 
                                WHEN ped.situacao = 'espera' THEN 'Espera'
                                WHEN ped.situacao = 'estudo' THEN 'Estudos'
                                WHEN ped.situacao = 'andamento' THEN 'Andamento'
                                WHEN ped.situacao = 'concluido' THEN 'Conclu&iacute;do'
                                WHEN ped.situacao = 'fechado' THEN 'Fechado'
                                WHEN ped.situacao = 'negociacao' THEN 'Negocia&ccedil;&atilde;o'
                                WHEN ped.situacao = 'cancelado' THEN 'Cancelado'
                            END as situacao,
                            proj.situacao situproj
                       FROM getar_pedidos ped,
                            getar_projetos proj
                      WHERE ped.codproj = proj.cod
                            " . $complemento . "
                   ORDER BY situacao, prioridade, dataini";

        return $consulta;
    }

    /**
     * insere um pedido de programacao
     * @param int $codProj
     * @return string
     */
    public function proj_cons02($codProj) {
        $consulta = "INSERT INTO getar_pedidos (titulo, resp, codproj, datareg, situacao)
                        VALUES ('Titulo do Pedido', '" . $_SESSION['resp'] . "', " . $codProj . ", CURDATE(), 't')";

        return $consulta;
    }

    /**
     * lista projetos de programacao conforme complemento
     * @param type $complemento
     * @return string
     */
    public function proj_cons03($complemento) {
        $consulta = "SELECT cod,
                            tag,
                            nome,
                            SUBSTRING((SELECT nome FROM getar_cad WHERE cod= proj.cliente ), 1, 20) AS cliente,
                            SUBSTRING(descr, 1, 40) AS descr,
                            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                            CASE
                               WHEN situacao = 'negociacao' THEN 'negociacao'
                               WHEN situacao = 'estudo' THEN 'em estudos'
                               WHEN situacao = 'espera' THEN 'em espera'
                               WHEN situacao = 'andamento' THEN 'em andamento'
                               WHEN situacao = 'fechado' THEN 'fechado'
                               WHEN situacao = 'cancelado' THEN 'cancelado'
                           END situacao,
                           CASE 
                               WHEN situacao IN('f', 'x') THEN 'n'
                               ELSE 's'
                           END editavel
                       FROM getar_projetos proj
                      WHERE 1 = 1
                      " . $complemento;

        return $consulta;
    }

    /**
     * Consulta para UPDATE de um projeto
     * @return string
     */
    public function proj_Cons05() {
        $consulta = "UPDATE getar_projetos SET
                            tag='".$this->get_tag()."',
                            nome='" . $this->get_nomeProj() . "',
                            cliente='" . $this->get_codCliente() . "',
                            descr='" . $this->get_descr() . "',
                            situacao='" . $this->get_situProj() . "'
                      WHERE cod= " . $this->get_codProj();
        return $consulta;
    }
    
    /**
     * 
     * @param type $tag
     * @param type $codPed
     * @return string
     */
    public function ped_Cons01($tag, $codPed){
        $consulta = "SELECT proj.nome AS nomeproj,
                            proj.cod AS codproj,
                            ped.titulo
                       FROM getar_pedidos AS ped,
                            getar_projetos AS proj
                      WHERE proj.cod= ped.codproj
                            # AND proj.tag = '".$tag."'
                            AND ped.cod= " . $codPed;
        
        return $consulta;
    }
    
    /**
     * Salvar alteraceos em um pedido
     * @return string
     */
    public function ped_Cons02() {
        $consulta= "UPDATE getar_pedidos SET resp='" . $this->get_resp() . "',
                            titulo='" . $this->get_tituPed() . "',
                            situacao='" . $this->get_situPed() . "',
                            prior='" . $this->get_priorPed() . "',
                            fatu = '" . $this->get_fatuPed() . "',
                            dataini='" . $this->get_dataIni() . "',
                            dataclc='" . $this->get_dataClc() . "',
                            doc='" . $this->get_docPed() . "'
                            WHERE cod=" . $this->get_codPed();
        
        return $consulta;
    }

    /**
     * Para edicao de uma tarefa
     * @param type $codTarf
     * @return string
     */
    public function tarf_Cons01($codTarf){
        $consulta="SELECT date_format(dataexc, '%d/%m/%Y') dia,
                          horaini,
                          horafim,
                          doc,
                          resp,
                          codped,
                          (SELECT doc FROM getar_pedidos WHERE cod = codped) doc_pedido,
                          situacao as situ
                     FROM getar_tarefas
                    WHERE cod= " . $codTarf;
        return $consulta;
    }
    
    public function tarf_Cons02(){
        $consulta= "UPDATE getar_tarefas SET
                            horaini= '" . $this->get_horaIni() . "',
                            horafim= " . $this->get_horaFim() . ",
                            resp= '" . $this->get_respTarf() . "',
                            doc= '" . $this->get_docTarf() . "',
                            situacao= '" . $this->get_statusTarf() . "'
                      WHERE cod= " . $this->get_codTarf();
        
        return $consulta;
    }
    
    public function tarf_Cons03($complemento){
        $consulta = " SELECT SUM((TIME_TO_SEC(horafim) - TIME_TO_SEC(horaini))) tempo
                        FROM getar_tarefas
                       WHERE situacao != 'temporario'
                             AND codped = '" . $this->get_codPed() . "'
                             " . $complemento;
        return $consulta;
    }
}
?>
