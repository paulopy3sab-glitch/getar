<?php

/*
 * Trabalha com as operacoes pertinentes ao cadastro indepedente do tipo de 
 * banco de dados usado (MySQL, Oracle, PostGree 
 */

class Cadastro extends Conex {

    private $codCad;
    private $nome;
    private $clasf;
    private $contato;
    private $emailCorp;
    private $cpcn;
    private $cnpj;
    private $rgie;
    private $ie;
    private $estciv;
    private $sexo;
    private $nacna;
    private $dataNasc;
    private $dataDesde;
    private $ref;
    private $endr;
    private $numero;
    private $complemento;
    private $bairro;
    private $cep;
    private $cidade;
    private $pais;
    private $estado;
    private $situCad;
    //
    private $urlRedrt;
    // telefone e celular
    private $codTel;
    private $descrTel;
    private $numTel;
    private $ramalTel;
    // email
    private $codEml;
    private $descrEml;
    private $endrEml;
    // sites
    private $codSite;
    private $descrSite;
    private $endrSite;
    // documentos
    private $nomeDoc;
    //
    private $datalog;
    private $pesq;
    private $msg;
    private $msgFone;
    private $msgEmail;
    private $msgSite;
    private $msgPart;
    private $msgLog;
    private $msgDoc;
    private $msgCPCN;
    private $msgCEP;

    function __construct() {
        parent::__construct();
        $msg = "# inicio processamento classe Cadastro";
        $this->gravaSQL($msg);
    }

    public function get_codCad() {
        return $this->codCad;
    }

    public function set_codCad($codCad) {
        $this->codCad = $codCad;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_clasf() {
        return $this->clasf;
    }

    public function set_clasf($clasf) {
        $this->clasf = $clasf;
    }

    public function get_contato() {
        return $this->contato;
    }

    public function set_contato($contato) {
        $this->contato = $contato;
    }

    public function get_emailCorp() {
        return $this->emailCorp;
    }

    public function set_emailCorp($emailCorp) {
        $this->emailCorp = $emailCorp;
    }

    public function get_cpcn() {
        return $this->cpcn;
    }

    public function set_cpcn($cpcn) {
        $this->cpcn = $cpcn;
    }

    public function get_cnpj() {
        return $this->cnpj;
    }

    public function set_cnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function get_rgie() {
        return $this->rgie;
    }

    public function set_rgie($rgie) {
        $this->rgie = $rgie;
    }

    public function get_ie() {
        return $this->ie;
    }

    public function set_ie($ie) {
        $this->ie = $ie;
    }

    public function get_estciv() {
        return $this->estciv;
    }

    public function get_sexo() {
        return $this->sexo;
    }

    public function set_sexo($sexo) {
        $this->sexo = $sexo;
    }

    public function set_estciv($estciv) {
        $this->estciv = $estciv;
    }

    public function get_nacna() {
        return $this->nacna;
    }

    public function set_nacna($nacna) {
        $this->nacna = $nacna;
    }

    public function get_dataNasc() {
        return $this->dataNasc;
    }

    public function set_dataNasc($dataNasc) {
        $this->dataNasc = $dataNasc;
    }

    public function get_dataDesde() {
        return $this->dataDesde;
    }

    public function set_dataDesde($dataDesde) {
        $this->dataDesde = $dataDesde;
    }

    public function get_ref() {
        return $this->ref;
    }

    public function set_ref($ref) {
        $this->ref = $ref;
    }

    public function get_endr() {
        return $this->endr;
    }

    public function set_endr($endr) {
        $this->endr = $endr;
    }

    public function get_numero() {
        return $this->numero;
    }

    public function set_numero($numero) {
        $this->numero = $numero;
    }

    public function get_complemento() {
        return $this->complemento;
    }

    public function set_complemento($complemento) {
        $this->complemento = $complemento;
    }

    public function get_bairro() {
        return $this->bairro;
    }

    public function set_bairro($bairro) {
        $this->bairro = $bairro;
    }

    public function get_cep() {
        return $this->cep;
    }

    public function set_cep($cep) {
        $this->cep = $cep;
    }

    public function get_cidade() {
        return $this->cidade;
    }

    public function get_pais() {
        return $this->pais;
    }

    public function set_cidade($cidade) {
        $this->cidade = $cidade;
    }

    public function set_pais($pais) {
        $this->pais = $pais;
    }

    public function get_estado() {
        return $this->estado;
    }

    public function set_estado($estado) {
        $this->estado = $estado;
    }

    public function get_situCad() {
        return $this->situCad;
    }

    public function set_situCad($situCad) {
        $this->situCad = $situCad;
    }

    public function get_urlRedrt() {
        return $this->urlRedrt;
    }

    public function set_urlRedrt($urlredrt) {
        $this->urlRedrt = $urlredrt;
    }

    public function get_codTel() {
        return $this->codTel;
    }

    public function set_codTel($codTel) {
        $this->codTel = $codTel;
    }

    public function get_descrTel() {
        return $this->descrTel;
    }

    public function set_descrTel($descrTel) {
        $this->descrTel = $descrTel;
    }

    public function get_numTel() {
        return $this->numTel;
    }

    public function set_numTel($numTel) {
        $this->numTel = $numTel;
    }

    public function get_ramalTel() {
        return $this->ramalTel;
    }

    public function set_ramalTel($ramalTel) {
        $this->ramalTel = $ramalTel;
    }

    public function get_descrOper() {
        return $this->descrOper;
    }

    public function set_descrOper($descrOper) {
        $this->descrOper = $descrOper;
    }

    public function get_situOper() {
        return $this->situOper;
    }

    public function set_situOper($situOper) {
        $this->situOper = $situOper;
    }

    public function get_codEml() {
        return $this->codEml;
    }

    public function set_codEml($codEml) {
        $this->codEml = $codEml;
    }

    public function get_descrEml() {
        return $this->descrEml;
    }

    public function set_descrEml($descrEml) {
        $this->descrEml = $descrEml;
    }

    public function get_endrEml() {
        return $this->endrEml;
    }

    public function set_endrEml($endrEml) {
        $this->endrEml = $endrEml;
    }

    public function get_codSite() {
        return $this->codSite;
    }

    public function set_codSite($codSite) {
        $this->codSite = $codSite;
    }

    public function get_descrSite() {
        return $this->descrSite;
    }

    public function set_descrSite($descrSite) {
        $this->descrSite = $descrSite;
    }

    public function get_endrSite() {
        return $this->endrSite;
    }

    public function set_endrSite($endrSite) {
        $this->endrSite = $endrSite;
    }

    public function get_nomeDoc() {
        return $this->nomeDoc;
    }

    public function set_nomeDoc($nomeDoc) {
        $this->nomeDoc = $nomeDoc;
    }

    private function set_datalog($novo_datalog) {
        $this->datalog = $novo_datalog;
    }

    public function get_datalog() {
        return $this->datalog;
    }

    public function get_pesq() {
        return $this->pesq;
    }

    public function set_pesq($pesq) {
        $this->pesq = $pesq;
    }

    public function get_msg() {
        return $this->msg;
    }

    public function set_msg($msg) {
        $this->msg = $msg;
    }

    public function get_msgFone() {
        return $this->msgFone;
    }

    public function set_msgFone($msgFone) {
        $this->msgFone = $msgFone;
    }

    public function get_msgEmail() {
        return $this->msgEmail;
    }

    public function set_msgEmail($msgEmail) {
        $this->msgEmail = $msgEmail;
    }

    public function get_msgSite() {
        return $this->msgSite;
    }

    public function set_msgSite($msgSite) {
        $this->msgSite = $msgSite;
    }

    public function get_msgPart() {
        return $this->msgPart;
    }

    public function set_msgPart($msgPart) {
        $this->msgPart = $msgPart;
    }

    public function get_msgLog() {
        return $this->msgLog;
    }

    public function set_msgLog($msgLog) {
        $this->msgLog = $msgLog;
    }

    public function get_msgDoc() {
        return $this->msgDoc;
    }

    public function set_msgDoc($msgDoc) {
        $this->msgDoc = $msgDoc;
    }

    public function get_msgCPCN() {
        return $this->msgCPCN;
    }

    public function set_msgCPCN($msgCPCN) {
        $this->msgCPCN = $msgCPCN;
    }

    public function get_msgCEP() {
        return $this->msgCEP;
    }

    public function set_msgCEP($msgCEP) {
        $this->msgCEP = $msgCEP;
    }

    /**
     * Para logon no sistema
     * @return string
     */
    public function logon_sis() {
        $consulta = "SELECT hashsl,
                            nick,
                            codcad
                       FROM getar_control
                      WHERE nick  ='" . $this->get_nick() . "'";
        #$dados = $this->consultaSQL(cad_cons02($this->get_nick(), $this->get_senha()));
        $dados = $this->consultaSQL($consulta);
        if (password_verify($this->get_senha(), $dados['hashsl'])) {
            $msg = "<b style=\"color: red;\">Bem Vindo!!!</b>";
            $this->logon_regt($dados['nick'], $dados['codcad']);
            return $msg;
        }
        $msg = "<b style=\"color: red;\">Usu&aacute;rio n&atilde;o Autorizado.</b><br>";
        $this->set_resp("visitante");
        $this->set_msgLog($msg);

        // verificar se tem redirecionamento programado
        /* $consulta = "  SELECT cl.url url,
          ct.frase senha
          FROM getar_cliente cl,
          getar_control ct
          WHERE ct.nick= cl.nick
          AND cl.nick= '" . $this->get_nick() . "'";
          $dados = $this->consultaSQL($consulta);
          if ($dados['url'] <> "") {
          // encriptar usuario e senha
          $sep = date('dH');
          $usuario = $this->get_nick();
          $usuarioRev = strrev($usuario);
          $senhaRev = strrev($dados['senha']);
          $str = $usuarioRev . $sep . $senhaRev . $sep;

          $url = $dados['url'] . "?rd=" . $str;
          $this->set_urlRedrt($url);
          } else {
          $this->set_urlRedrt("");
          }
          $this->set_urlRedrt(""); */

        return $msg;
    }

    /**
     * Registro do longon na sessao e do banco
     * @param type $nick
     * @param type $cod
     */
    protected function logon_regt($nick, $cod) {
        //Registrar a Sessao local
        $_SESSION['resp'] = $nick;
        $_SESSION['codresp'] = $cod;
        $this->set_resp($nick);

        //Registrar a sessao no Banco MySQL
        $this->executaSQL(cad_cons03($nick, $this->curtimeFuso()));
        $msg = "<b style=\"color: blue;\">Bem Vindo!</b><br>";
        $this->set_msgLog($msg);
    }

    /**
     * Para logon por redirecionamento
     * @return string
     */
    public function logon_Redir($red) {
        //decriptografar usuario e senha
        $chave = explode("*", $red);

        list($usuarioRet, $senhaRet) = (explode($chave[1], $red));

        $consulta = "SELECT cad.cod,
                            sn.nick,
                            cad.clasf
                       FROM getar_control AS sn,
                            getar_cad AS cad
                      WHERE sn.codcad= cad.cod
                            AND cad.situacao = 'ativo'
                            AND sn.nick  ='" . strrev($usuarioRet) . "'
                            AND sn.frase = '" . strrev($senhaRet) . "'";
        $dados = $this->consultaSQL($consulta);
        if ($dados['nick'] == "") {
            $msg = "<b style=\"color: red;\">Usu&aacute;rio n&atilde;o Autorizado.</b><br>";
            $this->set_resp("visitante");
            $this->set_msgLog($msg);
            return $msg;
        } else {
            $this->logon_regt($dados['nick'], $dados['cod']);
        }
    }

    /**
     * Verificar o logon e encaminhar para logof se necessario
     * $_SESSION['resp'] $_SESSION['codresp']
     * @return <boolean> TRUE se validado
     */
    public function user_validacao() {
        $validado = TRUE;
        if (!isset($_SESSION['codresp'])) {
            $validado = FALSE;
            session_unset();
            return $validado;
        }

        // Verificar se cadastrado no diretorio do dominio
        $consulta = "SELECT nick FROM getar_control WHERE nick='" . $_SESSION['resp'] . "' AND codcad= " . $_SESSION['codresp'];
        $dados = $this->consultaSQL($consulta);
        if ($dados['nick'] == "") {
            $validado = FALSE;
            session_unset();
            $msg = "<b style=\"color: red;\">Usu&aacute;rio n&atilde;o autorizado neste diret&oacute;rio</b>";
            $this->set_msgLog($msg);
            return $validado;
        }

        return $validado;
    }

    /**
     * Para logof do sistema
     * @return string
     */
    public function logof_sis() {
        //Fechar o registro da secao marcando a hora do logof
        $consulta = cad_cons05($_SESSION['resp'], $this->curtimeFuso());
        $this->executaSQL($consulta);

        $msg = "<b style=\"color: blue;\">Volte Sempre!</b><br>";
        $this->set_msgLog($msg);

        //Destroi a sessao
        session_unset();
        session_destroy();
    }

    /**
     * listagem de cadastrados
     * @param type $complemento
     * @param type $pag
     * @param type $pagList
     * @return type
     */
    public function cadList($complemento, $pag, $pagList) {
        if ($this->get_resp() <> "admin") {
            $complemento = " AND cad.cod NOT IN(1, 2, 3) " . $complemento;
        }
        $consulta = "SELECT cad.cod,
                            nome,
                            contato,
                            clasf,
                            (SELECT numero FROM getar_fones WHERE codcli = cad.cod LIMIT 1) AS fones,
                            (SELECT endr FROM getar_emails WHERE codcli = cad.cod LIMIT 1) AS email,
                            cidade,
                            estado,
                            (SELECT nick
                             FROM getar_control ct
                             WHERE ct.codcad = cad.cod
                             LIMIT 1) nick,
                            situacao,
                            cad.clasf
                       FROM getar_cad cad
                  WHERE cad.situacao != 'temporario'
                        " . $complemento;
        $resultado = $this->geraPaginacao($consulta, $pagList);

        return $resultado;
    }

    /**
     * Listagem de cadastro para mobile
     * @param string $complemento
     * @param type $pag
     * @param type $pagList
     * @return type
     */
    public function mcadList($complemento, $pag, $pagList) {
        $complemento = " AND cad.cod NOT IN(1, 2, 3) " . $complemento;

        $consulta = "SELECT cad.cod,
                            nome,
                            contato,
                            clasf,
                            (SELECT numero FROM getar_fones WHERE codcli = cad.cod LIMIT 1) AS fones,
                            (SELECT endr FROM getar_emails WHERE codcli = cad.cod LIMIT 1) AS email,
                            cidade,
                            estado,
                            (SELECT nick
                             FROM getar_control ct
                             WHERE ct.codcad = cad.cod
                             LIMIT 1) nick,
                            situacao,
                            cad.clasf
                       FROM getar_cad cad
                  WHERE cad.situacao != 'temporario'
                        " . $complemento;
        $resultado = $this->geraPaginacao($consulta, $pagList);
        $str = "<table id=\"listcad\">
                <caption>Cadastro - Listagem Geral.</caption>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cidade</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str .= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                        <td>";
            if (atrib("3")) {
                $str .= "<a href=\"m-index.php?st=cadastro&pag=edit&codcad=" . $dados["cod"] . "\">"
                        . $dados['nome'] . "
                        </a>";
            }
            if (atrib("4")) {
                $str .= "<a href=\"m-index.php?st=cadastro&pag=detal&codcad=" . $dados["cod"] . "\">"
                        . $dados['nome'] . "
                        </a>";
            }
            if ($dados["contato"] != "") {
                $str .= " - " . $dados["contato"];
            }

            $str .= "     </td>
                        <td>&nbsp;" . $dados["cidade"] . " - " . $dados['estado'] . "</td>
                        <td>&nbsp;" . $dados["fones"] . "</td>
                    </tr>";
        }
        $str .= "</tbody></table>";
        $doc = "index.php?st=cadastro&pag=" . $pag;
        $str .= $this->geraIndicesPaginas($pagList, $doc);

        return $str;
    }

    /**
     * formulario de edicao de um cadastro
     * @return string
     */
    public function cadEdit() {
        if ($this->cadRestr() <> "") {
            $str = "<b style=\"color: red;\">REGISTRO RESTRITO</b>";
            return $str;
        }
        //  Cadastro provissorio
        if ($this->get_codCad() == "") {
            $consulta = "INSERT INTO getar_cad (nome, desde, clasf, cidade, estado, situacao)
                                VALUES('', CURDATE(), 'c', '" . $this->get_cidPadr() . "', '" . $this->get_estPadr() . "', 'temporario')";
            $this->executaIdSQL($consulta);
            $codCad = $this->get_idRet();
            $this->set_codCad($codCad);
        }
        $consulta = "SELECT cad.cod,
                            cad.nome,
                            cad.clasf,
                            (SELECT emailcorp FROM getar_control WHERE codcad = " . $this->get_codCad() . ") emailcorp,
                            cad.contato,
                            cad.rgie,
                            cad.ie,
                            cad.cpcn,
                            cad.cnpj,
                            cad.endr,
                            cad.numero,
                            cad.complemento,
                            cad.bairro,
                            cad.cidade,
                            (SELECT codpais FROM estado est WHERE est.pais = cad.pais LIMIT 1) codpais,
                            cad.cep,
                            cad.estado,
                            cad.pais,
                            '',
                            estd.nome nmestado,
                            '',
                            date_format(cad.nasc, '%d') dia_nasc,
                            date_format(cad.nasc, '%m') mes_nasc,
                            date_format(cad.nasc, '%Y') ano_nasc,
                            date_format(cad.desde, '%d') dia_desde,
                            date_format(cad.desde, '%m') mes_desde,
                            date_format(cad.desde, '%Y') ano_desde,
                            cad.ref,
                            (SELECT COUNT(*) FROM getar_part WHERE nick = '" . $_SESSION['resp'] . "' AND codcad= cad.cod) nm,
                            cad.situacao
                       FROM getar_cad cad,
                            getar_estado estd
                      WHERE cad.getar_estado_cod= estd.cod
                            AND cad.cod=" . $this->get_codCad();

        $dados = $this->consultaSQL($consulta);
        //para eventual criacao de um logon
        $this->set_clasf($dados['clasf']);

        return $dados;
    }

    /**
     * Validar se o estado cadastrado esta correto
     * @return boolean
     */
    public function validaEstado($est) {
        $consulta = "SELECT COUNT(*) nm FROM estado WHERE nome = '" . $est . "'";
        $dados = $this->consultaSQL($consulta);
        $situ = $dados['nm'];

        return $situ;
    }

    /**
     * Edicao de Cadastro especifica para mobile
     * @return string
     */
    public function mcadEdit() {
        if ($this->cadRestr() <> "") {
            $str = "<b style=\"color: red;\">REGISTRO RESTRITO</b>";
            return $str;
        }
        //  Cadastro provissorio
        if ($this->get_codCad() == "") {
            $consulta = "INSERT INTO getar_cad (nome, desde, clasf, situacao)
                                VALUES('Cadastro Novo', CURDATE(), 'g', 'temporario')";
            $this->executaIdSQL($consulta);
            $codCad = $this->get_idRet();
            $this->set_codCad($codCad);
        }
        $consulta = "SELECT cod,
                            nome,
                            clasf,
                            contato,
                            rgie,
                            ie,
                            cpcn,
                            estciv,
                            nacna,
                            prof,
                            endr,
                            bairro,
                            cidade,
                            cep,
                            estado,
                            date_format(nasc, '%d') dia_nasc,
                            date_format(nasc, '%m') mes_nasc,
                            date_format(nasc, '%Y') ano_nasc,
                            date_format(desde, '%d') dia_desde,
                            date_format(desde, '%m') mes_desde,
                            date_format(desde, '%Y') ano_desde,
                            ref,
                            (SELECT COUNT(*) FROM getar_part WHERE nick = '" . $_SESSION['resp'] . "' AND codcad= getar_cad.cod) nm,
                            situacao
                       FROM getar_cad
                      WHERE cod=" . $this->get_codCad();

        $dados = $this->consultaSQL($consulta);
        //para eventual criacao de um logon
        $this->set_clasf($dados['clasf']);
        //Ocultando os cadatros particulares que nao sao do logado
        $bloq = "nao";
        if ($dados['clasf'] == "u" && $dados['nm'] == 0) {
            $bloq = "sim";
        }

        if (($dados['cod'] <> $this->get_codCad()) OR ( $bloq == "sim")) {
            $str = "<b style=\"color: red\">Nenhum registro para o codigo " . $this->get_codCad() . "</b>";
            return $str;
        }
        $str = "<form name=\"formCadastro\" action=\"m-index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "\" method=\"post\" onSubmit=\"return validaForm();\">
                <input name=\"cod\" type=\"hidden\" value=\"" . $this->get_codCad() . "\">
                <input name=\"mae\" type=\"hidden\" value=\"\">
                <input name=\"conj\" type=\"hidden\" value=\"\">
                <input name=\"sexo\" type=\"hidden\" value=\"\">
                <fieldset>
                    <legend>Dados Cadastrais</legend>
                    <label>C&oacute;digo :</label><b>" . $this->get_codCad() . "</b><br>
                    <label>Nome:</label>
                    <input name=\"nome\" type=\"text\" size=\"42\" maxlength=\"120\" value=\"" . $dados['nome'] . "\" autofocus><br>
                    <label>Nascimento: </label>" . selectData("_nasc", $dados['dia_nasc'], $dados['mes_nasc'], $dados['ano_nasc']) . "<br />";
        $msgDtPd = "";
        if (($dados['dia_nasc'] == "01") && ($dados['mes_nasc'] == "01") && ($dados['ano_nasc'] == "2001")) {
            $msgDtPd = "<small><i style=\"color: blue;\">01/Janeiro/2001 &eacute a data padr&atilde;o</i></small>";
        }
        $str .= "<label>Cliente desde: </label>" . selectData("_desde", $dados['dia_desde'], $dados['mes_desde'], $dados['ano_desde']);
        if (($dados['dia_desde'] == "01") && ($dados['mes_desde'] == "01") && ($dados['ano_desde'] == "2001")) {
            $msgDtPd = "<small><i style=\"color: blue;\">01/Janeiro/2001 &eacute a data padr&atilde;o</i></small>";
        }
        $str .= $msgDtPd . "<br />
            <label>Contato: </label>
            <input name=\"cont\" type=\"text\" id=\"cont\" value=\"" . $dados['contato'] . "\" size=\"22\" maxlength=\"20\"><br>";

        if ($this->atrib("2")) {// evita que outros alterem as classificacoes
            $str .= "<label> Classifica&ccedil;&atilde;o:</label>";
            //So exibir a lista para os administradores
            $str .= $this->selectClasf($dados['clasf']) . "<br />";
        } else {
            $str .= "<input name=\"clasf\" type=\"hidden\" value=\"" . $dados['clasf'] . "\">";
        }

        if ($this->get_msgPart() <> "") {
            $str .= $this->get_msgPart();
        }
        if (($dados['clasf'] <> "g") && (atrib("2"))) {
            $displayEmailCorp = " ";
        } else {
            $displayEmailCorp = " display: none;";
        }
        $str .= "<div id=\"adminEmailCorp\" style=\"" . $displayEmailCorp . "\">
                <label>E-mail Corporativo: </label>
                <input name=\"emailcorp\" type=\"text\" value=\"" . $dados['emailcorp'] . "\" size=\"22\" maxlength=\"20\"><br>
                <small><i style=\"color: blue;\">E-mail para receber mensagens do Getar.<br> Necesita de logon ativo, contate administrador do sistema.</i></small><br>
            </div>
            <label>RG: </label><input name=\"rgie\" type=\"text\" value=\"" . $dados['rgie'] . "\" size=\"22\" maxlength=\"20\"><br>
            <label>Ins. Estadual: </label><input name=\"ie\" type=\"text\" value=\"" . $dados['ie'] . "\" size=\"22\" maxlength=\"20\"><br>
            <label>CPF/CNPJ:</label><input name=\"cpcn\" type=\"text\" value=\"" . $dados['cpcn'] . "\" size=\"22\" maxlength=\"20\"><br>
            <label>Estado C&iacute;vil:</label>" . $this->selectEstCiv($dados['estciv']) . "<br>
            <label>Nacionalidade:</label><input name=\"nacna\" type=\"text\" value=\"" . $dados['nacna'] . "\" size=\"22\" maxlength=\"20\"><br>
            <label>Profiss&atilde;o:</label><input name=\"prof\" type=\"text\" value=\"" . $dados['prof'] . "\" size=\"22\" maxlength=\"60\"><br>
            <label>Refer&ecirc;ncia: </label><input name=\"ref\" type=\"text\" id=\"ref\" value=\"" . $dados['ref'] . "\" size=\"42\" maxlength=\"40\"><br>
            <label>Endere&ccedil;o: </label><input name=\"endr\" type=\"text\" value=\"" . $dados['endr'] . "\" size=\"42\" maxlength=\"40\"><br>
            <label>Bairro: </label><input name=\"bairro\" type=\"text\" value=\"" . $dados['bairro'] . "\"><br>
            <label>CEP.: </label><input name=\"cep\" type=\"text\" size=\"10\" maxlength=\"9\" value=\"" . $dados['cep'] . "\"><br>
            <label>Cidade: </label><input name=\"cidade\" type=\"text\" size=\"22\" maxlength=\"20\" value=\"" . $dados['cidade'] . "\"><br>
            <label>Estado: </label>" . $this->selectEstados($dados['estado']) . "<br>
            <label>Situa&ccedil;&atilde;o: </label>
            <select name=\"situacao\">
                <option value=\"ativo\" " . $this->selectedIf($dados['situacao'], "ativo") . ">ativo</option>
                <option value=\"inativo\" " . $this->selectedIf($dados['situacao'], "inativo") . ">inativo</option>
            </select><br>
            <label>&nbsp;</label><input type='submit' name='salvarCad' value='Atualizar'><br>";
        $str .= $this->get_msg();
        $str .= "</fieldset></form>";

        $str .= "<fieldset><legend>COMPLEMENTOS DO CONTATO: " . $this->cadNome() . "</legend>";
        $str .= $this->cadComple(FALSE);
        $str .= "</fieldset>
                <hr>";

        return $str;
    }

    /**
     * Apenas detalhamento de um cadastro
     * Nao permite edicao
     * @return string
     */
    public function cadDetal() {
        $consulta = "SELECT cod,
                            nome,
                            clasf,
                            emailcorp,
                            contato,
                            endr,
                            bairro,
                            cidade,
                            cep,
                            estado,
                            date_format(nasc, '%d') dia_nasc,
                            date_format(nasc, '%m') mes_nasc,
                            date_format(nasc, '%Y') ano_nasc,
                            date_format(desde, '%d') dia_desde,
                            date_format(desde, '%m') mes_desde,
                            date_format(desde, '%Y') ano_desde,
                            ref,
                            (SELECT COUNT(*) FROM getar_part WHERE nick = '" . $_SESSION['resp'] . "' AND codcad= getar_cad.cod) nm 
                       FROM getar_cad
                      WHERE cod= " . $this->get_codCad();
        $dados = $this->consultaSQL($consulta);
        //Ocultando os cadatros particulares que nao sao do logado
        $bloq = "nao";
        if ($dados['clasf'] == "u" && $dados['nm'] == 0) {
            $bloq = "sim";
        }

        if (($dados['cod'] <> $this->get_codCad()) OR ( $bloq == "sim")) {
            $str = "<b style=\"color: red\">Nenhum registro para o codigo " . $this->get_codCad() . "</b>";
            return $str;
        }
        $str = "<fieldset>
                    <legend>Dados Cadastrais</legend>
                    <label>C&oacute;digo :</label><b>" . $this->get_codCad() . "</b><br>
                    <label>Nome:</label>
                    <b>" . $dados['nome'] . "</b><br>
                    <label>Nascimento: </label>" . $dados['dia_nasc'] . "/" . $dados['mes_nasc'] . "/" . $dados['ano_nasc'] . "<br />";
        $msgDtPd = "";
        if (($dados['dia_nasc'] == "01") && ($dados['mes_nasc'] == "01") && ($dados['ano_nasc'] == "2001")) {
            $msgDtPd = "<small><i style=\"color: blue;\">01/Janeiro/2001 &eacute a data padr&atilde;o</i></small>";
        }
        $str .= "<label>Cliente desde: </label>" . $dados['dia_desde'] . "/" . $dados['mes_desde'] . "/" . $dados['ano_desde'];
        if (($dados['dia_desde'] == "01") && ($dados['mes_desde'] == "01") && ($dados['ano_desde'] == "2001")) {
            $msgDtPd = "<small><i style=\"color: blue;\">01/Janeiro/2001 &eacute a data padr&atilde;o</i></small>";
        }
        $str .= $msgDtPd . "<br />
            <label>Contato: </label>
            <b>" . $dados['contato'] . "</b><br>
            <label> Classifica&ccedil;&atilde;o:</label>";
        $arrayClasf = $this->descrClasf($dados['clasf']);
        $str .= $arrayClasf[1] . "<br />";
        $str .= "<label>Refer&ecirc;ncia: </label><b>" . $dados['ref'] . "</b><br>
                <label>Endere&ccedil;o: </label><b>" . $dados['endr'] . "</b><br>
                <label>Bairro: </label><b>" . $dados['bairro'] . "</b><br>
                <label>CEP.: </label><b>" . $dados['cep'] . "</b><br>
                <label>Cidade: </label><b>" . $dados['cidade'] . "</b><br>
                <label>Estado: </label><b>" . $dados['estado'] . "</b><br>
                 </fieldset></form>";

        $str .= "<fieldset><legend>COMPLEMENTOS DO CONTATO: " . $this->cadNome() . "</legend>";
        $str .= $this->cadComple(TRUE);
        $str .= "</fieldset>
                <hr>";

        return $str;
    }

    /**
     * Switch para cadastro
     * @param type $pag
     * @return string
     */
    public function cadSwitch($pag) {

        if ($this->atrib("6")) {// cadastro particulares
            $complemento = "AND ((cad.cod IN(SELECT codcad nm FROM getar_part WHERE nick = '" . $this->get_resp() . "' AND codcad= cad.cod))
                              OR (cad.clasf <> 'u'))";
        }
        switch ($pag) {
            case 'edit':
                $complemento = " AND cod = " . $this->get_codCad() . " ";
                break;
            case 'listunc'://lista somente um cadastro - editando um logon
                $complemento = " AND cod = " . $this->get_codCad() . " ";
                break;
            case 'detal':
                $complemento = "  AND cod = " . $this->get_codCad() . " ";
                break;
            case 'cad':
                $complemento = "  AND cod = " . $this->get_codCad() . " ";
                break;
            case 'list':
                $complemento = " AND situacao = 'ativo' ";
                break;
            case 'listff':
                $complemento = " AND situacao = 'ativo'
                         AND clasf IN('r', 'b')";
                break;
            case 'listall':
                $complemento = " ";
                break;
            case 'listu':
                $complemento = " ORDER BY cod DESC";
                break;
            case 'listlog':
                $complemento = " AND cad.cod IN(SELECT codcad FROM getar_control) ORDER BY cod DESC";
                break;
            case 'excl':
                excluir();
                $complemento = " ORDER BY cod DESC";
                break;
            case 'pesq':
                $complemento = " AND nome LIKE '" . $this->get_pesq() . "%' ORDER BY nome";
                break;
            case 'psqcpf':
                $complemento = " AND cpcn LIKE '" . $this->get_pesq() . "%' ORDER BY nome";
                break;
            case 'psqdsd':
                $complemento = " AND desde = '" . $this->get_pesq() . "' ORDER BY nome";
                break;
            case 'listingr':
                $complemento = "";
                break;
            default :
                $complemento = "";
                break;
        }

        return $complemento;
    }

    /**
     * Opcoes de listagem e pesquisa para cadastro
     * return <string> $str
     */
    public function cadOpcoes() {
        $str = "<div id=\"opcoes\">";

        if (atrib("3")) {

            $str .= "<div id=\"elemento\">
                        <a href=\"index.php?st=cadastro&pag=cad\" accesskey=\"n\">
                            <img src=\"imagens/novo.jpg\" alt=\"Novo\" titlie=\"Cadastro Novo\" ><br>
                            Cadastro Novo
                        </a>
                    </div>";
        }

        $str .= "<!--<div id=\"elemento\">
                    <a href=\"index.php?st=cadastro&pag=list\">
                        <img src=\"imagens/lista.jpg\" alt=\"Listar\" title=\"Listagem Geral\" ><br>
                        Listar
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=cadastro&pag=listall\">
                        <img src=\"imagens/lista.jpg\" alt=\"Todos\" title=\"Listo Todos (inativos tambem)\"><br>
                        Listar Todos
                    </a>
                </div>-->
                <div id=\"elemento\">
                    <a href=\"index.php?st=cadastro&pag=listu\">
                        <img src=\"imagens/lista.jpg\"  alt=\"Listar Ultimos\" title=\"Listar comecando pelo ultimos\"><br>
                        Listar &Uacute;ltimos
                    </a>
                </div>";

        if (atrib("2")) {
            $str .= "<div id=\"elementoAdmin\">    
                <a href=\"index.php?st=cadastro&pag=listlog\">
                    <img src=\"imagens/lista.jpg\" alt=\"Logaveis\" title=\"Listar administradores, vendedores, tecnicos com logon no sistema\"><br>
                    Listar Logaveis
                </a>
            </div>";
        }

        if (atrib("5")) {
            $str .= "<div id=\"elementoAdmin\">
                        <a href=\"index.php?st=cadastro&pag=listff\">
                            <img src=\"imagens/lista.jpg\"  alt=\"\" title=\"Listar Fornecedores/Fabricantes\"><br>
                            Listar fornecedores, fabricantes
                        </a>
                    </div>";
        }

        $str .= "<div id=\"elemento\" style=\"width: 132px;\">
                    <form action=\"index.php?st=cadastro&pag=pesq\" method=\"post\">
                    <fieldset>
                        <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                        <input type=\"hidden\" name=\"pagina\" value=\"\">
                        Pesquisa: <br />
                        <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"p\">
                        <input name=\"listar\" type=\"submit\" value=\"Pesquisar\">
                    </fieldset>
                    </form>
                </div>
                <div id=\"elemento\" style=\"width: 132px;\">
                    <form action=\"index.php?st=cadastro&pag=psqcpf\" method=\"post\">
                    <fieldset>
                        <input type=\"hidden\" name=\"pag\" value=\"psqcpf\">
                        <input type=\"hidden\" name=\"pagina\" value=\"\">
                        Pesq. por CPF: <br />
                        <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"14\" accesskey=\"c\">
                        <input name=\"listar\" type=\"submit\" value=\"Pesquisar\">
                    </fieldset>
                    </form>
                </div>
                <!--<div id=\"elemento\" style=\"width: 132px;\">
                    <form action=\"index.php?st=cadastro&pag=psqdsd\" method=\"post\">
                    <fieldset>
                        Pesq. por Dia: <br />
                        " . $this->selectDesde() . "
                        <input name=\"listar\" type=\"submit\" value=\"Pesquisar\">
                    </fieldset>
                    </form>
                </div>-->
            </div>";

        return $str;
    }

    /**
     * Rodape de opcoes para mobile
     * @return string
     */
    public function mcadOpcoes() {
        $str = "<div id=\"opcoes\">";

        if (atrib("3")) {

            $str .= "<div id=\"elemento\">
                        <a href=\"index.php?st=cadastro&pag=cad\" accesskey=\"n\">
                            <img src=\"imagens/novo.jpg\" alt=\"Novo\" titlie=\"Cadastro Novo\" ><br>
                            Cadastro Novo
                        </a>
                    </div>";
        }

        $str .= "<div id=\"elemento\">
                    <a href=\"index.php?st=cadastro&pag=list\">
                        <img src=\"imagens/grupo.gif\" alt=\"Listar\" title=\"Listagem Geral\" ><br>
                        Listar
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=cadastro&pag=listall\">
                        <img src=\"imagens/grupo.gif\" alt=\"Todos\" title=\"Listo Todos (inativos tambem)\"><br>
                        Listar Todos
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=cadastro&pag=listu\">
                        <img src=\"imagens/grupo.gif\"  alt=\"Listar Ultimos\" title=\"Listar comecando pelo ultimos\"><br>
                        Listar &Uacute;ltimos
                    </a>
                </div>";

        if (atrib("2")) {
            $str .= "<div id=\"elementoAdmin\">    
                <a href=\"index.php?st=cadastro&pag=listlog\">
                    <img src=\"imagens/grupo.gif\" alt=\"Logaveis\" title=\"Listar administradores, vendedores, tecnicos com logon no sistema\"><br>
                    Listar Logaveis
                </a>
            </div>";
        }

        if (atrib("5")) {
            $str .= "<div id=\"elementoAdmin\">
                        <a href=\"index.php?st=cadastro&pag=listff\">
                            <img src=\"imagens/grupo.gif\"  alt=\"\" title=\"Listar Fornecedores/Fabricantes\"><br>
                            Listar fornecedores, fabricantes
                        </a>
                    </div>";
        }

        $str .= "<br style=\"clear: both;\" />
                 <div id=\"elemento\" style=\"height: 92px;\">
                    <form action=\"index.php?st=cadastro&pag=pesq\" method=\"post\">
                    <fieldset>
                        <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                        <input type=\"hidden\" name=\"pagina\" value=\"\">
                        Pesquisa: <br />
                        <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"p\">
                        <input name=\"listar\" type=\"submit\" value=\"Pesquisar\">
                    </fieldset>
                    </form>
                </div>
                <div id=\"elemento\">
                    <form action=\"index.php?st=cadastro&pag=psqcpf\" method=\"post\">
                    <fieldset>
                        <input type=\"hidden\" name=\"pag\" value=\"psqcpf\">
                        <input type=\"hidden\" name=\"pagina\" value=\"\">
                        Pesquisa por CPF: <br />
                        <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"14\" accesskey=\"c\">
                        <input name=\"listar\" type=\"submit\" value=\"Pesquisar\">
                    </fieldset>
                    </form>
                </div>
            </div>";

        return $str;
    }

    /**
     * Monta select das classificacoes do cadastro
     * @param type $clasf
     * @return string
     */
    public function selectClasf($clasf) {
        $str = "<select name=\"clasf\">";
        if ($this->atrib("2")) {
            $str .= "<option value=\"a\"" . selectedIf($clasf, "a") . "> administrador</option>";
            $str .= "<option value=\"s\"" . selectedIf($clasf, "s") . "> secretario(s)</option>";
        }
        if ($this->atrib("50")) {
            $str .= "<option value=\"v\"" . $this->selectedIf($clasf, "v") . "> vendedor</option>";
        }
        $str .= "<option value=\"c\"" . selectedIf($clasf, "c") . "> cliente</option>";
        if ($this->atrib("30")) {
            $str .= "<option value=\"n\"" . selectedIf($clasf, "n") . "> analista</option>";
            $str .= "<option value=\"p\"" . selectedIf($clasf, "p") . "> programador/designer</option>";
        }
        if ($this->atrib("40")) {
            $str .= "<option value=\"n\"" . selectedIf($clasf, "n") . "> engenheiro</option>";
            $str .= "<option value=\"t\"" . selectedIf($clasf, "t") . "> tecnico</option>";
        }
        if ($this->atrib("60")) {
            $str .= "<option value=\"f\"" . selectedIf($clasf, "f") . "> financeiro</option>";
        }
        if ($this->atrib("20")) {
            $str .= "<option value=\"r\"" . selectedIf($clasf, "r") . "> fornecedor</option>
                    <option value=\"b\"" . selectedIf($clasf, "b") . "> fabricante</option>";
        }
        $str .= "<option value=\"g\"" . selectedIf($clasf, "g") . "> geral</option>";
        if ($this->atrib("100")) {
            $str .= "<option value=\"u\"" . selectedIf($clasf, "u") . "> particular</option>";
        }

        $str .= "</select>";

        return $str;
    }

    /**
     * Selelct com todas as datas de cadastro (desde
     * @return string
     */
    public function selectDesde() {
        $consulta = " SELECT DISTINCT(desde),
                            DATE_FORMAT(desde, '%d/%m/%Y') dia
                       FROM getar_cad
                      WHERE cod NOT IN(1, 2, 3)
                     ORDER BY desde";
        $resultado = $this->retornoSQL($consulta);

        $str = "<select name=\"string\">";
        while ($dados = $this->arraySQL($resultado)) {
            $str .= "<option value=\"" . $dados['desde'] . "\"> " . $dados['dia'] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }

    /**
     * Retorna a descricao resumida e completa de uma classificacao de um cliente
     * Ex.: a = administrador msg "Administrador do site."
     * a = administrador, v = vendedor, c = cliente, p = programador/designer,
     * f = financeiro e g = geral
     * @param <char> $clasf 
     * @return <array> $arrayDescr[1]= resumida - $arrayDescr[2]= completa
     */
    public function descrClasf($clasf) {
        switch ($clasf) {
            case 'a':
                $descricao = 'administrador';
                $msg = "Administrador do site.";
                break;
            case 'v':
                $descricao = 'vendedor';
                $msg = "Para listar na lista de contatos.";
                break;
            case 'c':
                $descricao = 'cliente';
                $msg = "Para cadastrar projetos.";
                break;
            case 'p':
                $descricao = 'programador/designer';
                $msg = "Para programador e designer.";
                break;
            case 'f':
                $descricao = 'financeiro';
                $msg = "Para departamento financa (contas a pagar e receber).";
                break;
            case 'b':
                $descricao = 'fabricante';
                $msg = "Fabricante de produtos e pecas";
                break;
            case 'r':
                $descricao = 'fornecedor';
                $msg = "Fornecedor de quem se compra";
                break;
            case 'u':
                $descricao = 'particular';
                $msg = "Cadastro de particular";
                break;
            case 'g':
                $descricao = 'geral';
                $msg = "Apenas para consulta on line.";
                break;
            default:
                $descricao = "geral";
                $msg = "Apenas para consulta on line.";
        }
        $arrayDescr[1] = $descricao;
        $arrayDescr[2] = $msg;
        return $arrayDescr;
    }

    /**
     * salva alteracoes no cadastro
     */
    public function cadSalvar() {
        //Validando o CPF
        if ($this->get_cpcn() <> "") {
            $valida = $this->validaCPF($this->get_cpcn());
            if (!$valida) {
                $this->msgCPCN = "<b style=\"color: red;\">CPF inv&aacute;lido</b>";
            }
        }

        //Validando o CNPJ
        if ($this->get_cnpj() <> "") {
            $valida = $this->validaCNPJ($this->get_cnpj());
            if (!$valida) {
                $this->msgCPCN = "<b style=\"color: red;\">CNPJ inv&aacute;lido</b>";
            }
        }

        //Validando o CEP
        if ($this->get_cep() <> "") {
            $valida = $this->validaCEP($this->get_cep());
            if (!$valida) {
                $this->msgCEP = "<b style=\"color: red;\">CEP invalido</b>";
            }
        }

        $consulta = "UPDATE getar_cad SET nome= '" . $this->get_nome() . "',
                                     nasc= '" . $this->get_dataNasc() . "',
                                     desde= '" . $this->get_dataDesde() . "',
                                     contato='" . $this->get_contato() . "',
                                     ie='" . $this->get_ie() . "',
                                     cpcn='" . $this->get_cpcn() . "',
                                     cnpj='" . $this->get_cnpj() . "',
                                     endr='" . $this->get_endr() . "',
                                     numero='" . $this->get_numero() . "',
                                     complemento='" . $this->get_complemento() . "',
                                     bairro='" . $this->get_bairro() . "',
                                     cidade='" . $this->get_cidade() . "',
                                     pais='" . $this->get_pais() . "',
                                     estado='" . $this->get_estado() . "',
                                     cep='" . $this->get_cep() . "',
                                     ref='" . $this->get_ref() . "',
                                     clasf= '" . $this->get_clasf() . "',
                                     situacao= '" . $this->get_situCad() . "'
                               WHERE cod=" . $this->get_codCad();
        $this->msg = $this->executaSQL($consulta);

        if ($this->get_clasf() == "u") {// Se for um cadastro particular
            // ver se ja esta cadastrado
            $consulta = "SELECT COUNT(*) nm FROM getar_part WHERE nick = '" . $this->get_resp() . "' AND codcad= " . $this->get_codCad();
            $dados = $this->consultaSQL($consulta);
            $this->set_msgPart("");
            if ($dados['nm'] == 0) {
                $consulta = "INSERT getar_part (nick, codcad) VALUES('" . $this->get_resp() . "', " . $this->get_codCad() . ")";
                $msgPart = $this->executaSQL($consulta);
                $msgPart = "<br><i style=\"color: blue\">Registro Partcular -</i> " . $msgPart;
                $msgPart .= "<br><b style=\"color: red\">BLOQUEADO AOS DEMAIS USU&Aacute;RIOS!!</b> ";
                $this->set_msgPart($msgPart);
            }
        } else {
            $consulta = "DELETE FROM getar_part WHERE nick = '" . $this->get_resp() . "' AND codcad = " . $this->get_codCad();
            $this->executaSQL($consulta);
            // Nao avisar se liberado
            $msgPart = "";
            /* $msgPart= "<br><i style=\"color: blue\">Registro Partcular -</i> ".$msgPart;
              $msgPart.= "<br><b style=\"color: red\">LIBERADO AOS DEMAIS USU&Aacute;RIOS!!</b> "; */
        }

        #se for atualizado o email corporativo
        if ($this->get_emailCorp() <> '') {
            $consulta = "UPDATE getar_control SET emailcorp='" . $this->get_emailCorp() . "' WHERE codcad= " . $this->get_codCad();
            $this->msg = $this->executaSQL($consulta);
        }

        //registrando log        
        $str = "Cadastro Editado: " . $this->get_nome() . ".\n";
        $clasf = $this->descrClasf($this->get_clasf());
        $str .= "Tipo " . $clasf[1] . ".\n";
        $str .= "Situacao " . $this->get_situCad() . ".\n";
        $this->gravaLog($str);
    }

    /**
     * retorna o nome do cadastro em foco por get_codCad
     * @return <string> $nome
     */
    public function cadNome() {
        $consulta = "SELECT nome FROM getar_cad WHERE cod=" . $this->get_codCad();
        $dados = $this->consultaSQL($consulta);

        return $dados['nome'];
    }

    /**
     * lista itens complementares do cadastrado
     * telefones, emails, site e redes sociai
     * @param <boolean> $bloq bloqueia a edicao e exclusao de complementos
     * @return string
     */
    public function cadComple($bloq = FALSE) {
        //telefones
        $consulta = "SELECT cod, numero, descr, ramal FROM getar_fones WHERE codcli=" . $this->get_codCad() . " AND situ='ativo'";
        $retorno = $this->retornoSQL($consulta);

        $str = "<fieldset>
            <legend>Telefones</legend>";
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<div class=\"txt\">
                        " . $dados['descr'] . ": " . $dados['numero'];
            if ($dados['ramal'] <> "") {
                $str .= " - Ramal: " . $dados['ramal'];
            }
            if (!$bloq) {
                $str .= "<a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&fnedt=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este Telefone\" style=\"height: 16px;\">
                        </a>
                        <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&fnexc=" . $dados['cod'] . "\">
                            <img src=\"imagens/lixo.gif\" alt=\"Excluir\" title=\"Excluir este telefone\">
                        </a><br>";
            }
            $str .= "</div>";
        }
        $str .= $this->get_msgFone();

        if (!$bloq) {
            $str .= " <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&fnedt=\">
                        <img src=\"imagens/novo.jpg\" alt=\"Novo\" title=\"Novo Telefone\">Adicionar telefone<br>
                    </a>";
        }
        $str .= "</fieldset>";

        //emails
        $consulta = "SELECT cod, endr, descr FROM getar_emails WHERE codcli=" . $this->get_codCad();
        $retorno = $this->retornoSQL($consulta);

        $str .= "<fieldset>
            <legend>Emails</legend>";
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<div class=\"txt\">
                        " . $dados['descr'] . ": <a href=\"mailto:" . $dados['endr'] . "\">" . $dados['endr'] . "</a>";
            if (!$bloq) {
                $str .= "<a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&emedt=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este Email\" style=\"height: 16px;\">
                        </a>
                        <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&emexc=" . $dados['cod'] . "\">
                            <img src=\"imagens/lixo.gif\" alt=\"Excluir\" title=\"Excluir este email\">
                        </a><br>";
            }
            $str .= "</div>";
        }
        $str .= $this->get_msgEmail();
        if (!$bloq) {
            $str .= " <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&emedt=\">
                        <img src=\"imagens/novo.jpg\" alt=\"Novo\" title=\"Novo Email\">Adicionar email<br>
                    </a>";
        }
        $str .= "</fieldset>";

        //site e rede sociais
        $consulta = "SELECT cod, endr, descr FROM getar_sites WHERE codcli=" . $this->get_codCad();
        $retorno = $this->retornoSQL($consulta);

        $str .= "<fieldset>
            <legend>Site e Redes Sociais</legend>";
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<div class=\"txt\">
                        " . $dados['descr'] . ": <a href=\"" . $dados['endr'] . "\" target=\"_blank\">" . $dados['endr'] . "</a>";
            if (!$bloq) {
                $str .= "<a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&stedt=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este Site\" style=\"height: 16px;\">
                        </a>
                        <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&stexc=" . $dados['cod'] . "\">
                            <img src=\"imagens/lixo.gif\" alt=\"Excluir\" title=\"Excluir este Site\">
                        </a><br>";
            }
            $str .= "</div>";
        }
        $str .= $this->get_msgSite();
        if (!$bloq) {
            $str .= "<a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&stedt=\">
                        <img src=\"imagens/novo.jpg\" alt=\"Novo\" title=\"Novo Email\">Adicionar Site
                    </a><br>";
        }
        $str .= "</fieldset>";

        $str .= "<fieldset>
            <legend>Documentos Digitalizados:</legend>";
        //documento
        $consulta = "SELECT cod,
                            codcad,
                            nomedoc
                       FROM getar_doc
                      WHERE codcad =" . $this->get_codCad();
        $retorno = $this->retornoSQL($consulta);
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<div class=\"txt\">
                        <a href=\"" . $this->get_localDocs() . $dados['nomedoc'] . "\" target=\"_blank\">" . $dados['nomedoc'] . "</a>";
            if (!$bloq) {
                $str .= "<a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&dcexc=" . $dados['cod'] . "\">
                            <img src=\"imagens/lixo.gif\" alt=\"Excluir\" title=\"Excluir este Documento\">
                        </a><br>";
            }
            $str .= "</div>";
        }
        $str .= $this->get_msgDoc();
        if (!$bloq) {
            $str .= "<a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&dcadd=\">
                        <img src=\"imagens/novo.jpg\" alt=\"Novo\" title=\"Novo Documento\">Adicionar Documento<br>
                    </a>";
        }

        $str .= "</fieldset>";

        return $str;
    }

    /**
     * formulario para edicao e inclusao de telefone
     * @return string
     */
    public function foneEdit() {
        //se necessario gerar o temporario
        if ($this->get_codTel() == "") {
            $numero = "(99)9 9999-9999";
            $descr = "Fone Novo";
            $consulta = "INSERT INTO getar_fones (codcli, numero, descr, ramal) VALUES(" . $this->get_codCad() . ", '" . $numero . "', '" . $descr . "', '')";
            $this->executaIdSQL($consulta);
            $codFone = $this->get_idRet();
            $this->set_codTel($codFone);
        }
        $consulta = "SELECT cod, numero, descr, ramal FROM getar_fones WHERE cod=" . $this->get_codTel();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * formulario para edicao e insercao de email
     * @return string
     */
    public function emailEdit() {
        //se necessario gerar o temporario
        if ($this->get_codEml() == "") {
            $endr = "nome@provedor.com";
            $descr = "Email Principal";
            $consulta = "INSERT INTO getar_emails (codcli, endr, descr) VALUES(" . $this->get_codCad() . ", '" . $endr . "', '" . $descr . "')";
            $this->executaIdSQL($consulta);
            $codEmail = $this->get_idRet();
            $this->set_codEml($codEmail);
        }
        $consulta = "SELECT cod, endr, descr FROM getar_emails WHERE cod=" . $this->get_codEml();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * formulario para edicao e insercao de site
     * @return string
     */
    public function siteEdit() {
        //se necessario gerar o temporario
        if ($this->get_codEml() == "") {
            $endr = "http://www.site.com";
            $descr = "Site Principal";
            $consulta = "INSERT INTO getar_sites (codcli, endr, descr) VALUES(" . $this->get_codCad() . ", '" . $endr . "', '" . $descr . "')";
            $this->executaIdSQL($consulta);
            $codEmail = $this->get_idRet();
            $this->set_codEml($codEmail);
        }
        $consulta = "SELECT cod, endr, descr FROM getar_sites WHERE cod=" . $this->get_codEml();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Formulario para anexar documento
     * @return string
     */
    public function docAdd() {
        $str = "<fieldset>
                    <legend>Anexando Documento</legend>
                    <form name=\"formdoc\" action=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "\" method=\"post\" enctype=\"multipart/form-data\">
                        <input type=\"hidden\" name=\"codcad\" value=\"" . $this->get_codcad() . "\" />
                        <input type=\"file\" name=\"docenv\"><br />
                        <label>&nbsp;</label>
                        <input type=\"submit\" name=\"docadd\" value=\"Enviar\" />
                    </form>
                </fieldset>";

        return $str;
    }

    /**
     * Salva alteracoes num telefone
     */
    public function foneSalvar() {
        if ($this->get_numTel() == "") {
            return;
        }

        //se necessario gerar o temporario
        if ($this->get_codTel() == "") {
            $numero = "(99)9 9999-9999";
            $descr = "Fone Novo";
            $consulta = "INSERT INTO getar_fones (codcli, numero, descr, ramal) VALUES(" . $this->get_codCad() . ", '" . $numero . "', '" . $descr . "', '')";
            $this->executaIdSQL($consulta);
            $codFone = $this->get_idRet();
            $this->set_codTel($codFone);
        }

        $consulta = "UPDATE getar_fones
                        SET numero= '" . $this->get_numTel() . "',
                            descr='" . $this->get_descrTel() . "',
                            ramal='" . $this->get_ramalTel() . "'
                      WHERE cod=" . $this->get_codTel();
        $this->msgFone = $this->executaSQL($consulta);
    }

    /**
     * Salva alteracoes num email
     */
    public function emailSalvar() {
        if ($this->get_endrEml() == "") {
            return;
        }

        //se necessario gerar o temporario
        if ($this->get_codEml() == "") {
            $endr = "nome@provedor.com";
            $descr = "Email Principal";
            $consulta = "INSERT INTO getar_emails (codcli, endr, descr) VALUES(" . $this->get_codCad() . ", '" . $endr . "', '" . $descr . "')";
            $this->executaIdSQL($consulta);
            $codEmail = $this->get_idRet();
            $this->set_codEml($codEmail);
        }
        $consulta = "UPDATE getar_emails
                        SET endr= '" . $this->get_endrEml() . "',
                            descr='" . $this->get_descrEml() . "'
                      WHERE cod=" . $this->get_codEml();
        $this->msgEmail = $this->executaSQL($consulta);
    }

    /**
     * Salva alteracoes num site
     */
    public function siteSalvar() {
        $consulta = "UPDATE getar_sites
                        SET endr= '" . $this->get_endrSite() . "',
                            descr='" . $this->get_descrSite() . "'
                      WHERE cod=" . $this->get_codSite();
        $this->msgSite = $this->executaSQL($consulta);
    }

    /**
     * Exclui um telefone do banco
     */
    public function foneExcl() {
        // Pegar fone e avisar
        $consulta = "SELECT numero, descr, ramal FROM getar_fones WHERE cod=" . $this->get_codTel();
        $dados = $this->consultaSQL($consulta);
        $this->msgFone = "<b style=\"color: red;\">Fone " . $dados['numero'] . ": " . $dados['descr'] . " Excluido.</b><br>";
        $consulta = "DELETE FROM getar_fones WHERE cod=" . $this->get_codTel();
        $this->executaSQL($consulta);
    }

    /**
     * Exclui um email do banco
     */
    public function emailExcl() {
        // Pegar email e avisar
        $consulta = "SELECT endr, descr FROM getar_emails WHERE cod=" . $this->get_codEml();
        $dados = $this->consultaSQL($consulta);
        $this->msgEmail = "<b style=\"color: red;\">Email " . $dados['endr'] . ": " . $dados['descr'] . " Excluido.</b><br>";
        $consulta = "DELETE FROM getar_emails WHERE cod=" . $this->get_codEml();
        $this->executaSQL($consulta);
    }

    /**
     * Exclui um email do banco
     */
    public function siteExcl() {
        // Pegar site e avisar
        $consulta = "SELECT endr, descr FROM getar_sites WHERE cod=" . $this->get_codSite();
        $dados = $this->consultaSQL($consulta);
        $this->msgSite = "<b style=\"color: red;\">Site " . $dados['endr'] . ": " . $dados['descr'] . " Excluido.</b><br>";
        $consulta = "DELETE FROM getar_sites WHERE cod=" . $this->get_codSite();
        $this->executaSQL($consulta);
    }

    /**
     * Listagem de ingresso no sistema
     * @param type $complemento
     * @param type $pag
     * @param type $pagList
     * @return type
     */
    public function ingressoList($complemento, $pag, $pagList) {
        $consulta = "    SELECT rg.cod,
                                rg.nick,
                                (SELECT cl.url FROM getar_cliente cl WHERE cl.nick = rg.nick) url,
                                DATE_FORMAT(rg.datalog, '%d/%m/%Y') datalog,
                                rg.horaini,
                                rg.horault,
                                rg.horafim
                           FROM getar_reglog rg
                          WHERE 1 = 1
                               " . $complemento . "
                      ORDER BY cod DESC";
        $resultado = $this->geraPaginacao($consulta, $pagList);
        $str = "<table>
                <caption>Listagem de Logons no Sistema</caption>
                <thead>
                    <tr>
                        <th>Reg.</th>
                        <th>Nick</th>
                        <th>Data</th>
                        <th>Hora Logon</th>
                        <th>Hora Atividade</th>
                        <th>Hora Logof</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $url = "";
            if ($dados['url'] <> "") {
                $url = "[" . $dados['url'] . "]";
            }
            $str .= "<tr class=\"" . corLinha() . "\">
                        <th>" . $dados['cod'] . "</th>
                        <td>" . $dados['nick'] . $url . "</td>
                        <td>" . $dados['datalog'] . "</td>
                        <td>" . $dados['horaini'] . "</td>
                        <td>" . $dados['horault'] . "</td>
                        <td>" . $dados['horafim'] . "</td>
                    </tr>";
        }
        $str .= "</tbody></table>";
        $doc = "index.php?st=cadastro&pag=" . $pag;
        $str .= $this->geraIndicesPaginas($pagList, $doc);

        return $str;
    }

    /**
     * Libera cadastro de logons no sistema e chama para criar ou
     *  editar(se jah existente) 
     * @return string
     */
    public function ingressoLibera() {
        $str = "";
        $lib = FALSE; // liberado ou nao o logon
        $clasf = $this->get_clasf();
        switch ($clasf) {
            case "a":// administrado
                $lib = TRUE;
                break;
            case "s":// secretaria(o)
                $lib = TRUE;
                break;
            case "v":// vendedor
                $lib = TRUE;
                break;
            case "c":// cliente
                if ($this->get_logCliente()) {
                    $lib = TRUE;
                }
                break;
            case "p":// programador
                $lib = TRUE;
                break;
            case "t":// tecnico
                $lib = TRUE;
                break;
            case "f":// financeiro
                $lib = TRUE;
                break;
        }

        //se liberado
        if ($lib) {
            if ($this->ingressoCar() == "") {
                $str = $this->ingressoNovo();
            } else {
                $str = $this->ingressoEdit();
            }
        }

        return $str;
    }

    /**
     * formulario para alterar ou cadastrar logon no sistema
     * @return string
     */
    public function ingressoEdit() {

        //se necessario gerar o temporario
        if ($this->get_nick() == "") {
            // verificar se nao tem mesmo para o cadastro em foco
            $nick = $this->ingressoCar();
            $this->set_nick($nick);
            if ($nick == "") {
                $nick = "temp" . $this->get_codCad();
                $this->set_nick($nick);
                $consulta = "INSERT INTO getar_control (nick, codcad, hashsl, contra) VALUES('', " . $this->get_codCad() . ", 'xxxx', 'xxxx')";
                $this->executaSQL($consulta);

                $novoLog = TRUE;
            } else {
                $novoLog = FALSE;
            }
        } else {
            $novoLog = FALSE;
        }
        $consulta = "SELECT cad.cod,
                            cad.nome,
                            ctl.nick
                       FROM getar_control ctl,
                            getar_cad cad
                      WHERE ctl.codcad = cad.cod";
        if ($novoLog) {
            $consulta .= " AND codcad=" . $this->get_codCad();
        } else {
            $consulta .= " AND ctl.nick= '" . $this->get_nick() . "'";
        }
        $dados = $this->consultaSQL($consulta);

        $str = "<form name=\"formLogon\" action=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "\" method=\"post\" \">
                    <input name=\"codcad\" type=\"hidden\" value=\"" . $this->get_codCad() . "\">
                    <input name=\"novolog\" type=\"hidden\" value=\"" . $novoLog . "\">
                    <fieldset>
                    <legend>Logon no Sistema</legend>
                    <label>Nome: </label><b>" . $dados['nome'] . "</b><br>
                    <label>C&oacute;digo: </label><b>" . $dados['cod'] . "</b><br>
                    <label>&nbsp;</label><i><div id=\"divNick\">&nbsp;</div></i>
                    <br style=\"clear:both;\" />
                    <label>Nick Para Logon: </label>";
        if ($novoLog) {
            $str .= "
                <input name=\"nick\" value=\"" . $nick . "\" autocomplete=\"off\" size=\"22\" maxlength=\"20\" onkeyup=\"atualDivNick(this.value);\" /><br />";
        } else {
            $str .= "<b>" . $dados['nick'] . "</b>
                <input type=\"hidden\" name=\"nick\" value=\"" . $dados['nick'] . "\" /><br>";
        }
        $str .= "<label>&nbsp;</label><i><div id=\"divSenha\">&nbsp;</div></i>
                 <br style=\"clear:both;\" />
                 <label>Senha: </label><input name='frase' id=\"frase\" type='password' size='22' maxlength='20' onkeyup=\"atualDivSenha(this.value);\"><br>
                 <label>Senha (Confirmacao): </label><input name='frase2' type='password' size='22' maxlength='20' onkeyup=\"senhaComp(this.value);\"><br>
                 <label>&nbsp;</label><input type='submit' name='salvaringr' value='Salvar'><br>
                 " . $this->get_msgLog() . "
                 </fieldset>
             </form>";

        return $str;
    }

    /**
     * Contra senha para pagamentos (modulo financeiro)
     */
    public function contraEdit() {
        $str .= "<form name=\"formContra\" action=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "\" method=\"post\" \">
                    <input name=\"codcad\" type=\"hidden\" value=\"" . $this->get_codCad() . "\">
                    <input name=\"novolog\" type=\"hidden\" value=\"" . $novoLog . "\">
                    <fieldset>
                    <legend>Contra Senha para Financeiro</legend>
                    <label>Nome: </label><b>" . $dados['nome'] . "</b><br>
                    <label>C&oacute;digo: </label><b>" . $dados['cod'] . "</b><br>
                    <label>Nick Para Logon: </label>";
        if ($novoLog) {
            $str .= "<input name=\"nick\" value=\"" . $dados['nick'] . "\" size=\"22\" maxlength=\"20\" /><br />";
        } else {
            $str .= "<b>" . $dados['nick'] . "</b>
                <input type=\"hidden\" name=\"nick\" value=\"" . $dados['nick'] . "\" /><br>";
        }
        $str .= " <label>Senha: </label><input name='contra' type='password' size='22' maxlength='20'><br>
                 <label>Senha (Confirmacao): </label><input name='contra2' type='password' size='22' maxlength='20'><br>
                 <label>&nbsp;</label><input type='submit' name='salvarcontra' value='Salvar'><br>
                 " . $this->get_msgLog() . "
                 </fieldset>
             </form>";
    }

    /**
     * Salvar o nome do documento no banco
     * @param type $docEnv
     */
    public function docSalvar($docEnv) {
        $consulta = "INSERT INTO getar_doc (codcad, nomedoc) VALUES(" . $this->get_codCad() . ", '" . $docEnv . "')";
        $this->executaIdSQL($consulta);
    }

    /**
     * Apaga do Banco um documento
     * @param type $codDoc
     */
    public function docExcl($codDoc) {
        //pegar nome do documento para excluir fisicamente
        $consulta = "SELECT nomedoc FROM getar_doc WHERE cod=" . $codDoc;
        $dados = $this->consultaSQL($consulta);
        if (!$this->get_suces()) {
            $msgDoc = "<b style=\"Erro ao consultar documento no Banco\"></b>";
            return;
        }
        $this->set_nomeDoc($dados['nomedoc']);

        $consulta = "DELETE FROM getar_doc WHERE cod=" . $codDoc;
        $msgDoc = $this->executaSQL($consulta);
        $this->set_msgDoc($msgDoc);
    }

    /**
     * salva alteracoes no logon do cadastro
     * @param type $novoLog
     * @param type $senha
     * @param type $confirma
     * @return string
     */
    public function ingressoSalvar($novoLog, $senha, $confirma) {
        //Validacoes

        if ($novoLog) {
            $consulta = "UPDATE getar_control SET nick='" . $this->get_nick() . "' WHERE codcad= " . $this->get_codCad();
            $msg = $this->executaSQL($consulta);
            // aplicar perfil para logon novo
            $this->perfilAplicar();

            //Criar tambem no banco raiz
            if ($this->get_bdRaiz() <> "") {
                $consulta = "INSERT INTO " . $this->get_bdRaiz() . "getar_control (nick, codcad)
                                         VALUES('" . $this->get_nick() . "', 2)";
                $msg = $this->executaSQL($consulta);
                //Salvar diretorio origim (ramo
                $consulta = "INSERT INTO " . $this->get_bdRaiz() . "getar_cliente (nick, url)
                                         VALUES('" . $this->get_nick() . "', '" . $this->get_dirRamo() . "')";
                $msg = $this->executaSQL($consulta);
            }
        }
        // Para evitar nick e senhas em branco
        if ($senha == "") {
            $msg = "<b style=\"color: red;\">Senha inv&aacute;lida!</b><br>";
            $this->msg = $msg . "<br /><b style=\"color: red;\">Logon N&Atilde;o Alterado!</b>";
            return;
        }
        if ($senha <> $confirma) {
            $msg = "<b style=\"color: red;\">Senhas n&atilde;o conferem</b><br>";
            $this->msg = $msg . "<br /><b style=\"color: red;\">Logon N&atilde;o Alterado!</b>";
            return;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $consulta = "UPDATE getar_control SET hashsl='" . $senhaHash . "' WHERE nick= '" . $this->get_nick() . "'";
        $msg = $this->executaSQL($consulta);
        //Criar tambem no banco raiz
        if ($this->get_bdRaiz() <> "") {
            $consulta = "UPDATE " . $this->get_bdRaiz() . "getar_control SET hashsl='" . $senhaHash . "' WHERE nick= '" . $this->get_nick() . "'";
            $msg = $this->executaSQL($consulta);
        }
        if ($this->get_suces()) {
            $this->msg = "<b style=\"color: blue;\">Logon Alterado com Sucesso!</b>";
        } else {
            $this->msg = $msg . "<br /><b style=\"color: red;\">Logon N&Atilde;o Alterado!</b>";
        }

        return;
    }

    /**
     * Aplica um perfil pre programado dependendo da classificacao
     * @return type
     */
    public function perfilAplicar() {
        $consulta = "SELECT clasf FROM getar_cad WHERE cod=" . $this->get_codCad();
        $dados = $this->consultaSQL($consulta);


        //carregar atribucoes do perfil
        $consulta = " SELECT arratrib
                        FROM getar_perfil
                       WHERE clasf='" . $dados['clasf'] . "'
                       LIMIT 1";
        $dados = $this->consultaSQL($consulta);

        if ($dados['arratrib'] == "") {
            return;
        }

        $arrAtrib = explode(",", $dados['arratrib']);

        foreach ($arrAtrib as $value) {
            $consulta = "INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                                             VALUES(" . $value . ", '" . $this->get_nick() . "', 'padrao')";
            $this->executaSQL($consulta);
        }
    }

    /**
     * verificar se nick esta disponivel
     * @return boolean TRUE para jah existente
     */
    public function ingressoVerificar() {
        $consulta = "SELECT COUNT(*) nm FROM getar_control WHERE nick='" . $this->get_nick() . "'";
        $dados = $this->consultaSQL($consulta);
        //Verificar se tambem esta disponivel no banco raiz
        if ($this->get_bdRaiz() <> "" && $dados['nm'] == 0) {
            $consulta = "SELECT COUNT(*) nm FROM " . $this->get_bdRaiz() . "getar_control WHERE nick='" . $this->get_nick() . "'";
            $dados = $this->consultaSQL($consulta);
        }
        if ($dados['nm'] > 0) {
            $msg = "<b style=\"color: red\">Logon J&aacute; em uso:" . $this->get_nick() . "</b>";
            $this->set_msgLog($msg);
            //apagar o temporario
            $consulta = "DELETE FROM getar_control WHERE codcad =" . $this->get_codCad();
            $this->executaSQL($consulta);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Salvar um contra senha para lancamento financeiro
     * Jah deve estar pre criada a senha de logon
     */
    public function ingressoContra($contra, $contra2) {
        // Para evitar nick e senhas em branco
        if ($contra == "") {
            $msg = "<b style=\"color: red;\">Senha inv&aacute;lida!</b><br>";
            $this->msg = $msg . "<br /><b style=\"color: red;\">Logon N&Atilde;o Alterado!</b>";
            return;
        }
        if ($contra <> $contra2) {
            $msg = "<b style=\"color: red;\">Senhas n&atilde;o conferem</b><br>";
            $this->msg = $msg . "<br /><b style=\"color: red;\">Logon N&atilde;o Alterado!</b>";
            return;
        }
        $senhaHash = password_hash($contra, PASSWORD_DEFAULT);
        $consulta = "UPDATE getar_control SET contrahash='" . $senhaHash . "' WHERE nick= '" . $this->get_nick() . "'";
        $msg = $this->executaSQL($consulta);

        if ($this->get_suces()) {
            $this->msg = "<b style=\"color: blue;\">Logon Alterado com Sucesso!</b>";
        } else {
            $this->msg = $msg . "<br /><b style=\"color: red;\">Logon N&atilde;o Alterado!</b>";
        }
    }

    /**
     * Carrega o nick apartir do cod do cadastro
     * @return type
     */
    public function ingressoCar() {
        $consulta = "SELECT nick
                             FROM getar_control ct
                             WHERE ct.codcad = " . $this->get_codCad() . "
                             LIMIT 1";
        $dados = $this->consultaSQL($consulta);

        return $dados['nick'];
    }

    /**
     * link para criar um logno novo
     * @return string
     */
    public function ingressoNovo() {
        $str = "<fieldset>
                  <legend>Logon no Sistema</legend>
                    <a href=\"index.php?st=cadastro&pag=ingr&nick=&codcad=" . $this->get_codCad() . " \">
                        <img src=\"imagens/novo.jpg\" alt=\"Novo\" title=\"Adcionar Logon no sistema\">Adicionar Logon<br>
                    </a>
                </fieldset>";

        return $str;
    }

    /**
     * Restringe acesso a registro restritos (1, 2 e 3) ao admin
     * @return string Aviso se registro restrito, "" se registro normal
     */
    public function cadRestr() {
        if ($this->get_resp() <> "admin") {
            if ($this->get_codCad() == "1") {
                $str = "<b style=\"color: red;\">REGISTRO RESTRITO</b>";
                return $str;
            }
            if ($this->get_codCad() == "2") {
                $str = "<b style=\"color: red;\">REGISTRO RESTRITO</b>";
                return $str;
            }
            if ($this->get_codCad() == "3") {
                $str = "<b style=\"color: red;\">REGISTRO RESTRITO</b>";
                return $str;
            }
        }
        return "";
    }

    /**
     * Listagem dos telefones do cadastro
     * @param type $codCad
     * @return string
     */
    public function foneList($codCad) {
        $consulta = "SELECT cod, numero, descr FROM getar_fones WHERE codcli = " . $codCad;
        $resultado = $this->retornoSQL($consulta);

        $str = "";
        $br = "";
        while ($dados = arraySQL($resultado)) {
            $str .= $br . $dados['descr'] . ":" . $dados['numero'] . "
                  <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&fnexc=" . $dados['cod'] . "\">
                      <img src=\"imagens/lixo.gif\" alt=\"Excluir\" title=\"Excluir este telefone\">
                  </a>";
            $br = "<br />";
        }


        return $str;
    }

    /**
     * Listagem de emails do cadastro
     * @param type $codCad
     * @return string
     */
    public function emailList($codCad) {
        $consulta = "SELECT cod, endr, descr FROM getar_emails WHERE codcli = " . $codCad;
        $resultado = $this->retornoSQL($consulta);

        $str = "";
        $br = "";
        while ($dados = arraySQL($resultado)) {
            $str .= $br . $dados['endr'] . "
                  <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $this->get_codCad() . "&emexc=" . $dados['cod'] . "\">
                      <img src=\"imagens/lixo.gif\" alt=\"Excluir\" title=\"Excluir este email\">
                  </a><br> ";
            $br = "<br />";
        }


        return $str;
    }

    /**
     * Listagem dos aniversariantes mes
     * @return string
     */
    public function aniver() {
        $consulta = " SELECT cod,
                            nome,
                            TIMESTAMPDIFF(YEAR, nasc, CURDATE()) as idade,
                            DATE_FORMAT(nasc, '%d') dia,
                            'dia' per,
                            1 ord
                       FROM getar_cad
                      WHERE nasc != '2001-01-01'
                            AND situacao NOT IN ('inativo')
                            AND DATE_FORMAT(nasc, '%d/%m') = DATE_FORMAT(CURDATE(), '%d/%m')
                     UNION(SELECT cod,
                            nome,
                            TIMESTAMPDIFF(YEAR, nasc, CURDATE()) as idade,
                            DATE_FORMAT(nasc, '%d') dia,
                            'mes' per,
                            2 ord
                       FROM getar_cad
                      WHERE nasc != '2001-01-01'
                            AND situacao NOT IN ('inativo')
                            AND DATE_FORMAT(nasc, '%m') = DATE_FORMAT(CURDATE(), '%m'))
                     ORDER BY ord";
        $resultado = $this->retornoSQL($consulta);

        $temDados = FALSE; //Controle para nao criar cabecalho de tabela vazio

        $str = "<table width=\"60%\">
                <caption>Aniversariantes M&ecirc;s</caption>
                <thead>
                    <tr>
                        <th>Reg.</th>
                        <th>Nome</th>
                        <th>Dia</th>
                        <th>Idade</th></tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $temDados = TRUE;
            $str .= "<tr class=\"" . $this->corLinha() . "\">
                        <th>" . $dados['cod'] . "</th>
                        <td>" . $dados['nome'] . "
                            <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $dados["cod"] . "\">
                               <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este registro\">
                            </a>
                        </td>
                        <td>";
            if ($dados['per'] == "dia") {
                $str .= "<b style=\"color: blue;\">HOJE</b>";
            } else {
                $str .= $dados['dia'];
            }
            $str .= "</td>
                        <td>" . $dados['idade'] . "</td>
                      </tr>";
        }
        $str .= "</tbody></table>";
        // bloquear cabecalho tabela vazia
        if (!$temDados) {
            $str = "";
        }
        return $str;
    }

    /**
     * Lista cadastrados no dia
     * @return string
     */
    public function novoHoje() {
        $consulta = " SELECT cod,
                            nome
                       FROM getar_cad
                      WHERE DATE_FORMAT(desde, '%d/%m/%Y') = DATE_FORMAT(CURDATE(), '%d/%m/%Y')
                     ORDER BY cod";
        $resultado = $this->retornoSQL($consulta);

        $temDados = FALSE; //Controle para nao criar cabecalho de tabela vazio

        $str = "<table width=\"60%\">
                <caption>Cadastros Novos Hoje</caption>
                <thead>
                    <tr>
                        <th>Reg.</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $temDados = TRUE;
            $str .= "<tr class=\"" . $this->corLinha() . "\">
                        <th>" . $dados['cod'] . "</th>
                        <td>" . $dados['nome'] . "
                            <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $dados["cod"] . "\">
                               <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este registro\">
                            </a>
                        </td>
                      </tr>";
        }
        $str .= "</tbody></table>";
        // bloquear cabecalho tabela vazia
        if (!$temDados) {
            $str = "";
        }

        return $str;
    }

    /**
     * Consulta fones do cadastro
     * @return type
     */
    public function consFones() {
        $consulta = "SELECT cod, numero, descr, ramal FROM getar_fones WHERE codcli=" . $this->get_codCad() . " AND situ='ativo'";
        $retorno = $this->retornoSQL($consulta);
        return $retorno;
    }

    /**
     * Consulta Emails do cadastro
     * @return type
     */
    public function consEmails() {
        $consulta = "SELECT cod, endr, descr FROM getar_emails WHERE codcli=" . $this->get_codCad();
        $retorno = $this->retornoSQL($consulta);

        return $retorno;
    }

    /**
     * Consulta Site e redes socias do cadastro
     * @return type
     */
    public function consSites() {
        $consulta = "SELECT cod, endr, descr FROM getar_sites WHERE codcli=" . $this->get_codCad();
        $retorno = $this->retornoSQL($consulta);

        return $retorno;
    }

    /**
     * Ocultando os cadatros particulares que nao sao do logado
     * @param type $dados
     * @return boolean
     */
    public function ocultaPart($dados) {
        $bloq = FALSE;
        if ($dados['clasf'] == "u" && $dados['nm'] == 0) {
            $bloq = TRUE;
        }

        return $bloq;
    }

}
