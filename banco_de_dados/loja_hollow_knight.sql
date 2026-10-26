-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 26-Out-2026 às 19:01
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `loja_hollow_knight`
--
CREATE DATABASE IF NOT EXISTS `loja_hollow_knight` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `loja_hollow_knight`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id_carrinho` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `qnt_itens` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_carrinho`),
  UNIQUE KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id_carrinho`, `id_usuario`, `qnt_itens`, `total`) VALUES
(1, 2, 7, '628.00'),
(2, 3, 0, '0.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_carrinho`
--

CREATE TABLE IF NOT EXISTS `itens_carrinho` (
  `id_carrinho` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qnt_produto` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_carrinho`,`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `itens_carrinho`
--

INSERT INTO `itens_carrinho` (`id_carrinho`, `id_produto`, `qnt_produto`, `subtotal`) VALUES
(1, 3, 1, '200.00'),
(1, 7, 1, '120.00'),
(1, 9, 2, '140.00'),
(1, 10, 3, '168.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(32) NOT NULL,
  `nome_produto` varchar(96) NOT NULL,
  `descricao` varchar(256) NOT NULL,
  `preco_compra` decimal(10,2) NOT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `qnt_estoque` int(11) NOT NULL,
  `imagem` varchar(128) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `categoria`, `nome_produto`, `descricao`, `preco_compra`, `preco_venda`, `qnt_estoque`, `imagem`) VALUES
(1, 'Action Figures', 'Knight', 'Action Figure do protagonista do jogo, Knight', '139.99', '160.00', 801, '../imagens/af_knight.png'),
(2, 'Action Figures', 'Hornet', 'Action Figure da personagem Hornet, protagonista de SilkSong', '98.99', '140.00', 659, '../imagens/af_hornet.png'),
(3, 'Action Figures', 'Receptaculo Puro', 'Action Figure do personagem Receptaculo Puro, um dos chefes secretos mais fortes do jogo', '174.00', '200.00', 471, '../imagens/af_pure_vessel.png'),
(4, 'Action Figures', 'Zote', 'Action Figure do personagem Zote, um NPC irritante', '80.00', '100.00', 1206, '../imagens/af_zote.png'),
(5, 'Roupas', 'Camisa Hollow Knight', 'Camisa preta com arte contendo diversos personagens do jogo, alem da logo "Hollow Knight"', '79.99', '110.00', 812, '../imagens/roupa_camisa_hk1.png'),
(6, 'Roupas', 'Camisa Hollow Knight', 'Camisa preta de mangas longas com arte contendo alguns personagens do jogo', '72.99', '100.00', 765, '../imagens/roupa_camisa_hk2.png'),
(7, 'Roupas', 'Camisa Knight', 'Camisa preta com arte nas costas do personagem "Knight" com o seu ferrao sob os cascos de outros receptaculos', '99.99', '120.00', 788, '../imagens/roupa_camisa_knight1.png'),
(8, 'Roupas', 'Camisa Knight', 'Camisa cinza com uma simples imagem do personagem "Knight"', '45.69', '60.00', 1824, '../imagens/roupa_camisa_knight2.png'),
(9, 'Canecas', 'Caneca Knight e Hornet', 'Caneca branca com arte detalhada dos personagens "Knight" e "Hornet", com detalhes em cor laranja', '42.89', '70.00', 503, '../imagens/caneca_knight_hornet1.png'),
(10, 'Canecas', 'Caneca Knight', 'Caneca branca e preta com uma imagem fofa do Knight sentado segurando uma caneca', '49.99', '56.00', 923, '../imagens/caneca_knight1.png'),
(11, 'Canecas', 'Caneca Personagens', 'Caneca branca com arte de diversos personagens do jogo', '39.00', '50.00', 549, '../imagens/caneca_hk1.png'),
(12, 'Canecas', 'Caneca Arte Knight', 'Caneca branca com arte do personagem "Knight" descansando em um banco perto dos corpos de outros insetos enquanto sua sombra o observa, alem da logo "Hollow Knight" no topo', '50.00', '60.00', 371, '../imagens/caneca_hk2.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(24) NOT NULL,
  `email` varchar(128) NOT NULL,
  `senha` varchar(16) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `nome_usuario` (`nome_usuario`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `email`, `senha`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin123'),
(2, 'Visitante', 'visitante@gmail.com', '12345678'),
(3, 'Reginaldooo', 'reginaldodelas456@gmail.com', 'naldao67');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
