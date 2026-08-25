<?php

/**
 * Description of classe_artigos
 *
 * @author pregis
 */
class Artigos extends Conex {

    private $codArtg;
    private $nomeArtg;
    private $linhaArtg;
    private $nomeLinha;
    private $chamada;
    private $modelo;
    private $texto;
    private $fonte;
    private $datacri;
    private $situacao;
    //
    private $titulo;
    private $intro;
    private $rodape;
    private $amplia;
    //
    private $msg;
    private $msgTxt;
    private $msgImg;
    private $pesq;
    //Parametros para link
    public $st;
    public $ft;
    public $pag;
    public $tipoCod;

    function __construct() {
        parent::__construct();
    }

    public function set_codArtg($novo_Codartg) {
        $this->codArtg = $novo_Codartg;
    }

    public function get_codArtg() {
        return $this->codArtg;
    }

    function get_nomeArtg() {
        return $this->nomeArtg;
    }

    function set_nomeArtg($nomeArtg) {
        $this->nomeArtg = $nomeArtg;
    }

    public function set_nomeLinha($nome) {
        $this->nomeLinha = $nome;
    }

    public function get_nomeLinha() {
        return $this->nomeLinha;
    }

    public function set_chamada($novo_chamada) {
        $this->chamada = $novo_chamada;
    }

    public function get_chamada() {
        return $this->chamada;
    }

    public function set_linhaArtg($novo_linhaArtg) {
        $this->linhaArtg = $novo_linhaArtg;
    }

    public function get_linhaArtg() {
        return $this->linhaArtg;
    }

    public function set_modelo($novo_modelo) {
        $this->modelo = $novo_modelo;
    }

    public function get_modelo() {
        return $this->modelo;
    }

    public function set_titulo($novo_titulo) {
        $this->titulo = $novo_titulo;
    }

    public function get_titulo() {
        return $this->titulo;
    }

    public function set_intro($novo_intro) {
        $this->intro = $novo_intro;
    }

    public function get_intro() {
        return $this->intro;
    }

    public function set_texto($novo_texto) {
        $this->texto = $novo_texto;
    }

    public function get_texto() {
        return $this->texto;
    }

    public function set_datacri($datacri) {
        $this->datacri = $datacri;
    }

    public function get_datacri() {
        return $this->datacri;
    }

    public function set_sitacao($situacao) {
        $this->situacao = $situacao;
    }

    public function get_situacao() {
        return $this->situacao;
    }

    public function set_rodape($novo_rodape) {
        $this->rodape = $novo_rodape;
    }

    public function get_rodape() {
        return $this->rodape;
    }

    public function set_amplia($novo_amplia) {
        $this->amplia = $novo_amplia;
    }

    public function get_amplia() {
        return $this->amplia;
    }

    public function set_msg($novo_msg) {
        $this->msg = $novo_msg;
    }

    public function get_msg() {
        return $this->msg;
    }

    public function set_msgTxt($novo_msgTxt) {
        $this->msgTxt = $novo_msgTxt;
    }

    public function get_msgTxt() {
        return $this->msgTxt;
    }

    public function get_msgImg() {
        return $this->msgImg;
    }

    public function set_msgImg($msgImg) {
        $this->msgImg = $msgImg;
    }

    function get_st() {
        return $this->st;
    }

    function get_ft() {
        return $this->ft;
    }

    function get_pag() {
        return $this->pag;
    }

    function get_tipoCod() {
        return $this->tipoCod;
    }

    /**
     * Para o parametro st dos link
     * Eh o modulo: lembretes, estoque
     * @param type $st
     */
    function set_st($st) {
        $this->st = $st;
    }

    function set_ft($ft) {
        $this->ft = $ft;
    }

    /**
     * Pagina interna 
     * Ex.: edit, nova, cad
     * @param type $pag
     */
    function set_pag($pag) {
        $this->pag = $pag;
    }

    function set_tipoCod($tipoCod) {
        $this->tipoCod = $tipoCod;
    }

    /**
     * Retorna o modelo do artigo (ft - rv - fck
     * @param type $codArtg
     * @return type modelo
     */
    public function busca_modelo() {
        $consulta = "SELECT modelo FROM getar_artgch WHERE cod=" . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);
        $this->set_modelo($dados['modelo']);

        return $dados['modelo'];
    }

    public function set_fonte($novo_fonte) {
        return $this->fonte = $novo_fonte;
    }

    public function get_fonte() {
        return $this->fonte;
    }

    /**
     * Salvar alteracoes artigos
     */
    public function artgSalvar() {
        $consulta = "UPDATE getar_artgch
                            SET nome='" . $this->get_nomeArtg() . "',
                                chamada='" . $this->get_chamada() . "',
                                modelo= '" . $this->get_modelo() . "',
                                linha= '" . $this->get_linhaArtg() . "',
                                situacao= '" . $this->get_situacao() . "'
                          WHERE cod=" . $this->get_codArtg();
        $msg = $this->executaSQL($consulta);
        $this->set_msg($msg);


        $texto = $this->html_texto($this->get_texto(), 1);
        $consulta = "UPDATE getar_artg01
                            SET titulo ='" . $this->get_titulo() . "',
                                intro ='" . $this->get_intro() . "',
                                texto = '" . $texto . "',
                                fonte = '" . $this->get_fonte() . "'
                          WHERE codartg = '" . $this->get_codArtg() . "'";

        $msgTxt = $this->executaSQL($consulta);
        $this->set_msgTxt($msgTxt);
    }

    /**
     * inserir um artigo novo conforme parametro
     * @param type $pag modelo de artigo
     * @return type
     */
    public function artgNovo($pag, $linhaArtg) {
        $msg = "";
        $this->set_linhaArtg($linhaArtg);
        switch ($pag) {
            case "novo_rv":
                $modelo = "rv";
                break;
            case "novo_fck":
                $modelo = "fck";
                break;
            case "novo_ft":
                $modelo = "ft";
                break;
        }
        $nmData = date('ymdh');
        $nomeArtg = "artg" . $nmData;
        $consulta = "INSERT INTO getar_artgch (dest, nome, linha, modelo, chamada, datacri, imagem, situacao)
                                     VALUES(1, '" . $nomeArtg . "', '" . $this->get_linhaArtg() . "', '" . $modelo . "', '', CURDATE(), 'radio.gif', 'temporario')";
        $msg .= $this->executaIdSQL($consulta);
        $codArtg = $this->get_idRet();
        $this->set_codArtg($codArtg);

        switch ($pag) {//inserindo na tabela correta conforme modelo artigo
            case "novo_rv":
                $consulta = "INSERT INTO getar_artg01 (codartg, titulo, intro, texto, fonte, imagem) 
                                                   VALUES (" . $codArtg . ", '', '', '', '', 'radio.gif')";
                break;
            case "novo_fck":
                $consulta = "INSERT INTO getar_artg01 (codartg, titulo, intro, texto, fonte, imagem) 
                                                   VALUES (" . $codArtg . ", '', '', '', '', 'radio.gif')";
                break;
            case "novo_ft":
                $consulta = "INSERT INTO getar_artgft (codartg, titulo, intro, rodape, amplia) 
                                                   VALUES (" . $codArtg . ", '', '', '', 1)";
                break;
        }
        $msg .= $this->executaIdSQL($consulta);

        return $msg;
    }

    /**
     * Edita artigo
     * Vai se tornar obseleta por nao vais mais se trabalhar com artigos modelo REVISTA muito menos FOTOS ou GALERIA
     * @param type $codArtg
     * @return string
     */
    public function artgEdit() {
        $consulta = "SELECT dest,
                            nome,
                            linha,
                            modelo,
                            chamada,
                            datacri,
                            imagem,
                            situacao
                       FROM getar_artgch
                      WHERE cod= " . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        $str = "<form id=\"artigo\" action=\"index.php?st=artigos&pag=edit&codartg=" . $this->get_codArtg() . "\" method=\"post\" enctype=\"multipart/form-data\">
                <fieldset id=\"formArtg\">
                    <legend>Editando um Artigo</legend>
                    <fieldset>
                        <legend>Cabe&ccedil;alho Artigo</legend>
                        <label>Nome do artigo:</label>
                        <input type=\"text\" name=\"nome\" value=\"" . $dados['nome'] . "\" size=\"22\" maxlength=\"20\"><br>
                        <i>(Sem espa&ccedil;os e caracteres especiais)</i><br>
                        <label>Linha do Artigo: </label>" . $this->selectLinha($dados['linha']) . "<br>
                        <label>Modelo (rv - fck - ft)</label>
                        <input type=\"text\" name=\"modelo\" value=\"" . $dados['modelo'] . "\"><br>
                        <label>Chamada:<br><b style=\"color: red;\">***N&AtildeO USAR MAIS***<br>Passar o que tiver para a Intro</b></label>
                        <textarea name=\"chamada\" cols=\"50\" rows=\"3\">" . $dados['chamada'] . "</textarea><br>
                        <fieldset>
                            <legend>Imagem Destaque</legend>
                            <img src=\"" . $this->get_localFotos() . $dados['imagem'] . "\" alt=\"\" style=\"width: 100px\"><br>
                            <!-- para limitar o tamanho do upload
                            <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2000000\"> -->
                            <input type=\"file\" name=\"arquivoCh\">
                            <input type=\"submit\" name=\"gravaftch\" value=\"Gravar Foto\" onclick=\"exibeDiv('carregandoCh');\">
                            <div id=\"carregandoCh\" align=\"center\" style=\" width:200px; height:150px; vertical-align:middle; display:none\">    
                                <img src=\"imagens/enviando.gif\" alt=\"\" /><br />    
                                Enviando sua Foto Aguarde!
                            </div>
                        </fieldset>
                   </fieldset><legend>Corpo do Artigo</legend>";
        if ($this->get_modelo() == "ft") {
            $str .= $this->editFt();
        } else {
            $str .= $this->editTxt($this->get_codArtg(), $this->get_modelo());
        }

        if (isset($this->msg)) {
            $str .= "<b style=\"color: red\">Cabe&ccedil;alho - </b>" . $this->msg . "<br>
                    <b style=\"color: red\">Parte Texto - </b>" . $this->msgTxt;
        }
        $str .= "   <label>Fonte: </label>
                    <input name=\"fonte\" type=\"text\" value=\"" . $this->get_fonte() . "\" size=\"102\" maxlength=\"100\"><br>
                    <label>&nbsp;</label><input type=\"submit\" name=\"salvarartg\" value=\"Salvar\">
                    </fieldset>
                </form>";
        return $str;
    }

    /**
     * select option com as linhas de artigo
     * @return string
     */
    public function selectLinha($ln) {
        $consulta = "SELECT cod, 
                            nome
                       FROM getar_linha
                      WHERE situacao = 'ativo'";
        $resultado = $this->retornoSQL($consulta);

        $str = "<select name=\"lnartg\">";
        while ($dados = $this->arraySQL($resultado)) {
            $str .= "<option value='" . $dados['cod'] . "' " . $this->selectedIf($dados['cod'], $ln) . "> " . $dados['nome'] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }
    
    /**
     * Nova versao para listgem com includes/lista_artigos.inc.php
     * Ver cabecalho deste para maiores detalhes
     * @param type $pag
     * @param type $pagList
     * @param type $complemento
     * @return type
     */
    public function artgList($pag, $pagList, $complemento) {
        $consulta = " SELECT ch.cod,
                             ch.nome,
                             ch.imagem,
                             ch.datacri,
                             ch.situacao,
                             rv.titulo,
                             rv.intro,
                             ln.nome nomeln
                        FROM getar_artgch ch,
                             getar_artg01 rv,
                             getar_linha ln
                       WHERE ch.cod = rv.codartg
                             AND ln.cod = ch.linha
                              " . $complemento . "
                             LIMIT 20";
        $resultado = $this->retornoSQL($consulta, $pagList);

        return $resultado;
    }

    /**
     * Listagem com as string de pesquisa
     * @return string
     */
    public function artgPesq() {
        $consulta = "(SELECT ch.cod,
                             ch.nome,
                             rv.titulo,
                             ch.dest,
                             ch.situacao,
                             ch.linha
                        FROM getar_artgch ch,
                             getar_artg01 rv
                        WHERE ch.cod = rv.codartg
                              " . $complemento . ")
                      UNION(SELECT ch.cod,
                                   ch.nome,
                                   ft.titulo,
                                   ch.dest,
                                   ch.situacao,
                                   ch.linha
                              FROM getar_artgch ch,
                                   getar_artgft ft
                             WHERE ch.cod = ft.codartg
                                   " . $complemento . ")
                          ORDER BY cod DESC";
        //$resultado = $this->geraPaginacao($consulta, $pagList);
        $resultado = $this->retornoSQL($consulta);
        $row = $this->rowsSQL($resultado);
        if ($row < 1) {
            $str = "<div  class=\"titulo\">Nenhum Artigo a Listar</div>";
            return $str;
        }
        $str = "<table>
                    <caption>Listagem Artigos " . $tipo . ".</caption>
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Nome</th>
                            <th>T&iacute;tulo</th>
                        </tr>
                    </thead>
                    <tbody>";

        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados['situacao'] == "inativo") {
                $style = ' style="text-decoration:line-through;"';
            }

            $str .= "<tr class='txt' " . $style . " onmouseover=\"this.className='txtAtivo'\" onmouseout=\"this.className='txt'\">
                    <td>" . $dados['cod'] . "(" . $dados['linha'] . ")
                        <a href=\"artigos.php?pag=edit&codartg=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                        </a>";

            // Nao imprimir o icone de desativacao se ja o esta
            if ($dados['situacao'] == "ativo") {
                $str .= '<img src="imagens/desativar.gif" width="16" height="16" alt="" onClick="return janela(\'artigos-excl.php?pag=confirma_excl&codartg=' . $dados['cod'] . '\')">';

                $imagem = "seta-vr.gif";
                $acao = "0";
                if ($dados['dest'] == "1") {
                    $imagem = "visto.gif";
                    $acao = "1";
                }
                $str .= '<a href="artigos.php?pag=dest&codartg=' . $dados['cod'] . '">
                                                      <img src="imagens/' . $imagem . '" alt="" border="0">
                                                  </a>';
            }

            $str .= " </td>
                    <td>" . $dados['nome'] . "</td>
                    <td>" . substr($dados['titulo'], 0, 52) . "</td>
                </tr>";
        }

        $str .= " <tr>
                    <td colspan=\"3\">";
        $str .= $this->geraIndicesPaginas($pagList, "artigos.php?pag=lista_geral&");
        $str .= "     </td>
                </tr>
            </tbody>
        </table>";

        return $str;
    }

    /**
     * Listagem geral de artigos para os visitantes do site
     * @param type $tipo
     * @param type $pagList
     * @param type $complemento
     * @return string
     */
    public function artgListSt($tipo, $pagList, $complemento) {
        $consulta = "(SELECT ch.cod,
                             ch.nome,
                             ch.chamada,
                             rv.titulo,
                             ch.dest,
                             ch.situacao,
                             ch.linha
                        FROM getar_artgch ch,
                             getar_artg01 rv
                        WHERE ch.cod = rv.codartg
                              " . $complemento . ")
                      UNION(SELECT ch.cod,
                                   ch.nome,
                                   ch.chamada,
                                   ft.titulo,
                                   ch.dest,
                                   ch.situacao,
                                   ch.linha
                              FROM getar_artgch ch,
                                   getar_artg01 ft
                             WHERE ch.cod = ft.codartg
                                   " . $complemento . ")
                          ORDER BY cod DESC";
        $resultado = $this->geraPaginacao($consulta, $pagList);
        $row = $this->rowsSQL($resultado);
        if ($row < 1) {
            $str = "<div  class=\"titulo\">Nenhum Artigo a Listar</div>";
            return $str;
        }
        $str = "<table>
                    <caption>Listagem Artigos " . $tipo . ".</caption>
                    <thead>
                        <tr>
                            <th>T&iacute;tulo</th>
                            <th>Chamada</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody>";

        while ($dados = $this->arraySQL($resultado)) {
            $style = "";
            if ($dados['situacao'] == "inativo") {
                $style = ' style="text-decoration:line-through;"';
            }

            $str .= "<tr class='txt' " . $style . " onmouseover=\"this.className='txtAtivo'\" onmouseout=\"this.className='txt'\">
                    <td>" . $dados['titulo'] . "
                        <a href=\"le_artigo.php?cod=" . $dados['cod'] . "\">
                            <img src=\"imagens/livro.gif\" alt=\"Ler Artigo\" title=\"Ler Artigo " . substr($dados['titulo'], 0, 52) . "\">
                        </a>
                    </td>
                    <td>" . substr($dados['chamada'], 0, 52) . "</td>
                    <td>" . $dados['nome'] . "</td>
                </tr>";
        }

        $str .= " <tr>
                    <td colspan=\"3\">";
        $str .= $this->geraIndicesPaginas($pagList, "artigos.php?pag=lista_geral&");
        $str .= "     </td>
                </tr>
            </tbody>
        </table>";

        return $str;
    }

    /**
     * Para edicao de artigos modelo revista
     * @return string
     */
    public function editTxt() {
        $consulta = "SELECT titulo,
                            intro,
                            texto,
                            fonte
                       FROM getar_artg01
                      WHERE codartg= " . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);
        $str = "<label>Titulo:</label>
               <input name=\"titulo\" type=\"text\" value=\"" . $dados['titulo'] . "\" size=\"62\" maxlength=\"60\"><br>
               <label>Introdu&ccedil;&atilde;o: </label>
               <textarea name=\"intro\" cols=\"30\" rows=\"10\">" . $this->devolve_texto($dados['intro']) . "</textarea><br>
               <label>Texto:</label>
               <textarea name=\"texto\" cols=\"120\" rows=\"22\">" . $this->devolve_texto($dados['texto']) . "</textarea><br>";

        return $str;
    }

    /**
     * Array de campos da tabela de chamada para um artigo
     * @return type
     */
    public function consultaCab() {
        $consulta = "SELECT dest,
                            nome,
                            linha,
                            modelo,
                            chamada,
                            datacri,
                            imagem,
                            situacao
                       FROM getar_artgch
                      WHERE cod=" . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Array de campos da tabela de texto para um artigo
     * @return type
     */
    public function consultaTexto() {
        $consulta = "SELECT * FROM getar_artg01 WHERE codartg= " . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * grava o nome da imagem ilustrativa do artigo na tabela de chamada
     * @param type $imagem nome da imagem
     */
    public function gravaImgCh($imagem) {
        $consulta = "UPDATE getar_artgch
                        SET imagem='" . $imagem . "'
                      WHERE cod=" . $this->get_codArtg();
        $msgImg = $this->executaSQL($consulta);
        $this->set_msgImg($msgImg);
    }

    /**
     * Grava o nome da foto na tabela de fotos
     * @param type $imagem nome da foto
     * @param type $tituFt
     * @param type $descr 
     * @return type
     */
    public function gravaImgFt($imagem, $tituFt, $descr) {
        $consulta = "INSERT INTO getar_artgft (codartg, imagem, titulo, descr)
                          VALUES ('" . $this->get_codArtg() . "', '" . $imagem . "', '" . $tituFt . "', '" . $descr . "')";
        $this->executaIdSQL($consulta);

        return $this->get_idRet();
    }

    /**
     * Grava nome corrigido da imagem
     * @param type $codFt
     * @param type $imagem nome da foto com parametro corigidos
     * @return type
     */
    public function atuImgFt($codFt, $imagem) {
        $consulta = "UPDATE getar_artgft
                            SET imagem='" . $imagem . "'
                          WHERE cod=" . $codFt;
        $msgImagem = $this->executaSQL($consulta);

        return $msgImagem;
    }

    /**
     * faz leitura do cabecalho do artigo
     * @return type $resultado
     */
    public function leArtgCab() {
        $consulta = "SELECT modelo, nome, linha FROM getar_artgft WHERE cod= " . $this->get_codArtg();
        $resultado = $this->retornoSQL($consulta);

        return $resultado;
    }

    /**
     * le o conteudo do artigo modelo RV
     * @param type $codArtg
     * @return type
     */
    public function leArtgRv() {
        $consulta = "SELECT titulo, intro, texto, fonte, imagem FROM getar_artg01 WHERE codartg= " . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * le o coneudo do artigo modelo FT
     * @return type
     */
    public function leArtgFt() {
        $consulta = "SELECT titulo, intro, rodape, amplia  FROM getar_artgft WHERE codartg=" . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * le as imagens do artigo modelo FT
     * @return type $resultado
     */
    public function leArtgImg() {
        $consulta = "SELECT imagem,
                            minifoto,
                            descr,
                            titulo,
                            seq
                       FROM getar_artg02
                      WHERE codartg=" . $this->get_codArtg() . "
                   ORDER BY seq";
        $resultado = $this->retornoSQL($consulta);

        return $resultado;
    }

    /**
     * le o conteudo do artigo modelo FCK
     * @return type
     */
    public function leArtgFck($codArtg) {
        $consulta = "SELECT titulo, intro, texto FROM getar_artg01 WHERE codartg=" . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * le os comentario de um artigo
     * @param type $nomeArtg nome do artigo
     * @return type $resultado
     */
    public function leArtgComt($nomeArtg) {
        $consulta = "SELECT remt, texto FROM getar_mens WHERE artigo = '$nomeArtg'";
        $resultado = $this->retornoSQL($consulta);

        return $resultado;
    }

    /**
     * Exclui uma foto do banco de dados
     * @param type $codFt
     * @return type
     */
    public function exclFoto($codFt) {
        $consulta = "SELECT imagem FROM getar_artgft WHERE cod=" . $codFt;
        $dados = $this->consultaSQL($consulta);
        $imagem = $dados['imagem'];
        // Apagar do banco
        $consulta = "DELETE FROM getar_artgft WHERE cod=" . $codFt;
        $this->executaSQL($consulta);

        return $imagem;
    }

    /**
     *  rodape das opcoes de pesquisa e listagem para artigos
     */
    public function artgOpcoes() {
        $str = "<div id=\"opcoes\">
                <div id=\"elemento\">
                    <a href=\"index.php?st=artigos&pag=list&pagina=\">
                        <img src=\"imagens/lista.jpg\" alt=\"\" title=\"Listagem normal\"><br>
                        Listar
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=artigos&pag=list_u&pagina=\">
                        <img src=\"imagens/lista.jpg\" alt=\"\" title=\"Listagem por &Uacute;ltimos\"><br>
                        Listar &Uacute;ltimos
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=artigos&pag=list_ina&pagina=\">
                        <img src=\"imagens/lista.jpg\" alt=\"\" title=\"Listar Artigos Inativos\"><br>
                        Listar Inativos
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=artigos&pag=novo_fck&linha=geral\">
                        <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\"><br>
                        Novo Artigo
                    </a>
                </div>
                <div id=\"elemento\">
                     <form action=\"index.php\" method=\"get\">
                        <input type=\"hidden\" name=\"st\" value=\"artigos\">
                        <input type=\"hidden\" name=\"pag\" value=\"leitura\">
                        <img src=\"imagens/pesquisa1.gif\" alt=\"\">Por C&oacute;digo<br>
                        <input name=\"codartg\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"c\">
                        <i><small>Atalho:[Shift] [Alt] [C]</small></i>
                        <input name=\"Listar\" type=\"submit\" value=\"OK\">
                    </form>
                </div>
            </div>";

        return $str;
    }

    /**
     * Abastece com o cod e o nome das linhas
     */
    public function selectLinhas($codLinha) {
        $str = "<select name=\"linha\" onChange=\"atualDivLinha(this.value);\">";

        //
        //Continuar trabalhando com variaveis globais para as tabelas para poder usar no site plus
        $consulta = "SELECT cod, nome FROM getar_linha";
        $resultado = $this->retornoSQL($consulta);
        while ($dados = $this->arraySQL($resultado)) {
            $str .= "<option value=\"" . $dados["cod"] . $this->selectedIf($dados['cod'], $codLinha) . "\">" . $dados["nome"] . "</option>";
        }

        $str .= " </select>";

        return $str;
    }

    /**
     * Switch para os artigos
     * @param type $pag
     * @return string
     */
    public function artgSwitch($pag) {
        $complemento = "";
        switch ($pag) {
            /* case 'edit':
              $complemento = " AND ch.cod= " . $this->get_codArtg();
              break;
              case 'salvar':
              $complemento = " AND ch.cod= " . $this->get_codArtg();
              //$this->set_linhaArtg("geral");
              break;
              case 'leitura':
              $complemento = " AND ch.cod= " . $this->get_codArtg();
              break;
              case 'listpsqc':
              $complemento = " AND rv.texto LIKE('%" . $this->get_pesq() . "%')
              AND ch.situacao = 'ativo'
              ORDER BY ch.cod ASC";
              $this->set_linhaArtg("geral");
              break;
              case 'listpsqt':
              $complemento = " AND rv.intro LIKE('%" . $this->get_pesq() . "%')
              AND ch.situacao = 'ativo'
              ORDER BY ch.cod ASC";
              $this->set_linhaArtg("geral");
              break; */
        }

        return $complemento;
    }

    /**
     * Ativa um artigo
     */
    public function artgAtv() {
        $consulta = "UPDATE getar_artgch SET situacao = 'ativo' WHERE cod = " . $this->get_codArtg();

        $this->executaSQL($consulta);
    }

    /**
     * Inativa um artigo
     */
    public function artgIna() {
        $consulta = "UPDATE getar_artgch SET situacao = 'inativo' WHERE cod = " . $this->get_codArtg();

        $this->executaSQL($consulta);
    }

    /**
     * Apena leitura de um artigo
     * @return string
     */
    public function artgLeitura() {
        $consulta = " SELECT ch.modelo,
                            (SELECT nome FROM getar_linha WHERE cod = ch.linha) linha,
                            (SELECT descr FROM getar_linha WHERE cod = ch.linha) descr
                       FROM getar_artgch ch
                      WHERE cod= " . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);
        $resultado = $this->retornoSQL($consulta);
        $rows = $this->rowsSQL($resultado);

        $str = "";
        if ($rows == 0) {//se o artigo chamado nao existir
            $str = "<b style=\"color: red\"> Artigo n&atilde;o encontrado!</b>";
            return $str;
        }
        $str .= $this->artgLtRv();

        return $str;
    }

    /**
     * Para leitura do artigo modelo revista
     * @return string
     */
    public function artgLtRv() {
        $consulta = "SELECT * FROM getar_artg01 WHERE codartg=" . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        $str = "<div class=\"titulo\">" . $dados['titulo'] . "</div>
                <div id=\"imagem\">";

        $imagen_ilu = $dados['imagem'];
        if ($imagen_ilu <> "-") {
            $str .= "<img id=\"img\" src=\"" . $this->get_localFotos() . $dados['imagem'] . "\" style=\"width: 100px\">
                   &nbsp;";
        }

        $str .= "</div>
               <div id=\"intro\">" . $dados['intro'] . "</div>
               <br style=\"clear: both;\" />
               <div id=\"texto\">" . $dados['texto'] . "</div>
               <div id=\"fonte\">" . $dados['fonte'] . " - Linha Artigo:" . $this->get_linhaArtg() . "</div>";

        return $str;
    }

    public function artgLtFck() {
        $consulta = "SELECT titulo, intro, texto, fonte FROM getar_artg01 WHERE codartg=" . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);
    }

    /**
     * Retorna array com campos da tabela de chamada do artigo
     * @return type
     */
    public function consArtgCh() {
        $consulta = "SELECT dest,
                            nome,
                            linha,
                            modelo,
                            chamada,
                            DATE_FORMAT(datacri, '%d/%m/%Y') datacri,
                            imagem,
                            situacao
                       FROM getar_artgch
                      WHERE cod= " . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Retorna array com campos da tabela de texto do artigo
     * @return type
     */
    public function consTexto() {
        $consulta = "SELECT titulo,
                            intro,
                            texto,
                            fonte
                       FROM getar_artg01
                      WHERE codartg= " . $this->get_codArtg();
        $dados = $this->consultaSQL($consulta);

        return $dados;
    }

    /**
     * Formulario para listar por um determinada linha de artigos
     * Ex; Sistema operacional, PHP/HTML
     * @return string
     */
    public function linhaForm() {
        $str = "<form action=\"index.php?st=artigos&pag=list&pagina=1\" method=\"post\">
                    <fieldset>
                        <legend>Listagem por linha de Artigo</legend>
                        <label>Selecione linha:</label>
                        " . $this->selectLinha($this->get_linhaArtg()) . "<br />
                        <label>&nbsp;</label>
                        <input type=\"submit\" name=\"lista\" value=\"Listar\" /><br />
                        <div id=\"divLinha\"></div>
                    </fieldset>
                </form>";

        return $str;
    }

    /**
     * Pesquisa por uma string no conteudo do artigo
     * @return string
     */
    public function pesqFormC() {
        $str = " <form action=\"index.php?st=artigos&pag=listpsqc&pagina=1\" method=\"post\">
                    <fieldset>
                        <legend>Pesquisa por string no conteudo</legend>
                        <label>Pesquisar por:</label>
                        <input type=\"text\" name=\"string\" value=\"\" /><br />
                        <label>&nbsp;</label>
                        <input type=\"submit\" name=\"pesq\" value=\"Pesquisar\" />
                    </fieldset>
                </form>";

        return $str;
    }

    /**
     * Pesquisa por tag na intro
     * @return string
     */
    public function pesqFormT() {
        $str = " <form action=\"index.php?st=artigos&pag=listpsqt&pagina=1\" method=\"post\">
                    <fieldset>
                        <legend>Pesquisa por tag na intro</legend>
                        <label>Pesquisar por:</label>
                        <input type=\"text\" name=\"string\" value=\"\" /><br />
                        <label>&nbsp;</label>
                        <input type=\"submit\" name=\"pesq\" value=\"Pesquisar\" />
                    </fieldset>
                </form>";

        return $str;
    }

}

?>
