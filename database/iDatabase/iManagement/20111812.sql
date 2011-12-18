# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-12-18 23:11:55
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for imanagement
DROP DATABASE IF EXISTS `imanagement`;
CREATE DATABASE IF NOT EXISTS `imanagement` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `imanagement`;


# Dumping structure for table imanagement.branch
DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `branchId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `myCompanyId` int(11) NOT NULL,
  `branchSequence` int(11) NOT NULL,
  `branchCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `branchDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
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
  PRIMARY KEY (`branchId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Dumping data for table imanagement.branch: ~0 rows (approximately)
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;


# Dumping structure for table imanagement.company
DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `myCompanyId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `myCompanySequence` int(11) NOT NULL,
  `myCompanyCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `myCompanyDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
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
  PRIMARY KEY (`myCompanyId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

# Dumping data for table imanagement.company: ~12 rows (approximately)
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` (`myCompanyId`, `myCompanySequence`, `myCompanyCode`, `myCompanyDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, 'MIS', 'Management Information System', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(2, 2, 'QIS', 'Quality Insurance', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(3, 3, 'CRM', 'Marketing', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-08-25 12:25:49'),
	(4, 4, 'MGT', 'Management', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(5, 5, 'HRM', 'Human Resources', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(6, 6, 'FIN', 'Finance', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(7, 7, 'MEC', 'Mechanical', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(8, 8, 'ECL', 'Electrical', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(9, 9, 'LDS', 'Landscape', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(10, 10, 'MSC', 'Music', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(11, 11, 'HPL', 'Hospitality', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(12, 12, 'PRT', 'Production', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;


# Dumping structure for table imanagement.department
DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `departmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `myCompanyId` int(11) NOT NULL,
  `branchId` int(11) NOT NULL,
  `departmentSequence` int(11) NOT NULL,
  `departmentCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `departmentDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

# Dumping data for table imanagement.department: ~12 rows (approximately)
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` (`departmentId`, `myCompanyId`, `branchId`, `departmentSequence`, `departmentCode`, `departmentDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, 0, 1, 'MIS', 'Management Information System', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(2, 0, 0, 2, 'QIS', 'Quality Insurance', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(3, 0, 0, 3, 'CRM', 'Marketing', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-08-25 12:25:49'),
	(4, 0, 0, 4, 'MGT', 'Management', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(5, 0, 0, 5, 'HRM', 'Human Resources', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(6, 0, 0, 6, 'FIN', 'Finance', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(7, 0, 0, 7, 'MEC', 'Mechanical', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(8, 0, 0, 8, 'ECL', 'Electrical', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(9, 0, 0, 9, 'LDS', 'Landscape', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(10, 0, 0, 10, 'MSC', 'Music', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(11, 0, 0, 11, 'HPL', 'Hospitality', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(12, 0, 0, 12, 'PRT', 'Production', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;


# Dumping structure for table imanagement.location
DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `locationId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `myCompanyId` int(11) NOT NULL,
  `branchId` int(11) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `locationSequence` int(11) NOT NULL,
  `locationCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locationDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
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
  PRIMARY KEY (`locationId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

# Dumping data for table imanagement.location: ~12 rows (approximately)
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` (`locationId`, `myCompanyId`, `branchId`, `departmentId`, `locationSequence`, `locationCode`, `locationDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, 0, 0, 1, 'MIS', 'Management Information System', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(2, 0, 0, 0, 2, 'QIS', 'Quality Insurance', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(3, 0, 0, 0, 3, 'CRM', 'Marketing', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-08-25 12:25:49'),
	(4, 0, 0, 0, 4, 'MGT', 'Management', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(5, 0, 0, 0, 5, 'HRM', 'Human Resources', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(6, 0, 0, 0, 6, 'FIN', 'Finance', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(7, 0, 0, 0, 7, 'MEC', 'Mechanical', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(8, 0, 0, 0, 8, 'ECL', 'Electrical', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(9, 0, 0, 0, 9, 'LDS', 'Landscape', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(10, 0, 0, 0, 10, 'MSC', 'Music', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(11, 0, 0, 0, 11, 'HPL', 'Hospitality', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25'),
	(12, 0, 0, 0, 12, 'PRT', 'Production', 0, 1, 0, 1, 0, 1, 0, 0, 0, 2, '2011-08-25 12:31:25');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;


# Dumping structure for table imanagement.staff
DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
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

# Dumping data for table imanagement.staff: ~7 rows (approximately)
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` (`staffId`, `teamId`, `departmentId`, `languageId`, `staffPassword`, `staffName`, `staffNo`, `staffIc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(2, 1, 1, 21, '690b2646e03f5411e297d208b79d4807', 'root', '', '', 0, 0, 0, 1, 0, 1, 2, 0, 0, 2, '0000-00-00 00:00:00'),
	(3, 1, 1, 21, '690b2646e03f5411e297d208b79d4807', 'admin', '', '', 0, 0, 0, 1, 0, 1, 2, 0, 0, 2, '0000-00-00 00:00:00'),
	(4, 2, 1, 21, '690b2646e03f5411e297d208b79d4807', 'supervisor', '', '', 0, 0, 0, 1, 0, 1, 2, 0, 0, 2, '0000-00-00 00:00:00'),
	(5, 3, 1, 21, '690b2646e03f5411e297d208b79d4807', 'staff', '', '', 0, 0, 0, 1, 0, 1, 2, 0, 0, 2, '0000-00-00 00:00:00'),
	(6, 4, 1, 21, '690b2646e03f5411e297d208b79d4807', 'member', '', '', 0, 0, 0, 1, 0, 1, 2, 0, 0, 2, '0000-00-00 00:00:00'),
	(7, 5, 1, 21, '690b2646e03f5411e297d208b79d4807', 'demo', '', '', 0, 0, 0, 1, 0, 1, 2, 0, 0, 2, '0000-00-00 00:00:00'),
	(8, 6, 1, 21, '690b2646e03f5411e297d208b79d4807', 'manager', '', '', 0, 0, 0, 1, 0, 1, 2, 0, 0, 2, '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;


# Dumping structure for table imanagement.team
DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `teamId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Group|',
  `teamSequence` int(11) NOT NULL,
  `teamCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `teamDesc` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'English|',
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

# Dumping data for table imanagement.team: ~6 rows (approximately)
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` (`teamId`, `teamSequence`, `teamCode`, `teamDesc`, `isAdmin`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, 'ad', 'administrator', 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(2, 2, 'sp', 'supervisor', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(3, 3, 'sf', 'staff', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(4, 4, 'mbr', 'member', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(5, 5, 'demo', 'demo', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(6, 5, 'mgr', 'manager', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
