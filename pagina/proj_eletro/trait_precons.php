<?php

/**
 * Description of trait_precons
 * Consultas para os projetos eletronicos em MySQL
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Agosto/2016
 * Revisoes:
 */
trait Tprecons {

    /**
     * Listagem de Pedidos
     * @param type $codProj
     * @param type $complemento
     * @return string
     */
    public function proj_cons01($codProj, $complemento) {
        $consulta = "SELECT cod,
                            (SELECT nome
                               FROM eletro_projetos
                              WHERE cod = ped.codproj) nome_proj,
                            ped.codproj projeto,
                            (SELECT cod FROM estpedidocab WHERE ospro = ped.cod AND tipo= 'consumo' AND situ NOT IN ('cancelado')) pedconsumo,
                            (SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))), '%H:%i') FROM eletro_tarefas WHERE codped= ped.cod AND situacao != 'x') AS tothora,
                            DATE_FORMAT(dataini, '%d/%m/%Y') dataini,
                            CASE
                                WHEN prioridade= 'a' THEN 'Urgente'
                                WHEN prioridade= 'b' THEN 'Alta'
                                WHEN prioridade= 'c' THEN 'M&eacute;dia'
                                WHEN prioridade= 'd' THEN 'Baixa'
                            END prioridade,
                            titulo,
                            CASE
                                WHEN situacao = 't' THEN 'em estudos'
                                WHEN situacao = 'e' THEN 'em espera'
                                WHEN situacao = 'a' THEN 'em andamento'
                                WHEN situacao = 'c' THEN 'concluido'
                                WHEN situacao = 'x' THEN 'cancelado'
                            END situacao
                       FROM eletro_pedidos ped
                      WHERE 1 = 1
                        " . $complemento . "
                   ORDER BY situacao, prioridade, dataini";
        return $consulta;
    }

    /**
     * insere um pedido
     * @param int $codProj
     * @return string
     */
    public function proj_cons02($codProj) {
        $consulta = "INSERT INTO eletro_pedidos (titulo, resp, codproj, datareg,dataini, dataclc, situacao)
                        VALUES ('Titulo do Pedido', '" . $_SESSION['resp'] . "', " . $codProj . ", CURDATE(), CURDATE(), CURDATE(), 'temporario')";

        return $consulta;
    }

    /**
     * listagem de projetos eletronicos conforme complemento
     * @param type $complemento
     * @return string
     */
    public function proj_cons04($complemento) {
        $consulta = "SELECT cod,
                        nome descr,
                        SUBSTRING((SELECT nome FROM getar_cad WHERE cod= proj.cliente ), 1, 20) AS col1,
                        SUBSTRING(descr, 1, 20) AS col3,
                        DATE_FORMAT(datareg, '%d/%m/%Y') col2,
                        CASE
                           WHEN situacao = 'n' THEN 'negociacao'
                           WHEN situacao = 'e' THEN 'em estudos'
                           WHEN situacao = 's' THEN 'em espera'
                           WHEN situacao = 'a' THEN 'em andamento'
                           WHEN situacao = 'f' THEN 'fechado'
                           WHEN situacao = 'x' THEN 'cancelado'
                       END col4,
                       CASE 
                           WHEN situacao IN('f', 'x') THEN 'n'
                           ELSE 's'
                       END editavel
                   FROM eletro_projetos proj
                  WHERE 1= 1
                  " . $complemento;

        return $consulta;
    }

    public function proj_Cons05() {
        $consulta = "UPDATE eletro_projetos SET
                           nome='" . $nome . "',
                           cliente='" . $codCliente . "',
                           descr='" . $descr . "',
                           situ='" . $situacao . "'
                     WHERE cod= " . $codproj;

        return $consulta;
    }
    
    /*
     * Edicao de um pedido
     */
    public function proj_cons06($codPed){
        $consulta= "SELECT cod,
                            titulo,
                            resp,
                            prioridade prior,
                            codproj,
                            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                            dataini,
                            dataclc,
                            fatu,
                            doc,
                            situacao
                       FROM eletro_pedidos
                      WHERE cod=". $codPed;
        
        return $consulta;
    }    
    
    /**
     * insere uma tarefa
     * @param int $codPed
     * @return string
     */
    public function proj_cons07($codPed) {
        $doc = "Descricao inicial da Tarefa: \n \nDocumentacao em anexo:";
        $consulta = "INSERT INTO eletro_tarefas (situacao, resp, codped, dataexc, horaini, horafim, doc)
                         VALUES ('temporario', '" . $_SESSION['resp'] . "', " . $codPed . ", CURDATE(), CURTIME(), '00:00', '" . $doc . "')";

        return $consulta;
    }
    
    /**
     * Editada uma tarefa
     * @param type $codTarf
     * @return string
     */
    public function proj_cons08($codTarf) {
        $consulta = "SELECT date_format(dataexc, '%d/%m/%Y') dia,
                            date_format(horaini, '%k:%i') hora_ini,
                            date_format(horafim, '%k:%i') hora_fim,
                            doc,
                            resp,
                            codped,
                            (SELECT doc FROM eletro_pedidos WHERE cod = codped) doc_pedido,
                            CASE 
                                 WHEN situacao = 'c' THEN 'concluido'
                                 WHEN situacao = 't' THEN 'andamento'
                                 WHEN situacao = 'a' THEN 'andamento'
                            END as st,
                            situacao
                       FROM eletro_tarefas
                      WHERE cod= " . $codTarf;
        
        return $consulta;
    }

}

?>
