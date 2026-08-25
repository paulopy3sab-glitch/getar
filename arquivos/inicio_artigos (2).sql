/**
**
**/

CREATE TABLE `getar_artgch` (
  `cod` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `dest` tinyint(1) DEFAULT '1',
  `nome` varchar(20) DEFAULT NULL,
  `linha` varchar(20) DEFAULT '1',
  `modelo` varchar(20) DEFAULT NULL,
  `chamada` varchar(100) DEFAULT NULL,
  `data` date NOT NULL DEFAULT '2006-12-15',
  `imagem` varchar(100) NOT NULL DEFAULT 'boletim.gif',
  `situacao` varchar(20) NOT NULL DEFAULT 'ativo'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT = 'cabecalho dos artigos';

CREATE TABLE `getar_artg01` (
  `cod` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `codartg` varchar(4) DEFAULT NULL,
  `titulo` varchar(60) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT 'radio.gif',
  `intro` text,
  `texto` text,
  `fonte` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT = 'parte textual dos artigos modelo REVISTA (BLOG)';

CREATE TABLE `getar_artg02` (
  `cod` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `codartg` varchar(4) DEFAULT NULL,
  `titulo` varchar(60) DEFAULT NULL,
  `intro` text,
  `rodape` varchar(100) DEFAULT NULL,
  `amplia` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT= 'parte introdutoria dos artigos modelo FOTO (GALERIA)';

CREATE TABLE `getar_artgft` (
  `cod` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `codartg` varchar(4) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT '-' COMMENT 'nome da foto armazenado na pasto fotos/ ou - para indicar que eh somente comentario',
  `descr` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT = 'fotos para os artigos modelo FOTO (GALERIA)';

CREATE TABLE `getar_linha` (
  `cod` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(20) DEFAULT NULL,
  `descr` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
INSERT INTO getar_linha (`nome`, `descr`) VALUES('Geral', 'Assuntos em geral' );

/**
** artigo base boas vindas
**/
INSERT INTO getar_artgch(dest, nome, linha, modelo, chamada, `data`, imagem, situacao)
            VALUES(1, 'boasvindas', 1, 'fck',
                   'Boas vindas ao sistema GETAR para os visitantes e aos cadastrado para logon.',
                    '2016-07-12', 'radio.gif', 'ativo');
INSERT INTO getar_artg01 (codartg, titulo, imagem, intro, texto, fonte)
            VALUES (1, 'Boas Vindas ao Getar', 'radio.gir',
                    'Boas vindas ao sistema GETAR.',
                    '<div>
<h1>GETAR - GESTOR ADMINISTRATIVO</h1>
<p class="txt">Este ERP foi criado em meados de 2008 para atender nossas demandas internas de gerenciamento de projetos, controle financeiro e cadastro de cliente.<br>
Desde de ent&atilde;o, vem se desenvolvendo e ganho outras funcionalidades.</p>
<p class="txt">Esperamos que esta vers&atilde;o seja uma ferramenta produtiva que alcance todos os objetivos de seu dia a dia<br>
Duvidas ou sugest&otilde;es utilize os canais de ajuda que disponibilizamos:<br>
<ul>
    <li>(92)9 9252-2852 (Celular Vivo)</li>
    <li>(92)9 8186-4839 (Celular TIM) e Whatsapp</li>
    <li>Emails: contato@schw.com.br - paulo_schw@yahoo.com.br</br>
</ul></p>
<p style="text-align: right;" class="autor"><em>Paulo Regis;<br />
Um servo do alt&iacute;ssimo, nada mais.</em></p>
</div>',
        '');

/**
** AREA DE TESTES
**/
TRUNCATE TABLE getar_artg01;
SELECT * FROM getar_linha;
SELECT * FROM getar_artgch;
SELECT * FROM getar_artgch WHERE nome= 'boasvindas';
SELECT * FROM getar_artg01;