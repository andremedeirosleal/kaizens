-- --------------------------------------------------------
-- Host:                         10.26.102.200
-- Server version:               5.7.24-0ubuntu0.16.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for KAIZENS
CREATE DATABASE IF NOT EXISTS `KAIZENS` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `KAIZENS`;


-- Dumping structure for table KAIZENS.kaizens
CREATE TABLE IF NOT EXISTS `kaizens` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cadastrou` int(11) DEFAULT NULL,
  `nomegerencia` varchar(50) NOT NULL,
  `gerencia` int(11) DEFAULT NULL,
  `supervisao` int(11) DEFAULT NULL,
  `nomesupervisao` varchar(50) NOT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  `objetivo` varchar(250) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `bt_nao_kaizen` bit(1) DEFAULT b'0',
  `saude` bit(1) DEFAULT NULL,
  `seg` bit(1) DEFAULT NULL,
  `pessoas` bit(1) DEFAULT NULL,
  `quali` bit(1) DEFAULT NULL,
  `prod` bit(1) DEFAULT NULL,
  `custos` bit(1) DEFAULT NULL,
  `nd` bit(1) DEFAULT NULL,
  `espera` bit(1) DEFAULT NULL,
  `superprod` bit(1) DEFAULT NULL,
  `transp` bit(1) DEFAULT NULL,
  `invent` bit(1) DEFAULT NULL,
  `movi` bit(1) DEFAULT NULL,
  `process` bit(1) DEFAULT NULL,
  `defeito` bit(1) DEFAULT NULL,
  `meio_ambiente` bit(1) DEFAULT NULL,
  `desc_antes` varchar(500) DEFAULT NULL,
  `desc_apos` varchar(500) DEFAULT NULL,
  `result` varchar(500) DEFAULT NULL,
  `colab1` int(11) DEFAULT NULL,
  `colab2` int(11) DEFAULT NULL,
  `colab3` int(11) DEFAULT NULL,
  `colab4` int(11) DEFAULT NULL,
  `colab5` int(11) DEFAULT NULL,
  `foto_antes` longblob,
  `foto_apos` longblob,
  `valor` double DEFAULT NULL,
  `riscseg_antes` varchar(15) DEFAULT NULL,
  `riscseg_apos` varchar(15) DEFAULT NULL,
  `riscseg_ganho` varchar(15) DEFAULT NULL,
  `qtdstq_antes` int(11) DEFAULT NULL,
  `qtdstq_apos` int(11) DEFAULT NULL,
  `qtdstq_ganho` int(11) DEFAULT NULL,
  `dist_antes` int(11) DEFAULT NULL,
  `dist_apos` int(11) DEFAULT NULL,
  `dist_ganho` int(11) DEFAULT NULL,
  `esp_antes` int(11) DEFAULT NULL,
  `esp_apos` int(11) DEFAULT NULL,
  `esp_ganho` int(11) DEFAULT NULL,
  `finan_antes` int(11) DEFAULT NULL,
  `finan_apos` int(11) DEFAULT NULL,
  `finan_ganho` int(11) DEFAULT NULL,
  `tempo_antes` int(11) DEFAULT NULL,
  `tempo_apos` int(11) DEFAULT NULL,
  `tempo_ganho` int(11) DEFAULT NULL,
  `outro_antes` varchar(20) DEFAULT NULL,
  `outro_apos` varchar(20) DEFAULT NULL,
  `outro_ganho` varchar(20) DEFAULT NULL,
  `outro_desc` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FKgerencia` (`gerencia`),
  KEY `FKsupervisao` (`supervisao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table KAIZENS.share_kaizens
CREATE TABLE IF NOT EXISTS `share_kaizens` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `data_share` date DEFAULT '0000-00-00',
  `cod_kaizen` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `diretoria` int(11) DEFAULT NULL,
  `cod_ger` int(11) DEFAULT NULL,
  `cod_sup` int(11) DEFAULT NULL,
  KEY `codigo` (`codigo`),
  KEY `FK_gerencia` (`cod_ger`),
  KEY `FK_supervisao` (`cod_sup`),
  KEY `FK_cod_kaizen` (`cod_kaizen`),
  CONSTRAINT `FK2_cod_ger` FOREIGN KEY (`cod_ger`) REFERENCES `LOCACAO`.`TBL_GERENCIAS` (`ID_GERENCIA`),
  CONSTRAINT `FK3_cod_sup` FOREIGN KEY (`cod_sup`) REFERENCES `LOCACAO`.`TBL_SUPERVISOES` (`ID_SUPERVISAO`),
  CONSTRAINT `FK_cod_kaizen` FOREIGN KEY (`cod_kaizen`) REFERENCES `kaizens` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table KAIZENS.TBL_APROVACOES_SEGURANCA
CREATE TABLE IF NOT EXISTS `TBL_APROVACOES_SEGURANCA` (
  `ID_APROVACAO_SEGURANCA` int(11) NOT NULL AUTO_INCREMENT,
  `DT_APROVACAO` date NOT NULL,
  `ID_USUARIO` int(11) NOT NULL DEFAULT '0',
  `ID_KAIZEN` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_APROVACAO_SEGURANCA`),
  KEY `FK_KAIZEN_APROVADO` (`ID_KAIZEN`),
  KEY `FK_USUARIO_APROVADOR` (`ID_USUARIO`),
  CONSTRAINT `FK_KAIZEN_APROVADO` FOREIGN KEY (`ID_KAIZEN`) REFERENCES `kaizens` (`codigo`),
  CONSTRAINT `FK_USUARIO_APROVADOR` FOREIGN KEY (`ID_USUARIO`) REFERENCES `USUARIOS`.`TBL_USUARIOS` (`ID_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table KAIZENS.TBL_APROVACOES_TECNICA
CREATE TABLE IF NOT EXISTS `TBL_APROVACOES_TECNICA` (
  `ID_APROVACAO_TECNICA` int(11) NOT NULL AUTO_INCREMENT,
  `DT_APROVACAO` date DEFAULT NULL,
  `ID_USUARIO` int(11) NOT NULL DEFAULT '0',
  `ID_KAIZEN` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_APROVACAO_TECNICA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table KAIZENS.TBL_IDEIAS
CREATE TABLE IF NOT EXISTS `TBL_IDEIAS` (
  `ID_IDEIA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `ID_GERENCIA_USUARIO` int(11) DEFAULT NULL,
  `ID_SUPERVISAO_USUARIO` int(11) DEFAULT NULL,
  `DS_PROBLEMA` varchar(4000) DEFAULT NULL,
  `DS_SOLUCAO` varchar(4000) DEFAULT NULL,
  `DT_CADASTRO` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_IDEIA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table KAIZENS.TBL_REPLICACOES_KAIZENS
CREATE TABLE IF NOT EXISTS `TBL_REPLICACOES_KAIZENS` (
  `ID_REPLICACAO_KAIZEN` int(11) NOT NULL AUTO_INCREMENT,
  `DT_REPLICACAO` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID_KAIZEN_ORIGINAL` int(11) NOT NULL,
  `ID_KAIZEN_NOVO` int(11) NOT NULL,
  `ID_REPLICADOR` int(11) NOT NULL,
  `ID_SUPERVISAO_APLICADA` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_REPLICACAO_KAIZEN`),
  KEY `FK_REPLICADOR` (`ID_REPLICADOR`),
  KEY `FK_SUPERVISAO_APLICADA` (`ID_SUPERVISAO_APLICADA`),
  KEY `FK_KAIZEN_NOVO` (`ID_KAIZEN_NOVO`),
  KEY `FK_KAIZEN_ORIGINAL` (`ID_KAIZEN_ORIGINAL`),
  CONSTRAINT `FK_KAIZEN_NOVO` FOREIGN KEY (`ID_KAIZEN_NOVO`) REFERENCES `kaizens` (`codigo`),
  CONSTRAINT `FK_KAIZEN_ORIGINAL` FOREIGN KEY (`ID_KAIZEN_ORIGINAL`) REFERENCES `kaizens` (`codigo`),
  CONSTRAINT `FK_REPLICADOR` FOREIGN KEY (`ID_REPLICADOR`) REFERENCES `USUARIOS`.`TBL_USUARIOS` (`ID_USUARIO`),
  CONSTRAINT `FK_SUPERVISAO_APLICADA` FOREIGN KEY (`ID_SUPERVISAO_APLICADA`) REFERENCES `LOCACAO`.`TBL_SUPERVISOES` (`ID_SUPERVISAO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
