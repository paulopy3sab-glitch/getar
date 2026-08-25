<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 23/03/2025
 * Descricao: switch para Mensagens
 */

switch ($pag) {
    case 'inativa':
        $lmb->mensInativa();
        $complemento = " dest='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Recebidas");
        break;

    case 'excl':
        $lmb->mensExcl();
        $complemento = " dest='" . $lmb->get_resp() . "''";
        $lmb->set_tipoMens("Recebidas");
        break;
    case "edit":
        if(isset($_GET['codmens'])){// ver como proceder pelo padrão
            $lmb->set_codMens($_GET['codmens']);
        }
        # echo $lmb->mensEdit();
        include './pagina/mensagens/includes/mens_edit.inc.php';
        $complemento = " dest='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Recebidas");
        break;
    case "nova":
        include './pagina/mensagens/includes/mens_edit.inc.php';
        $complemento = " dest='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Recebidas");
        break;
    case "exib":
        # echo $lmb->mensExib($lmb->get_codMens());
        include './pagina/mensagens/includes/mens_exib.inc.php';
        $complemento = " dest='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Recebidas");
        break;
    case 'list':
        $complemento = " dest='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Recebidas");
        break;
    case 'list_env':
        $complemento = " remt='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Enviadas");
        break;
    case 'list_recb':
        $complemento = " dest='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Recebidas");
        break;
    case 'contatos':
        $complemento = " dest='all_admin'
                         ORDER BY cod DESC";
        $lmb->set_tipoMens("Enviadas pelo sistema");
        break;
    case 'list_all':
        $complemento = " 1 = 1";
        $lmb->set_tipoMens("TODAS MENSAGENS");
        break;
    case 'list_u':
        $complemento = " ORDER BY cod DESC LIMIT 30";
        break;
    default :
        $complemento = " dest='" . $lmb->get_resp() . "'";
        $lmb->set_tipoMens("Recebidas");
}
?>
