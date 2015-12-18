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
  `DataType` varchar(45) NOT NULL DEFAULT 'String' COMMENT 'This column is used for indicate the data type. Its possible values are:\nString\nNumeric\nDirectory\nFile\nActivate\nBoolean',
  PRIMARY KEY (`Property`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_CONFIGURATION`
--

LOCK TABLES `TB_CONFIGURATION` WRITE;
/*!40000 ALTER TABLE `TB_CONFIGURATION` DISABLE KEYS */;
INSERT INTO `TB_CONFIGURATION` VALUES ('cakesImagesPath','images/cakes','Directorio donde se guardan las fotos de las tartas','Directorio de Tartas','Directory'),('cookiesImagesPath','images/cookies','Directorio donde se guardan las fotos de las galletas','Directorio de Galletas','Directory'),('Facebook','https://www.facebook.com/MEM-Cakes-Cookies-259622654111131/','Dirección de tu página facebook','Dirección de facebook','String'),('Instagram','esinobas','Usuario del a cuenta de Instagram','Usuario Instagram','String'),('modelsImagesPath','images/modelados','Directorio donde se guardan las fotos de los modelados','Directorio de Modelados','Directory'),('numberThumbnails','3','Número de miniaturas por pagina','Número de miniaturas','Numeric'),('Path','cursos','Directorio donde se guarda la información de los cursos (Imagenes, videos, ...)','Directorio de Cursos','Directory'),('SlideImagesPath','images','Directorio donde buscar las imagnes del inicio','Directorio Imagenes Inicio','Directory'),('thumbnailsPath','/thumbnails','Nombre para el directorio de las miniaturas de las fotos','Directorio miniaturas','String'),('Time_between_steps','120','Tiempo que hay entre un paso y el siguiente en un curso.','Tiempo entre pasos','Numeric'),('Twitter','https://twitter.com/MEMCyC','Dirección de tu cuenta de twiter','Dirección tweeter','String'),('URL','http://memcakesandcookies/','URL donde esta alojada la pagina','URL','String');
/*!40000 ALTER TABLE `TB_CONFIGURATION` ENABLE KEYS */;
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
