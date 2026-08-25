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
trait Toperacons {

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
     * lista projetos de programacao conforme complemento
     * @param type $complemento
     * @return string
     */
    public function opera_Cons03($complemento) {
        $consulta = "SELECT cod,
                            tag,
                            nome,
                            resp,
                            SUBSTRING(descr, 1, 40) AS descr,
                            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                            CASE
                               WHEN situacao = 'espera' THEN 'em espera'
                               WHEN situacao = 'ativo' THEN 'ativo'
                               WHEN situacao = 'fechado' THEN 'fechado'
                           END situacao
                       FROM getar_opera opr
                      WHERE 1 = 1
                      " . $complemento;

        return $consulta;
    }

    /**
     * Consulta para UPDATE de um projeto
     * @return string
     */
    public function opera_Cons05() {
        $consulta = "UPDATE getar_opera SET
                            tag='".$this->get_tag()."',
                            nome='" . $this->get_nomeOpera() . "',
                            resp='" . $this->get_respOpera() . "',
                            descr='" . $this->get_descr() . "',
                            situacao='" . $this->get_situOpera() . "'
                      WHERE cod= " . $this->get_codOpera();
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
     * Para edicao de uma tarefa
     * @param type $codTarf
     * @return string
     */
    public function tarf_Cons01($codTarf){
        $consulta="SELECT date_format(dataexc, '%d/%m/%Y') dia,
                        # date_format(horaini, '%k:%i') hora_ini,
                        horaini hora_ini,
                        # date_format(horafim, '%k:%i') hora_fim,
                        horafim hora_fim,
                        doc,
                        resp,
                        situacao as situ
                   FROM getar_tarfopera
                  WHERE cod= " . $codTarf;
        return $consulta;
    }
    
    public function tarf_Cons02(){
        $consulta= "UPDATE getar_tarfopera SET
                            horaini= '" . $this->get_horaIni() . "',
                            horafim= " . $this->get_horaFim() . ",
                            resp= '" . $this->get_respTarf() . "',
                            doc= '" . $this->get_docTarf() . "',
                            situacao= '" . $this->get_statusTarf() . "'
                      WHERE cod= " . $this->get_codTarf();
        
        return $consulta;
    }
}
?>
