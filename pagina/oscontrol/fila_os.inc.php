<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 02/08/2023
 * Descricao: arquivo de apoio e simplificacao do cadastro de OS em fila
 * ####Revisoes: Junho/2016 - pregis
 */
if ($dados['fila'] == 0) {
    ?>
    <label>Tratar em Fila</label>
    <img src="imagens/livro.gif" alt="" width="16" height="16" border="0" onclick="exibeFilaOS();" /><br />
    <fieldset style="display: none;" id="filaos">
        <?php
    } else {
        echo "<fieldset>";
    }
    ?>

    <legend>Tratando OS em fila</legend>
    <label>N&uacute;mero na fila:</label><input name="fila" type="text" value="<?php echo $dados["fila"]; ?>" size="4" maxlength="5">
    <b style="background-color: white;">
        <?php
        if ($dados['fila'] != 0) {
            echo $dados["ord"] . "&ordm; na fila atual.";
        }
        echo "<i style=\"color: red;\">" . $msgFila . "</i>";
        ?>
    </b><br>
    <label>Proximo numero fila:</label><?php echo $dados['proxfila']; ?><br />
    <label>Ultima OS em fila</label>
    <?php
    $arrayProx = explode("-", $dados['osproxfila']);
    ?>
    <a href="index.php?st=ordm&pag=edit&codos=<?php echo $arrayProx[0]; ?>" target="blank">OS<?php echo $arrayProx[0]; ?></a>
    <?php echo " - " . $arrayProx[1]; ?>
    <br />
    <label>Fila atual:</label><img src="imagens/livro.gif" alt="" width="16" height="16" border="0" onclick="exibeFilaAtual();" />
    <fieldset  style="display: none;" id="filaatu">
        <?php
        $arrayLinha = explode(",", $dados['filaos']);
        foreach ($arrayLinha as $linha) {
            $arrayColuna = explode("-", $linha);
            echo "<label>&nbsp;</label>";
            ?>
            <a href="index.php?st=ordm&pag=edit&codos=<?php echo $arrayColuna[0]; ?>">OS<?php echo $arrayColuna[0]; ?></a>
            <?php
            echo "- Ord. Fila: " . $arrayColuna[1] . "- Data Ini.:" . $arrayColuna[2] . "<br />";
        }
        ?>
    </fieldset>
</fieldset>
