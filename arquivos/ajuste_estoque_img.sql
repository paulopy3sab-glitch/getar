CREATE TABLE estoqueimg(
    cod int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    codestq int(11) NOT NULL,
    imagem VARCHAR(120) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE estoqueimg ADD CONSTRAINT fk_codIMG FOREIGN KEY (codestq) REFERENCES estoque (cod);
#
INSERT INTO estoqueimg (codestq, imagem) SELECT cod, foto FROM estoque WHERE foto != '';
