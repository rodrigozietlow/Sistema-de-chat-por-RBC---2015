-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 02-Ago-2015 às 03:17
-- Versão do servidor: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rbc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `casos`
--

CREATE TABLE IF NOT EXISTS `casos` (
  `nivel3` varchar(100) DEFAULT NULL,
  `nivel2` varchar(100) DEFAULT NULL,
  `nivel1` varchar(100) NOT NULL,
  `proxima` varchar(100) NOT NULL,
`id` int(11) NOT NULL,
  `peso` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conversa`
--

CREATE TABLE IF NOT EXISTS `conversa` (
`id` int(11) NOT NULL,
  `idEnviador` int(11) NOT NULL,
  `idReceptor` int(11) NOT NULL,
  `mensagem` varchar(2000) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `conversa`
--

INSERT INTO `conversa` (`id`, `idEnviador`, `idReceptor`, `mensagem`, `data`) VALUES
(1, 1, 2, 'Olá!', '2015-08-01 21:17:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `login` varchar(50) NOT NULL,
  `senha` varchar(32) NOT NULL,
`id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`login`, `senha`, `id`, `nome`) VALUES
('rodrigo', '3953526f726b29fae75e5fb9f411c26e', 1, 'Rodrigo'),
('igor', '3953526f726b29fae75e5fb9f411c26e', 2, 'Igor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `casos`
--
ALTER TABLE `casos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversa`
--
ALTER TABLE `conversa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `casos`
--
ALTER TABLE `casos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conversa`
--
ALTER TABLE `conversa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
