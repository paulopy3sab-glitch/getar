<?php

/**
 * Classe para conectar em MySQL, definicoes de trabalho
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * descricao: metodos de apoio as conexao ao banco de dados
 */
class Conex extends Config {

    use Tgeral;

    public $conexao;
    private $idRet;

    /**
     * Sucesso ou nao na execusao de uma SQL
     * @var <boolen> 
     */
    private $suces;
    //
    private $resp;
    private $nick;
    private $senha;
    public $arrayAtrib;
    //
    private $arqSincro;

    function __construct() {
        $msg = "# inicio processamento classe Conex";
        $this->gravaSQL($msg);
        parent::__construct();
        $this->arqSincro = "sincro" . date('ymdh') . ".sql";
        $this->conexao = mysqli_connect($this->host, $this->usuario, $this->senhaBd, $this->banco);
        mysqli_set_charset($this->conexao, "utf8");
    }

    public function get_conexao() {
        return $this->conexao;
    }

    public function set_conexao($conexao) {
        $this->conexao = $conexao;
    }

    public function get_arrayAtrib() {
        return $this->arrayAtrib;
    }

    public function set_arrayAtrib($arrayAtrib) {
        $this->arrayAtrib = $arrayAtrib;
    }

    /**
     * nick ou usuario para logon
     * @return type
     */
    public function set_nick($novo_nick) {
        $this->nick = $novo_nick;
    }

    /**
     * nick ou usuario para logon
     * @return type
     */
    protected function get_nick() {
        return $this->nick;
    }

    /**
     * senha para logon
     * @return type
     */
    public function set_senha($novo_senha) {
        $this->senha = $novo_senha;
    }

    /**
     * senha para logon
     * @return type
     */
    protected function get_senha() {
        return $this->senha;
    }

    /**
     * operador responsavel logado
     * @return type
     */
    public function set_resp($novo_resp) {
        $this->resp = $novo_resp;
    }

    /**
     * operador responsavel logado
     * @return type
     */
    public function get_resp() {
        return $this->resp;
    }

    /**
     * retorna o id (cod) gerado ao inserir um registro novo
     * @return type
     */
    public function get_idRet() {
        return $this->idRet;
    }

    /**
     * se uma SQL teve sucesso= TRUE
     * se erro: FALSE
     * @param <boolean> $suces
     */
    protected function set_suces($suces) {
        $this->suces = $suces;
    }

    /**
     * se uma SQL teve sucesso= TRUE
     * se erro: FALSE
     * return <boolean> $suces
     */
    protected function get_suces() {
        return $this->suces;
    }

    /**
     * Grava ou nao arquivos de sincronismo
     * @return type
     */
    protected function get_gravaSQL() {
        return $this->gravaSQL;
    }

    /**
     * Nome definido por um codigo formado pelo dia e hora para o arquivo onde
     * registra as consultas executadas
     * @return type
     */
    protected function get_arqSincro() {
        return $this->arqSincro;
    }

    /**
     * ponto de correcao do CURTIME() por um fuso horario diferente
     * Ex.: hospedadgem em portugual
     * @return string
     */
    protected function curtimeFuso() {
        $str = "SUBTIME(NOW(), '0 " . $this->get_fusoHora() . "')";

        return $str;
    }

    /**
     * SQL de INSERTE E UPDATE, grava para posterior sincronismo em banco externo
     * @param <string> $consulta
     * @return <string> $msg de erro ou sucesso
     */
    protected function executaSQL($consulta) {

        $resultado = mysqli_query($this->get_conexao(), $consulta);
        if ($resultado) {
            $msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
            $this->set_suces(TRUE);
        } else {
            $consulta = "# " . mysqli_error($this->get_conexao()) . "\n " . $consulta;
            $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
            // enviar mensgem para all_admin
            $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
            $this->mensAllAdmin($texto);
            $this->set_suces(FALSE);
        }
        $this->gravaSQL($consulta);

        return $msg;
    }

    /**
     * Executa um INSERT e registro via get_idRet o id criado (cod)
     * @param string $consulta
     * @return string $msg se erro ou nao
     */
    protected function executaIdSQL($consulta) {
        $retorno = mysqli_query($this->get_conexao(), $consulta);
        if ($retorno) {
            $msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
            $this->set_suces(TRUE);
        } else {
            $consulta = "# " . mysqli_error($this->get_conexao()) . "\n " . $consulta;
            $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
            // enviar mensgem para all_admin
            $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
            $this->mensAllAdmin($texto);
            $this->set_suces(FALSE);
        }
        $this->idRet = mysqli_insert_id($this->get_conexao());
        $consulta .= "\n# cod novo gerado= " . $this->idRet . "\n";
        $this->gravaSQL($consulta);

        return $msg;
    }

    /**
     * Grava SQL em arquivos js_ onde muda o loca de gravacao e o CSS do retorno
     * @param string $consulta
     * @return string $msg se erro ou nao
     */
    protected function executaJsSQL($consulta) {
        $msg = "";
        $retorno = mysqli_query($this->get_conexao(), $consulta);
        if ($retorno) {
            $msg = "DADOS GRAVADOS COM EXITO!!";
            $this->set_suces(TRUE);
        } else {
            $consulta = "# " . mysqli_error($this->get_conexao()) . "\n " . $consulta;
            $msg = "ERRO AO GRAVAR DADOS!!";
            // enviar mensgem para all_admin
            $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
            $this->mensAllAdmin($texto);
            $this->set_suces(FALSE);
        }
        $this->gravaSQL($consulta);

        return $msg;
    }

    /**
     * Apenas grava a consulta SQL em arquivo
     * @param <string> $consulta
     * @param <string> $resp nick logado no sistema
     */
    protected function gravaSQL($consulta) {
        $escreve = "";
        if ($this->gravaSQL) {// gravar a SQL num arquivo
            $fp = fopen($this->get_localBackup() . $this->arqSincro, "a+");
            $gravaConsulta = "\n # " . $this->get_resp() . " - " . date('d-m-Y H:i') . "\n" . $consulta . ";";
            $escreve = fwrite($fp, $gravaConsulta);
            fclose($fp);
        }
    }

    /**
     * Grava a saida $str no arquivo Backup/saidastrXXX.txt
     * @param type $str
     */
    public function gravaStr($str) {
        $arquivo = "saidastr" . date('ymdh') . ".txt";
        $fp = fopen($this->get_localBackup() . $arquivo, "w+");
        $gravaConsulta = "\n # " . $this->get_resp() . " - " . date('d-m-Y H:i') . "\n" . $str . ";";
        $escreve = fwrite($fp, $gravaConsulta);
        fclose($fp);
    }

    /**
     * Grava txt com registros de log
     * @param string $str
     * @return type
     */
    public function gravaLog($str) {
        if (!$this->get_gravaRegLog()) {
            return;
        }
        $arquivo = "logde" . $this->get_resp() . date('ymdh') . ".txt";
        $fp = fopen($this->get_localDocs() . $arquivo, "a+");
        $str = "\n # " . $this->get_resp() . " - " . date('d-m-Y H:i') . "\n" . $str . ";";
        $escreve = fwrite($fp, $str);
        fclose($fp);
    }

    /**
     * Para simples consulta. Podendo se adaptar para outros bancos (Oracle, MariaDb)
     * @param string $consulta consulta SQL
     * @return array tipo $dados['xxx']
     */
    protected function consultaSQL($consulta) {

        $resultado = mysqli_query($this->get_conexao(), $consulta);
        if ($resultado) {
            $msg = "<b style=\"color: red\">DADOS GRAVADOS COM EXITO!!</b>";
            $this->set_suces(TRUE);
        } else {
            $consulta = "# " . mysqli_error($this->get_conexao()) . "\n " . $consulta;
            $msg = "<b style=\"color: red\">ERRO AO GRAVAR DADOS!!</b>";
            // enviar mensagem para all_admin
            $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
            $this->mensAllAdmin($texto);
            $this->set_suces(FALSE);
        }
        $this->gravaSQL($consulta);

        if ($this->get_suces() == FALSE) {
            return "";
        }
        $dados = mysqli_fetch_array($resultado);

        return $dados;
    }

    /**
     * retorna para o array resultado da consulta
     * @param type $consulta
     * @return type $resultado
     */
    protected function retornoSQL($consulta) {
        $resultado = mysqli_query($this->get_conexao(), $consulta);
        if ($resultado) {
            $msg = "<b style=\"color: red\">DADOS CONSULTADOS COM EXITO!!</b>";
            $this->set_suces(TRUE);
        } else {
            $consulta = "# " . mysqli_error($this->get_conexao()) . "\n " . $consulta;
            $msg = "<b style=\"color: red\">ERRO AO CONSULTAR DADOS!!</b>";
            // enviar mensagem para all_admin
            $texto = "ERRO AO GRAVAR DADOS!!\n" . $consulta;
            $this->mensAllAdmin($texto);
            $this->set_suces(FALSE);
        }
        $this->gravaSQL($consulta);

        return $resultado;
    }

    /**
     * retorna o numero de linhas do SELECT
     * @param type $resultado
     * @return type $rows
     */
    protected function rowsSQL($resultado) {

        $rows = mysqli_num_rows($resultado);

        return $rows;
    }

    /**
     * retorna array do SELECT
     * @param type $resultado
     * @return type $array
     */
    protected function arraySQL($resultado) {

        $array = mysqli_fetch_array($resultado);

        return $array;
    }

    /**
     * Carregar array de atribuicoes ao usuarito logado
     */
    public function carAtrib($resp) {
        static $arrayAtrib = array();
        $consulta = cad_cons01($resp);
        $resultado = $this->retornoSQL($consulta);
        while ($dados = $this->arraySQL($resultado)) {
            array_push($arrayAtrib, $dados['codatrib']);
        }
        $this->arrayAtrib = $arrayAtrib;
    }

    /**
     * Verificar se atribui ou nao para o usuario logado
     * @param int $codAtrib
     * @return boolean Recurso atribuido ou nao ao usuario logado
     */
    public function atrib($codAtrib) {
        $atrib = FALSE;
        if (in_array($codAtrib, $this->arrayAtrib)) {
            $atrib = TRUE;
        }

        return $atrib;
    }

    /**
     * grava na tabela getar_reglog a hora da ultima atividade
     */
    public function gravaUlt() {
        $consulta = "UPDATE getar_reglog
                           SET horault = " . $this->curtimeFuso() . ",
                               horafim= " . $this->curtimeFuso() . "
                         WHERE nick= '" . $this->get_resp() . "'
                               AND situacao = 'ativo'";
        $this->executaSQL($consulta);
    }

    /**
     * Envia mensagem do erro para all_admin
     * @param type $texto
     */
    public function mensAllAdmin($texto, $email = FALSE) {
        $texto = $this->html_texto($texto);
        $consulta = "INSERT INTO getar_mens (dest, remt, remtemail, data, titulo, texto, situ)
                                      VALUES('all_admin', '" . $this->get_resp() . "', '', CURDATE(), 'Erro de Sistema', '" . $texto . "', 'enviada')";
        mysqli_query($this->get_conexao(), $consulta);
        $this->gravaSQL($consulta);

        // envia email
        if ($email) {
            $mail = $this->conecMailer();
            $mail->From = $this->get_smtpFrom(); // Email de quem envia o email
            $mail->FromName = "Contato SCHW"; // Nome de quem envia o email
            $mail->AddAddress($this->get_destEmail()); // Email de quem recebe
            $mail->AddReplyTo($this->get_smtpFrom(), "Contato SCHW"); // E-mail e nome para retorno

            $mail->WordWrap = 50; // Definir quebra de linha
            $mail->IsHTML(false);

            $mail->Subject = "Erro GETAR: " . $this->get_tituloPag(); // Assunto
            $texto = "Ola!<br><br>
          Foi enviada a seguinte mensagem na area administrativa do Getar:<br>
          Enviada: " . date('d/m/Y') . "<br>
              <pre>" . $texto . "</pre>";
            $mail->Body = $texto;
            $comentario = "";
            $mail->AltBody = $comentario . "\n" . "Enviada: " . date("d/m/Y");

            if (!$mail->Send()) { // Envia o email
                $msgMens = "<b style=\"color: red;\">A Mensagem nao foi enviada </b>
                Erro reportado: " . $mail->ErrorInfo . "<br>";
            } else {
                $msgMens = "<b>A mensagem foi enviada com sucesso.<br>
                Em breve retornaremos sua solicita&ccedil;&atilde;o/contato<br>";
            }
        }
    }

    public function conecMailer() {
        require($this->pastaPHPMailer . "class.phpmailer.php");

        $mail = new PHPMailer();

        $mail->IsSMTP(); // evia por SMTP
        $mail->Host = $this->get_smtpServer(); // SMTP servers
        $mail->SMTPAuth = $this->get_smtpAuth(); // Caso o servidor SMTP precise de autenticacao
        $mail->Username = $this->get_smtpUser(); // SMTP username
        $mail->Password = $this->get_smtpPassword(); // SMTP password

        return $mail;
    }

    /**
     * Retorna o nome completo do logado no sistema
     * @return type
     */
    public function nomeResp() {
        $consulta = "SELECT cad.nome,
                           cad.emailcorp
                      FROM getar_cad cad,
                           getar_control ct
                     WHERE cad.cod = ct.codcad
                           AND ct.nick = '" . $this->get_resp() . "'";
        $dados = $this->consultaSQL($consulta);
        $arrayResp[1] = $dados['nome'];
        $arrayResp[2] = $dados['emailcorp'];
        return $arrayResp;
    }

    /**
     * Aviso que tem mais linhas a serem listadas
     * @param type $conta
     * @return string
     */
    public function prim20($conta) {
        $str = "";
        if ($conta > 19) {
            $str = "<b style=\"color: blue;\">Listando primeiras 20 linhas</b>";
        }
        return $str;
    }

}

?>
