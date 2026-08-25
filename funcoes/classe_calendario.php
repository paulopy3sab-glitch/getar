<?php

/**
 * Para gerar um calendario
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Fonte: https://www.vivaolinux.com.br/script/Classe-para-gerar-calendario-em-PHP/
 * Autor: Edvaldo Silva de Almeitda Junior
 * 
 * Revisoes:
 */
class Calendario{

    public $dia;
    public $mes;
    public $ano;
    public $tstamp;
    public $dtmanip;
    public $dsprimdia;
    public $linhafechada;
    //
    public $arrayDia;

    public function __construct($pmes, $pano) {
        $this->linhafechada = true;
        $this->dia = 1;
        $this->mes= $pmes;
        $this->ano= $pano;
        $this->calcula_tstamp();
        $this->data_manipulavel();
        $this->primeiro_dia_mes();
        $this->montaArrayDia();
    }
    
    public function recal($pmes, $pano) {
        $this->linhafechada = true;
        $this->dia = 1;
        $this->mes= $pmes;
        $this->ano= $pano;
        $this->calcula_tstamp();
        $this->data_manipulavel();
        $this->primeiro_dia_mes();
        $this->montaArrayDia();
        
    }


    public function get_dia() {
        return $this->dia;
    }

    public function set_dia($dia) {
        $this->dia = $dia;
    }

    public function get_mes() {
        return $this->mes;
    }

    public function set_mes($mes) {
        $this->mes = $mes;
    }

    public function get_ano() {
        return $this->ano;
    }

    public function set_ano($ano) {
        $this->ano = $ano;
    }

    public function get_tstamp() {
        return $this->tstamp;
    }

    public function set_tstamp($tstamp) {
        $this->tstamp = $tstamp;
    }

    public function get_dtmanip() {
        return $this->dtmanip;
    }

    public function set_dtmanip($dtmanip) {
        $this->dtmanip = $dtmanip;
    }

    public function get_dsprimdia() {
        return $this->dsprimdia;
    }

    public function set_dsprimdia($dsprimdia) {
        $this->dsprimdia = $dsprimdia;
    }

    public function get_linhafechada() {
        return $this->linhafechada;
    }

    public function set_linhafechada($linhafechada) {
        $this->linhafechada = $linhafechada;
    }
    
    public function calcula_tstamp() {
        $this->tstamp = mktime(0, 0, 0, $this->mes, $this->dia, $this->ano);
    }

    public function data_manipulavel() {
        $this->dtmanip = getdate($this->tstamp);
    }

    public function primeiro_dia_mes() {
        $this->dsprimdia = $this->dtmanip["wday"];
    }

    public function proximo_dia() {
        $this->dia++;
        $this->calcula_tstamp();
    }

    /**
     * gera calendario pelo mes e ano extanciado $pmes, $pano
     * @return string $str
     */
    public function exibe_calendario($capt) {
        $larg = 100.0 / 7.0;
        $str = "<table border='1' width='100%' cellpadding='0' cellspacing='0' align='center' bordercolor='#333333'>\n
                    <caption>" . $capt . "</caption>
                    <thead>
                <tr class='titulotabela'>\n
                    <th width='" . $larg . "%'>Dom</td>\n
                    <th width='" . $larg . "%'>Seg</td>\n
                    <th width='" . $larg . "%'>Ter</td>\n
                    <th width='" . $larg . "%'>Qua</td>\n
                    <th width='" . $larg . "%'>Qui</td>\n
                    <th width='" . $larg . "%'>Sex</td>\n
                    <th width='" . $larg . "%'>Sab</td>\n
                </tr>\n
                </thead>\n
                <tbody id=\"calendario\">\n";

        $ccol = 0;
        $casa = 0;
        while (checkdate($this->mes, $this->dia, $this->ano)) {
            if ($this->linhafechada) {
                $str.= "<tr>\n";
                $this->linhafechada = false;
            }
            if ($casa < $this->dsprimdia) {//preenche o inicio do mes com vazios
                $str.= "<td height=\"82px\">&nbsp;</td>\n";
            } else {
                $dom= "";
                if($ccol==0){
                    $dom= "class=\"domingo\"";
                }
                if($ccol==6){
                    $dom= "class=\"sabado\"";
                }
                $str.= "<td ".$dom." height=\"82px\" valign=\"top\">\n" . $this->dia . "<br />\n";
                if($this->dia < 10){
                    $indexDia="0".$this->dia;
                }else{
                    $indexDia="".$this->dia;
                }
                $str.= $this->arrayDia[$indexDia];
                $str.= "</td>\n";
                $this->proximo_dia();
            }
            $ccol++;
            $ccol = $ccol % 7;
            $casa++;
            if (( $casa % 7 ) == 0) {
                $str.= "</tr>\n";
                $this->linhafecha = true;
            }
        }
        //Fechando o mes com celular vazias
        while ($ccol != 0) {
            $ccol++;
            $ccol = $ccol % 7;
            $str.= "<td> </td>\n";
        }
        $str.= "</tr>\n</tbody>\n</table>\n";

        return $str;
    }

    /**
     * Versao mobile
     * @param type $capt
     * @return string
     */
    public function m_exibe_calendario($capt) {

        $str = "<table id=\"calend\" border='1' width='100%' cellpadding='0' cellspacing='0' align='center' bordercolor='#333333'>\n
                    <caption>" . $capt . "</caption>
                    <thead>
                    <tr class='titulotabela'>\n
                        <th>Dom</td>\n
                        <th>Seg</td>\n
                        <th>Ter</td>\n
                        <th>Qua</td>\n
                        <th>Qui</td>\n
                        <th>Sex</td>\n
                        <th>Sab</td>\n
                    </tr>\n
                    </thead>\n
                    <tbody>\n";

        $ccol = 0;
        $casa = 0;
        while (checkdate($this->mes, $this->dia, $this->ano)) {
            if ($this->linhafechada) {
                $str.= "<tr>\n";
                $this->linhafechada = false;
            }
            if ($casa < $this->dsprimdia) {
                $str.= "<td>&nbsp;</td>\n";
            } else {
                $str.= "<td valign=\"top\">\n" . $this->dia . "<br />\n";
                if($this->dia < 10){
                    $indexDia="0".$this->dia;
                }else{
                    $indexDia="".$this->dia;
                }
                $str.= $this->arrayDia[$indexDia];
                $str.= "</td>\n";
                $this->proximo_dia();
            }
            $ccol++;
            $ccol = $ccol % 7;
            $casa++;
            if (( $casa % 7 ) == 0) {
                $str.= "</tr>\n";
                $this->linhafecha = true;
            }
        }
        while ($ccol != 0) {
            $ccol++;
            $ccol = $ccol % 7;
            $str.= "<td> </td>\n";
        }
        $str.= "</tr>\n</tbody>\n</table>\n";

        return $str;
    }

    public function montaArrayDia(){
        $this->arrayDia["01"]= "";
        $this->arrayDia["02"]= "";
        $this->arrayDia["03"]= "";
        $this->arrayDia["04"]= "";
        $this->arrayDia["05"]= "";
        $this->arrayDia["06"]= "";
        $this->arrayDia["07"]= "";
        $this->arrayDia["08"]= "";
        $this->arrayDia["09"]= "";
        $this->arrayDia["10"]= "";
        $this->arrayDia["11"]= "";
        $this->arrayDia["12"]= "";
        $this->arrayDia["13"]= "";
        $this->arrayDia["14"]= "";
        $this->arrayDia["15"]= "";
        $this->arrayDia["16"]= "";
        $this->arrayDia["17"]= "";
        $this->arrayDia["18"]= "";
        $this->arrayDia["19"]= "";
        $this->arrayDia["20"]= "";
        $this->arrayDia["21"]= "";
        $this->arrayDia["22"]= "";
        $this->arrayDia["23"]= "";
        $this->arrayDia["24"]= "";
        $this->arrayDia["25"]= "";
        $this->arrayDia["26"]= "";
        $this->arrayDia["27"]= "";
        $this->arrayDia["28"]= "";
        $this->arrayDia["29"]= "";
        $this->arrayDia["30"]= "";
        $this->arrayDia["31"]= "";
    }

}

?>
