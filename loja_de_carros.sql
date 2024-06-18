-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 17/06/2024 às 23:26
-- Versão do servidor: 5.7.23-23
-- Versão do PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_de_carros`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id`, `nome`, `email`, `senha`) VALUES
(2, 'SegundoUsuario', 'email@gmail.com', 'senha@123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `data_de_nascimento` date NOT NULL,
  `cidade` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` int(5) NOT NULL,
  `complemento` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `cpf`, `data_de_nascimento`, `cidade`, `estado`, `rua`, `endereco`, `complemento`) VALUES
(8, 'Jõao', 'joao@gmail.com', '690.444.702-80', '1998-10-08', 'Curitiba', 'PR', 'Rua das pipas', 12, 'Sobrado'),
(9, 'Maria', 'maria@gmail.com', '374.608.813-50', '1990-02-20', 'Matinhos', 'PR', 'R. do Mar', 219, 'Casa b'),
(10, 'Gustavo', 'gustavo@gmail.com', '511.849.597-06', '2004-09-01', 'Florianópolis', 'SC', 'R. 7 de Janeiro', 44, 'Ap 802'),
(11, 'Bruna', 'bruna@gmail.com', '671.888.211-94', '1991-07-11', 'Curitiba', 'PR', 'Rua das pipas', 893, 'Casa rosa grafitada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `marcas`
--

INSERT INTO `marcas` (`id`, `marca`) VALUES
(19, 'Volkswagen'),
(20, 'Renault'),
(21, 'Honda');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `modelo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `ano` int(4) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `preco` decimal(10,0) NOT NULL,
  `imagem` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'sem-imagem.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `modelos`
--

INSERT INTO `modelos` (`id`, `modelo`, `ano`, `id_marca`, `preco`, `imagem`) VALUES
(7, 'Gol', 2018, 19, 49000, 'img_65fbed0a67eff.jpg'),
(8, 'Expression', 2019, 20, 45990, 'img_65fbeddcec044.jpg'),
(9, 'Privilege', 2008, 20, 26900, 'img_65fbee070aa91.jpg'),
(10, 'New Civic', 2008, 21, 36, 'img_65fc2ce498f46.webp');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `data_venda` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id`, `id_cliente`, `id_vendedor`, `id_modelo`, `data_venda`) VALUES
(7, 9, 5, 8, '2024-03-18'),
(8, 8, 4, 7, '2024-01-24'),
(9, 11, 4, 7, '2024-03-20'),
(10, 10, 4, 9, '2024-03-13'),
(11, 10, 6, 8, '2024-02-11'),
(12, 10, 7, 10, '2024-03-21'),
(13, 8, 6, 10, '2024-03-22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(260) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `vendedores`
--

INSERT INTO `vendedores` (`id`, `nome`, `email`) VALUES
(4, 'Tubarão', 'tubarao@gmail.com'),
(5, 'Cachorro', 'cachorro@gmail.com'),
(6, 'Sapo', 'sapo@gmail.com'),
(7, 'liberti', 'liberti@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
