<?php

class classeFoto {

    // Definicao das tabelas
    private $tabArtgCh;
    private $tabArtgRv;
    private $tabArtgFt;
    private $tabArtgFtImg;

    /* Metodo construtor da classe */

    function __construct() {

        global $tabArtgCh;
        $this->tabArtgCh = $tabArtgCh;
        global $tabArtgRv;
        $this->tabArtgRv = $tabArtgRv;
        global $tabArtgFt;
        $this->tabArtgFt = $tabArtgFt;
        global $tabArtgFtImg;
        $this->tabArtgFtImg = $tabArtgFtImg;
    }

    /**
     * acao:
     *     edit_fotoCh= para editar as fotos/imagens da chamada
     *     edit_fotoFt= para editar as fotos dos artigos modelo fotos
     *     add_fotoFt= para as fotos dos artigos modelo fotos
     *     edit_fotoRv= para editar as fotos/imagens ilustrativas
     * @global $conexao $conexao
     * @param <type> $cod_artg
     * @param <type> $acao 
     */
    function addform($cod_artg, $acao) {
        global $conexao;

        $retorno = '
        <script type="Text/JavaScript">        
            function oculta() {        
                document.getElementById("botao").style.visibility = "hidden";        
            }        
        </script>        
        <form name="valida" method="post" action="artigofoto.php" onClick="oculta()">
            <input type="hidden" name="cod_artg" value="' . $cod_artg . '">';

        $pesq = "";
        switch ($acao) {
            case 'edit_fotoCh':
                $pesq = "SELECT * FROM $this->tabArtgCh WHERE cod= $cod_artg";
                $retorno .= "<input type='hidden' name='pag' value='edit_salvarch'>";
                break;
            case 'edit_fotoFt':
                $codFoto = $_REQUEST['codFoto'];
                $retorno .= "<input type='hidden' name='codFoto' value='$codFoto'>";
                $retorno .= "<input type='hidden' name='pag' value='edit_salvarft'>";
                $pesq = "SELECT * FROM $this->tabArtgFtImg WHERE cod= $codFoto";
                break;
            case 'add_fotoFt':
                $retorno .= "<input type='hidden' name='pag' value='addsalvarft'>";
                break;
            case 'edit_fotoRv':
                $pesq = "SELECT * FROM $this->tabArtgRv WHERE codartg= $cod_artg";
                $retorno .= "<input type='hidden' name='pag' value='edit_salvarrv'>";
                break;
        }

        if ($pesq != "") {
            $resultado = mysql_query($conexao, $pesq);
        } else {
            return;
        }

        $retorno .= '
        <table border=0>    
            <tr>    
                <td colspan="2" align="center">    
                    <b>Aproveitando fotos no Servidor</b></td>    
            </tr>    
            <tr>    
                <td colspan="2" align="center">
                    <script language="JavaScript">';

        if ($acao == "add_fotoFt") {
            $fotoIni = "moldura.jpg";
        } else {
            $fotoIni = mysql_result($resultado, 0, "imagem");
        }
        $retorno .= '
                    foto_ = "foto-' . $fotoIni . '";
                    </script>
                    <img id="foto-' . $fotoIni . '" src="../fotos/miniatura.php?imagem=' . $fotoIni . '&altura=100" alt="" /><br>';

        //Imprimir as imagens disponivel com tamanho 0
        $dir = "../fotos/";
        $i = 0;
        // Abre um diretorio conhecido, e faz a leitura de seu conteudo
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($this->aprovaArq($file) != "n") {

                        $retorno .= '<img id="foto-' . $file . '" src="' . $dir . 'miniatura.php?imagem=' . $file . '&altura=100" alt="" style="width: 0px">';

                        $listFoto[$i] = $file;
                        $i++;
                    } //Fecha o if $file
                } // Fecha o while
            } // Fecha o if $dh
        } //Fecha o if is_dir(

        $retorno .= '</td></tr>
        <tr>
            <td colspan="2">
                <select name="select_foto" id="foto" onChange="exibe(\'foto\')">';

        if ($acao == "add_fotoFt") {
            $foto = "Selecione no servidor";
            $codFoto = "-";
        } else {
            $foto = mysql_result($resultado, 0, "imagem");
        }

        $retorno .= '   <option value="' . $foto . '"> ' . $foto . '</option>';

        for ($i = 0; $listFoto[$i] != ""; $i++) {
            $retorno .= '<option value=' . $listFoto[$i] . '>' . $listFoto[$i] . '</option>\n';
        }
        $retorno .= '
                </select> <br> </td>
        </tr>';

        if ($acao == "add_fotoFt" or $acao == "edit_fotoFt") {
            $retorno .= '
                            <tr>                     
                                <td colspan="2" align="center">';

            $descr = "";
            if ($acao == "edit_fotoFt") {
                $descr = mysql_result($resultado, 0, "descr");
            }

            $retorno .= '             <textarea name="descr" cols="40" rows="3" id="descr">' . $descr . '</textarea></td>
                            </tr>';
        }

        $retorno .= '   <tr>                 
                            <td colspan="2" align="center">                
                                <input type="submit" value="Salvar"></td>                
                        </tr>                
                    </table>                
                </form>';
        return $retorno;
    }

    /**
     *
     * @global $conexao $conexao
     * @param <type> $consulta
     * @param <type> $codFoto
     * @param <type> $cod_artg
     * @return string 
     */
    function confirma_exclft($consulta, $codFoto, $cod_artg) {
        global $conexao;
        $resultado = mysqli_query($conexao, $consulta);
        $retorno = '<form name="valida" method="post" action="artigofoto.php">                        
                        <input type="hidden" name="pag" value="exclft">                        
                        <input type="hidden" name="codFoto" value="' . $codFoto . '">
                        <input type="hidden" name="cod_artg" value="' . $cod_artg . '"> 
                        <table border=1>                        
                            <tr>                         
                                <td class="sub-titulo" colspan="2"> Confirma&ccedil;&atilde;o de Exclus&atilde;o!</td>                        
                            </tr>                        
                            <tr>                        
                                <td colspan="2" align="center">                        
                                    <img src="../fotos/miniatura.php?imagem=' . mysql_result($resultado, 0, "imagem") . '&altura=100" alt="">
                                </td>                        
                            </tr>                        
                            <tr>                        
                                <td colspan="2" align="center">' . mysql_result($resultado, 0, "descr") . '&nbsp;</td>
                            <tr>                         
                                <td> Confirma Exclu&ccedil;&atilde;o desta foto?                         
                                    <select name="valida">                        
                                        <option value="s">Sim</option>                        
                                        <option value="n">N&atilde;o</option>                        
                                    </select></td>                        
                                <td> <input type="submit" value="Excluir"></td>                        
                            </tr>                        
                        </table>                        
                    </form>';
        return $retorno;
    }

    /**
     *
     * @global $conexao $conexao
     * @param <type> $cod 
     */
    function exclft($cod) {
        global $conexao;
        $valida = $_REQUEST['valida'];
        $consulta = "DELETE FROM $this->tabArtgFtImg WHERE cod=$cod";
        if ($valida == "s") {
            $resultado = mysqli_query($conexao, $consulta);
            $row = mysql_affected_rows($conexao);
            if ($row > 0) {
                $retorno = "<br><b>Foto e descri&ccedil;&atilde;o excluidos do artigo!</b>";
            }
        }
        return $retorno;
    }

    /**
     *
     * @global  $conexao
     * @param <type> $consulta 
     */
    function addfoto($consulta) {
        global $conexao;
        $resultado = mysqli_query($conexao, $consulta);
        $row = mysql_affected_rows($conexao);
        if ($row > 0) {
            $retorno = "<br><b>Foto e/ou descri&ccedil;&atilde;o adicionadas ao artigo!</b>";
        }
        return $retorno;
    }

    /**
     *
     * @param <type> $cod_artg
     * @param <type> $acao
     * @return string 
     */
    function ftpAnexar($cod_artg, $acao) {
        $retorno = '
            <script type="Text/JavaScript">                        
                <!--                        
                function oculta() {                        
                    document.getElementById("botao").style.visibility = "hidden";                        
                }                        
                function aguarde() {                        
                    document.getElementById("carregando").style.display = "block";                        
                }                        
                //-->                        
            </script>                        
            <form action="artigofoto.php" method="post" name="envia_arq" enctype="multipart/form-data" onClick="oculta()" onsubmit="aguarde()">                        
                <input type="hidden" name="pag" value="ftpImagens">                        
                <input type="hidden" name="pasta" value="fotos">                        
                <input type="hidden" name="codFoto" value="' . $_REQUEST['codFoto'] . '">
                <input type="hidden" name="cod_artg" value="' . $cod_artg . '">
                <input type="hidden" name="acao" value="' . $acao . '">
                <table border=0>                        
                    <tr>                        
                        <td colspan="2" align="center">                        
                            <b>Upload apartir do seu Computador.</b></td></tr>                        
                    <tr>                         

                        <td colspan="2" align="center">Descri&ccedil;&atilde;o da foto a ser anexada ao artigo.                        
                            <br>                        
                            <textarea name="descr" cols="40" rows="3" id="descr"></textarea></td>                        
                    </tr>                        
                    <tr>                         
                        <td>                        
                            <input type="hidden" name="MAX_FILE_SIZE" value="800000">                        
                            <input type="file" name="arquivo"></td>                        
                        <td>                        
                            <input name="submit" type="submit"></td>                        
                    </tr>                        
                    <tr>                        
                        <td colspan="2" class="chamada"> Nomes de fotos ou imagens com acentos ou                         
                    espa&ccedil;os ser&atilde;o convertidos<a href="../ajuda/nome_arqu.htm" target="_blank">                        
                    Mais<img src="imagens/exclama.gif" alt="" width="5" height="9" border="0" /></a></td>                        
                    </tr>                        
                </table>                        
            </form>                        
            <form name="anexar" method="post" action="artigofoto.php">                        
                <input type="hidden" name="pag" value="addform">                        
                <input type="hidden" name="cod_artg" value="' . $cod_artg . '">
                <input type="hidden" name="codFoto" value="' . $_REQUEST['codFoto'] . '">
                <input type="hidden" name="acao" value="' . $acao . '">
                <table border=0>    
                    <tr>    
                        <td colspan="2" class="chamada">    
                            <div id="carregando" align="center" style=" width:200px; height:150px; vertical-align:middle; display:none">    
                                <img src="imagens/enviando.gif" alt="" /><br />    
                         Enviando sua Foto Aguarde!</div></td>    
                    </tr>        
                    <tr>    
                        <td colspan="2" align="center">    
                            <input id="botao" type="submit" value="Reaproveitar do Servidor">    
                        </td>    
                    </tr>    
                </table>    
            </form>';
        return $retorno;
    }

    /**
     *
     * @global <type> $conexao
     * @global <type> $loginFTP
     * @global <type> $senhaFTP
     * @global <type> $serverFTP
     * @global <type> $diretorioFTP
     * @param <type> $cod_artg
     * @param <type> $acao 
     */
    function ftpImagens($cod_artg, $acao) {
        global $conexao;
        //Configuracao FTP
        global $loginFTP;
        global $senhaFTP;
        global $serverFTP;
        global $diretorioFTP;

        //Avisa arquivo muito grande
        $nome = $this->nomeSite; // Carrega o nome do site que carregou uma foto grande
        $email = "vendas@teutoinfo.com.br";
        $comentario = "Arquivo muito grande: " . $arquivo_remoto;
        $data = date('d-m-Y');
        $dest_email = "paulo_schw@yahoo.com.br";
        $cc_email = "";

        $cod_artg = $_REQUEST['cod_artg'];
        $pasta = "fotos";
        $descr = $_REQUEST['descr'];
        $arquivo_local = $_FILES['arquivo']['tmp_name'];
        $arquivo_remoto = $_FILES['arquivo']['name'];
        $arquivo_remoto = $this->trata_arqu($arquivo_remoto);
        $foto = $arquivo_remoto;
        $tam_arq = $_FILES['arquivo']['size'];
        if ($tam_arq == 0) {
            $retorno = "<b>Upload rejeitado porque a foto ultrapacou o tamanho maximo permitido!</b>";
            return $retorno;
        }
        //So imagens
        $aprov = "n";
        $redimen = "n";
        $ext = substr($foto, strlen($foto) - 4, 4);
        switch ($ext) {
            case '.gif':
                $aprov = "s";
                break;
            case '.GIF':
                $aprov = "s";
                break;
            case '.jpg':
                $aprov = "s";
                $redimen = "s";
                break;
            case 'jpeg':
                $aprov = "s";
                $redimen = "s";
                break;
            case '.JPG':
                $aprov = "s";
                $redimen = "s";
                break;
            case 'JPEG':
                $aprov = "s";
                $redimen = "s";
                break;
            case '.png':
                $aprov = "s";
                break;
            case '.PNG':
                $aprov = "s";
                break;
        }
        if ($aprov == "n") {
            $retorno = "<b>E permitido o upload somente de imagens ou fotos (JPEG, GIF ou PNG)</b>";
            return $retorno;
        }
        $conn_id = ftp_connect($serverFTP);
        if (!$conn_id) {
            $retorno = "nao foi possivel conectar ao servidor de ftp dp site <br>" . $ftp;
            return $retorno;
        }
        $login_result = ftp_login($conn_id, $loginFTP, $senhaFTP);
        if (!$login_result) {
            $retorno = "erro ao efetuar login<br>";
            return $retorno;
        }

        ftp_pasv($conn_id, true);
        $arquivo_remoto = $diretorioFTP . "/" . $pasta . "/" . $arquivo_remoto;
        $upload = ftp_put($conn_id, $arquivo_remoto, $arquivo_local, FTP_BINARY);
        if ($redimen == "s") {
            // Redimensiona fotos para menor tamanho
            $this->geraThumb($foto, $foto."_01", 640);
        }
        //Pega o tamanho do arquivo
        $res = ftp_size($conn_id, urldecode($arquivo_remoto));
        if ($res > 600000) {

            $mail->FromName = $nome; // Nome de quem envia o email
            $mail->AddAddress($dest_email); // Email e nome de quem receber
            $mail->AddReplyTo($email, $nome); // E-mail de retorno
            if ($cc_email <> "") {
                $mail->AddCC($cc_email);
            }

            $mail->WordWrap = 50; // Definir quebra de linha
            $mail->IsHTML(false);

            $mail->Subject = "Contato via Site " . $nomeSite; // Assunto
            $texto = "Ola!<br>" . $nome . " (" . $email . ")<br>";
            $texto = $texto . " Enviou a seguinte mensagens via site " . $nomeSite . ":<br>";
            $texto = $texto . "<hr>" . $comentario . "<hr>" . "Enviada: " . $data;
            $mail->Body = $texto;
            $mail->AltBody = $comentario . "\n" . "Enviada: " . $data;

            if (!$mail->Send()) { // Envia o email
                echo "A Mensagem nao foi enviada <p>";
                echo "Erro reportado: " . $mail->ErrorInfo;
                exit;
            } else {
                echo "<br>A mensagem foi enviada com sucesso.<br>";
                echo "Em breve retornaremos sua solicita&ccedil;&atilde;o/contato";
            }
        }
        if (!$upload) {
            $retorno = "O upload FTP falhou!";
            return $retorno;
        } else {
            $retorno = "Arquivo Transferido com sucesso para o servidor FTP<br>";
            $retorno .= "<script>document.getElementById(\"carregando\").style.display = \"none\";</script>";
        }
        //fechando a conexao FTP
        ftp_close($conn_id);
        $matriz = explode("/", $arquivo_remoto);
        $foto = array_pop($matriz);
        //Salva no banco de dados
        switch ($acao) {
            case 'edit_fotoCh':
                $consulta = "UPDATE " . $this->tabArtgCh . " SET imagem = '$foto' WHERE cod='$cod_artg'";
                break;
            case 'edit_fotoFt':
                $descr = $_REQUEST['descr'];
                $consulta = "UPDATE " . $this->tabArtgFtImg . " SET codartg= '$cod_artg', imagem= '$foto', descr='$descr' WHERE cod='" . $_REQUEST['codFoto'] . "'";
                break;
            case 'add_fotoFt':
                $descr = $_REQUEST['descr'];
                $consulta = "INSERT INTO " . $this->tabArtgFtImg . " (codartg, imagem, descr) VALUES ('$cod_artg', '$foto', '$descr')";
                break;
            case 'edit_fotoRv':
                $consulta = "UPDATE " . $this->tabArtgRv . " SET imagem = '$foto' WHERE codartg='$cod_artg'";
                break;
        }
        $resultado = mysqli_query($conexao, $consulta);
        $row = mysql_affected_rows($conexao);

        return $retorno;
    }

    /**
     * Metodo geraThumb
     * Gera thumbnail a partir da foto
     * Creditos: http://www.pablo.blog.br/35
     * uso: geraThumb("DSCI0143.JPG", "novaFoto.jpg", '240');
     * @param <type> $photo
     * @param <type> $output
     * @param <type> $new_width 
     */
    function geraThumb($photo, $output, $new_width) {
        $source = imagecreatefromstring(file_get_contents("../fotos/" . $photo));
        list($width, $height) = getimagesize("../fotos/" . $photo);
        if ($width > $new_width) {
            $new_height = ($new_width / $width) * $height;
            $thumb = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($thumb, $output, 100);
        } else {
            copy("../fotos/" . $photo, "../fotos/" . $output);
        }
    }

    /**
     * Evita nomes impropios de arquivos trazidos pela funcao dir()
     * @param <type> $nomeArq
     * @return string 
     */
    function aprovaArq($nomeArq) {
        $aprov = "s";
        switch ($nomeArq) {
            case '..':
                $aprov = "n";
                break;
            case '.':
                $aprov = "n";
                break;
            case '':
                $aprov = "n";
                break;
        }

        //Pegar extencao do arquivo e controlar impressao dos arquivos essenciais
        $ext = substr($nomeArq, strlen($nomeArq) - 4, 4);
        if ($ext == ".php") {
            $aprov = "n";
        }

        if ($file == "moldura.jpg") {
            $aprov = "n";
        }
        return $aprov;
    }

    /**
     *
     * @param <type> $str
     * @return <type>
     */
    function trata_arqu($str) {
        $str = str_replace("�", "A", $str); //�
        $str = str_replace("�", "A", $str); //�
        $str = str_replace("�", "A", $str); //�
        $str = str_replace("�", "A", $str); //�
        $str = str_replace("�", "A", $str); //�
        $str = str_replace("�", "E", $str); //�
        $str = str_replace("�", "E", $str); //�
        $str = str_replace("�", "I", $str); //�
        $str = str_replace("�", "O", $str); //�
        $str = str_replace("�", "O", $str); //�
        $str = str_replace("�", "O", $str); //�
        $str = str_replace("�", "U", $str); //�
        $str = str_replace("�", "U", $str); //�
        $str = str_replace("�", "C", $str); //�
        $str = str_replace("�", "a", $str); //�
        $str = str_replace("�", "a", $str); //�
        $str = str_replace("�", "a", $str); //�
        $str = str_replace("�", "a", $str); //�
        $str = str_replace("�", "e", $str); //�
        $str = str_replace("�", "e", $str); //�
        $str = str_replace("�", "i", $str); //�
        $str = str_replace("�", "i", $str); //�
        $str = str_replace("�", "o", $str); //�
        $str = str_replace("�", "o", $str); //�
        $str = str_replace("�", "u", $str); //�
        $str = str_replace("�", "u", $str); //�
        $str = str_replace("�", "c", $str); //�
        $str = str_replace(" ", "_", $str);
        $str = str_replace("'", "-", $str);
        $str = str_replace("[", "-", $str);
        $str = str_replace("]", "-", $str);
        $str = str_replace("{", "-", $str);
        $str = str_replace("}", "-", $str);
        $str = str_replace("(", "-", $str);
        $str = str_replace(")", "-", $str);
        $str = str_replace("@", "-", $str);
        return $str;
    }

}

?>
