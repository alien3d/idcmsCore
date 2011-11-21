-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: idcmscore
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
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application` (
  `applicationId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `iconId` int(11) NOT NULL DEFAULT '281' COMMENT 'Icon|',
  `applicationSequence` int(11) NOT NULL COMMENT 'Sequence|',
  `applicationCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `applicationEnglish` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `applicationFilename` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`applicationId`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES (1,1483,1,'Set','Setting','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(2,1356,1,'samp','Sample Application','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(3,1390,1,'GL','General Ledger','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(4,1393,1,'AR','Account Receivable','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(5,1392,1,'AP','Invoice','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(6,1371,1,'PO','Purchasing  or Account Payable','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(7,1414,1,'MBR','Membership','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(8,1387,1,'bank','Banks','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(9,1409,1,'prev','Preview Account','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(10,1399,1,'cale','Calendar','../../calendar/view/calendar.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(11,1406,1,'chat','Chat','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(12,1461,1,'todo','Todo','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(13,1337,1,'FA','Fix Asset','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(14,1405,1,'DO','Document Management','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(15,1393,1,'CB','Cash Book','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(16,1420,1,'PY','Payroll','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(17,1449,1,'HR','Human Resource','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(18,1450,1,'MAIL','Mail','main.php',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicationaccess`
--

DROP TABLE IF EXISTS `applicationaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicationaccess` (
  `applicationAccessId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Access|',
  `applicationId` int(11) NOT NULL COMMENT 'Application|',
  `teamId` int(11) NOT NULL COMMENT 'Group|',
  `applicationAccessValue` tinyint(1) NOT NULL COMMENT 'Value|',
  PRIMARY KEY (`applicationAccessId`),
  KEY `applicationId` (`applicationId`),
  KEY `teamId` (`teamId`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicationaccess`
--

LOCK TABLES `applicationaccess` WRITE;
/*!40000 ALTER TABLE `applicationaccess` DISABLE KEYS */;
INSERT INTO `applicationaccess` VALUES (1,1,1,1),(2,2,1,1),(3,3,1,1),(4,4,1,1),(5,5,1,1),(6,6,1,1),(7,7,1,1),(8,8,1,1),(9,9,1,1),(10,10,1,1),(11,11,1,1),(12,12,1,1),(13,13,1,1),(14,14,1,1),(15,15,1,1),(16,16,1,1),(17,17,1,1),(18,18,1,1),(19,1,2,1),(20,2,2,1),(21,3,2,1),(22,4,2,1),(23,5,2,1),(24,6,2,1),(25,7,2,1),(26,8,2,1),(27,9,2,1),(28,10,2,1),(29,11,2,1),(30,12,2,1),(31,13,2,1),(32,14,2,1),(33,15,2,1),(34,16,2,1),(35,17,2,1),(36,18,2,1),(37,1,3,1),(38,2,3,1),(39,3,3,1),(40,4,3,1),(41,5,3,1),(42,6,3,1),(43,7,3,1),(44,8,3,1),(45,9,3,1),(46,10,3,1),(47,11,3,1),(48,12,3,1),(49,13,3,1),(50,14,3,1),(51,15,3,1),(52,16,3,1),(53,17,3,1),(54,18,3,1),(55,1,4,1),(56,2,4,1),(57,3,4,1),(58,4,4,1),(59,5,4,1),(60,6,4,1),(61,7,4,1),(62,8,4,1),(63,9,4,1),(64,10,4,1),(65,11,4,1),(66,12,4,1),(67,13,4,1),(68,14,4,1),(69,15,4,1),(70,16,4,1),(71,17,4,1),(72,18,4,1),(73,1,5,1),(74,2,5,1),(75,3,5,1),(76,4,5,1),(77,5,5,1),(78,6,5,1),(79,7,5,1),(80,8,5,1),(81,9,5,1),(82,10,5,1),(83,11,5,1),(84,12,5,1),(85,13,5,1),(86,14,5,1),(87,15,5,1),(88,16,5,1),(89,17,5,1),(90,18,5,1),(91,1,6,1),(92,2,6,1),(93,3,6,1),(94,4,6,1),(95,5,6,1),(96,6,6,1),(97,7,6,1),(98,8,6,1),(99,9,6,1),(100,10,6,1),(101,11,6,1),(102,12,6,1),(103,13,6,1),(104,14,6,1),(105,15,6,1),(106,16,6,1),(107,17,6,1),(108,18,6,1);
/*!40000 ALTER TABLE `applicationaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicationtranslate`
--

DROP TABLE IF EXISTS `applicationtranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicationtranslate` (
  `applicationTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'translate|',
  `applicationId` int(11) NOT NULL COMMENT 'accordion|',
  `languageId` int(11) NOT NULL COMMENT 'language|',
  `applicationNative` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Accordion|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `ispost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`applicationTranslateId`),
  KEY `moduleId` (`applicationId`),
  KEY `languageId` (`languageId`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicationtranslate`
--

LOCK TABLES `applicationtranslate` WRITE;
/*!40000 ALTER TABLE `applicationtranslate` DISABLE KEYS */;
INSERT INTO `applicationtranslate` VALUES (1,1,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(2,2,21,'Sample Application',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(3,3,21,'General Ledger',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(4,4,21,'Account Receivable',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(5,5,21,'Invoice',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(6,6,21,'Purchasing  or Account Payable',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(7,7,21,'Membership',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(8,8,21,'Banks',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(9,9,21,'Preview Account',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(10,10,21,'Calendar',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(11,11,21,'Chat',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(12,12,21,'Todo',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(13,13,21,'Fix Asset',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(14,14,21,'Document Management',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(15,15,21,'Cash Book',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(16,16,21,'Payroll',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(17,17,21,'Human Resource',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(18,18,21,'Mail',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35');
/*!40000 ALTER TABLE `applicationtranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `calendarId` int(10) NOT NULL AUTO_INCREMENT,
  `calendarColorId` int(10) DEFAULT '0',
  `calendarTitle` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `calendarDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isHidden` tinyint(4) NOT NULL DEFAULT '0',
  `staffId` int(10) DEFAULT NULL,
  PRIMARY KEY (`calendarId`),
  KEY `calendarColorId` (`calendarColorId`),
  KEY `staffId` (`staffId`),
  CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`calendarColorId`) REFERENCES `calendarcolor` (`calendarColorId`),
  CONSTRAINT `calendar_ibfk_2` FOREIGN KEY (`staffId`) REFERENCES `staff` (`staffId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
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
-- Table structure for table `defaultlabel`
--

DROP TABLE IF EXISTS `defaultlabel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `defaultlabel` (
  `defaultLabelId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Label|',
  `defaultLabel` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Note|',
  `defaultLabelEnglish` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
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
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`defaultLabelId`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='this is basic english template';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defaultlabel`
--

LOCK TABLES `defaultlabel` WRITE;
/*!40000 ALTER TABLE `defaultlabel` DISABLE KEYS */;
INSERT INTO `defaultlabel` VALUES (1,'systemLabel','System',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(2,'systemErrorLabel','Error',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(3,'updateRecordToolTipLabel','Update',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(4,'deleteRecordToolTipLabel','Delete',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5,'deleteRecordTitleMessageLabel','Delete',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(6,'deleteRecordMessageLabel','Are you sure want to delete this record?',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(7,'waitMessageLabel','Processing',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(8,'successLabel','Sucess',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(9,'waitLabel','processing',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(10,'emptyTextLabel','Please field  Empty Text.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(11,'reloadToolbarLabel','Reload',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(12,'addToolbarLabel','New Record',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(13,'printerToolbarLabel','Printer',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(14,'excelToolbarLabel','Microsoft Excel',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(15,'blankTextLabel','Field in the blank',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(16,'duplicateMessageLabel','Duplicate Record',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(17,'defaultTextLabel','Default Text',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(18,'newButtonLabel','New Record',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(19,'saveButtonLabel','Save',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(20,'deleteButtonLabel','Delete',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(21,'draftButtonLabel','Draft',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(22,'resetButtonLabel','Reset',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(23,'postButtonLabel','Post',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(24,'gridButtonLabel','Listing Record',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(25,'cancelButtonLabel','Cancel',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(26,'firstButtonLabel','First',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(27,'previousButtonLabel','Previous',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(28,'nextButtonLabel','Next',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(29,'endButtonLabel','End',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(30,'loadFailureLabel','Load Failure',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(31,'clientInvalidLabel','Client Invalid',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(32,'connectFailureLabel','Connection Failure',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(33,'serverInvalidLabel','Server Response Invalid',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(34,'actionLabel','Action',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(35,'byLabel','By',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(36,'timeLabel','Time',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(39,'emptyRowLabel','Empty Row',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(40,'CheckAllLabel','Check All',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(41,'ClearAllLabel','Clear All',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(42,'uploadButtonLabel','Upload',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(43,'recordNotFoundLabel','Record not Found',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(44,'chooseRecordLabel','Please Choose a Record ?',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(45,'saveTextLabel','Save',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(46,'cancelTextLabel','Cancel',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(47,'checkDuplicateCodeLabel','Check Duplicate Code ?',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `defaultlabel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `defaultlabeltranslate`
--

DROP TABLE IF EXISTS `defaultlabeltranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `defaultlabeltranslate` (
  `languageId` int(11) NOT NULL COMMENT 'Language|',
  `defaultLabelTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Label|',
  `defaultLabelNative` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Native|',
  `defaultLabelId` int(11) NOT NULL COMMENT 'English|',
  PRIMARY KEY (`defaultLabelTranslateId`),
  KEY `languageId` (`languageId`)
) ENGINE=InnoDB AUTO_INCREMENT=2061 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defaultlabeltranslate`
--

LOCK TABLES `defaultlabeltranslate` WRITE;
/*!40000 ALTER TABLE `defaultlabeltranslate` DISABLE KEYS */;
INSERT INTO `defaultlabeltranslate` VALUES (9,5,'Stelsel',1),(10,6,'Sistem',1),(11,7,'نظام',1),(12,8,'Сістэма',1),(13,9,'Система',1),(14,10,'Sistema d&#39;',1),(15,11,'系统',1),(16,12,'系統',1),(17,13,'Sustav',1),(18,14,'Systém',1),(19,15,'System',1),(20,16,'Het systeem',1),(21,17,'System',1),(22,18,'Süsteemi',1),(23,19,'Sistema',1),(24,20,'System',1),(25,21,'Système',1),(26,22,'Sistema',1),(27,23,'System',1),(28,24,'Σύστημα',1),(29,25,'Sistèm',1),(30,26,'מערכת',1),(31,27,'प्रणाली',1),(32,28,'Rendszer',1),(33,29,'System',1),(34,30,'Sistem',1),(35,31,'Córas',1),(36,32,'Sistema',1),(37,33,'システム',1),(38,34,'Sistēmas',1),(39,35,'Sistemos',1),(40,36,'Систем',1),(41,37,'Sistem',1),(42,38,'Sistema',1),(43,39,'System',1),(44,40,'سیستم',1),(45,41,'Sistema',1),(46,42,'Sistemul de',1),(47,43,'Система',1),(48,44,'Систем',1),(49,45,'Systém',1),(50,46,'System',1),(51,47,'Sistema de',1),(52,48,'Mfumo',1),(53,49,'System',1),(54,50,'ระบบ',1),(55,51,'Система',1),(56,52,'Hệ thống',1),(57,53,'System',1),(58,54,'סיסטעמע',1),(9,55,'Fout',2),(10,56,'Gabim',2),(11,57,'خطأ',2),(12,58,'Памылка',2),(13,59,'Грешка',2),(14,60,'Error',2),(15,61,'错误',2),(16,62,'錯誤',2),(17,63,'Pogreška',2),(18,64,'Chyba',2),(19,65,'Fejl',2),(20,66,'Fout',2),(21,67,'Error',2),(22,68,'Viga',2),(23,69,'Mali',2),(24,70,'Virhe',2),(25,71,'Erreur',2),(26,72,'Erro',2),(27,73,'Fehler',2),(28,74,'Σφάλμα',2),(29,75,'Erè',2),(30,76,'שגיאה',2),(31,77,'त्रुटि',2),(32,78,'Hiba',2),(33,79,'Villa',2),(34,80,'Kesalahan',2),(35,81,'Earráid',2),(36,82,'Errore',2),(37,83,'エラー',2),(38,84,'Kļūda',2),(39,85,'Klaida',2),(40,86,'Грешка',2),(41,87,'Kesalahan',2),(42,88,'Error',2),(43,89,'Feil',2),(44,90,'خطا',2),(45,91,'Erro',2),(46,92,'Eroare',2),(47,93,'Ошибка',2),(48,94,'Грешка',2),(49,95,'Chyba',2),(50,96,'Napaka',2),(51,97,'Error',2),(52,98,'Kosa',2),(53,99,'Fel',2),(54,100,'ความผิดพลาด',2),(55,101,'Помилка',2),(56,102,'Lỗi',2),(57,103,'Gwall',2),(58,104,'גרייַז',2),(9,105,'Update',3),(10,106,'Update',3),(11,107,'التحديث',3),(12,108,'Абнаўленне',3),(13,109,'Update',3),(14,110,'Actualitzar',3),(15,111,'更新',3),(16,112,'更新',3),(17,113,'Ažuriranje',3),(18,114,'Aktualizace',3),(19,115,'Update',3),(20,116,'Update',3),(21,117,'Update',3),(22,118,'Ajakohastama',3),(23,119,'Update',3),(24,120,'Päivitä',3),(25,121,'Mise à jour',3),(26,122,'Update',3),(27,123,'Update',3),(28,124,'Ενημέρωση',3),(29,125,'Mizajou',3),(30,126,'עדכון',3),(31,127,'अद्यतन',3),(32,128,'Frissítés',3),(33,129,'Uppfæra',3),(34,130,'Update',3),(35,131,'Update',3),(36,132,'Aggiornamento',3),(37,133,'更新',3),(38,134,'Update',3),(39,135,'Atnaujinti',3),(40,136,'Ажурирање',3),(41,137,'Update',3),(42,138,'Aġġornament',3),(43,139,'Update',3),(44,140,'بروز رسانی',3),(45,141,'Update',3),(46,142,'Update',3),(47,143,'Обновление',3),(48,144,'Ажурирање',3),(49,145,'Aktualizácie',3),(50,146,'Update',3),(51,147,'Actualizar',3),(52,148,'Mwisho',3),(53,149,'Uppdatera',3),(54,150,'Update',3),(55,151,'Оновлення',3),(56,152,'Thông',3),(57,153,'Y Diweddaraf',3),(58,154,'דערהייַנטיקן',3),(9,155,'Verwyder',4),(10,156,'Fshij',4),(11,157,'حذف',4),(12,158,'Выдаліць',4),(13,159,'Изтриване',4),(14,160,'Eliminar',4),(15,161,'删除',4),(16,162,'刪除',4),(17,163,'Izbrisati',4),(18,164,'Odstranit',4),(19,165,'Slet',4),(20,166,'Verwijderen',4),(21,167,'Delete',4),(22,168,'Kustuta',4),(23,169,'Alisin',4),(24,170,'Poista',4),(25,171,'Supprimer',4),(26,172,'Borrar',4),(27,173,'Löschen',4),(28,174,'Διαγραφή',4),(29,175,'Delete',4),(30,176,'מחק',4),(31,177,'हटाएँ',4),(32,178,'Törlés',4),(33,179,'Eyða',4),(34,180,'Hapus',4),(35,181,'Scrios',4),(36,182,'Elimina',4),(37,183,'削除',4),(38,184,'Dzēst',4),(39,185,'Ištrinti',4),(40,186,'Бриши',4),(41,187,'Padam',4),(42,188,'Ħassar',4),(43,189,'Slett',4),(44,190,'حذف',4),(45,191,'Excluir',4),(46,192,'Şterge',4),(47,193,'Удалить',4),(48,194,'Избриши',4),(49,195,'Odstrániť',4),(50,196,'Izbriši',4),(51,197,'Eliminar',4),(52,198,'Delete',4),(53,199,'Radera',4),(54,200,'ลบ',4),(55,201,'Видалити',4),(56,202,'Xóa',4),(57,203,'Dileu',4),(58,204,'ויסמעקן',4),(9,205,'Verwyder',5),(10,206,'Fshij',5),(11,207,'حذف',5),(12,208,'Выдаліць',5),(13,209,'Изтриване',5),(14,210,'Eliminar',5),(15,211,'删除',5),(16,212,'刪除',5),(17,213,'Izbrisati',5),(18,214,'Odstranit',5),(19,215,'Slet',5),(20,216,'Verwijderen',5),(21,217,'Delete',5),(22,218,'Kustuta',5),(23,219,'Alisin',5),(24,220,'Poista',5),(25,221,'Supprimer',5),(26,222,'Borrar',5),(27,223,'Löschen',5),(28,224,'Διαγραφή',5),(29,225,'Delete',5),(30,226,'מחק',5),(31,227,'हटाएँ',5),(32,228,'Törlés',5),(33,229,'Eyða',5),(34,230,'Hapus',5),(35,231,'Scrios',5),(36,232,'Elimina',5),(37,233,'削除',5),(38,234,'Dzēst',5),(39,235,'Ištrinti',5),(40,236,'Бриши',5),(41,237,'Padam',5),(42,238,'Ħassar',5),(43,239,'Slett',5),(44,240,'حذف',5),(45,241,'Excluir',5),(46,242,'Şterge',5),(47,243,'Удалить',5),(48,244,'Избриши',5),(49,245,'Odstrániť',5),(50,246,'Izbriši',5),(51,247,'Eliminar',5),(52,248,'Delete',5),(53,249,'Radera',5),(54,250,'ลบ',5),(55,251,'Видалити',5),(56,252,'Xóa',5),(57,253,'Dileu',5),(58,254,'ויסמעקן',5),(9,255,'Is jy seker jy hierdie rekord te verwyder?',6),(10,256,'A jeni i sigurt se doni te fshini kete rekord?',6),(11,257,'هل تريد التأكد من حذف هذا السجل؟',6),(12,258,'Вы ўпэўненыя, што жадаеце выдаліць гэтую запіс?',6),(13,259,'Сигурни ли сте, искате да изтриете този запис?',6),(14,260,'Estàs segur que vols eliminar aquest registre?',6),(15,261,'你确定要删除此记录？',6),(16,262,'你確定要刪除此記錄？',6),(17,263,'Jeste li sigurni da želite pobrisati ovaj zapis?',6),(18,264,'Jste si jisti, že chcete smazat tento záznam?',6),(19,265,'Er du sikker på ønsker at slette denne post?',6),(20,266,'Weet u zeker dat deze record wilt verwijderen?',6),(21,267,'Are you sure want to delete this record?',6),(22,268,'Oled sa kindel, et soovite kustutada selle teate?',6),(23,269,'Sigurado ka bang gusto mong tanggalin ang ulat na ito?',6),(24,270,'Oletko varma että haluat poistaa tämän tietueen?',6),(25,271,'Etes-vous sûr de vouloir supprimer cet enregistrement?',6),(26,272,'¿Está seguro de querer eliminar este rexistro?',6),(27,273,'Sind Sie sicher, dass mit diesen Datensatz wirklich löschen?',6),(28,274,'Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το ρεκόρ;',6),(29,275,'Èske ou asire w vle efase dosye sa a?',6),(30,276,'האם אתה בטוח שברצונך למחוק רשומה זו?',6),(31,277,'क्या आप सुनिश्चित करने के लिए इस रिकॉर्ड को नष्ट करना चाहते हैं?',6),(32,278,'Biztos vagy benne, hogy törölni kívánja a rekordot?',6),(33,279,'Ertu viss um að vilja eyða þessari færslu?',6),(34,280,'Apakah Anda yakin ingin menghapus data ini?',6),(35,281,'An bhfuil tú cinnte go dteastaíonn a scriosadh taifead seo?',6),(36,282,'Sei sicuro di voler cancellare questo record?',6),(37,283,'あなたは確かにこのレコードを削除してもよろしいですか？',6),(38,284,'Vai esi pārliecināts, ka vēlaties dzēst šo ierakstu?',6),(39,285,'Ar tikrai norite ištrinti šį įrašą?',6),(40,286,'Дали сте сигурни дека сакате да ја избришете оваа плоча?',6),(41,287,'Adakah anda benar-benar ingin memadam data ini?',6),(42,288,'Inti żgur trid tħassar dan ir-rekord?',6),(43,289,'Er du sikker på at vil slette denne posten?',6),(44,290,'آیا مطمئن هستید که می خواهید این رکورد را حذف کنید؟',6),(45,291,'Tem certeza de que deseja excluir este registro?',6),(46,292,'Eşti sigur că doriţi să ştergeţi acest record?',6),(47,293,'Вы уверены, что хотите удалить эту запись?',6),(48,294,'Јесте ли сигурни да желите да избришете овај запис?',6),(49,295,'Ste si istí, že chcete zmazať tento záznam?',6),(50,296,'Ali ste prepričani, da želite izbrisati ta zapis?',6),(51,297,'¿Estás seguro que quieres eliminar este registro?',6),(52,298,'Una uhakika unataka kufuta rekodi?',6),(53,299,'Vill du verkligen ta bort denna post?',6),(54,300,'คุณแน่ใจหรือว่าต้องการลบบันทึกนี้หรือไม่',6),(55,301,'Ви впевнені, що хочете видалити цей запис?',6),(56,302,'Bạn có chắc chắn muốn xóa hồ sơ này?',6),(57,303,'A ydych yn sicr am ddileu&#39;r cofnod hwn?',6),(58,304,'זענט איר זיכער ווילן צו אויסמעקן דעם רעקאָרד?',6),(9,305,'Verwerking',7),(10,306,'Përpunimit',7),(11,307,'تجهيز',7),(12,308,'Апрацоўка',7),(13,309,'Обработка',7),(14,310,'Processament',7),(15,311,'处理',7),(16,312,'處理',7),(17,313,'Obrada',7),(18,314,'Zpracování',7),(19,315,'Forarbejdning',7),(20,316,'Verwerking',7),(21,317,'Processing',7),(22,318,'Töötlemine',7),(23,319,'Pagproseso',7),(24,320,'Jalostus',7),(25,321,'Traitement',7),(26,322,'Procesamento',7),(27,323,'Verarbeitung',7),(28,324,'Επεξεργασία',7),(29,325,'Processing',7),(30,326,'עיבוד',7),(31,327,'प्रसंस्करण',7),(32,328,'Feldolgozás',7),(33,329,'Vinnsla',7),(34,330,'Pengolahan',7),(35,331,'Próiseáil',7),(36,332,'Elaborazione',7),(37,333,'処理',7),(38,334,'Apstrāde',7),(39,335,'Perdirbimo',7),(40,336,'Обработка',7),(41,337,'Pemprosesan',7),(42,338,'Ipproċessar',7),(43,339,'Processing',7),(44,340,'پردازش',7),(45,341,'Processamento',7),(46,342,'Prelucrare',7),(47,343,'Обработка',7),(48,344,'Обрада',7),(49,345,'Spracovanie',7),(50,346,'Predelava',7),(51,347,'Procesamiento',7),(52,348,'Usindikaji',7),(53,349,'Bearbetning',7),(54,350,'การประมวลผล',7),(55,351,'Обробка',7),(56,352,'Chế biến',7),(57,353,'Prosesu',7),(58,354,'פּראַסעסינג',7),(9,355,'Sukses',8),(10,356,'Sukses',8),(11,357,'نجاح',8),(12,358,'Поспеху',8),(13,359,'Успех',8),(14,360,'Èxit',8),(15,361,'成功',8),(16,362,'成功',8),(17,363,'Uspjeh',8),(18,364,'Úspěch',8),(19,365,'Succes',8),(20,366,'Succes',8),(21,367,'Sucess',8),(22,368,'Edu',8),(23,369,'Tagumpay',8),(24,370,'Suoritettu',8),(25,371,'Succès',8),(26,372,'Éxito',8),(27,373,'Success',8),(28,374,'Επιτυχίας',8),(29,375,'Siksè',8),(30,376,'הצלחה',8),(31,377,'सफलता',8),(32,378,'Siker',8),(33,379,'Velgengni',8),(34,380,'Sukses',8),(35,381,'Rath',8),(36,382,'Successo',8),(37,383,'成功',8),(38,384,'Veiksme',8),(39,385,'Sėkmė',8),(40,386,'Успех',8),(41,387,'Sukses',8),(42,388,'Suċċess',8),(43,389,'Suksess',8),(44,390,'موفقیت',8),(45,391,'Sucesso',8),(46,392,'Succes',8),(47,393,'Успеха',8),(48,394,'Успех',8),(49,395,'Úspech',8),(50,396,'Uspeh',8),(51,397,'Éxito',8),(52,398,'Mafanikio',8),(53,399,'Framgång',8),(54,400,'ความสำเร็จ',8),(55,401,'Успіху',8),(56,402,'Thành công',8),(57,403,'Llwyddiant',8),(58,404,'דערפאָלג',8),(9,405,'verwerking',9),(10,406,'përpunimit',9),(11,407,'تجهيز',9),(12,408,'апрацоўкі',9),(13,409,'обработка',9),(14,410,'processament',9),(15,411,'处理',9),(16,412,'處理',9),(17,413,'obrada',9),(18,414,'zpracování',9),(19,415,'forarbejdning',9),(20,416,'verwerking',9),(21,417,'processing',9),(22,418,'töötlemine',9),(23,419,'pagproseso',9),(24,420,'jalostus',9),(25,421,'traitement',9),(26,422,'procesamento',9),(27,423,'Verarbeitung',9),(28,424,'μεταποίησης',9),(29,425,'pwosesis',9),(30,426,'עיבוד',9),(31,427,'प्रसंस्करण',9),(32,428,'feldolgozás',9),(33,429,'vinnsla',9),(34,430,'pengolahan',9),(35,431,'próiseála',9),(36,432,'elaborazione',9),(37,433,'処理',9),(38,434,'apstrāde',9),(39,435,'perdirbimo',9),(40,436,'обработка',9),(41,437,'pemprosesan',9),(42,438,'ipproċessar',9),(43,439,'prosessering',9),(44,440,'پردازش',9),(45,441,'processamento',9),(46,442,'prelucrare',9),(47,443,'обработки',9),(48,444,'обрада',9),(49,445,'spracovanie',9),(50,446,'predelavo',9),(51,447,'procesamiento',9),(52,448,'usindikaji',9),(53,449,'bearbetning',9),(54,450,'การประมวลผล',9),(55,451,'обробки',9),(56,452,'chế biến',9),(57,453,'prosesu',9),(58,454,'פּראַסעסינג',9),(9,455,'Asseblief veld leeg teks.',10),(10,456,'Ju lutem fushë Tekst bosh.',10),(11,457,'يرجى حقل نص فارغ.',10),(12,458,'Калі ласка, запаўняйце поле Тэкст.',10),(13,459,'Моля областта празен текст.',10),(14,460,'Si us plau, camp de text buit.',10),(15,461,'请字段为空文本。',10),(16,462,'請字段為空文本。',10),(17,463,'Molimo polje prazno tekst.',10),(18,464,'Prosím pole prázdné textové.',10),(19,465,'Venligst felt tom tekst.',10),(20,466,'Gelieve veld leeg tekst.',10),(21,467,'Please field  Empty Text.',10),(22,468,'Palun valdkonnas tühi tekst.',10),(23,469,'Mangyaring field Empty Text.',10),(24,470,'Ole hyvä kenttä tyhjä teksti.',10),(25,471,'S&#39;il vous plaît champ texte vide.',10),(26,472,'Por favor, campo de texto en branco.',10),(27,473,'Bitte Feld leer Text.',10),(28,474,'Παρακαλούμε πεδίο Κείμενο Κενό.',10),(29,475,'Tanpri, jaden Vide tèks.',10),(30,476,'אנא שדה טקסט ריק.',10),(31,477,'खाली पाठ क्षेत्र करें.',10),(32,478,'Kérjük mező üres szöveg.',10),(33,479,'Vinsamlegast sviði Empty Texti.',10),(34,480,'Silakan field Teks Kosong.',10),(35,481,'Tabhair faoi réimse Téacs Folamh.',10),(36,482,'Si prega di campo di testo vuoto.',10),(37,483,'空のテキストをフィールドしてください。',10),(38,484,'Lūdzu, lauku tukšu tekstu.',10),(39,485,'Prašome srityje Tuščias tekstas.',10),(40,486,'Ве молиме полето празно текст.',10),(41,487,'Sila field Mesej Kosong.',10),(42,488,'Jekk jogħġbok qasam Test vojta.',10),(43,489,'Vennligst feltet tom tekst.',10),(44,490,'لطفا زمینه متن خالی می باشد.',10),(45,491,'Por favor, campo de texto vazio.',10),(46,492,'Vă rugăm să câmp text gol.',10),(47,493,'Пожалуйста, заполняйте поле Текст.',10),(48,494,'Молимо Вас да поља празног текста.',10),(49,495,'Prosím pole prázdne textové.',10),(50,496,'Prosimo polje prazno besedilo.',10),(51,497,'Por favor, campo de texto vacío.',10),(52,498,'Tafadhali shamba Nakala tupu.',10),(53,499,'Vänligen fält tom text.',10),(54,500,'กรุณาฟิลด์ข้อความว่างเปล่า',10),(55,501,'Будь ласка, заповнюйте поле Текст.',10),(56,502,'Xin vui lòng lĩnh vực văn bản trống.',10),(57,503,'Os gwelwch yn dda maes Testun Gwag.',10),(58,504,'ביטע פעלד נוליקע טעקסט.',10),(9,505,'Reload',11),(10,506,'Ringarko',11),(11,507,'تحديث',11),(12,508,'Перазагрузіць',11),(13,509,'Презареди',11),(14,510,'Actualitzar',11),(15,511,'重载',11),(16,512,'重載',11),(17,513,'Učitajte',11),(18,514,'Obnovit',11),(19,515,'Opdater',11),(20,516,'Reload',11),(21,517,'Reload',11),(22,518,'Reload',11),(23,519,'Reload',11),(24,520,'Ladata',11),(25,521,'Recharger',11),(26,522,'Actualizar',11),(27,523,'Reload',11),(28,524,'Ανανέωση',11),(29,525,'Reload',11),(30,526,'רענן',11),(31,527,'Reload',11),(32,528,'Reload',11),(33,529,'Endurhlaða',11),(34,530,'Reload',11),(35,531,'Reload',11),(36,532,'Ricarica',11),(37,533,'リロード',11),(38,534,'Pārlādēt',11),(39,535,'Perkrauti',11),(40,536,'Вчитај',11),(41,537,'Reload',11),(42,538,'Reload',11),(43,539,'Reload',11),(44,540,'بارگذاری',11),(45,541,'Atualizar',11),(46,542,'Reîncarcă',11),(47,543,'Перезагрузить',11),(48,544,'Учитај поново',11),(49,545,'Obnoviť',11),(50,546,'Reload',11),(51,547,'Actualizar',11),(52,548,'Reload',11),(53,549,'Ladda om',11),(54,550,'Reload',11),(55,551,'Перезавантажити',11),(56,552,'Cập Nhật',11),(57,553,'Ail-lwytho',11),(58,554,'רעלאָאַד',11),(9,555,'Nuwe rekord',12),(10,556,'Regjistro reja',12),(11,557,'رقم قياسي جديد',12),(12,558,'Новая запіс',12),(13,559,'Нов запис',12),(14,560,'Nou registre',12),(15,561,'新记录',12),(16,562,'新記錄',12),(17,563,'Novi rekord',12),(18,564,'Nový rekord',12),(19,565,'Ny post',12),(20,566,'Nieuw record',12),(21,567,'New Record',12),(22,568,'New Record',12),(23,569,'Bagong Record',12),(24,570,'Uusi ennätys',12),(25,571,'Nouveau record',12),(26,572,'Novo Record',12),(27,573,'Neuer Rekord',12),(28,574,'Νέα Εγγραφή',12),(29,575,'Ekri nouvo',12),(30,576,'שיא חדש',12),(31,577,'नया रिकार्ड',12),(32,578,'Új rekord',12),(33,579,'New Record',12),(34,580,'Record Baru',12),(35,581,'Nua Taifead',12),(36,582,'Nuovo record',12),(37,583,'新しいレコード',12),(38,584,'Jauns ieraksts',12),(39,585,'Naujas įrašas',12),(40,586,'Нов рекорд',12),(41,587,'Record Baru',12),(42,588,'New Record',12),(43,589,'Ny post',12),(44,590,'رکورد جدید',12),(45,591,'Novo Record',12),(46,592,'Record nou',12),(47,593,'Новая запись',12),(48,594,'Нови запис',12),(49,595,'Nový rekord',12),(50,596,'Nov zapis',12),(51,597,'Nuevo registro',12),(52,598,'Mpya Record',12),(53,599,'Ny post',12),(54,600,'บันทึกใหม่',12),(55,601,'Новий запис',12),(56,602,'New Record',12),(57,603,'Cofnod Newydd',12),(58,604,'ניו רעקאָרד',12),(9,605,'Drukker',13),(10,606,'Printer',13),(11,607,'الطابعة',13),(12,608,'Друкарак',13),(13,609,'Принтер',13),(14,610,'Impressora',13),(15,611,'打印机',13),(16,612,'打印機',13),(17,613,'Printer',13),(18,614,'Tiskárny',13),(19,615,'Printer',13),(20,616,'Printer',13),(21,617,'Printer',13),(22,618,'Printer',13),(23,619,'Printer',13),(24,620,'Tulostimen',13),(25,621,'Imprimante',13),(26,622,'Impresora',13),(27,623,'Drucker',13),(28,624,'Εκτυπωτή',13),(29,625,'Printer',13),(30,626,'מדפסת',13),(31,627,'प्रिंटर',13),(32,628,'Nyomtató',13),(33,629,'Printer',13),(34,630,'Printer',13),(35,631,'Printéir',13),(36,632,'Stampante',13),(37,633,'プリンタ',13),(38,634,'Printeris',13),(39,635,'Spausdintuvas',13),(40,636,'Отпечати',13),(41,637,'Printer',13),(42,638,'Printer',13),(43,639,'Skriver',13),(44,640,'چاپگر',13),(45,641,'Impressora',13),(46,642,'Imprimantă',13),(47,643,'Принтеров',13),(48,644,'Штампач',13),(49,645,'Tlačiarne',13),(50,646,'Printer',13),(51,647,'Impresora',13),(52,648,'Printer',13),(53,649,'Skrivare',13),(54,650,'พิมพ์',13),(55,651,'Принтерів',13),(56,652,'Máy in',13),(57,653,'Argraffydd',13),(58,654,'דרוקער',13),(9,655,'Microsoft Excel',14),(10,656,'Microsoft Excel',14),(11,657,'مايكروسوفت إكسل',14),(12,658,'Microsoft Excel',14),(13,659,'Microsoft Excel',14),(14,660,'Microsoft Excel',14),(15,661,'微软的Excel',14),(16,662,'微軟的Excel',14),(17,663,'Microsoft Excel',14),(18,664,'Microsoft Excel',14),(19,665,'Microsoft Excel',14),(20,666,'Microsoft Excel',14),(21,667,'Microsoft Excel',14),(22,668,'Microsoft Excel',14),(23,669,'Microsoft Excel',14),(24,670,'Microsoft Excel',14),(25,671,'Microsoft Excel',14),(26,672,'Microsoft Excel',14),(27,673,'Microsoft Excel',14),(28,674,'Microsoft Excel',14),(29,675,'Microsoft Excel',14),(30,676,'Microsoft Excel',14),(31,677,'माइक्रोसॉफ्ट एक्सेल',14),(32,678,'Microsoft Excel',14),(33,679,'Microsoft Excel',14),(34,680,'Microsoft Excel',14),(35,681,'Microsoft Excel',14),(36,682,'Microsoft Excel',14),(37,683,'Microsoft Excelの',14),(38,684,'Microsoft Excel',14),(39,685,'&quot;Microsoft Excel&quot;',14),(40,686,'Microsoft Excel',14),(41,687,'Microsoft Excel',14),(42,688,'Microsoft Excel',14),(43,689,'Microsoft Excel',14),(44,690,'مایکروسافت اکسل',14),(45,691,'Microsoft Excel',14),(46,692,'Microsoft Excel',14),(47,693,'Microsoft Excel',14),(48,694,'Мицрософт Екцел',14),(49,695,'Microsoft Excel',14),(50,696,'Microsoft Excel',14),(51,697,'Microsoft Excel',14),(52,698,'Microsoft Excel',14),(53,699,'Microsoft Excel',14),(54,700,'Microsoft Excel',14),(55,701,'Microsoft Excel',14),(56,702,'Microsoft Excel',14),(57,703,'Microsoft Excel',14),(58,704,'מייקראָסאָפֿט עקססעל',14),(9,705,'Veld in die leë',15),(10,706,'Fushë në bosh',15),(11,707,'في حقل فارغ',15),(12,708,'Поле ў пусты',15),(13,709,'Поле в празното',15),(14,710,'Camp en l&#39;espai en blanc',15),(15,711,'场中的空白',15),(16,712,'場中的空白',15),(17,713,'Polje u prazno',15),(18,714,'Pole do prázdného',15),(19,715,'Felt i blank',15),(20,716,'Veld in het lege',15),(21,717,'Field in the blank',15),(22,718,'Väli tühjaks',15),(23,719,'Patlang ng mga blangko',15),(24,720,'Kenttä tyhjäksi',15),(25,721,'Champ dans l&#39;espace',15),(26,722,'Campo en branco',15),(27,723,'Feld in der leeren',15),(28,724,'Πεδίο στο κενό',15),(29,725,'Jaden nan vid la',15),(30,726,'שדה ריק',15),(31,727,'रिक्त में फील्ड',15),(32,728,'Field az üres',15),(33,729,'Field í auða',15),(34,730,'Lapangan di kosong',15),(35,731,'Réimse an bán',15),(36,732,'Campo nel vuoto',15),(37,733,'空白のフィールド',15),(38,734,'Jomā tukšajā',15),(39,735,'Laukas tuščias',15),(40,736,'Поле во празно',15),(41,737,'Lapangan di kosong',15),(42,738,'Qasam fl-imbjank',15),(43,739,'Field i det tomme',15),(44,740,'در فیلد خالی',15),(45,741,'Campo em branco',15),(46,742,'Câmp în gol',15),(47,743,'Поле в пустой',15),(48,744,'Поље у празно',15),(49,745,'Pole do prázdneho',15),(50,746,'Polje v prazno',15),(51,747,'Campo en el espacio en blanco',15),(52,748,'Shamba katika tupu',15),(53,749,'Fält i den tomma',15),(54,750,'เขตข้อมูลในที่ว่างเปล่า',15),(55,751,'Поле в порожній',15),(56,752,'Field vào chỗ trống',15),(57,753,'Maes yn y gwag',15),(58,754,'פעלד אין די ליידיק',15),(9,755,'Tweevoud Rekord',16),(10,756,'Duplicate Record',16),(11,757,'سجل مكرر',16),(12,758,'Запісы, якія паўтараюцца',16),(13,759,'Дублиране Запис',16),(14,760,'Registres duplicats',16),(15,761,'重复记录',16),(16,762,'重複記錄',16),(17,763,'Dvostruki rekord',16),(18,764,'Duplicitní záznam',16),(19,765,'Duplicate Record',16),(20,766,'Dubbele record',16),(21,767,'Duplicate Record',16),(22,768,'Duplicate Record',16),(23,769,'Doblehin Record',16),(24,770,'Monista Record',16),(25,771,'Dupliquer l&#39;enregistrement',16),(26,772,'Duplicate Record',16),(27,773,'Datensatz duplizieren',16),(28,774,'Διπλότυπο Εγγραφή',16),(29,775,'Kopi Dosye',16),(30,776,'שכפל שיא',16),(31,777,'नकल रिकार्ड',16),(32,778,'Duplicate rekord',16),(33,779,'Afrit Record',16),(34,780,'Duplikasi Record',16),(35,781,'Dúblach Taifead',16),(36,782,'Duplica il record',16),(37,783,'重複レコード',16),(38,784,'Duplicate Record',16),(39,785,'Dubliuoti Įrašų',16),(40,786,'Дупликат рекорд',16),(41,787,'Duplikasi Record',16),(42,788,'Duplikat Record',16),(43,789,'Duplicate Record',16),(44,790,'رکورد تکراری',16),(45,791,'Duplicate Record',16),(46,792,'Record duplicat',16),(47,793,'Повторяющиеся записи',16),(48,794,'Дупликат Рекорд',16),(49,795,'Duplicitné záznam',16),(50,796,'Duplicate Record',16),(51,797,'Registros duplicados',16),(52,798,'Duplicate Record',16),(53,799,'Duplicera post',16),(54,800,'บันทึกซ้ำ',16),(55,801,'Повторювані записи',16),(56,802,'Duplicate Record',16),(57,803,'Cofnod dyblyg',16),(58,804,'דופּליקאַט רעקאָרד',16),(9,805,'Standaard teks',17),(10,806,'Default Tekst',17),(11,807,'النص الافتراضي',17),(12,808,'Тэкст па змаўчанні',17),(13,809,'Текстът по подразбиране',17),(14,810,'Text per defecte',17),(15,811,'默认文本',17),(16,812,'默認文本',17),(17,813,'Zadani tekst',17),(18,814,'Výchozí text',17),(19,815,'Standard tekst',17),(20,816,'Default Text',17),(21,817,'Default Text',17),(22,818,'Vaikimisi tekst',17),(23,819,'Default na Teksto',17),(24,820,'Default Text',17),(25,821,'De texte par défaut',17),(26,822,'Default Text',17),(27,823,'Default Text',17),(28,824,'Default Text',17),(29,825,'Default Text',17),(30,826,'ברירת המחדל של הטקסט',17),(31,827,'डिफ़ॉल्ट पाठ',17),(32,828,'Alapértelmezett szöveg',17),(33,829,'Default Text',17),(34,830,'Default Text',17),(35,831,'Default Text',17),(36,832,'Testo predefinito',17),(37,833,'デフォルトのテキスト',17),(38,834,'Noklusējuma teksta',17),(39,835,'Numatytasis tekstas',17),(40,836,'Стандардна текст',17),(41,837,'Default Text',17),(42,838,'Default Test',17),(43,839,'Default Tekst',17),(44,840,'متن پیشفرض',17),(45,841,'Default Text',17),(46,842,'Implicit Text',17),(47,843,'Текст по умолчанию',17),(48,844,'Подразумевани текст',17),(49,845,'Východiskový text',17),(50,846,'Default Text',17),(51,847,'Texto por defecto',17),(52,848,'Nakala default',17),(53,849,'Default Text',17),(54,850,'ข้อความเริ่มต้น',17),(55,851,'Текст за умовчанням',17),(56,852,'Văn bản mặc định',17),(57,853,'Default Testun',17),(58,854,'ניט ויסצאָלן טעקסט',17),(9,855,'Nuwe rekord',18),(10,856,'Regjistro reja',18),(11,857,'رقم قياسي جديد',18),(12,858,'Новая запіс',18),(13,859,'Нов запис',18),(14,860,'Nou registre',18),(15,861,'新记录',18),(16,862,'新記錄',18),(17,863,'Novi rekord',18),(18,864,'Nový rekord',18),(19,865,'Ny post',18),(20,866,'Nieuw record',18),(21,867,'New Record',18),(22,868,'New Record',18),(23,869,'Bagong Record',18),(24,870,'Uusi ennätys',18),(25,871,'Nouveau record',18),(26,872,'Novo Record',18),(27,873,'Neuer Rekord',18),(28,874,'Νέα Εγγραφή',18),(29,875,'Ekri nouvo',18),(30,876,'שיא חדש',18),(31,877,'नया रिकार्ड',18),(32,878,'Új rekord',18),(33,879,'New Record',18),(34,880,'Record Baru',18),(35,881,'Nua Taifead',18),(36,882,'Nuovo record',18),(37,883,'新しいレコード',18),(38,884,'Jauns ieraksts',18),(39,885,'Naujas įrašas',18),(40,886,'Нов рекорд',18),(41,887,'Record Baru',18),(42,888,'New Record',18),(43,889,'Ny post',18),(44,890,'رکورد جدید',18),(45,891,'Novo Record',18),(46,892,'Record nou',18),(47,893,'Новая запись',18),(48,894,'Нови запис',18),(49,895,'Nový rekord',18),(50,896,'Nov zapis',18),(51,897,'Nuevo registro',18),(52,898,'Mpya Record',18),(53,899,'Ny post',18),(54,900,'บันทึกใหม่',18),(55,901,'Новий запис',18),(56,902,'New Record',18),(57,903,'Cofnod Newydd',18),(58,904,'ניו רעקאָרד',18),(9,905,'Slaan',19),(10,906,'Ruaj',19),(11,907,'حفظ',19),(12,908,'Захаваць',19),(13,909,'Запази',19),(14,910,'Guardar',19),(15,911,'保存',19),(16,912,'保存',19),(17,913,'Spasiti',19),(18,914,'Uložit',19),(19,915,'Gem',19),(20,916,'Opslaan',19),(21,917,'Save',19),(22,918,'Salvesta',19),(23,919,'Iligtas',19),(24,920,'Tallenna',19),(25,921,'Enregistrer',19),(26,922,'Gardar',19),(27,923,'Speichern',19),(28,924,'Αποθήκευση',19),(29,925,'Sove',19),(30,926,'שמור',19),(31,927,'सहेजें',19),(32,928,'Mentés',19),(33,929,'Vista',19),(34,930,'Simpan',19),(35,931,'Sábháil',19),(36,932,'Salva',19),(37,933,'名前を付けて保存',19),(38,934,'Saglabāt',19),(39,935,'Prisiminti',19),(40,936,'Зачувај',19),(41,937,'Simpan',19),(42,938,'Save',19),(43,939,'Lagre',19),(44,940,'ذخیره',19),(45,941,'Guardar',19),(46,942,'Salva',19),(47,943,'Сохранить',19),(48,944,'Сачувај',19),(49,945,'Uložiť',19),(50,946,'Shrani',19),(51,947,'Guardar',19),(52,948,'Ila',19),(53,949,'Spara',19),(54,950,'บันทึก',19),(55,951,'Зберегти',19),(56,952,'Lưu',19),(57,953,'Cadw',19),(58,954,'ראַטעווען',19),(9,955,'Verwyder',20),(10,956,'Fshij',20),(11,957,'حذف',20),(12,958,'Выдаліць',20),(13,959,'Изтриване',20),(14,960,'Eliminar',20),(15,961,'删除',20),(16,962,'刪除',20),(17,963,'Izbrisati',20),(18,964,'Odstranit',20),(19,965,'Slet',20),(20,966,'Verwijderen',20),(21,967,'Delete',20),(22,968,'Kustuta',20),(23,969,'Alisin',20),(24,970,'Poista',20),(25,971,'Supprimer',20),(26,972,'Borrar',20),(27,973,'Löschen',20),(28,974,'Διαγραφή',20),(29,975,'Delete',20),(30,976,'מחק',20),(31,977,'हटाएँ',20),(32,978,'Törlés',20),(33,979,'Eyða',20),(34,980,'Hapus',20),(35,981,'Scrios',20),(36,982,'Elimina',20),(37,983,'削除',20),(38,984,'Dzēst',20),(39,985,'Ištrinti',20),(40,986,'Бриши',20),(41,987,'Padam',20),(42,988,'Ħassar',20),(43,989,'Slett',20),(44,990,'حذف',20),(45,991,'Excluir',20),(46,992,'Şterge',20),(47,993,'Удалить',20),(48,994,'Избриши',20),(49,995,'Odstrániť',20),(50,996,'Izbriši',20),(51,997,'Eliminar',20),(52,998,'Delete',20),(53,999,'Radera',20),(54,1000,'ลบ',20),(55,1001,'Видалити',20),(56,1002,'Xóa',20),(57,1003,'Dileu',20),(58,1004,'ויסמעקן',20),(9,1005,'Ontwerp',21),(10,1006,'Projekt',21),(11,1007,'مشروع',21),(12,1008,'Праект',21),(13,1009,'Проект',21),(14,1010,'Projecte de',21),(15,1011,'草案',21),(16,1012,'草案',21),(17,1013,'Nacrt',21),(18,1014,'Návrh',21),(19,1015,'Udkast til',21),(20,1016,'Ontwerp-',21),(21,1017,'Draft',21),(22,1018,'Projekt',21),(23,1019,'Burador',21),(24,1020,'Luonnos',21),(25,1021,'Projet de',21),(26,1022,'Proxecto',21),(27,1023,'Entwurf',21),(28,1024,'Σχέδιο',21),(29,1025,'Bouyon',21),(30,1026,'טיוטה',21),(31,1027,'मसौदा',21),(32,1028,'Tervezet',21),(33,1029,'Draft',21),(34,1030,'Draf',21),(35,1031,'Dréacht',21),(36,1032,'Progetto',21),(37,1033,'ドラフト',21),(38,1034,'Projektu',21),(39,1035,'Projektas',21),(40,1036,'Предлог',21),(41,1037,'Draf',21),(42,1038,'Abbozz',21),(43,1039,'Utkast',21),(44,1040,'پیش نویس',21),(45,1041,'Projecto',21),(46,1042,'Proiect de',21),(47,1043,'Проект',21),(48,1044,'Нацрт',21),(49,1045,'Návrh',21),(50,1046,'Osnutek',21),(51,1047,'Proyecto de',21),(52,1048,'Rasimu',21),(53,1049,'Förslag',21),(54,1050,'ร่าง',21),(55,1051,'Проект',21),(56,1052,'Dự thảo',21),(57,1053,'Drafft',21),(58,1054,'פּלאַן',21),(9,1055,'Reset',22),(10,1056,'Reset',22),(11,1057,'إعادة تعيين',22),(12,1058,'Скід',22),(13,1059,'Проучване',22),(14,1060,'Restablir',22),(15,1061,'复位',22),(16,1062,'復位',22),(17,1063,'Reset',22),(18,1064,'Reset',22),(19,1065,'Nulstil',22),(20,1066,'Reset',22),(21,1067,'Reset',22),(22,1068,'Reset',22),(23,1069,'I-reset',22),(24,1070,'Nollaa',22),(25,1071,'Reset',22),(26,1072,'Reset',22),(27,1073,'Reset',22),(28,1074,'Επαναφορά',22),(29,1075,'Reyajiste',22),(30,1076,'איפוס',22),(31,1077,'रीसेट',22),(32,1078,'Reset',22),(33,1079,'Endurstilla',22),(34,1080,'Reset',22),(35,1081,'Athshocraigh',22),(36,1082,'Reset',22),(37,1083,'リセット',22),(38,1084,'Reset',22),(39,1085,'Atstatyti',22),(40,1086,'Ресетирај',22),(41,1087,'Kembalikan',22),(42,1088,'Irrisettja',22),(43,1089,'Reset',22),(44,1090,'بازنشانی',22),(45,1091,'Reset',22),(46,1092,'Resetare',22),(47,1093,'Сброс',22),(48,1094,'Ресетовање',22),(49,1095,'Reset',22),(50,1096,'Reset',22),(51,1097,'Restablecer',22),(52,1098,'Reset',22),(53,1099,'Återställ',22),(54,1100,'Reset',22),(55,1101,'Скидання',22),(56,1102,'Thiết lập lại',22),(57,1103,'Ailosod',22),(58,1104,'באַשטעטיק',22),(9,1105,'Post',23),(10,1106,'Post',23),(11,1107,'آخر',23),(12,1108,'Паведамленне',23),(13,1109,'Пост',23),(14,1110,'Missatge',23),(15,1111,'邮政',23),(16,1112,'郵政',23),(17,1113,'Post',23),(18,1114,'Příspěvek',23),(19,1115,'Post',23),(20,1116,'Post',23),(21,1117,'Post',23),(22,1118,'Post',23),(23,1119,'Post',23),(24,1120,'Post',23),(25,1121,'Post',23),(26,1122,'Post',23),(27,1123,'Post',23),(28,1124,'Δημοσίευση',23),(29,1125,'Post',23),(30,1126,'הודעה',23),(31,1127,'पोस्ट',23),(32,1128,'Hozzászólás',23),(33,1129,'Post',23),(34,1130,'Post',23),(35,1131,'Iar',23),(36,1132,'Post',23),(37,1133,'投稿',23),(38,1134,'Pastu',23),(39,1135,'Paštu',23),(40,1136,'Пост',23),(41,1137,'Post',23),(42,1138,'Post',23),(43,1139,'Post',23),(44,1140,'پست',23),(45,1141,'Post',23),(46,1142,'Post',23),(47,1143,'Сообщение',23),(48,1144,'Пост',23),(49,1145,'Príspevok',23),(50,1146,'Post',23),(51,1147,'Mensaje',23),(52,1148,'Post',23),(53,1149,'Post',23),(54,1150,'โพสต์',23),(55,1151,'Повідомлення',23),(56,1152,'Post',23),(57,1153,'Post',23),(58,1154,'פּאָסטן',23),(9,1155,'Aanbieding Rekord',24),(10,1156,'Listing Record',24),(11,1157,'إدراج سجل',24),(12,1158,'Лістынг запіс',24),(13,1159,'Обява Запис',24),(14,1160,'Llistat de Registre',24),(15,1161,'上市记录',24),(16,1162,'上市記錄',24),(17,1163,'Oglas rekord',24),(18,1164,'Výpis záznamů',24),(19,1165,'Notering Record',24),(20,1166,'Record aanbieding',24),(21,1167,'Listing Record',24),(22,1168,'Videod Record',24),(23,1169,'Listing Record',24),(24,1170,'Listing Record',24),(25,1171,'Exemple d&#39;enregistrement',24),(26,1172,'Listado Record',24),(27,1173,'Listing Record',24),(28,1174,'Λίστα Εγγραφή',24),(29,1175,'Listing Ekri',24),(30,1176,'רשימת תקליטים',24),(31,1177,'लिस्ट रिकार्ड',24),(32,1178,'Rekord listázása',24),(33,1179,'Listing Record',24),(34,1180,'Listing Rekam',24),(35,1181,'Liosta Taifead',24),(36,1182,'Elenco dei Record',24),(37,1183,'リストレコード',24),(38,1184,'Listing Ierakstīt',24),(39,1185,'Sąrašas Įrašų',24),(40,1186,'Рекорд на оглас',24),(41,1187,'Listing Rakam',24),(42,1188,'Elenku Record',24),(43,1189,'Oppføring Record',24),(44,1190,'مثال رکورد',24),(45,1191,'Listagem Record',24),(46,1192,'Listarea Record',24),(47,1193,'Листинг запись',24),(48,1194,'Оглас Рекорд',24),(49,1195,'Výpis záznamov',24),(50,1196,'Ad Record',24),(51,1197,'Listado de Registro',24),(52,1198,'Nyimbo Record',24),(53,1199,'Lista Record',24),(54,1200,'บันทึกรายการ',24),(55,1201,'Лістинг запис',24),(56,1202,'Liệt kê Record',24),(57,1203,'Cofnod Listing',24),(58,1204,'ליסטינג רעקאָרד',24),(9,1205,'Kanselleer',25),(10,1206,'Anuloj',25),(11,1207,'إلغاء',25),(12,1208,'Адмяніць',25),(13,1209,'Отказ',25),(14,1210,'Cancel',25),(15,1211,'取消',25),(16,1212,'取消',25),(17,1213,'Otkazati',25),(18,1214,'Zrušit',25),(19,1215,'Annuller',25),(20,1216,'Annuleren',25),(21,1217,'Cancel',25),(22,1218,'Tühista',25),(23,1219,'Kanselahin',25),(24,1220,'Peruuta',25),(25,1221,'Annuler',25),(26,1222,'Cancelar',25),(27,1223,'Abbrechen',25),(28,1224,'Ακύρωση',25),(29,1225,'Anile',25),(30,1226,'לבטל',25),(31,1227,'रद्द',25),(32,1228,'Mégsem',25),(33,1229,'Hætta við',25),(34,1230,'Membatalkan',25),(35,1231,'Cealaigh',25),(36,1232,'Annulla',25),(37,1233,'キャンセル',25),(38,1234,'Atcelt',25),(39,1235,'Atšaukti',25),(40,1236,'Откажи',25),(41,1237,'Membatalkan',25),(42,1238,'Ikkanċella',25),(43,1239,'Avbryt',25),(44,1240,'انصراف',25),(45,1241,'Cancelar',25),(46,1242,'Anula',25),(47,1243,'Отменить',25),(48,1244,'Отказати',25),(49,1245,'Zrušiť',25),(50,1246,'Prekliči',25),(51,1247,'Cancelar',25),(52,1248,'Kufuta',25),(53,1249,'Avbryt',25),(54,1250,'ยกเลิก',25),(55,1251,'Скасувати',25),(56,1252,'Huỷ',25),(57,1253,'Canslo',25),(58,1254,'באָטל מאַכן',25),(9,1255,'Eerste',26),(10,1256,'Parë',26),(11,1257,'الأول',26),(12,1258,'Першы',26),(13,1259,'Първи',26),(14,1260,'En primer lloc',26),(15,1261,'第一',26),(16,1262,'第一',26),(17,1263,'Prvi',26),(18,1264,'První',26),(19,1265,'Første',26),(20,1266,'Eerste',26),(21,1267,'First',26),(22,1268,'Esimese',26),(23,1269,'Unang',26),(24,1270,'Ensimmäinen',26),(25,1271,'Première',26),(26,1272,'Primeira',26),(27,1273,'Erste',26),(28,1274,'Πρώτα',26),(29,1275,'Premye',26),(30,1276,'ראשון',26),(31,1277,'पहले',26),(32,1278,'Első',26),(33,1279,'First',26),(34,1280,'Pertama',26),(35,1281,'An Chéad',26),(36,1282,'Primo',26),(37,1283,'最初の',26),(38,1284,'Pirmā',26),(39,1285,'Pirmosios',26),(40,1286,'Прво',26),(41,1287,'Pertama',26),(42,1288,'Ewwel',26),(43,1289,'Første',26),(44,1290,'اول',26),(45,1291,'Primeira',26),(46,1292,'În primul rând',26),(47,1293,'Первый',26),(48,1294,'Прва',26),(49,1295,'Prvé',26),(50,1296,'Prva',26),(51,1297,'En primer lugar',26),(52,1298,'Kwanza',26),(53,1299,'Första',26),(54,1300,'แรก',26),(55,1301,'Перший',26),(56,1302,'Đầu tiên',26),(57,1303,'Cyntaf',26),(58,1304,'ערשטער',26),(9,1305,'Vorige',27),(10,1306,'I mëparshëm',27),(11,1307,'السابقة',27),(12,1308,'Папярэдняя',27),(13,1309,'Предишна',27),(14,1310,'Anterior',27),(15,1311,'上一页',27),(16,1312,'上一頁',27),(17,1313,'Prethodna',27),(18,1314,'Předchozí',27),(19,1315,'Forrige',27),(20,1316,'Vorige',27),(21,1317,'Previous',27),(22,1318,'Eelmine',27),(23,1319,'Nakaraan',27),(24,1320,'Edellinen',27),(25,1321,'Précédent',27),(26,1322,'Anterior',27),(27,1323,'Zurück',27),(28,1324,'Προηγούμενη',27),(29,1325,'Previous',27),(30,1326,'קודם',27),(31,1327,'पिछला',27),(32,1328,'Előző',27),(33,1329,'Fyrri',27),(34,1330,'Sebelumnya',27),(35,1331,'Roimhe Seo',27),(36,1332,'Precedente',27),(37,1333,'前へ',27),(38,1334,'Iepriekšējais',27),(39,1335,'Ankstesnis',27),(40,1336,'Назад',27),(41,1337,'Sebelumnya',27),(42,1338,'Preċedenti',27),(43,1339,'Forrige',27),(44,1340,'قبلی',27),(45,1341,'Anterior',27),(46,1342,'Anterioare',27),(47,1343,'Предыдущая',27),(48,1344,'Претходни',27),(49,1345,'Predchádzajúci',27),(50,1346,'Prejšnja',27),(51,1347,'Anterior',27),(52,1348,'Previous',27),(53,1349,'Föregående',27),(54,1350,'ก่อน',27),(55,1351,'Попередня',27),(56,1352,'Trước',27),(57,1353,'Blaenorol',27),(58,1354,'פרייַערדיק',27),(9,1355,'Volgende',28),(10,1356,'Tjetër',28),(11,1357,'القادم',28),(12,1358,'Наступная',28),(13,1359,'Следваща',28),(14,1360,'Següent',28),(15,1361,'下一页',28),(16,1362,'下一頁',28),(17,1363,'Slijedeća',28),(18,1364,'Další',28),(19,1365,'Næste',28),(20,1366,'Volgende',28),(21,1367,'Next',28),(22,1368,'Järgmine',28),(23,1369,'Susunod',28),(24,1370,'Seuraava',28),(25,1371,'Suivant',28),(26,1372,'Seguinte',28),(27,1373,'Weiter',28),(28,1374,'Επόμενο',28),(29,1375,'Next',28),(30,1376,'הבא',28),(31,1377,'अगला',28),(32,1378,'Következő',28),(33,1379,'Next',28),(34,1380,'Berikutnya',28),(35,1381,'Ar Aghaidh',28),(36,1382,'Prossimo',28),(37,1383,'次へ',28),(38,1384,'Nākamā',28),(39,1385,'Kitas',28),(40,1386,'Следна',28),(41,1387,'Kemudian',28),(42,1388,'Li jmiss',28),(43,1389,'Neste',28),(44,1390,'بعدی',28),(45,1391,'Seguinte',28),(46,1392,'Următorul',28),(47,1393,'Следующая',28),(48,1394,'Следећа',28),(49,1395,'Ďalší',28),(50,1396,'Naprej',28),(51,1397,'Siguiente',28),(52,1398,'Ijayo',28),(53,1399,'Nästa',28),(54,1400,'ถัดไป',28),(55,1401,'Наступна',28),(56,1402,'Tiếp theo',28),(57,1403,'Nesaf',28),(58,1404,'ווייַטער',28),(9,1405,'Einde',29),(10,1406,'Fund',29),(11,1407,'نهاية',29),(12,1408,'Канец',29),(13,1409,'Край',29),(14,1410,'Fi',29),(15,1411,'完',29),(16,1412,'完',29),(17,1413,'Kraju',29),(18,1414,'Konec',29),(19,1415,'End',29),(20,1416,'Einde',29),(21,1417,'End',29),(22,1418,'Aasta lõpuks',29),(23,1419,'Katapusan',29),(24,1420,'Lopussa',29),(25,1421,'Fin',29),(26,1422,'Fin',29),(27,1423,'Ende',29),(28,1424,'Τέλος',29),(29,1425,'Fen',29),(30,1426,'בסוף',29),(31,1427,'अंत',29),(32,1428,'Vége',29),(33,1429,'End',29),(34,1430,'Akhir',29),(35,1431,'Deireadh',29),(36,1432,'Fine',29),(37,1433,'終了',29),(38,1434,'Beigās',29),(39,1435,'Pabaigos',29),(40,1436,'Крајот',29),(41,1437,'Akhir',29),(42,1438,'Tmiem',29),(43,1439,'Slutt',29),(44,1440,'پایان',29),(45,1441,'Fim',29),(46,1442,'Capăt',29),(47,1443,'Конец',29),(48,1444,'Крај',29),(49,1445,'Koniec',29),(50,1446,'End',29),(51,1447,'Fin',29),(52,1448,'Mwisho',29),(53,1449,'Avsluta',29),(54,1450,'ท้าย',29),(55,1451,'Кінець',29),(56,1452,'Cuối',29),(57,1453,'Diwedd',29),(58,1454,'ענדיקן',29),(9,1455,'Vrag Versuim',30),(10,1456,'Dështimi Load',30),(11,1457,'فشل تحميل',30),(12,1458,'Load Failure',30),(13,1459,'Разрушаващо натоварване',30),(14,1460,'La manca de càrrega',30),(15,1461,'加载失败',30),(16,1462,'加載失敗',30),(17,1463,'Učitaj Neuspjeh',30),(18,1464,'Zatížení selhání',30),(19,1465,'Belastning Manglende',30),(20,1466,'Load Failure',30),(21,1467,'Load Failure',30),(22,1468,'Load jätmine',30),(23,1469,'Load Kabiguang',30),(24,1470,'Kuorman jättäminen',30),(25,1471,'Échec du chargement',30),(26,1472,'Falla de carga',30),(27,1473,'Load Failure',30),(28,1474,'Αποτυχία φόρτωσης',30),(29,1475,'Si w chaj',30),(30,1476,'טען כישלון',30),(31,1477,'लोड करने में विफलता',30),(32,1478,'Töltsön hiba',30),(33,1479,'Hlaða Failure',30),(34,1480,'Load Kegagalan',30),(35,1481,'Failure Luchtaigh',30),(36,1482,'Carico di rottura',30),(37,1483,'負荷障害',30),(38,1484,'Slodzes Ja',30),(39,1485,'Įkelti neįvykdymas',30),(40,1486,'Оптоварување Неуспехот',30),(41,1487,'Load Kegagalan',30),(42,1488,'Nuqqas Tagħbija',30),(43,1489,'Last inn Failure',30),(44,1490,'شکست بار',30),(45,1491,'Falha de carga',30),(46,1492,'Nerespectarea de încărcare',30),(47,1493,'Load Failure',30),(48,1494,'Учитај неуспех',30),(49,1495,'Zaťaženie zlyhanie',30),(50,1496,'Naloži Če',30),(51,1497,'La falta de carga',30),(52,1498,'Mzigo Kushindwa',30),(53,1499,'Fyll Underlåtenhet',30),(54,1500,'ความล้มเหลวในการโหลด',30),(55,1501,'Load Failure',30),(56,1502,'Không tải',30),(57,1503,'Methiant Llwytho',30),(58,1504,'מאַסע פאַילורע',30),(9,1505,'Kliënt Ongeldige',31),(10,1506,'Klienti i pavlefshëm',31),(11,1507,'عميل غير صالح',31),(12,1508,'Кліент Няправільны',31),(13,1509,'Клиент Невалидна',31),(14,1510,'Client no és vàlid',31),(15,1511,'客户无效',31),(16,1512,'客戶無效',31),(17,1513,'Klijent nije valjan',31),(18,1514,'Klient Neplatná',31),(19,1515,'Client Ugyldig',31),(20,1516,'Opdrachtgever Ongeldige',31),(21,1517,'Client Invalid',31),(22,1518,'Klient Vigane',31),(23,1519,'Client Hindi wastong',31),(24,1520,'Asiakas ei kelpaa',31),(25,1521,'Client Blancs',31),(26,1522,'Cliente non válido',31),(27,1523,'Ungültige Client',31),(28,1524,'Πελάτης Άκυρα',31),(29,1525,'Kliyan envalid',31),(30,1526,'לקוח לא חוקית',31),(31,1527,'ग्राहक अवैध',31),(32,1528,'Érvénytelen kliens',31),(33,1529,'Viðskiptavinur Ógilt',31),(34,1530,'Klien tidak valid',31),(35,1531,'Cliant neamhbhailí',31),(36,1532,'Client non valida',31),(37,1533,'クライアントが無効です',31),(38,1534,'Klientu Nederīgs',31),(39,1535,'Kliento Neteisingas',31),(40,1536,'Невалиден клиент',31),(41,1537,'Pelanggan tidak sah',31),(42,1538,'Klijent Invalid',31),(43,1539,'Client Ugyldig',31),(44,1540,'کارفرما نامعتبر',31),(45,1541,'Cliente inválido',31),(46,1542,'Client nevalid',31),(47,1543,'Клиент Неверный',31),(48,1544,'Клијент Неважећи',31),(49,1545,'Klient Neplatná',31),(50,1546,'Client Invalid',31),(51,1547,'Cliente no es válido',31),(52,1548,'Mteja batili',31),(53,1549,'Client Ogiltig',31),(54,1550,'Client ไม่ถูกต้อง',31),(55,1551,'Клієнт Невірний',31),(56,1552,'Khách hàng không hợp lệ',31),(57,1553,'Cleient annilys',31),(58,1554,'קליענט אומלעקסיקער',31),(9,1555,'Verband Versuim',32),(10,1556,'Dështimi Connection',32),(11,1557,'فشل في الاتصال',32),(12,1558,'Памылка злучэння',32),(13,1559,'Грешка при свързване',32),(14,1560,'La manca de connexió',32),(15,1561,'连接失败',32),(16,1562,'連接失敗',32),(17,1563,'Veza Neuspjeh',32),(18,1564,'Chyba připojení',32),(19,1565,'Tilslutning Manglende',32),(20,1566,'Verbinding mislukt',32),(21,1567,'Connection Failure',32),(22,1568,'Connection jätmine',32),(23,1569,'Connection Kabiguang',32),(24,1570,'Yhteyden jättäminen',32),(25,1571,'Échec de connexion',32),(26,1572,'Fallou a conexión',32),(27,1573,'Verbindungsfehler',32),(28,1574,'Παράλειψη σύνδεσης',32),(29,1575,'Echèk Connection',32),(30,1576,'כשל בחיבור',32),(31,1577,'कनेक्शन विफलता',32),(32,1578,'Csatlakozási hiba',32),(33,1579,'Connection Failure',32),(34,1580,'Kegagalan Koneksi',32),(35,1581,'Failure Ceangal',32),(36,1582,'Errore di connessione',32),(37,1583,'接続障害',32),(38,1584,'Savienojuma Kļūda',32),(39,1585,'Ryšio gedimas',32),(40,1586,'Поврзување Неуспех',32),(41,1587,'Kegagalan Koneksi',32),(42,1588,'Nuqqas Konnessjoni',32),(43,1589,'Tilkobling Failure',32),(44,1590,'عدم اتصال',32),(45,1591,'Falha na conexão',32),(46,1592,'Conexiune Nerespectarea',32),(47,1593,'Ошибка соединения',32),(48,1594,'Цоннецтион фаилуре',32),(49,1595,'Chyba pripojenia',32),(50,1596,'Če povezava',32),(51,1597,'La falta de conexión',32),(52,1598,'Uhusiano Kushindwa',32),(53,1599,'Anslutningsfel',32),(54,1600,'ความล้มเหลวในการเชื่อมต่อ',32),(55,1601,'Помилка з&#39;єднання',32),(56,1602,'Không kết nối',32),(57,1603,'Methiant Cysylltiad',32),(58,1604,'קשר פאַילורע',32),(9,1605,'Bediener Response Ongeldige',33),(10,1606,'Përgjigje Server pavlefshme',33),(11,1607,'استجابة ملقم غير صالح',33),(12,1608,'Няправільны адказ сервера',33),(13,1609,'Отговор на сървъра Невалидна',33),(14,1610,'Resposta del servidor no vàlid',33),(15,1611,'服务器响应无效',33),(16,1612,'服務器響應無效',33),(17,1613,'Odgovor poslužitelja nije valjana',33),(18,1614,'Odezva serveru Neplatná',33),(19,1615,'Server Response Ugyldig',33),(20,1616,'Reactie van server Ongeldig',33),(21,1617,'Server Response Invalid',33),(22,1618,'Server Response Vigane',33),(23,1619,'Server Response Hindi wastong',33),(24,1620,'Palvelimen vastaus ei kelpaa',33),(25,1621,'Réponse du serveur invalide',33),(26,1622,'Resposta non válida do servidor',33),(27,1623,'Ungültige Server-Antwort',33),(28,1624,'Ανταπόκριση Server Άκυρα',33),(29,1625,'Repons Server envalid',33),(30,1626,'תגובת שרת לא חוקי',33),(31,1627,'सर्वर प्रतिक्रिया अमान्य',33),(32,1628,'Kiszolgáló válasza érvénytelen',33),(33,1629,'Server Response Ógilt',33),(34,1630,'Respon server tidak valid',33),(35,1631,'Freagra Freastalaí neamhbhailí',33),(36,1632,'Risposta del server non valida',33),(37,1633,'サーバーの応答が無効です',33),(38,1634,'Servera atbilde Nederīgs',33),(39,1635,'Serveris atsako Neteisingas',33),(40,1636,'Невалиден одговор од серверот',33),(41,1637,'Respon pelayan tidak sah',33),(42,1638,'Rispons Server Invalid',33),(43,1639,'Server Response Ugyldig',33),(44,1640,'پاسخ کارساز نامعتبر است',33),(45,1641,'Resposta inválida do servidor',33),(46,1642,'Server răspuns nevalid',33),(47,1643,'Неверный ответ сервера',33),(48,1644,'Одговор сервера Неважећи',33),(49,1645,'Odozva servera Neplatná',33),(50,1646,'Odgovor strežnika Invalid',33),(51,1647,'Respuesta del servidor no válido',33),(52,1648,'Response server batili',33),(53,1649,'Server Response Ogiltig',33),(54,1650,'Server ตอบสนองไม่ถูกต้อง',33),(55,1651,'Неправильна відповідь сервера',33),(56,1652,'Server đáp ứng không hợp lệ',33),(57,1653,'Ymateb annilys Gweinydd',33),(58,1654,'סערווירער רעספּאָנסע אומלעקסיקער',33),(9,1655,'Optrede',34),(10,1656,'Veprim',34),(11,1657,'عمل',34),(12,1658,'Дзеянняў',34),(13,1659,'Действие',34),(14,1660,'Acció',34),(15,1661,'行动',34),(16,1662,'行動',34),(17,1663,'Akcija',34),(18,1664,'Akce',34),(19,1665,'Handling',34),(20,1666,'Actie',34),(21,1667,'Action',34),(22,1668,'Tegevuskava',34),(23,1669,'Aksyon',34),(24,1670,'Toiminta',34),(25,1671,'Action',34),(26,1672,'Acción',34),(27,1673,'Aktion',34),(28,1674,'Δράση',34),(29,1675,'Aksyon',34),(30,1676,'פעולה',34),(31,1677,'कार्रवाई',34),(32,1678,'Cselekvési',34),(33,1679,'Action',34),(34,1680,'Tindakan',34),(35,1681,'Gníomh',34),(36,1682,'Azione',34),(37,1683,'アクション',34),(38,1684,'Darbības',34),(39,1685,'Veiksmų',34),(40,1686,'Акција',34),(41,1687,'Tindakan',34),(42,1688,'Azzjoni',34),(43,1689,'Action',34),(44,1690,'اقدام',34),(45,1691,'Ação',34),(46,1692,'Acţiune',34),(47,1693,'Действий',34),(48,1694,'Акција',34),(49,1695,'Akcia',34),(50,1696,'Ukrep',34),(51,1697,'Acción',34),(52,1698,'Hatua',34),(53,1699,'Åtgärd',34),(54,1700,'การกระทำ',34),(55,1701,'Дій',34),(56,1702,'Hành động',34),(57,1703,'Gweithredu',34),(58,1704,'אַקציע',34),(9,1705,'Skep deur',35),(10,1706,'Krijo Nga',35),(11,1707,'بإنشائها',35),(12,1708,'Стварыць па',35),(13,1709,'Създаване С',35),(14,1710,'En crear',35),(15,1711,'创建',35),(16,1712,'創建',35),(17,1713,'Napravi Po',35),(18,1714,'Vytvořil',35),(19,1715,'Opret Ved',35),(20,1716,'Te creëren door',35),(21,1717,'By',35),(22,1718,'Loo aasta',35),(23,1719,'Gumawa By',35),(24,1720,'Luo Tekijä',35),(25,1721,'Créé par',35),(26,1722,'Ao crear',35),(27,1723,'Erstellen Durch',35),(28,1724,'Δημιουργία Με',35),(29,1725,'Kreye By',35),(30,1726,'יוצר',35),(31,1727,'बनाएँ तक',35),(32,1728,'Létrehozása által',35),(33,1729,'Búa By',35),(34,1730,'Buat Dengan',35),(35,1731,'Cruthaigh De',35),(36,1732,'Creare con la',35),(37,1733,'を作成することにより',35),(38,1734,'Izveidot Pēc',35),(39,1735,'Sukurti Iki',35),(40,1736,'Креирај Со',35),(41,1737,'Buat Dengan',35),(42,1738,'Oħloq Permezz',35),(43,1739,'Lag Av',35),(44,1740,'ایجاد شده توسط',35),(45,1741,'Ao criar',35),(46,1742,'Prin crea',35),(47,1743,'Создать по',35),(48,1744,'Креирате',35),(49,1745,'Vytvoril',35),(50,1746,'Ustvarite Z',35),(51,1747,'Al crear',35),(52,1748,'Kwa kujenga',35),(53,1749,'Skapa av',35),(54,1750,'สร้างโดย',35),(55,1751,'Створити по',35),(56,1752,'Tạo Bởi',35),(57,1753,'Creu Erbyn',35),(58,1754,'שאַפֿן דורך',35),(9,1755,'Skep Tyd',36),(10,1756,'Krijo Time',36),(11,1757,'إنشاء الوقت',36),(12,1758,'Час стварэння',36),(13,1759,'Създаване на времето',36),(14,1760,'Crear Temps',36),(15,1761,'创建时间',36),(16,1762,'創建時間',36),(17,1763,'Napravi Vrijeme',36),(18,1764,'Vytvořit čas',36),(19,1765,'Opret Time',36),(20,1766,'Maak tijd',36),(21,1767,'Time',36),(22,1768,'Loo Time',36),(23,1769,'Gumawa ng Time',36),(24,1770,'Luo Time',36),(25,1771,'Créer Time',36),(26,1772,'Crear Time',36),(27,1773,'Erstellen Time',36),(28,1774,'Δημιουργία Χρόνος',36),(29,1775,'Kreye Tan',36),(30,1776,'יצירת זמן',36),(31,1777,'समय बनाएँ',36),(32,1778,'Idő létrehozása',36),(33,1779,'Búa Time',36),(34,1780,'Membuat Waktu',36),(35,1781,'Am Cruthaigh',36),(36,1782,'Crea Time',36),(37,1783,'時間を作成する',36),(38,1784,'Izveidot laiks',36),(39,1785,'Sukūrimo laikas',36),(40,1786,'Креирај Време',36),(41,1787,'Membuat Waktu',36),(42,1788,'Oħloq Ħin',36),(43,1789,'Lag Time',36),(44,1790,'زمان ایجاد',36),(45,1791,'Criar Time',36),(46,1792,'Timp de a crea',36),(47,1793,'Время создания',36),(48,1794,'Креирање Време',36),(49,1795,'Vytvoriť čas',36),(50,1796,'Ustvari Time',36),(51,1797,'Crear Tiempo',36),(52,1798,'Kujenga Time',36),(53,1799,'Skapa tid',36),(54,1800,'เวลาที่สร้าง',36),(55,1801,'Час створення',36),(56,1802,'Tạo Thời gian',36),(57,1803,'Creu Amser',36),(58,1804,'שאַפֿן צייט',36),(9,1805,'Gewysig deur',37),(10,1806,'Modifikuar nga',37),(11,1807,'تم تعديلها من قبل',37),(12,1808,'Аўтар змяненняў',37),(13,1809,'Променен от',37),(14,1810,'Modificat per',37),(15,1811,'修改者',37),(16,1812,'修改者',37),(17,1813,'Izmijenio',37),(18,1814,'Změnil',37),(19,1815,'Ændret af',37),(20,1816,'Gewijzigd door',37),(21,1817,'Modified By',37),(22,1818,'Muutja',37),(23,1819,'Modified By',37),(24,1820,'Muokkaaja',37),(25,1821,'Modifié par',37),(26,1822,'Modificado por',37),(27,1823,'Geändert von',37),(28,1824,'Τροποποιήθηκε από',37),(29,1825,'Edite By',37),(30,1826,'שונה על ידי',37),(31,1827,'द्वारा संशोधित',37),(32,1828,'Módosította',37),(33,1829,'Modified By',37),(34,1830,'Modifikasi Dengan',37),(35,1831,'De Athraithe',37),(36,1832,'Modificato da',37),(37,1833,'更新者',37),(38,1834,'Grozījumi izdarīti ar',37),(39,1835,'Modifikavo',37),(40,1836,'Пат од страна',37),(41,1837,'Modifikasi Dengan',37),(42,1838,'Modifikat Permezz',37),(43,1839,'Endret av',37),(44,1840,'اصلاح شده توسط',37),(45,1841,'Modificado por',37),(46,1842,'Modificat de',37),(47,1843,'Автор изменений',37),(48,1844,'Модификована',37),(49,1845,'Zmenil',37),(50,1846,'Spremenil',37),(51,1847,'Modificado por',37),(52,1848,'Iliyopita Kwa',37),(53,1849,'Ändrad av',37),(54,1850,'ปรับเปลี่ยนโดย',37),(55,1851,'Автор змін',37),(56,1852,'Sửa đổi theo',37),(57,1853,'Addaswyd yn Erbyn',37),(58,1854,'מאדיפיצירט דורך',37),(9,1855,'Modified Tyd',38),(10,1856,'Ndryshuar Time',38),(11,1857,'تعديل التوقيت',38),(12,1858,'Час змены',38),(13,1859,'Време на промяна',38),(14,1860,'Modificat Temps',38),(15,1861,'修改时间',38),(16,1862,'修改時間',38),(17,1863,'Promjena Vrijeme',38),(18,1864,'Modifikovaná čas',38),(19,1865,'Modificerede Time',38),(20,1866,'Gewijzigd Tijd',38),(21,1867,'Modified Time',38),(22,1868,'Muudetud aeg',38),(23,1869,'Binagong Oras',38),(24,1870,'Muokattu aika',38),(25,1871,'Mise à jour Temps',38),(26,1872,'Modificado Tempo',38),(27,1873,'Geändert Time',38),(28,1874,'Τροποποιημένο Χρόνος',38),(29,1875,'Edite Tan',38),(30,1876,'השתנה זמן',38),(31,1877,'संशोधित टाइम',38),(32,1878,'Módosított idő',38),(33,1879,'Tímabreyting',38),(34,1880,'Modifikasi Waktu',38),(35,1881,'Am Athraithe',38),(36,1882,'Modified Time',38),(37,1883,'修正時間',38),(38,1884,'Modificētais laiks',38),(39,1885,'Modifikuotas Laikas',38),(40,1886,'Време е изменета',38),(41,1887,'Modifikasi Waktu',38),(42,1888,'Modifikat Ħin',38),(43,1889,'Modifisert Time',38),(44,1890,'تغییر ساعت',38),(45,1891,'Modificado Tempo',38),(46,1892,'Modificat Time',38),(47,1893,'Время изменения',38),(48,1894,'Модификовани Време',38),(49,1895,'Modifikovaná čas',38),(50,1896,'Spremenjen čas',38),(51,1897,'Modificado Tiempo',38),(52,1898,'Iliyopita Time',38),(53,1899,'Ändrad tid',38),(54,1900,'เวลาแก้ไข',38),(55,1901,'Час зміни',38),(56,1902,'Được thay đổi Thời gian',38),(57,1903,'Addaswyd Amser',38),(58,1904,'מאדיפיצירט צייט',38),(9,1905,'Leë Row',39),(10,1906,'Row Empty',39),(11,1907,'فارغة الصف',39),(12,1908,'Пустая радок',39),(13,1909,'Празен ред',39),(14,1910,'Fila buida',39),(15,1911,'空行',39),(16,1912,'空行',39),(17,1913,'Prazan redak',39),(18,1914,'Prázdný řádek',39),(19,1915,'Tomme Row',39),(20,1916,'Lege rij',39),(21,1917,'Empty Row',39),(22,1918,'Tühi rida',39),(23,1919,'Walang laman ang Hilera',39),(24,1920,'Tyhjä rivi',39),(25,1921,'Ligne vide',39),(26,1922,'Liña baleira',39),(27,1923,'Leere Zeile',39),(28,1924,'Κενή γραμμή',39),(29,1925,'Vid Ranje',39),(30,1926,'ריק שורה',39),(31,1927,'खाली पंक्ति',39),(32,1928,'Üres sor',39),(33,1929,'Tóm Row',39),(34,1930,'Baris Kosong',39),(35,1931,'Ró Folamh',39),(36,1932,'Riga vuota',39),(37,1933,'空行',39),(38,1934,'Tukša rinda',39),(39,1935,'Tuščia eilutė',39),(40,1936,'Празен ред',39),(41,1937,'Baris Kosong',39),(42,1938,'Empty Ringiela',39),(43,1939,'Tomme Row',39),(44,1940,'سطر خالی',39),(45,1941,'Linha vazia',39),(46,1942,'Gol Row',39),(47,1943,'Пустая строка',39),(48,1944,'Празан ред',39),(49,1945,'Prázdny riadok',39),(50,1946,'Prazne Row',39),(51,1947,'Fila vacía',39),(52,1948,'Row tupu',39),(53,1949,'Tomma raden',39),(54,1950,'แถวว่าง',39),(55,1951,'Порожній рядок',39),(56,1952,'Empty Row',39),(57,1953,'Rhes Gwag',39),(58,1954,'נוליקע ראָוו',39),(9,1955,'Check Alle',40),(10,1956,'Kontrollo të gjitha',40),(11,1957,'الاختيار الكل',40),(12,1958,'Праверце ўсе',40),(13,1959,'Проверка на всички',40),(14,1960,'Comprovar tots els',40),(15,1961,'全部选中',40),(16,1962,'全部選中',40),(17,1963,'Provjerite sve',40),(18,1964,'Zkontrolujte, zda všechny',40),(19,1965,'Check Alle',40),(20,1966,'Check All',40),(21,1967,'Check All',40),(22,1968,'Kontrolli kõik',40),(23,1969,'Suriin ang Lahat',40),(24,1970,'Valitse kaikki',40),(25,1971,'Vérifier tous les',40),(26,1972,'Consulte todas as',40),(27,1973,'Check All',40),(28,1974,'Ελέγξτε Όλες',40),(29,1975,'Tcheke tout sa',40),(30,1976,'לבדוק את כל',40),(31,1977,'सभी की जाँच करें',40),(32,1978,'Összes ellenőrzése',40),(33,1979,'Check All',40),(34,1980,'Periksa Semua',40),(35,1981,'Seiceáil go léir',40),(36,1982,'Check All',40),(37,1983,'すべてをチェック',40),(38,1984,'Pārbaudīt visus',40),(39,1985,'Pažymėti visus',40),(40,1986,'Провери ги сите',40),(41,1987,'Semak Semua',40),(42,1988,'Iċċekkja kollha',40),(43,1989,'Sjekk alle',40),(44,1990,'انتخاب همه',40),(45,1991,'Confira todas as',40),(46,1992,'Verifica toate',40),(47,1993,'Проверьте все',40),(48,1994,'Проверите све',40),(49,1995,'Skontrolujte, či všetky',40),(50,1996,'Preverite Vse',40),(51,1997,'Comprobar todos los',40),(52,1998,'Kuangalia zote',40),(53,1999,'Markera alla',40),(54,2000,'เลือกทั้งหมด',40),(55,2001,'Перевірте всі',40),(56,2002,'Chọn tất cả',40),(57,2003,'Gwirio Pob',40),(58,2004,'קוק אַלע',40),(9,2005,'Alles',41),(10,2006,'Qartë të gjitha',41),(11,2007,'مسح الكل',41),(12,2008,'Ачысціць усе',41),(13,2009,'Изчистване на всички',41),(14,2010,'Esborrar tots',41),(15,2011,'全部清除',41),(16,2012,'全部清除',41),(17,2013,'Obriši sve',41),(18,2014,'Vymazat vše',41),(19,2015,'Ryd alle',41),(20,2016,'Alles wissen',41),(21,2017,'Clear All',41),(22,2018,'Kustuta kõik',41),(23,2019,'Maaliwalas Lahat',41),(24,2020,'Tyhjennä kaikki',41),(25,2021,'Effacer tout',41),(26,2022,'Borrar todo',41),(27,2023,'Clear All',41),(28,2024,'Καθαρισμός Όλων',41),(29,2025,'Tout klè',41),(30,2026,'נקה הכל',41),(31,2027,'सभी साफ़',41),(32,2028,'Az összes törlése',41),(33,2029,'Clear All',41),(34,2030,'Hapus Semua',41),(35,2031,'Gach Glan',41),(36,2032,'Cancella tutto',41),(37,2033,'[すべてクリア]',41),(38,2034,'Notīrīt visu',41),(39,2035,'Išvalyti visus',41),(40,2036,'Исчисти ги сите',41),(41,2037,'Padam Semua',41),(42,2038,'Clear kollha',41),(43,2039,'Fjern alle',41),(44,2040,'پاک کردن همه',41),(45,2041,'Limpar tudo',41),(46,2042,'Toate clar',41),(47,2043,'Очистить все',41),(48,2044,'Обриши све',41),(49,2045,'Vymazať všetko',41),(50,2046,'Počisti vse',41),(51,2047,'Borrar todos',41),(52,2048,'Wazi zote',41),(53,2049,'Rensa alla',41),(54,2050,'ล้างทั้งหมด',41),(55,2051,'Очистити всі',41),(56,2052,'Clear All',41),(57,2053,'Clear Pob',41),(58,2054,'קלאָר אַלע',41),(21,2055,'Upload',42),(21,2056,'Record not Found',43),(21,2057,'Please Choose a Record ?',44),(21,2058,'Save',45),(21,2059,'Cancel',46),(21,2060,'Check Duplicate Code ?',47);
/*!40000 ALTER TABLE `defaultlabeltranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `departmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `departmentSequence` int(11) NOT NULL,
  `departmentCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `departmentEnglish` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isDefault` tinyint(1) NOT NULL COMMENT 'Default|',
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`departmentId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,0,'','Pentabiran',0,0,1,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(2,2,'xx','xxrate',1,0,1,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(3,1,'2','3',0,0,1,0,0,0,1,0,0,0,2,'2011-08-25 12:25:49'),(4,1,'3','4',0,0,0,0,1,0,1,0,0,0,2,'2011-08-25 12:31:25');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `documentId` int(11) NOT NULL AUTO_INCREMENT,
  `documentCategoryId` int(11) NOT NULL,
  `leafId` int(11) NOT NULL,
  `documentCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `DocumentSequence` int(11) NOT NULL,
  `documentNote` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `documentTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `documentDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `documentPath` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `documentOriginalFilename` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `documentDownloadFilename` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `documentExtension` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `documentVersion` int(11) NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`documentId`),
  KEY `documentCategoryId` (`documentCategoryId`),
  KEY `leafId` (`leafId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
INSERT INTO `document` VALUES (1,0,512,'',0,'','','','','39396-1287155243.jpg','2011-08-22-23504.xlsx','',1,0,1,0,0,0,1,0,0,0,2,'2011-08-22 21:29:39'),(2,3,512,'',0,'','','','C:/inetpub/wwwroot/idcmsCore/document/document/user/2/','cv.pdf','cv-28628pdf','pdf',1,0,1,0,0,0,1,0,0,0,2,'2011-08-25 08:28:18');
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentcategory`
--

DROP TABLE IF EXISTS `documentcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentcategory` (
  `documentCategoryId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Document|',
  `documentCategoryTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `documentCategoryDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `documentCategorySequence` int(11) NOT NULL,
  `documentCategoryCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `documentCategoryEnglish` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `IsUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`documentCategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Document Category Audit Trail';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentcategory`
--

LOCK TABLES `documentcategory` WRITE;
/*!40000 ALTER TABLE `documentcategory` DISABLE KEYS */;
INSERT INTO `documentcategory` VALUES (3,'System Audit Trail','System Audit Trail',0,'','',0,1,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(5,'ab','k',7,'k','j',0,0,0,1,0,1,0,0,0,2,'2011-07-17 09:48:23');
/*!40000 ALTER TABLE `documentcategory` ENABLE KEYS */;
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
  KEY `calendarId` (`calendarId`),
  CONSTRAINT `event_ibfk_1` FOREIGN KEY (`calendarId`) REFERENCES `calendar` (`calendarId`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,1,'koko','','2011-08-01 00:00:00','2011-08-01 01:00:00','','','',0,0,'',2,'2011-08-11 13:02:41'),(2,1,'jikalai','','2011-08-02 00:00:00','2011-08-02 01:00:00','','','',0,0,'',2,'2011-08-11 13:03:52'),(3,1,'donmo','','2011-08-03 00:00:00','2011-08-03 01:00:00','','','',0,0,'',2,'2011-08-11 13:05:05'),(4,1,'ll','','2011-08-10 00:00:00','2011-08-10 01:00:00','','','',0,0,'',2,'2011-08-11 13:06:06'),(5,1,'koko','','2011-08-09 00:00:00','2011-08-09 01:00:00','','','',0,0,'',2,'2011-08-11 13:07:25'),(6,1,'koko','','2011-08-04 00:00:00','2011-08-04 01:00:00','','','',0,0,'',2,'2011-08-11 13:37:30'),(7,1,'koko','','2011-08-12 00:00:00','2011-08-12 01:00:00','','','',0,0,'',2,'2011-08-11 13:38:16'),(8,1,'ayam','','2011-08-13 00:00:00','2011-08-13 01:00:00','','','',0,0,'',2,'2011-08-11 13:39:01'),(9,1,'jeng jeng','','2011-08-14 00:00:00','2011-08-14 01:00:00','','','',0,0,'',2,'2011-08-11 13:40:17'),(10,1,'helmi kena jumpa sekali dengan mpk hoho','','2011-08-15 00:00:00','2011-08-15 01:00:00','','','',0,0,'',2,'2011-08-11 13:41:22'),(11,1,'macd','','2011-08-16 00:00:00','2011-08-16 01:00:00','','','',0,0,'',2,'2011-08-11 13:45:39'),(12,1,'letih ohh ......yaa beli mouse baru','','2011-08-08 00:00:00','2011-08-08 01:00:00','','','',0,0,'',2,'2011-08-12 21:10:56'),(13,1,'fsdf','','2011-08-17 00:00:00','2011-08-17 01:00:00','','','',0,0,'',2,'2011-08-12 21:18:21'),(14,1,'checking figure kospek','','2011-08-18 09:15:00','2011-08-18 10:00:00','','','',0,0,'',2,'2011-08-18 07:40:31'),(15,2,'tengok kereta dulu...','','2011-08-18 09:00:00','2011-08-18 10:00:00','','','',0,0,'',2,'2011-08-18 07:41:20'),(16,1,'Pergi MPK  Jumpa Jimmy if exist','','2011-08-18 14:00:00','2011-08-18 16:00:00','0','','',0,0,'',2,'2011-08-18 07:47:20'),(17,4,'tukar color  tepi calendar  dan calendar bagi default color...','','2011-08-18 20:00:00','2011-08-18 21:00:00','','','',0,0,'',2,'2011-08-18 08:07:40'),(18,2,'buka puasa donn.','','2011-08-18 19:30:00','2011-08-18 20:00:00','','','',0,0,'',2,'2011-08-18 08:08:04'),(19,2,'Bayar bill air da...','','2011-08-18 12:00:00','2011-08-18 13:00:00','','','',0,0,'',2,'2011-08-18 08:08:25'),(21,1,'','','2011-08-25 02:30:00','2011-08-25 04:30:00','0','','',0,0,'',2,'2011-08-25 12:05:33'),(22,1,'','','2011-08-25 00:30:00','2011-08-25 02:30:00','0','','',0,0,'',2,'2011-08-25 12:07:00'),(23,1,'','','2011-08-22 00:30:00','2011-08-22 01:30:00','','','',0,0,'',2,'2011-08-25 12:10:39'),(24,1,'','','2011-08-23 01:00:00','2011-08-23 02:00:00','','','',0,0,'',2,'2011-08-25 12:10:48'),(25,1,'tesitngo','','2011-08-21 00:00:00','2011-08-21 01:00:00','','','',0,0,'',2,'2011-08-25 12:23:52'),(26,1,'Update Department dan review yang staff tak samaa','','2011-09-05 09:00:00','2011-09-05 11:00:00','','','',0,0,'',2,'2011-09-05 08:43:12'),(27,1,'testingo','','2011-10-26 00:00:00','2011-10-26 01:00:00','','','',0,0,'',2,'2011-10-28 10:01:58'),(28,1,'aaaa','','2011-10-03 00:00:00','2011-10-03 01:00:00','','','',0,0,'',2,'2011-10-28 10:03:11'),(29,1,'jfj','','2011-11-14 00:00:00','2011-11-14 01:00:00','0','','',0,0,'',2,'2011-11-02 07:26:12'),(30,3,'uiks','','2011-11-15 00:00:00','2011-11-15 01:00:00','','','',0,0,'',2,'2011-11-08 16:18:40'),(31,1,'lollool','','2011-11-07 00:00:00','2011-11-07 01:00:00','0','','',0,0,'',2,'2011-11-08 16:20:22'),(32,1,'sdfsdfdsf','','0000-00-00 00:00:00','0000-00-00 00:00:00','','','',0,0,'',2,'2011-11-17 15:24:15'),(33,1,'sdfsdfdsf','','0000-00-00 00:00:00','0000-00-00 00:00:00','','','',0,0,'',2,'2011-11-17 15:24:23'),(34,1,'dsfdsf','','0000-00-00 00:00:00','0000-00-00 00:00:00','','','',0,0,'',2,'2011-11-17 15:24:39');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extlabel`
--

DROP TABLE IF EXISTS `extlabel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extlabel` (
  `extLabelId` int(11) NOT NULL AUTO_INCREMENT,
  `extLabeLEnglish` varchar(32) NOT NULL,
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
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`extLabelId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extlabel`
--

LOCK TABLES `extlabel` WRITE;
/*!40000 ALTER TABLE `extlabel` DISABLE KEYS */;
/*!40000 ALTER TABLE `extlabel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extlabeltranslate`
--

DROP TABLE IF EXISTS `extlabeltranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extlabeltranslate` (
  `extLabelTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Label|',
  `extLabelId` int(11) NOT NULL,
  `languageId` int(11) NOT NULL,
  `extLabelNative` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Native|',
  PRIMARY KEY (`extLabelTranslateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extlabeltranslate`
--

LOCK TABLES `extlabeltranslate` WRITE;
/*!40000 ALTER TABLE `extlabeltranslate` DISABLE KEYS */;
/*!40000 ALTER TABLE `extlabeltranslate` ENABLE KEYS */;
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
-- Table structure for table `folder`
--

DROP TABLE IF EXISTS `folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder` (
  `folderId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'folder|',
  `applicationId` int(11) NOT NULL,
  `moduleId` int(11) NOT NULL COMMENT 'Tab|',
  `iconId` int(11) NOT NULL DEFAULT '281' COMMENT 'Icon|',
  `folderSequence` int(11) NOT NULL COMMENT 'Sequence|',
  `folderCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `folderPath` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Path|',
  `folderEnglish` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`folderId`),
  KEY `tabId` (`moduleId`),
  KEY `iconId` (`iconId`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folder`
--

LOCK TABLES `folder` WRITE;
/*!40000 ALTER TABLE `folder` DISABLE KEYS */;
INSERT INTO `folder` VALUES (1,1,1,281,1,'sys','system','System Entry',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(2,1,1,281,2,'sys','system','Common',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(3,1,2,281,1,'sys','system','Common',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(4,1,3,281,1,'sys','system','Common',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(5,2,4,281,1,'sys','sample','Single Form',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(6,2,4,491,2,'sys','sample','Multiplied Form',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(7,3,5,491,1,'gl','gl','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(8,3,24,491,2,'gl','gl','Budget',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(9,3,24,491,3,'gl','gl','Forecast',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(10,3,24,491,4,'gl','gl','Journal',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(11,5,6,281,1,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(12,5,25,491,2,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(13,5,7,491,1,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(14,6,15,281,1,'po','po','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(15,6,28,491,2,'po','po','Inventory and Purchasing',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(16,6,28,491,3,'po','po','Suppliers',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(17,6,28,491,5,'po','po','Shippers',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(18,6,35,841,6,'po','po','Reports',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(19,7,8,281,1,'mbr','mbr','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(20,7,19,491,1,'mbr','mbr','Dividen',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(21,7,36,841,4,'mbr','mbr','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(22,9,9,281,1,'bank','bank','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(23,9,20,491,1,'bank','bank','Bank ',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(24,13,10,281,1,'fa','fa','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(25,13,21,491,1,'fa','fa','Fix Asset',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(26,13,21,491,2,'fa','fa','Disposal',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(27,13,21,491,3,'fa','fa','Depreciation',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(28,13,21,491,4,'fa','fa','Write Off',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(29,13,21,491,5,'fa','fa','Adjustment',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(30,13,38,841,6,'fa','fa','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(31,14,11,281,1,'dm','dm','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(32,14,22,852,2,'dm','dm','Public',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(33,14,22,852,3,'dm','dm','Group',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(34,14,22,852,4,'dm','dm','Private',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(35,16,23,491,1,'py','py','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(36,16,13,491,1,'py','py','Designation',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(37,16,13,491,2,'py','py','Category',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(38,16,13,491,3,'py','py','Management',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(39,16,13,491,4,'py','py','Parameter',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(40,16,30,841,1,'py','py','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(41,17,14,491,1,'hr','hr','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(42,17,29,491,2,'hr','hr','Leave Management Module',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(43,17,29,491,3,'hr','hr','Recruitment Management',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(44,17,29,491,4,'hr','hr','Key Performance Index',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(45,17,40,841,1,'hr','hr','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(46,17,40,841,2,'hr','hr','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(47,3,32,841,1,'gl','gl','Financial Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(48,3,32,841,2,'gl','gl','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(49,5,34,841,1,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(50,5,34,841,2,'ap','ap','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(51,6,28,491,4,'po','po','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(52,7,36,841,5,'mbr','mbr','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(53,9,37,841,2,'bank','bank','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(54,9,37,841,3,'bank','bank','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(55,13,38,841,7,'fa','fa','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(56,16,30,841,2,'py','py','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(57,4,16,491,1,'ar','ar','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(58,4,27,491,2,'ar','ar','Invoice',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(59,4,27,491,3,'ar','ar','Adjustment',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(60,15,17,491,1,'cb','cb','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(61,15,12,652,2,'cb','cb','Reverse  Payment',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(62,15,12,652,3,'cb','cb','Refund Payment',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(63,4,33,841,4,'ar','ar','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(64,4,33,841,5,'ar','ar','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(65,15,26,841,4,'cb','cb','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(66,15,26,841,5,'cb','cb','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(67,1,31,281,1,'sys','system','Common',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(68,6,35,841,7,'po','po','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(69,7,18,491,2,'mbr','mbr','Membership',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(70,17,29,491,1,'hr','hr','Personal Information Management',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(71,6,28,491,1,'po','po','Customers And Orders',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(72,5,25,491,1,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(73,15,12,652,1,'cb','cb','Receive Payment',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(74,3,32,841,3,'gl','gl','Custom Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(75,3,24,281,1,'gl','gl','Chart Of Account',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(76,3,24,281,5,'','','Reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(77,4,27,491,1,'ar','ar','Sales',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(78,3,5,491,2,'gl','gl','Financial',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(79,4,27,491,4,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(80,4,27,491,5,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(81,4,27,491,6,'','','reserve',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folderaccess`
--

DROP TABLE IF EXISTS `folderaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folderaccess` (
  `folderAccessId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Access|',
  `teamId` int(11) NOT NULL COMMENT 'Group|',
  `folderId` int(11) NOT NULL COMMENT 'Folder|',
  `folderAccessValue` tinyint(1) NOT NULL COMMENT 'Value|',
  PRIMARY KEY (`folderAccessId`),
  KEY `groupId` (`teamId`),
  KEY `folderId` (`folderId`)
) ENGINE=InnoDB AUTO_INCREMENT=487 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folderaccess`
--

LOCK TABLES `folderaccess` WRITE;
/*!40000 ALTER TABLE `folderaccess` DISABLE KEYS */;
INSERT INTO `folderaccess` VALUES (1,1,1,1),(2,1,2,1),(3,1,3,1),(4,1,4,1),(5,1,5,1),(6,1,6,1),(7,1,7,1),(8,1,8,1),(9,1,9,1),(10,1,10,1),(11,1,11,1),(12,1,12,1),(13,1,13,1),(14,1,14,1),(15,1,15,1),(16,1,16,1),(17,1,17,1),(18,1,18,1),(19,1,19,1),(20,1,20,1),(21,1,21,1),(22,1,22,1),(23,1,23,1),(24,1,24,1),(25,1,25,1),(26,1,26,1),(27,1,27,1),(28,1,28,1),(29,1,29,1),(30,1,30,1),(31,1,31,1),(32,1,32,1),(33,1,33,1),(34,1,34,1),(35,1,35,1),(36,1,36,1),(37,1,37,1),(38,1,38,1),(39,1,39,1),(40,1,40,1),(41,1,41,1),(42,1,42,1),(43,1,43,1),(44,1,44,1),(45,1,45,1),(46,1,46,1),(47,1,47,1),(48,1,48,1),(49,1,49,1),(50,1,50,1),(51,1,51,1),(52,1,52,1),(53,1,53,1),(54,1,54,1),(55,1,55,1),(56,1,56,1),(57,1,57,1),(58,1,58,1),(59,1,59,1),(60,1,60,1),(61,1,61,1),(62,1,62,1),(63,1,63,1),(64,1,64,1),(65,1,65,1),(66,1,66,1),(67,1,67,1),(68,1,68,1),(69,1,69,1),(70,1,70,1),(71,1,71,1),(72,1,72,1),(73,1,73,1),(74,1,74,1),(75,1,75,1),(76,1,76,1),(77,1,77,1),(78,1,78,1),(79,1,79,1),(80,1,80,1),(81,1,81,1),(82,2,1,1),(83,2,2,1),(84,2,3,1),(85,2,4,1),(86,2,5,1),(87,2,6,1),(88,2,7,1),(89,2,8,1),(90,2,9,1),(91,2,10,1),(92,2,11,1),(93,2,12,1),(94,2,13,1),(95,2,14,1),(96,2,15,1),(97,2,16,1),(98,2,17,1),(99,2,18,1),(100,2,19,1),(101,2,20,1),(102,2,21,1),(103,2,22,1),(104,2,23,1),(105,2,24,1),(106,2,25,1),(107,2,26,1),(108,2,27,1),(109,2,28,1),(110,2,29,1),(111,2,30,1),(112,2,31,1),(113,2,32,1),(114,2,33,1),(115,2,34,1),(116,2,35,1),(117,2,36,1),(118,2,37,1),(119,2,38,1),(120,2,39,1),(121,2,40,1),(122,2,41,1),(123,2,42,1),(124,2,43,1),(125,2,44,1),(126,2,45,1),(127,2,46,1),(128,2,47,1),(129,2,48,1),(130,2,49,1),(131,2,50,1),(132,2,51,1),(133,2,52,1),(134,2,53,1),(135,2,54,1),(136,2,55,1),(137,2,56,1),(138,2,57,1),(139,2,58,1),(140,2,59,1),(141,2,60,1),(142,2,61,1),(143,2,62,1),(144,2,63,1),(145,2,64,1),(146,2,65,1),(147,2,66,1),(148,2,67,1),(149,2,68,1),(150,2,69,1),(151,2,70,1),(152,2,71,1),(153,2,72,1),(154,2,73,1),(155,2,74,1),(156,2,75,1),(157,2,76,1),(158,2,77,1),(159,2,78,1),(160,2,79,1),(161,2,80,1),(162,2,81,1),(163,3,1,1),(164,3,2,1),(165,3,3,1),(166,3,4,1),(167,3,5,1),(168,3,6,1),(169,3,7,1),(170,3,8,1),(171,3,9,1),(172,3,10,1),(173,3,11,1),(174,3,12,1),(175,3,13,1),(176,3,14,1),(177,3,15,1),(178,3,16,1),(179,3,17,1),(180,3,18,1),(181,3,19,1),(182,3,20,1),(183,3,21,1),(184,3,22,1),(185,3,23,1),(186,3,24,1),(187,3,25,1),(188,3,26,1),(189,3,27,1),(190,3,28,1),(191,3,29,1),(192,3,30,1),(193,3,31,1),(194,3,32,1),(195,3,33,1),(196,3,34,1),(197,3,35,1),(198,3,36,1),(199,3,37,1),(200,3,38,1),(201,3,39,1),(202,3,40,1),(203,3,41,1),(204,3,42,1),(205,3,43,1),(206,3,44,1),(207,3,45,1),(208,3,46,1),(209,3,47,1),(210,3,48,1),(211,3,49,1),(212,3,50,1),(213,3,51,1),(214,3,52,1),(215,3,53,1),(216,3,54,1),(217,3,55,1),(218,3,56,1),(219,3,57,1),(220,3,58,1),(221,3,59,1),(222,3,60,1),(223,3,61,1),(224,3,62,1),(225,3,63,1),(226,3,64,1),(227,3,65,1),(228,3,66,1),(229,3,67,1),(230,3,68,1),(231,3,69,1),(232,3,70,1),(233,3,71,1),(234,3,72,1),(235,3,73,1),(236,3,74,1),(237,3,75,1),(238,3,76,1),(239,3,77,1),(240,3,78,1),(241,3,79,1),(242,3,80,1),(243,3,81,1),(244,4,1,1),(245,4,2,1),(246,4,3,1),(247,4,4,1),(248,4,5,1),(249,4,6,1),(250,4,7,1),(251,4,8,1),(252,4,9,1),(253,4,10,1),(254,4,11,1),(255,4,12,1),(256,4,13,1),(257,4,14,1),(258,4,15,1),(259,4,16,1),(260,4,17,1),(261,4,18,1),(262,4,19,1),(263,4,20,1),(264,4,21,1),(265,4,22,1),(266,4,23,1),(267,4,24,1),(268,4,25,1),(269,4,26,1),(270,4,27,1),(271,4,28,1),(272,4,29,1),(273,4,30,1),(274,4,31,1),(275,4,32,1),(276,4,33,1),(277,4,34,1),(278,4,35,1),(279,4,36,1),(280,4,37,1),(281,4,38,1),(282,4,39,1),(283,4,40,1),(284,4,41,1),(285,4,42,1),(286,4,43,1),(287,4,44,1),(288,4,45,1),(289,4,46,1),(290,4,47,1),(291,4,48,1),(292,4,49,1),(293,4,50,1),(294,4,51,1),(295,4,52,1),(296,4,53,1),(297,4,54,1),(298,4,55,1),(299,4,56,1),(300,4,57,1),(301,4,58,1),(302,4,59,1),(303,4,60,1),(304,4,61,1),(305,4,62,1),(306,4,63,1),(307,4,64,1),(308,4,65,1),(309,4,66,1),(310,4,67,1),(311,4,68,1),(312,4,69,1),(313,4,70,1),(314,4,71,1),(315,4,72,1),(316,4,73,1),(317,4,74,1),(318,4,75,1),(319,4,76,1),(320,4,77,1),(321,4,78,1),(322,4,79,1),(323,4,80,1),(324,4,81,1),(325,5,1,1),(326,5,2,1),(327,5,3,1),(328,5,4,1),(329,5,5,1),(330,5,6,1),(331,5,7,1),(332,5,8,1),(333,5,9,1),(334,5,10,1),(335,5,11,1),(336,5,12,1),(337,5,13,1),(338,5,14,1),(339,5,15,1),(340,5,16,1),(341,5,17,1),(342,5,18,1),(343,5,19,1),(344,5,20,1),(345,5,21,1),(346,5,22,1),(347,5,23,1),(348,5,24,1),(349,5,25,1),(350,5,26,1),(351,5,27,1),(352,5,28,1),(353,5,29,1),(354,5,30,1),(355,5,31,1),(356,5,32,1),(357,5,33,1),(358,5,34,1),(359,5,35,1),(360,5,36,1),(361,5,37,1),(362,5,38,1),(363,5,39,1),(364,5,40,1),(365,5,41,1),(366,5,42,1),(367,5,43,1),(368,5,44,1),(369,5,45,1),(370,5,46,1),(371,5,47,1),(372,5,48,1),(373,5,49,1),(374,5,50,1),(375,5,51,1),(376,5,52,1),(377,5,53,1),(378,5,54,1),(379,5,55,1),(380,5,56,1),(381,5,57,1),(382,5,58,1),(383,5,59,1),(384,5,60,1),(385,5,61,1),(386,5,62,1),(387,5,63,1),(388,5,64,1),(389,5,65,1),(390,5,66,1),(391,5,67,1),(392,5,68,1),(393,5,69,1),(394,5,70,1),(395,5,71,1),(396,5,72,1),(397,5,73,1),(398,5,74,1),(399,5,75,1),(400,5,76,1),(401,5,77,1),(402,5,78,1),(403,5,79,1),(404,5,80,1),(405,5,81,1),(406,6,1,1),(407,6,2,1),(408,6,3,1),(409,6,4,1),(410,6,5,1),(411,6,6,1),(412,6,7,1),(413,6,8,1),(414,6,9,1),(415,6,10,1),(416,6,11,1),(417,6,12,1),(418,6,13,1),(419,6,14,1),(420,6,15,1),(421,6,16,1),(422,6,17,1),(423,6,18,1),(424,6,19,1),(425,6,20,1),(426,6,21,1),(427,6,22,1),(428,6,23,1),(429,6,24,1),(430,6,25,1),(431,6,26,1),(432,6,27,1),(433,6,28,1),(434,6,29,1),(435,6,30,1),(436,6,31,1),(437,6,32,1),(438,6,33,1),(439,6,34,1),(440,6,35,1),(441,6,36,1),(442,6,37,1),(443,6,38,1),(444,6,39,1),(445,6,40,1),(446,6,41,1),(447,6,42,1),(448,6,43,1),(449,6,44,1),(450,6,45,1),(451,6,46,1),(452,6,47,1),(453,6,48,1),(454,6,49,1),(455,6,50,1),(456,6,51,1),(457,6,52,1),(458,6,53,1),(459,6,54,1),(460,6,55,1),(461,6,56,1),(462,6,57,1),(463,6,58,1),(464,6,59,1),(465,6,60,1),(466,6,61,1),(467,6,62,1),(468,6,63,1),(469,6,64,1),(470,6,65,1),(471,6,66,1),(472,6,67,1),(473,6,68,1),(474,6,69,1),(475,6,70,1),(476,6,71,1),(477,6,72,1),(478,6,73,1),(479,6,74,1),(480,6,75,1),(481,6,76,1),(482,6,77,1),(483,6,78,1),(484,6,79,1),(485,6,80,1),(486,6,81,1);
/*!40000 ALTER TABLE `folderaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foldertranslate`
--

DROP TABLE IF EXISTS `foldertranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foldertranslate` (
  `folderTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'translate|',
  `folderId` int(11) NOT NULL COMMENT 'folder|',
  `languageId` int(11) NOT NULL COMMENT 'language|',
  `folderNative` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Folder|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`folderTranslateId`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foldertranslate`
--

LOCK TABLES `foldertranslate` WRITE;
/*!40000 ALTER TABLE `foldertranslate` DISABLE KEYS */;
INSERT INTO `foldertranslate` VALUES (1,1,21,'System Entry',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(2,2,21,'Common',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(3,3,21,'Common',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(4,4,21,'Common',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(5,5,21,'Single Form',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(6,6,21,'Multiplied Form',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(7,7,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(8,8,21,'Budget',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(9,9,21,'Forecast',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(10,10,21,'Journal',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(11,11,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(12,12,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(13,13,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(14,14,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(15,15,21,'Inventory and Purchasing',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(16,16,21,'Suppliers',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(17,17,21,'Shippers',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(18,18,21,'Reports',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(19,19,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(20,20,21,'Dividen',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(21,21,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(22,22,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(23,23,21,'Bank ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(24,24,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(25,25,21,'Fix Asset',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(26,26,21,'Disposal',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(27,27,21,'Depreciation',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(28,28,21,'Write Off',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(29,29,21,'Adjustment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(30,30,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(31,31,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(32,32,21,'Public',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(33,33,21,'Group',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(34,34,21,'Private',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(35,35,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(36,36,21,'Designation',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(37,37,21,'Category',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(38,38,21,'Management',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(39,39,21,'Parameter',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(40,40,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(41,41,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(42,42,21,'Leave Management Module',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(43,43,21,'Recruitment Management',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(44,44,21,'Key Performance Index',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(45,45,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(46,46,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(47,47,21,'Financial Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(48,48,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(49,49,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(50,50,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(51,51,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(52,52,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(53,53,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(54,54,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(55,55,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(56,56,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(57,57,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(58,58,21,'Invoice',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(59,59,21,'Adjustment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(60,60,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(61,61,21,'Reverse  Payment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(62,62,21,'Refund Payment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(63,63,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(64,64,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(65,65,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(66,66,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(67,67,21,'Common',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(68,68,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(69,69,21,'Membership',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(70,70,21,'Personal Information Management',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(71,71,21,'Customers And Orders',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(72,72,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(73,73,21,'Receive Payment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(74,74,21,'Custom Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(75,75,21,'Chart Of Account',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(76,76,21,'Reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(77,77,21,'Sales',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(78,78,21,'Financial',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(79,79,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(80,80,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(81,81,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35');
/*!40000 ALTER TABLE `foldertranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `icon`
--

DROP TABLE IF EXISTS `icon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `icon` (
  `iconId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Icon|',
  `iconName` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name|',
  `iconSize` int(11) NOT NULL,
  `isDefault` tinyint(4) NOT NULL COMMENT 'default|',
  `isActive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iconId`)
) ENGINE=InnoDB AUTO_INCREMENT=1512 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `icon`
--

LOCK TABLES `icon` WRITE;
/*!40000 ALTER TABLE `icon` DISABLE KEYS */;
INSERT INTO `icon` VALUES (29,'accept',16,2,1),(31,'acroread',16,2,1),(32,'add',16,2,1),(33,'ai',16,2,1),(34,'aktion',16,2,1),(35,'anchor',16,2,1),(36,'application',16,2,1),(37,'application_add',16,2,1),(38,'application_cascade',16,2,1),(39,'application_delete',16,2,1),(40,'application_double',16,2,1),(41,'application_edit',16,2,1),(42,'application_error',16,2,1),(43,'application_form',16,2,1),(44,'application_form_add',16,2,1),(45,'application_form_delete',16,2,1),(46,'application_form_edit',16,2,1),(47,'application_form_magnify',16,2,1),(48,'application_get',16,2,1),(49,'application_go',16,2,1),(50,'application_home',16,2,1),(51,'application_key',16,2,1),(52,'application_lightning',16,2,1),(53,'application_link',16,2,1),(54,'application_osx',16,2,1),(55,'application_osx_terminal',16,2,1),(56,'application_put',16,2,1),(57,'application_side_boxes',16,2,1),(58,'application_side_contract',16,2,1),(59,'application_side_expand',16,2,1),(60,'application_side_list',16,2,1),(61,'application_side_tree',16,2,1),(62,'application_split',16,2,1),(63,'application_tile_horizontal',16,2,1),(64,'application_tile_vertical',16,2,1),(65,'application_view_columns',16,2,1),(66,'application_view_detail',16,2,1),(67,'application_view_gallery',16,2,1),(68,'application_view_icons',16,2,1),(69,'application_view_list',16,2,1),(70,'application_view_tile',16,2,1),(71,'application_xp',16,2,1),(72,'application_xp_terminal',16,2,1),(73,'ark',16,2,1),(74,'arrow_branch',16,2,1),(75,'arrow_divide',16,2,1),(76,'arrow_down',16,2,1),(77,'arrow_in',16,2,1),(78,'arrow_inout',16,2,1),(79,'arrow_join',16,2,1),(80,'arrow_left',16,2,1),(81,'arrow_merge',16,2,1),(82,'arrow_out',16,2,1),(83,'arrow_redo',16,2,1),(84,'arrow_refresh',16,2,1),(85,'arrow_refresh_small',16,2,1),(86,'arrow_right',16,2,1),(87,'arrow_rotate_anticlockwise',16,2,1),(88,'arrow_rotate_clockwise',16,2,1),(89,'arrow_switch',16,2,1),(90,'arrow_turn_left',16,2,1),(91,'arrow_turn_right',16,2,1),(92,'arrow_undo',16,2,1),(93,'arrow_up',16,2,1),(94,'arts',16,2,1),(95,'ascend',16,2,1),(96,'asterisk_orange',16,2,1),(97,'asterisk_yellow',16,2,1),(98,'attach',16,2,1),(100,'award_star_add',16,2,1),(101,'award_star_bronze_1',16,2,1),(102,'award_star_bronze_2',16,2,1),(103,'award_star_bronze_3',16,2,1),(104,'award_star_delete',16,2,1),(105,'award_star_gold_1',16,2,1),(106,'award_star_gold_2',16,2,1),(107,'award_star_gold_3',16,2,1),(108,'award_star_silver_1',16,2,1),(109,'award_star_silver_2',16,2,1),(110,'award_star_silver_3',16,2,1),(111,'basket',16,2,1),(112,'basket_add',16,2,1),(113,'basket_delete',16,2,1),(114,'basket_edit',16,2,1),(115,'basket_error',16,2,1),(116,'basket_go',16,2,1),(117,'basket_put',16,2,1),(118,'basket_remove',16,2,1),(119,'bell',16,2,1),(120,'bell_add',16,2,1),(121,'bell_delete',16,2,1),(122,'bell_error',16,2,1),(123,'bell_go',16,2,1),(124,'bell_link',16,2,1),(125,'bin',16,2,1),(126,'bin_closed',16,2,1),(127,'bin_empty',16,2,1),(128,'blue',16,2,1),(130,'bomb',16,2,1),(131,'book',16,2,1),(133,'book_add',16,2,1),(134,'book_addresses',16,2,1),(135,'book_delete',16,2,1),(136,'book_edit',16,2,1),(137,'book_error',16,2,1),(138,'book_go',16,2,1),(139,'book_key',16,2,1),(140,'book_link',16,2,1),(141,'book_next',16,2,1),(142,'book_open',16,2,1),(143,'book_previous',16,2,1),(144,'box',16,2,1),(145,'brick',16,2,1),(146,'bricks',16,2,1),(147,'brick_add',16,2,1),(148,'brick_delete',16,2,1),(149,'brick_edit',16,2,1),(150,'brick_error',16,2,1),(151,'brick_go',16,2,1),(152,'brick_link',16,2,1),(153,'briefcase',16,2,1),(154,'browser',16,2,1),(155,'bug',16,2,1),(156,'bug_add',16,2,1),(157,'bug_delete',16,2,1),(158,'bug_edit',16,2,1),(159,'bug_error',16,2,1),(160,'bug_go',16,2,1),(161,'bug_link',16,2,1),(162,'building',16,2,1),(163,'building_add',16,2,1),(164,'building_delete',16,2,1),(165,'building_edit',16,2,1),(166,'building_error',16,2,1),(167,'building_go',16,2,1),(168,'building_key',16,2,1),(169,'building_link',16,2,1),(170,'bullet_add',16,2,1),(171,'bullet_arrow_bottom',16,2,1),(172,'bullet_arrow_down',16,2,1),(173,'bullet_arrow_top',16,2,1),(174,'bullet_arrow_up',16,2,1),(175,'bullet_black',16,2,1),(176,'bullet_blue',16,2,1),(177,'bullet_delete',16,2,1),(178,'bullet_disk',16,2,1),(179,'bullet_error',16,2,1),(180,'bullet_feed',16,2,1),(181,'bullet_go',16,2,1),(182,'bullet_green',16,2,1),(183,'bullet_key',16,2,1),(184,'bullet_orange',16,2,1),(185,'bullet_picture',16,2,1),(186,'bullet_pink',16,2,1),(187,'bullet_purple',16,2,1),(188,'bullet_red',16,2,1),(189,'bullet_star',16,2,1),(190,'bullet_toggle_minus',16,2,1),(191,'bullet_toggle_plus',16,2,1),(192,'bullet_white',16,2,1),(193,'bullet_wrench',16,2,1),(194,'bullet_yellow',16,2,1),(197,'cake',16,2,1),(198,'calculator',16,2,1),(199,'calculator_add',16,2,1),(200,'calculator_delete',16,2,1),(201,'calculator_edit',16,2,1),(202,'calculator_error',16,2,1),(203,'calculator_link',16,2,1),(204,'calendar',16,2,1),(205,'calendar_add',16,2,1),(206,'calendar_delete',16,2,1),(207,'calendar_edit',16,2,1),(208,'calendar_link',16,2,1),(209,'calendar_view_day',16,2,1),(210,'calendar_view_month',16,2,1),(211,'calendar_view_week',16,2,1),(212,'camera',16,2,1),(213,'camera_add',16,2,1),(214,'camera_delete',16,2,1),(215,'camera_edit',16,2,1),(216,'camera_error',16,2,1),(217,'camera_go',16,2,1),(218,'camera_link',16,2,1),(219,'camera_small',16,2,1),(220,'cancel',16,2,1),(221,'car',16,2,1),(222,'cart',16,2,1),(223,'cart_add',16,2,1),(224,'cart_delete',16,2,1),(225,'cart_edit',16,2,1),(226,'cart_error',16,2,1),(227,'cart_go',16,2,1),(228,'cart_put',16,2,1),(229,'cart_remove',16,2,1),(230,'car_add',16,2,1),(231,'car_delete',16,2,1),(232,'CC99FF',16,2,1),(233,'CCFFCC',16,2,1),(234,'ccffff',16,2,1),(235,'cd',16,2,1),(236,'cd_add',16,2,1),(237,'cd_burn',16,2,1),(238,'cd_delete',16,2,1),(239,'cd_edit',16,2,1),(240,'cd_eject',16,2,1),(241,'cd_go',16,2,1),(242,'chart_bar',16,2,1),(243,'chart_bar_add',16,2,1),(244,'chart_bar_delete',16,2,1),(245,'chart_bar_edit',16,2,1),(246,'chart_bar_error',16,2,1),(247,'chart_bar_link',16,2,1),(248,'chart_curve',16,2,1),(249,'chart_curve_add',16,2,1),(250,'chart_curve_delete',16,2,1),(251,'chart_curve_edit',16,2,1),(252,'chart_curve_error',16,2,1),(253,'chart_curve_go',16,2,1),(254,'chart_curve_link',16,2,1),(255,'chart_line',16,2,1),(256,'chart_line_add',16,2,1),(257,'chart_line_delete',16,2,1),(258,'chart_line_edit',16,2,1),(259,'chart_line_error',16,2,1),(260,'chart_line_link',16,2,1),(261,'chart_organisation',16,2,1),(262,'chart_organisation_add',16,2,1),(263,'chart_organisation_delete',16,2,1),(264,'chart_pie',16,2,1),(265,'chart_pie_add',16,2,1),(266,'chart_pie_delete',16,2,1),(267,'chart_pie_edit',16,2,1),(268,'chart_pie_error',16,2,1),(269,'chart_pie_link',16,2,1),(270,'clock',16,2,1),(271,'clock_add',16,2,1),(272,'clock_delete',16,2,1),(273,'clock_edit',16,2,1),(274,'clock_error',16,2,1),(275,'clock_go',16,2,1),(276,'clock_link',16,2,1),(277,'clock_pause',16,2,1),(278,'clock_play',16,2,1),(279,'clock_red',16,2,1),(280,'clock_stop',16,2,1),(281,'cog',16,2,1),(282,'cog_add',16,2,1),(283,'cog_delete',16,2,1),(284,'cog_edit',16,2,1),(285,'cog_error',16,2,1),(286,'cog_go',16,2,1),(287,'coins',16,2,1),(288,'coins_add',16,2,1),(289,'coins_delete',16,2,1),(290,'colors',16,2,1),(291,'color_swatch',16,2,1),(292,'color_wheel',16,2,1),(293,'comment',16,2,1),(294,'comments',16,2,1),(295,'comments_add',16,2,1),(296,'comments_delete',16,2,1),(297,'comment_add',16,2,1),(298,'comment_delete',16,2,1),(299,'comment_edit',16,2,1),(300,'compress',16,2,1),(301,'computer',16,2,1),(302,'computer_add',16,2,1),(303,'computer_delete',16,2,1),(304,'computer_edit',16,2,1),(305,'computer_error',16,2,1),(306,'computer_go',16,2,1),(307,'computer_key',16,2,1),(308,'computer_link',16,2,1),(309,'connect',16,2,1),(310,'contrast',16,2,1),(311,'contrast_decrease',16,2,1),(312,'contrast_high',16,2,1),(313,'contrast_increase',16,2,1),(314,'contrast_low',16,2,1),(315,'controller',16,2,1),(316,'controller_add',16,2,1),(317,'controller_delete',16,2,1),(318,'controller_error',16,2,1),(319,'control_eject',16,2,1),(320,'control_eject_blue',16,2,1),(321,'control_end',16,2,1),(322,'control_end_blue',16,2,1),(323,'control_equalizer',16,2,1),(324,'control_equalizer_blue',16,2,1),(325,'control_fastforward',16,2,1),(326,'control_fastforward_blue',16,2,1),(327,'control_pause',16,2,1),(328,'control_pause_blue',16,2,1),(329,'control_play',16,2,1),(330,'control_play_blue',16,2,1),(331,'control_repeat',16,2,1),(332,'control_repeat_blue',16,2,1),(333,'control_rewind',16,2,1),(334,'control_rewind_blue',16,2,1),(335,'control_start',16,2,1),(336,'control_start_blue',16,2,1),(337,'control_stop',16,2,1),(338,'control_stop_blue',16,2,1),(339,'cookie',16,2,1),(341,'creditcards',16,2,1),(342,'cross',16,2,1),(344,'css',16,2,1),(345,'css_add',16,2,1),(346,'css_delete',16,2,1),(347,'css_go',16,2,1),(348,'css_valid',16,2,1),(350,'cup',16,2,1),(351,'cup_add',16,2,1),(352,'cup_delete',16,2,1),(353,'cup_edit',16,2,1),(354,'cup_error',16,2,1),(355,'cup_go',16,2,1),(356,'cup_key',16,2,1),(357,'cup_link',16,2,1),(358,'cursor',16,2,1),(359,'cut',16,2,1),(360,'cut_red',16,2,1),(361,'database',16,2,1),(362,'database_add',16,2,1),(363,'database_connect',16,2,1),(364,'database_delete',16,2,1),(365,'database_edit',16,2,1),(366,'database_error',16,2,1),(367,'database_gear',16,2,1),(368,'database_go',16,2,1),(369,'database_key',16,2,1),(370,'database_lightning',16,2,1),(371,'database_link',16,2,1),(372,'database_refresh',16,2,1),(373,'database_save',16,2,1),(374,'database_table',16,2,1),(375,'date',16,2,1),(376,'date_add',16,2,1),(377,'date_delete',16,2,1),(378,'date_edit',16,2,1),(379,'date_error',16,2,1),(380,'date_go',16,2,1),(381,'date_link',16,2,1),(382,'date_magnify',16,2,1),(383,'date_next',16,2,1),(384,'date_previous',16,2,1),(385,'delete',16,2,1),(386,'descend',16,2,1),(387,'disconnect',16,2,1),(389,'disk_multiple',16,2,1),(390,'disc',16,2,1),(391,'document',16,2,1),(392,'door',16,2,1),(393,'door_in',16,2,1),(394,'door_open',16,2,1),(395,'door_out',16,2,1),(396,'drink',16,2,1),(397,'drink_empty',16,2,1),(398,'drive',16,2,1),(399,'drive_add',16,2,1),(400,'drive_burn',16,2,1),(401,'drive_cd',16,2,1),(402,'drive_cd_empty',16,2,1),(403,'drive_delete',16,2,1),(404,'drive_disk',16,2,1),(405,'drive_edit',16,2,1),(406,'drive_error',16,2,1),(407,'drive_go',16,2,1),(408,'drive_key',16,2,1),(409,'drive_link',16,2,1),(410,'drive_magnify',16,2,1),(411,'drive_network',16,2,1),(412,'drive_rename',16,2,1),(413,'drive_user',16,2,1),(414,'drive_web',16,2,1),(415,'dvd',16,2,1),(416,'dvd_add',16,2,1),(417,'dvd_delete',16,2,1),(418,'dvd_edit',16,2,1),(419,'dvd_error',16,2,1),(420,'dvd_go',16,2,1),(421,'dvd_key',16,2,1),(422,'dvd_link',16,2,1),(423,'email',16,2,1),(424,'email_add',16,2,1),(425,'email_attach',16,2,1),(426,'email_delete',16,2,1),(427,'email_edit',16,2,1),(428,'email_error',16,2,1),(429,'email_go',16,2,1),(430,'email_link',16,2,1),(431,'email_open',16,2,1),(432,'email_open_image',16,2,1),(433,'emoticon_evilgrin',16,2,1),(434,'emoticon_grin',16,2,1),(435,'emoticon_happy',16,2,1),(436,'emoticon_smile',16,2,1),(437,'emoticon_surprised',16,2,1),(438,'emoticon_tongue',16,2,1),(439,'emoticon_unhappy',16,2,1),(440,'emoticon_waii',16,2,1),(441,'emoticon_wink',16,2,1),(442,'error',16,2,1),(443,'error_add',16,2,1),(444,'error_delete',16,2,1),(445,'error_go',16,2,1),(447,'exclamation',16,2,1),(449,'exec',16,2,1),(450,'eye',16,2,1),(451,'feed',16,2,1),(452,'feed_add',16,2,1),(453,'feed_delete',16,2,1),(454,'feed_disk',16,2,1),(455,'feed_edit',16,2,1),(456,'feed_error',16,2,1),(457,'feed_go',16,2,1),(458,'feed_key',16,2,1),(459,'feed_link',16,2,1),(460,'feed_magnify',16,2,1),(461,'female',16,2,1),(472,'film',16,2,1),(473,'film_add',16,2,1),(474,'film_delete',16,2,1),(475,'film_edit',16,2,1),(476,'film_error',16,2,1),(477,'film_go',16,2,1),(478,'film_key',16,2,1),(479,'film_link',16,2,1),(480,'film_save',16,2,1),(481,'find',16,2,1),(483,'flags',16,2,1),(484,'flag_blue',16,2,1),(485,'flag_green',16,2,1),(486,'flag_orange',16,2,1),(487,'flag_pink',16,2,1),(488,'flag_purple',16,2,1),(489,'flag_red',16,2,1),(490,'flag_yellow',16,2,1),(491,'folder',16,2,1),(492,'folder_add',16,2,1),(493,'folder_bell',16,2,1),(494,'folder_brick',16,2,1),(495,'folder_bug',16,2,1),(496,'folder_camera',16,2,1),(497,'folder_database',16,2,1),(498,'folder_delete',16,2,1),(499,'folder_edit',16,2,1),(500,'folder_error',16,2,1),(501,'folder_explore',16,2,1),(502,'folder_feed',16,2,1),(503,'folder_find',16,2,1),(504,'folder_go',16,2,1),(505,'folder_grey',16,2,1),(506,'folder_heart',16,2,1),(507,'folder_image',16,2,1),(508,'folder_key',16,2,1),(509,'folder_lightbulb',16,2,1),(510,'folder_link',16,2,1),(511,'folder_magnify',16,2,1),(512,'folder_page',16,2,1),(513,'folder_page_white',16,2,1),(514,'folder_palette',16,2,1),(515,'folder_picture',16,2,1),(516,'folder_star',16,2,1),(517,'folder_table',16,2,1),(518,'folder_user',16,2,1),(519,'folder_wrench',16,2,1),(520,'font',16,2,1),(521,'fonts',16,2,1),(522,'font_add',16,2,1),(523,'font_delete',16,2,1),(524,'font_go',16,2,1),(526,'gimp',16,2,1),(527,'group',16,2,1),(528,'group_add',16,2,1),(529,'group_delete',16,2,1),(530,'group_edit',16,2,1),(531,'group_error',16,2,1),(532,'group_gear',16,2,1),(533,'group_go',16,2,1),(534,'group_key',16,2,1),(535,'group_link',16,2,1),(536,'heart',16,2,1),(537,'heart_add',16,2,1),(538,'heart_delete',16,2,1),(539,'help',16,2,1),(541,'hourglass',16,2,1),(542,'hourglass_add',16,2,1),(543,'hourglass_delete',16,2,1),(544,'hourglass_go',16,2,1),(545,'hourglass_link',16,2,1),(546,'house',16,2,1),(547,'house_go',16,2,1),(548,'house_link',16,2,1),(549,'html',16,2,1),(550,'html_add',16,2,1),(551,'html_delete',16,2,1),(552,'html_go',16,2,1),(553,'html_valid',16,2,1),(556,'image',16,2,1),(557,'images',16,2,1),(558,'image_add',16,2,1),(559,'image_delete',16,2,1),(560,'image_edit',16,2,1),(561,'image_link',16,2,1),(565,'information',16,2,1),(566,'ipod',16,2,1),(567,'ipod_cast',16,2,1),(568,'ipod_cast_add',16,2,1),(569,'ipod_cast_delete',16,2,1),(570,'ipod_sound',16,2,1),(571,'java',16,2,1),(572,'java_jar',16,2,1),(573,'joystick',16,2,1),(574,'joystick_add',16,2,1),(575,'joystick_delete',16,2,1),(576,'joystick_error',16,2,1),(578,'key',16,2,1),(579,'keyboard',16,2,1),(580,'keyboard_add',16,2,1),(581,'keyboard_delete',16,2,1),(582,'keyboard_magnify',16,2,1),(583,'key_add',16,2,1),(584,'key_delete',16,2,1),(585,'key_go',16,2,1),(586,'kservices',16,2,1),(587,'layers',16,2,1),(588,'layout',16,2,1),(589,'layout_add',16,2,1),(590,'layout_content',16,2,1),(591,'layout_delete',16,2,1),(592,'layout_edit',16,2,1),(593,'layout_error',16,2,1),(594,'layout_header',16,2,1),(595,'layout_link',16,2,1),(596,'layout_sidebar',16,2,1),(597,'lightbulb',16,2,1),(598,'lightbulb_add',16,2,1),(599,'lightbulb_delete',16,2,1),(600,'lightbulb_off',16,2,1),(601,'lightning',16,2,1),(602,'lightning_add',16,2,1),(603,'lightning_delete',16,2,1),(604,'lightning_go',16,2,1),(605,'link',16,2,1),(606,'link_add',16,2,1),(607,'link_break',16,2,1),(608,'link_delete',16,2,1),(609,'link_edit',16,2,1),(610,'link_error',16,2,1),(611,'link_go',16,2,1),(612,'lock',16,2,1),(613,'lock_add',16,2,1),(614,'lock_break',16,2,1),(615,'lock_delete',16,2,1),(616,'lock_edit',16,2,1),(617,'lock_go',16,2,1),(618,'lock_open',16,2,1),(619,'lorry',16,2,1),(620,'lorry_add',16,2,1),(621,'lorry_delete',16,2,1),(622,'lorry_error',16,2,1),(623,'lorry_flatbed',16,2,1),(624,'lorry_go',16,2,1),(625,'lorry_link',16,2,1),(626,'magifier_zoom_out',16,2,1),(627,'magnifier',16,2,1),(628,'magnifier_zoom_in',16,2,1),(629,'male',16,2,1),(630,'map',16,2,1),(631,'map_add',16,2,1),(632,'map_delete',16,2,1),(633,'map_edit',16,2,1),(634,'map_go',16,2,1),(635,'map_magnify',16,2,1),(636,'medal_bronze_1',16,2,1),(637,'medal_bronze_2',16,2,1),(638,'medal_bronze_3',16,2,1),(639,'medal_bronze_add',16,2,1),(640,'medal_bronze_delete',16,2,1),(641,'medal_gold_1',16,2,1),(642,'medal_gold_2',16,2,1),(643,'medal_gold_3',16,2,1),(644,'medal_gold_add',16,2,1),(645,'medal_gold_delete',16,2,1),(646,'medal_silver_1',16,2,1),(647,'medal_silver_2',16,2,1),(648,'medal_silver_3',16,2,1),(649,'medal_silver_add',16,2,1),(650,'medal_silver_delete',16,2,1),(651,'mime',16,2,1),(652,'money',16,2,1),(653,'money_add',16,2,1),(654,'money_delete',16,2,1),(655,'money_dollar',16,2,1),(656,'money_euro',16,2,1),(657,'money_pound',16,2,1),(658,'money_yen',16,2,1),(659,'monitor',16,2,1),(660,'monitor_add',16,2,1),(661,'monitor_delete',16,2,1),(662,'monitor_edit',16,2,1),(663,'monitor_error',16,2,1),(664,'monitor_go',16,2,1),(665,'monitor_lightning',16,2,1),(666,'monitor_link',16,2,1),(667,'mouse',16,2,1),(668,'mouse_add',16,2,1),(669,'mouse_delete',16,2,1),(670,'mouse_error',16,2,1),(673,'music',16,2,1),(674,'new',16,2,1),(675,'newspaper',16,2,1),(676,'newspaper_add',16,2,1),(677,'newspaper_delete',16,2,1),(678,'newspaper_go',16,2,1),(679,'newspaper_link',16,2,1),(680,'note',16,2,1),(681,'note_add',16,2,1),(682,'note_delete',16,2,1),(683,'note_edit',16,2,1),(684,'note_error',16,2,1),(685,'note_go',16,2,1),(686,'ooo_gulls',16,2,1),(687,'openoffice',16,2,1),(688,'overlays',16,2,1),(689,'package',16,2,1),(690,'package_add',16,2,1),(691,'package_delete',16,2,1),(692,'package_go',16,2,1),(693,'package_graphics',16,2,1),(694,'package_green',16,2,1),(695,'package_link',16,2,1),(696,'page-first-disabled',16,2,1),(697,'page-first',16,2,1),(698,'page-last-disabled',16,2,1),(699,'page-last',16,2,1),(700,'page-next-disabled',16,2,1),(701,'page-next',16,2,1),(702,'page-prev-disabled',16,2,1),(703,'page-prev',16,2,1),(704,'page',16,2,1),(705,'page_add',16,2,1),(706,'page_attach',16,2,1),(707,'page_code',16,2,1),(708,'page_copy',16,2,1),(709,'page_delete',16,2,1),(710,'page_edit',16,2,1),(711,'page_error',16,2,1),(712,'page_excel',16,2,1),(713,'page_find',16,2,1),(714,'page_gear',16,2,1),(715,'page_go',16,2,1),(716,'page_green',16,2,1),(717,'page_key',16,2,1),(718,'page_lightning',16,2,1),(719,'page_link',16,2,1),(720,'page_paintbrush',16,2,1),(721,'page_paste',16,2,1),(722,'page_red',16,2,1),(723,'page_refresh',16,2,1),(724,'page_save',16,2,1),(725,'page_white',16,2,1),(726,'page_white_acrobat',16,2,1),(727,'page_white_actionscript',16,2,1),(728,'page_white_add',16,2,1),(729,'page_white_c',16,2,1),(730,'page_white_camera',16,2,1),(731,'page_white_cd',16,2,1),(732,'page_white_code',16,2,1),(733,'page_white_code_red',16,2,1),(734,'page_white_coldfusion',16,2,1),(735,'page_white_compressed',16,2,1),(736,'page_white_copy',16,2,1),(737,'page_white_cplusplus',16,2,1),(738,'page_white_csharp',16,2,1),(739,'page_white_cup',16,2,1),(740,'page_white_database',16,2,1),(741,'page_white_delete',16,2,1),(742,'page_white_dvd',16,2,1),(743,'page_white_edit',16,2,1),(744,'page_white_error',16,2,1),(745,'page_white_excel',16,2,1),(746,'page_white_find',16,2,1),(747,'page_white_flash',16,2,1),(748,'page_white_freehand',16,2,1),(749,'page_white_gear',16,2,1),(750,'page_white_get',16,2,1),(751,'page_white_go',16,2,1),(752,'page_white_h',16,2,1),(753,'page_white_horizontal',16,2,1),(754,'page_white_key',16,2,1),(755,'page_white_lightning',16,2,1),(756,'page_white_link',16,2,1),(757,'page_white_magnify',16,2,1),(758,'page_white_medal',16,2,1),(759,'page_white_office',16,2,1),(760,'page_white_paint',16,2,1),(761,'page_white_paintbrush',16,2,1),(762,'page_white_paste',16,2,1),(763,'page_white_php',16,2,1),(764,'page_white_picture',16,2,1),(765,'page_white_powerpoint',16,2,1),(766,'page_white_put',16,2,1),(767,'page_white_ruby',16,2,1),(768,'page_white_stack',16,2,1),(769,'page_white_star',16,2,1),(770,'page_white_swoosh',16,2,1),(771,'page_white_text',16,2,1),(772,'page_white_text_width',16,2,1),(773,'page_white_tux',16,2,1),(774,'page_white_vector',16,2,1),(775,'page_white_visualstudio',16,2,1),(776,'page_white_width',16,2,1),(777,'page_white_word',16,2,1),(778,'page_white_world',16,2,1),(779,'page_white_wrench',16,2,1),(780,'page_white_zip',16,2,1),(781,'page_word',16,2,1),(782,'page_world',16,2,1),(783,'paintbrush',16,2,1),(784,'paintcan',16,2,1),(785,'palette',16,2,1),(786,'paste_plain',16,2,1),(787,'paste_word',16,2,1),(789,'pencil',16,2,1),(790,'pencil_add',16,2,1),(791,'pencil_delete',16,2,1),(792,'pencil_go',16,2,1),(793,'phone',16,2,1),(794,'phone_add',16,2,1),(795,'phone_delete',16,2,1),(796,'phone_sound',16,2,1),(797,'photo',16,2,1),(798,'photos',16,2,1),(799,'photo_add',16,2,1),(800,'photo_delete',16,2,1),(801,'photo_link',16,2,1),(802,'php-icon',16,2,1),(803,'picture',16,2,1),(804,'pictures',16,2,1),(805,'picture_add',16,2,1),(806,'picture_delete',16,2,1),(807,'picture_edit',16,2,1),(808,'picture_empty',16,2,1),(809,'picture_error',16,2,1),(810,'picture_go',16,2,1),(811,'picture_key',16,2,1),(812,'picture_link',16,2,1),(813,'picture_save',16,2,1),(814,'pilcrow',16,2,1),(815,'pill',16,2,1),(816,'pill_add',16,2,1),(817,'pill_delete',16,2,1),(818,'pill_go',16,2,1),(820,'plugin',16,2,1),(821,'plugin_add',16,2,1),(822,'plugin_delete',16,2,1),(823,'plugin_disabled',16,2,1),(824,'plugin_edit',16,2,1),(825,'plugin_error',16,2,1),(826,'plugin_go',16,2,1),(827,'plugin_link',16,2,1),(830,'printer',16,2,1),(831,'printer_add',16,2,1),(832,'printer_delete',16,2,1),(833,'printer_empty',16,2,1),(834,'printer_error',16,2,1),(837,'quicktime',16,2,1),(838,'rainbow',16,2,1),(839,'realplayer',16,2,1),(840,'red',16,2,1),(841,'report',16,2,1),(842,'report_add',16,2,1),(843,'report_delete',16,2,1),(844,'report_disk',16,2,1),(845,'report_edit',16,2,1),(846,'report_go',16,2,1),(847,'report_key',16,2,1),(848,'report_link',16,2,1),(849,'report_magnify',16,2,1),(850,'report_picture',16,2,1),(851,'report_user',16,2,1),(852,'report_word',16,2,1),(853,'resultset_first',16,2,1),(854,'resultset_last',16,2,1),(855,'resultset_next',16,2,1),(856,'resultset_previous',16,2,1),(857,'rosette',16,2,1),(858,'rpm',16,2,1),(859,'rss',16,2,1),(860,'rss_add',16,2,1),(861,'rss_delete',16,2,1),(862,'rss_go',16,2,1),(863,'rss_valid',16,2,1),(864,'rtf',16,2,1),(865,'ruby',16,2,1),(866,'ruby_add',16,2,1),(867,'ruby_delete',16,2,1),(868,'ruby_gear',16,2,1),(869,'ruby_get',16,2,1),(870,'ruby_go',16,2,1),(871,'ruby_key',16,2,1),(872,'ruby_link',16,2,1),(873,'ruby_put',16,2,1),(874,'script',16,2,1),(875,'script_add',16,2,1),(876,'script_code',16,2,1),(877,'script_code_red',16,2,1),(878,'script_delete',16,2,1),(879,'script_edit',16,2,1),(880,'script_error',16,2,1),(881,'script_gear',16,2,1),(882,'script_go',16,2,1),(883,'script_key',16,2,1),(884,'script_lightning',16,2,1),(885,'script_link',16,2,1),(886,'script_palette',16,2,1),(887,'script_save',16,2,1),(888,'server',16,2,1),(889,'server_add',16,2,1),(890,'server_chart',16,2,1),(891,'server_compressed',16,2,1),(892,'server_connect',16,2,1),(893,'server_database',16,2,1),(894,'server_delete',16,2,1),(895,'server_edit',16,2,1),(896,'server_error',16,2,1),(897,'server_go',16,2,1),(898,'server_key',16,2,1),(899,'server_lightning',16,2,1),(900,'server_link',16,2,1),(901,'server_uncompressed',16,2,1),(902,'shading',16,2,1),(903,'shape_align_bottom',16,2,1),(904,'shape_align_center',16,2,1),(905,'shape_align_left',16,2,1),(906,'shape_align_middle',16,2,1),(907,'shape_align_right',16,2,1),(908,'shape_align_top',16,2,1),(909,'shape_flip_horizontal',16,2,1),(910,'shape_flip_vertical',16,2,1),(911,'shape_group',16,2,1),(912,'shape_handles',16,2,1),(913,'shape_move_back',16,2,1),(914,'shape_move_backwards',16,2,1),(915,'shape_move_forwards',16,2,1),(916,'shape_move_front',16,2,1),(917,'shape_rotate_anticlockwise',16,2,1),(918,'shape_rotate_clockwise',16,2,1),(919,'shape_square',16,2,1),(920,'shape_square_add',16,2,1),(921,'shape_square_delete',16,2,1),(922,'shape_square_edit',16,2,1),(923,'shape_square_error',16,2,1),(924,'shape_square_go',16,2,1),(925,'shape_square_key',16,2,1),(926,'shape_square_link',16,2,1),(927,'shape_ungroup',16,2,1),(928,'shield',16,2,1),(929,'shield_add',16,2,1),(930,'shield_delete',16,2,1),(931,'shield_go',16,2,1),(932,'sitemap',16,2,1),(933,'sitemap_color',16,2,1),(934,'sound',16,2,1),(935,'sound_add',16,2,1),(936,'sound_delete',16,2,1),(937,'sound_low',16,2,1),(938,'sound_mute',16,2,1),(939,'sound_none',16,2,1),(940,'spellcheck',16,2,1),(941,'sport_8ball',16,2,1),(942,'sport_basketball',16,2,1),(943,'sport_football',16,2,1),(944,'sport_golf',16,2,1),(945,'sport_raquet',16,2,1),(946,'sport_shuttlecock',16,2,1),(947,'sport_soccer',16,2,1),(948,'sport_tennis',16,2,1),(949,'star',16,2,1),(950,'status_away',16,2,1),(951,'status_busy',16,2,1),(952,'status_offline',16,2,1),(953,'status_online',16,2,1),(954,'stop',16,2,1),(955,'style',16,2,1),(956,'stylesheet',16,2,1),(957,'style_add',16,2,1),(958,'style_delete',16,2,1),(959,'style_edit',16,2,1),(960,'style_go',16,2,1),(962,'swf',16,2,1),(963,'tab',16,2,1),(964,'table',16,2,1),(965,'table_add',16,2,1),(966,'table_delete',16,2,1),(967,'table_edit',16,2,1),(968,'table_error',16,2,1),(969,'table_gear',16,2,1),(970,'table_go',16,2,1),(971,'table_key',16,2,1),(972,'table_lightning',16,2,1),(973,'table_link',16,2,1),(974,'table_multiple',16,2,1),(975,'table_refresh',16,2,1),(976,'table_relationship',16,2,1),(977,'table_row_delete',16,2,1),(978,'table_row_insert',16,2,1),(979,'table_save',16,2,1),(980,'table_sort',16,2,1),(981,'tab_add',16,2,1),(982,'tab_delete',16,2,1),(983,'tab_edit',16,2,1),(984,'tab_go',16,2,1),(985,'tag',16,1,1),(986,'tag_blue',16,2,1),(987,'tag_blue_add',16,2,1),(988,'tag_blue_delete',16,2,1),(989,'tag_blue_edit',16,2,1),(990,'tag_green',16,2,1),(991,'tag_orange',16,2,1),(992,'tag_pink',16,2,1),(993,'tag_purple',16,2,1),(994,'tag_red',16,2,1),(995,'tag_yellow',16,2,1),(996,'tar',16,2,1),(997,'telephone',16,2,1),(998,'telephone_add',16,2,1),(999,'telephone_delete',16,2,1),(1000,'telephone_edit',16,2,1),(1001,'telephone_error',16,2,1),(1002,'telephone_go',16,2,1),(1003,'telephone_key',16,2,1),(1004,'telephone_link',16,2,1),(1005,'television',16,2,1),(1006,'television_add',16,2,1),(1007,'television_delete',16,2,1),(1008,'terminal',16,2,1),(1010,'textfield',16,2,1),(1011,'textfield_add',16,2,1),(1012,'textfield_delete',16,2,1),(1013,'textfield_key',16,2,1),(1014,'textfield_rename',16,2,1),(1015,'text_align_center',16,2,1),(1016,'text_align_justify',16,2,1),(1017,'text_align_left',16,2,1),(1018,'text_align_right',16,2,1),(1019,'text_allcaps',16,2,1),(1020,'text_bold',16,2,1),(1021,'text_columns',16,2,1),(1022,'text_dropcaps',16,2,1),(1023,'text_heading_1',16,2,1),(1024,'text_heading_2',16,2,1),(1025,'text_heading_3',16,2,1),(1026,'text_heading_4',16,2,1),(1027,'text_heading_5',16,2,1),(1028,'text_heading_6',16,2,1),(1029,'text_horizontalrule',16,2,1),(1030,'text_indent',16,2,1),(1031,'text_indent_remove',16,2,1),(1032,'text_italic',16,2,1),(1033,'text_kerning',16,2,1),(1034,'text_letterspacing',16,2,1),(1035,'text_letter_omega',16,2,1),(1036,'text_linespacing',16,2,1),(1037,'text_list_bullets',16,2,1),(1038,'text_list_numbers',16,2,1),(1039,'text_lowercase',16,2,1),(1040,'text_padding_bottom',16,2,1),(1041,'text_padding_left',16,2,1),(1042,'text_padding_right',16,2,1),(1043,'text_padding_top',16,2,1),(1044,'text_replace',16,2,1),(1045,'text_signature',16,2,1),(1046,'text_smallcaps',16,2,1),(1047,'text_strikethrough',16,2,1),(1048,'text_subscript',16,2,1),(1049,'text_superscript',16,2,1),(1050,'text_underline',16,2,1),(1051,'text_uppercase',16,2,1),(1052,'tgz',16,2,1),(1053,'Thumbs.db',16,2,1),(1054,'thumb_down',16,2,1),(1055,'thumb_up',16,2,1),(1056,'tick',16,2,1),(1058,'time',16,2,1),(1059,'timeline_marker',16,2,1),(1060,'time_add',16,2,1),(1061,'time_delete',16,2,1),(1062,'time_go',16,2,1),(1063,'transmit',16,2,1),(1064,'transmit_add',16,2,1),(1065,'transmit_blue',16,2,1),(1066,'transmit_delete',16,2,1),(1067,'transmit_edit',16,2,1),(1068,'transmit_error',16,2,1),(1069,'transmit_go',16,2,1),(1070,'tux',16,2,1),(1072,'user',16,2,1),(1073,'user_add',16,2,1),(1074,'user_comment',16,2,1),(1075,'user_delete',16,2,1),(1076,'user_edit',16,2,1),(1077,'user_female',16,2,1),(1078,'user_go',16,2,1),(1079,'user_gray',16,2,1),(1080,'user_green',16,2,1),(1081,'user_orange',16,2,1),(1082,'user_red',16,2,1),(1083,'user_suit',16,2,1),(1084,'vcard',16,2,1),(1085,'vcard_add',16,2,1),(1086,'vcard_delete',16,2,1),(1087,'vcard_edit',16,2,1),(1088,'vector',16,2,1),(1089,'vector_add',16,2,1),(1090,'vector_delete',16,2,1),(1091,'video',16,2,1),(1093,'wand',16,2,1),(1094,'weather_clouds',16,2,1),(1095,'weather_cloudy',16,2,1),(1096,'weather_lightning',16,2,1),(1097,'weather_rain',16,2,1),(1098,'weather_snow',16,2,1),(1099,'weather_sun',16,2,1),(1100,'webcam',16,2,1),(1101,'webcam_add',16,2,1),(1102,'webcam_delete',16,2,1),(1103,'webcam_error',16,2,1),(1107,'world',16,2,1),(1108,'world_add',16,2,1),(1109,'world_delete',16,2,1),(1110,'world_edit',16,2,1),(1111,'world_go',16,2,1),(1112,'world_link',16,2,1),(1113,'wrench',16,2,1),(1114,'wrench_orange',16,2,1),(1115,'www',16,2,1),(1116,'xhtml',16,2,1),(1117,'xhtml_add',16,2,1),(1118,'xhtml_delete',16,2,1),(1119,'xhtml_go',16,2,1),(1120,'xhtml_valid',16,2,1),(1121,'yellow',16,2,1),(1123,'zoom',16,2,1),(1124,'zoom_in',16,2,1),(1125,'zoom_out',16,2,1),(1319,'.',64,0,1),(1320,'..',64,0,1),(1321,'.DS_Store',64,0,1),(1322,'10_64x64',64,0,1),(1323,'11_64x64',64,0,1),(1324,'12_64x64',64,0,1),(1325,'13_64x64',64,0,1),(1326,'14_64x64',64,0,1),(1327,'15_64x64',64,0,1),(1328,'16_64x64',64,0,1),(1329,'17_64x64',64,0,1),(1330,'18_64x64',64,0,1),(1331,'19_64x64',64,0,1),(1332,'1_64x64',64,0,1),(1333,'20_64x64',64,0,1),(1334,'21_64x64',64,0,1),(1335,'22_64x64',64,0,1),(1336,'23_64x64',64,0,1),(1337,'24_64x64',64,0,1),(1338,'25_64x64',64,0,1),(1339,'26_64x64',64,0,1),(1340,'27_64x64',64,0,1),(1341,'28_64x64',64,0,1),(1342,'29_64x64',64,0,1),(1343,'2_64x64',64,0,1),(1344,'30_64x64',64,0,1),(1345,'31_64x64',64,0,1),(1346,'32_64x64',64,0,1),(1347,'33_64x64',64,0,1),(1348,'34_64x64',64,0,1),(1349,'35_64x64',64,0,1),(1350,'36_64x64',64,0,1),(1351,'37_64x64',64,0,1),(1352,'38_64x64',64,0,1),(1353,'39_64x64',64,0,1),(1354,'3_64x64',64,0,1),(1355,'40_64x64',64,0,1),(1356,'41_64x64',64,0,1),(1357,'42_64x64',64,0,1),(1358,'43_64x64',64,0,1),(1359,'44_64x64',64,0,1),(1360,'45_64x64',64,0,1),(1361,'46_64x64',64,0,1),(1362,'47_64x64',64,0,1),(1363,'48_64x64',64,0,1),(1364,'49_64x64',64,0,1),(1365,'4_64x64',64,0,1),(1366,'50_64x64',64,0,1),(1367,'51_64x64',64,0,1),(1368,'52_64x64',64,0,1),(1369,'53_64x64',64,0,1),(1370,'54_64x64',64,0,1),(1371,'55_64x64',64,0,1),(1372,'56_64x64',64,0,1),(1373,'57_64x64',64,0,1),(1374,'58_64x64',64,0,1),(1375,'59_64x64',64,0,1),(1376,'5_64x64',64,0,1),(1377,'60_64x64',64,0,1),(1378,'6_64x64',64,0,1),(1379,'7_64x64',64,0,1),(1380,'8_64x64',64,0,1),(1381,'9_64x64',64,0,1),(1382,'App Store',64,0,1),(1383,'Assorted',64,0,1),(1384,'Backgammon',64,0,1),(1385,'BandB',64,0,1),(1386,'BandR',64,0,1),(1387,'Battery',64,0,1),(1388,'BatteryG',64,0,1),(1389,'BlockPuzzle',64,0,1),(1390,'BooksB',64,0,1),(1391,'BooksG',64,0,1),(1392,'BooksR',64,0,1),(1393,'BooksY',64,0,1),(1394,'BossPrefs',64,0,1),(1395,'BossTool',64,0,1),(1396,'Calculator Alt',64,0,1),(1397,'Calculator',64,0,1),(1398,'Calendar Kate',64,0,1),(1399,'Calendar',64,0,1),(1400,'Calendar_alt',64,0,1),(1401,'Camera',64,0,1),(1402,'Camera1',64,0,1),(1403,'Camera2',64,0,1),(1404,'Camera3',64,0,1),(1405,'Categories',64,0,1),(1406,'Chat',64,0,1),(1407,'Chat1',64,0,1),(1408,'Chess',64,0,1),(1409,'Chuzzle',64,0,1),(1410,'Clock Alt',64,0,1),(1411,'Clock',64,0,1),(1412,'Clock1',64,0,1),(1413,'Collage',64,0,1),(1414,'Contacts',64,0,1),(1415,'Converter',64,0,1),(1416,'CubicMan',64,0,1),(1417,'Customize',64,0,1),(1418,'DailyMotion',64,0,1),(1419,'Facebook',64,0,1),(1420,'Finder Alt',64,0,1),(1421,'Finder',64,0,1),(1422,'FiveDice',64,0,1),(1423,'Flashlight',64,0,1),(1424,'fring',64,0,1),(1425,'Games',64,0,1),(1426,'genesis4iphone',64,0,1),(1427,'gpSPhone',64,0,1),(1428,'gpSPhone1',64,0,1),(1429,'iBlackjack',64,0,1),(1430,'iCave',64,0,1),(1431,'iCopter',64,0,1),(1432,'Installer',64,0,1),(1433,'iPhysics1',64,0,1),(1434,'iPhysics2',64,0,1),(1435,'iPhysiscs',64,0,1),(1436,'iPod',64,0,1),(1437,'iQuickBlock',64,0,1),(1438,'iSlsk',64,0,1),(1439,'iSnake',64,0,1),(1440,'iSolitaire',64,0,1),(1441,'iTunes',64,0,1),(1442,'iTunes_alt',64,0,1),(1443,'iZoo Alt',64,0,1),(1444,'iZoo',64,0,1),(1445,'Kate',64,0,1),(1446,'Labyrinth',64,0,1),(1447,'Labyrinth1',64,0,1),(1448,'LightsOff',64,0,1),(1449,'MacThemes',64,0,1),(1450,'Mail',64,0,1),(1451,'Maps',64,0,1),(1452,'Messages',64,0,1),(1453,'MIIS iPhone Icons by ABH',64,0,1),(1454,'Mines',64,0,1),(1455,'MMS',64,0,1),(1456,'MobileScrobbler',64,0,1),(1457,'Multimedia',64,0,1),(1458,'Music',64,0,1),(1459,'MxTube',64,0,1),(1460,'NES',64,0,1),(1461,'Notes',64,0,1),(1462,'ParkingLot',64,0,1),(1463,'PDFViewer',64,0,1),(1464,'Phone Alt',64,0,1),(1465,'Phone Default',64,0,1),(1466,'Phone',64,0,1),(1467,'Phone_alt',64,0,1),(1468,'Photos',64,0,1),(1469,'Photos_alt',64,0,1),(1470,'Pianist',64,0,1),(1471,'Poof',64,0,1),(1472,'Pool Alt',64,0,1),(1473,'Pool',64,0,1),(1474,'preview.jpg',64,0,1),(1475,'RagingThunder',64,0,1),(1476,'Remote',64,0,1),(1477,'Respring',64,0,1),(1478,'Ringtones',64,0,1),(1479,'Safari Alt',64,0,1),(1480,'Safari',64,0,1),(1481,'ScummVM',64,0,1),(1482,'SendFile',64,0,1),(1483,'Settings',64,0,1),(1484,'Sketches',64,0,1),(1485,'SMBPrefs',64,0,1),(1486,'snes4iphone',64,0,1),(1487,'Stocks',64,0,1),(1488,'SysInfo',64,0,1),(1489,'Terminal',64,0,1),(1490,'Text',64,0,1),(1491,'Text1',64,0,1),(1492,'ToDoList',64,0,1),(1493,'ToDoList1',64,0,1),(1494,'TouchPad',64,0,1),(1495,'Tribal',64,0,1),(1496,'Tribal2',64,0,1),(1497,'Tris',64,0,1),(1498,'TuneWiki',64,0,1),(1499,'TwistedFingers',64,0,1),(1500,'VideoRecorder',64,0,1),(1501,'Videos',64,0,1),(1502,'VNSea',64,0,1),(1503,'Voice Memos',64,0,1),(1504,'Voice Memos_alt',64,0,1),(1505,'Weather Alt',64,0,1),(1506,'Weather',64,0,1),(1507,'WeDict',64,0,1),(1508,'WeDictRed',64,0,1),(1509,'Wikipedia',64,0,1),(1510,'WildEyes',64,0,1),(1511,'YouTube',64,0,1);
/*!40000 ALTER TABLE `icon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language` (
  `languageId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Language|',
  `languageDesc` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description|',
  `languageCode` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Code|',
  `isGoogle` tinyint(1) NOT NULL,
  `isBing` tinyint(1) NOT NULL,
  `isSpeakLite` tinyint(1) NOT NULL,
  `isWebServices` tinyint(1) NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`languageId`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language`
--

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` VALUES (9,'Afrikaans','af',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(10,'Albanian','sq',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(11,'Arabic','ar',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(12,'Belarusian','be',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(13,'Bulgarian','bg',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(14,'Catalan','ca',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(15,'Chinese Simplified','zh-CN',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(16,'Chinease Traditional','zh-TW',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(17,'Croation','hr',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(18,'Czech','cs',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(19,'Danish','da',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(20,'Dutch','nl',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(21,'English','en',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(22,'Estonian','et',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(23,'Filpino','tl',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(24,'Finnish','fi',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(25,'French','fr',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(26,'Galician','gl',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(27,'German','de',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(28,'Greek','el',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(29,'Haitian Creole','ht',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(30,'Hebrew','he',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(31,'Hindi','hi',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(32,'Hungarian','hu',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(33,'Icelandic','is',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(34,'Indonesian','id',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(35,'Irish','ga',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(36,'Italian','it',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(37,'Japanse','ja',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(38,'Latvian','lv',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(39,'lithuanian','lt',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(40,'Macedonian','mk',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(41,'Malay','ms',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(42,'Maltese','mt',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(43,'Norwegian','no',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(44,'Persian','fa',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(45,'Portuguese','pt',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(46,'Romanian','ro',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(47,'Rusia','ru',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(48,'Serbian','sr',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(49,'Slovak','sk',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(50,'Slovenian','sl',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(51,'Spanish','es',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(52,'Swahili','sw',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(53,'Swedish','sv',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(54,'Thai','th',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(55,'Ukranian','uk',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(56,'Vietnamese','vi',0,1,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(57,'Welsh','cy',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(58,'Yiddish','yi',0,0,0,0,0,0,0,0,0,1,0,0,0,2,'2011-07-05 00:00:00'),(60,'km','kk',0,0,0,0,0,0,0,1,0,1,0,0,0,2,'2011-07-05 04:49:03');
/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaf`
--

DROP TABLE IF EXISTS `leaf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leaf` (
  `leafId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Leaf|',
  `leafCategoryId` int(11) NOT NULL,
  `applicationId` int(11) NOT NULL,
  `moduleId` int(11) NOT NULL COMMENT 'Accordion|',
  `folderId` int(11) NOT NULL COMMENT 'Folder|',
  `iconId` int(11) NOT NULL DEFAULT '36' COMMENT 'Icon|',
  `leafSequence` int(11) NOT NULL COMMENT 'Sequence|',
  `leafCode` char(4) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Code|',
  `leafFilename` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Filename|',
  `leafEnglish` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Deleted|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`leafId`),
  KEY `leafCategoryId` (`leafCategoryId`),
  KEY `tabId` (`moduleId`),
  KEY `folderId` (`folderId`),
  KEY `iconId` (`iconId`),
  KEY `isDefault` (`isDefault`),
  KEY `isNew` (`isNew`),
  KEY `isDraft` (`isDraft`),
  KEY `isUpdate` (`isUpdate`),
  KEY `isDelete` (`isDelete`),
  KEY `isActive` (`isActive`),
  KEY `isApproved` (`isApproved`),
  KEY `isPost` (`isPost`),
  KEY `isReview` (`isReview`),
  KEY `applicationId` (`applicationId`),
  CONSTRAINT `leaf_ibfk_1` FOREIGN KEY (`moduleId`) REFERENCES `module` (`moduleId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaf_ibfk_2` FOREIGN KEY (`folderId`) REFERENCES `folder` (`folderId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `leaf_ibfk_3` FOREIGN KEY (`iconId`) REFERENCES `icon` (`iconId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaf`
--

LOCK TABLES `leaf` WRITE;
/*!40000 ALTER TABLE `leaf` DISABLE KEYS */;
INSERT INTO `leaf` VALUES (2,0,1,1,1,36,1,'','application.php','Application',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(3,0,1,1,1,36,2,'','module.php','Module',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(4,0,1,1,1,36,3,'','folder.php','Folder',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(5,0,1,1,1,36,4,'','leaf.php','Leaf',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(6,0,1,1,2,36,1,'','theme.php','Theme',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(7,0,1,1,2,36,2,'','language.php','Language',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(8,0,1,2,3,36,2,'','defaultLabel.php','Default Label',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(9,0,1,2,3,36,2,'','tableMapping.php','Table Mapping',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(10,0,1,2,3,36,2,'','string.php','System String',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(11,0,1,3,4,50,1,'','personal.php','Preference',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(12,0,1,3,4,50,2,'','password.php','Password',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(13,0,1,31,67,35,1,'','district.php','District',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(14,0,1,31,67,35,2,'','state.php','State',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(15,0,1,31,67,35,3,'','national.php','National',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(16,0,1,31,67,35,4,'','race.php','Race',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(17,0,1,31,67,35,5,'','religion.php','Religion',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(18,0,3,5,7,35,1,'','documentGen.php','Document Generator',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(19,0,2,5,67,43,1,'','religionv1.php','Religion Version 1 ',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(20,0,2,5,67,43,2,'','religionv2.php','Religion Version 2 ',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(21,0,2,5,67,43,3,'','religionv3.php','Religion Version 3 ',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(22,0,2,5,67,43,4,'','religionv4.php','Religion Version 4 ',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(23,0,2,6,67,43,1,'','religionv5.php','Religion Version 5 ',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(24,0,2,6,67,43,2,'','religionv6.php','Religion Version 6 ',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(25,0,1,31,67,36,6,'','gender.php','Gender',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(26,0,3,5,7,35,2,'','documentCode.php','Document Code',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(27,0,3,5,7,35,3,'','documentAssign.php','Document Assign',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(28,0,3,24,75,35,1,'','segment.php','Segment',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(29,0,3,24,75,35,2,'','entry.php','Entry',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(30,0,3,24,75,35,3,'','dimension.php','Dimension',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(31,0,3,24,75,35,4,'','consolidation.php','Account Consolidation',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(32,0,3,24,75,35,5,'','saperation.php','Account Saperation',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(33,0,3,24,8,35,1,'','entry.php','Entry',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(34,0,3,24,8,35,2,'','finalize.php','Finalize',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(35,0,3,24,9,35,1,'','entry.php','Entry',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(36,0,3,24,9,35,2,'','finalize.php','Finalize',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(37,0,3,24,10,35,1,'','finalize.php','Journal',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(38,0,3,24,10,35,2,'','finalize.php','Recurring Journal',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(39,0,3,24,10,35,3,'','finalize.php','Year End Journal',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(40,0,3,5,78,35,1,'','period.php','Setting Financial Period',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(41,0,4,16,57,35,1,'','documentGen.php','Document Generator',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(42,0,4,16,57,35,2,'','documentCode.php','Document Code',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(43,0,4,16,57,35,3,'','documentAssign.php','Document Assign',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(44,0,4,27,77,35,1,'','quotation.php','Quotation',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(45,0,4,27,77,35,2,'','sales.php','Sales Order',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(46,0,4,27,77,35,3,'','delivery.php','Delivery',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(47,0,4,27,77,35,4,'','return.php','Return',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(48,0,4,27,77,35,5,'','deposit.php','Deposit',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(49,0,4,27,77,35,6,'','deposit.php','Invoice + Payment',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(50,0,4,27,58,35,1,'','invoiceTemplate.php','Invoice Template',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(51,0,4,27,58,35,2,'','invoice.php','Invoice',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(52,0,4,27,58,35,3,'','invoiceRecurring.php','Recurring Invoice',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(53,0,4,27,58,35,4,'','invoiceReverse.php','Reverse Invoice',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(54,0,4,27,59,35,1,'','adjustment.php','adjustment.php',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(55,0,4,27,59,35,2,'','creditmemo.php','creditmemo.php',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(56,0,4,27,59,35,3,'','debitnote.php','debitnote.php',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(57,0,4,27,59,35,4,'','creditnote.php','creditnote.php',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(58,0,7,8,19,35,1,'','documentGen.php','Document Generator',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(59,0,7,8,19,35,2,'','documentCode.php','Document Code',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(60,0,7,8,19,35,3,'','documentAssign.php','Document Assign',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(61,0,7,18,69,35,1,'','entry.php','Entry',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(62,0,7,18,69,35,2,'','approved.php','Approved',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(63,0,7,18,69,35,3,'','update.php','Update',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(64,0,7,19,20,35,1,'','dividen.php','Dividen',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(65,0,7,36,21,35,1,'','share.php','List Share',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(66,0,7,36,21,35,1,'','share.php','List fee',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(67,0,7,36,21,35,1,'','share.php','List Voter',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00'),(68,0,4,8,19,35,3,'','cooperativesetting.php','cooperative Setting',0,0,0,0,0,1,0,0,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `leaf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leafaccess`
--

DROP TABLE IF EXISTS `leafaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leafaccess` (
  `leafAccessId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Access|',
  `leafId` int(11) NOT NULL COMMENT 'Leaf|',
  `staffId` int(11) NOT NULL COMMENT 'Staff|',
  `leafAccessDraftValue` tinyint(1) NOT NULL,
  `leafAccessCreateValue` tinyint(1) NOT NULL COMMENT 'Create|',
  `leafAccessReadValue` tinyint(1) NOT NULL,
  `leafAccessUpdateValue` tinyint(1) NOT NULL,
  `leafAccessDeleteValue` tinyint(1) NOT NULL,
  `leafAccessReviewValue` tinyint(1) NOT NULL,
  `leafAccessApprovedValue` tinyint(1) NOT NULL,
  `leafAccessPostValue` tinyint(1) NOT NULL,
  `leafAccessPrintValue` tinyint(1) NOT NULL,
  PRIMARY KEY (`leafAccessId`),
  KEY `leafId` (`leafId`),
  KEY `staffId` (`staffId`)
) ENGINE=InnoDB AUTO_INCREMENT=470 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leafaccess`
--

LOCK TABLES `leafaccess` WRITE;
/*!40000 ALTER TABLE `leafaccess` DISABLE KEYS */;
INSERT INTO `leafaccess` VALUES (1,2,2,0,0,0,0,0,0,0,0,0),(2,2,3,0,0,0,0,0,0,0,0,0),(3,2,4,0,0,0,0,0,0,0,0,0),(4,2,5,0,0,0,0,0,0,0,0,0),(5,2,6,0,0,0,0,0,0,0,0,0),(6,2,7,0,0,0,0,0,0,0,0,0),(7,2,8,0,0,0,0,0,0,0,0,0),(8,3,2,0,0,0,0,0,0,0,0,0),(9,3,3,0,0,0,0,0,0,0,0,0),(10,3,4,0,0,0,0,0,0,0,0,0),(11,3,5,0,0,0,0,0,0,0,0,0),(12,3,6,0,0,0,0,0,0,0,0,0),(13,3,7,0,0,0,0,0,0,0,0,0),(14,3,8,0,0,0,0,0,0,0,0,0),(15,4,2,0,0,0,0,0,0,0,0,0),(16,4,3,0,0,0,0,0,0,0,0,0),(17,4,4,0,0,0,0,0,0,0,0,0),(18,4,5,0,0,0,0,0,0,0,0,0),(19,4,6,0,0,0,0,0,0,0,0,0),(20,4,7,0,0,0,0,0,0,0,0,0),(21,4,8,0,0,0,0,0,0,0,0,0),(22,5,2,0,0,0,0,0,0,0,0,0),(23,5,3,0,0,0,0,0,0,0,0,0),(24,5,4,0,0,0,0,0,0,0,0,0),(25,5,5,0,0,0,0,0,0,0,0,0),(26,5,6,0,0,0,0,0,0,0,0,0),(27,5,7,0,0,0,0,0,0,0,0,0),(28,5,8,0,0,0,0,0,0,0,0,0),(29,6,2,0,0,0,0,0,0,0,0,0),(30,6,3,0,0,0,0,0,0,0,0,0),(31,6,4,0,0,0,0,0,0,0,0,0),(32,6,5,0,0,0,0,0,0,0,0,0),(33,6,6,0,0,0,0,0,0,0,0,0),(34,6,7,0,0,0,0,0,0,0,0,0),(35,6,8,0,0,0,0,0,0,0,0,0),(36,7,2,0,0,0,0,0,0,0,0,0),(37,7,3,0,0,0,0,0,0,0,0,0),(38,7,4,0,0,0,0,0,0,0,0,0),(39,7,5,0,0,0,0,0,0,0,0,0),(40,7,6,0,0,0,0,0,0,0,0,0),(41,7,7,0,0,0,0,0,0,0,0,0),(42,7,8,0,0,0,0,0,0,0,0,0),(43,8,2,0,0,0,0,0,0,0,0,0),(44,8,3,0,0,0,0,0,0,0,0,0),(45,8,4,0,0,0,0,0,0,0,0,0),(46,8,5,0,0,0,0,0,0,0,0,0),(47,8,6,0,0,0,0,0,0,0,0,0),(48,8,7,0,0,0,0,0,0,0,0,0),(49,8,8,0,0,0,0,0,0,0,0,0),(50,9,2,0,0,0,0,0,0,0,0,0),(51,9,3,0,0,0,0,0,0,0,0,0),(52,9,4,0,0,0,0,0,0,0,0,0),(53,9,5,0,0,0,0,0,0,0,0,0),(54,9,6,0,0,0,0,0,0,0,0,0),(55,9,7,0,0,0,0,0,0,0,0,0),(56,9,8,0,0,0,0,0,0,0,0,0),(57,10,2,0,0,0,0,0,0,0,0,0),(58,10,3,0,0,0,0,0,0,0,0,0),(59,10,4,0,0,0,0,0,0,0,0,0),(60,10,5,0,0,0,0,0,0,0,0,0),(61,10,6,0,0,0,0,0,0,0,0,0),(62,10,7,0,0,0,0,0,0,0,0,0),(63,10,8,0,0,0,0,0,0,0,0,0),(64,11,2,0,0,0,0,0,0,0,0,0),(65,11,3,0,0,0,0,0,0,0,0,0),(66,11,4,0,0,0,0,0,0,0,0,0),(67,11,5,0,0,0,0,0,0,0,0,0),(68,11,6,0,0,0,0,0,0,0,0,0),(69,11,7,0,0,0,0,0,0,0,0,0),(70,11,8,0,0,0,0,0,0,0,0,0),(71,12,2,0,0,0,0,0,0,0,0,0),(72,12,3,0,0,0,0,0,0,0,0,0),(73,12,4,0,0,0,0,0,0,0,0,0),(74,12,5,0,0,0,0,0,0,0,0,0),(75,12,6,0,0,0,0,0,0,0,0,0),(76,12,7,0,0,0,0,0,0,0,0,0),(77,12,8,0,0,0,0,0,0,0,0,0),(78,13,2,0,0,0,0,0,0,0,0,0),(79,13,3,0,0,0,0,0,0,0,0,0),(80,13,4,0,0,0,0,0,0,0,0,0),(81,13,5,0,0,0,0,0,0,0,0,0),(82,13,6,0,0,0,0,0,0,0,0,0),(83,13,7,0,0,0,0,0,0,0,0,0),(84,13,8,0,0,0,0,0,0,0,0,0),(85,14,2,0,0,0,0,0,0,0,0,0),(86,14,3,0,0,0,0,0,0,0,0,0),(87,14,4,0,0,0,0,0,0,0,0,0),(88,14,5,0,0,0,0,0,0,0,0,0),(89,14,6,0,0,0,0,0,0,0,0,0),(90,14,7,0,0,0,0,0,0,0,0,0),(91,14,8,0,0,0,0,0,0,0,0,0),(92,15,2,0,0,0,0,0,0,0,0,0),(93,15,3,0,0,0,0,0,0,0,0,0),(94,15,4,0,0,0,0,0,0,0,0,0),(95,15,5,0,0,0,0,0,0,0,0,0),(96,15,6,0,0,0,0,0,0,0,0,0),(97,15,7,0,0,0,0,0,0,0,0,0),(98,15,8,0,0,0,0,0,0,0,0,0),(99,16,2,0,0,0,0,0,0,0,0,0),(100,16,3,0,0,0,0,0,0,0,0,0),(101,16,4,0,0,0,0,0,0,0,0,0),(102,16,5,0,0,0,0,0,0,0,0,0),(103,16,6,0,0,0,0,0,0,0,0,0),(104,16,7,0,0,0,0,0,0,0,0,0),(105,16,8,0,0,0,0,0,0,0,0,0),(106,17,2,0,0,0,0,0,0,0,0,0),(107,17,3,0,0,0,0,0,0,0,0,0),(108,17,4,0,0,0,0,0,0,0,0,0),(109,17,5,0,0,0,0,0,0,0,0,0),(110,17,6,0,0,0,0,0,0,0,0,0),(111,17,7,0,0,0,0,0,0,0,0,0),(112,17,8,0,0,0,0,0,0,0,0,0),(113,18,2,0,0,0,0,0,0,0,0,0),(114,18,3,0,0,0,0,0,0,0,0,0),(115,18,4,0,0,0,0,0,0,0,0,0),(116,18,5,0,0,0,0,0,0,0,0,0),(117,18,6,0,0,0,0,0,0,0,0,0),(118,18,7,0,0,0,0,0,0,0,0,0),(119,18,8,0,0,0,0,0,0,0,0,0),(120,19,2,0,0,0,0,0,0,0,0,0),(121,19,3,0,0,0,0,0,0,0,0,0),(122,19,4,0,0,0,0,0,0,0,0,0),(123,19,5,0,0,0,0,0,0,0,0,0),(124,19,6,0,0,0,0,0,0,0,0,0),(125,19,7,0,0,0,0,0,0,0,0,0),(126,19,8,0,0,0,0,0,0,0,0,0),(127,20,2,0,0,0,0,0,0,0,0,0),(128,20,3,0,0,0,0,0,0,0,0,0),(129,20,4,0,0,0,0,0,0,0,0,0),(130,20,5,0,0,0,0,0,0,0,0,0),(131,20,6,0,0,0,0,0,0,0,0,0),(132,20,7,0,0,0,0,0,0,0,0,0),(133,20,8,0,0,0,0,0,0,0,0,0),(134,21,2,0,0,0,0,0,0,0,0,0),(135,21,3,0,0,0,0,0,0,0,0,0),(136,21,4,0,0,0,0,0,0,0,0,0),(137,21,5,0,0,0,0,0,0,0,0,0),(138,21,6,0,0,0,0,0,0,0,0,0),(139,21,7,0,0,0,0,0,0,0,0,0),(140,21,8,0,0,0,0,0,0,0,0,0),(141,22,2,0,0,0,0,0,0,0,0,0),(142,22,3,0,0,0,0,0,0,0,0,0),(143,22,4,0,0,0,0,0,0,0,0,0),(144,22,5,0,0,0,0,0,0,0,0,0),(145,22,6,0,0,0,0,0,0,0,0,0),(146,22,7,0,0,0,0,0,0,0,0,0),(147,22,8,0,0,0,0,0,0,0,0,0),(148,23,2,0,0,0,0,0,0,0,0,0),(149,23,3,0,0,0,0,0,0,0,0,0),(150,23,4,0,0,0,0,0,0,0,0,0),(151,23,5,0,0,0,0,0,0,0,0,0),(152,23,6,0,0,0,0,0,0,0,0,0),(153,23,7,0,0,0,0,0,0,0,0,0),(154,23,8,0,0,0,0,0,0,0,0,0),(155,24,2,0,0,0,0,0,0,0,0,0),(156,24,3,0,0,0,0,0,0,0,0,0),(157,24,4,0,0,0,0,0,0,0,0,0),(158,24,5,0,0,0,0,0,0,0,0,0),(159,24,6,0,0,0,0,0,0,0,0,0),(160,24,7,0,0,0,0,0,0,0,0,0),(161,24,8,0,0,0,0,0,0,0,0,0),(162,25,2,0,0,0,0,0,0,0,0,0),(163,25,3,0,0,0,0,0,0,0,0,0),(164,25,4,0,0,0,0,0,0,0,0,0),(165,25,5,0,0,0,0,0,0,0,0,0),(166,25,6,0,0,0,0,0,0,0,0,0),(167,25,7,0,0,0,0,0,0,0,0,0),(168,25,8,0,0,0,0,0,0,0,0,0),(169,26,2,0,0,0,0,0,0,0,0,0),(170,26,3,0,0,0,0,0,0,0,0,0),(171,26,4,0,0,0,0,0,0,0,0,0),(172,26,5,0,0,0,0,0,0,0,0,0),(173,26,6,0,0,0,0,0,0,0,0,0),(174,26,7,0,0,0,0,0,0,0,0,0),(175,26,8,0,0,0,0,0,0,0,0,0),(176,27,2,0,0,0,0,0,0,0,0,0),(177,27,3,0,0,0,0,0,0,0,0,0),(178,27,4,0,0,0,0,0,0,0,0,0),(179,27,5,0,0,0,0,0,0,0,0,0),(180,27,6,0,0,0,0,0,0,0,0,0),(181,27,7,0,0,0,0,0,0,0,0,0),(182,27,8,0,0,0,0,0,0,0,0,0),(183,28,2,0,0,0,0,0,0,0,0,0),(184,28,3,0,0,0,0,0,0,0,0,0),(185,28,4,0,0,0,0,0,0,0,0,0),(186,28,5,0,0,0,0,0,0,0,0,0),(187,28,6,0,0,0,0,0,0,0,0,0),(188,28,7,0,0,0,0,0,0,0,0,0),(189,28,8,0,0,0,0,0,0,0,0,0),(190,29,2,0,0,0,0,0,0,0,0,0),(191,29,3,0,0,0,0,0,0,0,0,0),(192,29,4,0,0,0,0,0,0,0,0,0),(193,29,5,0,0,0,0,0,0,0,0,0),(194,29,6,0,0,0,0,0,0,0,0,0),(195,29,7,0,0,0,0,0,0,0,0,0),(196,29,8,0,0,0,0,0,0,0,0,0),(197,30,2,0,0,0,0,0,0,0,0,0),(198,30,3,0,0,0,0,0,0,0,0,0),(199,30,4,0,0,0,0,0,0,0,0,0),(200,30,5,0,0,0,0,0,0,0,0,0),(201,30,6,0,0,0,0,0,0,0,0,0),(202,30,7,0,0,0,0,0,0,0,0,0),(203,30,8,0,0,0,0,0,0,0,0,0),(204,31,2,0,0,0,0,0,0,0,0,0),(205,31,3,0,0,0,0,0,0,0,0,0),(206,31,4,0,0,0,0,0,0,0,0,0),(207,31,5,0,0,0,0,0,0,0,0,0),(208,31,6,0,0,0,0,0,0,0,0,0),(209,31,7,0,0,0,0,0,0,0,0,0),(210,31,8,0,0,0,0,0,0,0,0,0),(211,32,2,0,0,0,0,0,0,0,0,0),(212,32,3,0,0,0,0,0,0,0,0,0),(213,32,4,0,0,0,0,0,0,0,0,0),(214,32,5,0,0,0,0,0,0,0,0,0),(215,32,6,0,0,0,0,0,0,0,0,0),(216,32,7,0,0,0,0,0,0,0,0,0),(217,32,8,0,0,0,0,0,0,0,0,0),(218,33,2,0,0,0,0,0,0,0,0,0),(219,33,3,0,0,0,0,0,0,0,0,0),(220,33,4,0,0,0,0,0,0,0,0,0),(221,33,5,0,0,0,0,0,0,0,0,0),(222,33,6,0,0,0,0,0,0,0,0,0),(223,33,7,0,0,0,0,0,0,0,0,0),(224,33,8,0,0,0,0,0,0,0,0,0),(225,34,2,0,0,0,0,0,0,0,0,0),(226,34,3,0,0,0,0,0,0,0,0,0),(227,34,4,0,0,0,0,0,0,0,0,0),(228,34,5,0,0,0,0,0,0,0,0,0),(229,34,6,0,0,0,0,0,0,0,0,0),(230,34,7,0,0,0,0,0,0,0,0,0),(231,34,8,0,0,0,0,0,0,0,0,0),(232,35,2,0,0,0,0,0,0,0,0,0),(233,35,3,0,0,0,0,0,0,0,0,0),(234,35,4,0,0,0,0,0,0,0,0,0),(235,35,5,0,0,0,0,0,0,0,0,0),(236,35,6,0,0,0,0,0,0,0,0,0),(237,35,7,0,0,0,0,0,0,0,0,0),(238,35,8,0,0,0,0,0,0,0,0,0),(239,36,2,0,0,0,0,0,0,0,0,0),(240,36,3,0,0,0,0,0,0,0,0,0),(241,36,4,0,0,0,0,0,0,0,0,0),(242,36,5,0,0,0,0,0,0,0,0,0),(243,36,6,0,0,0,0,0,0,0,0,0),(244,36,7,0,0,0,0,0,0,0,0,0),(245,36,8,0,0,0,0,0,0,0,0,0),(246,37,2,0,0,0,0,0,0,0,0,0),(247,37,3,0,0,0,0,0,0,0,0,0),(248,37,4,0,0,0,0,0,0,0,0,0),(249,37,5,0,0,0,0,0,0,0,0,0),(250,37,6,0,0,0,0,0,0,0,0,0),(251,37,7,0,0,0,0,0,0,0,0,0),(252,37,8,0,0,0,0,0,0,0,0,0),(253,38,2,0,0,0,0,0,0,0,0,0),(254,38,3,0,0,0,0,0,0,0,0,0),(255,38,4,0,0,0,0,0,0,0,0,0),(256,38,5,0,0,0,0,0,0,0,0,0),(257,38,6,0,0,0,0,0,0,0,0,0),(258,38,7,0,0,0,0,0,0,0,0,0),(259,38,8,0,0,0,0,0,0,0,0,0),(260,39,2,0,0,0,0,0,0,0,0,0),(261,39,3,0,0,0,0,0,0,0,0,0),(262,39,4,0,0,0,0,0,0,0,0,0),(263,39,5,0,0,0,0,0,0,0,0,0),(264,39,6,0,0,0,0,0,0,0,0,0),(265,39,7,0,0,0,0,0,0,0,0,0),(266,39,8,0,0,0,0,0,0,0,0,0),(267,40,2,0,0,0,0,0,0,0,0,0),(268,40,3,0,0,0,0,0,0,0,0,0),(269,40,4,0,0,0,0,0,0,0,0,0),(270,40,5,0,0,0,0,0,0,0,0,0),(271,40,6,0,0,0,0,0,0,0,0,0),(272,40,7,0,0,0,0,0,0,0,0,0),(273,40,8,0,0,0,0,0,0,0,0,0),(274,41,2,0,0,0,0,0,0,0,0,0),(275,41,3,0,0,0,0,0,0,0,0,0),(276,41,4,0,0,0,0,0,0,0,0,0),(277,41,5,0,0,0,0,0,0,0,0,0),(278,41,6,0,0,0,0,0,0,0,0,0),(279,41,7,0,0,0,0,0,0,0,0,0),(280,41,8,0,0,0,0,0,0,0,0,0),(281,42,2,0,0,0,0,0,0,0,0,0),(282,42,3,0,0,0,0,0,0,0,0,0),(283,42,4,0,0,0,0,0,0,0,0,0),(284,42,5,0,0,0,0,0,0,0,0,0),(285,42,6,0,0,0,0,0,0,0,0,0),(286,42,7,0,0,0,0,0,0,0,0,0),(287,42,8,0,0,0,0,0,0,0,0,0),(288,43,2,0,0,0,0,0,0,0,0,0),(289,43,3,0,0,0,0,0,0,0,0,0),(290,43,4,0,0,0,0,0,0,0,0,0),(291,43,5,0,0,0,0,0,0,0,0,0),(292,43,6,0,0,0,0,0,0,0,0,0),(293,43,7,0,0,0,0,0,0,0,0,0),(294,43,8,0,0,0,0,0,0,0,0,0),(295,44,2,0,0,0,0,0,0,0,0,0),(296,44,3,0,0,0,0,0,0,0,0,0),(297,44,4,0,0,0,0,0,0,0,0,0),(298,44,5,0,0,0,0,0,0,0,0,0),(299,44,6,0,0,0,0,0,0,0,0,0),(300,44,7,0,0,0,0,0,0,0,0,0),(301,44,8,0,0,0,0,0,0,0,0,0),(302,45,2,0,0,0,0,0,0,0,0,0),(303,45,3,0,0,0,0,0,0,0,0,0),(304,45,4,0,0,0,0,0,0,0,0,0),(305,45,5,0,0,0,0,0,0,0,0,0),(306,45,6,0,0,0,0,0,0,0,0,0),(307,45,7,0,0,0,0,0,0,0,0,0),(308,45,8,0,0,0,0,0,0,0,0,0),(309,46,2,0,0,0,0,0,0,0,0,0),(310,46,3,0,0,0,0,0,0,0,0,0),(311,46,4,0,0,0,0,0,0,0,0,0),(312,46,5,0,0,0,0,0,0,0,0,0),(313,46,6,0,0,0,0,0,0,0,0,0),(314,46,7,0,0,0,0,0,0,0,0,0),(315,46,8,0,0,0,0,0,0,0,0,0),(316,47,2,0,0,0,0,0,0,0,0,0),(317,47,3,0,0,0,0,0,0,0,0,0),(318,47,4,0,0,0,0,0,0,0,0,0),(319,47,5,0,0,0,0,0,0,0,0,0),(320,47,6,0,0,0,0,0,0,0,0,0),(321,47,7,0,0,0,0,0,0,0,0,0),(322,47,8,0,0,0,0,0,0,0,0,0),(323,48,2,0,0,0,0,0,0,0,0,0),(324,48,3,0,0,0,0,0,0,0,0,0),(325,48,4,0,0,0,0,0,0,0,0,0),(326,48,5,0,0,0,0,0,0,0,0,0),(327,48,6,0,0,0,0,0,0,0,0,0),(328,48,7,0,0,0,0,0,0,0,0,0),(329,48,8,0,0,0,0,0,0,0,0,0),(330,49,2,0,0,0,0,0,0,0,0,0),(331,49,3,0,0,0,0,0,0,0,0,0),(332,49,4,0,0,0,0,0,0,0,0,0),(333,49,5,0,0,0,0,0,0,0,0,0),(334,49,6,0,0,0,0,0,0,0,0,0),(335,49,7,0,0,0,0,0,0,0,0,0),(336,49,8,0,0,0,0,0,0,0,0,0),(337,50,2,0,0,0,0,0,0,0,0,0),(338,50,3,0,0,0,0,0,0,0,0,0),(339,50,4,0,0,0,0,0,0,0,0,0),(340,50,5,0,0,0,0,0,0,0,0,0),(341,50,6,0,0,0,0,0,0,0,0,0),(342,50,7,0,0,0,0,0,0,0,0,0),(343,50,8,0,0,0,0,0,0,0,0,0),(344,51,2,0,0,0,0,0,0,0,0,0),(345,51,3,0,0,0,0,0,0,0,0,0),(346,51,4,0,0,0,0,0,0,0,0,0),(347,51,5,0,0,0,0,0,0,0,0,0),(348,51,6,0,0,0,0,0,0,0,0,0),(349,51,7,0,0,0,0,0,0,0,0,0),(350,51,8,0,0,0,0,0,0,0,0,0),(351,52,2,0,0,0,0,0,0,0,0,0),(352,52,3,0,0,0,0,0,0,0,0,0),(353,52,4,0,0,0,0,0,0,0,0,0),(354,52,5,0,0,0,0,0,0,0,0,0),(355,52,6,0,0,0,0,0,0,0,0,0),(356,52,7,0,0,0,0,0,0,0,0,0),(357,52,8,0,0,0,0,0,0,0,0,0),(358,53,2,0,0,0,0,0,0,0,0,0),(359,53,3,0,0,0,0,0,0,0,0,0),(360,53,4,0,0,0,0,0,0,0,0,0),(361,53,5,0,0,0,0,0,0,0,0,0),(362,53,6,0,0,0,0,0,0,0,0,0),(363,53,7,0,0,0,0,0,0,0,0,0),(364,53,8,0,0,0,0,0,0,0,0,0),(365,54,2,0,0,0,0,0,0,0,0,0),(366,54,3,0,0,0,0,0,0,0,0,0),(367,54,4,0,0,0,0,0,0,0,0,0),(368,54,5,0,0,0,0,0,0,0,0,0),(369,54,6,0,0,0,0,0,0,0,0,0),(370,54,7,0,0,0,0,0,0,0,0,0),(371,54,8,0,0,0,0,0,0,0,0,0),(372,55,2,0,0,0,0,0,0,0,0,0),(373,55,3,0,0,0,0,0,0,0,0,0),(374,55,4,0,0,0,0,0,0,0,0,0),(375,55,5,0,0,0,0,0,0,0,0,0),(376,55,6,0,0,0,0,0,0,0,0,0),(377,55,7,0,0,0,0,0,0,0,0,0),(378,55,8,0,0,0,0,0,0,0,0,0),(379,56,2,0,0,0,0,0,0,0,0,0),(380,56,3,0,0,0,0,0,0,0,0,0),(381,56,4,0,0,0,0,0,0,0,0,0),(382,56,5,0,0,0,0,0,0,0,0,0),(383,56,6,0,0,0,0,0,0,0,0,0),(384,56,7,0,0,0,0,0,0,0,0,0),(385,56,8,0,0,0,0,0,0,0,0,0),(386,57,2,0,0,0,0,0,0,0,0,0),(387,57,3,0,0,0,0,0,0,0,0,0),(388,57,4,0,0,0,0,0,0,0,0,0),(389,57,5,0,0,0,0,0,0,0,0,0),(390,57,6,0,0,0,0,0,0,0,0,0),(391,57,7,0,0,0,0,0,0,0,0,0),(392,57,8,0,0,0,0,0,0,0,0,0),(393,58,2,0,0,0,0,0,0,0,0,0),(394,58,3,0,0,0,0,0,0,0,0,0),(395,58,4,0,0,0,0,0,0,0,0,0),(396,58,5,0,0,0,0,0,0,0,0,0),(397,58,6,0,0,0,0,0,0,0,0,0),(398,58,7,0,0,0,0,0,0,0,0,0),(399,58,8,0,0,0,0,0,0,0,0,0),(400,59,2,0,0,0,0,0,0,0,0,0),(401,59,3,0,0,0,0,0,0,0,0,0),(402,59,4,0,0,0,0,0,0,0,0,0),(403,59,5,0,0,0,0,0,0,0,0,0),(404,59,6,0,0,0,0,0,0,0,0,0),(405,59,7,0,0,0,0,0,0,0,0,0),(406,59,8,0,0,0,0,0,0,0,0,0),(407,60,2,0,0,0,0,0,0,0,0,0),(408,60,3,0,0,0,0,0,0,0,0,0),(409,60,4,0,0,0,0,0,0,0,0,0),(410,60,5,0,0,0,0,0,0,0,0,0),(411,60,6,0,0,0,0,0,0,0,0,0),(412,60,7,0,0,0,0,0,0,0,0,0),(413,60,8,0,0,0,0,0,0,0,0,0),(414,61,2,0,0,0,0,0,0,0,0,0),(415,61,3,0,0,0,0,0,0,0,0,0),(416,61,4,0,0,0,0,0,0,0,0,0),(417,61,5,0,0,0,0,0,0,0,0,0),(418,61,6,0,0,0,0,0,0,0,0,0),(419,61,7,0,0,0,0,0,0,0,0,0),(420,61,8,0,0,0,0,0,0,0,0,0),(421,62,2,0,0,0,0,0,0,0,0,0),(422,62,3,0,0,0,0,0,0,0,0,0),(423,62,4,0,0,0,0,0,0,0,0,0),(424,62,5,0,0,0,0,0,0,0,0,0),(425,62,6,0,0,0,0,0,0,0,0,0),(426,62,7,0,0,0,0,0,0,0,0,0),(427,62,8,0,0,0,0,0,0,0,0,0),(428,63,2,0,0,0,0,0,0,0,0,0),(429,63,3,0,0,0,0,0,0,0,0,0),(430,63,4,0,0,0,0,0,0,0,0,0),(431,63,5,0,0,0,0,0,0,0,0,0),(432,63,6,0,0,0,0,0,0,0,0,0),(433,63,7,0,0,0,0,0,0,0,0,0),(434,63,8,0,0,0,0,0,0,0,0,0),(435,64,2,0,0,0,0,0,0,0,0,0),(436,64,3,0,0,0,0,0,0,0,0,0),(437,64,4,0,0,0,0,0,0,0,0,0),(438,64,5,0,0,0,0,0,0,0,0,0),(439,64,6,0,0,0,0,0,0,0,0,0),(440,64,7,0,0,0,0,0,0,0,0,0),(441,64,8,0,0,0,0,0,0,0,0,0),(442,65,2,0,0,0,0,0,0,0,0,0),(443,65,3,0,0,0,0,0,0,0,0,0),(444,65,4,0,0,0,0,0,0,0,0,0),(445,65,5,0,0,0,0,0,0,0,0,0),(446,65,6,0,0,0,0,0,0,0,0,0),(447,65,7,0,0,0,0,0,0,0,0,0),(448,65,8,0,0,0,0,0,0,0,0,0),(449,66,2,0,0,0,0,0,0,0,0,0),(450,66,3,0,0,0,0,0,0,0,0,0),(451,66,4,0,0,0,0,0,0,0,0,0),(452,66,5,0,0,0,0,0,0,0,0,0),(453,66,6,0,0,0,0,0,0,0,0,0),(454,66,7,0,0,0,0,0,0,0,0,0),(455,66,8,0,0,0,0,0,0,0,0,0),(456,67,2,0,0,0,0,0,0,0,0,0),(457,67,3,0,0,0,0,0,0,0,0,0),(458,67,4,0,0,0,0,0,0,0,0,0),(459,67,5,0,0,0,0,0,0,0,0,0),(460,67,6,0,0,0,0,0,0,0,0,0),(461,67,7,0,0,0,0,0,0,0,0,0),(462,67,8,0,0,0,0,0,0,0,0,0),(463,68,2,0,0,0,0,0,0,0,0,0),(464,68,3,0,0,0,0,0,0,0,0,0),(465,68,4,0,0,0,0,0,0,0,0,0),(466,68,5,0,0,0,0,0,0,0,0,0),(467,68,6,0,0,0,0,0,0,0,0,0),(468,68,7,0,0,0,0,0,0,0,0,0),(469,68,8,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `leafaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leafapproval`
--

DROP TABLE IF EXISTS `leafapproval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leafapproval` (
  `leafApprovalId` int(11) NOT NULL AUTO_INCREMENT,
  `leafApprovalEnum` char(1) COLLATE utf8_bin NOT NULL COMMENT '''S'',''G''',
  `leafId` int(11) NOT NULL,
  `staffId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL,
  `leafApprovalSuccessMessage` text COLLATE utf8_bin NOT NULL,
  `leafApprovalFailureMessage` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`leafApprovalId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leafapproval`
--

LOCK TABLES `leafapproval` WRITE;
/*!40000 ALTER TABLE `leafapproval` DISABLE KEYS */;
/*!40000 ALTER TABLE `leafapproval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leafcategory`
--

DROP TABLE IF EXISTS `leafcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leafcategory` (
  `leafCategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `leafCategoryNote` varchar(64) NOT NULL,
  PRIMARY KEY (`leafCategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leafcategory`
--

LOCK TABLES `leafcategory` WRITE;
/*!40000 ALTER TABLE `leafcategory` DISABLE KEYS */;
INSERT INTO `leafcategory` VALUES (1,'Application'),(2,'Report'),(3,'Enquiry'),(4,'Others');
/*!40000 ALTER TABLE `leafcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaftranslate`
--

DROP TABLE IF EXISTS `leaftranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leaftranslate` (
  `leafTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'translate|',
  `leafId` int(11) NOT NULL COMMENT 'leaf|',
  `languageId` int(11) NOT NULL COMMENT 'language|',
  `leafNative` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Leaf|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`leafTranslateId`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaftranslate`
--

LOCK TABLES `leaftranslate` WRITE;
/*!40000 ALTER TABLE `leaftranslate` DISABLE KEYS */;
INSERT INTO `leaftranslate` VALUES (1,2,21,'Application',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(2,3,21,'Module',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(3,4,21,'Folder',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(4,5,21,'Leaf',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(5,6,21,'Theme',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(6,7,21,'Language',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(7,8,21,'Default Label',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(8,9,21,'Table Mapping',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(9,10,21,'System String',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(10,11,21,'Preference',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(11,12,21,'Password',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(12,13,21,'District',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(13,14,21,'State',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(14,15,21,'National',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(15,16,21,'Race',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(16,17,21,'Religion',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(17,18,21,'Document Generator',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(18,19,21,'Religion Version 1 ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(19,20,21,'Religion Version 2 ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(20,21,21,'Religion Version 3 ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(21,22,21,'Religion Version 4 ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(22,23,21,'Religion Version 5 ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(23,24,21,'Religion Version 6 ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(24,25,21,'Gender',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(25,26,21,'Document Code',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(26,27,21,'Document Assign',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(27,28,21,'Segment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(28,29,21,'Entry',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(29,30,21,'Dimension',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(30,31,21,'Account Consolidation',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(31,32,21,'Account Saperation',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(32,33,21,'Entry',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(33,34,21,'Finalize',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(34,35,21,'Entry',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(35,36,21,'Finalize',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(36,37,21,'Journal',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(37,38,21,'Recurring Journal',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(38,39,21,'Year End Journal',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(39,40,21,'Setting Financial Period',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(40,41,21,'Document Generator',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(41,42,21,'Document Code',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(42,43,21,'Document Assign',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(43,44,21,'Quotation',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(44,45,21,'Sales Order',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(45,46,21,'Delivery',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(46,47,21,'Return',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(47,48,21,'Deposit',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(48,49,21,'Invoice + Payment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(49,50,21,'Invoice Template',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(50,51,21,'Invoice',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(51,52,21,'Recurring Invoice',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(52,53,21,'Reverse Invoice',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(53,54,21,'adjustment.php',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(54,55,21,'creditmemo.php',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(55,56,21,'debitnote.php',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(56,57,21,'creditnote.php',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(57,58,21,'Document Generator',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(58,59,21,'Document Code',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(59,60,21,'Document Assign',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(60,61,21,'Entry',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(61,62,21,'Approved',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(62,63,21,'Update',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(63,64,21,'Dividen',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(64,65,21,'List Share',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(65,66,21,'List fee',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(66,67,21,'List Voter',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(67,68,21,'cooperative Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35');
/*!40000 ALTER TABLE `leaftranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leafuser`
--

DROP TABLE IF EXISTS `leafuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leafuser` (
  `leafUserId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Leaf User|',
  `leafId` int(11) NOT NULL COMMENT 'leaf|',
  `leafSequence` int(11) NOT NULL COMMENT 'Sequence|',
  `staffId` int(11) NOT NULL,
  PRIMARY KEY (`leafUserId`),
  KEY `leafId` (`leafId`),
  KEY `staffId` (`staffId`),
  CONSTRAINT `leafuser_ibfk_1` FOREIGN KEY (`staffId`) REFERENCES `staff` (`staffId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This is User Predefine  long list tree grid.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leafuser`
--

LOCK TABLES `leafuser` WRITE;
/*!40000 ALTER TABLE `leafuser` DISABLE KEYS */;
/*!40000 ALTER TABLE `leafuser` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,5,'leafAccessReadValue','\r\n					SELECT	`language`.`languageId`,\r\n							`language`.`languageCode`,\r\n							`language`.`languageDesc`,\r\n							`language`.`isDefault`,\r\n							`language`.`isNew`,\r\n							`language`.`isDraft`,\r\n							`language`.`isUpdate`,\r\n							`language`.`isDelete`,\r\n							`language`.`isActive`,\r\n							`language`.`isApproved`,\r\n							`language`.`executeBy`,\r\n							`language`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`language`\r\n					JOIN	`staff`\r\n					ON		`language`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`language`.`isActive`		=	1','2011-11-16 11:30:31',2,'Granted',''),(2,5,'leafAccessReadValue','\r\n					SELECT	`language`.`languageId`,\r\n							`language`.`languageCode`,\r\n							`language`.`languageDesc`,\r\n							`language`.`isDefault`,\r\n							`language`.`isNew`,\r\n							`language`.`isDraft`,\r\n							`language`.`isUpdate`,\r\n							`language`.`isDelete`,\r\n							`language`.`isActive`,\r\n							`language`.`isApproved`,\r\n							`language`.`executeBy`,\r\n							`language`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`language`\r\n					JOIN	`staff`\r\n					ON		`language`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`language`.`isActive`		=	1','2011-11-16 11:30:31',2,'Granted',''),(3,0,'leafAccessReadValue','\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1','2011-11-16 11:35:15',2,'Denied',''),(4,0,'leafAccessReadValue','\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1','2011-11-16 11:35:15',2,'Denied','Maybe you should check out previous sql statement\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1 '),(5,0,'leafAccessReadValue','\r\n					SELECT	`theme`.`themeId`,\r\n							`theme`.`themeSequence`,\r\n							`theme`.`themeCode`,\r\n							`theme`.`themeNote`,\r\n							`theme`.`themePath`,\r\n							`theme`.`isDefault`,\r\n							`theme`.`isNew`,\r\n							`theme`.`isDraft`,\r\n							`theme`.`isUpdate`,\r\n							`theme`.`isDelete`,\r\n							`theme`.`isActive`,\r\n							`theme`.`isApproved`,\r\n							`theme`.`executeBy`,\r\n							`theme`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`theme`\r\n					JOIN	`staff`\r\n					ON		`theme`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`theme`.`isActive`		=	1','2011-11-16 11:35:15',2,'Denied',''),(6,0,'leafAccessReadValue','\r\n					SELECT	`language`.`languageId`,\r\n							`language`.`languageCode`,\r\n							`language`.`languageDesc`,\r\n							`language`.`isDefault`,\r\n							`language`.`isNew`,\r\n							`language`.`isDraft`,\r\n							`language`.`isUpdate`,\r\n							`language`.`isDelete`,\r\n							`language`.`isActive`,\r\n							`language`.`isApproved`,\r\n							`language`.`executeBy`,\r\n							`language`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`language`\r\n					JOIN	`staff`\r\n					ON		`language`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`language`.`isActive`		=	1','2011-11-16 11:35:15',2,'Denied',''),(7,0,'leafAccessUpdateValue','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-16 15:41:59\'\'\r\n						)','2011-11-16 15:41:59',2,'Denied',''),(8,0,'leafAccessReadValue','\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1','2011-11-16 15:42:02',2,'Denied',''),(9,0,'leafAccessReadValue','\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1','2011-11-16 15:42:02',2,'Denied','Maybe you should check out previous sql statement\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1 '),(10,0,'leafAccessReadValue','\r\n					SELECT	`theme`.`themeId`,\r\n							`theme`.`themeSequence`,\r\n							`theme`.`themeCode`,\r\n							`theme`.`themeNote`,\r\n							`theme`.`themePath`,\r\n							`theme`.`isDefault`,\r\n							`theme`.`isNew`,\r\n							`theme`.`isDraft`,\r\n							`theme`.`isUpdate`,\r\n							`theme`.`isDelete`,\r\n							`theme`.`isActive`,\r\n							`theme`.`isApproved`,\r\n							`theme`.`executeBy`,\r\n							`theme`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`theme`\r\n					JOIN	`staff`\r\n					ON		`theme`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`theme`.`isActive`		=	1','2011-11-16 15:42:02',2,'Denied',''),(11,0,'leafAccessReadValue','\r\n					SELECT	`language`.`languageId`,\r\n							`language`.`languageCode`,\r\n							`language`.`languageDesc`,\r\n							`language`.`isDefault`,\r\n							`language`.`isNew`,\r\n							`language`.`isDraft`,\r\n							`language`.`isUpdate`,\r\n							`language`.`isDelete`,\r\n							`language`.`isActive`,\r\n							`language`.`isApproved`,\r\n							`language`.`executeBy`,\r\n							`language`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`language`\r\n					JOIN	`staff`\r\n					ON		`language`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`language`.`isActive`		=	1','2011-11-16 15:42:03',2,'Denied',''),(12,0,'leafAccessReadValue','\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1','2011-11-16 15:44:01',2,'Denied',''),(13,0,'leafAccessReadValue','\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1','2011-11-16 15:44:01',2,'Denied','Maybe you should check out previous sql statement\r\n			SELECT		*\r\n			FROM 		`leaf`\r\n			JOIN		`folder`\r\n			USING		(`folderId`,`moduleId`)\r\n			JOIN		`module`\r\n			USING		(`moduleId`)\r\n			LEFT JOIN	`icon`\r\n			ON			`leaf`.`iconId`=`icon`.`iconId`\r\n			WHERE 			 1 \r\n			AND			`folder`.`isActive`		=	1\r\n			AND			`module`.`isActive`	= 1 '),(14,0,'leafAccessReadValue','\r\n					SELECT	`theme`.`themeId`,\r\n							`theme`.`themeSequence`,\r\n							`theme`.`themeCode`,\r\n							`theme`.`themeNote`,\r\n							`theme`.`themePath`,\r\n							`theme`.`isDefault`,\r\n							`theme`.`isNew`,\r\n							`theme`.`isDraft`,\r\n							`theme`.`isUpdate`,\r\n							`theme`.`isDelete`,\r\n							`theme`.`isActive`,\r\n							`theme`.`isApproved`,\r\n							`theme`.`executeBy`,\r\n							`theme`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`theme`\r\n					JOIN	`staff`\r\n					ON		`theme`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`theme`.`isActive`		=	1','2011-11-16 15:44:02',2,'Denied',''),(15,0,'leafAccessReadValue','\r\n					SELECT	`language`.`languageId`,\r\n							`language`.`languageCode`,\r\n							`language`.`languageDesc`,\r\n							`language`.`isDefault`,\r\n							`language`.`isNew`,\r\n							`language`.`isDraft`,\r\n							`language`.`isUpdate`,\r\n							`language`.`isDelete`,\r\n							`language`.`isActive`,\r\n							`language`.`isApproved`,\r\n							`language`.`executeBy`,\r\n							`language`.`executeTime`,\r\n							`staff`.`staffName`\r\n 					FROM 	`language`\r\n					JOIN	`staff`\r\n					ON		`language`.`executeBy` = `staff`.`staffId`\r\n					WHERE 		`language`.`isActive`		=	1','2011-11-16 15:44:02',2,'Denied',''),(16,0,'','INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-16 16:32:57\'\'\r\n						)','2011-11-16 16:32:57',0,'','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-16 16:32:57\'\'\r\n						)'),(17,0,'','INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-16 18:43:33\'\'\r\n						)','2011-11-16 18:43:33',0,'','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-16 18:43:33\'\'\r\n						)'),(18,0,'','INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-16 20:26:27\'\'\r\n						)','2011-11-16 20:26:27',0,'','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-16 20:26:27\'\'\r\n						)'),(19,0,'','INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-17 10:19:24\'\'\r\n						)','2011-11-17 10:19:24',0,'','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-17 10:19:24\'\'\r\n						)'),(20,0,'','INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-19 10:39:05\'\'\r\n						)','2011-11-19 10:39:05',0,'','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-19 10:39:05\'\'\r\n						)'),(21,0,'','INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-19 14:06:21\'\'\r\n						)','2011-11-19 14:06:21',0,'','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-19 14:06:21\'\'\r\n						)'),(22,0,'','INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-21 09:33:47\'\'\r\n						)','2011-11-21 09:33:47',0,'','\r\n				INSERT INTO `staffWebAccess`\r\n						(\r\n							`staffId`,\r\n							`staffWebAccessLogIn`\r\n						)\r\n				VALUES (\r\n							\'2\',\r\n							\'\'2011-11-21 09:33:47\'\'\r\n						)');
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
  `logAdvanceText` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `logAdvanceType` enum('C','U','D') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'C-Create,U-update,D-delete',
  `logAdvanceComparision` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `refTableName` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `leafId` int(11) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`logAdvanceId`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logadvance`
--

LOCK TABLES `logadvance` WRITE;
/*!40000 ALTER TABLE `logadvance` DISABLE KEYS */;
INSERT INTO `logadvance` VALUES (1,'{}','C','','',4,2,'2011-11-04 22:28:10'),(2,'{}','C','','',4,2,'2011-11-04 22:29:22'),(3,'{}','C','','',4,2,'2011-11-04 22:39:56'),(4,'{}','C','','folder',4,2,'2011-11-04 22:43:48'),(5,'{}','U','','folder',4,0,'0000-00-00 00:00:00'),(6,'{}','C','','folder',4,2,'2011-11-04 22:43:57'),(7,'{}','U','','folder',4,0,'0000-00-00 00:00:00'),(8,'{}','C','','folder',4,2,'2011-11-04 22:48:26'),(9,'{}','U','{ \"tablename\":\'folder\',\"leafId\":\'\',}','folder',4,2,'2011-11-04 22:48:26'),(10,'{}','C','','folder',4,2,'2011-11-04 22:51:17'),(11,'{}','U','{ \"tablename\":\'folder\',\"leafId\":\'\',}','folder',4,2,'2011-11-04 22:51:17'),(12,'{}','C','','folder',4,2,'2011-11-04 22:53:32'),(13,'{}','U','{ \"tablename\":\'folder\',\"leafId\":\'\',}','folder',4,2,'2011-11-04 22:53:32'),(14,'{\'folderId\':\'92\',\'applicationId\':\'0\',\'moduleId\':\'380\',\'iconId\':\'42\',\'folderSequence\':\'1\',\'folderCode\':\'\',\'folderPath\':\'membership\',\'folderEnglish\':\'Membership Entry\',\'isDefault\':\'0\',\'isNew\':\'1\',\'isDraft\':\'0\',\'isUpdate\':\'0\',\'isDelete\':\'0\',\'isActive\':\'1\',\'isApproved\':\'0\',\'isReview\':\'0\',\'isPost\':\'0\',\'executeBy\':\'2\',\'executeTime\':\'2011-11-04 23:20:12\'}','C','','folder',4,2,'2011-11-04 23:20:12'),(15,'{}','U','{ \"tablename\":\'folder\',\"leafId\":\'\',}','folder',4,2,'2011-11-04 23:20:12'),(16,'{\'folderId\':\'92\',\'applicationId\':\'0\',\'moduleId\':\'380\',\'iconId\':\'42\',\'folderSequence\':\'1\',\'folderCode\':\'\',\'folderPath\':\'membership\',\'folderEnglish\':\'Membership Entry\',\'isDefault\':\'0\',\'isNew\':\'1\',\'isDraft\':\'0\',\'isUpdate\':\'0\',\'isDelete\':\'0\',\'isActive\':\'1\',\'isApproved\':\'0\',\'isReview\':\'0\',\'isPost\':\'0\',\'executeBy\':\'2\',\'executeTime\':\'2011-11-04 23:20:12\'}','C','','folder',4,2,'2011-11-04 23:20:12');
/*!40000 ALTER TABLE `logadvance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership`
--

DROP TABLE IF EXISTS `membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership` (
  `membershipId` int(11) NOT NULL AUTO_INCREMENT,
  `districtId` int(11) NOT NULL,
  `stateId` int(11) NOT NULL,
  `religionId` int(11) NOT NULL,
  `raceId` int(11) NOT NULL,
  `familyId` int(11) NOT NULL,
  `membershipSalary` double(12,2) NOT NULL COMMENT 'staff salary',
  `membershipRegisterDate` date NOT NULL COMMENT 'register date',
  `membershipName` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `membershipNumber` int(4) unsigned zerofill NOT NULL,
  `staffNumber` int(4) unsigned zerofill NOT NULL,
  `membershipDesignation` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `membershipIC` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `membershipBirthday` date NOT NULL,
  `membershipPhone` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `membershipHP` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `membershipAddress` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `membershipPostcode` int(8) NOT NULL COMMENT 'postcode',
  `membershipExt` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `membershipEmail` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`membershipId`),
  UNIQUE KEY `staff_no` (`staffNumber`),
  KEY `designation_uniqueId` (`membershipDesignation`),
  KEY `districtId` (`districtId`,`stateId`,`religionId`,`raceId`,`familyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Member of  Kospek';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership`
--

LOCK TABLES `membership` WRITE;
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messaging`
--

DROP TABLE IF EXISTS `messaging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messaging` (
  `messagingId` int(11) NOT NULL AUTO_INCREMENT,
  `messagingFrom` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `messagingTo` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `messagingCc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `messagingTitle` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `messagingDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `messagingSendDate` date DEFAULT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `isSent` tinyint(1) NOT NULL,
  `executeBy` int(11) DEFAULT NULL,
  `executeTime` datetime DEFAULT NULL,
  PRIMARY KEY (`messagingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messaging`
--

LOCK TABLES `messaging` WRITE;
/*!40000 ALTER TABLE `messaging` DISABLE KEYS */;
/*!40000 ALTER TABLE `messaging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `moduleId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `applicationId` int(11) NOT NULL,
  `iconId` int(11) NOT NULL DEFAULT '281' COMMENT 'Icon|',
  `moduleSequence` int(11) NOT NULL COMMENT 'Sequence|',
  `moduleCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `moduleEnglish` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`moduleId`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Module';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,1,612,1,'SYS','System',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(2,1,612,2,'TLN','Translation',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(3,1,612,3,'PS','Personnel',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(4,2,601,1,'SF','Form Example ',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(5,3,281,1,'GL','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(6,5,281,1,'AP','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(7,5,1084,3,'AP','Vendor',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(8,7,281,1,'mbr','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(9,8,281,1,'bank','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(10,13,281,1,'FA','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(11,14,281,1,'DM','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(12,15,652,2,'CB','Cashbook',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(13,16,281,2,'PY','Payroll',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(14,17,281,1,'HR','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(15,6,281,1,'PO','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(16,4,281,1,'AR','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(17,15,281,1,'CB','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(18,7,461,2,'mbr','Memberships',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(19,7,461,3,'mbr','Dividens',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(20,8,198,2,'bank','Bank',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(21,13,546,2,'FA','Fix Asset',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(22,14,852,2,'DM','Document Management',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(23,16,281,1,'PY','Setting',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(24,3,601,2,'GL','General Ledger',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(25,5,1070,2,'AP','Invoicing',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(26,15,841,3,'CB','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(27,4,652,2,'AR','Account Receivable',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(28,6,222,2,'PO','Purchasing Order',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(29,17,281,2,'HR','Human Resource',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(30,16,841,3,'PY','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(31,1,612,4,'CM','Common ',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(32,3,841,3,'GL','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(33,4,841,3,'AR','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(34,5,841,4,'AP','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(35,6,841,3,'PO','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(36,7,841,4,'mbr','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(37,8,841,3,'bank','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(38,13,841,3,'FA','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(39,13,546,4,'FA','reserve',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(40,17,841,3,'HR','Report',0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moduleaccess`
--

DROP TABLE IF EXISTS `moduleaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moduleaccess` (
  `moduleAccessId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Access|',
  `moduleId` int(11) NOT NULL COMMENT 'Accordion|',
  `teamId` int(11) NOT NULL COMMENT 'Group|',
  `moduleAccessValue` tinyint(1) NOT NULL COMMENT 'Value|',
  PRIMARY KEY (`moduleAccessId`),
  KEY `moduleId` (`moduleId`),
  KEY `crewId` (`teamId`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT COMMENT='Validate Access Tab By Group';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moduleaccess`
--

LOCK TABLES `moduleaccess` WRITE;
/*!40000 ALTER TABLE `moduleaccess` DISABLE KEYS */;
INSERT INTO `moduleaccess` VALUES (1,1,1,1),(2,2,1,1),(3,3,1,1),(4,4,1,1),(5,5,1,1),(6,6,1,1),(7,7,1,1),(8,8,1,1),(9,9,1,1),(10,10,1,1),(11,11,1,1),(12,12,1,1),(13,13,1,1),(14,14,1,1),(15,15,1,1),(16,16,1,1),(17,17,1,1),(18,18,1,1),(19,19,1,1),(20,20,1,1),(21,21,1,1),(22,22,1,1),(23,23,1,1),(24,24,1,1),(25,25,1,1),(26,26,1,1),(27,27,1,1),(28,28,1,1),(29,29,1,1),(30,30,1,1),(31,31,1,1),(32,32,1,1),(33,33,1,1),(34,34,1,1),(35,35,1,1),(36,36,1,1),(37,37,1,1),(38,38,1,1),(39,39,1,1),(40,40,1,1),(41,1,2,1),(42,2,2,1),(43,3,2,1),(44,4,2,1),(45,5,2,1),(46,6,2,1),(47,7,2,1),(48,8,2,1),(49,9,2,1),(50,10,2,1),(51,11,2,1),(52,12,2,1),(53,13,2,1),(54,14,2,1),(55,15,2,1),(56,16,2,1),(57,17,2,1),(58,18,2,1),(59,19,2,1),(60,20,2,1),(61,21,2,1),(62,22,2,1),(63,23,2,1),(64,24,2,1),(65,25,2,1),(66,26,2,1),(67,27,2,1),(68,28,2,1),(69,29,2,1),(70,30,2,1),(71,31,2,1),(72,32,2,1),(73,33,2,1),(74,34,2,1),(75,35,2,1),(76,36,2,1),(77,37,2,1),(78,38,2,1),(79,39,2,1),(80,40,2,1),(81,1,3,1),(82,2,3,1),(83,3,3,1),(84,4,3,1),(85,5,3,1),(86,6,3,1),(87,7,3,1),(88,8,3,1),(89,9,3,1),(90,10,3,1),(91,11,3,1),(92,12,3,1),(93,13,3,1),(94,14,3,1),(95,15,3,1),(96,16,3,1),(97,17,3,1),(98,18,3,1),(99,19,3,1),(100,20,3,1),(101,21,3,1),(102,22,3,1),(103,23,3,1),(104,24,3,1),(105,25,3,1),(106,26,3,1),(107,27,3,1),(108,28,3,1),(109,29,3,1),(110,30,3,1),(111,31,3,1),(112,32,3,1),(113,33,3,1),(114,34,3,1),(115,35,3,1),(116,36,3,1),(117,37,3,1),(118,38,3,1),(119,39,3,1),(120,40,3,1),(121,1,4,1),(122,2,4,1),(123,3,4,1),(124,4,4,1),(125,5,4,1),(126,6,4,1),(127,7,4,1),(128,8,4,1),(129,9,4,1),(130,10,4,1),(131,11,4,1),(132,12,4,1),(133,13,4,1),(134,14,4,1),(135,15,4,1),(136,16,4,1),(137,17,4,1),(138,18,4,1),(139,19,4,1),(140,20,4,1),(141,21,4,1),(142,22,4,1),(143,23,4,1),(144,24,4,1),(145,25,4,1),(146,26,4,1),(147,27,4,1),(148,28,4,1),(149,29,4,1),(150,30,4,1),(151,31,4,1),(152,32,4,1),(153,33,4,1),(154,34,4,1),(155,35,4,1),(156,36,4,1),(157,37,4,1),(158,38,4,1),(159,39,4,1),(160,40,4,1),(161,1,5,1),(162,2,5,1),(163,3,5,1),(164,4,5,1),(165,5,5,1),(166,6,5,1),(167,7,5,1),(168,8,5,1),(169,9,5,1),(170,10,5,1),(171,11,5,1),(172,12,5,1),(173,13,5,1),(174,14,5,1),(175,15,5,1),(176,16,5,1),(177,17,5,1),(178,18,5,1),(179,19,5,1),(180,20,5,1),(181,21,5,1),(182,22,5,1),(183,23,5,1),(184,24,5,1),(185,25,5,1),(186,26,5,1),(187,27,5,1),(188,28,5,1),(189,29,5,1),(190,30,5,1),(191,31,5,1),(192,32,5,1),(193,33,5,1),(194,34,5,1),(195,35,5,1),(196,36,5,1),(197,37,5,1),(198,38,5,1),(199,39,5,1),(200,40,5,1),(201,1,6,1),(202,2,6,1),(203,3,6,1),(204,4,6,1),(205,5,6,1),(206,6,6,1),(207,7,6,1),(208,8,6,1),(209,9,6,1),(210,10,6,1),(211,11,6,1),(212,12,6,1),(213,13,6,1),(214,14,6,1),(215,15,6,1),(216,16,6,1),(217,17,6,1),(218,18,6,1),(219,19,6,1),(220,20,6,1),(221,21,6,1),(222,22,6,1),(223,23,6,1),(224,24,6,1),(225,25,6,1),(226,26,6,1),(227,27,6,1),(228,28,6,1),(229,29,6,1),(230,30,6,1),(231,31,6,1),(232,32,6,1),(233,33,6,1),(234,34,6,1),(235,35,6,1),(236,36,6,1),(237,37,6,1),(238,38,6,1),(239,39,6,1),(240,40,6,1);
/*!40000 ALTER TABLE `moduleaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moduletranslate`
--

DROP TABLE IF EXISTS `moduletranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moduletranslate` (
  `moduleTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'translate|',
  `moduleId` int(11) NOT NULL COMMENT 'accordion|',
  `languageId` int(11) NOT NULL COMMENT 'language|',
  `moduleNative` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Accordion|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `ispost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`moduleTranslateId`),
  KEY `moduleId` (`moduleId`),
  KEY `languageId` (`languageId`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moduletranslate`
--

LOCK TABLES `moduletranslate` WRITE;
/*!40000 ALTER TABLE `moduletranslate` DISABLE KEYS */;
INSERT INTO `moduletranslate` VALUES (1,1,21,'System',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(2,2,21,'Translation',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(3,3,21,'Personnel',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(4,4,21,'Form Example ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(5,5,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(6,6,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(7,7,21,'Vendor',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(8,8,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(9,9,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(10,10,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(11,11,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(12,12,21,'Cashbook',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(13,13,21,'Payroll',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(14,14,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(15,15,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(16,16,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(17,17,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(18,18,21,'Memberships',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(19,19,21,'Dividens',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(20,20,21,'Bank',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(21,21,21,'Fix Asset',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(22,22,21,'Document Management',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(23,23,21,'Setting',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(24,24,21,'General Ledger',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(25,25,21,'Invoicing',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(26,26,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(27,27,21,'Payment',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(28,28,21,'Purchasing Order',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(29,29,21,'Human Resource',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(30,30,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(31,31,21,'Common ',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(32,32,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(33,33,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(34,34,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(35,35,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(36,36,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(37,37,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(38,38,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(39,39,21,'reserve',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35'),(40,40,21,'Report',0,0,0,0,0,1,0,0,0,2,'2011-11-19 05:32:35');
/*!40000 ALTER TABLE `moduletranslate` ENABLE KEYS */;
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
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `paymentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `receiptNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `membershipId` int(11) NOT NULL,
  `paymentType` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `paymentDate` date NOT NULL,
  `paymentAmount` double(12,2) NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`paymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
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
-- Table structure for table `religionsample`
--

DROP TABLE IF EXISTS `religionsample`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `religionsample` (
  `religionId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Religion|',
  `religionDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description|',
  `isDefault` tinyint(1) NOT NULL COMMENT 'default|',
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`religionId`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `religionsample`
--

LOCK TABLES `religionsample` WRITE;
/*!40000 ALTER TABLE `religionsample` DISABLE KEYS */;
INSERT INTO `religionsample` VALUES (1,'Abrahamic religions',1,0,1,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(2,'Indian religions',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(3,'Iranian religions',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(4,'East Asian religions',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(5,'African diasporic religions',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(6,'Indigenous traditional religions',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(7,'Historical polytheism',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(8,'Neopaganism',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(9,'New Age, esotericism, mysticism',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(10,'New religious movements',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(11,'Fictional religions',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(12,'Parody or mock religions',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(13,'Others',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(14,'1',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(15,'2',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(16,'3',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(17,'Other categorisations',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(18,'kambinf',0,1,0,0,0,1,0,0,0,2,'2011-09-28 19:00:16'),(19,'koko',0,1,0,0,0,1,0,0,0,2,'2011-09-29 20:14:04'),(20,'kokok',0,1,0,0,0,1,0,0,0,2,'2011-09-29 20:15:14'),(21,'loklll999999999999999999999999',0,0,0,0,1,0,0,0,0,2,'2011-10-25 09:26:39'),(22,'updats',0,0,0,0,1,0,0,0,0,2,'2011-10-25 09:26:55'),(23,'hanafi',0,1,0,0,0,1,0,0,0,2,'2011-10-25 09:28:08'),(24,'this entry is nice',0,1,0,0,0,1,0,0,0,2,'2011-10-25 10:10:08'),(25,'kambing doll update',0,0,0,1,0,1,0,0,0,2,'2011-10-25 11:16:37'),(26,'hantu',0,1,0,0,0,1,0,0,0,2,'2011-11-12 12:17:11'),(27,'hantu2',0,1,0,0,0,1,0,0,0,2,'2011-11-12 12:22:16'),(28,'hantu3',0,1,0,0,0,1,0,0,0,2,'2011-11-12 12:22:42'),(29,'kambing x',0,0,0,1,0,1,0,0,0,2,'2011-11-12 12:27:40'),(30,'kambing2',0,1,0,0,0,1,0,0,0,2,'2011-11-12 12:38:04'),(31,'kambingxa',0,0,0,0,1,0,0,0,0,2,'2011-11-12 13:09:19'),(32,'kambingxtttt',0,0,0,0,1,0,0,0,0,2,'2011-11-12 13:27:12');
/*!40000 ALTER TABLE `religionsample` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `religionsampledetail`
--

DROP TABLE IF EXISTS `religionsampledetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `religionsampledetail` (
  `religionDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Religion|',
  `religionId` int(11) NOT NULL,
  `religionDetailTitle` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description|',
  `religionDetailDesc` text COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL COMMENT 'default|',
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`religionDetailId`),
  KEY `religionId` (`religionId`),
  CONSTRAINT `religionsampledetail_ibfk_1` FOREIGN KEY (`religionId`) REFERENCES `religionsample` (`religionId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `religionsampledetail`
--

LOCK TABLES `religionsampledetail` WRITE;
/*!40000 ALTER TABLE `religionsampledetail` DISABLE KEYS */;
INSERT INTO `religionsampledetail` VALUES (1,1,'Bábism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(2,1,'Bahá\'í Faith','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(3,1,'Christianity','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(4,1,'Gnosticism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(5,1,'Islam','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(6,1,'Judaism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(7,1,'Rastafari movement','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(8,1,'Mandaeans and Sabians','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(9,1,'Samaritanism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(10,1,'Unitarian Universalism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(11,2,'Ayyavazhi','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(12,2,'Bhakti Movement','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(13,2,'Buddhism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(14,2,'Din-i-Ilahi','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(15,2,'Hinduism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(16,2,'Jainism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(17,2,'Sikhism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(18,3,'Manichaeism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(19,3,'Mazdakism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(20,3,'Mithraism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(21,3,'Yazdânism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(22,4,'Zoroastrianism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(23,4,'Confucianism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(24,4,'Shinto','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(25,4,'Taoism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(26,4,'Other','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(27,6,'African','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(28,6,'American','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(29,6,'Eurasian','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(30,6,'Oceania/Pacific','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(31,7,'Ancient Near Eastern','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(32,7,'Indo-European','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(33,7,'Hellenistic','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(34,9,'New Age','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(35,9,'Esotericism and mysticism','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(36,9,'Occult and magical','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(37,9,'Left-Hand Path','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(38,10,'Creativity','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(39,10,'Philosophical','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(40,10,'New Thought','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(41,10,'Shinshukyo','',0,0,0,0,0,0,0,0,0,2,'0000-00-00 00:00:00'),(43,1,'','',0,1,0,0,0,1,0,0,0,2,'2011-09-26 22:56:02'),(44,1,'xmen','',0,1,0,0,0,1,0,0,0,2,'2011-09-26 23:01:11'),(45,1,'dotard','klhjl\r\n',0,1,0,0,0,1,0,0,0,2,'2011-09-26 23:03:26'),(46,1,'lol','',0,1,0,0,0,1,0,0,0,2,'2011-09-26 23:08:09'),(47,1,'6','',0,1,0,0,0,1,0,0,0,2,'2011-09-26 23:09:06'),(48,1,'gogo power rangers','kaizaban',0,1,0,0,0,1,0,0,0,2,'2011-09-26 23:14:03'),(49,20,'koko','kokoi',0,1,0,0,0,1,0,0,0,2,'2011-09-29 20:17:27'),(50,21,'loki1','LOKI2',0,1,0,0,0,1,0,0,0,2,'2011-09-29 20:22:19'),(51,21,'LOKI4','LOKI3',0,1,0,0,0,1,0,0,0,2,'2011-09-29 20:26:51'),(52,21,'EDIT1','9',0,0,0,1,0,1,0,0,0,2,'2011-09-29 21:19:07');
/*!40000 ALTER TABLE `religionsampledetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `staffId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Staff|',
  `teamId` int(11) NOT NULL COMMENT 'crew|',
  `departmentId` int(11) NOT NULL,
  `languageId` int(11) NOT NULL COMMENT 'Language|',
  `staffPassword` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Password|',
  `staffName` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name|',
  `staffNo` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Number|',
  `staffIc` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Identification|',
  `isDefault` int(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`staffId`),
  KEY `isPost` (`isPost`),
  KEY `isReview` (`isReview`),
  KEY `isApproved` (`isApproved`),
  KEY `isActive` (`isActive`),
  KEY `isDelete` (`isDelete`),
  KEY `isUpdate` (`isUpdate`),
  KEY `isNew` (`isNew`),
  KEY `isDraft` (`isDraft`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Clerk,System Admin';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (2,1,1,21,'690b2646e03f5411e297d208b79d4807','root','','',0,0,0,1,0,1,2,0,0,2,'0000-00-00 00:00:00'),(3,1,1,21,'690b2646e03f5411e297d208b79d4807','admin','','',0,0,0,1,0,1,2,0,0,2,'0000-00-00 00:00:00'),(4,2,1,21,'690b2646e03f5411e297d208b79d4807','supervisor','','',0,0,0,1,0,1,2,0,0,2,'0000-00-00 00:00:00'),(5,3,1,21,'690b2646e03f5411e297d208b79d4807','staff','','',0,0,0,1,0,1,2,0,0,2,'0000-00-00 00:00:00'),(6,4,1,21,'690b2646e03f5411e297d208b79d4807','member','','',0,0,0,1,0,1,2,0,0,2,'0000-00-00 00:00:00'),(7,5,1,21,'690b2646e03f5411e297d208b79d4807','demo','','',0,0,0,1,0,1,2,0,0,2,'0000-00-00 00:00:00'),(8,6,1,21,'690b2646e03f5411e297d208b79d4807','manager','','',0,0,0,1,0,1,2,0,0,2,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffwebaccess`
--

DROP TABLE IF EXISTS `staffwebaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffwebaccess` (
  `staffWebAccessId` int(11) NOT NULL AUTO_INCREMENT,
  `staffId` int(11) NOT NULL,
  `staffWebAccessLogIn` datetime NOT NULL,
  `staffWebAccessLogOut` datetime NOT NULL,
  `phpSession` varchar(32) NOT NULL,
  PRIMARY KEY (`staffWebAccessId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='System Access Audit Log....';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffwebaccess`
--

LOCK TABLES `staffwebaccess` WRITE;
/*!40000 ALTER TABLE `staffwebaccess` DISABLE KEYS */;
/*!40000 ALTER TABLE `staffwebaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `systemstring`
--

DROP TABLE IF EXISTS `systemstring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `systemstring` (
  `systemStringId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `systemStringCode` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `systemStringEnglish` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`systemStringId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `systemstring`
--

LOCK TABLES `systemstring` WRITE;
/*!40000 ALTER TABLE `systemstring` DISABLE KEYS */;
INSERT INTO `systemstring` VALUES (1,'create','Record Created.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(2,'update','Record Updated.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(3,'delete','Record Deleted.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(4,'duplicate','Code Required duplicate.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5,'notDuplicate','Code Required Not Duplicate.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(6,'fileFound','File Request Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(7,'fileNotFound','File Request Not  Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(8,'recordFound','Record Search Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(9,'recordNotFound','Record Search Not Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(11,'nonSupportedDatabase','Database Request Not Found ',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `systemstring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `systemstringtranslate`
--

DROP TABLE IF EXISTS `systemstringtranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `systemstringtranslate` (
  `systemStringTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `systemStringId` int(11) NOT NULL,
  `systemStringCode` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `languageId` int(11) NOT NULL,
  `systemStringNative` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`systemStringTranslateId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `systemstringtranslate`
--

LOCK TABLES `systemstringtranslate` WRITE;
/*!40000 ALTER TABLE `systemstringtranslate` DISABLE KEYS */;
INSERT INTO `systemstringtranslate` VALUES (1,1,'create',21,'Record Created.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(2,2,'update',21,'Record Updated.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(3,3,'delete',21,'Record Deleted.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(4,4,'duplicate',21,'Code Required duplicate.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5,5,'notDuplicate',21,'Code Required Not Duplicate.',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(6,6,'fileFound',21,'File Request Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(7,7,'fileNotFound',21,'File Request Not  Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(8,8,'recordFound',21,'Record Search Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(9,9,'Record Search Not Founded',21,'Record Search Not Founded',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(11,11,'nonSupportedDatabase',21,'Database Request Not Found ',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `systemstringtranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tablemapping`
--

DROP TABLE IF EXISTS `tablemapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tablemapping` (
  `tableMappingId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Mapping|',
  `tableMappingName` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Table|',
  `tableMappingColumnName` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Column|',
  `tableMappingEnglish` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`tableMappingId`)
) ENGINE=InnoDB AUTO_INCREMENT=494 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tablemapping`
--

LOCK TABLES `tablemapping` WRITE;
/*!40000 ALTER TABLE `tablemapping` DISABLE KEYS */;
INSERT INTO `tablemapping` VALUES (1,' calendar ',' calendarId','Calendar',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(2,' calendar ',' calendarColorId','Color',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(3,' calendar ',' calendarTitle','Title',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(4,' calendar ',' calendarDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(5,' calendar ',' isHidden','Hidden',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(6,' calendar ',' staffId','Staff',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(7,' calendarcolor ',' calendarColorId','Color',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(8,' defaultlabel ',' defaultLabelId','Default Label',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(9,' defaultlabel ',' defaultLabel',' Label',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(10,' defaultlabel ',' defaultLabelEnglish',' English Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(11,' defaultlabel ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(12,' defaultlabel ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(13,' defaultlabel ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(14,' defaultlabel ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(15,' defaultlabel ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(16,' defaultlabel ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(17,' defaultlabel ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(18,' defaultlabel ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(19,' defaultlabel ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(20,' defaultlabel ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(21,' defaultlabel ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(22,' defaultlabeltranslate ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(23,' defaultlabeltranslate ',' defaultLabelTranslateId','Default Label',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(24,' defaultlabeltranslate ',' defaultLabelNative','Native',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(25,' defaultlabeltranslate ',' defaultLabelId','Default Label',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(26,' department ',' departmentId','Department',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(27,' department ',' departmentSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(28,' department ',' departmentCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(29,' department ',' departmentEnglish','Note',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(30,' department ',' isAdmin','Admin',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(31,' department ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(32,' department ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(33,' department ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(34,' department ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(35,' department ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(36,' department ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(37,' department ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(38,' department ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(39,' department ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(40,' department ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(41,' department ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(42,' document ',' documentId','Document',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(43,' document ',' documentCategoryId','Document Category',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(44,' document ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(45,' document ',' documentCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(46,' document ',' DocumentSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(47,' document ',' documentEnglish','English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(48,' document ',' documentTitle','Title',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(49,' document ',' documentDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(50,' document ',' documentPath','Path',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(51,' document ',' documentOriginalFilename','Original Filename',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(52,' document ',' documentDownloadFilename','Download Filename',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(53,' document ',' documentExtension','Extension',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(54,' document ',' documentVersion','Version',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(55,' document ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(56,' document ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(57,' document ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(58,' document ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(59,' document ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(60,' document ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(61,' document ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(62,' document ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(63,' document ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(64,' document ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(65,' document ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(66,' documentcategory ',' documentCategoryId','Document Category',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(67,' documentcategory ',' documentCategoryTitle','Title',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(68,' documentcategory ',' documentCategoryDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(69,' documentcategory ',' documentCategorySequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(70,' documentcategory ',' documentCategoryCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(71,' documentcategory ',' documentCategoryEnglish','English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(72,' documentcategory ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(73,' documentcategory ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(74,' documentcategory ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(75,' documentcategory ',' IsUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(76,' documentcategory ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(77,' documentcategory ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(78,' documentcategory ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(79,' documentcategory ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(80,' documentcategory ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(81,' documentcategory ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(82,' documentcategory ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(83,' event ',' eventId','Event',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(84,' event ',' calendarId','Calendar',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(85,' event ',' eventTitle','Title',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(86,' event ',' eventDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(87,' event ',' eventStart',' Start',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(88,' event ',' eventEnd',' End',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(89,' event ',' eventLocation','Location',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(90,' event ',' eventNotes','Note',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(91,' event ',' eventUrl',' Hyperlink',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(92,' event ',' eventIsAllDay',' All Day',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(93,' event ',' eventIsNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(94,' event ',' eventReminder','Reminder',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(95,' event ',' staffId','Staff',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(96,' event ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(97,' extlabel ',' extLabelId','Ext  Label',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(98,' extlabel ',' extLabelEnglish','Note',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(99,' extlabel ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(100,' extlabel ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(101,' extlabel ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(102,' extlabel ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(103,' extlabel ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(104,' extlabel ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(105,' extlabel ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(106,' extlabel ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(107,' extlabel ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(108,' extlabel ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(109,' extlabel ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(110,' extlabeltranslate ',' extLabelTranslateId','Ext Label',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(111,' extlabeltranslate ',' extLabelId','Ext Label',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(112,' extlabeltranslate ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(113,' extlabeltranslate ',' extLabelNative','Native',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(114,' folder ',' folderId','Folder',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(115,' folder ',' moduleId','Module',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(116,' folder ',' iconId','Icon',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(117,' folder ',' folderSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(118,' folder ',' folderCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(119,' folder ',' folderPath','Path',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(120,' folder ',' folderEnglish','English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(121,' folder ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(122,' folder ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(123,' folder ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(124,' folder ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(125,' folder ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(126,' folder ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(127,' folder ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(128,' folder ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(129,' folder ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(130,' folder ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(131,' folder ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(132,' folderaccess ',' folderAccessId','Folder Access',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(133,' folderaccess ',' teamId','Team',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(134,' folderaccess ',' folderId','Folder',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(135,' folderaccess ',' folderAccessValue','Value',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(136,' foldertranslate ',' folderTranslateId','Folder Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(137,' foldertranslate ',' folderId','Folder',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(138,' foldertranslate ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(139,' foldertranslate ',' folderNative','Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(140,' icon ',' iconId','Icon',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(141,' icon ',' iconName','Name',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(142,' icon ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(143,' icon ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(144,' language ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(145,' language ',' languageDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(146,' language ',' languageCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(147,' language ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(148,' language ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(149,' language ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(150,' language ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(151,' language ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(152,' language ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(153,' language ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(154,' language ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(155,' language ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(156,' language ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(157,' language ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(158,' leaf ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(159,' leaf ',' leafCategoryId','Leaf Category',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(160,' leaf ',' moduleId','Module',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(161,' leaf ',' folderId','Folder',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(162,' leaf ',' iconId','Icon',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(163,' leaf ',' leafSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(164,' leaf ',' leafCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(165,' leaf ',' leafFilename','Filename',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(166,' leaf ','leafEnglish','English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(167,' leaf ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(168,' leaf ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(169,' leaf ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(170,' leaf ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(171,' leaf ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(172,' leaf ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(173,' leaf ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(174,' leaf ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(175,' leaf ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(176,' leaf ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(177,' leaf ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(178,' leafaccess ',' leafAccessId','Leaf Access',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(179,' leafaccess ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(180,' leafaccess ',' staffId','Staff',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(181,' leafaccess ',' leafAccessCreateValue','Create',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(182,' leafaccess ',' leafAccessReadValue','Read',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(183,' leafaccess ',' leafAccessUpdateValue','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(184,' leafaccess ',' leafAccessDeleteValue','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(185,' leafaccess ',' leafAccessPrintValue','Print',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(186,' leafaccess ',' leafAccessPostValue','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(187,' leafaccess ',' leafAccessDraftValue','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(188,' leafaccess ',' leafAccessApprovedValue','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(189,' leafaccess ',' leafAccessReviewValue','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(190,' leafapproval ',' leafApprovalId','Leaf Approval',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(191,' leafapproval ',' leafApprovalEnum','True ? False ?',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(192,' leafapproval ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(193,' leafapproval ',' staffId','Staff',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(194,' leafapproval ',' teamId','Team',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(195,' leafapproval ',' leafApprovalSuccessMessage','Success',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(196,' leafapproval ',' leafApprovalFailureMessage',' Failure',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(197,' leafcategory ',' leafCategoryId','Leaf Category',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(198,' leafcategory ',' leafCategoryEnglish','English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(199,' leafteamaccess ',' leafTeamAccessId','Team Access',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(200,' leafteamaccess ',' leafId','Leaf ',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(201,' leafteamaccess ',' teamId','Team',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(202,' leafteamaccess ',' leafTeamAccessCreateValue','Create',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(203,' leafteamaccess ',' leafTeamAccessReadValue','Read',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(204,' leafteamaccess ',' leafTeamAccessUpdateValue','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(205,' leafteamaccess ',' leafTeamAccessDeleteValue','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(206,' leafteamaccess ',' leafTeamAccessPrintValue','Print',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(207,' leafteamaccess ',' leafTeamAccessPostValue','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(208,' leafteamaccess ',' leafTeamAccessDraftValue','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(209,' leafteamaccess ',' leafTeamAccessReviewValue','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(210,' leaftranslate ',' leafTranslateId','Leaf Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(211,' leaftranslate ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(212,' leaftranslate ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(213,' leaftranslate ',' leafTranslate',' Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(214,' leafuser ',' leafUserId','Leaf User',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(215,' leafuser ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(216,' leafuser ',' leafSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(217,' leafuser ',' staffId','Staff',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(218,' log ',' logId','Log',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(219,' log ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(220,' log ',' operation','Operation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(221,' log ',' sql','Structure Query Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(222,' log ',' date',' Date',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(223,' log ',' staffId','Identification',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(224,' log ',' access','Access',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(225,' log ',' logError','Error',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(226,' logadvance ',' logAdvanceId','Log Advance',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(227,' logadvance ',' logAdvanceText','Text',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(228,' logadvance ',' logAdvanceType','Type',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(229,' logadvance ',' logAdvanceComparision','Comparision ',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(230,' logadvance ',' refTableName','Reference Table',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(231,' logadvance ',' leafId','Leaf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(232,' logadvance ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(233,' logadvance ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(234,' messaging ',' messagingId','Identification',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(235,' messaging ',' messagingFrom',' From',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(236,' messaging ',' messagingTo',' To',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(237,' messaging ',' messagingCc',' Carbon Copy',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(238,' messaging ',' messagingTitle','Title',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(239,' messaging ',' messagingDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(240,' messaging ',' messagingSendDate',' Send Date',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(241,' messaging ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(242,' messaging ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(243,' messaging ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(244,' messaging ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(245,' messaging ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(246,' messaging ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(247,' messaging ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(248,' messaging ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(249,' messaging ',' isSent','Sent',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(250,' messaging ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(251,' messaging ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(252,' module ',' moduleId','Module',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(253,' module ',' iconId','Icon',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(254,' module ',' moduleSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(255,' module ',' moduleCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(256,' module ','moduleEnglish','English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(257,' module ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(258,' module ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(259,' module ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(260,' module ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(261,' module ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(262,' module ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(263,' module ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(264,' module ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(265,' module ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(266,' module ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(267,' module ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(268,' moduleaccess ',' moduleAccessId','Module Access',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(269,' moduleaccess ',' moduleId','Module',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(270,' moduleaccess ',' teamId','Team',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(271,' moduleaccess ',' moduleAccessValue','Value',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(272,' moduletranslate ',' moduleTranslateId','Module Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(273,' moduletranslate ',' moduleId','Module',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(274,' moduletranslate ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(275,' moduletranslate ',' moduleNative','Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(276,' religion ',' religionId','Identification',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(277,' religion ',' religionDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(278,' religion ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(279,' religion ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(280,' religion ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(281,' religion ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(282,' religion ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(283,' religion ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(284,' religion ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(285,' religion ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(286,' religion ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(287,' religion ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(288,' religion ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(289,' religiondetail ',' religionDetailId','Religion Detail',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(290,' religiondetail ',' religionId','Religion',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(291,' religiondetail ',' religionDetailTitle','Title',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(292,' religiondetail ',' religionDetailDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(293,' religiondetail ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(294,' religiondetail ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(295,' religiondetail ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(296,' religiondetail ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(297,' religiondetail ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(298,' religiondetail ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(299,' religiondetail ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(300,' religiondetail ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(301,' religiondetail ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(302,' religiondetail ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(303,' religiondetail ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(304,' staff ',' staffId','Staff',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(305,' staff ',' teamId','Team',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(306,' staff ',' departmentId','Identification',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(307,' staff ',' languageId','Identification',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(308,' staff ',' staffPassword','Password',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(309,' staff ',' staffName','Staff Name',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(310,' staff ',' staffNo','Staff Number',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(311,' staff ',' staffIc','Staff Identification Card',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(312,' staff ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(313,' staff ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(314,' staff ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(315,' staff ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(316,' staff ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(317,' staff ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(318,' staff ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(319,' staff ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(320,' staff ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(321,' staff ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(322,' staff ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(323,' staffwebaccess ',' staffWebAccessId','Staff Web Access',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(324,' staffwebaccess ',' staffId','Staf',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(325,' staffwebaccess ',' staffWebAccessLogIn','Log in ',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(326,' staffwebaccess ',' staffWebAccessLogOut',' Log Out',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(327,' staffwebaccess ',' phpSession',' Session',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(328,' tablemapping ',' tableMappingId','Table Mapping',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(329,' tablemapping ',' tableMappingName','Table Name',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(330,' tablemapping ',' tableMappingColumnName','Column Name ',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(331,' tablemapping ',' tableMappingEnglish',' English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(332,' tablemapping ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(333,' tablemapping ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(334,' tablemapping ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(335,' tablemapping ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(336,' tablemapping ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(337,' tablemapping ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(338,' tablemapping ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(339,' tablemapping ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(340,' tablemapping ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(341,' tablemapping ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(342,' tablemapping ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(343,' tablemapping ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(344,' tablemappingtranslate ',' tableMappingTranslateId','Table Mapping Translation',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(345,' tablemappingtranslate ',' tableMappingId','Table Mapping',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(346,' tablemappingtranslate ',' tableMappingNative','Native',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(347,' tablemappingtranslate ',' languageId','Language',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(348,' team ',' teamId','Team',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(349,' team ',' teamSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(350,' team ',' teamCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(351,' team ',' teamEnglish','English',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(352,' team ',' isAdmin','Admin',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(353,' team ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(354,' team ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(355,' team ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(356,' team ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(357,' team ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(358,' team ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(359,' team ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(360,' team ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(361,' team ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(362,' team ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(363,' team ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(364,' theme ',' themeId','Theme',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(365,' theme ',' themeSequence','Sequence',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(366,' theme ',' themeCode','Code',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(367,' theme ',' themeNote','Note',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(368,' theme ',' themePath','Path',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(369,' theme ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(370,' theme ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(371,' theme ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(372,' theme ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(373,' theme ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(374,' theme ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(375,' theme ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(376,' theme ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(377,' theme ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(378,' theme ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(379,' theme ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(380,' todo ',' todoId','Todo',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(381,' todo ',' todoTitle','Title',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(382,' todo ',' todoDesc','Description',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(383,' todo ',' staffId','Staff',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(384,' todo ',' isDefault','Default',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(385,' todo ',' isNew','New',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(386,' todo ',' isDraft','Draft',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(387,' todo ',' isUpdate','Update',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(388,' todo ',' isDelete','Delete',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(389,' todo ',' isActive','Active',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(390,' todo ',' isApproved','Approved',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(391,' todo ',' isReview','Review',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(392,' todo ',' isPost','Post',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(393,' todo ',' isDone','Done',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(394,' todo ',' executeBy','By',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(395,' todo ',' executeTime','Time',0,1,0,0,0,0,0,0,0,2,'2011-10-13 18:08:25'),(396,'application','applicationId','Application',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(397,'application','iconId','Icon',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(398,'application','applicationSequence','Sequence',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(399,'application','applicationCode','Code',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(400,'application','applicationEnglish','Application',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(401,'application','applicationFilename','Filename',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(402,'application','isDefault','Default',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(403,'application','isNew','New',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(404,'application','isDraft','Draft',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(405,'application','isUpdate','Update',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(406,'application','isDelete','Delete',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(407,'application','isActive','Active',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(408,'application','isApproved','Approved',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(409,'application','isReview','Review',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(410,'application','isPost','Post',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(411,'application','executeBy','By',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(412,'application','executeTime','Time',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(413,'applicationaccess','applicationAccessId','applicationAccessId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(414,'applicationtranslate','applicationTranslateId','applicationTranslateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(415,'calendar','calendarId','calendarId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(416,'calendarcolor','calendarColorId','calendarColorId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(417,'defaultlabel','defaultLabelId','defaultLabelId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(418,'defaultlabeltranslate','languageId','languageId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(419,'department','departmentId','departmentId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(420,'district','districtId','districtId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(421,'document','documentId','documentId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(422,'documentcategory','documentCategoryId','documentCategoryId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(423,'event','eventId','eventId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(424,'extlabel','extLabelId','extLabelId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(425,'extlabeltranslate','extLabelTranslateId','extLabelTranslateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(426,'family','familyId','familyId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(427,'folder','folderId','folderId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(428,'folderaccess','folderAccessId','folderAccessId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(429,'foldertranslate','folderTranslateId','folderTranslateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(430,'icon','iconId','iconId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(431,'language','languageId','languageId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(432,'leaf','leafId','leafId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(433,'leafaccess','leafAccessId','leafAccessId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(434,'leafapproval','leafApprovalId','leafApprovalId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(435,'leafcategory','leafCategoryId','leafCategoryId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(436,'leaftranslate','leafTranslateId','leafTranslateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(437,'leafuser','leafUserId','leafUserId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(438,'log','logId','logId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(439,'logadvance','logAdvanceId','logAdvanceId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(441,'messaging','messagingId','messagingId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(442,'module','moduleId','moduleId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(443,'moduleaccess','moduleAccessId','moduleAccessId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(444,'moduletranslate','moduleTranslateId','moduleTranslateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(445,'national','nationalId','nationalId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(446,'payment','paymentId','paymentId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(447,'race','raceId','raceId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(448,'religion','religionId','religionId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(449,'religionsample','religionId','religionId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(450,'religionsampledetail','religionDetailId','religionDetailId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(451,'staff','staffId','staffId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(452,'staffwebaccess','staffWebAccessId','staffWebAccessId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(453,'systemstring','systemStringId','systemStringId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(454,'systemstringtranslate','systemStringTranslateId','systemStringTranslateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(455,'tablemapping','tableMappingId','tableMappingId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(456,'tablemappingtranslate','tableMappingTranslateId','tableMappingTranslateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(457,'team','teamId','teamId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(458,'template','templateId','templateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(459,'theme','themeId','themeId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(460,'todo','todoId','todoId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:05:43'),(463,'membership','membershipId','membershipId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(464,'membership','districtId','districtId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(465,'membership','stateId','stateId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(466,'membership','religionId','religionId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(467,'membership','raceId','raceId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(468,'membership','familyId','familyId',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(469,'membership','membershipSalary','membershipSalary',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(470,'membership','membershipRegisterDate','membershipRegisterDate',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(471,'membership','membershipName','membershipName',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(472,'membership','membershipNumber','membershipNumber',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(473,'membership','staffNumber','staffNumber',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(474,'membership','membershipDesignation','membershipDesignation',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(475,'membership','membershipIC','membershipIC',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(476,'membership','membershipBirthday','membershipBirthday',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(477,'membership','membershipPhone','membershipPhone',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(478,'membership','membershipHP','membershipHP',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(479,'membership','membershipAddress','membershipAddress',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(480,'membership','membershipPostcode','membershipPostcode',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(481,'membership','membershipExt','membershipExt',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(482,'membership','membershipEmail','membershipEmail',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(483,'membership','isDefault','Default',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(484,'membership','isNew','New',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(485,'membership','isDraft','Draft',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(486,'membership','isUpdate','Update',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(487,'membership','isDelete','Delete',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(488,'membership','isActive','Active',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(489,'membership','isApproved','Approved',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(490,'membership','isReview','Review',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(491,'membership','isPost','Post',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(492,'membership','executeBy','By',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20'),(493,'membership','executeTime','Time',0,0,0,0,0,0,0,0,0,2,'2011-11-21 04:31:20');
/*!40000 ALTER TABLE `tablemapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tablemappingtranslate`
--

DROP TABLE IF EXISTS `tablemappingtranslate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tablemappingtranslate` (
  `tableMappingTranslateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Mapping|',
  `tableMappingId` int(11) NOT NULL,
  `tableMappingNative` varchar(256) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Native|',
  `languageId` int(11) NOT NULL COMMENT 'Language|',
  `isDefault` tinyint(4) NOT NULL,
  `isNew` tinyint(4) NOT NULL,
  `isDraft` tinyint(4) NOT NULL,
  `isUpdate` tinyint(4) NOT NULL,
  `isDelete` tinyint(4) NOT NULL,
  `isActive` tinyint(4) NOT NULL,
  `isApproved` tinyint(4) NOT NULL,
  `isReview` tinyint(4) NOT NULL,
  `isPost` tinyint(4) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`tableMappingTranslateId`)
) ENGINE=InnoDB AUTO_INCREMENT=5447 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tablemappingtranslate`
--

LOCK TABLES `tablemappingtranslate` WRITE;
/*!40000 ALTER TABLE `tablemappingtranslate` DISABLE KEYS */;
INSERT INTO `tablemappingtranslate` VALUES (1,1,'Calendar',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(2,2,'Color',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(3,3,'Title',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(4,4,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5,5,'Hidden',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(6,6,'Staff',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(7,7,'Color',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(8,8,'Default Label',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(9,9,' Label',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(10,10,' English Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(11,11,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(12,12,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(13,13,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(14,14,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(15,15,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(16,16,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(17,17,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(18,18,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(19,19,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(20,20,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(21,21,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(22,22,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(23,23,'Default Label',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(24,24,'Native',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(25,25,'Default Label',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(26,26,'Department',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(27,27,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(28,28,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(29,29,'Note',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(30,30,'Admin',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(31,31,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(32,32,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(33,33,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(34,34,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(35,35,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(36,36,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(37,37,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(38,38,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(39,39,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(40,40,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(41,41,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(42,42,'Document',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(43,43,'Document Category',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(44,44,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(45,45,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(46,46,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(47,47,'English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(48,48,'Title',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(49,49,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(50,50,'Path',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(51,51,'Original Filename',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(52,52,'Download Filename',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(53,53,'Extension',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(54,54,'Version',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(55,55,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(56,56,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(57,57,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(58,58,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(59,59,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(60,60,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(61,61,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(62,62,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(63,63,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(64,64,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(65,65,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(66,66,'Document Category',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(67,67,'Title',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(68,68,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(69,69,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(70,70,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(71,71,'English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(72,72,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(73,73,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(74,74,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(75,75,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(76,76,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(77,77,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(78,78,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(79,79,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(80,80,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(81,81,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(82,82,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(83,83,'Event',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(84,84,'Calendar',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(85,85,'Title',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(86,86,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(87,87,' Start',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(88,88,' End',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(89,89,'Location',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(90,90,'Note',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(91,91,' Hyperlink',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(92,92,' All Day',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(93,93,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(94,94,'Reminder',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(95,95,'Staff',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(96,96,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(97,97,'Ext  Label',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(98,98,'Note',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(99,99,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(100,100,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(101,101,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(102,102,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(103,103,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(104,104,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(105,105,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(106,106,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(107,107,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(108,108,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(109,109,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(110,110,'Ext Label',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(111,111,'Ext Label',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(112,112,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(113,113,'Native',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(114,114,'Folder',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(115,115,'Module',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(116,116,'Icon',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(117,117,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(118,118,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(119,119,'Path',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(120,120,'English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(121,121,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(122,122,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(123,123,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(124,124,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(125,125,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(126,126,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(127,127,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(128,128,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(129,129,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(130,130,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(131,131,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(132,132,'Folder Access',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(133,133,'Team',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(134,134,'Folder',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(135,135,'Value',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(136,136,'Folder Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(137,137,'Folder',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(138,138,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(139,139,'Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(140,140,'Icon',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(141,141,'Name',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(142,142,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(143,143,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(144,144,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(145,145,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(146,146,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(147,147,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(148,148,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(149,149,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(150,150,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(151,151,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(152,152,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(153,153,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(154,154,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(155,155,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(156,156,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(157,157,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(158,158,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(159,159,'Leaf Category',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(160,160,'Module',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(161,161,'Folder',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(162,162,'Icon',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(163,163,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(164,164,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(165,165,'Filename',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(166,166,'English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(167,167,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(168,168,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(169,169,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(170,170,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(171,171,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(172,172,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(173,173,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(174,174,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(175,175,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(176,176,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(177,177,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(178,178,'Leaf Access',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(179,179,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(180,180,'Staff',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(181,181,'Create',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(182,182,'Read',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(183,183,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(184,184,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(185,185,'Print',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(186,186,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(187,187,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(188,188,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(189,189,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(190,190,'Leaf Approval',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(191,191,'True ? False ?',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(192,192,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(193,193,'Staff',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(194,194,'Team',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(195,195,'Success',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(196,196,' Failure',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(197,197,'Leaf Category',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(198,198,'English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(199,199,'Team Access',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(200,200,'Leaf ',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(201,201,'Team',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(202,202,'Create',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(203,203,'Read',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(204,204,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(205,205,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(206,206,'Print',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(207,207,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(208,208,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(209,209,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(210,210,'Leaf Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(211,211,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(212,212,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(213,213,' Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(214,214,'Leaf User',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(215,215,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(216,216,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(217,217,'Staff',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(218,218,'Log',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(219,219,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(220,220,'Operation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(221,221,'Structure Query Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(222,222,' Date',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(223,223,'Identification',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(224,224,'Access',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(225,225,'Error',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(226,226,'Log Advance',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(227,227,'Text',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(228,228,'Type',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(229,229,'Comparision ',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(230,230,'Reference Table',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(231,231,'Leaf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(232,232,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(233,233,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(234,234,'Identification',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(235,235,' From',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(236,236,' To',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(237,237,' Carbon Copy',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(238,238,'Title',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(239,239,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(240,240,' Send Date',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(241,241,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(242,242,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(243,243,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(244,244,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(245,245,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(246,246,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(247,247,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(248,248,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(249,249,'Sent',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(250,250,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(251,251,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(252,252,'Module',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(253,253,'Icon',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(254,254,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(255,255,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(256,256,'English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(257,257,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(258,258,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(259,259,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(260,260,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(261,261,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(262,262,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(263,263,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(264,264,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(265,265,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(266,266,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(267,267,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(268,268,'Module Access',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(269,269,'Module',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(270,270,'Team',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(271,271,'Value',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(272,272,'Module Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(273,273,'Module',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(274,274,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(275,275,'Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(276,276,'Identification',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(277,277,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(278,278,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(279,279,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(280,280,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(281,281,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(282,282,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(283,283,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(284,284,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(285,285,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(286,286,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(287,287,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(288,288,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(289,289,'Religion Detail',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(290,290,'Religion',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(291,291,'Title',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(292,292,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(293,293,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(294,294,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(295,295,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(296,296,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(297,297,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(298,298,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(299,299,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(300,300,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(301,301,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(302,302,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(303,303,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(304,304,'Staff',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(305,305,'Team',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(306,306,'Identification',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(307,307,'Identification',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(308,308,'Password',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(309,309,'Staff Name',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(310,310,'Staff Number',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(311,311,'Staff Identification Card',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(312,312,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(313,313,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(314,314,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(315,315,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(316,316,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(317,317,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(318,318,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(319,319,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(320,320,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(321,321,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(322,322,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(323,323,'Staff Web Access',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(324,324,'Staf',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(325,325,'Log in ',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(326,326,' Log Out',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(327,327,' Session',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(328,328,'Table Mapping',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(329,329,'Table Name',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(330,330,'Column Name ',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(331,331,' English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(332,332,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(333,333,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(334,334,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(335,335,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(336,336,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(337,337,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(338,338,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(339,339,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(340,340,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(341,341,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(342,342,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(343,343,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(344,344,'Table Mapping Translation',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(345,345,'Table Mapping',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(346,346,'Native',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(347,347,'Language',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(348,348,'Team',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(349,349,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(350,350,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(351,351,'English',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(352,352,'Admin',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(353,353,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(354,354,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(355,355,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(356,356,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(357,357,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(358,358,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(359,359,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(360,360,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(361,361,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(362,362,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(363,363,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(364,364,'Theme',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(365,365,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(366,366,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(367,367,'Note',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(368,368,'Path',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(369,369,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(370,370,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(371,371,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(372,372,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(373,373,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(374,374,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(375,375,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(376,376,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(377,377,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(378,378,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(379,379,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(380,380,'Todo',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(381,381,'Title',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(382,382,'Description',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(383,383,'Staff',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(384,384,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(385,385,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(386,386,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(387,387,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(388,388,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(389,389,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(390,390,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(391,391,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(392,392,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(393,393,'Done',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(394,394,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(395,395,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5430,396,'Application',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5431,397,'Icon',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5432,398,'Sequence',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5433,399,'Code',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5434,400,'Application',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5435,401,'Filename',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5436,402,'Default',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5437,403,'New',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5438,404,'Draft',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5439,405,'Update',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5440,406,'Delete',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5441,407,'Active',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5442,408,'Approved',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5443,409,'Review',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5444,410,'Post',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5445,411,'By',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5446,412,'Time',21,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tablemappingtranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `teamId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `teamSequence` int(11) NOT NULL,
  `teamCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `teamEnglish` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isDefault` tinyint(1) NOT NULL COMMENT 'Default|',
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(4) NOT NULL,
  `isPost` tinyint(4) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`teamId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci COMMENT='synomim to group';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,1,'ad','administrator',1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(2,2,'sp','supervisor',0,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(3,3,'sf','staff',0,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(4,4,'mbr','member',0,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(5,5,'demo','demo',0,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(6,5,'mgr','manager',0,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `template`
--

DROP TABLE IF EXISTS `template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `template` (
  `templateId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`templateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template`
--

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `theme` (
  `themeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `themeSequence` int(11) NOT NULL,
  `themeCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `themeNote` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
  `themePath` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL COMMENT 'Default|',
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`themeId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme`
--

LOCK TABLES `theme` WRITE;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` VALUES (1,0,'','Black','../../javascript/resources/css/xtheme-black.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(2,0,'','Vampire','../../javascript/resources/css/xtheme-vampire.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(3,0,'','Toxic','../../javascript/resources/css/xtheme-Toxic.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(4,0,'','Darkness','../../javascript/resources/css/xtheme-darkness.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(5,0,'','BlackNW','../../javascript/resources/css/xtheme-blacknw.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(6,0,'','Blue','../../javascript/resources/css/xtheme-blue.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(7,0,'','Access','../js/resources/css/xtheme-access.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(8,0,'','Dark Gray','../../javascript/resources/css/xtheme-darkgray.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(9,0,'','Gray','../../javascript/resources/css/xtheme-gray.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(10,0,'','Olive','../../javascript/resources/css/xtheme-olive.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(11,0,'','Chocolate','../../javascript/resources/css/xtheme-chocolate.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(12,0,'','Silver Cherry','../../javascript/resources/css/xtheme-silverCherry.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(13,0,'','Slickness','../../javascript/resources/css/xtheme-slickness.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(14,0,'','Midnight','../../javascript/resources/css/xtheme-midnight.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(15,0,'','Indigo','../../javascript/resources/css/xtheme-indigo.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(16,0,'','Pepermint','../../javascript/resources/css/xtheme-peppermint.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17'),(17,0,'','Ubuntu','../../javascript/resources/css/xtheme-human.css',0,1,0,0,0,1,0,0,0,2,'2011-09-02 19:59:17');
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo`
--

DROP TABLE IF EXISTS `todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo` (
  `todoId` int(11) NOT NULL AUTO_INCREMENT,
  `todoTitle` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `todoDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `staffId` int(11) NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `isDone` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`todoId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo`
--

LOCK TABLES `todo` WRITE;
/*!40000 ALTER TABLE `todo` DISABLE KEYS */;
/*!40000 ALTER TABLE `todo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-11-21 11:35:58
