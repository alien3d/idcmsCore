-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: iLog
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
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `logId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Log|',
  `leafId` int(11) NOT NULL COMMENT 'Leaf|',
  `operation` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Operation|',
  `sql` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Statement|',
  `date` datetime NOT NULL COMMENT 'Date|',
  `staffId` int(11) NOT NULL COMMENT 'Staff|',
  `access` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Access|',
  `logError` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Error|',
  PRIMARY KEY (`logId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logadvance`
--

DROP TABLE IF EXISTS `logadvance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logadvance` (
  `logAdvanceId` int(11) NOT NULL AUTO_INCREMENT,
  `logAdvanceText` text COLLATE utf8_unicode_ci NOT NULL,
  `logAdvanceType` enum('C','U','D') COLLATE utf8_unicode_ci NOT NULL COMMENT 'C-Create,U-update,D-delete',
  `logAdvanceComparision` text COLLATE utf8_unicode_ci NOT NULL,
  `refTableName` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `leafId` int(11) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`logAdvanceId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logadvance`
--

LOCK TABLES `logadvance` WRITE;
/*!40000 ALTER TABLE `logadvance` DISABLE KEYS */;
/*!40000 ALTER TABLE `logadvance` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-11-27 19:18:15
