<?php ?>
<html>
    <head>
        <title>Teste hash</title>
        <meta charset="utf-8" >
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    </head>

    <body>
        <pre>
            <?php
            $senhaAberta = "m!te1128";
            $senhaDoFormulario= "123mudar";
            echo $senhaAberta . "<br />";
            echo $senhaDoFormulario . "<br />";

            $senhaHash = password_hash($senhaAberta, PASSWORD_DEFAULT);
            #$senhaHash ='$2y$10$BS/ciby7ACQFdhZ2ijo6ve.DD9ZIx2byaJWSdAoQacUATnsD6IlNa';
            echo $senhaHash . "<br />";

            // Suponha que $senhaDoFormulario veio da requisição POST e $senhaHash veio do Banco de Dados
            if (password_verify($senhaDoFormulario, $senhaHash)) {
                echo "Login realizado com sucesso!";
            } else {
                echo "Senha incorreta.";
            }
            ?>
        </pre>
    </body>
</html>