<?php

/*
 * Description:
 * Arquivo para salvar alteracoes basica de um produto
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 28/09/2021
 * Revision:
 */

//Entrada de variaveis
$codEst = $_POST['cod'];
$numEst = $_POST['numest'];
$descr = $_POST['descr'];
$descrTec = $_POST['descrtec'];
$datasheet = $_POST['datasheet'];
$und = $_POST['und'];
$qtd = formatarValorMySQL($_POST['qtd']);
$peso = formatarValorMySQL($_POST['peso']);
$situ = $_POST['situacao'];
$foto = $_POST['foto'];
$qtdMin = formatarValorMySQL($_POST['qtdmin']);
$valorCusto = formatarValorMySQL($_POST['valorcusto']);
$valorVenda = formatarValorMySQL($_POST['valorvenda']);
$moeda = $_POST['moeda'];
$codClasf = $_POST['clasf'];
$codLocal = $_POST['local'];
$codCatg = $_POST['catg'];
$codSubCatg = $_POST['subcatg'];
if ($foto == "imagem") {
    $foto="";
}
$consulta = "UPDATE estoque
                SET numest= '" . $numEst . "',
                    descr= '" . $descr . "',
                    descrtec= '" . $descrTec . "',
                    datasheet= '" . $datasheet . "',
                    und= '" . $und . "',
                    qtd= " . $qtd . ",
                    clasf= '" . $codClasf . "',
                    situacao= '" . $situ . "',
                    qtdmin= " . $qtdMin . ",
                    valorcusto= " . $valorCusto . ",
                    valorvenda= " . $valorVenda . ",
                    moeda= '" . $moeda . "',
                    peso= " . $peso . ",
                    foto= '" . $foto . "',
                    local= " . $codLocal . ",
                    catg= " . $codCatg . ",
                    subcatg= " . $codSubCatg . "
                WHERE cod=" . $codEst;




$msgEst = executaSQL($consulta);
$msg = $msgEst;
?>
