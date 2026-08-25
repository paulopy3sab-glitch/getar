<?php

/**
 * Descricao: Conjunto de classes com metodos personalizado para cliente
 * 
 * Data Criacao: Janeiro/2017
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Revisoes
 */
class Pcadastro extends Cadastro {

    function __construct() {
        parent::__construct();
    }

    /**
     * Edita um cadatro de forma personalizada ou nao
     * @return string
     */
    public function cadEditPers() {
        $str = $this->cadEdit(); // para sem personalizacao

        return $str;
    }

    /**
     * Edita um cadatro de forma personalizada ou nao para versao mobile
     * @return string
     */
    public function mcadEditPers() {
        $str = $this->mcadEdit(); // para sem personalizacao

        return $str;
    }

}

?>
