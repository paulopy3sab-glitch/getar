<?php
/**
 * funcoes especificas para O GETAR
 */

/**
 * Retorna a descricao resumida e completa de uma classificacao de um cliente
 * Ex.: a = administrador msg "Administrador do site."
 * a = administrador, v = vendedor, c = cliente, p = programador/designer,
 * f = financeiro e g = geral
 * @param <char> $clasf
 * @param <string> $msg
 * @return <string>
 */
function descricaoClassificacao($clasf, $msg = "") {
    switch ($clasf) {
        case 'a':
            $descricao = 'administrador';
            $msg = "Administrador do site.";
            break;
        case 'v':
            $descricao = 'vendedor';
            $msg = "Para listar na lista de contatos.";
            break;
        case 'c':
            $descricao = 'cliente';
            $msg = "Para cadastrar projetos.";
            break;
        case 'p':
            $descricao = 'programador/designer';
            $msg = "Para programador e designer.";
            break;
        case 'f':
            $descricao = 'financeiro';
            $msg = "Para departamento financa (contas a pagar e receber).";
            break;
        case 'g':
            $descricao = 'geral';
            $msg = "Apenas para consulta on line.";
            break;
        default:
            $descricao = "geral";
            $msg = "Apenas para consulta on line.";
    }
    return $descricao;
}

/**
 * Verificar mensagens para o logado
 * @return <string> $msg
 * @global <type> $conexao
 */
function verificaMensagens($resp){
    $msg = "";
    $consulta = "SELECT COUNT(*) num
                   FROM getar_mens
                  WHERE dest = '".$resp."'
                        AND situacao = 'ativo'
                        AND lida= '0'";
    $dados= consultaSQL($consulta);
    $numMens= $dados['num'];
    
    if ($numMens > 0) {
        $msg= " - <a href=\"index.php?st=mensagens&pag=list&tipo=recb\">
            ".$dados['num']." mensagens novas</a>";
    }
    return $msg;
}

/**
 * Verefica se ha contatos vindo do site
 * e mensagens de erro SQL
 * @return string
 */
function verificaContatos(){
    $msg = "";    
    //se for administrador
    $consulta = "SELECT COUNT(*) num
                   FROM getar_mens
                  WHERE dest = 'all_admin'
                        AND situacao = 'ativo'
                        AND lida= '0'";
    $dados= consultaSQL($consulta);
    $numMens= $dados['num']; if ($numMens > 0) {
        $msg= " - <a href=\"index.php?st=mensagens&pag=contatos\">
            ".$dados['num']." Msg. all_admin novas</a>";
    }
    return $msg;
}

/**
 * Verificar lembretes para o logado
 * @return <string> $msg
 * @global <type> $conexao
 */
function verificaLembretes($resp){

    $consulta = "SELECT COUNT(*) num
                   FROM getar_lembre
                  WHERE dataAgendada <= CURDATE()
                        AND dest = '".$resp."'
                        AND situacao= 'ativo'";
    $dados = consultaSQL($consulta);
    $msg= "";
    if ($dados['num'] > 0) {
        $msg= " - <a href=\"index.php?st=lembretes&ft=lmb&pag=list&tipo=recb\">".$dados['num']." lembretes para hoje </a>";
    }
    return $msg;
}

/**
 * Verificar se atribui ou nao para o usuario logado
 * @global type $conexao
 * @param type $codAtrib
 * @return boolean
 */
function atrib($codAtrib){
    global $arrayAtribEst;
    
    $atrib = FALSE;
    if (in_array($codAtrib, $arrayAtribEst)) {
        $atrib = TRUE;
    }
    
    return $atrib;
}

?>
