<?php

/**
 * Destinada somente as listagem iniciais
 * Data criacao: Julho/2016
 * @author Paulo
 * Revisao: pregis 27/08/2016
 *     inclusao da trait Consultas [trait_consBoasVnd.php
 */
class BoasVindas extends Conex {

    use ConsBoasVnd;

    function __construct() {
        parent::__construct();
        $msg = "# inicio processamento classe BoasVindas";
        $this->gravaSQL($msg);
    }

    /*
     * Monta listagem de parcelas vencidas
     * @param type $tipo - aberta
     * @return type
     */

    public function listParcela() {
        $str = "";

        $resultado = $this->retornoSQL($this->listaParc());
        /*$rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $this->set_tituloObjeto("Parcelas Vencidas");
            $this->set_descrObjeto("Credor/Pagador");
            $this->set_cabCol1("Data");
            $this->set_cabCol2("Cr&eacute;dito/D&eacute;bito");

            $this->set_st("financaspr");
            $this->set_ft("fnc");
            $this->set_pag("pagar");
            $this->set_tipoCod("codpar");

            $str = $this->montaLista($resultado);
        }

        $this->set_cabCol1("");
        $this->set_cabCol2("");

        return $str;*/
        
        return $resultado;
    }

    /**
     * Monta listagem de lembretes
     * @param type $tipo - ativo
     * @return string
     */
    public function listLembre() {
        $str = "";

        $consulta = "SELECT cod,
                            titulo,
                            date_format(dataagd, '%d/%m/%Y') dtagd,
                            SUBSTRING(texto, 1, 40) descr,
                            situ
                       FROM getar_lembre
                      WHERE dataagd <= CURDATE()
                            AND dest = '" . $this->get_resp() . "'
                            AND situ = 'ativo'";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
                    <caption>Lembretes para Hoje</caption>
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Inicio do lembrete</th>
                            <th>Data Agendada</th>
                            <th>Situa&ccedil;&atilde;o</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . "</th>
                    <td>";
                if ($dados['titulo'] == "") {
                    $str.= $dados['descr'];
                } else {
                    $str.= $dados['titulo'];
                }
                $str.=" <a href=\"index.php?st=lembretes&ft=mens&pag=edit&codlmb=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\" alt=\"\">
                        </a>
                   </td>
                    <td>" . $dados["dtagd"] . "</td>
                    <td>" . $dados["situ"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }


        return $str;
    }

    /**
     * Listagem dos pedidos de estoque em processamento e em transito
     * @return type
     */
    public function listPedidos() {
        $str = "";

        $consulta = "SELECT cb.cod cod,
                            cb.nomeped,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) nomeforn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) nomecli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome)
                               FROM getar_projetos pj,
                                    getar_pedidos pd
                              WHERE pj.cod = pd.codproj
                                    AND pd.cod = cb.nmproj) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.marca, ' - ', eq.modelo)
                               FROM ordem od, equipo eq
                              WHERE od.cod = cb.ospro
                                AND od.codeqp = eq.cod) equipo,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            cb.tipo,
                            cb.situ
                       FROM estpedidocab cb
                       WHERE cb.situ IN ('processamento', 'transito', 'pago')
                       ORDER BY cb.tipo ASC";# IN ('processamento', 'transito', 'pago', 'estudo')
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Pedido Processamento/Transito</caption>
        <thead>
            <tr>
                <th>C&oacute;digo</th>
                <th>Fornecedor</th>
                <th>Cliente</th>
                <th>Objetivo</th>
                <th>Qtd. Itens</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . "(" . $dados['nomeped'] . ")" . "</th>";
                if ($dados['situ'] == "estudo"){
                    $situ= "orcamento";
                }  else {
                    $situ=  $dados['situ'];
                }
                
                $str.="    <td>" . $dados['nomeforn'] . "(" . $dados['tipo'] . "-" .$situ . ")" . "
                        <a href=\"index.php?st=pedido&pag=ped_edit&codped=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\" alt=\"\">
                        </a>
                        <a href=\"index.php?st=pedido&pag=ped_ldetal&codped=" . $dados['cod'] . "\">
                            <img src=\"imagens/livro.gif\" border=\"0\" alt=\"\">
                        </a>
                    </td>
                    <td>" . $dados['nomecli'] . "</td>
                    <td>";
                if ($dados['projeto']) {
                    $str.= $dados['projeto'];
                } elseif ($dados['equipo']) {
                    $str.= $dados['equipo'];
                }
                if ((!$dados['projeto']) && (!$dados['equipo'])) {
                    $str.= "Pedido de Reposi&ccedil;&atilde;o";
                }
                $str.="</td>
                    <td>" . $dados["qtitens"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem das tarefas de projetos eletronicos
     * @return <string> $str
     */
    public function listTarEletro() {
        $str = "";

        $consulta = "SELECT tar.cod cod,
                            proj.nome proj,
                            ped.titulo ped,
                            'andamento' situ
                       FROM eletro_tarefas tar,
                            eletro_pedidos ped,
                            eletro_projetos proj
                      WHERE tar.codped = ped.cod
                            AND ped.codproj = proj.cod
                            AND tar.situacao = 'a'
                            AND tar.resp = '" . $this->get_resp() . "'";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Listagem Eletro Tarefas em Aberto</caption>
        <thead>
            <tr>
                <th>C&oacute;digo</th>
                <th>Projeto</th>
                <th class=\"pmobil\">Titulo Pedido</th>
                <th class=\"pmobil\">Situa&ccedil;&atilde;o</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . "</th>
                    <td>" . $dados['proj'] . "
                        <a href=\"index.php?st=tarf_eletro&ft=pre&pag=edit&codTarefa=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\" alt=\"\">
                        </a>
                    </td>
                    <td class=\"pmobil\">" . $dados['ped'] . "</td>
                    <td class=\"pmobil\">" . $dados["situ"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem das tarefas de proj programacao em aberto
     * @return type
     */
    public function listTarPro() {
        $str = "";

        $consulta = "SELECT  tar.cod AS cod,
                             proj.nome AS proj,
                             ped.titulo AS ped,
                             'andamento' AS situ
                       FROM getar_tarefas tar,
                            getar_pedidos ped,
                            getar_projetos proj
                      WHERE tar.codped = ped.cod
                            AND ped.codproj = proj.cod
                            AND tar.situacao = 'andamento'
                            AND tar.resp  = '" . $this->get_resp() . "'";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Tarefas em Aberto</caption>
        <thead>
            <tr>
                <th>C&oacute;digo</th>
                <th>Projeto</th>
                <th class=\"pmobil\">Titulo Pedido</th>
                <th class=\"pmobil\">Situa&ccedil;&atilde;o</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . "</th>
                    <td>" . $dados['proj'] . "
                       <a href=\"index.php?st=tarefas&ft=prp&pag=edit&codTarefa=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\" alt=\"\">
                        </a>
                    </td>
                    <td class=\"pmobil\">" . $dados['ped'] . "</td>
                    <td class=\"pmobil\">" . $dados["situ"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem de tarefas abertas na OSs
     * @return type
     */
    public function listTarOS() {
        $str = "";

        $consulta = "SELECT trf.cod codtarf,
                            trf.codos,
                            (SELECT nome FROM getar_cad cad WHERE ord.codcli = cad.cod) nome,
                            eqp.descr,
                            eqp.marca,
                            eqp.modelo,
                            # ---,
                            trf.situ,
                            trf.tecn
                       FROM ordem_tarf trf,
                            ordem ord,
                            equipo eqp
                      WHERE trf.codos = ord.cod
                            AND ord.codeqp = eqp.cod
                            AND trf.situ = 'andamento'
                            AND trf.tecn= '" . $this->get_resp() . "'";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Tarefas em Aberto nas OS</caption>
        <thead>
            <tr>
                <th>C&oacute;digo</th>
                <th>Equipamento</th>
                <th>Marca/Modelo</th>
                <th>Cliente</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['codtarf'] . "</th>
                    <td>" . $dados['descr'] . "
                       <a href=\"index.php?st=ordm&ft=mens&pag=edit&codos=" . $dados['codos'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\" alt=\"\">
                        </a>
                    </td>
                    <td>" . $dados['marca'] . " - " . $dados['modelo'] . "</td>
                    <td>" . $dados["nome"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem de Tarefas mal finalizadas nas OSs
     * @return string
     */
    public function listTarErro(){
        $str = "";

        $consulta = "SELECT ord.cod codos,
                            trf.cod codtarf,
                            CASE
                                WHEN DATE_FORMAT(trf.horafim, '%H:%i') = '00:00' THEN 'ERRO'
                                WHEN DATE_FORMAT(trf.horafim, '%H:%i') <> '00:00' THEN 'OK'
                            END horafim
                       FROM ordem_tarf trf,
                            ordem ord
                      WHERE ord.cod = trf.codos
                            AND ord.situ IN('aberta', 'espera')
                            AND trf.situ = 'concluida'
                            AND DATE_FORMAT(trf.horafim, '%H:%i') = '00:00'
                            AND trf.tecn= '" . $this->get_resp() . "'";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Tarefas Mal Finalizadas nas OS</caption>
        <thead>
            <tr>
                <th>C&oacute;digo</th>
                <th>OS</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['codtarf'] . "</th>
                    <td>" . $dados['codos'] . "
                       <a href=\"index.php?st=ordm&pag=edit&codos=" . $dados['codos'] . "&codtarf=" . $dados['codtarf'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\" alt=\"\">
                        </a>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * monta listagem de pedidos de programacao em andamento e vencidos
     * @return string
     */
    public function listPedProg() {
        $str = "";

        $consulta = "SELECT pedido.cod,
                            projeto.tag,
                            projeto.nome,
                            projeto.cod codproj,
                            DATE_FORMAT(pedido.dataini, '%d/%m/%Y') dataini,
                            CASE
                                WHEN pedido.prior = 'urgente' THEN 'Urgente'
                                WHEN pedido.prior = 'alta' THEN 'Alta'
                                WHEN `prior` = 'media' THEN 'M&eacute;dia'
                                WHEN `prior` = 'baixa' THEN 'Baixa'
                            END prioridade,
                            pedido.titulo,
                            pedido.situacao,
                            CASE 
                                WHEN pedido.situacao = 'espera' THEN 'Espera'
                                WHEN pedido.situacao = 'estudo' THEN 'Estudos'
                                WHEN pedido.situacao = 'andamento' THEN 'Andamento'
                                WHEN pedido.situacao = 'concluido' THEN 'Conclu&iacute;do'
                                WHEN pedido.situacao = 'fechado' THEN 'Fechado'
                                WHEN pedido.situacao = 'negociacao' THEN 'Negocia&ccedil;&atilde;o'
                                WHEN pedido.situacao = 'cancelado' THEN 'Cancelado'
                            END as situacao,
                            CASE
                                WHEN pedido.dataclc < CURDATE() THEN 'vencido'
                                WHEN pedido.dataini <= CURDATE() THEN 'aberto'
                            END status
                       FROM getar_pedidos  AS pedido,
                            getar_projetos AS projeto
                      WHERE pedido.situacao NOT IN( 'concluido', 'estudo', 'cancelado', 'espera')
                            AND projeto.situacao != 'fechado'
                            AND projeto.cod = pedido.codproj
                            AND (pedido.dataclc < CURDATE() OR pedido.dataini <= CURDATE())
                            # Especifica para SAB Telecom que esta trabalhando com a versao antiga do Operacional
                            AND projeto.cod NOT IN(64, 104)# compativel versao antiga
                            AND pedido.resp = '" . $this->get_resp() . "'
                   ORDER BY situacao, prior, dataini ";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Seus Pedidos Agendados</caption>
        <thead>
            <tr>
                <th>C&oacute;d/tag</th>
                <th>Projeto</th>
                <th class=\"pmobil\">Titulo Pedido</th>
                <th class=\"pmobil\">Prioridade</th>
                <th class=\"pmobil\">Data In&iacute;cio</th>
                <th class=\"pmobil\">Situa&ccedil;&atilde;o</th>
                <th class=\"pmobil\">Agendamento</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $style = "";
                if ($dados['status'] == "vencido") {
                    $style = "style=\"color: red; \"";
                }
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . " - " . $dados['tag'] . "</th>
                    <th " . $style . ">" . $dados['nome'] . "</th>
                    <td class=\"pmobil\" " . $style . "\">" . $dados['titulo'] . "
                        <a href=\"index.php?st=pedidos&ft=prp&pag=edit&codped=" . $dados['cod'] . "&codproj=" . $dados['codproj'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"Edita\" style=\"width: 16px;\" title=\"Edita pedido\">
                        </a>
                        <a href=\"index.php?st=tarefas&ft=prp&pag=list_all&codped=" . $dados['cod'] . "\">
                            <img src=\"imagens/lista.jpg\" alt=\"Lista\" style=\"width: 16px;\" title=\"Lista tarefas do pedido\">
                        </a>
                    </td>
                    <td class=\"pmobil\" " . $style . ">" . $dados["prioridade"] . "</td>
                    <td class=\"pmobil\" " . $style . ">" . $dados['dataini'] . "</td>
                    <td class=\"pmobil\" " . $style . ">" . $dados["situacao"] . "</td>
                    <td " . $style . ">" . $dados['status'] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem de atividade operacionais
     * @author Paulo Regis <paulo_schw@yahoo.com.br>
     * @abstract Baseando na versao antiga ainda usando tabelas dos projetos
     * @return string
     */
    public function listOperaOld() {
        $str = "";

        $consulta = "SELECT pedido.cod,
                            projeto.tag,
                            projeto.nome,
                            projeto.cod codproj,
                            DATE_FORMAT(pedido.dataini, '%d/%m/%Y') dataini,
                            CASE
                                WHEN pedido.prior = 'urgente' THEN 'Urgente'
                                WHEN pedido.prior = 'alta' THEN 'Alta'
                                WHEN `prior` = 'media' THEN 'M&eacute;dia'
                                WHEN `prior` = 'baixa' THEN 'Baixa'
                            END prioridade,
                            pedido.titulo,
                            pedido.situacao
                       FROM getar_pedidos  AS pedido,
                            getar_projetos AS projeto
                      WHERE pedido.situacao NOT IN( 'concluido', 'estudo', 'cancelado', 'espera')
                            AND projeto.situacao != 'fechado'
                            AND projeto.cod = pedido.codproj
                            AND (pedido.dataclc < CURDATE() OR pedido.dataini <= CURDATE())
                            # Especifica para SAB Telecom que esta trabalhando com a versao antiga do Operacional
                            AND projeto.cod IN(64, 104)# compativel versao antiga
                            AND pedido.resp = '" . $this->get_resp() . "'
                   ORDER BY situacao, prior, dataini ";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Atividades Operacionais (Versao Antiga)</caption>
        <thead>
            <tr>
                <th>C&oacute;d/tag</th>
                <th>Projeto</th>
                <th>Titulo Pedido</th>
                <th>Prioridade</th>
                <th>Data In&iacute;cio</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . " - " . $dados['tag'] . "</th>
                    <th>" . $dados['nome'] . "</th>
                    <td>" . $dados['titulo'] . "
                        <a href=\"index.php?st=pedidos&ft=prp&pag=edit&codped=" . $dados['cod'] . "&codproj=" . $dados['codproj'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"Edita\" style=\"width: 16px;\" title=\"Edita pedido\">
                        </a>
                        <a href=\"index.php?st=tarefas&ft=prp&pag=list_all&codped=" . $dados['cod'] . "\">
                            <img src=\"imagens/lista.jpg\" alt=\"Lista\" style=\"width: 16px;\" title=\"Lista tarefas do pedido\">
                        </a>
                    </td>
                    <td>" . $dados["prioridade"] . "</td>
                    <td>" . $dados['dataini'] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem de atividade operacionais
     * @author Paulo Regis <paulo_schw@yahoo.com.br>
     * @abstract Baseando na versao antiga ainda usando tabelas dos projetos
     * @return string
     */
    public function listOpera() {
        $str = "";

        $consulta = "SELECT opr.cod,
                            opr.tag,
                            opr.nome,
                            opr.resp,
                            opr.situacao
                       FROM getar_opera AS opr
                      WHERE opr.situacao = 'ativo'
                            AND opr.resp = '" . $this->get_resp() . "'";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Atividades Operacionais</caption>
        <thead>
            <tr>
                <th>C&oacute;d/tag</th>
                <th>Projeto</th>
                <th>resp</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . " - " . $dados['tag'] . "</th>
                    <td>" . $dados['nome'] . "
                        <a href=\"index.php?st=opera&pag=edit&codopr=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"Edita\" style=\"width: 16px;\" title=\"Edita pedido\">
                        </a>
                        <a href=\"index.php?st=tarfopera&pag=list&codoper=" . $dados['cod'] . "\">
                            <img src=\"imagens/lista.jpg\" alt=\"Lista\" style=\"width: 16px;\" title=\"Lista tarefas do pedido\">
                        </a>
                    </th>
                    <td>" . $dados["resp"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    public function listTarfOpera() {
        $str = "";

        $consulta = "SELECT tar.cod AS cod,
                            opr.nome AS nome,
                            'andamento' AS situ
                       FROM getar_tarfopera tar,
                            getar_opera opr
                      WHERE tar.codopera = opr.cod
                            AND tar.situacao = 'andamento'
                            AND tar.resp  ='" . $_SESSION['resp'] . "'";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Tarefas em Andamento nas Atividades Operacionais</caption>
        <thead>
            <tr>
                <th>C&oacute;digo</th>
                <th>Nome</th>
                <th>Situa&ccedil;&atilde;o</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . "</th>
                    <td>" . $dados['nome'] . "
                       <a href=\"index.php?st=tarfopera&pag=edit&codTarefa=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\" alt=\"\">
                        </a>
                    </td>
                    <td class=\"pmobil\">" . $dados["situ"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem rapida de pedidos eletronico
     * @return type
     */
    public function listPedEletro() {
        $str = "";

        $consulta = "SELECT pedido.cod,
                            projeto.nome,
                            DATE_FORMAT(pedido.dataini, '%d/%m/%Y') dataini,
                            pedido.titulo,
                            CASE
                                WHEN pedido.dataclc < CURDATE() THEN 'vencido'
                                WHEN pedido.dataini <= CURDATE() THEN 'aberto'
                                ELSE pedido.situacao
                            END situ
                       FROM eletro_pedidos AS pedido, 
                            eletro_projetos AS projeto
                      WHERE pedido.situacao NOT IN( 'c', 't', 'x', 'e')
                            AND projeto.situacao != 'f'
                            AND projeto.cod = pedido.codproj
                            AND (pedido.dataclc < CURDATE() OR pedido.dataini <= CURDATE())
                            AND pedido.resp = '" . $this->get_resp() . "'
                   ORDER BY situ";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
        <caption>Pedidos Eletr&ocirc;nicos Agendados</caption>
        <thead>
            <tr>
                <th>C&oacute;digo</th>
                <th>Projeto</th>
                <th class=\"pmobil\">T&iacute;tulo Pedido</th>
                <th class=\"pmobil\">Data In&iacute;cio</th>
                <th class=\"pmobil\">Situa&ccedil;&atilde;o</th>
            </tr>
        </thead>
        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $style = "";
                if ($dados['situ'] == "vencido") {
                    $style = "style=\"color: red; \"";
                }
                $str .= "
                <tr class=\"" . corLinha() . "\">
                    <th " . $style . ">" . $dados['cod'] . "</th>
                    <th " . $style . ">" . $dados['nome'] . "</th>
                    <td " . $style . ">" . $dados['titulo'] . "
                        <a href=\"index.php?st=ped_eletro&ft=pre&pag=edit&codped=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" title=\"Edita Pedito\" style=\"width: 16px;\">
                        </a>
                        <a href=\"index.php?st=tarf_eletro&ft=pre&pag=list_all&codped=" . $dados['cod'] . "\">
                            <img src=\"imagens/lista.jpg\" alt=\"\" title=\"Lista Tarefas do Pedido\" style=\"width: 16px;\">
                        </a>
                    </td>
                    <td class=\"pmobil\" " . $style . ">" . $dados['dataini'] . "</td>
                    <td class=\"pmobil\" " . $style . ">" . $dados["situ"] . "</td>
                </tr>";
            }
            $str .= "</tbody>
              </table>";
        }

        return $str;
    }

    /**
     * Listagem das OS eletronicas em aberto
     * @return type
     */
    public function listOS() {
        $str = "";

        $consulta = "SELECT ord.cod AS cod,
                            (SELECT nome FROM getar_cad WHERE cod= ord.codcli) cliente,
                            eqp.descr AS descr,
                            CONCAT(eqp.marca, '/', eqp.modelo) AS marca,
                            DATE_FORMAT(ord.entd, '%d/%m/%Y') entd,
                            DATE_FORMAT(ord.inicio, '%d/%m/%Y') inicio,
                            CASE
                                WHEN fila = 0 THEN 9999
                                WHEN fila > 0 THEN fila
                            END fila,
                            (SELECT COUNT(*)+1 nm FROM ordem WHERE fila <ord.fila AND fila NOT IN(0)) ord,
                            ord.retorno,
                            ord.situ
                       FROM ordem ord,
                            equipo eqp
                      WHERE ord.codeqp = eqp.cod
                            AND ord.situ IN('aberta', 'programada')
                            AND ord.inicio <= CURDATE()
                            AND ord.resp = '" . $this->get_resp() . "'
                    ORDER BY fila ASC, inicio DESC, inicio ASC";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $str = "<table width=\"100%\">
                    <caption>OSs Abertas em Programa&ccedil;&atilde;o</caption>
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Descri&ccedil;&atilde;o</th>
                            <th>Cliente</th>
                            <th>Marca/Modelo</th>
                            <th>Fila</th>
                            <th>Data Entrada</th>
                            <th>Data In&iacute;cio</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($dados = $this->arraySQL($resultado)) {
                $str .= "<tr class=\"" . corLinha() . "\">
                            <th>" . $dados['cod'] . "</th>
                            <td>" . $dados['descr'] . "
                                <a href=\"index.php?st=ordm&ft=mens&pag=edit&codos=" . $dados['cod'] . "\">
                                    <img src=\"imagens/editar.gif\" alt=\"Edita\" style=\"width= 16px;\">
                                </a>";

                if ($dados['retorno']) {
                    $str.= "<b style=\"color: red\">RETORNO</b>";
                }
                if ($dados['situ'] == 'programada') {
                    $str.= "<b style=\"color: red\">PROGRAMADA</b>";
                }

                $str.= "    </td>
                            <td>" . $dados['cliente'] . "</td>
                            <td>" . $dados['marca'] . "</td>
                            <td>";
                if ($dados['fila'] == 9999) {
                    $str.= "&nbsp;";
                } else {
                    $str.= $dados['ord'] . "&ordm;";
                }
                $str.= "</td>
                            <td>" . $dados['entd'] . "</td>
                            <td>" . $dados['inicio'] . "</td>"
                        . "</tr>";
            }
            $str.="</tbody></table>";
        }

        return $str;
    }

    /**
     * Imprime o texto de boasvinda
     * @return string
     */
    public function textoBoaVindas() {
        $consulta = "SELECT titulo,
                            intro, 
                            texto,
                            fonte
                       FROM " . $this->get_bdRaiz() . "getar_artg01 txt,
                            " . $this->get_bdRaiz() . "getar_artgch ch
                      WHERE ch.cod = txt.codartg
                            AND ch.nome = 'boasvindas'";
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);

        $str = "<div id=\"intro\">" . $dados['intro'] . "</div>
            <br style=\"clear: both;\" />
            <div id=\"conteudo\">" . devolve_texto($dados['texto']) . "</div>
            <div id=\"fonte\">Fonte: " . $dados['fonte'] . "</div>";

        return $str;
    }

}

?>
