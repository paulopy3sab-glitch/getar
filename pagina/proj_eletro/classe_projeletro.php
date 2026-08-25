<?php

/**
 * Descricao:
 * Metodos de apoio a Projetos de Programacao
 *
 * @author Paulo
 * Data de criacao: junho/2016
 * Revisao: pregis 28/08/2016
 *   recriacao baseada na classe_projprog devida a mudanca de ideia, antes se 
 * estudava reaporveitar o maximo possivel usando os mesmo arquivos para projetos
 * de programacao e eletronicos. Nao eh possivel pois as semelhancas sao poucas.
 * Mas continua a ideia de prefixo [e]
 */
class Projeletro extends Conex {

    use Tprecons;

    private $acao;
    private $msg;
    // Para os projeto
    private $codProj;
    private $nomeProj;
    private $codCliente;
    private $descrProj;
    private $situProj;
    // Para os pedido
    private $codPed;
    private $tituPed;
    private $situPed;
    private $dataReg;
    private $priorPed;
    private $dataIni;
    private $dataClc;
    private $fatuPed;
    private $docPed;
    //para as tarefas
    private $codTarf;
    private $respTarf;
    private $situTarf;
    private $dataTarf;
    private $horaIni;
    private $horaFim;
    private $fatuTarf;
    private $docTarf;

    public function __construct() {
        parent::__construct();
    }

    function set_codProj($novo_codProj) {
        $this->codProj = $novo_codProj;

        $consulta = "SELECT nome FROM eletro_projetos WHERE cod =" . $this->codProj;
        $dados = $this->consultaSQL($consulta);
        $this->set_nomeProj($dados['nome']);
    }

    function get_codProj() {
        return $this->codProj;
    }

    function set_nomeProj($novo_nome) {
        $this->nomeProj = $novo_nome;
    }

    function get_nomeProj() {
        return $this->nomeProj;
    }

    /**
     * Fixado tambem o codigo do projeto, nome do projeto e o titulo do pedido
     * @param type $novo_codPed
     */
    function set_codPed($novo_codPed) {
        $this->codPed = $novo_codPed;

        $consulta = "SELECT proj.nome AS projeto,
                            proj.cod AS codproj,
                            ped.titulo 
                       FROM eletro_pedidos ped,
                            eletro_projetos AS proj
                      WHERE proj.cod= ped.codproj
                            AND ped.cod=" . $this->codPed;
        $dados = $this->consultaSQL($consulta);
        $this->codProj = $dados['codproj'];
        $this->nomeProj = $dados['projeto'];
        $this->tituPed = $dados['titulo'];
    }

    function get_codPed() {
        return $this->codPed;
    }

    function set_tituPed($novo_tituPed) {
        $this->tituPed = $novo_tituPed;
    }

    function get_tituPed() {
        return $this->tituPed;
    }

    function set_codCliente($novo_codCliente) {
        $this->codCliente = $novo_codCliente;
    }

    function get_codCliente() {
        return $this->codCliente;
    }

    function set_descrProj($novo_descr) {
        $this->descrProj = $novo_descr;
    }

    function get_descrProj() {
        return $this->descrProj;
    }

    function set_situProj($novo_situProj) {
        $this->situProj = $novo_situProj;
    }

    function get_situProj() {
        return $this->situProj;
    }

    function set_acao($novo_acao) {
        $this->acao = $novo_acao;
    }

    function get_acao() {
        return $this->acao;
    }

    /**
     * situacao do pedido
     * @param type $novo_situPed
     */
    public function set_situPed($novo_situPed) {
        $this->situPed = $novo_situPed;
    }

    /**
     * prioridade do pedido
     * @param type $novo_priorPed
     */
    public function set_priorPed($novo_priorPed) {
        $this->priorPed = $novo_priorPed;
    }

    /**
     * data do registro do pedido
     * @param type $novo_dataReg
     */
    public function set_dataReg($novo_dataReg) {
        $this->dataReg = $novo_dataReg;
    }

    /**
     * data prevista para inicio do pedido
     * @param type $novo_dataIni
     */
    public function set_dataIni($novo_dataIni) {
        $this->dataIni = $novo_dataIni;
    }

    /**
     * data prevista para conclusao do pedido
     * @param type $novo_dataClc
     */
    public function set_dataClc($novo_dataClc) {
        $this->dataClc = $novo_dataClc;
    }

    /**
     * se faturado ou nao
     * @param type $novo_fatura
     */
    public function set_fatuPed($novo_fatura) {
        $this->fatuPed = $novo_fatura;
    }

    /**
     * documentacao ou descricao do pedido
     * @param type $novo_doc
     */
    public function set_docPed($novo_doc) {
        $this->docPed = $novo_doc;
    }

    /**
     * situacao do pedido
     * @return type
     */
    public function get_situPed() {
        return $this->situPed;
    }

    /**
     * prioridade do pedido
     * @return type
     */
    public function get_priorPed() {
        return $this->priorPed;
    }

    /**
     * data de registro
     * @return type
     */
    public function get_dataReg() {
        return $this->dataReg;
    }

    /**
     * data inicial
     * @return type
     */
    public function get_dataIni() {
        return $this->dataIni;
    }

    /**
     * Data de conclusao
     * @return type
     */
    public function get_dataClc() {
        return $this->dataClc;
    }

    /**
     * faturado ou nao
     * @return type
     */
    public function get_fatuPed() {
        return $this->fatuPed;
    }

    /**
     * Documentacao ou descricao do pedido
     * @return type
     */
    public function get_docPed() {
        return $this->docPed;
    }

    /**
     * coddigo da tarefa
     * @param type $novo_codTarf
     */
    public function set_codTarf($novo_codTarf) {
        $this->codTarf = $novo_codTarf;

        $consulta = "SELECT pj.nome AS nomeproj,
                            pj.cod AS codproj,
                            pd.titulo,
                            pd.cod AS codped
                       FROM eletro_pedidos AS pd,
                            eletro_projetos AS pj,
                            eletro_tarefas AS tr
                      WHERE pj.cod= pd.codproj
                            AND pd.cod= tr.codped
                            AND tr.cod=" . $this->codTarf;
        $dados = $this->consultaSQL($consulta);
        $this->codProj = $dados['codproj'];
        $this->nomeProj = $dados['nomeproj'];
        $this->tituPed = $dados['titulo'];
        $this->codPed = $dados['codped'];
    }

    /**
     * responsavel pela execucao da tarefa
     * @param type $novo_respTarf
     */
    public function set_respTarf($novo_respTarf) {
        $this->respTarf = $novo_respTarf;
    }

    /**
     * status ou situacao da tarefa
     * @param type $novo_situTarf
     */
    public function set_situTarf($novo_situTarf) {
        $this->situTarf = $novo_situTarf;
    }

    /**
     * dia em que foi executada a tarefa
     * @param type $novo_dataTarf
     */
    public function set_dataTarf($novo_dataTarf) {
        $this->dataTarf = $novo_dataTarf;
    }

    /**
     * horaria em que foi iniciada a tarefa
     * @param type $novo_horaIni
     */
    public function set_horaIni($novo_horaIni) {
        $this->horaIni = $novo_horaIni;
    }

    /**
     * horario de finalizacao da tarefa
     * @param type $novo_horaFim
     */
    public function set_horaFim($novo_horaFim) {
        $this->horaFim = $novo_horaFim;
    }

    /**
     * se a tarefa eh ou nao lucrativa
     * @param type $novo_fatuTarf
     */
    public function set_fatuTarf($novo_fatuTarf) {
        $this->fatuTarf = $novo_fatuTarf;
    }

    /**
     * descricao do que foi feito na tarefa
     * @param type $novo_docTarf
     */
    public function set_docTarf($novo_docTarf) {
        $this->docTarf = $novo_docTarf;
    }

    /**
     * coddigo da tarefa
     * @return type
     */
    public function get_codTarf() {
        return $this->codTarf;
    }

    /**
     * responsavel pela execucao da tarefa
     * @return type
     */
    public function get_respTarf() {
        return $this->respTarf;
    }

    /**
     * status da tarefa
     * @return type
     */
    public function get_situTarf() {
        return $this->situTarf;
    }

    /**
     * data de execucao da tarefa
     * @return type
     */
    public function get_dataTarf() {
        return $this->dataTarf;
    }

    /**
     * horario de finalizacao da tarefa
     * @return type
     */
    public function get_horaFim() {
        return $this->horaFim;
    }

    /**
     * horario de inicio da tarefa
     * @return type
     */
    public function get_horaIni() {
        return $this->horaIni;
    }

    /**
     * se eh lucrativa ou nao a tarefa
     * @return type
     */
    public function get_fatuTarf() {
        return $this->fatuTarf;
    }

    /**
     * descricao do que foi feito na tarefa
     * @return type
     */
    public function get_docTarf() {
        return $this->docTarf;
    }

    /**
     * Listagem de projetos de programacao
     * @param type $complemento
     * @param type $acao
     * @return type
     */
    public function projLista($complemento, $acao) {
        $str = "";

        $consulta = $this->proj_cons04($complemento);
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows > 0) {
            $this->set_tituloObjeto($acao);
            $this->set_descrObjeto("Nome Projeto");
            $this->set_cabCol1("Cliente");
            $this->set_cabCol2("Data");
            $this->set_cabCol3("Inicio Descr.");
            $this->set_cabCol4("Status");
            $this->set_st("proj_eletro");
            $this->set_ft("pre");
            $this->set_pag("edit");
            $this->set_tipoCod("codproj");

            $str = $this->montaLista($resultado);
        }

        return $str;
    }

    /**
     * Listagem das tarefas
     * @param type $complemento
     * @return string
     */
    public function tarfLista($complemento) {
        $consulta = "    SELECT cod,
                                resp,
                                doc,
                                date_format(dataexc, '%d/%m/%Y') dia,
                                date_format(horaini, '%k:%i') hora_ini,
                                date_format(horafim, '%k:%i') hora_fim,
                                date_format(SUBTIME(horafim, horaini), '%k:%i') tempotrab,
                                CASE 
                                    WHEN situacao = 'c' THEN 'concluida'
                                    WHEN situacao = 'x' THEN 'cancelada'
                                    WHEN situacao = 'a' THEN 'andamento'
                                END AS situacao
                           FROM eletro_tarefas
                          WHERE situacao != 'temporario'
                                AND codped = " . $this->get_codPed() . "
                                " . $complemento . "
                       ORDER BY cod DESC";
        $resultado = $this->retornoSQL($consulta);
        $row = $this->rowsSQL($resultado);
        if ($row < 1) {
            $str = "N&atilde;o h&aacute; tarefas nesta listagem";
        } else {
            $str = "<table width=\"100%\">
                        <caption>LISTAGEM DE TAREFAS</caption>
                        <thead>
                            <tr>
                                <th>C&oacute;digo</th>
                                <th>Respons&aacute;vel</th>
                                <th>Data</th>
                                <th>Hora In&iacute;cio</th>
                                <th>Situa&ccedil;&atilde;o</th>
                                <th>Duracao</th>
                                <th>Inc&iacute;cio Descri&ccedil;&atilde;o</th>
                            </tr>
                        </thead>
                        <tbody>";
            while ($dados = arraySQL($resultado)) {
                $style = "";
                if ($dados["situacao"] == "cancelada") {
                    $style = " style=\"text-decoration:line-through;\"";
                }
                $str .= "
                <tr " . $style . " class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . "</th>
                    <td>" . $dados['resp'];

                if ($dados['situacao'] != "concluida") {
                    //  Para nao poder editar ou excluir tarefas concluidas
                    $str .= "
                            <a href=\"index.php?st=tarf_eletro&ft=pre&pag=edit&codTarefa=" . $dados['cod'] . "\">
                                <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                            </a>";
                } else {
                    $str .= "
                            <a href=\"index.php?st=tarf_eletro&ft=pre&pag=detalhar&codTarefa=" . $dados['cod'] . "\">
                                <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                            </a>";
                }
                $str .= "
                    </td>
                    <td>" . $dados['dia'] . "</td>
                    <td>" . $dados['hora_ini'] . "</td>
                    <td>" . $dados["situacao"] . "</td>
                    <td>" . $dados['tempotrab'] . "&nbsp;</td>
                    <td>
                        <textarea cols=\"80\" rows=\"4\" class=\"txt\">" . $dados["doc"] . "</textarea>
                    </td>
                </tr>";
            };
            $consulta = " SELECT SUM((TIME_TO_SEC(horafim) - TIME_TO_SEC(horaini))) tempo
                            FROM eletro_tarefas
                           WHERE situacao NOT IN('x', 'temporario')
                                 AND codped = '" . $this->get_codPed() . "'
                                 " . $complemento;
            $dados = $this->consultaSQL($consulta);
            $tempo = $dados['tempo'];
            $hora = floor($tempo / 3600);
            $minuto = round(($tempo / 60) % 60, 2);
            $str .= "
            <tr>
                <td colspan=\"6\" class=\"sub-titulo\" align=\"right\">
                    Total horas trabalhadas: </td>
                <td class=\"sub-titulo\">
                    <b>" . $hora . ":" . $minuto . "</b>
                </td>
            </tr>
        </tbody>
    </table>";
        }

        return $str;
    }

    /**
     * opcoes de rodape para as tarefas
     * @return string
     */
    public function tarfOpcoes() {
        $str = "<div id=\"opcoes\">
                <div id=\"elemento\">";
        $consulta = "SELECT situacao FROM getar_pedidos WHERE cod='" . $this->get_codPed() . "'";
        $dados = $this->consultaSQL($consulta);
        if ($dados["situacao"] != "x") {
            $str .= "
            <a href=\"index.php?st=tarf_eletro&ft=pre&pag=edit&codped=" . $this->get_codPed() . "\" accesskey=\"n\">
                <img src=\"imagens/novo.jpg\" style=\"width: 32px;\" alt=\"Tarefa Nova\" title=\"Criar Nova Tarefa\"><br>
                Tarefa Nova.
            </a>";
        } else {
            $str .= "Pedido Cancelado";
        }

        $str .= "</div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=ped_eletro&ft=pre&pag=list_atv&codproj=" . $this->get_codProj() . "\">
                        <img src=\"imagens/livro.gif\" alt=\"Listar Pedidos\" style=\"width: 32px;\" title=\"Listar Pedidos Ativos do Projeto\"><br>
                        Listar Pedidos
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=tarf_eletro&ft=pre&pag=list&codped=" . $this->get_codPed() . "\">
                        <img src=\"imagens/livro.gif\" alt=\"\"  style=\"width: 32px;\" title=\"0\"><br>
                        Listar Suas Tarefas em Andamento
                    </a>
                </div>
                <div id=\"elementoAdmin\">";
// so para Engenheiro/Tecnico
        if (atrib("42")) {
            $str .= "<div id=\"elemento\">
                        <a href=\"index.php?st=tarf_eletro&ft=pre&pag=list_adm&codped=" . $this->get_codPed() . "\">
                            <img src=\"imagens/livro.gif\" alt=\"Listar Tarefas\" style=\"width: 32px;\" title=\"Listar Todos Tarefas N&iacute;vel Administrador\"><br>
                            Listar Tarefas
                        </a>
                    </div>";
        }
        $str .= "
            </div>
            <div id=\"elemento\">
                <a href=\"index.php?st=tarf_eletro&ft=pre&pag=list_all&codped=" . $this->get_codped() . "\">
                    <img src=\"imagens/livro.gif\" alt=\"\" style=\"width: 32px;\" title=\"Listar Todas Suas Tarefas\"><br>
                    Listar Todas
                </a>
            </div>
        </div>";

        return $str;
    }

    /**
     * Salva alteracoes no projeto
     */
    function projSalvar() {
        $consulta = "UPDATE eletro_projetos SET
                           nome='" . $this->get_nomeProj() . "',
                           cliente='" . $this->get_codCliente() . "',
                           descr='" . $this->get_descrProj() . "',
                           situacao='" . $this->get_situProj() . "'
                     WHERE cod= " . $this->get_codProj();
        $this->msg = $this->executaSQL($consulta);
        //$this->msg = $this->executaSQL($this->proj_Cons05());
    }

    /**
     * salvar alteracoes em pedidos
     */
    function pedSalvar() {

        $consulta = "UPDATE eletro_pedidos SET resp='" . $this->get_resp() . "',
                            titulo='" . $this->get_tituPed() . "',
                            situacao='" . $this->get_situPed() . "',
                            prioridade='" . $this->get_priorPed() . "',
                            fatu = '" . $this->get_fatuPed() . "',
                            dataini='" . $this->get_dataIni() . "',
                            dataclc='" . $this->get_dataClc() . "',
                            doc='" . $this->get_docPed() . "'
                            WHERE cod=" . $this->get_codPed();
        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * salva as alteracoes nas tarefas
     * @return string
     */
    public function tarfSalvar() {
        //Verificacoes
        if ($this->get_situTarf() == "c" && $this->get_horaFim() == "0:00") {
            $horafim = "CURTIME()";
        } else {
            $horafim = "'" . $this->get_horaFim() . "'";
        }

        $consulta = "UPDATE eletro_tarefas SET
                            horaini= '" . $this->get_horaIni() . "',
                            horafim= " . $horafim . ",
                            resp= '" . $this->get_respTarf() . "',
                            doc= '" . $this->get_docTarf() . "',
                            situacao= '" . $this->get_situTarf() . "'
                      WHERE cod= " . $this->get_codTarf();

        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * switch case para as listagens dos projetos
     * @param type $pag
     * @return string
     */
    public function projSwitch($pag) {
        $complemento = "";
        switch ($pag) {
            case 'edit':
                $complemento = " AND cod= " . $this->codProj;
                $acao = " Projeto em Foco";
                break;
            case 'detal':
                $complemento = " AND cod= " . $this->codProj;
                $acao = " Projeto em Foco";
                break;
            case 'list':
                $complemento = " AND situacao NOT IN('temporario', 'f', 'x') ORDER BY nome ASC";
                $acao = "Projetos em Andamento";
                break;
            case 'list_est':
                $complemento = " AND situacao = 'e' ORDER BY nome ASC";
                $acao = "Projeto em estudos";
                break;
            case 'list_u':
                $complemento = " ORDER BY cod DESC";
                $acao = "Ultimos Projetos";
                break;
            case 'list_all':
                $complemento = " ORDER BY cod ASC";
                $acao = " Novo";
                break;
            case 'list_pesq':
                $complemento = " AND nome LIKE '" . $_REQUEST['string'] . "%' ORDER BY nome ASC";
                $acao = " Novo";
                break;
            case 'listped':
                $complemento = " AND cod= " . $this->codProj;
                $acao = " Projeto em Foco";
                break;
        }

        return $complemento;
    }

    /**
     * switch case para listagem dos pedidos
     * @param type $pag
     * @return string
     */
    function pedSwitch($pag) {
        switch ($pag) {
            case 'edit':
                $complemento = " AND codproj= " . $this->get_codProj() . " 
                                 AND cod= " . $this->get_codPed();
                break;
            case 'list_atv':
                $complemento = " AND situacao IN('a', 'e')   
                                 AND codproj= " . $this->get_codProj();
                break;
            case 'list_proj':
                $complemento = " AND codproj= " . $this->get_codProj();
                break;
            case 'list':
                $complemento = " AND resp = '" . $this->get_resp() . "'  
                                 AND codproj= " . $this->get_codProj();
                break;
            case 'list_user':
                $complemento = " AND situacao IN('a', 'e')   
                                 AND resp = '" . $this->get_resp() . "'  ";
                break;
            case 'list_and':
                $complemento = "AND codproj= " . $this->get_codProj() . " 
                                AND resp = '" . $this->get_resp() . "'
                                AND situacao = 'a'";
                break;
            case 'list_all':
                $complemento = "";
                break;
            default :
                $complemento = " ";
        }
        return $complemento;
    }

    public function tarfSwitch($pag) {
        $complemento = "";
        switch ($pag) {
            case 'edit':
                //echo $this->tarfEdit();
                break;
            case 'detalhar':
                // echo $this->tarfDetal();
                break;
            case 'list':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                         AND status = 'a' ";
                break;
            case 'list_all':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'";
                break;
            case 'list_adm':
                $complemento = " ";
                break;
        }
    }

    /**
     * detalhar um projeto sem opcoes de edicao
     * @return string
     */
    function projDetal() {
        $consulta = "SELECT nome,
                        SUBSTRING((SELECT nome FROM getar_cad WHERE cod= cliente ), 1, 20) AS cliente,
                        descr,
                        DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                        CASE
                            WHEN situacao = 'n' THEN 'negociacao'
                            WHEN situacao = 'e' THEN 'em estudos'
                            WHEN situacao = 's' THEN 'em espera'
                            WHEN situacao = 'a' THEN 'em andamento'
                            WHEN situacao = 'f' THEN 'fechado'
                            WHEN situacao = 'x' THEN 'cancelado'
                        END situacao
                   FROM getar_projetos
                  WHERE cod= " . $this->codProj;
        $dados = consultaSQL($consulta);

        $str = "<fieldset>
              <legend>Dados do Projeto</legend>
              <label>C&oacute;digo: </label><b>" . $this->codProj . "</b><br>
              <label>Nome: </label><b>" . $dados['nome'] . "</b><br>
              <label>Cliente: </label><b>" . $dados['cliente'] . "</b><br>
              <label>Descri&ccedil;&atilde;o:</label><textarea name=\"descr\" cols=\"60\" rows=\"3\" readonly=\"\">" . $dados["descr"] . "</textarea><br>
              <label>Data Registro: </label><b>" . $dados["datareg"] . "</b><br>
              <label>Situa&ccedil;&atilde;o: </labe><b>" . $dados["situacao"] . "</b>
          </fieldset>";

        return $str;
    }

    public function tarfDetal() {
        $consulta = "SELECT date_format(data, '%d/%m/%Y') dia,
                                date_format(horaini, '%k:%i') hora_ini,
                                date_format(horafim, '%k:%i') hora_fim,
                                doc,
                                resp,
                                pedido,
                                CASE
                                    WHEN fatura THEN 'sim'
                                    ELSE 'nao'
                                END fatu,
                                CASE 
                                     WHEN status = 'c' THEN 'concluido'
                                     WHEN status = 't' THEN 'andamento'
                                     WHEN status = 'a' THEN 'andamento'
                                END as st
                           FROM getar_tarefas
                          WHERE cod=" . $this->get_codTarf();
        $dados = $this->consultaSQL($consulta);

        $str = "<fieldset>
                <legend>Dados do Projeto</legend>
                <label>C&oacute;digo: </label><b>" . $this->get_codTarf() . "</b><br>
                <label>Respons&aacute;vel :</label><b>" . $dados['resp'] . "</b><br>
                <label>Data: </label><b>" . $dados['dia'] . "</b><br>
                <label>Hora In&iacute;cio: </label><b>" . $dados['hora_ini'] . "</b><br>
                <label>Hora Fim: </label><b>" . $dados['hora_fim'] . "</b><br>
                <label>documenta&ccedil;&atilde;o: </label><textarea cols='80' rows='5' readonly='readonly'>" . $dados['doc'] . "</textarea><br>
                <label>Status: </label><b>" . $dados['st'] . "</b><br>
                <label>Tarifada: </label><b>" . $dados['fatu'] . "</b><br>
            </fieldset>";

        return $str;
    }

    /**
     * Edita ou cria um projeto novo
     * @return string
     */
    function projEdit() {
        if ($this->codProj == "") {
            //Cria o temporario
            $consulta = "INSERT INTO eletro_projetos (cod, nome, datareg, cliente, situacao)
                                           VALUES('', 'Projeto Novo', CURDATE(), 2, 'temporario')";
            $this->msg = $this->executaIdSQL($consulta);
            $codProj = $this->get_idRet();
            $this->set_codProj($codProj);
        }

        //  Carrega para edicao
        $consulta = "SELECT proj.nome nmproj,
                            proj.cliente codcli,
                            cad.nome,
                            proj.descr,
                            DATE_FORMAT(proj.datareg, '%d/%m/%Y') datareg,
                            proj.situacao
                       FROM eletro_projetos proj,
                            getar_cad cad
                      WHERE proj.cliente = cad.cod
                            AND proj.cod= " . $this->codProj;
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);

        $str = "<form action='index.php?st=proj_eletro&ft=pre&pag=edit&codproj=" . $this->codProj . "' method='post'>
                <input name='codproj' type='hidden' value='" . $this->codProj . "'>
            <fieldset>
                <legend>Dados do Projeto Eletr&ocirc;nico</legend>
                <label>C&oacute;digo :</label><b>" . $this->codProj . "</b><br>
                <label>Nome: </label><input name='nome' type='text' size='42' maxlength='40' value=\"" . $dados["nmproj"] . "\"><br>
                <label>Cliente:</label>";
        if ($dados['situacao'] == "temporario") {
            $str .= $this->selectCliente($dados['codcli']) . "<br>";
        } else {
            $str .= "<b>" . $dados['nome'] . "</b>
                    <input type='hidden' name='codCliente' value='" . $dados["codcli"] . "'>
                    <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $dados["codcli"] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este registro\">
                    </a><br />";
        }
        $str .= "<label>Descri&ccedil&atilde;o: </label><textarea name=\"descr\" cols=\"40\" rows=\"3\">" . $dados["descr"] . "</textarea><br>
                <label>Data Registro: </label><b>" . $dados["datareg"] . "</b><br>
                <label>Situa&ccedil;&atilde;o: </label>" . $this->projSitu($dados['situacao']) . "<br>
                <label>&nbsp;</label><input type='submit' name='salvar' value='Salvar'><br>
                " . $this->msg . "
            </fieldset></form>";

        return $str;
    }

    /**
     * Select da situacao do projeto
     * @param type $situ
     * @return string
     */
    public function projSitu($situ) {
        $str = "<select name=\"situacao\">
                    <option value=\"n\" " . $this->selectedIf($situ, "n") . ">em negocia&ccedil;&atilde;o</option>
                    <option value=\"e\" " . $this->selectedIf($situ, "e") . ">em estudos</option>
                    <option value=\"s\" " . $this->selectedIf($situ, "s") . ">em espera</option>
                    <option value=\"a\" " . $this->selectedIf($situ, "a") . ">em andamento</option>
                    <option value=\"f\" " . $this->selectedIf($situ, "f") . ">fechado</option>
                    <option value=\"x\" " . $this->selectedIf($situ, "x") . ">cancelado</option>
                </select>";

        return $str;
    }

    /**
     * Cria e edita um pedido para um projeto
     * @return string
     */
    function pedEdit() {

        //inserindo pedido temporario
        if ($this->get_codPed() == "") {
            $consulta = $this->proj_cons02($this->get_codProj());
            $this->msg = $this->executaIdSQL($consulta);
            $this->set_codPed($this->get_idRet());
        }

        $consulta = $this->proj_cons06($this->get_codPed());
        $dados = $this->consultaSQL($consulta);

        $str = "<form name=\"formulario\" action=\"index.php?st=ped_eletro&ft=pre&pag=edit&codped=" . $this->get_codPed() . "&codproj=" . $this->get_codProj() . "\" method=\"post\" onsubmit=\"return validaFormPed();\">
        <input name=\"codped\" type=\"hidden\" value=\"" . $this->get_codPed() . "\">
        <input name=\"codproj\" type=\"hidden\" value=\"" . $this->get_codProj() . "\">
        <fieldset>
            <legend>Detalhes do Pedido</legend>
            <label>C&oacute;digo: </label><b>" . $this->get_codPed() . "</b><br>
            <label for=\"titulo\">T&iacute;tulo:</label>
            <input name=\"titulo\" type=\"text\" value=\"" . $dados["titulo"] . "\" size=\"60\" maxlength=\"60\"><br>
            <label>Respons&aacute;vel: </label>" . $this->selectResp($dados['resp'], '41') . "<br>
            <label>Data Registro</label>: <b>" . $dados["datareg"] . "</b><br>
            <label>Data In&iacute;cio: </label>";
        if ($dados["dataini"] == "") {
            $dados["dataini"] = date('Y-m-d');
        }
        $diaIni = date('d', strtotime($dados["dataini"]));
        $mesIni = date('m', strtotime($dados["dataini"]));
        $anoIni = date('Y', strtotime($dados["dataini"]));
        $str .= selectData("ini", $diaIni, $mesIni, $anoIni) . "<br>";

        $str .= "    <label>Data Conclus&atilde;o</label>";
        if ($dados["dataclc"] == "") {
            $dados["dataclc"] = date('Y-m-d');
        }
        $diaClc = date('d', strtotime($dados["dataclc"]));
        $mesClc = date('m', strtotime($dados["dataclc"]));
        $anoClc = date('Y', strtotime($dados["dataclc"]));
        $str .= selectData("clc", $diaClc, $mesClc, $anoClc) . "<br>";

        $str .= "     <label>Documenta&ccedil;&atilde;o: </label>
             <textarea name=\"doc\" cols=90 rows=10>" . $dados["doc"] . "</textarea><br>
             <label>Situa&ccedil;&atilde;o: </label>
                <select name=\"situped\">
                    <option value=\"e\" " . $this->selectedIf($dados['situacao'], "e") . ">espera</option>
                    <option value=\"t\" " . $this->selectedIf($dados['situacao'], "t") . ">estudos</option>
                    <option value=\"a\" " . $this->selectedIf($dados['situacao'], "a") . ">andamento</option>
                    <option value=\"c\" " . $this->selectedIf($dados['situacao'], "c") . ">concluido</option>
                    <option value=\"x\" " . $this->selectedIf($dados['situacao'], "x") . ">cancelado</option>
                </select>
                <a href=\"index.php?st=artigos&pag=leitura&codartg=85\" target=\"blank\"><img src=\"imagens/duvida.gif\" border=\"0\"></a><br>
             <label>Prioridade: </label>
                <select name=\"prioridade\">
                    <option value=\"a\" " . $this->selectedIf($dados['prior'], "a") . ">Urgente</option>
                    <option value=\"b\" " . $this->selectedIf($dados['prior'], "b") . ">Alta</option>
                    <option value=\"c\" " . $this->selectedIf($dados['prior'], "c") . ">M&eacute;dia</option>
                    <option value=\"d\" " . $this->selectedIf($dados['prior'], "d") . ">Baixa</option>
                </select><br>
             <label>Fatura: </label>
                <select name=\"fatura\" id=\"fatura\">
                    <option value=\"1\" " . $this->selectedIf($dados['fatu'], "1") . ">Sim</option>
                    <option value=\"0\" " . $this->selectedIf($dados['fatu'], "0") . ">N&atilde;o</option>
                </select><br>
            <label for=\"salvar\">&nbsp;</label>
                " . $this->msg . "<input name=\"salvar\" type=\"submit\" value=\"Editar\">
            </fieldset>
        </form>";

        return $str;
    }

    /**
     * Cadastro e edicao de tarefas
     * @return string
     */
    public function tarfEdit() {
        //  Cadastra provissoria
        if ($this->get_codTarf() == "") {
            $consulta = $this->proj_cons07($this->get_codPed());
            $this->msg = $this->executaIdSQL($consulta);
            $this->set_codTarf($this->get_idRet());
        }

        // Para edicao
        $consulta = $this->proj_cons08($this->get_codTarf());
        $dados = $this->consultaSQL($consulta);

        //Correcao da hora fina de tarefas nao concluidas
        if (($dados['situacao'] <> "c") && ($dados['hora_fim'] == '0:00')) {
            $dados['hora_fim'] = "";
        }
        if ($dados['hora_ini'] == "0:00") {
            $dados['hora_ini'] = "";
        }

        $str = "
    <form name=\"formTarefa\" action=\"index.php?st=tarf_eletro&ft=pre&pag=edit&codTarefa=" . $this->get_codTarf() . "\" method=\"post\" onSubmit=\"return validaFormTarf()\">
        <fieldset>
            <legend>Descricao do pedido:</legend>
            <textarea cols=\"80\" rows=\"12\" readonly='readonly'>" . $dados['doc_pedido'] . "</textarea>
        </fieldset>
        <fieldset>
            <legend>Detalhamento da Tarefa</legend>
            <label>C&oacute;digo: </label><b>" . $this->get_codTarf() . "</b><br>
            <label>Respons&aacute;vel :</label>" . $this->selectResp($dados['resp'], "42") . "<br>
            <label>Data: </label><b>" . $dados['dia'] . "</b><br>
            <label>Hora In&iacute;cio: </label>
            <input name=\"horaini\" type=\"text\" id=\"horaini\" value=\"" . $dados['hora_ini'] . "\" onclick=\"agora('horaini', this.value);\"><br>
            <label>Hora Fim: </label>
            <input name=\"horafim\" type=\"text\" id=\"horafim\" value=\"" . $dados['hora_fim'] . "\" onclick=\"agora('horafim', this.value);\"><br>
            <label>Documenta&ccedil;&atilde;o: </label>
            <textarea name=\"doc\" cols=\"80\" rows=\"10\" id=\"doc\">" . $dados['doc'] . "</textarea><br>
            <label>Situacao: </label>
                <select name=\"situacao\">
                    <option value=\"a\" " . $this->selectedIf($dados['situacao'], "a") . ">andamento</option>
                    <option value=\"c\" " . $this->selectedIf($dados['situacao'], "c") . ">concluido</option>
                    <option value=\"x\" " . $this->selectedIf($dados['situacao'], "x") . ">cancelado</option>
                </select><br>
            <label>&nbsp;</label><input name=\"salvar\" type=\"submit\" value=\"Editar\"><br>
            " . $this->msg . "
        </fieldset>
    </form>";

        return $str;
    }

    /**
     * Listagem dos pedido comforme parametros em $complemento
     * @param type $complemento
     * @return string
     */
    function pedLista($complemento = "") {
        $consulta = $this->proj_cons01($this->get_codProj(), $complemento);
        $resultado = $this->retornoSQL($consulta);
        $row = $this->rowsSQL($resultado);
        if ($row < 1) {
            $str = "<br /><b>N&atilde;o h&aacute; pedidos ativos</b>";
            return $str;
        } else {

            $str = "<table width=\"100%\">
                    <caption>LISTAGEM DE PEDIDOS</caption>
                        <thead>
                            <tr>
                                <th>C&oacute;digo</th>";
            if ($this->get_codProj() == "") {
                $str .= "         <th>Projeto</th>";
            }
            $str .= "             <th>T&iacute;tulo Pedido</th>
                                <th>Data In&iacute;cio</th>
                                <th>Prioridade</th>
                                <th>Situa&ccedil;&atilde;o</th>
                                <th>Tempo</th>
                            </tr>
                        </thead>
                        <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $style = "";
                if ($dados["situacao"] == "x") {
                    $style = " style=\"text-decoration:line-through;\"";
                }

                $str .= "<tr " . $style . " class=\"" . $this->corLinha() . "'\">
                            <th>" . $dados["cod"] . "</td>";
                if ($this->get_codProj() == "") {
                    $str .= "         <td>" . $dados["nome_proj"] . "</td>";
                }
                $str .= "     <td>" . $dados["titulo"];
                //so disponibilizar para o Engenheiro/Tecnico
                if ($this->atrib("42")) {
                    $str .= "<a href=\"index.php?st=ped_eletro&ft=pre&pag=edit&codped=" . $dados['cod'] . "&codproj=" . $dados['projeto'] . "\">
                                                <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                                            </a>";
                }
                $str .= "
                                <a href=\"index.php?st=tarf_eletro&ft=pre&pag=list_all&codped=" . $dados['cod'] . "\">
                                    <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\">
                                </a>
                            </td>
                            <td>" . $dados["dataini"] . "</td>
                            <td>" . $dados["prioridade"] . "</td>
                            <td>" . $dados["situacao"] . "</td>
                            <td>&nbsp;" . $dados['tothora'] . "</td>
                        </tr>";
            }
            $str .= "</tbody></table>";

            $this->set_situProj($dados['situproj']);

            return $str;
        }
    }

    /**
     * Rodape para os pedidos
     * @return string
     */
    public function pedOpcoes() {

        if ($this->get_codProj() == "") {
            $complemento = "";
        } else {
            $complemento = "&codproj=" . $this->get_codProj();
        }

        $str = "
            <div id=\"opcoes\">";
//so disponibilizar para o Engenheiro/Tecnico
        if (atrib("42")) {
            $str .= "<div id=\"elementoAdmin\">
            <a href=\"index.php?st=ped_eletro&ft=pre&pag=list_all" . $complemento . "\">
                <img src=\"imagens/lista.jpg\" style=\"width: 32px;\" alt=\"Todos\" title=\"Listar Todos\"><br> 
                Todos n&iacute;vel Administrador.
            </a>
        </div>
        <div id=\"elementoAdmin\">";

            if ($this->get_situProj() != "x") {
                $str .= "
                <a href=\"index.php?st=ped_eletro&ft=pre&pag=edit" . $complemento . "\">
                <img src=\"imagens/editar.gif\" style=\"width: 32px;\" alt=\"Pedido Novo\" title=\"Inserir Pedido Novo\"><br>
                    Pedido Novo.
                </a>";
            } else {
                $str .= "Projeto Cancelado";
            }
            $str .= "
        </div>
        <div id=\"elementoAdmin\">
            <a href=\"index.php?st=ped_eletro&ft=pre&pag=list_atv" . $complemento . "\">
                <img src=\"imagens/lista.jpg\" style=\"width: 32px;\" alt=\"Ativos\" title=\"Listar Pedidos Ativos do Projeto\"><br>
                Listar Ativos
            </a>
        </div>
        <div id=\"elementoAdmin\">
            <a href=\"index.php?st=ped_eletro&ft=pre&pag=list" . $complemento . "\">
                <img src=\"imagens/lista.jpg\" style=\"width: 32px;\" title=\"Listar seus Pedido para o Projeto\"><br>
                Listar Todos
            </a>
        </div>";
        }

        $str .= "
            <div id=\"elemento\">
                <a href=\"index.php?st=ped_eletro&ft=pre&pag=list_user" . $complemento . "\">
                    <img src=\"imagens/lista.jpg\" style=\"width: 32px;\" title=\"Lista Todos seus Pedidos Aivos\"><br>
                    Listar Pedidos
                </a>
            </div>
        </div>";

        return $str;
    }

    /**
     * Lista de componentes envolvidos no pedido eletronico
     */
    public function pedComp() {
        $consulta = "    SELECT pd.coditem,
                                cb.cod codpedido,
                                estq.descr,
                                estq.cod,
                                pd.codest,
                                pd.qt,
                                pd.custo,
                                cb.situ
                           FROM estoque estq,
                                estpedidocab cb,
                                estpedidoitem pd
                          WHERE estq.cod = pd.codest
                                AND pd.codped = cb.cod
                                AND cb.ospro =" . $this->get_codPed() . " 
                       ORDER BY descr";
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows < 1) {
            $str = "<a href=\"index.php?st=estoque&pag=ped_edit&codped=&codpedproj=" . $this->get_codPed() . "\">
                <img src=\"imagens/novo.jpg\" style=\"width: 32px;\" alt=\"Inserir orcamento de componetes/pecas\"/>
            </a>
            Inserir pedido de componentes/pe&ccedil;as.";
            return $str;
        }
        $str = "<table width=\"100%\">
            <caption>LISTAGEM DE PEDIDOS Processamento/Transito</caption>
            <thead>
                <tr>
                    <th>Sequencia</th>
                    <th>Componente</th>
                    <th>Qt. Pedida</th>
                    <th>Custo</th>
                    <th>Sub. Total</th>
                </tr>
        </thead>
        <tbody>";
        $totPed = 0;
        while ($dados = arraySQL($resultado)) {
            $str .= "<tr class=\"" . corLinha() . "\" >";
            $str .= "<th>" . $dados["coditem"] . "</th>
                     <td>" . $dados["codest"] . "
                        <a href=\"index.php?st=estoque&pag=edit&codestq=" . $dados["codest"] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                        </a> - " . $dados["descr"];

            $custo = $dados['custo'];
            $qt = $dados['qt'];
            $subtot = $custo * $qt;
            $str .= "</td>
                    <td style=\"text-align: center;\">" . $qt . "</td>
                    <td>R$ " . number_format($custo, 2, ',', '.') . "</td>
                    <td>R$ " . number_format($subtot, 2, ',', '.') . "</td>
                </tr>";
            $totPed += $subtot;
        }
        $str .= "<tr class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style=\"text-align: right;\"><b>Total pedido = </b></td>
                    <td style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                </tr>
            </table>
            <hr>";

        return $str;
    }

    /**
     * monta um cabacalho para as tarefas
     * @return string
     */
    public function tarfCab() {
        // Identificar o projeto
        if ($this->get_codTarf() != "") {
            $consulta = "SELECT projetos.nome AS nomeProj,
                         projetos.cod AS codProj,
                         tarefas.pedido AS codPedido,
                         pedidos.titulo
                    FROM getar_pedidos AS pedidos,
                         getar_projetos AS projetos,
                        getar_tarefas AS tarefas
                   WHERE projetos.cod= pedidos.projeto
                         AND pedidos.cod= tarefas.pedido
                         AND tarefas.cod= " . $this->get_codTarf();
        } elseif ($this->get_codPed() != "") {
            $consulta = " SELECT projetos.nome AS nomeProj,
                         projetos.cod AS codProj,
                         pedidos.cod AS codPedido,
                         pedidos.titulo
                    FROM getar_pedidos AS pedidos,
                         getar_projetos AS projetos
                   WHERE projetos.cod= pedidos.projeto
                         AND pedidos.cod='" . $this->get_codPed() . "'";
        }
        $dados = consultaSQL($consulta);
        $str = "<div class=\"titulo\">TAREFAS - Projetos Programa&ccedil;&atilde;o</div>
                <div class=\"sub-titulo\" style=\"margin-bottom: 3px;\">
                    Projeto: <b>" . $dados["nomeProj"] . "</b>
                    <a href=\"index.php?st=projetos&ft=pre&pag=edit&codproj=" . $dados["codProj"] . "\">
                        <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\">
                    </a>
                </div>
                <div class=\"sub-titulo\">
                    T&iacute;tulo Pedido: <b>" . $dados['titulo'] . "</b>
                    <a href=\"index.php?st=pedidos&ft=pre&pag=edit&codped=" . $dados["codPedido"] . "&codproj=" . $dados["codProj"] . "\">
                        <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\">
                    </a>
                </div>";

        return $str;
    }

    /**
     * Cabecalho para a tela dos pedidos
     * @return string
     */
    public function pedCab() {
        if ($this->get_codProj() <> "") {
            $str = "<div class=\"titulo\">PEDIDOS - Projetos Eletr&ocircle;nicos</div>
                    <div class=\"sub-titulo\">Projeto: <b>" . $this->get_nomeproj() . "</b>
                        <a href=\"index.php?st=projetos&ft=pre&pag=edit&codproj=" . $this->get_codProj() . "\">
                          <img src=\"imagens/editar.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\">
                        </a>
                    </div>";
        } else {
            $str = "<span class='titulo'>Listagem de Seus pedidos ativos</span>";
        }

        return $str;
    }

    /**
     * Rodape de opcoes para projetos eletronicos
     * @return string
     */
    public function projOpcoes() {
        $str = " <div id=\"opcoes\">
                <div id=\"elemento\">
                    <a href=\"index.php?st=proj_eletro&ft=pre&pag=edit\" accesskey=\"n\">
                        <img src=\"imagens/novo.jpg\" alt=\"Projeto Novo\" title=\"Cria um projeto novo\"><br>
                        Projeto Novo.
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=proj_eletro&ft=pre&pag=list_est\">
                        <img src=\"imagens/grupo.gif\" alt=\"Lista Estudo\" title=\"Listar Projetos Programa&ccedil;&atilde;o em estudo\"><br>
                        Listar em estudo.
                    </a>
                </div>";
        if ($this->get_codProj() <> "") {
            if (($this->situProj <> "f") && ($this->situProj <> "x")) {
                $str .= "<div id=\"elemento\">
                    <a href=\"index.php?st=ped_eletro&ft=pre&pag=edit&codproj=" . $this->get_codProj() . "\">
                        <img src=\"imagens/grupo.gif\" alt=\"Pedido Novo\" title=\"Inserir pedido novo\"><br>
                        Pedido Novo
                    </a>
                </div>";
            } else {
                $str .= "<div id=\"elementoAdmin\">
                            <img src=\"imagens/desativar.gif\" alt=\"Projeto Cancelado\" title=\"Projeto Cancelado. Imposs&iacute;vel Criar Pedido Novo\"><br>
                            Projeto Cancelado
                        </div>";
            }
            $str .= "<div id=\"elemento\">
                    <a href=\"index.php?st=ped_eletro&ft=pre&pag=list&codproj=" . $this->get_codProj() . "\">
                        <img src=\"imagens/grupo.gif\" alt=\"lista pedidos\" title=\"Lista pedidos para este projeto\"><br>
                        Listar Todos Pedido
                    </a>
                </div>";
        }

        $str .= "<div id=\"elemento\">
                    <a href=\"index.php?st=proj_eletro&ft=pre&pag=list\">
                        <img src=\"imagens/grupo.gif\" alt=\"Listar Andamento\" title=\"Listar Projetos Programa&ccedil;&atilde;o em andamento.\"><br>
                        Listar Andamento
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=proj_eletro&ft=pre&pag=list_u\">
                        <img src=\"imagens/recicle.gif\" alt=\"Listaf Ultimos\" title=\"Listar comecando pelos ultimos cadastrados\"><br>
                        Listar &Uacute;ltimos
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=proj_eletro&ft=pre&pag=list_all\">
                        <img src=\"imagens/grupo.gif\" alt=\"Listar Todos\" title=\"Listar todos projetos\"><br>
                        Listar Todos
                    </a>
                </div>";

        $str .= "    </div>";
        return $str;
    }

}

?>
