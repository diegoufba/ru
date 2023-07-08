-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 08, 2023 at 05:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ru`
--

-- --------------------------------------------------------

--
-- Table structure for table `Bolsista`
--

CREATE TABLE `Bolsista` (
  `cpf` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Bolsista`
--

INSERT INTO `Bolsista` (`cpf`) VALUES
(777),
(22720920045);

-- --------------------------------------------------------

--
-- Table structure for table `Cargo`
--

CREATE TABLE `Cargo` (
  `cpf` bigint(20) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `turno` varchar(20) NOT NULL,
  `funcao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Cargo`
--

INSERT INTO `Cargo` (`cpf`, `salario`, `turno`, `funcao`) VALUES
(4543, 435.00, 'vespertino', 'Chef de cozinha'),
(43543, 54.00, 'vespertino', 'Chef de cozinha'),
(345343, 3423.00, 'vespertino', 'Nutricionista'),
(45456457654, 324.00, 'vespertino', 'Nutricionista'),
(234544534543, 324.00, 'vespertino', 'Caixa'),
(456794565576, 200.00, 'matutino', 'Auxiliar de limpeza');

-- --------------------------------------------------------

--
-- Table structure for table `Composicao`
--

CREATE TABLE `Composicao` (
  `id_prato` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Composicao`
--

INSERT INTO `Composicao` (`id_prato`, `id_ingrediente`) VALUES
(1, 4),
(1, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Conta`
--

CREATE TABLE `Conta` (
  `id` int(11) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `cpf_pagante` bigint(20) DEFAULT NULL,
  `cpf_docente` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Conta`
--

INSERT INTO `Conta` (`id`, `saldo`, `cpf_pagante`, `cpf_docente`) VALUES
(1, 5070.00, NULL, 3456789012),
(2, 1942.50, 35457805034, NULL),
(3, 1405.00, 50514392096, NULL),
(4, 400.00, NULL, 2345678901),
(5, 7687.44, NULL, 1234567890),
(6, 438.50, 1111, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Docente`
--

CREATE TABLE `Docente` (
  `cpf` bigint(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `colegiado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Docente`
--

INSERT INTO `Docente` (`cpf`, `nome`, `colegiado`) VALUES
(1234567890, 'John Doe', 'Matemática'),
(2345678901, 'Jane Smith', 'Educação'),
(3456789012, 'David Johnson', 'Ciências Sociais');

-- --------------------------------------------------------

--
-- Table structure for table `Estoque`
--

CREATE TABLE `Estoque` (
  `id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Estoque`
--

INSERT INTO `Estoque` (`id`, `quantidade`) VALUES
(1, 50),
(2, 75),
(3, 100);

-- --------------------------------------------------------

--
-- Table structure for table `Estudante`
--

CREATE TABLE `Estudante` (
  `cpf` bigint(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `matricula` int(11) NOT NULL,
  `curso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Estudante`
--

INSERT INTO `Estudante` (`cpf`, `nome`, `matricula`, `curso`) VALUES
(777, 'jOSE', 234, 'Engenharia'),
(1111, 'jose', 33, 'Ciências Sociais'),
(22720920045, 'David Johnson', 20210003, 'Computação'),
(35457805034, 'Jane Smith', 20210002, 'Administração'),
(50514392096, 'John Doe', 20210001, 'Matemática');

-- --------------------------------------------------------

--
-- Table structure for table `Funcionario`
--

CREATE TABLE `Funcionario` (
  `cpf` bigint(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `campus_ru` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Funcionario`
--

INSERT INTO `Funcionario` (`cpf`, `nome`, `campus_ru`) VALUES
(4543, 'gf', 'Vitória'),
(43543, 'sdfsd', 'Ondina'),
(345343, 'aaaa', 'São Lazaro'),
(45456457654, 'aaDFDSFD', 'Ondina'),
(234544534543, 'e', 'São Lazaro'),
(456794565576, 'f', 'Ondina');

-- --------------------------------------------------------

--
-- Table structure for table `Ingrediente`
--

CREATE TABLE `Ingrediente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Ingrediente`
--

INSERT INTO `Ingrediente` (`id`, `nome`) VALUES
(1, 'Batata'),
(2, 'Cebola'),
(3, 'feijao'),
(4, 'arroz');

-- --------------------------------------------------------

--
-- Table structure for table `Movimentacao`
--

CREATE TABLE `Movimentacao` (
  `id` int(11) NOT NULL,
  `id_conta` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `tipo` enum('recarga','refeicao') NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Movimentacao`
--

INSERT INTO `Movimentacao` (`id`, `id_conta`, `valor`, `tipo`, `data`) VALUES
(2, 2, 50.00, 'recarga', '0000-00-00 00:00:00'),
(3, 3, 50.00, 'recarga', '0000-00-00 00:00:00'),
(4, 4, 50.00, 'recarga', '0000-00-00 00:00:00'),
(191, 3, -2.50, 'refeicao', '2023-07-07 18:41:13'),
(192, 3, 10.00, 'recarga', '2023-07-07 18:41:19'),
(193, 6, -2.50, 'refeicao', '2023-07-07 18:44:25'),
(194, 6, -2.50, 'refeicao', '2023-07-07 18:44:28'),
(195, 6, -2.50, 'refeicao', '2023-07-07 18:44:30'),
(196, 3, -2.50, 'refeicao', '2023-07-07 19:36:59'),
(197, 3, -2.50, 'refeicao', '2023-07-07 19:37:01'),
(198, 3, -2.50, 'refeicao', '2023-07-07 19:37:03'),
(199, 3, -2.50, 'refeicao', '2023-07-07 19:38:02'),
(200, 3, 5.00, 'recarga', '2023-07-07 19:38:06'),
(201, 2, 5.00, 'recarga', '2023-07-07 19:42:14'),
(202, 2, 10.00, 'recarga', '2023-07-07 19:42:15'),
(203, 2, -2.50, 'refeicao', '2023-07-07 19:42:18'),
(204, 3, 5.00, 'recarga', '2023-07-07 19:56:42'),
(205, 3, 5.00, 'recarga', '2023-07-07 19:56:44'),
(206, 3, -2.50, 'refeicao', '2023-07-07 19:56:47'),
(207, 3, -2.50, 'refeicao', '2023-07-07 19:56:50'),
(208, 2, -2.50, 'refeicao', '2023-07-07 20:05:07'),
(209, 2, 50.00, 'recarga', '2023-07-07 20:05:09'),
(211, 5, -14.39, 'refeicao', '2023-07-07 20:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `Pagante`
--

CREATE TABLE `Pagante` (
  `cpf` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Pagante`
--

INSERT INTO `Pagante` (`cpf`) VALUES
(1111),
(35457805034),
(50514392096);

-- --------------------------------------------------------

--
-- Table structure for table `Prato`
--

CREATE TABLE `Prato` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `valor_nutricional` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Prato`
--

INSERT INTO `Prato` (`id`, `nome`, `valor_nutricional`) VALUES
(1, 'Opção 1', 200),
(2, 'Opção 2', 300);

-- --------------------------------------------------------

--
-- Table structure for table `Refeicao`
--

CREATE TABLE `Refeicao` (
  `id` int(11) NOT NULL,
  `cpf_pagante` bigint(20) DEFAULT NULL,
  `cpf_bolsista` bigint(20) DEFAULT NULL,
  `cpf_docente` bigint(20) DEFAULT NULL,
  `data` datetime NOT NULL,
  `id_prato` int(11) DEFAULT NULL,
  `campus_ru` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Refeicao`
--

INSERT INTO `Refeicao` (`id`, `cpf_pagante`, `cpf_bolsista`, `cpf_docente`, `data`, `id_prato`, `campus_ru`) VALUES
(34, 35457805034, NULL, NULL, '2023-07-06 12:49:18', 1, 'São Lázaro'),
(35, NULL, 22720920045, NULL, '2023-07-06 12:49:35', 1, 'Ondina'),
(36, NULL, NULL, 1234567890, '2023-07-06 12:50:58', 1, 'Ondina'),
(37, 35457805034, NULL, NULL, '2023-07-06 13:02:30', 1, 'Vitória'),
(38, NULL, NULL, 1234567890, '2023-07-06 13:02:51', 1, 'Vitória'),
(39, NULL, NULL, 1234567890, '2023-07-06 13:02:54', 1, 'Vitória'),
(40, 35457805034, NULL, NULL, '2023-07-06 13:10:58', 2, 'São Lázaro'),
(41, 35457805034, NULL, NULL, '2023-07-06 13:14:10', 2, 'São Lázaro'),
(42, 35457805034, NULL, NULL, '2023-07-06 13:15:13', 2, 'São Lázaro'),
(43, 1111, NULL, NULL, '2023-07-06 13:49:17', 1, 'São Lázaro'),
(57, 50514392096, NULL, NULL, '2023-07-07 18:41:10', 2, 'São Lázaro'),
(58, 50514392096, NULL, NULL, '2023-07-07 18:41:13', 2, 'São Lázaro'),
(59, 1111, NULL, NULL, '2023-07-07 18:44:25', 1, 'São Lázaro'),
(60, 1111, NULL, NULL, '2023-07-07 18:44:28', 1, 'Vitória'),
(61, 1111, NULL, NULL, '2023-07-07 18:44:30', 1, 'Ondina'),
(62, 50514392096, NULL, NULL, '2023-07-07 19:36:59', 1, 'São Lázaro'),
(63, 50514392096, NULL, NULL, '2023-07-07 19:37:01', 1, 'São Lázaro'),
(64, 50514392096, NULL, NULL, '2023-07-07 19:37:03', 1, 'São Lázaro'),
(65, 50514392096, NULL, NULL, '2023-07-07 19:38:02', 1, 'São Lázaro'),
(66, NULL, 777, NULL, '2023-07-07 19:39:25', 1, 'São Lázaro'),
(67, 35457805034, NULL, NULL, '2023-07-07 19:42:18', 1, 'São Lázaro'),
(68, NULL, 777, NULL, '2023-07-07 19:42:41', 1, 'São Lázaro'),
(69, NULL, 777, NULL, '2023-07-07 19:42:51', 2, 'São Lázaro'),
(70, NULL, 777, NULL, '2023-07-07 19:42:57', 2, 'São Lázaro'),
(71, NULL, 777, NULL, '2023-07-07 19:45:41', 2, 'São Lázaro'),
(72, 50514392096, NULL, NULL, '2023-07-07 19:56:47', 1, 'São Lázaro'),
(73, 50514392096, NULL, NULL, '2023-07-07 19:56:50', 1, 'São Lázaro'),
(74, NULL, 777, NULL, '2023-07-07 20:01:48', 1, 'Vitória'),
(75, 35457805034, NULL, NULL, '2023-07-07 20:05:07', 1, 'São Lázaro'),
(76, NULL, NULL, 1234567890, '2023-07-07 20:34:54', 2, 'Vitória'),
(77, NULL, 777, NULL, '2023-07-07 20:37:10', 2, 'São Lázaro');

-- --------------------------------------------------------

--
-- Table structure for table `RU`
--

CREATE TABLE `RU` (
  `campus` varchar(50) NOT NULL,
  `nome_empresa` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `capacidade` int(11) NOT NULL,
  `id_estoque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `RU`
--

INSERT INTO `RU` (`campus`, `nome_empresa`, `status`, `capacidade`, `id_estoque`) VALUES
('Ondina', 'Meiodia Refeições Industriais', 1, 1000, 1),
('São Lázaro', 'Sodexo', 1, 1500, 2),
('Vitória', 'GRSA', 1, 4000, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Bolsista`
--
ALTER TABLE `Bolsista`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `Cargo`
--
ALTER TABLE `Cargo`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `Composicao`
--
ALTER TABLE `Composicao`
  ADD KEY `id_prato` (`id_prato`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- Indexes for table `Conta`
--
ALTER TABLE `Conta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_conta_pagante` (`cpf_pagante`),
  ADD KEY `fk_conta_docente` (`cpf_docente`);

--
-- Indexes for table `Docente`
--
ALTER TABLE `Docente`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `Estoque`
--
ALTER TABLE `Estoque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Estudante`
--
ALTER TABLE `Estudante`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `Funcionario`
--
ALTER TABLE `Funcionario`
  ADD PRIMARY KEY (`cpf`),
  ADD KEY `campus_ru` (`campus_ru`);

--
-- Indexes for table `Ingrediente`
--
ALTER TABLE `Ingrediente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Movimentacao`
--
ALTER TABLE `Movimentacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimentacao_ibfk_3` (`id_conta`);

--
-- Indexes for table `Pagante`
--
ALTER TABLE `Pagante`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `Prato`
--
ALTER TABLE `Prato`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Refeicao`
--
ALTER TABLE `Refeicao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cpf_pagante` (`cpf_pagante`),
  ADD KEY `cpf_docente` (`cpf_docente`),
  ADD KEY `cpf_bolsista` (`cpf_bolsista`),
  ADD KEY `fk_id_prato` (`id_prato`),
  ADD KEY `fk_campus_ru` (`campus_ru`);

--
-- Indexes for table `RU`
--
ALTER TABLE `RU`
  ADD PRIMARY KEY (`campus`),
  ADD KEY `id_estoque` (`id_estoque`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Conta`
--
ALTER TABLE `Conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Ingrediente`
--
ALTER TABLE `Ingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Movimentacao`
--
ALTER TABLE `Movimentacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `Prato`
--
ALTER TABLE `Prato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Refeicao`
--
ALTER TABLE `Refeicao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Bolsista`
--
ALTER TABLE `Bolsista`
  ADD CONSTRAINT `bolsista_ibfk_1` FOREIGN KEY (`cpf`) REFERENCES `Estudante` (`cpf`);

--
-- Constraints for table `Cargo`
--
ALTER TABLE `Cargo`
  ADD CONSTRAINT `cargo_ibfk_1` FOREIGN KEY (`cpf`) REFERENCES `Funcionario` (`cpf`);

--
-- Constraints for table `Composicao`
--
ALTER TABLE `Composicao`
  ADD CONSTRAINT `composicao_ibfk_1` FOREIGN KEY (`id_prato`) REFERENCES `Prato` (`id`),
  ADD CONSTRAINT `composicao_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `Ingrediente` (`id`);

--
-- Constraints for table `Conta`
--
ALTER TABLE `Conta`
  ADD CONSTRAINT `fk_conta_docente` FOREIGN KEY (`cpf_docente`) REFERENCES `Docente` (`cpf`),
  ADD CONSTRAINT `fk_conta_pagante` FOREIGN KEY (`cpf_pagante`) REFERENCES `Pagante` (`cpf`);

--
-- Constraints for table `Funcionario`
--
ALTER TABLE `Funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`campus_ru`) REFERENCES `RU` (`campus`);

--
-- Constraints for table `Movimentacao`
--
ALTER TABLE `Movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_3` FOREIGN KEY (`id_conta`) REFERENCES `Conta` (`id`);

--
-- Constraints for table `Pagante`
--
ALTER TABLE `Pagante`
  ADD CONSTRAINT `pagante_ibfk_1` FOREIGN KEY (`cpf`) REFERENCES `Estudante` (`cpf`);

--
-- Constraints for table `Refeicao`
--
ALTER TABLE `Refeicao`
  ADD CONSTRAINT `fk_campus_ru` FOREIGN KEY (`campus_ru`) REFERENCES `RU` (`campus`),
  ADD CONSTRAINT `fk_id_prato` FOREIGN KEY (`id_prato`) REFERENCES `Prato` (`id`),
  ADD CONSTRAINT `refeicao_ibfk_1` FOREIGN KEY (`cpf_pagante`) REFERENCES `Pagante` (`cpf`),
  ADD CONSTRAINT `refeicao_ibfk_2` FOREIGN KEY (`cpf_docente`) REFERENCES `Docente` (`cpf`),
  ADD CONSTRAINT `refeicao_ibfk_3` FOREIGN KEY (`cpf_bolsista`) REFERENCES `Bolsista` (`cpf`);

--
-- Constraints for table `RU`
--
ALTER TABLE `RU`
  ADD CONSTRAINT `ru_ibfk_1` FOREIGN KEY (`id_estoque`) REFERENCES `Estoque` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
