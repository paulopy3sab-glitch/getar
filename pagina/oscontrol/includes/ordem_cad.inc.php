<?php
/**
 * Aquivo auxiliar para edicão de uma OS
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * @date Indeterminada 
 * 06/07/2024
 * Remodelagem: informar que não exite a OS num XXX
 */
?>
<!-- edicao de uma OS -->
<form name="formulario" action="index.php?st=ordm&pag=edit&codos=<?php echo $codOS; ?>" method="post">
    <?php
    if ($OS->atrib("11")) {
        ?>
        <input type="hidden" name="acao" value="salvar">
        <input name="codeqp" type="hidden" value="<?php echo $codEqp; ?>">
        <input name="codos" type="hidden" value="<?php echo $codOS; ?>">
        <input name="codcli" type="hidden" value="<?php echo $dados['codcli']; ?>">
        <?php
    }
    ?>
    <fieldset>
        <legend>REGISTRO DA OS</legend>
        <label>Equipamento: </label><b><?php echo $dados['equipamento']; ?></b>
        <a href="index.php?st=eqp&pag=edit&codeqp=<?php echo $dados["codeqp"]; ?>">
            <img src="imagens/editar.gif" alt="" width="16" height="16" border="0">
        </a><br>
        <label>Outras OS do Equipamento: </label><b><?php echo $dados['osante']; ?></b><br />
        <label>OS C&oacute;digo: </label>
        <b>
            <?php
            echo $codOS;
            if ($dados['retorno']) {
                ?>
                <b style="color: red">RETORNO</b>
                <?php
            }
            ?>
        </b><br>
        <label>Cliente/Respons&aacute;vel:</label>
        <b><?php echo $dados['cliente']; ?></b>
        <a href="index.php?st=cadastro&pag=edit&codcad=<?php echo $dados["codcli"]; ?>" target="blank">
            <img src="imagens/editar.gif" alt="" width="16" height="16" border="0" />
        </a><img src="imagens/livro.gif" alt="" width="16" height="16" border="0" onclick="exibeCliProp();" /><br>
        <fieldset style="display: none;" id="clipprop">
            <legend>Trocando Cliente Proprietario</legend>
            <label>Codigo Cliente Responsavel:</label>
            <input name="codcli" type="text" value="<?php echo $dados["codcli"]; ?>"><br />
        </fieldset>
        <label>T&eacute;cnico: </label>
        <?php echo selectResp($dados['resp'], "11"); ?><br>
        <label>Data de entrada: </label><b><?php echo $dados['entd']; ?></b><br>
        <label>Data de In&iacute;cio: </label>
        <input type="date" name="dataini" size="20" value="<?php echo $dados['inicio']; ?>" /><br />
        <?php
        if ($dados["situ"] == "fechada") {
            if ($dados['diafcd'] == "00") {
                $consulta = "SELECT dataexec,
                                    DATE_FORMAT(dataexec, '%d') diafcd,
                                    DATE_FORMAT(dataexec, '%m') mesfcd,
                                    DATE_FORMAT(dataexec, '%Y') anofcd,
                                    dataexec
                               FROM ordem_tarf
                              WHERE codos=" . $codOS . "
                           ORDER BY dataexec DESC LIMIT 1 ";
                $dadosPesq = consultaSQL($consulta);
                $dados['diafcd'] = $dadosPesq['diafcd'];
                $dados['mesfcd'] = $dadosPesq['mesfcd'];
                $dados['anofcd'] = $dadosPesq['anofcd'];
                $dados['datafcd'] = $dadosPesq['dataexec'];
            }
            ?>
            <label>Data de fechamento: </label>
            <input type="date" name="datafcd" value="<?php echo $dados['datafcd']; ?>" />
            <br />
            <label>Data de sa&iacute;da: </label>
            <input type="date" name="saida" value="<?php echo $dados['saida']; ?>" /><br>
            <input name="fila" type="text" value="" hidden="">
            <?php
        } else {
            if ($dados["situ"] == "aberta") {
                include ("pagina/oscontrol/fila_os.inc.php");
            }
            ?>
            <input name="dia_fcd" type="text" value="00" hidden="">
            <input name="mes_fcd" type="text" value="00" hidden="">
            <input name="ano_fcd" type="text" value="00" hidden="">
            <input name="dia_sd" type="text" value="00" hidden="">
            <input name="mes_sd" type="text" value="00" hidden="">
            <input name="ano_sd" type="text" value="00" hidden="">
            <?php
        }
        ?>
        <label>Retorno: </label>
        <select name="retorno">
            <option value="0" <?php echo selectedIf($dados["retorno"], "0"); ?>>N&atilde;o</option>
            <option value="1" <?php echo selectedIf($dados["retorno"], "1"); ?>>Sim</option>
        </select><br />
        <label>Situa&ccedil;&atilde;o OS:</label>
        <select name="situ">
            <option value="aberta" <?php echo selectedIf($dados["situ"], "aberta"); ?>>aberta</option>
            <option value="espera" <?php echo selectedIf($dados["situ"], "espera"); ?>>espera</option>
            <option value="programada" <?php echo selectedIf($dados["situ"], "programada"); ?>>programada</option>
            <option value="cancelada" <?php echo selectedIf($dados["situ"], "cancelada"); ?>>cancelada</option>
            <option value="fechada" <?php echo selectedIf($dados["situ"], "fechada"); ?>>fechada</option>
        </select><br>
        <label>Situa&ccedil;&atilde;o do equipamento:</label>
        <select name="situequip">
            <option value="normal" <?php echo selectedIf($dados["situequip"], "normal"); ?>>normal</option>
            <option value="travado" <?php echo selectedIf($dados["situequip"], "travado"); ?>>travado</option>
            <!--<option value="sucata" <?php echo selectedIf($dados["situequip"], "sucata"); ?>>sucata</option>-->
        </select><b style="color: red;"><?php echo $dados['sucata']; ?></b><br>
        <label>&nbsp;</label><i style="color: blue">travado: j&aacute; com muitas horas trabalhadas</i><br />
        <label>Defeito reclamado: </label><textarea name="recla" cols="32" rows="5"><?php echo $dados["recla"]; ?></textarea><br>
        <label>Defeito encontrado: </label><textarea name="encr" cols="32" rows="5"><?php echo $dados["encr"]; ?></textarea><br>
        <label>Servico executado: </label><textarea name="serv" cols="32" rows="5"><?php echo $dados["serv"]; ?></textarea><br>        
        <label>Observa&ccedil;&atilde;o: </label><textarea name="texto" cols="80" rows="5"><?php echo ordemObs($codOS); ?></textarea><br>
        <?php
        echo $msgObs;
        echo extraiHashtag(ordemObs($codOS));
        ?><br>
        <label>Pagamento: </label>
        <select name="fatu">
            <option value="aberta" <?php echo selectedIf($dados["fatu"], "aberta"); ?>>em aberta</option>
            <option value="paga" <?php echo selectedIf($dados["fatu"], "paga"); ?>>paga</option>
            <option value="pagparc" <?php echo selectedIf($dados["fatu"], "pagparc"); ?>>paga parcial</option>
            <option value="naofatu" <?php echo selectedIf($dados["fatu"], "naofatu"); ?>>nao faturada</option>
        </select><br>
        <label>Valor pago:</label><input name="valcb" type="text" value="<?php echo $dados["valcb"]; ?>" size="12" maxlength="10"><br>
        <?php
        if ($OS->atrib("11")) {
            ?>
            <label>&nbsp;</label><input name="submit" type="submit" value="Editar"><br>
            <?php
        } else {
            ?>
            <label>&nbsp;</label><input name="submit" type="submit" value="Voltar"><br>
            <?php
        }
        if (isset($msg)) {
            echo $msg;
        }
        ?>
    </fieldset>
</form>

<fieldset>
    <legend>Estat&iacute;ticas da OS</legend>
    <span class="sub-titulo">Total horas trabalhadas: <?php echo $OS->tarfTotHora(); ?></span><br />
    <?php
    $maoObra = $OS->get_totHora() * $OS->valorCusto($dados['resp']);
    $maoObraFormt = formatarValorPadrao($maoObra, TRUE);
    ?>
    <span class="sub-titulo">Total M&atilde;o de Obra: <?php echo $maoObraFormt; ?></span><br />
    <i><a href="index.php?st=artigos&pag=leitura&codartg=249">Padrao #hashtag</a></i><br />
    <span class="sub-titulo">
        <?php echo hashtagList($codOS) ?>
    </span>
</fieldset>

<?php
# passar para um método
$consulta = "SELECT cod FROM estpedidocab WHERE tipo = 'venda' AND ospro = " . $codOS;
$resultado = mysqli_query($conexao, $consulta);
$dadosPesq = mysqli_fetch_assoc($resultado);
if ($dadosPesq['cod'] <> "") {
    # echo $est->pedidosLista($dadosPesq['cod']);
    echo pedidoLista($dadosPesq['cod']);
} else {
    ?>
    <a href="index.php?st=pedido&pag=ped_edit&codped=&codos=<?php echo $codOS; ?>" target="blank">
        <img src="imagens/novo.jpg" style="width: 32;" alt="Inserir Orcamento" title="Inserir Orcamento de componetes/pecas"/>
    </a>
    Inserir Or&ccedil;amento.
    <?php
}

/**
 * Gerenciando tarefas
 */
if ($codTarf <> "") {//re-edicao de tarefa
    echo tarfEdit($codTarf);
} elseif (isset($dados['codtarf'])) {//trabalhando a tarefa em andamento
    echo tarfEdit($dados['codtarf']);
} else {
    ?>
    <div id="opcoes" style="height: 62px;">
        <div id="elemento" style="height: 62px;">
            <a href="index.php?st=ordm&pag=edit&codos=<?php echo $codOS; ?>&tarnv=1" accesskey="n">
                <img src="imagens/arquivo.gif" alt="Tarefa Nova" style="width: 16px;" title="Criar uma tarefa nova"><br>
                Tarefa nova
            </a>
        </div>
        <div id="elemento" style="height: 62px;">
            <a href="impress.php?st=ordm&pag=detal&codos=<?php echo $codOS; ?>" target="_blank">
                <img src="imagens/impress.jpeg" alt="Imprimir OS" style="width: 16px;" title="Imprimir a OS"><br />
                Imprimir OS
            </a>
        </div>
        <div id="elemento" style="height: 62px;">
            <a href="impress.php?st=etiqueta&codos=<?php echo $codOS; ?>" target="_blank">
                <img src="imagens/impress.jpeg" alt="Imprimir OS" style="width: 16px;" title="Imprimir a OS"><br />
                Imprimir Etiquetas
            </a>
        </div>
        <div id="elemento" style="height: 62px;">
            <a href="impress.php?st=decla&codos=<?php echo $codOS; ?>" target="_blank">
                <img src="imagens/impress.jpeg" alt="Imprimir OS" style="width: 16px;" title="Imprimir a OS"><br />
                Declaracao Conte&uacute;do
            </a>
        </div>
        <div id="elemento" style="height: 62px;">
            <a href="impress.php?st=relatos&codos=<?php echo $codOS; ?>" target="_blank">
                <img src="imagens/impress.jpeg" alt="Relato OS" style="width: 16px;" title="Relatorio da OS"><br />
                Relatorio Acompanhamento.
            </a>
        </div>
    </div>
    <?php
}

echo "<div id=\"divTarfOS\">" . tarfList($codOS) . "</div>";
?>
<hr>
