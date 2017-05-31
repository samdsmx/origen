CREATE DATABASE  IF NOT EXISTS `origen` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `origen`;
-- MySQL dump 10.15  Distrib 10.0.29-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.13-MariaDB

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
-- Table structure for table `campos`
--

DROP TABLE IF EXISTS `campos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campos` (
  `Nombre` varchar(50) NOT NULL DEFAULT '',
  `Tipo` varchar(50) NOT NULL DEFAULT '',
  `activo` int(11) DEFAULT NULL,
  PRIMARY KEY (`Nombre`,`Tipo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campos`
--

LOCK TABLES `campos` WRITE;
/*!40000 ALTER TABLE `campos` DISABLE KEYS */;
/*!40000 ALTER TABLE `campos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `casos`
--

DROP TABLE IF EXISTS `casos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `casos` (
  `IDCaso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(70) DEFAULT NULL,
  `Edad` int(3) DEFAULT '0',
  `EstadoCivil` varchar(20) DEFAULT NULL,
  `Telefono` varchar(30) DEFAULT NULL,
  `Municipio` tinytext,
  `Estado` varchar(40) DEFAULT NULL,
  `Ocupacion` text,
  `Religion` varchar(20) DEFAULT NULL,
  `VivesCon` text,
  `ComoTeEnteraste` text,
  `tipocaso` text,
  `PosibleSolucion` text,
  `Estatus` text,
  `HorasInvertidas` smallint(5) DEFAULT NULL,
  `Sexo` varchar(1) DEFAULT NULL,
  `NivelEstudios` varchar(50) DEFAULT NULL,
  `LenguaIndigena` varchar(2) DEFAULT NULL,
  `CP` varchar(5) DEFAULT NULL,
  `Colonia` tinytext,
  `CorreoElectronico` tinytext,
  `MedioContacto` tinytext,
  `Pais` varchar(45) DEFAULT 'México',
  PRIMARY KEY (`IDCaso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `casos`
--

LOCK TABLES `casos` WRITE;
/*!40000 ALTER TABLE `casos` DISABLE KEYS */;
/*!40000 ALTER TABLE `casos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogocp`
--

DROP TABLE IF EXISTS `catalogocp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogocp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CP` varchar(5) DEFAULT NULL,
  `Estado` varchar(40) DEFAULT NULL,
  `Municipio` varchar(60) DEFAULT NULL,
  `Colonia` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogocp`
--

LOCK TABLES `catalogocp` WRITE;
/*!40000 ALTER TABLE `catalogocp` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogocp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consejeros`
--

DROP TABLE IF EXISTS `consejeros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consejeros` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `acceso` int(1) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_usuario`),
  KEY `SIA_USUARIO_SIA_PERSONA` (`id_persona`),
  CONSTRAINT `SIA_USUARIO_SIA_PERSONA` FOREIGN KEY (`id_persona`) REFERENCES `sia_persona` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consejeros`
--

LOCK TABLES `consejeros` WRITE;
/*!40000 ALTER TABLE `consejeros` DISABLE KEYS */;
INSERT INTO `consejeros` VALUES (1,1,'angel','$2y$10$pYh9dEPUw.CqYW8y9n5gIOF0JS3O8iKeBbJeh8ol/nQ6k33FpPlle',1,NULL,NULL,'2017-05-24 05:51:41','2017-05-24 05:51:41'),(9,9,'sergio','$2y$10$fXk71K.K1zf5.L7p91bIpOZZdAITvQxknqniR47WMPbMwt7MBPzYy',1,NULL,NULL,'2016-04-22 02:48:40','2016-04-22 07:50:09'),(10,10,'iaguirrem','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:42','2016-05-12 00:31:42'),(11,11,'adangeles','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:44','2016-05-12 00:31:44'),(12,12,'abachavez','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:45','2016-05-12 00:31:45'),(13,13,'cruizj','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:45','2016-05-12 00:31:45'),(14,14,'espinosagonzalezdaniel','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:46','2016-05-12 00:31:46'),(15,15,'drodriguez','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:47','2016-05-12 00:31:47'),(16,16,'dtobon','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:47','2016-05-12 00:31:47'),(17,17,'efcruz','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:48','2016-05-12 00:31:48'),(18,18,'elopezc','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:48','2016-05-12 00:31:48'),(19,19,'fhgarciaa','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:49','2016-05-12 00:31:49'),(20,20,'garciniegaa','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:50','2016-05-12 00:31:50'),(21,21,'bmenad','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:50','2016-05-12 00:31:50'),(22,22,'cescamilla','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:51','2016-05-12 00:31:51'),(23,23,'iramirezg','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:52','2016-05-12 00:31:52'),(24,24,'operacioncec','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:52','2016-05-12 00:31:52'),(25,25,'iaguirrem','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:53','2016-05-12 00:31:53'),(26,26,'jlopeza','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:54','2016-05-12 00:31:54'),(27,27,'fdelafue','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:55','2016-05-12 00:31:55'),(28,28,'JBAUTISTAM','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:56','2016-05-12 00:31:56'),(29,29,'jfrutero','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:56','2016-05-12 00:31:56'),(30,30,'jlsanchez','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:57','2016-05-12 00:31:57'),(31,31,'lsalazara','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:58','2016-05-12 00:31:58'),(32,32,'ltlatelpa','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:59','2016-05-12 00:31:59'),(33,33,'jteloxa','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:31:59','2016-05-12 00:31:59'),(34,34,'pcervanteso','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:00','2016-05-12 00:32:00'),(35,35,'rgarciac','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:01','2016-05-12 00:32:01'),(36,36,'rteranr','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:02','2016-05-12 00:32:02'),(37,37,'rortizva','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:02','2016-05-12 00:32:02'),(38,38,'rluna','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:03','2016-05-12 00:32:03'),(39,39,'ragarciac','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:04','2016-05-12 00:32:04'),(40,40,'rpalacioss','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:05','2016-05-12 00:32:05'),(41,41,'svargasc','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:09','2016-05-12 00:32:09'),(42,42,'segutierrez','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:10','2016-05-12 00:32:10'),(43,43,'smarquezs','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:11','2016-05-12 00:32:11'),(44,44,'smelendezc','$2y$10$GzlttC6KqMoFPt5vnMBix.1cR1EYSeatjJ.K8qu9p7WvSIvTzYC1K',1,NULL,NULL,'2016-05-12 00:32:12','2016-05-12 00:32:12');
/*!40000 ALTER TABLE `consejeros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `llamadas`
--

DROP TABLE IF EXISTS `llamadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `llamadas` (
  `IDCaso` int(10) unsigned NOT NULL,
  `LlamadaNo` smallint(6) DEFAULT NULL,
  `FechaLlamada` date DEFAULT NULL,
  `Consejera` varchar(70) DEFAULT NULL,
  `Horainicio` time DEFAULT NULL,
  `Horatermino` time DEFAULT NULL,
  `ComentariosAdicionales` text,
  `AyudaPsicologico` text,
  `AyudaLegal` text,
  `AyudaMedica` text,
  `AyudaOtros` text,
  `DesarrolloCaso` text,
  `CanaLegal` text,
  `CanaOtro` text,
  `Duracion` smallint(5) DEFAULT NULL,
  `Acceso` smallint(1) DEFAULT NULL,
  `TipoViolencia` text,
  `ModalidadViolencia` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `llamadas`
--

LOCK TABLES `llamadas` WRITE;
/*!40000 ALTER TABLE `llamadas` DISABLE KEYS */;
/*!40000 ALTER TABLE `llamadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organismos`
--

DROP TABLE IF EXISTS `organismos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organismos` (
  `ID` smallint(5) unsigned NOT NULL,
  `Tema` text,
  `Objetivo` text,
  `Institucion` text,
  `Estado` varchar(50) DEFAULT NULL,
  `Direccion` text,
  `Referencia` text,
  `Telefono` text,
  `Email` text,
  `Observaciones` text,
  `Requisitos` text,
  `HorariosCostos` text,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organismos`
--

LOCK TABLES `organismos` WRITE;
/*!40000 ALTER TABLE `organismos` DISABLE KEYS */;
/*!40000 ALTER TABLE `organismos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte`
--

DROP TABLE IF EXISTS `reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte` (
  `IDCaso` int(10) unsigned NOT NULL,
  `LlamadaNo` smallint(6) DEFAULT NULL,
  `FechaLlamada` date DEFAULT NULL,
  `Consejera` varchar(70) DEFAULT NULL,
  `Horainicio` time DEFAULT NULL,
  `Horatermino` time DEFAULT NULL,
  `ComentariosAdicionales` text,
  `AyudaPsicologico` text,
  `AyudaLegal` text,
  `AyudaMedica` text,
  `AyudaOtros` text,
  `DesarrolloCaso` text,
  `CanaLegal` text,
  `CanaOtro` text,
  `Duracion` smallint(5) DEFAULT NULL,
  `Acceso` smallint(1) DEFAULT NULL,
  `TipoViolencia` text,
  `ModalidadViolencia` text,
  `Edad` int(3) DEFAULT '0',
  `Religion` varchar(20) DEFAULT NULL,
  `Sexo` varchar(1) DEFAULT NULL,
  `Municipio` tinytext,
  `EstadoCivil` varchar(20) DEFAULT NULL,
  `Estado` varchar(40) DEFAULT NULL,
  `Ocupacion` text,
  `ComoTeEnteraste` text,
  `MedioContacto` tinytext,
  `CP` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte`
--

LOCK TABLES `reporte` WRITE;
/*!40000 ALTER TABLE `reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sia_aso_usuario_actividad`
--

DROP TABLE IF EXISTS `sia_aso_usuario_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sia_aso_usuario_actividad` (
  `id_usuario_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_usuario_actividad`),
  KEY `SIA_ASO_USUARIO_PROPIEDAD_SIA_ACTIVIDAD` (`id_actividad`),
  KEY `SIA_ASO_USUARIO_PROPIEDAD_SIA_USUARIO` (`id_usuario`),
  CONSTRAINT `SIA_ASO_USUARIO_PROPIEDAD_SIA_ACTIVIDAD` FOREIGN KEY (`id_actividad`) REFERENCES `sia_cat_actividad` (`id_actividad`),
  CONSTRAINT `SIA_ASO_USUARIO_PROPIEDAD_SIA_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `consejeros` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sia_aso_usuario_actividad`
--

LOCK TABLES `sia_aso_usuario_actividad` WRITE;
/*!40000 ALTER TABLE `sia_aso_usuario_actividad` DISABLE KEYS */;
INSERT INTO `sia_aso_usuario_actividad` VALUES (1,NULL,NULL,1,1,0,'2016-05-03 22:52:55','2016-05-04 03:52:55'),(2,NULL,NULL,1,2,1,'2015-12-17 04:25:14','2015-12-17 04:25:14'),(3,NULL,NULL,1,3,0,'2016-04-12 01:45:48','2016-04-12 06:40:44'),(4,NULL,NULL,1,4,0,'2016-03-02 01:37:51','2016-03-02 07:37:47'),(5,NULL,NULL,1,5,0,'2016-03-01 15:14:20','2016-03-01 21:14:16'),(6,NULL,NULL,1,7,0,'2016-05-12 01:18:28','2016-02-27 08:17:42'),(7,NULL,NULL,1,8,0,'2016-05-12 01:18:30','2016-04-12 06:47:55'),(8,NULL,NULL,1,9,0,'2016-05-12 01:18:30','2016-04-13 06:08:05'),(9,NULL,NULL,1,6,0,'2016-05-12 01:18:30','2016-04-12 06:40:26'),(10,NULL,NULL,1,7,0,'2016-05-12 01:18:30','2016-04-12 06:39:13'),(11,NULL,NULL,1,10,0,'2016-05-12 01:18:30','2016-04-12 06:15:07'),(12,NULL,NULL,1,3,1,'2016-05-12 01:18:30','2016-04-12 06:49:21'),(13,NULL,NULL,1,4,1,'2016-05-12 01:18:30','2016-04-12 06:51:57'),(14,NULL,NULL,1,5,1,'2016-05-12 01:18:30','2016-04-12 06:52:51'),(15,NULL,NULL,1,6,1,'2016-05-12 01:18:30','2016-04-12 06:53:14'),(16,NULL,NULL,1,7,1,'2016-05-12 01:18:30','2016-04-13 06:26:08'),(17,NULL,NULL,1,8,1,'2016-05-12 01:18:30','2016-04-13 06:26:16'),(18,NULL,NULL,1,9,1,'2016-05-12 01:18:30','2016-04-13 06:26:24'),(19,NULL,NULL,1,10,0,'2016-05-12 01:18:30','2016-04-30 08:06:35'),(20,NULL,NULL,1,10,1,'2016-05-12 01:18:30','2016-04-30 08:06:43'),(21,NULL,NULL,1,1,1,'2016-05-12 01:18:30','2016-05-04 07:03:47'),(22,NULL,NULL,10,8,1,'2016-05-12 01:22:20','2016-05-12 01:22:20'),(23,NULL,NULL,11,8,1,'2016-05-12 01:23:15','2016-05-12 01:23:15'),(24,NULL,NULL,12,8,1,'2016-05-12 01:23:20','2016-05-12 01:23:20'),(25,NULL,NULL,13,8,1,'2016-05-12 01:23:22','2016-05-12 01:23:22'),(26,NULL,NULL,14,8,1,'2016-05-12 01:23:23','2016-05-12 01:23:23'),(27,NULL,NULL,15,8,1,'2016-05-12 01:23:25','2016-05-12 01:23:25'),(28,NULL,NULL,16,8,1,'2016-05-12 01:23:26','2016-05-12 01:23:26'),(29,NULL,NULL,17,8,1,'2016-05-12 01:23:27','2016-05-12 01:23:27'),(30,NULL,NULL,18,8,1,'2016-05-12 01:23:27','2016-05-12 01:23:27'),(31,NULL,NULL,19,8,1,'2016-05-12 01:23:28','2016-05-12 01:23:28'),(32,NULL,NULL,20,8,1,'2016-05-12 01:23:29','2016-05-12 01:23:29'),(33,NULL,NULL,21,8,1,'2016-05-12 01:23:30','2016-05-12 01:23:30'),(34,NULL,NULL,22,8,1,'2016-05-12 01:23:31','2016-05-12 01:23:31'),(35,NULL,NULL,23,8,1,'2016-05-12 01:23:31','2016-05-12 01:23:31'),(36,NULL,NULL,24,8,1,'2016-05-12 01:23:32','2016-05-12 01:23:32'),(37,NULL,NULL,25,8,1,'2016-05-12 01:23:33','2016-05-12 01:23:33'),(38,NULL,NULL,26,8,1,'2016-05-12 01:23:34','2016-05-12 01:23:34'),(39,NULL,NULL,27,8,1,'2016-05-12 01:23:35','2016-05-12 01:23:35'),(40,NULL,NULL,28,8,1,'2016-05-12 01:23:35','2016-05-12 01:23:35'),(41,NULL,NULL,29,8,1,'2016-05-12 01:23:36','2016-05-12 01:23:36'),(42,NULL,NULL,30,8,1,'2016-05-12 01:23:37','2016-05-12 01:23:37'),(43,NULL,NULL,31,8,1,'2016-05-12 01:23:38','2016-05-12 01:23:38'),(44,NULL,NULL,32,8,1,'2016-05-12 01:23:38','2016-05-12 01:23:38'),(45,NULL,NULL,33,8,1,'2016-05-12 01:23:39','2016-05-12 01:23:39'),(46,NULL,NULL,34,8,1,'2016-05-12 01:23:40','2016-05-12 01:23:40'),(47,NULL,NULL,35,8,1,'2016-05-12 01:23:41','2016-05-12 01:23:41'),(48,NULL,NULL,36,8,1,'2016-05-12 01:23:42','2016-05-12 01:23:42'),(49,NULL,NULL,37,8,1,'2016-05-12 01:23:42','2016-05-12 01:23:42'),(50,NULL,NULL,38,8,1,'2016-05-12 01:23:43','2016-05-12 01:23:43'),(51,NULL,NULL,39,8,1,'2016-05-12 01:23:44','2016-05-12 01:23:44'),(52,NULL,NULL,40,8,1,'2016-05-12 01:23:45','2016-05-12 01:23:45'),(53,NULL,NULL,41,8,1,'2016-05-12 01:23:45','2016-05-12 01:23:45'),(54,NULL,NULL,42,8,1,'2016-05-12 01:23:46','2016-05-12 01:23:46'),(55,NULL,NULL,43,8,1,'2016-05-12 01:23:47','2016-05-12 01:23:47'),(56,NULL,NULL,44,8,1,'2016-05-12 01:23:48','2016-05-12 01:23:48');
/*!40000 ALTER TABLE `sia_aso_usuario_actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sia_cat_actividad`
--

DROP TABLE IF EXISTS `sia_cat_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sia_cat_actividad` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `descripcion` text NOT NULL,
  `icono` varchar(20) NOT NULL,
  `url` varchar(45) NOT NULL,
  `color` varchar(10) NOT NULL,
  PRIMARY KEY (`id_actividad`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sia_cat_actividad`
--

LOCK TABLES `sia_cat_actividad` WRITE;
/*!40000 ALTER TABLE `sia_cat_actividad` DISABLE KEYS */;
INSERT INTO `sia_cat_actividad` VALUES (1,'Actividades',1,'2016-03-30 03:42:17','2016-03-19 09:48:08','Gestión de actividades del sistema','fa fa-list','/Actividades','#c70039'),(2,'Permisos de usuario',1,'2016-03-30 03:42:17','2015-12-17 04:22:12','Gestión de permisos/actividades asignados a cada usuarios','fa fa-lock','/PermisosUsuarios','#57c785'),(3,'Secciones del cuestionario',1,'2016-03-30 03:42:17','2015-12-17 04:22:22','Aquí podrás gestionar las secciones en las que se divide el cuestionario de cada sistema','fa fa-archive','/Grupos','#ff5733'),(4,'Periodos',1,'2016-03-30 03:42:17','2015-12-17 04:22:31','Administración de los periodos para el registro de aplicativos en el sistema','fa fa-clock-o','/Periodos','#00baad'),(5,'Preguntas del cuestionario',1,'2016-03-30 03:42:17','2015-12-17 04:23:14','En esta sección podrás administrar las preguntas que se hacen sobre los aplicativos','fa fa-question','/Propiedades','#ff8d1a'),(6,'Unidades Responsables',1,'2016-03-30 03:42:17','2015-12-17 04:23:26','Catálogo de las Unidades Responsables del sistema','fa fa-building','/UnidadesResponsables','#2a7b9b'),(7,'Usuarios',1,'2016-04-12 01:14:38','2016-04-12 06:09:33','Gestión de Usuarios del SIA','fa fa-users','/ActividadesUsuario','#ffc300'),(8,'Mis Sistemas',1,'2016-04-12 01:31:49','2016-04-12 06:26:44','Gestión de Captura, Actualización o Modificación de mis sistemas ','fa fa-book','/MisSistemas','#3d3d6b'),(9,'Consultas',1,'2016-04-07 04:29:59','2016-04-07 09:25:02','Sección de consultas y reportes','fa fa-binoculars','/Consultas','#add45c'),(10,'Reportes',1,'2016-05-03 22:49:10','2016-05-04 03:49:10','Dashboard Data Warehouse','fa fa-tachometer','/Reportes','#900c3f');
/*!40000 ALTER TABLE `sia_cat_actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sia_persona`
--

DROP TABLE IF EXISTS `sia_persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sia_persona` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT,
  `primer_apellido` varchar(45) NOT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `nombres` varchar(70) NOT NULL,
  `curp` varchar(18) DEFAULT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sia_persona`
--

LOCK TABLES `sia_persona` WRITE;
/*!40000 ALTER TABLE `sia_persona` DISABLE KEYS */;
INSERT INTO `sia_persona` VALUES (1,'ANDRADE','CHAVEZ','ANGEL','AACA920529HDFNHN01','abachavez@gmail.com','51585',1,'2017-05-21 16:56:13','2016-04-27 04:40:11'),(9,'marquez','de silva','sergio','MASS810908HDFRLR05','samdsmx@hotmail.com','51584',1,'2016-04-22 07:49:54','2016-04-22 07:49:54'),(10,'Israel','Aguirre','Martinez',NULL,'iaguirrem@ipn.mx','null',1,'2016-05-12 00:24:34','2016-05-12 00:24:34'),(11,'Adrian David','Angeles','Espinosa',NULL,'adangeles@ipn.mx','null',1,'2016-05-12 00:24:36','2016-05-12 00:24:36'),(12,'Angel','Andrade','',NULL,'abachavez@gmail.com','null',1,'2016-05-12 00:24:37','2016-05-12 00:24:37'),(13,'Carlos','Ruiz','Juárez',NULL,'cruizj@ipn.mx','null',1,'2016-05-12 00:24:38','2016-05-12 00:24:38'),(14,'Daniel','Espinosa','',NULL,'espinosagonzalezdaniel@gmail.com','null',1,'2016-05-12 00:24:39','2016-05-12 00:24:39'),(15,'David','Rodríguez','Hernández',NULL,'drodriguez@ipn.mx','null',1,'2016-05-12 00:24:39','2016-05-12 00:24:39'),(16,'David','Tobón','Sánchez',NULL,'dtobon@ipn.mx','null',1,'2016-05-12 00:24:40','2016-05-12 00:24:40'),(17,'Efren','Cruz','Carlin',NULL,'efcruz@ipn.mx','null',1,'2016-05-12 00:24:41','2016-05-12 00:24:41'),(18,'Ernesto','López','Caballero',NULL,'elopezc@ipn.mx','null',1,'2016-05-12 00:24:41','2016-05-12 00:24:41'),(19,'Francisco Hiram','García','Alonso',NULL,'fhgarciaa@ipn.mx','null',1,'2016-05-12 00:24:42','2016-05-12 00:24:42'),(20,'Gabriel','Arciniega','Aguilar',NULL,'garciniegaa@ipn.mx','null',1,'2016-05-12 00:24:43','2016-05-12 00:24:43'),(21,'Betsy Pamela','Mena','Díaz',NULL,'bmenad@ipn.mx','null',1,'2016-05-12 00:24:44','2016-05-12 00:24:44'),(22,'Carlos Alberto','Escamilla','Molina',NULL,'cescamilla@ipn.mx','null',1,'2016-05-12 00:24:44','2016-05-12 00:24:44'),(23,'Iris Noemí','Ramírez','García',NULL,'iramirezg@ipn.mx','null',1,'2016-05-12 00:24:45','2016-05-12 00:24:45'),(24,'Isaías','Contreras','Martínez',NULL,'operacioncec@gmail.com','null',1,'2016-05-12 00:24:46','2016-05-12 00:24:46'),(25,'Israel','Aguirre','Martinez',NULL,'iaguirrem@ipn.mx','null',1,'2016-05-12 00:24:47','2016-05-12 00:24:47'),(26,'Jaime','López','Alanis',NULL,'jlopeza@ipn.mx','null',1,'2016-05-12 00:24:47','2016-05-12 00:24:47'),(27,'Jorge Fernando','De La Fuente','Martinez',NULL,'fdelafue@ipn.mx','null',1,'2016-05-12 00:24:48','2016-05-12 00:24:48'),(28,'Juan Carlos','Bautista','Martinez',NULL,'JBAUTISTAM@IPN.MX','null',1,'2016-05-12 00:24:49','2016-05-12 00:24:49'),(29,'Juana Virginia','Frutero','Blancas',NULL,'jfrutero@ipn.mx','null',1,'2016-05-12 00:24:50','2016-05-12 00:24:50'),(30,'Julia Leticia','Sánchez','Sánchez',NULL,'jlsanchez@ipn.mx','null',1,'2016-05-12 00:24:51','2016-05-12 00:24:51'),(31,'Liliana','Salazar','',NULL,'lsalazara@ipn.mx','null',1,'2016-05-12 00:24:51','2016-05-12 00:24:51'),(32,'Luis Alberto','Tlatelpa','Fonseca',NULL,'ltlatelpa@ipn.mx','null',1,'2016-05-12 00:24:52','2016-05-12 00:24:52'),(33,'Ma. Julia','Teloxa','Flores',NULL,'jteloxa@ipn.mx','null',1,'2016-05-12 00:24:53','2016-05-12 00:24:53'),(34,'Perla Xochitl','Cervantes','Orozco',NULL,'pcervanteso@ipn.mx','null',1,'2016-05-12 00:24:54','2016-05-12 00:24:54'),(35,'Raúl Austreberto','García','Cárdenas',NULL,'rgarciac@ipn.mx','null',1,'2016-05-12 00:24:54','2016-05-12 00:24:54'),(36,'Reynaldo','Terán','Rodríguez',NULL,'rteranr@ipn.mx','null',1,'2016-05-12 00:24:55','2016-05-12 00:24:55'),(37,'Ricardo','Ortiz','Valenzuela',NULL,'rortizva@ipn.mx','null',1,'2016-05-12 00:24:56','2016-05-12 00:24:56'),(38,'Roberto','Luna','Elizondo',NULL,'rluna@ipn.mx','null',1,'2016-05-12 00:24:57','2016-05-12 00:24:57'),(39,'Rocio Aidé','García','Cárdenas',NULL,'ragarciac@ipn.mx','null',1,'2016-05-12 00:24:57','2016-05-12 00:24:57'),(40,'Rocío','Palacios','Solano',NULL,'rpalacioss@ipn.mx','null',1,'2016-05-12 00:24:58','2016-05-12 00:24:58'),(41,'Saúl Israel','Vargas','Camacho',NULL,'svargasc@ipn.mx','null',1,'2016-05-12 00:24:59','2016-05-12 00:24:59'),(42,'Sebastián','Gutiérrez','Flores',NULL,'segutierrez@ipn.mx','null',1,'2016-05-12 00:24:59','2016-05-12 00:24:59'),(43,'Sergio Antonio','Marquez','De Silva',NULL,'smarquezs@ipn.mx','null',1,'2016-05-12 00:25:00','2016-05-12 00:25:00'),(44,'Sergio','Meléndez','César',NULL,'smelendezc@ipn.mx','null',1,'2016-05-12 00:25:01','2016-05-12 00:25:01');
/*!40000 ALTER TABLE `sia_persona` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-29 11:38:36
