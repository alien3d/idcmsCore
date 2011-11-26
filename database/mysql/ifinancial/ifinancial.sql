-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: ifinancial
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
-- Table structure for table `adjustment`
--

DROP TABLE IF EXISTS `adjustment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment` (
  `adjustmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`adjustmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment`
--

LOCK TABLES `adjustment` WRITE;
/*!40000 ALTER TABLE `adjustment` DISABLE KEYS */;
/*!40000 ALTER TABLE `adjustment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustmentdetail`
--

DROP TABLE IF EXISTS `adjustmentdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustmentdetail` (
  `adjustmentDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`adjustmentDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustmentdetail`
--

LOCK TABLES `adjustmentdetail` WRITE;
/*!40000 ALTER TABLE `adjustmentdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `adjustmentdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bankbalance`
--

DROP TABLE IF EXISTS `bankbalance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bankbalance` (
  `bankBalanceId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `bankBalanceCashAmount` double(12,2) NOT NULL,
  `bankBalancechequeAmount` double(12,2) NOT NULL,
  `bankBalanceMonth` int(11) NOT NULL,
  `bankBalanceYear` int(11) NOT NULL,
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
  PRIMARY KEY (`bankBalanceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bankbalance`
--

LOCK TABLES `bankbalance` WRITE;
/*!40000 ALTER TABLE `bankbalance` DISABLE KEYS */;
/*!40000 ALTER TABLE `bankbalance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `businesspartner`
--

DROP TABLE IF EXISTS `businesspartner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `businesspartner` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `businesspartner`
--

LOCK TABLES `businesspartner` WRITE;
/*!40000 ALTER TABLE `businesspartner` DISABLE KEYS */;
/*!40000 ALTER TABLE `businesspartner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `businesspartnercategory`
--

DROP TABLE IF EXISTS `businesspartnercategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `businesspartnercategory` (
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
-- Dumping data for table `businesspartnercategory`
--

LOCK TABLES `businesspartnercategory` WRITE;
/*!40000 ALTER TABLE `businesspartnercategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `businesspartnercategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentnoassign`
--

DROP TABLE IF EXISTS `documentnoassign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentnoassign` (
  `documentNoId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`documentNoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentnoassign`
--

LOCK TABLES `documentnoassign` WRITE;
/*!40000 ALTER TABLE `documentnoassign` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentnoassign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentnocode`
--

DROP TABLE IF EXISTS `documentnocode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentnocode` (
  `documentNoCodeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`documentNoCodeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentnocode`
--

LOCK TABLES `documentnocode` WRITE;
/*!40000 ALTER TABLE `documentnocode` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentnocode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentnosequence`
--

DROP TABLE IF EXISTS `documentnosequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentnosequence` (
  `documentNoSequenceId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`documentNoSequenceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentnosequence`
--

LOCK TABLES `documentnosequence` WRITE;
/*!40000 ALTER TABLE `documentnosequence` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentnosequence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financialduration`
--

DROP TABLE IF EXISTS `financialduration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financialduration` (
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
-- Dumping data for table `financialduration`
--

LOCK TABLES `financialduration` WRITE;
/*!40000 ALTER TABLE `financialduration` DISABLE KEYS */;
/*!40000 ALTER TABLE `financialduration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalledger`
--

DROP TABLE IF EXISTS `generalledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalledger` (
  `generalLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalledger`
--

LOCK TABLES `generalledger` WRITE;
/*!40000 ALTER TABLE `generalledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalledgerbudget`
--

DROP TABLE IF EXISTS `generalledgerbudget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalledgerbudget` (
  `generalLedgerBudgetId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerBudgetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalledgerbudget`
--

LOCK TABLES `generalledgerbudget` WRITE;
/*!40000 ALTER TABLE `generalledgerbudget` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalledgerbudget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalledgerchartofaccount`
--

DROP TABLE IF EXISTS `generalledgerchartofaccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalledgerchartofaccount` (
  `generalLedgerChartOfAccountId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerChartOfAccountId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalledgerchartofaccount`
--

LOCK TABLES `generalledgerchartofaccount` WRITE;
/*!40000 ALTER TABLE `generalledgerchartofaccount` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalledgerchartofaccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalledgerchartofaccountdimension`
--

DROP TABLE IF EXISTS `generalledgerchartofaccountdimension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalledgerchartofaccountdimension` (
  `generalLedgerChartOfAccountDimensionId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerChartOfAccountDimensionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalledgerchartofaccountdimension`
--

LOCK TABLES `generalledgerchartofaccountdimension` WRITE;
/*!40000 ALTER TABLE `generalledgerchartofaccountdimension` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalledgerchartofaccountdimension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalledgerchartofaccountsegment`
--

DROP TABLE IF EXISTS `generalledgerchartofaccountsegment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalledgerchartofaccountsegment` (
  `generalLedgerChartAccountSegmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerChartAccountSegmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalledgerchartofaccountsegment`
--

LOCK TABLES `generalledgerchartofaccountsegment` WRITE;
/*!40000 ALTER TABLE `generalledgerchartofaccountsegment` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalledgerchartofaccountsegment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalledgerforecast`
--

DROP TABLE IF EXISTS `generalledgerforecast`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalledgerforecast` (
  `generalLedgerForecastId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerForecastId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalledgerforecast`
--

LOCK TABLES `generalledgerforecast` WRITE;
/*!40000 ALTER TABLE `generalledgerforecast` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalledgerforecast` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalledgerjournal`
--

DROP TABLE IF EXISTS `generalledgerjournal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalledgerjournal` (
  `generalLedgerJournalId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerJournalId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalledgerjournal`
--

LOCK TABLES `generalledgerjournal` WRITE;
/*!40000 ALTER TABLE `generalledgerjournal` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalledgerjournal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoicedetailledger`
--

DROP TABLE IF EXISTS `invoicedetailledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoicedetailledger` (
  `invoiceDetailLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`invoiceDetailLedgerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoicedetailledger`
--

LOCK TABLES `invoicedetailledger` WRITE;
/*!40000 ALTER TABLE `invoicedetailledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoicedetailledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoiceledger`
--

DROP TABLE IF EXISTS `invoiceledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoiceledger` (
  `invoiceLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`invoiceLedgerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoiceledger`
--

LOCK TABLES `invoiceledger` WRITE;
/*!40000 ALTER TABLE `invoiceledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoiceledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoiceproject`
--

DROP TABLE IF EXISTS `invoiceproject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoiceproject` (
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
-- Dumping data for table `invoiceproject`
--

LOCK TABLES `invoiceproject` WRITE;
/*!40000 ALTER TABLE `invoiceproject` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoiceproject` ENABLE KEYS */;
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
-- Table structure for table `transactiondetailledger`
--

DROP TABLE IF EXISTS `transactiondetailledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactiondetailledger` (
  `transactionDetailLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `transactionDetailAmount` double(12,2) NOT NULL,
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
  PRIMARY KEY (`transactionDetailLedgerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactiondetailledger`
--

LOCK TABLES `transactiondetailledger` WRITE;
/*!40000 ALTER TABLE `transactiondetailledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactiondetailledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactionledger`
--

DROP TABLE IF EXISTS `transactionledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactionledger` (
  `transactionLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `transactionLedgerTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `transactionLedgerDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `transactionLedgerAmount` double(12,2) NOT NULL,
  `transactionLedgerDate` date NOT NULL,
  `businessPartnerId` int(11) NOT NULL,
  `reconciled` tinyint(1) NOT NULL,
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
  PRIMARY KEY (`transactionLedgerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactionledger`
--

LOCK TABLES `transactionledger` WRITE;
/*!40000 ALTER TABLE `transactionledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactionledger` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-11-24  7:27:04
