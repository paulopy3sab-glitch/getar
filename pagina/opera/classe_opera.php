<?php

/**
 * Descricao
 * Metodos de apoio a Projetos de Programacao
 *
 * @author Paulo
 * Data de criacao: junho/2016
 * Revisao: pregis 28/08/2016
 *   Retirada dos metodos dos projetos eletronicos, se optou por trabalhar com 
 * arquivos separados pois as semalhancas sao poucas
 */
class Opera extends Conex {

    use Toperacons;

    private $acao;
    private $msg;
    // Para os projeto
    private $codOpera;
    private $tag;
    private $nomeOpera;
    private $respOpera;
    private $descr;
    private $situOpera;
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

    function set_codOpera($novo_codOpera) {
        $this->codOpera = $novo_codOpera;

        $consulta = "SELECT nome FROM getar_opera WHERE cod =" . $this->codOpera;
        $dados = $this->consultaSQL($consulta);
        $this->set_nomeOpera($dados['nome']);
    }

    function get_codOpera() {
        return $this->codOpera;
    }

    function get_tag() {
        return $this->tag;
    }

    function set_nomeOpera($novo_nome) {
        $this->nomeOpera = $novo_nome;
    }

    function set_respOpera($novo_resp) {
        $this->respOpera = $novo_resp;
    }

    function get_nomeOpera() {
        return $this->nomeOpera;
    }

    function get_respOpera() {
        return $this->respOpera;
    }

    function set_descr($novo_descr) {
        $this->descr = $novo_descr;
    }

    function set_tag($novo_tag) {
        $this->tag = $novo_tag;
    }

    function get_descr() {
        return $this->descr;
    }

    function set_situOpera($novo_situOpera) {
        $this->situOpera = $novo_situOpera;
    }

    function get_situOpera() {
        return $this->situOpera;
    }

    function set_acao($novo_acao) {
        $this->acao = $novo_acao;
    }

    function get_acao() {
        return $this->acao;
    }

    /**
     * codigo da tarefa
     * @param type $novo_codTarf
     */
    public function set_codTarf($novo_codTarf) {
        $this->codTarf = $novo_codTarf;

        $consulta = "SELECT opr.nome nome,
                            opr.cod cod
                       FROM getar_opera AS opr,
                            getar_tarfopera AS tarf
                      WHERE opr.cod= tarf.codopera
                            AND tarf.cod=" . $this->codTarf;
        $dados = $this->consultaSQL($consulta);
        $this->codOpera = $dados['cod'];
        $this->nomeOpera = $dados['nome'];
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
    public function operaLista($complemento) {
        $str = "";

        $consulta = $this->opera_Cons03($complemento);
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);

        if ($rows < 1) {
            $str = "<br /><b style=\"color: red;\">N&atilde;o h&aacute; retorno para" . $complemento . "</b>";
            return $str;
        } else {
            $str = "<table width=\"100%\">
                    <caption>LISTAGEM DOS OPERA&Ccedil;&Otilde;ES</caption>
                    <thead>
                    <tr>
                        <th>C&oacute;d/Tag</th>
                        <th>Atividade</th>
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

                $str.="<tr " . $style . " class=\"" . $this->corLinha() . "'\">
                        <td>" . $dados["cod"] . "-" . $dados["tag"] . "</td>
                        <td>" . $dados["nome"];
                //so disponibilizar para o administrador
                if ($this->atrib("32")) {
                    $str.="<a href=\"index.php?st=opera&pag=edit&codopr=" . $dados['cod'] . "\">
                               <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                           </a>";
                } else {
                    $str.="<a href=\"index.php?st=opera&pag=detal&codopr=" . $dados['cod'] . "\">
                               <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                           </a>";
                }
                $str.="
                            
                        </td>
                        <td>" . $dados["datareg"] . "</td>
                        <td>" . $dados["descr"] . "</td>
                        <td>" . $dados["situacao"] . "</td>
                    </tr>";
            }
            $str.="</tbody></table>";
        }

        return $str;
    }

    /**
     * opcoes de rodape para os projeto
     * @return string
     */
    public function operaOpcoes() {

        $str = " <div id=\"opcoes\">";
        if ($this->atrib("42")) {
            $str = "<div id=\"elemento\">
                        <a href=\"index.php?st=opera&pag=edit\" accesskey=\"n\">
                            <img src=\"imagens/novo.jpg\" alt=\"Operacional Novo\" title=\"Cria uma nova atividade Operacional\"><br>
                            Operacional Novo.
                        </a>
                    </div>";
        }
        $str = "    <div id=\"elemento\">
                        <a href=\"index.php?st=opera&pag=list\">
                            <img src=\"imagens/grupo.gif\" alt=\"Lista Operacionais\" title=\"Listar atividade Operacional\"><br>
                            Listar.
                        </a>
                    </div>";

        if ($this->get_codOpera() != "") {
            $str.="<div id=\"elemento\">
                       <a href=\"index.php?st=tarfopera&pag=list&codoper=" . $this->get_codOpera() . "\">
                           <img src=\"imagens/editar.gif\" alt=\"Lista Todos\" title=\"Lista todos tarefas da operacao\"><br>
                               Listar Tarefas
                       </a>
                   </div>";
        }

        return $str;
    }

    /**
     * listagem de tarefas de programacao
     * @param type $complemento
     * @param type $limit Limitar em 20 linhas se TRUE
     * @return string
     */
    public function tarfLista($complemento, $limit = TRUE) {
        $consulta = "    SELECT cod,
                                resp,
                                doc,
                                date_format(dataexc, '%d/%m/%Y') dia,
                                date_format(dataexc, '%m') mes,
                                date_format(horaini, '%k:%i') hora_ini,
                                date_format(horafim, '%k:%i') hora_fim,
                                date_format(SUBTIME(horafim, horaini), '%k:%i') tempotrab,
                                CASE 
                                    WHEN situacao = 'concluida' THEN 'concluida'
                                    WHEN situacao = 'andamento' THEN 'andamento'
                                    WHEN situacao = 'cancelada' THEN 'cancelada'
                                END AS situ
                           FROM getar_tarfopera
                          WHERE situacao != 'temporario'
                                AND codopera = " . $this->get_codOpera() . "
                                " . $complemento . "
                       ORDER BY cod DESC";
        if ($limit) {
            $consulta.= " LIMIT 20";
        }
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
                                <th>Hora In&iacute;cio</th>
                                <th>Situa&ccedil;&atilde;o</th>
                                <th>Duracao</th>
                                <th>Inc&iacute;cio Descri&ccedil;&atilde;o</th>
                            </tr>
                        </thead>
                        <tbody>";
            $dataAnt = "";
            $dataList = "";
            $mesAnt = "";
            $mesList = "";
            while ($dados = arraySQL($resultado)) {
                $style = "";
                if ($dados["situ"] == "cancelada") {
                    $style = " style=\"text-decoration:line-through;\"";
                }
                // separando por dia
                $dataList = $dados['dia'];
                if ($dataList <> $dataAnt) {
                    $str.=" <tr class=\"" . corLinha() . "\">
                                <th>&nbsp;</th>
                                <th>" . $dataList . "</th>
                                <td colspan=\"4\">&nbsp;</td>
                            </tr>";
                }
                // trocando de mes
                $mesList = $dados['mes'];
                if ($mesList <> $mesAnt) {
                    $str.=" <tr class=\"" . corLinha() . "\">
                                <th>&nbsp;</th>
                                <th>" . mesExtBR($mesList) . "</th>
                                <td colspan=\"5\">&nbsp;</td>
                            </tr>";
                }
                $str.="
                <tr " . $style . " class=\"" . corLinha() . "\">
                    <th>" . $dados['cod'] . "</th>
                    <td>" . $dados['resp'] . "
                        <a href=\"index.php?st=tarfopera&pag=edit&codTarefa=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                        </a>
                    </td>
                    <td>" . $dados['hora_ini'] . "</td>
                    <td>" . $dados["situ"] . "</td>
                    <td>" . $dados['tempotrab'] . "&nbsp;</td>
                    <td>
                        <textarea cols=\"80\" rows=\"4\" class=\"txt\" readonly=\"\">" . $dados["doc"] . "</textarea>
                    </td>
                </tr>";
                $dataAnt = $dados['dia'];
                $mesAnt = $dados['mes'];
            };
            $consulta = " SELECT SUM((TIME_TO_SEC(horafim) - TIME_TO_SEC(horaini))) tempo
                                      FROM getar_tarfopera
                                     WHERE situacao != 'temporario'
                                           AND codopera = '" . $this->get_codOpera() . "'
                                           " . $complemento;
            $dados = $this->consultaSQL($consulta);
            $tempo = $dados['tempo'];
            $hora = floor($tempo / 3600);
            $minuto = round(($tempo / 60) % 60, 2);
            $str.="
            <tr>
                <td colspan=\"5\" class=\"sub-titulo\" align=\"right\">
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
        $consulta = "SELECT situacao FROM getar_pedidos WHERE cod='" . $this->get_codOpera() . "'";
        $dados = $this->consultaSQL($consulta);
        if ($dados["situacao"] != "x") {
            $str.="<a href=\"index.php?st=tarfopera&pag=edit&codoper=" . $this->get_codOpera() . "\" accesskey=\"n\">
                        <img src=\"imagens/novo.jpg\" alt=\"Nova Tarefa\" title=\"Criar nova tarefa para o Operacao\"><br>
                        Tarefa Nova.
                    </a>";
        } else {
            $str.= "Atividade Cancelada";
        }

        $str.="</div>
            <div id=\"elemento\">
                    <a href=\"index.php?st=tarfopera&pag=list&codoper=" . $this->get_codOpera() . "\">
                        <img src=\"imagens/livro.gif\" alt=\"Listar Tarefas\" title=\"Listar Suas Tarefas em Andamento\"><br>
                        Listar Tarefas
                    </a>
                </div>";

        if (atrib("42")) {
            $str.="
                <div id=\"elementoAdmin\">
                    <a href=\"index.php?st=tarfopera&pag=list_adm&codoper=" . $this->get_codOpera() . "\">
                        <img src=\"imagens/livro.gif\" alt=\"Listar Todas\" title=\"Listar Todos Tarefas- N&iacute;vel Administrador\"><br>
                        Listar Todas<br />
                        Nivel Adm
                    </a>
                </div>";
        }
        $str.="</div>";
        return $str;
    }

    /**
     * Salva alteracoes no projeto
     */
    function operaSalvar() {
        $consulta = $this->opera_Cons05();
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
    public function operaSwitch($pag) {
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
     * Detalhar um projeto sem opcoes de edicao
     * @return string
     */
    function operaDetal() {
        $consulta = "SELECT opr.cod,
                            opr.tag,
                            opr.nome,
                            opr.resp,
                            opr.descr,
                            DATE_FORMAT(opr.datareg, '%d/%m/%Y') datareg,
                            opr.situacao
                       FROM getar_opera opr
                      WHERE opr.cod= " . $this->codOpera;
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);


        $str = "<form action='' method='post'>
                <fieldset>
                <legend>Dados do Projeto</legend>
                <label>C&oacute;digo :</label><b>" . $this->codOpera . "</b><br>
                <label>Tag :</label><b>" . $dados["tag"] . "</b><br>
                <label>Nome: </label><b>" . $dados["nome"] . "</b><br>
                <label>Responsavel:</label><b>" . $dados['resp'] . "</b><br>";
        $str.= "<label>Descri&ccedil&atilde;o: </label><textarea name=\"descr\" cols=\"40\" rows=\"3\" disabled=\"\">" . $dados["descr"] . "</textarea><br>
                <label>Data Registro: </label><b>" . $dados["datareg"] . "</b><br>
                <label>Situa&ccedil;&atilde;o: </label>" . $this->operSitu($dados['situacao']) . "<br>
            </fieldset></form>";

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
    function operaEdit() {
        if ($this->codOpera == "") {
            //Cria o temporario
            $consulta = "INSERT INTO getar_opera ( tag, nome, resp, datareg, descr, situacao)
                         VALUES('TM001', 'Operacional Novo', '" . $_SESSION['resp'] . "', CURDATE(), 'Descricao do projeto', 'temporario');";
            $this->executaIdSQL($consulta);
            $codOpera = $this->get_idRet();
            $this->set_codOpera($codOpera);
            $this->set_tag('TM001');
        }

        //  Carrega para edicao
        $consulta = "SELECT cod,
                            tag,
                            clasf,
                            nome,
                            resp,
                            descr,
                            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                            situacao
                       FROM getar_opera
                      WHERE cod= " . $this->codOpera;
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);


        $str = "<form action='index.php?st=opera&pag=edit&codopr=" . $this->codOpera . "' method='post'>
                <input type='hidden' name='codopera' value='" . $this->codOpera . "'>
            <fieldset>
                <legend>Dados do Projeto</legend>
                <label>C&oacute;digo :</label><b>" . $this->codOpera . "</b><br>
                <label>Tag :</label><input name='tag' type='text' size='42' maxlength='40' value=\"" . $dados["tag"] . "\"><br>
                <label>Clasfica&ccedil;&atilde;o :</label>" . $this->selectClasf($dados["clasf"]) . "<br>
                <label>Nome: </label><input name='nome' type='text' size='42' maxlength='40' value=\"" . $dados["nome"] . "\"><br>
                <label>Responsavel:</label>";
        $str.= $this->selectResp($dados['resp'], 41) . "<br>";
        $str.= "<label>Descri&ccedil&atilde;o: </label><textarea name=\"descr\" cols=\"40\" rows=\"3\">" . $dados["descr"] . "</textarea><br>
                <label>Data Registro: </label><b>" . $dados["datareg"] . "</b><br>
                <label>Situa&ccedil;&atilde;o: </label>" . $this->operSitu($dados['situacao']) . "<br>
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
    public function operSitu($situ) {
        $str = "<select name=\"situacao\">
                    <option value=\"espera\" " . $this->selectedIf($situ, "espera") . ">em espera</option>
                    <option value=\"ativo\" " . $this->selectedIf($situ, "ativo") . ">ativo</option>
                    <option value=\"fechado\" " . $this->selectedIf($situ, "fechado") . ">fechado</option>
                </select>";

        return $str;
    }

    /**
     * Cadastro e edicao de tarefas
     * @return string
     */
    public function tarfEdit() {
        //  Cadastra provissoria
        if ($this->get_codTarf() == "") {
            $doc = "Descricao inicial da Tarefa.";

            $consulta = "INSERT INTO getar_tarfopera (resp, codopera, dataexc, horaini, doc, situacao)
                         VALUES ('" . $_SESSION['resp'] . "', " . $this->get_codOpera() . ", CURDATE(), " . $this->curtimeFuso() . ", '" . $doc . "', 'andamento')";
            $this->msg = $this->executaIdSQL($consulta);
            $this->set_codTarf($this->get_idRet());
        }

        // Para edicao
        $consulta = $this->tarf_Cons01($this->get_codTarf());
        $resultado = $this->retornoSQL($consulta);
        $dados = $this->arraySQL($resultado);

        //Correcao da hora final de tarefas nao concluidas
        if (($dados['situ'] <> "concluido") && ($dados['hora_fim'] == '0:00')) {
            $dados['hora_fim'] = "";
        }
        if ($dados['hora_ini'] == "0:00") {
            $dados['hora_ini'] = "";
        }

        $str = "
    <form name=\"formTarefa\" action=\"index.php?st=tarfopera&pag=edit&codTarefa=" . $this->get_codTarf() . "\" method=\"post\" onSubmit=\"return validaFormTarf()\">
         <fieldset>
            <legend>Detalhamento da Tarefa</legend>
            <label>C&oacute;digo: </label><b>" . $this->get_codTarf() . "</b><br>
            <label>Respons&aacute;vel :</label>" . $this->selectResp($dados['resp'], "41") . "<br>
            <label>Data: </label><b>" . $dados['dia'] . "</b><br>
            <label>Hora In&iacute;cio: </label>
            <input name=\"horaini\" type=\"time\" id=\"horaini\" value=\"" . $dados['hora_ini'] . "\" onclick=\"agora('horaini', this.value);\"><br>
            <label>Hora Fim: </label>
            <input name=\"horafim\" type=\"time\" id=\"horafim\" value=\"" . $dados['hora_fim'] . "\" onclick=\"agora('horafim', this.value);\"><br>
            <label>Documenta&ccedil;&atilde;o: </label><textarea name=\"doc\" cols=\"80\" rows=\"10\" id=\"doc\" autofocus=\"\">" . $dados['doc'] . "</textarea><br>
            <label>Situacao: </label>
                    <select name=\"situacao\">
                        <option value=\"andamento\" " . $this->selectedIf($dados["situ"], "andamento") . ">Andamento</option>
                        <option value=\"concluida\" " . $this->selectedIf($dados["situ"], "concluida") . ">Conclu&iacute;da</option>
                        <option value=\"cancelada\" " . $this->selectedIf($dados["situ"], "cancelada") . ">Cancelada</option>
                    </select><br>
            <label>&nbsp;</label><input name=\"salvartarf\" type=\"submit\" value=\"Editar\"><br>
            " . $this->msg . "
        </fieldset>
    </form>";

        return $str;
    }

    /**
     * monta um cabacalho para as tarefas
     * @return string
     */
    public function tarfCab() {
        // Identificar o projeto

        $consulta = " SELECT cod, 
                             nome
                        FROM getar_opera
                       WHERE cod=" . $this->get_codOpera();

        $dados = consultaSQL($consulta);
        $str = "<div class=\"titulo\">TAREFAS DA ATIVIDADE OPERACIONAL</div>
                <div class=\"sub-titulo\" style=\"margin-bottom: 3px;\">
                    Projeto: <b>" . $dados["nome"] . "</b>
                    <a href=\"index.php?st=opera&pag=edit&codopr=" . $dados["cod"] . "\">
                        <img src=\"imagens/livro.gif\" alt=\"\" width=\"16\" height=\"16\" border=\"0\">
                    </a>
                </div>
               ";

        return $str;
    }

/**
 * Select para as classificacoes das Atividades Operacionais
 * @param type $clasf
 * @return string
 */
    public function selectClasf($clasf) {
    $consulta = "SELECT cod,
                        titulo
                  FROM  getar_clasfopera
                  WHERE situacao = 'ativo'";
    $retorno = retornoSQL($consulta);
    $str = "<select name=\"clasf\">
                        <option value=\"\">Selecione</option>";
    while ($dados = arraySQL($retorno)) {
        $str .= "<option value=\"" . $dados["titulo"] . "\" " . selectedIf($dados["titulo"], $clasf) . " >" . $dados["titulo"] . "</option>";
    }
    $str .= "</select>";

    return $str;
}
    
    /**
     * Consulta protegida das listagem das atividades operacionais
     * @param type $complemento
     * @return string
     */
    public function operaConsulta($complemento){
        $consulta = $this->opera_Cons03($complemento);
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);

        if ($rows < 1) {
            $str = "<br /><b style=\"color: red;\">N&atilde;o h&aacute; retorno para" . $complemento . "</b>";
            return $str;
        }
        
        return $resultado;
    }
}

