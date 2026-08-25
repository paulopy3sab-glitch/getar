<?php ?>
<html>
    <head>
        <title>Teste Formatar Numero</title>
        <meta charset="utf-8" >
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    </head>

    <body>
    <pre>
        <?php
        #$valor= "2.001.146,12";
        $valor= ",12";
        
        $valorNovo= "";
        $centavos= "00";
        if(mb_strpos($valor, ",") !== FALSE){
            $arrayValor= explode(",", $valor);
            /*echo $arrayValor[0];
            echo "<br />";*/
            $centavos= $arrayValor[1];
            $valorNovo= str_replace(".", "", $valor);
            echo "centavos= ".$centavos;
            echo "<br />";
        }
        /**$valor=number_format($valor, 2, '.', '');
        echo floatval($valor);
        echo "<br />";*/
        
        if($valorNovo !== ""){
            echo floatval($valorNovo).".".$centavos;
            echo "<br />";
        }  else {
           echo floatval($valor);
            echo "<br />";
        }
        echo "Valor original= ".$valor;
        ?>
    </pre>
    </body>
</html>