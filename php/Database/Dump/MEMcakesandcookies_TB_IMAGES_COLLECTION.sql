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
-- Table structure for table `TB_IMAGES_COLLECTION`
--

DROP TABLE IF EXISTS `TB_IMAGES_COLLECTION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TB_IMAGES_COLLECTION` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `CollectionId` int(11) NOT NULL,
  `Path` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `TypeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `IdxUniqueLocal` (`CollectionId`,`Path`),
  KEY `FK_ImageType` (`TypeId`),
  CONSTRAINT `FK_CollectionImage` FOREIGN KEY (`CollectionId`) REFERENCES `TB_COLLECTION` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_ImageType` FOREIGN KEY (`TypeId`) REFERENCES `TB_TYPES` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COMMENT='Table where the file path and name and the collection belong';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_IMAGES_COLLECTION`
--

LOCK TABLES `TB_IMAGES_COLLECTION` WRITE;
/*!40000 ALTER TABLE `TB_IMAGES_COLLECTION` DISABLE KEYS */;
INSERT INTO `TB_IMAGES_COLLECTION` VALUES (6,2,'images/cakes/la foto 3.JPG','Frutas del bosque',1),(7,2,'images/cakes/la foto 3(3).JPG','Gato 1',1),(8,2,'images/cakes/la foto 3(4).JPG','Gato 2',1),(10,2,'images/cakes/tarta campanilla 007.jpg','Campanilla 1',1),(11,2,'images/cakes/la foto 1.JPG','Maceta',1),(16,2,'images/cakes/la foto 4.JPG','MÃ¡s Frutas',1),(17,19,'images/cakes/Mini tartas 001.jpg','Tarta con Mariposa',1),(18,19,'images/cakes/Mini tartas 013.jpg','Tarta con moras',1),(20,18,'images/cakes/Mini tartas 011.jpg','Tarta con flores',1),(21,20,'images/cakes/Mini tartas 003.jpg','Tarta con Mariposas',1),(22,2,'images/cakes/la foto 3(2).JPG','Gato',1),(24,2,'images/cakes/Mini tartas 007.jpg','Tarta con libelula',1),(25,13,'images/cakes/Tarta de comunion.jpg','Tarta ComuniÃ³n',1),(26,5,'images/cakes/la foto 1(5).JPG','Gato',1),(27,4,'images/cakes/la foto 3(1).JPG','Maceta flores',1),(28,3,'images/cakes/tarta arbol navidad.JPG','Arbol Navidad y Osos',1),(29,12,'images/cookies/bebes1.jpg','Pareja de bebes',2),(30,6,'images/cookies/galletas Don Algodon.JPG','Colonias Don AlgodÃ³n',2);
/*!40000 ALTER TABLE `TB_IMAGES_COLLECTION` ENABLE KEYS */;
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
