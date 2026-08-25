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
            $sep = date('dH');
            $usuario = "clientea";
            $usuarioRev = strrev($usuario);
            $senha = "*EDA3881CA744F437C7C6CBC3E40C574BFE660FD3";
            $senhaRev = strrev($senha);
            $str = $usuarioRev . $sep . $senhaRev;
            echo $str;
            echo "<br />";
            list($usuarioRet, $senhaRet) = (explode($sep, $str));
            echo "Usuario: " . strrev($usuarioRet);
            echo "<br />";
            echo "Senha Encripto: " . strrev($senhaRet);
            ?>
        </pre>
    </body>
</html>