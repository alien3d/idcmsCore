-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: icommon
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
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `districtId` int(11) NOT NULL AUTO_INCREMENT,
  `districtName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `stateId` int(11) NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` tinyint(1) NOT NULL,
  `executeTime` tinyint(1) NOT NULL,
  PRIMARY KEY (`districtId`),
  KEY `state_uniqueId` (`stateId`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (1,'Timur Laut P.Pinang',1,0,0,0,0,0,0,0,0,0,0,0),(2,'Seberang Prai Utara',1,0,0,0,0,0,0,0,0,0,0,0),(3,'Seberang Prai Tengah',1,0,0,0,0,0,0,0,0,0,0,0),(4,'Seberang Prai Selatan',1,0,0,0,0,0,0,0,0,0,0,0),(5,'Bukit Mertajam',1,0,0,0,0,0,0,0,0,0,0,0),(6,'Balik Pulau',1,0,0,0,0,0,0,0,0,0,0,0),(7,'Seberang Jaya',1,0,0,0,0,0,0,0,0,0,0,0),(8,'Kepala Batas',1,0,0,0,0,0,0,0,0,0,0,0),(9,'Kinta',2,0,0,0,0,0,0,0,0,0,0,0),(10,'Larut',2,0,0,0,0,0,0,0,0,0,0,0),(11,'Matang',2,0,0,0,0,0,0,0,0,0,0,0),(12,'Selama',2,0,0,0,0,0,0,0,0,0,0,0),(13,'Hilir Perak',2,0,0,0,0,0,0,0,0,0,0,0),(14,'Manjung',2,0,0,0,0,0,0,0,0,0,0,0),(15,'Batang Padang',2,0,0,0,0,0,0,0,0,0,0,0),(16,'Batu Gajah',2,0,0,0,0,0,0,0,0,0,0,0),(17,'Sg. Siput',2,0,0,0,0,0,0,0,0,0,0,0),(18,'Lambor Kanan',2,0,0,0,0,0,0,0,0,0,0,0),(19,'Seri Manjung',2,0,0,0,0,0,0,0,0,0,0,0),(20,'Grik',2,0,0,0,0,0,0,0,0,0,0,0),(21,'Slim River',2,0,0,0,0,0,0,0,0,0,0,0),(22,'Kampar',2,0,0,0,0,0,0,0,0,0,0,0),(23,'Kerian',2,0,0,0,0,0,0,0,0,0,0,0),(24,'Kuala Kangsar',2,0,0,0,0,0,0,0,0,0,0,0),(25,'Hulu Perak',2,0,0,0,0,0,0,0,0,0,0,0),(26,'Parit Buntar',2,0,0,0,0,0,0,0,0,0,0,0),(27,'Perak Tengah',2,0,0,0,0,0,0,0,0,0,0,0),(28,'Ipoh',2,0,0,0,0,0,0,0,0,0,0,0),(29,'Tapah',2,0,0,0,0,0,0,0,0,0,0,0),(30,'Teluk Intan',2,0,0,0,0,0,0,0,0,0,0,0),(31,'Taiping',2,0,0,0,0,0,0,0,0,0,0,0),(32,'Gombak',3,0,0,0,0,0,0,0,0,0,0,0),(33,'Hulu Langat',3,0,0,0,0,0,0,0,0,0,0,0),(34,'Hulu Selangor',3,0,0,0,0,0,0,0,0,0,0,0),(35,'Klang',3,0,0,0,0,0,0,0,0,0,0,0),(36,'Kuala Langat',3,0,0,0,0,0,0,0,0,0,0,0),(37,'Kuala Selangor',3,0,0,0,0,0,0,0,0,0,0,0),(38,'Petaling Jaya',3,0,0,0,0,0,0,0,0,0,0,0),(39,'Sabak Bernam',3,0,0,0,0,0,0,0,0,0,0,0),(40,'Sepang',3,0,0,0,0,0,0,0,0,0,0,0),(41,'Shah Alam',3,0,0,0,0,0,0,0,0,0,0,0),(42,'Putrajaya',5,0,0,0,0,0,0,0,0,0,0,0),(43,'Jelebu',6,0,0,0,0,0,0,0,0,0,0,0),(44,'Jempol',6,0,0,0,0,0,0,0,0,0,0,0),(45,'Kuala Pilah',6,0,0,0,0,0,0,0,0,0,0,0),(46,'Port Dickson',6,0,0,0,0,0,0,0,0,0,0,0),(47,'Rembau',6,0,0,0,0,0,0,0,0,0,0,0),(48,'Seremban',6,0,0,0,0,0,0,0,0,0,0,0),(49,'Tampin',6,0,0,0,0,0,0,0,0,0,0,0),(50,'Alor Gajah',7,0,0,0,0,0,0,0,0,0,0,0),(51,'Central Melaka',7,0,0,0,0,0,0,0,0,0,0,0),(52,'Jasin',7,0,0,0,0,0,0,0,0,0,0,0),(53,'Melaka Town',7,0,0,0,0,0,0,0,0,0,0,0),(54,'Batu Pahat',8,0,0,0,0,0,0,0,0,0,0,0),(55,'Johor Bharu',8,0,0,0,0,0,0,0,0,0,0,0),(56,'Kluang',8,0,0,0,0,0,0,0,0,0,0,0),(57,'Kota Tinggi',8,0,0,0,0,0,0,0,0,0,0,0),(58,'Kulai',8,0,0,0,0,0,0,0,0,0,0,0),(59,'Mersing',8,0,0,0,0,0,0,0,0,0,0,0),(60,'Muar',8,0,0,0,0,0,0,0,0,0,0,0),(61,'Pontian',8,0,0,0,0,0,0,0,0,0,0,0),(62,'Segamat',8,0,0,0,0,0,0,0,0,0,0,0),(63,'Tangkak',8,0,0,0,0,0,0,0,0,0,0,0),(64,'Bera',9,0,0,0,0,0,0,0,0,0,0,0),(65,'Bentong',9,0,0,0,0,0,0,0,0,0,0,0),(66,'Cameron Highlands',9,0,0,0,0,0,0,0,0,0,0,0),(67,'Jengka',9,0,0,0,0,0,0,0,0,0,0,0),(68,'Jerantut',9,0,0,0,0,0,0,0,0,0,0,0),(69,'Kuantan',9,0,0,0,0,0,0,0,0,0,0,0),(70,'Kuala Lipis',9,0,0,0,0,0,0,0,0,0,0,0),(71,'Maran',9,0,0,0,0,0,0,0,0,0,0,0),(72,'Mentakab',9,0,0,0,0,0,0,0,0,0,0,0),(73,'Muadzam',9,0,0,0,0,0,0,0,0,0,0,0),(74,'Pekan',9,0,0,0,0,0,0,0,0,0,0,0),(75,'Raub',9,0,0,0,0,0,0,0,0,0,0,0),(76,'Rompin',9,0,0,0,0,0,0,0,0,0,0,0),(77,'Temerloh',9,0,0,0,0,0,0,0,0,0,0,0),(78,'Besut',10,0,0,0,0,0,0,0,0,0,0,0),(79,'Dungun',10,0,0,0,0,0,0,0,0,0,0,0),(80,'Hulu Terengganu',10,0,0,0,0,0,0,0,0,0,0,0),(81,'Kemaman',10,0,0,0,0,0,0,0,0,0,0,0),(82,'Kuala Terengganu',10,0,0,0,0,0,0,0,0,0,0,0),(83,'Marang',10,0,0,0,0,0,0,0,0,0,0,0),(84,'Setiu',10,0,0,0,0,0,0,0,0,0,0,0),(93,'Bandar Tun Razak',4,0,0,0,0,0,0,0,0,0,0,0),(94,'Batu',4,0,0,0,0,0,0,0,0,0,0,0),(95,'Bukit Bintang',4,0,0,0,0,0,0,0,0,0,0,0),(96,'Cheras',4,0,0,0,0,0,0,0,0,0,0,0),(97,'Kepong',4,0,0,0,0,0,0,0,0,0,0,0),(98,'Lembah Pantai',4,0,0,0,0,0,0,0,0,0,0,0),(99,'Segamat',4,0,0,0,0,0,0,0,0,0,0,0),(100,'Seputeh',4,0,0,0,0,0,0,0,0,0,0,0),(101,'Setiawangsa',4,0,0,0,0,0,0,0,0,0,0,0),(102,'Titiwangsa',4,0,0,0,0,0,0,0,0,0,0,0),(103,'Wangsa Maju',4,0,0,0,0,0,0,0,0,0,0,0),(104,'Bachok',11,0,0,0,0,0,0,0,0,0,0,0),(105,'Gua Musang',11,0,0,0,0,0,0,0,0,0,0,0),(106,'Jeli',11,0,0,0,0,0,0,0,0,0,0,0),(107,'Kota Bharu',11,0,0,0,0,0,0,0,0,0,0,0),(108,'Kuala Krai',11,0,0,0,0,0,0,0,0,0,0,0),(109,'Machang',11,0,0,0,0,0,0,0,0,0,0,0),(110,'Pasir Mas',11,0,0,0,0,0,0,0,0,0,0,0),(111,'Pasir Puteh',11,0,0,0,0,0,0,0,0,0,0,0),(112,'Tanah Merah',11,0,0,0,0,0,0,0,0,0,0,0),(113,'Tumpat',11,0,0,0,0,0,0,0,0,0,0,0),(114,'Pantai Barat',12,0,0,0,0,0,0,0,0,0,0,0),(115,'Kudat',12,0,0,0,0,0,0,0,0,0,0,0),(116,'Sandakan',12,0,0,0,0,0,0,0,0,0,0,0),(117,'Tawau',12,0,0,0,0,0,0,0,0,0,0,0),(118,'Pedalaman',12,0,0,0,0,0,0,0,0,0,0,0),(119,'Kota Kinabalu',12,0,0,0,0,0,0,0,0,0,0,0),(120,'Beaufort',12,0,0,0,0,0,0,0,0,0,0,0),(121,'Beluran',12,0,0,0,0,0,0,0,0,0,0,0),(122,'Keningau',12,0,0,0,0,0,0,0,0,0,0,0),(123,'labuan',13,0,0,0,0,0,0,0,0,0,0,0),(124,'Betong',14,0,0,0,0,0,0,0,0,0,0,0),(125,'Bintulu',14,0,0,0,0,0,0,0,0,0,0,0),(126,'Kapit',14,0,0,0,0,0,0,0,0,0,0,0),(127,'Kuching',14,0,0,0,0,0,0,0,0,0,0,0),(128,'Limbang',14,0,0,0,0,0,0,0,0,0,0,0),(129,'Miri',14,0,0,0,0,0,0,0,0,0,0,0),(130,'Mukah',14,0,0,0,0,0,0,0,0,0,0,0),(131,'Samarahan',14,0,0,0,0,0,0,0,0,0,0,0),(132,'Sarikei',14,0,0,0,0,0,0,0,0,0,0,0),(133,'Sri Aman',14,0,0,0,0,0,0,0,0,0,0,0),(134,'Arau',15,0,0,0,0,0,0,0,0,0,0,0),(135,'Chuping',15,0,0,0,0,0,0,0,0,0,0,0),(136,'Kuala Perlis',15,0,0,0,0,0,0,0,0,0,0,0),(137,'Sanglang',15,0,0,0,0,0,0,0,0,0,0,0),(138,'Kangar',15,0,0,0,0,0,0,0,0,0,0,0),(139,'Alor Setar',16,0,0,0,0,0,0,0,0,0,0,0),(140,'Baling',16,0,0,0,0,0,0,0,0,0,0,0),(141,'Bandar Bharu',16,0,0,0,0,0,0,0,0,0,0,0),(142,'Jitra',16,0,0,0,0,0,0,0,0,0,0,0),(143,'Kuala Muda',16,0,0,0,0,0,0,0,0,0,0,0),(144,'Kubang Pasu',16,0,0,0,0,0,0,0,0,0,0,0),(145,'Kuala Nerang',16,0,0,0,0,0,0,0,0,0,0,0),(146,'Kulim',16,0,0,0,0,0,0,0,0,0,0,0),(147,'Langkawi',16,0,0,0,0,0,0,0,0,0,0,0),(148,'Sik',16,0,0,0,0,0,0,0,0,0,0,0),(149,'Yan',16,0,0,0,0,0,0,0,0,0,0,0),(150,'Sungai Petani',16,0,0,0,0,0,0,0,0,0,0,0),(151,'Kajang',3,0,0,0,0,0,0,0,0,0,0,0),(152,'Barat Daya P.Pinang',1,0,0,0,0,0,0,0,0,0,0,0),(153,'Georgetown',1,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `family`
--

DROP TABLE IF EXISTS `family`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `family` (
  `familyId` int(11) NOT NULL AUTO_INCREMENT,
  `familyName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` tinyint(1) NOT NULL,
  `executeTime` tinyint(1) NOT NULL,
  PRIMARY KEY (`familyId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `family`
--

LOCK TABLES `family` WRITE;
/*!40000 ALTER TABLE `family` DISABLE KEYS */;
INSERT INTO `family` VALUES (1,'SUAMI',0,0,0,0,0,0,0,0,0,0,0),(2,'ISTERI',0,0,0,0,0,0,0,0,0,0,0),(3,'BAPA',0,0,0,0,0,0,0,0,0,0,0),(4,'IBU',0,0,0,0,0,0,0,0,0,0,0),(5,'ANAK',0,0,0,0,0,0,0,0,0,0,0),(6,'BAPA SAUDARA',0,0,0,0,0,0,0,0,0,0,0),(7,'IBU SAUDARA',0,0,0,0,0,0,0,0,0,0,0),(8,'ANAK ANGKAT',0,0,0,0,0,0,0,0,0,0,0),(9,'BAPA MERTUA',0,0,0,0,0,0,0,0,0,0,0),(10,'IBU MERTUA',0,0,0,0,0,0,0,0,0,0,0),(11,'ANAK SAUDARA',0,0,0,0,0,0,0,0,0,0,0),(12,'CUCU',0,0,0,0,0,0,0,0,0,0,0),(13,'NENEK',0,0,0,0,0,0,0,0,0,0,0),(14,'DATUK',0,0,0,0,0,0,0,0,0,0,0),(15,'SEPUPU',0,0,0,0,0,0,0,0,0,0,0),(16,'ABANG',0,0,0,0,0,0,0,0,0,0,0),(17,'KAKAK',0,0,0,0,0,0,0,0,0,0,0),(18,'ADIK',0,0,0,0,0,0,0,0,0,0,0),(19,'MENANTU',0,0,0,0,0,0,0,0,0,0,0),(20,'ANAK TIRI',0,0,0,0,0,0,0,0,0,0,0),(21,'TIADA',0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `family` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `national`
--

DROP TABLE IF EXISTS `national`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `national` (
  `nationalId` int(11) NOT NULL AUTO_INCREMENT,
  `nationalCode` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nationalDescription` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` tinyint(1) NOT NULL,
  `executeTime` tinyint(1) NOT NULL,
  PRIMARY KEY (`nationalId`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `national`
--

LOCK TABLES `national` WRITE;
/*!40000 ALTER TABLE `national` DISABLE KEYS */;
INSERT INTO `national` VALUES (1,'AF','AFGHANISTAN',0,0,0,0,0,0,0,0,0,0,0),(2,'AL','ALBANIA',0,0,0,0,0,0,0,0,0,0,0),(3,'DZ','ALGERIA',0,0,0,0,0,0,0,0,0,0,0),(4,'AS','AMERICAN SAMOA',0,0,0,0,0,0,0,0,0,0,0),(5,'AD','ANDORRA',0,0,0,0,0,0,0,0,0,0,0),(6,'AO','ANGOLA',0,0,0,0,0,0,0,0,0,0,0),(7,'AI','ANGUILLA',0,0,0,0,0,0,0,0,0,0,0),(8,'AQ','ANTARCTICA',0,0,0,0,0,0,0,0,0,0,0),(9,'AG','ANTIGUA AND BARBUDA',0,0,0,0,0,0,0,0,0,0,0),(10,'AR','ARGENTINA',0,0,0,0,0,0,0,0,0,0,0),(11,'AM','ARMENIA',0,0,0,0,0,0,0,0,0,0,0),(12,'AW','ARUBA',0,0,0,0,0,0,0,0,0,0,0),(13,'AU','AUSTRALIA',0,0,0,0,0,0,0,0,0,0,0),(14,'AT','AUSTRIA',0,0,0,0,0,0,0,0,0,0,0),(15,'AZ','AZERBAIJAN',0,0,0,0,0,0,0,0,0,0,0),(16,'BS','BAHAMAS',0,0,0,0,0,0,0,0,0,0,0),(17,'BH','BAHRAIN',0,0,0,0,0,0,0,0,0,0,0),(18,'BD','BANGLADESH',0,0,0,0,0,0,0,0,0,0,0),(19,'BB','BARBADOS',0,0,0,0,0,0,0,0,0,0,0),(20,'BY','BELARUS',0,0,0,0,0,0,0,0,0,0,0),(21,'FR','FRANCE',0,0,0,0,0,0,0,0,0,0,0),(22,'HK','HONG KONG',0,0,0,0,0,0,0,0,0,0,0),(23,'KZ','KAZAKHSTAN',0,0,0,0,0,0,0,0,0,0,0),(24,'MY','MALAYSIA',0,0,0,0,0,0,0,0,0,0,0),(25,'MM','MYANMAR',0,0,0,0,0,0,0,0,0,0,0),(26,'NZ','NEW ZEALAND',0,0,0,0,0,0,0,0,0,0,0),(27,'SE','SWEDEN',0,0,0,0,0,0,0,0,0,0,0),(28,'CH','SWITZERLAND',0,0,0,0,0,0,0,0,0,0,0),(29,'TH','THAILAND',0,0,0,0,0,0,0,0,0,0,0),(30,'US','UNITED STATES',0,0,0,0,0,0,0,0,0,0,0),(31,'YU','YUGOSLAVIA',0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `national` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race`
--

DROP TABLE IF EXISTS `race`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race` (
  `raceId` int(11) NOT NULL AUTO_INCREMENT,
  `raceCode` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `raceDescription` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` tinyint(1) NOT NULL,
  `executeTime` tinyint(1) NOT NULL,
  PRIMARY KEY (`raceId`),
  UNIQUE KEY `race_code` (`raceCode`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race`
--

LOCK TABLES `race` WRITE;
/*!40000 ALTER TABLE `race` DISABLE KEYS */;
INSERT INTO `race` VALUES (2,'Mela','Melayu',0,0,0,0,0,0,0,0,0,0,0),(3,'Cina','Cina',0,0,0,0,0,0,0,0,0,0,0),(4,'Inda','India',0,0,0,0,0,0,0,0,0,0,0),(5,'Bdyh','Bidayuh',0,0,0,0,0,0,0,0,0,0,0),(6,'Meln','Melanau',0,0,0,0,0,0,0,0,0,0,0),(7,'Iban','Iban',0,0,0,0,0,0,0,0,0,0,0),(8,'Kdzn','Kadazan',0,0,0,0,0,0,0,0,0,0,0),(9,'Murt','Murut',0,0,0,0,0,0,0,0,0,0,0),(10,'Baja','Bajau',0,0,0,0,0,0,0,0,0,0,0),(12,'Keyn','Kedayan',0,0,0,0,0,0,0,0,0,0,0),(15,'Sulu','Sulu',0,0,0,0,0,0,0,0,0,0,0),(17,'Brni','Brunei',0,0,0,0,0,0,0,0,0,0,0),(18,'Bajr','Banjar',0,0,0,0,0,0,0,0,0,0,0),(19,'Dusn','Dusun',0,0,0,0,0,0,0,0,0,0,0),(20,'Rugs','Rungus',0,0,0,0,0,0,0,0,0,0,0),(21,'SiNa','Sino-Native',0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `race` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `religion`
--

DROP TABLE IF EXISTS `religion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `religion` (
  `religionId` int(11) NOT NULL AUTO_INCREMENT,
  `religionCode` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `religionDescription` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` tinyint(1) NOT NULL,
  `executeTime` tinyint(1) NOT NULL,
  PRIMARY KEY (`religionId`),
  UNIQUE KEY `religion_code` (`religionCode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `religion`
--

LOCK TABLES `religion` WRITE;
/*!40000 ALTER TABLE `religion` DISABLE KEYS */;
INSERT INTO `religion` VALUES (1,'Is','Islam',0,0,0,0,0,0,0,0,0,0,0),(2,'Kr','Kristian',0,0,0,0,0,0,0,0,0,0,0),(3,'Bu','Budha',0,0,0,0,0,0,0,0,0,0,0),(4,'Hi','Hindu',0,0,0,0,0,0,0,0,0,0,0),(5,'Co','Confucius',0,0,0,0,0,0,0,0,0,0,0),(6,'ASK','Agama Suku Kaum',0,0,0,0,0,0,0,0,0,0,0),(7,'Ta','Tiada Agama',0,0,0,0,0,0,0,0,0,0,0),(8,'LL','Lain-lain',0,0,0,0,0,0,0,0,0,0,0),(9,'kk','jgkgkjgkj',0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `religion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `stateId` int(11) NOT NULL AUTO_INCREMENT,
  `stateName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` tinyint(1) NOT NULL,
  `executeTime` tinyint(1) NOT NULL,
  PRIMARY KEY (`stateId`),
  KEY `state_name` (`stateName`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
INSERT INTO `state` VALUES (1,'Pulau Pinang',0,0,0,0,0,0,0,0,0,0,0),(2,'Perak',0,0,0,0,0,0,0,0,0,0,0),(3,'Selangor',0,0,0,0,0,0,0,0,0,0,0),(4,'Wilayah Persekutuan',0,0,0,0,0,0,0,0,0,0,0),(5,'Putrajaya',0,0,0,0,0,0,0,0,0,0,0),(6,'N. Sembilan',0,0,0,0,0,0,0,0,0,0,0),(7,'Melaka',0,0,0,0,0,0,0,0,0,0,0),(8,'Johor',0,0,0,0,0,0,0,0,0,0,0),(9,'Pahang',0,0,0,0,0,0,0,0,0,0,0),(10,'Terengganu',0,0,0,0,0,0,0,0,0,0,0),(11,'Kelantan',0,0,0,0,0,0,0,0,0,0,0),(12,'Sabah',0,0,0,0,0,0,0,0,0,0,0),(13,'W.P Labuan',0,0,0,0,0,0,0,0,0,0,0),(14,'Sarawak',0,0,0,0,0,0,0,0,0,0,0),(15,'Perlis',0,0,0,0,0,0,0,0,0,0,0),(16,'Kedah',0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-11-20 20:52:42
