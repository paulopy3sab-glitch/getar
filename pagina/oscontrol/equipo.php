<?php

/*
 * Para gerenciar os Equipamentos cadastrados
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 11/07/2024
 */
//Ajustes de variaveis
if (isset($_GET['codeqp'])) {
    $OS->set_codEqp($_GET['codeqp']);
}
echo "<div class=\"titulo\">EQUIPAMENTOS CADASTRADOS</div>";
if (isset($_POST['salvar'])) {

    $OS->set_codEqp($_POST['codeqp']);
    //cadastro rapido do cliente
    if (isset($_POST['codcli'])) {
        $OS->set_codCli($_POST['codcli']);
    } else {
        $nome = $_POST['nome'];
        $endr = $_POST['endr'];
        $num = $_POST['num'];
        $bai = $_POST['bai'];
        $cep = $_POST['cep'];
        $cidade = $_POST['cidade'];
        $est = $_POST['estado'];
        $codcli = clienteSalvRap($nome, $endr, $num, $bai, $cep, $cidade, $est);
        $descr = "Telefone";
        $numero = $_POST['fone'];
        clienteSalvFone($codcli, $descr, $numero);
        // preparando para gravar o equipamento
        $OS->set_codCli($codcli);
    }
    $OS->set_hist($_POST['hist']);
    $OS->set_descr($_POST['descr']);
    $OS->set_marca($_POST['marca']);
    $OS->set_modelo($_POST['modelo']);
    $OS->set_serial($_POST['serial']);
    $OS->set_situEqp($_POST['situ']);
    $OS->eqpSalvar();

    # Salvando a observacao para o equipamento
    if ($_POST['texto'] <> "") {
        $texto = $_POST['texto'];
        $consulta = "SELECT codobs FROM ordem_obs WHERE codeqp =" . $OS->get_codeqp();
        $dados = consultaSQL($consulta);

        if (isset($dados['codobs'])) {
            $consulta = "UPDATE ordem_obs SET texto = '" . $texto . "' WHERE codobs=" . $dados['codobs'];
        } else {
            $consulta = "INSERT INTO ordem_obs (codeqp, texto) VALUES(" . $OS->get_codeqp() . ", '" . $texto . "')";
        }
        $msgObs = executaSQL($consulta);
    }
}


$str = "";
switch ($pag) {
    case 'edit':
        //echo $this->eqpEdit();
        $OS->set_codEqp($_GET['codeqp']);
        $dados = $OS->eqpEdit();

        # Contestando a existencia do codeqp
        if ($dados['cod'] <> $OS->get_codEqp()) {
            $str = "<b style=\"color: red\">Nenhum registro para o codigo " . $OS->get_codEqp() . "</b>";
            $complemento = "AND eqp.situ = 'ativo' ORDER BY eqp.cod DESC";
            $acao = "Ultimos Projetos";
        } else {
            $tipo = "edit";
            include './pagina/oscontrol/includes/equipo_edit.inc.php';
            $complemento = " AND eqp.cod= " . $OS->get_codEqp();
        }
        break;
    case 'novo':
        if (isset($_GET['codcli'])) {
            $OS->set_codCli($_GET['codcli']);
            $OS->set_codEqp($_GET['codeqp']);
            $dados = $OS->eqpEdit();
            $dados['codcli'] = $OS->get_codCli();
            //$tipo = "edit";
            $tipo = "novo";
            include './pagina/oscontrol/includes/equipo_edit.inc.php';
            $complemento = " AND eqp.cod= " . $OS->get_codEqp();
        } else {
            $OS->eqpNovo();
            $tipo = "novo";
            $dados = $OS->eqpEdit();
            include './pagina/oscontrol/includes/equipo_edit.inc.php';
            $_SESSION['link'] = "index.php?st=eqp&pag=novo&codeqp=" . $OS->get_codEqp();
        }
        $complemento = " AND eqp.cod= " . $OS->get_codEqp();
        break;
    case 'list':
        $complemento = "AND eqp.situ = 'ativo' ORDER BY eqp.descr ASC";
        $acao = "Projetos em Andamento";
        break;
    case 'list_u':
        $complemento = "AND eqp.situ = 'ativo' ORDER BY eqp.cod DESC";
        $acao = "Ultimos Projetos";
        break;
    case 'list_all':
        $complemento = " ORDER BY eqp.cod DESC";
        $acao = " Novo";
        break;
    case 'pesq':
        $complemento = "AND eqp.modelo LIKE '" . $_REQUEST['string'] . "%' ORDER BY eqp.modelo ASC";
        $acao = " Novo";
        break;
    default :
        $complemento = "AND eqp.situ = 'ativo' ORDER BY eqp.cod DESC";
        $acao = "Ultimos Projetos";
}
echo $str;
include './pagina/oscontrol/includes/equipo_lista.inc.php';
echo "<hr>";
echo $OS->eqpOpcoes();
?>
