<?php
/*
 * Para criar futura funcao ou metodo
 * Listagem de pedidos Compra Reposicao em ABERTO
 * Autor: Paulo Regis
 * Data:
 * 30/05/2024 - 
 */

$consulta = "SELECT forn.codforn,
                    cad.nome,
                    ped.nomeped,
                    ped.cod codped,
                    ped.situ
               FROM fornecedor forn,
                    getar_cad cad,
                    estoque est,
                    estpedidocab ped
               WHERE forn.codestq = est.cod
                     AND forn.codforn = cad.cod
                     AND forn.codforn = ped.codforn
                     AND ped.situ IN('processamento', 'estudo')
                     AND est.qtd < est.qtdmin
                     AND est.cod NOT IN(SELECT itm.codest
                                          FROM estpedidocab cab,
                                               estpedidoitem itm
                                         WHERE cab.cod = itm.codped
                                               AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
                                               AND cab.tipo= 'compra'
                                               AND itm.codest = est.cod)
                     AND est.cod =" . $dados["cod"];
$resultado = retornoSQL($consulta);

$str="";
while ($dados = arraySQL($resultado)) {
    $nomePed = "";
    if ($dados['nomeped'] <> "") {
        $nomePed = $dados['nomeped'] . " - ";
    }
    
    $str.=" <fieldset>
                <legend>INSERIR EM PEDIDO DE COMPRA/REPOSI&Ccedil;&Atilde;O N&Uacute;MERO: ". $dados['codped'] . " (" . $nomePed . $dados['situ'] . ")"."</legend>
                <b>Fornecedor: </b>". $dados['nome']."  
                <a href=\"index.php?st=estoque&pag=edit&codestq=". $dados["cod"]."&inped=". $dados['codped']."\">
                    <img src=\"imagens/visto.gif\" alt=\"\" border=\"no\">
                </a>
            </fieldset>";    
}
?>
