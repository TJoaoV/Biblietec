-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Ago-2021 às 18:18
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblietec`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `alu_codi` int(11) NOT NULL,
  `alu_rm` int(11) NOT NULL,
  `alu_nome` varchar(100) NOT NULL,
  `alu_senh` varchar(150) NOT NULL,
  `alu_cpf` varchar(11) NOT NULL,
  `alu_tele` varchar(10) DEFAULT NULL,
  `alu_celu` varchar(11) DEFAULT NULL,
  `alu_emai` varchar(150) NOT NULL,
  `alu_dtna` date NOT NULL,
  `alu_reds` int(1) NOT NULL COMMENT 'Redefinição de senha (1 - Redefinida, 0 - Normal)',
  `cur_codi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`alu_codi`, `alu_rm`, `alu_nome`, `alu_senh`, `alu_cpf`, `alu_tele`, `alu_celu`, `alu_emai`, `alu_dtna`, `alu_reds`, `cur_codi`) VALUES
(1, 19229, 'GUILHERME SPERANDINI COSTA', '202cb962ac59075b964b07152d234b70', '44115123869', NULL, '16991624093', 'GUISPCOSTA@GMAIL.COM', '2004-06-15', 0, 1),
(2, 123, 'GUILHERME COSTA', '202cb962ac59075b964b07152d234b70', '44215123869', '1631341254', '16991624093', 'guisperandinicosta@yahoo.com.br', '2004-06-15', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `cat_codi` int(11) NOT NULL,
  `cat_nome` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`cat_codi`, `cat_nome`) VALUES
(1, 'Romance');

-- --------------------------------------------------------

--
-- Estrutura da tabela `corpo_emprestimo`
--

CREATE TABLE `corpo_emprestimo` (
  `cor_codi` int(11) NOT NULL,
  `emp_codi` int(11) NOT NULL,
  `liv_codi` int(11) NOT NULL COMMENT 'Relacionado com tabela livros',
  `emp_dtde` date NOT NULL COMMENT 'Data Devolução (previsão)',
  `emp_devo` enum('Devolvido','NÃO Devolvido') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE `cursos` (
  `cur_codi` int(11) NOT NULL,
  `cur_nome` varchar(100) NOT NULL,
  `cur_dura` varchar(20) NOT NULL,
  `cur_peri` enum('INTEGRAL','MANHÃ','TARDE','NOITE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`cur_codi`, `cur_nome`, `cur_dura`, `cur_peri`) VALUES
(1, 'ETIM DESENVOLVIMENTO DE SISTEMAS', '3 ANOS', 'INTEGRAL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimo`
--

CREATE TABLE `emprestimo` (
  `emp_codi` int(11) NOT NULL,
  `alu_rm` varchar(11) NOT NULL COMMENT 'Relacionado com tabela alunos',
  `emp_data` date NOT NULL COMMENT 'Data emprestimo',
  `usu_codi` int(11) NOT NULL COMMENT 'Relacionado com tabela usuario (Usuário que fez o emprestimo)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros`
--

CREATE TABLE `livros` (
  `liv_codi` int(11) NOT NULL,
  `liv_titu` varchar(100) NOT NULL,
  `liv_auto` varchar(100) NOT NULL,
  `liv_edit` varchar(80) NOT NULL,
  `cat_codi` int(11) NOT NULL COMMENT 'Relacionado com tabela categoria',
  `liv_sino` varchar(900) NOT NULL COMMENT 'Sinopse'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usu_codi` int(11) NOT NULL,
  `usu_nome` varchar(100) NOT NULL,
  `usu_emai` varchar(150) NOT NULL,
  `usu_logi` varchar(50) NOT NULL,
  `usu_senh` varchar(50) NOT NULL,
  `usu_perm` enum('Administrador','Bibliotecário') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usu_codi`, `usu_nome`, `usu_emai`, `usu_logi`, `usu_senh`, `usu_perm`) VALUES
(1, 'Guilherme Sperandini Costa', 'guispcosta@gmail.com', 'guispcosta', '123', 'Administrador');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`alu_codi`),
  ADD UNIQUE KEY `alu_rm` (`alu_rm`),
  ADD UNIQUE KEY `alu_cpf` (`alu_cpf`),
  ADD KEY `cur_codi` (`cur_codi`);
ALTER TABLE `alunos` ADD FULLTEXT KEY `alu_nome` (`alu_nome`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`cat_codi`);

--
-- Índices para tabela `corpo_emprestimo`
--
ALTER TABLE `corpo_emprestimo`
  ADD PRIMARY KEY (`cor_codi`),
  ADD KEY `liv_codi` (`liv_codi`),
  ADD KEY `emp_codi` (`emp_codi`);

--
-- Índices para tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`cur_codi`);

--
-- Índices para tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`emp_codi`),
  ADD KEY `usu_codi` (`usu_codi`);

--
-- Índices para tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`liv_codi`),
  ADD KEY `cat_codi` (`cat_codi`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_codi`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `alu_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `cat_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `corpo_emprestimo`
--
ALTER TABLE `corpo_emprestimo`
  MODIFY `cor_codi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `cur_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `emp_codi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `liv_codi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `cursosfk` FOREIGN KEY (`cur_codi`) REFERENCES `cursos` (`cur_codi`);

--
-- Limitadores para a tabela `corpo_emprestimo`
--
ALTER TABLE `corpo_emprestimo`
  ADD CONSTRAINT `emprestimofk` FOREIGN KEY (`emp_codi`) REFERENCES `emprestimo` (`emp_codi`),
  ADD CONSTRAINT `livroskfk` FOREIGN KEY (`liv_codi`) REFERENCES `livros` (`liv_codi`);

--
-- Limitadores para a tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `usuariosfk` FOREIGN KEY (`usu_codi`) REFERENCES `usuario` (`usu_codi`);

--
-- Limitadores para a tabela `livros`
--
ALTER TABLE `livros`
  ADD CONSTRAINT `categoriafk` FOREIGN KEY (`cat_codi`) REFERENCES `categoria` (`cat_codi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
