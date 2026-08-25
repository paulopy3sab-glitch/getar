/**
** modelagem atual das tabelas
**/
SHOW CREATE TABLE getar_contanome;
CREATE TABLE `getar_contanome` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `descr` text,
  `peratu` int(11) NOT NULL,
  `situacao` varchar(60) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COMMENT='registro de lancamentos';
ALTER TABLE getar_contanome ADD moeda VARCHAR(20) COMMENT 'Moeda da C/C. Ex.: Real' AFTER descr;
ALTER TABLE getar_contanome ADD inclcpr tinyint(1) DEFAULT TRUE NOT NULL COMMENT 'Incluir no Contas Pagar Receber' AFTER nome;
ALTER TABLE getar_contanome DROP inclcpr;

SHOW CREATE TABLE getar_contacor;
CREATE TABLE `getar_contacor` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codctco` int(11) NOT NULL COMMENT 'codigo conta corrente',
  `custo` int(11) NOT NULL,
  `datalanca` date DEFAULT NULL,
  `descr` text,
  `codclasf` int(11) DEFAULT NULL,
  `cred` decimal(10,2) DEFAULT '0.00',
  `debt` decimal(10,2) DEFAULT '0.00',
  `resp` varchar(20) NOT NULL DEFAULT '',
  `peratu` int(11) NOT NULL COMMENT 'periodo atual de lancamentos',
  `situacao` varchar(60) NOT NULL DEFAULT 'ativo',
  `obs` text COMMENT 'Comentarios para o lancamento',
  PRIMARY KEY (`cod`),
  KEY `fk_codctnm` (`codctco`),
  KEY `fk_codclasf` (`codclasf`),
  CONSTRAINT `fk_codclasf` FOREIGN KEY (`codclasf`) REFERENCES `getar_contaclasf` (`cod`),
  CONSTRAINT `fk_codctnm` FOREIGN KEY (`codctco`) REFERENCES `getar_contanome` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=3167 DEFAULT CHARSET=latin1 COMMENT='registro de lancamentos';

SHOW CREATE TABLE getar_contaclasf;
CREATE TABLE `getar_contaclasf` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) DEFAULT NULL,
  `codctco` int(11) NOT NULL,
  `descr` text,
  `situacao` varchar(60) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`),
  KEY `fk_codctcocl` (`codctco`),
  CONSTRAINT `fk_codctcocl` FOREIGN KEY (`codctco`) REFERENCES `getar_contanome` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1 COMMENT='classificacao de lancamentos';

SHOW CREATE TABLE peratu;
CREATE TABLE `peratu` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codctco` int(11) NOT NULL COMMENT 'conta corrente relacionada',
  `nome` varchar(20) NOT NULL COMMENT 'nome do periodo',
  `dataini` date NOT NULL COMMENT 'data em que inicia',
  `datafim` date NOT NULL COMMENT 'data em que finaliza',
  `situacao` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=507 DEFAULT CHARSET=latin1;

SHOW CREATE TABLE conta_carne;
CREATE TABLE `conta_carne` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codcad` int(11) NOT NULL COMMENT 'codigo do fornecedor ou cliente',
  `codctco` int(11) NOT NULL COMMENT 'codigo da conta corrente a ser usada',
  `finc` varchar(20) NOT NULL COMMENT 'nick do financeiro responsavel',
  `tipo` varchar(20) DEFAULT 'pagar' COMMENT 'pagar: contas a pagar, receber: a receber',
  `projetado` varchar(20) DEFAULT 'fixo' COMMENT 'fixo: parcelas fixas, nego: parcelas negociaveis ou com variacao',
  `objeto` varchar(60) DEFAULT NULL,
  `juro` decimal(6,2) DEFAULT '0.00',
  `valortot` decimal(8,3) NOT NULL COMMENT 'Valor total do carne',
  `datacarne` date NOT NULL COMMENT 'data em que foi criado o carne',
  `obs` text COMMENT 'Observacoes pertinentes ao carne',
  `situacao` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`cod`),
  KEY `fk_codctco` (`codctco`),
  CONSTRAINT `fk_codctco` FOREIGN KEY (`codctco`) REFERENCES `getar_contanome` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
ALTER TABLE conta_carne ADD `codclasf` int(11) DEFAULT NULL AFTER codctco;

SHOW CREATE TABLE conta_carnepar;
CREATE TABLE `conta_carnepar` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `parnum` int(11) NOT NULL COMMENT 'numero da parcela',
  `codcarne` int(11) NOT NULL COMMENT 'codigo do carne a que se revere',
  `datavnc` date NOT NULL COMMENT 'data de vencimento da parcela',
  `datapag` date DEFAULT NULL COMMENT 'data de pagamento da parcela',
  `valorpar` decimal(8,3) NOT NULL COMMENT 'valor da parcela',
  `obs` text COMMENT 'Observacoes pertinentes a parcela',
  `situacao` varchar(20) DEFAULT 'aberta' COMMENT 'aberta, paga, cancelada',
  PRIMARY KEY (`cod`),
  KEY `fk_codcarne` (`codcarne`),
  CONSTRAINT `fk_codcarne` FOREIGN KEY (`codcarne`) REFERENCES `conta_carne` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

/**
** manipulacao e pesquisa de dados
**/

SELECT * FROM conta_carne WHERE cod= 63;
SELECT * FROM conta_carnepar;
SELECT SUM(`valorpar`) FROM conta_carnepar WHERE codcarne= 4;
        SELECT *
        FROM conta_carnepar
        WHERE datapag BETWEEN '2016-01-01' AND '2016-12-30';


/**
** GERANDO PAGAMENTOS FIXOS
**/
# Para pagamento do cartao Visa BB- Codigo carne: 1
INSERT INTO conta_carne (codcad, codctco, finc, valortot, datacad, projetado, obs)
            VALUES(239, 2, 'pregis', 0, CURDATE(), 'fatu', 'Cartao Visa BB');# Ver codigo carne gerado
SELECT * FROM conta_carne WHERE codcad = 239;
SELECT * FROM conta_carne WHERE cod = 32;
INSERT INTO conta_carnepar (codcarne, parnum, datavnc, projetado, valorpar)
                     VALUES(1, 1, '2015-4-16', 'fixo', '350');
SELECT * FROM conta_carnepar WHERE codcarne = 32;
SELECT * FROM conta_carnepar WHERE cod IN (107, 111, 113, 115, 118, 121, 124);
# Cancelando um carne
UPDATE conta_carnepar SET situacao = 'cancelada'
 WHERE cod IN(44, 45,46,47,48,49,50,51,52,53)
       AND codcarne = 27; # mensalidade da LABRE-AM

UPDATE conta_carnepar SET situacao = 'cancelada' WHERE codcarne = 31; # compra anulada 2SC2904

# Pagamento Escolinha Sofia
INSERT INTO conta_carne (codcad, codctco, finc, valortot, datacad, obs)
            VALUES(821, 1, 'pregis', 0, CURDATE(), 'Escolinha Sofia');# Ver codigo carne gerado
SELECT * FROM conta_carne WHERE codcad = 821;
INSERT INTO conta_carnepar (codcarne, parnum, datavnc, valorpar)
                     VALUES(2, 4, '2015-11-10', '280'),
                           (2, 5, '2015-12-10', '280');


INSERT INTO conta_carne (codcad, codctco, finc, tipo, valortot, datacarne, situacao)
                   VALUES(2, 1, 'pregis', 'pagar', 0, CURDATE(), 'temporario');
SELECT * FROM conta_carne;
ALTER TABLE conta_carnepar ADD `situacao` varchar(20) DEFAULT 'ativo';
# DELETE FROM conta_carne;

SELECT * FROM conta_carnepar WHERE codcarne=2;
        UPDATE conta_carnepar
           SET situacao= 'ativo'
         WHERE codcarne= 2
               AND situacao NOT IN('pago');

TRUNCATE TABLE conta_carnepar;
ALTER TABLE conta_carnepar DROP FOREIGN KEY `fk_codcarne`;
TRUNCATE TABLE conta_carne;
ALTER TABLE conta_carnepar ADD CONSTRAINT fk_codcarne FOREIGN KEY (codcarne) REFERENCES conta_carne (cod);

# Ver codigo carne gerado
SELECT * FROM conta_carne WHERE codcad = 709;
INSERT INTO conta_carnepar (codcarne, parnum, datavnc, valorpar)
                     VALUES(4, 1, '2015-11-10', '270'),
                           (4, 2, '2015-12-10', '270'),
                           (4, 3, '2015-01-10', '270'),
                           (4, 4, '2015-02-10', '270');
SELECT * FROM conta_carnepar WHERE codcarne = 1;

# Pagamento Condominio
INSERT INTO conta_carne (codcad, codctco, finc, valortot, datacad, projetado, obs)
            VALUES(708, 1, 'pregis', 0, CURDATE(), 'fixo', 'Condominia Apartamento Manaus');
# Ver codigo carne gerado
SELECT * FROM conta_carne WHERE codcad = 708;
SELECT * FROM conta_carne WHERE cod= 16;
INSERT INTO conta_carnepar (codcarne, parnum, datavnc, valorpar)
                     VALUES(3, 1, '2015-11-10', '300'),
                           (3, 2, '2015-12-10', '300'),
                           (3, 3, '2015-12-10', '300'),
                           (3, 4, '2015-12-10', '300');
SELECT * FROM conta_carnepar WHERE codcarne = 3;


/**
** LISTANDO PARCELAS
*/
             SELECT pr.cod codpar,
                    cad.nome,
                    cn.cod codcarne,
                    cn.tipo,
                    date_format(pr.datavnc, '%d/%m/%Y') datavnc,
                    MONTH(pr.datavnc) mes,
                    pr.valorpar,
                    pr.situ
               FROM getar_cad cad,
                    conta_carne cn,
                    conta_carnepar pr
               WHERE cn.codcad = cad.cod
                     AND pr.codcarne = cn.cod
                     AND MONTH(pr.datavnc) = '9';

        SELECT cn.cod,
               cn.codcad,
               cad.nome,
               cn.codctco,
               cn.tipo,
               cn.projetado,
               (SELECT COUNT(*)FROM conta_carnepar WHERE codcarne= cn.cod) numparc,
               (SELECT date_format(datavnc, '%d/%m/%Y') FROM conta_carnepar WHERE codcarne= 2 AND parnum = 1) priparc,
               ROUND(cn.valortot, 2) valortot,
               cn.obs
          FROM getar_cad cad,
               conta_carne cn
         WHERE cn.codcad = cad.cod
               AND cn.cod = 2;
SELECT cod, parnum, codcarne, datavnc, situ, date_format(datavnc, '%d/%m/%Y') priparc FROM conta_carnepar WHERE codcarne= 2 AND parnum = 1;
SELECT * FROM conta_carne WHERE cod= 1;
SELECT * FROM conta_carnepar WHERE codcarne= 1;
UPDATE conta_carnepar SET situacao= 'cancelada' WHERE situacao= 'cancelado';

             SELECT pr.cod codpar,
                    pr.parnum,
                    cad.nome,
                    cn.cod codcarne,
                    cn.tipo,
                    date_format(pr.datavnc, '%d/%m/%Y') datavnc,
                    ROUND(pr.valorpar, 2) valorpar,
                    pr.situacao
               FROM getar_cad cad,
                    conta_carne cn,
                    conta_carnepar pr
               WHERE cn.codcad = cad.cod
                     AND pr.codcarne = cn.cod AND pr.situacao NOT IN ('cancelada')
                          AND MONTH(pr.datavnc) = '06'
                          AND YEAR(pr.datavnc) = YEAR(CURDATE())
                     ORDER BY pr.datavnc ASC;
# situacao do carne se todas as parcelas estao canceladas ou uma pelo menos ativa
        SELECT CASE
                   WHEN parnum = parcanc THEN 'cancelado'
                   WHEN parnum != parcanc THEN 'ativo'
               END situcarne
          FROM(SELECT COUNT(*) parnum,
                      (SELECT COUNT(*) parcanc
                         FROM conta_carnepar cn2
                        WHERE cn2.codcarne = cn1.codcarne
                              AND cn2.situ = 'cancelada') parcanc
                 FROM conta_carnepar cn1
                WHERE cn1.codcarne = 1) grp;

SELECT * FROM conta_carnepar;
SELECT * FROM conta_carne;
SELECT * FROM conta_carnepar WHERE codcarne = 2;

# edicao atual
             SELECT cn.cod,
                    cn.codcad,
                    cad.nome,
                    cn.codctco,
                    cn.tipo,
                    cn.projetado,
                    (SELECT COUNT(*)FROM conta_carnepar WHERE codcarne= cn.cod) numparc,
                    date_format(par.datavnc, '%d/%m/%Y') priparc,
                    ROUND(cn.valortot, 2) valortot,
                    cn.obs,
                    situacao
               FROM getar_cad cad,
                    conta_carne cn,
                    conta_carnepar par
              WHERE cn.codcad = cad.cod
                    AND codcarne= cn.cod
                    AND parnum = 1
                    AND cn.cod = 2;

(SELECT date_format(datavnc, '%d/%m/%Y') FROM conta_carnepar WHERE codcarne= 2 AND parnum = 1);

             SELECT cn.cod,
                    cad.nome,
                    cn.codctco,
                    cn.obs,
                    cn.situacao
                    # estatistica carne
                    cn.tipo,
                    cn.projetado,
                    ROUND(cn.valortot, 2) valortot,
                    '0' numparc,
                    '12/12/2016' priparc,
               FROM getar_cad cad,
                    conta_carne cn
              WHERE cn.codcad = cad.cod
                    AND cn.cod = 2;


/**
** HISTORICO DO CLIENTE (TRANFERIR PARA O PETRA
**/
        SELECT cn.cod codcarne,
               ROUND(cn.valortot, 2) valortot,
               date_format(cn.datacarne, '%d/%m/%Y') datacarne,
               cn.objeto,
               (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod) numparc,
               (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'semprev') semprev,
               (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'comprev') comprev,
               (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'paga') paga,
               (SELECT COUNT(*) FROM conta_carnepar WHERE codcarne = cn.cod AND situacao= 'aberta') aberta
        FROM conta_carne cn
        WHERE cn.codcad= 6; # Jose das couve

/**
** GERINDO CONTAS CORRENTES
**/

# manipulando manualmente o periodo
CREATE TABLE `peratu` (
    `cod` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `codctco` INT(11) NOT NULL COMMENT 'conta corrente relacionada',
    `nome` VARCHAR(20) NOT NULL COMMENT 'nome do periodo',
    `dataini` DATE NOT NULL COMMENT 'data em que inicia',
    `datafim` DATE NOT NULL COMMENT 'data em que finaliza',
    `situacao` varchar(20) DEFAULT 'ativo'
);

# finalizando todos os periodos ativos
UPDATE peratu SET situacao = 'inativo' WHERE situacao = 'ativo';

# criando novos periodos
# CUIDADO COM OS MESES DE FINAL 30 OU 31
# codidos peratu sao gerados automatico
INSERT INTO peratu (nome, codctco, dataini, datafim) 
     VALUES ('Abril-25', 1,'2025-04-01', '2025-04-30'); # caixa no envelope 
INSERT INTO peratu (nome, codctco, dataini, datafim) 
     VALUES ('BB_Abril-25', 8,'2025-04-01', '2025-04-30');# c/c BB
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('MP_Abril-25', 11,'2025-04-01', '2025-04-30');# Mercado Pago
INSERT INTO peratu (nome, codctco, dataini, datafim) 
     VALUES ('NU_Abril-25', 3,'2025-04-01', '2025-04-30');# C/C NuBank
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('BTG_Abril-25', 14,'2025-04-01', '2025-04-30');# Conta corrente BTG Banking

INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('NU_Capi_Abril-25', 13,'2025-04-01', '2025-04-30');# NUBank Caixinha Formacao Capital
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('NU_CX_Abril-25', 10,'2025-04-01', '2025-04-30');# NUBank Caixinha Reserva de Emergencia
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('NU_FrePecas_Abril-25', 9,'2025-04-01', '2025-04-30');# NUBank Reserva Fretes e Pecas
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('Criptos_Abril-25', 17,'2025-04-01', '2025-04-30');# Saldo em Criptos


/*
INSERT INTO peratu (nome, codctco, dataini, datafim) 
     VALUES ('BB51_Dezembro-24', 2,'2024-12-01', '2024-12-31');# poupanca BB
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('Fund_Cap_Dezembro-24', 15,'2024-12-01', '2024-12-31');# Conta corrente Fundo Formacao de Capital
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('Fund_Res_Dezembro-24', 16,'2024-12-01', '2024-12-31');# Conta corrente Fundo Reserva de Emergencia
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('SICOOB_Dezembro-24', 12,'2024-12-01', '2024-12-31');# SICOOB
INSERT INTO peratu (nome, codctco, dataini, datafim) 
     VALUES ('NU_Junho-24', 3,'2024-06-01', '2024-06-30');# C/C NuBank
INSERT INTO peratu (nome, codctco, dataini, datafim) 
     VALUES ('NUGuard_Junho-24', 9,'2024-06-01', '2024-06-30');# C/C NuBank Guardados 
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('NU_CX_Junho-24', 10,'2024-06-01', '2024-06-30');# NUBank Caixinha Reserva de Emergencia
INSERT INTO peratu (nome, codctco, dataini, datafim) 
     VALUES ('BB51_Junho-24', 2,'2024-06-01', '2024-06-30');# poupanca BB
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('NU_Capi_Junho-24', 13,'2024-06-01', '2024-06-30');# NUBank Caixinha Formacao Capital
INSERT INTO peratu (nome, codctco, dataini, datafim)
     VALUES ('BTG_Banking_Junho-24', 14,'2024-06-01', '2024-06-30');# Conta corrente BTG Banking
*/

INSERT INTO peratu (nome, codctco, dataini, datafim, situacao) 
     VALUES ('', 2, CURDATE(), CURDATE(), 'temporario');

# limpeza de registros C/C obsoletos
SELECT * FROM getar_contacor ORDER BY cod DESC LIMIT 10;
SELECT cod, peratu, cred, debt FROM getar_contacor WHERE DATE_FORMAT(datalanca, '%Y') = '2024';
DELETE FROM getar_contacor WHERE DATE_FORMAT(datalanca, '%Y') = '2023';
SELECT peratu FROM getar_contacor WHERE cod =1;
SELECT * FROM getar_contanome;
SELECT * FROM peratu ORDER BY cod DESC LIMIT 5;
SELECT * FROM peratu ORDER BY cod ASC LIMIT 5;
DELETE FROM peratu WHERE DATE_FORMAT(dataini, '%Y') IN('2019', '2020', '2021', '2022', '2023');
SELECT * FROM peratu WHERE situacao= 'ativo';
SELECT * FROM peratu WHERE codctco= 1;# caixa geral
SELECT cod, nome, dataini, datafim, situacao FROM peratu WHERE codctco= 2;# poupanca BB
SELECT COUNT(*) FROM peratu WHERE codctco= 2 AND situacao = 'ativo';
SELECT cod FROM peratu WHERE codctco= 8 AND situacao= 'ativo';# Banco do Brasil
SELECT * FROM peratu WHERE cod= 303;
SELECT cod FROM peratu WHERE codctco= 8 AND situacao= 'ativo';
SELECT cod, nome, codctco, dataini FROM peratu WHERE DATE_FORMAT(dataini, '%m/%Y') = '09/2020'  AND codctco IN(1, 4, 8);

SELECT codctco, datalanca, descr, cred, debt, peratu, situacao FROM getar_contacor WHERE datalanca = CURDATE();

SELECT * FROM getar_contacor WHERE peratu = 310;
SELECT * FROM getar_contacor WHERE peratu IN(145, 146, 148) ORDER BY datalanca DESC;
SELECT * FROM getar_contacor WHERE cod=1556;
SELECT * FROM getar_contacor ORDER BY datalanca DESC;
SELECT * FROM getar_contacor WHERE codctco= 8 ORDER BY datalanca DESC;
SELECT * FROM getar_contacor ORDER BY cod DESC;

# somatoria de um periodo
SELECT SUM(cred)-SUM(debt) saldo FROM getar_contacor WHERE peratu = 502;# 

# vendo se a data incerida esta dentro do intervalo do periodo
        SELECT COUNT(*) # cod
          FROM peratu 
         WHERE '2023-06-15' BETWEEN dataini AND datafim
               AND codctco = 8
               AND situacao = 'ativo';

# listagem periodos ativos
        SELECT ctn.nome nomecc,
               per.cod cod,
               per.nome nomeper,
               (SELECT SUM(cred)
                  FROM getar_contacor
                 WHERE peratu = per.cod) tt_cred,
               (SELECT SUM(debt)
                  FROM getar_contacor
                 WHERE peratu = per.cod) tt_debt,
               (SELECT SUM(cred)-SUM(debt)
                  FROM getar_contacor
                 WHERE peratu = per.cod) saldo,
               DATE_FORMAT(per.dataini, '%d/%m/%Y') data_ini,
               DATE_FORMAT(per.datafim, '%d/%m/%Y') data_fim,
               # para melhor ordenar
               DATE_FORMAT(per.dataini, '%Y') ano_ini,
               DATE_FORMAT(per.dataini, '%m') mes_ini,
               per.situacao
          FROM getar_contanome ctn,
               peratu per
         WHERE ctn.cod = per.codctco
               AND per.codctco= 8 # situacao= 'ativo';
         ORDER BY ano_ini DESC, mes_ini DESC;

# listagem contas correntes
         SELECT nm.cod,
                nm.nome,
                nm.descr,
               (SELECT SUM(cred)-SUM(debt)
                  FROM getar_contacor
                 WHERE peratu = per.cod) saldo,
                nm.situacao
           FROM getar_contanome nm,
                peratu per
          WHERE nm.cod = per.codctco
                AND per.situacao = 'ativo'
                AND nm.situacao = 'ativo';

         SELECT nm.cod,
                nm.nome,
                nm.descr,
               (SELECT cod
                  FROM peratu
                 WHERE codctco= nm.cod
                       AND situacao = 'ativo'
                 LIMIT 1) codper,# codigo do periodo ativo
               (SELECT COUNT(*)
                  FROM peratu
                 WHERE codctco= nm.cod
                       AND situacao = 'ativo') nmper,# numero de periodos ativos
               (SELECT nome
                  FROM peratu
                 WHERE codctco= nm.cod
                       AND situacao = 'ativo'
                 LIMIT 1) peratu,# periodo ativo
                nm.moeda,
                nm.situacao
           FROM getar_contanome nm
          WHERE 1 = 1;

# listagem do mes
        SELECT codctco,
               DATE_FORMAT(datalanca, '%d/%m/%Y') data_lanca,
               descr,
               peratu,
               situacao
          FROM getar_contacor
         WHERE DATE_FORMAT(datalanca, '%m/%Y') = '08/2021';
# listagem geral periodo
        SELECT cor.cod,
               (SELECT nome FROM getar_contanome WHERE cod= cor.codctco) conta_cor,
               DATE_FORMAT(cor.datalanca, '%d/%m/%Y') data_lanca,
               cor.descr,
               cor.peratu,
               cor.situacao
          FROM getar_contacor cor
         WHERE peratu IN(SELECT cod FROM peratu WHERE situacao= 'ativo');

SELECT * FROM getar_contacor WHERE cod IN(2753, 2752);







/**
** Calcular o faturamento ate R$ 6450,00 mes e compras (ate 80%
** Faturamento: cod 2
** Compras: cod 19
**/

# total recebido pag de OSs
SELECT cod, descr, codclasf, peratu FROM getar_contacor WHERE codclasf=2 ORDER BY cod DESC LIMIT 5; 
SELECT cod FROM peratu WHERE situacao= 'ativo';
SELECT cod, dataini FROM peratu WHERE DATE_FORMAT(dataini, '%m/%Y') = '07/2025';

    SELECT ct.cod,
           ct.descr,
           ct.codctco,
           ct.cred,
           ct.debt
      FROM getar_contacor ct
     WHERE ct.peratu IN(SELECT pt.cod
                          FROM peratu pt
                         WHERE pt.situacao = 'ativo')
           AND ct.codclasf = 19;
    SELECT ct.cod,
           ct.descr,
           ct.codctco,
           ct.cred,
           ct.debt
      FROM getar_contacor ct
     WHERE ct.peratu IN(SELECT pt.cod
                          FROM peratu pt
                         WHERE DATE_FORMAT(pt.dataini, '%m/%Y') = '01/2025')
           AND ct.codclasf = 2;

    SELECT SUM(ct.cred) faturamento
      FROM getar_contacor ct
     WHERE ct.peratu IN(SELECT pt.cod
                          FROM peratu pt
                         WHERE DATE_FORMAT(pt.dataini, '%m/%Y') = '08/2025')
           AND ct.codclasf = 2;
#Compras
    SELECT SUM(ct.debt) faturamento
      FROM getar_contacor ct
     WHERE ct.peratu IN(SELECT pt.cod
                          FROM peratu pt
                         WHERE DATE_FORMAT(pt.dataini, '%m/%Y') = '03/2025')
           AND ct.codclasf = 19;


SELECT * FROM getar_contacor WHERE cod = 3252;

# localizar pag de uma OS
SELECT * FROM getar_contacor WHERE descr LIKE('%653%');

# calculando o dizimo com base nos creditos de todas contas no mes
        SELECT cod,
               DATE_FORMAT(datalanca, '%d/%m/%y') datalanca,
               descr,
               codclasf,
               cred,
               '' tt_cred,
               situacao
          FROM getar_contacor
         WHERE cred > 0
               AND situacao = 'ativo'
               AND DATE_FORMAT(datalanca, '%m/%y') = '08/21';

# Listagem por periodo
        SELECT cc.cod,
               DATE_FORMAT(cc.datalanca, '%d/%m/%y') datalanca,
               cc.descr,
               cc.codclasf,
               clf.nome,
               cc.debt,
               cc.cred
          FROM getar_contacor cc,
               getar_contaclasf clf
         WHERE cc.codclasf = clf.cod
               AND cc.situacao = 'ativo'
               # AND DATE_FORMAT(cc.datalanca, '%m/%y') = '08/21'
               AND cc.peratu IN(207, 205);

/*Da um erro de blog se faz:
       UNION(SELECT '' cod,
                    '' datalanca,
                    'Total Credito: ' descr,
                    '' codclasf,
                    '' cred,
                    SUM(cred) tt_cred,
                    '' situacao
               FROM getar_contacor
              WHERE cred > 0
                    AND situacao = 'ativo'
                    AND DATE_FORMAT(datalanca, '%m/%y') = '09/18');*/

# listagem atual
         SELECT cc.cod,
                cc.descr,
                cc.cred,
                cc.debt,
                cl.nome clasf,
                cc.resp,
                date_format(cc.datalanca, '%d/%m/%Y') datalanca,
                date_format(cc.datalanca, '%Y') ano_reg,
                date_format(cc.datalanca, '%m') mes_reg,
                date_format(cc.datalanca, '%d') dia_reg,
                cc.obs,
                '' peratu,
                cc.situacao
           FROM getar_contacor cc,
                getar_contaclasf cl
          WHERE cc.codclasf = cl.cod
                AND cc.peratu = (SELECT cod FROM peratu WHERE codctco = 1 AND situacao = 'ativo')
                AND cc.codctco= 1                            
        UNION(;
SELECT 0 cod,
                    '' descr,
                    SUM(cred)-SUM(debt) cred,
                    '' debt,
                    '' codclasf,
                    '' resp,
                    '<b>Saldo Final:</b> ' datalanca,
                    date_format('2001-01-01', '%Y') ano_reg,
                    date_format('2001-01-01', '%m') mes_reg,
                    date_format('2001-01-01', '%d') dia_reg,
                    '' obs,
                    (SELECT CONCAT(nome, ' (', DATE_FORMAT(dataini, '%d/%m/%Y'), ' - ', DATE_FORMAT(datafim, '%d/%m/%Y'), ')') AS peratu
                        FROM peratu
                       WHERE codctco = 8 # conta corrente
                         AND situacao = 'ativo') peratu,
                    situacao
               FROM getar_contacor
              WHERE codctco= 1
                    AND peratu = (SELECT cod FROM peratu WHERE codctco = 1 AND situacao = 'ativo')
                    AND situacao NOT IN('pend', 'inativo');
)
           ORDER BY ano_reg DESC, mes_reg DESC, dia_reg DESC;

# pegando o periodo atual para a conta corrente
    SELECT cod,
           nome,
           date_format(dataini, '%d/%m/%Y') dataini,
           date_format(datafim, '%d/%m/%Y') datafim
      FROM peratu
     WHERE codctco = 1 # conta corrente
       AND situacao = 'ativo';

    SELECT CONCAT(nome, ' (', DATE_FORMAT(dataini, '%d/%m/%Y'), ' - ', DATE_FORMAT(datafim, '%d/%m/%Y'), ')') AS peratu
      FROM peratu
     WHERE codctco = 1 # conta corrente
       AND situacao = 'ativo';

# listando contas corrente
        SELECT nm.cod,
               nm.nome,
               nm.descr,
               nm.situacao,
               (SELECT SUM(cc.cred)-SUM(cc.debt) sd
                  FROM getar_contacor cc
                 WHERE cc.nome = nm.nome) sd
          FROM getar_contanome nm
         WHERE nm.situacao = 'ativo';

        SELECT SUM(cred)-SUM(debt) sd
          FROM getar_contacor
         WHERE codctco = 1
               AND situacao NOT IN('temporario');

# salvando ateracoes
UPDATE getar_contanome SET nome= 'Caixa Geral xx', descr= 'Conta basica inicial xx', situacao= 'ativo' WHERE cod= 1;
SELECT * FROM getar_contanome;

# listando com saldo
        SELECT *
          FROM getar_contanome 
        WHERE  situacao = 'ativo'
      ORDER BY nome;

        SELECT SUM(debt) tt_debt,
               SUM(cred) tt_cred,
               SUM(cred)-SUM(debt) sd
          FROM getar_contacor
         WHERE nome = 'BB_Teutonia'
               AND situacao = 'ativo';

             SELECT nm.cod,
                    nm.nome,
                    nm.descr,
                    nm.situacao,
                    (SELECT SUM(cc.cred)-SUM(cc.debt)
                       FROM getar_contacor cc
                      WHERE cc.nome = nm.nome) sd
               FROM getar_contanome nm
             WHERE  nm.situacao = 'ativo';
           ORDER BY nome;

SELECT * FROM getar_contanome;

        SELECT cod,
               descr,
               date_format(data, '%d/%m/%Y') data,
               date_format(data, '%Y') ano_reg,
               date_format(data, '%m') mes_reg,
               date_format(data, '%d') dia_reg,
               cred,
               debt,
               situacao,
               (SELECT SUM(cc2.cred)-SUM(cc2.debt)
                  FROM getar_contacor cc2
                 WHERE cc.nome = cc2.nome) sd
          FROM getar_contacor cc 
         WHERE nome= 'BB_Teutonia'
               AND situacao != 'temporario'
      ORDER BY ano_reg DESC, mes_reg DESC, dia_reg DESC;

         SELECT nm.cod,
                nm.nome,
                nm.descr,
                nm.situacao,
                (SELECT SUM(cc.cred)-SUM(cc.debt)
                   FROM getar_contacor cc
                  WHERE cc.codctco = nm.cod
                        AND cc.situacao NOT IN('temporario', 'inativo')) sd
           FROM getar_contanome nm
          WHERE 1 = 1# so para nao atrapalhar o WHERE
;

/**
** CUIDANDO DOS LANCAMENTOS NA CONTA CORRENTE
**/
SELECT * FROM getar_contacor WHERE nome = 'Caixa_SCHW'; 
    
         SELECT cc.cod,
                cc.descr,
                cc.cred,
                cc.debt,
                cl.nome,
                cc.resp,
                date_format(cc.datalanc, '%d/%m/%Y') datalanc,
                date_format(cc.datalanc, '%Y') ano_reg,
                date_format(cc.datalanc, '%m') mes_reg,
                date_format(cc.datalanc, '%d') dia_reg,
                cc.situacao
           FROM getar_contacor cc,
                getar_contaclasf cl
          WHERE  cc.codclasf = cl.cod
                 AND cc.codctco= 1
                 AND cc.situacao NOT IN('temporario', 'inativo')
        UNION(SELECT 0 cod,
                        'Saldo Final: 'descr,
                        SUM(cred)-SUM(debt) cred,
                        '' debt,
                        '' codclasf,
                        '' resp,
                        '' datalanc,
                        date_format('2001-01-01', '%Y') ano_reg,
                        date_format('2001-01-01', '%m') mes_reg,
                        date_format('2001-01-01', '%d') dia_reg,
                        situacao
                   FROM getar_contacor
                  WHERE codctco= 1
                        AND situacao NOT IN('temporario', 'inativo'))
        ORDER BY ano_reg DESC, mes_reg DESC, dia_reg DESC;

                SELECT SUM(cred)-SUM(debt) sd
                   FROM getar_contacor
                  WHERE codctco= 1
                        AND situacao NOT IN('temporario', 'inativo');
SELECT * FROM getar_contacor;
        SELECT cod,
               codctco,
               descr, debt, cred, codclasf, situacao 
          FROM getar_contacor
         WHERE cod=19;


INSERT INTO getar_contacor (codctco, custo, datalanca, peratu, situacao)
                                VALUES(1, 0, CURDATE(), (SELECT cod FROM peratu WHERE codctco= 1 AND situacao= 'ativo'), 'ativo');
INSERT INTO getar_contacor (codctco, datalanc, descr, codclasf, cred, debt, resp, situacao)
            VALUES(1, '2016/09/16', 'Pagamento Luz', 1, 0, 15, 'admin', 'ativo');

SELECT cod, nome, inclcpr, situacao FROM getar_contanome ORDER BY cod DESC;

/**
** Carnes a pagar e a receber
**/
SELECT * FROM conta_carne WHERE cod IN(71, 72);
SELECT * FROM conta_carne WHERE cod =7;
SELECT * FROM conta_carne ORDER BY cod DESC LIMIT 5;
SELECT * FROM conta_carnepar ORDER BY cod DESC LIMIT 5;
SELECT * FROM conta_carnepar WHERE cod =71;
SELECT * FROM conta_carnepar WHERE codcarne =7;
SELECT * FROM conta_carnepar WHERE cod =5;
UPDATE conta_carne SET codctco= 1, codclasf = 2 WHERE cod = 5;
UPDATE conta_carnepar SET valorpar= 187.11 WHERE codcarne =70;
UPDATE conta_carnepar SET situacao= 'paga' WHERE codcarne =70;
UPDATE conta_carnepar SET datapag= NULL WHERE cod =213;

# reiniciando as tabelas contas pager e recebeir
TRUNCATE TABLE conta_carnepar;
ALTER TABLE conta_carnepar ADD CONSTRAINT fk_codcarne FOREIGN KEY (codcarne) REFERENCES conta_carne (cod);
ALTER TABLE conta_carnepar DROP FOREIGN KEY fk_codcarne;
TRUNCATE TABLE conta_carne;

# criando novo parcelamento
INSERT INTO conta_carne(codcad, codctco, finc, projetado, valortot, datacarne, situacao)
                 VALUES(1187, 8, 'pregis', 'fixo', 117.00, CURDATE(), 'ativo');
INSERT INTO conta_carnepar(parnum, codcarne, datavnc, valorpar, situacao)
                 VALUES(1, 65, '2023-08-20', 82, 'aberta');

         SELECT cnt.cod,
                cnt.codcad,
                cad.nome,
                cnt.codctco,
                cnt.tipo,
                cnt.projetado,
                cnt.objeto,
                cnt.obs,
                cnt.situacao
           FROM getar_cad cad,
                conta_carne cnt
          WHERE cnt.codcad = cad.cod
                AND cnt.cod = 72;

      SELECT pr.cod codpar,
            pr.cod cod,# toda listagem tem que ter esta campo: cod
            cad.nome descr,# compo obrigatorio: descr
            date_format(pr.datavnc, '%d/%m/%Y') col1,
            ROUND(pr.valorpar, 2) col2
       FROM getar_cad cad,
            conta_carne cn,
            conta_carnepar pr
       WHERE cn.codcad = cad.cod
             AND pr.codcarne = cn.cod
             AND pr.situacao = 'aberta'
             AND pr.datavnc < CURDATE();

# lanacamento automatico se pagar uma parcela
        INSERT INTO getar_contacor (codctco, datalanca, descr, resp, cred, debt, codclasf, situacao)
                            VALUES ( 1,
                                    CURDATE(),
                                   'Pagto. Par.: 1 Credor: ',
                                   'pregis',
                                   0,
                                   32,
                                   3,
                                   'pend');

                 SELECT cc.cod,
                        cc.codctco,
                        cc.codclasf,
                        cc.datalanc,
                        date_format(cc.datalanc, '%Y') ano_reg,
                        date_format(cc.datalanc, '%m') mes_reg,
                        date_format(cc.datalanc, '%d') dia_reg,
                        nm.nome contanome,
                        cc.descr,
                        cc.cred,
                        cc.debt,
                        cc.situacao
                   FROM getar_contacor cc,
                        getar_contanome nm
                  WHERE  cc.codctco = nm.cod
                        AND cc.cod = 1;

/**
** CLASSIFICOES DAS CONTAS CORRENTES
**/
         SELECT cl.cod,
                cl.nome,
                cl.codctco,
                nm.nome,
                cl.descr,
                cl.situacao
           FROM getar_contaclasf cl,
                getar_contanome nm
          WHERE  cl.codctco = nm.cod
                AND cl.cod = 9;

             SELECT cl.cod,
                    cl.nome,
                    cl.codctco,
                    nm.nome contanome,
                    cl.descr,
                    cl.situacao
               FROM getar_contaclasf cl,
                    getar_contanome nm
              WHERE  
                    cl.cod = 9;

# inicialilzando um conta corrente
INSERT INTO `getar_contaclasf` (`nome`, `codctco`, `descr`, `situacao`) VALUES
('Deposito Dinheiro', 5, 'Depósito em dinheiro', 'ativo'), # 5 C/C CEF Paulo
('Deposito Cheque-24h', 5, 'Deposito em cheque. Aguarda 24h para compensação', 'ativo'),
('Deposito Cheque-48h', 5, 'Deposito em cheque. Aguarda 48h para compensação', 'ativo'),
('Transferencia', 5, 'Vem de algum tipo de tranferencia', 'ativo'),
('Saque', 5, 'Saque diversos', 'ativo'),
('Poupado', 5, 'Transferido para uma variação de poupança', 'ativo'),
('Aplicação', 5, 'Aplicado em algum investimento', 'ativo'),
('Pag. Cartão', 5, 'Pag cartão de crédito', 'ativo'),
('Taxas e Tarifas', 5, 'Taxas, tarifas, impostos', 'ativo'),
('Internet/telefone', 5, 'Pag. acesso internet e telefonia fixa', 'ativo'),
('Telefone', 5, 'Telefonia Pré paga', 'ativo'),
('Serviços WEB', 5, 'Hospedagem, seguranção e afins', 'ativo'),
('Pag. Proj. Program', 5, 'Pag. recebido de projetos de programação ou designer', 'ativo'),
('Pag. Proj. Eletronic', 5, 'Pag. recebido de projetos eletrônicos', 'ativo');

SELECT * FROM getar_contanome;
SELECT * FROM getar_contaclasf ORDER BY cod DESC;
SELECT * FROM getar_contaclasf WHERE codctco= 1;

         
/**
** Totalizando por classificações das Contas Correntes
**/
SELECT cod, datalanca, descr, codclasf FROM getar_contacor WHERE codctco= 8 AND peratu = 418;
SELECT cod, nome, codctco, situacao FROM getar_contaclasf;

        SELECT cc.cod,
               cc.datalanca,
               cc.descr,
               cc.codclasf
          FROM getar_contacor cc,
               getar_contaclasf cl
         WHERE cc.codctco = cl.codctco
               # AND # sub SELECT com as classificacões usada
               AND cc.codctco= 8
               AND cc.peratu = 418;

/**
** PARCELAMENTOS
**/
SELECT * FROM conta_carne ORDER BY cod DESC;
SELECT * FROM conta_carne WHERE cod= 44;
SELECT * FROM conta_carnepar WHERE codcarne= 52;
SELECT * FROM conta_carnepar WHERE cod IN(78, 79);
         SELECT pr.cod codpar,
                pr.parnum,
                cad.nome,
                cn.cod codcarne,
                cn.tipo,
                date_format(pr.datavnc, '%d/%m/%Y') datavnc,
                ROUND(pr.valorpar, 2) valorpar,
                pr.situ
           FROM getar_cad cad,
                conta_carne cn,
                conta_carnepar pr
           WHERE cn.codcad = cad.cod
                 AND pr.codcarne = cn.cod AND pr.situ = 'aberta'
              AND pr.datavnc < CURDATE();

        SELECT cn.cod,
                cn.codcad,
                cad.nome,
                cn.codctco,
                cn.tipo,
                cn.projetado,
                (SELECT COUNT(*)FROM conta_carnepar WHERE codcarne= cn.cod) numparc,
                # (SELECT date_format(datavnc, '%d/%m/%Y') FROM conta_carnepar WHERE codcarne= cn.cod AND parnum = 1) priparc,
                ROUND(cn.valortot, 2) valortot,
                cn.obs
           FROM getar_cad cad,
                conta_carne cn
          WHERE cn.codcad = cad.cod
                AND cn.cod =8;


/**
** Area de testes
**/
     SELECT pr.cod codpar,
            pr.cod cod,# toda listagem tem que ter esta campo: cod
            cad.nome descr,# compo obrigatorio: descr
            date_format(pr.datavnc, '%d/%m/%Y') col1,
            ROUND(pr.valorpar, 2) col2
       FROM getar_cad cad,
            conta_carne cn,
            conta_carnepar pr
       WHERE cn.codcad = cad.cod
             AND pr.codcarne = cn.cod
             AND pr.situacao IN('aberta', 'atrazada')
             AND pr.datavnc < CURDATE();

         SELECT pr.cod codpar,
                cad.nome descr,
                date_format(pr.datavnc, '%d/%m/%Y') datapar,
                ROUND(pr.valorpar, 2) valorpar,
                pr.situacao
           FROM getar_cad cad,
                conta_carne cn,
                conta_carnepar pr
           WHERE cn.codcad = cad.cod
                 AND pr.codcarne = cn.cod
                 AND pr.situacao IN('aberta', 'atrasada')
                 AND pr.datavnc < CURDATE();