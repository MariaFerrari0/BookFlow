-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/07/2026 às 08:46
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bookflow`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL,
  `nota_geral` decimal(3,1) NOT NULL,
  `nota_historia` int(11) DEFAULT 0,
  `nota_personagens` int(11) DEFAULT 0,
  `nota_final_livro` int(11) DEFAULT 0,
  `nota_escrita` int(11) DEFAULT 0,
  `opiniao_geral` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL,
  `pagina` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `diario_leitura`
--

CREATE TABLE `diario_leitura` (
  `id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL,
  `data_registro` date NOT NULL,
  `paginas_lidas` int(11) NOT NULL,
  `pagina_atual` int(11) NOT NULL,
  `anotacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `diario_leitura`
--

INSERT INTO `diario_leitura` (`id`, `livro_id`, `data_registro`, `paginas_lidas`, `pagina_atual`, `anotacao`) VALUES
(1, 5, '2026-07-14', 0, 0, 'adorei a pagina 10'),
(2, 5, '2026-07-14', 0, 0, 'estou odiando a personagem principal, ela me da nos nervos'),
(3, 6, '2026-07-15', 0, 0, 'gffghhgfg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `editora` varchar(150) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `paginas` int(11) NOT NULL,
  `ano_publicacao` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `capa_url` varchar(255) DEFAULT NULL,
  `status` enum('Quero comprar','Quero ler','Lendo','Finalizado','Abandonado') NOT NULL DEFAULT 'Quero ler',
  `favorito` tinyint(1) DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `paginas_lidas` int(11) DEFAULT 0,
  `comentarios` text DEFAULT NULL,
  `capa` varchar(255) DEFAULT NULL,
  `nota` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `usuario_id`, `titulo`, `autor`, `editora`, `genero`, `paginas`, `ano_publicacao`, `isbn`, `capa_url`, `status`, `favorito`, `criado_em`, `paginas_lidas`, `comentarios`, `capa`, `nota`) VALUES
(5, 12, 'test', 'asddf', NULL, NULL, 599, NULL, NULL, NULL, 'Finalizado', 0, '2026-07-14 13:10:40', 60, 'gostei muitooo da 15', NULL, 0),
(6, 12, 'eeee', 'dff', NULL, NULL, 600, NULL, NULL, NULL, 'Quero ler', 0, '2026-07-15 00:20:12', 400, NULL, NULL, 0),
(8, 11, 'A vida invisivel de addy larue', 'V. E. SCHWAB', NULL, NULL, 500, NULL, NULL, NULL, 'Lendo', 0, '2026-07-15 06:26:32', 56, NULL, NULL, 0),
(9, 11, 'Jogo de Amor Para Dois', 'Ali Hazelwood', NULL, NULL, 167, NULL, NULL, NULL, 'Quero ler', 0, '2026-07-15 06:28:37', 0, NULL, NULL, 0),
(10, 11, 'O Acordo', 'Elle kennedy', NULL, NULL, 356, NULL, NULL, NULL, 'Quero ler', 0, '2026-07-15 06:29:54', 0, NULL, NULL, 0),
(11, 11, 'No Fundo é Amor', 'Ali Hazelwood', NULL, NULL, 500, NULL, NULL, NULL, 'Quero ler', 0, '2026-07-15 06:30:49', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `metas`
--

CREATE TABLE `metas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `meta_livros` int(11) DEFAULT 0,
  `meta_paginas` int(11) DEFAULT 0,
  `meta_tempo_minutos` int(11) DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessoes_pomodoro`
--

CREATE TABLE `sessoes_pomodoro` (
  `id` int(11) NOT NULL,
  `livro_id` int(11) NOT NULL,
  `duracao_minutos` int(11) NOT NULL,
  `data_sessao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(1, 'teste', 'teste@email.com', '$2y$10$yI28B8/U01hSreK9D02mFOHfCms.2U3bI9ZbeV3N1mN58Cg1q.f.a', '2026-07-14 10:26:33'),
(11, 'teste te', 'teste@gmail.com', '$2y$10$5fJXw5FpDKas1JFTU8NxnO8ons08wTVEQ9Ca2PHaq6b.8BWG86SYa', '2026-07-14 10:49:10'),
(12, 'maria Ferrari', 'maria@gmail.com', '$2y$10$EbeoTnTPzZsTSgOsTxPkBOmZiOGGMiXifm2xJpaE6mRcAz0o62G9G', '2026-07-14 12:45:31');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `livro_id` (`livro_id`);

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livro_id` (`livro_id`);

--
-- Índices de tabela `diario_leitura`
--
ALTER TABLE `diario_leitura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livro_id` (`livro_id`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario_ano` (`usuario_id`,`ano`);

--
-- Índices de tabela `sessoes_pomodoro`
--
ALTER TABLE `sessoes_pomodoro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livro_id` (`livro_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `diario_leitura`
--
ALTER TABLE `diario_leitura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `metas`
--
ALTER TABLE `metas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sessoes_pomodoro`
--
ALTER TABLE `sessoes_pomodoro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `diario_leitura`
--
ALTER TABLE `diario_leitura`
  ADD CONSTRAINT `diario_leitura_ibfk_1` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `livros`
--
ALTER TABLE `livros`
  ADD CONSTRAINT `livros_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `sessoes_pomodoro`
--
ALTER TABLE `sessoes_pomodoro`
  ADD CONSTRAINT `sessoes_pomodoro_ibfk_1` FOREIGN KEY (`livro_id`) REFERENCES `livros` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
