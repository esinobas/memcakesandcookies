CREATE DATABASE  IF NOT EXISTS `MEMcakesandcookies` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `MEMcakesandcookies`;
-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: MEMcakesandcookies
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `TB_CONFIGURATION`
--

DROP TABLE IF EXISTS `TB_CONFIGURATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TB_CONFIGURATION` (
  `Property` varchar(50) NOT NULL,
  `Value` text NOT NULL,
  `Description` mediumtext,
  `Label` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Property`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_CONFIGURATION`
--

LOCK TABLES `TB_CONFIGURATION` WRITE;
/*!40000 ALTER TABLE `TB_CONFIGURATION` DISABLE KEYS */;
INSERT INTO `TB_CONFIGURATION` VALUES ('Path','images/cookies','Directorio donde se guarda la información de los cursos (Imagenes, videos, ...)','Directorio de Cursos'),('Time_between_steps','90','Tiempo que hay entre un paso y el siguiente en un curso.','Tiempo entre pasos');
/*!40000 ALTER TABLE `TB_CONFIGURATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TB_Level`
--

DROP TABLE IF EXISTS `TB_Level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TB_Level` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Level` varchar(30) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Curse level';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_Level`
--

LOCK TABLES `TB_Level` WRITE;
/*!40000 ALTER TABLE `TB_Level` DISABLE KEYS */;
INSERT INTO `TB_Level` VALUES (1,'Fácil'),(2,'Medio'),(3,'Difícil');
/*!40000 ALTER TABLE `TB_Level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TB_Curso`
--

DROP TABLE IF EXISTS `TB_Curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TB_Curso` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Image` text,
  `Duration` int(11) NOT NULL,
  `Level_Id` int(11) NOT NULL,
  `Price` float DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name_UNIQUE` (`Name`),
  KEY `Idx_Name` (`Name`),
  KEY `FK_Level` (`Level_Id`),
  CONSTRAINT `FK_Level` FOREIGN KEY (`Level_Id`) REFERENCES `TB_Level` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='Curse general information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_Curso`
--

LOCK TABLES `TB_Curso` WRITE;
/*!40000 ALTER TABLE `TB_Curso` DISABLE KEYS */;
INSERT INTO `TB_Curso` VALUES (3,'Curso 1','Vamos a probar el select de mas de una tabla','',3,3,0),(10,'Insert Curso.','Insercion del segundo curso en la base de datos. A ver si ahora podemos poner el alto de las celdas feten.','',10,1,0),(14,'Insert Curso numero 2','Insercion del segundo curso en la base de datos','',20,2,0);
/*!40000 ALTER TABLE `TB_Curso` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-14 13:46:49
