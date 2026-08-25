<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 21/04/2025
 * Descricao: Gerenciamento do custo hora de tecnicos e demais colaboradores
 */
?>
<form name="formCusto" id="formCusto" action="index.php?st=custos&pag=edit&codcad=<?php echo $codCad; ?>" method="post">
    <input type="hidden" name="nick" value="<?php echo $dados['nick']; ?>">    
    <fieldset>
        <legend>Custo Hora</legend>
        <label>Logon :</label><b><?php echo $dados['nick']; ?></b><br>
        <label>Colaborador :</label><b><?php echo $dados['nome']; ?></b><br>
        <label>Valor :</label><input name="custohora" type="text" size="12" maxlength="10" value="<?php echo $dados["custohora"]; ?>"><br>
        <label>&nbsp;</label><input type="submit" name="salvaCusto" value="Editar"><br>
    </fieldset>
</form>
<hr>