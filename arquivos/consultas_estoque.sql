/***
** para exemplos de como criar e alterar tabelas
** ver artigo http://localhost/getarsab/index.php?st=artigos&pag=leitura&codartg=172
*/
SHOW CREATE TABLE estoque;
CREATE TABLE `estoque` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(120) NOT NULL,
  `descrtec` varchar(120) NOT NULL COMMENT 'Descricao tecnica do produto- sucinta',
  `numest` int(11) NOT NULL DEFAULT '1' COMMENT 'Para varios estoques',
  `datasheet` varchar(60) NOT NULL,
  `fabr` int(11) NOT NULL,
  `und` varchar(10) NOT NULL,
  `qtd` decimal(10,3) NOT NULL,
  `qtdmin` decimal(10,3) NOT NULL,
  `valorcusto` decimal(10,3) NOT NULL,
  `valorvenda` decimal(10,3) NOT NULL,
  `moeda` varchar(20) DEFAULT 'Real',
  `peso` decimal(10,3) NOT NULL,
  `foto` varchar(120) NOT NULL,
  `rua` int(11) NOT NULL DEFAULT '1' COMMENT 'Para estoque num pavilahao',
  `quadra` int(11) NOT NULL DEFAULT '1' COMMENT 'Para estoque num pavilahao',
  `local` int(11) NOT NULL DEFAULT '1',
  `situacao` varchar(60) NOT NULL,
  `clasf` varchar(60) NOT NULL DEFAULT 'geral',
  `catg` int(11) NOT NULL,
  `subcatg` int(11) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_subcatg` (`subcatg`),
  KEY `fk_catg` (`catg`),
  CONSTRAINT `fk_catg` FOREIGN KEY (`catg`) REFERENCES `estcatg` (`cod`),
  CONSTRAINT `fk_subcatg` FOREIGN KEY (`subcatg`) REFERENCES `estsubcatg` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=3179 DEFAULT CHARSET=latin1;

ALTER TABLE `estoque` ADD `nossonum` VARCHAR(20) COMMENT 'Codigo de estoque independente' AFTER `numest`;
ALTER TABLE estoque ADD `moeda` VARCHAR(20) DEFAULT 'Real' AFTER valorvenda;

ALTER TABLE `estoque` ADD `descrtec` VARCHAR(120) NOT NULL COMMENT 'Descricao tecnica do produto- sucinta' AFTER `descr`;
/**
** Gerenciamento dos pedidos
**  Reposição, consumo e venda nas OSs
**/
SHOW CREATE TABLE estpedidocab;
CREATE TABLE `estpedidocab` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nomeped` varchar(30) DEFAULT '' COMMENT 'Nome do Pedido',
  `codforn` int(11) NOT NULL COMMENT 'codigo do fornecedor na getar_cad',
  `resp` varchar(20) DEFAULT NULL COMMENT 'nick do responsavel pelo pedido',
  `codcli` int(11) DEFAULT NULL COMMENT 'codigo do cliente na getar_cad',
  `dtped` date DEFAULT NULL COMMENT 'data do pedido',
  `ospro` int(11) DEFAULT NULL COMMENT 'OS ou projeto vinculado ao pedido',
  `dtcheg` date DEFAULT NULL COMMENT 'data de privissao de chegada',
  `dtrecb` date DEFAULT NULL COMMENT 'data de recebimento do pedido',
  `rastr` varchar(120) DEFAULT NULL COMMENT 'codigo rastreador',
  `vlfrete` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'custo do frete',
  `empfrete` varchar(120) DEFAULT NULL,
  `situ` varchar(20) NOT NULL DEFAULT 'processamento',
  `tipo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_codfornped` (`codforn`),
  CONSTRAINT `fk_codfornped` FOREIGN KEY (`codforn`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=638 DEFAULT CHARSET=latin1 COMMENT='se dtper eh vasio= pedido em processamento, se dtrecb eh vas'

# aprimoramentos
ALTER TABLE estpedidocab ADD `nomeped` VARCHAR(30) DEFAULT '' COMMENT 'Nome do Pedido' AFTER cod ; 

 # esta dando muito confuso o ospro
ALTER TABLE estpedidocab ADD `tpcons` VARCHAR(20) DEFAULT '' COMMENT 'Tipo de consumo: OS - projeto - venda' AFTER ospro; # Venda avulsa
ALTER TABLE estpedidocab ADD `nmproj` INT(11) DEFAULT NULL COMMENT 'Numero do projeto Eletronico vinculado' AFTER ospro;
SELECT * FROM estpedidocab ORDER BY cod DESC LIMIT 5;
SELECT * FROM estpedidocab WHERE cod IN (500, 638);
/**
** LISTAGEM PARA O SITE
**/
     SELECT cod,
            descr,
                CASE
                   WHEN und IN('pc', 'und') THEN ROUND(qtd, 0)
                   WHEN und IN('m', 'ml', 'Kg') THEN ROUND(qtd, 3)
                END qtd,
            und,
            (SELECT etq FROM estlocal WHERE cod = est.local) etqlocal,
            (SELECT descr FROM estcatg WHERE cod = est.catg) descrcatg,
            (SELECT descr FROM estsubcatg WHERE cod = est.subcatg) descrsubcatg,
            clasf,
            situacao
       FROM estoque est
      WHERE situacao != 'temporario'
        AND situacao != 'inativo'  ORDER BY cod DESC LIMIT 1;

/**
** PARA EDITAR
**/
     SELECT estq.cod,
            estq.descr,
            estq.numest,
            estq.datasheet,
            estq.fabr codfabr,
            (SELECT nome FROM getar_cad WHERE cod=estq.fabr) fabr,# pode nao ter fabricante e nao amarrar o SELECT
            estq.und,
            CASE
                WHEN estq.und IN('pc', 'und') THEN ROUND(estq.qtd, 0)
                WHEN estq.und IN('cm2', 'm', 'ml', 'Kg') THEN ROUND(estq.qtd, 3)
                ELSE ROUND(estq.qtd, 3)
            END qtd,
            CASE
                WHEN estq.und IN('pc', 'und') THEN ROUND(estq.qtdmin, 0)
                WHEN estq.und IN('cm2', 'm', 'ml', 'Kg') THEN ROUND(estq.qtdmin, 3)
                ELSE ROUND(estq.qtdmin, 3)
            END qtdmin,
            estq.valorcusto,
            estq.valorvenda,
            estq.moeda,
            estq.peso,
            estq.foto,
            estq.local,
            qd.etq quadra,
            rua.etq rua,
            estq.situacao,
            estq.clasf,
            estq.catg,
            estq.subcatg,
            (SELECT cb.cod
               FROM estpedidocab cb,
                    estpedidoitem it
              WHERE cb.cod = it.codped
                    AND cb.tipo = 'compra'
                    AND it.codest = estq.cod
              ORDER BY cb.cod DESC
              LIMIT 1) AS codpedido,
            (SELECT cb.situ stpedido
               FROM estpedidocab cb,
                    estpedidoitem it
              WHERE cb.cod = it.codped
                    AND cb.tipo = 'compra'
                    AND it.codest = estq.cod
              ORDER BY cb.cod DESC
              LIMIT 1) AS stpedido,
             (SELECT cad.nome
                FROM estpedidocab cb,
                     getar_cad cad,
                     estpedidoitem it
               WHERE cb.cod = it.codped
                     AND cad.cod = cb.codforn
                     AND cb.tipo = 'compra'
                     AND it.codest = estq.cod
               ORDER BY cb.cod DESC
               LIMIT 1) AS nomeforn
       FROM estoque estq,
            estlocal loc,
            estquadra qd,
            estrua rua
      WHERE loc.cod = estq.`local`
            AND qd.cod = loc.quadra
            AND rua.cod = qd.codrua
            # AND estq.cod = '2016' # saquilho placsti
            AND estq.cod = '777' # fio cobre esmaltado 18AWG - nao tem local
;

/**
** Trabalhando com as imagen ilustrativas.
**  agora podendo ter mais de uma por produto.
**/
CREATE TABLE estoqueimg(
    cod int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    codestq int(11) NOT NULL,
    imagem VARCHAR(120) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE estoqueimg ADD CONSTRAINT fk_codIMG FOREIGN KEY (codestq) REFERENCES estoque (cod);
# testes
INSERT INTO estoqueimg (codestq, imagem)
                VALUES (3624, 'capacitor_eletrolitico-SMD.jpg');
INSERT INTO estoqueimg (codestq, imagem) SELECT cod, foto FROM estoque WHERE foto != '';
SELECT cod, foto FROM estoque WHERE foto = '';
SELECT imagem FROM estoqueimg WHERE codestq= 3624;
TRUNCATE TABLE estoqueimg;

/**
** Para acrescentar novos componentes
*/

# procurando cod vagos
SELECT cod, descr, situacao FROM estoque WHERE situacao = 'inativo';
SELECT cod, descr, situacao FROM estoque WHERE cod BETWEEN 3000 AND 3500;
SELECT cod, descr, situacao FROM estoque WHERE cod = 3379;
# 2053[ja usado], 2500[ja usado], 2709[ja usado], 1048[ja usado], 1104[usado], 1112[usado], 1131[usado], 1184[usado], 1215[usado], 1270[usado]
# 1276[ja usado], 1294 {ja usado]
# 2035[ja usado], 2132 [ja usado], 2271[ja usado], 2281[ja usado], 3197[ja usado], 0505 [usado]
# 1879 [liberado]

INSERT INTO estoque (cod, descr, descrtec, datasheet, foto, fabr, und, qtd, qtdmin, valorcusto, valorvenda, catg, subcatg, peso, situacao)
             VALUES (3290, 'Fonte de Alimentacao', '', '', '', 0, 'pc', 0, 0, 0, 0, 1, 1, 0, 'ativo');

# procurando codigos inativos
SELECT cod, descr, situacao FROM estoque WHERE situacao = 'inativo';
SELECT cod, descr, situacao FROM estoque WHERE situacao = 'temporario';
SELECT cod, descr, situacao FROM estoque WHERE descr LIKE ('Capacitor ceramico%') AND situacao = 'inativo';
SELECT cod, descr, numest, situacao FROM estoque WHERE cod= 1877;

# procurando codigos temporarios perdidos
SELECT cod, descr, situacao FROM estoque WHERE descr = 'Produto Novo';
SELECT cod, descr, situacao FROM estoque WHERE descr LIKE ('Capacitor ceramico%') AND situacao = 'temporario';

# procurando codigos do estoque 2
SELECT cod, descr, situacao, numest FROM estoque WHERE numest = 2; # mecanica

# reutilizando codigos das Placa de Lavar roupa
SELECT cod, descr, situacao FROM estoque WHERE descr LIKE ('Placa%') AND situacao = 'inativo';# 11 registros
# excluindo pedido relacionados
SELECT * FROM estpedidoitem WHERE codest = 1877;
SELECT * FROM estpedidocab WHERE cod = 652;

SELECT cod, descr, situacao FROM estoque WHERE cod= 950;
SELECT * FROM estoque WHERE cod= 2739;

SELECT cod, descr FROM estoque ORDER BY cod DESC;


/**
** Inserindo mais de um produdo semelhante
**/
INSERT INTO estoque (cod, descr, descrtec, datasheet, fabr, und, qtd, qtdmin, valorcusto, valorvenda, peso, foto, `local`, situacao, catg, subcatg)
              VALUES(1371, 'Capacitor eletrolitico 15uF x 200', '', '', 0, 'pc', 1, 2, 0, 0, 0, '', 0, 'ativo', 9, 21);
INSERT INTO estoque (descr,
                      descrtec,
                       datasheet,
                       fabr,
                       und,
                       qtd,
                       qtdmin,
                       valorcusto,
                       valorvenda,
                       peso,
                       foto,
                       local,
                       situacao,
                       clasf,
                       catg,
                       subcatg) VALUES                         # custo venda                          # local
('Capacitor ceramico SMD 470nF 470N 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 470pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 220pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 820nF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 3.3nF 3N3 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 82pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 0.5pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 1.2pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 2.7pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 3pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 3.3pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 3.9pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 5pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 6.8pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 8.2pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 9pF 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21),
('Capacitor ceramico SMD 30F 50V 0406','', '', 0, 'pc', 0, 1, 0.10, 0.20, 0, 'capacitor_ceramico-SMD.jpg', 7, 'normal', 'novo', 9, 21)
;

INSERT INTO estoque (descr,
                      descrtec,
                       datasheet,
                       fabr,
                       und,
                       qtd,
                       qtdmin,
                       valorcusto,
                       valorvenda,
                       peso,
                       foto,
                       local,
                       situacao,
                       clasf,
                       catg,
                       subcatg) VALUES           # custo venda                           # local
('Trimpot Hor. Mini RF-637 500R','', 'trimpot_Hor_mini-02.jpg', 0, 'pc', 0, 1, 0.23, 0.46, 0, 'trimpot_RF-637.jpg', 69, 'normal', 'novo', 13, 72),
('Trimpot Hor. Mini RF-637 500R','', 'trimpot_Hor_mini-02.jpg', 0, 'pc', 0, 1, 0.23, 0.46, 0, 'trimpot_RF-637.jpg', 69, 'normal', 'novo', 13, 72);

SELECT * FROM estoque WHERE cod IN(1371, 1696);
SELECT * FROM estoque WHERE cod =2786;
INSERT INTO estoque (cod
SELECT * FROM estoque WHERE cod IN(3092,3093);
SELECT * FROM estobs WHERE codestq= 3172;
SELECT cod, descr, foto FROM estoque WHERE foto LIKE '%0805%';
SELECT cod, descr, foto, situacao FROM estoque WHERE descr LIKE 'Prod%';
SELECT cod, descr, valorvenda, valorcusto FROM estoque WHERE valorcusto=0.1 AND valorvenda=0.0 AND descr LIKE 'Capa% 0603';
UPDATE estoque SET valorvenda = 0.32 WHERE valorcusto=0.1 AND valorvenda=0.0 AND descr LIKE 'Capa% 0603';

SELECT * FROM estoque ORDER BY cod DESC;
SELECT cod, descr, nossonum, situacao FROM estoque WHERE descr LIKE 'Para% M3%';

DELETE FROM estoque WHERE cod= 1276;

UPDATE estoque SET `local` = 90 WHERE descr LIKE '78%';
UPDATE estoque SET `local` = 69, datasheet= 'datasheet_resistor SMD.pdf' WHERE `local`= 7 AND catg = 3;
SELECT cod, descr, `local`, catg, subcatg FROM estoque WHERE `local`= 7 AND catg = 3;

/**
** Para o Nosso Numero
**/
SELECT cod, descr, nossonum FROM estoque WHERE catg= 9 LIMIT 10;
# 9=Capacitores 3=resistores (43 Trimpots 44=Potenciometros) 4=CIs (10=Audio 9=diversos 8=Logico) 10=Conector
# 11= Ferragens (45= geral
# 1 = Transistores
UPDATE estoque est SET nossonum = CONCAT('CON0', est.cod) WHERE catg= 10 AND cod < 999;
UPDATE estoque est SET nossonum = CONCAT('CON', est.cod) WHERE catg= 10 AND cod > 999;

UPDATE estoque est SET nossonum = CONCAT('CIL0', est.cod) WHERE catg= 4 AND subcatg= 8 AND cod < 999;
UPDATE estoque est SET nossonum = CONCAT('CIL', est.cod) WHERE catg= 4 AND subcatg= 8 AND cod > 999;

UPDATE estoque est SET nossonum = CONCAT('FRG0', est.cod) WHERE catg= 11 AND subcatg= 45 AND cod < 999;
UPDATE estoque est SET nossonum = CONCAT('FRG', est.cod) WHERE catg= 11 AND subcatg= 45 AND cod > 999;
# Suplementos em geral
UPDATE estoque est SET nossonum = CONCAT('SUP0', est.cod) WHERE catg= 7 AND subcatg= 18 AND cod < 999;
UPDATE estoque est SET nossonum = CONCAT('SUP', est.cod) WHERE catg= 7 AND subcatg= 18 AND cod > 999;
# Transistores qq tipo
UPDATE estoque est SET nossonum = CONCAT('TRS00', est.cod) WHERE catg= 1 AND cod < 99;
UPDATE estoque est SET nossonum = CONCAT('TRS0', est.cod) WHERE catg= 1 AND cod < 999;
UPDATE estoque est SET nossonum = CONCAT('TRS', est.cod) WHERE catg= 1 AND cod > 999;

SELECT DISTINCT nossonum, cod, descr FROM estoque;# puxa toda a listagem
SELECT cod, descr, catg, subcatg FROM estoque WHERE nossonum LIKE('FER%') LIMIT 10;# Ferremantas
SELECT cod, descr, catg, subcatg FROM estoque WHERE nossonum LIKE('FRG%') LIMIT 10;# Ferragens
SELECT cod, descr, catg, subcatg FROM estoque WHERE nossonum LIKE('SUP%') LIMIT 10;# Suplementos
SELECT cod, descr, catg, subcatg FROM estoque WHERE nossonum LIKE('TRN%') LIMIT 10;# Suplementos
SELECT cod, descr, catg, subcatg FROM estoque WHERE nossonum LIKE('TRS%') LIMIT 10;# Transistores

# quais prefixos já existem
        SELECT DISTINCT nossonum
         FROM (SELECT SUBSTRING(nossonum, 1, 3) nossonum
                  FROM estoque
                  WHERE nossonum <> '') nvs;

        SELECT SUBSTRING(nossonum, 1, 3),
               nossonum
          FROM estoque
          WHERE nossonum <> ''
# cod = 287
         LIMIT 10;

/**
   Regras para o estoque minimo
- 2 pc para todos os resistores
- 0 (zero) para qualquer componente que nao precise manter em estoque, se nao for "colecionavel"
*/

/**
** FORNECEDORES
**/
# Excluindo um fornecedor
DELETE FROM fornecedor WHERE codestq= 1 AND codforn = 753 LIMIT 1;
SELECT codestq, codforn FROM fornecedor ORDER BY codestq;
        SELECT codestq,
               est.descr,
               codforn,
               cad.nome
          FROM fornecedor forn,
               getar_cad cad,
               estoque est
          WHERE forn.codestq = est.cod
                AND forn.codforn = cad.cod
                AND est.cod = 518
       ORDER BY codestq;

        SELECT est.cod,
               est.descr,
               forn.codforn,
               cad.nome,
               ped.cod codped
          FROM fornecedor forn,
               getar_cad cad,
               estoque est,
               estpedidocab ped
          WHERE forn.codestq = est.cod
                AND forn.codforn = cad.cod
                AND forn.codforn = ped.codforn
                AND ped.situ IN('processamento')
                AND est.cod = 542
       ORDER BY codestq;

       SELECT cad.nome,
              forn.codforn,
              est.descr
         FROM getar_cad cad,
              estoque est,
              fornecedor forn
        WHERE est.cod = forn.codestq
              AND cad.cod = 767
              AND est.cod = 367;

-- registro de retiradas sem afetar o estoque
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo)
                VALUES('2014-05-10', 295, 'pregis', 5, 'pc', 'Montagem QRP Novicio');
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo)
                VALUES(NOW(), 66, 'pregis', 1, 'pc', 'Montagem Medidor Indutancia Baixa frequencia'),
                      (NOW(), 11, 'pregis', 1, 'pc', 'Montagem Medidor Indutancia Baixa frequencia'),
                      (NOW(), 69, 'pregis', 1, 'pc', 'Montagem Medidor Indutancia Baixa frequencia'),
                      (NOW(), 24, 'pregis', 1, 'pc', 'Montagem Medidor Indutancia Baixa frequencia'),
                      (NOW(), 216, 'pregis', 1, 'pc', 'Montagem Medidor Indutancia Baixa frequencia'),
                      (NOW(), 211, 'pregis', 2, 'pc', 'Montagem Medidor Indutancia Baixa frequencia'),
                      (NOW(), 4, 'pregis', 2, 'pc', 'Montagem Medidor Indutancia Baixa frequencia'),
                      (NOW(), 127, 'pregis', 1, 'pc', 'Montagem Medidor Indutancia Baixa frequencia');
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo)
                VALUES(NOW(), 288, 'pregis', 4, 'pc', 'Painel teste transistor e triac'),
                      (NOW(), 453, 'pregis', 1, 'pc', 'Painel teste transistor e triac');
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo) VALUES(CURDATE(), 608, 'pregis', 3, 'pc', 'Doacao Marcia Renato PY3AB');
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo) VALUES(CURDATE(), 741, 'pregis', 2, 'pc', 'Doacao Marcia Renato PY3AB');
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo) VALUES(CURDATE(), 502, 'pregis', 2, 'pc', 'Doacao Pardal PU3LBT');
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo) VALUES(NOW(), 585, 'pregis', 1, 'pc', 'OS044');# 7905
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo) VALUES(NOW(), 270, 'pregis', 1, 'pc', 'OS044');# T410 600
INSERT INTO estretira (dia, codestq, usuario, qtd, und, motivo) VALUES(NOW(), 471, 'pregis', 1, 'pc', 'OS048');# 10uF/50

SELECT * FROM estretira ORDER BY cod DESC;
SELECT * FROM estretira WHERE motivo LIKE '%linear%';
SELECT * FROM estretira WHERE codestq= 1472;
ALTER TABLE estretira CHANGE `qtd` `qtd` DECIMAL(10,3) NOT NULL;

--
SELECT cod, DATE_FORMAT(dia, '%d/%m/%Y %h:%i'), user, motivo FROM estretira WHERE codestq = 79;
DESC estretira;

--Atualizar preco de uma determinada categoria de componentes
UPDATE estoque SET valorcusto = 0.12 WHERE catg= 3 AND subcatg = 6;

/**
** Gerenciando categorias de produtos
**/
SELECT * FROM estcatg WHERE descr = 'Diversos';
SELECT * FROM estcatg WHERE cod = 18;
SELECT * FROM estsubcatg WHERE codcatg= 6;
INSERT INTO estsubcatg (codcatg, descr, situacao) VALUES(3, 'alta dissipacao', 'ativo');

SELECT cod, descr FROM estcatg WHERE situacao = 'ativo' ORDER BY descr DESC;

SELECT cod, descr, situacao FROM estoque WHERE catg = 8;# diversos

    SELECT ct.cod,
           ct.descr,
           (SELECT COUNT(*) FROM estoque WHERE ct.cod = estoque.catg) nmitct,
           ct.situacao situ,
           sb.cod codsub,
           sb.descr descrsub,
           (SELECT COUNT(*) FROM estoque WHERE sb.cod = estoque.subcatg) nmitsb,
           sb.situacao situsub
      FROM estcatg ct,
           estsubcatg sb
      WHERE ct.cod = sb.codcatg
        ORDER BY ct.descr, sb.descr;
UPDATE estoque SET catg = 9, subcatg = 42 WHERE descr LIKE '%Trimmer%';
UPDATE estoque SET catg = 12, subcatg = 65 WHERE cod IN(1206, 1207, 1516, 1620, 1675);
SELECT * FROM estcatg WHERE descr LIKE ('%integrado'); # codigo 4
SELECT * FROM estsubcatg WHERE codcatg= 4; # audio codigo 10
SELECT cod, descr, qtd FROM estoque WHERE catg = 6;
SELECT cod, descr, qtd FROM estoque WHERE catg = 4 AND subcatg= 10;

-- Listagem dos itens colecionaveis
SELECT cod,
      qtd,
      descr,
      valorcusto,
      (SELECT nome FROM getar_cad WHERE cod = est.fabr) Fabricante
 FROM estoque est
WHERE clasf = 'colec'
      -- AND qtd = 0
ORDER BY descr;

-- Com datasheet
SELECT cod,
      qtd,
      descr,
      valorcusto,
      (SELECT nome FROM getar_cad WHERE cod = est.fabr) Fabricante
 FROM estoque est
WHERE datasheet <> ''
ORDER BY descr;

-- listar resistores com menos de 5 pc no estoque
SELECT cod,
       descr,
       qtd,
       ' ' QtdPedido,
       valorcusto
  FROM estoque
WHERE catg= 3
      AND subcatg = 6
      AND qtd < 5
ORDER BY descr ASC;

-- listar os resistores em sequencia de valores
SELECT descr,
        qtd,
        ' ' QtdPedido,
        valorcusto,
        CAST(REPLACE(SUBSTRING(descr, 10, 4), 'K', '.') AS DECIMAL(5,2)) vl
   FROM estoque
  WHERE catg= 3
        AND subcatg = 6
        AND descr LIKE '%K%'
  ORDER BY vl ASC;


(SELECT descr,
        qtd,
        ' ' QtdPedido,
        valorcusto,
        CAST(REPLACE(SUBSTRING(descr, 10, 4), 'K', '.') AS DECIMAL(5,2)) vl
   FROM estoque
  WHERE catg= 3
        AND subcatg = 6
        AND descr LIKE '%K%')
UNION(SELECT descr,
             qtd,
             ' ' Qtd,
             valorcusto,
             CAST(REPLACE(SUBSTRING(descr, 10, 4), 'M', '.') AS DECIMAL(5,2))* 1000 vl
        FROM estoque
      WHERE catg= 3
            AND subcatg = 6
            AND descr LIKE '%M%')
ORDER BY vl ASC;-- quando tento como o 'R' mistura tudo, sozinho o 'R' pega o K e o M tambem

/**
* listar os capacitores em sequencia de valores
*/
SELECT descr,
        qtd,
        ' ' QtdPedido,
        valorcusto,
        CAST(SUBSTRING(descr, 19, 4) AS DECIMAL(5,2)) vl--Capacitor ceramico
   FROM estoque
  WHERE catg= 9
        AND subcatg = 21
        AND descr LIKE '%pF%'
  ORDER BY vl ASC;

-- lista completa
(SELECT descr,
        qtd,
        ' ' QtdPedido,
        valorcusto,
        CAST(SUBSTRING(descr, 19, 4) AS DECIMAL(5,2)) vl
   FROM estoque
  WHERE catg= 9
        AND subcatg = 21
        AND descr LIKE '%pF%')
UNION(SELECT descr,
        qtd,
        ' ' QtdPedido,
        valorcusto,
        CAST(SUBSTRING(descr, 19, 4) AS DECIMAL(5,2))*1000 vl
   FROM estoque
  WHERE catg= 9
        AND subcatg = 21
        AND descr LIKE '%nF%')
  ORDER BY vl ASC;

/**
** MANUTENCAO TABELAS DE PEDIDOS
**/

# Criando cabecalho de um pedido
INSERT INTO estpedidocab (codforn, tipo) VALUES(769); # Cria um pedio em modo EM PROCESSAMENTO

# pesquisas
SELECT * FROM estpedidocab WHERE cod = 638; # PED638 Fonte 13,8V 30A Bancada
SELECT * FROM estpedidocab WHERE codforn = 555; # 555 Daniel Alves Cunhado
SELECT * FROM estpedidocab WHERE cod IN (10, 9);
SELECT * FROM estpedidocab WHERE ospro = 650;
SELECT * FROM estpedidocab WHERE situ= 'estudo';# mudar para  "orcamento"
SELECT * FROM estpedidocab WHERE situ= 'pago' ORDER BY cod DESC;
SELECT * FROM estpedidoitem WHERE codped = 312 AND codest= 2288; # Proesi
SELECT coditem, codped, codest, qt, custo FROM estpedidoitem WHERE codped = 43;

# para edicao de item no pedido
         SELECT it.coditem,
                it.codped,
                it.codest,
                est.descr,
                it.qt,
                it.custo
           FROM estpedidoitem it,
                estoque est
          WHERE est.cod = it.codest
                AND est.cod = 627
                AND codped = 43;

SELECT * FROM estobs obs WHERE codestq = 3362;
SELECT * FROM estobs obs WHERE cod = 1358;
SELECT COUNT(*) FROM estobs obs WHERE obs.codestq = 3362;

# pesquisa por descricao tecnica do produto
SELECT cod, descr, descrtec FROM estoque WHERE descrtec LIKE 'dual%';

# com listagem
        SELECT cod,
               (SELECT nome FROM getar_cad WHERE cod = cab.codforn) Fornecedor,
               DATE_FORMAT(dtped, '%d/%m/%Y') DataPed,
               DATE_FORMAT(dtcheg, '%d/%m/%Y') DataCheq,
               DATE_FORMAT(dtrecb, '%d/%m/%Y') DataRecb,
               (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cab.cod) Qt,
               situ,
               '-' sep,
               codforn,
               codcli
          FROM estpedidocab cab
         WHERE 1 =1
               # AND situ= 'recebido'
               AND tipo = 'compra'
               AND codforn = 752 # Proesi
         ORDER BY cod DESC;

# descobrindo fornecedores de um produto
        SELECT itm.codped pedidonum,
               cad.nome forn,
               est.descr descr,
               ped.tipo
          FROM estpedidoitem itm,
               estpedidocab ped,
               estoque est,
               getar_cad cad
         WHERE ped.cod = itm.codped
               AND est.cod = itm.codest
               AND cad.cod = ped.codforn
               AND ped.tipo = 'compra'
               # AND itm.codest = 237;# Capacitor 33uF/16
               # AND est.descr LIKE 'Macho%';
               AND est.catg IN(11, 5); # 11 - ferragens 5 - ferramentas
# Listando fornecedores de Ferragens
SELECT cod, descr FROM estoque WHERE catg IN(11, 5); # 11 - ferragens 5 - ferramentas
SELECT  FROM estoque WHERE catg IN(11, 5);
        SELECT DISTINCT nome fornecedor,
               cidade,
               estado
          FROM getar_cad
         WHERE cod IN(SELECT DISTINCT ped.codforn
                       FROM estpedidoitem itm,
                            estpedidocab ped,
                            estoque est
                      WHERE ped.cod = itm.codped
                            AND est.cod = itm.codest
                            AND ped.tipo = 'compra'
                            AND ped.situ NOT IN ('cancelado')
                            AND est.catg IN(11, 5));

SELECT * FROM estoque ORDER BY cod DESC;
SELECT cod, descr, valorcusto, valorvenda FROM estoque WHERE cod IN(3367,3368,3369,3370);
# inserindo pedido de consumo para o pedido 644, cabo forca 6 pinos
# inserir um pedido de compra pelo GETAR e pegar seu numero
SELECT * FROM estpedidocab WHERE cod= 526;
# agora alterar 'tipo' para 'consumo' e em 'ospro' colocar o numero do pedido eletronico

# estudos para inserir pedido de consumo vinculada ao pedido eletronico PE100
SELECT DISTINCT tipo FROM estpedidocab ORDER BY cod DESC; 
SELECT cod, codforn, ospro, tipo, situ FROM estpedidocab WHERE tipo= 'consumo' ORDER BY cod DESC; 

# pedidos de compra
SELECT * FROM estpedidocab ORDER BY cod DESC;
SELECT * FROM estpedidocab WHERE tipo = 'compra' ORDER BY cod DESC;
SELECT * FROM estpedidocab WHERE ospro = 615;
SELECT * FROM estpedidocab WHERE cod = 545;# Radio Componentes
SELECT * FROM estpedidoitem WHERE codped = 560;
SELECT * FROM estpedidoitem WHERE codped = 296;# Proesi
SELECT * FROM estpedidoitem WHERE codped = 639;# Solda Fria
SELECT * FROM estpedidoitem WHERE codped = 520;# Eletro Parts
SELECT * FROM estpedidoitem WHERE codped = 607;# OS570
SELECT * FROM estpedidoitem WHERE codped = 610;# Joao Paiva Cristais

SELECT * FROM estpedidocab WHERE situ = 'pago';# Gerador de RF- VHF

# descobrindo pedido de reposicao
    SELECT ped.cod,
           cad.nome,
           ped.dtped,
           ped.dtrecb
     FROM estpedidocab ped,
          getar_cad cad
     WHERE ped.codforn= cad.cod
           AND ped.tipo= 'compra'
 ORDER BY ped.cod DESC,ped.dtped ASC;

    SELECT est.cod,
           est.descr,
           cab.cod
      FROM estoque est,
           estpedidocab cab,
           estpedidoitem it
     WHERE cab.cod= it.codped
           AND est.cod= it.coditem
           AND cab.cod= 233;

SELECT * FROM estoque ORDER BY cod DESC;
SELECT * FROM estoque WHERE cod =2432;
SELECT * FROM estpedidocab ORDER BY cod DESC;
SELECT cod, nomeped, codforn FROM estpedidocab ORDER BY nomeped DESC;
SELECT * FROM estpedidocab WHERE tipo= 'venda';
SELECT * FROM estpedidocab WHERE ospro= 98;# vendo pedido do projeto Base de Tempo
SELECT * FROM estpedidocab WHERE codforn= 389;# Proesi
SELECT * FROM estpedidocab WHERE cod= 627;# Eletro Parts Baterias
SELECT * FROM estpedidocab WHERE cod= 410; # montagem do OCXO
SELECT * FROM estpedidocab WHERE cod = 631;# Pedido Ebay MC146805
SELECT * FROM estpedidocab WHERE cod = 609;# Pedido Mouser

SELECT * FROM estpedidoitem WHERE situ LIKE 'e%';

SELECT * FROM estpedidoitem WHERE codped = 618;
SELECT * FROM estpedidoitem WHERE codped = 448;# Radio Componentes
SELECT * FROM estpedidoitem WHERE codped = 301;# Mamute Eletronica
SELECT * FROM estpedidoitem WHERE codped = 261;# Casa do Resistor
SELECT * FROM estpedidoitem WHERE codped = 430;# Tigger
SELECT * FROM estpedidoitem WHERE codped = 530;# Proesi
SELECT * FROM estpedidoitem WHERE codped = 551;# Usinainfo
SELECT * FROM estpedidoitem WHERE codped = 432;# Solda fria
SELECT * FROM estpedidoitem WHERE codped = 531;# Santa Efigenia
SELECT * FROM estpedidoitem WHERE codped = 706;# ML Componentes

SELECT coditem, codped, qt FROM estpedidoitem WHERE codest= 1918;

# se um determinado tipo de componente jah fou usada
        SELECT est.cod,
              est.descr,
              it.codped,
              cab.tipo
         FROM estoque est,
              estpedidocab cab,
              estpedidoitem it
         WHERE est.cod = it.codest
               AND it.codped = cab.cod
               AND cab.tipo = 'venda'
               AND est.descr LIKE 'Capa%33uF%';

# nao funciona 
# Table 'estpedidoitem' is specified twice, both as a target for 'DELETE' and as a separate source for data
# DELETE FROM estpedidoitem WHERE codped = 274 AND codest IN (SELECT codest FROM estpedidoitem WHERE codped = 258);

SELECT codest FROM estpedidoitem WHERE codped = 274 AND codest IN (SELECT codest FROM estpedidoitem WHERE codped = 258);

SELECT tipo FROM estpedidocab;

# pedido 
INSERT INTO estpedidoitem (codped, codest, qt, custo)
                   VALUES (351, 2982, 2, 0.23),
                    (351, 2983, 2, 0.23),
                    (351, 2984, 2, 0.23),
                    (351, 2985, 2, 0.23),
                    (351, 2986, 2, 0.23),
                    (351, 2987, 2, 0.23),
                    (351, 2988, 2, 0.23),
                    (351, 2989, 2, 0.23),
                    (351, 2990, 2, 0.23),
                    (351, 2991, 2, 0.23),
                    (351, 2992, 2, 0.23),
                    (351, 2993, 2, 0.23),
                    (351, 2994, 2, 0.23),
                    (351, 2995, 2, 0.23),
                    (351, 2996, 2, 0.23),
                    (351, 2997, 2, 0.23),
                    (351, 2998, 2, 0.23),
                    (351, 2999, 2, 0.23),
                    (351, 2300, 2, 0.23),
                    (351, 3001, 2, 0.23);

# Casa do Resistor - Cad 1061
# Solda Fria Cad751
INSERT INTO fornecedor (codestq, codforn)
                VALUES(2982, 751),
                (2983, 751),
                (2984, 751),
                (2985, 751),
                (2986, 751),
                (2987, 751),
                (2988, 751),
                (2989, 751),
                (2990, 751),
                (2991, 751),
                (2992, 751),
                (2993, 751),
                (2994, 751),
                (2995, 751),
                (2996, 751),
                (2997, 751),
                (2998, 751),
                (2999, 751),
                (2300, 751),
                (3001, 751);
SELECT * FROM fornecedor WHERE codestq= 1746;
SELECT * FROM fornecedor WHERE codforn= 751 ORDER BY codestq DESC;

         SELECT cb.cod codpedido,
                cad.nome forn,
                cb.situ,
                cb.tipo,
                (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtintens
           FROM getar_cad cad,
                estpedidocab cb
           WHERE cb.codforn = cad.cod
                 AND cb.situ IN ('processamento', 'transito');

SELECT * FROM estpedidocab WHERE codforn= 752 ORDER BY cod DESC;
SELECT * FROM estpedidoitem WHERE codped= 294;

# auto preencher capacitores ceramicos do pedido da casa do resistor
# sao 58 itens
# Código do erro 1093, estado do SQL HY000: Table 'estoque' is specified twice, both as a target for 'UPDATE' and as a separate source for data
UPDATE estoque SET qtd= 20 WHERE cod in (
        SELECT est.cod
               # it.codped,
               # est.descr
          FROM estpedidoitem it,
               estoque est
         WHERE est.cod = it.codest
               AND est.descr LIKE 'Capa%'
               AND it.codped = 261);


# pesquisando item mais usados
      SELECT cab.cod codPed,
             cab.tipo,
             est.descr,
             (SELECT SUM(soma.qt)
               FROM estpedidoitem soma
              WHERE soma.codest = est.cod
                    AND cab.cod = soma.codped ) consumo,
             est.subcatg
        FROM estpedidocab cab,
             estpedidoitem it,
             estoque est
       WHERE it.codped = cab.cod
             AND it.codest = est.cod
             AND est.catg = 9 AND est.subcatg = 22 # capacitor eletrolitico
             AND cab.tipo IN('venda')# , 'consumo')
        ORDER BY consumo DESC;

SELECT est.cod, est.descr, est.qtd FROM estoque est WHERE est.catg = 9 AND est.subcatg = 22 ORDER by est.qtd ASC; # capacitor eletrolitico
SELECT * FROM estoque WHERE cod = 1598;

          SELECT DISTINCT(est.cod) codest                 
            FROM estpedidocab cab,
                 estpedidoitem it,
                 estoque est
           WHERE cab.tipo = 'venda'
                 AND it.codped = cab.cod
                 AND est.cod = it.codest
                 AND est.catg = 9 AND est.subcatg = 22
                 AND it.qt >2;

# capacitores eletroliticos abaixo do estoque minimo
     SELECT '--' codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            '--' fornc,
            '--' qtd,
            '--' valorcusto,
            '--' situpedido,
            '--' situitem
       FROM estoque est
      WHERE est.qtd < est.qtdmin
            AND est.situacao = 'normal'
            AND est.catg = 9 AND est.subcatg = 22;

SELECT codest,
        descr,
        qtd,
        consumo
FROM
         (SELECT est.cod codest,
                est.descr,
                est.qtd,
                # cab.cod codpedido,
                # it.qt,
                (SELECT SUM(it.qt)
                   FROM estpedidocab cab,
                        estpedidoitem it
                  WHERE cab.tipo = 'venda'
                        AND it.codped = cab.cod
                        AND it.codest = est.cod) consumo
          FROM estoque est
         WHERE est.cod IN(SELECT DISTINCT(est.cod) codest                 
                            FROM estpedidocab cab,
                                 estpedidoitem it,
                                 estoque est
                           WHERE cab.tipo = 'venda'
                                 AND it.codped = cab.cod
                                 AND est.cod = it.codest
                                 AND est.catg = 9 AND est.subcatg = 22)) est
           WHERE 1 = 1
                 # AND qtd < consumo
                 AND qtd < 10
                 AND consumo > 20
        ORDER BY consumo DESC;

         SELECT SUM(it.qt)
                   FROM estpedidocab cab,
                        estpedidoitem it
                  WHERE cab.tipo = 'venda'
                        AND it.codped = cab.cod
                        AND it.codest = 3509;

                 # AND it.codest = 1484; # Capacitor eletrolitico SMD 10uF x 16V, são 22 peças em OSs

/* inserindo itens no pedido */
INSERT INTO estpedidoitem (codped, codest, qt, custo, situ)# soldafria
                    VALUES(4, 478, 10, 0.14, 'esg'),# term auto DJ622
                          (4, 662, 1, 1.11, ''),# 
                          (4, 467, 2, 0.68, ''),# 
                          (4, 736, 2, 1.79, ''),# 
                          (4, 596, 2, 0.39, '');# 

# manutencoes nos pedidos
        SELECT it.codest,
               estq.descr
          FROM estpedidoitem it,
               estoque estq
         WHERE it.codest = estq.cod
               # AND it.codest IN (487, 666, 467)
               AND situ= 'esg'
               AND it.codped = 4;

DELETE FROM estpedidoitem WHERE codped= 9 AND codest= 734 LIMIT 1;
DELETE FROM estpedidoitem WHERE codped= 4 AND situ= 'esg';
UPDATE estpedidoitem SET situ= 'esg' WHERE codped= 10 AND codest = 552;
UPDATE estpedidoitem SET situ= 'esg' WHERE codped= 10 AND codest IN(584, 572, 552, 542);

/**
** Nao tem no Soldafria, na Proesi e na Eletroparts
**/


/* consultando pedido */
SELECT cb.cod codpedido,
       cad.nome,
       estq.descr,
       estq.`local`,
       estq.cod,
       pd.qt,
       pd.custo,
       cb.situ
  FROM estoque estq,
       getar_cad cad,
       estpedidocab cb,
       estpedidoitem pd
 WHERE estq.cod = pd.codest
       AND pd.codped = cb.cod
       AND cad.cod = cb.codforn
       AND cb.cod = 8
      # AND cb.situ IN('processamento', 'transito')
ORDER BY codpedido, descr;

         SELECT cb.cod codped,
                (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                estq.descr,
                estq.cod,
                pd.qt,
                (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                pd.custo,
                cb.situ,
                cb.tipo,
                pd.situ situitem
           FROM estoque estq,
                estpedidocab cb,
                estpedidoitem pd
          WHERE estq.cod = pd.codest
                AND pd.codped = cb.cod
                 AND cb.situ IN('processamento', 'transito') 
         ORDER BY codpedido, descr;

SELECT * FROM estpedidocab WHERE cod = 24;

DELETE FROM estpedidoitem 
      WHERE codest = 378 # IN(235, 339, 471,470, 352, 420, 244, 452)
            AND codped = 4
      LIMIT 1;
UPDATE estpedidocab SET dtped= '2014-08-02' AND cod = 8;
UPDATE estpedidoitem SET codest=74 WHERE codest = 272 AND codped = 8;
/* Para inserir 3 pedido antigos */
UPDATE estpedidoitem SET codped = 4 WHERE codped= 1;
SELECT * FROM estpedidocab WHERE cod=4;
SELECT * FROM estpedidoitem WHERE codped = 10 AND codest = 493;
DELETE FROM estpedidoitem WHERE codped = 4 AND codest = 566;
DELETE FROM estoque WHERE cod= 566;
DELETE FROM fornecedor WHERE codestq= 725;

SELECT COUNT(*) numforn FROM fornecedor WHERE codestq= 3539 AND codforn = 751;

/** Listagem para insercao **/
         SELECT codped,
                nome,
                projeto,
                equipo,
                # tpcons,
                ospro,
                tipo                    
           FROM (SELECT cb.cod codped,
                        cad.nome,
                        (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
                           FROM eletro_projetos pj,
                                eletro_pedidos pd 
                          WHERE pj.cod = pd.codproj
                                AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('<b>OS Numero: </b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                           FROM ordem od, equipo eq
                          WHERE od.cod = cb.ospro 
                                AND od.codeqp = eq.cod) equipo,
                        (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = " . $dados['cod'] . ") AS numitem,
                        # cb.tpcons,
                        cb.ospro,
                        cb.situ,
                        cb.tipo
                   FROM estpedidocab cb,
                        getar_cad cad
                  WHERE cad.cod = cb.codcli
                        AND cb.resp = 'pregis'
                        AND cb.tipo IN ('venda', 'consumo')
                        AND cb.situ = 'processamento') as cb
          WHERE numitem = 0;

  SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
    FROM eletro_projetos pj,
         eletro_pedidos pd
   WHERE pj.cod = pd.codproj
         AND pd.cod = 53;

  SELECT CONCAT('<b>OS Numero: </b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
    FROM ordem od,
         equipo eq
   WHERE od.cod = 195 
     AND od.codeqp = eq.cod;
SELECT * FROM estpedidocab WHERE cod= 195;


/**
** LOCAL DOS COMPONENTES
** manutencao do local
**/
SELECT cod, descr, `local` FROM estoque WHERE `local`= 20;
SELECT cod, descr, `local` FROM estoque WHERE descr LIKE 'Resi% 1W';
UPDATE estoque SET `local` = 96 WHERE descr LIKE 'Resi% 2W%';

/* Ver componente recebidos e que nao local definido */
SELECT codpedido,
       nome fornecedor,
       descr,
       local,
       qt,
       st
FROM(SELECT cb.cod codpedido,
            cad.nome,
            estq.descr,
            # lc.etq local,
            estq.local,
            pd.qt,
            CASE
                WHEN cb.dtped =  0 THEN 'processamento'
                WHEN cb.dtrecb = 0 THEN 'transito'
                ELSE 'recebido'
            END AS st
       FROM estoque estq,
            getar_cad cad,
            estpedidocab cb,
            estpedidoitem pd/*,
            estlocal lc*/
      WHERE estq.cod = pd.codest
            AND pd.codped = cb.cod
            AND cad.cod = cb.codforn
            # AND lc.cod = estq.local
            ) tst
WHERE local= 0
      AND st = 'recebido'
ORDER BY descr;

# quadra e rua
SELECT * FROM estquadra;
SELECT * FROM estrua;
SELECT * FROM estquadra WHERE etq LIKE 'CAP%';
SELECT * FROM estquadra WHERE cod= 1;
SELECT * FROM estquadra WHERE situacao = 'ativo';
SELECT * FROM estlocal WHERE etq LIKE 'SUP018';
SELECT * FROM estlocal WHERE etq LIKE 'DV%';
SELECT * FROM estlocal WHERE cod = 6;

# para edicao do Local
     SELECT lc.etq,
            lc.descr,
            lc.quadra,
            lc.categ,
            qd.etq etqquadra,
            ru.etq etqrua,
            lc.situacao
       FROM estlocal lc,
            estquadra qd,
            estrua ru
       WHERE lc.numest = 1
            AND qd.cod = lc.quadra
            AND ru.cod = qd.codrua
            AND lc.cod= 6;

ALTER TABLE estlocal ADD `situacao` VARCHAR(20) DEFAULT 'ativo' AFTER descr;
SELECT * FROM estlocal WHERE cod=1;

        SELECT cod,
               etq,
               quadra,
               descr,
               situacao
          FROM estlocal
        ORDER BY etq;

        SELECT estq.cod,
               estq.descr,
               estq.`local`,
               lc.etq
          FROM estoque estq,
               estlocal lc
         WHERE estq.`local` = lc.cod
               AND estq.descr LIKE '%pilhas AA%';
UPDATE estoque SET `local`= 38 WHERE descr LIKE 'BTA%';

UPDATE estoque SET `local`= 73 WHERE cod IN(792, 309, 818, 1314, 1520, 1333, 307, 1242, 1285, 921, 284, 956);# criado DIO002 aproveitar melhor o espaco
UPDATE estoque SET `local`= 25 WHERE descr LIKE ('Soquete Base%');
SELECT cod, descr, `local` FROM estoque WHERE descr LIKE ('Soquete Torneado%');
SELECT cod, descr, `local` FROM estoque WHERE `local` = 20;
SELECT cod, descr, `local` FROM estoque WHERE codforn = 917;
SELECT cod, descr, `local` FROM estoque WHERE valorcusto = 50.000;
SELECT cod, descr, `local` FROM estoque WHERE `local` = 24;
SELECT * FROM fornecedor;

        SELECT est.cod,
               est.descr,
               est.`local`
          FROM estoque est,
               fornecedor fnc
         WHERE est.cod = fnc.codestq
               AND fnc.codforn = 917;

UPDATE estoque SET `local`= 52 WHERE descr LIKE 'Capacitor eletrolitico%SMD%';
SELECT cod, descr, `local` FROM estoque WHERE descr LIKE 'Capacitor eletrolitico%SMD%';
INSERT INTO estlocal (etq, descr) VALUES ('FER003', 'Buchas, ganchos, etc');
SELECT * FROM estlocal WHERE etq = 'DIO002';

/**
** Categorias
**/
SELECT cod, descr,nossonum, `local`, catg, subcatg FROM estoque WHERE descr LIKE 'Broca%';
UPDATE estoque SET catg = 13, subcatg = 72 WHERE descr LIKE 'Microchoque%';# Indutor - Microchoque
UPDATE estoque SET catg = 7, subcatg = 18 WHERE descr LIKE 'Fita%';# Suprimento - Geral
UPDATE estoque SET catg = 14, subcatg = 76 WHERE descr LIKE 'Cristal%';# Ressonador - Cristal
UPDATE estoque SET catg = 14, subcatg = 78 WHERE descr LIKE 'Ressonador%';# Ressonador - Ceramico
UPDATE estoque SET catg = 14, subcatg = 79 WHERE descr LIKE 'Filtro Ceramico%';# Ressonador - Filtro Ceramico
UPDATE estoque SET catg = 15, subcatg = 84 WHERE descr LIKE 'Porta Fusivel%';# Fusivel - xxx
UPDATE estoque SET catg = 10, subcatg = 54 WHERE descr LIKE 'Borne Pino%';# .
SELECT cod, descr, `local`, catg, subcatg FROM estoque WHERE foto = 'lampada03%';


SELECT cod, descr, local FROM estoque WHERE cod = 1348;
UPDATE estoque SET foto='fusivel_pequeno.jpg' WHERE descr LIKE 'Fusivel%';

UPDATE estoque SET `local`= 63 WHERE cod IN(1800, );# CP018
UPDATE estoque SET `local`= 77 WHERE cod IN(010);# .
UPDATE estoque SET `local`= 7 WHERE descr LIKE 'Trimmer%';# 
UPDATE estoque SET `local`= 26 WHERE `local`= 23;
UPDATE estoque SET `local`= 64 WHERE `local`= 21 AND descr LIKE ('Trimpot%');

SELECT * FROM estlocal WHERE etq LIKE 'SUP%';
SELECT * FROM estlocal WHERE etq = 'SUP016';
SELECT * FROM estlocal WHERE etq LIKE 'CON%';
SELECT * FROM estlocal;
SELECT * FROM estoque WHERE cod = 2035;
ALTER TABLE `estlocal` ADD `quadra` INT NOT NULL DEFAULT '1' COMMENT 'Quadra em que esta' AFTER `etq`;
ALTER TABLE `estlocal` DROP `quadra`;
ALTER TABLE `estoque` CHANGE `local` `local` INT(11) NOT NULL DEFAULT '1';

# Selecionar componente que estao em determinia local
SELECT COUNT(*) FROM estoque WHERE `local` = 20;
        SELECT est.cod,
               est.descr,
               (SELECT etq FROM estlocal WHERE cod=est.`local`) localestq
          FROM estoque est
         WHERE `local` = 53;

         SELECT estq.cod,
                estq.descr,
                loc.etq
         FROM estoque estq,
              estlocal loc
         WHERE estq.local= loc.cod
               AND estq.descr LIKE 'Capacitor eletrolitico%';

         SELECT DISTINCT loc.etq
         FROM estoque estq,
              estlocal loc
         WHERE estq.local= loc.cod
               AND estq.descr LIKE 'Capacitor eletrolitico%';

SELECT * FROM estlocal LIMIT 5;
SELECT COUNT(*) FROM estoque WHERE `local`;

         SELECT loc.cod,
                loc.etq,
                (SELECT COUNT(*) FROM estoque WHERE `local` = loc.cod) numitm,
                loc.descr,
                loc.situacao
           FROM estlocal loc
           WHERE loc.situacao = 'ativo'
           LIMIT 5;
           

/**
** incrementando RUAS - QUADRAS
**/
INSERT INTO estrua (etq, descr) VALUES ('Laboratorio', 'Prateleiras do laboratorio');
INSERT INTO estrua (etq, descr) VALUES ('Armario 1', 'Gavetas que estao no banheiro social');
SELECT * FROM estrua;

INSERT INTO estquadra (codrua, etq, descr) VALUES (1, 'Prat. Esq.', 'Prateleiras do laboratorio lado Esquerdo de quem entra');
INSERT INTO estquadra (codrua, etq, descr) VALUES (2, 'Prat. Dir.', 'Prateleiras do laboratorio lado Direito de quem entra');

SELECT cod, etq FROM estquadra ORDER BY etq ASC;
SELECT cod, etq, quadra, situacao FROM estlocal WHERE etq = 'SUP014';
SELECT cod, etq, quadra, categ, situacao FROM estlocal WHERE etq LIKE 'SUP%';

SELECT cod, etq FROM estquadra WHERE codrua = 1 ORDER BY etq ASC;
# TRUNCAT TABLE quadra;

SELECT * FROM estquadra ORDER BY etq ASC;
SELECT cod, descr FROM estoque WHERE `local` = 29;
SELECT cod, etq, quadra, descr, categ FROM estlocal WHERE cod= 74;
SELECT cod, etq, quadra, categ, situacao FROM estlocal WHERE etq = 'SUP018';
SELECT * FROM estoque WHERE cod= 2107;

-- Atualizar local de uma categoria
UPDATE estoque SET local = 1 WHERE catg = 1; -- transistores
UPDATE estoque SET local = 68 WHERE descr LIKE 'Capacitor Stiroflex%' AND local= 6; -- capacitores ceramicos de disco
UPDATE estoque SET local = 68 WHERE descr LIKE 'Capacitor Poliester%' AND local= 6; -- capacitores ceramicos de disco
UPDATE estoque SET local = 6 WHERE descr LIKE 'Capacitor ceramico%SMD%'; -- resistores
UPDATE estoque SET local = 74 WHERE descr LIKE 'Toroide%';

SELECT cod, descr FROM estoque WHERE descr LIKE 'Microchoque%' AND local= 6;

SELECT cod, descr, local FROM estoque WHERE cod= 0216;
UPDATE estoque SET und = 'und'  WHERE catg= 3 AND subcatg = 6;
SELECT descr, und FROM estoque WHERE catg= 3 AND subcatg = 6;
# capacitores eletroliticos para a CP009
SELECT cod, descr, `local` FROM estoque WHERE catg= 9 AND subcatg = 22;
UPDATE estoque SET `local` = 32 WHERE catg= 9 AND subcatg = 22;
UPDATE estlocal SET situacao= 'inativo' WHERE etq LIKE 'FER0%';

# vinculando um box a uma categoria
SHOW CREATE TABLE estlocal;
CREATE TABLE `estlocal` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `etq` varchar(8) NOT NULL,
  `quadra` int(11) NOT NULL DEFAULT '1' COMMENT 'Quadra em que esta',
  `descr` text NOT NULL COMMENT 'Descrição do local gavata ou caixa onde esta o componente',
  `situacao` varchar(20) DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

ALTER TABLE estlocal ADD `categ` INT(11) DEFAULT 1 AFTER quadra;
SELECT * FROM estlocal WHERE etq LIKE 'FER0%';
SELECT * FROM estlocal WHERE etq = 'SUP015';
SELECT * FROM estlocal WHERE cod = 2;
UPDATE estlocal SET categ= 7 WHERE etq LIKE 'T00%';
UPDATE estlocal SET categ= 7 WHERE etq LIKE 'SUP%';

SELECT COUNT(*) num FROM estlocal WHERE categ= 7;

SELECT cod, descr, qtd, `local` FROM estoque WHERE cod = 476;

# para montar o select personalizado
         SELECT cod,
                etq,
                descr
           FROM estlocal
          WHERE categ = 7
       ORDER BY etq ASC;

SELECT COUNT(*) num FROM estlocal WHERE categ= 10;


# produtos sem local definido
SELECT cod, descr, `local` FROM estoque WHERE `local` = 46;
SELECT * FROM estoque WHERE `local`= '';
SELECT * FROM estoque WHERE cod= 848;
SELECT cod, descr, `local` FROM estoque WHERE `local` NOT IN(SELECT cod
                                              FROM estlocal);
SELECT * FROM estlocal ORDER BY cod LIMIT 3;
SELECT cod, etq, quadra, descr FROM estlocal WHERE cod= 62;
UPDATE estoque SET `local` = 62 WHERE descr LIKE 'Fio cobre%' AND local = 1;
SELECT cod, descr, qtd FROM estoque WHERE descr LIKE 'Fio cobre%' AND local = 1;
UPDATE estoque SET `local` = 1 WHERE `local`= '';# valor truncado
UPDATE estoque SET `local` = 1 WHERE `local`= 0;

/**
** MANUTENCAO DE PEDIDOS
**/


/* se um item esta sendo pedido */
SELECT pd.codped,
       estq.descr,
       pd.qt,
       pd.custo,
       CASE
           WHEN cb.dtped =  0 THEN 'processamento'
           WHEN cb.dtrecb = 0 THEN 'transito'
           ELSE 'recebido'
       END AS stpedido
  FROM estoque estq,
       estpedidocab cb,
       estpedidoitem pd
 WHERE estq.cod = pd.codest
       AND pd.codped = cb.cod
       AND estq.cod = 348;

/*
* Verificar se tem algum produto que precisse ser encomendado mas seu campo 
* estoque minimo esta zerado
*/
    SELECT cod,
           descr,
           qtd,
           qtdmin
      FROM estoque
     WHERE qtdmin = 1
           AND clasf NOT IN('colec')
           AND qtd < 2;
/**
** Listagem geral para pedidos
**/
    SELECT estq.cod cod_estoque,
            estq.descr,
            estq.qtd,
            ' ' QtdPedido,
            estq.valorcusto,
           (SELECT CASE
                       WHEN cb.dtped =  0 THEN 'processamento'
                       WHEN cb.dtrecb = 0 THEN 'transito'
                       ELSE 'recebido'
                   END AS stpedido
             FROM estpedidocab cb,
                  estpedidoitem it
            WHERE cb.cod = it.codped
                  AND it.codest = estq.cod
            LIMIT 1) AS stpedido
     FROM estoque estq
     WHERE estq.qtd < estq.qtdmin
           AND estq.clasf IN ('novo', 'usado')
  ORDER BY stpedido, descr;

/**
* LISTAGEM GERAL PARA PEDIDOS
* Dando tratamento adquado para os NULL dos componentes que ainda nao foram pedidos
**/
         SELECT codpedido,
                descr,
                cod,
                fornc,
                qtd qt,
                valorcusto custo,
                situpedido,
                situitem
           FROM (
      SELECT '' codpedido,
             estq.cod,
             (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                 FROM getar_cad cad,
                      fornecedor forn
                WHERE cad.cod = forn.codforn
                      AND forn.codestq = estq.cod) fornc,
             estq.descr,
             estq.qtd,
             estq.valorcusto,
             'sem pedido' situpedido,
             '' situitem
        FROM estoque estq
       WHERE estq.qtd < estq.qtdmin
             AND estq.cod NOT IN(SELECT codest FROM estpedidoitem)
             AND estq.clasf IN ('novo', 'usado')
      UNION(
      SELECT (SELECT group_concat(cb.cod) 
                FROM estpedidocab cb,
                     estpedidoitem it
               WHERE cb.cod = it.codped
                     AND it.codest = estq.cod
                     AND cb.situ IN('processamento', 'transito')) codpedido,
             estq.cod,
             (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                 FROM getar_cad cad,
                      fornecedor forn
                WHERE cad.cod = forn.codforn
                      AND forn.codestq = estq.cod) fornc,
             estq.descr,
             estq.qtd,
             estq.valorcusto,
             (SELECT group_concat(CASE
                         WHEN cb.situ =  'processamento' THEN CONCAT('pedido n. ', cb.cod, ' processamento')
                         WHEN cb.situ = 'transito' THEN CONCAT('pedido n. ', cb.cod, ' transito')
                         WHEN estq.qtd < estq.qtdmin THEN 'sem pedido'
                     END) AS stpedido
                FROM estpedidocab cb,
                     estpedidoitem it
               WHERE cb.cod = it.codped
                     AND it.codest = estq.cod
                     AND cb.situ IN('recebido', 'processamento', 'transito')) AS situpedido,
             (SELECT it.situ 
                FROM estpedidoitem it
               WHERE it.codest = estq.cod
               LIMIT 1) situitem
        FROM estoque estq
       WHERE estq.qtd < estq.qtdmin
             AND estq.cod IN(SELECT codest FROM estpedidoitem)
             AND estq.clasf IN ('novo', 'usado'))) grp
       WHERE cod = 348
       ORDER BY descr ASC;

# As partes
     SELECT cad.nome
       FROM estpedidocab cb,
            estpedidoitem it,
            getar_cad cad,
            estoque estq
      WHERE cb.cod = it.codped
            AND it.codest = estq.cod
            AND cb.codforn = cad.cod
            AND estq.cod = 140
      LIMIT 1;

      SELECT concat_ws(stpedido) FROM(
              SELECT CASE
                         WHEN cb.situ =  'processamento' THEN CONCAT('pedido n. ', cb.cod, ' processamento')
                         WHEN cb.situ = 'transito' THEN CONCAT('pedido n. ', cb.cod, ' transito')
                         WHEN estq.qtd < estq.qtdmin THEN 'sem pedido'
                     END AS stpedido,
                     '-' sep,
                     cb.cod codped,
                     it.coditem,
                     it.codest
                FROM estpedidocab cb,
                     estpedidoitem it,
                     estoque estq
               WHERE cb.cod = it.codped
                     # AND cb.situ IN('processamento', 'transito')
                     AND it.codest = estq.cod
                     AND it.codest = 452);

              SELECT CASE
                        WHEN cb.situ = 'processamento' THEN CONCAT('pedido n. ', cb.cod, ' processamento')
                        WHEN cb.situ = 'transito' THEN CONCAT('pedido n. ', cb.cod, ' transito')
                        WHEN estq.qtd < estq.qtdmin THEN 'sem pedido'
                     END AS stpedido,
                     cb.situ,
                     cb.cod codped
                FROM estpedidocab cb,
                     estpedidoitem it,
                     estoque estq
               WHERE cb.cod = it.codped
                     AND it.codest = estq.cod
                     AND cb.situ IN('processamento', 'transito')
                     # AND cb.tipo = 'compra'
                     AND it.codest = 855;
SELECT * FROM estpedidocab WHERE cod = 14;
/*
    Listagem para pedidos
Todos abaixo da quantidade minimo sem pedidos em transito ou recebidos 
 */
        SELECT descr,
               cod,
               qtd,
               ' ' QtdPedido,
               valorcusto,
               stpedido
          FROM (SELECT estq.descr,
                       estq.cod,
                       estq.qtd,
                       ' ' QtdPedido,
                       estq.valorcusto,
                      (SELECT cb.situ
                        FROM estpedidocab cb,
                             estpedidoitem it
                       WHERE cb.cod = it.codped
                             AND it.codest = estq.cod
                       LIMIT 1) AS stpedido
                FROM estoque estq
                WHERE estq.qtd < estq.qtdmin
                      AND estq.clasf IN ('novo', 'usado')) grp-- menos os colecionaveis -colec-
         WHERE stpedido IS NULL
               OR stpedido IN('processamento')
      ORDER BY descr ASC;


/*
** listagem distinguindo os numero de zeros para METROS de pecas
*/
        SELECT cod,
               descr,
               CASE
                   WHEN und IN('pc', 'und') THEN ROUND(qtd, 0)
                   WHEN und IN('m', 'ml', 'Kg') THEN ROUND(qtd, 3)
               END qtd,
               und,
               (SELECT etq FROM estlocal WHERE cod = est.local) etqlocal,
               (SELECT descr FROM estcatg WHERE cod = est.catg) descrcatg,
               (SELECT descr FROM estsubcatg WHERE cod = est.subcatg) descrsubcatg,
               clasf,
               situacao
           FROM estoque est
          WHERE situacao != 'temporario'
                AND cod = 491;# 1 2SC1969 - 491 breu 0,5Kg

SELECT * FROM estoque WHERE situacao = 'temporario';
SELECT * FROM estoque WHERE cod=854;

         SELECT est.cod,
                est.descr,
                forn.codforn,
                cad.nome,
                ped.cod codped
           FROM fornecedor forn,
                getar_cad cad,
                estoque est,
                estpedidocab ped
           WHERE forn.codestq = est.cod
                 AND forn.codforn = cad.cod
                 AND forn.codforn = ped.codforn
                 AND ped.situ IN('processamento')
                 AND est.qtd < est.qtdmin
                 AND est.cod = 543;

/**
** ESTUDOS TOTALIZAR ESTOQUE
*/
    SELECT SUM(subtotal) totalgeral
    FROM (SELECT @subtotal := qtd * valorcusto subtotal
        FROM estoque
        WHERE qtd > 0
              AND situacao= 'normal'
              AND numest= 1
              AND valorcusto > 0) AS grp;

# Quantos itens sem valor de venda
SELECT COUNT(*) semvalor FROM estoque WHERE valorvenda = 0;
SELECT cod, descr, situacao FROM estoque LIMIT 10;

# Quantos itens sem valor de custo
SELECT COUNT(*) FROM estoque WHERE valorcusto = 0;

# itens sem valor de venda mas com valor de custo
        SELECT cod,
               descr,
               valorcusto,
               valorvenda,
               situacao
          FROM estoque
         WHERE valorvenda = 0
               AND valorcusto > 0
         LIMIT 10;
/**
** Usando o Estoque como Controle Patrimonial
**/
# clasf= ne [Nao estocavel]
# catg= 5 [Ferramentas]
# catg= 6 [Instrumentos]
SELECT cod, descr, catg, subcatg, clasf FROM estoque WHERE cod= 3228; # Alicate Decapador
SELECT cod, descr, qtd, catg, subcatg,valorcusto, valorvenda, clasf FROM estoque WHERE cod= 3208; # Medidor ESR LCR-T4

# Vendo todas as ferramentas
SELECT cod, descr, qtd, catg, subcatg,valorcusto, valorvenda, clasf FROM estoque WHERE catg = 5;
UPDATE estoque SET clasf = 'ne', valorvenda = 0 WHERE catg = 5;
UPDATE estoque SET qtd = 1 WHERE catg = 5;
# totalizando
SELECT SUM(valorcusto) FROM estoque WHERE catg= 5 AND clasf= 'ne'; # Intrumentos

# Vendo todas os instrumentos
SELECT cod, descr, qtd, catg, subcatg,valorcusto, valorvenda, clasf FROM estoque WHERE catg = 6;
UPDATE estoque SET clasf = 'ne', valorvenda = 0 WHERE catg = 6;
UPDATE estoque SET qtd = 1 WHERE catg = 6;
# totalizando
SELECT SUM(valorcusto) FROM estoque WHERE catg= 6 AND clasf= 'ne'; # Intrumentos

# testes e estudos
# corrigindo
        /**UPDATE estoque
           SET valorvenda = valorcusto * 1.4
         WHERE cod IN(SELECT est.cod
                        FROM estoque est
                       WHERE est.valorvenda = 0
                             AND est.valorcusto > 0);**/ # erro twice

CREATE VIEW codestq AS 
               SELECT est.cod
                 FROM estoque est
                WHERE est.valorvenda = 0
                      AND est.valorcusto > 0;
# https://blog.devart.com/how-to-create-a-view-in-mysql.html
;

SELECT * FROM codestq;

        UPDATE estoque
           SET valorvenda = valorcusto * 1.4
         WHERE cod IN(SELECT * FROM codestq);# erro de novo
DROP VIEW codestq;

CREATE TABLE codestq (cod int(11));
INSERT INTO codestq (cod) SELECT est.cod
                                    FROM estoque est
                                   WHERE est.valorvenda = 0
                                         AND est.valorcusto > 0;# deu certo!!!
# https://blog.betrybe.com/sql-insert/
;
SELECT * FROM codestq;

        UPDATE estoque
           SET valorvenda = valorcusto * 1.4
         WHERE cod IN(SELECT * FROM codestq);
DROP TABLE codestq;

# totalizando pedido recebidos no mes
SELECT COUNT(*)  FROM estpedidocab WHERE tipo='compra' AND DATE_FORMAT(dtrecb, '%m/%y') = '05/24';
SELECT cod FROM estpedidocab WHERE tipo='compra' AND situ= 'recebido';
# totalizando pedido abertos no mes
SELECT COUNT(*)  FROM estpedidocab WHERE tipo='compra' AND DATE_FORMAT(dtped, '%m/%y') = '04/24';
SELECT COUNT(*)  FROM estpedidocab WHERE tipo='compra' AND DATE_FORMAT(dtped, '%m/%y') = DATE_FORMAT(CURDATE(), '%m/%y');

SELECT CURDATE() FROM estoque;
# Totalizando pedidos pagos no mes
        SELECT cod,
               (SELECT nome FROM getar_cad WHERE cod=codforn) fornecedor,
               vlfrete,
               # (SELECT SUM()) TotalPed
               DATE_FORMAT(dtped, '%d/%m/%y') DtPed,
               dtped,
               DATE_FORMAT(dtcheg, '%d/%m/%y') DtCheg,
               dtcheg,
               DATE_FORMAT(dtrecb, '%d/%m/%y') DtRecb,
               dtrecb,
               situ
          FROM estpedidocab cab
         WHERE tipo='compra'
               AND situ IN('recebido', 'transito')
               AND DATE_FORMAT(dtped, '%m/%y') IN ('11/21', '10/21', '09/21', '08/21', '07/21', '06/21')
        ORDER BY cod DESC;

/**
** ACOMPANHANDO PEDIDOS
**/
SELECT * FROM estpedidocab  WHERE cod= 374;# Tigger
SELECT * FROM estpedidocab  WHERE cod= 351;# Solda Fria
SELECT * FROM estpedidocab  WHERE cod= 405;# Fusopar
SELECT * FROM estpedidocab  WHERE cod= 388;# Proesi
SELECT * FROM estpedidocab  WHERE cod= 386;
SELECT cod, dtped, dtcheg, dtrecb, tipo, situ FROM estpedidocab  WHERE cod= 405;# Fusopar
SELECT cod, codforn, dtped, dtcheg, dtrecb, tipo, situ FROM estpedidocab ORDER BY cod DESC;
SELECT DISTINCT tipo FROM estpedidocab;
SELECT DISTINCT situ FROM estpedidocab;

# pedidos de placa de maquina de lavar
SELECT * FROM estpedidoitem WHERE codped IN(37, 38);
DELETE FROM estpedidoitem WHERE codped IN(37, 38);
SELECT * FROM estpedidocab WHERE cod= 30;
DELETE FROM estpedidocab WHERE cod IN(37, 38);

# Retiradas avulsas
SELECT * FROM estretira WHERE codestq= 1038;

        SELECT est.cod,
               est.descr,
               est.valorcusto,
               ret.qtd,
               est.und,
               DATE_FORMAT(ret.dia, '%d/%m/%y') dia,
               ret.motivo
          FROM estretira ret,
               estoque est
         WHERE est.cod = ret.codestq
               AND DATE_FORMAT(ret.dia, '%m/%y') = '10/21'
      ORDER BY ret.cod DESC;


/**
** DETALHAR UM ITEM
**/
             SELECT estq.cod,
                    estq.descr,
                    estq.datasheet,
                    estq.fabr,
                    (SELECT nome FROM getar_cad WHERE cod = estq.fabr) nmfabr,
                    estq.und,
                    CASE
                        WHEN estq.und IN('pc', 'und') THEN ROUND(estq.qtd, 0)
                        WHEN estq.und IN('m', 'ml', 'Kg') THEN ROUND(estq.qtd, 3)
                    END qtd,
                    CASE
                        WHEN estq.und IN('pc', 'und') THEN ROUND(estq.qtdmin, 0)
                        WHEN estq.und IN('m', 'ml', 'Kg') THEN ROUND(estq.qtdmin, 3)
                    END qtdmin,
                    estq.valorcusto,
                    estq.valorvenda,
                    estq.peso,
                    estq.foto,
                    estq.local,
                    (SELECT CONCAT(etq, ' - ', descr) FROM estlocal WHERE cod = estq.local) descrlocal,
                    estq.situacao,
                    estq.clasf,
                    CASE
                        WHEN estq.clasf = 'colec' THEN 'Colecionavel'
                        WHEN estq.clasf = 'novo' THEN 'Novo'
                        WHEN estq.clasf = 'usado' THEN 'Usado'
                    END nmclasf,
                    estq.catg,
                    (SELECT descr FROM estcatg WHERE cod = estq.catg) descrcatg,
                    (SELECT descr FROM estsubcatg WHERE cod = estq.subcatg) descrsubcatg,
                    estq.subcatg,
                    (SELECT cb.cod
                       FROM estpedidocab cb,
                            estpedidoitem it
                      WHERE cb.cod = it.codped
                            AND cb.tipo = 'compra'
                            AND it.codest = estq.cod
                      ORDER BY cb.cod DESC
                      LIMIT 1) AS codpedido,
                    (SELECT cb.situ stpedido
                       FROM estpedidocab cb,
                            estpedidoitem it
                      WHERE cb.cod = it.codped
                            AND cb.tipo = 'compra'
                            AND it.codest = estq.cod
                      ORDER BY cb.cod DESC
                      LIMIT 1) AS stpedido
               FROM estoque estq
              WHERE estq.cod = 2;

                  SELECT cb.cod
                    FROM estpedidocab cb,
                         estpedidoitem it
                   WHERE cb.cod = it.codped
                         AND cb.tipo = 'consumo'
                         AND it.codest = 73
                   ORDER BY cb.cod DESC
                   LIMIT 1;
/**
** pedidos
**/
SELECT * FROM estpedidocab WHERE cod= 8;
SELECT * FROM estpedidoitem WHERE codest= 348;

SELECT * FROM estpedidoitem WHERE codped= 528;

# Inserir em pedido de compra/reposicao em aberto
         SELECT est.cod,
                est.descr,
                forn.codforn,
                cad.nome,
                ped.cod codped
           FROM fornecedor forn,
                getar_cad cad,
                estoque est,
                estpedidocab ped
           WHERE forn.codestq = est.cod
                 AND forn.codforn = cad.cod
                 AND forn.codforn = ped.codforn
                 AND ped.situ IN('processamento')
                 AND est.qtd < est.qtdmin
                 AND est.cod = 79;

# Inserir produto em pedido de venda ou consumo interno
         SELECT cb.cod codped,
                cb.codcli,
                cad.nome,
                (SELECT CONCAT(pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                (SELECT CONCAT(eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                (SELECT CONCAT('Quantidade: ', qt, ' - Custo: ', custo) FROM estpedidoitem WHERE codped = cb.cod AND codest = 348) qtcst,
                (SELECT codest FROM estpedidoitem WHERE codped = cb.cod AND codest = 348) codest,
                cb.situ,
                cb.tipo
           FROM estpedidocab cb,
                getar_cad cad
          WHERE cad.cod = cb.codcli
                AND cb.resp = 'pregis'
                AND cb.tipo IN ('venda', 'consumo');
SELECT * FROM estpedidocab WHERE ospro = 341;
SELECT * FROM estpedidocab WHERE cod IN(1,2,3,4,5,6,7,8);
SELECT * FROM estpedidoitem WHERE codped = 241;# OS341 FT-ONE
SELECT * FROM estpedidoitem WHERE codped = 14 AND codest = 365;
SELECT codest FROM estpedidoitem WHERE codest = 365 ORDER BY coditem LIMIT 1 ;

         SELECT cb.cod codped,
                cad.nome,
                (SELECT descr FROM estoque WHERE cod=it.codest) descr,
                (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo)
                   FROM eletro_projetos pj,
                        eletro_pedidos pd
                  WHERE pj.cod = pd.codproj
                        AND pd.cod = cb.ospro) projetoEletro,
                (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
                   FROM getar_projetos pj, getar_pedidos pd
                  WHERE pj.cod = pd.codproj
                        AND pd.cod = cb.ospro) projeto,
                (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                   FROM ordem od, equipo eq
                  WHERE od.cod = cb.ospro
                        AND od.codeqp = eq.cod) equipo,
                (SELECT CONCAT('Quantidade: ', qt, ' - Custo: ', custo)
                   FROM estpedidoitem
                  WHERE codped = cb.cod
                        AND codest = it.codest LIMIT 1) qtcst,
                (SELECT codest
                   FROM estpedidoitem
                  WHERE codped = cb.cod
                        AND codest = it.codest LIMIT 1) codest,
                (SELECT COUNT(*)
                   FROM estpedidoitem 
                  WHERE codped = cb.cod
                        AND codest = it.codest) AS numitem,
                cb.situ,
                cb.tipo
           FROM estpedidocab cb,
                estpedidoitem it,
                getar_cad cad
          WHERE cb.cod = it.codped
                AND cad.cod = cb.codcli
                AND cb.tipo IN ('venda', 'consumo')
                AND it.codest = 0082;

         SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) refped
           FROM eletro_projetos pj,
                eletro_pedidos pd
          WHERE pj.cod = pd.codproj
                AND pd.cod = 25;

         SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) refped
           FROM ordem od,
                equipo eq
          WHERE od.codeqp = eq.cod
                AND od.cod = 2;

             SELECT ped.codforn,
                    (SELECT nome FROM getar_cad WHERE cod= ped.codforn) nmforn,
                    (SELECT nome FROM getar_cad WHERE cod= ped.codcli) nmcli,
                    (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
                       FROM eletro_projetos pj,
                            eletro_pedidos pd
                      WHERE pj.cod = pd.codproj
                        AND pd.cod = ped.ospro) projeto,
                    (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                       FROM ordem od,
                            equipo eq
                      WHERE od.cod = ped.ospro
                            AND od.codeqp = eq.cod) equipo,
                    ped.codcli,
                    ped.tipo,
                    ped.situ
               FROM estpedidocab ped
              WHERE ped.cod = 20;
SELECT * FROM estpedidocab ORDER BY cod;
SELECT * FROM estpedidocab WHERE cod = 25;
SELECT * FROM estpedidoitem WHERE codped = 25;
SELECT * FROM estpedidocab WHERE ospro = 306;
        
             SELECT codped,
                    nome,
                    projeto,
                    equipo,
                    tipo                    
             FROM (SELECT cb.cod codped,
                          cad.nome,
                          (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                          (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                          (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = 4) AS numitem,
                          cb.tipo
                     FROM estpedidocab cb,
                          getar_cad cad
                    WHERE cad.cod = cb.codcli
                          AND cb.resp = 'pregis'
                          AND cb.tipo IN ('venda', 'consumo')
                          AND cb.situ = 'processamento') as cb
            WHERE numitem = 0;

/**
**
*/
         SELECT cb.cod codped,
                        cad.nome,
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                        (SELECT CONCAT('Quantidade: ', qt, ' - Custo: ', custo) FROM estpedidoitem WHERE codped = cb.cod AND codest = 2 LIMIT 1) qtcst,
                        (SELECT codest FROM estpedidoitem WHERE codped = cb.cod AND codest = 2 LIMIT 1) codest,
                        (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = 2) AS numitem,
                        cb.situ,
                        cb.tipo
                   FROM estpedidocab cb,
                        getar_cad cad
                  WHERE cad.cod = cb.codcli
                        AND cb.resp = 'pregis'
                        AND cb.tipo IN ('venda', 'consumo');
/**
**
**/

SELECT COUNT(*), coditem, qt FROM estpedidoitem WHERE codped=10 AND codest=734;
DELETE FROM estpedidoitem WHERE coditem= 648;

# inserindo um pedido de venda de produtos atrelada a uma OS
INSERT INTO estpedidocab (codforn, codcli, resp, tipo, ospro, dtped, situ)
                            VALUES(2, (SELECT codcli FROM ordem WHERE cod= 175), 'pregis', 'venda', 175, CURDATE(), 'espera');
# inserindo um pedido de reposisao
SELECT cod, codforn, dtped, tipo, situ FROM estpedidocab WHERE codforn= 752 ORDER BY dtped DESC LIMIT 5;# 752 - Proesi
SELECT cod, codforn, dtped, tipo, situ FROM estpedidocab ORDER BY dtped DESC LIMIT 5;# 752 - Proesi

INSERT INTO estpedidocab (codforn, resp, tipo, dtped, situ)
                            VALUES(752, 'pregis', 'compra', CURDATE(), 'espera');

DELETE FROM estpedidocab WHERE ospro=175;
SELECT * FROM estpedidocab;

SELECT cod FROM estpedidocab WHERE ospro =43;

         SELECT pd.coditem,
                cb.cod codpedido,
                estq.descr,
                estq.cod,
                pd.codest,
                pd.qt,
                pd.custo,
                cb.situ,
                estq.situacao
           FROM estoque estq,
                estpedidocab cb,
                estpedidoitem pd
          WHERE estq.cod = pd.codest
                AND pd.codped = cb.cod
                AND cb.ospro =1592;

             SELECT codpedido,
                    descr,
                    cod,
                    fornc,
                    qtd qt,
                    valorcusto custo,
                    situpedido,
                    situitem
               FROM (
          SELECT '' codpedido,
                 estq.cod,
                 (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                     FROM getar_cad cad,
                          fornecedor forn
                    WHERE cad.cod = forn.codforn
                          AND forn.codestq = estq.cod) fornc,
                 estq.descr,
                 estq.qtd,
                 estq.valorcusto,
                 'sem pedido' situpedido,
                 '' situitem
            FROM estoque estq
           WHERE estq.qtd < estq.qtdmin
                 AND estq.situacao = 'ativo'
                 AND estq.cod NOT IN(SELECT codest FROM estpedidoitem)
                 AND estq.clasf IN ('novo', 'usado')
          UNION(
          SELECT (SELECT group_concat(cb.cod) 
                    FROM estpedidocab cb,
                         estpedidoitem it
                   WHERE cb.cod = it.codped
                         AND it.codest = estq.cod
                         AND cb.tipo = 'compra'
                         AND cb.situ IN('processamento', 'transito')) codpedido,
                 estq.cod,
                 (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                     FROM getar_cad cad,
                          fornecedor forn
                    WHERE cad.cod = forn.codforn
                          AND forn.codestq = estq.cod) fornc,
                 estq.descr,
                 estq.qtd,
                 estq.valorcusto,
                 (SELECT group_concat(CASE
                                          WHEN cb.situ =  'processamento' THEN CONCAT('pedido n. ', cb.cod, ' processamento')
                                          WHEN cb.situ = 'transito' THEN CONCAT('pedido n. ', cb.cod, ' transito')
                                          WHEN cb.situ = 'espera' THEN CONCAT('pedido n. ', cb.cod, ' espera')
                                          WHEN estq.qtd < estq.qtdmin THEN 'sem pedido'
                                      END) AS stpedido
                    FROM estpedidocab cb,
                         estpedidoitem it
                   WHERE cb.cod = it.codped
                         AND it.codest = estq.cod
                         AND cb.tipo = 'compra'
                         AND cb.situ IN('processamento', 'transito', 'espera')) AS situpedido,
                 (SELECT it.situ 
                    FROM estpedidoitem it
                   WHERE it.codest = estq.cod
                   LIMIT 1) situitem
            FROM estoque estq
           WHERE estq.qtd < estq.qtdmin
                 AND estq.cod IN(SELECT codest FROM estpedidoitem)
                 AND estq.clasf IN ('novo', 'usado'))) grp
           ORDER BY descr ASC;

             SELECT cod,
                    etq,
                    SUBSTRING(descr, 1, 20) descr
               FROM estlocal
               WHERE situacao = 'ativo'
              LIMIT 3;

# XXXXXXXXXXXXXXXXXXXXXXXXXXXX
              SELECT CONCAT(cb.cod, ' (',cad.nome, ')') pedido
                FROM estpedidocab cb,
                     getar_cad cad,
                     estpedidoitem it
               WHERE cb.cod = it.codped
                     AND cad.cod = cb.codforn
                     AND cb.tipo = 'compra'
                     AND it.codest = 1929
               ORDER BY cb.cod DESC;

SELECT * FROM estpedidocab WHERE cod= 274;

/**
** inserindo resistores SMD 0603 doados pelo Jose Henok
**/
SELECT * FROM estoque WHERE cod= 2076;

INSERT INTO estoque (descr, descrtec, numest, datasheet, fabr, und, qtd, qtdmin, valorcusto, valorvenda, moeda, peso, foto, rua, quadra, `local`, situacao, clasf, catg, subcatg) 
	VALUES ('Resistor 1M 0.1W 0603', 'Resistor SMD', 1, 'datasheet_resistor SMD.pdf', 0, 'pc', 19.000, 0.000, 0.200, 0.000, 'Real', 0.000, 'resistor-smd-0603.jpg', 1, 1, 69, 'normal', 'novo', 3, 59);

# inserido a mais
DELETE FROM estoque WHERE cod= 2360;

# Pegando os codigos dos Capacitores que vieram do Casa do Resistor 0603
        SELECT cod,
               descr,
               qtd
          FROM estoque
         WHERE qtd = 0
               AND descr LIKE ('Capa%0603');
UPDATE estoque SET qtd= 20 WHERE cod IN(2232,2233,2234,2235,2236,2237);


/**
**listagem para pedidos
**/
# listagem antiga
                           SELECT codpedido,
                            descr,
                            cod,
                            fornc,
                            qtd qt,
                            valorcusto custo,
                            situpedido,
                            situitem
                       FROM (
                  SELECT '' codpedido,
                         estq.cod,
                         (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                             FROM getar_cad cad,
                                  fornecedor forn
                            WHERE cad.cod = forn.codforn
                                  AND forn.codestq = estq.cod) fornc,
                         estq.descr,
                         estq.qtd,
                         estq.valorcusto,
                         'sem pedido' situpedido,
                         '' situitem
                    FROM estoque estq
                   WHERE estq.qtd < estq.qtdmin
                         AND estq.cod NOT IN(SELECT codest FROM estpedidoitem)
                         AND estq.clasf IN ('novo', 'usado')
                  UNION(
                  SELECT (SELECT group_concat(cb.cod) 
                            FROM estpedidocab cb,
                                 estpedidoitem it
                           WHERE cb.cod = it.codped
                                 AND it.codest = estq.cod
                                 AND cb.tipo = 'compra'
                                 AND cb.situ IN('processamento', 'transito')) codpedido,
                         estq.cod,
                         (SELECT group_concat(SUBSTRING(cad.nome, 1, 20))
                             FROM getar_cad cad,
                                  fornecedor forn
                            WHERE cad.cod = forn.codforn
                                  AND forn.codestq = estq.cod) fornc,
                         estq.descr,
                         estq.qtd,
                         estq.valorcusto,
                         (SELECT group_concat(CASE
                                                  WHEN cb.situ =  'processamento' THEN CONCAT('pedido n. ', cb.cod, ' processamento')
                                                  WHEN cb.situ = 'transito' THEN CONCAT('pedido n. ', cb.cod, ' transito')
                                                  WHEN cb.situ = 'espera' THEN CONCAT('pedido n. ', cb.cod, ' espera')
                                                  WHEN estq.qtd < estq.qtdmin THEN 'sem pedido'
                                              END) AS stpedido
                            FROM estpedidocab cb,
                                 estpedidoitem it
                           WHERE cb.cod = it.codped
                                 AND it.codest = estq.cod
                                 AND cb.tipo = 'compra'
                                 AND cb.situ IN('processamento', 'transito', 'espera')) AS situpedido,
                         (SELECT it.situ 
                            FROM estpedidoitem it
                           WHERE it.codest = estq.cod
                           LIMIT 1) situitem
                    FROM estoque estq
                   WHERE estq.qtd < estq.qtdmin
                         AND estq.cod IN(SELECT codest FROM estpedidoitem)
                         AND estq.clasf IN ('novo', 'usado'))) grp
                   ORDER BY descr ASC;

# Montagem do SELECT para pedidos
        SELECT DISTINCT cb.cod,
               (SELECT nome
                FROM getar_cad
                WHERE cod= cb.codforn) forn
          FROM estpedidocab cb,
               estpedidoitem it
         WHERE cb.cod = it.codped
               AND cb.tipo = 'compra'
               AND cb.situ IN('processamento', 'transito', 'espera');

# SQL em uso
     SELECT cb.cod codpedido,
            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
            (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo)
               FROM eletro_projetos pj, eletro_pedidos pd # nao se usa mais essas tabelas para projetos
              WHERE pj.cod = pd.codproj
                    AND pd.cod = cb.nmproj) projeto, # pd.cod = cb.ospro
            (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
            cb.situ,
            cb.tipo,
            cb.nomeped,
            CASE
                WHEN cb.tipo =  'compra' THEN 'Compra' # 'compra/reposicao'
                WHEN cb.tipo = 'venda' THEN 'Vvenda' # 'venda/orcamento'
                WHEN cb.tipo = 'consumo' THEN 'Cconsumo'
                ELSE 'indefinido'
            END AS desctipo,
            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens
       FROM estpedidocab cb
      WHERE cb.situ IN ('processamento', 'transito', 'espera', 'estudo', 'orcamento', 'pago')
            AND cb.cod= 638
      ORDER BY cb.tipo DESC, cb.situ DESC;
SELECT * FROM estpedidocab WHERE cod = 485;
/**
** sql simplificada somente para um pedido
**/
# parte 1: o que ja tem no pedido
     SELECT cab.cod codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            SUBSTRING(cad.nome, 1, 20) fornc,
            est.qtd qt,
            est.valorcusto custo,
            cab.situ situpedido,
            '--' situitem
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem itm,
            getar_cad cad
      WHERE cab.cod= itm.codped
            AND itm.codest = est.cod
            AND cab.codforn= cad.cod
            AND cab.cod = 249;
# parte 2: o que eh do fornecedor e ainda nao esta no pedido
     SELECT '--' codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            SUBSTRING(cad.nome, 1, 20) fornc,
            '--' qt,
            '--' valorcusto,
            '--' situpedido,
            '--' situitem
       FROM estoque est,
            getar_cad cad
      WHERE est.qtd < est.qtdmin
            AND est.cod NOT IN(SELECT itm.codest
                                      FROM estpedidocab cab,
                                           estpedidoitem itm
                                     WHERE cab.cod = itm.codped
                                           AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
                                           AND cab.tipo= 'compra'
                                           AND itm.codest = est.cod)
            AND cad.cod = 752
            AND est.cod IN(SELECT frn.codestq FROM fornecedor frn WHERE frn.codforn= 752);
# para poder inserir num pedido
SELECT itm.codest,
             cab.situ
        FROM estpedidocab cab,
             estpedidoitem itm
       WHERE cab.cod = itm.codped
             # AND cab.situ = 'espera'# era IN('processamento', 'espera')
             # AND cab.situ IN('processamento', 'espera')
             AND cab.situ = 'estudo'
             AND cab.tipo= 'compra'
             AND itm.codest = 3539;

        SELECT itm.codest,
               cab.situ
          FROM estpedidocab cab,
               estpedidoitem itm
         WHERE cab.cod = itm.codped
               AND itm.codest = 3539;

# pegando tudo do fornecedor
SELECT frn.codestq FROM fornecedor frn WHERE frn.codforn= 826;# 752 Proesi

        SELECT cod,
               descr
          FROM estoque est
         WHERE est.qtd < est.qtdmin
               AND est.cod IN(SELECT frn.codestq FROM fornecedor frn WHERE frn.codforn= 752);# 752 Proesi

# montando sql
        SELECT @codfonr := cab.codforn
          FROM estpedidocab cab
         WHERE cab.cod = 295;
         SELECT codpedido,
                descr,
                descrtec,
                codest,
                fornc,
                qtd qt,
                valorcusto custo,
                situpedido,
                situitem
           FROM (# parte 1: o que ja tem no pedido
     SELECT cab.cod codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            SUBSTRING(cad.nome, 1, 20) fornc,
            itm.qt qtd,
            itm.custo valorcusto,
            cab.situ situpedido,
            itm.situ situitem
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem itm,
            getar_cad cad
      WHERE cab.cod= itm.codped
            AND itm.codest = est.cod
            AND cab.codforn= cad.cod
            AND cab.cod = 249
     UNION(# parte 2: o que eh do fornecedor e ainda nao esta no pedido
     SELECT cab.cod codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            SUBSTRING(cad.nome, 1, 20) fornc,
            itm.qt qtd,
            itm.custo valorcusto,
            cab.situ situpedido,
            itm.situ situitem
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem itm,
            getar_cad cad
      WHERE cab.cod= itm.codped
            AND itm.codest = est.cod
            AND cab.codforn= cad.cod
            AND est.qtd < est.qtdmin
            AND cab.tipo = 'compra'
            AND cab.situ IN('processamento', 'transito', 'espera')
            AND est.cod IN(SELECT frn.codestq FROM fornecedor frn WHERE frn.codforn=752) @codforn))
     ) qrp
     ORDER BY descr ASC;

/**
** Listagem geral
**/
# parte: testes
     /*SELECT cab.cod codpedido,
            est.descr,
            est.cod,
            SUBSTRING(cad.nome, 1, 20) fornc,
            est.qtd qt,
            est.valorcusto custo,
            cab.situ situpedido,
            '--' situitem
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem itm,
            getar_cad cad
      WHERE cab.cod= itm.codped
            AND itm.codest = est.cod
            AND cab.codforn= cad.cod
            AND est.qtd < est.qtdmin
            AND cab.situ= 'processamento'
            AND est.cod IN (SELECT frn.codestq FROM fornecedor frn WHERE frn.codforn = 752);
            AND est.cod IN (SELECT frn.codestq FROM fornecedor frn WHERE frn.codforn = cab.codforn)
            AND cab.codforn IN (SELECT codforn FROM estpedidocab WHERE cod= 278);*/

# parte 1: abaixo da quanticade minima e tem pedido ativo
     SELECT CONCAT('Pedido: ',cab.cod) codpedido,
            est.descr,
            est.cod,
            (SELECT nome FROM getar_cad WHERE cod= cab.codforn) fornc,
            itm.qt qtd,
            itm.custo valorcusto,
            cab.situ situpedido,
            itm.situ situitem
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem itm
      WHERE cab.cod= itm.codped
            AND itm.codest = est.cod
            AND cab.tipo = 'compra'
            AND est.qtd < est.qtdmin
            AND est.cod = itm.codest
            AND est.cod = 1823# 78L08
            AND cab.situ IN('processamento', 'transito', 'espera');
      LIMIT 5;

SELECT * FROM estpedidoitem WHERE codest= 1823 AND codped= 274;

# parte 2: abaixo da quanticade minima sem pedido e com fornecedor
     SELECT 'sem pedido' codpedido,
            est.descr,
            est.cod,
            (SELECT group_concat(SUBSTRING(cad2.nome, 1, 20))
               FROM estoque est2,
                    fornecedor frn2,
                    getar_cad cad2
               WHERE cad2.cod = frn2.codforn
                     AND est2.cod = frn2.codestq
                     AND est2.cod = est.cod) fornc,
            '--' qt,
            '--' valorcusto,
            '--' situpedido,
            '--' situitem
       FROM estoque est
      WHERE est.qtd < est.qtdmin
            # AND est.situacao = 'normal'
            AND est.cod IN (SELECT frn.codestq FROM fornecedor frn)
            # AND est.cod NOT IN(1,0)
            AND est.cod NOT IN(SELECT itm.codest
                                 FROM estpedidocab cab,
                                      estpedidoitem itm
                                WHERE cab.cod = itm.codped
                                      AND cab.tipo = 'compra'
                                      AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
                                      AND itm.codest = est.cod)
            AND est.cod= 471;
      

      SELECT CONCAT(0, cad2.nome) nome
        FROM estoque est2,
             fornecedor frn2,
             getar_cad cad2
       WHERE cad2.cod = frn2.codforn
             AND est2.cod = frn2.codestq;

      SELECT # COUNT(*) nm
             cab.cod codped,
             itm.codest codest
        FROM estpedidocab cab,
             estpedidoitem itm
       WHERE cab.cod = itm.codped
             AND cab.tipo = 'compra'
             AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
             AND itm.codest = 471;

SELECT * FROM estpedidoitem WHERE codest = 471;
SELECT * FROM estpedidocab WHERE cod IN(4,188,148,203,241,226,247,254);
/*UNION(
      SELECT cod codest
        FROM estoque
       WHERE cod = 1);*/


# parte 3: abaixo da quanticade minima e sem pedido e sem fornecedor
     SELECT 'sem pedido-sem fornecedor' codpedido,
            est.descr,
            est.cod,
            'sem fornecedor' fornc,
            est.qtd qt,
            est.valorcusto custo,
            '--' situpedido,
            '--' situitem
       FROM estoque est
      WHERE est.qtd < est.qtdmin
            AND est.cod NOT IN (SELECT frn.codestq FROM fornecedor frn)
      LIMIT 5;

# montagem do SQL novo
         SELECT codpedido,
                descr,
                descrtec,
                codest,
                fornc,
                qtd qt,
                valorcusto custo,
                situpedido,
                situitem
           FROM (# parte 1: abaixo da quanticade minima e tem pedido ativo
     SELECT cab.cod codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            (SELECT nome FROM getar_cad WHERE cod= cab.codforn) fornc,
            itm.qt qtd,
            itm.custo valorcusto,
            cab.situ situpedido,
            itm.situ situitem
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem itm
      WHERE cab.cod= itm.codped
            AND itm.codest = est.cod
            AND cab.tipo = 'compra'
            AND est.qtd < est.qtdmin
            AND est.cod = itm.codest
            AND cab.situ IN('processamento', 'transito', 'espera')
     UNION(# parte 3: abaixo da quanticade minima e sem pedido e sem fornecedor
     SELECT 'sem pedido-sem fornecedor' codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            'sem fornecedor' fornc,
            '--' qtd,
            '--' valorcusto,
            '--' situpedido,
            '--' situitem
       FROM estoque est
      WHERE est.situacao = 'normal'
            AND est.qtd < est.qtdmin
            AND est.cod NOT IN (SELECT frn.codestq FROM fornecedor frn)
      )
UNION(
# parte 2: abaixo da quanticade minima sem pedido e com fornecedor
     SELECT 'sem pedido' codpedido,
            est.descr,
            est.descrtec,
            est.cod codest,
            (SELECT group_concat(SUBSTRING(cad2.nome, 1, 20))
               FROM estoque est2,
                    fornecedor frn2,
                    getar_cad cad2
               WHERE cad2.cod = frn2.codforn
                     AND est2.cod = frn2.codestq
                     AND est2.cod = est.cod) fornc,
            '--' qt,
            '--' valorcusto,
            '--' situpedido,
            '--' situitem
       FROM estoque est
      WHERE est.qtd < est.qtdmin
            AND est.cod IN (SELECT frn.codestq FROM fornecedor frn)
        )
        ) grp
      ORDER BY descr ASC;

# para inserir em um pedido
         SELECT forn.codforn,
                cad.nome,
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
                 AND est.cod =2405;
SELECT * FROM estpedidocab WHERE cod= 274;
SELECT * FROM estpedidoitem WHERE codest= 2405;

          SELECT cb.cod pedido
            FROM estpedidocab cb,
                 estpedidoitem it
           WHERE cb.cod = it.codped
                 AND cb.tipo = 'compra'
                 AND cb.situ NOT IN('cancelado')
                 AND it.codest = 1340
           ORDER BY cb.cod DESC
           LIMIT 1;

/**
** GERINDO MAIS DE UM ESTOQUE
**/

# criando tabela para futura personalizacao
CREATE TABLE `estnum` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `descr` varchar(80) NOT NULL,
  `situacao` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO estnum (nome, descr) VALUES
                  ('Eletronica', 'Componentes eletronicos'),
                  ('Motopecas', 'Pecas para moto');
SELECT * FROM estnum;

SELECT * FROM estoque WHERE descr LIKE ('%corre%');
SELECT * FROM estoque WHERE cod = 855;
SELECT cod, descr, numest, clasf, `local` FROM estoque WHERE cod IN(855, 856, 857, 858, 859);
SELECT cod, descr, numest, catg, `local` FROM estoque WHERE cod IN(881, 882, 883, 884, 885, 886, 887, 888, 889, 890, 891, 892, 893, 896, 897, 898);
SELECT cod, descr, numest, catg, `local` FROM estoque WHERE cod IN(899, 900, 901, 902, 903, 904, 905, 906, 907, 908, 909, 910, 911, 912, 913, 914);
# todos abaixo sao da eletronica
# SELECT cod, descr, numest, catg, `local` FROM estoque WHERE cod IN(915, 916, 917, 918, 919, 920, 921, 922, 923, 924, 925, 926, 927, 928, 929, 930);
# SELECT cod, descr, numest, catg, `local` FROM estoque WHERE cod IN(931, 932, 933, 934, 935, 936, 937, 938, 939, 940, 941, 942, 943, 944, 945, 946);

# atualizacoes
# UPDATE estoque SET numest =2, situacao = 'ativo', catg= 17, `local` = 84 WHERE cod IN(855, 856, 881, 857, 858, 1006);
# UPDATE estoque SET numest =2, situacao = 'ativo', catg= 17, `local` = 84 WHERE cod IN(881, 882, 883, 884, 885, 886, 887, 888, 889, 890, 891, 892, 893, 896, 897, 898);
UPDATE estoque SET numest =2, situacao = 'ativo', catg= 17, `local` = 84 WHERE cod IN(899, 900, 901, 902, 903, 904, 905, 906, 907, 908, 909, 910, 911, 912, 913, 914);

SELECT cod, descr FROM estoque WHERE numest= 2;

# Categoria
ALTER TABLE `estcatg` ADD `numest` INT(11) NOT NULL COMMENT 'Para Varios estoques' AFTER `cod`;
# ALTER TABLE `estcatg` CHANGE `numest` `numest` INT(11) NOT NULL DEFAULT '1' COMMENT 'Para Varios estoques';

SELECT * FROM estcatg ORDER BY cod DESC;
SELECT * FROM estsubcatg ORDER BY cod DESC;

# Local
ALTER TABLE `estlocal` ADD `numest` INT(11) NOT NULL DEFAULT '1' COMMENT 'Para Varios estoques' AFTER `cod`;
SELECT * FROM estlocal ORDER BY cod DESC;


/**
** Acertando pedidos dos projetos eletronicos importados das tabelas antigas
** eletro_projetos - eletro_pedidos
**/

# Potenciometro GT1142 que estava apontando para o Site Madelupe
SELECT cod, ospro, tipo FROM estpedidocab WHERE cod= 59;# aponta para o pedido 36
SELECT * FROM eletro_pedidos WHERE cod= 36;# aponta para o projeto 3 - Demais ajustes e testes
SELECT * FROM eletro_projetos WHERE cod = 3;# Novicio QRP 80m
SELECT cod, tag, codant FROM getar_projetos WHERE nome LIKE '%Novicio %'; # Buscando na tabela atual - cod 90
SELECT * FROM getar_pedidos WHERE codproj= 90;# buscando qual pedido na tabela atual - esconhido o 302 - Confecção de Placas e Montagem
# corrigindo o vinculo errado
SELECT cod, ospro, tipo FROM estpedidocab WHERE cod= 59;# de 36 para o 302

# Potenciometro GT0082 que estava apontando para o Site vdsmusic.com.br
SELECT cod, codcli, ospro, tipo FROM estpedidocab WHERE cod= 287;# aponta para o pedido 62
SELECT cod, codproj, titulo FROM eletro_pedidos WHERE cod= 62;# aponta para o projeto 17 - Desenvolvimento e Montagem
SELECT cod, nome FROM eletro_projetos WHERE cod = 17;# Carga Eletronica
SELECT cod, tag, codant FROM getar_projetos WHERE nome LIKE '%Carga%'; # Buscando na tabela atual - NAO ENCONTRADO - Vai ter que ser importado o projeto
SELECT cod, tag, codant FROM getar_projetos WHERE codant = 17;# nao encontrado
SELECT cod, tag, codant, nome FROM getar_projetos WHERE tag LIKE 'PE%';# nao encontrado nada semelhane: Carga Eletronica
# corrigindo o vinculo errado
SELECT cod, ospro, tipo FROM estpedidocab WHERE cod= 287;# pedido para o projeto eletronico criado -> 649

# Resistor 100R 3W GT1213 que estava apontando para o: Siticalte - Site Atualizações
SELECT cod, codcli, ospro, tipo FROM estpedidocab WHERE cod= 67;# aponta para o pedido 40
SELECT cod, codproj, titulo FROM eletro_pedidos WHERE cod= 40;# aponta para o projeto 4 - Carga Fantasma
SELECT cod, nome FROM eletro_projetos WHERE cod = 4;# Equipamentos de Shack e Instrumentação
SELECT cod, titulo, codproj FROM getar_pedidos WHERE titulo LIKE '%Carga%'; # Buscando na tabela atual - 86
# corrigindo o vinculo errado
SELECT cod, ospro, tipo FROM estpedidocab WHERE cod= 67;# de 40 para o 650, pedido novo criado

# tentando localizar se tem mais pedidos de consumo atrelados erroneamente a projetos de programação 
SELECT cod, titulo, codproj FROM getar_pedidos WHERE codproj=86;
SELECT cod, codcli, ospro, tipo FROM estpedidocab WHERE ospro= 22;
SELECT cod, codcli, ospro, tipo FROM estpedidocab WHERE ospro < 200 AND tipo= 'consumo';# um dos ospro -> 27, codped 31
# Chave Gangorra 3T (KCD1102) Vermelha GT0527 - Projeto Eletronico: CentralMensagens
SELECT coditem, codped, codest FROM estpedidoitem WHERE codped = 27;
SELECT cod, titulo, codproj FROM getar_pedidos WHERE cod = 27;# sem titulo, projeto 9
SELECT cod, tag, codant, nome FROM getar_projetos WHERE cod = 9;

        SELECT cab.cod,
               cab.ospro,
               prj.nome,
               it.codest,
               cab.tipo
          FROM estpedidocab cab,
               estpedidoitem it,
               getar_projetos prj
         WHERE cab.tipo='consumo'
               AND it.codped= cab.cod
               AND cab.ospro = prj.cod
               AND cab.ospro <> '';

# excluindo um pedido
    SELECT it.codest, 
           est.descr,
           it.codped 
      FROM estpedidoitem it, estoque est
     WHERE it.codest = est.cod
           AND it.codped=20;
# DELETE FROM estpedidoitem WHERE codped= 20;
# DELETE FROM estpedidocab WHERE cod= 20;


# SQL usada no detalhamento do produto para ver em que pedidos foi usado
# GT1706 BD169D
     SELECT cb.cod codped,
            cad.nome,
# Sub Query com problemas
            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
               FROM getar_projetos pj,
                    getar_pedidos pd
              WHERE pj.cod = pd.codproj 
                    AND pd.cod = cb.ospro) projeto,
# 
            (SELECT CONCAT('<b>OS Numero: </b> ',
                    od.cod,
                    ' - ',
                    eq.descr,
                    ' - ',
                    eq.marca,
                    ' - ', eq.modelo)
               FROM ordem od, equipo eq 
              WHERE od.cod = cb.ospro
                    AND od.codeqp = eq.cod) equipo,
            (SELECT CONCAT('Quantidade: ', qt, ' - Custo: ', custo)
               FROM estpedidoitem
              WHERE codped = cb.cod AND codest = 1706 LIMIT 1) qtcst,
            (SELECT codest
               FROM estpedidoitem
              WHERE codped = cb.cod AND codest = 1706 LIMIT 1) codest,
            (SELECT COUNT(*)
               FROM estpedidoitem
              WHERE codped = cb.cod AND codest = 1706) AS numitem,
            cb.situ,
            cb.tipo
       FROM estpedidocab cb,
            estpedidoitem it,
            getar_cad cad
      WHERE cad.cod = cb.codcli
# Onde amarra o item com o codigo em foco? GT1706 (BD169D) ou o GT0004 (BC548
            AND it.coditem= 1706 # BD169D -> teste
            # AND cb.resp = 'pregis'
            AND cb.tipo IN ('venda', 'consumo');
# estudos na sub query
      SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
        FROM getar_projetos pj,
             getar_pedidos pd
       WHERE pj.cod = pd.codproj 
             AND pd.cod = 51;

# localizando o projeto pelo codigo do pedido
        SELECT prj.cod codproj,
               prj.nome,
               pd.cod codped,
               pd.titulo
        FROM eletro_projetos prj,
             eletro_pedidos pd
        WHERE prj.cod = pd.codproj
              AND pd.cod = 51;

# estudando novo SQL
# 1o Para os projetos
    SELECT est.cod,
           est.descr,
           cab.ospro,
           (SELECT CONCAT('Pedido do projeto: ', pdj.titulo, ' - Cod. Projeto: ',pdj.codproj)
              FROM getar_pedidos pdj # pedido do projeto
              WHERE pdj.cod = cab.ospro) predProj,
           cab.cod,
           cab.codforn,
           cab.tipo
       FROM estoque est,
            estpedidocab cab,
            estpedidoitem it
      WHERE cab.cod = it.codped
            AND it.codest = est.cod
            AND cab.tipo = 'consumo'
            # AND cab.ospro = 51;# Protecao sobre tensao
            AND est.cod= 0004;# BC548
          
     SELECT CONCAT('Pedido do projeto: ', pdj.titulo, ' - Cod. Projeto: ',pdj.codproj)
       FROM getar_pedidos pdj # pedido do projeto
      WHERE pdj.cod = 51;
# 
     SELECT cod,
            titulo,
            resp,
            prior,
            codproj,
            DATE_FORMAT(datareg, '%d/%m/%Y') datareg,
            dataini,
            dataclc,
            fatu,
            doc,
            (SELECT cod FROM estpedidocab WHERE ospro = 297 AND tipo = 'consumo' LIMIT 1) codpedcons,
            (SELECT COUNT(*) FROM estpedidocab WHERE ospro = 297 AND tipo = 'consumo') numcodpedcons,
            situacao
   FROM getar_pedidos
      WHERE cod= 297;

# Nova listagem somente para projetos e OSs
         SELECT cb.cod codpedido,
                (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM getar_projetos pj, getar_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                estq.descr,
                estq.cod,
                estq.nossonum,
                pd.codest,
                pd.qt,
                (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                pd.custo,
                cb.situ,
                cb.tipo,
                pd.situ situitem
           FROM estoque estq,
                estpedidocab cb,
                estpedidoitem pd
          WHERE estq.cod = pd.codest
                AND pd.codped = cb.cod
                AND cb.tpcons = 'projeto'
                AND cb.nmproj = 653
         ORDER BY codpedido, descr;

SELECT * FROM estpedidocab WHERE ospro=297;
/**
** 
**/
     
# Ultimo pedido recebido
(SELECT CONCAT ('Pedido GT', cb.cod,
            ': Valor de Custo=', it.custo,
            ': Frete=', cb.vlfrete)
            strPedRec
        FROM estpedidocab cb,
             estpedidoitem it
       WHERE cb.cod = it.codped
             AND cb.tipo = 'compra'
             AND it.codest = estq.cod
             AND cb.situ = 'recebido'
       ORDER BY cb.cod DESC
       LIMIT 1) strPedRec,
# 
                    (SELECT cb.situ stpedido
                       FROM estpedidocab cb,
                            estpedidoitem it
                      WHERE cb.cod = it.codped
                            AND cb.tipo = 'compra'
                            AND it.codest = estq.cod
                            AND cb.situ NOT IN('cancelado')
                      ORDER BY cb.cod DESC
                      LIMIT 1) AS stpedido,
                      (SELECT cad.nome
                         FROM estpedidocab cb,
                              getar_cad cad,
                              estpedidoitem it
                        WHERE cb.cod = it.codped
                              AND cad.cod = cb.codforn
                              AND cb.tipo = 'compra'
                              AND it.codest = estq.cod
                              AND cb.situ NOT IN('cancelado')
                        ORDER BY cb.cod DESC
                        LIMIT 1) AS nomeforn
               FROM estoque estq,
                    estlocal loc,
                    estquadra qd,
                    estrua rua
              WHERE loc.cod = estq.`local`
                    AND qd.cod = loc.quadra
                    AND rua.cod = qd.codrua
                    AND estq.numest = 1
                    AND estq.cod = 355;# GT0355 Capa 33uF x 16

# por partes
     SELECT CONCAT ('Pedido GT', cb.cod,
            '(', (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn), ')'
            '| Valor de Custo= ', it.custo,
            '| Frete Agregado= ', (cb.vlfrete /(SELECT COUNT(*) numItens FROM estpedidoitem itsoma WHERE itsoma.codped = cb.cod)))
            strPedRec,
            cb.cod pedido,
            FORMAT(it.custo, 2, 'de_DE') custo,
            FORMAT(cb.vlfrete, 2, 'de_DE') vlfrete,
            (SELECT COUNT(*) numItens FROM estpedidoitem itsoma WHERE itsoma.codped = cb.cod) numItens,            
            (cb.vlfrete /(SELECT SUM(qt) numPecas FROM estpedidoitem itsoma WHERE itsoma.codped = cb.cod)) custFretAg,
            (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn) nomforn,
            cb.situ
        FROM estpedidocab cb,
             estpedidoitem it
       WHERE cb.cod = it.codped
             AND cb.tipo = 'compra'
             AND it.codest = 2840 # Cap 3300uF x 25V
             AND cb.situ = 'recebido'
       ORDER BY cb.cod DESC
       LIMIT 1;
 # para calcular o numero de itens
SELECT COUNT(*) numItens FROM estpedidoitem WHERE codped = 269;
SELECT codest, qt FROM estpedidoitem WHERE codped = 369;
SELECT SUM(qt) FROM estpedidoitem WHERE codped = 369;

/**
** Pedido em estudo GT269
Total 137.19
Frete 46
Num itens= 24 pecas
**/
     SELECT CONCAT ('Pedido GT', cb.cod,
            '(', (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn), ')'
            '| Valor de Custo= ', it.custo,
            '| em ', cb.situ,
            '(', cb.nomeped,')'
            ) strPedRec,
            cb.cod pedido,
            FORMAT(it.custo, 2,'de_DE') custo,
            cb.vlfrete,
            (SELECT COUNT(*) numItens FROM estpedidoitem itsoma WHERE itsoma.codped = cb.cod) numItens,            
            (cb.vlfrete /(SELECT COUNT(*) numItens FROM estpedidoitem itsoma WHERE itsoma.codped = cb.cod))*it.custo custFret,
            (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn) nomforn,
            cb.situ
        FROM estpedidocab cb,
             estpedidoitem it
       WHERE cb.cod = it.codped
             AND cb.tipo = 'compra'
             AND it.codest = 2434 # Diodo Varicap na Mouser
             AND cb.situ IN('processamento', 'espera', 'estudo')
       ORDER BY cb.cod DESC
       LIMIT 1;
SELECT * FROM estpedidocab WHERE cod= 249;
SELECT cod, situ, tipo FROM estpedidocab WHERE situ NOT IN('recebido', 'cancelado');
SELECT cod, situ, tipo FROM estpedidocab WHERE situ IN('processamento', 'espera', 'estudo');

/**
** Observacoes dos produtos
**/
# Mais de uma observacao para o mesmo produto
SELECT * FROM estobs obs WHERE codestq = 3356;

# Tipo errado de relacionamento, talves seja o direcionamento: estoque-> observações e não com esta agora observações-> estoque
CREATE TABLE `estobs` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codestq` int(11) NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_codobs` (`codestq`),
  CONSTRAINT `fk_codobs` FOREIGN KEY (`codestq`) REFERENCES `estoque` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE estobs DROP KEY `fk_codobs`;
ALTER TABLE estoque ADD CONSTRAINT fk_codobs FOREIGN KEY (cod) REFERENCES estobs(cod);
# estudos
SELECT * FROM estobs obs WHERE codestq = 1798;
        SELECT est.cod,
               obs.cod
          FROM estobs obs,
               estoque est
         WHERE obs.codestq = est.cod
    ORDER BY est.cod;

# todas as observaçoes tem seu produto referenciado
SELECT obs.cod FROM estobs obs, estoque est WHERE obs.codestq NOT IN(SELECT cod FROM estoque);
SELECT COUNT(codestq), codestq FROM estobs WHERE codestq= (SELECT codestq FROM estobs);

/**
** AREA DE TESTES
**/
         SELECT est.cod,
                est.nossonum,
                est.descr,
                est.descrtec,
                CASE
                   WHEN est.und IN('pc', 'und') THEN ROUND(qtd, 0)
                   WHEN est.und IN('m', 'ml', 'Kg') THEN ROUND(qtd, 3)
                END qtd,
                est.und,
                (SELECT nome FROM getar_cad WHERE cod= est.fabr) fabr,
                (SELECT etq FROM estlocal WHERE cod = est.local) etqlocal,
                (SELECT descr FROM estcatg WHERE cod = est.catg) descrcatg,
                (SELECT descr FROM estsubcatg WHERE cod = est.subcatg) descrsubcatg,
                est.clasf,
                est.situacao
           FROM estoque est
          WHERE est.situacao != 'temporario'
                AND est.cod =3195;

SELECT cod, descr FROM estoque WHERE descr LIKE ('Resi% 100R%');

     SELECT est.cod,
            est.nossonum,
            est.descr,
            est.descrtec,
            CASE
               WHEN est.und IN('pc', 'und') THEN ROUND(qtd, 0)
               WHEN est.und IN('m', 'ml', 'Kg') THEN ROUND(qtd, 3)
            END qtd,
            est.und,
            (SELECT nome FROM getar_cad WHERE cod= est.fabr) fabr,
            (SELECT etq FROM estlocal WHERE cod = est.local) etqlocal,
            (SELECT descr FROM estcatg WHERE cod = est.catg) descrcatg,
            (SELECT descr FROM estsubcatg WHERE cod = est.subcatg) descrsubcatg,
            CASE
                WHEN est.clasf ='ne' THEN 'N&atilde;o Estocavel'
                WHEN est.clasf = 'colec' THEN 'Colecionavel'
                ELSE est.clasf
            END clasf,
            # est.clasf,
            est.situacao
       FROM estoque est
      WHERE est.situacao != 'temporario'
            AND est.numest = 1
ORDER BY cod DESC LIMIT 1;

SELECT CONCAT ('Pedido PED', cb.cod,
            '(', (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn), ')'
            '| Valor de Custo= ', it.custo,
            '| em situa&ccedil;&atilde;o: (', cb.situ,
            ' - ', cb.nomeped,')') strPedRec
        FROM estpedidocab cb,
             estpedidoitem it
       WHERE cb.cod = it.codped
             AND cb.tipo = 'compra'
             AND it.codest = 3410
             AND cb.situ IN('processamento', 'espera', 'estudo', 'pago')
       ORDER BY cb.cod DESC
       ;

     SELECT it.custo custo,
            cb.situ situ,
            cb.nomeped nomeped,
            cb.cod cod,
            (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn) forn,
            cb.cod codped
        FROM estpedidocab cb,
             estpedidoitem it
       WHERE cb.cod = it.codped
             AND cb.tipo = 'compra'
             AND it.codest = 3394
             AND cb.situ IN('processamento', 'espera', 'transito', 'estudo', 'pago')
       ORDER BY cb.cod DESC;

     SELECT forn.codforn,
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
             AND ped.situ IN('processamento', 'estudo', 'transito', 'estudo')
             AND est.qtd < est.qtdmin
             AND est.cod NOT IN(SELECT itm.codest
                                  FROM estpedidocab cab,
                                       estpedidoitem itm
                                 WHERE cab.cod = itm.codped
                                       AND cab.situ IN('processamento', 'espera')
                                       AND cab.tipo= 'compra'
                                       AND itm.codest = est.cod)
             AND est.cod = 3410;

     SELECT itm.codest
            FROM estpedidocab cab,
                 estpedidoitem itm
           WHERE cab.cod = itm.codped
                 AND cab.situ IN('processamento', 'espera', 'transito', 'estudo')
                 AND cab.tipo= 'compra'
                 AND itm.codest =3410;

# SQL usada em inserPedido($cod) -> funcoes_estoque.php
     SELECT codped,
            nome,
            projeto,
            equipo,
            tipo                    
       FROM (SELECT cb.cod codped,
                    cad.nome,
                    (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM getar_projetos pj, getar_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                    (SELECT CONCAT('<b>OS Numero: </b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                    (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = 3417) AS numitem,
                    cb.situ,
                    cb.tipo
               FROM estpedidocab cb,
                    getar_cad cad
              WHERE cad.cod = cb.codcli
                    AND cb.tipo IN ('venda', 'consumo')
                    AND cb.situ = 'processamento') as cb
      WHERE numitem = 0;# vem vazio o "projeto" e o "equipo

     SELECT cb.cod codped,
            cad.nome,
            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
               FROM getar_projetos pj,
                    getar_pedidos pd
              WHERE pj.cod = pd.codproj
                    AND pd.cod = cb.nmproj) projeto,
            (SELECT CONCAT('<b>OS Numero: </b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
               FROM ordem od,
                    equipo eq
              WHERE od.cod = cb.ospro
                    AND od.codeqp = eq.cod) equipo,
            (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = 3417) AS numitem,
            cb.situ,
            cb.tipo
       FROM estpedidocab cb,
            getar_cad cad
      WHERE cad.cod = cb.codcli
            AND cb.tipo IN ('venda', 'consumo')
            AND cb.situ = 'processamento';
SELECT * FROM estpedidocab WHERE cod = 638;

     SELECT cb.cod codpedido,
            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM getar_projetos pj, getar_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
            cb.situ,
            cb.tipo
       FROM estpedidocab cb
      WHERE cb.cod = 668;

UPDATE estpedidoitem SET qt= 1.000, custo = 186,53 WHERE coditem= 6577;

# Erro em analise
# ERRO AO PESQUISAR DADOS!!
# You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY cb.tipo DESC, cb.situ DESC' at line 18
 SELECT cb.cod codpedido,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                        cb.situ,
                        cb.tipo,
                        cb.nomeped,
                        CASE
                            WHEN cb.tipo =  'compra' THEN 'Compra' # 'compra/reposicao'
                            WHEN cb.tipo = 'venda' THEN 'Venda' # 'venda/orcamento'
                            WHEN cb.tipo = 'consumo' THEN 'Consumo'
                            ELSE 'indefinido'
                        END AS desctipo,
                        (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens
                   FROM estpedidocab cb
                   WHERE cb.cod =
                ORDER BY cb.tipo DESC, cb.situ DESC;

ERRO AO PESQUISAR DADOS!!
# You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'AND cb.situ IN('processamento', 'espera', 'transito', 'estudo', 'pago')
#       ' at line 12
 SELECT it.custo custo,
                            cb.situ situ,
                            cb.nomeped nomeped,
                            cb.cod cod,
                            (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn) forn,
                            cb.cod codped
                        FROM estpedidocab cb,
                             estpedidoitem it
                       WHERE cb.cod = it.codped
                             AND cb.tipo = 'compra'
                             AND it.codest = 
                             AND cb.situ IN('processamento', 'espera', 'transito', 'estudo', 'pago')
                       ORDER BY cb.cod DESC;

# pesquisa de pedidos de um fornecedor
SELECT cb.cod codpedido,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                        cb.situ,
                        cb.tipo,
                        cb.nomeped,
                        CASE
                            WHEN cb.tipo =  'compra' THEN 'Compra' # 'compra/reposicao'
                            WHEN cb.tipo = 'venda' THEN 'Venda' # 'venda/orcamento'
                            WHEN cb.tipo = 'consumo' THEN 'Consumo'
                            ELSE 'indefinido'
                        END AS desctipo,
                        (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens
                   FROM estpedidocab cb
                   WHERE cb.codforn = (SELECT cod FROM getar_cad WHERE nome LIKE ('Eletro%') LIMIT 1)
                ORDER BY cb.tipo DESC, cb.situ DESC;

SELECT cod FROM getar_cad WHERE nome LIKE ('Proesi%') LIMIT 1;

SELECT codpedido,
                                descr,
                                descrtec,
                                codest,
                                fornc,
                                qtd qt,
                                valorcusto custo,
                                situpedido,
                                situitem
                           FROM (# parte 1: os com pedido em andamento 
                           SELECT CONCAT('Pedido: ',cab.cod) codpedido,
                            est.descr,
                            est.descrtec,
                            est.cod codest,
                            (SELECT SUBSTRING(nome, 1, 20) FROM getar_cad WHERE cod= cab.codforn) fornc,
                            itm.qt qtd,
                            itm.custo valorcusto,
                            cab.situ situpedido,
                            itm.situ situitem
                       FROM estoque est,
                            estpedidocab cab,
                            estpedidoitem itm
                      WHERE cab.cod= itm.codped
                            AND itm.codest = est.cod
                            AND cab.tipo = 'compra'
                            AND est.cod = itm.codest
                            AND cab.situ IN('processamento', 'transito', 'espera')
                            AND est.situacao = 'normal'
                            AND est.qtd < est.qtdmin
                            AND est.catg = 9 AND est.subcatg = 22
                            UNION(SELECT '--' codpedido,
                                        est.descr,
                                        est.descrtec,
                                        est.cod codest,
                                        '--' fornc,
                                        '--' qt,
                                        '--' custo,
                                        '--' situpedido,
                                        '--' situitem
                                   FROM estoque est
                                  WHERE est.qtd < est.qtdmin
                                        AND est.situacao = 'normal'
                                        AND est.catg = 9 AND est.subcatg = 22)) qrp
                            ORDER BY descr ASC;

      
/*
** Componete para um pedido de projeto eletronico
*/
# para a edicao de um componente e insercão no pedido de consumo, arquivo estoque_cad.inc.php
    SELECT codped,
            nome,
            projeto,
            equipo,
            tipo                    
       FROM (SELECT cb.cod codped,
                    cad.nome,
                    (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
                       FROM getar_projetos pj,
                            getar_pedidos pd
                      WHERE pj.cod = pd.codproj
                            # AND pd.cod = cb.ospro) projeto,
                            AND pd.cod = cb.nmproj) projeto,
                    (SELECT CONCAT('<b>OS Numero: </b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                       FROM ordem od,
                            equipo eq
                      WHERE od.cod = cb.ospro
                            AND od.codeqp = eq.cod) equipo,
                    (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = 0162) AS numitem,
                                    cb.situ,
                                    cb.tipo
                               FROM estpedidocab cb,
                                    getar_cad cad
                              WHERE cad.cod = cb.codcli
                                    AND cb.tipo IN ('venda', 'consumo')
                                    AND cb.situ = 'processamento') as cb
                      WHERE numitem = 0;

# para detalhamento num pedido de compra consumo, arquico pedido-cad.inc.php
SELECT nomeped,
                    (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                    (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                    (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) refped
                        FROM ordem od,
                             equipo eq
                       WHERE od.codeqp = eq.cod
                             AND od.cod = cb.ospro) detalos,
                    (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) refped
                             FROM getar_projetos pj,
                                  getar_pedidos pd
                            WHERE pj.cod = pd.codproj
                                  AND pd.cod = cb.nmproj) detalpro,
                    cb.ospro,
                    date_format(cb.dtped, '%d/%m/%Y') dtped,
                    date_format(cb.dtcheg, '%d') diacheg,
                    date_format(cb.dtcheg, '%m') mescheg,
                    date_format(cb.dtcheg, '%Y') anocheg,
                    date_format(cb.dtrecb, '%d') diarecb,
                    date_format(cb.dtrecb, '%m') mesrecb,
                    date_format(cb.dtrecb, '%Y') anorecb,
                    cb.rastr,
                    cb.vlfrete,
                    cb.empfrete,
                    cb.situ,
                    cb.tipo
               FROM estpedidocab cb
              WHERE cb.cod = 711; # 711 na area de testes

      SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) refped
        FROM getar_projetos pj,
             getar_pedidos pd
       WHERE pj.cod = pd.codproj
             AND pd.cod = 711;

# Para listagem de pedidos em Boas Vindas
     SELECT cb.cod cod,
            cb.nomeped,
            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) nomeforn,
            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) nomecli,
            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome)
               FROM getar_projetos pj,
                    getar_pedidos pd
              WHERE pj.cod = pd.codproj
                    AND pd.cod = cb.nmproj) projeto,
            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.marca, ' - ', eq.modelo)
               FROM ordem od, equipo eq
              WHERE od.cod = cb.ospro
                AND od.codeqp = eq.cod) equipo,
            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
            cb.tipo,
            cb.situ
       FROM estpedidocab cb
       WHERE cb.situ IN ('processamento', 'transito', 'pago')
       ORDER BY cb.tipo ASC;

          SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome)
            FROM getar_projetos pj,
                 getar_pedidos pd
           WHERE pj.cod = pd.codproj
                 AND pd.cod = cb.nmproj;

SELECT * FROM estpedidocab WHERE tipo= 'consumo' ORDER BY cod DESC LIMIT 5;

         SELECT cb.cod codpedido
           FROM estpedidocab cb
          WHERE cb.nmproj = 299;

UPDATE estoque
        SET numest= '1',
            nossonum= '',
            descr= 'Temporario xxx',
            descrtec= '',
            datasheet= '',
            und= 'pc',
            qtd= 0,
            clasf= 'novo',
            situacao= 'normal',
            qtdmin= 0,
            valorcusto= 0.00,
            valorvenda= 0.00,
            moeda= 'Real',
            peso= 0,
            local= 61,
            catg= 1,
            subcatg= 2
        WHERE cod=3625;