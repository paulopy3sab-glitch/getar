<?php
/*
 * Para edição do cadastro de clientes
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 05/08/2024
 */
?>
<form name="formCadastro" action="index.php?st=cadastro&pag=edit&codcad=<?php echo $cad->get_codCad(); ?>" method="post" onSubmit="return validaForm();">
    <input name="cod" type="hidden" value="<?php echo $cad->get_codCad(); ?>">
    <fieldset>
        <legend>Dados Cadastrais</legend>
        <fieldset>
            <legend>Campos Pr&oacute;pios</legend>
            <label>C&oacute;digo :</label><b><?php echo $cad->get_codCad(); ?></b><br>
            <label>Nome:</label>
            <input name="nome" type="text" size="42" maxlength="120" value="<?php echo $dados['nome']; ?>" autofocus><br>
            <label>Cliente desde: </label><?php echo $cad->selectData("_desde", $dados['dia_desde'], $dados['mes_desde'], $dados['ano_desde']); ?><br />
            <?php
            if (($dados['dia_desde'] == "01") && ($dados['mes_desde'] == "01") && ($dados['ano_desde'] == "2001")) {
                ?>
                <label>&nbsp;</label><small><i style="color: blue;">01/Janeiro/2001 &eacute a data padr&atilde;o</i></small><br />
                <?php
            }
            ?>
            <label>Contato: </label>
            <input name="cont" type="text" id="cont" value="<?php echo $dados['contato']; ?>" size="22" maxlength="20"><br>
            <?php
            if ($cad->atrib("2")) {// evita que outros alterem as classificacoes So exibir a lista para os administradores
                ?>
                <label> Classifica&ccedil;&atilde;o:</label>
                <?php echo $cad->selectClasf($dados['clasf']); ?><br />
                <?php
            } else {
                ?>
                <input name="clasf" type="hidden" value="<?php echo $dados['clasf']; ?>">
                <?php
            }

            if ($cad->get_msgPart() <> "") {
                echo $cad->get_msgPart();
            }
            if (($dados['clasf'] <> "g") && (atrib("2"))) {
                $displayEmailCorp = " ";
            } else {
                $displayEmailCorp = " display: none;";
            }
            ?>
            <div id="adminEmailCorp" style="<?php echo $displayEmailCorp; ?>">
                <label>E-mail Corporativo: </label>
                <input name="emailcorp" type="text" value="<?php echo $dados['emailcorp']; ?>" size="22" maxlength="20"><br>
                <small><i style="color: blue;">E-mail para receber mensagens do Getar.<br> Necesita de logon ativo, contate administrador do sistema.</i></small><br>
            </div>
            <?php
            // Validar CPF
            $msgCPCN = "";
            if ($dados['cpcn'] <> "") {
                if (!$cad->validaCPF($dados['cpcn'])) {
                    $msgCPCN = "<b style=\"color: red;\">CPF inv&aacute;lido</b>";
                }
            }

            $msgCNPJ = "";
            if ($dados['cnpj'] <> "") {
                if (!$cad->validaCNPJ($dados['cnpj'])) {
                    $msgCNPJ = "<b style=\"color: red;\">CNPJ inv&aacute;lido</b>";
                }
            }
            ?>
            <label>Ins. Estadual: </label><input name="ie" type="text" value="<?php echo $dados['ie']; ?>" size="22" maxlength="20"><br>
            <label>CPF: <?php echo $msgCPCN; ?></label><input name="cpcn" type="text" value="<?php echo $dados['cpcn']; ?>" size="22" maxlength="20"><br>
            <label>CNPJ: <?php echo $msgCNPJ; ?></label><input name="cnpj" type="text" value="<?php echo $dados['cnpj']; ?>" size="22" maxlength="20"><br>

            <label>Nascimento: </label><?php echo $cad->selectData("_nasc", $dados['dia_nasc'], $dados['mes_nasc'], $dados['ano_nasc']); ?><br />
            <?php
            if (($dados['dia_nasc'] == "01") && ($dados['mes_nasc'] == "01") && ($dados['ano_nasc'] == "2001")) {
                ?>
                <label>&nbsp;</label><small><i style="color: blue;">01/Janeiro/2001 &eacute a data padr&atilde;o</i></small><br />
                <?php
            }
            ?>
        </fieldset>
        <fieldset>
            <legend>Endere&ccedil;amento</legend>
            <label>Endere&ccedil;o: </label><input name="endr" type="text" value="<?php echo $dados['endr']; ?>" size="42" maxlength="40"><br>
            <label>N&uacute;mero: </label><input name="numero" type="text" value="<?php echo $dados['numero']; ?>" size="10" maxlength="8"><br>
            <label>Complemento: </label><input name="complemento" type="text" value="<?php echo $dados['complemento']; ?>" size="42" maxlength="62"><br>
            <label>Bairro: </label><input name="bairro" type="text" value="<?php echo $dados['bairro']; ?>"><br>
            <label>CEP.: <?php echo $cad->get_msgCEP(); ?></label><input name="cep" type="text" size="10" maxlength="9" value="<?php echo $dados['cep']; ?>"><br>
            <label>Cidade: </label><input name="cidade" type="text" size="22" maxlength="40" value="<?php echo $dados['cidade']; ?>"><br>
            <label>Estado: </label>
                <div id="divEstado">
                    <?php echo $cad->selectEstadosNv($dados['codestado'], $dados['codpais']); ?><br>
                </div>
            <label>Pa&iacute;s: </label><?php echo $cad->selectPaisNv($dados['codpais']); ?><br>
        </fieldset>
        <fieldset>
            <legend>O Registro</legend>
            <label>Situa&ccedil;&atilde;o: </label>
            <select name="situacao">
                <option value="ativo" <?php echo $cad->selectedIf($dados['situacao'], "ativo"); ?>>ativo</option>
                <option value="inativo" <?php echo $cad->selectedIf($dados['situacao'], "inativo"); ?>>inativo</option>
            </select><br>
            <label>&nbsp;</label><input type='submit' name='salvarCad' value='Atualizar'><br>
            <?php echo $cad->get_msg(); ?>
        </fieldset>
    </fieldset>
</form>
<?php
if (!$cadNovo) {
    echo $cad->ingressoLibera();
    include './pagina/cadastros/includes/cad_comple.inc.php';
}
?>

