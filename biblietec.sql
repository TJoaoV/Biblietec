-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Nov-2021 às 02:29
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.10

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
(1, 19229, 'GUILHERME SPERANDINI COSTA', '202cb962ac59075b964b07152d234b70', '44115123869', '', '16991624093', 'guispcosta@gmail.com', '2004-06-15', 0, 1),
(2, 19999, 'ROGERIO GALDIANO O BRABO', '202cb962ac59075b964b07152d234b70', '08987288005', '1631341254', '', 'guisperandinicosta@yahoo.com.br', '2004-06-15', 0, 2);

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
(1, 'Romance'),
(2, 'Literatura Infantil'),
(3, 'Aventura'),
(4, 'Drama'),
(5, 'Novela'),
(6, 'Conto'),
(7, 'Crônica'),
(8, 'Poesia'),
(9, 'Carta'),
(10, 'Bibliografia'),
(11, 'Terror'),
(12, 'Comédia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `corpo_emprestimo`
--

CREATE TABLE `corpo_emprestimo` (
  `cor_codi` int(11) NOT NULL,
  `emp_codi` int(11) NOT NULL,
  `liv_codi` int(11) NOT NULL COMMENT 'Relacionado com tabela livros',
  `emp_dtde` date NOT NULL COMMENT 'Data Devolução (previsão)',
  `emp_devo` enum('Devolvido','NÃO Devolvido') NOT NULL,
  `cor_pego` int(2) NOT NULL COMMENT 'Se o livro foi pego ou não (0 - NÃO, 1 - PEGO)',
  `cor_dten` date DEFAULT NULL COMMENT 'Data de Entrega do Livro',
  `cor_dtde` date DEFAULT NULL COMMENT 'Data que foi devolvido',
  `alu_rm` int(11) NOT NULL,
  `usu_codi` int(20) DEFAULT NULL COMMENT 'Relacionado com tabela usuario (Usuário que fez o emprestimo)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `corpo_emprestimo`
--

INSERT INTO `corpo_emprestimo` (`cor_codi`, `emp_codi`, `liv_codi`, `emp_dtde`, `emp_devo`, `cor_pego`, `cor_dten`, `cor_dtde`, `alu_rm`, `usu_codi`) VALUES
(1, 1, 4, '2021-10-11', 'Devolvido', 1, '2021-10-10', '2021-10-10', 19229, 1),
(2, 1, 6, '2021-10-12', 'Devolvido', 1, '2021-10-10', '2021-10-10', 19229, 1),
(3, 1, 1, '2021-10-09', 'Devolvido', 1, '2021-10-09', '2021-10-10', 19229, 1),
(8, 2, 6, '2021-11-13', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(9, 2, 1, '2021-11-15', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(11, 2, 2, '2021-11-15', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(12, 2, 4, '2021-11-13', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(13, 2, 2, '2021-11-13', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(14, 2, 1, '2021-11-13', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(15, 2, 2, '2021-11-13', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(16, 2, 1, '2021-11-13', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(17, 2, 4, '2021-11-11', 'Devolvido', 1, '2021-11-13', '2021-11-13', 19229, 1),
(18, 2, 1, '2021-11-10', 'Devolvido', 1, '2021-11-13', '2021-11-14', 19229, 1),
(35, 15, 2, '2021-11-15', 'Devolvido', 1, '2021-11-14', '2021-11-14', 19229, 1),
(36, 15, 5, '2021-11-16', 'Devolvido', 1, '2021-11-14', '2021-11-14', 19229, 1),
(37, 15, 1, '2021-11-14', 'Devolvido', 1, '2021-11-14', '2021-11-14', 19229, 1),
(42, 15, 6, '2021-11-15', 'Devolvido', 1, '2021-11-14', '2021-11-14', 19229, 1);

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
(1, 'ETIM DESENVOLVIMENTO DE SISTEMAS', '3 ANOS', 'INTEGRAL'),
(2, 'ETIM Meio Ambiente', '3 Anos', 'INTEGRAL'),
(3, 'MTEC Meio Ambiente', '3 Anos', 'MANHÃ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimo`
--

CREATE TABLE `emprestimo` (
  `emp_codi` int(11) NOT NULL,
  `alu_rm` varchar(11) NOT NULL COMMENT 'Relacionado com tabela alunos',
  `emp_data` date NOT NULL COMMENT 'Data emprestimo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `emprestimo`
--

INSERT INTO `emprestimo` (`emp_codi`, `alu_rm`, `emp_data`) VALUES
(1, '19229', '2021-10-10'),
(2, '19229', '2021-11-13'),
(3, '19229', '2021-11-13'),
(4, '19229', '2021-11-13'),
(5, '19229', '2021-11-13'),
(6, '19229', '2021-11-13'),
(7, '19229', '2021-11-13'),
(8, '19229', '2021-11-13'),
(9, '19229', '2021-11-13'),
(10, '19229', '2021-11-13'),
(11, '19229', '2021-11-13'),
(12, '19229', '2021-11-13'),
(13, '19229', '2021-11-13'),
(14, '19229', '2021-11-13'),
(15, '19229', '2021-11-14'),
(16, '19229', '2021-11-14'),
(17, '19229', '2021-11-14'),
(18, '19229', '2021-11-14'),
(19, '19229', '2021-11-14'),
(20, '19229', '2021-11-14'),
(21, '19229', '2021-11-14'),
(22, '19229', '2021-11-14'),
(23, '19229', '2021-11-14'),
(24, '19229', '2021-11-14'),
(25, '19229', '2021-11-14'),
(26, '19229', '2021-11-14'),
(27, '19229', '2021-11-14'),
(28, '19229', '2021-11-14'),
(29, '19229', '2021-11-14'),
(30, '19229', '2021-11-14'),
(31, '19229', '2021-11-14'),
(32, '19229', '2021-11-14'),
(33, '19229', '2021-11-14'),
(34, '19229', '2021-11-14'),
(35, '19229', '2021-11-14'),
(36, '19229', '2021-11-14'),
(37, '19229', '2021-11-14'),
(38, '19229', '2021-11-14'),
(39, '19229', '2021-11-14'),
(40, '19229', '2021-11-14'),
(41, '19229', '2021-11-14'),
(42, '19229', '2021-11-14'),
(43, '19229', '2021-11-14'),
(44, '19229', '2021-11-14'),
(45, '19229', '2021-11-14'),
(46, '19229', '2021-11-14');

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
  `liv_sino` varchar(900) NOT NULL COMMENT 'Sinopse',
  `liv_quan` int(100) NOT NULL COMMENT 'Quantidade total de livros',
  `liv_qtdd` int(100) NOT NULL COMMENT 'Quantidade disponível de livros'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `livros`
--

INSERT INTO `livros` (`liv_codi`, `liv_titu`, `liv_auto`, `liv_edit`, `cat_codi`, `liv_sino`, `liv_quan`, `liv_qtdd`) VALUES
(1, 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'ViaLeitura', 2, 'Le Petit Prince é uma novela do escritor, aviador aristocrata francês Antoine de Saint-Exupéry, originalmente publicada em inglês e francês em abril de 1943 nos Estados Unidos. Durante a Segunda Guerra Mundial, Saint-Exupéry foi exilado para a América do Norte.', 2, 2),
(2, 'Dom Quixote de la Mancha', 'Miguel de Cervantes', 'D.QUIXOTE', 3, 'Dom Quixote de la Mancha é um livro escrito pelo espanhol Miguel de Cervantes. O título e ortografia originais eram El ingenioso hidalgo Don Quixote de La Mancha, com sua primeira edição publicada em Madrid no ano de 1605.', 5, 5),
(4, 'Guerra e Paz', 'Liev Tolstói', 'Paulus', 1, 'Guerra e Paz é um romance histórico escrito pelo autor russo Liev Tolstói e publicado entre 1865 e 1869 no Russkii Vestnik, um periódico da época. É uma das obras mais volumosas da história da literatura universal. O livro narra a história da Rússia à época de Napoleão Bonaparte.', 3, 3),
(5, 'O Patinho Feio', 'Hans Christian Andersen', 'Zahar', 2, 'O Patinho Feio é um conto de fadas do escritor dinamarquês Hans Christian Andersen, publicado pela primeira vez em 11 de Novembro de 1843 em Nye Eventyr. Første Bind. Første Samling. 1844.', 4, 4),
(6, 'O Homem de Giz', 'C.J. Tudor', 'editorateste', 11, 'Assassinato e sinais misteriosos em uma trama para fãs de Stranger Things e Stephen King   Em 1986, Eddie e os amigos passam a maior parte dos dias andando de bicicleta pela pacata vizinhança em busca de aventuras.', 1, 1),
(9, '1984', 'George Orwell', 'Nova Fronteira', 1, 'Winston Smith é um funcionário do Ministério da Verdade, órgão responsável por notícias, entretenimento, educação e belas-artes do Estado. Seu trabalho consiste em reescrever a história para satisfazer as demandas do Partido, que busca o poder em benefício próprio e persegue todos os que se atrevem a cometer os chamados \"pensamentos-crime\". Um dia, porém, cansado daquela realidade, ele decide desafiar o sistema, mas o Grande Irmão está sempre de olho em tudo e em todos... Romance surpreendente, \"1984\" cria um mundo imaginário assustadoramente verossímil do início ao fim. Nesta distopia, uma das mais celebradas e influentes da literatura mundial, George Orwell nos apresenta presságios que podem estar mais perto da realidade de hoje do que gostaríamos. Esta edição conta com a tradução de Adalgisa Campos da Silva e o prefácio do advogado e escritor José Roberto de Castro Neves.', 25, 25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `preemprestimo`
--

CREATE TABLE `preemprestimo` (
  `pre_codi` int(11) NOT NULL,
  `liv_codi` int(11) NOT NULL,
  `alu_rm` int(11) NOT NULL,
  `pre_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usu_codi` int(11) NOT NULL,
  `usu_nome` varchar(100) NOT NULL,
  `usu_logi` varchar(50) NOT NULL,
  `usu_cpf` varchar(11) NOT NULL,
  `usu_ende` varchar(100) NOT NULL,
  `usu_dtna` date NOT NULL,
  `usu_tele` varchar(10) DEFAULT NULL,
  `usu_celu` varchar(11) DEFAULT NULL,
  `usu_emai` varchar(150) NOT NULL,
  `usu_senh` varchar(50) NOT NULL,
  `usu_perm` enum('Administrador','Bibliotecario') NOT NULL,
  `usu_reds` int(2) NOT NULL COMMENT '	Redefinição de senha (1 - Redefinida, 0 - Normal)',
  `usu_ativ` int(1) NOT NULL COMMENT '1 - usuário ativo e 0 - Usuário inativo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usu_codi`, `usu_nome`, `usu_logi`, `usu_cpf`, `usu_ende`, `usu_dtna`, `usu_tele`, `usu_celu`, `usu_emai`, `usu_senh`, `usu_perm`, `usu_reds`, `usu_ativ`) VALUES
(1, 'Guilherme Sperandini Costa', 'guispcosta', '44115123869', 'Rua Abilio dos Santos, 150, Jd Roselandia, Jeriquara/SP', '2004-06-15', '1631341254', '16991624093', 'guispcosta@gmail.com', '202cb962ac59075b964b07152d234b70', 'Administrador', 0, 1),
(2, 'João Vitor Ribeiro Lopes', 'alemao', '18828752068', 'Rua do Guara', '2021-11-17', '', '16999999999', 'joaozinhopokabala123@gmail.com', '202cb962ac59075b964b07152d234b70', 'Bibliotecario', 0, 1);

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
  ADD KEY `emp_codi` (`emp_codi`),
  ADD KEY `usuariofk` (`usu_codi`);

--
-- Índices para tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`cur_codi`);

--
-- Índices para tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`emp_codi`);

--
-- Índices para tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`liv_codi`),
  ADD KEY `cat_codi` (`cat_codi`);

--
-- Índices para tabela `preemprestimo`
--
ALTER TABLE `preemprestimo`
  ADD PRIMARY KEY (`pre_codi`),
  ADD KEY `liv_codi` (`liv_codi`),
  ADD KEY `alu_rm` (`alu_rm`);

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
  MODIFY `alu_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `cat_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `corpo_emprestimo`
--
ALTER TABLE `corpo_emprestimo`
  MODIFY `cor_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `cur_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `emp_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `liv_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `preemprestimo`
--
ALTER TABLE `preemprestimo`
  MODIFY `pre_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `livroskfk` FOREIGN KEY (`liv_codi`) REFERENCES `livros` (`liv_codi`),
  ADD CONSTRAINT `usuariofk` FOREIGN KEY (`usu_codi`) REFERENCES `usuario` (`usu_codi`);

--
-- Limitadores para a tabela `livros`
--
ALTER TABLE `livros`
  ADD CONSTRAINT `categoriafk` FOREIGN KEY (`cat_codi`) REFERENCES `categoria` (`cat_codi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
