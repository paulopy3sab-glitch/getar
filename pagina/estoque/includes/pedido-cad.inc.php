<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 27/11/2020
 * Descricao: Para criar e acompanhar os pedidos, compra, de consumo e venda
 * Revisoes:
 * 27/11/2020 - pregis
 *     formatacoes iniciais
 */

# 
if ($codPed == "") {
    if ($codPedProj == "" && $codOS == "") {
        $est->novoPed = TRUE;
        $consulta = "INSERT INTO estpedidocab (codforn, codcli, resp, tipo, dtped, situ)
                            VALUES(3, 3, '" . $_SESSION['resp'] . "', 'compra', CURDATE(), 'espera')";
        $codPed = executaIdSQL($consulta);
    }
    // Gerar um pedido de venda/orcamento vindo diretamente das OSs
    if ($codOS <> "") {
        $consulta = "INSERT INTO estpedidocab (codforn, codcli, resp, tipo, ospro, dtped, situ)
                            VALUES(3, (SELECT codcli FROM ordem WHERE cod= " . $codOS . "), '" . $_SESSION['resp'] . "', 'venda', " . $codOS . ", CURDATE(), 'espera')";
        $codPed = executaIdSQL($consulta);
    }

    // Gerar um pedido de consumo interno vindo diretamente do pedido eletronico
    if ($codPedProj <> "") {
        $consulta = "INSERT INTO estpedidocab (codforn, codcli, resp, tipo, nmproj, dtped, situ)
                            VALUES(3, 3, '" . $_SESSION['resp'] . "', 'consumo', " . $codPedProj . ", CURDATE(), 'espera')";
        $codPed = executaIdSQL($consulta);
    }
}

$_SESSION['codped'] = $codPed;
$_SESSION['codest'] = ""; // sinaliza que o js_forn.php vai mandar salvar forn do pedidos

$consulta = $est->pedidoEdit($codPed);
$dados = consultaSQL($consulta);
?>
<form action="index.php?st=pedido&pag=ped_edit&codped=<?php echo $codPed; ?>" method="post">
    <input name="codped" type="hidden" value="<?php echo $codPed; ?>">
    <input name="tipo" type="hidden" value="<?php echo $dados['tipo'] ?> ">
    <fieldset>
        <legend>Acompanhamento de um Pedido</legend>
        <label>Pedido n&uacute;mero:</label><b> <?php echo $codPed; ?> </b><br />
        <label>Tipo:</label><b><?php echo $dados['tipo']; ?></b><br />
        <?php
        if ($est->novoPed) {
            echo pedidoNovo($dados['tipo']);
        } else {
            if ($dados['tipo'] == "compra") {
                ?>
                <label>Fornecedor:</label><b><?php echo $dados['forn']; ?></b><br />
            <?php } else {
                ?>
                <label>Cliente:</label><b><?php echo $dados['cli']; ?></b><br />
                <?php
            }
        }
        ?>
        <label>Nome Pedido:</label><b>
        <input name="nomeped" type="tex" value="<?php echo $dados['nomeped']; ?>" size="22" maxlength="30"></b><br />
        <label>Data Pedido:</label><b><?php echo $dados['dtped']; ?></b><br />
        <?php
        if ($dados['situ'] == "transito" && $dados['tipo'] == "compra") {
            ?>
            <label>Data Previsao de chegada:</label> <?php echo selectData("cheg", $dados['diacheg'], $dados['mescheg'], $dados['anocheg']); ?> <br />
            <?php
        }
        if ($dados['situ'] == "recebido") {
            ?>
            <label>Data Recebimento:</label> <?php echo selectData("recb", $dados['diarecb'], $dados['mesrecb'], $dados['anorecb']); ?><br />
            <?php
        }
        
        if ($dados["tipo"] <> "consumo") {
            ?>
            <label>Rastreador:</label>
            <input name="rastr" type="tex" value="<?php echo $dados['rastr']; ?>" size="22" maxlength="120"><br />
            <label>Valor Frete:</label>
            <input name="vlfrete" type="tex" value="<?php echo$dados['vlfrete']; ?>" size="7" maxlength="6"><br />
            <label>Transportador:</label>
            <input name="empfrete" type="tex" value="<?php echo $dados['empfrete']; ?>" size="22" maxlength="120"><br />
            <?php
        }
        $msgRef = "Indefinido";
        if ($dados['tipo'] == "venda") {
            ?>
            <label>Ordem de Servi&ccedil;o vinculada:</label>
            <b><?php echo $dados["ospro"]; ?></b><br />
            <?php
            //Detalhar qual OS a que se refere
            $msgRef = $dados['detalos'];
        }
        if ($dados['tipo'] == "consumo") {
            //Detalhar qual pedido a que se refere
            $msgRef = $dados['detalpro'];
        }
        if ($dados['tipo'] == "compra") {
            echo "&nbsp";
        } else {
            ?>
            <label>&nbsp;</label><b><?php echo $msgRef; ?></b><br />
            <?php
        }
        ?>
        <input type="hidden" name="tipo" value="<?php echo $dados["tipo"]; ?>" />
        <input type="hidden" name="ospro" value="<?php echo $dados["ospro"]; ?>" />
        <label>Situa&ccedil;&atilde;o:</label>
        <select name="situ">
            <option value="processamento" <?php echo selectedIf("processamento", $dados['situ']); ?>>Em Processamento</option>
            <option value="espera" <?php echo selectedIf("espera", $dados['situ']); ?>>Espera</option>
            <option value="estudo" <?php echo selectedIf("estudo", $dados['situ']); ?>>Or&ccedil;amento</option>
            <option value="transito" <?php echo selectedIf("transito", $dados['situ']); ?>>Em transito</option>
            <?php if ($dados['tipo'] == "compra") { ?>
                <option value="pago" <?php echo selectedIf("pago", $dados['situ']); ?>>Pago</option>
                <option value="recebido" <?php echo selectedIf("recebido", $dados['situ']); ?>>Recebido</option>
                <?php
            }
            ?>
            <option value="finalizado" <?php echo selectedIf("finalizado", $dados['situ']); ?>>Finalizado</option>
            <option value="cancelado" <?php echo selectedIf("cancelado", $dados['situ']); ?>>Cancelado</option>
        </select><br />
        <label>&nbsp;</label><?php echo $msgAcop; ?><input type="submit" name="salvarAcop" value="Salvar"><br />
    </fieldset>
</form>
