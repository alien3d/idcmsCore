# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-12-12 15:52:20
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for iFinancial
DROP DATABASE IF EXISTS `iFinancial`;
CREATE DATABASE IF NOT EXISTS `ifinancial` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `iFinancial`;


# Dumping structure for table iFinancial.adjustment
DROP TABLE IF EXISTS `adjustment`;
CREATE TABLE IF NOT EXISTS `adjustment` (
  `adjustmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `referenceNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `adjustmentTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `adjustmentDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `adjustmentDate` date NOT NULL,
  `adjustmentAmount` double(12,2) NOT NULL,
  `businessPartnerId` int(11) NOT NULL,
  `invoiceProjectId` int(11) NOT NULL,
  `invoiceId` int(11) NOT NULL,
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

# Dumping data for table iFinancial.adjustment: ~0 rows (approximately)
/*!40000 ALTER TABLE `adjustment` DISABLE KEYS */;
/*!40000 ALTER TABLE `adjustment` ENABLE KEYS */;


# Dumping structure for table iFinancial.adjustmentDetail
DROP TABLE IF EXISTS `adjustmentDetail`;
CREATE TABLE IF NOT EXISTS `adjustmentDetail` (
  `adjustmentDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `adjustmentId` int(11) NOT NULL,
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `transactionMode` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '''D''->Debit,''C''->Credit',
  `adjustmentDetailAmount` double(12,2) NOT NULL,
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

# Dumping data for table iFinancial.adjustmentDetail: ~0 rows (approximately)
/*!40000 ALTER TABLE `adjustmentDetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `adjustmentDetail` ENABLE KEYS */;


# Dumping structure for table iFinancial.bankBalance
DROP TABLE IF EXISTS `bankBalance`;
CREATE TABLE IF NOT EXISTS `bankBalance` (
  `bankBalanceId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `bankBalanceCashAmount` double(12,2) NOT NULL,
  `bankBalanceChequeAmount` double(12,2) NOT NULL,
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

# Dumping data for table iFinancial.bankBalance: ~0 rows (approximately)
/*!40000 ALTER TABLE `bankBalance` DISABLE KEYS */;
/*!40000 ALTER TABLE `bankBalance` ENABLE KEYS */;


# Dumping structure for table iFinancial.businessPartner
DROP TABLE IF EXISTS `businessPartner`;
CREATE TABLE IF NOT EXISTS `businessPartner` (
  `businessPartnerId` int(10) NOT NULL AUTO_INCREMENT,
  `businessPartnerCompany` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerLastName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerFirstName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerEmail` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerJobTitle` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerBusinessPhone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerHomePhone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerMobilePhone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerFaxNum` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerAddress` longtext COLLATE utf8_unicode_ci,
  `businessPartnerCity` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerState` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerPostCode` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerCountry` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerWebPage` longtext COLLATE utf8_unicode_ci,
  `businessPartnerNotes` longtext COLLATE utf8_unicode_ci,
  `businessPartnerAttachments` longtext COLLATE utf8_unicode_ci,
  `businessPartnerDate` date NOT NULL,
  `businessPartnerCategoryId` int(11) NOT NULL,
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
  PRIMARY KEY (`businessPartnerId`),
  KEY `City` (`businessPartnerCity`),
  KEY `Company` (`businessPartnerCompany`),
  KEY `First Name` (`businessPartnerFirstName`),
  KEY `Last Name` (`businessPartnerLastName`),
  KEY `Postal Code` (`businessPartnerPostCode`),
  KEY `State/Province` (`businessPartnerState`),
  KEY `businessPartnerCategoryId` (`businessPartnerCategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.businessPartner: ~51 rows (approximately)
/*!40000 ALTER TABLE `businessPartner` DISABLE KEYS */;
INSERT INTO `businessPartner` (`businessPartnerId`, `businessPartnerCompany`, `businessPartnerLastName`, `businessPartnerFirstName`, `businessPartnerEmail`, `businessPartnerJobTitle`, `businessPartnerBusinessPhone`, `businessPartnerHomePhone`, `businessPartnerMobilePhone`, `businessPartnerFaxNum`, `businessPartnerAddress`, `businessPartnerCity`, `businessPartnerState`, `businessPartnerPostCode`, `businessPartnerCountry`, `businessPartnerWebPage`, `businessPartnerNotes`, `businessPartnerAttachments`, `businessPartnerDate`, `businessPartnerCategoryId`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 'Northwind Traders', 'Freehafer', 'Nancy', 'nancy@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 1st Avenue', 'Seattle', 'WA', '99999', 'USA', '#http://northwindtraders.com#', NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(2, 'Northwind Traders', 'Cencini', 'Andrew', 'andrew@northwindtraders.com', 'Vice President, Sales', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 2nd Avenue', 'Bellevue', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Joined the company as a sales representative, was promoted to sales manager and was then named vice president of sales.', NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(3, 'Northwind Traders', 'Kotas', 'Jan', 'jan@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 3rd Avenue', 'Redmond', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Was hired as a sales associate and was promoted to sales representative.', NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(4, 'Northwind Traders', 'Sergienko', 'Mariya', 'mariya@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 4th Avenue', 'Kirkland', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(5, 'Northwind Traders', 'Thorpe', 'Steven', 'steven@northwindtraders.com', 'Sales Manager', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 5th Avenue', 'Seattle', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Joined the company as a sales representative and was promoted to sales manager.  Fluent in French.', NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(6, 'Northwind Traders', 'Neipper', 'Michael', 'michael@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 6th Avenue', 'Redmond', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Fluent in Japanese and can read and write French, Portuguese, and Spanish.', NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(7, 'Northwind Traders', 'Zare', 'Robert', 'robert@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 7th Avenue', 'Seattle', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(8, 'Northwind Traders', 'Giussani', 'Laura', 'laura@northwindtraders.com', 'Sales Coordinator', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 8th Avenue', 'Redmond', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Reads and writes French.', NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(9, 'Northwind Traders', 'Hellung-Larsen', 'Anne', 'anne@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 9th Avenue', 'Seattle', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Fluent in French and German.', NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(16, 'Company A', 'Bedecs', 'Anna', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 1st Street', 'Seattle', 'WA', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(17, 'Company B', 'Gratacos Solsona', 'Antonio', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 2nd Street', 'Boston', 'MA', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(18, 'Company C', 'Axen', 'Thomas', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 3rd Street', 'Los Angelas', 'CA', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(19, 'Company D', 'Lee', 'Christina', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 4th Street', 'New York', 'NY', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(20, 'Company E', 'O’Donnell', 'Martin', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 5th Street', 'Minneapolis', 'MN', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(21, 'Company F', 'Pérez-Olaeta', 'Francisco', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(22, 'Company G', 'Xie', 'Ming-Yang', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 7th Street', 'Boise', 'ID', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(23, 'Company H', 'Andersen', 'Elizabeth', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 8th Street', 'Portland', 'OR', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(24, 'Company I', 'Mortensen', 'Sven', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 9th Street', 'Salt Lake City', 'UT', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(25, 'Company J', 'Wacker', 'Roland', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 10th Street', 'Chicago', 'IL', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(26, 'Company K', 'Krschne', 'Peter', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 11th Street', 'Miami', 'FL', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(27, 'Company L', 'Edwards', 'John', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 12th Street', 'Las Vegas', 'NV', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(28, 'Company M', 'Ludick', 'Andre', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 13th Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(29, 'Company N', 'Grilo', 'Carlos', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 14th Street', 'Denver', 'CO', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(30, 'Company O', 'Kupkova', 'Helena', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 15th Street', 'Honolulu', 'HI', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(31, 'Company P', 'Goldschmidt', 'Daniel', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 16th Street', 'San Francisco', 'CA', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(32, 'Company Q', 'Bagel', 'Jean Philippe', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 17th Street', 'Seattle', 'WA', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(33, 'Company R', 'Autier Miconi', 'Catherine', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 18th Street', 'Boston', 'MA', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(34, 'Company S', 'Eggerer', 'Alexander', NULL, 'Accounting Assistant', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 19th Street', 'Los Angelas', 'CA', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(35, 'Company T', 'Li', 'George', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 20th Street', 'New York', 'NY', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(36, 'Company U', 'Tham', 'Bernard', NULL, 'Accounting Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 21th Street', 'Minneapolis', 'MN', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(37, 'Company V', 'Ramos', 'Luciana', NULL, 'Purchasing Assistant', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 22th Street', 'Milwaukee', 'WI', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(38, 'Company W', 'Entin', 'Michael', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 23th Street', 'Portland', 'OR', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(39, 'Company X', 'Hasselberg', 'Jonas', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 24th Street', 'Salt Lake City', 'UT', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(40, 'Company Y', 'Rodman', 'John', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 25th Street', 'Chicago', 'IL', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(41, 'Company Z', 'Liu', 'Run', NULL, 'Accounting Assistant', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 26th Street', 'Miami', 'FL', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(42, 'Company AA', 'Toh', 'Karen', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 27th Street', 'Las Vegas', 'NV', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(43, 'Company BB', 'Raghav', 'Amritansh', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 28th Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(44, 'Company CC', 'Lee', 'Soo Jung', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 29th Street', 'Denver', 'CO', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(47, 'Supplier A', 'Andersen', 'Elizabeth A.', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(48, 'Supplier B', 'Weiler', 'Cornelia', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(49, 'Supplier C', 'Kelley', 'Madeleine', NULL, 'Sales Representative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(50, 'Supplier D', 'Sato', 'Naoki', NULL, 'Marketing Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(51, 'Supplier E', 'Hernandez-Echevarria', 'Amaya', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(52, 'Supplier F', 'Hayakawa', 'Satomi', NULL, 'Marketing Assistant', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(53, 'Supplier G', 'Glasson', 'Stuart', NULL, 'Marketing Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(54, 'Supplier H', 'Dunton', 'Bryn Paul', NULL, 'Sales Representative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(55, 'Supplier I', 'Sandberg', 'Mikael', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(56, 'Supplier J', 'Sousa', 'Luis', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(62, 'Shipping Company A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123 Any Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(63, 'Shipping Company B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123 Any Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33'),
	(64, 'Shipping Company C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123 Any Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL, '0000-00-00', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:33');
/*!40000 ALTER TABLE `businessPartner` ENABLE KEYS */;


# Dumping structure for table iFinancial.businessPartnerCategory
DROP TABLE IF EXISTS `businessPartnerCategory`;
CREATE TABLE IF NOT EXISTS `businessPartnerCategory` (
  `businessPartnerCategoryId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `businessPartnerCategoryDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`businessPartnerCategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.businessPartnerCategory: ~1 rows (approximately)
/*!40000 ALTER TABLE `businessPartnerCategory` DISABLE KEYS */;
INSERT INTO `businessPartnerCategory` (`businessPartnerCategoryId`, `businessPartnerCategoryDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 'dsfsdfsdf', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:41');
/*!40000 ALTER TABLE `businessPartnerCategory` ENABLE KEYS */;


# Dumping structure for table iFinancial.businessPartnerContact
DROP TABLE IF EXISTS `businessPartnerContact`;
CREATE TABLE IF NOT EXISTS `businessPartnerContact` (
  `businessPartnerContactId` int(11) NOT NULL AUTO_INCREMENT,
  `businessPartnerContactName` varchar(128) NOT NULL,
  `businessPartnerContactTitle` varchar(64) NOT NULL,
  `businessPartnerContactPhone` varchar(64) NOT NULL,
  `businessPartnerContactEmail` varchar(128) NOT NULL,
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
  PRIMARY KEY (`businessPartnerContactId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table iFinancial.businessPartnerContact: ~0 rows (approximately)
/*!40000 ALTER TABLE `businessPartnerContact` DISABLE KEYS */;
/*!40000 ALTER TABLE `businessPartnerContact` ENABLE KEYS */;


# Dumping structure for table iFinancial.country
DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `countryId` int(11) NOT NULL AUTO_INCREMENT,
  `countrySequence` int(11) NOT NULL,
  `countryCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `countryCurrencyCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `countryCurrencyCodeDesc` text COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table iFinancial.country: ~164 rows (approximately)
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`countryId`, `countrySequence`, `countryCode`, `countryCurrencyCode`, `countryCurrencyCodeDesc`, `countryDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, 'AE', 'AED', 'United Arab Emirates Dirham', 'United Arab Emirates ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(2, 0, 'AF', 'AFN', 'Afghanistan Afghani', 'stan ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(3, 0, 'AL', 'ALL', 'Albania Lek', 'Albania ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(4, 0, 'AM', 'AMD', 'Armenia Dram', 'Armenia', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(5, 0, 'AN', 'ANG', 'Netherlands Antilles Guilder', 'Netherlands Antilles ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(6, 0, 'AO', 'AOA', 'Angola Kwanza', 'Angola ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(7, 0, 'AR', 'ARS', 'Argentina Peso', 'Argentina ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(8, 0, 'AU', 'AUD', 'Australia Dollar', 'Australia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(9, 0, 'AW', 'AWG', 'Aruba Guilder', 'Aruba ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(10, 0, 'AZ', 'AZN', 'Azerbaijan New Manat', 'Azerbaijan New Manat', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(11, 0, 'BA', 'BAM', 'Bosnia and Herzegovina Convertible Marka', 'Bosnia and Herzegovina', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(12, 0, 'BB', 'BBD', 'Barbados Dollar', 'Barbados ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(13, 0, 'BD', 'BDT', 'Bangladesh Taka', 'Bangladesh', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(14, 0, 'BG', 'BGN', 'Bulgaria Lev', 'Bulgaria Lev', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(15, 0, 'BH', 'BHD', 'Bahrain Dinar', 'Bahrain ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(16, 0, 'BI', 'BIF', 'Burundi Franc', 'Burundi ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(17, 0, 'BM', 'BMD', 'Bermuda Dollar', 'Bermuda ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(18, 0, 'BN', 'BND', 'Brunei Darussalam Dollar', 'Brunei Darussalam ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(19, 0, 'BO', 'BOB', 'Bolivia Boliviano', 'Bolivia Boliviano', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(20, 0, 'BR', 'BRL', 'Brazil Real', 'Brazil Real', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(21, 0, 'BS', 'BSD', 'Bahamas Dollar', 'Bahamas ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(22, 0, 'BT', 'BTN', 'Bhutan Ngultrum', 'Bhutan Ngultrum', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(23, 0, 'BW', 'BWP', 'Botswana Pula', 'Botswana Pula', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(24, 0, 'BY', 'BYR', 'Belarus Ruble', 'Belarus ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(25, 0, 'BZ', 'BZD', 'Belize Dollar', 'Belize ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(26, 0, 'CA', 'CAD', 'Canada Dollar', 'Canada ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(27, 0, 'CD', 'CDF', 'Congo/Kinshasa Franc', 'Congo/Kinshasa ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(28, 0, 'CH', 'CHF', 'Switzerland Franc', 'Switzerland ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(29, 0, 'CL', 'CLP', 'Chile Peso', 'Chile ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(30, 0, 'CN', 'CNY', 'China Yuan Renminbi', 'China', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(31, 0, 'CO', 'COP', 'Colombia Peso', 'Colombia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(32, 0, 'CR', 'CRC', 'Costa Rica Colon', 'Costa Rica', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(33, 0, 'CU', 'CUC', 'Cuba Convertible Peso', 'Cuba', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(34, 0, 'CU', 'CUP', 'Cuba Peso', 'Cuba ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(35, 0, 'CV', 'CVE', 'Cape Verde Escudo', 'Cape Verde', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(36, 0, 'CZ', 'CZK', 'Czech Republic Koruna', 'Czech Republic', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(37, 0, 'DJ', 'DJF', 'Djibouti Franc', 'Djibouti ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(38, 0, 'DK', 'DKK', 'Denmark Krone', 'Denmark', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(39, 0, 'DO', 'DOP', 'Dominican Republic Peso', 'Dominican Republic ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(40, 0, 'DZ', 'DZD', 'Algeria Dinar', 'Algeria ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(41, 0, 'EG', 'EGP', 'Egypt Pound', 'Egypt ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(42, 0, 'ER', 'ERN', 'Eritrea Nakfa', 'Eritrea Nakfa', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(43, 0, 'ET', 'ETB', 'Ethiopia Birr', 'Ethiopia Birr', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(44, 0, 'EU', 'EUR', 'Euro Member Countries', 'Euro Member Countries', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(45, 0, 'FJ', 'FJD', 'Fiji Dollar', 'Fiji ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(46, 0, 'FK', 'FKP', 'Falkland Islands (Malvinas) Pound', 'Falkland Islands (Malvinas) ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(47, 0, 'GB', 'GBP', 'United Kingdom Pound', 'United Kingdom ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(48, 0, 'GE', 'GEL', 'Georgia Lari', 'Georgia Lari', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(49, 0, 'GG', 'GGP', 'Guernsey Pound', 'Guernsey ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(50, 0, 'GH', 'GHS', 'Ghana Cedi', 'Ghana Cedi', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(51, 0, 'GI', 'GIP', 'Gibraltar Pound', 'Gibraltar ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(52, 0, 'GM', 'GMD', 'Gambia Dalasi', 'Gambia Dalasi', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(53, 0, 'GN', 'GNF', 'Guinea Franc', 'Guinea ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(54, 0, 'GT', 'GTQ', 'Guatemala Quetzal', 'Guatemala Quetzal', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(55, 0, 'GY', 'GYD', 'Guyana Dollar', 'Guyana ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(56, 0, 'HK', 'HKD', 'Hong Kong Dollar', 'Hong Kong ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(57, 0, 'HN', 'HNL', 'Honduras Lempira', 'Honduras ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(58, 0, 'HR', 'HRK', 'Croatia Kuna', 'Croatia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(59, 0, 'HT', 'HTG', 'Haiti Gourde', 'Haiti Gourde', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(60, 0, 'HU', 'HUF', 'Hungary Forint', 'Hungary Forint', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(61, 0, 'ID', 'IDR', 'Indonesia Rupiah', 'Indonesia Rupiah', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(62, 0, 'IL', 'ILS', 'Israel Shekel', 'Israel Shekel', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(63, 0, 'IM', 'IMP', 'Isle of Man Pound', 'Isle of Man ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(64, 0, 'IN', 'INR', 'India Rupee', 'India ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(65, 0, 'IQ', 'IQD', 'Iraq Dinar', 'Iraq ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(66, 0, 'IR', 'IRR', 'Iran Rial', 'Iran ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(67, 0, 'IS', 'ISK', 'Iceland Krona', 'Iceland ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(68, 0, 'JE', 'JEP', 'Jersey Pound', 'Jersey ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(69, 0, 'JM', 'JMD', 'Jamaica Dollar', 'Jamaica ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(70, 0, 'JO', 'JOD', 'Jordan Dinar', 'Jordan ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(71, 0, 'JP', 'JPY', 'Japan Yen', 'Japan Yen', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(72, 0, 'KE', 'KES', 'Kenya Shilling', 'Kenya ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(73, 0, 'KG', 'KGS', 'Kyrgyzstan Som', 'Kyrgyzstan ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(74, 0, 'KH', 'KHR', 'Cambodia Riel', 'Cambodia Riel', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(75, 0, 'KM', 'KMF', 'Comoros Franc', 'Comoros ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(76, 0, 'KP', 'KPW', 'Korea (North) Won', 'Korea (North) Won', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(77, 0, 'KR', 'KRW', 'Korea (South) Won', 'Korea (South) Won', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(78, 0, 'KW', 'KWD', 'Kuwait Dinar', 'Kuwait ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(79, 0, 'KY', 'KYD', 'Cayman Islands Dollar', 'Cayman Islands ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(80, 0, 'KZ', 'KZT', 'Kazakhstan Tenge', 'Kazakhstan Tenge', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(81, 0, 'LA', 'LAK', 'Laos Kip', 'Laos Kip', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(82, 0, 'LB', 'LBP', 'Lebanon Pound', 'Lebanon ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(83, 0, 'LK', 'LKR', 'Sri Lanka Rupee', 'Sri Lanka ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(84, 0, 'LR', 'LRD', 'Liberia Dollar', 'Liberia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(85, 0, 'LS', 'LSL', 'Lesotho Loti', 'Lesotho Loti', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(86, 0, 'LT', 'LTL', 'Lithuania Litas', 'Lithuania Litas', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(87, 0, 'LV', 'LVL', 'Latvia Lat', 'Latvia Lat', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(88, 0, 'LY', 'LYD', 'Libya Dinar', 'Libya ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(89, 0, 'MA', 'MAD', 'Morocco Dirham', 'Morocco ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(90, 0, 'MD', 'MDL', 'Moldova Leu', 'Moldova Leu', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(91, 0, 'MG', 'MGA', 'Madagascar Ariary', 'Madagascar Ariary', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(92, 0, 'MK', 'MKD', 'Macedonia Denar', 'Macedonia Denar', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(93, 0, 'MM', 'MMK', 'Myanmar (Burma) Kyat', 'Myanmar (Burma) Kyat', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(94, 0, 'MN', 'MNT', 'Mongolia Tughrik', 'Mongolia Tughrik', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(95, 0, 'MO', 'MOP', 'Macau Pataca', 'Macau Pataca', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(96, 0, 'MR', 'MRO', 'Mauritania Ouguiya', 'Mauritania Ouguiya', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(97, 0, 'MU', 'MUR', 'Mauritius Rupee', 'Mauritius ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(98, 0, 'MV', 'MVR', 'Maldives (Maldive Islands) Rufiyaa', 'Maldives (Maldive Islands) ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(99, 0, 'MW', 'MWK', 'Malawi Kwacha', 'Malawi Kwacha', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(100, 0, 'MX', 'MXN', 'Mexico Peso', 'Mexico ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(101, 1, 'MY', 'MYR', 'Malaysia Ringgit', 'Malaysia', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(102, 0, 'MZ', 'MZN', 'Mozambique Metical', 'Mozambique', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(103, 0, 'NA', 'NAD', 'Namibia Dollar', 'Namibia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(104, 0, 'NG', 'NGN', 'Nigeria Naira', 'Nigeria Naira', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(105, 0, 'NI', 'NIO', 'Nicaragua Cordoba', 'Nicaragua Cordoba', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(106, 0, 'NO', 'NOK', 'Norway Krone', 'Norway Krone', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(107, 0, 'NP', 'NPR', 'Nepal Rupee', 'Nepal ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(108, 0, 'NZ', 'NZD', 'New Zealand Dollar', 'New Zealand ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(109, 0, 'OM', 'OMR', 'Oman Rial', 'Oman ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(110, 0, 'PA', 'PAB', 'Panama Balboa', 'Panama Balboa', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(111, 0, 'PE', 'PEN', 'Peru Nuevo Sol', 'Peru Nuevo', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(112, 0, 'PG', 'PGK', 'Papua New Guinea Kina', 'Papua New Guinea', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(113, 0, 'PH', 'PHP', 'Philippines Peso', 'Philippines ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(114, 0, 'PK', 'PKR', 'Pakistan Rupee', 'Pakistan ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(115, 0, 'PL', 'PLN', 'Poland Zloty', 'Poland Zloty', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(116, 0, 'PY', 'PYG', 'Paraguay Guarani', 'Paraguay Guarani', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(117, 0, 'QA', 'QAR', 'Qatar Riyal', 'Qatar Riyal', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(118, 0, 'RO', 'RON', 'Romania New Leu', 'Romania New Leu', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(119, 0, 'RS', 'RSD', 'Serbia Dinar', 'Serbia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(120, 0, 'RU', 'RUB', 'Russia Ruble', 'Russia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(121, 0, 'RW', 'RWF', 'Rwanda Franc', 'Rwanda ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(122, 0, 'SA', 'SAR', 'Saudi Arabia Riyal', 'Saudi Arabia Riyal', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(123, 0, 'SB', 'SBD', 'Solomon Islands Dollar', 'Solomon Islands ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(124, 0, 'SC', 'SCR', 'Seychelles Rupee', 'Seychelles ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(125, 0, 'SD', 'SDG', 'Sudan Pound', 'Sudan ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(126, 0, 'SE', 'SEK', 'Sweden Krona', 'Sweden ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(127, 0, 'SG', 'SGD', 'Singapore Dollar', 'Singapore ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(128, 0, 'SH', 'SHP', 'Saint Helena Pound', 'Saint Helena ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(129, 0, 'SL', 'SLL', 'Sierra Leone Leone', 'Sierra Leone Leone', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(130, 0, 'SO', 'SOS', 'Somalia Shilling', 'alia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(131, 0, 'SP', 'SPL*', 'Seborga Luigino', 'Seborga Luigino', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(132, 0, 'SR', 'SRD', 'Suriname Dollar', 'Suriname ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(133, 0, 'ST', 'STD', 'S?o Principe and Tome Dobra', 'S?o Principe and Tome Dobra', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(134, 0, 'SV', 'SVC', 'El Salvador Colon', 'El Salvador Colon', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(135, 0, 'SY', 'SYP', 'Syria Pound', 'Syria ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(136, 0, 'SZ', 'SZL', 'Swaziland Lilangeni', 'Swaziland Lilangeni', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(137, 0, 'TH', 'THB', 'Thailand Baht', 'Thailand Baht', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(138, 0, 'TJ', 'TJS', 'Tajikistan Somoni', 'Tajikistan oni', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(139, 0, 'TM', 'TMT', 'Turkmenistan Manat', 'Turkmenistan Manat', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(140, 0, 'TN', 'TND', 'Tunisia Dinar', 'Tunisia ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(141, 0, 'TO', 'TOP', 'Tonga Pa\'anga', 'Tonga Pa\'anga', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(142, 0, 'TR', 'TRY', 'Turkey Lira', 'Turkey Lira', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(143, 0, 'TT', 'TTD', 'Trinidad and Tobago Dollar', 'Trinidad and Tobago ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(144, 0, 'TV', 'TVD', 'Tuvalu Dollar', 'Tuvalu ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(145, 0, 'TW', 'TWD', 'Taiwan New Dollar', 'Taiwan New ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(146, 0, 'TZ', 'TZS', 'Tanzania Shilling', 'Tanzania ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(147, 0, 'UA', 'UAH', 'Ukraine Hryvna', 'Ukraine Hryvna', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(148, 0, 'UG', 'UGX', 'Uganda Shilling', 'Uganda ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(149, 0, 'US', 'USD', 'United States Dollar', 'United States ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(150, 0, 'UY', 'UYU', 'Uruguay Peso', 'Uruguay ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(151, 0, 'UZ', 'UZS', 'Uzbekistan Som', 'Uzbekistan ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(152, 0, 'VE', 'VEF', 'Venezuela Bolivar Fuerte', 'Venezuela', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(153, 0, 'VN', 'VND', 'Viet Nam Dong', 'Viet Nam ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(154, 0, 'VU', 'VUV', 'Vanuatu Vatu', 'Vanuatu', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(155, 0, 'WS', 'WST', 'Samoa Tala', 'Samoa', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(156, 0, 'XA', 'XAF', 'Communaut‚ FinanciŠre Africaine (BEAC) CFA Franc BEAC', 'Communaut‚ FinanciŠre Africaine (BEAC) CFA  BEAC', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(157, 0, 'XC', 'XCD', 'East Caribbean Dollar', 'East Caribbean ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(158, 0, 'XD', 'XDR', 'International Monetary Fund (IMF) Special Drawing Rights', 'International Monetary Fund (IMF) Special Drawing Rights', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(159, 0, 'XO', 'XOF', 'Communaut‚ FinanciŠre Africaine (BCEAO) Franc', 'Communaut‚ FinanciŠre Africaine (BCEAO) ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(160, 0, 'XP', 'XPF', 'Comptoirs Fran‡ais du Pacifique (CFP) Franc', 'Comptoirs Fran‡ais du Pacifique (CFP) ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(161, 0, 'YE', 'YER', 'Yemen Rial', 'Yemen ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(162, 0, 'ZA', 'ZAR', 'South Africa Rand', 'South Africa Rand', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(163, 0, 'ZM', 'ZMK', 'Zambia Kwacha', 'Zambia Kwacha', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127),
	(164, 0, 'ZW', 'ZWD', 'Zimbabwe Dollar', 'Zimbabwe ', 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, 127);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;


# Dumping structure for table iFinancial.financialDuration
DROP TABLE IF EXISTS `financialDuration`;
CREATE TABLE IF NOT EXISTS `financialDuration` (
  `financialDurationId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `financialDurationYear` int(4) NOT NULL,
  `financialDurationYearClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodFirst` int(2) NOT NULL,
  `financialDurationYearPeriodFirstClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodSecond` int(2) NOT NULL,
  `financialDurationYearPeriodSecondClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodThird` int(2) NOT NULL,
  `financialDurationYearPeriodThirdClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodFourth` int(2) NOT NULL,
  `financialDurationYearPeriodFourthClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodFifth` int(2) NOT NULL,
  `financialDurationYearPeriodFifthClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodSix` int(2) NOT NULL,
  `financialDurationYearPeriodSixClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodSeven` int(2) NOT NULL,
  `financialDurationYearPeriodSevenClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodEigth` int(2) NOT NULL,
  `financialDurationYearPeriodEigthClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodNine` int(2) NOT NULL,
  `financialDurationYearPeriodNineClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodTen` int(2) NOT NULL,
  `financialDurationYearPeriodTenClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodEleven` int(2) NOT NULL,
  `financialDurationYearPeriodElevenClose` tinyint(1) NOT NULL,
  `financialDurationYearPeriodTwelve` int(2) NOT NULL,
  `financialDurationYearPeriodTwelveClose` tinyint(1) NOT NULL,
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
  PRIMARY KEY (`financialDurationId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.financialDuration: ~10 rows (approximately)
/*!40000 ALTER TABLE `financialDuration` DISABLE KEYS */;
INSERT INTO `financialDuration` (`financialDurationId`, `financialDurationYear`, `financialDurationYearClose`, `financialDurationYearPeriodFirst`, `financialDurationYearPeriodFirstClose`, `financialDurationYearPeriodSecond`, `financialDurationYearPeriodSecondClose`, `financialDurationYearPeriodThird`, `financialDurationYearPeriodThirdClose`, `financialDurationYearPeriodFourth`, `financialDurationYearPeriodFourthClose`, `financialDurationYearPeriodFifth`, `financialDurationYearPeriodFifthClose`, `financialDurationYearPeriodSix`, `financialDurationYearPeriodSixClose`, `financialDurationYearPeriodSeven`, `financialDurationYearPeriodSevenClose`, `financialDurationYearPeriodEigth`, `financialDurationYearPeriodEigthClose`, `financialDurationYearPeriodNine`, `financialDurationYearPeriodNineClose`, `financialDurationYearPeriodTen`, `financialDurationYearPeriodTenClose`, `financialDurationYearPeriodEleven`, `financialDurationYearPeriodElevenClose`, `financialDurationYearPeriodTwelve`, `financialDurationYearPeriodTwelveClose`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 2011, 0, 1, 1, 2, 1, 3, 1, 4, 1, 5, 1, 6, 1, 7, 1, 8, 1, 9, 1, 10, 1, 11, 1, 12, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 2, '2011-12-13 11:25:33'),
	(2, 2012, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(3, 2013, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(4, 2014, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(5, 2015, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(6, 2016, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(7, 2017, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(8, 2018, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(9, 2019, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33'),
	(10, 2020, 0, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 8, 0, 9, 0, 10, 0, 11, 0, 12, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:25:33');
/*!40000 ALTER TABLE `financialDuration` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedger
DROP TABLE IF EXISTS `generalLedger`;
CREATE TABLE IF NOT EXISTS `generalLedger` (
  `generalLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerDate` date NOT NULL,
  `countryId` int(11) NOT NULL,
  `countryCurrencyCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `transactionMode` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '''D''->Debit,''C''->Credit',
  `generalLedgerForeignAmount` double(12,2) NOT NULL,
  `generalLedgerLocalAmount` double(12,2) NOT NULL,
  `generalLedgerChartOfAccountCategoryId` int(11) NOT NULL,
  `generalLedgerChartOfAccountTypeId` int(11) NOT NULL,
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `generalLedgerChartOfAccountNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `businessPartnerId` int(11) NOT NULL,
  `businessPartnerDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `isAuthorized` tinyint(1) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`generalLedgerId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedger: ~0 rows (approximately)
/*!40000 ALTER TABLE `generalLedger` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalLedger` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerBudget
DROP TABLE IF EXISTS `generalLedgerBudget`;
CREATE TABLE IF NOT EXISTS `generalLedgerBudget` (
  `generalLedgerBudgetId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `generalLedgerBudgetMonth` int(2) NOT NULL,
  `generalLedgerBudgetYear` int(4) NOT NULL,
  `generalLedgerBudgetAmount` double(12,2) NOT NULL,
  `generalLedgerBudgetDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerBudgetId`),
  KEY `generalLedgerChartOfAccountId` (`generalLedgerChartOfAccountId`),
  CONSTRAINT `generalledgerbudget_ibfk_1` FOREIGN KEY (`generalLedgerChartOfAccountId`) REFERENCES `generalLedgerChartOfAccount` (`generalLedgerChartOfAccountId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerBudget: ~0 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerBudget` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalLedgerBudget` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerBudgetType
DROP TABLE IF EXISTS `generalLedgerBudgetType`;
CREATE TABLE IF NOT EXISTS `generalLedgerBudgetType` (
  `generalLedgerChartOfAccountTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountTypeSequence` int(11) NOT NULL,
  `generalLedgerChartOfAccountTypeCode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountTypeDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerBudgetType: ~0 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerBudgetType` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalLedgerBudgetType` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccount
DROP TABLE IF EXISTS `generalLedgerChartOfAccount`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccount` (
  `generalLedgerChartOfAccountId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountCategoryId` int(11) NOT NULL,
  `generalLedgerChartOfAccountTypeId` int(11) NOT NULL COMMENT ' bank, Accounts Receivable, Other Current Asset, Fixed Asset, Accounts Payable, Credit Card, Other Current Liability, Long Term Liability, Equity, Income, Cost of Goods Sold, Expense, Non-Posting',
  `generalLedgerChartOfAccountReportTypeId` int(11) NOT NULL COMMENT '''Balance Sheet'',''P&L Statement''',
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL COMMENT 'New|',
  `isDraft` tinyint(1) NOT NULL COMMENT 'Draft|',
  `isUpdate` tinyint(1) NOT NULL COMMENT 'Updated|',
  `isDelete` tinyint(1) NOT NULL COMMENT 'Delete|',
  `isActive` tinyint(1) NOT NULL COMMENT 'Active|',
  `isApproved` tinyint(1) NOT NULL COMMENT 'Approved|',
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `isConsolidation` int(11) NOT NULL,
  `isSeperated` int(11) NOT NULL,
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`generalLedgerChartOfAccountId`),
  KEY `generalLedgerChartOfAccountTypeId` (`generalLedgerChartOfAccountTypeId`),
  KEY `generalLedgerChartOfAccountReportTypeId` (`generalLedgerChartOfAccountReportTypeId`),
  CONSTRAINT `generalledgerchartofaccount_ibfk_1` FOREIGN KEY (`generalLedgerChartOfAccountTypeId`) REFERENCES `generalLedgerChartOfAccountType` (`generalLedgerChartOfAccountTypeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `generalledgerchartofaccount_ibfk_2` FOREIGN KEY (`generalLedgerChartOfAccountReportTypeId`) REFERENCES `generalLedgerChartOfAccountReportType` (`generalLedgerChartOfAccountReportTypeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=461 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerChartOfAccount: ~414 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccount` DISABLE KEYS */;
INSERT INTO `generalLedgerChartOfAccount` (`generalLedgerChartOfAccountId`, `generalLedgerChartOfAccountTitle`, `generalLedgerChartOfAccountDesc`, `generalLedgerChartOfAccountNo`, `generalLedgerChartOfAccountCategoryId`, `generalLedgerChartOfAccountTypeId`, `generalLedgerChartOfAccountReportTypeId`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `isConsolidation`, `isSeperated`, `executeBy`, `executeTime`) VALUES
	(9, 'ASSETS', 'ASSETS', '100000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(10, ' Checking Account #1', ' Checking Account #1', '100000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(11, ' Checking Account #2', ' Checking Account #2', '101000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(12, ' Escrow Account', ' Escrow Account', '102000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(13, ' Payroll Account', ' Payroll Account', '103000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(14, ' Reserve Account-Warranty', ' Reserve Account-Warranty', '104000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(15, ' Savings Account #1', ' Savings Account #1', '105000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(16, ' Money Market Account #1', ' Money Market Account #1', '106000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(17, ' Short Term CD\'s', ' Short Term CD\'s', '107000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(18, ' Costs Pd by Third Parties', ' Costs Pd by Third Parties', '108000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(19, ' Petty Cash', ' Petty Cash', '109000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(20, ' Accounts Receivable', ' Accounts Receivable', '110000', 0, 2, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(21, ' Retainage Receivable', ' Retainage Receivable', '111000', 0, 2, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(22, ' Rental Property Leases', ' Rental Property Leases', '112000', 0, 2, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(23, ' Due from Subsidary Companies', ' Due from Subsidary Companies', '115000', 0, 2, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(24, ' Long Term CD\'s', ' Long Term CD\'s', '120000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(25, ' [Bank Name - CD #1]', ' [Bank Name - CD #1]', '120100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(26, ' [Bank Name - CD #2]', ' [Bank Name - CD #2]', '120200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(27, ' [Bank Name - CD #3]', ' [Bank Name - CD #3]', '120300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(28, ' Government Securities', ' Government Securities', '121000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(29, ' [Name - Gov\'t Security #1]', ' [Name - Gov\'t Security #1]', '121100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(30, ' [Name - Gov\'t Security #2]', ' [Name - Gov\'t Security #2]', '121200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(31, ' [Name - Gov\'t Security #3]', ' [Name - Gov\'t Security #3]', '121300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(32, ' Mutual Funds', ' Mutual Funds', '122000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(33, ' [Name - Mutual Funds #1]', ' [Name - Mutual Funds #1]', '122100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(34, ' [Name - Mutual Funds #2]', ' [Name - Mutual Funds #2]', '122200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(35, ' [Name - Mutual Funds #3]', ' [Name - Mutual Funds #3]', '122300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(36, ' Marketable Stocks', ' Marketable Stocks', '123000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(37, ' [Name - Stock #1]', ' [Name - Stock #1]', '123100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(38, ' [Name - Stock #2]', ' [Name - Stock #2]', '123200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(39, ' [Name - Stock #3]', ' [Name - Stock #3]', '123300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(40, ' Loans Made To Others', ' Loans Made To Others', '130000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(41, ' [Name - Loan #1]', ' [Name - Loan #1]', '130100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(42, ' [Name - Loan #2]', ' [Name - Loan #2]', '130200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(43, ' [Name - Loan #3]', ' [Name - Loan #3]', '130300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(44, ' Loans Made To Principles', ' Loans Made To Principles', '135000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(45, ' [Name - Loan #1]', ' [Name - Loan #1]', '135100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(46, ' [Name - Loan #2]', ' [Name - Loan #2]', '135200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(47, ' [Name - Loan #3]', ' [Name - Loan #3]', '135300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(48, ' Inventory - Land', ' Inventory - Land', '140000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(49, ' Inventory - Houses', ' Inventory - Houses', '150000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(50, ' [Street Address - Unit #1]', ' [Street Address - Unit #1]', '150100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(51, ' [Street Address - Unit #2]', ' [Street Address - Unit #2]', '150200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(52, ' [Street Address - Unit #3]', ' [Street Address - Unit #3]', '150300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(53, ' Inventory- Rental Property', ' Inventory- Rental Property', '160000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(54, ' [Street Address - Unit #1]', ' [Street Address - Unit #1]', '160100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(55, ' [Street Address - Unit #2]', ' [Street Address - Unit #2]', '160200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(56, ' [Street Address - Unit #3]', ' [Street Address - Unit #3]', '160300', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(57, ' Business Property', ' Business Property', '169000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(58, 'Office Building & Land', 'Office Building & Land', '169100', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(59, 'Shop Building & Land', 'Shop Building & Land', '169200', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(60, ' Work in Progress', ' Work in Progress', '170000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(61, ' Other Assets', ' Other Assets', '171000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(62, ' Prepaid Expenses', ' Prepaid Expenses', '172000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(63, ' Refundable Deposits', ' Refundable Deposits', '173000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(64, ' Undeposited Funds', ' Undeposited Funds', '174000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(65, ' Reserve - G/L Insurance', ' Reserve - G/L Insurance', '175000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(66, ' Reserve - Work Comp', ' Reserve - Work Comp', '176000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(67, ' Reserve - Warranty', ' Reserve - Warranty', '177000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(68, ' Shop Inventory', ' Shop Inventory', '178000', 0, 3, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(69, ' Fixed Assets-General', ' Fixed Assets-General', '180000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(70, ' Business Vehicles', ' Business Vehicles', '181000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(71, ' Tools & Equipment', ' Tools & Equipment', '182000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(72, ' Office Furninshings & Equip', ' Office Furninshings & Equip', '183000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(73, ' Model Home Furnishings', ' Model Home Furnishings', '183500', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(74, ' Office/Shop Buildings', ' Office/Shop Buildings', '184000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(75, ' Leasehold Improvements', ' Leasehold Improvements', '184500', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(76, ' Fixed Assets-Other', ' Fixed Assets-Other', '184900', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(77, ' Accumulated Dep-General', ' Accumulated Dep-General', '185000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(78, ' Accumulated Dep-Vehicles', ' Accumulated Dep-Vehicles', '186000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(79, ' Accumulated Dep-Tools', ' Accumulated Dep-Tools', '187000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(80, ' Accumulated Dep-Office Equipment', ' Accumulated Dep-Office Equipment', '188000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(81, ' Accumulated Dep-Model Furnishings', ' Accumulated Dep-Model Furnishings', '188500', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(82, ' Accumulated Dep-Buildings', ' Accumulated Dep-Buildings', '189000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(83, ' Accumulated Dep-Lease Improvements', ' Accumulated Dep-Lease Improvements', '189500', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(84, ' Accumulated Dep-Other', ' Accumulated Dep-Other', '189900', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(85, ' Depreciated Assets-General', ' Depreciated Assets-General', '190000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(86, ' Depreciated Vehicles', ' Depreciated Vehicles', '191000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(87, ' Depreciated Tools/Equipment', ' Depreciated Tools/Equipment', '192000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(88, ' Depreciated Office Equipment', ' Depreciated Office Equipment', '193000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(89, ' Depreciated Model Furnshings', ' Depreciated Model Furnshings', '193500', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(90, ' Depreciated Buildings', ' Depreciated Buildings', '194000', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(91, ' Depreciated Lease Improvements', ' Depreciated Lease Improvements', '194500', 0, 4, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(92, 'LIABILITIES', 'LIABILITIES', '200000', 0, 5, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(93, ' Accounts Payable', ' Accounts Payable', '200000', 0, 5, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(94, ' Retainage Payable', ' Retainage Payable', '201000', 0, 5, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(95, ' Business Taxes Payable', ' Business Taxes Payable', '202000', 0, 5, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(96, ' Open Purchase Orders', ' Open Purchase Orders', '204000', 0, 5, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(97, ' Credit Card #1', ' Credit Card #1', '205000', 0, 6, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(98, ' Credit Card #2', ' Credit Card #2', '206000', 0, 6, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(99, ' Short Term Loans', ' Short Term Loans', '210000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(100, ' [Name - Loan #1]', ' [Name - Loan #1]', '210100', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(101, ' [Name - Loan #2]', ' [Name - Loan #2]', '210200', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(102, ' [Name - Loan #3]', ' [Name - Loan #3]', '210300', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(103, ' Loans from Principals', ' Loans from Principals', '211000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(104, ' [Name - Loan #1]', ' [Name - Loan #1]', '211100', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(105, ' [Name - Loan #2]', ' [Name - Loan #2]', '211200', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(106, ' [Name - Loan #3]', ' [Name - Loan #3]', '211300', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(107, ' Construction Loans', ' Construction Loans', '220000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(108, ' Other Current Liabilities', ' Other Current Liabilities', '230000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(109, ' G/L Insurance (on revenue)', ' G/L Insurance (on revenue)', '231000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(110, ' Contract Deposits', ' Contract Deposits', '232000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(111, ' Lease Deposits', ' Lease Deposits', '233000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(112, ' Payroll Liabilities', ' Payroll Liabilities', '240000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(113, ' Employee Fed Tax Withholdings', ' Employee Fed Tax Withholdings', '240500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(114, ' Employee Soc. Sec. Withholdings', ' Employee Soc. Sec. Withholdings', '241000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(115, ' Employee Medicare Withholdings', ' Employee Medicare Withholdings', '241500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(116, ' Employee State Tax Withholdings', ' Employee State Tax Withholdings', '242000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(117, ' Employee Local Tax Withholdings', ' Employee Local Tax Withholdings', '242500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(118, ' Company Soc. Sec. Liability', ' Company Soc. Sec. Liability', '243000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(119, ' Company Medicare Liability', ' Company Medicare Liability', '243500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(120, ' Fed Unemployment Tax Liability', ' Fed Unemployment Tax Liability', '244000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(121, ' St Unemployment Tax Liability', ' St Unemployment Tax Liability', '244500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(122, ' State Employment Taxes Owed', ' State Employment Taxes Owed', '245000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(123, ' Local Employment Taxes Owed', ' Local Employment Taxes Owed', '245500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(124, ' Company Paid Health Insurance', ' Company Paid Health Insurance', '246000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(125, ' Employee Paid Health Insurance', ' Employee Paid Health Insurance', '246500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(126, ' W/C Insurance Liability', ' W/C Insurance Liability', '247000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(127, ' G/L Insurance (on payroll)', ' G/L Insurance (on payroll)', '247500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(128, ' Company Paid Benefits', ' Company Paid Benefits', '247600', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(129, ' Accrued Vacation/Sick time', ' Accrued Vacation/Sick time', '248000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(130, ' Retirement Plan Contributions', ' Retirement Plan Contributions', '249000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(131, ' Contract Draw Liabilities', ' Contract Draw Liabilities', '250000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(132, ' Vendor Liabilities', ' Vendor Liabilities', '255000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(133, 'Vendor Insurance Liabilities', 'Vendor Insurance Liabilities', '255500', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(134, ' Vehicle/Equipment Loans', ' Vehicle/Equipment Loans', '260000', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(135, ' Payee Name - Loan #1', ' Payee Name - Loan #1', '260100', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(136, ' Payee Name - Loan #2', ' Payee Name - Loan #2', '260200', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(137, ' Payee Name - Loan #3', ' Payee Name - Loan #3', '260300', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(138, ' Mortgages Owned', ' Mortgages Owned', '270000', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(139, ' Street Address - Unit #1', ' Street Address - Unit #1', '270100', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(140, ' Street Address - Unit #2', ' Street Address - Unit #2', '270200', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(141, ' Street Address - Unit #3', ' Street Address - Unit #3', '270300', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(142, 'R/E Development Loans', 'R/E Development Loans', '280000', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(143, ' Subdivision - Loan #1', ' Subdivision - Loan #1', '280100', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(144, ' Subdivision - Loan #2', ' Subdivision - Loan #2', '280200', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(145, ' Subdivision - Loan #3', ' Subdivision - Loan #3', '280300', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(146, ' Owner\'s Equity', ' Owner\'s Equity', '290000', 0, 9, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(147, ' Capitol Stock', ' Capitol Stock', '291000', 0, 9, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(148, ' Revenue in Excess of Costs', ' Revenue in Excess of Costs', '292000', 0, 9, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(149, ' Retained Earnings', ' Retained Earnings', '299000', 0, 9, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(150, 'INCOME', 'INCOME', '300000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(151, ' Construction Revenue', ' Construction Revenue', '300000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(152, ' Construction Loan Draws', ' Construction Loan Draws', '305000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(153, ' Land / Lot Sales', ' Land / Lot Sales', '310000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(154, ' Residential Construction', ' Residential Construction', '320000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(155, ' Residential Remodeling', ' Residential Remodeling', '330000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(156, ' Commercial Construction', ' Commercial Construction', '340000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(157, ' Commercial Remodeling', ' Commercial Remodeling', '350000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(158, ' Shop Projects', ' Shop Projects', '360000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(159, ' Professional Services', ' Professional Services', '370000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(160, ' Inspection Services', ' Inspection Services', '371000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(161, ' Design/Drafting Services', ' Design/Drafting Services', '372000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(162, ' Estimating Services', ' Estimating Services', '373000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(163, ' Construction Management', ' Construction Management', '374000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(164, ' Property Management', ' Property Management', '375000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(165, ' Referrals & Commissions', ' Referrals & Commissions', '379000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(166, ' Subcontracting', ' Subcontracting', '380000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(167, ' Rental Property Income', ' Rental Property Income', '390000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(168, ' Interest Income', ' Interest Income', '395000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(169, ' Discounts Taken', ' Discounts Taken', '396000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(170, ' Gain/Loss Sale of Assets', ' Gain/Loss Sale of Assets', '397000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(171, ' Miscellaneous Income', ' Miscellaneous Income', '398000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(172, ' Transferred to Acct #2200 CLD', ' Transferred to Acct #2200 CLD', '399000', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(173, ' Transferred to Acct #2500 CDL', ' Transferred to Acct #2500 CDL', '399500', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(174, ' Perm Uncategorized Income', ' Perm Uncategorized Income', '399800', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(175, ' Temp Uncategorized Income', ' Temp Uncategorized Income', '399900', 0, 10, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(176, 'DIRECT EXPENSES (Construction Costs)', 'DIRECT EXPENSES (Construction Costs)', '400000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(177, 'OTHER DIRECT EXPENSES', 'OTHER DIRECT EXPENSES', '440000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(178, ' SUBCONTRATING COSTS', ' SUBCONTRATING COSTS', '440000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(179, ' Subcontracted Costs - Uncategorized', ' Subcontracted Costs - Uncategorized', '441000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(180, ' Materials - Uncategorized', ' Materials - Uncategorized', '442000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(181, ' Labor - Uncategorized', ' Labor - Uncategorized', '443000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(182, ' Rental - Uncategorized', ' Rental - Uncategorized', '444000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(183, ' [unit cost assembly #1]', ' [unit cost assembly #1]', '445000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(184, ' [unit cost assembly #2]', ' [unit cost assembly #2]', '445100', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(185, ' [unit cost assembly #3]', ' [unit cost assembly #3]', '445200', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(186, ' SHOP COSTS', ' SHOP COSTS', '450000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(187, ' Shop Costs-General', ' Shop Costs-General', '451000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(188, ' Shop Materials', ' Shop Materials', '452000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(189, ' Shop Labor', ' Shop Labor', '453000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(190, ' Shop Rental', ' Shop Rental', '454000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(191, ' Shop Overhead', ' Shop Overhead', '455000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(192, ' RENTAL PROPERTY COSTS', ' RENTAL PROPERTY COSTS', '460000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(193, ' Acquisition Costs', ' Acquisition Costs', '461000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(194, ' Rental Commissions', ' Rental Commissions', '461500', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(195, ' Management Fees', ' Management Fees', '462000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(196, ' Advertising', ' Advertising', '462500', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(197, ' Credit Checks', ' Credit Checks', '463000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(198, ' Maintenance & Repairs', ' Maintenance & Repairs', '463500', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(199, ' Cleaning', ' Cleaning', '464000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(200, ' Pest Control', ' Pest Control', '464500', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(201, ' Insurance', ' Insurance', '465000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(202, ' Utilities', ' Utilities', '465500', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(203, ' Property Taxes', ' Property Taxes', '466000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(204, ' Legal Expenses', ' Legal Expenses', '466500', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(205, ' Sales taxes (on leases)', ' Sales taxes (on leases)', '467000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(206, ' PROFESSIONAL SERVICE COSTS', ' PROFESSIONAL SERVICE COSTS', '470000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(207, ' DESIGN SERVICE COSTS', ' DESIGN SERVICE COSTS', '480000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(208, ' Design Fees', ' Design Fees', '481000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(209, ' Drafting Supplies', ' Drafting Supplies', '482000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(210, ' Copying & Blueprinting', ' Copying & Blueprinting', '483000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(211, ' Delivery & Shipping', ' Delivery & Shipping', '484000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(212, ' MISCELLANEOUS', ' MISCELLANEOUS', '490000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(213, ' Transferred to Acct #1500 INV', ' Transferred to Acct #1500 INV', '499000', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(214, ' Transferred to Acct #1700 WIP', ' Transferred to Acct #1700 WIP', '499500', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(215, ' Perm Uncategorized Job Costs', ' Perm Uncategorized Job Costs', '499800', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(216, ' Temp Uncategorized Job Costs', ' Temp Uncategorized Job Costs', '499900', 0, 11, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(217, ' SALES AND MARKETING', ' SALES AND MARKETING', '500000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(218, ' Preliminary Designs', ' Preliminary Designs', '500500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(219, ' Advertising', ' Advertising', '501000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(220, ' Promotional Events', ' Promotional Events', '502000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(221, ' Promotional Literature', ' Promotional Literature', '503000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(222, ' Displays/Product Samples', ' Displays/Product Samples', '503500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(223, ' Signage', ' Signage', '504000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(224, ' Model Home Lease', ' Model Home Lease', '505000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(225, ' Model Home Insurance', ' Model Home Insurance', '505100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(226, ' Model Home Security', ' Model Home Security', '505200', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(227, ' Model Home Maintenance', ' Model Home Maintenance', '505300', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(228, ' Model Home HOA Fees', ' Model Home HOA Fees', '505400', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(229, ' Model Home Phone', ' Model Home Phone', '505500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(230, ' Model Home Utilities', ' Model Home Utilities', '505600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(231, ' Model Home Reception', ' Model Home Reception', '505700', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(232, ' Model Home Furnishings', ' Model Home Furnishings', '505800', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(233, ' Model Home Decorating', ' Model Home Decorating', '505900', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(234, ' Model Home Miscellaneous', ' Model Home Miscellaneous', '506000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(235, ' Sales & Marketing Expense-Other', ' Sales & Marketing Expense-Other', '509000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(236, ' PERSONNEL EXPENSES', ' PERSONNEL EXPENSES', '510000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(237, ' Office/Clerical Personnel', ' Office/Clerical Personnel', '510500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(238, ' Bookkeeping Personnel', ' Bookkeeping Personnel', '511000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(239, ' Estimating/Purchasing Personnel', ' Estimating/Purchasing Personnel', '511500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(240, ' Estimating/Sales Personnel', ' Estimating/Sales Personnel', '512000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(241, ' Design/Sales Personnel', ' Design/Sales Personnel', '512500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(242, ' Sales Management Personnel', ' Sales Management Personnel', '513000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(243, ' Project Management Personnel', ' Project Management Personnel', '513500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(244, ' Field Supervisory Personnel', ' Field Supervisory Personnel', '514000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(245, ' Undistributed Field Labor', ' Undistributed Field Labor', '514500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(246, ' Employee Bonuses', ' Employee Bonuses', '515000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(247, ' Employee Sick Pay', ' Employee Sick Pay', '515500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(248, ' Employee Vacation Pay', ' Employee Vacation Pay', '515600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(249, ' Company Paid Medicare (FICA)', ' Company Paid Medicare (FICA)', '516000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(250, ' Company Paid Soc. Sec. (FICA)', ' Company Paid Soc. Sec. (FICA)', '516100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(251, ' Federal Unemployment Tax (FUTA)', ' Federal Unemployment Tax (FUTA)', '516500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(252, ' State Unemployment Tax (SUTA)', ' State Unemployment Tax (SUTA)', '516600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(253, ' Local Payroll Taxes', ' Local Payroll Taxes', '516700', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(254, ' Workers Comp Insurance', ' Workers Comp Insurance', '517000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(255, ' Co. Paid Health Insurance', ' Co. Paid Health Insurance', '517500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(256, ' Co. Paid Disability Insurance', ' Co. Paid Disability Insurance', '517600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(257, ' Co. Paid Retirement Plan', ' Co. Paid Retirement Plan', '517700', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(258, ' Employment Advertising', ' Employment Advertising', '518000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(259, ' Recruiting & Hiring', ' Recruiting & Hiring', '518100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(260, ' Training & Education', ' Training & Education', '518200', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(261, ' Employee Entertainment', ' Employee Entertainment', '518300', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(262, ' Payroll Service Fees', ' Payroll Service Fees', '518400', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(263, ' Prior Period Payroll Taxes', ' Prior Period Payroll Taxes', '519000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(264, ' Prior Period FICA', ' Prior Period FICA', '519100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(265, ' Prior Period FUTA', ' Prior Period FUTA', '519200', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(266, ' Prior Period SUTA', ' Prior Period SUTA', '519300', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(267, ' Prior Period Local Taxes', ' Prior Period Local Taxes', '519400', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(268, ' Prior Period Payroll Tax-Other', ' Prior Period Payroll Tax-Other', '519500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(269, ' BUSINESS OVERHEAD', ' BUSINESS OVERHEAD', '520000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(270, ' Accounting Fees', ' Accounting Fees', '520500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(271, ' Association Dues', ' Association Dues', '521000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(272, ' Association Functions', ' Association Functions', '521500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(273, ' Attorney Costs/Expenses', ' Attorney Costs/Expenses', '522000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(274, ' Attorney Fees', ' Attorney Fees', '522500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(275, ' Bad Debts', ' Bad Debts', '523000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(276, ' Bank Account Finance Charges', ' Bank Account Finance Charges', '523500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(277, ' Bank Account Service Fees', ' Bank Account Service Fees', '524000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(278, ' Blueprinting', ' Blueprinting', '524500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(279, ' Bonding', ' Bonding', '525000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(280, ' Bookkeeping Fees', ' Bookkeeping Fees', '525500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(281, ' Charitable Contributions', ' Charitable Contributions', '526000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(282, ' Client Entertainment', ' Client Entertainment', '526500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(283, ' Computer Software', ' Computer Software', '527000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(284, ' Consultant-Business', ' Consultant-Business', '527500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(285, ' Consultant-Computer', ' Consultant-Computer', '528000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(286, ' Consultant-PR/Marketing', ' Consultant-PR/Marketing', '528500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(287, ' Consumable Tools', ' Consumable Tools', '529000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(288, ' Corporation Fees & Costs', ' Corporation Fees & Costs', '529500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(289, ' Credit Card Finance Charges', ' Credit Card Finance Charges', '530000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(290, ' Credit Card Service Fees', ' Credit Card Service Fees', '530500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(291, ' Equipment Lease-Copier', ' Equipment Lease-Copier', '531000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(292, ' Equipment Lease-Office', ' Equipment Lease-Office', '531500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(293, ' Equipment Lease-Postage Meter', ' Equipment Lease-Postage Meter', '532000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(294, ' Equipment Lease-Tools', ' Equipment Lease-Tools', '532500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(295, ' Equipment Maintanence & Repairs', ' Equipment Maintanence & Repairs', '533000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(296, ' Estimating / Selling', ' Estimating / Selling', '533500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(297, ' Insurance-Bonding', ' Insurance-Bonding', '534000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(298, ' Insurance-Builders Risk Policy', ' Insurance-Builders Risk Policy', '534500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(299, ' Insurance-Completed Operations', ' Insurance-Completed Operations', '535000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(300, ' Insurance-G/L (on payroll)', ' Insurance-G/L (on payroll)', '535500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(301, ' Insurance-G/L (on revenue)', ' Insurance-G/L (on revenue)', '536000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(302, ' Insurance-Life (lender req\'d)', ' Insurance-Life (lender req\'d)', '536500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(303, ' Insurance-Life (on employees)', ' Insurance-Life (on employees)', '537000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(304, ' Insurance-Other', ' Insurance-Other', '537500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(305, ' Insurance-Rental Equipment', ' Insurance-Rental Equipment', '538000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(306, ' Insurance-Vehicles', ' Insurance-Vehicles', '538500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(307, ' Interest-Inventory Houses', ' Interest-Inventory Houses', '539000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(308, ' Interest-Inventory Lots', ' Interest-Inventory Lots', '539500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(309, ' Interest-Loans', ' Interest-Loans', '540000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(310, ' Internet Service Provider', ' Internet Service Provider', '540500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(311, ' Internet Web Site', ' Internet Web Site', '541000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(312, ' Mailbox Rental', ' Mailbox Rental', '541500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(313, ' Mileage Reimbursement', ' Mileage Reimbursement', '542000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(314, ' Minor Medical Expenses', ' Minor Medical Expenses', '542500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(315, ' Miscellaneous Overhead Costs', ' Miscellaneous Overhead Costs', '543000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(316, ' Mobile Radio Service', ' Mobile Radio Service', '543500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(317, ' Office Building Maintenance', ' Office Building Maintenance', '544000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(318, ' Office Cleaning Service', ' Office Cleaning Service', '544500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(319, ' Office Equip Maint. & Repairs', ' Office Equip Maint. & Repairs', '545000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(320, ' Office Misc. Expenses', ' Office Misc. Expenses', '545500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(321, ' Office Rent/Lease', ' Office Rent/Lease', '546000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(322, ' Office Security Monitoring', ' Office Security Monitoring', '546500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(323, ' Office Storage', ' Office Storage', '547000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(324, ' Office Supplies', ' Office Supplies', '547500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(325, ' Office Utilities', ' Office Utilities', '548000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(326, ' Packing/Shipping Service', ' Packing/Shipping Service', '548500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(327, ' Pager Service', ' Pager Service', '549000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(328, ' Photography', ' Photography', '549500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(329, ' Postage (USPS)', ' Postage (USPS)', '550000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(330, ' Printing & Copying', ' Printing & Copying', '550500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(331, ' Professional Licensing Fees', ' Professional Licensing Fees', '551000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(332, ' Publications & Subscriptions', ' Publications & Subscriptions', '551500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(333, ' Shipping (Commercial Carrier)', ' Shipping (Commercial Carrier)', '552000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(334, ' Shop Bldg Maintenance', ' Shop Bldg Maintenance', '552500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(335, ' Shop Cleaning Service', ' Shop Cleaning Service', '553000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(336, ' Shop Equipment Lease(s)', ' Shop Equipment Lease(s)', '553500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(337, ' Shop Equipment Maintenance', ' Shop Equipment Maintenance', '554000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(338, ' Shop Misc. Expenses', ' Shop Misc. Expenses', '554500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(339, ' Shop Property Taxes', ' Shop Property Taxes', '555000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(340, ' Shop Rent/Lease', ' Shop Rent/Lease', '555500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(341, ' Shop Utilities', ' Shop Utilities', '556000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(342, ' Stock Dividends', ' Stock Dividends', '556500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(343, ' Taxes-Business License', ' Taxes-Business License', '557000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(344, ' Taxes-Business Property', ' Taxes-Business Property', '557500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(345, ' Taxes-Corporate Income', ' Taxes-Corporate Income', '558000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(346, ' Taxes-Gross Sales', ' Taxes-Gross Sales', '558500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(347, ' Taxes-Inventory', ' Taxes-Inventory', '559000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(348, ' Taxes-Office Property', ' Taxes-Office Property', '559500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(349, ' Taxes-Other', ' Taxes-Other', '560000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(350, ' Taxes-Retail Sales', ' Taxes-Retail Sales', '560500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(351, ' Taxes-Vehicle', ' Taxes-Vehicle', '561000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(352, ' Telephone-Answering Service', ' Telephone-Answering Service', '561500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(353, ' Telephone-Cellular Service', ' Telephone-Cellular Service', '562000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(354, ' Telephone-ISDN Line', ' Telephone-ISDN Line', '562500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(355, ' Telephone-Local Service', ' Telephone-Local Service', '563000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(356, ' Telephone-Long Dist Service', ' Telephone-Long Dist Service', '563500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(357, ' Tolls & Parking', ' Tolls & Parking', '564000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(358, ' Tool Maintenance & Repairs', ' Tool Maintenance & Repairs', '564500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(359, ' Travel', ' Travel', '565000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(360, ' Travel-Airfare', ' Travel-Airfare', '565500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(361, ' Travel-Car Rental', ' Travel-Car Rental', '566000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(362, ' Travel-Hotel', ' Travel-Hotel', '566500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(363, ' Travel-Food & Entertainment', ' Travel-Food & Entertainment', '567000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(364, ' Travel-Miscellaneous', ' Travel-Miscellaneous', '567500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(365, ' Uniforms', ' Uniforms', '568000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(366, ' Vehicle Fuel & Oil', ' Vehicle Fuel & Oil', '568500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(367, ' Vehicle Maintenance & Repairs', ' Vehicle Maintenance & Repairs', '569000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(368, ' Vehicle Leases', ' Vehicle Leases', '569500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(369, ' Voided Check', ' Voided Check', '570000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(370, ' Warranty Program Fee', ' Warranty Program Fee', '570500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(371, ' Workers Comp (policy fees)', ' Workers Comp (policy fees)', '571000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(372, ' DEPRECIATION & AMORITIZATION', ' DEPRECIATION & AMORITIZATION', '590000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(373, ' Amortization-Lease Improvements', ' Amortization-Lease Improvements', '590500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(374, ' Amortization-Organizing Costs', ' Amortization-Organizing Costs', '591000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(375, ' Depreciation-General', ' Depreciation-General', '595000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(376, ' Depreciation-Buildings', ' Depreciation-Buildings', '595500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(377, ' Depreciation-Company Vehicles', ' Depreciation-Company Vehicles', '596000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(378, ' Depreciation-Model Furnshings', ' Depreciation-Model Furnshings', '597000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(379, ' Depreciation-Office Equipment', ' Depreciation-Office Equipment', '597500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(380, ' Depreciation-Tools & Equipment', ' Depreciation-Tools & Equipment', '598000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(381, ' Perm Uncategorized Overhead', ' Perm Uncategorized Overhead', '599800', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(382, ' Temp Uncategorized Overhead', ' Temp Uncategorized Overhead', '599900', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(383, 'OWNER\'S COMPENSATION', 'OWNER\'S COMPENSATION', '600000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(384, ' Owner\'s Salary (payroll)', ' Owner\'s Salary (payroll)', '601000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(385, ' Checks Cashed by Owner', ' Checks Cashed by Owner', '601100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(386, ' Stock Dividend / Profit Dist.', ' Stock Dividend / Profit Dist.', '601500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(387, ' Checks to Spouse', ' Checks to Spouse', '602000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(388, ' Checks to Dependents', ' Checks to Dependents', '602100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(389, ' Checks to Relatives', ' Checks to Relatives', '602200', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(390, ' Checks to Friends', ' Checks to Friends', '602300', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(391, ' Checks to Associates', ' Checks to Associates', '602400', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(392, ' Checks for Spouse', ' Checks for Spouse', '602500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(393, ' Checks for Dependents', ' Checks for Dependents', '602600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(394, ' Checks for Relatives', ' Checks for Relatives', '602700', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(395, ' Checks for Friends', ' Checks for Friends', '602800', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(396, ' Checks for Associates', ' Checks for Associates', '602900', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(397, ' Personal Mortgage Payment', ' Personal Mortgage Payment', '603000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(398, ' Personal Utility Bills', ' Personal Utility Bills', '604000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(399, ' Personal Credit Cards', ' Personal Credit Cards', '605000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(400, ' Personal Vehicle Payment', ' Personal Vehicle Payment', '606000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(401, ' Personal Vehicle Gas & Oil', ' Personal Vehicle Gas & Oil', '606100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(402, ' Personal Vehicle Repairs', ' Personal Vehicle Repairs', '606200', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(403, ' Personal Vehicle Insurance', ' Personal Vehicle Insurance', '606300', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(404, ' Personal Vehicle Misc.', ' Personal Vehicle Misc.', '606500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(405, ' Personal Health Insurance', ' Personal Health Insurance', '607000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(406, ' Personal Life Insurance', ' Personal Life Insurance', '607100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(407, ' Personal Legal Expenses', ' Personal Legal Expenses', '608000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(408, ' Personal Accounting Expenses', ' Personal Accounting Expenses', '608100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(409, ' Personal Tax Payment', ' Personal Tax Payment', '608500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(410, ' Personal Property Taxes', ' Personal Property Taxes', '608600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(411, ' [enter additional accounts]', ' [enter additional accounts]', '609000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(412, ' Misc. Owners Compensation', ' Misc. Owners Compensation', '609900', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(413, ' OWNER #2 COMPENSATION', ' OWNER #2 COMPENSATION', '610000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(414, ' Owner #2 Salary (payroll)', ' Owner #2 Salary (payroll)', '611000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(415, ' Checks Cashed by Owner #2', ' Checks Cashed by Owner #2', '611100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(416, ' Stock Dividend / Profit Dist.', ' Stock Dividend / Profit Dist.', '611500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(417, ' Checks to Spouse', ' Checks to Spouse', '612000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(418, ' Checks to Dependents', ' Checks to Dependents', '612100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(419, ' Checks to Relatives', ' Checks to Relatives', '612200', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(420, ' Checks to Friends', ' Checks to Friends', '612300', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(421, ' Checks to Associates', ' Checks to Associates', '612400', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(422, ' Checks for Spouse', ' Checks for Spouse', '612500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(423, ' Checks for Dependents', ' Checks for Dependents', '612600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(424, ' Checks for Relatives', ' Checks for Relatives', '612700', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(425, ' Checks for Friends', ' Checks for Friends', '612800', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(426, ' Checks for Associates', ' Checks for Associates', '612900', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(427, ' Personal Mortgage Payment', ' Personal Mortgage Payment', '613000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(428, ' Personal Utility Bills', ' Personal Utility Bills', '614000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(429, ' Personal Credit Cards', ' Personal Credit Cards', '615000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(430, ' Personal Vehicle Payment', ' Personal Vehicle Payment', '616000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(431, ' Personal Vehicle Gas & Oil', ' Personal Vehicle Gas & Oil', '616100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(432, ' Personal Vehicle Repairs', ' Personal Vehicle Repairs', '616200', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(433, ' Personal Health Insurance', ' Personal Health Insurance', '617000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(434, ' Personal Life Insurance', ' Personal Life Insurance', '617100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(435, ' Personal Legal Expenses', ' Personal Legal Expenses', '618000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(436, ' Personal Accounting Expenses', ' Personal Accounting Expenses', '618100', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(437, ' Personal Tax Payment', ' Personal Tax Payment', '618500', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(438, ' Personal Property Taxes', ' Personal Property Taxes', '618600', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(439, ' [enter additional accounts]', ' [enter additional accounts]', '619000', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(440, ' Misc. Owners Compensation', ' Misc. Owners Compensation', '619900', 0, 12, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(441, 'NON-POSTING ACCOUNTS', 'NON-POSTING ACCOUNTS', '700000', 0, 14, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(442, ' Purchase Orders', ' Purchase Orders', '700000', 0, 14, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(443, ' Estimates', ' Estimates', '800000', 0, 14, 2, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(444, 'testingo', 'testingo', '10000', 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-11 10:46:45'),
	(445, 'testingox', 'testingx', '100', 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-11 11:09:13'),
	(446, 'asdass', 'sdfdsfsss', '343242400', 0, 3, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 2, '2011-12-11 11:12:15'),
	(447, ' Subdivision - Loan #3', ' Subdivision - Loan #3', '280300', 0, 8, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(448, 'Fee', 'Fee', '234000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(449, 'Share', 'Share', '235000', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(450, 'debtor1', 'Fee', '234001', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(451, 'debtor2', 'Fee', '234002', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(452, 'debtor3', 'Fee', '234003', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(453, 'debtor4', 'Fee', '234004', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(454, 'debtor5', 'Fee', '234005', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(455, 'debtor1', 'Share', '235001', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(456, 'debtor2', 'Share', '235002', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(457, 'debtor3', 'Share', '235003', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(458, 'debtor4', 'Share', '235004', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(459, 'debtor5', 'Share', '235005', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33'),
	(460, 'debtor6', 'Share', '235006', 0, 7, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, '2011-12-01 16:48:33');
/*!40000 ALTER TABLE `generalLedgerChartOfAccount` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccountAccess
DROP TABLE IF EXISTS `generalLedgerChartOfAccountAccess`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccountAccess` (
  `folderAccessId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Access|',
  `staffId` int(11) NOT NULL COMMENT 'Group|',
  `generalLedgerChartOfAccountAccessId` int(11) NOT NULL COMMENT 'Folder|',
  `generalLedgerChartOfAccountAccessValue` tinyint(1) NOT NULL COMMENT 'Value|',
  PRIMARY KEY (`folderAccessId`),
  KEY `groupId` (`staffId`),
  KEY `folderId` (`generalLedgerChartOfAccountAccessId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table iFinancial.generalLedgerChartOfAccountAccess: ~0 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccountAccess` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalLedgerChartOfAccountAccess` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccountCategory
DROP TABLE IF EXISTS `generalLedgerChartOfAccountCategory`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccountCategory` (
  `generalLedgerChartOfAccountCategoryId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountCategorySequence` int(11) NOT NULL,
  `generalLedgerChartOfAccountCategoryCode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountCategoryDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountCategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerChartOfAccountCategory: ~0 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccountCategory` DISABLE KEYS */;
INSERT INTO `generalLedgerChartOfAccountCategory` (`generalLedgerChartOfAccountCategoryId`, `generalLedgerChartOfAccountCategorySequence`, `generalLedgerChartOfAccountCategoryCode`, `generalLedgerChartOfAccountCategoryDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, 'A', 'Asset', 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, '2011-12-12 15:45:49'),
	(2, 2, 'L', 'Liability', 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, '2011-12-12 15:45:49'),
	(3, 3, 'I', 'Income', 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, '2011-12-12 15:45:49'),
	(4, 4, 'E', 'Expenses', 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, '2011-12-12 15:45:49');
/*!40000 ALTER TABLE `generalLedgerChartOfAccountCategory` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccountDimension
DROP TABLE IF EXISTS `generalLedgerChartOfAccountDimension`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccountDimension` (
  `generalLedgerChartOfAccountDimensionId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountDimensionType` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '''Range'',''Formula''',
  `generalLedgerChartOfAccountDimensionTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountDimensionDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountIdStart` int(11) NOT NULL,
  `generalLedgerChartOfAccountIdEnd` int(11) NOT NULL,
  `generalLedgerChartOfAccountDimensionFormula` text COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountDimensionId`),
  KEY `generalLedgerChartOfAccountIdStart` (`generalLedgerChartOfAccountIdStart`),
  KEY `generalLedgerChartOfAccountIdEnd` (`generalLedgerChartOfAccountIdEnd`),
  CONSTRAINT `generalledgerchartofaccountdimension_ibfk_1` FOREIGN KEY (`generalLedgerChartOfAccountIdStart`) REFERENCES `generalLedgerChartOfAccount` (`generalLedgerChartOfAccountId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `generalledgerchartofaccountdimension_ibfk_2` FOREIGN KEY (`generalLedgerChartOfAccountIdEnd`) REFERENCES `generalLedgerChartOfAccount` (`generalLedgerChartOfAccountId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerChartOfAccountDimension: ~2 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccountDimension` DISABLE KEYS */;
INSERT INTO `generalLedgerChartOfAccountDimension` (`generalLedgerChartOfAccountDimensionId`, `generalLedgerChartOfAccountDimensionType`, `generalLedgerChartOfAccountDimensionTitle`, `generalLedgerChartOfAccountDimensionDesc`, `generalLedgerChartOfAccountIdStart`, `generalLedgerChartOfAccountIdEnd`, `generalLedgerChartOfAccountDimensionFormula`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, '', 'Bank', 'Bank', 10, 19, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00'),
	(4, '', '', 'sdfds', 10, 14, '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-09 20:37:50');
/*!40000 ALTER TABLE `generalLedgerChartOfAccountDimension` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccountReportType
DROP TABLE IF EXISTS `generalLedgerChartOfAccountReportType`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccountReportType` (
  `generalLedgerChartOfAccountReportTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountReportTypeSequence` int(11) NOT NULL,
  `generalLedgerChartOfAccountReportTypeCode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountReportTypeDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountReportTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerChartOfAccountReportType: ~2 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccountReportType` DISABLE KEYS */;
INSERT INTO `generalLedgerChartOfAccountReportType` (`generalLedgerChartOfAccountReportTypeId`, `generalLedgerChartOfAccountReportTypeSequence`, `generalLedgerChartOfAccountReportTypeCode`, `generalLedgerChartOfAccountReportTypeDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, '', 'Balance Sheet', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-10 16:02:12'),
	(2, 2, '', 'Profit and Loss', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-10 16:02:12');
/*!40000 ALTER TABLE `generalLedgerChartOfAccountReportType` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccountSegment
DROP TABLE IF EXISTS `generalLedgerChartOfAccountSegment`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccountSegment` (
  `generalLedgerChartOfAccountSegmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountSegmentTypeId` int(11) NOT NULL,
  `generalLedgerChartOfAccountSegmentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountSegmentLength` int(11) NOT NULL,
  `generalLedgerChartOfAccountSegmentTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountSegmentDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountSegmentId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerChartOfAccountSegment: ~4 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccountSegment` DISABLE KEYS */;
INSERT INTO `generalLedgerChartOfAccountSegment` (`generalLedgerChartOfAccountSegmentId`, `generalLedgerChartOfAccountSegmentTypeId`, `generalLedgerChartOfAccountSegmentNo`, `generalLedgerChartOfAccountSegmentLength`, `generalLedgerChartOfAccountSegmentTitle`, `generalLedgerChartOfAccountSegmentDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, '1', 1, 'Title', 'Title', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-02 15:57:21'),
	(2, 1, '1', 1, 'Sub Account', 'Sub Account', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-02 15:57:21'),
	(3, 1, '1', 3, 'Detail Account', 'Detail Account', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-02 15:57:21'),
	(4, 0, '12', 22, 'testingo3', 'description34', 0, 0, 0, 0, 1, 0, 0, 0, 0, 2, '2011-12-03 12:27:22');
/*!40000 ALTER TABLE `generalLedgerChartOfAccountSegment` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccountSegmentType
DROP TABLE IF EXISTS `generalLedgerChartOfAccountSegmentType`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccountSegmentType` (
  `generalLedgerChartOfAccountSegmentTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountSegmentTypeSequence` int(11) NOT NULL,
  `generalLedgerChartOfAccountSegmentTypeCode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountSegmentTypeDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountSegmentTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerChartOfAccountSegmentType: ~3 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccountSegmentType` DISABLE KEYS */;
INSERT INTO `generalLedgerChartOfAccountSegmentType` (`generalLedgerChartOfAccountSegmentTypeId`, `generalLedgerChartOfAccountSegmentTypeSequence`, `generalLedgerChartOfAccountSegmentTypeCode`, `generalLedgerChartOfAccountSegmentTypeDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, 'NMRC', 'Numeric', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00'),
	(2, 2, 'ALNM', 'AlphaNumeric', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00'),
	(3, 3, 'ALBC', 'Alphabetic', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `generalLedgerChartOfAccountSegmentType` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerChartOfAccountType
DROP TABLE IF EXISTS `generalLedgerChartOfAccountType`;
CREATE TABLE IF NOT EXISTS `generalLedgerChartOfAccountType` (
  `generalLedgerChartOfAccountTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountCategoryId` int(11) NOT NULL,
  `generalLedgerChartOfAccountTypeSequence` int(11) NOT NULL,
  `generalLedgerChartOfAccountTypeCode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountTypeDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerChartOfAccountType: ~14 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerChartOfAccountType` DISABLE KEYS */;
INSERT INTO `generalLedgerChartOfAccountType` (`generalLedgerChartOfAccountTypeId`, `generalLedgerChartOfAccountCategoryId`, `generalLedgerChartOfAccountTypeSequence`, `generalLedgerChartOfAccountTypeCode`, `generalLedgerChartOfAccountTypeDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, 0, '', 'Bank', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(2, 1, 0, '', 'Accounts Receivable', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(3, 1, 0, '', 'Other Current Asset', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(4, 1, 0, '', 'Fixed Asset', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(5, 2, 0, '', 'Accounts Payable', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(6, 2, 0, '', 'Credit Card', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(7, 2, 0, '', 'Other Current Liability', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(8, 2, 0, '', 'Long Term Liability', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(9, 2, 0, '', 'Equity', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(10, 3, 0, '', 'Income', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(11, 3, 0, '', 'Cost of Goods Sold', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(12, 4, 0, '', 'Expense', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(13, 4, 0, '', 'Non-Posting', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16'),
	(14, 4, 0, '', 'Unidentified', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-01 14:47:16');
/*!40000 ALTER TABLE `generalLedgerChartOfAccountType` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerForecast
DROP TABLE IF EXISTS `generalLedgerForecast`;
CREATE TABLE IF NOT EXISTS `generalLedgerForecast` (
  `generalLedgerForecastId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `generalLedgerForecastMonth` int(2) NOT NULL,
  `generalLedgerForecastYear` int(4) NOT NULL,
  `generalLedgerForecastAmount` double(12,2) NOT NULL,
  `generalLedgerForecastDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerForecastId`),
  KEY `generalLedgerChartOfAccountId` (`generalLedgerChartOfAccountId`),
  CONSTRAINT `generalledgerforecast_ibfk_1` FOREIGN KEY (`generalLedgerChartOfAccountId`) REFERENCES `generalLedgerChartOfAccount` (`generalLedgerChartOfAccountId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerForecast: ~0 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerForecast` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalLedgerForecast` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerForecastType
DROP TABLE IF EXISTS `generalLedgerForecastType`;
CREATE TABLE IF NOT EXISTS `generalLedgerForecastType` (
  `generalLedgerChartOfAccountTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartOfAccountTypeSequence` int(11) NOT NULL,
  `generalLedgerChartOfAccountTypeCode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountTypeDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartOfAccountTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerForecastType: ~3 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerForecastType` DISABLE KEYS */;
INSERT INTO `generalLedgerForecastType` (`generalLedgerChartOfAccountTypeId`, `generalLedgerChartOfAccountTypeSequence`, `generalLedgerChartOfAccountTypeCode`, `generalLedgerChartOfAccountTypeDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, '', 'Stagnant', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:00:30'),
	(2, 2, '', 'Increment', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:00:30'),
	(3, 3, '', 'Due Invoice(Aging)', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-13 11:00:30');
/*!40000 ALTER TABLE `generalLedgerForecastType` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerJournal
DROP TABLE IF EXISTS `generalLedgerJournal`;
CREATE TABLE IF NOT EXISTS `generalLedgerJournal` (
  `generalLedgerJournalId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerJournalTypeId` int(11) NOT NULL,
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `referenceNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerJournalTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerJournalDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerJournalDate` date NOT NULL,
  `generalLedgerJournalStartDate` date NOT NULL,
  `generalLedgerJournalEndDate` date NOT NULL,
  `generalLedgerJournalAmount` double(12,2) NOT NULL,
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
  PRIMARY KEY (`generalLedgerJournalId`),
  KEY `generalLedgerJournalTypeId` (`generalLedgerJournalTypeId`),
  CONSTRAINT `generalledgerjournal_ibfk_1` FOREIGN KEY (`generalLedgerJournalTypeId`) REFERENCES `generalLedgerJournalType` (`generalLedgerJournalTypeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerJournal: ~1 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerJournal` DISABLE KEYS */;
INSERT INTO `generalLedgerJournal` (`generalLedgerJournalId`, `generalLedgerJournalTypeId`, `documentNo`, `referenceNo`, `generalLedgerJournalTitle`, `generalLedgerJournalDesc`, `generalLedgerJournalDate`, `generalLedgerJournalStartDate`, `generalLedgerJournalEndDate`, `generalLedgerJournalAmount`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(42, 1, 'JRNL000039', 'MBBB10012', 'kambing', 'testingo<br>', '2011-12-12', '0000-00-00', '0000-00-00', 12000.00, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-12 15:36:44');
/*!40000 ALTER TABLE `generalLedgerJournal` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerJournalDetail
DROP TABLE IF EXISTS `generalLedgerJournalDetail`;
CREATE TABLE IF NOT EXISTS `generalLedgerJournalDetail` (
  `generalLedgerJournalDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerJournalId` int(11) NOT NULL,
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `transactionMode` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '''D''->Debit,''C''->Credit',
  `generalLedgerJournalDetailAmount` double(12,2) NOT NULL,
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
  PRIMARY KEY (`generalLedgerJournalDetailId`),
  KEY `generalLedgerJournalId` (`generalLedgerJournalId`),
  KEY `generalLedgerChartOfAccountId` (`generalLedgerChartOfAccountId`),
  KEY `countryId` (`countryId`),
  CONSTRAINT `generalledgerjournaldetail_ibfk_1` FOREIGN KEY (`generalLedgerJournalId`) REFERENCES `generalLedgerJournal` (`generalLedgerJournalId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `generalledgerjournaldetail_ibfk_2` FOREIGN KEY (`generalLedgerChartOfAccountId`) REFERENCES `generalLedgerChartOfAccount` (`generalLedgerChartOfAccountId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `generalledgerjournaldetail_ibfk_3` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerJournalDetail: ~2 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerJournalDetail` DISABLE KEYS */;
INSERT INTO `generalLedgerJournalDetail` (`generalLedgerJournalDetailId`, `generalLedgerJournalId`, `generalLedgerChartOfAccountId`, `countryId`, `transactionMode`, `generalLedgerJournalDetailAmount`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(5, 42, 9, 101, 'D', 12000.00, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-12 15:36:59'),
	(6, 42, 14, 101, 'C', 12000.00, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-12 15:37:15');
/*!40000 ALTER TABLE `generalLedgerJournalDetail` ENABLE KEYS */;


# Dumping structure for table iFinancial.generalLedgerJournalType
DROP TABLE IF EXISTS `generalLedgerJournalType`;
CREATE TABLE IF NOT EXISTS `generalLedgerJournalType` (
  `generalLedgerJournalTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerJournalTypeSequence` int(11) NOT NULL,
  `generalLedgerJournalCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerJournalTypeDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerJournalTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.generalLedgerJournalType: ~4 rows (approximately)
/*!40000 ALTER TABLE `generalLedgerJournalType` DISABLE KEYS */;
INSERT INTO `generalLedgerJournalType` (`generalLedgerJournalTypeId`, `generalLedgerJournalTypeSequence`, `generalLedgerJournalCode`, `generalLedgerJournalTypeDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, 'JRNL', 'Normal', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-02 14:53:55'),
	(2, 2, 'JRRG', 'Range', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-02 14:53:55'),
	(3, 3, 'JRME', 'Month End', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-02 14:53:55'),
	(4, 4, 'JRYE', 'Year End', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-12-02 14:53:55');
/*!40000 ALTER TABLE `generalLedgerJournalType` ENABLE KEYS */;


# Dumping structure for table iFinancial.invoiceDetailLedger
DROP TABLE IF EXISTS `invoiceDetailLedger`;
CREATE TABLE IF NOT EXISTS `invoiceDetailLedger` (
  `invoiceDetailLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `invoiceLedgerId` int(11) NOT NULL,
  `generalLedgerChartAccountNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `countryId` int(11) NOT NULL,
  `transactionMode` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '''D''->Debit,''C''->Credit',
  `amount` double(12,2) NOT NULL,
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

# Dumping data for table iFinancial.invoiceDetailLedger: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoiceDetailLedger` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoiceDetailLedger` ENABLE KEYS */;


# Dumping structure for table iFinancial.invoiceLedger
DROP TABLE IF EXISTS `invoiceLedger`;
CREATE TABLE IF NOT EXISTS `invoiceLedger` (
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

# Dumping data for table iFinancial.invoiceLedger: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoiceLedger` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoiceLedger` ENABLE KEYS */;


# Dumping structure for table iFinancial.invoiceProject
DROP TABLE IF EXISTS `invoiceProject`;
CREATE TABLE IF NOT EXISTS `invoiceProject` (
  `invoiceProjectId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`invoiceProjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.invoiceProject: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoiceProject` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoiceProject` ENABLE KEYS */;


# Dumping structure for table iFinancial.refund
DROP TABLE IF EXISTS `refund`;
CREATE TABLE IF NOT EXISTS `refund` (
  `refundId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `referenceNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `refundTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `refundDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `refundDate` date NOT NULL,
  `adjustmentAmount` double(12,2) NOT NULL,
  `businessPartnerId` int(11) NOT NULL,
  `invoiceProjectId` int(11) NOT NULL,
  `invoiceId` int(11) NOT NULL,
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
  PRIMARY KEY (`refundId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.refund: ~0 rows (approximately)
/*!40000 ALTER TABLE `refund` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund` ENABLE KEYS */;


# Dumping structure for table iFinancial.refundDetail
DROP TABLE IF EXISTS `refundDetail`;
CREATE TABLE IF NOT EXISTS `refundDetail` (
  `refundDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `refundId` int(11) NOT NULL,
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `transactionMode` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '''D''->Debit,''C''->Credit',
  `refundDetailAmount` double(12,2) NOT NULL,
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
  PRIMARY KEY (`refundDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.refundDetail: ~0 rows (approximately)
/*!40000 ALTER TABLE `refundDetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `refundDetail` ENABLE KEYS */;


# Dumping structure for table iFinancial.template
DROP TABLE IF EXISTS `template`;
CREATE TABLE IF NOT EXISTS `template` (
  `InvoiceProjectLateInterestId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `InvoiceProjectLateInterestDay` int(11) NOT NULL,
  `InvoiceProjectLateInterestTypeId` int(11) NOT NULL,
  `InvoiceProjectLateInterestValue` double(12,2) NOT NULL,
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
  PRIMARY KEY (`InvoiceProjectLateInterestId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

# Dumping data for table iFinancial.template: ~0 rows (approximately)
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
/*!40000 ALTER TABLE `template` ENABLE KEYS */;


# Dumping structure for table iFinancial.transactionDetailLedger
DROP TABLE IF EXISTS `transactionDetailLedger`;
CREATE TABLE IF NOT EXISTS `transactionDetailLedger` (
  `transactionDetailLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `transactionLedgerId` int(11) NOT NULL,
  `generalLedgerChartOfAccountNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `countryId` int(11) NOT NULL,
  `transactionMode` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '''D''->Debit,''C''->Credit',
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

# Dumping data for table iFinancial.transactionDetailLedger: ~0 rows (approximately)
/*!40000 ALTER TABLE `transactionDetailLedger` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactionDetailLedger` ENABLE KEYS */;


# Dumping structure for table iFinancial.transactionLedger
DROP TABLE IF EXISTS `transactionLedger`;
CREATE TABLE IF NOT EXISTS `transactionLedger` (
  `transactionLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `referenceNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
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

# Dumping data for table iFinancial.transactionLedger: ~0 rows (approximately)
/*!40000 ALTER TABLE `transactionLedger` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactionLedger` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
