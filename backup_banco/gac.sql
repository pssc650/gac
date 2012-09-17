-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 26/05/2012 às 06h05min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `gac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE IF NOT EXISTS `alunos` (
  `id_aluno` int(11) NOT NULL,
  `nome_aluno` varchar(70) NOT NULL,
  `id_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id_aluno`, `nome_aluno`, `id_turma`) VALUES
(52, 'Gabriel Matsuoka', 16),
(55, 'Pablo', 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE IF NOT EXISTS `atividades` (
  `id_atividade` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno` int(11) NOT NULL,
  `id_aula` int(11) DEFAULT NULL,
  `id_categoria_atividade` int(11) NOT NULL,
  `nome_atividade` varchar(255) NOT NULL,
  `descricao_atividade` varchar(255) NOT NULL,
  `horas` int(11) NOT NULL,
  `nome_arquivo` varchar(70) NOT NULL,
  `visto` varchar(2) NOT NULL,
  PRIMARY KEY (`id_atividade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `atividades`
--

INSERT INTO `atividades` (`id_atividade`, `id_aluno`, `id_aula`, `id_categoria_atividade`, `nome_atividade`, `descricao_atividade`, `horas`, `nome_arquivo`, `visto`) VALUES
(11, 52, 3, 3, 'Testando', 'Testando', 10, 'github.txt', '1'),
(12, 52, 3, 3, 'tes', 'tes', 30, 'github45.txt', '1'),
(15, 55, 3, 3, 'teste', 'fsafsa', 10, 'gabriel.ppk', '1'),
(16, 55, 3, 3, 'sihha', 'hiasuhdiaudas', 50, 'Dados cPanel.txt', '1'),
(17, 52, 0, 5, 'Livro 123', 'Livro 123', 2, 'github22.txt', '1'),
(18, 55, 0, 5, 'Pablo 123', '123', 2, 'Dados cPanel29.txt', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aulas`
--

CREATE TABLE IF NOT EXISTS `aulas` (
  `id_aula` int(11) NOT NULL AUTO_INCREMENT,
  `id_turma` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `id_disciplina` int(11) NOT NULL,
  PRIMARY KEY (`id_aula`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `aulas`
--

INSERT INTO `aulas` (`id_aula`, `id_turma`, `id_professor`, `id_disciplina`) VALUES
(3, 16, 51, 22),
(4, 16, 54, 24),
(5, 16, 54, 23);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_atividades`
--

CREATE TABLE IF NOT EXISTS `categoria_atividades` (
  `id_categoria_atividade` int(11) NOT NULL AUTO_INCREMENT,
  `nome_categoria_atividade` varchar(90) NOT NULL,
  `id_tipo_atividade` int(11) NOT NULL,
  `resumo` varchar(10) NOT NULL,
  `visto` varchar(10) NOT NULL,
  `max_horas` varchar(10) NOT NULL,
  `hora_fixa` int(11) NOT NULL,
  PRIMARY KEY (`id_categoria_atividade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `categoria_atividades`
--

INSERT INTO `categoria_atividades` (`id_categoria_atividade`, `nome_categoria_atividade`, `id_tipo_atividade`, `resumo`, `visto`, `max_horas`, `hora_fixa`) VALUES
(3, 'Curso Ã  DistÃ¢ncia (EAD)', 5, 'NÃ£o', 'Sim', '20%', 0),
(4, 'Cine Fieo de Arte', 6, 'Sim', 'Sim', '2', 0),
(5, 'Leitura de Livro', 6, 'Sim', 'NÃ£o', '10', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE IF NOT EXISTS `cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nome_curso` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`id_curso`, `nome_curso`) VALUES
(4, 'Tecnologia Analise e Desenvolvimento de Sistemas'),
(6, 'Sistemas da InformaÃ§Ã£o');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso_semestres`
--

CREATE TABLE IF NOT EXISTS `curso_semestres` (
  `id_curso_semestre` int(11) NOT NULL AUTO_INCREMENT,
  `id_curso` int(11) NOT NULL,
  `id_semestre` int(11) NOT NULL,
  `min_horas` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_curso_semestre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `curso_semestres`
--

INSERT INTO `curso_semestres` (`id_curso_semestre`, `id_curso`, `id_semestre`, `min_horas`) VALUES
(6, 4, 9, '80'),
(5, 4, 8, '70'),
(7, 4, 10, '80'),
(8, 4, 11, '80'),
(9, 6, 8, '80');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplinas`
--

CREATE TABLE IF NOT EXISTS `disciplinas` (
  `id_disciplina` int(11) NOT NULL AUTO_INCREMENT,
  `nome_disciplina` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_disciplina`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `disciplinas`
--

INSERT INTO `disciplinas` (`id_disciplina`, `nome_disciplina`) VALUES
(22, 'Algoritmos ll'),
(23, 'Engenharia de Software ll'),
(24, 'Redes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista_disciplinas`
--

CREATE TABLE IF NOT EXISTS `lista_disciplinas` (
  `id_curso_semestre` int(11) NOT NULL,
  `id_disciplina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `lista_disciplinas`
--

INSERT INTO `lista_disciplinas` (`id_curso_semestre`, `id_disciplina`) VALUES
(7, 22),
(7, 23),
(7, 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodos`
--

CREATE TABLE IF NOT EXISTS `periodos` (
  `id_periodo` int(11) NOT NULL AUTO_INCREMENT,
  `nome_periodo` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_periodo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `periodos`
--

INSERT INTO `periodos` (`id_periodo`, `nome_periodo`) VALUES
(7, 'Manha'),
(8, 'Noite');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores`
--

CREATE TABLE IF NOT EXISTS `professores` (
  `id_professor` int(11) NOT NULL AUTO_INCREMENT,
  `nome_professor` varchar(70) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_professor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=57 ;

--
-- Extraindo dados da tabela `professores`
--

INSERT INTO `professores` (`id_professor`, `nome_professor`) VALUES
(51, 'Maria Emilia'),
(54, 'Alexandre'),
(56, 'prof');

-- --------------------------------------------------------

--
-- Estrutura da tabela `semestres`
--

CREATE TABLE IF NOT EXISTS `semestres` (
  `id_semestre` int(11) NOT NULL AUTO_INCREMENT,
  `nome_semestre` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_semestre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `semestres`
--

INSERT INTO `semestres` (`id_semestre`, `nome_semestre`) VALUES
(11, '4Âº Semestre'),
(10, '3Âº Semestre'),
(9, '2Âº Semestre'),
(8, '1Âº Semestre');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_atividades`
--

CREATE TABLE IF NOT EXISTS `tipo_atividades` (
  `id_tipo_atividade` int(11) NOT NULL AUTO_INCREMENT,
  `nome_tipo_atividade` varchar(90) NOT NULL,
  PRIMARY KEY (`id_tipo_atividade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tipo_atividades`
--

INSERT INTO `tipo_atividades` (`id_tipo_atividade`, `nome_tipo_atividade`) VALUES
(5, 'Atividade Academica'),
(6, 'Atividade Cultural');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE IF NOT EXISTS `turmas` (
  `id_turma` int(11) NOT NULL AUTO_INCREMENT,
  `id_curso_semestre` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  `identificador` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ano` int(11) NOT NULL,
  PRIMARY KEY (`id_turma`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`id_turma`, `id_curso_semestre`, `id_periodo`, `identificador`, `ano`) VALUES
(16, 7, 8, 'A', 2012);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `nivel` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=57 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `login`, `senha`, `nivel`, `status`) VALUES
(24, 'root', 'root', 0, 1),
(51, 'maria', 'maria', 2, 1),
(36, 'admin', 'admin', 0, 1),
(52, 'gabriel', 'gabriel', 3, 1),
(54, 'alexandre', 'alexandre', 2, 1),
(55, 'pablo', 'pablo', 3, 1),
(56, 'prof', 'prof', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
