<?php

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data de criacao:
 * @date: desconhecida ate 28/05/2025
 * Descricao:Metodos de apoio a Projetos de Programacao
 * Revisoes:
 */
class Estoque extends Conex {

    use Testcons;

    public $msgEst;
    public $msgAcop;
    public $msgItem;
    public $msgRet;
    private $dataReg;
    // propriedades para estoque
    private $codEst;
    #private $numEst;
    private $nossoNum;
    private $descr;
    private $descrTec;
    private $datasheet;
    private $und;
    private $qtd;
    private $peso;
    private $situ;
    private $foto;
    private $qtdMin;
    private $valorCusto;
    private $valorVenda;
    private $moeda;
    private $codClasf;
    private $codLocal;
    private $descrLocal;
    private $codCatg;
    private $codSubCatg;
    // propriedades para retiradas
    private $codRet;
    private $motv;
    // propriedades para pedidos
    private $codPed;
    public $novoPed;
    private $nomePed;
    private $codForn;
    private $codCli;
    private $ospro;
    private $dataPed;
    private $dataRecb;
    private $rastr;
    private $valorFrete;
    private $emprFrete;
    private $situPed;
    private $tipoPed;
    private $codItem;
    private $situItem;

    public function __construct() {
        parent::__construct();
        $this->msgAcop = "";
        $this->msgItem = "";
        $this->novoPed = FALSE;
    }

    public function get_dataReg() {
        return $this->dataReg;
    }

    public function set_datReg($dataReg) {
        $this->dataReg = $dataReg;
    }

    public function get_msgAcop() {
        return $this->msgAcop;
    }

    public function set_msgAcop($msgAcop) {
        $this->msgAcop = $msgAcop;
    }

    public function get_msgItem() {
        return $this->msgItem;
    }

    public function set_msgItem($msgItem) {
        $this->msgItem = $msgItem;
    }

    //Metodos para Estoque
    public function get_codEst() {
        return $this->codEst;
    }

    public function set_codEst($codEst) {
        $this->codEst = $codEst;
    }

    /* public function get_numEst() {
      return $this->numEst;
      }

      public function set_numEst($numEst) {
      $this->numEst = $numEst;
      } */

    public function get_nossoNum() {
        return $this->nossoNum;
    }

    public function set_nossoNum($nossoNum) {
        $this->nossoNum = $nossoNum;
    }

    public function get_descr() {
        return $this->descr;
    }

    public function set_descr($descr) {
        $this->descr = $descr;
    }

    public function get_descrTec() {
        return $this->descrTec;
    }

    public function set_descrTec($descrTec) {
        $this->descrTec = $descrTec;
    }

    public function get_datasheet() {
        return $this->datasheet;
    }

    public function set_datasheet($datasheet) {
        $this->datasheet = $datasheet;
    }

    public function get_und() {
        return $this->und;
    }

    public function set_und($und) {
        $this->und = $und;
    }

    public function get_qtd() {
        return $this->qtd;
    }

    public function set_qtd($qtd) {
        $this->qtd = $qtd;
    }

    public function get_peso() {
        return $this->peso;
    }

    public function set_peso($peso) {
        $this->peso = $peso;
    }

    public function get_situ() {
        return $this->situ;
    }

    public function set_situ($situ) {
        $this->situ = $situ;
    }

    public function get_foto() {
        return $this->foto;
    }

    public function set_foto($foto) {
        $this->foto = $foto;
    }

    public function get_qtdMin() {
        return $this->qtdMin;
    }

    public function set_qtdMin($qtdMin) {
        $this->qtdMin = $qtdMin;
    }

    public function get_valorCusto() {
        return $this->valorCusto;
    }

    public function set_valorCusto($valorCusto) {
        $this->valorCusto = $valorCusto;
    }

    public function get_valorVenda() {
        return $this->valorVenda;
    }

    public function set_valorVenda($valorVenda) {
        $this->valorVenda = $valorVenda;
    }

    public function get_moeda() {
        return $this->moeda;
    }

    public function set_moeda($moeda) {
        $this->moeda = $moeda;
    }

    public function get_codClasf() {
        return $this->codClasf;
    }

    public function set_codClasf($codClasf) {
        $this->codClasf = $codClasf;
    }

    public function get_codlocal() {
        return $this->codLocal;
    }

    public function set_codLocal($codLocal) {
        $this->codLocal = $codLocal;
    }

    public function set_descrLocal($descrLocal) {
        $this->descrLocal = $descrLocal;
    }

    public function get_descrLocal() {
        return $this->descrLocal;
    }

    public function get_codCatg() {
        return $this->codCatg;
    }

    public function set_codCatg($codCatg) {
        $this->codCatg = $codCatg;
    }

    public function get_codSubCatg() {
        return $this->codSubCatg;
    }

    public function set_codSubCatg($codSubCatg) {
        $this->codSubCatg = $codSubCatg;
    }

    //metodos para retiradas
    public function get_codRet() {
        return $this->codRet;
    }

    public function set_codRet($codRet) {
        $this->codRet = $codRet;
    }

    public function get_motv() {
        return $this->motv;
    }

    public function set_motv($motv) {
        $this->motv = $motv;
    }

    // medodos para os pedidos

    public function get_codPed() {
        return $this->codPed;
    }

    public function set_codPed($codPed) {
        $this->codPed = $codPed;
    }

    public function get_nomePed() {
        return $this->nomePed;
    }

    public function set_nomePed($nomePed) {
        $this->nomePed = $nomePed;
    }

    public function get_codForn() {
        return $this->codForn;
    }

    public function set_codForn($codForn) {
        $this->codForn = $codForn;
    }

    public function get_codCli() {
        return $this->codCli;
    }

    public function set_codCli($codCli) {
        $this->codCli = $codCli;
    }

    public function get_dataPed() {
        return $this->dataPed;
    }

    public function set_dataPed($dataPed) {
        $this->dataPed - $dataPed;
    }

    public function get_ospro() {
        return $this->ospro;
    }

    public function set_ospro($ospro) {
        $this->ospro = $ospro;
    }

    public function get_dataRecb() {
        return $this->dataRecb;
    }

    public function set_dataRecb($dataRecb) {
        $this->dataRecb = $dataRecb;
    }

    public function get_rastr() {
        return $this->rastr;
    }

    public function set_rastr($rastr) {
        $this->rastr = $rastr;
    }

    public function get_valorFrete() {
        return $this->valorFrete;
    }

    public function set_valorFrete($valorFrete) {
        $this->valorFrete = $valorFrete;
    }

    public function get_emprFrete() {
        return $this->emprFrete;
    }

    public function set_emprFrete($emprFrete) {
        $this->emprFrete = $emprFrete;
    }

    public function get_situPed() {
        return $this->situPed;
    }

    public function set_situPed($situPed) {
        $this->situPed = $situPed;
    }

    public function get_tipoPed() {
        return $this->tipoPed;
    }

    public function set_tipoPed($tipoPed) {
        $this->tipoPed = $tipoPed;
    }

    public function get_codItem() {
        return $this->codItem;
    }

    public function set_codItem($codItem) {
        $this->codItem = $codItem;
    }

    public function get_situItem() {
        return $this->situItem;
    }

    public function set_situItem($situItem) {
        $this->situItem = $situItem;
    }

    /**
     * Listagem previa dos pedidos em processamento/transito/espera
     * @param type $tipo
     * @return string
     */
    function pedidoLPrev($tipo = "") {

        $complemento = " 1 = 1";
        if ($tipo == "PTE") {// Processamtento - Transito - Espera
            $complemento = " cb.situ IN ('processamento', 'transito', 'espera') ";
            $tipoList = "<div class=\"titulo\">Listagem Pr&eacute;via de Pedidos Processamento/Transito/Espera.</div>";
        } else {
            $tipoList = "<div class=\"titulo\">Listagem Geral de Pedidos.</div>";
        }
        // Listagem previa
        $consulta = "SELECT cb.cod codpedido,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                        cb.situ,
                        cb.tipo,
                        CASE
                            WHEN cb.tipo =  'compra' THEN 'compra/reposicao'
                            WHEN cb.tipo = 'venda' THEN 'venda/orcamento'
                            WHEN cb.tipo = 'consumo' THEN 'consumo'
                            ELSE 'indefinido'
                        END AS desctipo,
                        (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens
                   FROM estpedidocab cb
                   WHERE " . $complemento;
        $resultado = $this->retornoSQL($consulta);

        $str = $tipoList . "       <table width=\"100%\">
                <tr>
                    <td class='sub-titulo'>Num. Pedido</td>
                    <td class='sub-titulo'>Fornecedor/Cliente</td>
                    <td class='sub-titulo'>Tipo</td>
                    <td class='sub-titulo'>Situ. Pedido</td>
                    <td class='sub-titulo'>Qtd. Itens</td>
                </tr>";

        while ($dados = $this->arraySQL($resultado)) {
            $style = "";

            $str.="<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">
                   <td class=\"txt\">" . $dados['codpedido'] . "</td>";

            if ($dados['tipo'] == "compra") {
                $str .= "<td class=\"txt\"><b>Fornecedor:</b> " . $dados['forn'];
            } else {
                $str .= "<td class=\"txt\"><b>Cliente:</b> " . $dados['cli'];
            }
            if ($dados['tipo'] == "venda") {
                $str.= "<br>" . $dados['equipo'];
            } elseif ($dados['tipo'] == "consumo") {
                $str.= "<br>" . $dados['projeto'];
            }
            $str .="        <a href=\"index.php?st=estoque&pag=ped_edit&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>
                        <a href=\"index.php?st=estoque&pag=list_ped&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/livro.gif\" alt=\"\" border=\"no\"></a>
                        <a href=\"impress.php?st=estoque&pag=list_ped&codped=" . $dados['codpedido'] . "\" target=\"_blank\"><img src=\"imagens/impress.jpeg\" alt=\"\" border=\"no\" width=\"16\" height=\"16\"></a>
                    </td>
                    <td class='txt'>" . $dados["desctipo"] . "</td>
                    <td class='txt'>" . $dados["situ"] . "</td>
                    <td class='txt'>" . $dados["qtitens"] . "</td>
                </tr>";
        }
        $str.= "</table>";

        return $str;
    }

    /**
     * Para criar um pedido novo, itens na listagem para pedidos
     * @return string
     */
    public function pedidoNovo() {

        $str = "<div class=\"titulo\">CRIANDO UM PEDIDO NOVO</div>";
        if (!isset($_POST['tipo'])) {
            $_POST['tipo'] = "novo";
            $str .= "<form action=\"index.php?st=estoque&pag=ped_novo\" method=\"post\">";
        } else {
            $str .= "<form action=\"index.php?st=estoque&pag=ped_edit&codped=\" method=\"post\">";
        }
        if ($_REQUEST['tipo'] == "compra") {
            $str .= "Defina o Fornecedor:
        <select name=\"forn\">";
            $consulta = "SELECT cod,
                                nome
                           FROM getar_cad
                          WHERE clasf = 'r'
                                AND situacao = 'ativo'
                       ORDER BY nome";
            $resultado = $this->retornoSQL($consulta);
            while ($dadosSelect = $this->arraySQL($resultado)) {
                $str.="<option value=\"" . $dadosSelect['cod'] . "\" >" . $dadosSelect['nome'] . "</option>";
            }

            $str.="</select>";
        }
        if ($_POST['tipo'] == "venda") {
            $str.="Defina o Cliente:
        <select name=\"cli\">";
            $consulta = "SELECT cod,
                            nome
                       FROM getar_cad
                      WHERE clasf = 'c'
                            AND situacao = 'ativo'
                   ORDER BY nome";
            $resultado = retornoSQL($consulta);
            while ($dadosSelect = arraySQL($resultado)) {
                $str.="<option value=\"" . $dadosSelect['cod'] . "\" >" . $dadosSelect['nome'] . "</option>";
            }

            $str.="</select>";
        }
        if ($_POST['tipo'] == "consumo") {
            $str.="Pedido de Consumo interno";
        }
        if ($_POST['tipo'] == "novo") {
            $str.="<select name=\"tipo\">Tipo pedido:
            <option value=\"compra\">Compra/Reposi&ccedil;&atilde;o</option>
            <option value=\"venda\">Venda/Or&ccedil;amento</option>
            <option value=\"consumo\">Consumo interno</option>
        </select>
        <input type=\"submit\" name=\"criarPedido\" value=\"Criar\">
        <br>";
        } else {
            $str.="<input type=\"hidden\" name=\"tipo\" value=\"" . $_POST['tipo'] . "\">
            <input type=\"submit\" name=\"salvarPedido\" value=\"Criar\">
        <br>";
        }
        $str.="<span class=\"txt\">
        <i>Ap&oacute;s definido o fornecedor do pedido de compra/reposi&ccedil;&atilde;o ser&aacute; encaminhado para a listagem de produtos com estoque abaixo do m&iacute;nimo.</i><br>
        <i>Pedidos de venda/or&ccedil;amento e de consumo ser&atilde;o apontados no detalhamento dos produtos que far&atilde;o parte do mesmo, assim ser&aacute; poss&iacute;vel inserir a quantidade solicitada</i> 
    </span>
</form>";

        return $str;
    }

    /**
     * Gerencia os pedidos de componentes eletronicos
     * @param type $codPed
     * @return string
     */
    public function pedidoAcopForm($codPed) {

        // Gerar um pedido de venda/orcamento vindo deratamente das OSs
        if ($codPed == "" && isset($_GET['codos'])) {
            $codos = $_GET['codos'];
            $consulta = "INSERT INTO estpedidocab (codforn, codcli, resp, tipo, ospro, dtped, situ)
                            VALUES(2, (SELECT codcli FROM ordem WHERE cod= " . $codos . "), '" . $_SESSION['resp'] . "', 'venda', " . $codos . ", CURDATE(), 'espera')";
            $msg = $this->executaIdSQL($consulta);
            $codPed = $this->get_idRet();
        }

        // Gerar um pedido de consumo interno vindo deratamente do pedido eletronico
        if ($codPed == "" && isset($_GET['codpedproj'])) {
            $codpedproj = $_GET['codpedproj'];
            $consulta = "INSERT INTO estpedidocab (codforn, codcli, resp, tipo, ospro, dtped, situ)
                            VALUES(2, 1, '" . $_SESSION['resp'] . "', 'consumo', " . $codpedproj . ", CURDATE(), 'espera')";
            $msg = $this->executaIdSQL($consulta);
            $codPed = $this->get_idRet();
        }

        $consulta = "SELECT (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                        cb.ospro,
                        date_format(cb.dtped, '%d/%m/%Y') dtped,
                        date_format(cb.dtcheg, '%d') diacheg,
                        date_format(cb.dtcheg, '%m') mescheg,
                        date_format(cb.dtcheg, '%Y') anocheg,
                        date_format(cb.dtrecb, '%d') diarecb,
                        date_format(cb.dtrecb, '%m') mesrecb,
                        date_format(cb.dtrecb, '%Y') anorecb,
                        cb.rastr,
                        cb.vlfrete,
                        cb.empfrete,
                        cb.situ,
                        cb.tipo
                   FROM estpedidocab cb
                  WHERE cb.cod = " . $codPed;
        $dados = $this->consultaSQL($consulta);

        $str = "<form action=\"index.php?st=estoque&pag=ped_edit&codped=" . $codPed . "\" method=\"post\">
        <input name=\"codped\" type=\"hidden\" value=\"" . $codPed . "\">
        <input name=\"tipo\" type=\"hidden\" value=\"" . $dados['tipo'] . "\">
    <div class=\"titulo\">ACOMPANHANDO UM PEDIDO</div>
    <table border=\"1\">
        <tr>";
        if ($dados['tipo'] == "compra") {
            $str .= "<td class=\"txt\"><b>Fornecedor:</b> " . $dados['forn'] . "</td>";
        } else {
            $str .= "<td class=\"txt\"><b>Cliente:</b> " . $dados['cli'] . "</td>";
        }
        $str .="<td class=\"txt\"><b>Pedido n&uacute;mero:</b> " . $codPed . "</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class=\"txt\"><b>Data pedido:</b> " . $dados['dtped'] . "</td>
            <td class=\"txt\">";
        if ($dados['situ'] <> "processamento" && $dados['tipo'] == "compra") {
            $str.="<b>Data Previsao de chegada:</b> " . selectData("cheg", $dados['diacheg'], $dados['mescheg'], $dados['anocheg']) . "</td>";
            if ($dados['situ'] == "recebido") {
                $str.="<td class=\"txt\"><b>Data Recebimento:</b> " . selectData("recb", $dados['diarecb'], $dados['mesrecb'], $dados['anorecb']) . "</td>";
            } else {
                $str.="<td>&nbsp;</td>";
            }
        } else {
            $str.="&nbsp;</td>
               <td>&nbsp;</td>";
        }
        $str.="</tr>";
        if ($dados['tipo'] <> "consumo") {
            $str.="<tr>
            <td class=\"txt\"><b>Rastreador:</b>
                <input name=\"rastr\" type=\"tex\"' value=\"" . $dados['rastr'] . "\" size=\"22\" maxlength=\"120\">
            </td>
            <td class=\"txt\"><b>Valor Frete:</b>
                <input name=\"vlfrete\" type=\"tex\"' value=\"" . $dados['vlfrete'] . "\" size=\"7\" maxlength=\"6\">
            </td>
            <td class=\"txt\"><b>Transportador:</b>
                <input name=\"empfrete\" type=\"tex\"' value=\"" . $dados['empfrete'] . "\" size=\"22\" maxlength=\"120\">" . "
            </td>
        </tr>";
        }
        $str.="<tr>";
        $msgRef = "";
        if ($dados['tipo'] == "compra") {
            $str.="<td class=\"txt\"><b>Tipo pedido:</b> Compra/Reposi&ccedil;&atilde;o</td>
               <td>&nbsp;</td>";
        } elseif ($dados['tipo'] == "venda") {
            $str.="<td class=\"txt\"><b>Tipo pedido:</b> Venda/Or&ccedil;amento<br></td>
               <td class=\"txt\"><b>Ordem de Servi&ccedil;o vinculada:</b>
                   <input name=\"ospro\" type=\"tex\"' value=\"" . $dados['ospro'] . "\" size=\"2\" maxlength=\"4\">
               </td>";
            $consulta = "SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) refped
                       FROM ordem od,
                            equipo eq
                      WHERE od.codeqp = eq.cod
                            AND od.cod =" . $dados['ospro'];
            $dadosPesp = $this->consultaSQL($consulta);
            $msgRef = $dadosPesp['refped'];
        } elseif ($dados['tipo'] == "consumo") {
            $str.="<td class=\"txt\"><b>Tipo pedido:</b> Consumo interno</td>
               <td class=\"txt\"><b>Pedido Vinculado:</b>
                   <input name=\"ospro\" type=\"tex\"' value=\"" . $dados['ospro'] . "\" size=\"2\" maxlength=\"4\">
               </td>";
            //Detalhar qual pedido a que se refere
            $consulta = "SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) refped
                     FROM eletro_projetos pj,
                          eletro_pedidos pd
                    WHERE pj.cod = pd.codproj
                          AND pd.cod = 0" . $dados['ospro'];
            $dadosPesp = $this->consultaSQL($consulta);
            $msgRef = $dadosPesp['refped'];
        } else {
            $str.="<td class=\"txt\"><b>Tipo pedido:</b> Indefinido</td>
               <td>&nbsp;</td>";
        }

        $str .="<td class=\"txt\"><b>Situa&ccedil;&atilde;o:</b>
                <select name=\"situ\">
                    <option value=\"processamento\" " . selectedIf("processamento", $dados['situ']) . ">Em Processamento</option>
                    <option value=\"espera\" " . selectedIf("espera", $dados['situ']) . ">Espera</option>
                    <option value=\"transito\" " . selectedIf("transito", $dados['situ']) . ">Em transito</option>";
        if ($dados['tipo'] == "compra") {
            $str .="               <option value=\"recebido\" " . selectedIf("recebido", $dados['situ']) . ">Recebido</option>";
        } else {
            $str .="               <option value=\"recebido\" " . selectedIf("finalizado", $dados['situ']) . ">Finalizado</option>";
        }
        $str .="           </select>
            </td>
        </tr>
        <tr>
            <td colspan=\"2\" class=\"txt\">" . $msgRef . "</td>
            <td>" . $this->get_msgAcop() . "<input type=\"submit\" name=\"salvarAcop\" value=\"Salvar\"></td>
        </tr>
    </table>
</form>";
        return $str;
    }

    /**
     * 
     * @param type $codPed
     * @return string
     */
    public function pedidoDetal($codPed) {

        $consulta = "SELECT cad.nome forn,
                        date_format(cb.dtped, '%d/%m/%Y') dtped,
                        date_format(cb.dtcheg, '%d/%m/%Y') dtcheg,
                        date_format(cb.dtrecb, '%d/%m/%Y') dtrecb,
                        cb.rastr,
                        cb.vlfrete,
                        cb.empfrete,
                        cb.situ,
                        cb.tipo
                   FROM getar_cad cad,
                        estpedidocab cb
                  WHERE cb.codforn = cad.cod
                        AND cb.cod = " . $codPed;
        $dados = $this->consultaSQL($consulta);

        $str = "
    <div class=\"titulo\">DETALHANDO UM PEDIDO</div>
    <table>
        <tr>
            <td class=\"txt\"><b>Fornecedor:</b> " . $dados['forn'] . "</td>
            <td class=\"txt\"><b>Pedido n&uacute;mero:</b> " . $codPed . "</td>
            <td></td>
        </tr>
        <tr>
            <td class=\"txt\"><b>Data pedido:</b> " . $dados['dtped'] . "</td>
            <td class=\"txt\"><b>Data Previsao de chegada:</b> " . $dados['dtcheg'] . "</td>
            <td class=\"txt\"><b>Data Recebimento:</b> " . $dados['dtrecb'] . "</td>
        </tr>
        <tr>
            <td class=\"txt\"><b>Rastreador:</b> " . $dados['rastr'] . "</td>
            <td class=\"txt\"><b>Valor Frete:</b> " . $dados['vlfrete'] . "</td>
            <td class=\"txt\"><b>Transportador:</b> " . $dados['empfrete'] . "</td>
        </tr>
        <tr>
            <td class=\"txt\"><b>Tipo pedido:</b> " . $dados['tipo'] . "</td>
            <td class=\"txt\"><b>Situa&ccedil;&atilde;o:</b>" . $dados['situ'] . "</td>
            <td>&nbsp;</td>
        </tr>
    </table>
</form>";

        return $str;
    }

    /**
     * 
     * @param type $codPed
     * @return string
     */
    public function pedidosDetal($codPed) {

        $complemento = "";
        if ($codPed <> "") {
            $complemento = "  AND cb.cod = " . $codPed;
        } elseif ($codPed == "") {
            $complemento = " AND cb.situ IN('processamento', 'transito') ";
        }
        $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            pd.codest,
                            pd.qt,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            " . $complemento . "
                     ORDER BY codpedido, descr";
        $resultado = $this->retornoSQL($consulta);

        $str = "<div class=\"titulo\">Listagem Pedido Processamento/Transito.</div>
            <table width=\"100%\">
                <tr>
                    <td class='sub-titulo'>Componente</td>
                    <td class='sub-titulo'>Qt. Pedida</td>
                    <td class='sub-titulo'>Custo</td>
                    <td class='sub-titulo'>Sub. Total</td>
                </tr>";

        $pedAnt = 0;
        $totPed = 0;
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";

            $str.="<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">";

            if ($dados['codpedido'] <> $pedAnt) {
                if ($pedAnt <> 0) {
                    $str.= "    <td class='txt'>&nbsp;</td>
                            <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                            <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                            <td class='txt'>&nbsp;</td>
                        </tr>";
                    $totPed = 0;
                }
                if ($dados['tipo'] == "compra") {
                    $forCli = "<b>Fornecedor:</b> " . $dados['forn'];
                } else {
                    if ($dados['tipo'] == "consumo") {
                        $forCli = $dados['projeto'] . "<br>";
                    } else {
                        $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
                    }
                }
                $str.= "
                        <tr class=" . corLinha() . ">
                            <td class='sub-titulo' colspan=\"4\">
                                " . $forCli . "- pedido: " . $dados['codpedido'] . "(" . $dados["situ"] . ")";
                $str.= "<a href=\"index.php?st=estoque&pag=ped_detal&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>";
                $str.= "</td>
                        </tr>";
                $str.="<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">
                        ";
                $pedAnt = $dados['codpedido'];
            } else {
                $str.= "";
            }

            $str.="<td class='txt'>" . $dados["codest"] . " - " . $dados["descr"];
            $custo = $dados['custo'];
            $qt = $dados['qt'];
            $subtot = $custo * $qt;
            $str.="</td>
            <td class='txt' style=\"text-align: center;\">" . $qt . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($custo, 2, ',', '.') . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($subtot, 2, ',', '.') . "</td>
        </tr>";
            $totPed += $subtot;
        }
        $str.="<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">";
        $str.= "    <td class='txt'>&nbsp;</td>
                <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                <td class='txt'>&nbsp;</td>
            </tr>
        </table>
        <hr>";

        return $str;
    }

    /**
     * 
     * @param type $codPed Codigo do pedido a ser detalhado, se vazio lista pedidos em andamento/transito
     * @param type $tipo abt = abastecimento de estoque - pro = separa para montagem de um projeto
     * @return string
     */
    public function pedidosLista($codPed) {

        $complemento = "";
        if ($codPed <> "") {
            $complemento = "  AND cb.cod = " . $codPed;
        } elseif ($codPed == "") {
            $complemento = " AND cb.situ IN('processamento', 'transito') ";
        }
        $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            pd.codest,
                            pd.qt,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            " . $complemento . "
                     ORDER BY codpedido, descr";
        $resultado = $this->retornoSQL($consulta);

        $str = "<div class=\"titulo\">Listagem Pedido Processamento/Transito.</div>
            <table width=\"100%\">
                <tr>
                    <td class='sub-titulo'>Componente</td>
                    <td class='sub-titulo'>Qt. Pedida</td>
                    <td class='sub-titulo'>Custo</td>
                    <td class='sub-titulo'>Sub. Total</td>
                </tr>";

        $pedAnt = 0;
        $totPed = 0;
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";

            $str.="<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">";

            if ($dados['codpedido'] <> $pedAnt) {
                if ($pedAnt <> 0) {
                    $str.= "    <td class='txt'>&nbsp;</td>
                            <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                            <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                            <td class='txt'>&nbsp;</td>
                        </tr>";
                    $totPed = 0;
                }
                if ($dados['tipo'] == "compra") {
                    $forCli = "<b>Fornecedor:</b> " . $dados['forn'];
                } else {
                    if ($dados['tipo'] == "consumo") {
                        $forCli = $dados['projeto'] . "<br>";
                    } else {
                        $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
                    }
                }
                $str.= "
                        <tr class=" . corLinha() . ">
                            <td class='sub-titulo' colspan=\"4\">
                                " . $forCli . "- pedido: " . $dados['codpedido'] . "(" . $dados["situ"] . ")";
                if ($dados["situ"] == "recebido") {
                    $str.= "<a href=\"index.php?st=estoque&pag=ped_detal&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>";
                } else {
                    $str.= "<a href=\"index.php?st=estoque&pag=ped_edit&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>";
                }
                $str.= "</td>
                        </tr>";
                $str.="<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">
                        ";
                $pedAnt = $dados['codpedido'];
            } else {
                $str.= "";
            }

            $str.="<td class='txt'>" . $dados["codest"] . "
            <a href=\"index.php?st=estoque&pag=edit&codestq=" . $dados["codest"] . "\">
                    <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                </a> - " . $dados["descr"];
            if ($dados['situitem'] == "esg") {
                $str.=" - <b style=\"color: red;\">ESGOTADO</b>";
            }
            $custo = $dados['custo'];
            $qt = $dados['qt'];
            $subtot = $custo * $qt;
            $str.="</td>
            <td class='txt' style=\"text-align: center;\">" . $qt . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($custo, 2, ',', '.') . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($subtot, 2, ',', '.') . "</td>
        </tr>";
            $totPed += $subtot;
        }
        $str.="<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">";
        $str.= "    <td class='txt'>&nbsp;</td>
                <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                <td class='txt'>&nbsp;</td>
            </tr>
        </table>
<hr>";

        return $str;
    }

    /**
     * 
     * @param type $codPed
     * @return string
     */
    public function pedidosListaImpress($codPed) {

        $complemento = "";
        if ($codPed <> "") {
            $complemento = "  AND cb.cod = " . $codPed;
        } elseif ($codPed == "") {
            $complemento = " AND cb.situ IN('processamento', 'transito') ";
        }
        $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            pd.codest,
                            pd.qt,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            " . $complemento . "
                     ORDER BY codpedido, descr";
        $resultado = $this->retornoSQL($consulta);

        $str = "<div class=\"titulo\">Listagem Pedido Processamento/Transito.</div>
            <table width=\"100%\" border=\"1\">
                <tr>
                    <td class='sub-titulo'>Componente</td>
                    <td class='sub-titulo'>Qt. Pedida</td>
                    <td class='sub-titulo'>Custo</td>
                    <td class='sub-titulo'>Sub. Total</td>
                </tr>";

        $pedAnt = 0;
        $totPed = 0;
        while ($dados = $this->arraySQL($resultado)) {
            $str.="<tr>";

            if ($dados['codpedido'] <> $pedAnt) {
                if ($pedAnt <> 0) {
                    $str.= "    <td class='txt'>&nbsp;</td>
                            <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                            <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                            <td class='txt'>&nbsp;</td>
                        </tr>";
                    $totPed = 0;
                }
                if ($dados['tipo'] == "compra") {
                    $forCli = "<b>Fornecedor:</b> " . $dados['forn'];
                } else {
                    if ($dados['tipo'] == "consumo") {
                        $forCli = $dados['projeto'] . " ";
                    } else {
                        $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
                    }
                }
                $str.= "
                        <tr class=" . corLinha() . ">
                            <td class='sub-titulo' colspan=\"4\">
                                " . $forCli . "- pedido: " . $dados['codpedido'] . "(" . $dados["situ"] . ")
                            </td>
                        </tr>";
                $str.="<tr>";
                $pedAnt = $dados['codpedido'];
            } else {
                $str.= "";
            }

            $str.="<td class='txt'>" . $dados["codest"] . " - " . $dados["descr"];
            if ($dados['situitem'] == "esg") {
                $str.=" - <b style=\"color: red;\">ESGOTADO</b>";
            }
            $custo = $dados['custo'];
            $qt = $dados['qt'];
            $subtot = $custo * $qt;
            $str.="</td>
            <td class='txt' style=\"text-align: center;\">" . $qt . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($custo, 2, ',', '.') . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($subtot, 2, ',', '.') . "</td>
        </tr>";
            $totPed += $subtot;
        }
        $str.="<tr>
                <td class='txt'>&nbsp;</td>
                <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                <td class='txt'>&nbsp;</td>
            </tr>
        </table>";

        return $str;
    }

    /**
     * Listagem de produtos abaixo do estoque minimo
     * @return string
     */
    public function pedidosCompra() {

        $consulta = "      SELECT codpedido,
                            descr,
                            cod,
                            fornc,
                            qtd qt,
                            valorcusto custo,
                            situpedido,
                            situitem
                       FROM (
                  SELECT '' codpedido,
                         estq.cod,
                         (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                             FROM getar_cad cad,
                                  fornecedor forn
                            WHERE cad.cod = forn.codforn
                                  AND forn.codestq = estq.cod) fornc,
                         estq.descr,
                         estq.qtd,
                         estq.valorcusto,
                         'sem pedido' situpedido,
                         '' situitem
                    FROM estoque estq
                   WHERE estq.qtd < estq.qtdmin
                         AND estq.cod NOT IN(SELECT codest FROM estpedidoitem)
                         AND estq.clasf IN ('novo', 'usado')
                  UNION(
                  SELECT (SELECT group_concat(cb.cod) 
                            FROM estpedidocab cb,
                                 estpedidoitem it
                           WHERE cb.cod = it.codped
                                 AND it.codest = estq.cod
                                 AND cb.situ IN('processamento', 'transito')) codpedido,
                         estq.cod,
                         (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                             FROM getar_cad cad,
                                  fornecedor forn
                            WHERE cad.cod = forn.codforn
                                  AND forn.codestq = estq.cod) fornc,
                         estq.descr,
                         estq.qtd,
                         estq.valorcusto,
                         (SELECT group_concat(CASE
                                                  WHEN cb.situ =  'processamento' THEN CONCAT('pedido n. ', cb.cod, ' processamento')
                                                  WHEN cb.situ = 'transito' THEN CONCAT('pedido n. ', cb.cod, ' transito')
                                                  WHEN estq.qtd < estq.qtdmin THEN 'sem pedido'
                                              END) AS stpedido
                            FROM estpedidocab cb,
                                 estpedidoitem it
                           WHERE cb.cod = it.codped
                                 AND it.codest = estq.cod
                                 AND cb.situ IN('processamento', 'transito')) AS situpedido,
                         (SELECT it.situ 
                            FROM estpedidoitem it
                           WHERE it.codest = estq.cod
                           LIMIT 1) situitem
                    FROM estoque estq
                   WHERE estq.qtd < estq.qtdmin
                         AND estq.cod IN(SELECT codest FROM estpedidoitem)
                         AND estq.clasf IN ('novo', 'usado'))) grp
                   ORDER BY descr ASC";
        $resultado = retornoSQL($consulta);

        $str = "<div class=\"titulo\">Listagem Produtos para Compra.</div>"
                . $msgItem . "<table width=\"100%\">
                <tr>
                    <td class='sub-titulo'>Componente</td>
                    <td class='sub-titulo'>Qt. Pedida</td>
                    <td class='sub-titulo'>Custo</td>
                    <td class='sub-titulo'>Situ. Pedido</td>
                </tr>";

        while ($dados = $this->arraySQL($resultado)) {
            $style = "";

            $str.=" <tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">
                    <td class='txt'>" . $dados["descr"] . " - " . $dados['fornc'] . "
            <a href=\"index.php?st=estoque&pag=edit&codestq=" . $dados["cod"] . "\" target=\"blank\">
                            <img src=\"imagens/livro.gif\" alt=\"\" border=\"0\">
                        </a>";
            if ($dados['situitem'] == "esg") {
                $str.=" - <b style=\"color: red;\">ESGOTADO</b>";
            }
            //inserindo um item em pedido
            $consulta = "SELECT est.cod,
                            est.descr,
                            forn.codforn,
                            cad.nome,
                            ped.cod codped
                       FROM fornecedor forn,
                            getar_cad cad,
                            estoque est,
                            estpedidocab ped
                       WHERE forn.codestq = est.cod
                             AND forn.codforn = cad.cod
                             AND forn.codforn = ped.codforn
                             AND ped.situ IN('processamento')
                             AND est.cod =" . $dados["cod"];
            $dadosPesq = $this->consultaSQL($consulta);
            if (($dadosPesq['codped'] <> "") && ($dados['codpedido'] <> $dadosPesq['codped'])) {
                $str.= "
            <form name=\"formCadastro\" action=\"index.php?st=estoque&pag=list_compra\" method=\"post\">
                <input name=\"codped\" type=\"hidden\"  value=\"" . $dadosPesq['codped'] . "\">
                <input name=\"codestq\" type=\"hidden\" value=\"" . $dados["cod"] . "\">                
                Pedido: " . $dadosPesq['codped'] . "               
                Qt:<input name=\"qt\" type=\"text\" value=\"\"  size=\"3\" maxlength=\"4\">                
                Custo:<input name=\"custo\" type=\"text\" value=\"\"  size=\"5\" maxlength=\"9\">
                <select name=\"situ\">
                    <option value=\"\">Dispon&iacute;vel</option>
                    <option value=\"esg\">Esgotado</option>
                </select>
                <input name=\"inserirItem\" type=\"submit\" value=\"Inserir\"> 
            </form>";
            }

            $str.="
                    </td>
                    <td class='txt'>" . $dados["qt"] . "</td>
                    <td class='txt'>" . $dados['custo'] . "</td>
                    <td class='txt'>";
            $str.= $dados["situpedido"];
            if ($dados["situpedido"] <> "sem pedido") {
                $str.= "<a href=\"index.php?st=estoque&pag=list_compra&codestq=" . $dados["cod"] . "&codped=" . $dadosPesq['codped'] . "&acao=excitem\">
                        <img src=\"imagens/lixo.gif\" alt=\"\" border=\"0\">
                    </a>";
            }

            $str.= "         </td>
                </tr>";
        }

        $str.="</table>
<hr>";

        return $str;
    }

    /**
     * Funcao abandonado pois no modo $str nao ha controle HTML
     * rodape para estoque
     * @return string
     */
    public function estoqueRodape() {
        $str = "";
        return $str;
    }

    /**
     * Para salvar alteracoes de um produto
     */
    public function estSalvar() {
        if ($this->get_foto() == "imagem") {
            $this->set_foto("");
        }

        $consulta = $this->est_Cons01();
        $this->msgEst = $this->executaSQL($consulta);
    }

    /**
     * Para retistar um retirada avulso
     */
    public function retSalvar() {
        $consulta = $this->ret_Cons01();

        $this->msgRet = $this->executaSQL($consulta);
    }

    /**
     * Para gravar o acompanhemento do pedido
     * ou auteracoes do mesmo
     * @param type $complemento
     */
    public function pedidoAcop($complemento) {
        $consulta = $this->pedido_Cons02($complemento);

        $this->msgAcop = $this->executaSQL($consulta);
    }

    /**
     * Para incrementar ou inserir item no pedido
     */
    public function pedidoSalvarItem() {
        //Consultar se o item ja esta pedido
        $consulta = $this->pedido_Cons03();
        $dados = $this->consultaSQL($consulta);
        if ($dados['nmitem'] > 0) {// incrementa a quantidade
            $qtd = $this->get_qtd() + $dados['qt'];
            $consulta = $this->pedido_Cons04($dados['coditem'], $qtd);
            $msgItem = executaSQL($consulta);
        } else {// insere item no pedido
            $consulta = $this->pedido_Cons05();
            $msgItem = executaIdSQL($consulta);
        }
    }

    /**
     * Excluir um item de um pedido
     */
    public function pedidoExclItem() {
        $consulta = $this->pedido_Cons06();
        $msgItem = $this->executaSQL($consulta);
        if ($msgItem == "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>") {
            $msgItem = "<b style=\"color: red\">Codigo Getar " . $this->get_codEst() . " excluido pedido " . $this->get_codPed() . "</b> ";
        }
    }

    /**
     * Consulta para detalhar os itens de um pedido
     * @param type $codPed
     * @return string
     */
    public function pedidoDetalhar($codPed) {
        if ($codPed <> "") {
            $complemento = "  AND cb.cod = " . $codPed;
        } elseif ($codPed == "") {
            $complemento = " AND cb.situ IN('processamento', 'transito') ";
        }
        $consulta = $this->pedido_Cons07($complemento);

        return $consulta;
    }

    /**
     * Consulta para editar e acompanhar um pedido
     * @param type $codPed
     * @return string
     */
    public function pedidoEdit($codPed) {
        $consulta = "SELECT nomeped,
                    (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                    (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                    (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) refped
                        FROM ordem od,
                             equipo eq
                       WHERE od.codeqp = eq.cod
                             AND od.cod = cb.ospro) detalos,
                    (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) refped
                             FROM getar_projetos pj,
                                  getar_pedidos pd
                            WHERE pj.cod = pd.codproj
                                  AND pd.cod = cb.nmproj) detalpro,
                    cb.ospro,
                    date_format(cb.dtped, '%d/%m/%Y') dtped,
                    date_format(cb.dtcheg, '%d') diacheg,
                    date_format(cb.dtcheg, '%m') mescheg,
                    date_format(cb.dtcheg, '%Y') anocheg,
                    date_format(cb.dtrecb, '%d') diarecb,
                    date_format(cb.dtrecb, '%m') mesrecb,
                    date_format(cb.dtrecb, '%Y') anorecb,
                    cb.rastr,
                    cb.vlfrete,
                    cb.empfrete,
                    cb.situ,
                    cb.tipo
               FROM estpedidocab cb
              WHERE cb.cod =" . $codPed;

        return $consulta;
    }

    /**
     * Para listar pedido de compra/venda/consumo
     * @param type $complemento
     * @return string
     */
    public function pedidoList($complemento) {
        $consulta = "SELECT cb.cod codpedido,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                        cb.situ,
                        cb.tipo,
                        cb.nomeped,
                        CASE
                            WHEN cb.tipo =  'compra' THEN 'Compra' # 'compra/reposicao'
                            WHEN cb.tipo = 'venda' THEN 'Venda' # 'venda/orcamento'
                            WHEN cb.tipo = 'consumo' THEN 'Consumo'
                            ELSE 'indefinido'
                        END AS desctipo,
                        (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens
                   FROM estpedidocab cb
                   WHERE " . $complemento . "
                ORDER BY cb.tipo DESC, cb.situ DESC";
        return $consulta;
    }

    /**
     * Select com os box disponivel para uma categoria
     * @param type $box
     * @param type $codCatg
     * @return string
     */
    public function selectBox($box, $codCatg = 1) {

        // para ver se a categoria tem local
        $consulta = "SELECT cod
                   FROM estlocal
                  WHERE situacao = 'ativo'
                        AND categ=" . $codCatg;
        $resultado = retornoSQL($consulta);
        $rows = rowsSQL($resultado);
        $complemento = " ";
        $msg = "";
        if ($rows < 1) {
            $msg = "<b>CATEGORIA SEM NENHUM BOX DEFINIDO</b>";
        } else {
            $complemento = " AND categ = " . $codCatg;
        }

        $consulta = "    SELECT cod,
                            etq,
                            SUBSTRING(descr, 1, 20) descr,
                            descr descrcomp
                       FROM estlocal
                       WHERE numest = " . $this->get_numEstq() . "
                             AND situacao = 'ativo' 
                       " . $complemento . "
                   ORDER BY etq ASC";
        $resultado = retornoSQL($consulta);

        $str = "<select name=\"local\" onchange=\"atualDivLocal(this.value)\">
                <option value=\"1\">Selecione</option>";
        while ($dadosSelect = mysqli_fetch_assoc($resultado)) {
            if ($box == $dadosSelect['cod']) {
                $selected = "selected";
                $this->set_descrLocal($dadosSelect['descrcomp']);
            } else {
                $selected = "";
            }
            $str.= "<option value=\"" . $dadosSelect['cod'] . "\" " . $selected . ">" . $dadosSelect['etq'] . "-" . $dadosSelect['descr'] . "</option>";
        }

        $str.= "    </select>" . $msg;

        return $str;
    }

    /**
     * Listagem de pedidos ativos para o produto em foco
     * @return string
     */
    public function listPedAtv() {
        $consulta = "SELECT it.custo custo,
                            cb.situ situ,
                            cb.nomeped nomeped,
                            cb.cod cod,
                            (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn) forn,
                            cb.cod codped
                        FROM estpedidocab cb,
                             estpedidoitem it
                       WHERE cb.cod = it.codped
                             AND cb.tipo = 'compra'
                             AND it.codest = " . $this->get_codEst() . "
                             AND cb.situ IN('processamento', 'espera', 'transito', 'estudo', 'pago')
                       ORDER BY cb.cod DESC";
        $retorno = retornoSQL($consulta);

        $str = "";
        while ($dados = arraySQL($retorno)) {
            $str .= "<small class=\"txt\">Pedido PED" . $dados['cod'] . "(" . $dados['forn'] . ")| Valor de Custo= " . $dados['custo'];
            $situ = $dados['situ'];
            if ($situ == "estudo") {
                $situ = "Or&ccedil;amento";
            }
            $str .= "| em situa&ccedil;&atilde;o: (" . $situ;
            if ($dados['nomeped'] <> "") {
                $str .= " - " . $dados['nomeped'];
            }
            $str.=")</small>
                    <a href=\"index.php?st=pedido&pag=ped_ldetal&codped=" . $dados['codped'] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                    </a>
                    <a href=\"index.php?st=estoque&pag=excitem&codestq=" . $this->get_codEst() . "&codped=" . $dados['codped'] . "\">
                        <img src=\"imagens/lixo.gif\" alt=\"\" border=\"0\">
                    </a><br />";
        }

        return $str;
    }

    /**
     * Listagem de produtos abaixo do estoque minimo
     * herdado do arquivo funcoes_estoque.php
     * @return string
     */
    public function pedidoCompraxxx($codPed) {
        # global $msgItem;

        if ($codPed == "") {
            $consulta = "       SELECT codpedido,
                                descr,
                                descrtec,
                                codest,
                                fornc,
                                qtd qt,
                                valorcusto custo,
                                situpedido,
                                situitem
                           FROM (# parte 1: abaixo da quanticade minima e tem pedido ativo
                     SELECT CONCAT('Pedido: ',cab.cod) codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            (SELECT nome FROM getar_cad WHERE cod= cab.codforn) fornc,
                            itm.qt qtd,
                            itm.custo valorcusto,
                            cab.situ situpedido,
                            itm.situ situitem
                       FROM estoque est,
                            estpedidocab cab,
                            estpedidoitem itm
                      WHERE cab.cod= itm.codped
                            AND itm.codest = est.cod
                            AND cab.tipo = 'compra'
                            AND est.qtd < est.qtdmin
                            AND est.cod = itm.codest
                            AND est.situacao = 'normal'
                            AND cab.situ IN('processamento', 'transito', 'espera')
                     UNION(# parte 3: abaixo da quanticade minima e sem pedido e sem fornecedor
                     SELECT 'sem fornecedor' codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            'sem fornecedor' fornc,
                            '--' qtd,
                            '--' valorcusto,
                            '--' situpedido,
                            '--' situitem
                       FROM estoque est
                      WHERE est.qtd < est.qtdmin
                            AND est.situacao = 'normal'
                            AND est.cod NOT IN (SELECT frn.codestq FROM fornecedor frn)
                      )
                UNION(
                # parte 2: abaixo da quanticade minima sem pedido e com fornecedor
                     SELECT 'sem pedido' codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            (SELECT group_concat(SUBSTRING(cad2.nome, 1, 20))
                               FROM estoque est2,
                                    fornecedor frn2,
                                    getar_cad cad2
                               WHERE cad2.cod = frn2.codforn
                                     AND est2.cod = frn2.codestq
                                     AND est2.cod = est.cod) fornc,
                            '--' qt,
                            '--' valorcusto,
                            '--' situpedido,
                            '--' situitem
                       FROM estoque est
                      WHERE est.qtd < est.qtdmin
                            AND est.situacao = 'normal'
                            AND est.cod IN (SELECT frn.codestq FROM fornecedor frn)
                            AND est.cod NOT IN(SELECT itm.codest
                                 FROM estpedidocab cab,
                                      estpedidoitem itm
                                WHERE cab.cod = itm.codped
                                              AND cab.tipo = 'compra'
                                      AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
                                      AND itm.codest = est.cod)
                        )
                        ) grp
                      ORDER BY descr ASC";
        } else {
            if ($codPed == "000") {# sem fornecedor
                $consulta = "SELECT 'sem pedido-sem fornecedor' codpedido,
                                est.descr,
                                est.descrtec,
                                est.cod codest,
                                'sem fornecedor' fornc,
                                est.qtd qt,
                                est.valorcusto custo,
                                '--' situpedido,
                                '--' situitem
                           FROM estoque est
                          WHERE est.qtd < est.qtdmin
                                AND est.cod NOT IN (SELECT frn.codestq FROM fornecedor frn)";
            } else {
                $consulta = " SELECT cab.codforn codforn
                            FROM estpedidocab cab
                          WHERE cab.cod =" . $codPed;
                $dados = consultaSQL($consulta);

                $consulta = " SELECT codpedido,
                descr,
                descrtec,
                codest,
                fornc,
                qtd qt,
                valorcusto custo,
                situpedido,
                situitem
           FROM (# parte 1: o que ja tem no pedido
     SELECT cab.cod codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            SUBSTRING(cad.nome, 1, 20) fornc,
            itm.qt qtd,
            itm.custo valorcusto,
            cab.situ situpedido,
            itm.situ situitem
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem itm,
            getar_cad cad
      WHERE cab.cod= itm.codped
            AND itm.codest = est.cod
            AND cab.codforn= cad.cod
                        AND cab.cod = " . $codPed . "
     UNION(# parte 2: o que eh do fornecedor e ainda nao esta no pedido
                 SELECT '--' codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            SUBSTRING(cad.nome, 1, 20) fornc,
                        '--' qt,
                        '--' valorcusto,
                        '--' situpedido,
                        '--' situitem
       FROM estoque est,
            getar_cad cad
                  WHERE est.qtd < est.qtdmin
                        AND est.cod NOT IN(SELECT itm.codest
                                                  FROM estpedidocab cab,
                                                       estpedidoitem itm
                                                 WHERE cab.cod = itm.codped
                                                       AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
                                                       AND cab.tipo= 'compra'
                                                       AND itm.codest = est.cod)
                        AND cad.cod = " . $dados['codforn'] . "
                        AND est.cod IN(SELECT frn.codestq FROM fornecedor frn WHERE frn.codforn= " . $dados['codforn'] . "))
     ) qrp
     ORDER BY descr ASC";
            }
        }
        $resultado = retornoSQL($consulta);

        return $resultado;
    }

    /**
     * Listagem de produtos abaixo do estoque minimo
     * herdado do arquivo funcoes_estoque.php
     * ver pedidoCompraxxx para a versao anterior com outras SQL
     * @return type
     */
    public function pedidoCompra() {
        $consulta = "       SELECT codpedido,
                                descr,
                                descrtec,
                                codest,
                                fornc,
                                qtd qt,
                                valorcusto custo,
                                situpedido,
                                situitem
                           FROM (# parte 1: abaixo da quanticade minima e tem pedido ativo
                     SELECT CONCAT('Pedido: ',cab.cod) codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            (SELECT nome FROM getar_cad WHERE cod= cab.codforn) fornc,
                            itm.qt qtd,
                            itm.custo valorcusto,
                            cab.situ situpedido,
                            itm.situ situitem
                       FROM estoque est,
                            estpedidocab cab,
                            estpedidoitem itm
                      WHERE cab.cod= itm.codped
                            AND itm.codest = est.cod
                            AND cab.tipo = 'compra'
                            AND est.qtd < est.qtdmin
                            AND est.cod = itm.codest
                            AND est.situacao = 'normal'
                            AND cab.situ IN('processamento', 'transito', 'espera')
                     UNION(# parte 3: abaixo da quanticade minima e sem pedido e sem fornecedor
                     SELECT 'sem fornecedor' codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            'sem fornecedor' fornc,
                            '--' qtd,
                            '--' valorcusto,
                            '--' situpedido,
                            '--' situitem
                       FROM estoque est
                      WHERE est.qtd < est.qtdmin
                            AND est.situacao = 'normal'
                            AND est.cod NOT IN (SELECT frn.codestq FROM fornecedor frn)
                      )
                UNION(
                # parte 2: abaixo da quanticade minima sem pedido e com fornecedor
                     SELECT 'sem pedido' codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            (SELECT group_concat(SUBSTRING(cad2.nome, 1, 20))
                               FROM estoque est2,
                                    fornecedor frn2,
                                    getar_cad cad2
                               WHERE cad2.cod = frn2.codforn
                                     AND est2.cod = frn2.codestq
                                     AND est2.cod = est.cod) fornc,
                            '--' qt,
                            '--' valorcusto,
                            '--' situpedido,
                            '--' situitem
                       FROM estoque est
                      WHERE est.qtd < est.qtdmin
                            AND est.situacao = 'normal'
                            AND est.cod IN (SELECT frn.codestq FROM fornecedor frn)
                            AND est.cod NOT IN(SELECT itm.codest
                                 FROM estpedidocab cab,
                                      estpedidoitem itm
                                WHERE cab.cod = itm.codped
                                              AND cab.tipo = 'compra'
                                      AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
                                      AND itm.codest = est.cod)
                        )
                        ) grp
                      ORDER BY descr ASC";
        $resultado = retornoSQL($consulta);

        return $resultado;
    }

    /**
     * Consulta capacitore eletroliticos abaixo do estoque minimo
     * @return type
     */
    public function pedidoCompraCapEletro() {
        $consulta = "     SELECT codpedido,
                                descr,
                                descrtec,
                                codest,
                                fornc,
                                qtd qt,
                                valorcusto custo,
                                situpedido,
                                situitem
                           FROM (# parte 1: os com pedido em andamento 
                           SELECT CONCAT('Pedido: ',cab.cod) codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            (SELECT SUBSTRING(nome, 1, 20) FROM getar_cad WHERE cod= cab.codforn) fornc,
                            itm.qt qtd,
                            itm.custo valorcusto,
                            cab.situ situpedido,
                            itm.situ situitem
                       FROM estoque est,
                            estpedidocab cab,
                            estpedidoitem itm
                      WHERE cab.cod= itm.codped
                            AND itm.codest = est.cod
                            AND cab.tipo = 'compra'
                            AND est.cod = itm.codest
                            AND cab.situ IN('processamento', 'transito', 'espera')
                            AND est.situacao = 'normal'
                            AND est.qtd < est.qtdmin
                            AND est.catg = 9 AND est.subcatg = 22
                            UNION(SELECT '--' codpedido,
                                        est.descr,
                                        est.descrtec,
                                        est.cod codest,
                                        '--' fornc,
                                        '--' qt,
                                        '--' custo,
                                        '--' situpedido,
                                        '--' situitem
                                   FROM estoque est
                                  WHERE est.qtd < est.qtdmin
                                        AND est.situacao = 'normal'
                                        AND est.catg = 9 AND est.subcatg = 22)) qrp
                            ORDER BY descr ASC";
        $resultado = retornoSQL($consulta);

        return $resultado;
    }

    /**
     * Para criar futura funcao ou metodo
     * Listagem de pedidos Compra Reposicao em ABERTO
     * Autor: Paulo Regis
     * Data:
     * 31/05/2024 - Criacao da funcao
     * 1/10/2025 - migrado da função para metodo
     * @param type $cod
     * @return string
     */
    public function listPedAbt($cod) {
        $consulta = "SELECT forn.codforn,
                            cad.nome,
                            ped.nomeped,
                            ped.cod codped,
                            ped.situ
                       FROM fornecedor forn,
                            getar_cad cad,
                            estoque est,
                            estpedidocab ped
                       WHERE forn.codestq = est.cod
                             AND forn.codforn = cad.cod
                             AND forn.codforn = ped.codforn
                             AND ped.situ IN('processamento', 'estudo', 'transito', 'estudo', 'orcamento')
                             AND est.qtd < est.qtdmin
                             AND est.cod NOT IN(SELECT itm.codest
                                                  FROM estpedidocab cab,
                                                       estpedidoitem itm
                                                 WHERE cab.cod = itm.codped
                                                       AND cab.situ IN('processamento', 'espera')
                                                       AND cab.tipo= 'compra'
                                                       AND itm.codest = est.cod)
                            AND est.cod =" . $cod;
        $resultado = retornoSQL($consulta);

        $str = "";
        while ($dados = arraySQL($resultado)) {
            $nomePed = "";
            if ($dados['nomeped'] <> "") {
                $nomePed = $dados['nomeped'] . " - ";
            }
            if ($dados['situ'] == "estudo") {
                $situPed = "Orcamento";
            } else {
                $situPed = $dados['situ'];
            }

            $str.=" <fieldset>
                <legend>INSERIR EM PEDIDO DE COMPRA/REPOSI&Ccedil;&Atilde;O N&Uacute;MERO: " . $dados['codped'] . " (" . $nomePed . $situPed . ")" . "</legend>
                <b>Fornecedor: </b>" . $dados['nome'] . "  
                <a href=\"index.php?st=estoque&pag=edit&codestq=" . $cod . "&inped=" . $dados['codped'] . "\">
                    <img src=\"imagens/visto.gif\" alt=\"\" border=\"no\">
                </a>
            </fieldset>";
        }
        return $str;
    }
    
    /**
     * Insere a imagem ilustrativa no banco
     * @param type $imagIlu
     */
    public function gravaImg($imagIlu) {
        $consulta = "INSERT INTO estoqueimg (codestq, imagem) VALUES(" . $this->get_codEst() . ", '" . $imagIlu . "')";
        $msgImg = $this->executaSQL($consulta);
        #$this->set_msgImg($msgImg);
    }

}

?>
