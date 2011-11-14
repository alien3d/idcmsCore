# --------------------------------------------------------
# Host:                         192.168.0.123
# Server version:               5.5.10-log
# Server OS:                    Win64
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-11-12 18:20:00
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for northwindgood
DROP DATABASE IF EXISTS `northwindgood`;
CREATE DATABASE IF NOT EXISTS `northwindgood` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `northwindgood`;


# Dumping structure for table northwindgood.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
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

# Dumping data for table northwindgood.customers: ~29 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`customersId`, `customersCompany`, `customersLastName`, `customersFirstName`, `customersEmail`, `customersJobTitle`, `customersBusinessPhone`, `customersHomePhone`, `customersMobilePhone`, `customersFaxNum`, `customersAddress`, `customersCity`, `customersState`, `customersPostCode`, `customersCountry`, `customersWebPage`, `customersNotes`, `customersAttachments`) VALUES
	(1, 'Company A', 'Bedecs', 'Anna', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 1st Street', 'Seattle', 'WA', '99999', 'USA', NULL, NULL, NULL),
	(2, 'Company B', 'Gratacos Solsona', 'Antonio', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 2nd Street', 'Boston', 'MA', '99999', 'USA', NULL, NULL, NULL),
	(3, 'Company C', 'Axen', 'Thomas', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 3rd Street', 'Los Angelas', 'CA', '99999', 'USA', NULL, NULL, NULL),
	(4, 'Company D', 'Lee', 'Christina', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 4th Street', 'New York', 'NY', '99999', 'USA', NULL, NULL, NULL),
	(5, 'Company E', 'O’Donnell', 'Martin', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 5th Street', 'Minneapolis', 'MN', '99999', 'USA', NULL, NULL, NULL),
	(6, 'Company F', 'Pérez-Olaeta', 'Francisco', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', NULL, NULL, NULL),
	(7, 'Company G', 'Xie', 'Ming-Yang', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 7th Street', 'Boise', 'ID', '99999', 'USA', NULL, NULL, NULL),
	(8, 'Company H', 'Andersen', 'Elizabeth', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 8th Street', 'Portland', 'OR', '99999', 'USA', NULL, NULL, NULL),
	(9, 'Company I', 'Mortensen', 'Sven', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 9th Street', 'Salt Lake City', 'UT', '99999', 'USA', NULL, NULL, NULL),
	(10, 'Company J', 'Wacker', 'Roland', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 10th Street', 'Chicago', 'IL', '99999', 'USA', NULL, NULL, NULL),
	(11, 'Company K', 'Krschne', 'Peter', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 11th Street', 'Miami', 'FL', '99999', 'USA', NULL, NULL, NULL),
	(12, 'Company L', 'Edwards', 'John', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '123 12th Street', 'Las Vegas', 'NV', '99999', 'USA', NULL, NULL, NULL),
	(13, 'Company M', 'Ludick', 'Andre', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 13th Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL),
	(14, 'Company N', 'Grilo', 'Carlos', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 14th Street', 'Denver', 'CO', '99999', 'USA', NULL, NULL, NULL),
	(15, 'Company O', 'Kupkova', 'Helena', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 15th Street', 'Honolulu', 'HI', '99999', 'USA', NULL, NULL, NULL),
	(16, 'Company P', 'Goldschmidt', 'Daniel', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 16th Street', 'San Francisco', 'CA', '99999', 'USA', NULL, NULL, NULL),
	(17, 'Company Q', 'Bagel', 'Jean Philippe', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 17th Street', 'Seattle', 'WA', '99999', 'USA', NULL, NULL, NULL),
	(18, 'Company R', 'Autier Miconi', 'Catherine', NULL, 'Purchasing Representative', '(123)555-0100', NULL, NULL, '(123)555-0101', '456 18th Street', 'Boston', 'MA', '99999', 'USA', NULL, NULL, NULL),
	(19, 'Company S', 'Eggerer', 'Alexander', NULL, 'Accounting Assistant', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 19th Street', 'Los Angelas', 'CA', '99999', 'USA', NULL, NULL, NULL),
	(20, 'Company T', 'Li', 'George', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 20th Street', 'New York', 'NY', '99999', 'USA', NULL, NULL, NULL),
	(21, 'Company U', 'Tham', 'Bernard', NULL, 'Accounting Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 21th Street', 'Minneapolis', 'MN', '99999', 'USA', NULL, NULL, NULL),
	(22, 'Company V', 'Ramos', 'Luciana', NULL, 'Purchasing Assistant', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 22th Street', 'Milwaukee', 'WI', '99999', 'USA', NULL, NULL, NULL),
	(23, 'Company W', 'Entin', 'Michael', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 23th Street', 'Portland', 'OR', '99999', 'USA', NULL, NULL, NULL),
	(24, 'Company X', 'Hasselberg', 'Jonas', NULL, 'Owner', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 24th Street', 'Salt Lake City', 'UT', '99999', 'USA', NULL, NULL, NULL),
	(25, 'Company Y', 'Rodman', 'John', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 25th Street', 'Chicago', 'IL', '99999', 'USA', NULL, NULL, NULL),
	(26, 'Company Z', 'Liu', 'Run', NULL, 'Accounting Assistant', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 26th Street', 'Miami', 'FL', '99999', 'USA', NULL, NULL, NULL),
	(27, 'Company AA', 'Toh', 'Karen', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 27th Street', 'Las Vegas', 'NV', '99999', 'USA', NULL, NULL, NULL),
	(28, 'Company BB', 'Raghav', 'Amritansh', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 28th Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL),
	(29, 'Company CC', 'Lee', 'Soo Jung', NULL, 'Purchasing Manager', '(123)555-0100', NULL, NULL, '(123)555-0101', '789 29th Street', 'Denver', 'CO', '99999', 'USA', NULL, NULL, NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;


# Dumping structure for view northwindgood.customers extended
DROP VIEW IF EXISTS `customers extended`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `customers extended` (
	`File As` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`Contact Name` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersId` INT(10) NOT NULL DEFAULT '0',
	`customersCompany` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersLastName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersFirstName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersEmail` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersJobTitle` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf32_unicode_ci',
	`customersBusinessPhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersHomePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersMobilePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersFaxNum` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersAddress` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersCity` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersState` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersPostCode` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersCountry` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersWebPage` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersNotes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`customersAttachments` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;


# Dumping structure for table northwindgood.employeeprivileges
DROP TABLE IF EXISTS `employeeprivileges`;
CREATE TABLE IF NOT EXISTS `employeeprivileges` (
  `employeesId` int(10) NOT NULL,
  `privilegeId` int(10) NOT NULL,
  PRIMARY KEY (`employeesId`,`privilegeId`),
  KEY `EmployeePriviligesforEmployees` (`employeesId`),
  KEY `EmployeePriviligesLookup` (`privilegeId`),
  KEY `New_EmployeePriviligesforEmploy` (`employeesId`),
  KEY `New_EmployeePriviligesLookup` (`privilegeId`),
  KEY `Privilege ID` (`privilegeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.employeeprivileges: ~1 rows (approximately)
/*!40000 ALTER TABLE `employeeprivileges` DISABLE KEYS */;
INSERT INTO `employeeprivileges` (`employeesId`, `privilegeId`) VALUES
	(2, 2);
/*!40000 ALTER TABLE `employeeprivileges` ENABLE KEYS */;


# Dumping structure for table northwindgood.employees
DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
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

# Dumping data for table northwindgood.employees: ~9 rows (approximately)
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` (`employeesId`, `employeesCompany`, `employeesLastName`, `employeesFirstName`, `employeesEmail`, `employeesJobTitle`, `employeesBusinessPhone`, `employeesHomePhone`, `employeesMobilePhone`, `employeesFaxNum`, `employeesAddress`, `employeesCity`, `employeesState`, `employeesPostCode`, `employeesCountry`, `employeesWebPage`, `employeesNotes`, `employeesAttachments`) VALUES
	(1, 'Northwind Traders', 'Freehafer', 'Nancy', 'nancy@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 1st Avenue', 'Seattle', 'WA', '99999', 'USA', '#http://northwindtraders.com#', NULL, NULL),
	(2, 'Northwind Traders', 'Cencini', 'Andrew', 'andrew@northwindtraders.com', 'Vice President, Sales', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 2nd Avenue', 'Bellevue', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Joined the company as a sales representative, was promoted to sales manager and was then named vice president of sales.', NULL),
	(3, 'Northwind Traders', 'Kotas', 'Jan', 'jan@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 3rd Avenue', 'Redmond', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Was hired as a sales associate and was promoted to sales representative.', NULL),
	(4, 'Northwind Traders', 'Sergienko', 'Mariya', 'mariya@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 4th Avenue', 'Kirkland', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', NULL, NULL),
	(5, 'Northwind Traders', 'Thorpe', 'Steven', 'steven@northwindtraders.com', 'Sales Manager', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 5th Avenue', 'Seattle', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Joined the company as a sales representative and was promoted to sales manager.  Fluent in French.', NULL),
	(6, 'Northwind Traders', 'Neipper', 'Michael', 'michael@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 6th Avenue', 'Redmond', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Fluent in Japanese and can read and write French, Portuguese, and Spanish.', NULL),
	(7, 'Northwind Traders', 'Zare', 'Robert', 'robert@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 7th Avenue', 'Seattle', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', NULL, NULL),
	(8, 'Northwind Traders', 'Giussani', 'Laura', 'laura@northwindtraders.com', 'Sales Coordinator', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 8th Avenue', 'Redmond', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Reads and writes French.', NULL),
	(9, 'Northwind Traders', 'Hellung-Larsen', 'Anne', 'anne@northwindtraders.com', 'Sales Representative', '(123)555-0100', '(123)555-0102', NULL, '(123)555-0103', '123 9th Avenue', 'Seattle', 'WA', '99999', 'USA', 'http://northwindtraders.com#http://northwindtraders.com/#', 'Fluent in French and German.', NULL);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;


# Dumping structure for view northwindgood.employees extended
DROP VIEW IF EXISTS `employees extended`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `employees extended` (
	`File As` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`Employee Name` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesId` INT(10) NOT NULL DEFAULT '0',
	`employeesCompany` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesLastName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesFirstName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesEmail` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesJobTitle` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesBusinessPhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesHomePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesMobilePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesFaxNum` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesAddress` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesCity` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesState` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesPostCode` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesCountry` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesWebPage` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesNotes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`employeesAttachments` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;


# Dumping structure for view northwindgood.inventory on hold
DROP VIEW IF EXISTS `inventory on hold`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `inventory on hold` (
	`productsId` INT(10) NOT NULL DEFAULT '',
	`Quantity On Hold` DECIMAL(31,0) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for view northwindgood.inventory on order
DROP VIEW IF EXISTS `inventory on order`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `inventory on order` (
	`productsId` INT(10) NULL DEFAULT NULL,
	`Quantity On Order` DECIMAL(40,4) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for view northwindgood.inventory purchased
DROP VIEW IF EXISTS `inventory purchased`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `inventory purchased` (
	`productsId` INT(10) NOT NULL DEFAULT '',
	`Quantity Purchased` DECIMAL(31,0) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for view northwindgood.inventory sold
DROP VIEW IF EXISTS `inventory sold`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `inventory sold` (
	`productsId` INT(10) NOT NULL DEFAULT '',
	`Quantity Sold` DECIMAL(31,0) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for table northwindgood.inventorytransactions
DROP TABLE IF EXISTS `inventorytransactions`;
CREATE TABLE IF NOT EXISTS `inventorytransactions` (
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

# Dumping data for table northwindgood.inventorytransactions: ~102 rows (approximately)
/*!40000 ALTER TABLE `inventorytransactions` DISABLE KEYS */;
INSERT INTO `inventorytransactions` (`inventoryTransactionsId`, `inventoryTransactionsTypesId`, `inventoryTransactionsCreatedDate`, `inventoryTransactionsModifiedDate`, `productsId`, `inventoryTransactionsQuantity`, `purchaseOrdersID`, `customerOrdersId`, `inventoryTransactionsComments`) VALUES
	(35, 1, '2006-03-22 16:02:28', '2006-03-22 16:02:28', 80, 75, NULL, NULL, NULL),
	(36, 1, '2006-03-22 16:02:48', '2006-03-22 16:02:48', 72, 40, NULL, NULL, NULL),
	(37, 1, '2006-03-22 16:03:04', '2006-03-22 16:03:04', 52, 100, NULL, NULL, NULL),
	(38, 1, '2006-03-22 16:03:09', '2006-03-22 16:03:09', 56, 120, NULL, NULL, NULL),
	(39, 1, '2006-03-22 16:03:14', '2006-03-22 16:03:14', 57, 80, NULL, NULL, NULL),
	(40, 1, '2006-03-22 16:03:40', '2006-03-22 16:03:40', 6, 100, NULL, NULL, NULL),
	(41, 1, '2006-03-22 16:03:47', '2006-03-22 16:03:47', 7, 40, NULL, NULL, NULL),
	(42, 1, '2006-03-22 16:03:54', '2006-03-22 16:03:54', 8, 40, NULL, NULL, NULL),
	(43, 1, '2006-03-22 16:04:02', '2006-03-22 16:04:02', 14, 40, NULL, NULL, NULL),
	(44, 1, '2006-03-22 16:04:07', '2006-03-22 16:04:07', 17, 40, NULL, NULL, NULL),
	(45, 1, '2006-03-22 16:04:12', '2006-03-22 16:04:12', 19, 20, NULL, NULL, NULL),
	(46, 1, '2006-03-22 16:04:17', '2006-03-22 16:04:17', 20, 40, NULL, NULL, NULL),
	(47, 1, '2006-03-22 16:04:20', '2006-03-22 16:04:20', 21, 20, NULL, NULL, NULL),
	(48, 1, '2006-03-22 16:04:24', '2006-03-22 16:04:24', 40, 120, NULL, NULL, NULL),
	(49, 1, '2006-03-22 16:04:28', '2006-03-22 16:04:28', 41, 40, NULL, NULL, NULL),
	(50, 1, '2006-03-22 16:04:31', '2006-03-22 16:04:31', 48, 100, NULL, NULL, NULL),
	(51, 1, '2006-03-22 16:04:38', '2006-03-22 16:04:38', 51, 40, NULL, NULL, NULL),
	(52, 1, '2006-03-22 16:04:41', '2006-03-22 16:04:41', 74, 20, NULL, NULL, NULL),
	(53, 1, '2006-03-22 16:04:45', '2006-03-22 16:04:45', 77, 60, NULL, NULL, NULL),
	(54, 1, '2006-03-22 16:05:07', '2006-03-22 16:05:07', 3, 100, NULL, NULL, NULL),
	(55, 1, '2006-03-22 16:05:11', '2006-03-22 16:05:11', 4, 40, NULL, NULL, NULL),
	(56, 1, '2006-03-22 16:05:14', '2006-03-22 16:05:14', 5, 40, NULL, NULL, NULL),
	(57, 1, '2006-03-22 16:05:26', '2006-03-22 16:05:26', 65, 40, NULL, NULL, NULL),
	(58, 1, '2006-03-22 16:05:32', '2006-03-22 16:05:32', 66, 80, NULL, NULL, NULL),
	(59, 1, '2006-03-22 16:05:47', '2006-03-22 16:05:47', 1, 40, NULL, NULL, NULL),
	(60, 1, '2006-03-22 16:05:51', '2006-03-22 16:05:51', 34, 60, NULL, NULL, NULL),
	(61, 1, '2006-03-22 16:06:00', '2006-03-22 16:06:00', 43, 100, NULL, NULL, NULL),
	(62, 1, '2006-03-22 16:06:03', '2006-03-22 16:06:03', 81, 125, NULL, NULL, NULL),
	(63, 2, '2006-03-22 16:07:56', '2006-03-24 11:03:00', 80, 30, NULL, NULL, NULL),
	(64, 2, '2006-03-22 16:08:19', '2006-03-22 16:08:59', 7, 10, NULL, NULL, NULL),
	(65, 2, '2006-03-22 16:08:29', '2006-03-22 16:08:59', 51, 10, NULL, NULL, NULL),
	(66, 2, '2006-03-22 16:08:37', '2006-03-22 16:08:59', 80, 10, NULL, NULL, NULL),
	(67, 2, '2006-03-22 16:09:46', '2006-03-22 16:10:27', 1, 15, NULL, NULL, NULL),
	(68, 2, '2006-03-22 16:10:06', '2006-03-22 16:10:27', 43, 20, NULL, NULL, NULL),
	(69, 2, '2006-03-22 16:11:39', '2006-03-24 11:00:55', 19, 20, NULL, NULL, NULL),
	(70, 2, '2006-03-22 16:11:56', '2006-03-24 10:59:41', 48, 10, NULL, NULL, NULL),
	(71, 2, '2006-03-22 16:12:29', '2006-03-24 10:57:38', 8, 17, NULL, NULL, NULL),
	(72, 1, '2006-03-24 10:41:30', '2006-03-24 10:41:30', 81, 200, NULL, NULL, NULL),
	(73, 2, '2006-03-24 10:41:33', '2006-03-24 10:41:42', 81, 200, NULL, NULL, 'Fill Back Ordered product, Order #40'),
	(74, 1, '2006-03-24 10:53:13', '2006-03-24 10:53:13', 48, 100, NULL, NULL, NULL),
	(75, 2, '2006-03-24 10:53:16', '2006-03-24 10:55:46', 48, 100, NULL, NULL, 'Fill Back Ordered product, Order #39'),
	(76, 1, '2006-03-24 10:53:36', '2006-03-24 10:53:36', 43, 300, NULL, NULL, NULL),
	(77, 2, '2006-03-24 10:53:39', '2006-03-24 10:56:57', 43, 300, NULL, NULL, 'Fill Back Ordered product, Order #38'),
	(78, 1, '2006-03-24 10:54:04', '2006-03-24 10:54:04', 41, 200, NULL, NULL, NULL),
	(79, 2, '2006-03-24 10:54:07', '2006-03-24 10:58:40', 41, 200, NULL, NULL, 'Fill Back Ordered product, Order #36'),
	(80, 1, '2006-03-24 10:54:33', '2006-03-24 10:54:33', 19, 30, NULL, NULL, NULL),
	(81, 2, '2006-03-24 10:54:35', '2006-03-24 11:02:02', 19, 30, NULL, NULL, 'Fill Back Ordered product, Order #33'),
	(82, 1, '2006-03-24 10:54:58', '2006-03-24 10:54:58', 34, 100, NULL, NULL, NULL),
	(83, 2, '2006-03-24 10:55:02', '2006-03-24 11:03:00', 34, 100, NULL, NULL, 'Fill Back Ordered product, Order #30'),
	(84, 2, '2006-03-24 14:48:15', '2006-04-04 11:41:14', 6, 10, NULL, NULL, NULL),
	(85, 2, '2006-03-24 14:48:23', '2006-04-04 11:41:14', 4, 10, NULL, NULL, NULL),
	(86, 3, '2006-03-24 14:49:16', '2006-03-24 14:49:16', 80, 20, NULL, NULL, NULL),
	(87, 3, '2006-03-24 14:49:20', '2006-03-24 14:49:20', 81, 50, NULL, NULL, NULL),
	(88, 3, '2006-03-24 14:50:09', '2006-03-24 14:50:09', 1, 25, NULL, NULL, NULL),
	(89, 3, '2006-03-24 14:50:14', '2006-03-24 14:50:14', 43, 25, NULL, NULL, NULL),
	(90, 3, '2006-03-24 14:50:18', '2006-03-24 14:50:18', 81, 25, NULL, NULL, NULL),
	(91, 2, '2006-03-24 14:51:03', '2006-04-04 11:09:24', 40, 50, NULL, NULL, NULL),
	(92, 2, '2006-03-24 14:55:03', '2006-04-04 11:06:56', 21, 20, NULL, NULL, NULL),
	(93, 2, '2006-03-24 14:55:39', '2006-04-04 11:06:13', 5, 25, NULL, NULL, NULL),
	(94, 2, '2006-03-24 14:55:52', '2006-04-04 11:06:13', 41, 30, NULL, NULL, NULL),
	(95, 2, '2006-03-24 14:56:09', '2006-04-04 11:06:13', 40, 30, NULL, NULL, NULL),
	(96, 3, '2006-03-30 16:46:34', '2006-03-30 16:46:34', 34, 12, NULL, NULL, NULL),
	(97, 3, '2006-03-30 17:23:27', '2006-03-30 17:23:27', 34, 10, NULL, NULL, NULL),
	(98, 3, '2006-03-30 17:24:33', '2006-03-30 17:24:33', 34, 1, NULL, NULL, NULL),
	(99, 2, '2006-04-03 13:50:08', '2006-04-03 13:50:15', 48, 10, NULL, NULL, NULL),
	(100, 1, '2006-04-04 11:00:54', '2006-04-04 11:00:54', 57, 100, NULL, NULL, NULL),
	(101, 2, '2006-04-04 11:00:56', '2006-04-04 11:08:49', 57, 100, NULL, NULL, 'Fill Back Ordered product, Order #46'),
	(102, 1, '2006-04-04 11:01:14', '2006-04-04 11:01:14', 34, 50, NULL, NULL, NULL),
	(103, 1, '2006-04-04 11:01:35', '2006-04-04 11:01:35', 43, 250, NULL, NULL, NULL),
	(104, 3, '2006-04-04 11:01:37', '2006-04-04 11:01:37', 43, 300, NULL, NULL, 'Fill Back Ordered product, Order #41'),
	(105, 1, '2006-04-04 11:01:55', '2006-04-04 11:01:55', 8, 25, NULL, NULL, NULL),
	(106, 2, '2006-04-04 11:01:58', '2006-04-04 11:07:37', 8, 25, NULL, NULL, 'Fill Back Ordered product, Order #48'),
	(107, 1, '2006-04-04 11:02:17', '2006-04-04 11:02:17', 34, 300, NULL, NULL, NULL),
	(108, 2, '2006-04-04 11:02:19', '2006-04-04 11:08:14', 34, 300, NULL, NULL, 'Fill Back Ordered product, Order #47'),
	(109, 1, '2006-04-04 11:02:37', '2006-04-04 11:02:37', 19, 25, NULL, NULL, NULL),
	(110, 2, '2006-04-04 11:02:39', '2006-04-04 11:41:14', 19, 10, NULL, NULL, 'Fill Back Ordered product, Order #42'),
	(111, 1, '2006-04-04 11:02:56', '2006-04-04 11:02:56', 19, 10, NULL, NULL, NULL),
	(112, 2, '2006-04-04 11:02:58', '2006-04-04 11:07:37', 19, 25, NULL, NULL, 'Fill Back Ordered product, Order #48'),
	(113, 1, '2006-04-04 11:03:12', '2006-04-04 11:03:12', 72, 50, NULL, NULL, NULL),
	(114, 2, '2006-04-04 11:03:14', '2006-04-04 11:08:49', 72, 50, NULL, NULL, 'Fill Back Ordered product, Order #46'),
	(115, 1, '2006-04-04 11:03:38', '2006-04-04 11:03:38', 41, 50, NULL, NULL, NULL),
	(116, 2, '2006-04-04 11:03:39', '2006-04-04 11:09:24', 41, 50, NULL, NULL, 'Fill Back Ordered product, Order #45'),
	(117, 2, '2006-04-04 11:04:55', '2006-04-04 11:05:04', 34, 87, NULL, NULL, NULL),
	(118, 2, '2006-04-04 11:35:50', '2006-04-04 11:35:54', 51, 30, NULL, NULL, NULL),
	(119, 2, '2006-04-04 11:35:51', '2006-04-04 11:35:54', 7, 30, NULL, NULL, NULL),
	(120, 2, '2006-04-04 11:36:15', '2006-04-04 11:36:21', 17, 40, NULL, NULL, NULL),
	(121, 2, '2006-04-04 11:36:39', '2006-04-04 11:36:47', 6, 90, NULL, NULL, NULL),
	(122, 2, '2006-04-04 11:37:06', '2006-04-04 11:37:09', 4, 30, NULL, NULL, NULL),
	(123, 2, '2006-04-04 11:37:45', '2006-04-04 11:37:49', 48, 40, NULL, NULL, NULL),
	(124, 2, '2006-04-04 11:38:07', '2006-04-04 11:38:11', 48, 40, NULL, NULL, NULL),
	(125, 2, '2006-04-04 11:38:27', '2006-04-04 11:38:32', 41, 10, NULL, NULL, NULL),
	(126, 2, '2006-04-04 11:38:48', '2006-04-04 11:38:53', 43, 5, NULL, NULL, NULL),
	(127, 2, '2006-04-04 11:39:12', '2006-04-04 11:39:29', 40, 40, NULL, NULL, NULL),
	(128, 2, '2006-04-04 11:39:50', '2006-04-04 11:39:53', 8, 20, NULL, NULL, NULL),
	(129, 2, '2006-04-04 11:40:13', '2006-04-04 11:40:16', 80, 15, NULL, NULL, NULL),
	(130, 2, '2006-04-04 11:40:32', '2006-04-04 11:40:38', 74, 20, NULL, NULL, NULL),
	(131, 2, '2006-04-04 11:41:39', '2006-04-04 11:41:45', 72, 40, NULL, NULL, NULL),
	(132, 2, '2006-04-04 11:42:17', '2006-04-04 11:42:26', 3, 50, NULL, NULL, NULL),
	(133, 2, '2006-04-04 11:42:24', '2006-04-04 11:42:26', 8, 3, NULL, NULL, NULL),
	(134, 2, '2006-04-04 11:42:48', '2006-04-04 11:43:08', 20, 40, NULL, NULL, NULL),
	(135, 2, '2006-04-04 11:43:05', '2006-04-04 11:43:08', 52, 40, NULL, NULL, NULL),
	(136, 3, '2006-04-25 17:04:05', '2006-04-25 17:04:57', 56, 110, NULL, NULL, NULL);
/*!40000 ALTER TABLE `inventorytransactions` ENABLE KEYS */;


# Dumping structure for table northwindgood.inventorytransactiontypes
DROP TABLE IF EXISTS `inventorytransactiontypes`;
CREATE TABLE IF NOT EXISTS `inventorytransactiontypes` (
  `inventoryTransactionTypesId` int(10) NOT NULL,
  `inventoryTransactionTypesName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`inventoryTransactionTypesId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.inventorytransactiontypes: ~4 rows (approximately)
/*!40000 ALTER TABLE `inventorytransactiontypes` DISABLE KEYS */;
INSERT INTO `inventorytransactiontypes` (`inventoryTransactionTypesId`, `inventoryTransactionTypesName`) VALUES
	(1, 'Purchased'),
	(2, 'Sold'),
	(3, 'On Hold'),
	(4, 'Waste');
/*!40000 ALTER TABLE `inventorytransactiontypes` ENABLE KEYS */;


# Dumping structure for table northwindgood.invoices
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
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

# Dumping data for table northwindgood.invoices: ~35 rows (approximately)
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` (`invoicesId`, `ordersId`, `invoicesDate`, `invoicesDueDate`, `invoicesTax`, `invoicesShipping`, `invoicesAmtDue`) VALUES
	(5, 31, '2006-03-22 16:08:59', NULL, 0.0000, 0.0000, 0.0000),
	(6, 32, '2006-03-22 16:10:27', NULL, 0.0000, 0.0000, 0.0000),
	(7, 40, '2006-03-24 10:41:41', NULL, 0.0000, 0.0000, 0.0000),
	(8, 39, '2006-03-24 10:55:46', NULL, 0.0000, 0.0000, 0.0000),
	(9, 38, '2006-03-24 10:56:57', NULL, 0.0000, 0.0000, 0.0000),
	(10, 37, '2006-03-24 10:57:38', NULL, 0.0000, 0.0000, 0.0000),
	(11, 36, '2006-03-24 10:58:40', NULL, 0.0000, 0.0000, 0.0000),
	(12, 35, '2006-03-24 10:59:41', NULL, 0.0000, 0.0000, 0.0000),
	(13, 34, '2006-03-24 11:00:55', NULL, 0.0000, 0.0000, 0.0000),
	(14, 33, '2006-03-24 11:02:02', NULL, 0.0000, 0.0000, 0.0000),
	(15, 30, '2006-03-24 11:03:00', NULL, 0.0000, 0.0000, 0.0000),
	(16, 56, '2006-04-03 13:50:15', NULL, 0.0000, 0.0000, 0.0000),
	(17, 55, '2006-04-04 11:05:04', NULL, 0.0000, 0.0000, 0.0000),
	(18, 51, '2006-04-04 11:06:13', NULL, 0.0000, 0.0000, 0.0000),
	(19, 50, '2006-04-04 11:06:56', NULL, 0.0000, 0.0000, 0.0000),
	(20, 48, '2006-04-04 11:07:37', NULL, 0.0000, 0.0000, 0.0000),
	(21, 47, '2006-04-04 11:08:14', NULL, 0.0000, 0.0000, 0.0000),
	(22, 46, '2006-04-04 11:08:49', NULL, 0.0000, 0.0000, 0.0000),
	(23, 45, '2006-04-04 11:09:24', NULL, 0.0000, 0.0000, 0.0000),
	(24, 79, '2006-04-04 11:35:54', NULL, 0.0000, 0.0000, 0.0000),
	(25, 78, '2006-04-04 11:36:21', NULL, 0.0000, 0.0000, 0.0000),
	(26, 77, '2006-04-04 11:36:47', NULL, 0.0000, 0.0000, 0.0000),
	(27, 76, '2006-04-04 11:37:09', NULL, 0.0000, 0.0000, 0.0000),
	(28, 75, '2006-04-04 11:37:49', NULL, 0.0000, 0.0000, 0.0000),
	(29, 74, '2006-04-04 11:38:11', NULL, 0.0000, 0.0000, 0.0000),
	(30, 73, '2006-04-04 11:38:32', NULL, 0.0000, 0.0000, 0.0000),
	(31, 72, '2006-04-04 11:38:53', NULL, 0.0000, 0.0000, 0.0000),
	(32, 71, '2006-04-04 11:39:29', NULL, 0.0000, 0.0000, 0.0000),
	(33, 70, '2006-04-04 11:39:53', NULL, 0.0000, 0.0000, 0.0000),
	(34, 69, '2006-04-04 11:40:16', NULL, 0.0000, 0.0000, 0.0000),
	(35, 67, '2006-04-04 11:40:38', NULL, 0.0000, 0.0000, 0.0000),
	(36, 42, '2006-04-04 11:41:14', NULL, 0.0000, 0.0000, 0.0000),
	(37, 60, '2006-04-04 11:41:45', NULL, 0.0000, 0.0000, 0.0000),
	(38, 63, '2006-04-04 11:42:26', NULL, 0.0000, 0.0000, 0.0000),
	(39, 58, '2006-04-04 11:43:08', NULL, 0.0000, 0.0000, 0.0000);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;


# Dumping structure for table northwindgood.orderdetailsstatus
DROP TABLE IF EXISTS `orderdetailsstatus`;
CREATE TABLE IF NOT EXISTS `orderdetailsstatus` (
  `orderDetailsStatusId` int(10) NOT NULL,
  `orderDetailsStatusName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`orderDetailsStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.orderdetailsstatus: ~6 rows (approximately)
/*!40000 ALTER TABLE `orderdetailsstatus` DISABLE KEYS */;
INSERT INTO `orderdetailsstatus` (`orderDetailsStatusId`, `orderDetailsStatusName`) VALUES
	(0, 'None'),
	(1, 'Allocated'),
	(2, 'Invoiced'),
	(3, 'Shipped'),
	(4, 'On Order'),
	(5, 'No Stock');
/*!40000 ALTER TABLE `orderdetailsstatus` ENABLE KEYS */;


# Dumping structure for table northwindgood.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `ordersId` int(10) NOT NULL AUTO_INCREMENT,
  `employeesId` int(10) DEFAULT NULL,
  `customersId` int(10) DEFAULT NULL,
  `ordersDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ordersShippedDate` datetime DEFAULT NULL,
  `shipperId` int(10) DEFAULT NULL,
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
  KEY `New_ShipperOnOrder` (`shipperId`),
  KEY `New_TaxStatusOnOrders` (`ordersTaxStatusId`),
  KEY `OrderStatus` (`ordersStatusId`),
  KEY `ShipperID` (`shipperId`),
  KEY `ShipperOnOrder` (`shipperId`),
  KEY `Status ID` (`ordersStatusId`),
  KEY `TaxStatusOnOrders` (`ordersTaxStatusId`),
  KEY `ZIP/Postal Code` (`ordersShipPostCode`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`shipperId`) REFERENCES `shippers` (`shippersId`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.orders: ~49 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`ordersId`, `employeesId`, `customersId`, `ordersDate`, `ordersShippedDate`, `shipperId`, `ordersShipName`, `ordersShipAddress`, `ordersShipCity`, `ordersShipState`, `ordersShipPostCode`, `ordersShipCountry`, `ordersShippingFee`, `ordersTaxes`, `ordersPaymentType`, `ordersPaidDate`, `ordersNotes`, `ordersTaxRate`, `ordersTaxStatusId`, `ordersStatusId`) VALUES
	(30, 9, 27, '2006-01-15 00:00:00', '2006-01-22 00:00:00', 2, 'Karen Toh', '789 27th Street', 'Las Vegas', 'NV', '99999', 'USA', 200.0000, 0.0000, 'Check', '2006-01-15 00:00:00', NULL, 0, NULL, 3),
	(31, 3, 4, '2006-01-20 00:00:00', '2006-01-22 00:00:00', 1, 'Christina Lee', '123 4th Street', 'New York', 'NY', '99999', 'USA', 5.0000, 0.0000, 'Credit Card', '2006-01-20 00:00:00', NULL, 0, NULL, 3),
	(32, 4, 12, '2006-01-22 00:00:00', '2006-01-22 00:00:00', 2, 'John Edwards', '123 12th Street', 'Las Vegas', 'NV', '99999', 'USA', 5.0000, 0.0000, 'Credit Card', '2006-01-22 00:00:00', NULL, 0, NULL, 3),
	(33, 6, 8, '2006-01-30 00:00:00', '2006-01-31 00:00:00', 3, 'Elizabeth Andersen', '123 8th Street', 'Portland', 'OR', '99999', 'USA', 50.0000, 0.0000, 'Credit Card', '2006-01-30 00:00:00', NULL, 0, NULL, 3),
	(34, 9, 4, '2006-02-06 00:00:00', '2006-02-07 00:00:00', 3, 'Christina Lee', '123 4th Street', 'New York', 'NY', '99999', 'USA', 4.0000, 0.0000, 'Check', '2006-02-06 00:00:00', NULL, 0, NULL, 3),
	(35, 3, 29, '2006-02-10 00:00:00', '2006-02-12 00:00:00', 2, 'Soo Jung Lee', '789 29th Street', 'Denver', 'CO', '99999', 'USA', 7.0000, 0.0000, 'Check', '2006-02-10 00:00:00', NULL, 0, NULL, 3),
	(36, 4, 3, '2006-02-23 00:00:00', '2006-02-25 00:00:00', 2, 'Thomas Axen', '123 3rd Street', 'Los Angelas', 'CA', '99999', 'USA', 7.0000, 0.0000, 'Cash', '2006-02-23 00:00:00', NULL, 0, NULL, 3),
	(37, 8, 6, '2006-03-06 00:00:00', '2006-03-09 00:00:00', 2, 'Francisco Pérez-Olaeta', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', 12.0000, 0.0000, 'Credit Card', '2006-03-06 00:00:00', NULL, 0, NULL, 3),
	(38, 9, 28, '2006-03-10 00:00:00', '2006-03-11 00:00:00', 3, 'Amritansh Raghav', '789 28th Street', 'Memphis', 'TN', '99999', 'USA', 10.0000, 0.0000, 'Check', '2006-03-10 00:00:00', NULL, 0, NULL, 3),
	(39, 3, 8, '2006-03-22 00:00:00', '2006-03-24 00:00:00', 3, 'Elizabeth Andersen', '123 8th Street', 'Portland', 'OR', '99999', 'USA', 5.0000, 0.0000, 'Check', '2006-03-22 00:00:00', NULL, 0, NULL, 3),
	(40, 4, 10, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, 'Roland Wacker', '123 10th Street', 'Chicago', 'IL', '99999', 'USA', 9.0000, 0.0000, 'Credit Card', '2006-03-24 00:00:00', NULL, 0, NULL, 3),
	(41, 1, 7, '2006-03-24 00:00:00', NULL, NULL, 'Ming-Yang Xie', '123 7th Street', 'Boise', 'ID', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(42, 1, 10, '2006-03-24 00:00:00', '2006-04-07 00:00:00', 1, 'Roland Wacker', '123 10th Street', 'Chicago', 'IL', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 2),
	(43, 1, 11, '2006-03-24 00:00:00', NULL, 3, 'Peter Krschne', '123 11th Street', 'Miami', 'FL', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(44, 1, 1, '2006-03-24 00:00:00', NULL, NULL, 'Anna Bedecs', '123 1st Street', 'Seattle', 'WA', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(45, 1, 28, '2006-04-07 00:00:00', '2006-04-07 00:00:00', 3, 'Amritansh Raghav', '789 28th Street', 'Memphis', 'TN', '99999', 'USA', 40.0000, 0.0000, 'Credit Card', '2006-04-07 00:00:00', NULL, 0, NULL, 3),
	(46, 7, 9, '2006-04-05 00:00:00', '2006-04-05 00:00:00', 1, 'Sven Mortensen', '123 9th Street', 'Salt Lake City', 'UT', '99999', 'USA', 100.0000, 0.0000, 'Check', '2006-04-05 00:00:00', NULL, 0, NULL, 3),
	(47, 6, 6, '2006-04-08 00:00:00', '2006-04-08 00:00:00', 2, 'Francisco Pérez-Olaeta', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', 300.0000, 0.0000, 'Credit Card', '2006-04-08 00:00:00', NULL, 0, NULL, 3),
	(48, 4, 8, '2006-04-05 00:00:00', '2006-04-05 00:00:00', 2, 'Elizabeth Andersen', '123 8th Street', 'Portland', 'OR', '99999', 'USA', 50.0000, 0.0000, 'Check', '2006-04-05 00:00:00', NULL, 0, NULL, 3),
	(50, 9, 25, '2006-04-05 00:00:00', '2006-04-05 00:00:00', 1, 'John Rodman', '789 25th Street', 'Chicago', 'IL', '99999', 'USA', 5.0000, 0.0000, 'Cash', '2006-04-05 00:00:00', NULL, 0, NULL, 3),
	(51, 9, 26, '2006-04-05 00:00:00', '2006-04-05 00:00:00', 3, 'Run Liu', '789 26th Street', 'Miami', 'FL', '99999', 'USA', 60.0000, 0.0000, 'Credit Card', '2006-04-05 00:00:00', NULL, 0, NULL, 3),
	(55, 1, 29, '2006-04-05 00:00:00', '2006-04-05 00:00:00', 2, 'Soo Jung Lee', '789 29th Street', 'Denver', 'CO', '99999', 'USA', 200.0000, 0.0000, 'Check', '2006-04-05 00:00:00', NULL, 0, NULL, 3),
	(56, 2, 6, '2006-04-03 00:00:00', '2006-04-03 00:00:00', 3, 'Francisco Pérez-Olaeta', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', 0.0000, 0.0000, 'Check', '2006-04-03 00:00:00', NULL, 0, NULL, 3),
	(57, 9, 27, '2006-04-22 00:00:00', '2006-04-22 00:00:00', 2, 'Karen Toh', '789 27th Street', 'Las Vegas', 'NV', '99999', 'USA', 200.0000, 0.0000, 'Check', '2006-04-22 00:00:00', NULL, 0, NULL, 0),
	(58, 3, 4, '2006-04-22 00:00:00', '2006-04-22 00:00:00', 1, 'Christina Lee', '123 4th Street', 'New York', 'NY', '99999', 'USA', 5.0000, 0.0000, 'Credit Card', '2006-04-22 00:00:00', NULL, 0, NULL, 3),
	(59, 4, 12, '2006-04-22 00:00:00', '2006-04-22 00:00:00', 2, 'John Edwards', '123 12th Street', 'Las Vegas', 'NV', '99999', 'USA', 5.0000, 0.0000, 'Credit Card', '2006-04-22 00:00:00', NULL, 0, NULL, 0),
	(60, 6, 8, '2006-04-30 00:00:00', '2006-04-30 00:00:00', 3, 'Elizabeth Andersen', '123 8th Street', 'Portland', 'OR', '99999', 'USA', 50.0000, 0.0000, 'Credit Card', '2006-04-30 00:00:00', NULL, 0, NULL, 3),
	(61, 9, 4, '2006-04-07 00:00:00', '2006-04-07 00:00:00', 3, 'Christina Lee', '123 4th Street', 'New York', 'NY', '99999', 'USA', 4.0000, 0.0000, 'Check', '2006-04-07 00:00:00', NULL, 0, NULL, 0),
	(62, 3, 29, '2006-04-12 00:00:00', '2006-04-12 00:00:00', 2, 'Soo Jung Lee', '789 29th Street', 'Denver', 'CO', '99999', 'USA', 7.0000, 0.0000, 'Check', '2006-04-12 00:00:00', NULL, 0, NULL, 0),
	(63, 4, 3, '2006-04-25 00:00:00', '2006-04-25 00:00:00', 2, 'Thomas Axen', '123 3rd Street', 'Los Angelas', 'CA', '99999', 'USA', 7.0000, 0.0000, 'Cash', '2006-04-25 00:00:00', NULL, 0, NULL, 3),
	(64, 8, 6, '2006-05-09 00:00:00', '2006-05-09 00:00:00', 2, 'Francisco Pérez-Olaeta', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', 12.0000, 0.0000, 'Credit Card', '2006-05-09 00:00:00', NULL, 0, NULL, 0),
	(65, 9, 28, '2006-05-11 00:00:00', '2006-05-11 00:00:00', 3, 'Amritansh Raghav', '789 28th Street', 'Memphis', 'TN', '99999', 'USA', 10.0000, 0.0000, 'Check', '2006-05-11 00:00:00', NULL, 0, NULL, 0),
	(66, 3, 8, '2006-05-24 00:00:00', '2006-05-24 00:00:00', 3, 'Elizabeth Andersen', '123 8th Street', 'Portland', 'OR', '99999', 'USA', 5.0000, 0.0000, 'Check', '2006-05-24 00:00:00', NULL, 0, NULL, 0),
	(67, 4, 10, '2006-05-24 00:00:00', '2006-05-24 00:00:00', 2, 'Roland Wacker', '123 10th Street', 'Chicago', 'IL', '99999', 'USA', 9.0000, 0.0000, 'Credit Card', '2006-05-24 00:00:00', NULL, 0, NULL, 3),
	(68, 1, 7, '2006-05-24 00:00:00', NULL, NULL, 'Ming-Yang Xie', '123 7th Street', 'Boise', 'ID', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(69, 1, 10, '2006-05-24 00:00:00', NULL, 1, 'Roland Wacker', '123 10th Street', 'Chicago', 'IL', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(70, 1, 11, '2006-05-24 00:00:00', NULL, 3, 'Peter Krschne', '123 11th Street', 'Miami', 'FL', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(71, 1, 1, '2006-05-24 00:00:00', NULL, 3, 'Anna Bedecs', '123 1st Street', 'Seattle', 'WA', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(72, 1, 28, '2006-06-07 00:00:00', '2006-06-07 00:00:00', 3, 'Amritansh Raghav', '789 28th Street', 'Memphis', 'TN', '99999', 'USA', 40.0000, 0.0000, 'Credit Card', '2006-06-07 00:00:00', NULL, 0, NULL, 3),
	(73, 7, 9, '2006-06-05 00:00:00', '2006-06-05 00:00:00', 1, 'Sven Mortensen', '123 9th Street', 'Salt Lake City', 'UT', '99999', 'USA', 100.0000, 0.0000, 'Check', '2006-06-05 00:00:00', NULL, 0, NULL, 3),
	(74, 6, 6, '2006-06-08 00:00:00', '2006-06-08 00:00:00', 2, 'Francisco Pérez-Olaeta', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', 300.0000, 0.0000, 'Credit Card', '2006-06-08 00:00:00', NULL, 0, NULL, 3),
	(75, 4, 8, '2006-06-05 00:00:00', '2006-06-05 00:00:00', 2, 'Elizabeth Andersen', '123 8th Street', 'Portland', 'OR', '99999', 'USA', 50.0000, 0.0000, 'Check', '2006-06-05 00:00:00', NULL, 0, NULL, 3),
	(76, 9, 25, '2006-06-05 00:00:00', '2006-06-05 00:00:00', 1, 'John Rodman', '789 25th Street', 'Chicago', 'IL', '99999', 'USA', 5.0000, 0.0000, 'Cash', '2006-06-05 00:00:00', NULL, 0, NULL, 3),
	(77, 9, 26, '2006-06-05 00:00:00', '2006-06-05 00:00:00', 3, 'Run Liu', '789 26th Street', 'Miami', 'FL', '99999', 'USA', 60.0000, 0.0000, 'Credit Card', '2006-06-05 00:00:00', NULL, 0, NULL, 3),
	(78, 1, 29, '2006-06-05 00:00:00', '2006-06-05 00:00:00', 2, 'Soo Jung Lee', '789 29th Street', 'Denver', 'CO', '99999', 'USA', 200.0000, 0.0000, 'Check', '2006-06-05 00:00:00', NULL, 0, NULL, 3),
	(79, 2, 6, '2006-06-23 00:00:00', '2006-06-23 00:00:00', 3, 'Francisco Pérez-Olaeta', '123 6th Street', 'Milwaukee', 'WI', '99999', 'USA', 0.0000, 0.0000, 'Check', '2006-06-23 00:00:00', NULL, 0, NULL, 3),
	(80, 2, 4, '2006-04-25 17:03:55', NULL, NULL, 'Christina Lee', '123 4th Street', 'New York', 'NY', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(81, 2, 3, '2006-04-25 17:26:53', NULL, NULL, 'Thomas Axen', '123 3rd Street', 'Los Angelas', 'CA', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0),
	(82, 2, 2, '2011-11-07 12:55:03', NULL, NULL, 'Antonio Gratacos Solsona', '123 2nd Street', 'Boston', 'MA', '99999', 'USA', 0.0000, 0.0000, NULL, NULL, NULL, 0, NULL, 0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


# Dumping structure for table northwindgood.ordersdetails
DROP TABLE IF EXISTS `ordersdetails`;
CREATE TABLE IF NOT EXISTS `ordersdetails` (
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

# Dumping data for table northwindgood.ordersdetails: ~58 rows (approximately)
/*!40000 ALTER TABLE `ordersdetails` DISABLE KEYS */;
INSERT INTO `ordersdetails` (`orderDetailsId`, `ordersId`, `productsId`, `ordersDetailsQuantity`, `ordersDetailsUnitPrice`, `ordersDetailsDiscount`, `ordersDetailsStatusId`, `ordersDetailsDateAllocated`, `purchaseOrdersId`, `inventoryId`) VALUES
	(27, 30, 34, 100.0000, 14.0000, 0, 2, NULL, 96, 83),
	(28, 30, 80, 30.0000, 3.5000, 0, 2, NULL, NULL, 63),
	(29, 31, 7, 10.0000, 30.0000, 0, 2, NULL, NULL, 64),
	(30, 31, 51, 10.0000, 53.0000, 0, 2, NULL, NULL, 65),
	(31, 31, 80, 10.0000, 3.5000, 0, 2, NULL, NULL, 66),
	(32, 32, 1, 15.0000, 18.0000, 0, 2, NULL, NULL, 67),
	(33, 32, 43, 20.0000, 46.0000, 0, 2, NULL, NULL, 68),
	(34, 33, 19, 30.0000, 9.2000, 0, 2, NULL, 97, 81),
	(35, 34, 19, 20.0000, 9.2000, 0, 2, NULL, NULL, 69),
	(36, 35, 48, 10.0000, 12.7500, 0, 2, NULL, NULL, 70),
	(37, 36, 41, 200.0000, 9.6500, 0, 2, NULL, 98, 79),
	(38, 37, 8, 17.0000, 40.0000, 0, 2, NULL, NULL, 71),
	(39, 38, 43, 300.0000, 46.0000, 0, 2, NULL, 99, 77),
	(40, 39, 48, 100.0000, 12.7500, 0, 2, NULL, 100, 75),
	(41, 40, 81, 200.0000, 2.9900, 0, 2, NULL, 101, 73),
	(42, 41, 43, 300.0000, 46.0000, 0, 1, NULL, 102, 104),
	(43, 42, 6, 10.0000, 25.0000, 0, 2, NULL, NULL, 84),
	(44, 42, 4, 10.0000, 22.0000, 0, 2, NULL, NULL, 85),
	(45, 42, 19, 10.0000, 9.2000, 0, 2, NULL, 103, 110),
	(46, 43, 80, 20.0000, 3.5000, 0, 1, NULL, NULL, 86),
	(47, 43, 81, 50.0000, 2.9900, 0, 1, NULL, NULL, 87),
	(48, 44, 1, 25.0000, 18.0000, 0, 1, NULL, NULL, 88),
	(49, 44, 43, 25.0000, 46.0000, 0, 1, NULL, NULL, 89),
	(50, 44, 81, 25.0000, 2.9900, 0, 1, NULL, NULL, 90),
	(51, 45, 41, 50.0000, 9.6500, 0, 2, NULL, 104, 116),
	(52, 45, 40, 50.0000, 18.4000, 0, 2, NULL, NULL, 91),
	(53, 46, 57, 100.0000, 19.5000, 0, 2, NULL, 105, 101),
	(54, 46, 72, 50.0000, 34.8000, 0, 2, NULL, 106, 114),
	(55, 47, 34, 300.0000, 14.0000, 0, 2, NULL, 107, 108),
	(56, 48, 8, 25.0000, 40.0000, 0, 2, NULL, 108, 106),
	(57, 48, 19, 25.0000, 9.2000, 0, 2, NULL, 109, 112),
	(59, 50, 21, 20.0000, 10.0000, 0, 2, NULL, NULL, 92),
	(60, 51, 5, 25.0000, 21.3500, 0, 2, NULL, NULL, 93),
	(61, 51, 41, 30.0000, 9.6500, 0, 2, NULL, NULL, 94),
	(62, 51, 40, 30.0000, 18.4000, 0, 2, NULL, NULL, 95),
	(66, 56, 48, 10.0000, 12.7500, 0, 2, NULL, 111, 99),
	(67, 55, 34, 87.0000, 14.0000, 0, 2, NULL, NULL, 117),
	(68, 79, 7, 30.0000, 30.0000, 0, 2, NULL, NULL, 119),
	(69, 79, 51, 30.0000, 53.0000, 0, 2, NULL, NULL, 118),
	(70, 78, 17, 40.0000, 39.0000, 0, 2, NULL, NULL, 120),
	(71, 77, 6, 90.0000, 25.0000, 0, 2, NULL, NULL, 121),
	(72, 76, 4, 30.0000, 22.0000, 0, 2, NULL, NULL, 122),
	(73, 75, 48, 40.0000, 12.7500, 0, 2, NULL, NULL, 123),
	(74, 74, 48, 40.0000, 12.7500, 0, 2, NULL, NULL, 124),
	(75, 73, 41, 10.0000, 9.6500, 0, 2, NULL, NULL, 125),
	(76, 72, 43, 5.0000, 46.0000, 0, 2, NULL, NULL, 126),
	(77, 71, 40, 40.0000, 18.4000, 0, 2, NULL, NULL, 127),
	(78, 70, 8, 20.0000, 40.0000, 0, 2, NULL, NULL, 128),
	(79, 69, 80, 15.0000, 3.5000, 0, 2, NULL, NULL, 129),
	(80, 67, 74, 20.0000, 10.0000, 0, 2, NULL, NULL, 130),
	(81, 60, 72, 40.0000, 34.8000, 0, 2, NULL, NULL, 131),
	(82, 63, 3, 50.0000, 10.0000, 0, 2, NULL, NULL, 132),
	(83, 63, 8, 3.0000, 40.0000, 0, 2, NULL, NULL, 133),
	(84, 58, 20, 40.0000, 81.0000, 0, 2, NULL, NULL, 134),
	(85, 58, 52, 40.0000, 7.0000, 0, 2, NULL, NULL, 135),
	(86, 80, 56, 10.0000, 38.0000, 0, 1, NULL, NULL, 136),
	(90, 81, 81, 0.0000, 2.9900, 0, 5, NULL, NULL, NULL),
	(91, 81, 56, 0.0000, 38.0000, 0, 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `ordersdetails` ENABLE KEYS */;


# Dumping structure for table northwindgood.ordersstatus
DROP TABLE IF EXISTS `ordersstatus`;
CREATE TABLE IF NOT EXISTS `ordersstatus` (
  `ordersStatusId` smallint(5) NOT NULL,
  `ordersStatusName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ordersStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.ordersstatus: ~4 rows (approximately)
/*!40000 ALTER TABLE `ordersstatus` DISABLE KEYS */;
INSERT INTO `ordersstatus` (`ordersStatusId`, `ordersStatusName`) VALUES
	(0, 'New'),
	(1, 'Invoiced'),
	(2, 'Shipped'),
	(3, 'Closed');
/*!40000 ALTER TABLE `ordersstatus` ENABLE KEYS */;


# Dumping structure for table northwindgood.orderstaxstatus
DROP TABLE IF EXISTS `orderstaxstatus`;
CREATE TABLE IF NOT EXISTS `orderstaxstatus` (
  `ordersTaxStatusId` smallint(5) NOT NULL,
  `ordersTaxStatusName` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ordersTaxStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.orderstaxstatus: ~2 rows (approximately)
/*!40000 ALTER TABLE `orderstaxstatus` DISABLE KEYS */;
INSERT INTO `orderstaxstatus` (`ordersTaxStatusId`, `ordersTaxStatusName`) VALUES
	(0, 'Tax Exempt'),
	(1, 'Taxable');
/*!40000 ALTER TABLE `orderstaxstatus` ENABLE KEYS */;


# Dumping structure for table northwindgood.privileges
DROP TABLE IF EXISTS `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `privilegeId` int(10) NOT NULL AUTO_INCREMENT,
  `privilegeName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`privilegeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.privileges: ~1 rows (approximately)
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
INSERT INTO `privileges` (`privilegeId`, `privilegeName`) VALUES
	(2, 'Purchase Approvals');
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;


# Dumping structure for view northwindgood.product orders
DROP VIEW IF EXISTS `product orders`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `product orders` (
	`productsId` INT(10) NULL DEFAULT NULL,
	`ordersId` INT(10) NOT NULL DEFAULT '0',
	`ordersDate` TIMESTAMP NULL DEFAULT NULL,
	`ordersShippedDate` DATETIME NULL DEFAULT NULL,
	`customersId` INT(10) NULL DEFAULT NULL,
	`ordersdetailsQuantity` DECIMAL(18,4) NOT NULL DEFAULT '0.0000',
	`ordersdetailsUnitPrice` DECIMAL(19,4) NULL DEFAULT NULL,
	`ordersdetailsDiscount` DOUBLE NOT NULL DEFAULT '0',
	`Company Name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`ordersdetailsStatusId` INT(10) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for view northwindgood.product purchases
DROP VIEW IF EXISTS `product purchases`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `product purchases` (
	`productsId` INT(10) NULL DEFAULT NULL,
	`purchaseOrdersId` INT(10) NOT NULL DEFAULT '0',
	`purchaseOrdersCreationDate` TIMESTAMP NULL DEFAULT NULL,
	`purchaseOrderDetailsQuantity` DECIMAL(18,4) NOT NULL DEFAULT '',
	`purchaseOrderDetailsUnitCost` DECIMAL(19,4) NOT NULL DEFAULT '',
	`Company Name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`postedToInventory` TINYINT(4) NOT NULL DEFAULT ''
) ENGINE=MyISAM;


# Dumping structure for view northwindgood.product sales by category
DROP VIEW IF EXISTS `product sales by category`;
/* SQL Error (1356): View 'northwindgood.product sales by category' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them */

# Dumping structure for view northwindgood.product sales quantity by employee and date
DROP VIEW IF EXISTS `product sales quantity by employee and date`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `product sales quantity by employee and date` (
	`ordersDate` TIMESTAMP NULL DEFAULT NULL,
	`Employee Name` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`SumOfQuantity` DECIMAL(40,4) NULL DEFAULT NULL,
	`productsName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;


# Dumping structure for table northwindgood.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `supplierId` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `productsId` int(10) NOT NULL AUTO_INCREMENT,
  `productsCode` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `productsName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `productsDescription` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `productsStdCost` decimal(19,4) DEFAULT NULL,
  `productsListPrice` decimal(19,4) NOT NULL,
  `productsReorderLevel` smallint(5) DEFAULT NULL,
  `productsTargetLevel` int(10) DEFAULT NULL,
  `productsQtyPerUnit` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `productsDiscontinued` tinyint(4) NOT NULL,
  `productsMinReorderQty` smallint(5) DEFAULT NULL,
  `productsCategory` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `productsAttachments` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`productsId`),
  KEY `Product Code` (`productsCode`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.products: ~45 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`supplierId`, `productsId`, `productsCode`, `productsName`, `productsDescription`, `productsStdCost`, `productsListPrice`, `productsReorderLevel`, `productsTargetLevel`, `productsQtyPerUnit`, `productsDiscontinued`, `productsMinReorderQty`, `productsCategory`, `productsAttachments`) VALUES
	('4', 1, 'NWTB-1', 'Northwind Traders Chai', NULL, 13.5000, 18.0000, 10, 40, '10 boxes x 20 bags', 0, 10, 'Beverages', NULL),
	('10', 3, 'NWTCO-3', 'Northwind Traders Syrup', NULL, 7.5000, 10.0000, 25, 100, '12 - 550 ml bottles', 0, 25, 'Condiments', NULL),
	('10', 4, 'NWTCO-4', 'Northwind Traders Cajun Seasoning', NULL, 16.5000, 22.0000, 10, 40, '48 - 6 oz jars', 0, 10, 'Condiments', NULL),
	('10', 5, 'NWTO-5', 'Northwind Traders Olive Oil', NULL, 16.0125, 21.3500, 10, 40, '36 boxes', 0, 10, 'Oil', NULL),
	('2;6', 6, 'NWTJP-6', 'Northwind Traders Boysenberry Spread', NULL, 18.7500, 25.0000, 25, 100, '12 - 8 oz jars', 0, 25, 'Jams, Preserves', NULL),
	('2', 7, 'NWTDFN-7', 'Northwind Traders Dried Pears', NULL, 22.5000, 30.0000, 10, 40, '12 - 1 lb pkgs.', 0, 10, 'Dried Fruit & Nuts', NULL),
	('8', 8, 'NWTS-8', 'Northwind Traders Curry Sauce', NULL, 30.0000, 40.0000, 10, 40, '12 - 12 oz jars', 0, 10, 'Sauces', NULL),
	('2;6', 14, 'NWTDFN-14', 'Northwind Traders Walnuts', NULL, 17.4375, 23.2500, 10, 40, '40 - 100 g pkgs.', 0, 10, 'Dried Fruit & Nuts', NULL),
	('6', 17, 'NWTCFV-17', 'Northwind Traders Fruit Cocktail', NULL, 29.2500, 39.0000, 10, 40, '15.25 OZ', 0, 10, 'Canned Fruit & Vegetables', NULL),
	('1', 19, 'NWTBGM-19', 'Northwind Traders Chocolate Biscuits Mix', NULL, 6.9000, 9.2000, 5, 20, '10 boxes x 12 pieces', 0, 5, 'Baked Goods & Mixes', NULL),
	('2;6', 20, 'NWTJP-6', 'Northwind Traders Marmalade', NULL, 60.7500, 81.0000, 10, 40, '30 gift boxes', 0, 10, 'Jams, Preserves', NULL),
	('1', 21, 'NWTBGM-21', 'Northwind Traders Scones', NULL, 7.5000, 10.0000, 5, 20, '24 pkgs. x 4 pieces', 0, 5, 'Baked Goods & Mixes', NULL),
	('4', 34, 'NWTB-34', 'Northwind Traders Beer', NULL, 10.5000, 14.0000, 15, 60, '24 - 12 oz bottles', 0, 15, 'Beverages', NULL),
	('7', 40, 'NWTCM-40', 'Northwind Traders Crab Meat', NULL, 13.8000, 18.4000, 30, 120, '24 - 4 oz tins', 0, 30, 'Canned Meat', NULL),
	('6', 41, 'NWTSO-41', 'Northwind Traders Clam Chowder', NULL, 7.2375, 9.6500, 10, 40, '12 - 12 oz cans', 0, 10, 'Soups', NULL),
	('3;4', 43, 'NWTB-43', 'Northwind Traders Coffee', NULL, 34.5000, 46.0000, 25, 100, '16 - 500 g tins', 0, 25, 'Beverages', NULL),
	('10', 48, 'NWTCA-48', 'Northwind Traders Chocolate', NULL, 9.5625, 12.7500, 25, 100, '10 pkgs', 0, 25, 'Candy', NULL),
	('2', 51, 'NWTDFN-51', 'Northwind Traders Dried Apples', NULL, 39.7500, 53.0000, 10, 40, '50 - 300 g pkgs.', 0, 10, 'Dried Fruit & Nuts', NULL),
	('1', 52, 'NWTG-52', 'Northwind Traders Long Grain Rice', NULL, 5.2500, 7.0000, 25, 100, '16 - 2 kg boxes', 0, 25, 'Grains', NULL),
	('1', 56, 'NWTP-56', 'Northwind Traders Gnocchi', NULL, 28.5000, 38.0000, 30, 120, '24 - 250 g pkgs.', 0, 30, 'Pasta', NULL),
	('1', 57, 'NWTP-57', 'Northwind Traders Ravioli', NULL, 14.6250, 19.5000, 20, 80, '24 - 250 g pkgs.', 0, 20, 'Pasta', NULL),
	('8', 65, 'NWTS-65', 'Northwind Traders Hot Pepper Sauce', NULL, 15.7875, 21.0500, 10, 40, '32 - 8 oz bottles', 0, 10, 'Sauces', NULL),
	('8', 66, 'NWTS-66', 'Northwind Traders Tomato Sauce', NULL, 12.7500, 17.0000, 20, 80, '24 - 8 oz jars', 0, 20, 'Sauces', NULL),
	('5', 72, 'NWTD-72', 'Northwind Traders Mozzarella', NULL, 26.1000, 34.8000, 10, 40, '24 - 200 g pkgs.', 0, 10, 'Dairy Products', NULL),
	('2;6', 74, 'NWTDFN-74', 'Northwind Traders Almonds', NULL, 7.5000, 10.0000, 5, 20, '5 kg pkg.', 0, 5, 'Dried Fruit & Nuts', NULL),
	('10', 77, 'NWTCO-77', 'Northwind Traders Mustard', NULL, 9.7500, 13.0000, 15, 60, '12 boxes', 0, 15, 'Condiments', NULL),
	('2', 80, 'NWTDFN-80', 'Northwind Traders Dried Plums', NULL, 3.0000, 3.5000, 50, 75, '1 lb bag', 0, 25, 'Dried Fruit & Nuts', NULL),
	('3', 81, 'NWTB-81', 'Northwind Traders Green Tea', NULL, 2.0000, 2.9900, 100, 125, '20 bags per box', 0, 25, 'Beverages', NULL),
	('1', 82, 'NWTC-82', 'Northwind Traders Granola', NULL, 2.0000, 4.0000, 20, 100, NULL, 0, NULL, 'Cereal', NULL),
	('9', 83, 'NWTCS-83', 'Northwind Traders Potato Chips', NULL, 0.5000, 1.8000, 30, 200, NULL, 0, NULL, 'Chips, Snacks', NULL),
	('1', 85, 'NWTBGM-85', 'Northwind Traders Brownie Mix', NULL, 9.0000, 12.4900, 10, 20, '3 boxes', 0, 5, 'Baked Goods & Mixes', NULL),
	('1', 86, 'NWTBGM-86', 'Northwind Traders Cake Mix', NULL, 10.5000, 15.9900, 10, 20, '4 boxes', 0, 5, 'Baked Goods & Mixes', NULL),
	('7', 87, 'NWTB-87', 'Northwind Traders Tea', NULL, 2.0000, 4.0000, 20, 50, '100 count per box', 0, NULL, 'Beverages', NULL),
	('6', 88, 'NWTCFV-88', 'Northwind Traders Pears', NULL, 1.0000, 1.3000, 10, 40, '15.25 OZ', 0, NULL, 'Canned Fruit & Vegetables', NULL),
	('6', 89, 'NWTCFV-89', 'Northwind Traders Peaches', NULL, 1.0000, 1.5000, 10, 40, '15.25 OZ', 0, NULL, 'Canned Fruit & Vegetables', NULL),
	('6', 90, 'NWTCFV-90', 'Northwind Traders Pineapple', NULL, 1.0000, 1.8000, 10, 40, '15.25 OZ', 0, NULL, 'Canned Fruit & Vegetables', NULL),
	('6', 91, 'NWTCFV-91', 'Northwind Traders Cherry Pie Filling', NULL, 1.0000, 2.0000, 10, 40, '15.25 OZ', 0, NULL, 'Canned Fruit & Vegetables', NULL),
	('6', 92, 'NWTCFV-92', 'Northwind Traders Green Beans', NULL, 1.0000, 1.2000, 10, 40, '14.5 OZ', 0, NULL, 'Canned Fruit & Vegetables', NULL),
	('6', 93, 'NWTCFV-93', 'Northwind Traders Corn', NULL, 1.0000, 1.2000, 10, 40, '14.5 OZ', 0, NULL, 'Canned Fruit & Vegetables', NULL),
	('6', 94, 'NWTCFV-94', 'Northwind Traders Peas', NULL, 1.0000, 1.5000, 10, 40, '14.5 OZ', 0, NULL, 'Canned Fruit & Vegetables', NULL),
	('7', 95, 'NWTCM-95', 'Northwind Traders Tuna Fish', NULL, 0.5000, 2.0000, 30, 50, '5 oz', 0, NULL, 'Canned Meat', NULL),
	('7', 96, 'NWTCM-96', 'Northwind Traders Smoked Salmon', NULL, 2.0000, 4.0000, 30, 50, '5 oz', 0, NULL, 'Canned Meat', NULL),
	('1', 97, 'NWTC-82', 'Northwind Traders Hot Cereal', NULL, 3.0000, 5.0000, 50, 200, NULL, 0, NULL, 'Cereal', NULL),
	('6', 98, 'NWTSO-98', 'Northwind Traders Vegetable Soup', NULL, 1.0000, 1.8900, 100, 200, NULL, 0, NULL, 'Soups', NULL),
	('6', 99, 'NWTSO-99', 'Northwind Traders Chicken Soup', NULL, 1.0000, 1.9500, 100, 200, NULL, 0, NULL, 'Soups', NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


# Dumping structure for table northwindgood.purchaseorderdetails
DROP TABLE IF EXISTS `purchaseorderdetails`;
CREATE TABLE IF NOT EXISTS `purchaseorderdetails` (
  `purchaseOrderDetailsId` int(10) NOT NULL AUTO_INCREMENT,
  `purchaseOrdersId` int(10) NOT NULL,
  `productsId` int(10) DEFAULT NULL,
  `purchaseOrderDetailsQuantity` decimal(18,4) NOT NULL,
  `purchaseOrderDetailsUnitCost` decimal(19,4) NOT NULL,
  `purchaseOrderDetailsDateRec` datetime DEFAULT NULL,
  `postedToInventory` tinyint(4) NOT NULL,
  `inventoryId` int(10) DEFAULT NULL,
  PRIMARY KEY (`purchaseOrderDetailsId`),
  KEY `ID` (`purchaseOrderDetailsId`),
  KEY `Inventory ID` (`inventoryId`),
  KEY `InventoryTransactionsOnPurchase` (`inventoryId`),
  KEY `New_InventoryTransactionsOnPurc` (`inventoryId`),
  KEY `New_ProductOnPurchaseOrderDetai` (`productsId`),
  KEY `New_PurchaseOrderDeatilsOnPurch` (`purchaseOrdersId`),
  KEY `OrderID` (`purchaseOrdersId`),
  KEY `ProductID` (`productsId`),
  KEY `ProductOnPurchaseOrderDetails` (`productsId`),
  KEY `PurchaseOrderDeatilsOnPurchaseO` (`purchaseOrdersId`)
) ENGINE=InnoDB AUTO_INCREMENT=296 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.purchaseorderdetails: ~55 rows (approximately)
/*!40000 ALTER TABLE `purchaseorderdetails` DISABLE KEYS */;
INSERT INTO `purchaseorderdetails` (`purchaseOrderDetailsId`, `purchaseOrdersId`, `productsId`, `purchaseOrderDetailsQuantity`, `purchaseOrderDetailsUnitCost`, `purchaseOrderDetailsDateRec`, `postedToInventory`, `inventoryId`) VALUES
	(238, 90, 1, 40.0000, 14.0000, '2006-01-22 00:00:00', 1, 59),
	(239, 91, 3, 100.0000, 8.0000, '2006-01-22 00:00:00', 1, 54),
	(240, 91, 4, 40.0000, 16.0000, '2006-01-22 00:00:00', 1, 55),
	(241, 91, 5, 40.0000, 16.0000, '2006-01-22 00:00:00', 1, 56),
	(242, 92, 6, 100.0000, 19.0000, '2006-01-22 00:00:00', 1, 40),
	(243, 92, 7, 40.0000, 22.0000, '2006-01-22 00:00:00', 1, 41),
	(244, 92, 8, 40.0000, 30.0000, '2006-01-22 00:00:00', 1, 42),
	(245, 92, 14, 40.0000, 17.0000, '2006-01-22 00:00:00', 1, 43),
	(246, 92, 17, 40.0000, 29.0000, '2006-01-22 00:00:00', 1, 44),
	(247, 92, 19, 20.0000, 7.0000, '2006-01-22 00:00:00', 1, 45),
	(248, 92, 20, 40.0000, 61.0000, '2006-01-22 00:00:00', 1, 46),
	(249, 92, 21, 20.0000, 8.0000, '2006-01-22 00:00:00', 1, 47),
	(250, 90, 34, 60.0000, 10.0000, '2006-01-22 00:00:00', 1, 60),
	(251, 92, 40, 120.0000, 14.0000, '2006-01-22 00:00:00', 1, 48),
	(252, 92, 41, 40.0000, 7.0000, '2006-01-22 00:00:00', 1, 49),
	(253, 90, 43, 100.0000, 34.0000, '2006-01-22 00:00:00', 1, 61),
	(254, 92, 48, 100.0000, 10.0000, '2006-01-22 00:00:00', 1, 50),
	(255, 92, 51, 40.0000, 40.0000, '2006-01-22 00:00:00', 1, 51),
	(256, 93, 52, 100.0000, 5.0000, '2006-01-22 00:00:00', 1, 37),
	(257, 93, 56, 120.0000, 28.0000, '2006-01-22 00:00:00', 1, 38),
	(258, 93, 57, 80.0000, 15.0000, '2006-01-22 00:00:00', 1, 39),
	(259, 91, 65, 40.0000, 16.0000, '2006-01-22 00:00:00', 1, 57),
	(260, 91, 66, 80.0000, 13.0000, '2006-01-22 00:00:00', 1, 58),
	(261, 94, 72, 40.0000, 26.0000, '2006-01-22 00:00:00', 1, 36),
	(262, 92, 74, 20.0000, 8.0000, '2006-01-22 00:00:00', 1, 52),
	(263, 92, 77, 60.0000, 10.0000, '2006-01-22 00:00:00', 1, 53),
	(264, 95, 80, 75.0000, 3.0000, '2006-01-22 00:00:00', 1, 35),
	(265, 90, 81, 125.0000, 2.0000, '2006-01-22 00:00:00', 1, 62),
	(266, 96, 34, 100.0000, 10.0000, '2006-01-22 00:00:00', 1, 82),
	(267, 97, 19, 30.0000, 7.0000, '2006-01-22 00:00:00', 1, 80),
	(268, 98, 41, 200.0000, 7.0000, '2006-01-22 00:00:00', 1, 78),
	(269, 99, 43, 300.0000, 34.0000, '2006-01-22 00:00:00', 1, 76),
	(270, 100, 48, 100.0000, 10.0000, '2006-01-22 00:00:00', 1, 74),
	(271, 101, 81, 200.0000, 2.0000, '2006-01-22 00:00:00', 1, 72),
	(272, 102, 43, 300.0000, 34.0000, NULL, 0, NULL),
	(273, 103, 19, 10.0000, 7.0000, '2006-04-17 00:00:00', 1, 111),
	(274, 104, 41, 50.0000, 7.0000, '2006-04-06 00:00:00', 1, 115),
	(275, 105, 57, 100.0000, 15.0000, '2006-04-05 00:00:00', 1, 100),
	(276, 106, 72, 50.0000, 26.0000, '2006-04-05 00:00:00', 1, 113),
	(277, 107, 34, 300.0000, 10.0000, '2006-04-05 00:00:00', 1, 107),
	(278, 108, 8, 25.0000, 30.0000, '2006-04-05 00:00:00', 1, 105),
	(279, 109, 19, 25.0000, 7.0000, '2006-04-05 00:00:00', 1, 109),
	(280, 110, 43, 250.0000, 34.0000, '2006-04-10 00:00:00', 1, 103),
	(281, 90, 1, 40.0000, 14.0000, NULL, 0, NULL),
	(282, 92, 19, 20.0000, 7.0000, NULL, 0, NULL),
	(283, 111, 34, 50.0000, 10.0000, '2006-04-04 00:00:00', 1, 102),
	(285, 91, 3, 50.0000, 8.0000, NULL, 0, NULL),
	(286, 91, 4, 40.0000, 16.0000, NULL, 0, NULL),
	(288, 140, 85, 10.0000, 9.0000, NULL, 0, NULL),
	(289, 141, 6, 10.0000, 18.7500, NULL, 0, NULL),
	(290, 142, 1, 1.0000, 13.5000, NULL, 0, NULL),
	(292, 146, 20, 40.0000, 60.0000, NULL, 0, NULL),
	(293, 146, 51, 40.0000, 39.0000, NULL, 0, NULL),
	(294, 147, 40, 120.0000, 13.0000, NULL, 0, NULL),
	(295, 148, 72, 40.0000, 26.0000, NULL, 0, NULL);
/*!40000 ALTER TABLE `purchaseorderdetails` ENABLE KEYS */;


# Dumping structure for table northwindgood.purchaseorders
DROP TABLE IF EXISTS `purchaseorders`;
CREATE TABLE IF NOT EXISTS `purchaseorders` (
  `purchaseOrdersId` int(10) NOT NULL AUTO_INCREMENT,
  `suppliersId` int(10) DEFAULT NULL,
  `purchaseOrdersCreatedBy` int(10) DEFAULT NULL,
  `purchaseOrdersSubmitDate` datetime DEFAULT NULL,
  `purchaseOrdersCreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `purchaseOrdersStatusId` int(10) DEFAULT '0',
  `purchaseOrdersExpectedDate` datetime DEFAULT NULL,
  `purchaseOrdersShippingFee` decimal(19,4) NOT NULL,
  `purchaseOrdersTaxes` decimal(19,4) NOT NULL,
  `purchaseOrdersPaymentDate` datetime DEFAULT NULL,
  `purchaseOrdersPaymentAmt` decimal(19,4) DEFAULT NULL,
  `purchaseOrdersPaymentMethod` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchaseOrdersNotes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `purchaseOrdersApprovedBy` int(10) DEFAULT NULL,
  `purchaseOrdersApprovedDate` datetime DEFAULT NULL,
  `purchaseOrdersSubmitBy` int(10) DEFAULT NULL,
  PRIMARY KEY (`purchaseOrdersId`),
  UNIQUE KEY `ID` (`purchaseOrdersId`),
  KEY `EmployeesOnPurchaseOrder` (`purchaseOrdersCreatedBy`),
  KEY `New_EmployeesOnPurchaseOrder` (`purchaseOrdersCreatedBy`),
  KEY `New_PurchaseOrderStatusLookup` (`purchaseOrdersStatusId`),
  KEY `New_SuppliersOnPurchaseOrder` (`suppliersId`),
  KEY `PurchaseOrderStatusLookup` (`purchaseOrdersStatusId`),
  KEY `Status ID` (`purchaseOrdersStatusId`),
  KEY `SupplierID` (`suppliersId`),
  KEY `SuppliersOnPurchaseOrder` (`suppliersId`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.purchaseorders: ~28 rows (approximately)
/*!40000 ALTER TABLE `purchaseorders` DISABLE KEYS */;
INSERT INTO `purchaseorders` (`purchaseOrdersId`, `suppliersId`, `purchaseOrdersCreatedBy`, `purchaseOrdersSubmitDate`, `purchaseOrdersCreationDate`, `purchaseOrdersStatusId`, `purchaseOrdersExpectedDate`, `purchaseOrdersShippingFee`, `purchaseOrdersTaxes`, `purchaseOrdersPaymentDate`, `purchaseOrdersPaymentAmt`, `purchaseOrdersPaymentMethod`, `purchaseOrdersNotes`, `purchaseOrdersApprovedBy`, `purchaseOrdersApprovedDate`, `purchaseOrdersSubmitBy`) VALUES
	(90, 1, 2, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-01-22 00:00:00', 2),
	(91, 3, 2, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-01-22 00:00:00', 2),
	(92, 2, 2, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-01-22 00:00:00', 2),
	(93, 5, 2, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-01-22 00:00:00', 2),
	(94, 6, 2, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-01-22 00:00:00', 2),
	(95, 4, 2, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-01-22 00:00:00', 2),
	(96, 1, 5, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #30', 2, '2006-01-22 00:00:00', 5),
	(97, 2, 7, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #33', 2, '2006-01-22 00:00:00', 7),
	(98, 2, 4, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #36', 2, '2006-01-22 00:00:00', 4),
	(99, 1, 3, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #38', 2, '2006-01-22 00:00:00', 3),
	(100, 2, 9, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #39', 2, '2006-01-22 00:00:00', 9),
	(101, 1, 2, '2006-01-14 00:00:00', '2006-01-22 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #40', 2, '2006-01-22 00:00:00', 2),
	(102, 1, 1, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #41', 2, '2006-04-04 00:00:00', 1),
	(103, 2, 1, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #42', 2, '2006-04-04 00:00:00', 1),
	(104, 2, 1, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #45', 2, '2006-04-04 00:00:00', 1),
	(105, 5, 7, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, 'Check', 'Purchase generated based on Order #46', 2, '2006-04-04 00:00:00', 7),
	(106, 6, 7, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #46', 2, '2006-04-04 00:00:00', 7),
	(107, 1, 6, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #47', 2, '2006-04-04 00:00:00', 6),
	(108, 2, 4, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #48', 2, '2006-04-04 00:00:00', 4),
	(109, 2, 4, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #48', 2, '2006-04-04 00:00:00', 4),
	(110, 1, 3, '2006-03-24 00:00:00', '2006-03-24 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #49', 2, '2006-04-04 00:00:00', 3),
	(111, 1, 2, '2006-03-31 00:00:00', '2006-03-31 00:00:00', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, 'Purchase generated based on Order #56', 2, '2006-04-04 00:00:00', 2),
	(140, 6, NULL, '2006-04-25 00:00:00', '2006-04-25 16:40:51', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-04-25 16:41:33', 2),
	(141, 8, NULL, '2006-04-25 00:00:00', '2006-04-25 17:10:35', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, 2, '2006-04-25 17:10:55', 2),
	(142, 8, NULL, '2006-04-25 00:00:00', '2006-04-25 17:18:29', 2, NULL, 0.0000, 0.0000, NULL, 0.0000, 'Check', NULL, 2, '2006-04-25 17:18:51', 2),
	(146, 2, 2, '2006-04-26 18:26:37', '2006-04-26 18:26:37', 1, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, NULL, NULL, 2),
	(147, 7, 2, '2006-04-26 18:33:28', '2006-04-26 18:33:28', 1, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, NULL, NULL, 2),
	(148, 5, 2, '2006-04-26 18:33:52', '2006-04-26 18:33:52', 1, NULL, 0.0000, 0.0000, NULL, 0.0000, NULL, NULL, NULL, NULL, 2);
/*!40000 ALTER TABLE `purchaseorders` ENABLE KEYS */;


# Dumping structure for table northwindgood.purchaseorderstatus
DROP TABLE IF EXISTS `purchaseorderstatus`;
CREATE TABLE IF NOT EXISTS `purchaseorderstatus` (
  `purchaseOrdersStatusId` int(10) NOT NULL,
  `purchaseOrdersStatus` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`purchaseOrdersStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.purchaseorderstatus: ~4 rows (approximately)
/*!40000 ALTER TABLE `purchaseorderstatus` DISABLE KEYS */;
INSERT INTO `purchaseorderstatus` (`purchaseOrdersStatusId`, `purchaseOrdersStatus`) VALUES
	(0, 'New'),
	(1, 'Submitted'),
	(2, 'Approved'),
	(3, 'Closed');
/*!40000 ALTER TABLE `purchaseorderstatus` ENABLE KEYS */;


# Dumping structure for table northwindgood.salesreports
DROP TABLE IF EXISTS `salesreports`;
CREATE TABLE IF NOT EXISTS `salesreports` (
  `salesRprtGroupBy` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `salesRprtDisplay` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `salesRprtTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `salesRprtFilterRowSource` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `salesRprtDefault` tinyint(4) NOT NULL,
  PRIMARY KEY (`salesRprtGroupBy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.salesreports: ~5 rows (approximately)
/*!40000 ALTER TABLE `salesreports` DISABLE KEYS */;
INSERT INTO `salesreports` (`salesRprtGroupBy`, `salesRprtDisplay`, `salesRprtTitle`, `salesRprtFilterRowSource`, `salesRprtDefault`) VALUES
	('Category', 'Category', 'Sales By Category', 'SELECT DISTINCT [Category] FROM [Products] ORDER BY [Category];', 0),
	('Country/Region', 'Country/Region', 'Sales By Country', 'SELECT DISTINCT [Country/Region] FROM [Customers Extended] ORDER BY [Country/Region];', 0),
	('Customer ID', 'Customer', 'Sales By Customer', 'SELECT DISTINCT [Company] FROM [Customers Extended] ORDER BY [Company];', 0),
	('Employee ID', 'Employee', 'Sales By Employee', 'SELECT DISTINCT [Employee Name] FROM [Employees Extended] ORDER BY [Employee Name];', 0),
	('Product ID', 'Product', 'Sales by Product', 'SELECT DISTINCT [Product Name] FROM [Products] ORDER BY [Product Name];', 1);
/*!40000 ALTER TABLE `salesreports` ENABLE KEYS */;


# Dumping structure for table northwindgood.shippers
DROP TABLE IF EXISTS `shippers`;
CREATE TABLE IF NOT EXISTS `shippers` (
  `shippersId` int(10) NOT NULL AUTO_INCREMENT,
  `shippersCompany` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersLastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersFirstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersEmail` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersJobTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersBusinessPhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersHomePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersMobilePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersFaxNum` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersAddress` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `shippersCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersState` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersPostCode` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersCountry` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shippersWebPage` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `shippersNotes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `shippersAttachments` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`shippersId`),
  KEY `City` (`shippersCity`),
  KEY `Company` (`shippersCompany`),
  KEY `First Name` (`shippersFirstName`),
  KEY `Last Name` (`shippersLastName`),
  KEY `Postal Code` (`shippersPostCode`),
  KEY `State/Province` (`shippersState`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.shippers: ~3 rows (approximately)
/*!40000 ALTER TABLE `shippers` DISABLE KEYS */;
INSERT INTO `shippers` (`shippersId`, `shippersCompany`, `shippersLastName`, `shippersFirstName`, `shippersEmail`, `shippersJobTitle`, `shippersBusinessPhone`, `shippersHomePhone`, `shippersMobilePhone`, `shippersFaxNum`, `shippersAddress`, `shippersCity`, `shippersState`, `shippersPostCode`, `shippersCountry`, `shippersWebPage`, `shippersNotes`, `shippersAttachments`) VALUES
	(1, 'Shipping Company A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123 Any Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL),
	(2, 'Shipping Company B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123 Any Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL),
	(3, 'Shipping Company C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123 Any Street', 'Memphis', 'TN', '99999', 'USA', NULL, NULL, NULL);
/*!40000 ALTER TABLE `shippers` ENABLE KEYS */;


# Dumping structure for view northwindgood.shippers extended
DROP VIEW IF EXISTS `shippers extended`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `shippers extended` (
	`File As` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`Contact Name` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersId` INT(10) NOT NULL DEFAULT '0',
	`shippersCompany` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersLastName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersFirstName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersEmail` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersJobTitle` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersBusinessPhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersHomePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersMobilePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersFaxNum` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersAddress` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersCity` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersState` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersPostCode` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersCountry` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersWebPage` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersNotes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`shippersAttachments` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;


# Dumping structure for table northwindgood.strings
DROP TABLE IF EXISTS `strings`;
CREATE TABLE IF NOT EXISTS `strings` (
  `stringsId` int(10) NOT NULL AUTO_INCREMENT,
  `stringsData` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`stringsId`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.strings: ~62 rows (approximately)
/*!40000 ALTER TABLE `strings` DISABLE KEYS */;
INSERT INTO `strings` (`stringsId`, `stringsData`) VALUES
	(2, 'Northwind Traders'),
	(3, 'Cannot remove posted inventory!'),
	(4, 'Back ordered product filled for Order #|'),
	(5, 'Discounted price below cost!'),
	(6, 'Insufficient inventory.'),
	(7, 'Insufficient inventory. Do you want to create a purchase order?'),
	(8, 'Purchase orders were successfully created for | products'),
	(9, 'There are no products below their respective reorder levels'),
	(10, 'Must specify customer name!'),
	(11, 'Restocking will generate purchase orders for all products below desired inventory levels.  Do you want to continue?'),
	(12, 'Cannot create purchase order.  No suppliers listed for specified product'),
	(13, 'Discounted price is below cost!'),
	(14, 'Do you want to continue?'),
	(15, 'Order is already invoiced. Do you want to print the invoice?'),
	(16, 'Order does not contain any line items'),
	(17, 'Cannot create invoice!  Inventory has not been allocated for each specified product.'),
	(18, 'Sorry, there are no sales in the specified time period'),
	(19, 'Product successfully restocked.'),
	(21, 'Product does not need restocking! Product is already at desired inventory level.'),
	(22, 'Product restocking failed!'),
	(23, 'Invalid login specified!'),
	(24, 'Must first select reported!'),
	(25, 'Changing supplier will remove purchase line items, continue?'),
	(26, 'Purchase orders were successfully submitted for | products.  Do you want to view the restocking report?'),
	(27, 'There was an error attempting to restock inventory levels.'),
	(28, '| product(s) were successfully restocked.  Do you want to view the restocking report?'),
	(29, 'You cannot remove purchase line items already posted to inventory!'),
	(30, 'There was an error removing one or more purchase line items.'),
	(31, 'You cannot modify quantity for purchased product already received or posted to inventory.'),
	(32, 'You cannot modify price for purchased product already received or posted to inventory.'),
	(33, 'Product has been successfully posted to inventory.'),
	(34, 'Sorry, product cannot be successfully posted to inventory.'),
	(35, 'There are orders with this product on back order.  Would you like to fill them now?'),
	(36, 'Cannot post product to inventory without specifying received date!'),
	(37, 'Do you want to post received product to inventory?'),
	(38, 'Initialize purchase, orders, and inventory data?'),
	(39, 'Must first specify employee name!'),
	(40, 'Specified user must be logged in to approve purchase!'),
	(41, 'Purchase order must contain completed line items before it can be approved'),
	(42, 'Sorry, you do not have permission to approve purchases.'),
	(43, 'Purchase successfully approved'),
	(44, 'Purchase cannot be approved'),
	(45, 'Purchase successfully submitted for approval'),
	(46, 'Purchase cannot be submitted for approval'),
	(47, 'Sorry, purchase order does not contain line items'),
	(48, 'Do you want to cancel this order?'),
	(49, 'Canceling an order will permanently delete the order.  Are you sure you want to cancel?'),
	(100, 'Your order was successfully canceled.'),
	(101, 'Cannot cancel an order that has items received and posted to inventory.'),
	(102, 'There was an error trying to cancel this order.'),
	(103, 'The invoice for this order has not yet been created.'),
	(104, 'Shipping information is not complete.  Please specify all shipping information and try again.'),
	(105, 'Cannot mark as shipped.  Order must first be invoiced!'),
	(106, 'Cannot cancel an order that has already shipped!'),
	(107, 'Must first specify salesperson!'),
	(108, 'Order is now marked closed.'),
	(109, 'Order must first be marked shipped before closing.'),
	(110, 'Must first specify payment information!'),
	(111, 'There was an error attempting to restock inventory levels.  | product(s) were successfully restocked.'),
	(112, 'You must supply a Unit Cost.'),
	(113, 'Fill back ordered product, Order #|'),
	(114, 'Purchase generated based on Order #|');
/*!40000 ALTER TABLE `strings` ENABLE KEYS */;


# Dumping structure for table northwindgood.suppliers
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `suppliersId` int(10) NOT NULL AUTO_INCREMENT,
  `suppliersCompany` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersLastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersFirstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersEmail` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersJobTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersBusinessPhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersHomePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersMobilePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersFaxNum` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersAddress` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `suppliersCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersState` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersPostCode` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersCountry` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `suppliersWebPage` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `suppliersNotes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `suppliersAttachments` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`suppliersId`),
  KEY `City` (`suppliersCity`),
  KEY `Company` (`suppliersCompany`),
  KEY `First Name` (`suppliersFirstName`),
  KEY `Last Name` (`suppliersLastName`),
  KEY `Postal Code` (`suppliersPostCode`),
  KEY `State/Province` (`suppliersState`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

# Dumping data for table northwindgood.suppliers: ~10 rows (approximately)
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` (`suppliersId`, `suppliersCompany`, `suppliersLastName`, `suppliersFirstName`, `suppliersEmail`, `suppliersJobTitle`, `suppliersBusinessPhone`, `suppliersHomePhone`, `suppliersMobilePhone`, `suppliersFaxNum`, `suppliersAddress`, `suppliersCity`, `suppliersState`, `suppliersPostCode`, `suppliersCountry`, `suppliersWebPage`, `suppliersNotes`, `suppliersAttachments`) VALUES
	(1, 'Supplier A', 'Andersen', 'Elizabeth A.', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'Supplier B', 'Weiler', 'Cornelia', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'Supplier C', 'Kelley', 'Madeleine', NULL, 'Sales Representative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 'Supplier D', 'Sato', 'Naoki', NULL, 'Marketing Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 'Supplier E', 'Hernandez-Echevarria', 'Amaya', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'Supplier F', 'Hayakawa', 'Satomi', NULL, 'Marketing Assistant', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(7, 'Supplier G', 'Glasson', 'Stuart', NULL, 'Marketing Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 'Supplier H', 'Dunton', 'Bryn Paul', NULL, 'Sales Representative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(9, 'Supplier I', 'Sandberg', 'Mikael', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(10, 'Supplier J', 'Sousa', 'Luis', NULL, 'Sales Manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;


# Dumping structure for view northwindgood.suppliers extended
DROP VIEW IF EXISTS `suppliers extended`;
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `suppliers extended` (
	`File As` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`Contact Name` VARCHAR(103) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersId` INT(10) NOT NULL DEFAULT '0',
	`suppliersCompany` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersLastName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersFirstName` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersEmail` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersJobTitle` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersBusinessPhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersHomePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersMobilePhone` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersFaxNum` VARCHAR(25) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersAddress` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersCity` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersState` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersPostCode` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersCountry` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersWebPage` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersNotes` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`suppliersAttachments` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;


# Dumping structure for view northwindgood.customers extended
DROP VIEW IF EXISTS `customers extended`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `customers extended`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customers extended` AS select if(isnull(`customers`.`customersLastName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersCompany`,`customers`.`customersFirstName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersLastName`,concat(`customers`.`customersLastName`,concat(' , ',`customers`.`customersFirstName`)))) AS `File As`,if(isnull(`customers`.`customersLastName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersCompany`,`customers`.`customersFirstName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersLastName`,concat(`customers`.`customersFirstName`,concat(' , ',`customers`.`customersLastName`)))) AS `Contact Name`,`customers`.`customersId` AS `customersId`,`customers`.`customersCompany` AS `customersCompany`,`customers`.`customersLastName` AS `customersLastName`,`customers`.`customersFirstName` AS `customersFirstName`,`customers`.`customersEmail` AS `customersEmail`,`customers`.`customersJobTitle` AS `customersJobTitle`,`customers`.`customersBusinessPhone` AS `customersBusinessPhone`,`customers`.`customersHomePhone` AS `customersHomePhone`,`customers`.`customersMobilePhone` AS `customersMobilePhone`,`customers`.`customersFaxNum` AS `customersFaxNum`,`customers`.`customersAddress` AS `customersAddress`,`customers`.`customersCity` AS `customersCity`,`customers`.`customersState` AS `customersState`,`customers`.`customersPostCode` AS `customersPostCode`,`customers`.`customersCountry` AS `customersCountry`,`customers`.`customersWebPage` AS `customersWebPage`,`customers`.`customersNotes` AS `customersNotes`,`customers`.`customersAttachments` AS `customersAttachments` from `customers` order by if(isnull(`customers`.`customersLastName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersCompany`,`customers`.`customersFirstName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersLastName`,concat(`customers`.`customersLastName`,concat(' , ',`customers`.`customersFirstName`)))),if(isnull(`customers`.`customersLastName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersCompany`,`customers`.`customersFirstName`),if(isnull(`customers`.`customersFirstName`),`customers`.`customersLastName`,concat(`customers`.`customersFirstName`,concat(' , ',`customers`.`customersLastName`))));


# Dumping structure for view northwindgood.employees extended
DROP VIEW IF EXISTS `employees extended`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `employees extended`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employees extended` AS select if(isnull(`employees`.`employeesLastName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesCompany`,`employees`.`employeesFirstName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesLastName`,concat(`employees`.`employeesLastName`,concat(' , ',`employees`.`employeesFirstName`)))) AS `File As`,if(isnull(`employees`.`employeesLastName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesCompany`,`employees`.`employeesFirstName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesLastName`,concat(`employees`.`employeesFirstName`,concat(' , ',`employees`.`employeesLastName`)))) AS `Employee Name`,`employees`.`employeesId` AS `employeesId`,`employees`.`employeesCompany` AS `employeesCompany`,`employees`.`employeesLastName` AS `employeesLastName`,`employees`.`employeesFirstName` AS `employeesFirstName`,`employees`.`employeesEmail` AS `employeesEmail`,`employees`.`employeesJobTitle` AS `employeesJobTitle`,`employees`.`employeesBusinessPhone` AS `employeesBusinessPhone`,`employees`.`employeesHomePhone` AS `employeesHomePhone`,`employees`.`employeesMobilePhone` AS `employeesMobilePhone`,`employees`.`employeesFaxNum` AS `employeesFaxNum`,`employees`.`employeesAddress` AS `employeesAddress`,`employees`.`employeesCity` AS `employeesCity`,`employees`.`employeesState` AS `employeesState`,`employees`.`employeesPostCode` AS `employeesPostCode`,`employees`.`employeesCountry` AS `employeesCountry`,`employees`.`employeesWebPage` AS `employeesWebPage`,`employees`.`employeesNotes` AS `employeesNotes`,`employees`.`employeesAttachments` AS `employeesAttachments` from `employees` order by if(isnull(`employees`.`employeesLastName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesCompany`,`employees`.`employeesFirstName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesLastName`,concat(`employees`.`employeesLastName`,concat(' , ',`employees`.`employeesFirstName`)))),if(isnull(`employees`.`employeesLastName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesCompany`,`employees`.`employeesFirstName`),if(isnull(`employees`.`employeesFirstName`),`employees`.`employeesLastName`,concat(`employees`.`employeesFirstName`,concat(' , ',`employees`.`employeesLastName`))));


# Dumping structure for view northwindgood.inventory on hold
DROP VIEW IF EXISTS `inventory on hold`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `inventory on hold`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventory on hold` AS select `inventorytransactions`.`productsId` AS `productsId`,sum(`inventorytransactions`.`inventoryTransactionsQuantity`) AS `Quantity On Hold` from `inventorytransactions` where (`inventorytransactions`.`inventoryTransactionsTypesId` = 3) group by `inventorytransactions`.`productsId`;


# Dumping structure for view northwindgood.inventory on order
DROP VIEW IF EXISTS `inventory on order`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `inventory on order`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventory on order` AS select `purchaseorderdetails`.`productsId` AS `productsId`,sum(`purchaseorderdetails`.`purchaseOrderDetailsQuantity`) AS `Quantity On Order` from `purchaseorderdetails` where (`purchaseorderdetails`.`postedToInventory` = 0) group by `purchaseorderdetails`.`productsId`;


# Dumping structure for view northwindgood.inventory purchased
DROP VIEW IF EXISTS `inventory purchased`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `inventory purchased`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventory purchased` AS select `inventorytransactions`.`productsId` AS `productsId`,sum(`inventorytransactions`.`inventoryTransactionsQuantity`) AS `Quantity Purchased` from `inventorytransactions` where (`inventorytransactions`.`inventoryTransactionsTypesId` = 1) group by `inventorytransactions`.`productsId`;


# Dumping structure for view northwindgood.inventory sold
DROP VIEW IF EXISTS `inventory sold`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `inventory sold`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventory sold` AS select `inventorytransactions`.`productsId` AS `productsId`,sum(`inventorytransactions`.`inventoryTransactionsQuantity`) AS `Quantity Sold` from `inventorytransactions` where (`inventorytransactions`.`inventoryTransactionsTypesId` = 2) group by `inventorytransactions`.`productsId`;


# Dumping structure for view northwindgood.product orders
DROP VIEW IF EXISTS `product orders`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `product orders`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `product orders` AS select `ordersdetails`.`productsId` AS `productsId`,`orders`.`ordersId` AS `ordersId`,`orders`.`ordersDate` AS `ordersDate`,`orders`.`ordersShippedDate` AS `ordersShippedDate`,`orders`.`customersId` AS `customersId`,`ordersdetails`.`ordersDetailsQuantity` AS `ordersdetailsQuantity`,`ordersdetails`.`ordersDetailsUnitPrice` AS `ordersdetailsUnitPrice`,`ordersdetails`.`ordersDetailsDiscount` AS `ordersdetailsDiscount`,`customers extended`.`customersCompany` AS `Company Name`,`ordersdetails`.`ordersDetailsStatusId` AS `ordersdetailsStatusId` from ((`customers extended` join `orders` on((`customers extended`.`customersId` = `orders`.`customersId`))) join `ordersdetails` on((`orders`.`ordersId` = `ordersdetails`.`ordersId`))) order by `orders`.`ordersDate`;


# Dumping structure for view northwindgood.product purchases
DROP VIEW IF EXISTS `product purchases`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `product purchases`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product purchases` AS select `purchaseorderdetails`.`productsId` AS `productsId`,`purchaseorders`.`purchaseOrdersId` AS `purchaseOrdersId`,`purchaseorders`.`purchaseOrdersCreationDate` AS `purchaseOrdersCreationDate`,`purchaseorderdetails`.`purchaseOrderDetailsQuantity` AS `purchaseOrderDetailsQuantity`,`purchaseorderdetails`.`purchaseOrderDetailsUnitCost` AS `purchaseOrderDetailsUnitCost`,`suppliers`.`suppliersCompany` AS `Company Name`,`purchaseorderdetails`.`postedToInventory` AS `postedToInventory` from ((`suppliers` join `purchaseorders` on((`suppliers`.`suppliersId` = `purchaseorders`.`suppliersId`))) join `purchaseorderdetails` on((`purchaseorders`.`purchaseOrdersId` = `purchaseorderdetails`.`purchaseOrdersId`))) where (`purchaseorderdetails`.`postedToInventory` = 1) order by `purchaseorders`.`purchaseOrdersCreationDate`;


# Dumping structure for view northwindgood.product sales by category
DROP VIEW IF EXISTS `product sales by category`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `product sales by category`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product sales by category` AS select `northwindgood`.`orders`.`ordersDate` AS `ordersDate`,`northwindgood`.`products`.`productsName` AS `productsName`,`northwindgood`.`products`.`productsCategory` AS `productsCategory`,(`northwindgood`.`orderdetails`.`orderDetailsQuantity` * `northwindgood`.`orderdetails`.`orderDetailsUnitPrice`) AS `Amount` from ((`orders` join `products`) join `orderdetails` on(((`northwindgood`.`products`.`productsId` = `northwindgood`.`orderdetails`.`productsId`) and (`northwindgood`.`orders`.`ordersId` = `northwindgood`.`orderdetails`.`ordersId`)))) order by `northwindgood`.`orders`.`ordersDate`,`northwindgood`.`products`.`productsName`;


# Dumping structure for view northwindgood.product sales quantity by employee and date
DROP VIEW IF EXISTS `product sales quantity by employee and date`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `product sales quantity by employee and date`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product sales quantity by employee and date` AS select `orders`.`ordersDate` AS `ordersDate`,`employees extended`.`Employee Name` AS `Employee Name`,sum(`ordersdetails`.`ordersDetailsQuantity`) AS `SumOfQuantity`,`products`.`productsName` AS `productsName` from (((`products` join `employees extended`) join `orders` on((`employees extended`.`employeesId` = `orders`.`employeesId`))) join `ordersdetails` on(((`orders`.`ordersId` = `ordersdetails`.`ordersId`) and (`products`.`productsId` = `ordersdetails`.`productsId`)))) group by `orders`.`ordersDate`,`employees extended`.`Employee Name`,`products`.`productsName` order by `orders`.`ordersDate` desc,`employees extended`.`Employee Name`,`products`.`productsName`;


# Dumping structure for view northwindgood.shippers extended
DROP VIEW IF EXISTS `shippers extended`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `shippers extended`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `shippers extended` AS select if(isnull(`shippers`.`shippersLastName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersCompany`,`shippers`.`shippersFirstName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersLastName`,concat(`shippers`.`shippersLastName`,concat(' , ',`shippers`.`shippersFirstName`)))) AS `File As`,if(isnull(`shippers`.`shippersLastName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersCompany`,`shippers`.`shippersFirstName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersLastName`,concat(`shippers`.`shippersFirstName`,concat(' , ',`shippers`.`shippersLastName`)))) AS `Contact Name`,`shippers`.`shippersId` AS `shippersId`,`shippers`.`shippersCompany` AS `shippersCompany`,`shippers`.`shippersLastName` AS `shippersLastName`,`shippers`.`shippersFirstName` AS `shippersFirstName`,`shippers`.`shippersEmail` AS `shippersEmail`,`shippers`.`shippersJobTitle` AS `shippersJobTitle`,`shippers`.`shippersBusinessPhone` AS `shippersBusinessPhone`,`shippers`.`shippersHomePhone` AS `shippersHomePhone`,`shippers`.`shippersMobilePhone` AS `shippersMobilePhone`,`shippers`.`shippersFaxNum` AS `shippersFaxNum`,`shippers`.`shippersAddress` AS `shippersAddress`,`shippers`.`shippersCity` AS `shippersCity`,`shippers`.`shippersState` AS `shippersState`,`shippers`.`shippersPostCode` AS `shippersPostCode`,`shippers`.`shippersCountry` AS `shippersCountry`,`shippers`.`shippersWebPage` AS `shippersWebPage`,`shippers`.`shippersNotes` AS `shippersNotes`,`shippers`.`shippersAttachments` AS `shippersAttachments` from `shippers` order by if(isnull(`shippers`.`shippersLastName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersCompany`,`shippers`.`shippersFirstName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersLastName`,concat(`shippers`.`shippersLastName`,concat(' , ',`shippers`.`shippersFirstName`)))),if(isnull(`shippers`.`shippersLastName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersCompany`,`shippers`.`shippersFirstName`),if(isnull(`shippers`.`shippersFirstName`),`shippers`.`shippersLastName`,concat(`shippers`.`shippersFirstName`,concat(' , ',`shippers`.`shippersLastName`))));


# Dumping structure for view northwindgood.suppliers extended
DROP VIEW IF EXISTS `suppliers extended`;
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `suppliers extended`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `suppliers extended` AS select if(isnull(`suppliers`.`suppliersLastName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersCompany`,`suppliers`.`suppliersFirstName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersLastName`,concat(`suppliers`.`suppliersLastName`,concat(' , ',`suppliers`.`suppliersFirstName`)))) AS `File As`,if(isnull(`suppliers`.`suppliersLastName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersCompany`,`suppliers`.`suppliersFirstName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersLastName`,concat(`suppliers`.`suppliersFirstName`,concat(' , ',`suppliers`.`suppliersLastName`)))) AS `Contact Name`,`suppliers`.`suppliersId` AS `suppliersId`,`suppliers`.`suppliersCompany` AS `suppliersCompany`,`suppliers`.`suppliersLastName` AS `suppliersLastName`,`suppliers`.`suppliersFirstName` AS `suppliersFirstName`,`suppliers`.`suppliersEmail` AS `suppliersEmail`,`suppliers`.`suppliersJobTitle` AS `suppliersJobTitle`,`suppliers`.`suppliersBusinessPhone` AS `suppliersBusinessPhone`,`suppliers`.`suppliersHomePhone` AS `suppliersHomePhone`,`suppliers`.`suppliersMobilePhone` AS `suppliersMobilePhone`,`suppliers`.`suppliersFaxNum` AS `suppliersFaxNum`,`suppliers`.`suppliersAddress` AS `suppliersAddress`,`suppliers`.`suppliersCity` AS `suppliersCity`,`suppliers`.`suppliersState` AS `suppliersState`,`suppliers`.`suppliersPostCode` AS `suppliersPostCode`,`suppliers`.`suppliersCountry` AS `suppliersCountry`,`suppliers`.`suppliersWebPage` AS `suppliersWebPage`,`suppliers`.`suppliersNotes` AS `suppliersNotes`,`suppliers`.`suppliersAttachments` AS `suppliersAttachments` from `suppliers` order by if(isnull(`suppliers`.`suppliersLastName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersCompany`,`suppliers`.`suppliersFirstName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersLastName`,concat(`suppliers`.`suppliersLastName`,concat(' , ',`suppliers`.`suppliersFirstName`)))),if(isnull(`suppliers`.`suppliersLastName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersCompany`,`suppliers`.`suppliersFirstName`),if(isnull(`suppliers`.`suppliersFirstName`),`suppliers`.`suppliersLastName`,concat(`suppliers`.`suppliersFirstName`,concat(' , ',`suppliers`.`suppliersLastName`))));
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
