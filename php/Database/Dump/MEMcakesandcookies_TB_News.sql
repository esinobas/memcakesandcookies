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
-- Table structure for table `TB_News`
--

DROP TABLE IF EXISTS `TB_News`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TB_News` (
  `DateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'New timestamp of its last update',
  `Title` varchar(100) NOT NULL,
  `New` longtext NOT NULL,
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Title_UNIQUE` (`Title`),
  UNIQUE KEY `DateTime_UNIQUE` (`DateTime`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COMMENT='Table where the page web news are saved';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TB_News`
--

LOCK TABLES `TB_News` WRITE;
/*!40000 ALTER TABLE `TB_News` DISABLE KEYS */;
INSERT INTO `TB_News` VALUES ('2015-11-12 12:03:45','<p>Primera entrada en el blog<br></p>','<p>Esperemos que esta si que se la primera entrada definitiva.<br></p>',2),('2015-11-12 14:23:10','<p>Segunda entrada del blog<br></p>','<p>Que bien, ya por fin estamos insertando en blog, y ahora viene la segunda entrada, la cual, debe de insertar el principio del listbox el nombre de la entrada y cambiar el id del contenedor de las <strong>news </strong>o <strong>entradas del blog</strong><span data-mce-bogus=\"true\" id=\"_mce_caret\">ï»¿.</span><br></p><p><br data-mce-bogus=\"1\"></p>',3),('2015-11-12 14:26:37','<p>Tercera entrada del blog<br></p>','<p>Esta va viento en popa, ahora toca, modificar el id.<br></p>',4),('2015-11-12 14:38:40','<p>Cuarta entrada del blog<br></p>','<p>Si no se consigue ahora, intentarÃ© el <strong>clonar</strong> el elemento y cambiarlo ahÃ­ antes de insertarlo en el listbox<br data-mce-bogus=\"1\"></p>',5),('2015-11-12 15:17:12','<p>Sexta Entrada en el blog<br></p>','<p>Esta es la sexta entrada en el blog.<br>Espero que se la Ãºltima insercciÃ³n y que lo proximo sea modifcaciones.<br></p><p>Lo que pretendo ahora, es que esta nueva entrada, tenga sus eventos bien definidos y se pueda mover el usuario por las distintas entradas si problemas.<br data-mce-bogus=\"1\"></p><p><br data-mce-bogus=\"1\"></p><p data-mce-style=\"text-align: center;\" style=\"text-align: center;\">Vamos a ver<br data-mce-bogus=\"1\"></p>',6),('2015-12-04 10:54:30','<p>Quinta entrada en el blog<br></p>','<p>Esta es la quita entrada en el blog, que me la comi antes.<br></p><p>Espero que <strong>funcione</strong> y quede bonito<br data-mce-bogus=\"1\"></p>',7),('2015-11-24 14:32:26','<p>Septima entrada<br></p>','<p>vamos a ver el alert<br></p><p><img data-mce-style=\"float: left;\" style=\"float: left;\" src=\"http://memcakesandcookies/images/cakes/tarta campanilla 007.jpg\" alt=\"Casa de Campanilla\" data-mce-src=\"../images/cakes/tarta campanilla 007.jpg\" width=\"167\" height=\"224\"></p><p>&nbsp;Esto funcion de maravilla, espero que le guste.<br></p>',8),('2015-12-04 10:32:05','<p>Octava entrada<br></p>','<p>Vamos a por la 8Âª<br></p><p><br></p><p>Quiero poner una immagen</p><p><img caption=\"false\" data-mce-src=\"../images/cakes/Mini tartas 013.jpg\" src=\"../images/cakes/Mini tartas 013.jpg\" alt=\"Tarta de moras\" width=\"170\" height=\"170\">Me gusta como queda, el poder escribir al lado de la imagen.<br></p><p>La&nbsp; verdad que&nbsp; mola<br></p><p>&nbsp;<br></p><p>&nbsp;<br></p><p>&nbsp;<br></p><p>Voy a probar la&nbsp; otra opcion en otra entrada del blog.</p>',9),('2015-10-05 10:54:03','<p>a Seguir buscando<br></p>','<p>A la busqueda, que cosa mas rara<br></p><p>no me lo esta ordenando<br data-mce-bogus=\"1\"></p><p><br data-mce-bogus=\"1\"></p>',17),('2015-10-05 10:52:33','<p>A ver cuantas, so so<br></p>','<p>A ver cuantos selected tenemos ????<br></p>',18),('2015-10-05 10:49:00','<p>Ultima prueba<br></p>','<p>Vamos a probar esta chapuza, a ver que ocurre<br></p>',19),('2015-10-05 11:09:45','<p>Una solo.<br></p>','<p>Una solo.<br></p><p>No lo entiendo.<br data-mce-bogus=\"1\"></p>',21);
/*!40000 ALTER TABLE `TB_News` ENABLE KEYS */;
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
