-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: iCommon
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
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank` (
  `bankId` int(11) NOT NULL AUTO_INCREMENT,
  `bankSequence` int(11) NOT NULL,
  `bankCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `bankSwiftCode` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `bankSwiftCodeCity` varchar(128) CHARACTER SET latin1 NOT NULL,
  `bankSwiftCodeBranch` varchar(128) CHARACTER SET latin1 NOT NULL,
  `bankMepsCode` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `bankDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`bankId`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank`
--

LOCK TABLES `bank` WRITE;
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
INSERT INTO `bank` VALUES (1,0,' ','Swift Code','','','Swift Co','Bank or Institution',0,0,0,0,1,0,0,0,0,2,'2011-11-22 04:46:34'),(2,0,' ','ABNAMY2AXXX','','','ABNAMY2A','ABN AMRO BANK N.V.',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(3,0,' ','PHBMMYKLXXX','','','PHBMMYKL','AFFIN BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(4,0,' ','AIBBMYKLXXX','','','AIBBMYKL','AFFIN ISLAMIC BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(5,0,' ','RJHIMYKLXXX','','','RJHIMYKL','AL RAJHI BANKING AND INVESTMENT CORPORATION (MALAYSIA) BHD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(6,0,' ','MFBBMYKLXXX','','','MFBBMYKL','ALLIANCE BANK MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(7,0,' ','ARBKMYKLXXX','','','ARBKMYKL','AMBANK (M) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(8,0,' ','AMMBMYKLXXX','','','AMMBMYKL','AMINVESTMENT BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(9,0,' ','AISLMYKLXXX','','','AISLMYKL','AMISLAMIC BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(10,0,' ','AFBQMYKLXXX','','','AFBQMYKL','ASIAN FINANCE BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(11,0,' ','BKKBMYKLXXX','','','BKKBMYKL','BANGKOK BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(12,0,' ','BIMBMYKLXXX','','','BIMBMYKL','BANK ISLAM MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(13,0,' ','BISLMYKAXXX','','','BISLMYKA','BANK ISLAM MALAYSIA BERHAD LABUAN OFFSHORE BRANCH',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(14,0,' ','BMMBMYKLXXX','','','BMMBMYKL','BANK MUAMALAT MALAYSIA BERHAD (6175-W)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(15,0,' ','BNMAMYKLXXX','','','BNMAMYKL','BANK NEGARA MALAYSIA',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(16,0,' ','BOFAMY2XXXX','','','BOFAMY2X','BANK OF AMERICA, MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(17,0,' ','BOFAMY2XLBN','','','BOFAMY2X','BANK OF AMERICA, MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(18,0,' ','BKCHMYKLXXX','','','BKCHMYKL','BANK OF CHINA (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(19,0,' ','NOSCMYKLXXX','','','NOSCMYKL','BANK OF NOVA SCOTIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(20,0,' ','NOSCMY2LXXX','','','NOSCMY2L','BANK OF NOVA SCOTIA, THE',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(21,0,' ','BOTKMYKXXXX','','','BOTKMYKX','BANK OF TOKYO-MITSUBISHI UFJ (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(22,0,' ','BOTKMYKAXXX','','','BOTKMYKA','BANK OF TOKYO-MITSUBISHI UFJ, LTD., THE',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(23,0,' ','BNPAMYKAXXX','','','BNPAMYKA','BNP PARIBAS',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(24,0,' ','CIBBMYKAXXX','','','CIBBMYKA','CIMB BANK (L) LIMITED',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(25,0,' ','CIBBMYKLXXX','','','CIBBMYKL','CIMB BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(26,0,' ','COIMMYKLXXX','','','COIMMYKL','CIMB INVESTMENT BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(27,0,' ','CTBBMYKLXXX','','','CTBBMYKL','CIMB ISLAMIC BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(28,0,' ','CITIMYKLPEN','','','CITIMYKL','CITIBANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(29,0,' ','CITIMYKLJOD','','','CITIMYKL','CITIBANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(30,0,' ','CITIMYKLXXX','','','CITIMYKL','CITIBANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(31,0,' ','CITIMYKLLAB','','','CITIMYKL','CITIBANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(32,0,' ','DBSSMY2AXXX','','','DBSSMY2A','DBS BANK LTD, LABUAN BRANCH',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(33,0,' ','DEUTMYKLGMO','','','DEUTMYKL','DEUTSCHE BANK (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(34,0,' ','DEUTMYKLISB','','','DEUTMYKL','DEUTSCHE BANK (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(35,0,' ','DEUTMYKLXXX','','','DEUTMYKL','DEUTSCHE BANK (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(36,0,' ','DEUTMYKLBLB','','','DEUTMYKL','DEUTSCHE BANK (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(37,0,' ','EOBBMYKLXXX','','','EOBBMYKL','EON BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(38,0,' ','EIBBMYKLXXX','','','EIBBMYKL','EONCAP ISLAMIC BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(39,0,' ','EXMBMYKLXXX','','','EXMBMYKL','EXPORT-IMPORT BANK OF MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(40,0,' ','FEEBMYKAXXX','','','FEEBMYKA','FIRST EAST EXPORT BANK',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(41,0,' ','HLBBMYKLJBU','','','HLBBMYKL','HONG LEONG BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(42,0,' ','HLBBMYKLIBU','','','HLBBMYKL','HONG LEONG BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(43,0,' ','HLBBMYKLXXX','','','HLBBMYKL','HONG LEONG BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(44,0,' ','HLBBMYKLKCH','','','HLBBMYKL','HONG LEONG BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(45,0,' ','HLBBMYKLPNG','','','HLBBMYKL','HONG LEONG BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(46,0,' ','HLIBMYKLXXX','','','HLIBMYKL','HONG LEONG ISLAMIC BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(47,0,' ','HSBCMYKAXXX','','','HSBCMYKA','HONGKONG AND SHANGHAI BANKING CORPORATION LTD.,THE',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(48,0,' ','HSTMMYKLGWS','','','HSTMMYKL','HSBC (MALAYSIA) TRUSTEE BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(49,0,' ','HSTMMYKLXXX','','','HSTMMYKL','HSBC (MALAYSIA) TRUSTEE BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(50,0,' ','HMABMYKLXXX','','','HMABMYKL','HSBC AMANAH MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(51,0,' ','HBMBMYKLXXX','','','HBMBMYKL','HSBC BANK MALAYSIA BERHAD, MALAYSIA',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(52,0,' ','HDSBMY2PXXX','','','HDSBMY2P','HWANGDBS INVESTMENT BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(53,0,' ','HDSBMY2PSEL','','','HDSBMY2P','HWANGDBS INVESTMENT BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(54,0,' ','CHASMYKXKEY','','','CHASMYKX','J.P.MORGAN CHASE BANK BERHAD, KUALA LUMPUR',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(55,0,' ','CHASMYKXXXX','','','CHASMYKX','J.P.MORGAN CHASE BANK BERHAD, KUALA LUMPUR',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(56,0,' ','KAFBMYKLXXX','','','KAFBMYKL','KAF INVESTMENT BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(57,0,' ','KFHOMYKLXXX','','','KFHOMYKL','KUWAIT FINANCE HOUSE (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(58,0,' ','MBBEMYKLBWC','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(59,0,' ','MBBEMYKLIPH','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(60,0,' ','MBBEMYKLJOB','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(61,0,' ','MBBEMYKLKIN','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(62,0,' ','MBBEMYKLBAN','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(63,0,' ','MBBEMYKLBBG','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(64,0,' ','MBBEMYKLCSD','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(65,0,' ','MBBEMYKLKEP','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(66,0,' ','MBBEMYKLPUD','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(67,0,' ','MBBEMYKLSUB','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(68,0,' ','MBBEMYKLKLC','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(69,0,' ','MBBEMYKLWSD','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(70,0,' ','MBBEMYKLXXX','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(71,0,' ','MBBEMYKLMAL','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(72,0,' ','MBBEMYKLPSG','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(73,0,' ','MBBEMYKLPGC','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(74,0,' ','MBBEMYKLPEN','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(75,0,' ','MBBEMYKLPJC','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(76,0,' ','MBBEMYKLYSL','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(77,0,' ','MBBEMYKLPJY','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(78,0,' ','MBBEMYKLPKG','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(79,0,' ','MBBEMYKLSBN','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(80,0,' ','MBBEMYKLSAC','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(81,0,' ','MBBEMYKLSHA','','','MBBEMYKL','MALAYAN BANKING BERHAD (MAYBANK)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(82,0,' ','MBBEMYKAXXX','','','MBBEMYKA','MAYBANK INTERNATIONAL (L) LTD.',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(83,0,' ','DABEMYKLXXX','','','DABEMYKL','MERCEDES-BENZ MALAYSIA SDN. BHD.',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(84,0,' ','MHCBMYKAXXX','','','MHCBMYKA','MIZUHO CORPORATE BANK, LTD., LABUAN BRANCH',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(85,0,' ','OABBMYKLXXX','','','OABBMYKL','OCBC AL-AMIN BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(86,0,' ','OCBCMYKLXXX','','','OCBCMYKL','OCBC BANK (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(87,0,' ','OSKIMYKLXXX','','','OSKIMYKL','OSK INVESTMENT BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(88,0,' ','PERMMYKLXXX','','','PERMMYKL','PERMODALAN NASIONAL BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(89,0,' ','PTROMYKLFSD','','','PTROMYKL','PETROLIAM NASIONAL BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(90,0,' ','PTROMYKLXXX','','','PTROMYKL','PETROLIAM NASIONAL BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(91,0,' ','PCGLMYKLXXX','','','PCGLMYKL','PETRONAS CARIGALI SDN BHD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(92,0,' ','PTRDMYKLXXX','','','PTRDMYKL','PETRONAS TRADING CORPORATION SDN. BHD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(93,0,' ','PBLLMYKAXXX','','','PBLLMYKA','PUBLIC BANK (L) LTD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(94,0,' ','PBBEMYKLXXX','','','PBBEMYKL','PUBLIC BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(95,0,' ','RHBBMYKAXXX','','','RHBBMYKA','RHB BANK (L) LTD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(96,0,' ','RHBBMYKLXXX','','','RHBBMYKL','RHB BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(97,0,' ','RHBAMYKLXXX','','','RHBAMYKL','RHB ISLAMIC BANK BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(98,0,' ','SCBLMYKXXXX','','','SCBLMYKX','STANDARD CHARTERED BANK MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(99,0,' ','SCBLMYKXLAB','','','SCBLMYKX','STANDARD CHARTERED BANK MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(100,0,' ','SMBCMYKAXXX','','','SMBCMYKA','SUMITOMO MITSUI BANKING CORPORATION',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(101,0,' ','ABNAMYKLXXX','','','ABNAMYKL','THE ROYAL BANK OF SCOTLAND BERHAD (301932-A)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(102,0,' ','ABNAMYKLPNG','','','ABNAMYKL','THE ROYAL BANK OF SCOTLAND BERHAD (301932-A)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(103,0,' ','UIIBMYKLXXX','','','UIIBMYKL','UNICORN INTERNATIONAL ISLAMIC BANK MALAYSIA BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(104,0,' ','UOVBMYKLCND','','','UOVBMYKL','UNITED OVERSEAS BANK (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(105,0,' ','UOVBMYKLXXX','','','UOVBMYKL','UNITED OVERSEAS BANK (MALAYSIA) BERHAD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 04:46:34'),(106,0,'k1x','k2x','k3x','k4x','','k5x',0,0,0,0,1,0,0,0,0,2,'2011-11-22 16:44:02');
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `countryId` int(11) NOT NULL AUTO_INCREMENT,
  `countrySequence` int(11) NOT NULL,
  `countryCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `countryCurrencyCode` varchar(4) CHARACTER SET latin1 NOT NULL,
  `countryDesc` text COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`countryId`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,0,'AF','','AFGHANISTAN',0,1,0,0,0,1,0,0,0,2,127),(2,0,'AL','','ALBANIA',0,1,0,0,0,1,0,0,0,2,127),(3,0,'DZ','','ALGERIA',0,1,0,0,0,1,0,0,0,2,127),(4,0,'AS','','AMERICAN SAMOA',0,1,0,0,0,1,0,0,0,2,127),(5,0,'AD','','ANDORRA',0,1,0,0,0,1,0,0,0,2,127),(6,0,'AO','','ANGOLA',0,1,0,0,0,1,0,0,0,2,127),(7,0,'AI','','ANGUILLA',0,1,0,0,0,1,0,0,0,2,127),(8,0,'AQ','','ANTARCTICA',0,1,0,0,0,1,0,0,0,2,127),(9,0,'AG','','ANTIGUA AND BARBUDA',0,1,0,0,0,1,0,0,0,2,127),(10,0,'AR','','ARGENTINA',0,1,0,0,0,1,0,0,0,2,127),(11,0,'AM','','ARMENIA',0,1,0,0,0,1,0,0,0,2,127),(12,0,'AW','','ARUBA',0,1,0,0,0,1,0,0,0,2,127),(13,0,'AU','','AUSTRALIA',0,1,0,0,0,1,0,0,0,2,127),(14,0,'AT','','AUSTRIA',0,1,0,0,0,1,0,0,0,2,127),(15,0,'AZ','','AZERBAIJAN',0,1,0,0,0,1,0,0,0,2,127),(16,0,'BS','','BAHAMAS',0,1,0,0,0,1,0,0,0,2,127),(17,0,'BH','','BAHRAIN',0,1,0,0,0,1,0,0,0,2,127),(18,0,'BD','','BANGLADESH',0,1,0,0,0,1,0,0,0,2,127),(19,0,'BB','','BARBADOS',0,1,0,0,0,1,0,0,0,2,127),(20,0,'BY','','BELARUS',0,1,0,0,0,1,0,0,0,2,127),(21,0,'FR','','FRANCE',0,1,0,0,0,1,0,0,0,2,127),(22,0,'HK','','HONG KONG',0,1,0,0,0,1,0,0,0,2,127),(23,0,'KZ','','KAZAKHSTAN',0,1,0,0,0,1,0,0,0,2,127),(24,0,'MY','','MALAYSIA',0,1,0,0,0,1,0,0,0,2,127),(25,0,'MM','','MYANMAR',0,1,0,0,0,1,0,0,0,2,127),(26,0,'NZ','','NEW ZEALAND',0,1,0,0,0,1,0,0,0,2,127),(27,0,'SE','','SWEDEN',0,1,0,0,0,1,0,0,0,2,127),(28,0,'CH','','SWITZERLAND',0,1,0,0,0,1,0,0,0,2,127),(29,0,'TH','','THAILAND',0,1,0,0,0,1,0,0,0,2,127),(30,0,'US','','UNITED STATES',0,1,0,0,0,1,0,0,0,2,127),(31,0,'YU','','YUGOSLAVIA',0,1,0,0,0,1,0,0,0,2,127);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disease`
--

DROP TABLE IF EXISTS `disease`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disease` (
  `diseaseId` int(11) NOT NULL AUTO_INCREMENT,
  `diseaseSequence` int(11) NOT NULL,
  `diseaseCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `diseaseDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`diseaseId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disease`
--

LOCK TABLES `disease` WRITE;
/*!40000 ALTER TABLE `disease` DISABLE KEYS */;
INSERT INTO `disease` VALUES (1,0,' ','Tiada Penyakit',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(2,0,' ','Lelah(Asma)',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(3,0,' ','Darah Tinggi',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(4,0,' ','Sakit Jantung',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(5,0,' ','Kencing Manis',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(6,0,' ','Barah',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(7,0,' ','Buah Pinggan',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(8,0,' ','Sakit Tua',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33'),(9,0,' ','lain-lain',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:33');
/*!40000 ALTER TABLE `disease` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `districtId` int(11) NOT NULL AUTO_INCREMENT,
  `districtSequence` int(11) NOT NULL,
  `districtCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `districtDesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `countryId` int(11) NOT NULL,
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
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`districtId`),
  KEY `state_uniqueId` (`stateId`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (1,0,'','Timur Laut P.Pinang',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(2,0,'','Seberang Prai Utara',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(3,0,'','Seberang Prai Tengah',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(4,0,'','Seberang Prai Selatan',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(5,0,'','Bukit Mertajam',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(6,0,'','Balik Pulau',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(7,0,'','Seberang Jaya',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(8,0,'','Kepala Batas',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(9,0,'','Kinta',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(10,0,'','Larut',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(11,0,'','Matang',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(12,0,'','Selama',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(13,0,'','Hilir Perak',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(14,0,'','Manjung',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(15,0,'','Batang Padang',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(16,0,'','Batu Gajah',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(17,0,'','Sg. Siput',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(18,0,'','Lambor Kanan',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(19,0,'','Seri Manjung',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(20,0,'','Grik',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(21,0,'','Slim River',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(22,0,'','Kampar',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(23,0,'','Kerian',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(24,0,'','Kuala Kangsar',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(25,0,'','Hulu Perak',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(26,0,'','Parit Buntar',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(27,0,'','Perak Tengah',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(28,0,'','Ipoh',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(29,0,'','Tapah',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(30,0,'','Teluk Intan',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(31,0,'','Taiping',24,2,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(32,0,'','Gombak',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(33,0,'','Hulu Langat',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(34,0,'','Hulu Selangor',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(35,0,'','Klang',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(36,0,'','Kuala Langat',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(37,0,'','Kuala Selangor',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(38,0,'','Petaling Jaya',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(39,0,'','Sabak Bernam',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(40,0,'','Sepang',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(41,0,'','Shah Alam',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(42,0,'','Putrajaya',24,5,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(43,0,'','Jelebu',24,6,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(44,0,'','Jempol',24,6,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(45,0,'','Kuala Pilah',24,6,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(46,0,'','Port Dickson',24,6,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(47,0,'','Rembau',24,6,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(48,0,'','Seremban',24,6,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(49,0,'','Tampin',24,6,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(50,0,'','Alor Gajah',24,7,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(51,0,'','Central Melaka',24,7,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(52,0,'','Jasin',24,7,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(53,0,'','Melaka Town',24,7,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(54,0,'','Batu Pahat',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(55,0,'','Johor Bharu',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(56,0,'','Kluang',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(57,0,'','Kota Tinggi',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(58,0,'','Kulai',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(59,0,'','Mersing',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(60,0,'','Muar',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(61,0,'','Pontian',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(62,0,'','Segamat',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(63,0,'','Tangkak',24,8,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(64,0,'','Bera',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(65,0,'','Bentong',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(66,0,'','Cameron Highlands',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(67,0,'','Jengka',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(68,0,'','Jerantut',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(69,0,'','Kuantan',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(70,0,'','Kuala Lipis',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(71,0,'','Maran',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(72,0,'','Mentakab',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(73,0,'','Muadzam',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(74,0,'','Pekan',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(75,0,'','Raub',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(76,0,'','Rompin',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(77,0,'','Temerloh',24,9,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(78,0,'','Besut',24,10,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(79,0,'','Dungun',24,10,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(80,0,'','Hulu Terengganu',24,10,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(81,0,'','Kemaman',24,10,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(82,0,'','Kuala Terengganu',24,10,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(83,0,'','Marang',24,10,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(84,0,'','Setiu',24,10,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(93,0,'','Bandar Tun Razak',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(94,0,'','Batu',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(95,0,'','Bukit Bintang',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(96,0,'','Cheras',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(97,0,'','Kepong',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(98,0,'','Lembah Pantai',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(99,0,'','Segamat',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(100,0,'','Seputeh',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(101,0,'','Setiawangsa',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(102,0,'','Titiwangsa',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(103,0,'','Wangsa Maju',24,4,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(104,0,'','Bachok',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(105,0,'','Gua Musang',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(106,0,'','Jeli',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(107,0,'','Kota Bharu',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(108,0,'','Kuala Krai',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(109,0,'','Machang',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(110,0,'','Pasir Mas',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(111,0,'','Pasir Puteh',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(112,0,'','Tanah Merah',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(113,0,'','Tumpat',24,11,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(114,0,'','Pantai Barat',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(115,0,'','Kudat',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(116,0,'','Sandakan',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(117,0,'','Tawau',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(118,0,'','Pedalaman',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(119,0,'','Kota Kinabalu',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(120,0,'','Beaufort',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(121,0,'','Beluran',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(122,0,'','Keningau',24,12,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(123,0,'','labuan',24,13,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(124,0,'','Betong',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(125,0,'','Bintulu',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(126,0,'','Kapit',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(127,0,'','Kuching',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(128,0,'','Limbang',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(129,0,'','Miri',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(130,0,'','Mukah',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(131,0,'','Samarahan',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(132,0,'','Sarikei',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(133,0,'','Sri Aman',24,14,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(134,0,'','Arau',24,15,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(135,0,'','Chuping',24,15,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(136,0,'','Kuala Perlis',24,15,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(137,0,'','Sanglang',24,15,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(138,0,'','Kangar',24,15,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(139,0,'','Alor Setar',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(140,0,'','Baling',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(141,0,'','Bandar Bharu',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(142,0,'','Jitra',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(143,0,'','Kuala Muda',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(144,0,'','Kubang Pasu',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(145,0,'','Kuala Nerang',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(146,0,'','Kulim',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(147,0,'','Langkawi',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(148,0,'','Sik',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(149,0,'','Yan',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(150,0,'','Sungai Petani',24,16,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(151,0,'','Kajang',24,3,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(152,0,'','Barat Daya P.Pinang',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(153,0,'','Georgetown',24,1,0,0,0,0,0,1,0,0,0,2,'0000-00-00 00:00:00'),(154,0,'','kambing',24,1,0,1,0,0,0,1,0,0,0,2,'2011-11-21 21:54:35'),(155,0,'','kambingx',24,1,0,1,0,0,0,1,0,0,0,2,'2011-11-21 21:55:10'),(156,0,'','kucingx',24,1,0,1,0,0,0,1,0,0,0,2,'2011-11-21 21:56:12'),(157,0,'','78',24,7,0,0,0,1,0,1,0,0,0,2,'2011-11-21 22:21:35');
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `education` (
  `educationId` int(11) NOT NULL AUTO_INCREMENT,
  `educationSequence` int(11) NOT NULL,
  `educationCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `educationDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`educationId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` VALUES (1,0,' ','Tidak Bersekolah',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(2,0,' ','Pra Persekolahan',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(3,0,' ','Sekolah Rendah/Setaraf',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(4,0,' ','Menengah Rendah/Setaraf',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(5,0,' ','Menengah Tinggi/Setaraf',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(6,0,' ','Kolej',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(7,0,' ','Maktab',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(8,0,' ','Diploma',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(9,0,' ','Ijazah',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29'),(10,0,' ','PHD',0,1,0,0,0,1,0,0,0,2,'2011-11-22 11:20:29');
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `family`
--

DROP TABLE IF EXISTS `family`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `family` (
  `familyId` int(11) NOT NULL AUTO_INCREMENT,
  `familyCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `familyDesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `family`
--

LOCK TABLES `family` WRITE;
/*!40000 ALTER TABLE `family` DISABLE KEYS */;
INSERT INTO `family` VALUES (1,'','SUAMI',0,1,0,0,0,1,0,0,0,2,127),(2,'','ISTERI',0,1,0,0,0,1,0,0,0,2,127),(3,'','BAPA',0,1,0,0,0,1,0,0,0,2,127),(4,'','IBU',0,1,0,0,0,1,0,0,0,2,127),(5,'','ANAK',0,1,0,0,0,1,0,0,0,2,127),(6,'','BAPA SAUDARA',0,1,0,0,0,1,0,0,0,2,127),(7,'','IBU SAUDARA',0,1,0,0,0,1,0,0,0,2,127),(8,'','ANAK ANGKAT',0,1,0,0,0,1,0,0,0,2,127),(9,'','BAPA MERTUA',0,1,0,0,0,1,0,0,0,2,127),(10,'','IBU MERTUA',0,1,0,0,0,1,0,0,0,2,127),(11,'','ANAK SAUDARA',0,1,0,0,0,1,0,0,0,2,127),(12,'','CUCU',0,1,0,0,0,1,0,0,0,2,127),(13,'','NENEK',0,1,0,0,0,1,0,0,0,2,127),(14,'','DATUK',0,1,0,0,0,1,0,0,0,2,127),(15,'','SEPUPU',0,1,0,0,0,1,0,0,0,2,127),(16,'','ABANG',0,1,0,0,0,1,0,0,0,2,127),(17,'','KAKAK',0,1,0,0,0,1,0,0,0,2,127),(18,'','ADIK',0,1,0,0,0,1,0,0,0,2,127),(19,'','MENANTU',0,1,0,0,0,1,0,0,0,2,127),(20,'','ANAK TIRI',0,1,0,0,0,1,0,0,0,2,127),(21,'','TIADA',0,1,0,0,0,1,0,0,0,2,127);
/*!40000 ALTER TABLE `family` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gender` (
  `genderId` int(11) NOT NULL AUTO_INCREMENT,
  `genderSequence` int(11) NOT NULL,
  `genderCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `genderDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`genderId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gender`
--

LOCK TABLES `gender` WRITE;
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` VALUES (1,1,'M','Lelaki',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:58'),(2,2,'F','Perempuan',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:58');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impair`
--

DROP TABLE IF EXISTS `impair`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `impair` (
  `impairId` int(11) NOT NULL AUTO_INCREMENT,
  `impairSequence` int(11) NOT NULL,
  `impairCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `impairDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`impairId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impair`
--

LOCK TABLES `impair` WRITE;
/*!40000 ALTER TABLE `impair` DISABLE KEYS */;
INSERT INTO `impair` VALUES (1,0,' ','Tidak Cacat',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08'),(2,0,' ','Buta',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08'),(3,0,' ','Kurang Penglihatan',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08'),(4,0,' ','Pekak',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08'),(5,0,' ','Kurang Pendengaran',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08'),(6,0,' ','Tidak Bergerak Bebas',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08'),(7,0,' ','Cacat Akal/Jiwa',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08'),(8,0,' ','Lain-lain',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:08');
/*!40000 ALTER TABLE `impair` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marriage`
--

DROP TABLE IF EXISTS `marriage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marriage` (
  `marriageId` int(11) NOT NULL AUTO_INCREMENT,
  `marriageSequence` int(11) NOT NULL,
  `marriageCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `marriageDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`marriageId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marriage`
--

LOCK TABLES `marriage` WRITE;
/*!40000 ALTER TABLE `marriage` DISABLE KEYS */;
INSERT INTO `marriage` VALUES (1,0,' ','Belum Berkahwin',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:51'),(2,0,' ','Berkahwin',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:51'),(3,0,' ','Duda',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:51'),(4,0,' ','Janda',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:51'),(5,0,' ','Balu',0,1,0,0,0,1,0,0,0,2,'2011-11-22 17:38:51');
/*!40000 ALTER TABLE `marriage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race`
--

DROP TABLE IF EXISTS `race`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race` (
  `raceId` int(11) NOT NULL AUTO_INCREMENT,
  `raceSequence` int(11) NOT NULL,
  `raceCode` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `raceDesc` text COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race`
--

LOCK TABLES `race` WRITE;
/*!40000 ALTER TABLE `race` DISABLE KEYS */;
INSERT INTO `race` VALUES (2,0,'Mela','Melayu',0,1,0,0,0,1,0,0,0,2,127),(3,0,'Cina','Cina',0,1,0,0,0,1,0,0,0,2,127),(4,0,'Inda','India',0,1,0,0,0,1,0,0,0,2,127),(5,0,'Bdyh','Bidayuh',0,1,0,0,0,1,0,0,0,2,127),(6,0,'Meln','Melanau',0,1,0,0,0,1,0,0,0,2,127),(7,0,'Iban','Iban',0,1,0,0,0,1,0,0,0,2,127),(8,0,'Kdzn','Kadazan',0,1,0,0,0,1,0,0,0,2,127),(9,0,'Murt','Murut',0,1,0,0,0,1,0,0,0,2,127),(10,0,'Baja','Bajau',0,1,0,0,0,1,0,0,0,2,127),(12,0,'Keyn','Kedayan',0,1,0,0,0,1,0,0,0,2,127),(15,0,'Sulu','Sulu',0,1,0,0,0,1,0,0,0,2,127),(17,0,'Brni','Brunei',0,1,0,0,0,1,0,0,0,2,127),(18,0,'Bajr','Banjar',0,1,0,0,0,1,0,0,0,2,127),(19,0,'Dusn','Dusun',0,1,0,0,0,1,0,0,0,2,127),(20,0,'Rugs','Rungus',0,1,0,0,0,1,0,0,0,2,127),(21,0,'SiNa','Sino-Native',0,1,0,0,0,1,0,0,0,2,127);
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
  `religionSequence` int(11) NOT NULL,
  `religionCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `religionDesc` text COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `religion`
--

LOCK TABLES `religion` WRITE;
/*!40000 ALTER TABLE `religion` DISABLE KEYS */;
INSERT INTO `religion` VALUES (1,0,'Is','Islam',0,1,0,0,0,1,0,0,0,2,127),(2,0,'Kr','Kristian',0,1,0,0,0,1,0,0,0,2,127),(3,0,'Bu','Budha',0,1,0,0,0,1,0,0,0,2,127),(4,0,'Hi','Hindu',0,1,0,0,0,1,0,0,0,2,127),(5,0,'Co','Confucius',0,1,0,0,0,1,0,0,0,2,127),(6,0,'ASK','Agama Suku Kaum',0,1,0,0,0,1,0,0,0,2,127),(7,0,'Ta','Tiada Agama',0,1,0,0,0,1,0,0,0,2,127),(8,0,'LL','Lain-lain',0,1,0,0,0,1,0,0,0,2,127),(9,0,'kk','jgkgkjgkj',0,1,0,0,0,1,0,0,0,2,127);
/*!40000 ALTER TABLE `religion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salutation`
--

DROP TABLE IF EXISTS `salutation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salutation` (
  `salutationId` int(11) NOT NULL AUTO_INCREMENT,
  `salutationSequence` int(11) NOT NULL,
  `salutationCode` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `salutationDesc` text COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`salutationId`),
  UNIQUE KEY `race_code` (`salutationCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salutation`
--

LOCK TABLES `salutation` WRITE;
/*!40000 ALTER TABLE `salutation` DISABLE KEYS */;
/*!40000 ALTER TABLE `salutation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `stateId` int(11) NOT NULL AUTO_INCREMENT,
  `countryId` int(11) NOT NULL,
  `stateSequence` int(11) NOT NULL,
  `stateCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `stateDesc` text COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`stateId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
INSERT INTO `state` VALUES (1,24,0,'','Pulau Pinang',0,0,0,0,0,1,0,0,0,2,0),(2,24,0,'','Perak',0,0,0,0,0,1,0,0,0,2,0),(3,24,0,'','Selangor',0,0,0,0,0,1,0,0,0,2,0),(4,24,0,'','Wilayah Persekutuan',0,0,0,0,0,1,0,0,0,2,0),(5,24,0,'','Putrajaya',0,0,0,0,0,1,0,0,0,2,0),(6,24,0,'','N. Sembilan',0,0,0,0,0,1,0,0,0,2,0),(7,24,0,'','Melaka',0,0,0,0,0,1,0,0,0,2,0),(8,24,0,'','Johor',0,0,0,0,0,1,0,0,0,2,0),(9,24,0,'','Pahang',0,0,0,0,0,1,0,0,0,2,0),(10,24,0,'','Terengganu',0,0,0,0,0,1,0,0,0,2,0),(11,24,0,'','Kelantan',0,0,0,0,0,1,0,0,0,2,0),(12,24,0,'','Sabah',0,0,0,0,0,1,0,0,0,2,0),(13,24,0,'','W.P Labuan',0,0,0,0,0,1,0,0,0,2,0),(14,24,0,'','Sarawak',0,0,0,0,0,1,0,0,0,2,0),(15,24,0,'','Perlis',0,0,0,0,0,1,0,0,0,2,0),(16,24,0,'','Kedah',0,0,0,0,0,1,0,0,0,2,0);
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

-- Dump completed on 2011-11-27 19:18:39
