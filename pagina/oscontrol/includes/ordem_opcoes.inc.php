<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 08/10/2024
 * Descricao: Rodape para as OSs
 * @date
 * 15/06/2024
 * @author
 * Paulo Regis
 * Revisoes:
 *
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=eqp&pag=novo">
            <img src="imagens/novo.jpg" alt="Equipamento Novo" style="width: 32px;" title="Cadastrar um equipamento novo"><br>
            Equipamento Novo
        </a>
    </div>
    <?php
    if ($codEqp <> "") {
        ?>
        <div id="elemento">
            <a href="index.php?st=ordm&pag=list_eqp&codeqp=<?php echo $codEqp ?>">
                <img src="imagens/livro.gif" alt="Listar OS" style="width: 32px;" title="Lista todas as OS deste equipemto"><br>
                Listar OS<br> 
                p/ Equipamento
            </a>
        </div>
        <?php
    }
    ?>
    <div id="elemento">
        <a href="index.php?st=ordm&pag=list">
            <img src="imagens/livro.gif" alt="Lista OS Abertas" style="width: 32px;" title="Lista OS ainda em aberto" accesskey="l"><br>
            Listar OS Abertas
        </a>
    </div>
    <div id="elemento" title="Atalho [shift]+[alt]+e">
        <form action="index.php?st=eqp&pag=pesq" method="post">
            <input type="hidden" name="pag" value="pesq">
            <input type="hidden" name="pagina" value="">
            <!--<img src="imagens/pesquisa1.gif" alt=""><br />-->
            Por Modelo <u style="color: blue">E</u>quipamento<br>
            <input name="string" type="text" size="12" maxlength="10" accesskey="e">
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
    <div id="elemento" title="Atalho [shift]+[alt]+p">
        <form action="index.php" method="get">
            <input type="hidden" name="st" value="ordm">
            <input type="hidden" name="pag" value="listprop">
            <!--<img src="imagens/pesquisa1.gif" alt=""><br />-->
            Por<br/> <u style="color: blue">P</u>ropriet&aacute;rio<br>
            <input name="strpesq" type="text" size="12" maxlength="10" accesskey="p">
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
    <div id="elemento" title="Atalho [shift]+[alt]+o">
        <form action="index.php" method="get">
            <input type="hidden" name="st" value="ordm">
            <input type="hidden" name="pag" value="edit">
            <!--<img src="imagens/pesquisa1.gif" alt=""><br />-->
            Por<br/> C&oacute;digo da <u style="color: blue">O</u>S<br>
            <input name="codos" type="number" size="12" maxlength="10" accesskey="o">
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
    <div id="elemento" title="Atalho [shift]+[alt]+t">
        <form action="index.php" method="get">
            <input type="hidden" name="st" value="ordm">
            <input type="hidden" name="pag" value="edit">
            <input type="hidden" name="codos" value="000">
            <!--<img src="imagens/pesquisa1.gif" alt=""><br />-->
            Por<br/> C&oacute;digo da <u style="color: blue">T</u>arefa<br>
            <input name="codtarf" type="number" size="12" maxlength="10" accesskey="t">
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
</div>
