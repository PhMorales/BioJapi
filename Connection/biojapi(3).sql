-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/06/2025 às 00:14
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biojapi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin`
--

CREATE TABLE `admin` (
  `nome_usuario` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `post_id` varchar(30) DEFAULT NULL,
  `nome_usuario` varchar(25) DEFAULT NULL,
  `id_comentario` varchar(70) DEFAULT NULL,
  `comentario` varchar(255) NOT NULL,
  `data_comentario` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`post_id`, `nome_usuario`, `id_comentario`, `comentario`, `data_comentario`) VALUES
('68499b0abce1f0.23916067', '@combo', '68499b0abce1f0.23916067684c34929c8de6.29080875', 'comentário', '2025-06-13 11:24:18'),
('68499b0abce1f0.23916067', '@combo', '68499b0abce1f0.23916067684c34a3644c52.65123454', 'comentario 2', '2025-06-13 11:24:35'),
('68499ed7ea10d7.15243490', '@combo', '68499ed7ea10d7.15243490684dcfe141c2e2.65947900', 'comentario', '2025-06-14 16:39:13'),
('68499b0abce1f0.23916067', '@Biojapi', '68499b0abce1f0.23916067684e0270d15524.59967573', 'comentário novo', '2025-06-14 20:14:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `especialistas`
--

CREATE TABLE `especialistas` (
  `nome_usuario` varchar(25) DEFAULT NULL,
  `lattes` varchar(30) NOT NULL,
  `area` varchar(15) DEFAULT NULL,
  `especializacao` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `especies`
--

CREATE TABLE `especies` (
  `nome_cientifico` varchar(50) NOT NULL,
  `nome_popular` varchar(50) DEFAULT NULL,
  `classificacao` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `especies`
--

INSERT INTO `especies` (`nome_cientifico`, `nome_popular`, `classificacao`) VALUES
('Bothrops Jararaca', 'Jararaca', 'Réptil'),
('Cariama Cristata', 'Siriema', 'Ave'),
('Cuniculus Paca', 'Paca', 'Mamífero'),
('Dorcacerus Barbatus', 'Besouro Serra-Pau', 'Inseto'),
('Leptodactylus Labyrinthicus', 'Rã-Pimenta', 'Anfíbio'),
('Não Identificado - Anfíbio', NULL, 'Anfíbio'),
('Não Identificado - Arbusto', NULL, 'Arbusto'),
('Não Identificado - Árvore', NULL, 'Árvore'),
('Não Identificado - Ave', NULL, 'Ave'),
('Não Identificado - Cogumelo', NULL, 'Cogumelo'),
('Não Identificado - Inseto', NULL, 'Inseto'),
('Não Identificado - Mamifero', NULL, 'Mamífero'),
('Não Identificado - Outros', NULL, 'Outros'),
('Não Identificado - Peixe', NULL, 'Peixe'),
('Não Identificado - Rasteira', NULL, 'Rasteira'),
('Não Identificado - Réptil', NULL, 'Réptil'),
('Tilapia Rendali', 'Tilápia', 'Peixe');

-- --------------------------------------------------------

--
-- Estrutura para tabela `likes`
--

CREATE TABLE `likes` (
  `nome_usuario` varchar(25) DEFAULT NULL,
  `post_id` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `likes`
--

INSERT INTO `likes` (`nome_usuario`, `post_id`) VALUES
('@Biojapi', '68499b0abce1f0.23916067');

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `post_id` varchar(30) NOT NULL,
  `nome_usuario` varchar(25) DEFAULT NULL,
  `imagem_nome` text NOT NULL,
  `nome_cientifico` varchar(50) DEFAULT 'N.I.',
  `sensivel` tinyint(1) DEFAULT NULL,
  `acidente` tinyint(1) DEFAULT NULL,
  `legenda` varchar(255) DEFAULT NULL,
  `data_upload` datetime DEFAULT current_timestamp(),
  `data_imagem` date NOT NULL,
  `localizacao` varchar(40) DEFAULT NULL,
  `validado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`post_id`, `nome_usuario`, `imagem_nome`, `nome_cientifico`, `sensivel`, `acidente`, `legenda`, `data_upload`, `data_imagem`, `localizacao`, `validado`) VALUES
('6841d6cd324313.65067976', '@combo', 'Paca_at_Brazil@combo05062025194133.jpg', 'Cuniculus Paca', 0, 0, 'paca', '2025-06-05 14:41:33', '0000-00-00', '-23.201944 -46.907158', NULL),
('68499b0abce1f0.23916067', '@combo', 'seriema2@combo11062025170442.jpg', 'Cariama Cristata', 0, 0, 'priquito', '2025-06-11 12:04:42', '2025-05-16', '-23.254945 -46.989735', NULL),
('68499ed7ea10d7.15243490', '@combo', 'sapo pimenta@combo11062025172055.jpg', 'Leptodactylus Labyrinthicus', 0, 0, 'AAAAAAAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAAAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAAAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA\r\nAAAAAA', '2025-06-11 12:20:55', '2023-02-11', '-23.232243 -46.955416', NULL),
('6849db4ae8b643.48683426', '@combo', 'Captura de tela 2024-12-19 172635@combo11062025213850.png', 'Não Identificado - Mamífero', 1, 0, 'Mamífero secreto', '2025-06-11 16:38:50', '1111-11-11', '-23.263385 -47.053070', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao_especialista`
--

CREATE TABLE `solicitacao_especialista` (
  `nome_usuario` varchar(25) DEFAULT NULL,
  `id_lattes` varchar(30) NOT NULL,
  `area_atuacao` varchar(20) DEFAULT NULL,
  `descricao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `nome` varchar(50) DEFAULT NULL,
  `nome_usuario` varchar(25) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` text DEFAULT NULL,
  `bio_usuario` varchar(255) DEFAULT NULL,
  `foto_usuario` varchar(100) DEFAULT 'default.png',
  `cidade` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`nome`, `nome_usuario`, `email`, `senha`, `bio_usuario`, `foto_usuario`, `cidade`, `estado`) VALUES
('BioJapi Oficial', '@Biojapi', 'teste@biojapi.com', 'KmxPhxjRUpa1iC8Cf0H/Ak9mYnluVkVscVI0ZE1ieHAxV3RtU1E9PQ==', 'Somos a biojapi oficial!', 'bioJapi4@Biojapi13062025210035.png', 'Jundiaí', 'SP'),
('Pedro H. R. Morales', '@combo', 'pmctrlplay@gmail.com', 'dcaLrIgv+GKq5mEhQ2Mn3W1CZjQ3VGZ4bFpWNzFhb0tobmRaTWc9PQ==', '- Usuário #1 desse projeto aqui 🏆\r\n- O único que o criador lembra a senha 🧠\r\n- Bom em fotografar animais misteriosos ❓\r\n- Não sei mais o que por nessa bio de exemplo', 'Captura de tela 2025-06-08 135430@combo12062025214345.png', 'Jundiaí', 'SP'),
('linguado', '@linguad0', 'linguado@email.com', 'dcaLrIgv+GKq5mEhQ2Mn3W1CZjQ3VGZ4bFpWNzFhb0tobmRaTWc9PQ==', NULL, 'default.png', '', ''),
('teste email', '@nomefoda', 'teste@email.com', 'dcaLrIgv+GKq5mEhQ2Mn3W1CZjQ3VGZ4bFpWNzFhb0tobmRaTWc9PQ==', NULL, 'default.png', 'Jundiaí', 'SP'),
('Peixe Mafioso', '@peixeMafia01', 'peixe@mafia.com', 'dcaLrIgv+GKq5mEhQ2Mn3W1CZjQ3VGZ4bFpWNzFhb0tobmRaTWc9PQ==', NULL, 'default.png', '', ''),
('peixe tortelini', '@tortelini', 'tortelini@peixe.com', 'dcaLrIgv+GKq5mEhQ2Mn3W1CZjQ3VGZ4bFpWNzFhb0tobmRaTWc9PQ==', NULL, 'default.png', '', ''),
('Usuário01', '@user01', 'user@0.1', 'dcaLrIgv+GKq5mEhQ2Mn3W1CZjQ3VGZ4bFpWNzFhb0tobmRaTWc9PQ==', NULL, 'default.png', '', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admin`
--
ALTER TABLE `admin`
  ADD KEY `nome_usuario` (`nome_usuario`);

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD KEY `nome_usuario` (`nome_usuario`),
  ADD KEY `post_id` (`post_id`);

--
-- Índices de tabela `especialistas`
--
ALTER TABLE `especialistas`
  ADD PRIMARY KEY (`lattes`),
  ADD KEY `nome_usuario` (`nome_usuario`);

--
-- Índices de tabela `especies`
--
ALTER TABLE `especies`
  ADD PRIMARY KEY (`nome_cientifico`);

--
-- Índices de tabela `likes`
--
ALTER TABLE `likes`
  ADD KEY `nome_usuario` (`nome_usuario`),
  ADD KEY `post_id` (`post_id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `nome_usuario` (`nome_usuario`),
  ADD KEY `especie` (`nome_cientifico`);

--
-- Índices de tabela `solicitacao_especialista`
--
ALTER TABLE `solicitacao_especialista`
  ADD PRIMARY KEY (`id_lattes`),
  ADD KEY `solicitacao_especialista_ibfk_1` (`nome_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nome_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`nome_usuario`) REFERENCES `usuarios` (`nome_usuario`);

--
-- Restrições para tabelas `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`nome_usuario`) REFERENCES `usuarios` (`nome_usuario`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Restrições para tabelas `especialistas`
--
ALTER TABLE `especialistas`
  ADD CONSTRAINT `especialistas_ibfk_1` FOREIGN KEY (`nome_usuario`) REFERENCES `usuarios` (`nome_usuario`);

--
-- Restrições para tabelas `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`nome_usuario`) REFERENCES `usuarios` (`nome_usuario`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`nome_usuario`) REFERENCES `usuarios` (`nome_usuario`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`nome_cientifico`) REFERENCES `especies` (`nome_cientifico`);

--
-- Restrições para tabelas `solicitacao_especialista`
--
ALTER TABLE `solicitacao_especialista`
  ADD CONSTRAINT `solicitacao_especialista_ibfk_1` FOREIGN KEY (`nome_usuario`) REFERENCES `usuarios` (`nome_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
