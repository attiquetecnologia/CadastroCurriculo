-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Jul-2016 às 21:02
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `casab805_crmpessoal`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(120) NOT NULL,
  `cep` varchar(16) NOT NULL,
  `bairro` varchar(120) NOT NULL,
  `cidade` varchar(120) NOT NULL,
  `uf` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cep` (`cep`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `logradouro`, `cep`, `bairro`, `cidade`, `uf`) VALUES
(1, 'Rua C-19', '14781-463', 'Cristiano de Carvalho', 'Barretos', 'SP'),
(2, 'Rua 10', '14780-028', 'Centro', 'Barretos', 'SP');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `papel` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `papel` (`papel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`id`, `papel`, `descricao`) VALUES
(1, 'root', 'administradores'),
(2, 'usuario', 'usuarios comuns do sistema');

-- --------------------------------------------------------

--
-- Estrutura da tabela `membros`
--

CREATE TABLE IF NOT EXISTS `membros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grupo_id_2` (`grupo_id`,`usuario_id`),
  KEY `grupo_id` (`grupo_id`,`usuario_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `membros`
--

INSERT INTO `membros` (`id`, `grupo_id`, `usuario_id`) VALUES
(1, 1, 1),
(5, 2, 1),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE IF NOT EXISTS `permissao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tabela_objeto` varchar(120) NOT NULL COMMENT 'tela, tabela, classe...',
  PRIMARY KEY (`id`),
  UNIQUE KEY `grupo_id_2` (`grupo_id`,`nome`,`tabela_objeto`),
  KEY `grupo_id` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) DEFAULT NULL,
  `contato` varchar(500) DEFAULT NULL,
  `endereco_id` bigint(11) DEFAULT NULL,
  `numero_endereco` varchar(10) DEFAULT NULL,
  `img_url` text,
  PRIMARY KEY (`id`),
  KEY `endereco_id` (`endereco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `pessoas`
--

INSERT INTO `pessoas` (`id`, `nome`, `sobrenome`, `contato`, `endereco_id`, `numero_endereco`, `img_url`) VALUES
(1, 'Roberval', 'Grandâo', '[{"telefone":"(17)3322.4858"}]', 2, '15', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha`, `ativo`) VALUES
(1, 'root@crmpessoal.com.br', 'c21f969b5f03d33d43e04f8f136e7682', 1),
(2, 'default@crmpessoal.com.br', 'c21f969b5f03d33d43e04f8f136e7682', 1);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `membros`
--
ALTER TABLE `membros`
  ADD CONSTRAINT `membros_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `membros_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD CONSTRAINT `pessoas_ibfk_1` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
