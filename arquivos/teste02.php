<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Div flutuante centro da tela.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style>
            .move {
                z-index:100000;
                position:absolute;
                display:inline;
                padding: 0.5em;
                border:1px solid #000;
                cursor: -webkit-grabbing;
                background:#fff;
            }
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script>
            $(function() {
                $(".move").draggable();
            });
        </script>
    </head>
    <body>
        <!-- div móvel por belosonho --><br />
        <div class="move">
            <p>Textooo aqui</p>
        </div><br />
        <!-- div móvel por belosonho -->
    </body>
</html>