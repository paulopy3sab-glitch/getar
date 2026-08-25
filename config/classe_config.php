<?php

/**
 * Description of classe_config:
 * Destinada a separar as configuracoes de conexao e locais de trabalho
 *
 * @author Paulo Regis Agosto/2016
 * Revisoes:
 * 22/03/2026
 *   $logonBoasVindas; # sem o relatorio de boasvindas.inc.php
 * Ver TRAF5602
 */
class Config {

    use Tpersonal;

    protected $host;
    protected $banco;
    protected $senhaBd;
    protected $usuario;
    protected $logonBoasVindas; # sem o relatorio de boasvindas.inc.php
    //
    public $servLc;
    public $cidPadr; //Cidade e estado onde esta o cliente para padrao no cadastro novo
    public $estPadr;
    protected $fusoHora;
    protected $bdRaiz;
    protected $dirRamo; //Diretorio Ramo
    protected $dirRaiz; //Diretorio Raiz
    protected $logCliente; // se TRUE libera logon para cliente
    //
    protected $gravaSQL;
    protected $gravaUlt;
    protected $gravaRegLog;
    private $localBackup;
    private $localDocs;
    private $localFck;
    private $localFotos;
    public $pastaPHPMailer;
    //para emails
    private $smtpServer;
    private $smtpAuth;
    private $smtpUser;
    private $smtpPassword;
    private $smtpFrom;
    private $destEmail;
    //
    private $tituloPag;
    
    # para Estoque
    private $numEstq;
    
    function __construct() {
        //para servidor localhost
        $this->host = "localhost";
        $this->banco = "getarteste";
        #$this->usuario = "root";
        #$this->senhaBd = "sardo312";
        $this->usuario = "dbgetar";
        $this->senhaBd = "m@te1128";
        //
        $this->servLc= "TOBI";
        $this->cidPadr = "Sombrio";
        $this->estPadr = "Santa Catarina";
        $this->fusoHora = "0:00:00"; // ajuste de fuso horario (servidor em Portugal
        $this->bdRaiz = "";
        $this->dirRaiz = "";
        $this->dirRamo = "";
        $this->logCliente = FALSE;
        $this->logonBoasVindas= TRUE;# para o notebook ver TARF5602

        $this->tituloPag = ".: SAB Telecom- GETAR Testes :.";
        $this->gravaSQL = TRUE;
        $this->gravaRegLog = FALSE;
        #$this->localBackup = "http://tobi/SABTelecom/backup/"; // cuidar nos js_XXX.php
        $this->localBackup = "./DocsGetar/Backup/"; // cuidar nos js_XXX.php
        $this->localDocs = "http://tobi/SABTelecom/"; // cuidar nos js_XXX.php
        $this->localFck = "../getarsab/fckeditor266/";
        #$this->localFotos = "http://tobi/SABTelecom/fotos/";
        $this->localFotos = "./DocsGetar/Fotos/";
        $this->pastaPHPMailer = "../phpmailer/"; // cuidar nos js_XXX.php
        //para emails
        // Envio pelo servidor localhost
        $this->smtpServer = "mail.schw.com.br"; // SMTP servers
        $this->smtpAuth = FALSE; //Caso o servidor SMTP precise de autenticacao
        $this->smtpUser = "contato"; // SMTP username
        $this->smtpPassword = "salm37teca5"; // SMTP password
        $this->smtpFrom = "contato@schw.com.br"; // Nome de quem envia o email
        #$this->dest_email = "webmaster@schw.com.br"; // Destinatario de e-mail para avisos do gestor
        
        # estoque
        $this->numEstq= 1; # eletronica 2 Mecanica
    }

    public function get_LBVindas(){
        return $this->logonBoasVindas;
    }
    
    /**
     * Definido no __construct()
     * @param type $logonBoasVindas
     */
    public function set_servLc($serv){
        $this->servLc= $servLc;
    }
    
    public function get_servLc(){
        return $this->servLc;
    }

    public function set_LBVindas($logonBoasVindas){
        $this->logonBoasVindas= $logonBoasVindas;
    }

    public function get_gravaRegLog() {
        return $this->gravaRegLog;
    }

    public function set_gravaRegLog($gravaRegLog) {
        $this->gravaRegLog = $gravaRegLog;
    }

    public function get_fusoHora() {
        return $this->fusoHora;
    }

    public function set_fusoHora($fusoHora) {
        $this->fusoHora = $fusoHora;
    }

    public function get_cidPadr() {
        return $this->cidPadr;
    }

    public function set_cidPadr($cidPadr) {
        $this->cidPadr = $cidPadr;
    }

    public function get_estPadr() {
        return $this->estPadr;
    }

    public function set_estPadr($estPadr) {
        $this->estPadr = $estPadr;
    }

    function get_bdRaiz() {
        return $this->bdRaiz;
    }

    function set_bdRaiz($bdRaiz) {
        $this->bdRaiz = $bdRaiz;
    }

    public function get_dirRamo() {
        return $this->dirRamo;
    }

    public function set_dirRamo($dirRamo) {
        $this->dirRamo = $dirRamo;
    }

    public function get_dirRaiz() {
        return $this->dirRaiz;
    }

    public function set_dirRaiz($dirRaiz) {
        $this->dirRaiz = $dirRaiz;
    }

    public function get_logCliente() {
        return $this->logCliente;
    }

    public function set_logCliente($logCliente) {
        $this->logCliente = $logCliente;
    }

    public function get_gravaUlt() {
        return $this->gravaUlt;
    }

    public function set_gravaUlt($gravaUlt) {
        $this->gravaUlt = $gravaUlt;
    }

    public function get_pastaPHPMailer() {
        return $this->pastaPHPMailer;
    }

    public function set_pastaPHPMailer($pastaPHPMailer) {
        $this->pastaPHPMailer = $pastaPHPMailer;
    }

    /**
     * Local redefinido para gravacao dos arquivos de sincronismo
     * @param type $novo_local
     */
    public function set_localBackup($novo_local) {
        $this->localBackup = $novo_local;
    }

    /**
     * Local definido para gravacao dos arquivos de sincronismo
     * @return type
     */
    public function get_localBackup() {
        return $this->localBackup;
    }

    /**
     * local onde esta a documentacao
     * @return type
     */
    public function get_localDocs() {
        return $this->localDocs;
    }

    public function get_localFotos() {
        return $this->localFotos;
    }

    public function set_localFotos($localFotos) {
        $this->localFotos = $localFotos;
    }

    /**
     * local onde esta a documentacao
     * @param type $localDocs
     */
    public function set_localDocs($localDocs) {
        $this->localDocs = $localDocs;
    }

    function get_localFck() {
        return $this->localFck;
    }

    function set_localFck($localFck) {
        $this->localFck = $localFck;
    }
    
    /**
     * Titulo das pagina em PHP/HTML
     * @return type
     */
    public function get_tituloPag() {
        return $this->tituloPag;
    }

    public function set_tituloPag($titulo_pag) {
        $this->titulo_pag = $titulo_pag;
    }

    public function get_smtpServer() {
        return $this->smtpServer;
    }

    public function set_smtpServer($smtpServer) {
        $this->smtpServer = $smtpServer;
    }

    public function get_smtpAuth() {
        return $this->smtpAuth;
    }

    public function set_smtpAuth($smtpAuth) {
        $this->smtpAuth = $smtpAuth;
    }

    public function get_smtpUser() {
        return $this->smtpUser;
    }

    public function set_smtpUser($smtpUser) {
        $this->smtpUser = $smtpUser;
    }

    public function get_smtpPassword() {
        return $this->smtpPassword;
    }

    public function set_smtpPassword($smtpPassword) {
        $this->smtpPassword = $smtpPassword;
    }

    public function get_smtpFrom() {
        return $this->smtpFrom;
    }

    public function set_smtpFrom($smtpFrom) {
        $this->smtpFrom = $smtpFrom;
    }

    public function get_destEmail() {
        return $this->destEmail;
    }

    public function set_destEmail($destEmail) {
        $this->destEmail = $destEmail;
    }

    public function set_numEstq($numEstq){
        $this->numEstq=$numEstq;
    }
    
    public function get_numEstq(){
        return $this->numEstq;
    }
}

?>
