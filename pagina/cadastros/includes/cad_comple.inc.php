<?php
/*
 * Para Listagem dos telefones, emails e sites do cadastro de clientes
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 07/08/2024
 */
?>

<fieldset>
    <legend>COMPLEMENTOS DO CONTATO: <?php echo $cad->cadNome(); ?></legend>
    <fieldset>
        <legend>Telefones</legend>
        <?php
//telefones
        $retorno = $cad->consFones();
        while ($dados = arraySQL($retorno)) {
            ?>
            <div class="txt">
                <?php echo $dados['descr'] . ": " . $dados['numero']; ?>
                <a href="index.php?st=cadastro&pag=fnedt&codcad=<?php echo $cad->get_codCad(); ?>&fnedt=<?php echo $dados['cod']; ?>">
                    <img src="imagens/editar.gif" alt="Editar" title="Editar este Telefone" style="height: 16px;">
                </a>
                <a href="index.php?st=cadastro&pag=fnexc&codcad=<?php echo $cad->get_codCad(); ?>&fnexc=<?php echo $dados['cod']; ?>">
                    <img src="imagens/lixo.gif" alt="Excluir" title="Excluir este telefone">
                </a><br>
            </div>
            <?php
        }
        echo $cad->get_msgFone();
        ?>
        <a href="index.php?st=cadastro&pag=fnedt&codcad=<?php echo $cad->get_codCad(); ?>&fnedt=">
            <img src="imagens/novo.jpg" alt="Novo" title="Novo Telefone">Adicionar telefone<br>
        </a>
    </fieldset>
    <fieldset>
        <legend>Emails</legend>
        <?php
//emails
        $retorno = $cad->consEmails();
        while ($dados = arraySQL($retorno)) {
            ?>
            <div class="txt">
                <?php echo $dados['descr']; ?>: <a href="mailto:<?php echo $dados['endr']; ?>"><?php echo $dados['endr']; ?></a>
                <a href="index.php?st=cadastro&pag=emedt&codcad=<?php echo $cad->get_codCad(); ?>&emedt=<?php echo $dados['cod']; ?>">
                    <img src="imagens/editar.gif" alt="Editar" title="Editar este Email" style="height: 16px;">
                </a>
                <a href="index.php?st=cadastro&pag=emexc&codcad=<?php echo $cad->get_codCad(); ?>&emexc=<?php echo $dados['cod']; ?>">
                    <img src="imagens/lixo.gif" alt="Excluir" title="Excluir este email">
                </a><br>
            </div>
            <?php
        }
        echo $cad->get_msgEmail();
        ?>
        <a href="index.php?st=cadastro&pag=emedt&codcad=<?php echo $cad->get_codCad(); ?>&emedt=">
            <img src="imagens/novo.jpg" alt="Novo" title="Novo Email">Adicionar email<br>
        </a>
    </fieldset>
    <fieldset>
        <legend>Site e Redes Sociais</legend>
        <?php
        //site e rede sociais
        $retorno = $cad->consSites();
        while ($dados = arraySQL($retorno)) {
            ?>
            <div class="txt">
                <?php echo $dados['descr']; ?>: <a href="<?php echo $dados['endr']; ?>" target="_blank"><?php echo $dados['endr']; ?></a>
                <a href="index.php?st=cadastro&pag=stedt&codcad=<?php echo $cad->get_codCad(); ?>&stedt=<?php echo $dados['cod']; ?>">
                    <img src="imagens/editar.gif" alt="Editar" title="Editar este Site" style="height: 16px;">
                </a>
                <a href="index.php?st=cadastro&pag=stexc&codcad=<?php echo $cad->get_codCad(); ?>&stexc=<?php echo $dados['cod']; ?>">
                    <img src="imagens/lixo.gif" alt="Excluir" title="Excluir este Site">
                </a><br>
            </div>
            <?php
        }
        echo $cad->get_msgSite();
        ?>
        <a href="index.php?st=cadastro&pag=stedt&codcad=<?php echo $cad->get_codCad(); ?>&stedt=">
            <img src="imagens/novo.jpg" alt="Novo" title="Novo Email">Adicionar Site
        </a><br>
    </fieldset>    
</fieldset>
