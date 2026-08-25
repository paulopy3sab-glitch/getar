<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: Switch para gerenciamento de equipamentos e OSs
 * @date 11/07/2024
 * Ajustes modelagem do fluxo do cadastro e edição de Equipamento
 */
?>

<script type="" language="javascript" src="pagina/oscontrol/funcoes_os.js"></script>
<?php
# modo orientado
/*include './pagina/estoque/trait_estcons.php';
include './pagina/estoque/classe_estoque.php';
$est = new Estoque();
//Para recarregar apos logado
$est->set_resp($resp);
//Carregar atribuicoes
$est->carAtrib($resp);*/

include './pagina/oscontrol/trait_ordem.php';
include './pagina/oscontrol/classe_os.php';
$OS = new OScontrol();
//Para recarregar apos logado
$OS->set_resp($resp);
//Carregar atribuicoes
$OS->carAtrib($resp);
switch ($setor) {
    /* para os equipamentos das OSs
     * orientado a objeto
     */
    case "eqp":
        include './pagina/oscontrol/equipo.php';
    /* Para detalhamento das OS
     * Modo Estruturado em mudanças para orientado a objeto
     */
    break;
    case "ordm":
        include './pagina/estoque/funcoes_estoque.php';
        include './pagina/oscontrol/funcoes_os.php';
        #include './pagina/oscontrol/funcoes_oscons.php';
        include 'pagina/oscontrol/ordem.php';
        break;
}
