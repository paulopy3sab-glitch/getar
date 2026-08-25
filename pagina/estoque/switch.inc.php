<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: Switch para gerenciamento de estoque
 * 19/11/2020: pregis
 *     Continuando a implementacao do POO
 */
?>

<script type="" language="javascript" src="funcoes/funcoes.js"></script>
<script type="" language="javascript" src="pagina/estoque/funcoes_estoque.js"></script>
<?php

# modo orientado
include './pagina/estoque/trait_estcons.php';
include './pagina/estoque/classe_estoque.php';
$est = new Estoque();
//Para recarregar apos logado
$est->set_resp($resp);
//Carregar atribuicoes
$est->carAtrib($resp);

# Modo estruturado
include 'funcoes_estoque.php';
#include 'trait-estoque.php';
switch ($setor) {
    case "estoque":
        # modo estruturado ainda
        include("pagina/estoque/estoque.php");
        break;
    case "categ":
        include("pagina/estoque/categ.php");
        echo "<hr>";
        echo categRodape();
        break;
    case "local":
        include("pagina/estoque/local.php");
        echo "<hr>";
        echo localRodape();
        break;
    case "pedido":
        if (isset($_GET['codped'])) {
            $codPed = $_GET['codped'];
        } elseif (isset($_POST['codped'])) {
            $codPed = $_POST['codped'];
        } else {
            $codPed = "";
        }
        
        
        //Criar cabecalho de pedido novo
        $msgPedido = "";
        if (isset($_POST['salvarPedido'])) {
            $est->set_tipoPed($_POST['tipo']);
            if ($est->get_tipoPed() == "compra") {
                $est->set_codForn($_POST['forn']);
            } else {
                $est->set_codForn("2"); //Proprietario como Empressa
            }
            if ($est->get_tipoPed() == "venda") {
                $est->set_codCli($_POST['cli']);
            } else {
                $est->set_codCli("1"); //Proprietario como Cliente
            }
            $msgPedido = $est->pedidoSalvar();
        }

        //Gravando acompanhamento de pedido
        $msgAcop = "";
        if (isset($_POST['salvarAcop'])) {
            $est->set_codPed($_POST['codped']);
            $est->set_nomePed($_POST['nomeped']);
            $est->set_situPed($_POST['situ']);
            $situ = $_POST['situ'];
            if (isset($_POST['ospro'])) {
                if($_POST['ospro'] == ""){
                    $est->set_ospro(0);
                }  else {
                    $est->set_ospro($_POST['ospro']);
                }                
            } else {
                $est->set_ospro(0);
            }
            $est->set_tipoPed($_POST['tipo']);
            $tipo = $_POST['tipo'];
            $complemento = "";
            if ($situ == "transito" && isset($_POST['diacheg'])) {
                $diaCheg = $_POST['diacheg'];
                $mesCheg = $_POST['mescheg'];
                $anoCheg = $_POST['anocheg'];
                $dataCheg = $anoCheg . "-" . $mesCheg . "-" . $diaCheg;
                //$est->set_dataCheg($dataCheg);
                $complemento = " , dtcheg= '" . $dataCheg . "'";
            }
            if ($situ == "recebido" && isset($_POST['diarecb'])) {
                $diaRecb = $_POST['diarecb'];
                $mesRecb = $_POST['mesrecb'];
                $anoRecb = $_POST['anorecb'];
                $dataRecb = $anoRecb . "-" . $mesRecb . "-" . $diaRecb;
                $est->set_dataRecb($dataRecb);
                $complemento = " , dtrecb='" . $dataRecb . "'";
            }
            if ($situ == "recebido" && !isset($_POST['diarecb'])) {
                $complemento = " , dtrecb= CURDATE() ";
            }
            if ($tipo == "compra" || $tipo == "venda") {
                $rastr = $_POST['rastr'];
                $est->set_rastr($rastr);
                $valorFrete = formatarValorMySQL($_POST['vlfrete']);
                $est->set_valorFrete($valorFrete);
                $emprFrete = $_POST['empfrete'];
                $est->set_emprFrete($emprFrete);
                $complemento .= ", rastr='" . $rastr . "', vlfrete='" . $valorFrete . "', empfrete='" . $emprFrete . "'";
            }

            $msgAcop = $est->pedidoAcop($complemento);
        }
        
        include 'pedido.php';
        break;
}

