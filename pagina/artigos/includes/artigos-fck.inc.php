<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 9/06/2017
 * Descricao: arquivo complementar para edicao de artigos em FCKEditor
 * Revisoes:
 */

$dados = $artg->consArtgCh();
?>

<form id="artigo" action="index.php?st=artigos&pag=edit&codartg=<?php echo $artg->get_codArtg(); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="modelo" value="<?php echo $dados['modelo']; ?>">
    <fieldset id="formArtg">
        <legend>Editando um Artigo</legend>
        <fieldset>
            <legend>Cabe&ccedil;alho Artigo</legend>
            <label>Nome do artigo:</label>
            <input type="text" name="nome" value="<?php echo $dados['nome']; ?>" size="22" maxlength="20"><br>
            <i>(Sem espa&ccedil;os e caracteres especiais)</i><br>
            <label>Linha do Artigo: </label><?php echo $artg->selectLinha($dados['linha']); ?><br>
            <label>Data Criacao: </label><b><?php echo $dados['datacri']; ?></b><br>
            <label>Chamada:<br><b style="color: red;">***N&AtildeO USAR MAIS***<br>Passar o que tiver para a Intro</b></label>
            <textarea name="chamada" cols="50" rows="3"><?php echo $dados['chamada']; ?></textarea><br>
            <fieldset>
                <legend>Imagem Destaque</legend>
                <img src="<?php echo $artg->get_localFotos() . $dados['imagem']; ?>" alt="" style="width: 100px"><br>
                <!-- para limitar o tamanho do upload
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> -->
                <input type="file" name="arquivoCh">
                <input type="submit" name="gravaftch" value="Gravar Foto" onclick="exibeDiv('carregandoCh');">
                <div id="carregandoCh" align="center" style=" width:200px; height:150px; vertical-align:middle; display:none">    
                    <img src="imagens/enviando.gif" alt="" /><br />    
                    Enviando sua Foto Aguarde!
                </div>
            </fieldset>
            <label>Situa&ccedil;&atilde;o: </label>
            <select name="situacao">
                <option value="ativo" <?php echo selectedIf($dados['situacao'], "ativo"); ?>> ativo</option>
                <option value="inativo" <?php echo selectedIf($dados['situacao'], "inativo"); ?>> inativo</option>
            </select><br />
        </fieldset>
        <fieldset><legend>Corpo do Artigo</legend>
            <?php
            $dadosTxt = $artg->consTexto();
            ?>
            <label>Titulo:</label>
            <input name="titulo" type="text" value="<?php echo $dadosTxt['titulo']; ?>" size="62" maxlength="60"><br>
            <label>Introdu&ccedil;&atilde;o: </label>
            <textarea name="intro" cols="30" rows="10"><?php echo $artg->devolve_texto($dadosTxt['intro']); ?></textarea><br>
            <label>Texto:</label>

            <?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
//$sBasePath = $_SERVER['PHP_SELF'] ;
//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;

            $oFCKeditor = new FCKeditor('texto');
//$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", "Basic");
//$oFCKeditor->ToolbarSet = 'Basic';
//$oFCKeditor->BasePath	= $sBasePath ;
//$oFCKeditor->BasePath = '../fckeditor/';
            $oFCKeditor->BasePath = $pastaFCK;
            $oFCKeditor->Value = $artg->devolve_texto($dadosTxt['texto']);
            $oFCKeditor->Create();

            echo "<br />";

            if (isset($artg->msg)) {
                ?>
                <b style="color: red">Cabe&ccedil;alho - </b><?php echo $artg->msg; ?><br>
                <b style="color: red">Parte Texto - </b><?php echo $artg->msgTxt; ?>
                <?php
            }
            ?>
            <label>Fonte: </label>
            <input name="fonte" type="text" value="<?php echo $artg->get_fonte(); ?>" size="102" maxlength="100"><br>
            <label>&nbsp;</label><input type="submit" name="salvarartg" value="Salvar">
        </fieldset>
    </fieldset>
</form>