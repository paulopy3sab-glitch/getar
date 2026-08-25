<div>
    <fieldset>
        <legend>Programa&ccedil;&atilde;o e Relat&oacute;rios Estoque</legend>
        <div id="elemento">
            <a href="index.php?st=pedido&pag=list_compra">Listagem para Pedidos</a>
        </div>
        <div id="elemento">
            <a href="index.php?st=estoque&pag=balanco">Balan&ccedil;o totalizador</a>
        </div>
        <!--<div id="elemento">
            <form action="index.php?st=eqp&pag=pesq" method="post">
                <input type="hidden" name="pag" value="pesq">
                <input type="hidden" name="pagina" value="">
                Por Modelo Equipamento<br>
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            <input name="string" type="text" size="12" maxlength="10" accesskey="p">
                        </td>
                        <td>
                            <input name="Listar" type="submit" value="OK">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="elemento">
            <form action="index.php" method="get">
                <input type="hidden" name="st" value="ordm">
                <input type="hidden" name="pag" value="edit">
                Por C&oacute;digo OS<br>
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            <input name="codos" type="text" size="12" maxlength="10" accesskey="c">
                        </td>
                        <td>
                            <input name="Listar" type="submit" value="OK">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="elemento">
            <form action="index.php?st=ordm&pag=list_rlt" method="post">
                Fechadas por M&ecirc;s<br />
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            <label>Mes/Ano:</label>
                            <?php
                            echo selectData("Relato", "xx");
                            ?>
                        </td>
                        <td valign="top" align="center">
                            <input type="submit" name="Enviar" value="Enviar">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="elemento">
            <form action="index.php?st=ordm&pag=repro_os" method="post">
                <input type="hidden" name="repro_os" value="salvar">
                Reprogramar OSs<br />
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            Atual Mes/Ano:<br />
                            <?php
                            echo selectData("Atual");
                            ?>
                        </td>
                        <td valign="top">
                            Novo Mes/Ano:<br />
                            <?php
                            echo selectData("Novo");
                            ?>
                        </td>
                        <td valign="top" align="center">
                            <input type="submit" name="Enviar" value="Enviar">
                        </td>
                    </tr>
                </table>
            </form>
        </div>-->
    </fieldset>
    <fieldset>
        
    <div id="elemento">
        <form action="index.php?st=pedido&pag=list_compra" method="post">
            <img src="imagens/livro.gif" alt=""><br />
            Pedido Compra<br>
            <?php
            $consulta = "  SELECT DISTINCT cb.cod cod,
                        (SELECT SUBSTRING(nome, 1, 12) nome
                         FROM getar_cad
                         WHERE cod= cb.codforn) forn,
                         cb.situ
                    FROM estpedidocab cb,
                         estpedidoitem it
                   WHERE cb.cod = it.codped
                         AND cb.tipo = 'compra'
                         AND cb.situ IN('processamento', 'transito', 'espera', 'estudo');";
            $resultado = retornoSQL($consulta);

            while ($dados = arraySQL($resultado)) {
                echo  $dados['cod'] . "-" . $dados['cod'] . "-" . $dados['situ'] . "-" . $dados['forn']."<br />";
            }
            
            ?>
            
        </form>
    </div>
    </fieldset>
</div>
<hr>
