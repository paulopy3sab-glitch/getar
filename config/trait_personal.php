<?php

/*
 * Descricao: Conjunto de metodos personalizado para cliente
 * 
 * Data Criacao:
 * @date: Setembro/2016
 * Autor: Paulo Regis <paulo_schw@yahoo.com.br>
 * Revisoes:
 */

trait Tpersonal {

    /**
     * div para cabecalho personalizado ao lado do logo do GETAR
     * @return string $str
     */
    public function cabecalho($dir ="./") {
        # Usar banner no tamanhao aproximado de 80x400 px
        $str = "<img src=\"".$dir."imagens/LogoGetar-rt.png\" style=\"height: 82px;\" alt=\"Logo SAB Telecom\" />";

        return $str;
    }
    
    /**
     * div para cabecalho personalizado ao lado do logo do GETAR
     * @return string $str
     */
    public function mcabecalho($dir ="./") {
        $str = "<div style=\"padding-left: 68px;\">
                    <img src=\"".$dir."config/Logo-SAB Telecom-Qd-2019.png\" style=\"height: 82px;\" alt=\"Logo SAB Telecom\" />
                </div>";

        return $str;
    }
    
    /**
     * Logomarca principal do cliente
     * @return string $str
     */
    public function logoPrin(){
        $str= "<img src=\"config/Logo-SAB Telecom-Qd-2019.png\" style=\"height: 240px;\" alt=\"Logo SAB Telecom\"/>";
        
        return $str;
    }

    /**
     * Rodape personalizado
     * @return string
     */
     public function rodape() {
        $str = " <div id=\"rodape\">
                   <div id=\"designer\"> Programador Idealizador: Paulo Regis - Maio/2008. Vers&atilde;o 4.0.0: Janeiro/2025<br />
                   &Uacute;ltimo Backup: 17/01/2026</div>
                   <div id=\"contato\">" . $this->contato() . "</div>
               </div>";

        return $str;
    }    
    
    /**
     * Link dos contatos do site e ajuda do sistema
     */
    public function contato() {
        $str = "<a href=\"mailto:paulo_schw@yahoo.com.br\">paulo_schw@yahoo.com.br</a>";

        return $str;
    }

}

?>
