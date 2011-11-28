-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: iCalendar
-- ------------------------------------------------------
-- Server version	5.5.16

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
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `calendarId` int(10) NOT NULL AUTO_INCREMENT,
  `calendarColorId` int(10) DEFAULT '0',
  `calendarTitle` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  `calendarDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isHidden` tinyint(4) NOT NULL DEFAULT '0',
  `staffId` int(10) DEFAULT NULL,
  PRIMARY KEY (`calendarId`),
  KEY `calendarColorId` (`calendarColorId`),
  KEY `staffId` (`staffId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` VALUES (1,1,'Work','',0,2),(2,2,'House','',0,2),(3,3,'unknown','',0,2),(4,4,'Personel Project','',0,2);
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendarcolor`
--

DROP TABLE IF EXISTS `calendarcolor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendarcolor` (
  `calendarColorId` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`calendarColorId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendarcolor`
--

LOCK TABLES `calendarcolor` WRITE;
/*!40000 ALTER TABLE `calendarcolor` DISABLE KEYS */;
INSERT INTO `calendarcolor` VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10);
/*!40000 ALTER TABLE `calendarcolor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `eventId` int(10) NOT NULL AUTO_INCREMENT,
  `calendarId` int(10) DEFAULT NULL,
  `eventTitle` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eventDesc` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `eventStart` datetime DEFAULT NULL,
  `eventEnd` datetime DEFAULT NULL,
  `eventLocation` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eventNotes` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eventUrl` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `eventIsAllDay` tinyint(4) NOT NULL DEFAULT '0',
  `eventIsNew` int(11) NOT NULL,
  `eventReminder` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `staffId` int(11) DEFAULT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `calendarId` (`calendarId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,1,'startin the multi db  system','','2011-11-15 00:00:00','2011-11-15 01:00:00','','','',0,0,'',2,'2011-11-27 14:59:11'),(2,1,'start mult system update doll b','','2011-11-16 00:00:00','2011-11-16 01:00:00','','','',0,0,'',2,'2011-11-27 14:59:32'),(5,1,'lalalaa','','2011-11-27 00:00:00','2011-11-27 00:00:00','','','',0,0,'',2,'2011-11-27 15:02:53');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-11-27 19:16:48
