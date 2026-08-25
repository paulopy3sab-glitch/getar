<?php

/**
 * Descricao
 * Metodos de apoio a plano de atribuicoes
 *
 * @author Paulo
 * Data de criacao: Outubor/2016
 * Revisao: pregis 
 */
class Atrib extends Conex {

    private $codAtrib;
    private $nick;
    private $tipoAtrib;
    //
    private $codTop;
    private $descrTop;
    private $arquiTop;
    //
    private $codPerfil;
    private $nomePerfil;
    private $arrayPerfil;
    private $situPerfil;

    public function __construct() {
        parent::__construct();
    }

    public function get_codAtrib() {
        return $this->codAtrib;
    }

    public function set_codAtrib($codAtrib) {
        $this->codAtrib = $codAtrib;
    }

    public function get_nick() {
        return $this->nick;
    }

    public function set_nick($nick) {
        $this->nick = $nick;
    }

    public function get_tipoAtrib() {
        return $this->tipoAtrib;
    }

    public function set_tipoAtrib($tipoAtrib) {
        $this->tipoAtrib = $tipoAtrib;
    }

    public function get_codTop() {
        return $this->codTop;
    }

    public function set_codTop($codTop) {
        $this->codTop = $codTop;
    }

    public function get_descrTop() {
        return $this->descrTop;
    }

    public function set_descrTop($descrTop) {
        $this->descrTop = $descrTop;
    }

    public function get_arquiTop() {
        return $this->arquiTop;
    }

    public function set_arquiTop($arquiTop) {
        $this->arquiTop = $arquiTop;
    }

    public function get_codPerfil() {
        return $this->codPerfil;
    }

    public function set_codPerfil($codPerfil) {
        $this->codPerfil = $codPerfil;
    }

    public function get_nomePerfil() {
        return $this->nomePerfil;
    }

    public function set_nomePerfil($nomePerfil) {
        $this->nomePerfil = $nomePerfil;
    }

    public function get_arrayPerfil() {
        return $this->arrayPerfil;
    }

    public function set_arrayPerfil($arrayPerfil) {
        $this->arrayPerfil = $arrayPerfil;
    }

    public function get_situPerfil() {
        return $this->situPerfil;
    }

    public function set_situPerfil($situPerfil) {
        $this->situPerfil = $situPerfil;
    }

    /**
     * Listagem 
     * @return string
     */
    public function atribList() {
        $consulta = "    SELECT cod,
                        descr,
                        ' ' nick,
                        ' ' tipo
                   FROM getar_topico
           UNION(SELECT codatrib cod,
                        tp.descr,
                        nick,
                        tipo
                   FROM getar_atrib atr,
                        getar_topico tp
                        WHERE atr.codatrib = tp.cod)
               ORDER BY cod";
        $resultado = $this->retornoSQL($consulta);

        $str = "<table>
                <caption>PLANO DE ATRIBUI&Ccedil;&Otilde;ES</caption>
                <thead>
                    <tr>
                        <th>C&oacute;digo Atribui&ccedil;&atilde;o</th>
                        <th>Descri&ccedil;&atilde;o</th>
                        <th>Nick</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>";
        $codAnt = "";
        while ($dados = arraySQL($resultado)) {
            $str.="<tr class=\"" . $this->corLinha() . "\">";
            $codAtrib = "";
            $descr = "";
            if ($codAnt <> $dados['cod']) {
                $codAtrib = $dados['cod'];
                $descr = $dados['descr'];
                $codAnt = $dados['cod'];
            }
            $str.="<th>" . $codAtrib . "</th>
                <td class=\"txt\">" . $descr . "</td>
                <td class=\"txt\">" . $dados['nick'] . "</td>
                <td class=\"txt\">" . $dados['tipo'] . "</td>
            </tr>";
        }
        $str.="</tbody></table>";

        return $str;
    }

    /**
     * Switch para os atributos
     * @param type $pag
     * @return string
     */
    public function atribSwitch($pag) {
        switch ($pag) {
            case 'edit':
                $complemento = " AND cod = " . $this->get_codPerfil() . " ";
                break;
            case 'list':
                $complemento = " AND situ= 'ativo' ";
                break;
            default :
                $complemento = " AND situ= 'ativo' ";
                break;
        }

        return $complemento;
    }

    /**
     * Listgem dos perfis de atribuicao existentes
     * Para Edicao e criar novos
     * @return string
     */
    public function atribListPerfil($complemento) {
        $consulta = " SELECT cod,
                            nome,
                            arratrib,
                            situ
                      FROM getar_perfil
                     WHERE 1 = 1 " . $complemento;
        $resultado = $this->retornoSQL($consulta);

        $str = "<table style=\"width: 640px;\">
                <caption>Perfil de Atributos de Usu&aacute;rios - Listagem Geral.</caption>
                <thead>
                    <tr>
                        <th>Reg.</th>
                        <th>Nome Perfil</th>
                        <th>Array de Atribui&ccedil;&otilde;es</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situ"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str.= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                        <th>" . $dados['cod'] . "</th>
                        <td>" . $dados['nome'] . "
                            <a href=\"index.php?st=cadastro&pag=edit&codcad=" . $dados["cod"] . "\">
                                <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este registro\">
                            </a>
                        </td><td>&nbsp;";
            $arrAtrib = explode(",", $dados['arratrib']);

            foreach ($arrAtrib as $value) {
                $str.= $this->atribDescr($value) . "<br />";
            }
            $str.= "</td>
                    </tr>";
        }
        $str.=" </tbody></table>";

        return $str;
    }

    /**
     * Opcoes para plano de atribuicoes
     * @return string
     */
    public function atribOpcoes() {
        $str = "<div id=\"opcoes\">
                    <div id=\"elemento\">
                        <a href=\"index.php?st=cadastro&pag=cad\" accesskey=\"n\">
                            <img src=\"imagens/novo.jpg\" alt=\"Novo\" titlie=\"Cadastro Novo\" ><br>
                            Cadastro Novo
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=perfilatrib&pag=list\">
                            <img src=\"imagens/grupo.gif\" alt=\"Todos\" title=\"Listar perfis de atributos\"><br>
                            Perfis de Atributos
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=plano_atrib&pag=list\">
                            <img src=\"imagens/grupo.gif\" alt=\"Todos\" title=\"Listar atributos e seus Personagens\"><br>
                            Listar Atributos
                        </a>
                    </div>
                    <div id=\"elemento\">
                        <a href=\"index.php?st=cadastro&pag=listall\">
                            <img src=\"imagens/grupo.gif\" alt=\"Todos\" title=\"Listo todos cadastros (inativos tambem)\"><br>
                            Listar Cadastrados
                        </a>
                    </div>
                    <div id=\"elemento\">    
                        <a href=\"index.php?st=cadastro&pag=listlog\">
                            <img src=\"imagens/grupo.gif\" alt=\"Logaveis\" title=\"Listar administradores, vendedores, tecnicos com logon no sistema\"><br>
                            Listar Logaveis
                        </a>
                    </div>
                </div>";

        return $str;
    }

    /**
     * Aplica um perfil apartir do array de atribuicoes
     * @param type $nick
     * @param type $perfil
     */
    public function atribAplicPerfil($codperfil, $nick) {
        //carregar atribucoes do perfil
        $consulta = " SELECT arratrib
                        FROM getar_perfil
                       WHERE cod=" . $codperfil;
        $dados = $this->consultaSQL($consulta);
        $arrAtrib = explode(",", $dados['arratrib']);

        foreach ($arrAtrib as $value) {
            $consulta = "INSERT INTO `getar_atrib` (`codatrib`, `nick`, `tipo`)
                                             VALUES(" . $value . ", '" . $nick . "', 'padrao')";
            $this->executaSQL($consulta);
        }
    }

    /**
     * Formulario com a listagem de nick logaveis sem perfil
     * @return string
     */
    public function atribSemPerfil() {
        $str = "<div class=\"titulo\">LOGAVEIS SEM PERFIL ATRIBUIDOS</div>
              <form name=\"formCadastro\" action=\"index.php?st=perfilatrib&pag=list\" method=\"post\">
                <input name=\"cod\" type=\"hidden\" value=\"\">
                <table id=\"listcad\">
                <caption>Listgem</caption>
                    <thead>
                    <tr>
                        <th>Logons sem perfil: </th>
                        <th>Perfil Ativo </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>
                        <select name=\"nick\">";
        $consulta = "SELECT ct.nick,
                            cad.nome
                       FROM getar_control ct,
                            getar_cad cad
                      WHERE ct.codcad = cad.cod
                            AND cad.situacao= 'ativo'
                            AND cad.cod NOT IN(1, 2, 3)
                            AND ct.nick NOT IN(SELECT DISTINCT nick
                                                 FROM getar_atrib) ";
        $resultado = $this->retornoSQL($consulta);
        $row = $this->rowsSQL($resultado);
        if ($row < 1) {
            $str = "Todos os logaveis tem atribui&ccedil;&otilde;es";
            return $str;
        }
        while ($dados = $this->arraySQL($resultado)) {
            $str.="<option value=\"" . $dados['nick'] . "\" >" . $dados['nome'] . " - " . $dados['nick'] . "</option>";
        }
        $str.="         </select>
                    </td>
                    <td>
                        <select name=\"codperfil\">";
        $consulta = " SELECT cod,
                             nome,
                             arratrib,
                             situ
                       FROM getar_perfil
                      WHERE situ= 'ativo' ";
        $resultado = $this->retornoSQL($consulta);
        while ($dados = $this->arraySQL($resultado)) {
            $str.="<option value=\"" . $dados['cod'] . "\" >" . $dados['nome'] . "</option>";
        }
        $str.="                </select>
                    </td>
                    </tr>
                    <tr>
                    <td colspan=\"2\">
                    <label>&nbsp;</label><input type='submit' name='aplicPerfil' value='Aplicar'>
                    </td>
                    </tr>
                    </tbody>
                    </table>
            </fieldset>
            </form>";

        return $str;
    }

    /**
     * Listagem de nick logaveis e suas atribuicoes
     * @return string
     */
    public function atribListLoga() {
        $consulta = " SELECT ct.nick,
                             cad.nome,
                             cad.situacao
                        FROM getar_control ct,
                             getar_cad cad
                       WHERE ct.codcad = cad.cod
                             AND cad.cod NOT IN(1)
                             AND ct.nick IN(SELECT DISTINCT nick
                                                  FROM getar_atrib)";
        $resultado = $this->retornoSQL($consulta);

        $str = "<table style=\"width: 640px;\">
                <caption>Logaveis com atributos.</caption>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Nick</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            $str.= "<tr class=\"" . $this->corLinha() . "\" " . $style . ">
                        <td>" . $dados['nome'] . "</td>
                        <td>" . $dados['nick'] . "
                            <a href=\"index.php?st=perfilatrib&pag=excall&nick=" . $dados["nick"] . "\">
                                <img src=\"imagens/desativar.gif\" alt=\"Revogar\" title=\"Revogar todas as atribuicoes\">
                            </a>
                        </td>
                    </tr>";
        }
        $str.=" </tbody></table>";

        return $str;
    }

    /**
     * Deleta todas as atribucoes de um logovel
     * @param type $nick
     * @return string
     */
    public function atribExcTudo($nick) {
        $consulta = "DELETE FROM getar_atrib WHERE nick='" . $nick . "'";

        $this->executaSQL($consulta);
        if ($this->get_suces()) {
            $str = "<b style=\"blue\">TODOAS AS ATRIBUICOES DE " . $nick . " FORAM EXCLUIDAS";
        } else {
            $str = "<b style=\"color: red;\">OCORREU UM ERRO</b>";
        }

        return $str;
    }

    /**
     * Retorna a descricao do topico a ser atribuido
     * @param type $codTop
     * @return string
     */
    public function atribDescr($codTop) {
        $consulta = "SELECT descr FROM getar_topico WHERE cod=" . $codTop;
        $dados = $this->consultaSQL($consulta);
        $str = $codTop . " - " . $dados['descr'];

        return $str;
    }

}

?>
