/**
** modelagem atual das tabelas
**/
SHOW CREATE TABLE getar_artgch;
CREATE TABLE `getar_artgch` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `dest` tinyint(1) DEFAULT 1,
  `nome` varchar(20) DEFAULT NULL,
  `linha` varchar(20) DEFAULT '1',
  `modelo` varchar(20) DEFAULT NULL,
  `chamada` varchar(100) DEFAULT NULL,
  `datacri` date NOT NULL,
  `imagem` varchar(100) NOT NULL DEFAULT 'boletim.gif',
  `situacao` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM AUTO_INCREMENT=314 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci

SHOW CREATE TABLE getar_artg01;
CREATE TABLE `getar_artg01` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codartg` varchar(4) DEFAULT NULL,
  `titulo` varchar(60) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT 'radio.gif',
  `intro` text DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `fonte` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM AUTO_INCREMENT=298 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

SELECT * FROM getar_artg01 WHERE codartg = 2;

SHOW CREATE TABLE getar_linha;
CREATE TABLE `getar_linha` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) DEFAULT NULL,
  `descr` varchar(100) DEFAULT NULL,
  `situacao` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

SHOW CREATE TABLE getar_artgft;
/**
** CONSULTAS ADMINISTRATIVAS
**/
     SELECT ch.cod,    
            ch.chamada,
            ch.dest,
            ln.nome linha,
            ch.situacao
       FROM getar_artgch ch,
            getar_linha ln
      WHERE ln.cod = ch.linha
            AND ch.situacao = 'inativo' ;

SELECT * FROM getar_linha;
SELECT cod, nome, datacri, situacao FROM getar_artgch WHERE cod=312;
SELECT cod, nome, datacri, situacao FROM getar_artgch WHERE nome='boasvindas';
         SELECT nome
            FROM getar_linha
           WHERE situ = 'ativo';

        SELECT ch.modelo,
               (SELECT nome FROM getar_linha WHERE cod = ch.linha) linha,
               (SELECT descr FROM getar_linha WHERE cod = ch.linha) descr
          FROM getar_artgch ch
         WHERE cod=142;
SELECT * FROM getar_artgch WHERE cod = 313;

SELECT * FROM getar_artgch WHERE modelo = 'rv';
SELECT * FROM getar_artgch WHERE modelo = 'ft';
SELECT * FROM getar_artgch WHERE nome = 'boasvindas';
SELECT * FROM getar_artgch WHERE modelo = 'fck';
SELECT * FROM getar_artg01 WHERE codartg = 52;
SELECT * FROM getar_artg02;
# SELECT * FROM getar_artgft WHERE codartg=19;# tabela obsoleta e excluida
# SELECT * FROM getar_artg02;#  tabela obsoleta e excluida

# ajustes de tabela
/*ALTER TABLE `getar_artgft` ADD `seq` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencia em que lista' AFTER `cod`;
ALTER TABLE `getar_artgft` ADD `titulo` varchar(120) NOT NULL DEFAULT '' COMMENT 'Titulo para a foto' AFTER `codartg`;
ALTER TABLE `getar_artgft` ADD `minifoto` VARCHAR(60) NOT NULL DEFAULT '' COMMENT 'Miniatura para a foto' AFTER `imagem`;*/
ALTER TABLE `getar_artgch` CHANGE `linha` `linha` INT(11) NULL DEFAULT '1';
ALTER TABLE getar_artgch CHANGE data datacri date NOT NULL;
SHOW CREATE TABLE getar_artgch;

ALTER TABLE `getar_linha` ADD `situacao` VARCHAR(20) NOT NULL DEFAULT 'ativo' AFTER `descr`;

DELETE FROM getar_artgch WHERE cod= 117;
DELETE FROM getar_artg01 WHERE codartg= 117;

INSERT INTO schw.getar_linha (cod, nome, descr) 
	VALUES (10, 'lavadoras', 'Artigos referentes a placa de maquina de lavar roupa');
INSERT INTO getar_artgch (dest, nome, linha, modelo, chamada, `data`, imagem, situacao)
            VALUES(1, '', 1, 'ft', '', NOW(), 'radio.gif', 'temporario');
INSERT INTO getar_artgch (cod, dest, nome, linha, modelo, chamada, datacri, imagem, situacao)
            VALUES(2, 1, 'defigetar', 1, 'rv', '', '2009-11-07', 'LogoGETAR-qd.png', 'ativo');
INSERT INTO getar_artg01 (cod, codartg, intro, texto, titulo, fonte) 
            VALUES (299, 2, '', '', '', '');
UPDATE getar_artgch SET modelo ='fck' WHERE cod= 2;

# estudos para eliminar o campo getar_artgch.chamada
SELECT COUNT(*) FROM getar_artgch WHERE chamada != '';
SELECT cod, nome FROM getar_artgch WHERE chamada != '' ORDER BY cod DESC LIMIT 5;
SELECT cod, nome FROM getar_artgch WHERE chamada != '' ORDER BY cod DESC LIMIT 5;
        SELECT ch.cod,
               ch.nome
          FROM getar_artgch ch,
               getar_artg01 rv
         WHERE rv.codartg = ch.cod 
               AND ch.chamada != ''
               AND rv.intro = '';

/**
** PROCURANDO UMA PALAVRA CHAVE NOS ARTIGOS
*/
SELECT codartg, intro, texto FROM getar_artg01 WHERE texto LIKE('%_POST%');
             SELECT ch.cod,
                    ch.chamada,
                    ln.nome linha,
                    ch.situacao
               FROM getar_artgch ch,
                    getar_artg01 rv,
                    getar_linha ln
              WHERE ln.cod = ch.linha
                    AND ch.cod = rv.codartg
                    AND ch.situacao = 'ativo' 
                    AND rv.texto LIKE('%_POST%')
               ORDER BY ch.cod ASC;
/**
** Procurando hashtag na INTRO, não colocar na CHAMADA-> campo a ser abolido!!!
**/
SELECT * FROM getar_artg01 WHERE intro LIKE ('%#%');
        SELECT ch.cod,
               rv.titulo,
               rv.intro,
               REGEXP_SUBSTR(rv.intro, '#[a-z]+') AS tag,
               REGEXP_SUBSTR(rv.intro, '-[0-9]+') AS tagnum
          FROM getar_artgch ch,
               getar_artg01 rv
         WHERE ch.cod= rv.codartg
               AND rv.intro LIKE ('%#%');

SELECT * FROM getar_artg01 WHERE intro REGEXT '^[#]';# You have an error in your SQL syntax ...syntax to use near 'REGEXT '^[#]' 
SELECT * FROM getar_artg01 WHERE intro REGEXT('^[#]');# You have an error in your SQL syntax ...syntax to use near 'REGEXT ('^[#]') 
SELECT * FROM getar_artg01 WHERE cod =1;
/**
** Manipulando e corrigindo artigos no SQL
**/
SELECT * FROM getar_artgch WHERE cod =  234;
SELECT * FROM getar_artg01 WHERE texto LIKE ('%blindagem%');

# fotos dos artigos modelo FOTO
INSERT INTO getar_artgft (codartg, imagem, descr)
    VALUES (130, 'placa_emenda01.jpg', 'Traçar com régua metalica a linha inicial, puxando bem leve forçando um pouco para a lateral da régua. '),
     (130, 'placa_emenda01.jpg', 'Não forçar a lâmina, sempre só encostando no cobre'),
     (130, 'placa_emenda01.jpg', 'Iniciar empurrando a Lâmina do estilete sobre o '),
     (130, 'placa_emenda01.jpg', 'Após sentir que esta ficando pessado pode ir forçando mais, mas almento aos poucos a força de tração.'),
     (130, 'placa_emenda01.jpg', 'Usar parte da lupa de maior grau de almento.'),
     (130, 'placa_emenda01.jpg', 'Depois de cortado o cobre, usando a luz da lanterna atraz da placa acompanhar a transperencia do fenolite ir almentando aos poucos o espaçamento entre trilhas.'),
     (130, 'placa_emenda01.jpg', 'Passar uma pincelada de fluido de solda'),
     (130, 'placa_emenda01.jpg', 'Com um pouco de solda em pasta fazer a estanhagem');

SELECT * FROM getar_artgft WHERE codartg = 130;

/**
** Corrigindo erro que perdeu os nomes dos artigos
** ficou tudo boas vindas
**/
CREATE TABLE artgchtemp(
    cod INT(11),
    nome varchar(20)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO artgchtemp (cod) SELECT cod FROM getar_artgch;
SELECT * FROM artgchtemp ORDER BY cod DESC LIMIT 5;
SELECT cod, nome FROM getar_artgch;# 272 linha
SELECT cod, nome FROM getar_artgch ORDER BY cod DESC LIMIT 5;# O ultimo é cod 313

# ver TARF5719
DELIMITER //

CREATE PROCEDURE corrige()
BEGIN
    DECLARE contador INT DEFAULT 1;
    WHILE contador < 312 DO
        SELECT * FROM getar_artg01 WHERE intro LIKE ('%#%');
        SELECT ch.cod,
               rv.titulo,
               rv.intro,
               REGEXP_SUBSTR(rv.intro, '#[a-z]+') AS tag,
               REGEXP_SUBSTR(rv.intro, '-[0-9]+') AS tagnum
          FROM getar_artgch ch,
               getar_artg01 rv
         WHERE ch.cod= rv.codartg
               AND rv.intro LIKE ('%#%');
    END WHILE;
    SELECT contador;
END //

CREATE PROCEDURE corrige()
BEGIN
    SET @contador = 1;
    WHILE contador < 312 DO
        SET contador = contador + 1;
    END WHILE;
    SELECT contador;
END //

DELIMITER ;
SELECT contador;
# E para executá-la:
CALL corrige();
DROP PROCEDURE corrige;
# O mais pratico e proficional eh usar JOIN
UPDATE artgchtemp a
JOIN getar_artgch g ON g.cod = a.cod
SET a.nome = g.nome;

UPDATE getar_artgch a
JOIN artgchtemp g ON g.cod = a.cod
SET a.nome = g.nome;

SELECT cod, nome FROM getar_artgch LIMIT 5;

UPDATE getar_artgch SET (
/**
** AREA DE TESTES
**/
    SELECT titulo,
           intro, 
           texto,
           fonte
      FROM getar_artg01 txt,
           getar_artgch ch
     WHERE ch.cod = txt.codartg
           AND ch.nome = 'boasvindas';

           SELECT ch.cod,
                ch.nome,
                rv.titulo,
                rv.intro,
                ch.dest,
                ch.situacao,
                ch.linha
           FROM getar_artgch ch,
                getar_artg01 rv
           WHERE ch.cod = rv.codartg
                 # AND ch.situacao NOT IN('temporario');
                 AND ch.cod = 312;


    (SELECT ch.cod,
                ch.nome,
                rv.titulo,
                ch.dest,
                ch.situacao,
                ch.linha
           FROM getar_artgch ch,
                getar_artg01 rv,
                getar_linha ln
           WHERE ch.cod = rv.codartg
                      AND ln.cod = ch.linha
                 AND ch.situacao NOT IN('temporario'))
         UNION(SELECT ch.cod,
                      ch.nome,
                      ft.titulo,
                      ch.dest,
                      ch.situacao,
                      ln.nome
                 FROM getar_artgch ch,
                      getar_artgft ft,
                      getar_linha ln
                WHERE ch.cod = ft.codartg
                      AND ln.cod = ch.linha
                      AND ch.situacao NOT IN('temporario'))
             ORDER BY cod DESC;

UPDATE getar_artgch
                        SET imagem='314'
                      WHERE cod=314;