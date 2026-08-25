<?php
/*
 * Para Edicao dos Operacionais cadastrados
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 22/12/2024
 */

if ($codopera == "") {
    //Cria o temporario
    $consulta = "INSERT INTO getar_opera ( tag, nome, resp, datareg, descr, situacao)
                         VALUES('TM001', 'Operacional Novo', '" . $_SESSION['resp'] . "', CURDATE(), 'Descricao do projeto', 'temporario');";
    $codopera = executaIdSQL($consulta);
    //$codopera = get_idRet();
    $opr->set_codOpera($codopera);
    $opr->set_tag('TM001');
}

//  Carrega para edicao
$consulta = "SELECT cod,
                            tag,
                            clasf,
                            nome,
                            resp,
                            descr,
                            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
                            situacao
                       FROM getar_opera
                      WHERE cod= " . $codopera;
$resultado = retornoSQL($consulta);
$dados = arraySQL($resultado);
?>

<form name="formCadastro" id="formCadastro" action="index.php?st=opera&pag=edit&codopr=<?php echo $codopera; ?>" method="post">
    <input type="hidden" name="codopera" value="<?php echo $codopera; ?>">    
    <fieldset>
        <legend>Dados do Projeto</legend>
        <label>C&oacute;digo :</label><b><?php echo $codopera; ?></b><br>
        <label>Tag :</label><input name="tag" type="text" size="42" maxlength="40" value="<?php echo $dados["tag"]; ?>"><br>
        <label>Clasfica&ccedil;&atilde;o :</label><?php echo $opr->selectClasf($dados["clasf"]); ?><br>
        <label>Nome: </label><input name="nome" type="text" size="42" maxlength="40" value="<?php echo $dados["nome"]; ?>"><br>
        <label>Responsavel:</label>
        <?php echo $opr->selectResp($dados['resp'], 41); ?><br>
        <label>Descri&ccedil&atilde;o: </label><textarea name="descr" cols="40" rows="3"><?php echo $dados["descr"]; ?></textarea><br>
        <label>Data Registro: </label><b><?php echo $dados["datareg"]; ?></b><br>
        <label>Situa&ccedil;&atilde;o: </label><?php echo $opr->operSitu($dados['situacao']); ?><br>
        <label>&nbsp;</label><input type="submit" name="salvar" value="Salvar"><br>
        <?php //echo $opr->msg; ?>
    </fieldset>
</form>
<hr>



