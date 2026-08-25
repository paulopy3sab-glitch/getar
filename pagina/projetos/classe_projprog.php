<?php

/**
 * Descricao
 * Metodos de apoio a Projetos de Programacao
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data de criacao:
 * @date junho/2016
 * Revisao: pregis 28/08/2016
 *   Retirada dos metodos dos projetos eletronicos, se optou por trabalhar com 
 * arquivos separados pois as semalhancas sao poucas
 */
class Projprog extends Conex {

    use Tprojcons;

    private $acao;
    private $msg;
    private $erro;
    // Para os projeto
    private $codProj;
    private $tag;
    private $nomeProj;
    private $codCliente;
    private $descr;
    private $situProj;
    // Para os pedido
    private $codPed;
    private $codPedCons;
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
    private $statusTarf;
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

        $consulta = "SELECT nome FROM getar_projetos WHERE cod =" . $this->codProj;
        $dados = $this->consultaSQL($consulta);
        $this->set_nomeProj($dados['nome']);
    }

    function get_codProj() {
        return $this->codProj;
    }

    function get_tag() {
        return $this->tag;
    }

    function set_nomeProj($novo_nome) {
        $this->nomeProj = $novo_nome;
    }

    function get_nomeProj() {
        return $this->nomeProj;
    }

    function set_codPed($novo_codPed) {
        $this->codPed = $novo_codPed;

        $consulta = $this->ped_Cons01($this->tag, $this->codPed);
        $dados = $this->consultaSQL($consulta);
        $this->codProj = $dados['codproj'];
        $this->nomeProj = $dados['nomeproj'];
        $this->tituPed = $dados['titulo'];
    }

    function get_codPed() {
        return $this->codPed;
    }

    function set_CodPedCons($novo_codPedCons) {
        $this->codPedCons = $novo_codPedCons;
    }

    function get_codPedCons() {
        return $this->codPedCons;
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

    function set_descr($novo_descr) {
        $this->descr = $novo_descr;
    }

    function set_tag($novo_tag) {
        $this->tag = $novo_tag;
    }

    function busca_tag() {
        $consulta = "   SELECT tag
                          FROM getar_projetos prj,
                               getar_pedidos ped
                         WHERE prj.cod= ped.codproj
                               AND ped.cod=" . $this->get_codPed();
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);
        $this->set_tag($dados['tag']);
    }

    function get_descr() {
        return $this->descr;
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

    function set_erro($erro) {
        $this->erro = $erro;
    }

    function get_erro() {
        return $this->erro;
    }

    function set_msg($erro) {
        $this->msg = $erro;
    }

    function get_msg() {
        return $this->msg;
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
     * codigo da tarefa
     * @param type $novo_codTarf
     */
    public function set_codTarf($novo_codTarf) {
        $this->codTarf = $novo_codTarf;

        $consulta = "SELECT proj.nome AS NOMEPROJ,
                            proj.cod AS CODPROJ,
                            ped.titulo TITULO,
                            ped.cod AS CODPED
                       FROM getar_pedidos AS ped,
                            getar_projetos AS proj,
                            getar_tarefas AS tarf
                      WHERE proj.cod= ped.codproj
                            AND ped.cod= tarf.codped
                            AND tarf.cod=" . $this->codTarf;
        $dados = $this->consultaSQL($consulta);
        $this->codProj = $dados['CODPROJ'];
        $this->nomeProj = $dados['NOMEPROJ'];
        $this->tituPed = $dados['TITULO'];
        $this->codPed = $dados['CODPED'];
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
     * @param type $novo_statusTarf
     */
    public function set_statusTarf($novo_statusTarf) {
        $this->statusTarf = $novo_statusTarf;
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
    public function get_statusTarf() {
        return $this->statusTarf;
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
    public function projLista($complemento) {
        $str = "";

        $consulta = $this->proj_cons03($complemento);
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);

        if ($rows < 1) {
            $str = "<br /><b style=\"color: red;\">N&atilde;o h&aacute; retorno para" . $complemento . "</b>";
            return $str;
        } else {
            $str = "<table width=\"100%\">
                    <caption>LISTAGEM DOS PROJETOS</caption>
                    <thead>
                    <tr>
                        <th>C&oacute;d/Tag</th>
                        <th>Nome Projeto</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Inicio Descr.</td>
                        <th>Situa&ccedil;&atilde;o</th>
                    </tr>
                    </thead>
                    <tbody>";

            while ($dados = $this->arraySQL($resultado)) {
                $style = "";
                if ($dados["situacao"] == "cancelado") {
                    $style = " style=\"text-decoration:line-through;\"";
                }

                $str.="<tr " . $style . " class=\"" . $this->corLinha() . "\">
                        <td>" . $dados["cod"] . "-" . $dados["tag"] . "</td>
                        <td>" . $dados["nome"];
                //so disponibilizar para o administrador
                if ($this->atrib("32")) {
                    $str.="<a href=\"index.php?st=projetos&ft=prp&pag=edit&codproj=" . $dados['cod'] . "&tag=" . $dados['tag'] . "\">
                                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                                        </a>";
                }
                $str.="
                            
                        </td>
                        <td>" . $dados["cliente"] . "</td>
                        <td>" . $dados["datareg"] . "</td>
                        <td>" . $dados["descr"] . "</td>
                        <td>" . $dados["situacao"] . "</td>
                    </tr>";
            }
            $str.="</tbody></table>";
        }
        $this->set_situProj($dados['situproj']);

        return $str;
    }

    /**
     * opcoes de rodape para os projeto
     * @return string
     */
    public function projOpcoes() {

        $str = " <div id=\"opcoes\">
                    <div id=\"elemento\">
                        <a href=\"index.php?st=projetos&ft=prp&pag=edit\" accesskey=\"n\">
                            <img src=\"imagens/novo.jpg\" alt=\"Projeto Novo\" title=\"Cria um projeto novo\"><br>
                            Projeto Novo.
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=projetos&ft=prp&pag=list_est\">
                            <img src=\"imagens/grupo.gif\" alt=\"Lista Estudo\" title=\"Listar Projetos Programa&ccedil;&atilde;o em estudo\"><br>
                            Listar em estudo.
                        </a>
                    </div>";

        if ($this->get_codProj() != "") {
            if ($this->get_situProj() != "x") {
                $str.="<div id=\"elementoAdmin\">
                            <a href=\"index.php?st=pedidos&ft=prp&pag=edit&codproj=" . $this->get_codProj() . "\">
                                <img src=\"imagens/editar.gif\" alt=\"Pedido Novo\" title=\"Cria um pedido novo para o projeto em foco\"><br>
                                    Pedido Novo.
                            </a>
                        </div>";
            } else {
                $str.="<div id=\"elementoAdmin\">
                            <img src=\"imagens/desativar.gif\" alt=\"Projeto Cancelado\" title=\"Projeto Cancelado. Imposs&iacute;vel Criar Pedido Novo\"><br>
                            Projeto Cancelado
                        </div>";
            }
            $str.="<div id=\"elemento\">
                       <a href=\"index.php?st=projetos&ft=prp&pag=listped&codproj=" . $this->get_codProj() . "\">
                           <img src=\"imagens/editar.gif\" alt=\"Lista Todos\" title=\"Lista todos pedidos do projeto\"><br>
                               Lista Pedido
                       </a>
                   </div>";
        }

        $str.="   <div id=\"elemento\">
                        <a href=\"index.php?st=projetos&ft=prp&pag=list\">
                            <img src=\"imagens/grupo.gif\" alt=\"Listar Andamento\" title=\"Listar Projetos Programa&ccedil;&atilde;o em andamento.\"><br>
                            Listar Projetos
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=projetos&ft=prp&pag=list_all\">
                            <img src=\"imagens/grupo.gif\" alt=\"Listar Todos\" title=\"Listar todos projetos\"><br>
                            Listar Todos Projetos
                        </a>
                    </div>
                </div>";

        return $str;
    }

    /**
     * listagem de tarefas de programacao
     * @param type $complemento
     * @return string
     */
    public function tarfLista($complemento) {
        $consulta = "    SELECT cod,
                                resp,
                                doc,
                                date_format(dataexc, '%d/%m/%Y') dia,
                                date_format(dataexc, '%m') mes,
                                date_format(horaini, '%k:%i') hora_ini,
                                date_format(horafim, '%k:%i') hora_fim,
                                date_format(SUBTIME(horafim, horaini), '%k:%i') tempotrab,
                                CASE 
                                    WHEN situacao = 'concluido' THEN 'concluido'
                                    WHEN situacao = 'andamento' THEN 'andamento'
                                    WHEN situacao = 'cancelada' THEN 'cancelada'
                                END AS situ
                           FROM getar_tarefas
                          WHERE situacao != 'temporario'
                                AND codped = " . $this->get_codPed() . "
                                " . $complemento . "
                       ORDER BY cod DESC";
        $resultado = $this->retornoSQL($consulta);
        $row = $this->rowsSQL($resultado);
        if ($row < 1) {
            $this->set_erro(TRUE);
        } else {
            $this->set_erro(FALSE);
        }

        return $resultado;
    }

    /**
     * Totaliza horas trabalhadas
     * @param type $complemento
     * @return string
     */
    public function totHoras($complemento) {
        $dados = $this->consultaSQL($this->tarf_Cons03($complemento));
        $tempo = $dados['tempo'];
        $hora = floor($tempo / 3600);
        $minuto = round(($tempo / 60) % 60, 2);

        $str = $hora . ":" . $minuto;

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
            $str.="<a href=\"index.php?st=tarefas&ft=prp&pag=edit&codped=" . $this->get_codPed() . "\" accesskey=\"n\">
                        <img src=\"imagens/novo.jpg\" alt=\"Nova Tarefa\" title=\"Criar nova tarefa para o pedido\"><br>
                        Tarefa Nova.
                    </a>";
        } else {
            $str.= "Pedido Cancelado";
        }

        $str.="</div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=pedidos&ft=prp&pag=list_atv&codproj=" . $this->get_codProj() . "\">
                        <img src=\"imagens/livro.gif\" alt=\"Listar Pedido\"  title=\"Listar Pedido Ativos no Projeto\"><br>
                        Listar Pedidos
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=tarefas&ft=prp&pag=list&codped=" . $this->get_codPed() . "\">
                        <img src=\"imagens/livro.gif\" alt=\"Listar Tarefas\" title=\"Listar Suas Tarefas em Andamento\"><br>
                        Listar Tarefas
                    </a>
                </div>
                <div id=\"elementoAdmin\">";

        if (atrib("32")) {
            $str.="<td valign=\"top\" align=\"center\">
                        <a href=\"index.php?st=tarefas&ft=prp&pag=list_adm&codped=" . $this->get_codPed() . "\">
                            <img src=\"imagens/livro.gif\" alt=\"Listar Todas\" title=\"Listar Todos Tarefas- N&iacute;vel Administrador\"><br>
                            Listar Todos Tarefas
                        </a>
                    </td>";
        }
        $str.="</div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=tarefas&ft=prp&pag=list_all&codped=" . $this->get_codped() . "\">
                        <img src=\"imagens/livro.gif\" alt=\"\" title=\"Listar Todas Suas Tarefas\"><br>
                        Listar suas Tarefas
                    </a>
                </div>
            </div>";

        return $str;
    }

    /**
     * Salva alteracoes no projeto
     */
    function projSalvar() {
        $consulta = $this->proj_Cons05();
        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * salvar alteracoe em pedidos
     */
    function pedSalvar() {
        $consulta = $this->ped_Cons02();
        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * salva as alteracoes nas tarefas
     * @return string
     */
    public function tarfSalvar() {
        $consulta = $this->tarf_Cons02();

        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * switch case para as listagens dos projetos
     * @param type $pag
     * @return string
     */
    public function projSwitch($pag) {
        global $str;

        $complemento = "";
        switch ($pag) {
            case 'edit':
                $str = $this->projEdit($this->codProj);
                $complemento = " AND tag= '" . $this->get_tag() . "'
                                 AND cod= " . $this->codProj;
                $this->set_acao(" Projeto em Foco");
                break;
            case 'detal':
                $str = $this->projDetal();
                $complemento = " AND cod= " . $this->codProj;
                $this->set_acao(" Projeto em Foco");
                break;
            case 'list':
                $complemento = " AND situacao NOT IN('temporario', 'fechado', 'cancelado') ORDER BY nome ASC";
                $this->set_acao(" Projetos em Andamento");
                break;
            case 'list_est':
                $complemento = " AND situacao = 'estudo' ORDER BY nome ASC";
                $this->set_acao(" Projeto em estudos");
                break;
            case 'list_u':
                $complemento = " ORDER BY cod DESC";
                $this->set_acao(" Ultimos Projetos");
                break;
            case 'list_all':
                $complemento = " ORDER BY cod ASC";
                $this->set_acao(" Todos Projetos");
                break;
            case 'list_pesq':
                $complemento = " AND nome LIKE '" . $_REQUEST['string'] . "%' ORDER BY nome ASC";
                $this->set_acao(" em Pesquisa");
                break;
            case 'listped':
                $complemento = " AND cod= " . $this->codProj;
                $this->set_acao(" Projeto em Foco");
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
            case 'list_atv':
                $complemento = " AND proj.cod = " . $this->get_codProj() . "
                                 AND ped.situacao IN('andamento', 'espera') ";
                break;
            case 'list':
                $complemento = " AND proj.cod = " . $this->get_codProj() . "
                                 AND ped.situacao NOT IN('cocluido', 'cancelado', 'estudo') ";
                break;
            case 'list_user':
                $complemento = " AND ped.resp = '" . $_SESSION['resp'] . "'
                                 AND ped.situacao NOT IN('concluido', 'cancelado') ";
                break;
            case 'list_and':
                $complemento = "AND ped.resp = '" . $_SESSION['resp'] . "'
                                AND ped.situacao = 'andamento'";
                break;
            case 'list_all':
                $complemento = "";
                break;
            default :
                $complemento = " ";
        }
        return $complemento;
    }

    /**
     * switch case para as listagens das tarefas
     * @param type $pag
     */
    public function tarfSwitch($pag) {
        global $str;

        $complemento = "";
        switch ($pag) {
            case 'edit':
                $str = $this->tarfEdit();
                break;
            case 'detalhar':
                $str = $this->tarfDetal();
                break;
            case 'list':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 AND situacao = 'andamento' ";
                break;
            case 'list_all':
                $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 AND situacao IN('andamento', 'concluido') ";
                break;
            case 'list_adm':
                $complemento = " ";
                break;
        }

        return $complemento;
    }

    /**
     * Detalhar um projeto sem opcoes de edicao
     * @return string
     */
    function projDetal() {
        $consulta = "SELECT nome,
                        SUBSTRING((SELECT nome FROM getar_cad WHERE cod= cliente ), 1, 20) AS cliente,
                        descr,
                        DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                        CASE
                            WHEN situacao = 'negociacao' THEN 'negociacao'
                            WHEN situacao = 'estudo' THEN 'em estudos'
                            WHEN situacao = 'espera' THEN 'em espera'
                            WHEN situacao = 'andamento' THEN 'em andamento'
                            WHEN situacao = 'fechado' THEN 'fechado'
                            WHEN situacao = 'cancelado' THEN 'cancelado'
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

    /**
     * Detalhar um projeto sem opcoes de edicao
     * @return string
     */
    public function tarfDetal() {
        $consulta = "SELECT date_format(dataexc, '%d/%m/%Y') dia,
                                date_format(horaini, '%k:%i') hora_ini,
                                date_format(horafim, '%k:%i') hora_fim,
                                doc,
                                resp,
                                codped,
                                CASE
                                    WHEN fatura THEN 'sim'
                                    ELSE 'nao'
                                END fatu,
                                situacao
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
                <label>Situa&ccedil;&atilde;o: </label><b>" . $dados['situacao'] . "</b><br>
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
            $consulta = "INSERT INTO getar_projetos ( tag, nome, datareg, cliente, descr, situacao)
                         VALUES('TM001', 'Projeto Novo', CURDATE(), 2, 'Descricao do projeto', 'temporario');";
            $this->executaIdSQL($consulta);
            $codProj = $this->get_idRet();
            $this->set_codProj($codProj);
            $this->set_tag('TM001');
        }

        //  Carrega para edicao
        $consulta = "SELECT proj.cod cod,
                            proj.tag,
                            proj.nome nmproj,
                            proj.cliente codcli,
                            cad.nome,
                            proj.descr,
                            DATE_FORMAT(proj.datareg, '%d/%m/%Y') datareg,
                            proj.situacao
                       FROM  getar_cad cad,
                             getar_projetos proj
                      WHERE proj.cliente = cad.cod
                            AND proj.cod= " . $this->codProj . "
                            AND proj.tag= '" . $this->tag . "'";
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);


        $str = "<form action='index.php?st=projetos&ft=prp&pag=edit&codproj=" . $this->codProj . "' method='post'>
                <input type='hidden' name='codproj' value='" . $this->codProj . "'>
            <fieldset>
                <legend>Dados do Projeto</legend>
                <label>C&oacute;digo :</label><b>" . $this->codProj . "</b><br>
                <label>Tag :</label><input name='tag' type='text' size='42' maxlength='40' value=\"" . $dados["tag"] . "\"><br>
                <label>Nome: </label><input name='nome' type='text' size='42' maxlength='40' value=\"" . $dados["nmproj"] . "\"><br>
                <label>Cliente:</label>";
        if ($dados['situacao'] == "temporario") {
            $str.= $this->selectCliente($dados['codcli']) . "<br>";
        } else {
            $str.= "<b>" . $dados['nome'] . "</b>
                    <input type='hidden' name='codCliente' value='" . $dados["codcli"] . "'>
                    <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $dados["codcli"] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este registro\">
                    </a><br />";
        }

        $str.= "<label>Descri&ccedil&atilde;o: </label><textarea name=\"descr\" cols=\"40\" rows=\"3\">" . $dados["descr"] . "</textarea><br>
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
                    <option value=\"negociacao\" " . $this->selectedIf($situ, "negociacao") . ">em negocia&ccedil;&atilde;o</option>
                    <option value=\"estudo\" " . $this->selectedIf($situ, "estudo") . ">em estudos</option>
                    <option value=\"espera\" " . $this->selectedIf($situ, "espera") . ">em espera</option>
                    <option value=\"andamento\" " . $this->selectedIf($situ, "andamento") . ">em andamento</option>
                    <option value=\"fechado\" " . $this->selectedIf($situ, "fechado") . ">fechado</option>
                    <option value=\"cancelado\" " . $this->selectedIf($situ, "cancelado") . ">cancelado</option>
                </select>";

        return $str;
    }

    /**
     * Cria e edita um pedido para um projeto
     * @return string
     */
    function pedEdit() {

        if ($this->get_codPed() == "") {
            // validacao
            if ($this->get_codProj() == "") {
                $this->msg = "<b>Erro: nao veio o codigo do projeto";
                return;
            } else {
                $consulta = $this->proj_cons02($this->get_codProj());
                $this->msg = $this->executaIdSQL($consulta);
                $this->set_codPed($this->get_idRet());
            }
        }

        $consulta = "SELECT cod,
                            titulo,
                            resp,
                            prior,
                            codproj,
                            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                            dataini,
                            dataclc,
                            fatu,
                            doc,
                            (SELECT cod FROM estpedidocab WHERE ospro = " . $this->get_codPed() . " AND tipo = 'consumo' LIMIT 1) codpedcons,
                            (SELECT COUNT(*) FROM estpedidocab WHERE ospro = " . $this->get_codPed() . " AND tipo = 'consumo') numcodpedcons,
                            situacao
                   FROM getar_pedidos
                      WHERE cod= " . $this->get_codPed();
        $dados = $this->consultaSQL($consulta);

        $this->set_CodPedCons($dados['codpedcons']);


        return $dados;
    }

    /**
     * Cadastro e edicao de tarefas
     * @return string
     */
    public function tarfEdit() {
        //  Cadastra provissoria
        if ($this->get_codTarf() == "") {
            $doc = "Descricao inicial da Tarefa: \n \nArquivos envolvidos: \n \nDocumentacao em anexo:";

            $consulta = "INSERT INTO getar_tarefas (situacao, resp, codped, dataexc, horaini, doc)
                         VALUES ('andamento', '" . $this->get_respTarf() . "', '" . $this->get_codPed() . "', CURDATE(), " . $this->curtimeFuso() . ", '" . $doc . "')";
            $this->msg = $this->executaIdSQL($consulta);
            $this->set_codTarf($this->get_idRet());
        }

        // Para edicao
        $consulta = $this->tarf_Cons01($this->get_codTarf());
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);

        //Correcao da hora final de tarefas nao concluidas
        if (($dados['situ'] <> "concluido") && ($dados['horafim'] == '00:00:00')) {
            $dados['horafim'] = "";
        }
        if ($dados['horaini'] == "00:00:00") {
            $dados['horaini'] = "";
        }

        return $dados;
    }

    /**
     * Listagem dos pedido comforme parametros em $complemento
     * @param type $complemento
     * @return string
     */
    function pedLista($complemento = "") {
        $consulta = $this->proj_cons01($complemento);
        $resultado = $this->retornoSQL($consulta);
        $row = $this->rowsSQL($resultado);

        if ($row < 1) {
            $this->set_erro(TRUE);
        } else {
            $this->set_erro(FALSE);
        }

        return $resultado;
    }

    /**
     * Rodape para os pedidos
     * @return string
     */
    public function pedOpcoes() {
        $str = "
            <div id=\"opcoes\">";
//so disponibilizar para o administrador
        if (atrib("32")) {

            $str.="<div id=\"elementoAdmin\">
            <a href=\"index.php?st=pedidos&ft=prp&pag=list_all&codproj=" . $this->get_codProj() . "\">
                <img src=\"imagens/grupo.gif\" alt=\"\" width=\"20\" height=\"16\" border=\"no\"><br> 
                Todos n&iacute;vel Administrador.
            </a>
        </div>";
            if ($this->get_codProj() != "") {
                if ($this->get_situProj() != "x") {
                    $str.="
                    <div id=\"elementoAdmin\">
                            <a href=\"index.php?st=pedidos&ft=prp&pag=edit&codproj=" . $this->get_codProj() . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" width=\"16\" height=\"16\"><br>
                                Pedido Novo.
                            </a>
                    </div>
                    <div id=\"elementoAdmin\">
                        <a href=\"index.php?st=pedidos&ft=prp&pag=list_atv&codproj=" . $this->get_codProj() . "\">
                            <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\"><br>
                            Listar Pedidos Ativos do Projeto
                        </a>
                    </div>
                    <div id=\"elementoAdmin\">
                        <a href=\"index.php?st=pedidos&ft=prp&pag=list&codproj=" . $this->get_codProj() . "\">
                            <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\"><br>
                            Listar Pedidos<br>
                            p/ Projeto
                        </a>
                    </div>";
                }
            }
        }

        $str.="
                <div id=\"elemento\">
                    <a href=\"index.php?st=pedidos&ft=prp&pag=list_user\">
                        <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\"><br>
                        Listar seus<br>
                        Pedidos
                    </a>
                </div>
</div>";

        return $str;
    }

    /**
     * monta um cabacalho para as tarefas
     * @return string
     */
    public function tarfCab() {
        // Identificar o projeto
        if ($this->get_codTarf() != "") {
            $consulta = "SELECT proj.nome AS nomeProj,
                                proj.cod AS codProj,
                                proj.tag,
                                tarf.codped AS codPedido,
                                ped.titulo
                           FROM getar_pedidos AS ped,
                                getar_projetos AS proj,
                               getar_tarefas AS tarf
                          WHERE proj.cod= ped.codproj
                                AND ped.cod= tarf.codped
                                AND tarf.cod= " . $this->get_codTarf();
        } elseif ($this->get_codPed() != "") {
            $consulta = " SELECT proj.nome AS nomeProj,
                                 proj.cod AS codProj,
                                 proj.tag,
                                 ped.cod AS codPedido,
                                 ped.titulo
                            FROM getar_pedidos AS ped,
                                 getar_projetos AS proj
                           WHERE proj.cod= ped.codproj
                                 AND ped.cod=" . $this->get_codPed();
        }
        $dados = consultaSQL($consulta);
        $str = "<div class=\"titulo\">TAREFAS DO PEDIDO</div>
                <div class=\"sub-titulo\" style=\"margin-bottom: 3px;\">
                    Projeto: <b>" . $dados["nomeProj"] . "</b>
                    <a href=\"index.php?st=projetos&ft=prp&pag=edit&codproj=" . $dados["codProj"] . "&tag=" . $dados["tag"] . "\">
                        <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\">
                    </a>
                </div>
                <div class=\"sub-titulo\">
                    T&iacute;tulo Pedido: <b>" . $dados['titulo'] . "</b>
                    <a href=\"index.php?st=pedidos&ft=prp&pag=edit&codped=" . $dados["codPedido"] . "&codproj=" . $dados["codProj"] . "\">
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
            $str = "<div class=\"titulo\">PEDIDOS DO PROJETO</div>
                    <div class=\"sub-titulo\">Projeto: <b>" . $this->get_nomeproj() . "</b>
                        <a href=\"index.php?st=projetos&ft=prp&pag=edit&codproj=" . $this->get_codProj() . "&tag=" . $this->get_tag() . "\">
                          <img src=\"imagens/editar.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\">
                        </a>
                    </div>";
        } else {
            $str = "<span class='titulo'>Listagem de Seus pedidos ativos</span>";
        }

        return $str;
    }

    /**
     * Lista de componentes envolvidos no pedido eletronico
     * @return string
     */
    public function pedComp() {
        $consulta = "    SELECT cb.cod codpedido
                           FROM estpedidocab cb
                         WHERE cb.nmproj =" . $this->get_codPed();
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);
        if ($rows == 0) {
            $str = "<a href=\"index.php?st=pedido&pag=ped_edit&codped=&codpedproj=" . $this->get_codPed() . "\">
                <img src=\"imagens/novo.jpg\" style=\"width: 32px;\" alt=\"Inserir orcamento de componetes/pecas\"/>
            </a>
            Inserir pedido de componentes/pe&ccedil;as.";
            return $str;
        }
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
                                AND cb.tipo = 'consumo'
                                AND cb.nmproj =" . $this->get_codPed() . " 
                       ORDER BY descr";
        $resultado = $this->retornoSQL($consulta);
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
            $codpedido = $dados["codpedido"];
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
                <tr>
                    <th colspan=\"5\">
                    Ver pedido Estoque/Consumo: " . $this->get_codPed() . "
                    </th>
                </tr>
            </table>
            <hr>";

        return $str;
    }

    /**
     * Verifica a situacao do pedido
     */
    public function verificaPedido() {
        $consulta = "SELECT situacao FROM getar_pedidos WHERE cod=" . $this->get_codPed();
        $dados = $this->consultaSQL($consulta);
        $this->set_situPed($dados["situacao"]);
    }

}
