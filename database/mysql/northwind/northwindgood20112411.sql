-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: northwindgood
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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customersId` int(10) NOT NULL AUTO_INCREMENT,
  `customersCompany` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersLastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersFirstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersEmail` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersJobTitle` varchar(50) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `customersBusinessPhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersHomePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersMobilePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersFaxNum` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersAddress` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `customersCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersState` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersPostCode` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersCountry` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `customersWebPage` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `customersNotes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `customersAttachments` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`customersId`),
  KEY `City` (`customersCity`),
  KEY `Company` (`customersCompany`),
  KEY `First Name` (`customersFirstName`),
  KEY `Last Name` (`customersLastName`),
  KEY `Postal Code` (`customersPostCode`),
  KEY `State/Province` (`customersState`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Company A','Bedecs','Anna',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 1st Street','Seattle','WA','99999','USA',NULL,NULL,NULL),(2,'Company B','Gratacos Solsona','Antonio',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 2nd Street','Boston','MA','99999','USA',NULL,NULL,NULL),(3,'Company C','Axen','Thomas',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','123 3rd Street','Los Angelas','CA','99999','USA',NULL,NULL,NULL),(4,'Company D','Lee','Christina',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 4th Street','New York','NY','99999','USA',NULL,NULL,NULL),(5,'Company E','O’Donnell','Martin',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 5th Street','Minneapolis','MN','99999','USA',NULL,NULL,NULL),(6,'Company F','Pérez-Olaeta','Francisco',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 6th Street','Milwaukee','WI','99999','USA',NULL,NULL,NULL),(7,'Company G','Xie','Ming-Yang',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 7th Street','Boise','ID','99999','USA',NULL,NULL,NULL),(8,'Company H','Andersen','Elizabeth',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','123 8th Street','Portland','OR','99999','USA',NULL,NULL,NULL),(9,'Company I','Mortensen','Sven',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 9th Street','Salt Lake City','UT','99999','USA',NULL,NULL,NULL),(10,'Company J','Wacker','Roland',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 10th Street','Chicago','IL','99999','USA',NULL,NULL,NULL),(11,'Company K','Krschne','Peter',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 11th Street','Miami','FL','99999','USA',NULL,NULL,NULL),(12,'Company L','Edwards','John',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 12th Street','Las Vegas','NV','99999','USA',NULL,NULL,NULL),(13,'Company M','Ludick','Andre',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 13th Street','Memphis','TN','99999','USA',NULL,NULL,NULL),(14,'Company N','Grilo','Carlos',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 14th Street','Denver','CO','99999','USA',NULL,NULL,NULL),(15,'Company O','Kupkova','Helena',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','456 15th Street','Honolulu','HI','99999','USA',NULL,NULL,NULL),(16,'Company P','Goldschmidt','Daniel',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 16th Street','San Francisco','CA','99999','USA',NULL,NULL,NULL),(17,'Company Q','Bagel','Jean Philippe',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','456 17th Street','Seattle','WA','99999','USA',NULL,NULL,NULL),(18,'Company R','Autier Miconi','Catherine',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 18th Street','Boston','MA','99999','USA',NULL,NULL,NULL),(19,'Company S','Eggerer','Alexander',NULL,'Accounting Assistant','(123)555-0100',NULL,NULL,'(123)555-0101','789 19th Street','Los Angelas','CA','99999','USA',NULL,NULL,NULL),(20,'Company T','Li','George',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 20th Street','New York','NY','99999','USA',NULL,NULL,NULL),(21,'Company U','Tham','Bernard',NULL,'Accounting Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 21th Street','Minneapolis','MN','99999','USA',NULL,NULL,NULL),(22,'Company V','Ramos','Luciana',NULL,'Purchasing Assistant','(123)555-0100',NULL,NULL,'(123)555-0101','789 22th Street','Milwaukee','WI','99999','USA',NULL,NULL,NULL),(23,'Company W','Entin','Michael',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 23th Street','Portland','OR','99999','USA',NULL,NULL,NULL),(24,'Company X','Hasselberg','Jonas',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','789 24th Street','Salt Lake City','UT','99999','USA',NULL,NULL,NULL),(25,'Company Y','Rodman','John',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 25th Street','Chicago','IL','99999','USA',NULL,NULL,NULL),(26,'Company Z','Liu','Run',NULL,'Accounting Assistant','(123)555-0100',NULL,NULL,'(123)555-0101','789 26th Street','Miami','FL','99999','USA',NULL,NULL,NULL),(27,'Company AA','Toh','Karen',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 27th Street','Las Vegas','NV','99999','USA',NULL,NULL,NULL),(28,'Company BB','Raghav','Amritansh',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 28th Street','Memphis','TN','99999','USA',NULL,NULL,NULL),(29,'Company CC','Lee','Soo Jung',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 29th Street','Denver','CO','99999','USA',NULL,NULL,NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `customers extended`
--

DROP TABLE IF EXISTS `customers extended`;
/*!50001 DROP VIEW IF EXISTS `customers extended`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `customers extended` (
  `File As` varchar(103),
  `Contact Name` varchar(103),
  `customersId` int(10),
  `customersCompany` varchar(50),
  `customersLastName` varchar(50),
  `customersFirstName` varchar(50),
  `customersEmail` varchar(50),
  `customersJobTitle` varchar(50),
  `customersBusinessPhone` varchar(25),
  `customersHomePhone` varchar(25),
  `customersMobilePhone` varchar(25),
  `customersFaxNum` varchar(25),
  `customersAddress` longtext,
  `customersCity` varchar(50),
  `customersState` varchar(50),
  `customersPostCode` varchar(15),
  `customersCountry` varchar(50),
  `customersWebPage` longtext,
  `customersNotes` longtext,
  `customersAttachments` longtext
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `employeeprivileges`
--

DROP TABLE IF EXISTS `employeeprivileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employeeprivileges` (
  `employeesId` int(10) NOT NULL,
  `privilegeId` int(10) NOT NULL,
  PRIMARY KEY (`employeesId`,`privilegeId`),
  KEY `EmployeePriviligesforEmployees` (`employeesId`),
  KEY `EmployeePriviligesLookup` (`privilegeId`),
  KEY `New_EmployeePriviligesforEmploy` (`employeesId`),
  KEY `New_EmployeePriviligesLookup` (`privilegeId`),
  KEY `Privilege ID` (`privilegeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employeeprivileges`
--

LOCK TABLES `employeeprivileges` WRITE;
/*!40000 ALTER TABLE `employeeprivileges` DISABLE KEYS */;
INSERT INTO `employeeprivileges` VALUES (2,2);
/*!40000 ALTER TABLE `employeeprivileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `employeesId` int(10) NOT NULL AUTO_INCREMENT,
  `employeesCompany` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesLastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesFirstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesEmail` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesJobTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesBusinessPhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesHomePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesMobilePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesFaxNum` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesAddress` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `employeesCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesState` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesPostCode` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesCountry` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employeesWebPage` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `employeesNotes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `employeesAttachments` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`employeesId`),
  KEY `City` (`employeesCity`),
  KEY `Company` (`employeesCompany`),
  KEY `First Name` (`employeesFirstName`),
  KEY `Last Name` (`employeesLastName`),
  KEY `Postal Code` (`employeesPostCode`),
  KEY `State/Province` (`employeesState`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Northwind Traders','Freehafer','Nancy','nancy@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 1st Avenue','Seattle','WA','99999','USA','#http://northwindtraders.com#',NULL,NULL),(2,'Northwind Traders','Cencini','Andrew','andrew@northwindtraders.com','Vice President, Sales','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 2nd Avenue','Bellevue','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Joined the company as a sales representative, was promoted to sales manager and was then named vice president of sales.',NULL),(3,'Northwind Traders','Kotas','Jan','jan@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 3rd Avenue','Redmond','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Was hired as a sales associate and was promoted to sales representative.',NULL),(4,'Northwind Traders','Sergienko','Mariya','mariya@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 4th Avenue','Kirkland','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#',NULL,NULL),(5,'Northwind Traders','Thorpe','Steven','steven@northwindtraders.com','Sales Manager','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 5th Avenue','Seattle','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Joined the company as a sales representative and was promoted to sales manager.  Fluent in French.',NULL),(6,'Northwind Traders','Neipper','Michael','michael@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 6th Avenue','Redmond','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Fluent in Japanese and can read and write French, Portuguese, and Spanish.',NULL),(7,'Northwind Traders','Zare','Robert','robert@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 7th Avenue','Seattle','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#',NULL,NULL),(8,'Northwind Traders','Giussani','Laura','laura@northwindtraders.com','Sales Coordinator','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 8th Avenue','Redmond','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Reads and writes French.',NULL),(9,'Northwind Traders','Hellung-Larsen','Anne','anne@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 9th Avenue','Seattle','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Fluent in French and German.',NULL);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `employees extended`
--

DROP TABLE IF EXISTS `employees extended`;
/*!50001 DROP VIEW IF EXISTS `employees extended`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `employees extended` (
  `File As` varchar(103),
  `Employee Name` varchar(103),
  `employeesId` int(10),
  `employeesCompany` varchar(50),
  `employeesLastName` varchar(50),
  `employeesFirstName` varchar(50),
  `employeesEmail` varchar(50),
  `employeesJobTitle` varchar(50),
  `employeesBusinessPhone` varchar(25),
  `employeesHomePhone` varchar(25),
  `employeesMobilePhone` varchar(25),
  `employeesFaxNum` varchar(25),
  `employeesAddress` longtext,
  `employeesCity` varchar(50),
  `employeesState` varchar(50),
  `employeesPostCode` varchar(15),
  `employeesCountry` varchar(50),
  `employeesWebPage` longtext,
  `employeesNotes` longtext,
  `employeesAttachments` longtext
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inventory on hold`
--

DROP TABLE IF EXISTS `inventory on hold`;
/*!50001 DROP VIEW IF EXISTS `inventory on hold`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `inventory on hold` (
  `productsId` int(10),
  `Quantity On Hold` decimal(32,0)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inventory on order`
--

DROP TABLE IF EXISTS `inventory on order`;
/*!50001 DROP VIEW IF EXISTS `inventory on order`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `inventory on order` (
  `productsId` int(10),
  `Quantity On Order` decimal(40,4)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inventory purchased`
--

DROP TABLE IF EXISTS `inventory purchased`;
/*!50001 DROP VIEW IF EXISTS `inventory purchased`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `inventory purchased` (
  `productsId` int(10),
  `Quantity Purchased` decimal(32,0)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inventory sold`
--

DROP TABLE IF EXISTS `inventory sold`;
/*!50001 DROP VIEW IF EXISTS `inventory sold`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `inventory sold` (
  `productsId` int(10),
  `Quantity Sold` decimal(32,0)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `inventorytransactions`
--

DROP TABLE IF EXISTS `inventorytransactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventorytransactions` (
  `inventoryTransactionsId` int(10) NOT NULL AUTO_INCREMENT,
  `inventoryTransactionsTypesId` smallint(5) NOT NULL,
  `inventoryTransactionsCreatedDate` datetime DEFAULT NULL,
  `inventoryTransactionsModifiedDate` datetime DEFAULT NULL,
  `productsId` int(10) NOT NULL,
  `inventoryTransactionsQuantity` int(10) NOT NULL,
  `purchaseOrdersID` int(10) DEFAULT NULL,
  `customerOrdersId` int(10) DEFAULT NULL,
  `inventoryTransactionsComments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`inventoryTransactionsId`),
  KEY `Customer Order ID` (`customerOrdersId`),
  KEY `New_OrdersOnInventoryTransactio` (`customerOrdersId`),
  KEY `New_ProductOnInventoryTransacti` (`productsId`),
  KEY `New_PuchaseOrdersonInventoryTra` (`purchaseOrdersID`),
  KEY `New_TransactionTypesOnInventory` (`inventoryTransactionsTypesId`),
  KEY `OrdersOnInventoryTransactions` (`customerOrdersId`),
  KEY `Product ID` (`productsId`),
  KEY `ProductOnInventoryTransaction` (`productsId`),
  KEY `PuchaseOrdersonInventoryTransac` (`purchaseOrdersID`),
  KEY `Purchase Order ID` (`purchaseOrdersID`),
  KEY `TransactionTypesOnInventoryTran` (`inventoryTransactionsTypesId`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventorytransactions`
--

LOCK TABLES `inventorytransactions` WRITE;
/*!40000 ALTER TABLE `inventorytransactions` DISABLE KEYS */;
INSERT INTO `inventorytransactions` VALUES (35,1,'2006-03-22 16:02:28','2006-03-22 16:02:28',80,75,NULL,NULL,NULL),(36,1,'2006-03-22 16:02:48','2006-03-22 16:02:48',72,40,NULL,NULL,NULL),(37,1,'2006-03-22 16:03:04','2006-03-22 16:03:04',52,100,NULL,NULL,NULL),(38,1,'2006-03-22 16:03:09','2006-03-22 16:03:09',56,120,NULL,NULL,NULL),(39,1,'2006-03-22 16:03:14','2006-03-22 16:03:14',57,80,NULL,NULL,NULL),(40,1,'2006-03-22 16:03:40','2006-03-22 16:03:40',6,100,NULL,NULL,NULL),(41,1,'2006-03-22 16:03:47','2006-03-22 16:03:47',7,40,NULL,NULL,NULL),(42,1,'2006-03-22 16:03:54','2006-03-22 16:03:54',8,40,NULL,NULL,NULL),(43,1,'2006-03-22 16:04:02','2006-03-22 16:04:02',14,40,NULL,NULL,NULL),(44,1,'2006-03-22 16:04:07','2006-03-22 16:04:07',17,40,NULL,NULL,NULL),(45,1,'2006-03-22 16:04:12','2006-03-22 16:04:12',19,20,NULL,NULL,NULL),(46,1,'2006-03-22 16:04:17','2006-03-22 16:04:17',20,40,NULL,NULL,NULL),(47,1,'2006-03-22 16:04:20','2006-03-22 16:04:20',21,20,NULL,NULL,NULL),(48,1,'2006-03-22 16:04:24','2006-03-22 16:04:24',40,120,NULL,NULL,NULL),(49,1,'2006-03-22 16:04:28','2006-03-22 16:04:28',41,40,NULL,NULL,NULL),(50,1,'2006-03-22 16:04:31','2006-03-22 16:04:31',48,100,NULL,NULL,NULL),(51,1,'2006-03-22 16:04:38','2006-03-22 16:04:38',51,40,NULL,NULL,NULL),(52,1,'2006-03-22 16:04:41','2006-03-22 16:04:41',74,20,NULL,NULL,NULL),(53,1,'2006-03-22 16:04:45','2006-03-22 16:04:45',77,60,NULL,NULL,NULL),(54,1,'2006-03-22 16:05:07','2006-03-22 16:05:07',3,100,NULL,NULL,NULL),(55,1,'2006-03-22 16:05:11','2006-03-22 16:05:11',4,40,NULL,NULL,NULL),(56,1,'2006-03-22 16:05:14','2006-03-22 16:05:14',5,40,NULL,NULL,NULL),(57,1,'2006-03-22 16:05:26','2006-03-22 16:05:26',65,40,NULL,NULL,NULL),(58,1,'2006-03-22 16:05:32','2006-03-22 16:05:32',66,80,NULL,NULL,NULL),(59,1,'2006-03-22 16:05:47','2006-03-22 16:05:47',1,40,NULL,NULL,NULL),(60,1,'2006-03-22 16:05:51','2006-03-22 16:05:51',34,60,NULL,NULL,NULL),(61,1,'2006-03-22 16:06:00','2006-03-22 16:06:00',43,100,NULL,NULL,NULL),(62,1,'2006-03-22 16:06:03','2006-03-22 16:06:03',81,125,NULL,NULL,NULL),(63,2,'2006-03-22 16:07:56','2006-03-24 11:03:00',80,30,NULL,NULL,NULL),(64,2,'2006-03-22 16:08:19','2006-03-22 16:08:59',7,10,NULL,NULL,NULL),(65,2,'2006-03-22 16:08:29','2006-03-22 16:08:59',51,10,NULL,NULL,NULL),(66,2,'2006-03-22 16:08:37','2006-03-22 16:08:59',80,10,NULL,NULL,NULL),(67,2,'2006-03-22 16:09:46','2006-03-22 16:10:27',1,15,NULL,NULL,NULL),(68,2,'2006-03-22 16:10:06','2006-03-22 16:10:27',43,20,NULL,NULL,NULL),(69,2,'2006-03-22 16:11:39','2006-03-24 11:00:55',19,20,NULL,NULL,NULL),(70,2,'2006-03-22 16:11:56','2006-03-24 10:59:41',48,10,NULL,NULL,NULL),(71,2,'2006-03-22 16:12:29','2006-03-24 10:57:38',8,17,NULL,NULL,NULL),(72,1,'2006-03-24 10:41:30','2006-03-24 10:41:30',81,200,NULL,NULL,NULL),(73,2,'2006-03-24 10:41:33','2006-03-24 10:41:42',81,200,NULL,NULL,'Fill Back Ordered product, Order #40'),(74,1,'2006-03-24 10:53:13','2006-03-24 10:53:13',48,100,NULL,NULL,NULL),(75,2,'2006-03-24 10:53:16','2006-03-24 10:55:46',48,100,NULL,NULL,'Fill Back Ordered product, Order #39'),(76,1,'2006-03-24 10:53:36','2006-03-24 10:53:36',43,300,NULL,NULL,NULL),(77,2,'2006-03-24 10:53:39','2006-03-24 10:56:57',43,300,NULL,NULL,'Fill Back Ordered product, Order #38'),(78,1,'2006-03-24 10:54:04','2006-03-24 10:54:04',41,200,NULL,NULL,NULL),(79,2,'2006-03-24 10:54:07','2006-03-24 10:58:40',41,200,NULL,NULL,'Fill Back Ordered product, Order #36'),(80,1,'2006-03-24 10:54:33','2006-03-24 10:54:33',19,30,NULL,NULL,NULL),(81,2,'2006-03-24 10:54:35','2006-03-24 11:02:02',19,30,NULL,NULL,'Fill Back Ordered product, Order #33'),(82,1,'2006-03-24 10:54:58','2006-03-24 10:54:58',34,100,NULL,NULL,NULL),(83,2,'2006-03-24 10:55:02','2006-03-24 11:03:00',34,100,NULL,NULL,'Fill Back Ordered product, Order #30'),(84,2,'2006-03-24 14:48:15','2006-04-04 11:41:14',6,10,NULL,NULL,NULL),(85,2,'2006-03-24 14:48:23','2006-04-04 11:41:14',4,10,NULL,NULL,NULL),(86,3,'2006-03-24 14:49:16','2006-03-24 14:49:16',80,20,NULL,NULL,NULL),(87,3,'2006-03-24 14:49:20','2006-03-24 14:49:20',81,50,NULL,NULL,NULL),(88,3,'2006-03-24 14:50:09','2006-03-24 14:50:09',1,25,NULL,NULL,NULL),(89,3,'2006-03-24 14:50:14','2006-03-24 14:50:14',43,25,NULL,NULL,NULL),(90,3,'2006-03-24 14:50:18','2006-03-24 14:50:18',81,25,NULL,NULL,NULL),(91,2,'2006-03-24 14:51:03','2006-04-04 11:09:24',40,50,NULL,NULL,NULL),(92,2,'2006-03-24 14:55:03','2006-04-04 11:06:56',21,20,NULL,NULL,NULL),(93,2,'2006-03-24 14:55:39','2006-04-04 11:06:13',5,25,NULL,NULL,NULL),(94,2,'2006-03-24 14:55:52','2006-04-04 11:06:13',41,30,NULL,NULL,NULL),(95,2,'2006-03-24 14:56:09','2006-04-04 11:06:13',40,30,NULL,NULL,NULL),(96,3,'2006-03-30 16:46:34','2006-03-30 16:46:34',34,12,NULL,NULL,NULL),(97,3,'2006-03-30 17:23:27','2006-03-30 17:23:27',34,10,NULL,NULL,NULL),(98,3,'2006-03-30 17:24:33','2006-03-30 17:24:33',34,1,NULL,NULL,NULL),(99,2,'2006-04-03 13:50:08','2006-04-03 13:50:15',48,10,NULL,NULL,NULL),(100,1,'2006-04-04 11:00:54','2006-04-04 11:00:54',57,100,NULL,NULL,NULL),(101,2,'2006-04-04 11:00:56','2006-04-04 11:08:49',57,100,NULL,NULL,'Fill Back Ordered product, Order #46'),(102,1,'2006-04-04 11:01:14','2006-04-04 11:01:14',34,50,NULL,NULL,NULL),(103,1,'2006-04-04 11:01:35','2006-04-04 11:01:35',43,250,NULL,NULL,NULL),(104,3,'2006-04-04 11:01:37','2006-04-04 11:01:37',43,300,NULL,NULL,'Fill Back Ordered product, Order #41'),(105,1,'2006-04-04 11:01:55','2006-04-04 11:01:55',8,25,NULL,NULL,NULL),(106,2,'2006-04-04 11:01:58','2006-04-04 11:07:37',8,25,NULL,NULL,'Fill Back Ordered product, Order #48'),(107,1,'2006-04-04 11:02:17','2006-04-04 11:02:17',34,300,NULL,NULL,NULL),(108,2,'2006-04-04 11:02:19','2006-04-04 11:08:14',34,300,NULL,NULL,'Fill Back Ordered product, Order #47'),(109,1,'2006-04-04 11:02:37','2006-04-04 11:02:37',19,25,NULL,NULL,NULL),(110,2,'2006-04-04 11:02:39','2006-04-04 11:41:14',19,10,NULL,NULL,'Fill Back Ordered product, Order #42'),(111,1,'2006-04-04 11:02:56','2006-04-04 11:02:56',19,10,NULL,NULL,NULL),(112,2,'2006-04-04 11:02:58','2006-04-04 11:07:37',19,25,NULL,NULL,'Fill Back Ordered product, Order #48'),(113,1,'2006-04-04 11:03:12','2006-04-04 11:03:12',72,50,NULL,NULL,NULL),(114,2,'2006-04-04 11:03:14','2006-04-04 11:08:49',72,50,NULL,NULL,'Fill Back Ordered product, Order #46'),(115,1,'2006-04-04 11:03:38','2006-04-04 11:03:38',41,50,NULL,NULL,NULL),(116,2,'2006-04-04 11:03:39','2006-04-04 11:09:24',41,50,NULL,NULL,'Fill Back Ordered product, Order #45'),(117,2,'2006-04-04 11:04:55','2006-04-04 11:05:04',34,87,NULL,NULL,NULL),(118,2,'2006-04-04 11:35:50','2006-04-04 11:35:54',51,30,NULL,NULL,NULL),(119,2,'2006-04-04 11:35:51','2006-04-04 11:35:54',7,30,NULL,NULL,NULL),(120,2,'2006-04-04 11:36:15','2006-04-04 11:36:21',17,40,NULL,NULL,NULL),(121,2,'2006-04-04 11:36:39','2006-04-04 11:36:47',6,90,NULL,NULL,NULL),(122,2,'2006-04-04 11:37:06','2006-04-04 11:37:09',4,30,NULL,NULL,NULL),(123,2,'2006-04-04 11:37:45','2006-04-04 11:37:49',48,40,NULL,NULL,NULL),(124,2,'2006-04-04 11:38:07','2006-04-04 11:38:11',48,40,NULL,NULL,NULL),(125,2,'2006-04-04 11:38:27','2006-04-04 11:38:32',41,10,NULL,NULL,NULL),(126,2,'2006-04-04 11:38:48','2006-04-04 11:38:53',43,5,NULL,NULL,NULL),(127,2,'2006-04-04 11:39:12','2006-04-04 11:39:29',40,40,NULL,NULL,NULL),(128,2,'2006-04-04 11:39:50','2006-04-04 11:39:53',8,20,NULL,NULL,NULL),(129,2,'2006-04-04 11:40:13','2006-04-04 11:40:16',80,15,NULL,NULL,NULL),(130,2,'2006-04-04 11:40:32','2006-04-04 11:40:38',74,20,NULL,NULL,NULL),(131,2,'2006-04-04 11:41:39','2006-04-04 11:41:45',72,40,NULL,NULL,NULL),(132,2,'2006-04-04 11:42:17','2006-04-04 11:42:26',3,50,NULL,NULL,NULL),(133,2,'2006-04-04 11:42:24','2006-04-04 11:42:26',8,3,NULL,NULL,NULL),(134,2,'2006-04-04 11:42:48','2006-04-04 11:43:08',20,40,NULL,NULL,NULL),(135,2,'2006-04-04 11:43:05','2006-04-04 11:43:08',52,40,NULL,NULL,NULL),(136,3,'2006-04-25 17:04:05','2006-04-25 17:04:57',56,110,NULL,NULL,NULL);
/*!40000 ALTER TABLE `inventorytransactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventorytransactionstypes`
--

DROP TABLE IF EXISTS `inventorytransactionstypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventorytransactionstypes` (
  `inventorytransactionstypesId` int(10) NOT NULL,
  `inventorytransactionstypesName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`inventorytransactionstypesId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventorytransactionstypes`
--

LOCK TABLES `inventorytransactionstypes` WRITE;
/*!40000 ALTER TABLE `inventorytransactionstypes` DISABLE KEYS */;
INSERT INTO `inventorytransactionstypes` VALUES (1,'Purchased'),(2,'Sold'),(3,'On Hold'),(4,'Waste');
/*!40000 ALTER TABLE `inventorytransactionstypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `invoice data`
--

DROP TABLE IF EXISTS `invoice data`;
/*!50001 DROP VIEW IF EXISTS `invoice data`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `invoice data` (
  `ordersId` int(10),
  `ordersShipName` varchar(50),
  `ordersShipAddress` longtext,
  `ordersShipCity` varchar(50),
  `ordersShipState` varchar(50),
  `ordersShipPostcode` varchar(50),
  `ordersShipCountry` varchar(50),
  `customersId` int(10),
  `Customer Name` varchar(50),
  `customersAddress` longtext,
  `customersCity` varchar(50),
  `customersState` varchar(50),
  `customersPostcode` varchar(15),
  `customersCountry` varchar(50),
  `Salesperson` varchar(103),
  `ordersDate` timestamp,
  `ordersShippedDate` datetime,
  `Shipper Name` varchar(50),
  `productsId` int(10),
  `ordersDetailsUnitPrice` decimal(19,4),
  `ordersDetailsQuantity` decimal(18,4),
  `ordersDetailsDiscount` double,
  `ExtendedPrice` double,
  `ordersShippingFee` decimal(19,4),
  `productsName` varchar(50)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `invoicesId` int(10) NOT NULL AUTO_INCREMENT,
  `ordersId` int(10) DEFAULT NULL,
  `invoicesDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `invoicesDueDate` datetime DEFAULT NULL,
  `invoicesTax` decimal(19,4) DEFAULT NULL,
  `invoicesShipping` decimal(19,4) DEFAULT NULL,
  `invoicesAmtDue` decimal(19,4) DEFAULT NULL,
  PRIMARY KEY (`invoicesId`),
  KEY `New_OrderInvoice` (`ordersId`),
  KEY `Order ID` (`ordersId`),
  KEY `OrderInvoice` (`ordersId`),
  CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`ordersId`) REFERENCES `orders` (`ordersId`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (5,31,'2006-03-22 08:08:59',NULL,0.0000,0.0000,0.0000),(6,32,'2006-03-22 08:10:27',NULL,0.0000,0.0000,0.0000),(7,40,'2006-03-24 02:41:41',NULL,0.0000,0.0000,0.0000),(8,39,'2006-03-24 02:55:46',NULL,0.0000,0.0000,0.0000),(9,38,'2006-03-24 02:56:57',NULL,0.0000,0.0000,0.0000),(10,37,'2006-03-24 02:57:38',NULL,0.0000,0.0000,0.0000),(11,36,'2006-03-24 02:58:40',NULL,0.0000,0.0000,0.0000),(12,35,'2006-03-24 02:59:41',NULL,0.0000,0.0000,0.0000),(13,34,'2006-03-24 03:00:55',NULL,0.0000,0.0000,0.0000),(14,33,'2006-03-24 03:02:02',NULL,0.0000,0.0000,0.0000),(15,30,'2006-03-24 03:03:00',NULL,0.0000,0.0000,0.0000),(16,56,'2006-04-03 05:50:15',NULL,0.0000,0.0000,0.0000),(17,55,'2006-04-04 03:05:04',NULL,0.0000,0.0000,0.0000),(18,51,'2006-04-04 03:06:13',NULL,0.0000,0.0000,0.0000),(19,50,'2006-04-04 03:06:56',NULL,0.0000,0.0000,0.0000),(20,48,'2006-04-04 03:07:37',NULL,0.0000,0.0000,0.0000),(21,47,'2006-04-04 03:08:14',NULL,0.0000,0.0000,0.0000),(22,46,'2006-04-04 03:08:49',NULL,0.0000,0.0000,0.0000),(23,45,'2006-04-04 03:09:24',NULL,0.0000,0.0000,0.0000),(24,79,'2006-04-04 03:35:54',NULL,0.0000,0.0000,0.0000),(25,78,'2006-04-04 03:36:21',NULL,0.0000,0.0000,0.0000),(26,77,'2006-04-04 03:36:47',NULL,0.0000,0.0000,0.0000),(27,76,'2006-04-04 03:37:09',NULL,0.0000,0.0000,0.0000),(28,75,'2006-04-04 03:37:49',NULL,0.0000,0.0000,0.0000),(29,74,'2006-04-04 03:38:11',NULL,0.0000,0.0000,0.0000),(30,73,'2006-04-04 03:38:32',NULL,0.0000,0.0000,0.0000),(31,72,'2006-04-04 03:38:53',NULL,0.0000,0.0000,0.0000),(32,71,'2006-04-04 03:39:29',NULL,0.0000,0.0000,0.0000),(33,70,'2006-04-04 03:39:53',NULL,0.0000,0.0000,0.0000),(34,69,'2006-04-04 03:40:16',NULL,0.0000,0.0000,0.0000),(35,67,'2006-04-04 03:40:38',NULL,0.0000,0.0000,0.0000),(36,42,'2006-04-04 03:41:14',NULL,0.0000,0.0000,0.0000),(37,60,'2006-04-04 03:41:45',NULL,0.0000,0.0000,0.0000),(38,63,'2006-04-04 03:42:26',NULL,0.0000,0.0000,0.0000),(39,58,'2006-04-04 03:43:08',NULL,0.0000,0.0000,0.0000);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `order details extended`
--

DROP TABLE IF EXISTS `order details extended`;
/*!50001 DROP VIEW IF EXISTS `order details extended`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `order details extended` (
  `orderDetailsId` int(10),
  `ordersId` int(10),
  `productsId` int(10),
  `ordersDetailsQuantity` decimal(18,4),
  `ordersDetailsUnitPrice` decimal(19,4),
  `ordersDetailsDiscount` double,
  `ordersDetailsStatusId` int(10),
  `ordersDetailsDateAllocated` datetime,
  `purchaseOrdersId` int(10),
  `inventoryId` int(10),
  `Extended Price` double,
  `ordersDetailsStatusName` varchar(50)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `order price totals`
--

DROP TABLE IF EXISTS `order price totals`;
/*!50001 DROP VIEW IF EXISTS `order price totals`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `order price totals` (
  `ordersId` int(10),
  `Price Total` double
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `order subtotals`
--

DROP TABLE IF EXISTS `order subtotals`;
/*!50001 DROP VIEW IF EXISTS `order subtotals`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `order subtotals` (
  `ordersId` int(10),
  `Subtotal` double
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `ordersId` int(10) NOT NULL AUTO_INCREMENT,
  `employeesId` int(10) DEFAULT NULL,
  `customersId` int(10) DEFAULT NULL,
  `ordersDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ordersShippedDate` datetime DEFAULT NULL,
  `shippersId` int(10) DEFAULT NULL,
  `ordersShipName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordersShipAddress` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ordersShipCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordersShipState` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordersShipPostCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordersShipCountry` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordersShippingFee` decimal(19,4) DEFAULT NULL,
  `ordersTaxes` decimal(19,4) DEFAULT NULL,
  `ordersPaymentType` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordersPaidDate` datetime DEFAULT NULL,
  `ordersNotes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ordersTaxRate` double DEFAULT '0',
  `ordersTaxStatusId` smallint(5) DEFAULT NULL,
  `ordersStatusId` smallint(5) DEFAULT '0',
  PRIMARY KEY (`ordersId`),
  KEY `CustomerID` (`customersId`),
  KEY `CustomerOnOrders` (`customersId`),
  KEY `EmployeeID` (`employeesId`),
  KEY `EmployeesOnOrders` (`employeesId`),
  KEY `ID` (`ordersId`),
  KEY `New_CustomerOnOrders` (`customersId`),
  KEY `New_EmployeesOnOrders` (`employeesId`),
  KEY `New_OrderStatus` (`ordersStatusId`),
  KEY `New_ShipperOnOrder` (`shippersId`),
  KEY `New_TaxStatusOnOrders` (`ordersTaxStatusId`),
  KEY `OrderStatus` (`ordersStatusId`),
  KEY `ShipperID` (`shippersId`),
  KEY `ShipperOnOrder` (`shippersId`),
  KEY `Status ID` (`ordersStatusId`),
  KEY `TaxStatusOnOrders` (`ordersTaxStatusId`),
  KEY `ZIP/Postal Code` (`ordersShipPostCode`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (30,9,27,'2006-01-14 16:00:00','2006-01-22 00:00:00',2,'Karen Toh','789 27th Street','Las Vegas','NV','99999','USA',200.0000,0.0000,'Check','2006-01-15 00:00:00',NULL,0,NULL,3),(31,3,4,'2006-01-19 16:00:00','2006-01-22 00:00:00',1,'Christina Lee','123 4th Street','New York','NY','99999','USA',5.0000,0.0000,'Credit Card','2006-01-20 00:00:00',NULL,0,NULL,3),(32,4,12,'2006-01-21 16:00:00','2006-01-22 00:00:00',2,'John Edwards','123 12th Street','Las Vegas','NV','99999','USA',5.0000,0.0000,'Credit Card','2006-01-22 00:00:00',NULL,0,NULL,3),(33,6,8,'2006-01-29 16:00:00','2006-01-31 00:00:00',3,'Elizabeth Andersen','123 8th Street','Portland','OR','99999','USA',50.0000,0.0000,'Credit Card','2006-01-30 00:00:00',NULL,0,NULL,3),(34,9,4,'2006-02-05 16:00:00','2006-02-07 00:00:00',3,'Christina Lee','123 4th Street','New York','NY','99999','USA',4.0000,0.0000,'Check','2006-02-06 00:00:00',NULL,0,NULL,3),(35,3,29,'2006-02-09 16:00:00','2006-02-12 00:00:00',2,'Soo Jung Lee','789 29th Street','Denver','CO','99999','USA',7.0000,0.0000,'Check','2006-02-10 00:00:00',NULL,0,NULL,3),(36,4,3,'2006-02-22 16:00:00','2006-02-25 00:00:00',2,'Thomas Axen','123 3rd Street','Los Angelas','CA','99999','USA',7.0000,0.0000,'Cash','2006-02-23 00:00:00',NULL,0,NULL,3),(37,8,6,'2006-03-05 16:00:00','2006-03-09 00:00:00',2,'Francisco Pérez-Olaeta','123 6th Street','Milwaukee','WI','99999','USA',12.0000,0.0000,'Credit Card','2006-03-06 00:00:00',NULL,0,NULL,3),(38,9,28,'2006-03-09 16:00:00','2006-03-11 00:00:00',3,'Amritansh Raghav','789 28th Street','Memphis','TN','99999','USA',10.0000,0.0000,'Check','2006-03-10 00:00:00',NULL,0,NULL,3),(39,3,8,'2006-03-21 16:00:00','2006-03-24 00:00:00',3,'Elizabeth Andersen','123 8th Street','Portland','OR','99999','USA',5.0000,0.0000,'Check','2006-03-22 00:00:00',NULL,0,NULL,3),(40,4,10,'2006-03-23 16:00:00','2006-03-24 00:00:00',2,'Roland Wacker','123 10th Street','Chicago','IL','99999','USA',9.0000,0.0000,'Credit Card','2006-03-24 00:00:00',NULL,0,NULL,3),(41,1,7,'2006-03-23 16:00:00',NULL,NULL,'Ming-Yang Xie','123 7th Street','Boise','ID','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(42,1,10,'2006-03-23 16:00:00','2006-04-07 00:00:00',1,'Roland Wacker','123 10th Street','Chicago','IL','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,2),(43,1,11,'2006-03-23 16:00:00',NULL,3,'Peter Krschne','123 11th Street','Miami','FL','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(44,1,1,'2006-03-23 16:00:00',NULL,NULL,'Anna Bedecs','123 1st Street','Seattle','WA','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(45,1,28,'2006-04-06 16:00:00','2006-04-07 00:00:00',3,'Amritansh Raghav','789 28th Street','Memphis','TN','99999','USA',40.0000,0.0000,'Credit Card','2006-04-07 00:00:00',NULL,0,NULL,3),(46,7,9,'2006-04-04 16:00:00','2006-04-05 00:00:00',1,'Sven Mortensen','123 9th Street','Salt Lake City','UT','99999','USA',100.0000,0.0000,'Check','2006-04-05 00:00:00',NULL,0,NULL,3),(47,6,6,'2006-04-07 16:00:00','2006-04-08 00:00:00',2,'Francisco Pérez-Olaeta','123 6th Street','Milwaukee','WI','99999','USA',300.0000,0.0000,'Credit Card','2006-04-08 00:00:00',NULL,0,NULL,3),(48,4,8,'2006-04-04 16:00:00','2006-04-05 00:00:00',2,'Elizabeth Andersen','123 8th Street','Portland','OR','99999','USA',50.0000,0.0000,'Check','2006-04-05 00:00:00',NULL,0,NULL,3),(50,9,25,'2006-04-04 16:00:00','2006-04-05 00:00:00',1,'John Rodman','789 25th Street','Chicago','IL','99999','USA',5.0000,0.0000,'Cash','2006-04-05 00:00:00',NULL,0,NULL,3),(51,9,26,'2006-04-04 16:00:00','2006-04-05 00:00:00',3,'Run Liu','789 26th Street','Miami','FL','99999','USA',60.0000,0.0000,'Credit Card','2006-04-05 00:00:00',NULL,0,NULL,3),(55,1,29,'2006-04-04 16:00:00','2006-04-05 00:00:00',2,'Soo Jung Lee','789 29th Street','Denver','CO','99999','USA',200.0000,0.0000,'Check','2006-04-05 00:00:00',NULL,0,NULL,3),(56,2,6,'2006-04-02 16:00:00','2006-04-03 00:00:00',3,'Francisco Pérez-Olaeta','123 6th Street','Milwaukee','WI','99999','USA',0.0000,0.0000,'Check','2006-04-03 00:00:00',NULL,0,NULL,3),(57,9,27,'2006-04-21 16:00:00','2006-04-22 00:00:00',2,'Karen Toh','789 27th Street','Las Vegas','NV','99999','USA',200.0000,0.0000,'Check','2006-04-22 00:00:00',NULL,0,NULL,0),(58,3,4,'2006-04-21 16:00:00','2006-04-22 00:00:00',1,'Christina Lee','123 4th Street','New York','NY','99999','USA',5.0000,0.0000,'Credit Card','2006-04-22 00:00:00',NULL,0,NULL,3),(59,4,12,'2006-04-21 16:00:00','2006-04-22 00:00:00',2,'John Edwards','123 12th Street','Las Vegas','NV','99999','USA',5.0000,0.0000,'Credit Card','2006-04-22 00:00:00',NULL,0,NULL,0),(60,6,8,'2006-04-29 16:00:00','2006-04-30 00:00:00',3,'Elizabeth Andersen','123 8th Street','Portland','OR','99999','USA',50.0000,0.0000,'Credit Card','2006-04-30 00:00:00',NULL,0,NULL,3),(61,9,4,'2006-04-06 16:00:00','2006-04-07 00:00:00',3,'Christina Lee','123 4th Street','New York','NY','99999','USA',4.0000,0.0000,'Check','2006-04-07 00:00:00',NULL,0,NULL,0),(62,3,29,'2006-04-11 16:00:00','2006-04-12 00:00:00',2,'Soo Jung Lee','789 29th Street','Denver','CO','99999','USA',7.0000,0.0000,'Check','2006-04-12 00:00:00',NULL,0,NULL,0),(63,4,3,'2006-04-24 16:00:00','2006-04-25 00:00:00',2,'Thomas Axen','123 3rd Street','Los Angelas','CA','99999','USA',7.0000,0.0000,'Cash','2006-04-25 00:00:00',NULL,0,NULL,3),(64,8,6,'2006-05-08 16:00:00','2006-05-09 00:00:00',2,'Francisco Pérez-Olaeta','123 6th Street','Milwaukee','WI','99999','USA',12.0000,0.0000,'Credit Card','2006-05-09 00:00:00',NULL,0,NULL,0),(65,9,28,'2006-05-10 16:00:00','2006-05-11 00:00:00',3,'Amritansh Raghav','789 28th Street','Memphis','TN','99999','USA',10.0000,0.0000,'Check','2006-05-11 00:00:00',NULL,0,NULL,0),(66,3,8,'2006-05-23 16:00:00','2006-05-24 00:00:00',3,'Elizabeth Andersen','123 8th Street','Portland','OR','99999','USA',5.0000,0.0000,'Check','2006-05-24 00:00:00',NULL,0,NULL,0),(67,4,10,'2006-05-23 16:00:00','2006-05-24 00:00:00',2,'Roland Wacker','123 10th Street','Chicago','IL','99999','USA',9.0000,0.0000,'Credit Card','2006-05-24 00:00:00',NULL,0,NULL,3),(68,1,7,'2006-05-23 16:00:00',NULL,NULL,'Ming-Yang Xie','123 7th Street','Boise','ID','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(69,1,10,'2006-05-23 16:00:00',NULL,1,'Roland Wacker','123 10th Street','Chicago','IL','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(70,1,11,'2006-05-23 16:00:00',NULL,3,'Peter Krschne','123 11th Street','Miami','FL','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(71,1,1,'2006-05-23 16:00:00',NULL,3,'Anna Bedecs','123 1st Street','Seattle','WA','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(72,1,28,'2006-06-06 16:00:00','2006-06-07 00:00:00',3,'Amritansh Raghav','789 28th Street','Memphis','TN','99999','USA',40.0000,0.0000,'Credit Card','2006-06-07 00:00:00',NULL,0,NULL,3),(73,7,9,'2006-06-04 16:00:00','2006-06-05 00:00:00',1,'Sven Mortensen','123 9th Street','Salt Lake City','UT','99999','USA',100.0000,0.0000,'Check','2006-06-05 00:00:00',NULL,0,NULL,3),(74,6,6,'2006-06-07 16:00:00','2006-06-08 00:00:00',2,'Francisco Pérez-Olaeta','123 6th Street','Milwaukee','WI','99999','USA',300.0000,0.0000,'Credit Card','2006-06-08 00:00:00',NULL,0,NULL,3),(75,4,8,'2006-06-04 16:00:00','2006-06-05 00:00:00',2,'Elizabeth Andersen','123 8th Street','Portland','OR','99999','USA',50.0000,0.0000,'Check','2006-06-05 00:00:00',NULL,0,NULL,3),(76,9,25,'2006-06-04 16:00:00','2006-06-05 00:00:00',1,'John Rodman','789 25th Street','Chicago','IL','99999','USA',5.0000,0.0000,'Cash','2006-06-05 00:00:00',NULL,0,NULL,3),(77,9,26,'2006-06-04 16:00:00','2006-06-05 00:00:00',3,'Run Liu','789 26th Street','Miami','FL','99999','USA',60.0000,0.0000,'Credit Card','2006-06-05 00:00:00',NULL,0,NULL,3),(78,1,29,'2006-06-04 16:00:00','2006-06-05 00:00:00',2,'Soo Jung Lee','789 29th Street','Denver','CO','99999','USA',200.0000,0.0000,'Check','2006-06-05 00:00:00',NULL,0,NULL,3),(79,2,6,'2006-06-22 16:00:00','2006-06-23 00:00:00',3,'Francisco Pérez-Olaeta','123 6th Street','Milwaukee','WI','99999','USA',0.0000,0.0000,'Check','2006-06-23 00:00:00',NULL,0,NULL,3),(80,2,4,'2006-04-25 09:03:55',NULL,NULL,'Christina Lee','123 4th Street','New York','NY','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(81,2,3,'2006-04-25 09:26:53',NULL,NULL,'Thomas Axen','123 3rd Street','Los Angelas','CA','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0),(82,2,2,'2011-11-07 04:55:03',NULL,NULL,'Antonio Gratacos Solsona','123 2nd Street','Boston','MA','99999','USA',0.0000,0.0000,NULL,NULL,NULL,0,NULL,0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `orders summary`
--

DROP TABLE IF EXISTS `orders summary`;
/*!50001 DROP VIEW IF EXISTS `orders summary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `orders summary` (
  `ordersId` int(10),
  `employeesId` int(10),
  `customersId` int(10),
  `ordersDate` timestamp,
  `ordersShippedDate` datetime,
  `Sub Total` double,
  `ordersShippingFee` decimal(19,4),
  `ordersTaxes` decimal(19,4),
  `Order Total` double,
  `ordersShipName` varchar(50),
  `ordersShipAddress` longtext,
  `ordersPaidDate` datetime,
  `Status` varchar(50)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ordersdetails`
--

DROP TABLE IF EXISTS `ordersdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordersdetails` (
  `orderDetailsId` int(10) NOT NULL AUTO_INCREMENT,
  `ordersId` int(10) NOT NULL,
  `productsId` int(10) DEFAULT NULL,
  `ordersDetailsQuantity` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `ordersDetailsUnitPrice` decimal(19,4) DEFAULT NULL,
  `ordersDetailsDiscount` double NOT NULL DEFAULT '0',
  `ordersDetailsStatusId` int(10) DEFAULT NULL,
  `ordersDetailsDateAllocated` datetime DEFAULT NULL,
  `purchaseOrdersId` int(10) DEFAULT NULL,
  `inventoryId` int(10) DEFAULT NULL,
  PRIMARY KEY (`orderDetailsId`),
  KEY `ID` (`orderDetailsId`),
  KEY `Inventory ID` (`inventoryId`),
  KEY `New_OrderDetails` (`ordersId`),
  KEY `New_OrderStatusLookup` (`ordersDetailsStatusId`),
  KEY `New_ProductsOnOrders` (`productsId`),
  KEY `OrderDetails` (`ordersId`),
  KEY `OrderID` (`ordersId`),
  KEY `OrderStatusLookup` (`ordersDetailsStatusId`),
  KEY `ProductID` (`productsId`),
  KEY `ProductsOnOrders` (`productsId`),
  KEY `Purchase Order ID` (`purchaseOrdersId`),
  KEY `Status ID` (`ordersDetailsStatusId`),
  CONSTRAINT `ordersdetails_ibfk_24` FOREIGN KEY (`ordersId`) REFERENCES `orders` (`ordersId`),
  CONSTRAINT `ordersdetails_ibfk_25` FOREIGN KEY (`productsId`) REFERENCES `products` (`productsId`),
  CONSTRAINT `ordersdetails_ibfk_26` FOREIGN KEY (`purchaseOrdersId`) REFERENCES `purchaseorders` (`purchaseOrdersId`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordersdetails`
--

LOCK TABLES `ordersdetails` WRITE;
/*!40000 ALTER TABLE `ordersdetails` DISABLE KEYS */;
INSERT INTO `ordersdetails` VALUES (27,30,34,100.0000,14.0000,0,2,NULL,96,83),(28,30,80,30.0000,3.5000,0,2,NULL,NULL,63),(29,31,7,10.0000,30.0000,0,2,NULL,NULL,64),(30,31,51,10.0000,53.0000,0,2,NULL,NULL,65),(31,31,80,10.0000,3.5000,0,2,NULL,NULL,66),(32,32,1,15.0000,18.0000,0,2,NULL,NULL,67),(33,32,43,20.0000,46.0000,0,2,NULL,NULL,68),(34,33,19,30.0000,9.2000,0,2,NULL,97,81),(35,34,19,20.0000,9.2000,0,2,NULL,NULL,69),(36,35,48,10.0000,12.7500,0,2,NULL,NULL,70),(37,36,41,200.0000,9.6500,0,2,NULL,98,79),(38,37,8,17.0000,40.0000,0,2,NULL,NULL,71),(39,38,43,300.0000,46.0000,0,2,NULL,99,77),(40,39,48,100.0000,12.7500,0,2,NULL,100,75),(41,40,81,200.0000,2.9900,0,2,NULL,101,73),(42,41,43,300.0000,46.0000,0,1,NULL,102,104),(43,42,6,10.0000,25.0000,0,2,NULL,NULL,84),(44,42,4,10.0000,22.0000,0,2,NULL,NULL,85),(45,42,19,10.0000,9.2000,0,2,NULL,103,110),(46,43,80,20.0000,3.5000,0,1,NULL,NULL,86),(47,43,81,50.0000,2.9900,0,1,NULL,NULL,87),(48,44,1,25.0000,18.0000,0,1,NULL,NULL,88),(49,44,43,25.0000,46.0000,0,1,NULL,NULL,89),(50,44,81,25.0000,2.9900,0,1,NULL,NULL,90),(51,45,41,50.0000,9.6500,0,2,NULL,104,116),(52,45,40,50.0000,18.4000,0,2,NULL,NULL,91),(53,46,57,100.0000,19.5000,0,2,NULL,105,101),(54,46,72,50.0000,34.8000,0,2,NULL,106,114),(55,47,34,300.0000,14.0000,0,2,NULL,107,108),(56,48,8,25.0000,40.0000,0,2,NULL,108,106),(57,48,19,25.0000,9.2000,0,2,NULL,109,112),(59,50,21,20.0000,10.0000,0,2,NULL,NULL,92),(60,51,5,25.0000,21.3500,0,2,NULL,NULL,93),(61,51,41,30.0000,9.6500,0,2,NULL,NULL,94),(62,51,40,30.0000,18.4000,0,2,NULL,NULL,95),(66,56,48,10.0000,12.7500,0,2,NULL,111,99),(67,55,34,87.0000,14.0000,0,2,NULL,NULL,117),(68,79,7,30.0000,30.0000,0,2,NULL,NULL,119),(69,79,51,30.0000,53.0000,0,2,NULL,NULL,118),(70,78,17,40.0000,39.0000,0,2,NULL,NULL,120),(71,77,6,90.0000,25.0000,0,2,NULL,NULL,121),(72,76,4,30.0000,22.0000,0,2,NULL,NULL,122),(73,75,48,40.0000,12.7500,0,2,NULL,NULL,123),(74,74,48,40.0000,12.7500,0,2,NULL,NULL,124),(75,73,41,10.0000,9.6500,0,2,NULL,NULL,125),(76,72,43,5.0000,46.0000,0,2,NULL,NULL,126),(77,71,40,40.0000,18.4000,0,2,NULL,NULL,127),(78,70,8,20.0000,40.0000,0,2,NULL,NULL,128),(79,69,80,15.0000,3.5000,0,2,NULL,NULL,129),(80,67,74,20.0000,10.0000,0,2,NULL,NULL,130),(81,60,72,40.0000,34.8000,0,2,NULL,NULL,131),(82,63,3,50.0000,10.0000,0,2,NULL,NULL,132),(83,63,8,3.0000,40.0000,0,2,NULL,NULL,133),(84,58,20,40.0000,81.0000,0,2,NULL,NULL,134),(85,58,52,40.0000,7.0000,0,2,NULL,NULL,135),(86,80,56,10.0000,38.0000,0,1,NULL,NULL,136),(90,81,81,0.0000,2.9900,0,5,NULL,NULL,NULL),(91,81,56,0.0000,38.0000,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ordersdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordersdetailsstatus`
--

DROP TABLE IF EXISTS `ordersdetailsstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordersdetailsstatus` (
  `ordersDetailsStatusId` int(10) NOT NULL,
  `ordersDetailsStatusName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ordersDetailsStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordersdetailsstatus`
--

LOCK TABLES `ordersdetailsstatus` WRITE;
/*!40000 ALTER TABLE `ordersdetailsstatus` DISABLE KEYS */;
INSERT INTO `ordersdetailsstatus` VALUES (0,'None'),(1,'Allocated'),(2,'Invoiced'),(3,'Shipped'),(4,'On Order'),(5,'No Stock');
/*!40000 ALTER TABLE `ordersdetailsstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordersstatus`
--

DROP TABLE IF EXISTS `ordersstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordersstatus` (
  `ordersStatusId` smallint(5) NOT NULL,
  `ordersStatusName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ordersStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordersstatus`
--

LOCK TABLES `ordersstatus` WRITE;
/*!40000 ALTER TABLE `ordersstatus` DISABLE KEYS */;
INSERT INTO `ordersstatus` VALUES (0,'New'),(1,'Invoiced'),(2,'Shipped'),(3,'Closed');
/*!40000 ALTER TABLE `ordersstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderstaxstatus`
--

DROP TABLE IF EXISTS `orderstaxstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderstaxstatus` (
  `ordersTaxStatusId` smallint(5) NOT NULL,
  `ordersTaxStatusName` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ordersTaxStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderstaxstatus`
--

LOCK TABLES `orderstaxstatus` WRITE;
/*!40000 ALTER TABLE `orderstaxstatus` DISABLE KEYS */;
INSERT INTO `orderstaxstatus` VALUES (0,'Tax Exempt'),(1,'Taxable');
/*!40000 ALTER TABLE `orderstaxstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privileges` (
  `privilegeId` int(10) NOT NULL AUTO_INCREMENT,
  `privilegeName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`privilegeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privileges`
--

LOCK TABLES `privileges` WRITE;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
INSERT INTO `privileges` VALUES (2,'Purchase Approvals');
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;
UNLOCK TABLES;
