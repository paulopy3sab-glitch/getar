<?php ?>
<html>
    <head>
        <title>Teste Quebra String</title>
        <meta charset="utf-8" >
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    </head>

    <body>
    <pre>
        <?php
        $arrAtrib = "Avaliações<br>
#estudos xxx #testes";
        
        //$arrAtrib= "xx #estudos abce";
        # soh a primeira hashtag encontrada
        //echo strstr($arrAtrib, "#");
        $x= strstr($arrAtrib, "#");
        echo "<br/>";
        echo strstr($x, " ", TRUE)."-";
        echo "<br/>";
        
        # mais de uma hashtag
        /*$arrayTest= explode("#", $arrAtrib);
        foreach ($arrayTest as $value) {
            //if(!$value==""){
            echo "#".$value."+<br />";
            echo "#".strstr($value, " ")."*<br />";
            echo "#".strstr($value, " ", TRUE)."-<br />";
            //}
            //echo substr($value, 0, 1)."<br />";
        }*/
        
        ?>
    </pre>
    </body>
</html>