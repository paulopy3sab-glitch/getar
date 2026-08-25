<?php
include './pagina/oscontrol/funcoes_os.php';
#include './pagina/oscontrol/funcoes_oscons.php';

$codOS = $_GET['codos'];

$consulta = "    SELECT cad.nome,
                        cad.cpcn,
                        cad.endr,
                        cad.bairro,
                        cad.cep,
                        cad.cidade,
                        cad.estado,
                        cad.pais
                  FROM ordem ord,
                       getar_cad cad
                 WHERE ord.codcli = cad.cod
                       AND ord.cod=" . $codOS;
$dados = consultaSQL($consulta);
?>
<style>
    p{
        text-indent: 4em;
    }
    
    table{
        border-style: solid;
        border-width: 2px;
    }
    
    td{
        border-style: solid;
        border-width: 2px;
    }
    
</style>
<!--
td{
        border: 1px solid;
    }
-->
<table width="100%">
    <tr>
        <td style="text-align: center;" colspan="2">DECLARAÇÃO DE TRANSPORTE DE BENS POR NÃO CONTRIBUINTE DO ICMS</td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="2">REMETENTE</td>
                </tr>
                <tr>
                    <td colspan="2">Paulo Regis da Silva Schwingel - CPF:&nbsp;548.365.650-49</td>
                </tr>
                <tr>
                    <td>Rua Imanuel Wurffell, 923</td>
                    <td>S&atilde;o Lu&iacute;z</td>
                </tr>
                <tr>
                    <td><label>CEP</label>88960-000</td>
                    <td>Sombrio/Santa Catarina</td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="2">DESTINAT&Aacute;RIO</td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $dados['nome']." - CPF:&nbsp;".$dados['cpcn']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $dados['endr']; ?></td>
                    <td><?php echo $dados['bairro']; ?></td>
                </tr>
                <tr>
                    <td><label>CEP</label><?php echo $dados['cep']; ?></td>
                    <td><?php echo $dados['cidade'] . "/" . $dados['estado']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td colspan="4">IDENTIFICA&Ccedil;&Atilde;O DOS BENS</td>
    </tr>
    <tr>
        <td>ITEM</td>
        <td>CONTE&Uacute;DO</td>
        <td>QUANTIDADE</td>
        <td>VALOR</td>
    </tr>
    <tr>
        <td>1</td>
        <td>Radio para amador</td>
        <td>1</td>
        <td>R$ 980,00</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #888888; text-align: right;">Total</td>
        <td>1</td>
        <td>R$ 980,00</td>
    </tr>
    <tr>
        <td colspan="2" style="background-color: #888888; text-align: right;">Peso Total</td>
        <td colspan="2" >&nbsp;</td>
    </tr>
</table>
<table>
    <tr>
        <td>DECLARA&Ccedil;&Atilde;O</td>
    </tr>
    <tr>
        <td>
            <p style="">Declaro que n&atilde;o me enquadro no conceito de contribuinte previsto no artigo 4o da lei complementar n. 87/1996, uma vez que
            não realizo com habitualidade ou em volume que caracteriza intuito comercial opera&ccedil;&atilde;es de circula&ccedil;&atilde;o de mercadoria,
            ainda que se iniciem no exterior, ou estou dispensado da emiss&atilde;o da nota fiscal por for&ccedil;a da legisla&ccedil;&atilde;o
            tribut&aacute;ria vigente, responsabilizando-me nos termos da lei e a quem de direito por informa&ccedil;&otilde;es inver&iacute;dicas.</p>
            <p>
                Declaro ainda que n&atilde;o estou postando conte&uacute;do inflam&aacute;vel,, explosivo, causador de combust&ccedil;&atilde;o 
                espont&acirc;nea, t&oacute;xico, corrosivo, g&aacute;s ou quarquer outro conte&uacute;do que constitua perigo, conforme artigo 13 da lei
                postal n&uacute;mero 6.538/78.
            </p>
            <br/><br/>
            Sombrio, _____/_____/2023,_________________________________________________
        </td>
    </tr>
</table>