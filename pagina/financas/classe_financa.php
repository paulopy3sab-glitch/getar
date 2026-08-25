<?php

/**
 * Descricao: para contas pagar/receber e contas correntes
 * Data criacao: Setembro/2016
 * @author Paulo Retis <paulo_schw@yahoo.com.br>
 * Revisao: 
 */
class Financa extends Conex {

    use Fnccons;

//
    private $mesPesq;
    private $erro;
    private $msg;
    private $dataIni;
    private $dataFim;
    private $numParc;
    private $jurosParc;
//
    private $codCarne;
    private $codCad;
    private $codCtCo;
    private $finc;
    private $tipoCarne;
    private $projetado;
    private $objeto;
    private $valorTot;
    private $dataCarne;
    private $obsCarne;
    private $situCarne;
//
    private $codParc;
    private $parcNum;
    private $dataVncParc;
    private $valorParc;
    private $obsParc;
    private $situParc;
//
    private $codConta;
    private $nomeConta;
    private $descrConta;
    private $moeda;
    private $situConta;
//
    private $codLanca;
    private $dataLanca;
    private $descrLanca;
    private $valorCred;
    private $valorDeb;
    private $respLanca;
    private $situLanca;
    private $obsLanca;
//
    private $codClasf;
    private $nomeClasf;
    private $descrClasf;
    private $situClasf;
    //Periodos das conta correntes
    private $codPer;
    private $nomePer;
    private $dataIniPer;
    private $dataFimPer;
    private $situPer;

    function __construct() {
        parent::__construct();
    }

    //Periodos das conta correntes
    public function get_situPer() {
        return $this->situPer;
    }

    public function get_dataFimPer() {
        return $this->dataFimPer;
    }

    public function get_dataIniPer() {
        return $this->dataIniPer;
    }

    public function get_nomePer() {
        return $this->nomePer;
    }

    public function get_codPer() {
        return $this->codPer;
    }

    public function set_situPer($situPer) {
        $this->situPer = $situPer;
    }

    public function set_dataFimPer($dataFimPer) {
        $this->dataFimPer = $dataFimPer;
    }

    public function set_dataIniPer($dataIniPer) {
        $this->dataIniPer = $dataIniPer;
    }

    public function set_nomePer($nomePer) {
        $this->nomePer = $nomePer;
    }

    public function set_codPer($codPer) {
        $this->codPer = $codPer;
    }

    //Parcelamentos
    public function get_numParc() {
        return $this->numParc;
    }

    public function set_numParc($numParc) {
        $this->numParc = $numParc;
    }

    public function get_jurosParc() {
        return $this->jurosParc;
    }

    public function set_jurosParc($jurosParc) {
        $this->jurosParc = $jurosParc;
    }

    public function get_mesPesq() {
        return $this->mesPesq;
    }

    public function set_mesPesq($mesPesq) {
        $this->mesPesq = $mesPesq;
    }

    public function get_msg() {
        return $this->msg;
    }

    public function set_msg($msg) {
        $this->msg = $msg;
    }

    public function get_erro() {
        return $this->erro;
    }

    public function set_erro($erro) {
        $this->erro = $erro;
    }

    public function get_dataIni() {
        return $this->dataIni;
    }

    public function set_dataIni($dataIni) {
        $this->dataIni = $dataIni;
    }

    public function get_dataFim() {
        return $this->dataFim;
    }

    public function set_dataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function get_codCarne() {
        return $this->codCarne;
    }

    public function set_codCarne($codCarne) {
        $this->codCarne = $codCarne;
    }

    public function get_codCad() {
        return $this->codCad;
    }

    public function set_codCad($codCad) {
        $this->codCad = $codCad;
    }

    public function get_codCtCo() {
        return $this->codCtCo;
    }

    public function set_codCtCo($codCtCo) {
        $this->codCtCo = $codCtCo;
    }

    public function get_finc() {
        return $this->finc;
    }

    public function set_finc($finc) {
        $this->finc = $finc;
    }

    public function get_tipoCarne() {
        return $this->tipoCarne;
    }

    public function set_tipoCarne($tipoCarne) {
        $this->tipoCarne = $tipoCarne;
    }

    public function get_projetado() {
        return $this->projetado;
    }

    public function set_projetado($projetado) {
        $this->projetado = $projetado;
    }

    public function get_objeto() {
        return $this->objeto;
    }

    public function set_objeto($objeto) {
        $this->objeto = $objeto;
    }

    public function get_valorTot() {
        return $this->valorTot;
    }

    public function set_valorTot($valorTot) {
        $this->valorTot = $valorTot;
    }

    public function get_dataCarne() {
        return $this->dataCarne;
    }

    public function set_dataCarne($dataCarne) {
        $this->dataCarne = $dataCarne;
    }

    public function get_obsCarne() {
        return $this->obsCarne;
    }

    public function set_obsCarne($obsCarne) {
        $this->obsCarne = $obsCarne;
    }

    public function get_situCarne() {
        return $this->situCarne;
    }

    public function set_situCarne($situCarne) {
        $this->situCarne = $situCarne;
    }

    public function get_codParc() {
        return $this->codParc;
    }

    public function set_codParc($codParc) {
        $this->codParc = $codParc;
    }

    public function get_parcNum() {
        return $this->parcNum;
    }

    public function set_parcNum($parcNum) {
        $this->parcNum = $parcNum;
    }

    public function get_dataVncParc() {
        return $this->dataVncParc;
    }

    public function set_dataVncParc($dataVncParc) {
        $this->dataVncParc = $dataVncParc;
    }

    public function get_valorParc() {
        return $this->valorParc;
    }

    public function set_valorParc($valorParc) {
        $this->valorParc = $valorParc;
    }

    public function get_obsParc() {
        return $this->obsParc;
    }

    public function set_obsParc($obsParc) {
        $this->obsParc = $obsParc;
    }

    public function get_situParc() {
        return $this->situParc;
    }

    public function set_situParc($situParc) {
        $this->situParc = $situParc;
    }

    public function get_codConta() {
        return $this->codConta;
    }

    public function set_codConta($codConta) {
        $this->codConta = $codConta;
    }

    public function get_nomeConta() {
        return $this->nomeConta;
    }

    public function set_nomeConta($nomeConta) {
        $this->nomeConta = $nomeConta;
    }

    public function get_descrConta() {
        return $this->descrConta;
    }

    public function set_descrConta($descrConta) {
        $this->descrConta = $descrConta;
    }

    public function get_moeda() {
        return $this->moeda;
    }

    public function set_moeda($moeda) {
        $this->moeda = $moeda;
    }

    public function get_situConta() {
        return $this->situConta;
    }

    public function set_situConta($situConta) {
        $this->situConta = $situConta;
    }

    public function get_codLanca() {
        return $this->codLanc;
    }

    public function set_codLanca($codLanca) {
        $this->codLanc = $codLanca;
    }

    public function get_dataLanca() {
        return $this->dataLanca;
    }

    public function set_dataLanca($dataLanca) {
        $this->dataLanca = $dataLanca;
    }

    public function get_descrLanca() {
        return $this->descrLanca;
    }

    public function set_descrLanca($descrLanca) {
        $this->descrLanca = $descrLanca;
    }

    public function get_valorCred() {
        return $this->valorCred;
    }

    public function set_valorCred($valorCred) {
        $this->valorCred = $valorCred;
    }

    public function get_valorDeb() {
        return $this->valorDeb;
    }

    public function set_valorDeb($valorDeb) {
        $this->valorDeb = $valorDeb;
    }

    public function get_respLanca() {
        return $this->respLanca;
    }

    public function set_respLanca($respLanca) {
        $this->respLanca = $respLanca;
    }

    public function get_situLanca() {
        return $this->situLanca;
    }

    public function set_situLanca($situLanca) {
        $this->situLanca = $situLanca;
    }

    public function get_obsLanca() {
        return $this->obsLanca;
    }

    public function set_obsLanca($obsLanca) {
        $this->obsLanca = $obsLanca;
    }

    public function get_codClasf() {
        return $this->codClasf;
    }

    public function set_codClasf($codClasf) {
        $this->codClasf = $codClasf;
    }

    public function get_nomeClasf() {
        return $this->nomeClasf;
    }

    public function set_nomeClasf($nomeClasf) {
        $this->nomeClasf = $nomeClasf;
    }

    public function get_descrClasf() {
        return $this->descrClasf;
    }

    public function set_descrClasf($descrClasf) {
        $this->descrClasf = $descrClasf;
    }

    public function get_situClasf() {
        return $this->situClasf;
    }

    public function set_situClasf($situClasf) {
        $this->situClasf = $situClasf;
    }

    /**
     * opcoes de rodape para as contas pagar e receber
     * @return string
     */
    public function carneOpcoes() {

        $str = "<div id=\"opcoes\">
                <div id=\"elemento\">
                    <a href=\"index.php?st=financaspr&ft=fnc&pag=carnenv&tipo=pagar\" accesskey=\"n\">
                        <img src=\"imagens/novo.jpg\" alt=\"Novo Carne Pagar\" title=\"Novo Parcelamento (Carne) a Pagar\"><br>
                        Novo<br>
                        Parcelamento a Pagar
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=financaspr&ft=fnc&pag=carnenv&tipo=receber\">
                        <img src=\"imagens/editar.gif\" alt=\"Novo Carne Receber\" title=\"Novo Parcelmento (Carne) a Receber\"><br>
                        Novo<br>
                        Parcelamento a Receber
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=financaspr&ft=fnc&pag=listvenc\">
                        <img src=\"imagens/grupo.gif\" alt=\"Lista Vencidas\" title=\"Listar Todas Vencidas\"><br>
                        Listagem:<br />
                        Vencidas
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=financaspr&ft=fnc&pag=listabt\">
                        <img src=\"imagens/grupo.gif\" alt=\"Lista Aberta\" title=\"Listagem geral de todas em aberta\"><br>
                        Listagem:<br />
                        Abertas
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=financaspr&ft=fnc&pag=listmes&mes=" . date('m') . "\">
                        <img src=\"imagens/grupo.gif\" alt=\"Lista Mes\" title=\"Listar as do mes em curso\"><br>
                        Listagem:<br />
                        " . $this->mesExtBR(date('m')) . "
                    </a>
                </div>
            </div>";

        return $str;
    }

    public function m_carneOpcoes() {
        $str = "<div id=\"opcoes\">
                <div id=\"elemento\">
                    <a href=\"m-index.php?st=financaspr&ft=fnc&pag=listvenc\">
                        <img src=\"imagens/grupo.gif\" width=\"32\" height=\"32\" alt=\"\" border=\"no\"><br>
                        Listagem:<br />
                        Vencidas
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"m-index.php?st=financaspr&ft=fnc&pag=listmes&mes=" . date('m') . "\">
                        <img src=\"imagens/grupo.gif\" width=\"32\" height=\"32\" alt=\"\" border=\"no\"><br>
                        Listagem:<br />
                        " . $this->mesExtBR(date('m')) . "
                    </a>
                </div>
            </div>";

        return $str;
    }

    /**
     * Listagem de contas pagar e receber
     * @param type $complemento
     * @return string $str
     */
    public function carneList($complemento) {
        $resultado = $this->retornoSQL($this->fnc_cons01($complemento));

        return $resultado;
    }

    /**
     * Listagem para mobile
     * @param type $complemento
     * @return string
     */
    public function m_carneList($complemento) {
        $resultado = $this->retornoSQL($this->fnc_cons01($complemento));

        $str = "<table>
                <caption>Listagem Parcelas Geral.</caption>
                <thead>
                    <tr>
                        <th>Parcela</th>
                        <th>Credor/Pagador</th>
                        <th>Data</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $valorCredito = null;
            $valorDebito = null;
            if ($dados['tipo'] == "receber") {
                $valorCredito = $dados['valorpar'];
            } else {
                $valorDebito = $dados['valorpar'];
            }
            $style = "";
            if ($dados["situacao"] == "cancelada") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str .= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                    <td class=\"txt\" valign=\"top\">
                        Parcela No.: " . $dados['parnum'] . "(" . $dados['situacao'] . ") ";

            $str .= " <a href=\"m-index.php?st=financaspr&ft=fnc&pag=detalpar&codpar=" . $dados['codpar'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                        </a>";

            $str .= "</td>
                    <td class=\"txt\" valign=\"top\">" . $dados['nome'] . "</td>
                    <td class=\"txt\" valign=\"top\">" . $dados['datavnc'] . "</td>
                    <td class=\"txt\" valign=\"top\">&nbsp;" . $valorCredito . $valorDebito . "</td>
                </tr>";
        }
        $str .= "</tbody></table>";

        return $str;
    }

    /**
     * Switch para contas a pagar e receber
     * @param string $pag
     */
    public function carneSwitch($pag) {
        $complemento = "";
        switch ($pag) {
            case 'carnenv':// Para criar um carne novo
                $complemento = " AND cn.cod= 0"; // para bloquear listagem
                break;
            case 'edit':
                $complemento = " AND cn.cod= 0"; // para bloquear listagem
                break;
            case 'editpar':
                $complemento = " AND pr.cod = " . $this->get_codParc();
                break;
            case 'detalpar':
                $complemento = " AND pr.cod = " . $this->get_codParc();
                break;
            case 'pagar':
                $complemento = " AND pr.cod = " . $this->get_codParc();
                break;
            case 'list':
                $complemento = "";
                break;
            case 'listmes':
                $complemento = " AND pr.situacao NOT IN ('cancelada')
                                 AND MONTH(pr.datavnc) = '" . $this->get_mesPesq() . "'
                                 AND YEAR(pr.datavnc) = YEAR(CURDATE())";
                break;
            case 'listvenc':
                $complemento = " AND pr.situacao = 'aberta'
                         AND pr.datavnc < CURDATE()";
                break;
            case 'listper':
                $complemento = " AND pr.situacao NOT IN ('cancelada')
                                 AND pr.datavnc BETWEEN '" . $this->get_dataIni() . "'
                                 AND '" . $this->get_dataFim() . "'";
                break;
            case 'listcom':
                $complemento = " AND pr.situacao = 'comprev'";
                break;
            case 'listsem':
                $complemento = " AND pr.situacao = 'semprev'";
                break;
            case 'listpend':
                $complemento = " AND pr.situacao = 'pend'";
                break;
            case 'listhoje':
                $complemento = " AND pr.situacao NOT IN ('cancelada')
                                AND pr.datavnc = CURDATE()";
                break;
            case 'listabt':
                $complemento = " AND pr.situacao NOT IN('paga', 'cancelada') ";
                break;
            default:
                $complemento = "";
        }

        return$complemento;
    }

    /**
     * Editar um carne
     * @return string
     */
    public function carneEdit() {

        $consulta = "SELECT cn.cod,
                            cn.codcad,
                            cad.nome,
                            cn.codctco,
                            cn.codclasf,
                            cn.tipo,
                            cn.projetado,
                            cn.objeto,
                            (SELECT COUNT(*)FROM conta_carnepar WHERE codcarne= cn.cod) numparc,
                            (SELECT ROUND(SUM(`valorpar`), 2) FROM conta_carnepar WHERE codcarne= cn.cod) valorpag,
                            date_format(par.datavnc, '%d/%m/%Y') priparc,
                            ROUND(cn.valortot, 2) valortot,
                            cn.obs,
                            cn.situacao
                       FROM getar_cad cad,
                            conta_carne cn,
                            conta_carnepar par
                      WHERE cn.codcad = cad.cod
                            AND codcarne= cn.cod
                            AND parnum = 1
                            AND cn.cod =" . $this->get_codCarne();
        $dados = $this->consultaSQL($consulta);

        if ($dados['cod'] <> $this->get_codCarne()) {
            $this->set_erro(TRUE);
        }

        return $dados;
    }

    /**
     * Cria um carne novo (pagar/receber
     * @param type $tipo
     * @param type $codCad
     * @return string
     */
    public function carneNovo() {
        $consulta = "INSERT INTO conta_carne (codcad, codctco, finc, tipo, valortot, datacarne, situacao)
                                           VALUES(2, 1, '" . $this->get_resp() . "', '" . $this->get_tipoCarne() . "', 0, CURDATE(), 'temporario')";
        $msg = $this->executaIdSQL($consulta);
        $this->set_msg($msg);
        $this->set_codCarne($this->get_idRet());

        $consulta = "SELECT cnt.cod,
                            cnt.codcad,
                            cad.nome,
                            cnt.codctco,
                            cnt.codclasf,
                            cnt.tipo,
                            cnt.projetado,
                            cnt.objeto,
                            cnt.obs,
                            cnt.situacao
                       FROM getar_cad cad,
                            conta_carne cnt
                      WHERE cnt.codcad = cad.cod
                            AND cnt.cod = " . $this->get_codCarne();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * select com cliente ou fornecedores (pagar)
     * @param string $tipo pagar - receber
     * @param int $codCad
     * @return string
     */
    public function selectAgente($tipo, $codCad = 0) {
        if ($tipo == "pagar") {
            $clasf = 'r';
            $agente = "Credor";
        } else {
            $clasf = 'c';
            $agente = "Pagador";
        }
        $consulta = "SELECT cod, nome FROM getar_cad WHERE clasf = '" . $clasf . "' AND situacao = 'ativo' ORDER BY nome";
        $resultado = $this->retornoSQL($consulta);

        $str = "<select name=\"codcad\">
                <option value=\"0\">Selecione " . $agente . "</option>";
        while ($dados = $this->arraySQL($resultado)) {
            $str .= "<option value=\"" . $dados['cod'] . "\" " . $this->selectedIf($dados['cod'], $codCad) . " >" . $dados['nome'] . "</option>";
        }

        $str .= "</select>";

        return $str;
    }

    /**
     * Select com conta correntes ativas
     * @param int $codCtCo
     * @return string $str
     */
    public function selectCtCo($codCtCo) {
        $consulta = "SELECT cod,
                            nome,
                            descr,
                            situacao
                       FROM getar_contanome
                      WHERE situacao = 'ativo'
                            AND inclcpr = 1";
        $resultado = $this->retornoSQL($consulta);
        $str = "<select name=\"codctco\">";
        while ($dados = $this->arraySQL($resultado)) {
            $str .= "<option value=\"" . $dados['cod'] . "\" " . $this->selectedIf($dados['cod'], $codCtCo) . ">" . $dados['nome'] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }

    /**
     * Select com a situacao do carne.
     * Se todas as parcelas estiverem canceladas: retorna cancelado
     * @param type $codCarne
     * @return string
     */
    public function carneSitu($codCarne) {
        $consulta = "SELECT CASE
                                WHEN parnum = parcanc THEN 'cancelado'
                                WHEN parnum != parcanc THEN 'ativo'
                            END situcarne
                       FROM(SELECT COUNT(*) parnum,
                                   (SELECT COUNT(*) parcanc
                                      FROM conta_carnepar cn2
                                     WHERE cn2.codcarne = cn1.codcarne
                                           AND cn2.situacao = 'cancelada') parcanc
                              FROM conta_carnepar cn1
                             WHERE cn1.codcarne = " . $codCarne . ") grp";
        $dados = $this->consultaSQL($consulta);
        $str = " <select name=\"situcarne\">
                    <option value=\"cancelado\" " . $this->selectedIf("cancelado", $dados['situcarne']) . " >Cancelado</option>
                    <option value=\"ativo\" " . $this->selectedIf("ativo", $dados['situcarne']) . " >Ativo</option>
                </select>";
        return $str;
    }

    /**
     * Edita ou cancela uma parcela em aberto
     * @global type $msg
     * @param type $codParc
     * @return string
     */
    function parcelaEdit($codParc) {
        $consulta = "SELECT pr.cod codpar,
                            pr.parnum,
                            cad.nome,
                            cn.cod codcarne,
                            cn.codclasf,
                            cn.codcad,
                            cn.codctco,
                            cn.tipo,
                            ct.nome contanome,
                            date_format(pr.datavnc, '%d') diavnc,
                            date_format(pr.datavnc, '%m') mesvnc,
                            date_format(pr.datavnc, '%Y') anovnc,
                            ROUND(pr.valorpar, 2) valorpar,
                            pr.obs,
                            pr.situacao
                       FROM getar_cad cad,
                            conta_carne cn,
                            conta_carnepar pr,
                            getar_contanome ct
                      WHERE cn.codcad = cad.cod
                            AND pr.codcarne = cn.cod
                            AND cn.codctco = ct.cod
                            AND pr.cod =" . $codParc;
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Para pagar uma parcela e lancar na conta correte
     * @return string
     */
    public function parcelaPagar($codParc) {
        $consulta = "SELECT pr.cod codpar,
                            pr.parnum,
                            cad.nome,
                            cn.cod codcarne,
                            cn.codctco,
                            cn.tipo,
                            ct.nome contanome,
                            date_format(pr.datavnc, '%d') diavnc,
                            date_format(pr.datavnc, '%m') mesvnc,
                            date_format(pr.datavnc, '%Y') anovnc,
                            ROUND(pr.valorpar, 2) valorpar,
                            pr.obs obspar,
                            cn.obs obscn,
                            pr.situacao
                       FROM getar_cad cad,
                            conta_carne cn,
                            conta_carnepar pr,
                            getar_contanome ct
                      WHERE cn.codcad = cad.cod
                            AND pr.codcarne = cn.cod
                            AND cn.codctco = ct.cod
                            AND pr.cod =" . $this->get_codParc();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Detalha um parcela paga
     * @param type $codParc
     * @return string
     */
    public function parcelaDetal($codParc) {

        $consulta = "SELECT pr.cod codpar,
                            pr.parnum,
                            cad.nome,
                            cad.cod codcad,
                            cn.cod codcarne,
                            cn.tipo,
                            ct.nome coct,
                            date_format(pr.datavnc, '%d/%m/%Y') datavnc,
                            date_format(pr.datapag, '%d/%m/%Y') datapag,
                            ROUND(pr.valorpar, 2) valorpar,
                            pr.situacao,
                            pr.obs
                       FROM getar_cad cad,
                            conta_carne cn,
                            conta_carnepar pr,
                            getar_contanome ct
                      WHERE cn.codcad = cad.cod
                            AND pr.codcarne = cn.cod
                            AND pr.cod =" . $codParc;
        $dados = $this->consultaSQL($consulta);
        if ($dados['tipo'] == "pagar") {
            $tipoAgente = "Credor";
        } else {
            $tipoAgente = "Cliente";
        }

        $str = "<div id=\"parcedit\">
            <div id=\"parcform\">
                <fieldset>
                    <legend>DETALHANDO UMA PARCELA</legend>
                    <label>" . $tipoAgente . ": </label><b>" . $dados['nome'] . "</b><br>
                    <label>Conta Corrente: </label><b>" . $dados['coct'] . "</b><br>
                    <label>Situa&ccedil;&atilde;o da parcela: </label><b>" . $dados['situacao'] . "</b><br>
                    <label>Situa&ccedil;&atilde;o da parcela: </label><b>" . $dados['situacao'] . "</b><br>
                    <label>Parcela n&uacute;mero: </label><b>" . $dados['parnum'] . "</b><br>
                    <label>Valor da Parcela: </label><b>" . $dados['valorpar'] . "</b><br>
                    <label>Data Vencimento: </label><b>" . $dados['datavnc'] . "</b><br>
                    <label>Data Pagamento: </label><b>" . $dados['datapag'] . "</b><br>
                    <label>Observa&ccedil;&atilde;o da Parcela: </label><br>
                    <textarea cols=\"40\" rows=\"3\" name=\"obs\" readonly=\"\">" . $dados['obs'] . "</textarea>
                </fieldset>
                </div>
        </div>
        <div id=\"parchist\"> ";

        $str .= $this->carneRelato($dados['codcad']);

        $str .= "</div>
                </div>";

        return $str;
    }

    /**
     * Rodape para contas correntes
     * @return string $str
     */
    public function contaOpcoes() {

        $str = "<div id=\"opcoes\">
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=editcor\" accesskey=\"n\">
                            <img src=\"imagens/novo.jpg\" alt=\"Nova conta corrente\" title=\"Nova Conta Corrente\"><br>
                            Nova Conta Corrente
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listcor\">
                            <img src=\"imagens/moedas.png\" alt=\"Listar Contas\" title=\"Listar contas corrente\"><br>
                            Contas Correntes<br />
                            Ativas
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listccnome\">
                            <img src=\"imagens/listar_.jpg\" alt=\"Listar Contas\" title=\"Listar contas corrente\"><br>
                            Contas Correntes<br />
                            TODAS
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listperativo\">
                            <img src=\"imagens/listar_.jpg\" alt=\"Listar Periodos\" title=\"Listar periodos das contas corrente\"><br>
                            Listar<br>
                            Per&iacute;odos Ativos
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listlanca\">
                            <img src=\"imagens/editar.gif\" alt=\"Fluxo de caixa\" title=\"Listar lancamentos da conta corrente ativa\"><br>
                            Fluxo Caixa de<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                </div>";

        return $str;
    }

    /**
     * Editar uma classificacao de uma conta corrente
     * @return string
     */
    function contaClasfEdit($codClasf) {

        if ($codClasf == "") {//  Cria o temporario
            $consulta = "INSERT INTO getar_contaclasf (cod, nomeconta, situacao)
                                VALUES('', '" . $_SESSION["contanome"] . "', 'temporario')";
            $msg = $this->executaIdSQL($consulta);
            $this->set_msg($msg);
            $codClasf = $this->get_idRet();
        }

        $consulta = "SELECT nome,
                            descr
                       FROM getar_contaclasf
                      WHERE cod= " . $codClasf;
        $dados = $this->consultaSQL($consulta);

        $str = "<form action=\"index.php?st=contaclasf&pag=edit&codclasf=" . $codClasf . "\" method=\"post\">
                    <input name=\"cod\" type=\"hidden\" value=\"" . $codClasf . "\">
                    <fieldset>
                        <legend>Dados da Classifica&ccedil;&atilde;o</legend>
                        <label>C&oacute;digo: </label><b>" . $codClasf . "</b><br>
                        <label>Nome: </label><input name='nome' type='text' size='22' maxlength='20' value=\"" . $dados["nome"] . "\"><br>
                        <label>Descri&ccedil;&atilde;o: </label><input name='descr' type='text' size='42' value=\"" . $dados["descr"] . "\"><br>
                        <label>&nbsp;</label><input name=\"salvar\" type=\"submit\" value=\"Editar\">
                    </fieldset>
                </form>";

        return $str;
    }

    /**
     * Cria uma conta corrente nova ou edita
     * @param type $codCtNm
     * @return string
     */
    public function contaNomeEdit($codCtCo) {
        //Cria um temporario
        if ($codCtCo == "") {
            $consulta = "INSERT INTO getar_contanome (cod, situacao) VALUES('', 'temporario')";
            $msg = $this->executaIdSQL($consulta);
            $this->set_msg($msg);
            $codCtCo = $this->get_idRet();
        }

        $consulta = "SELECT nome, descr, moeda, situacao FROM getar_contanome WHERE cod= " . $codCtCo;
        $dados = $this->consultaSQL($consulta);

        $str = "<form name=\"formContaNome\" action=\"index.php?st=financascc&ft=fnc&pag=editcor&codctco=" . $codCtCo . "\" method=\"post\">
                    <input name=\"cod\" type=\"hidden\" value=\"" . $codCtCo . "\">
                    <fieldset>
                        <legend>Dados da Conta Corrente.</legend>
                        <label>C&oacute;digo: </label><b>" . $codCtCo . "</b><br>
                        <label>Nome Conta: </label>
                        <input name=\"nome\" type=\"text\" size=\"22\" maxlength=\"20\" value=\"" . $dados["nome"] . "\" /><br>
                        <label>Descri&ccedil;&atilde;o:</label>
                        <textarea cols=\"60\" rows=\"3\" name=\"descr\">" . $dados['descr'] . "</textarea><br>
                        <label>Moeda:</label>
                        <select name=\"moeda\">
                            <option value=\"R$\" " . $this->selectedIf("R$", $dados['moeda']) . ">Real</option>
                            <option value=\"USS$\" " . $this->selectedIf("USS$", $dados['moeda']) . ">Dolar</option>
                        </select><br>
                        <label>Situacao</label>
                        <select name=\"situacao\">
                            <option value=\"ativo\" " . $this->selectedIf("ativo", $dados['situacao']) . ">Ativo</option>
                            <option value=\"inativo\" " . $this->selectedIf("inativo", $dados['situacao']) . ">Inativo</option>
                        </select><br>
                        <label>" . $this->get_msg() . "&nbsp;</label><input type=\"submit\" name=\"salvarCtNm\" value=\"Editar\">
                    </fieldset>
                </form>";

        return $str;
    }

    /**
     * Cria um carne novo apartir do temporario gerado
     */
    public function carneSalvar($contra) {
        // Validar contra senha se necessario
        if ($this->atrib("64")) {
            if (!$this->contraTst($contra)) {
                $msg = "<b style=\"color: red;\">Contra Senha Invalida<br />
                        Verifique Dados do Formul&aacute;rio!</b>";
                $this->set_msg($msg);
                $str = $this->carneNovo("");
                return $str;
            }
        }
        $codCarne = $this->get_codCarne();
        $codClasf = $this->get_codClasf();
        $codCtco = $this->get_codCtCo();
        $obs = $this->get_obsCarne();
        $codCad = $this->get_codCad();
        $valorTot = $this->formataValorMySQL($this->get_valorTot());
        $numParc = $this->get_numParc();
        //Validacao do dados do carne
        if ($codCad == "0") {
            $valida = 'nao';
            $str = "<b style=\"color: red;\">SELECIONE UM CREDOR/CLIENTE!!</b><br>";
            return $str;
        }
        if ($numParc == "0") {
            $valida = 'nao';
        } else {
            $valida = 'sim';
        }
        if ($numParc == "") {
            $valida = 'nao';
            $str = "<b style=\"color: red;\">DIGITE NUMERO DE PARCELAS!!</b><br>";
            return $str;
        } elseif ($numParc == 0) {
            $valida = 'nao';
            $str = "<b style=\"color: red;\">DIGITE NUMERO DE PARCELAS VALIDO!!</b><br>";
            return $str;
        }

        if ($valorTot <> "") {
            if (abs($valorTot) < 0) {
                $valida = 'nao';
                $str = "<b style=\"color: red;\">DIGITE UM VALOR TOTAL VALIDO!!</b><br>";
                return $str;
            }
        }
        if (isset($_POST['valorparc'])) {
            $valorParc = $_POST['valorparc'];
        } else {
            $valorParc = 0;
        }
        if ($valorParc <> "") {
            if ($valorParc < 0) {
                $valida = 'nao';
                $str = "<b style=\"color: red;\">DIGITE UM VALOR PARCELA VALIDO!!</b><br>";
                return $str;
            }
        }
        if (($valorTot == "") && ($valorParc == "")) {
            $valida = 'nao';
            $str = "<b style=\"color: red;\">DIGITE UM VALOR PARCELA OU VALOR TOTAL!!</b><br>";
            return $str;
        }

        if ($valida == "sim") {
            /* Se vai gerar um carne caso for um carne novo
              Primeiro sempre pelo valor parcela. Se houver */
            if ($valorParc > 0) {
                $valorTot = $valorParc * $numParc;
            } else {
                $valorParc = $valorTot / $numParc;
            }
//montagem da data de vencimento
            $diaPri = $_POST['diapri'];
            $mesPri = $_POST['mespri'];
            $anoPri = $_POST['anopri'];
            $dataVenc = $anoPri . "-" . $mesPri . "-" . $diaPri;
        }
        $consulta = "UPDATE conta_carne
                        SET codcad = " . $codCad . ",
                            codctco = " . $codCtco . ",
                            codclasf = " . $codClasf . ",
                            valortot = " . $valorTot . ",
                            obs = '" . $obs . "',
                            situacao= 'ativo'
                       WHERE cod = " . $codCarne;
        $this->msg = $this->executaSQL($consulta);
        // Gerando as parcelas
        for ($loop = 0; $loop < $numParc; $loop++) {
            $parnum = $loop + 1;
            $consulta = "INSERT INTO conta_carnepar (cod, parnum, codcarne, datavnc, valorpar, situacao)
                              VALUES(NULL, " . $parnum . ", " . $codCarne . ", '" . $dataVenc . "', '" . $valorParc . "', 'aberta')";
            $this->executaIdSQL($consulta);
            //$dataVencimento= date('Y/m/d', strtotime($dataVencimento."+ ".$intervalo." days"));
            $mesPri++;
            if ($mesPri > 12) {
                $mesPri = 1;
                $anoPri++;
            }
            $dataVenc = $anoPri . "-" . $mesPri . "-" . $diaPri;
        }
    }

    /**
     * Atualizar um carne
     */
    public function carneAtual() {
        $consulta = "UPDATE conta_carne
                        SET codctco = " . $this->get_codCtCo() . ",                            
                            codclasf = " . $this->get_codClasf() . ",
                            obs = '" . $this->get_obsCarne() . "'
                       WHERE cod = " . $this->get_codCarne();
        $this->msg = $this->executaSQL($consulta);

        // cancelar um carne se solicitado
        if ($this->get_situCarne() == "cancelado") {
            $this->carneCanc($this->get_codCarne());
        } elseif ($this->get_situCarne() == "ativo") {
            $this->carneAtiva($this->get_codCarne());
        }
    }

    /**
     * Para salvar o pagamento da parcela
     */
    public function parcelaSlPagar() {
        $consulta = "UPDATE conta_carnepar SET
                            valorpar= " . $this->formataValorMySQL($this->get_valorParc()) . ",
                            datavnc= '" . $this->get_dataVncParc() . "',
                            datapag= CURDATE(),
                            obs= 'parcela paga:\n" . $this->get_obsParc() . "',
                            situacao= 'paga'
                      WHERE cod=" . $this->get_codParc();
        $this->msg = $this->executaSQL($consulta);
        //registrando log        
        $str = "Parcela numero: " . $this->get_numParc() . ", de " . $this->cadNome($this->get_codParc()) . ".\n";
        $str .= "Valor R$ " . $this->get_valorParc() . " - Pagamento pendente.\n";
        $str .= "Vencimento para: " . $this->get_dataVncParc();
        $this->gravaLog($str);

        // Registro automatico como pendente na conta corrente
        $vlDebt = 0;
        $vlCredt = 0;
        if ($this->get_tipoCarne() == "pagar") {// eh debito
            $vlDebt = $this->formataValorMySQL($this->get_valorParc());
            $tpcls = 2; // Plano de contas: Custos operacionais
        } else {// ser for receber eh um credito
            $vlCredt = $this->formataValorMySQL($this->get_valorParc());
            $tpcls = 3; // Plano de contas: Faturamento
        }

        // Inserir lancamento na conta corrente
        $consulta = "INSERT INTO getar_contacor (codctco, custo, datalanca, descr, resp, peratu, cred, debt, codclasf, obs, situacao)
                                         VALUES (" . $this->get_codCtCo() . ",
                                                 0,
                                                 CURDATE(),
                                                'Pagto. Par.: " . $this->get_numParc() . " Credor: " . $this->cadNome($this->get_codParc()) . "',
                                                '" . $this->get_resp() . "',
                                                (SELECT cod FROM peratu WHERE codctco= " . $this->get_codCtCo() . " AND situacao= 'ativo'),
                                                " . $vlCredt . ",
                                                " . $vlDebt . ",
                                                " . $tpcls . ",
                                                '" . $this->get_obsParc() . "',
                                                'pend')";
        $this->executaSQL($consulta);
    }

    /**
     * Salvar a edicao de uma parcela
     */
    public function parcelaSlEdit() {
        $consulta = "UPDATE conta_carnepar SET
                            valorpar= " . $this->formataValorMySQL($this->get_valorParc()) . ",
                            datavnc= '" . $this->get_dataVncParc() . "',
                            datapag= CURDATE(),
                            situacao = '" . $this->get_situParc() . "',
                            obs= 'Parcela editada:\n" . $this->get_obsParc() . "'
                      WHERE cod=" . $this->get_codParc();
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);
        //registrando log        
        $str = "Parcela numero: " . $this->get_numParc() . ", de " . $this->cadNome($this->get_codParc()) . ".\n";
        $str .= "Valor R$ " . $this->get_valorParc() . " - Novo status: " . $this->get_situParc() . ".\n";
        $str .= "Vencimento para: " . $this->get_dataVncParc();
        $this->gravaLog($str);
    }

    /*
     * Salvando alteracoes no plano de contas e na conta C/C destino da conta a pagar/receber
     */

    public function contaSlEdit() {
        $consulta = "UPDATE conta_carne SET codctco= " . $this->get_codCtCo() . ", codclasf = " . $this->get_codClasf() . " WHERE cod = " . $this->get_codCarne();
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);
        //registrando log        
        $str = "Conta numero: " . $this->get_numParc() . " editada por " . $_SESSION['resp'] . ".\n";
        $this->gravaLog($str);
    }

    /**
     * Cancela o carne e todas suas parcelas
     * @param type $codCarne
     */
    public function carneCanc($codCarne) {
        $consulta = "UPDATE conta_carne SET situacao= 'cancelado' WHERE cod= " . $codCarne;
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);

        //Cancelar parcelas ativas
        $consulta = "UPDATE conta_carnepar
                       SET situacao= 'cancelada'
                     WHERE cod= " . $codCarne . "
                           AND situacao ='ativo'";
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);
    }

    /**
     * Reatva o carne e todas suas parcelas
     * @param type $codCarne
     */
    public function carneAtiva($codCarne) {
        $consulta = "UPDATE conta_carne SET situacao= 'ativo' WHERE cod= " . $codCarne;
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);

        //Ativar parcelas canceladas
        $consulta = "UPDATE conta_carnepar
                       SET situacao= 'ativa'
                     WHERE cod= " . $codCarne . "
                           AND situacao = 'cancelada'";
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);
    }

    /**
     * Carrega o nome e o codido da conta corrente em uso
     */
    public function contaFixa($codCtCo) {
        $consulta = "SELECT cod,
                            nome,
                            descr
                       FROM getar_contanome 
                      WHERE cod = " . $codCtCo;
        $dados = $this->consultaSQL($consulta);
        $codCtCo = $dados['cod'];
        $this->set_codCtCo($dados['cod']);
        $this->set_nomeConta($dados['nome']);
        $this->set_descrConta($dados['descr']);
    }

    /**
     * Switch para as contas correntes
     * @param string $pag
     * @return string $complemento
     */
    public function contaSwith($pag) {
        switch ($pag) {
            case 'editcor':
                $complemento = " AND nm.cod = " . $this->get_codCtCo(); // so para nao atrapalhar o WHERE
                break;
            case 'lancaedit':
                //include ("contacor-edita.inc.php");
                break;
            case 'contaSaldo':
                //echo geraSaldoCC();
                break;
            case 'listlanc':
                $complemento = " nome= '" . $this->get_nomeConta() . "'
                         AND peratu = (SELECT cod FROM peratu WHERE codctco = " . $this->get_codCtCo() . " AND situacao = 'ativo')
                         AND situacao NOT IN('temporario', 'inativo')
                ORDER BY ano_reg DESC, mes_reg DESC, dia_reg DESC";
                break;
            case 'listcor':
                $complemento = " AND nm.situacao NOT IN('temporario', 'inativo') 
                                 AND per.situacao = 'ativo' ";
                break;
            default :
                $complemento = " AND nm.situacao = 'ativo' ";
                break;
        }
        return $complemento;
    }

    /**
     * Listagem de contas correntes em uso
     * @param string $complemento
     * @return string $str
     */
    public function contaList($complemento) {
        $consulta = "SELECT nm.cod,
                            nm.nome,
                            nm.descr,
                            nm.moeda,
                           (SELECT SUM(cred)-SUM(debt)
                              FROM getar_contacor
                             WHERE peratu = per.cod
                                   AND situacao NOT IN('inativo', 'pend')) saldo,
                            nm.situacao
                       FROM getar_contanome nm,
                            peratu per
                      WHERE nm.cod = per.codctco 
                            " . $complemento . "
                   ORDER BY cod";
        $resultado = $this->retornoSQL($consulta);
        $str = "<table width=\"100%\">
                <caption>Contas Correntes - Listagem.</caption>
                <thead>
                    <tr>
                        <th class='sub-titulo'>C&oacute;digo</th>
                        <th class='sub-titulo'>Nome</th>
                        <th class='sub-titulo'>Descri&ccedil;&atilde;o</th>
                        <th class='sub-titulo'>Saldo</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = mysqli_fetch_array($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str .= "<tr " . $style . " class=\"" . $this->corLinha() . "\">
                <th>" . $dados["cod"] . "</th>
                <td>" . $dados["nome"] . "
                    <a href=\"index.php?st=financascc&ft=fnc&pag=editcor&codctco=" . $dados["cod"] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"\" title=\"Editar Conta Corrente\" border=\"no\">
                    </a>";
            if ($dados['situacao'] == 'ativo') {
                $str .= "&nbsp;
                       <a href=\"index.php?st=financascc&ft=fnc&pag=defcor&codctco=" . $dados["cod"] . "\">
                           <img src=\"imagens/visto.gif\" alt=\"\" title=\"Definir Conta Corrente\" border=\"no\">
                       </a>";
            }
            $str .= "</td>
                <td>" . $dados["descr"] . "</td>
                <td>" . $dados['moeda'] . "&nbsp;" . $dados["saldo"] . "</td>
            </tr>";
        }
        $str .= "</tbody></table>";

        return $str;
    }

    /**
     * Listagem de periodos de contat corrente
     * @param type $complemento
     * @return string
     */
    public function periodoList($complemento) {
        $consulta = "SELECT ctn.nome nomecc,
                            per.cod cod,
                            per.nome nomeper,
                           (SELECT SUM(cred)-SUM(debt)
                              FROM getar_contacor
                             WHERE peratu = per.cod) saldo,
                            DATE_FORMAT(per.dataini, '%d/%m/%Y') data_ini,
                            DATE_FORMAT(per.datafim, '%d/%m/%Y') data_fim,
                            per.situacao
                       FROM getar_contanome ctn,
                            peratu per
                      WHERE ctn.cod = per.codctco
                      " . $complemento . " 
                          ORDER BY cod DESC";
        $resultado = $this->retornoSQL($consulta);
        $str = "<table width=\"100%\">
                <caption>Periodos Conta Corrente</caption>
                <thead>
                    <tr>
                        <th class='sub-titulo'>C&oacute;digo</th>
                        <th class='sub-titulo'>Nome C/C</th>
                        <th class='sub-titulo'>Nome Per&iacute;odo</th>
                        <th class='sub-titulo'>Data In&iacute;cio</th>
                        <th class='sub-titulo'>Data Fim</th>
                        <th class='sub-titulo'>Situacao</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = mysqli_fetch_array($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                //$style = " style=\"text-decoration:line-through;\"";
                $style = "";
            }
            $str .= "<tr " . $style . " class=\"" . $this->corLinha() . "\">
                <th>" . $dados["cod"] . "</th>
                <td>" . $dados["nomecc"] . "
                    <a href=\"index.php?st=financascc&ft=fnc&pag=editper&cod=" . $dados["cod"] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"\" title=\"Editar Periodo\" border=\"no\">
                    </a>
                    <a href=\"index.php?st=financascc&ft=fnc&pag=listperlanca&cod=" . $dados["cod"] . "\">
                        <img src=\"imagens/lista.jpg\" style=\"width: 16px;\" alt=\"\" title=\"Lancamentos do Periodo\" border=\"no\">
                    </a>
                </td>
                <td>" . $dados["nomeper"] . "</td>
                <!--<td>" . formatarValorPadrao($dados["saldo"]) . "</td>-->
                <td>" . $dados["data_ini"] . "</td>
                <td>" . $dados["data_fim"] . "</td>
                <td>" . $dados["situacao"] . "</td>
            </tr>";
        }
        $str .= "</tbody></table>";

        return $str;
    }

    /**
     * Salvar alteracoes na conta corrente
     */
    public function contaSalvar() {
        $consulta = "UPDATE getar_contanome SET nome= '" . $this->get_nomeConta() . "',
                                               descr= '" . $this->get_descrConta() . "',
                                               moeda= '" . $this->get_moeda() . "',
                                               situacao= '" . $this->get_situConta() . "'
                                         WHERE cod=" . $this->get_codCtCo();
        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * Listagem das "classificacoes" plano de contas para os lancamentos
     * @param type $complemento
     * @return string
     * Revisao:
     * 03/05/2025 - tratar Plano de Contas, antes era clasfList(
     */
    public function plancoContas($complemento = "") {
        $consulta = "SELECT cl.cod,
                            cl.nome,
                            cl.codctco,
                            nm.nome contanome,
                            cl.descr,
                            cl.situacao
                       FROM getar_contaclasf cl,
                            getar_contanome nm
                      WHERE cl.codctco = nm.cod
                            AND cl.situacao NOT IN('temporario')
                            AND nm.cod= 1 " . $complemento;
        $resultado = $this->retornoSQL($consulta);
        $str = "<table width=\"100%\">
                <caption>Conta Corrente - " . $this->get_nomeConta() . ".</caption>
                <thead>
                    <tr>
                        <th class='sub-titulo'>C&oacute;digo</th>
                        <th class='sub-titulo'>Conta Corrente</th>
                        <th class='sub-titulo'>Nome Classificacao</th>
                        <th class='sub-titulo'>Descri&ccedil;&atilde;o</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = mysqli_fetch_array($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str .= "<tr " . $style . " class=\"" . $this->corLinha() . "\">
                <th>" . $dados["cod"] . "</th>
                <th>" . $dados["contanome"] . "</th>
                <td>" . $dados["nome"] . "
                    <a href=\"index.php?st=financascc&ft=fnc&pag=editclasf&codclasf=" . $dados['cod'] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"\" title=\"Editar Classificacao\" border=\"no\">
                    </a>
                </td>
                <td>" . $dados["descr"] . "</td>
            </tr>";
        }
        $str .= "</tbody></table>";

        return $str;
    }

    /**
     * Switch para as classificacoes
     * @param type $pag
     * @return string
     */
    public function clasfSwitch($pag) {
        switch ($pag) {
            case 'editclasf':
                $complemento = " AND cl.cod = " . $this->get_codClasf();
                break;
            case 'listclasf':
                $complemento = " AND cl.situacao NOT IN('temporario')
                                 AND  nm.cod= " . $this->get_codCtCo();
                break;
            default :
                $complemento = " AND cl.situacao NOT IN('temporario')
                                 AND nm.cod= " . $this->get_codCtCo();
                break;
        }

        return $complemento;
    }

    /**
     * Edita classificacao de lancamento
     * @return string
     */
    public function clasfEdit() {
        $codClasf = $this->get_codClasf();
        //Cria um temporario
        if ($codClasf == "") {
            $consulta = "INSERT INTO getar_contaclasf (codctco, situacao) VALUES(" . $this->get_codCtCo() . ", 'temporario')";
            $msg = $this->executaIdSQL($consulta);
            $this->set_msg($msg);
            $codClasf = $this->get_idRet();
            $this->set_codClasf($codClasf);
        }

        $consulta = "SELECT cl.cod,
                            cl.nome,
                            cl.codctco,
                            nm.nome contanome,
                            cl.descr,
                            cl.situacao
                       FROM getar_contaclasf cl,
                            getar_contanome nm
                      WHERE  cl.codctco = nm.cod
                            AND cl.cod = " . $codClasf;
        $dados = $this->consultaSQL($consulta);

        $str = "<form name=\"formClasf\" action=\"index.php?st=financascc&ft=fnc&pag=editclasf&codclasf=" . $codClasf . "\" method=\"post\">
                    <input name=\"codclasf\" type=\"hidden\" value=\"" . $codClasf . "\">
                    <fieldset>
                        <legend>Classificacao de Lancamentos para: <b>" . $dados['contanome'] . "</b>.</legend>
                        <label>C&oacute;digo: </label><b>" . $codClasf . "</b><br>
                        <label>Nome Classificacao: </label>
                        <input name=\"nome\" type=\"text\" size=\"22\" maxlength=\"20\" value=\"" . $dados["nome"] . "\" /><br>
                        <label>Descri&ccedil;&atilde;o:</label>
                        <input name=\"descr\" type=\"text\" size=\"42\" value=\"" . $dados["descr"] . "\" /><br>
                        <label>Situa&ccedil;&atilde;o</label>
                        <select name=\"situacao\">
                            <option value=\"ativo\" " . $this->selectedIf("ativo", $dados['situacao']) . ">Ativo</option>
                            <option value=\"inativo\" " . $this->selectedIf("inativo", $dados['situacao']) . ">Inativo</option>
                        </select><br>
                        <label>" . $this->get_msg() . "&nbsp;</label><input type=\"submit\" name=\"salvarClasf\" value=\"Editar\">
                    </fieldset>
                </form>";

        return $str;
    }

    /**
     * Edicao de um periodo de conta corrente
     * @return string
     */
    public function periodoEdit() {
        $consulta = "SELECT ctn.nome nomecc,
                            per.cod,
                            per.codctco,
                            per.nome nomeper, 
                            per.dataini,
                            per.datafim,
                            DATE_FORMAT(per.dataini, '%d/%m/%Y') data_ini,
                            DATE_FORMAT(per.datafim, '%d/%m/%Y') data_fim,
                            per.situacao
                       FROM getar_contanome ctn,
                            peratu per
                      WHERE ctn.cod = per.codctco
                            AND per.cod= " . $this->codPer;
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Salva alteracoes na classificacao
     */
    public function clasfSalvar() {
        $consulta = "UPDATE getar_contaclasf SET nome= '" . $this->get_nomeClasf() . "',
                                               descr= '" . $this->get_descrClasf() . "',
                                               situacao= '" . $this->get_situClasf() . "'
                                         WHERE cod=" . $this->get_codClasf();
        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * Salva altercoes nos periodos das contas correntes
     */
    public function periodoSalvar() {
        $consulta = " UPDATE peratu SET nome= '" . $this->get_nomePer() . "',
                                        codctco= " . $this->get_codCtCo() . ",
                                        dataini= '" . $this->get_dataIniPer() . "',
                                        datafim= '" . $this->get_dataFimPer() . "',
                                        situacao= '" . $this->get_situPer() . "'
                                  WHERE cod=" . $this->get_codPer();
        $this->msg = $this->executaSQL($consulta);
    }

    /**
     * Opcoes para as classificacoes
     * @return string
     */
    public function clasfOpcoes() {
        $str = "<div id=\"opcoes\">
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=editclasf\" accesskey=\"n\">
                            <img src=\"imagens/editar.gif\" alt=\"Nova conta corrente\" title=\"Nova Conta Corrente\"><br>
                            Nova Classifica&ccedil;&atilde;o<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listclasf&codctco=" . $this->get_codCtCo() . "\">
                            <img src=\"imagens/grupo.gif\" alt=\"Listar Classificacoes\" title=\"Listar Classificacoes para a conta corrente\"><br>
                            Classifica&ccedil;&otilde;es de<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listcor\">
                            <img src=\"imagens/grupo.gif\" alt=\"Listar Contas\" title=\"Listar contas corrente\"><br>
                            Listar<br>
                            Contas Correntes
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listlanca\">
                            <img src=\"imagens/editar.gif\" alt=\"Fluxo de caixa\" title=\"Listar lancamentos da conta corrente ativa\"><br>
                            Fluxo Caixa de<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                </div>";

        return $str;
    }

    /**
     * Listage do Fluxo de caixa
     * @param string $complemento
     * @return string $str
     */
    public function lancaList($complemento) {
        $consulta = "SELECT cc.cod,
                            cc.descr,
                            cc.cred,
                            cc.debt,
                            cl.nome clasf,
                            cc.resp,
                            date_format(cc.datalanca, '%d/%m/%Y') datalanca,
                            date_format(cc.datalanca, '%Y') ano_reg,
                            date_format(cc.datalanca, '%m') mes_reg,
                            date_format(cc.datalanca, '%d') dia_reg,
                            cc.obs,
                            (SELECT CONCAT(nome, ' (', DATE_FORMAT(dataini, '%d/%m/%Y'), ' - ', DATE_FORMAT(datafim, '%d/%m/%Y'), ')') AS peratu
                                       FROM peratu
                                      WHERE codctco = " . $this->get_codCtCo() . " # conta corrente
                                            AND situacao = 'ativo') peratu, # periodo atual
                            cc.situacao
                       FROM getar_contacor cc,
                            getar_contaclasf cl
                      WHERE  cc.codclasf = cl.cod
                             AND cc.codctco= " . $this->get_codCtCo() . "
                             " . $complemento . "
                    ORDER BY ano_reg DESC, mes_reg DESC, dia_reg DESC";
        $resultado = $this->retornoSQL($consulta);
        $str = "<table width=\"640px\">
                <caption>Fluxo de Caixa de: " . $this->get_nomeConta() . ".</caption>
                <thead>
                    <tr>
                        <th>C&oacute;digo</th>
                        <th>Descri&ccedil;&atilde;o</th>
                        <th>Classifica&ccedil;&atilde;o</th>
                        <th>Data</th>
                        <th>Cr&eacute;dito/D&eacute;bito</th>
                    </tr>
                </thead>
                <tbody>";
        $saldoFinal = 0;
        $peratu = "";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            if ($dados["situacao"] == "pend") {
                $style = " style=\"color: orange;\"";
            }
            $str .= "<tr class=\"" . $this->corLinha() . "\">
                <th " . $style . ">" . $dados["cod"] . "</th>
                <td " . $style . ">" . $dados["descr"] . "";
            if ($dados['cod'] != '0') {
                $str .= "  <a href=\"index.php?st=financascc&ft=fnc&pag=editlanca&codlanca=" . $dados['cod'] . "\">
                               <img src=\"imagens/editar.gif\" alt=\"\" title=\"Editar Lancamento\" border=\"no\">
                           </a>";
            }
            if ($dados['obs'] != "") {
                $str .= " <img src=\"imagens/exclama.gif\" alt=\"\" title=\"Tem observacao\" border=\"no\">";
            }

            $cor = "";
            $valor = "";
            if ($dados["situacao"] == 'ativo') {
                if ($dados["cred"] > 0) {
                    $valor = $dados["cred"];
                    $saldoFinal+= $valor;
                    $cor = "black";
                } else {
                    $valor = $dados["debt"];
                    $saldoFinal-= $valor;
                    $cor = "red";
                }
            }

            $str .= "</td>
                <td " . $style . ">" . $dados["clasf"] . "</td>
                <td " . $style . ">" . $dados["datalanca"] . "</td>
                <td " . $style . ">
                    <div style=\"color: " . $cor . "; width: 100%; text-align: right;\">
                    <b>" . $valor . "</b>
                    </div>
                </td>
            </tr>";
            $peratu = $dados["peratu"];
        }
        if ($saldoFinal > 0) {
            $cor = "black";
        } else {
            $cor = "red";
        }
        $str .= "<tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td colspan=\"2\">Saldo Final: 
                        <b style=\"color: " . $cor . "; width: 100%; text-align: right;\">
                            " . formatarValorPadrao($saldoFinal) . "
                        </b>
                     </td>
                 </tr>
                 <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>Periodo atual:</td>
                     <td colspan=\"2\">&nbsp; <b>" . $peratu . "</b></td>
                 </tr>
                 </tbody></table>";

        return $str;
    }

    /**
     * Switch para os lancamentos
     * @param type $pag
     * @return string
     */
    public function lancaSwitch($pag) {
        switch ($pag) {
            // case 'listmes':
            case 'listlanca':
                $complemento = " AND cc.peratu = (SELECT cod FROM peratu WHERE codctco = " . $this->get_codCtCo() . " AND situacao = 'ativo') ";
                break;
            case 'listperlanca':
                $complemento = " AND cc.peratu = ";
                break;
            default :
                $complemento = " AND cc.peratu = (SELECT cod FROM peratu WHERE codctco = " . $this->get_codCtCo() . " AND situacao = 'ativo') ";
                break;
        }

        return $complemento;
    }

    /**
     * Edita ou cria novo lancamento em um a conta corrente
     * @return string
     */
    public function lancaEdit() {
        $codLanca = $this->get_codLanca();
        //Cria um temporario
        if ($codLanca == "") {
            $consulta = "INSERT INTO getar_contacor (codctco, custo, datalanca, peratu, situacao)
                                VALUES(" . $this->get_codCtCo() . ", 0, CURDATE(), (SELECT cod FROM peratu WHERE codctco= " . $this->get_codCtCo() . " AND situacao= 'ativo'), 'ativo')";
            $msg = $this->executaIdSQL($consulta);
            $this->set_msg($msg);
            $codLanca = $this->get_idRet();
            $this->set_codLanca($codLanca);
        }

        $consulta = "SELECT cc.cod,
                            cc.codctco,
                            cc.codclasf,
                            cc.datalanca,
                            nm.nome contanome,
                            cc.peratu,
                            cc.descr,
                            cc.cred,
                            cc.debt,
                            cc.obs,
                            cc.situacao
                       FROM getar_contacor cc,
                            getar_contanome nm
                      WHERE  cc.codctco = nm.cod
                            AND cc.cod = " . $codLanca;
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Retorna o saldo de um conta corrente
     * @param <int> $numCtCo - por padrao salda da conta em uso
     * @return <decimal> saldo
     */
    public function lancaTot($numCtCo = 0) {
        if ($numCtCo == 0) {
            $numCtCo = $this->get_codCtCo();
        }
        $consulta = "  SELECT SUM(cred)-SUM(debt) sd
                        FROM getar_contacor
                       WHERE codctco = " . $numCtCo . "
                             AND situacao NOT IN('pend', 'inativo')";
        $dados = $this->consultaSQL($consulta);

        return $dados['sd'];
    }

    /**
     * Calcula o saldo de um periodo
     * @param type $peratu
     * @return type
     */
    public function lancaTotPer($peratu) {
        $consulta = "  SELECT SUM(cred)-SUM(debt) sd
                        FROM getar_contacor
                       WHERE peratu = " . $peratu . "
                             AND situacao NOT IN('pend', 'inativo')";
        $dados = $this->consultaSQL($consulta);

        return $dados['sd'];
    }

    /**
     * Totaliza parcelas por um parametro
     * @param <string> $complemento
     * @return <decimal> total
     */
    public function parcTot($complemento) {
        $consulta = "  SELECT ROUND(SUM(valorpar), 2) tot
                        FROM conta_carnepar
                       WHERE 1 = 1
                             AND " . $complemento;
        $dados = $this->consultaSQL($consulta);

        return $dados['tot'];
    }

    /**
     * Opcoes para os lancamentos de contacorrente
     * @return string
     */
    public function lancaOpcoes() {
        $str = "<div id=\"opcoes\">
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=editlanca&codlanca=&codctco=" . $this->get_codCtCo() . "\" accesskey=\"n\">
                            <img src=\"imagens/editar.gif\" alt=\"Novo Lancamento\" title=\"Novo Lancamento na conta corrente\"><br>
                            Novo lan&ccedil;amento<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listcor\">
                            <img src=\"imagens/moedas.png\" alt=\"Listar\" title=\"Listar todas contas correntes\"><br>
                            Contas Correntes<br />
                            Ativas
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listclasf&codctco=" . $this->get_codCtCo() . "\">
                            <img src=\"imagens/listar_.jpg\" alt=\"Listar Classificacoes\" title=\"Listar Classificacoes para a conta corrente\"><br>
                            Classifica&ccedil;&otilde;es de<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listlanca\">
                            <img src=\"imagens/listar_.jpg\" alt=\"Fluxo de Caixa\" title=\"Listar lancamentos da conta corrente\"><br>
                            Fluxo Caixa de<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listperativo\">
                            <img src=\"imagens/listar_.jpg\" alt=\"Periodos de Caixa\" title=\"Listar Periodos da conta corrente\"><br>
                            Periodos Ativos<br />
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=financascc&ft=fnc&pag=listperant\">
                            <img src=\"imagens/listar_.jpg\" alt=\"Periodos de Caixa\" title=\"Listar Periodos da conta corrente\"><br>
                            Periodos Anteriores de<br />
                            " . $this->get_nomeConta() . "
                        </a>
                    </div>
                </div>";

        return $str;
    }

    /**
     * Select com as classificacoes disponiveis
     * @param type $codClasf
     * @return string
     * @date 01/08/2024
     * Não mais Classficação-> Plano de contas, unicos para TODOS as C/C
     */
    public function clasfSelect($codClasf) {
        # $consulta = "SELECT cod, nome FROM getar_contaclasf WHERE situacao = 'ativo' AND codctco= " . $this->get_codCtCo() . " ORDER BY nome";
        $consulta = "SELECT cod, nome FROM getar_contaclasf WHERE situacao = 'ativo' AND codctco= 1 ORDER BY nome"; # soh pega os da Caixa Geral
        $resultado = $this->retornoSQL($consulta);

        $str = "<select name=\"codclasf\">";
        while ($dados = $this->arraySQL($resultado)) {
            $str .= "<option value=\"" . $dados['cod'] . "\" " . $this->selectedIf($dados['cod'], $codClasf) . ">" . $dados['nome'] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }

    /**
     * Salva alteracoes em um lancamento
     */
    public function lancaSalvar() {
        $vlDebt = 0;
        $vlCredt = 0;
        // eh debito
        $vlDebt = $this->formataValorMySQL($this->get_valorDeb());
        // ser for receber eh um credito
        $vlCredt = $this->formataValorMySQL($this->get_valorCred());

        $consulta = "UPDATE getar_contacor SET codctco=" . $this->get_codCtCo() . ",
                                               descr='" . $this->get_descrLanca() . "',
                                               codclasf=" . $this->get_codClasf() . ",
                                               datalanca='" . $this->get_dataLanca() . "',
                                               cred=" . $vlCredt . ",
                                               debt=" . $vlDebt . ",
                                               obs='" . $this->get_obsLanca() . "',
                                               situacao= '" . $this->get_situLanca() . "'
                                         WHERE cod=" . $this->get_codLanca();
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);
    }

    /**
     * Listagem das parcelas de um carne
     * @return string
     */
    public function parcelaList() {
        $consulta = " SELECT cod,
                            parnum,
                            DATE_FORMAT(datavnc, '%d/%m/%Y') datavnc,
                            DATE_FORMAT(datapag, '%d/%m/%Y') datapag,
                            ROUND(valorpar, 2) valorpar,
                            obs,
                            situacao
                       FROM conta_carnepar
                      WHERE codcarne=" . $this->get_codCarne();
        $resultado = $this->retornoSQL($consulta);
        $str = "<table>
                <caption>Listagem Parcelas Carn&ecirc; No:" . $this->get_codCarne() . "</caption>
                <thead>
                    <tr>
                        <th>Parcela</th>
                        <th>Data Venc.</th>
                        <th>Data Pag.</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "cancelada") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str .= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                    <td class=\"txt\" valign=\"top\">
                        Parcela No.: " . $dados['parnum'] . "(" . $dados['situacao'] . ") ";

            if ($dados['situacao'] == "paga") {
                $str .= "<a href=\"index.php?st=financaspr&ft=fnc&pag=detalpar&codpar=" . $dados['cod'] . "\">
                            <img src=\"imagens/livro.gif\" alt=\"\" border=\"0\">
                        </a>";
            } else {
                $str .= "    <a href=\"index.php?st=financaspr&ft=fnc&pag=editpar&codpar=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                        </a>";
            }
            $str .= "</td>
                    <td class=\"txt\" valign=\"top\">" . $dados['datavnc'] . "</td>";
            if ($dados['situacao'] == 'pend' or $dados['situacao'] == 'paga') {
                $str .= "<td class=\"txt\" valign=\"top\">" . $dados['datapag'] . "</td>";
            } else {
                $str .= "<td class=\"txt\" valign=\"top\" style=\"text-align: center\">-</td>";
            }
            $str .= "        <td class=\"txt\" valign=\"top\">&nbsp;" . $dados['valorpar'] . "</td>
                </tr>";
        }
        $str .= "</tbody></table>";

        return $str;
    }

    /**
     * Retorno o nome do credor/devedor da parcela
     * @param <int> $codPar
     * @return <string> nome
     */
    public function cadNome($codPar) {
        $consulta = "  SELECT cad.nome
                        FROM getar_cad cad,
                             conta_carne cn,
                             conta_carnepar pr
                        WHERE cn.codcad = cad.cod
                              AND cn.cod = pr.codcarne
                              AND pr.cod =" . $codPar;
        $dados = $this->consultaSQL($consulta);

        return $dados['nome'];
    }

    /**
     * Testa a contra senha financeira
     * @param type $nick
     * @param type $contra
     * @return boolean
     */
    public function contraTst($contra) {
        $consulta = " SELECT contrahash
                        FROM getar_control
                       WHERE contrahash NOT IN('')
                             AND nick= '" . $this->get_resp() . "'";
        $dados = $this->consultaSQL($consulta);

        if ($dados['contrahash'] == "") {
            return FALSE;
        } else {
            if (password_verify($contra, $dados['contrahash'])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        return FALSE;
    }

    /**
     * Historico parcelamento do cliente
     * @param type $codCad
     * @return string
     */
    public function carneRelato($codCad) {
        $consulta = " SELECT cn.cod codcarne,
                            ROUND(cn.valortot, 2) valortot,
                            date_format(cn.datacarne, '%d/%m/%Y') datacarne,
                            cn.objeto,
                            (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod) numparc,
                            (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'semprev') semprev,
                            (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'comprev') comprev,
                            (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'paga') paga,
                            (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'aberta') aberta
                     FROM conta_carne cn
                     WHERE cn.codcad= " . $codCad;
        $resultado = $this->retornoSQL($consulta);

        $str = "<table width=\"520px\">
                    <caption>Hist&oacute;rico Cliente</caption>
                    <head>
                    <tr>
                        <th rowspan=\"2\">Carne</th>
                        <th rowspan=\"2\">Data</th>
                        <th rowspan=\"2\">Objeto</th>
                        <th colspan=\"5\">Parcelas</th>
                    </tr>
                    <tr>
                        <th>No. Parc.</th>                 
                        <th>Pagas</th>                        
                        <th>Abertas</th>                        
                    </tr>
                    </head>
                    <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $str .= " <tr>
                    <th>" . $dados['codcarne'] . "</th>
                    <td>" . $dados['datacarne'] . "</td>
                    <td>" . $dados['objeto'] . "</td>
                    <td>" . $dados['numparc'] . "</td>
                    <td>" . $dados['paga'] . "</td>
                    <td>" . $dados['aberta'] . "</td>
                </tr>";
        }

        $str .= "
                    </tbody>
                </table>";

        return $str;
    }

    /**
     * Simple consulta de uma parcela
     * @param type $codParc
     * @return type
     */
    public function consParc($codParc) {
        $consulta = "SELECT pr.parnum,
                            pr.obs,
                            cad.nome,
                            cad.endr,
                            cn.cod carnenum,
                            date_format(pr.datapag, '%d/%m/%Y') datapag,
                            date_format(pr.datapag, '%d') diapag,
                            date_format(pr.datapag, '%m') mespag,
                            date_format(pr.datapag, '%Y') anopag,
                            ROUND(pr.valorpar, 2) valorpar
                       FROM getar_cad cad,
                            conta_carne cn,
                            conta_carnepar pr
                      WHERE cn.codcad = cad.cod
                            AND pr.codcarne = cn.cod
                            AND pr.cod =" . $codParc;
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    public function conscRelato($dataIni, $dataFim) {
        $consulta = "SELECT pr.parnum,
                            cad.nome,
                            date_format(pr.datapag, '%d/%m/%Y') datapag,
                            ROUND(pr.valorpar, 2) valorpar
                       FROM getar_cad cad,
                            conta_carne cn,
                            conta_carnepar pr
                      WHERE cn.codcad = cad.cod
                            AND pr.codcarne = cn.cod
                            AND datapag BETWEEN '" . $this->dataIni . "' AND '" . $dataFim . "'";
        $resultado = $this->retornoSQL($consulta);

        $str = "<table border=\"1\">
                <caption>...</caption>
                <thead>
                    <tr>
                        <th>Parcela</th>
                        <th>Pagador</th>
                        <th>Data</th>
                        <th>Pago</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $str .= "<tr>
                    <td class=\"txt\" valign=\"top\">
                        Parcela No.: " . $dados['parnum'] . "
                    <td class=\"txt\" valign=\"top\">" . $dados['nome'] . "</td>
                    <td class=\"txt\" valign=\"top\">" . $dados['datapag'] . "</td>
                    <td class=\"txt\" valign=\"top\">&nbsp;" . $dados['valorpar'] . "</td>
                </tr>";
        }
        $str .= "</tbody></table>";

        return $str;
    }

    /**
     * Listagem por periodo
     * @return string
     */
    public function parcelaRlPer() {
        $str = "<div id=\"elemento\" style=\"width: 272px; text-align: right\">
                    <form action=\"index.php?st=financaspr&ft=fnc&pag=listper\" method=\"post\">
                        <fieldset>
                            <legend>Listagem por periodo</legend>
                            <label style=\"width: 0;\">De: </label>" . $this->selectData('ini') . "<br>
                            <label style=\"width: 0;\">At&eacute;: </label>" . $this->selectData('fim') . "
                        <input type=\"submit\" value=\"Pesquisar\" accesskey=\"p\">
                        </fieldset>
                    </form>
                </div>";

        return $str;
    }

    /**
     * Chama relatorio pagas por periodo
     * @return string
     */
    public function parcelaRlpag() {
        $str = "<div id=\"elemento\" style=\"width: 272px; text-align: right\">
                    <form action=\"pagina/financas/relato.php\" method=\"post\" target=\"_blank\">
                        <fieldset>
                            <legend>Relat&oacute;rio pagas por per&iacute;odo</legend>
                            <label style=\"width: 0;\">De: </label>" . $this->selectData('ini') . "<br>
                            <label style=\"width: 0;\">At&eacute;: </label>" . $this->selectData('fim') . "
                            <input type=\"submit\" value=\"Relat&oacute;rio\">
                        </fieldset>
                    </form>
                </div>";

        return $str;
    }

}

?>
