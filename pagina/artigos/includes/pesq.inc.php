<?php
/*
 * Para pesquisas nos artigos gravados
 * Data criacao:
 * @date 22/06/2024
 * @author Paulo Regis (paulo_schw@yahoo.com.br)
 * Implantado o sistema de tags, hashtag #
 */


?>
<form action="index.php?st=artigos&pag=listln&pagina=1" method="post">
    <fieldset>
        <legend>Listagem por linha de Artigo</legend>
        <label>Selecione linha:</label>
        <?php echo $artg->selectLinha($artg->get_linhaArtg()); ?><br />
        <label>&nbsp;</label>
        <input type="submit" name="lista" value="Listar" /><br />
        <div id="divLinha"></div>
    </fieldset>
</form>
<form action="index.php?st=artigos&pag=listpsqc&pagina=1" method="post">
    <fieldset>
        <legend>Pesquisa por string no conteudo</legend>
        <label>Pesquisar por:</label>
        <input type="text" name="string" value="" /><br />
        <label>&nbsp;</label>
        <input type="submit" name="pesq" value="Pesquisar" />
    </fieldset>
</form>
<form action="index.php?st=artigos&pag=listpsqt&pagina=1" method="post">
    <fieldset>
        <legend>Pesquisa por tag na intro</legend>
        <label>Pesquisar por:</label>
        <input type="text" name="string" value="" /><br />
        <label>&nbsp;</label>
        <input type="submit" name="pesq" value="Pesquisar" />
    </fieldset>
</form>
<b>LITAGEM DAS RASHTAG</b><br>
<?php
$consulta = "SELECT ch.cod,
                    rv.titulo,
                    rv.intro,
                    REGEXP_SUBSTR(rv.intro, '#[a-z]+') AS tag,
                    REGEXP_SUBSTR(rv.intro, '-[0-9]+') AS tagnum
               FROM getar_artgch ch,
                    getar_artg01 rv
              WHERE ch.cod= rv.codartg
                    AND rv.intro LIKE ('%#%')";
$resultado = retornoSQL($consulta);
while ($dados = arraySQL($resultado)) {
    echo "<a href=\"index.php?st=artigos&pag=edit&codartg=".$dados['cod']."\">
                    ".$dados['tag'].$dados['tagnum']."</a>&nbsp;";
    # contagem de hashtag
    $array = explode("#",$dados['intro']);
    $numArray= count($array)-1;
    if($numArray > 1){
        echo "<b style=\"color: red;\"> +".$numArray." tags #</b>";
    }
}
?>

    <div id="elemento">
        <a href="index.php?st=artigos&pag=novo_fck&linha=geral">
            <img src="imagens/editar.gif" alt="" border="0"><br>
            Novo Artigo
        </a>
    </div>
