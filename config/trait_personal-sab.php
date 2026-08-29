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
        $str = "<img src=\"".$dir."config/logo-SAB-banner 80x340.png\" style=\"height: 82px;\" alt=\"Logo SAB Telecom\" />";

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

}

?>
