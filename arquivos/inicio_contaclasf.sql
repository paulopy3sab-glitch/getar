-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Set-2018 às 14:52
-- Versão do servidor: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `getarschw`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `getar_contaclasf`
--

CREATE TABLE `getar_contaclasf` (
  `cod` int(11) NOT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `codctco` int(11) NOT NULL,
  `descr` text,
  `situacao` varchar(60) NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='classificacao de lancamentos';

--
-- Extraindo dados da tabela `getar_contaclasf`
--

INSERT INTO `getar_contaclasf` (`cod`, `nome`, `codctco`, `descr`, `situacao`) VALUES
(1, 'Entrada Capital', 1, 'Capital inicial ou credito para saldar pagamentos', 'ativo'),
(2, 'Pag. Div.', 1, 'Pagamentos Diversos', 'ativo'),
(3, 'Rec. Diversos', 1, 'Recebimentos Diversos', 'ativo'),
(4, 'Deposito Dinheiro', 2, 'Depósito em dinheiro', 'ativo'),
(5, 'Deposito Cheque-24h', 2, 'Deposito em cheque. Aguarda 24h para compensação', 'ativo'),
(6, 'Deposito Cheque-48h', 2, 'Deposito em cheque. Aguarda 48h para compensação', 'ativo'),
(7, 'Transferencia', 2, 'Vem de algum tipo de tranferencia', 'ativo'),
(8, 'Saque', 2, 'Saque diversos', 'ativo'),
(9, 'Poupado', 2, 'Transferido para uma variação de poupança', 'ativo'),
(10, 'Aplicação', 2, 'Aplicado em algum investimento', 'ativo'),
(11, 'Pag. Cartão', 2, 'Pag cartão de crédito', 'ativo'),
(12, 'Taxas e Tarifas', 2, 'Taxas, tarifas, impostos', 'ativo'),
(13, 'Internet/telefone', 2, 'Pag. acesso internet e telefonia fixa', 'ativo'),
(14, 'Telefone', 2, 'Telefonia Pré paga', 'ativo'),
(15, 'Serviços WEB', 2, 'Hospedagem, seguranção e afins', 'ativo'),
(16, 'Pag. Proj. Program', 2, 'Pag. recebido de projetos de programação ou designer', 'ativo'),
(17, 'Pag. Proj. Eletronic', 2, 'Pag. recebido de projetos eletrônicos', 'ativo'),
(18, 'Pag. Proj. Program', 1, 'Pag. recebido de projetos de programação ou designer', 'ativo'),
(19, 'Pag. Proj. Eletronic', 1, 'Pag. recebido de projetos eletrônicos', 'ativo'),
(20, 'Pag. OS', 1, 'Pag. recebido de OS', 'ativo'),
(21, 'Pag Venda Comp', 1, 'Pag de venda de componentes', 'ativo'),
(22, 'Compra Componentes', 1, 'Compra Componentes, reposição ou estoque', 'ativo'),
(23, 'Retirada Capital', 1, 'Retiradas de capital', 'ativo'),
(24, 'Intrumentos e Equipo', 1, 'Compra equipamentos, instrumentos, ferramentas uso em serviço', 'ativo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `getar_contaclasf`
--
ALTER TABLE `getar_contaclasf`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `fk_codctcocl` (`codctco`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `getar_contaclasf`
--
ALTER TABLE `getar_contaclasf`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `getar_contaclasf`
--
ALTER TABLE `getar_contaclasf`
  ADD CONSTRAINT `fk_codctcocl` FOREIGN KEY (`codctco`) REFERENCES `getar_contanome` (`cod`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
