-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.21-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para scheduling
CREATE DATABASE IF NOT EXISTS `scheduling` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `scheduling`;

-- Copiando estrutura para tabela scheduling.sc_agendamentos
CREATE TABLE IF NOT EXISTS `sc_agendamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `data_agendamento` date NOT NULL,
  `hora_agendamento` time NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'Agendado',
  `ativo` int(11) NOT NULL DEFAULT 1,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_modificacao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `sc_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela scheduling.sc_agendamentos: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `sc_agendamentos` DISABLE KEYS */;
INSERT INTO `sc_agendamentos` (`id`, `id_usuario`, `data_agendamento`, `hora_agendamento`, `status`, `ativo`, `data_registro`, `data_modificacao`) VALUES
	(1, 2, '2023-07-07', '12:00:00', 'Agendado', 1, '2023-06-15 23:00:19', '2023-06-17 18:17:55'),
	(17, 1, '2023-07-03', '11:00:00', 'Agendado', 1, '2023-06-17 14:56:29', '2023-06-17 18:17:35'),
	(19, 1, '2023-07-04', '09:00:00', 'Agendado', 1, '2023-06-17 14:57:21', '2023-06-17 18:17:49'),
	(20, 1, '2023-07-06', '11:00:00', 'Agendado', 1, '2023-06-17 14:57:24', '2023-06-17 18:17:41'),
	(21, 1, '2023-07-04', '08:00:00', 'Agendado', 1, '2023-06-17 14:58:53', '2023-06-17 18:17:39'),
	(22, 1, '2023-07-03', '13:00:00', 'Agendado', 1, '2023-06-17 15:06:24', '2023-06-17 18:17:33'),
	(23, 1, '2023-06-27', '10:00:00', 'Agendado', 1, '2023-06-17 15:10:02', '2023-06-17 18:17:14'),
	(24, 2, '2023-06-30', '14:00:00', 'Agendado', 1, '2023-06-17 16:24:52', '2023-06-17 18:10:13'),
	(25, 2, '2023-06-28', '15:00:00', 'Cancelado', 1, '2023-06-17 16:27:41', '2023-06-17 18:18:13'),
	(26, 3, '2023-06-28', '17:00:00', 'Atendido', 1, '2023-06-17 16:36:41', '2023-06-17 17:59:51'),
	(27, 3, '2023-07-26', '15:00:00', 'Confirmado', 1, '2023-06-17 18:09:08', '2023-06-17 19:10:08'),
	(28, 3, '2023-07-05', '17:00:00', 'Agendado', 1, '2023-06-17 19:21:30', NULL);
/*!40000 ALTER TABLE `sc_agendamentos` ENABLE KEYS */;

-- Copiando estrutura para tabela scheduling.sc_agendamentos_servicos
CREATE TABLE IF NOT EXISTS `sc_agendamentos_servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agendamento` int(11) NOT NULL,
  `id_servicos` int(11) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT 1,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_modificacao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_agendamento` (`id_agendamento`),
  KEY `fk_servicos` (`id_servicos`),
  CONSTRAINT `fk_agendamento` FOREIGN KEY (`id_agendamento`) REFERENCES `sc_agendamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_servicos` FOREIGN KEY (`id_servicos`) REFERENCES `sc_servicos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela scheduling.sc_agendamentos_servicos: ~23 rows (aproximadamente)
/*!40000 ALTER TABLE `sc_agendamentos_servicos` DISABLE KEYS */;
INSERT INTO `sc_agendamentos_servicos` (`id`, `id_agendamento`, `id_servicos`, `ativo`, `data_registro`, `data_modificacao`) VALUES
	(1, 1, 1, 1, '2023-06-15 23:08:40', NULL),
	(2, 1, 2, 1, '2023-06-15 23:08:40', NULL),
	(9, 17, 1, 1, '2023-06-17 14:56:29', NULL),
	(11, 19, 1, 1, '2023-06-17 14:57:21', NULL),
	(12, 20, 1, 1, '2023-06-17 14:57:24', NULL),
	(13, 21, 1, 1, '2023-06-17 14:58:53', NULL),
	(14, 21, 2, 1, '2023-06-17 14:58:53', NULL),
	(15, 22, 1, 1, '2023-06-17 15:06:24', NULL),
	(16, 22, 2, 1, '2023-06-17 15:06:24', NULL),
	(17, 23, 1, 1, '2023-06-17 15:10:02', NULL),
	(18, 23, 2, 1, '2023-06-17 15:10:02', NULL),
	(19, 24, 1, 1, '2023-06-17 16:24:52', NULL),
	(20, 24, 2, 1, '2023-06-17 16:24:52', NULL),
	(28, 26, 1, 1, '2023-06-17 17:59:51', NULL),
	(29, 26, 2, 1, '2023-06-17 17:59:51', NULL),
	(32, 25, 1, 1, '2023-06-17 18:18:13', NULL),
	(33, 25, 2, 1, '2023-06-17 18:18:13', NULL),
	(34, 27, 1, 1, '2023-06-17 19:10:08', NULL),
	(35, 27, 2, 1, '2023-06-17 19:10:08', NULL),
	(36, 28, 1, 1, '2023-06-17 19:21:30', NULL),
	(37, 28, 4, 1, '2023-06-17 19:21:30', NULL),
	(38, 28, 3, 1, '2023-06-17 19:21:30', NULL),
	(39, 28, 2, 1, '2023-06-17 19:21:30', NULL);
/*!40000 ALTER TABLE `sc_agendamentos_servicos` ENABLE KEYS */;

-- Copiando estrutura para tabela scheduling.sc_menu
CREATE TABLE IF NOT EXISTS `sc_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `url` varchar(191) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_order` (`item_order`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela scheduling.sc_menu: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `sc_menu` DISABLE KEYS */;
INSERT INTO `sc_menu` (`id`, `name`, `url`, `icon`, `item_order`) VALUES
	(1, 'Agendamentos', NULL, 'flaticon-suitcase', 1),
	(2, 'Gerenciamento', NULL, 'flaticon-dashboard', 2);
/*!40000 ALTER TABLE `sc_menu` ENABLE KEYS */;

-- Copiando estrutura para tabela scheduling.sc_menu_submenu
CREATE TABLE IF NOT EXISTS `sc_menu_submenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_menu_id` int(11) NOT NULL,
  `item_order` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_order` (`item_order`),
  KEY `menu_id` (`sc_menu_id`) USING BTREE,
  CONSTRAINT `menu_submenu_fk` FOREIGN KEY (`sc_menu_id`) REFERENCES `sc_menu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela scheduling.sc_menu_submenu: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `sc_menu_submenu` DISABLE KEYS */;
INSERT INTO `sc_menu_submenu` (`id`, `sc_menu_id`, `item_order`, `name`, `url`) VALUES
	(1, 1, 1, 'Listar', 'agendamentos'),
	(2, 1, 2, 'Agendar', 'agendamentos.agendar'),
	(3, 2, 3, 'Desempenho Semanal', 'gerenciamento.desempenho');
/*!40000 ALTER TABLE `sc_menu_submenu` ENABLE KEYS */;

-- Copiando estrutura para tabela scheduling.sc_perfil
CREATE TABLE IF NOT EXISTS `sc_perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `tipo` varchar(250) NOT NULL,
  `permissao` varchar(250) NOT NULL,
  `admin` int(11) NOT NULL,
  `relacionado` int(11) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT 1,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_modificacao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela scheduling.sc_perfil: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `sc_perfil` DISABLE KEYS */;
INSERT INTO `sc_perfil` (`id`, `nome`, `tipo`, `permissao`, `admin`, `relacionado`, `ativo`, `data_registro`, `data_modificacao`, `deleted_at`) VALUES
	(1, 'Admin', 'Admin', '{"1":["1","2"],"2":["3"]}', 1, 0, 1, '2023-06-15 14:22:01', '2023-06-17 18:25:26', NULL),
	(2, 'Cliente', 'Cliente', '{"1":["1", "2"]}', 0, 1, 1, '2023-06-15 14:22:09', '2023-06-17 18:20:30', NULL);
/*!40000 ALTER TABLE `sc_perfil` ENABLE KEYS */;

-- Copiando estrutura para tabela scheduling.sc_servicos
CREATE TABLE IF NOT EXISTS `sc_servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servico` varchar(250) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT 1,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_modificacao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela scheduling.sc_servicos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `sc_servicos` DISABLE KEYS */;
INSERT INTO `sc_servicos` (`id`, `servico`, `valor`, `ativo`, `data_registro`, `data_modificacao`) VALUES
	(1, 'Cabelo Unisex', 45.00, 1, '2023-06-15 14:38:36', '2023-06-15 14:39:05'),
	(2, 'Unhas', 35.00, 1, '2023-06-15 14:38:36', '2023-06-15 14:38:58'),
	(3, 'Pintura Cabelo', 35.00, 1, '2023-06-15 14:38:36', '2023-06-15 14:38:58'),
	(4, 'Cílios', 35.00, 1, '2023-06-15 14:38:36', '2023-06-15 14:38:58');
/*!40000 ALTER TABLE `sc_servicos` ENABLE KEYS */;

-- Copiando estrutura para tabela scheduling.sc_usuarios
CREATE TABLE IF NOT EXISTS `sc_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perfil` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `login` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `ativo` int(11) NOT NULL DEFAULT 1,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_modificacao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_perfil` (`id_perfil`),
  CONSTRAINT `fk_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `sc_perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela scheduling.sc_usuarios: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `sc_usuarios` DISABLE KEYS */;
INSERT INTO `sc_usuarios` (`id`, `id_perfil`, `nome`, `login`, `senha`, `ativo`, `data_registro`, `data_modificacao`) VALUES
	(1, 1, 'Administrador', 'admin', '$2y$10$MxvGlVLQI8i0G5OfHR31c.x6pcoMp7pPr.n/Vn3MrsJKi43FoKEOm', 1, '2023-06-15 14:35:22', '2023-06-15 16:24:02'),
	(2, 2, 'Cliente1', 'cliente1', '$2y$10$MxvGlVLQI8i0G5OfHR31c.x6pcoMp7pPr.n/Vn3MrsJKi43FoKEOm', 1, '2023-06-15 14:35:22', '2023-06-16 10:58:59'),
	(3, 2, 'Cliente2', 'cliente2', '$2y$10$MxvGlVLQI8i0G5OfHR31c.x6pcoMp7pPr.n/Vn3MrsJKi43FoKEOm', 1, '2023-06-15 14:35:22', '2023-06-16 10:58:59');
/*!40000 ALTER TABLE `sc_usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
