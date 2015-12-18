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
-- Table structure for table `TB_COLLECTION`
--

DROP TABLE IF EXISTS `TB_COLLECTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TB_COLLECTION` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifier',
  `Name` varchar(45) NOT NULL COMMENT 'Collection name',
  `Id_Menu` int(11) NOT NULL COMMENT 'Foreign key to TB_MENU',
  PRIMARY KEY (`Id`),
  KEY `FK_MENU` (`Id_Menu`),
  CONSTRAINT `FK_MENU` FOREIGN KEY (`Id_Menu`) REFERENCES `TB_MENU` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COMMENT='Table where the collection are stored and its link with the ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_COLLECTION`
--

LOCK TABLES `TB_COLLECTION` WRITE;
/*!40000 ALTER TABLE `TB_COLLECTION` DISABLE KEYS */;
INSERT INTO `TB_COLLECTION` VALUES (2,'Bodas',2),(3,'Navidad',2),(4,'Flores',2),(5,'Animales',2),(6,'Don Algodon',3),(12,'Bebes',3),(13,'Test Galleria',2),(14,'Navidad',4),(15,'Flores',4),(16,'Prueba 1',4),(18,'Nueva ColecciÃ³n',2),(19,'Nueva ColecciÃ³n 2',2),(20,'ColecciÃ³n definitiva',2),(21,'ColecciÃ³n de cookies',3),(22,'ColecciÃ³n cookies 2',3),(23,'ColecciÃ³n de Cookies 3',3),(24,'ColecciÃ³n definitiva',3),(25,'ColecciÃ³n modelados',4),(26,'ColecciÃ³n modelados 2',4),(27,'ColecciÃ³n definitiva',4);
/*!40000 ALTER TABLE `TB_COLLECTION` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-18 11:47:08
