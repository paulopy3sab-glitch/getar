<?php

/*
 * 
 * @author Paulo Regis paulo.py3sab@gmail.com
 * Data de criacao: 23/01/207
 * Descricao:
 * Trabalha com as operacoes pertinentes ao cadastro indepedente do tipo de 
 * banco de dados usado (MySQL, Oracle, PostGree 
 *
 * Revisoes:
 * 
 */

class OScontrol extends Conex {
    
    use Tordem;

    private $msgEqp;
    private $msgOS;
    private $erro;
    // Para as OS
    private $codOS;
    private $retorno;
    private $codCli;
    private $dtEntd;
    private $dtIni;
    private $dtSaida;
    private $fila;
    private $dtFcd;
    private $respOS;
    private $recla;
    private $encr;
    private $serv;
    private $valCb;
    private $fatu;
    private $vndAcs;
    private $situOS;
    // Para os Equipamentos
    private $codEqp;
    private $hist;
    private $descr;
    private $marca;
    private $modelo;
    private $serial;
    private $acess;
    private $situEqp;
    //
    private $codObsOS;
    private $obsOS;
    //
    private $codTarfOS;
    private $tecn;
    private $dtExec;
    private $horaIni;
    private $horaFim;
    private $descrTarf;
    // para estatisticas da OS
    private $totHora;

    function __construct() {
        parent::__construct();
        $msg = "# inicio processamento classe OScontrol";
        $this->gravaSQL($msg);
    }

    public function get_msgEqp() {
        return $this->msgEqp;
    }

    public function set_msgEqp($msgEqp) {
        $this->msgEqp = $msgEqp;
    }

    public function set_erro($erro) {
        $this->erro = $erro;
    }

    public function get_erro() {
        return $this->erro;
    }

    public function get_msgOS() {
        return $this->msgOS;
    }

    public function set_msgOS($msgOS) {
        $this->msgOS = $msgOS;
    }

    public function get_codOS() {
        return $this->codOS;
    }

    public function set_codOS($codOS) {
        $this->codOS = $codOS;
    }

    public function get_retorno() {
        return $this->retorno;
    }

    public function set_retorno($retorno) {
        $this->retorno = $retorno;
    }

    public function get_codCli() {
        return $this->codCli;
    }

    public function set_codCli($codCli) {
        $this->codCli = $codCli;
    }

    public function get_dtEntd() {
        return $this->dtEntd;
    }

    public function set_dtEntd($dtEntd) {
        $this->dtEntd = $dtEntd;
    }

    public function get_dtIni() {
        return $this->dtIni;
    }

    public function set_dtIni($dtIni) {
        $this->dtIni = $dtIni;
    }

    public function get_dtSaida() {
        return $this->dtSaida;
    }

    public function set_dtSaida($dtSaida) {
        $this->dtSaida = $dtSaida;
    }

    public function get_dtFcd() {
        return $this->dtFcd;
    }

    public function set_dtFcd($dtFcd) {
        $this->dtFcd = $dtFcd;
    }

    public function get_fila() {
        return $this->fila;
    }

    public function set_fila($fila) {
        $this->fila = $fila;
    }

    public function get_respOS() {
        return $this->respOS;
    }

    public function set_respOS($respOS) {
        $this->respOS = $respOS;
    }

    public function get_recla() {
        return $this->recla;
    }

    public function set_recla($recla) {
        $this->recla = $recla;
    }

    public function get_encr() {
        return $this->encr;
    }

    public function set_encr($encr) {
        $this->encr = $encr;
    }

    public function get_serv() {
        return $this->serv;
    }

    public function set_serv($serv) {
        $this->serv = $serv;
    }

    public function get_valCb() {
        return $this->valCb;
    }

    public function set_valCb($valCb) {
        $this->valCb = $valCb;
    }

    public function get_fatu() {
        return $this->fatu;
    }

    public function set_fatu($fatu) {
        $this->fatu = $fatu;
    }

    public function get_vndAcs() {
        return $this->vndAcs;
    }

    public function set_vndAcs($vndAcs) {
        $this->vndAcs = $vndAcs;
    }

    public function get_situOS() {
        return $this->situOS;
    }

    public function set_situOS($situOS) {
        $this->situOS = $situOS;
    }

    public function get_codEqp() {
        return $this->codEqp;
    }

    public function set_codEqp($codEqp) {
        $this->codEqp = $codEqp;
    }

    public function get_hist() {
        return $this->hist;
    }

    public function set_hist($hist) {
        $this->hist = $hist;
    }

    public function get_descr() {
        return $this->descr;
    }

    public function set_descr($descr) {
        $this->descr = $descr;
    }

    public function get_marca() {
        return $this->marca;
    }

    public function set_marca($marca) {
        $this->marca = $marca;
    }

    public function get_modelo() {
        return $this->modelo;
    }

    public function set_modelo($modelo) {
        $this->modelo = $modelo;
    }

    public function get_serial() {
        return $this->serial;
    }

    public function set_serial($serial) {
        $this->serial = $serial;
    }

    public function get_acess() {
        return $this->acess;
    }

    public function set_acess($acess) {
        $this->acess = $acess;
    }

    public function get_situEqp() {
        return $this->situEqp;
    }

    public function set_situEqp($situEqp) {
        $this->situEqp = $situEqp;
    }

    public function get_codObsOS() {
        return $this->codObsOS;
    }

    public function set_codObsOS($codObsOS) {
        $this->codObsOS = $codObsOS;
    }

    public function get_obsOS() {
        return $this->obsOS;
    }

    public function set_obsOS($obsOS) {
        $this->obsOS = $obsOS;
    }

    public function get_codTarfOS() {
        return $this->codTarfOS;
    }

    public function set_codTarfOS($codTarfOS) {
        $this->codTarfOS = $codTarfOS;
    }

    public function get_tecn() {
        return $this->tecn;
    }

    public function set_tecn($tecn) {
        $this->tecn = $tecn;
    }

    public function get_dtExec() {
        return $this->dtExec;
    }

    public function set_dtExec($dtExec) {
        $this->dtExec = $dtExec;
    }

    public function get_horaIni() {
        return $this->horaIni;
    }

    public function set_horaIni($horaIni) {
        $this->horaIni = $horaIni;
    }

    public function get_horaFim() {
        return $this->horaFim;
    }

    public function set_horaFim($horaFim) {
        $this->horaFim = $horaFim;
    }

    public function get_descrTarf() {
        return $this->descrTarf;
    }

    public function set_descrTarf($descrTarf) {
        $this->descrTarf = $descrTarf;
    }

    public function get_totHora() {
        return $this->totHora;
    }
    
    public function set_totHora($totHora) {
        $this->totHora = $totHora;
    }

    /**
     * Cria um Equipamento novo e retorna seu código
     * @return type
     */
    public function eqpNovo() {
        $consulta = "INSERT INTO equipo (cod, codcli, descr, hist, situ)
                                 VALUES (NULL, 3, '', 0, 'temporario')";
        $this->executaIdSQL($consulta);
        $this->set_codEqp($this->get_idRet());
    }

    /**
     * Cria uma OS nova e retorna seu código
     * @return type
     */
    public function ordemNova() {
        $consulta = "INSERT INTO ordem (cod, codcli, entd, inicio, codeqp, resp, valcb, situ)
                                VALUES (NULL, (SELECT codcli FROM equipo WHERE cod = " . $this->get_codEqp() . "),
                                        CURDATE(), CURDATE(), " . $this->get_codEqp() . ",'" . $this->get_respOS() . "', 0.00, 'temporario');";
        $this->executaIdSQL($consulta);
        $this->set_codOS($this->get_idRet());

        return $this->get_codOS();
    }

    /**
     * Edita e gerencia um equipamento
     * @return type
     */
    public function eqpEdit() {
        $consulta = "SELECT cod,
                        codcli,
                        (SELECT CASE
                                    WHEN cad.clasf = 'c' THEN 'cli'
                                    WHEN cad.clasf NOT IN('c') THEN 'naocli'
                                END 
                           FROM getar_cad cad
                          WHERE codcli = cad.cod) stcad,
                        (SELECT nome 
                           FROM getar_cad cad
                          WHERE codcli = cad.cod) nome,
                        hist,
                        descr,
                        marca,
                        modelo,
                        serial,
                        acess,
                        (SELECT texto FROM ordem_obs WHERE codeqp = cod LIMIT 1) eqpobs,
                        situ
                   FROM equipo
                  WHERE cod=" . $this->get_codEqp();
        $dados = $this->consultaSQL($consulta);
        
        return $dados;
    }

    /**
     * Switch para editar e listar equipamentos
     * @param type $pag
     * @return string
     */
    public function eqpSwitch($pag) {
        $complemento = "";
        switch ($pag) {
            case 'edit':
                echo $this->eqpEdit();
                $complemento = " AND eqp.cod= " . $this->get_codEqp();
                break;
            case 'novo':
                $complemento = " AND eqp.cod= " . $this->get_codEqp();
                break;
            case 'list':
                $complemento = "AND eqp.situ = 'ativo' ORDER BY eqp.descr ASC";
                $acao = "Projetos em Andamento";
                break;
            case 'list_u':
                $complemento = "AND eqp.situ = 'ativo' ORDER BY eqp.cod DESC";
                $acao = "Ultimos Projetos";
                break;
            case 'list_all':
                $complemento = " ORDER BY eqp.cod DESC";
                $acao = " Novo";
                break;
            case 'list_pesq':
                $complemento = "AND eqp.descr LIKE '" . $_REQUEST['string'] . "%' ORDER BY eqp.nome ASC";
                $acao = " Novo";
                break;
        }

        return $complemento;
    }

    /**
     * Opcoes para o cadastro de equipamentos
     * @return string
     */
    public function eqpOpcoes() {
        $str = "<div id=\"opcoes\">
                    <div id=\"elemento\">
                        <a href=\"index.php?st=eqp&pag=novo\">
                            <img src=\"imagens/novo.jpg\" alt=\"Novo\" title=\"Novo Equipamento\"><br>
                            Equipamento Novo.
                        </a>
                    </div>";

        if ($this->get_codEqp() <> "") {
            $str .= "<div id=\"elemento\">
                        <a href=\"index.php?st=ordm&pag=cad&codeqp=" . $this->get_codEqp() . "\">
                            <img src=\"imagens/novo.jpg\" alt=\"Nova OS\" title=\"Nova Ordem de Servi&ccedil;o para este equipamento\"><br>
                            Nova Ordem.
                        </a>
                    </div>";
        }
        $str .= "<div id=\"elemento\">
            <a href=\"index.php?st=eqp&pag=list_u\">
                <img src=\"imagens/grupo.gif\" alt=\"\" title=\"Listar &uacute;ltimos\"><br>
                Listar &uacute;ltimos
            </a>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php?st=eqp&pag=pesq\" method=\"post\">
                <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                <input type=\"hidden\" name=\"pagina\" value=\"\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />
                Por Modelo Equipamento<br>
                <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"10\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php\" method=\"get\">
                <input type=\"hidden\" name=\"st\" value=\"eqp\">
                <input type=\"hidden\" name=\"pag\" value=\"edit\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />
                Por Numero do Equipamento<br>
                <input name=\"codeqp\" type=\"text\" size=\"12\" maxlength=\"10\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php\" method=\"get\">
                <input type=\"hidden\" name=\"st\" value=\"ordm\">
                <input type=\"hidden\" name=\"pag\" value=\"listprop\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />
                Por Propriet&aacute;rio<br>
                <input name=\"strpesq\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"c\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
    </div>";

        return $str;
    }

    /**
     * Select da situacao do equipamento
     * ativo - sucata
     * @param type $situ
     * @return string
     */
    public function selectSituEqp($situ) {
        $str = "<select name=\"situ\">
                    <option value=\"ativo\" " . $this->selectedIf("ativo", $situ) . ">ativo</option>
                    <option value=\"sucata\" " . $this->selectedIf("sucata", $situ) . ">sucata</option>
               </select>";

        return $str;
    }

    /**
     * Select registro de equipamento historico ou nao
     * @param type $hist
     * @return string
     */
    public function selectHist($hist) {
        $selectedSim = "";
        $selectedNao = "";
        if ($hist) {
            $selectedSim = "selected";
        } else {
            $selectedNao = "selected";
        }
        $str = "<select name=\"hist\">
                   <option value=\"1\" " . $selectedSim . ">Sim</option>
                   <option value=\"0\" " . $selectedNao . ">N&atilde;o</option>
               </select>";

        return $str;
    }

    /**
     * Salva alteracoes num equipamento
     */
    public function eqpSalvar() {
        $consulta = "UPDATE equipo SET
                        codcli='" . $this->get_codCli() . "',
                        hist='" . $this->get_hist() . "',
                        descr='" . $this->get_descr() . "',
                        marca='" . $this->get_marca() . "',
                        modelo='" . $this->get_modelo() . "',
                        serial='" . $this->get_serial() . "',
                        situ='" . $this->get_situEqp() . "'
                  WHERE cod=" . $this->get_codEqp();
        $msg = $this->executaSQL($consulta);
        $this->set_msgEqp($msg);
    }

    /**
     * Salva alteraçoes numa OS
     * @author Paulo Regis <paulo_schw@yahoo.com.br>
     * @date 08/07/2024
     */
    public function osSalvar() {
        $consulta = "UPDATE ordem SET resp='" . $this->respOS . "',
                        situequip='" . $this->situEqp . "',
                        codcli='" . $this->codCli . "',
                        inicio='" . $this->dtIni . "',# definir
                        datafcd='" . $this->dtFcd . "',
                        saida='" . $this->dtSaida . "',
                        fatu = '" . $this->fatu . "',
                        valcb = " . $this->valCb . ",
                        recla='" . $this->recla . "',
                        encr='" . $this->encr . "',
                        serv='" . $this->serv . "',
                        fila='" . $this->fila . "',
                        retorno='" . $this->retorno . "',
                        situ='" . $this->situOS . "'
                  WHERE cod= " . $this->codOS;
        $msg = $this->executaSQL($consulta);
        $this->set_msgOS($msg);
    }

    /**
     * Em desenvolvimento
     */
    public function hashtagList() {
        $consulta = "SELECT cod,
                        DATE_FORMAT(dataexec, '%d/%m/%Y') dataexec,
                        DATE_FORMAT(dataexec, '%m') mes,
                        DATE_FORMAT(horaini, '%k:%i') horaini,
                        TIMEDIFF(horafim, horaini) AS tempo,
                        tecn,
                        descr,
                        REGEXP_SUBSTR(descr, '#[a-z]+') AS tag
                   FROM ordem_tarf
                  WHERE codos = " . $codOS . "
                        AND situ = 'concluida'
                  ORDER BY cod DESC";
        $resultado = $this->retornoSQL($consulta);
    }

    /**
     * Calculo de horas trabalhadas
     * @return string
     */
    public function tarfTotHora() {
        $consulta = "SELECT SUM(DATE_FORMAT((TIMEDIFF(horafim, horaini)), '%H')) hora,
                            SUM(DATE_FORMAT((TIMEDIFF(horafim, horaini)), '%i')) min
                       FROM ordem_tarf
                      WHERE codos=" . $this->get_codOS() . "
                            AND situ = 'concluida'";
        $dados = $this->consultaSQL($consulta);

        /**
         * Retirando as horas do total dos minutos
         */
        $hora = $dados['hora'];
        $horaMin = $dados['min'] / 60;
        $min = $dados['min'] % 60;
        $horaTot = $hora + $horaMin;
        if ($min < 10) {
            $zero = "0";
        } else {
            $zero = "";
        }

        $str = intval($horaTot) . " horas e " . $zero . $min . " minutos";
        # passando para outras estatisticas
        $this->set_totHora($horaTot);
        return $str;
    }

    /**
     * Listagem de OSs
     * @param type $complemento
     * @return type
     */
    public function ordemList($complemento) {
        $consulta = $this->os_cons1($complemento);
        $resultado = retornoSQL($consulta);

        return $resultado;
}

    /**
     * Valor custo hora de um tecnico
     * @param type $resp
     * @return type
     */
    public function valorCusto($resp) {
        $consulta = "SELECT custohora FROM getar_control WHERE nick= '" . $resp . "'";
        $dados = $this->consultaSQL($consulta);

        return $dados['custohora'];
    }
    
    /**
     * Consulta para listagem de OSs infileradas
     * @param type $complemento
     */
    public function relOS($complemento) {
        $consulta = $this->os_cons1($complemento);
        $resultado = retornoSQL($consulta);
        $rows = rowsSQL($resultado);
        if ($rows < 1) {
            $this->set_erro(TRUE);
        } else {
            $this->set_erro(FALSE);
        }
        
        return $resultado;
    }

    /**
     * Pesquisa por Tag
     * @return type
     */
    public function relTag($complemento) {
        $consulta = $this->os_cons6($complemento);
        $resultado = retornoSQL($consulta);
        $rows = rowsSQL($resultado);
        if ($rows < 1) {
            $this->set_erro(TRUE);
        } else {
            $this->set_erro(FALSE);
        }
        
        return $resultado;
    }
    
    /**
     * Consulta para gerenciamento de um OS
     * @return type
     */
    public function ordemEdit() {
        $dados = $this->consultaSQL($this->os_cons5($this->get_codOS()));
        $codEqp = $dados['codeqp'];
        if ($codEqp == 0) {
            $this->set_erro(TRUE);
        } else {
            $this->set_erro(FALSE);
        }
        
        return $dados;
    }
    
    /**
     * Retorna a OS a qual pertence a tarefe
     * @param type $codTarf
     * @return type
     */
    public function pegaCodOS($codTarf){
        $consulta= "SELECT codos FROM ordem_tarf WHERE cod= ". $codTarf;
        $dados = $this->consultaSQL($consulta);
        $codOS = $dados['codos'];
        
        return $codOS;
}

}

?>
