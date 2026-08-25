<?php
/*
 * Para edição dos Equipamentos das OSs
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 10/07/2024
 */
?>
<form name="formulario" action="index.php?st=eqp&pag=edit&codeqp=<?php echo $OS->get_codEqp(); ?>" method="post">
    <input type="hidden" name="acao" value="salvar">
    <input name="codeqp" type="hidden" value="<?php echo $OS->get_codEqp(); ?>">
    <fieldset>
        <legend>Detalhes do Equipamento</legend>
        <label>C&oacute;digo Equipamento: </label><b><?php echo $OS->get_codEqp(); ?></b><br>
        <?php
        if ($tipo == "novo") {
            if ($OS->get_codCli() <> "") {
                $detal = $OS->clienteDetalRap($OS->get_codCli());
                ?>
                <input type="hidden" name="codcli" value="<?php echo $OS->get_codCli(); ?>" />
                <label>Cliente: </label><b><?php echo $detal['nome']; ?></b><br />
                <div id="dadosCli"><?php echo $detal['cidade'] . " - " . $detal['fone']; ?></div>
                <?php
            } else {
                echo $OS->clienteCadRap() . "<br />";
            }
        } else {
            $detal = $OS->clienteDetalRap($dados['codcli']);
            ?>
            <input type="hidden" name="codcli" value="<?php echo $dados['codcli']; ?>" />
            <label>Cliente Propriet&aacute;rio: </label><b><?php echo $dados['nome']; ?></b>
            <a href="index.php?st=cadastro&pag=edit&codcad=<?php echo $dados["codcli"]; ?>">
                <img src="imagens/editar.gif" alt="Editar" title="Editar este registro">
            </a><br />
            <div id="dadosCli"><?php echo $detal['cidade'] . " - " . $detal['fone']; ?></div>
            <?php
        }
        ?>
        <label>Descri&ccedil;&atilde;o: </label><input name="descr" type="text" value="<?php echo $dados['descr']; ?>" size="40" maxlength="60"><br>
        <label>Fabricante: </label><input name="marca" type="text" value="<?php echo $dados['marca']; ?>" size="40" maxlength="60"><br>
        <label>Modelo: </label><input name="modelo" type="text" value="<?php echo $dados['modelo']; ?>" size="22" maxlength="20"><br>
        <label>Serial: </label><input name="serial" type="text" value="<?php echo $dados['serial']; ?>" size=\"40\" maxlength=\"40\"><br>
        <label>Situacao: </label><?php echo $OS->selectSituEqp($dados['situ']); ?><br>
        <label>Registro Hist&oacute;rico: </label><?php echo $OS->selectHist($dados['hist']); ?><br>
        <?php
        $aviso = "";
        if ($dados['eqpobs'] == '') {
            $aviso = "N&atilde;o ainda Obs para este equipo.";
        }
        ?>
        <label>Observa&ccedil;&atilde;o: </label><textarea name="texto" cols="80" rows="5"><?php echo $dados['eqpobs']; ?></textarea><br>
        <label><i style="color: blue"><?php echo $aviso; ?></i></label><b>&nbsp;</b><br />
        <label>&nbsp;</label><input name="salvar" type="submit" value="Editar"><br>
        <?php echo $OS->get_msgEqp(); ?>
    </fieldset>
</form>
