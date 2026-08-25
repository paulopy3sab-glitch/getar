<?php

/**
 * Trabalhar com os lembretes
 * Data Criacao: Julho/2016
 * @author Paulo <paulo_schw@yahoo.com.br>
 * Revisoes:
 */
class Lembr extends Conex {

    use Tmenscons;

    private $msgLmb;
    private $msgMens;
    private $tipoMens;
    //
    private $codLmb;
    private $tituLmb;
    private $textoLmb;
    private $remtLmb;
    private $destLmb;
    private $situLmb;
    private $dataAgd;
    //
    private $codMens;
    private $tituMens;
    private $destMens;
    private $remtMens;
    private $remtEmail;
    private $dataEnv;
    private $lida;
    private $texto;
    private $situMens;
    //
    public $arrayLmb;

    function __construct() {
        parent::__construct();
        $msg = "# inicio processamento classe Lembre";
        $this->gravaSQL($msg);
    }

    public function get_msgLmb() {
        return $this->msgLmb;
    }

    public function set_tituLmb($tituLmb) {
        $this->tituLmb = $tituLmb;
    }

    public function set_msgLmb($msgLmb) {
        $this->msgLmb = $msgLmb;
    }

    public function set_codLmb($novo_lemb) {
        $this->codLmb = $novo_lemb;
    }

    public function get_codLmb() {
        return $this->codLmb;
    }

    public function set_textoLmb($novo_texto) {
        $this->textoLmb = $novo_texto;
    }

    public function get_textoLmb() {
        return $this->textoLmb;
    }

    public function set_remtLmb($novo_remt) {
        $this->remtLmb = $novo_remt;
    }

    public function get_remtLmb() {
        return $this->remtLmb;
    }

    public function set_destLmb($novo_dest) {
        $this->destLmb = $novo_dest;
    }

    public function get_tituLmb() {
        return $this->tituLmb;
    }

    public function get_destLmb() {
        return $this->destLmb;
    }

    public function set_situLmb($novo_situ) {
        $this->situLmb = $novo_situ;
    }

    public function get_situLmb() {
        return $this->situLmb;
    }

    public function set_dataAgd($novo_dataAgd) {
        $this->dataAgd = $novo_dataAgd;
    }

    public function get_dataAgd() {
        return $this->dataAgd;
    }

    public function get_msgMens() {
        return $this->msgMens;
    }

    public function set_msgMens($msgMens) {
        $this->msgMens = $msgMens;
    }

    public function get_tipoMens() {
        return $this->tipoMens;
    }

    public function set_tipoMens($tipoMens) {
        $this->tipoMens = $tipoMens;
    }

    public function get_texto() {
        return $this->texto;
    }

    public function set_texto($texto) {
        $this->texto = $texto;
    }

    public function get_codMens() {
        return $this->codMens;
    }

    public function set_codMens($codMens) {
        $this->codMens = $codMens;
    }

    public function get_tituMens() {
        return $this->tituMens;
    }

    public function set_tituMens($tituMens) {
        $this->tituMens = $tituMens;
    }

    public function get_destMens() {
        return $this->destMens;
    }

    public function set_destMens($destMens) {
        $this->destMens = $destMens;
    }

    public function get_remtMens() {
        return $this->remtMens;
    }

    public function set_remtMens($remtMens) {
        $this->remtMens = $remtMens;
    }

    public function get_remtEmail() {
        return $this->remtEmail;
    }

    public function set_remtEmail($remtEmail) {
        $this->remtEmail = $remtEmail;
    }

    public function get_dataEnv() {
        return $this->dataEnv;
    }

    public function set_dataEnv($dataEnv) {
        $this->dataEnv = $dataEnv;
    }

    public function get_lida() {
        return $this->lida;
    }

    public function set_lida($lida) {
        $this->lida = $lida;
    }

    public function get_situMens() {
        return $this->situMens;
    }

    public function set_situMens($situMens) {
        $this->situMens = $situMens;
    }

    /**
     * Listagem de lembretes
     * @param type $complemento
     * @return string $str
     */
    public function lembrList($complemento, $pag, $pagList) {
        $resultado = $this->geraPaginacao($this->cons05($complemento), $pagList);
        $str = "<table>
                <caption>Listagem Lembretes</caption>
                <thead>
                    <tr>
                        <th>Registro</th>
                        <th>Titulo.</th>
                        <th>Data Agendada</th>
                        <th>Remetente->Destinatario</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situ"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }

            $str .= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                        <th>" . $dados['cod'] . "</th>
                        <td>";
            if ($dados['titulo'] == "") {
                $str.= $dados['texto'];
            } else {
                $str.= $dados['titulo'];
            }

            $str.= "        <a href=\"index.php?st=lembretes&ft=mens&pag=edit&codlmb=" . $dados["cod"] . "\">
                                <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar/ler esta lembrete\">
                            </a>
                        </td>
                        <td>" . $dados['dataagd'] . " - " . $dados['diasem'] . "</td>
                        <td>" . $dados["remt"] . "->" . $dados["dest"] . "
                    </tr>";
        }
        $str .= "</tbody></table>";
        $doc = "index.php?st=lembretes&ft=mens&pag=" . $pag;
        $str .= $this->geraIndicesPaginas($pagList, $doc);

        return $str;
    }

    /**
     * Listagem de lembretes preparado para mobile
     * @param type $complemento
     * @return string $str
     */
    public function mlembrList($complemento, $pag, $pagList) {
        $resultado = $this->geraPaginacao($this->cons05($complemento), $pagList);
        $str = "<table>
                <caption>Listagem Lembretes</caption>
                <thead>
                    <tr>
                        <th>Data Agendada</th>
                        <th>Inicio do Lembrete.</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situ"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }

            $str .= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                        <th>" . $dados['dataagd'] . " - " . $dados['diasem'] . "</th>
                        <td>" . $dados['texto'] . "
                            <a href=\"m-index.php?st=lembretes&ft=mens&pag=edit&codlmb=" . $dados["cod"] . "\">
                                <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar/ler esta lembrete\">
                            </a>
                        </td>
                    </tr>";
        }
        $str .= "</tbody></table>";
        $doc = "index.php?st=lembretes&ft=mens&pag=" . $pag;
        $str .= $this->geraIndicesPaginas($pagList, $doc);

        return $str;
    }

    /**
     * Opcoes para os lembretes
     * @return string
     */
    public function lembrOpcoes() {

        $str = "<div id=\"opcoes\">
                <div id=\"elemento\">
                    <a href=\"index.php?st=lembretes&ft=mens&pag=nova\" accesskey=\"n\">
                        <img src=\"imagens/novo.jpg\" alt=\"\" border=\"no\"><br>
                        Novo Lembrete
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=lembretes&ft=mens&pag=list\">
                        <img src=\"imagens/grupo.gif\" alt=\"\" border=\"no\"><br>
                        Lembretes Vencidos
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=lembretes&ft=mens&pag=list_env\">
                        <img src=\"imagens/grupo.gif\" alt=\"\" border=\"no\"><br>
                        Lembretes Enviados a Outros
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=lembretes&ft=mens&pag=list_agd\">
                        <img src=\"imagens/grupo.gif\" alt=\"\" border=\"no\"><br>
                        Lembretes Agendados
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=lembretes&ft=mens&pag=list_todos\">
                        <img src=\"imagens/grupo.gif\" alt=\"\" border=\"no\"><br>
                        Todos Seus Lembretes</a>
                </div>";

        //so disponibilizar para o administrador
        if ($this->atrib("71")) {
            $str.=" <div id=\"elemento\">
                        <a href=\"index.php?st=lembretes&ft=mens&pag=list_all\">
                            <img src=\"imagens/pesquisa1.gif\" alt=\"\" width=\"20\" height=\"16\" border=\"no\"><br>
                            Todos n&iacute;vel Administrador.</a>
                    </div>";
        }
        $str.="</div>";

        return $str;
        ;
    }

    /**
     * Salva a edicao de um lembrente
     * @return type
     */
    public function lembreSalvar() {

        $this->msgLmb = $this->executaSQL($this->cons04());
    }

    /**
     * Salvar alteracoes numa mensagem, ainda em forma de rascunho
     */
    public function mensSalvar() {
        $consulta = "UPDATE getar_mens SET
                            titulo='" . $this->get_tituMens() . "',
                            remtemail='" . $this->get_remtEmail() . "',
                            dest='" . $this->get_destMens() . "',
                            destemail='" . $this->get_destEmail() . "',
                            texto='" . $this->get_texto() . "',
                            situ= '" . $this->get_situMens() . "'
                      WHERE cod= " . $this->get_codMens();

        $this->msgMens = $this->executaSQL($consulta);
    }

    /**
     * Consulta para detalhar uma mensagem
     * @return string
     */
    public function mensExib() {
        //Marcar mensagem como lida
        $consulta = "UPDATE getar_mens SET situ='lida' WHERE cod='" . $this->get_codMens() . "'";
        $this->executaSQL($consulta);

        $dados = $this->consultaSQL($this->cons06());

        return $dados;
    }

    /**
     * Consulta um lembrete ou cria novo lembrete para edicao
     * @return string
     */
    public function lembrEdit() {

        $codLmb = $this->get_codLmb();
        if ($codLmb == "") {
            //  Cria novo temporario
            $msg = $this->executaIdSQL($this->cons01());
            $this->set_msgLmb($msg);
            $this->set_codLmb($this->get_idRet());
            $codLmb = $this->get_codLmb();
        }

        $dados = $this->consultaSQL($this->cons02($this->codLmb));

        return $dados;
    }

    /**
     * Editar lembretes com formato preparado para mobile
     * @return string
     */
    public function mlembrEdit() {
        $codLmb = $this->get_codLmb();
        if ($codLmb == "") {
            //  Cria novo temporario
            $msg = $this->executaIdSQL($this->cons01());
            $this->set_msgLmb($msg);
            $this->set_codLmb($this->get_idRet());
            $codLmb = $this->get_codLmb();
        }

        $dados = $this->consultaSQL($this->cons02($this->codLmb));

        $str = "<form name=\"formLembr\" action=\"index.php?st=lembretes&ft=mens&pag=edit&codlmb=" . $codLmb . "\" method=\"post\" onsubmit=\"return validaForm();\">
                    <input name=\"codlmb\" type=\"hidden\" value=\"" . $codLmb . "\">
                    <input name=\"remt\" type=\"hidden\" value=\"" . $this->get_resp() . "\">
                    <fieldset>
                    <legend>detalhes do Lembrete</legend>
                    <label>Destinat&aacute;rio: </label><br />
                    " . $this->lembrUsuarios($dados["dest"]) . "<br>
                    <label>Agendar para: </label><br />
                    " . $this->selectData("agd", $dados['diaagd'], $dados['mesagd'], $dados['anoagd']) . "<br>
                    <label>Texto da mensagem:</label><br />
                    <textarea name=\"texto\" rows=\"10\" cols=\"38\">" . $dados["texto"] . "</textarea><br>
                    <label>Situa&ccedil;&atilde;o:</label><br />
                    <select name=\"situacao\">
                        <option value=\"ativo\" " . selectedIf($dados['situ'], "ativo") . " >ativo</option>
                        <option value=\"inativo\" " . selectedIf($dados['situ'], "inativo") . " >inativo</option>
                    </select><br>
                    <label>&nbsp;</label><br ?>
                    <input type=\"submit\" name=\"salvarLmb\" value=\"Salvar\"><br>
                    " . $this->get_msgLmb() . "
                </fieldset>
               </form>";

        return $str;
    }

    /**
     * Switch para editar e listar lembretes
     * @param string $pag
     * @return string $complemento
     */
    public function lembrSwitch($pag) {
        $complemento = "";
        switch ($pag) {
            case 'edit':
                $complemento = " AND cod = " . $this->get_codLmb();
                break;
            case 'nova':
                $complemento = " AND dataagd <= CURDATE()
                        AND situ = 'ativo' ";
                break;
            case 'list':
                $complemento = " AND dataagd <= CURDATE()
                        AND situ = 'ativo' 
                        AND dest='" . $this->get_resp() . "'
                        ";
                break;
            case 'list_env':
                $complemento = " AND situ = 'ativo' 
                        AND remt='" . $this->get_resp() . "'
                        AND dest <> '" . $this->get_resp() . "'
                        ";
                break;
            case 'list_agd':
                $complemento = " AND dataagd >= CURDATE()
                        AND situ = 'ativo' 
                        AND dest='" . $this->get_resp() . "'
                        ";
                break;
            case 'list_todos':
                $complemento = " AND dest='" . $this->get_resp() . "'
                        ";
                break;
            case 'list_all':
                $complemento = "";
                break;
            default:
                break;
        }

        return $complemento;
    }

    /**
     * select com o usuarios que podem receber lembretes
     * @param string $dest (nick
     * @return string $str
     */
    public function lembrUsuarios($dest) {
        $consulta = "  SELECT nome,
                              ctl.nick
                        FROM  getar_control ctl,
                              getar_cad cad
                        WHERE ctl.codcad = cad.cod
                              AND cad.situacao = 'ativo'";
        $retorno = $this->retornoSQL($consulta);
        $str = "
                <select name=\"dest\">
                    <option value=\"\">Selecione</option>";

        while ($dados = $this->arraySQL($retorno)) {
            $str.="<option value=\"" . $dados["nick"] . "\" " . $this->selectedIf($dados["nick"], $dest) . ">" . $dados["nome"] . "</option>";
        }

        $str.="</select>";

        return $str;
    }

    /**
     * select com nicks para os destinatarios
     * @param type $dest
     * @return string
     */
    public function selectDest($dest) {
        $resultado = $this->retornoSQL($this->cons03());
        $str = "<select name=\"dest\">
                    <option value=\"\">Selecione</option>";

        while ($dados = $this->arraySQL($resultado)) {
            $str.="<option value=\"" . $dados["nick"] . "\" " . $this->selectedIf($dados['nick'], $dest) . ">" . $dados["nome"] . "</option>";
        }
        $str.= "</select>";

        return $str;
    }

    /**
     * Switch para as mensagens
     * @param type $pag
     * @return string
     */
    public function mensSwitch($pag) {
        $complemento = "";

        switch ($pag) {
            case 'exib':
                $complemento = " dest='" . $this->get_resp() . "'
                                 AND situ= 'ativo'";
                $this->set_tipoMens("Recebidas");
                break;
            case 'nova':
                $complemento = " dest='" . $this->get_resp() . "'
                                 AND situ= 'ativo'";
                $this->set_tipoMens("Recebidas");
                break;
            case 'list':
                $complemento = " dest='" . $this->get_resp() . "'
                                 AND situ= 'ativo'";
                $this->set_tipoMens("Recebidas");
                break;
            case 'list_env':
                $complemento = " remt='" . $this->get_resp() . "'
                                 AND situ= 'ativo'";
                $this->set_tipoMens("Enviadas");
                break;
            case 'list_recb':
                $complemento = " dest='" . $this->get_resp() . "'
                                 AND situ= 'ativo'";
                $this->set_tipoMens("Recebidas");
                break;
            case 'contatos':
                $complemento = " dest='all_admin'
                                 AND situ= 'ativo'";
                $this->set_tipoMens("Enviadas pelo sistema");
                break;
            case 'list_all':
                $complemento = " 1 = 1";
                $this->set_tipoMens("TODAS MENSAGENS");
                break;
            case 'list_u':
                $complemento = " ORDER BY cod DESC LIMIT 30";
                break;
            default :
                $complemento = " dest='" . $this->get_resp() . "'
                                 AND situ= 'ativo'";
                $this->set_tipoMens("Recebidas");
        }

        return $complemento;
    }

    /**
     * Listagem das mensagens
     * @param type $complemento
     * @param type $pag
     * @param type $pagList
     * @return type
     */
    public function mensList($complemento, $pag, $pagList) {
        $consulta = " SELECT cod,
                            remt,
                            dest,
                            DATE_FORMAT(data, '%d/%m/%Y') data,
                            titulo,
                            situ
                       FROM getar_mens
                      WHERE " . $complemento;
        $resultado = $this->geraPaginacao($consulta, $pagList);
        $str = "<table id=\"listcad\">
                <caption>Mensagens - " . $this->get_tipoMens() . "</caption>
                <thead>
                    <tr>
                        <th>Registro</th>
                        <th>Titulo.</th>
                        <th>Data</th>
                        <th>Remetente->Destinatario</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situ"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str .= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                        <th>" . $dados['cod'] . "</th>
                        <td>";
            if ($dados['titulo'] == "") {
                $str.="Sem Titulo";
            } else {
                $str.=$dados['titulo'];
            }
            
            switch ($dados["situ"]) {
                case "enviada":
                    $str.="<a href=\"index.php?st=mensagens&ft=mens&pag=exib&codmens=" . $dados["cod"] . "\">
                           <img src=\"imagens/mensagem_nova.jpg\" alt=\"Ler Mens\" title=\"Editar/ler esta mensagens\"  height=\"16px\">
                       </a>";
                    break;
                case "rascunho":
                    $str.="<a href=\"index.php?st=mensagens&ft=mens&pag=exib&codmens=" . $dados["cod"] . "\">
                           <img src=\"imagens/mensagem.jpg\" alt=\"Ler Mens\" title=\"Editar/ler esta mensagens\"  height=\"16px\">
                       </a>";
                    break;
                case "lida":
                    $str.="<a href=\"index.php?st=mensagens&ft=mens&pag=exib&codmens=" . $dados["cod"] . "\">
                           <img src=\"imagens/mensagem_lida.jpg\" alt=\"Ler Mens\" title=\"Editar/ler esta mensagens\"  height=\"16px\">
                       </a>";
                    break;
            }
            $str.="     </td>
                        <td>" . $dados['data'] . "</td>
                        <td>" . $dados["remt"] . "->" . $dados["dest"] . "
                    </tr>";
        }
        $str .= "</tbody></table>";
        $doc = "index.php?st=mensagens&pag=" . $pag;
        $str .= $this->geraIndicesPaginas($pagList, $doc);

        return $str;
    }

    /**
     * Opcoes para mensagens
     * @return string
     */
    public function mensOpcoes() {
        $str = "<div id=\"opcoes\">
                <div id=\"elemento\">
                    <a href=\"index.php?st=mensagens&ft=mens&pag=nova\" accesskey=\"n\">
                        <img src=\"imagens/novo.jpg\" alt=\"Nova Mensagem\" title=\"\"><br>
                        Nova Mensagem
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=mensagens&ft=mens&pag=list_recb\">
                        <img src=\"imagens/grupo.gif\" alt=\"\" title=\"Mensagens Recebidas\"><br>
                        Mensagens Recebidas
                    </a>
                </div>";

        //Lista novas mensagens para administradores
        if (atrib("71")) {
            $str.="<div id=\"elemento\">
                    <a href=\"index.php?st=mensagens&ft=mens&pag=contatos\">
                        <img src=\"imagens/grupo.gif\" alt=\"Mensagens Administrativas\" title=\"Mensagens Administrativas\"><br>
                        Mensagens Administrativas
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=mensagens&ft=mens&pag=list_all\">
                        <img src=\"imagens/grupo.gif\" alt=\"Todas\" title=\"Todas Mensagens Recebidas\"><br>
                        Todas Mensagens
                    </a>
                </div>";
        }
        $str.="<div id=\"elemento\">
                <a href=\"index.php?st=mensagens&ft=mens&pag=list_env\">
                    <img src=\"imagens/grupo.gif\" alt=\"\" title=\"Mensagens Enviadas\"><br>
                    Mensagens Enviadas
                </a>
            </div>
        </div>";

        return $str;
    }

    /**
     * Enviar uma nova mensagem
     * @return string
     */
    public function mensEditOLd($dest = "") {

        $str = "<div class=\"titulo\">ENVIANDO MENSAGEM NOVA</div>
                   <form action='index.php?st=mensagens&ft=mens&pag=nova' method='post'>
                   <fieldset>
                   <legend>Enviando Mensagem</legend>
                   <label>Destinat&aacute;rio</label>" . $this->selectDest($dest) . "<br>
                   <label>Data: </label><b>" . date('d-m-Y') . "</b><br>
                   <label>Texto da Mensagem: </label>
                   <textarea name=\"texto\" rows=\"10\" cols=\"45\"></textarea><br>
                   <label>&nbsp;</label><input type='submit' name='postarNova' value='Enviar'><br>
                   " . $this->get_msgMens() . "
                       </fieldset>
               </form>";

        return $str;
    }

    /**
     * Retorna os dados de mensagem em edicao ou cria nova
     * @return type
     */
    public function mensEdit() {

        $codMens = $this->get_codMens();
        if ($codMens == "") {
            //  Cria novo temporario
            $consulta = "INSERT INTO getar_mens (dest, remt, remtemail, data, titulo, texto, situ)
                                          VALUES('', '" . $this->get_resp() . "', '', CURDATE(), '', '', 'rascunho')";
            $msg = $this->executaIdSQL($consulta);
            $this->set_msgMens($msg);
            $this->set_codMens($this->get_idRet());
            $codMens = $this->get_codMens();
        }

        $consulta = " SELECT mens.cod,
                             mens.titulo,
                             mens.remt,
                             (SELECT cad.nome
                               FROM  getar_control ctl,
                                     getar_cad cad
                               WHERE ctl.codcad = cad.cod
                                 AND ctl.nick = mens.remt) nomeremt,
                             mens.remtemail,
                             mens.dest,
                             (SELECT cad.nome
                               FROM  getar_control ctl,
                                     getar_cad cad
                               WHERE ctl.codcad = cad.cod
                                 AND ctl.nick = mens.dest) nomedest,
                             mens.destemail,
                             mens.data,
                             mens.texto,
                             mens.situ
                        FROM getar_mens mens
                       WHERE mens.cod =" . $this->get_codMens();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Inativa uma mensagem
     * @param type $codMens
     * @return type
     */
    public function mensInativa($codMens) {
        $consulta = "UPDATE getar_mens SET situacao= 'inativo' WHERE cod=" . $codMens;
        $msg = $this->executaSQL($consulta);

        return $msg;
    }

    /**
     * Apaga uma mensagem do banco
     * @param type $codMens
     * @return type
     */
    public function mensExcl() {
        $consulta = "DELETE FROM getar_mens WHERE cod=" . $this->get_codMens();
        $msg = $this->executaSQL($consulta);

        return $msg;
    }

    /**
     * 
     */
    public function mensPostar() {
        //Enviar texto para o email cadastrado
        $consulta = "SELECT cad.nome AS remtnome,
                        cad.emailcorp AS remtemail,
                        (SELECT nome
                           FROM getar_cad caddt,
                                getar_control ctdt
                          WHERE caddt.cod= ctdt.codcad
                                AND ctdt.nick= '" . $this->get_destMens() . "') AS destnome,
                        (SELECT caddt.emailcorp
                           FROM getar_cad caddt,
                                getar_control ctdt
                          WHERE caddt.cod= ctdt.codcad
                                AND ctdt.nick= '" . $this->get_destMens() . "') AS destemail
                   FROM getar_control ct,
                        getar_cad cad
                  WHERE ct.codcad = cad.cod
                        AND ct.nick='" . $this->get_resp() . "'";
        $dados = $this->consultaSQL($consulta);

        /**
         *  Se nao houver e-mail para destinario ou o remetente nao tiver e-mail
         * aborta-se envio de e-mail pelo Getar
         */
        if (($dados['destemail'] <> "") && ($dados['destemail'] <> "")) {
            $mail = conecMailer();
            $cc_email = "";

            $mail->From = $dados['destemail']; // Email de quem envia o email
            $mail->FromName = $dados['remtnome']; // Nome de quem envia o email
            $mail->AddAddress($dados['destemail']); // Email de quem recebe
            $mail->AddReplyTo($dados['destemail'], $dados['remtnome']); // E-mail e nome para retorno
            if ($cc_email <> "") {
                $mail->AddCC($cc_email);
            }

            $mail->WordWrap = 50; // Definir quebra de linha
            $mail->IsHTML(false);

            $mail->Subject = "Contato via Getar "; // Assunto
            $texto = "Ola!<br>" . $dados['destnome'] . " (" . $dados['destemail'] . ")<br>
              Foi enviada a seguinte mensagem na area administrativa do Getar:<br>
              Enviada: " . date('d/m/Y') . "<br>" . $this->get_texto();
            $mail->Body = $texto;
            $comentario = "";
            $mail->AltBody = $comentario . "\n" . "Enviada: " . date('d/m/Y');

            if (!$mail->Send()) { // Envia o email
                $msgMens = "<b style=\"color: red;\">A Mensagem nao foi enviada </b>
                    Erro reportado: " . $mail->ErrorInfo . "<br>";
            } else {
                $msgMens = "<b>A mensagem foi enviada com sucesso.<br>
                    Em breve retornaremos sua solicita&ccedil;&atilde;o/contato<br>";
            }
        } else {
            $msgMens = "<b style=\"color: red;\">A mensagem n&atilde;o foi enviada por e-mail pois o destinatario ou o remetente n&atilde;o tem e-mail corporativo.<br>";
        }
    }

    /**
     * Exibe os lembretes de um dia mes e ano
     * @global type $conexao
     * @param type $dia
     * @param type $mes
     * @param type $ano
     * @return string
     */
    public function lembrDia($dia, $mes, $ano) {

        // correcoes
        if ($dia < 10) {
            $strDia = "0" . $dia;
        } else {
            $strDia = $dia;
        }
        $strMes = $mes;

        $consulta = " SELECT SUBSTRING(texto, 1,40) descr,
                             cod
                        FROM getar_lembre
                       WHERE situ = 'ativo'
                             AND DATE_FORMAT(dataagd, '%d/%m/%Y') = '" . $strDia . "/" . $strMes . "/" . $ano . "'";
        $resultado = $this->retornoSQL($consulta);
        $str = "";
        $lp = 0;
        while ($dados = mysqli_fetch_array($resultado)) {
            if ($lp < 2) {
                $str.= "<div>
                            <a href=\"index.php?st=lembretes&ft=mens&pag=edit&codlmb=" . $dados['cod'] . "\">" . $dados['descr'] . "</a><br />
                        </div>";
            } else {
                if ($lp < 100) {
                    $str.= "<div>E mais...</div>";
                    $lp = 100;
                }
            }

            $lp++;
        }

        return $str;
    }

    /**
     * 
     * @param type $mes
     * @param type $ano
     * @return string
     */
    public function lembreMes($mes, $ano, $mb = FALSE) {
        if ($mb) {
            $limt = "10";
        } else {
            $limt = "40";
        }
        $consulta = " SELECT DATE_FORMAT(dataagd, '%d') dia,
                             SUBSTRING(titulo, 1, " . $limt . ") descr,
                             cod
                        FROM getar_lembre
                       WHERE situ = 'ativo'
                             AND DATE_FORMAT(dataagd, '%m/%Y') = '" . $mes . "/" . $ano . "'
                    ORDER BY dia";
        $resultado = $this->retornoSQL($consulta);
        $str = "";
        $lp = 0;
        while ($dados = mysqli_fetch_array($resultado)) {
            $lembr = explode("\n", $dados['descr']);
            $this->arrayLmb[$dados['dia']] =
                    "<div>
                        <a href=\"index.php?st=lembretes&ft=mens&pag=edit&codlmb=" . $dados['cod'] . "\">" . $lembr[0] . "</a><br />
                    </div>";
        }

        return $str;
    }

}

