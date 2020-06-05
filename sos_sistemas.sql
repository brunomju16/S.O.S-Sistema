-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Jun-2020 às 05:25
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sos_sistemas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `nomeCliente` varchar(20) NOT NULL,
  `telefoneCliente` varchar(15) NOT NULL,
  `enderecoCliente` varchar(25) NOT NULL,
  `emailCliente` varchar(40) NOT NULL,
  `cpfCliente` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nomeCliente`, `telefoneCliente`, `enderecoCliente`, `emailCliente`, `cpfCliente`) VALUES

(1, 'Bruno', '34543258', 'Av Mario Correa 1031', 'brunomju16@gmail.com', '034.720.041-93');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `idFuncionario` int(11) NOT NULL,
  `nomeFuncionario` varchar(25) NOT NULL,
  `cpfFuncionario` varchar(18) NOT NULL,
  `telefoneFuncionario` varchar(15) NOT NULL,
  `enderecoFuncionario` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`idFuncionario`, `nomeFuncionario`, `cpfFuncionario`, `telefoneFuncionario`, `enderecoFuncionario`) VALUES
(1, 'Bruno', '034.720.041-93', '34543258', 'Av Mario Correa 1031');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerente`
--

CREATE TABLE `gerente` (
  `idGerente` int(11) NOT NULL,
  `nomeGerente` varchar(25) NOT NULL,
  `enderecoGerente` varchar(35) NOT NULL,
  `cpfGerente` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `gerente`
--

INSERT INTO `gerente` (`idGerente`, `nomeGerente`, `enderecoGerente`, `cpfGerente`) VALUES
(1, 'Bruno Krugmann Araujo', 'Av mario correa 1031', '0344.720.041-93');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamentos`
--

CREATE TABLE `orcamentos` (
  `idCliente` int(11) NOT NULL,
  `idFuncionario` int(11) NOT NULL,
  `equipamento` varchar(25) NOT NULL,
  `defeito` varchar(255) DEFAULT NULL,
  `observacao` varchar(255) NOT NULL,
  `valor` double DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL,
  `dataOrc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `orcamentos`
--

INSERT INTO `orcamentos` (`idCliente`, `idFuncionario`, `equipamento`, `defeito`, `observacao`, `valor`, `status`, `dataOrc`) VALUES
(1, 1, 'Notebook Dell ', 'Carregador Queimou', 'Troca Do carregador', 100, 'Em aberto', '2019-08-22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `os`
--

CREATE TABLE `os` (
  `idCliente` int(11) NOT NULL,
  `idFuncionario` int(11) NOT NULL,
  `equipamento` varchar(25) NOT NULL,
  `defeito` varchar(100) NOT NULL,
  `observacao` varchar(100) NOT NULL,
  `status` varchar(15) DEFAULT NULL,
  `valor` decimal(10,0) NOT NULL,
  `dataOS` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `os`
--

INSERT INTO `os` (`idCliente`, `idFuncionario`, `equipamento`, `defeito`, `observacao`, `status`, `valor`, `dataOS`) VALUES
(1, 1, 'Iphone X', 'Tela quebrada', 'Trocar a Tela', 'Em aberto', '800', '2019-08-22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `idProduto` int(11) NOT NULL,
  `nomeProduto` varchar(20) NOT NULL,
  `preçoProduto` double NOT NULL,
  `refenciaProduto` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`idProduto`, `nomeProduto`, `preçoProduto`, `refenciaProduto`) VALUES
(1, 'Formatação s backup', 100, '12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUser` int(11) NOT NULL,
  `loginUser` varchar(20) NOT NULL,
  `senhaUser` varchar(20) NOT NULL,
  `cargoUser` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idUser`, `loginUser`, `senhaUser`, `cargoUser`) VALUES
(1, 'bruno', '123', 'Gerente');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
