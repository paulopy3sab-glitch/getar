<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 20/03/2025
 * Descricao: Opcoes de rodape para Artigos
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=artigos&pag=list&pagina=">
            <img src="imagens/lista.jpg" alt="" title="Listagem normal"><br>
            Listar
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=artigos&pag=list_u&pagina=">
            <img src="imagens/lista.jpg" alt="" title="Listagem por &Uacute;ltimos"><br>
            Listar &Uacute;ltimos
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=artigos&pag=novo_fck&linha=geral">
            <img src="imagens/editar.gif" alt="Criar um Artigo Novo" border="0"><br>
            Novo Artigo
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=artigos&pag=pesq">
            <img src="imagens/lista.jpg" alt="" title="Pesquisas"><br>
            Pesquisas e Hastegs
        </a>
    </div>
    <div id="elemento">
        <form action="index.php" method="get">
            <input type="hidden" name="st" value="artigos">
            <input type="hidden" name="pag" value="leitura">
            <img src="imagens/pesquisa1.gif" alt=""><br>
            <input name="codartg" type="text" size="12" maxlength="10" accesskey="c">
            <input name="Listar" type="submit" value="Por C&oacute;digo">
        </form>
    </div>
    <div id="elemento">
        <form action="index.php?st=artigos&pag=listpsqt&pagina=1" method="post">
            <img src="imagens/pesquisa1.gif" alt=""><br>
            <input type="text" name="string" value="" size="12" maxlength="10" accesskey="p" /><br />
            <input type="submit" name="pesq" value="Pesquisar na Intro" />
        </form>
</div>
    <div id="elemento" style="width: 100%;">
    <i><small>Para pesquisa por c&oacute;digo:[Shift] [Alt] [c]</small></i><br />
    <i><small>Para pesquisa na Intro:[Shift] [Alt] [p]</small></i>
    </div>
</div>