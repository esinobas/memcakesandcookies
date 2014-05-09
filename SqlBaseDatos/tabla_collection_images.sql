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
-- Table structure for table `TB_COLLECTION_IMAGES`
--

DROP TABLE IF EXISTS `TB_COLLECTION_IMAGES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TB_COLLECTION_IMAGES` (
  `Id_Image` int(11) NOT NULL,
  `Id_Collection` int(11) NOT NULL,
  PRIMARY KEY (`Id_Image`,`Id_Collection`),
  KEY `FK_IMAGES` (`Id_Image`),
  KEY `FK_COLLECTION` (`Id_Collection`),
  CONSTRAINT `FK_IMAGES` FOREIGN KEY (`Id_Image`) REFERENCES `TB_IMAGES` (`Type`) ON UPDATE CASCADE,
  CONSTRAINT `FK_COLLECTION` FOREIGN KEY (`Id_Collection`) REFERENCES `TB_COLLECTION` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relationship between tables TB_IMAGES and TB_COLLECTION';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_COLLECTION_IMAGES`
--

LOCK TABLES `TB_COLLECTION_IMAGES` WRITE;
/*!40000 ALTER TABLE `TB_COLLECTION_IMAGES` DISABLE KEYS */;
/*!40000 ALTER TABLE `TB_COLLECTION_IMAGES` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-07 16:04:14
