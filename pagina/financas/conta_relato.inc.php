<div>
    <fieldset>
        <legend>Relat&oacute;rios Pagamentos e Contas</legend>
        <!--
        <li><a href="index.php?st=contacarne&ft=fnc&pag=rlper">Relat&oacute;rio/Per&iacute;odo</a></li>                                
        <li><a href="index.php?st=contacarne&ft=fnc&pag=rlpag">Relat&oacute;rio/Pagas</a></li>
        -->
        <div id="elemento">
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
        </div>
    </fieldset>
</div>
<hr>
