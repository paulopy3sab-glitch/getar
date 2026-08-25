<?php ?>
<html>
    <head>
        <title>Conexao PDO</title>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->

        <meta charset="utf-8" >
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    </head>

    <body>
        <?php
        try {
            //$opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');  
            $conn = new PDO('mysql:host=localhost; dbname=getarschw; charset=utf8', 'root', 'sardo312');
            /**
             * fonte:
             * http://www.devmedia.com.br/php-pdo-como-se-conectar-ao-banco-de-dados/37211
             * http://www.devwilliam.com.br/php/configurando-uma-conexao-com-mysql-utilizando-pdo-no-php
             * 
             */
   
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $conn->prepare('SELECT * FROM getar_projetos WHERE cod = 72');
            $stmt->execute(array('cod' => 72));

            $result = $stmt->fetchAll();

            if (count($result)) {

                foreach ($result as $row) {
                    //print_r($row);
                    echo $row['nome'] . "<br />";
                    echo $row['descr'] . "<br />";
                }
            } else {
                echo "Nenhum resultado retornado.";
            }
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        ?>
    </body>
</html>