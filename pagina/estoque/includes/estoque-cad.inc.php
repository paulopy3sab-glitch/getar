<?php
/**
 * Description:
 * Formulario para edicao dos dados de um produto
 * Optei por manter em HTML ao inves de chamar carregando um STR como nos modulos 
 * outro pois assim eh possivel carregar dicas e possiveis erros de HTML
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: em meados de 2014
 * Revision:
 * 19/11/2020: pregis
 *     trabalhando em POO
 */
//  Cadastro provissorio
if ($codestq == "") {
// Provissorios anteriores sao apagados somente durante o backup
//  Cria novo temporario
    $consulta = "INSERT INTO estoque (descr, und, catg, subcatg, situacao)
                      VALUES('Produto Novo', 'pc', 1, 1, 'temporario')";
    $codestq = executaIdSQL($consulta);
}

//  Para edicao
$consulta = "SELECT estq.cod,
                    estq.descr,
                    estq.descrtec,
                    estq.numest,
                    estq.nossonum,
                    estq.datasheet,
                    estq.fabr codfabr,
                    (SELECT nome FROM getar_cad WHERE cod=estq.fabr) fabr,# pode nao ter fabricante e nao amarrar o SELECT
                    estq.und,
                    estq.qtd qtd,
                    FORMAT(estq.qtd, 0) strQtd,
                    estq.qtdmin qtdmin,
                    FORMAT(estq.qtdmin, 0) strQtdMin,
                    estq.valorcusto,
                    FORMAT(estq.valorcusto, 2, 'de_DE') strValorCusto,
                    estq.valorvenda,
                    FORMAT(estq.valorvenda, 2, 'de_DE') strValorVenda,
                    estq.moeda,
                    estq.peso,
                    estq.local,
                    qd.etq quadra,
                    rua.etq rua,
                    estq.situacao,
                    estq.clasf,
                    estq.catg,
                    estq.subcatg,
                    (SELECT cb.cod pedido
                       FROM estpedidocab cb,
                            estpedidoitem it
                      WHERE cb.cod = it.codped
                            AND cb.tipo = 'compra'
                            AND it.codest = estq.cod
                            AND cb.situ NOT IN('cancelado')
                      ORDER BY cb.cod DESC
                      LIMIT 1) AS codpedido,
# Ultimo pedido recebido
(SELECT CONCAT ('Pedido PED', cb.cod,
            '(', (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn), ')'
            '| Valor de Custo= ', it.custo,
            '| Frete Agregado= ', (cb.vlfrete /(SELECT SUM(qt) numPecas FROM estpedidoitem itsoma WHERE itsoma.codped = cb.cod)))
            strPedRec
        FROM estpedidocab cb,
             estpedidoitem it
       WHERE cb.cod = it.codped
             AND cb.tipo = 'compra'
             AND it.codest = estq.cod
             AND cb.situ = 'recebido'
       ORDER BY cb.cod DESC
       LIMIT 1) strPedRec,
# 
# recebido ativo
(SELECT cb.cod strPedAtv
        FROM estpedidocab cb,
             estpedidoitem it
       WHERE cb.cod = it.codped
             AND cb.tipo = 'compra'
             AND it.codest = estq.cod
             AND cb.situ IN('processamento', 'espera', 'estudo', 'transito', 'pago')
       ORDER BY cb.cod DESC
       LIMIT 1) strPedAtv,
# 
                    (SELECT cb.cod pedido
                       FROM estpedidocab cb,
                            estpedidoitem it
                      WHERE cb.cod = it.codped
                            AND cb.tipo = 'compra'
                            AND it.codest = estq.cod
                            AND cb.situ NOT IN('cancelado')
                      ORDER BY cb.cod DESC
                      LIMIT 1) AS codpedido,
                      (SELECT obs.cod FROM estobs obs WHERE obs.codestq = estq.cod LIMIT 1) codobs,
                      (SELECT obs.texto FROM estobs obs WHERE obs.codestq = estq.cod LIMIT 1) txtobs,
                      (SELECT COUNT(*) FROM estobs obs WHERE obs.codestq = estq.cod) numcodobs
               FROM estoque estq,
                    estlocal loc,
                    estquadra qd,
                    estrua rua
              WHERE loc.cod = estq.`local`
                    AND qd.cod = loc.quadra
                    AND rua.cod = qd.codrua
                    AND estq.numest = " . $numest . "
                    AND estq.cod = " . $codestq;
$dados = consultaSQL($consulta);

if ($dados['cod'] <> $codestq) {
    echo "<b style=\"color: red\">Nenhum registro para o codigo " . $codestq . "</b>";
} else {
    ?>
    <fieldset>
        <legend>Dados do Produto ou Componente</legend>
        <form name="formCadastro" id="formCadastro" action='index.php?st=estoque&pag=edit&codestq=<?php echo $codestq ?>' method='post' onSubmit="return validaForm();" enctype="multipart/form-data">
            <fieldset>
                <legend>Dados Gerais</legend>
                <input name="cod" type="hidden" value="<?php echo $codestq; ?>">
                <?php $_SESSION['codest'] = $codestq; ?>
                <div>
                    <label>C&oacute;digo GETAR:</label>
                    <b style="background-color: white"><?php echo $codestq ?></b><br>
                    <i><div id="divDescr"></div></i>
                    <label>Descri&ccedil;&atilde;o:</label>
                    <input name='descr' type='text' autocomplete="off" size='42' maxlength='120' value='<?php echo $dados['descr']; ?>' onkeydown="atualDivDescr(this.value);" onclick="blqForn()"><br>
                    <i><div id="divFabr"></div></i>
                    <label for="fabr">Fabricante: </label>
                    <input name='fabr' id="inpfabr" type='text' autocomplete="off" disabled="" size='42' maxlength='120' value='<?php echo $dados['fabr']; ?>' onkeydown="atualDivFabr(this.value);">
                    <img src="imagens/cadeado-aberto.gif" onclick="atvDivFabr();" onmouseover=""><br>
                    <i><div id="divDescrTec"></div></i>
                    <label>Descr. T&eacute;nica:</label>
                    <input name='descrtec' type='text' size='42' maxlength='120' value='<?php echo $dados['descrtec']; ?>'  onkeydown="atualDivDescrTec(this.value);" onclick="blqForn()"><br>                    
                    <label>Estoque:</label>
                    <input name="numest" type="hidden" value="<?php echo $dados['numest']; ?>">
                    <b style="background-color: white"><?php echo $nomeest; ?></b><br>
                    <label>Nosso Num.:</label>
                    <input name="nossonum" type='text' size='22' maxlength='20' value="<?php echo $dados['nossonum']; ?>"><br />
                    <label>Categoria:</label>
                    <select name="catg" onchange="atualDivSubCateg(this.value);">
                        <?php
                        $consulta = "SELECT cod, descr FROM estcatg WHERE numest= " . $numest . " AND situacao = 'ativo' ORDER BY descr";
                        $resultado = retornoSQL($consulta);
                        while ($dadosSelect = arraySQL($resultado)) {
                            if ($dados['catg'] == $dadosSelect['cod']) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo '<option value="' . $dadosSelect['cod'] . '"' . $selected . '>' . $dadosSelect['descr'] . '</option>';
                        }
                        ?>
                    </select><br>
                    <label>Sub-categoria: </label>
                    <div id="divSubCateg">
                        <select name="subcatg" onclick="blqForn()">
                            <?php
                            $consulta = "SELECT cod, descr FROM estsubcatg WHERE codcatg = " . $dados['catg'] . " and situacao = 'ativo' ORDER BY descr";
                            $resultado = retornoSQL($consulta);
                            while ($dadosSelect = arraySQL($resultado)) {
                                if ($dados['subcatg'] == $dadosSelect['cod']) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo '<option value="' . $dadosSelect['cod'] . '" ' . $selected . '>' . $dadosSelect['descr'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <label for="foto">Foto Ilustrativa: </label>
                    <?php
                    # vendo se tem imagens ilustrativas
                    $consulta = "SELECT imagem FROM estoqueimg WHERE codestq= " .$dados['cod'];
                      $resultado = retornoSQL($consulta);
                      while ($dadosSelect = arraySQL($resultado)) {
                      ?>
                        <a href="<?php echo $pastaDocs; ?>imagens/<?php echo  $dadosSelect['imagem']; ?>" title="<?php echo  $dados['descr']; ?>" rel="shadowbox[galeria];"  style="background-image: url('<?php echo $pastaDocs; ?>imagens/<?php echo  $dadosSelect['imagem']; ?>');">
                            <img width="90" border="0" src="<?php echo $pastaDocs; ?>imagens/<?php echo $dadosSelect['imagem']; ?>" >
                        </a>
                    <?php
                      }
                    ?><br />
                    <label>&nbsp;</label>
                    <fieldset>
                        <legend>Imagem Ilustrativa</legend>
                        <!-- para limitar o tamanho do upload
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> -->
                        <input type="file" name="imagIlu">
                        
                        <div><?php echo $pastaDocs."imagens/" . $imagIlu; ?></div>
                    </fieldset>
                    <br />
                    <?php
                    if ($dados['datasheet'] <> "") {
                        ?>
                        <label for="datasheet">Datasheet: </label>
                        <a href="<?php echo $pastaDocs . "DataSheet/" . $dados['datasheet']; ?>" target="blank">
                            <img src="imagens/arquivo_pdf.png" width="83" height="90" alt="arquivo_pdf" title="<?php echo $dados['datasheet']; ?>"/>
                        </a>
                        <?php
                    }
                    ?><br>
                    <label>Arquivo Datasheet: </label>
                    <input name='datasheet' type='text' size='42' maxlength='60' value='<?php echo $dados['datasheet']; ?>' size="42" maxlength="40" onclick="blqForn()"><br><i><div id="divForn"></div></i>
                    <label for="forn">Fornecedor: </label>
                    <?php
                    $consulta = "SELECT cad.nome,
                                        forn.codforn
                                   FROM getar_cad cad,
                                        estoque est,
                                        fornecedor forn
                                  WHERE cad.cod = forn.codforn
                                        AND est.cod = forn.codestq
                                        AND est.cod = " . $dados['cod'] . "
                                        AND cad.situacao = 'ativo'";
                    $resultado = retornoSQL($consulta);
                    while ($dadosSelect = arraySQL($resultado)) {
                        echo " <b>" . $dadosSelect['nome'] . "</b>";
                        ?>
                        <a href="index.php?st=estoque&pag=excforn&codestq=<?php echo $codestq; ?>&codforn=<?php echo $dadosSelect['codforn']; ?>">
                            <img src="imagens/desativar.gif" width="16" height="16" alt="Exclui este fornecedor" />
                        </a>                    
                        <?php
                    }
                    ?>
                    <br />
                    <i><div id="divForn"></div></i>
                    <label for="fornNv">Acrescente Fornecedor</label>
                    <input name='forn' id="inpforn" type='text' autocomplete="off" disabled="" size='42' maxlength='120' value="" onkeydown="atualDivForn(this.value);">
                    <img src="imagens/cadeado-aberto.gif" onclick="atvDivForn();" onmouseover=""><br>
                    <label for="qtd">Quantidade: </label>
                    <?php
                    if (($dados['und'] == "pc") || ($dados['und'] == "und")) {
                        $strQtd = $dados['strQtd'];
                    } else {
                        $strQtd = $dados['qtd'];
                    }
                    ?>
                    <input name='qtd' type='text' id="qtd" size='7' maxlength='6' value='<?php echo $strQtd; ?>' onclick="blqForn()"><br>
                    <label for="qtdmin">Quantidade m&iacute;mina: </label>
                    <?php
                    if (($dados['und'] == "pc") || ($dados['und'] == "und")) {
                        $strQtd = $dados['strQtdMin'];
                    } else {
                        $strQtd = $dados['qtdmin'];
                    }
                    ?>
                    <input name='qtdmin' type='text' id="qtdMin" size='7' maxlength='6' value='<?php echo $strQtd; ?>' onclick="blqForn()"><br>
                    <i>Zerando quantidade m&iacute;nima n&atilde;o haver&aacute; pedido.</i><br />
                    <label>Unidade: </label>
                    <select name="und" onclick="blqForn()">
                        <option value="m" <?php echo selectedIf($dados['und'], "m"); ?>> m</option>
                        <option value="cm2" <?php echo selectedIf($dados['und'], "cm2"); ?>> cm2</option>
                        <option value="ml" <?php echo selectedIf($dados['und'], "ml"); ?>> ml</option>
                        <option value="pc" <?php echo selectedIf($dados['und'], "pc"); ?>> pc</option>
                        <option value="und" <?php echo selectedIf($dados['und'], "und"); ?>> und</option>
                        <option value="Kg" <?php echo selectedIf($dados['und'], "Kg"); ?>> Kg</option>
                    </select><br>
                    <label>Classifica&ccedil;&atilde;o: </label>
                    <select name="clasf" onclick="blqForn();">
                        <option value="novo" <?php echo selectedIf($dados['clasf'], "novo"); ?>> novo</option>
                        <option value="usado" <?php echo selectedIf($dados['clasf'], "usado"); ?>> usado</option>
                        <option value="colec" <?php echo selectedIf($dados['clasf'], "colec"); ?>> colecionavel</option>
                        <option value="ne" <?php echo selectedIf("ne", $dados['clasf']); ?>>N&atilde;o Estocavel</option>
                    </select><br>
                    <label for="local">Box: </label>
                    <?php
                    $descrLocal = "";
                    #echo selectBox($dados['local'], $dados['catg'])
                    echo $est->selectBox($dados['local'], $dados['catg'])
                    ?>

                    <div id="divEtqLocal"><i style="color: blue; font-size: x-small"><?php echo $descrLocal; ?></i></div><br>
                    <label>Quadra:</label>
                    <b><?php echo $dados['quadra']; ?></b><br>
                    <label>Rua:</label>
                    <b><?php echo $dados['rua'] ?></b><br>
                    <fieldset>
                        <legend>Proje&ccedil;&atilde;o de Pre&ccedil;o</legend>
                        <?php
                        if ($dados['strPedRec'] <> "") {
                            ?>
                            <small class="txt"><?php echo $dados['strPedRec']; ?></small>
                            <a href="index.php?st=pedido&pag=ped_ldetal&codped=<?php echo $dados['codpedido']; ?>">
                                <img src="imagens/editar.gif" alt="" border="0">
                            </a><br />
                            <?php
                        }
                        if ($dados['strPedAtv'] <> "") {
                            if ($est->get_codEst() == "") {# ver TARF5491
                                echo "Aqui!!!";
                            } else {
                                echo $est->listPedAtv();
                            }
                        }
                        ?><br>
                        <label for="valorcusto">Valor custo: </label>
                        <?php
                        switch ($dados['moeda']) {
                            case 'Real':
                                echo "R$";
                                break;
                            case 'Dolar':
                                echo "USD$";
                                break;
                        }
                        ?>
                        <input name='valorcusto' type='text' size='9' maxlength='22' value='<?php echo formatarValorPadrao($dados['valorcusto']); ?>' onclick="blqForn();"><br>
                        <label for="valorvenda">Valor venda: </label>R$ 
                        <input name='valorvenda' type='text' size='9' maxlength='22' value='<?php echo formatarValorPadrao($dados['valorvenda']); ?>' onclick="blqForn();"><br>
                        <label for="moeda">Moeda: </label> 
                        <input name='moeda' type='text' size='9' maxlength='8' value='<?php echo $dados['moeda']; ?>' onclick="blqForn();"><br>
                        <label for="peso">Peso: </label>
                        <input name='peso' type='text' size='7' maxlength='6' value='<?php echo $dados['peso']; ?>' onclick="blqForn();"><br>
                    </fieldset>
                    <label for="situacao">Situa&ccedil;&atilde;o do registro:</label>
                    <select name="situacao" onclick="blqForn();">
                        <option value="normal" <?php echo selectedIf($dados['situacao'], "normal"); ?>> normal</option>
                        <option value="inativo" <?php echo selectedIf($dados['situacao'], "inativo"); ?>> inativo</option>
                    </select><br />

                </div>
            </fieldset>

            <?php
            if ($dados['numcodobs'] > 1) {
                ?>        
                <b style="color: red;">H&aacute; mais de uma (1) Observa&ccedil;&atilde;o para este Produto!!!</b>
                <?php
            }
            ?>

            <fieldset>
                <legend>Observa&ccedil;&otilde;es para o Produto</legend>                
                <div>
                    <?php
                    $consulta = "SELECT cod, texto FROM estobs WHERE codestq =" . $dados['cod'];
                    $dadosPesq = consultaSQL($consulta);
                    ?>
                    <input type="hidden" name="codEstq" value="<?php echo $dados['cod']; ?>" />
                    <input type="hidden" name="codObs" value="<?php echo $dados['codobs']; ?>" />
                    <label for="texto">Observa&ccedil;&atilde;o: </label>
                    <textarea name="texto" cols="40" rows="5"><?php echo $dados['txtobs']; ?></textarea><br>
                    <label for="salvar">&nbsp;</label><input type="submit" name="salvarProd" value="Salvar" />
                    <div id="msgObs"></div>
                </div>
            </fieldset>
        </form>
        <?php
        # Inserir consumo deste produto em um pedidos de compra e Reposicao ou Venda/Consumo setado via _GET
        if (isset($_GET['inped'])) {
            $codPed = $_GET['inped'];
            $consulta = "SELECT ped.codforn,
                                ped.nomeped,
                                (SELECT nome FROM getar_cad WHERE cod= ped.codforn) nmforn,
                                (SELECT nome FROM getar_cad WHERE cod= ped.codcli) nmcli,
                                ped.codcli,
                                ped.tipo,
                                (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
                                   FROM getar_projetos pj,
                                        getar_pedidos pd
                                  WHERE pj.cod = pd.codproj
                                    AND pd.cod = ped.nmproj) projeto,
                                (SELECT CONCAT('<b>OS Numero: </b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                                   FROM ordem od,
                                        equipo eq
                                  WHERE od.cod = ped.ospro
                                        AND od.codeqp = eq.cod) equipo,
                                ped.situ
                           FROM estpedidocab ped
                          WHERE ped.cod =" . $codPed;
            $dadosPesq = consultaSQL($consulta);
            ?>

            <form name="formPed" id="formPed" action="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["cod"]; ?>" method="post">
                <fieldset>
                    <legend>INSERIR EM PEDIDO DE <?php echo $dadosPesq['tipo'] . "(" . $dadosPesq['nomeped'] . ")"; ?> N&Uacute;MERO:</b> <?php echo $codPed; ?></legend>
                    <input name="codped" type="hidden"  value="<?php echo $codPed; ?>">
                    <input name="codcli" type="hidden"  value="<?php echo $dadosPesq['codcli']; ?>">
                    <input name="codestq" type="hidden" value="<?php echo $dados["cod"]; ?>">        
                    <?php
                    if ($dadosPesq['tipo'] == "compra") {
                        echo "<b>Pedido: </b>" . $codPed . " - <b>Fornecedor: </b>" . $dadosPesq['nmforn'] . "<br>";
                    } elseif ($dadosPesq['tipo'] == "consumo") {
                        echo $dadosPesq['projeto'] . "<br>";
                    } else {
                        echo "<b>Cliente: </b>" . $dadosPesq['nmcli'] . "<br>";
                        echo $dadosPesq['equipo'] . "<br>";
                    }
                    ?>
                    Qt:<input name="qt" type="text" value=""  size="3" maxlength="4" autofocus="">                
                    Custo:<input name="custo" type="text" value="<?php echo $dados['valorvenda']; ?>"  size="5" maxlength="9">
                    <?php
                    if ($prodEsgotado == TRUE) {
                        echo "<select name=\"situ\">
                                <option value=\"\">Dispon&iacute;vel</option>
                                <option value=\"esg\">Esgotado</option>
                            </select>";
                    } else {
                        echo "<input name=\"situ\" type=\"text\" value=\"\" disabled=\"\" style=\"visibility: hidden\" />";
                    }
                    ?>
                    <input name="inserirItem" type="submit" value="Inserir">
                </fieldset>
            </form>
            <?php
        }
        ?>

        <div id="listPedAberto" class="txt">
            <?php
            echo $est->listPedAbt($dados['cod']);

            echo inserPedido($dados['cod']);

            echo listPedHist($dados['cod']);
            ?>
        </div>
        <!--REGISTRO DE RETIRADAS AVULSAS -->
        <form name="formRetira" id="formRetira" action="index.php?st=estoque&pag=edit&codestq=<?php echo $codestq ?>" method="post">
            <fieldset>
                <legend>REGISTRO DE RETIRADAS AVULSAS</legend>
                <input name="codEstq" type="hidden" value="<?php echo $dados['cod']; ?>">
                <input name="und" type="hidden" value="<?php echo $dados['und']; ?>">
                <input name="usuario" type="hidden" value="<?php echo $_SESSION['resp']; ?>">
                <label for="">Quantidade:</label>
                <input name="qtd" type="text" size='6' maxlength='6' ><br>
                <label for="motivo">Motivo:</label>
                <input name="motivo" type="text" size='60'><br>
                <i>Sem decri&ccedil;&atilde;o de motivo para a retirada n&atilde;o haver&aacute; resgistro.</i><br>
                <label for="enviarRetira">&nbsp;</label><input type="submit" name="enviarRetira" value="Registrar Retirada"><br>
                <?php
                if (isset($msgRetira)) {
                    echo $msgRetira;
                }
                ?>
            </fieldset>
        </form>

        <div id="divRetira" class="txt">
            &nbsp;
            <?php
            $sep = "<fieldset>
                        <legend>Retiradas Avulsas realizadas:</legend>";
            $consulta = "SELECT cod, DATE_FORMAT(dia, '%d/%m/%Y %h:%i') datahora, usuario, qtd, und, motivo FROM estretira WHERE codestq =" . $dados['cod'];
            $resultado = retornoSQL($consulta);
            while ($dadosSelect = arraySQL($resultado)) {
                echo $sep;
                echo $dadosSelect['datahora'] . " - " . $dadosSelect['usuario'] . " (" . $dadosSelect['qtd'] . " " . $dadosSelect['und'] . "): " . $dadosSelect['motivo'] . "<br>";
                $sep = "";
            }
            if ($sep == "") {
                echo "<br><i style=\"color: blue\">Havendo necessidade de editar/excluir retiradas entre em contato com o administrador. </i>
                    </fieldset>";
            }
            ?>
        </div>
    </fieldset>
    <?php
}
?>