# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-12-18 23:13:37
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for icommon
DROP DATABASE IF EXISTS `icommon`;
CREATE DATABASE IF NOT EXISTS `icommon` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `icommon`;


# Dumping structure for table icommon.bank
DROP TABLE IF EXISTS `bank`;
CREATE TABLE IF NOT EXISTS `bank` (
  `bankId` int(11) NOT NULL AUTO_INCREMENT,
  `bankSequence` int(11) NOT NULL,
  `bankCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `bankSwiftCode` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `bankSwiftCodeCity` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bankSwiftCodeBranch` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bankMepsCode` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `bankDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bankAccount` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL,
  `isNew` tinyint(1) NOT NULL,
  `isDraft` tinyint(1) NOT NULL,
  `isUpdate` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `isReview` tinyint(1) NOT NULL,
  `isPost` tinyint(1) NOT NULL,
  `isDepositAccount` tinyint(1) NOT NULL,
  `isPayrollAccount` tinyint(1) NOT NULL,
  `isInvestmentAccount` tinyint(1) NOT NULL,
  `isTransactionAccount` tinyint(1) NOT NULL,
  `executeBy` int(1) NOT NULL,
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`bankId`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table icommon.bank: ~106 rows (approximately)
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
INSERT INTO `bank` (`bankId`, `bankSequence`, `bankCode`, `bankSwiftCode`, `bankSwiftCodeCity`, `bankSwiftCodeBranch`, `bankMepsCode`, `bankDesc`, `bankAccount`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `isDepositAccount`, `isPayrollAccount`, `isInvestmentAccount`, `isTransactionAccount`, `executeBy`, `executeTime`) VALUES
	(1, 0, ' ', 'Swift Code', '', '', 'Swift Co', 'Bank or Institution', '', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(2, 0, ' ', 'ABNAMY2AXXX', '', '', 'ABNAMY2A', 'ABN AMRO BANK N.V.', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(3, 0, ' ', 'PHBMMYKLXXX', '', '', 'PHBMMYKL', 'AFFIN BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(4, 0, ' ', 'AIBBMYKLXXX', '', '', 'AIBBMYKL', 'AFFIN ISLAMIC BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(5, 0, ' ', 'RJHIMYKLXXX', '', '', 'RJHIMYKL', 'AL RAJHI BANKING AND INVESTMENT CORPORATION (MALAYSIA) BHD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(6, 0, ' ', 'MFBBMYKLXXX', '', '', 'MFBBMYKL', 'ALLIANCE BANK MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(7, 0, ' ', 'ARBKMYKLXXX', '', '', 'ARBKMYKL', 'AMBANK (M) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(8, 0, ' ', 'AMMBMYKLXXX', '', '', 'AMMBMYKL', 'AMINVESTMENT BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(9, 0, ' ', 'AISLMYKLXXX', '', '', 'AISLMYKL', 'AMISLAMIC BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(10, 0, ' ', 'AFBQMYKLXXX', '', '', 'AFBQMYKL', 'ASIAN FINANCE BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(11, 0, ' ', 'BKKBMYKLXXX', '', '', 'BKKBMYKL', 'BANGKOK BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(12, 0, ' ', 'BIMBMYKLXXX', '', '', 'BIMBMYKL', 'BANK ISLAM MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(13, 0, ' ', 'BISLMYKAXXX', '', '', 'BISLMYKA', 'BANK ISLAM MALAYSIA BERHAD LABUAN OFFSHORE BRANCH', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(14, 0, ' ', 'BMMBMYKLXXX', '', '', 'BMMBMYKL', 'BANK MUAMALAT MALAYSIA BERHAD (6175-W)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(15, 0, ' ', 'BNMAMYKLXXX', '', '', 'BNMAMYKL', 'BANK NEGARA MALAYSIA', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(16, 0, ' ', 'BOFAMY2XXXX', '', '', 'BOFAMY2X', 'BANK OF AMERICA, MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(17, 0, ' ', 'BOFAMY2XLBN', '', '', 'BOFAMY2X', 'BANK OF AMERICA, MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(18, 0, ' ', 'BKCHMYKLXXX', '', '', 'BKCHMYKL', 'BANK OF CHINA (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(19, 0, ' ', 'NOSCMYKLXXX', '', '', 'NOSCMYKL', 'BANK OF NOVA SCOTIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(20, 0, ' ', 'NOSCMY2LXXX', '', '', 'NOSCMY2L', 'BANK OF NOVA SCOTIA, THE', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(21, 0, ' ', 'BOTKMYKXXXX', '', '', 'BOTKMYKX', 'BANK OF TOKYO-MITSUBISHI UFJ (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(22, 0, ' ', 'BOTKMYKAXXX', '', '', 'BOTKMYKA', 'BANK OF TOKYO-MITSUBISHI UFJ, LTD., THE', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(23, 0, ' ', 'BNPAMYKAXXX', '', '', 'BNPAMYKA', 'BNP PARIBAS', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(24, 0, ' ', 'CIBBMYKAXXX', '', '', 'CIBBMYKA', 'CIMB BANK (L) LIMITED', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(25, 0, ' ', 'CIBBMYKLXXX', '', '', 'CIBBMYKL', 'CIMB BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(26, 0, ' ', 'COIMMYKLXXX', '', '', 'COIMMYKL', 'CIMB INVESTMENT BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(27, 0, ' ', 'CTBBMYKLXXX', '', '', 'CTBBMYKL', 'CIMB ISLAMIC BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(28, 0, ' ', 'CITIMYKLPEN', '', '', 'CITIMYKL', 'CITIBANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(29, 0, ' ', 'CITIMYKLJOD', '', '', 'CITIMYKL', 'CITIBANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(30, 0, ' ', 'CITIMYKLXXX', '', '', 'CITIMYKL', 'CITIBANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(31, 0, ' ', 'CITIMYKLLAB', '', '', 'CITIMYKL', 'CITIBANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(32, 0, ' ', 'DBSSMY2AXXX', '', '', 'DBSSMY2A', 'DBS BANK LTD, LABUAN BRANCH', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(33, 0, ' ', 'DEUTMYKLGMO', '', '', 'DEUTMYKL', 'DEUTSCHE BANK (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(34, 0, ' ', 'DEUTMYKLISB', '', '', 'DEUTMYKL', 'DEUTSCHE BANK (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(35, 0, ' ', 'DEUTMYKLXXX', '', '', 'DEUTMYKL', 'DEUTSCHE BANK (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(36, 0, ' ', 'DEUTMYKLBLB', '', '', 'DEUTMYKL', 'DEUTSCHE BANK (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(37, 0, ' ', 'EOBBMYKLXXX', '', '', 'EOBBMYKL', 'EON BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(38, 0, ' ', 'EIBBMYKLXXX', '', '', 'EIBBMYKL', 'EONCAP ISLAMIC BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(39, 0, ' ', 'EXMBMYKLXXX', '', '', 'EXMBMYKL', 'EXPORT-IMPORT BANK OF MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(40, 0, ' ', 'FEEBMYKAXXX', '', '', 'FEEBMYKA', 'FIRST EAST EXPORT BANK', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(41, 0, ' ', 'HLBBMYKLJBU', '', '', 'HLBBMYKL', 'HONG LEONG BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(42, 0, ' ', 'HLBBMYKLIBU', '', '', 'HLBBMYKL', 'HONG LEONG BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(43, 0, ' ', 'HLBBMYKLXXX', '', '', 'HLBBMYKL', 'HONG LEONG BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(44, 0, ' ', 'HLBBMYKLKCH', '', '', 'HLBBMYKL', 'HONG LEONG BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(45, 0, ' ', 'HLBBMYKLPNG', '', '', 'HLBBMYKL', 'HONG LEONG BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(46, 0, ' ', 'HLIBMYKLXXX', '', '', 'HLIBMYKL', 'HONG LEONG ISLAMIC BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(47, 0, ' ', 'HSBCMYKAXXX', '', '', 'HSBCMYKA', 'HONGKONG AND SHANGHAI BANKING CORPORATION LTD.,THE', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(48, 0, ' ', 'HSTMMYKLGWS', '', '', 'HSTMMYKL', 'HSBC (MALAYSIA) TRUSTEE BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(49, 0, ' ', 'HSTMMYKLXXX', '', '', 'HSTMMYKL', 'HSBC (MALAYSIA) TRUSTEE BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(50, 0, ' ', 'HMABMYKLXXX', '', '', 'HMABMYKL', 'HSBC AMANAH MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(51, 0, ' ', 'HBMBMYKLXXX', '', '', 'HBMBMYKL', 'HSBC BANK MALAYSIA BERHAD, MALAYSIA', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(52, 0, ' ', 'HDSBMY2PXXX', '', '', 'HDSBMY2P', 'HWANGDBS INVESTMENT BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(53, 0, ' ', 'HDSBMY2PSEL', '', '', 'HDSBMY2P', 'HWANGDBS INVESTMENT BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(54, 0, ' ', 'CHASMYKXKEY', '', '', 'CHASMYKX', 'J.P.MORGAN CHASE BANK BERHAD, KUALA LUMPUR', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(55, 0, ' ', 'CHASMYKXXXX', '', '', 'CHASMYKX', 'J.P.MORGAN CHASE BANK BERHAD, KUALA LUMPUR', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(56, 0, ' ', 'KAFBMYKLXXX', '', '', 'KAFBMYKL', 'KAF INVESTMENT BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(57, 0, ' ', 'KFHOMYKLXXX', '', '', 'KFHOMYKL', 'KUWAIT FINANCE HOUSE (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(58, 0, ' ', 'MBBEMYKLBWC', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(59, 0, ' ', 'MBBEMYKLIPH', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(60, 0, ' ', 'MBBEMYKLJOB', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(61, 0, ' ', 'MBBEMYKLKIN', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(62, 0, ' ', 'MBBEMYKLBAN', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(63, 0, ' ', 'MBBEMYKLBBG', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(64, 0, ' ', 'MBBEMYKLCSD', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(65, 0, ' ', 'MBBEMYKLKEP', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(66, 0, ' ', 'MBBEMYKLPUD', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(67, 0, ' ', 'MBBEMYKLSUB', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(68, 0, ' ', 'MBBEMYKLKLC', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(69, 0, ' ', 'MBBEMYKLWSD', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(70, 0, ' ', 'MBBEMYKLXXX', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(71, 0, ' ', 'MBBEMYKLMAL', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(72, 0, ' ', 'MBBEMYKLPSG', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(73, 0, ' ', 'MBBEMYKLPGC', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(74, 0, ' ', 'MBBEMYKLPEN', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(75, 0, ' ', 'MBBEMYKLPJC', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(76, 0, ' ', 'MBBEMYKLYSL', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(77, 0, ' ', 'MBBEMYKLPJY', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(78, 0, ' ', 'MBBEMYKLPKG', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(79, 0, ' ', 'MBBEMYKLSBN', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(80, 0, ' ', 'MBBEMYKLSAC', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(81, 0, ' ', 'MBBEMYKLSHA', '', '', 'MBBEMYKL', 'MALAYAN BANKING BERHAD (MAYBANK)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(82, 0, ' ', 'MBBEMYKAXXX', '', '', 'MBBEMYKA', 'MAYBANK INTERNATIONAL (L) LTD.', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(83, 0, ' ', 'DABEMYKLXXX', '', '', 'DABEMYKL', 'MERCEDES-BENZ MALAYSIA SDN. BHD.', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(84, 0, ' ', 'MHCBMYKAXXX', '', '', 'MHCBMYKA', 'MIZUHO CORPORATE BANK, LTD., LABUAN BRANCH', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(85, 0, ' ', 'OABBMYKLXXX', '', '', 'OABBMYKL', 'OCBC AL-AMIN BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(86, 0, ' ', 'OCBCMYKLXXX', '', '', 'OCBCMYKL', 'OCBC BANK (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(87, 0, ' ', 'OSKIMYKLXXX', '', '', 'OSKIMYKL', 'OSK INVESTMENT BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(88, 0, ' ', 'PERMMYKLXXX', '', '', 'PERMMYKL', 'PERMODALAN NASIONAL BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(89, 0, ' ', 'PTROMYKLFSD', '', '', 'PTROMYKL', 'PETROLIAM NASIONAL BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(90, 0, ' ', 'PTROMYKLXXX', '', '', 'PTROMYKL', 'PETROLIAM NASIONAL BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(91, 0, ' ', 'PCGLMYKLXXX', '', '', 'PCGLMYKL', 'PETRONAS CARIGALI SDN BHD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(92, 0, ' ', 'PTRDMYKLXXX', '', '', 'PTRDMYKL', 'PETRONAS TRADING CORPORATION SDN. BHD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(93, 0, ' ', 'PBLLMYKAXXX', '', '', 'PBLLMYKA', 'PUBLIC BANK (L) LTD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(94, 0, ' ', 'PBBEMYKLXXX', '', '', 'PBBEMYKL', 'PUBLIC BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(95, 0, ' ', 'RHBBMYKAXXX', '', '', 'RHBBMYKA', 'RHB BANK (L) LTD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(96, 0, ' ', 'RHBBMYKLXXX', '', '', 'RHBBMYKL', 'RHB BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(97, 0, ' ', 'RHBAMYKLXXX', '', '', 'RHBAMYKL', 'RHB ISLAMIC BANK BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(98, 0, ' ', 'SCBLMYKXXXX', '', '', 'SCBLMYKX', 'STANDARD CHARTERED BANK MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(99, 0, ' ', 'SCBLMYKXLAB', '', '', 'SCBLMYKX', 'STANDARD CHARTERED BANK MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(100, 0, ' ', 'SMBCMYKAXXX', '', '', 'SMBCMYKA', 'SUMITOMO MITSUI BANKING CORPORATION', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(101, 0, ' ', 'ABNAMYKLXXX', '', '', 'ABNAMYKL', 'THE ROYAL BANK OF SCOTLAND BERHAD (301932-A)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(102, 0, ' ', 'ABNAMYKLPNG', '', '', 'ABNAMYKL', 'THE ROYAL BANK OF SCOTLAND BERHAD (301932-A)', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(103, 0, ' ', 'UIIBMYKLXXX', '', '', 'UIIBMYKL', 'UNICORN INTERNATIONAL ISLAMIC BANK MALAYSIA BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(104, 0, ' ', 'UOVBMYKLCND', '', '', 'UOVBMYKL', 'UNITED OVERSEAS BANK (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(105, 0, ' ', 'UOVBMYKLXXX', '', '', 'UOVBMYKL', 'UNITED OVERSEAS BANK (MALAYSIA) BERHAD', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 04:46:34'),
	(106, 0, 'k1x', 'k2x', 'k3x', 'k4x', '', 'k5x', '', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 2, '2011-11-22 16:44:02');
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;


# Dumping structure for table icommon.country
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

# Dumping data for table icommon.country: ~164 rows (approximately)
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`countryId`, `countrySequence`, `countryCode`, `countryCurrencyCode`, `countryCurrencyCodeDesc`, `countryDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, 'AE', 'AED', 'United Arab Emirates Dirham', 'United Arab Emirates ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(2, 0, 'AF', 'AFN', 'Afghanistan Afghani', 'stan ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(3, 0, 'AL', 'ALL', 'Albania Lek', 'Albania ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(4, 0, 'AM', 'AMD', 'Armenia Dram', 'Armenia', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(5, 0, 'AN', 'ANG', 'Netherlands Antilles Guilder', 'Netherlands Antilles ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(6, 0, 'AO', 'AOA', 'Angola Kwanza', 'Angola ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(7, 0, 'AR', 'ARS', 'Argentina Peso', 'Argentina ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(8, 0, 'AU', 'AUD', 'Australia Dollar', 'Australia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(9, 0, 'AW', 'AWG', 'Aruba Guilder', 'Aruba ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(10, 0, 'AZ', 'AZN', 'Azerbaijan New Manat', 'Azerbaijan New Manat', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(11, 0, 'BA', 'BAM', 'Bosnia and Herzegovina Convertible Marka', 'Bosnia and Herzegovina', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(12, 0, 'BB', 'BBD', 'Barbados Dollar', 'Barbados ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(13, 0, 'BD', 'BDT', 'Bangladesh Taka', 'Bangladesh', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(14, 0, 'BG', 'BGN', 'Bulgaria Lev', 'Bulgaria Lev', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(15, 0, 'BH', 'BHD', 'Bahrain Dinar', 'Bahrain ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(16, 0, 'BI', 'BIF', 'Burundi Franc', 'Burundi ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(17, 0, 'BM', 'BMD', 'Bermuda Dollar', 'Bermuda ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(18, 0, 'BN', 'BND', 'Brunei Darussalam Dollar', 'Brunei Darussalam ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(19, 0, 'BO', 'BOB', 'Bolivia Boliviano', 'Bolivia Boliviano', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(20, 0, 'BR', 'BRL', 'Brazil Real', 'Brazil Real', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(21, 0, 'BS', 'BSD', 'Bahamas Dollar', 'Bahamas ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(22, 0, 'BT', 'BTN', 'Bhutan Ngultrum', 'Bhutan Ngultrum', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(23, 0, 'BW', 'BWP', 'Botswana Pula', 'Botswana Pula', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(24, 0, 'BY', 'BYR', 'Belarus Ruble', 'Belarus ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(25, 0, 'BZ', 'BZD', 'Belize Dollar', 'Belize ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(26, 0, 'CA', 'CAD', 'Canada Dollar', 'Canada ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(27, 0, 'CD', 'CDF', 'Congo/Kinshasa Franc', 'Congo/Kinshasa ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(28, 0, 'CH', 'CHF', 'Switzerland Franc', 'Switzerland ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(29, 0, 'CL', 'CLP', 'Chile Peso', 'Chile ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(30, 0, 'CN', 'CNY', 'China Yuan Renminbi', 'China', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(31, 0, 'CO', 'COP', 'Colombia Peso', 'Colombia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(32, 0, 'CR', 'CRC', 'Costa Rica Colon', 'Costa Rica', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(33, 0, 'CU', 'CUC', 'Cuba Convertible Peso', 'Cuba', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(34, 0, 'CU', 'CUP', 'Cuba Peso', 'Cuba ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(35, 0, 'CV', 'CVE', 'Cape Verde Escudo', 'Cape Verde', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(36, 0, 'CZ', 'CZK', 'Czech Republic Koruna', 'Czech Republic', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(37, 0, 'DJ', 'DJF', 'Djibouti Franc', 'Djibouti ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(38, 0, 'DK', 'DKK', 'Denmark Krone', 'Denmark', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(39, 0, 'DO', 'DOP', 'Dominican Republic Peso', 'Dominican Republic ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(40, 0, 'DZ', 'DZD', 'Algeria Dinar', 'Algeria ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(41, 0, 'EG', 'EGP', 'Egypt Pound', 'Egypt ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(42, 0, 'ER', 'ERN', 'Eritrea Nakfa', 'Eritrea Nakfa', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(43, 0, 'ET', 'ETB', 'Ethiopia Birr', 'Ethiopia Birr', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(44, 0, 'EU', 'EUR', 'Euro Member Countries', 'Euro Member Countries', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(45, 0, 'FJ', 'FJD', 'Fiji Dollar', 'Fiji ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(46, 0, 'FK', 'FKP', 'Falkland Islands (Malvinas) Pound', 'Falkland Islands (Malvinas) ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(47, 0, 'GB', 'GBP', 'United Kingdom Pound', 'United Kingdom ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(48, 0, 'GE', 'GEL', 'Georgia Lari', 'Georgia Lari', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(49, 0, 'GG', 'GGP', 'Guernsey Pound', 'Guernsey ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(50, 0, 'GH', 'GHS', 'Ghana Cedi', 'Ghana Cedi', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(51, 0, 'GI', 'GIP', 'Gibraltar Pound', 'Gibraltar ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(52, 0, 'GM', 'GMD', 'Gambia Dalasi', 'Gambia Dalasi', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(53, 0, 'GN', 'GNF', 'Guinea Franc', 'Guinea ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(54, 0, 'GT', 'GTQ', 'Guatemala Quetzal', 'Guatemala Quetzal', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(55, 0, 'GY', 'GYD', 'Guyana Dollar', 'Guyana ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(56, 0, 'HK', 'HKD', 'Hong Kong Dollar', 'Hong Kong ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(57, 0, 'HN', 'HNL', 'Honduras Lempira', 'Honduras ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(58, 0, 'HR', 'HRK', 'Croatia Kuna', 'Croatia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(59, 0, 'HT', 'HTG', 'Haiti Gourde', 'Haiti Gourde', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(60, 0, 'HU', 'HUF', 'Hungary Forint', 'Hungary Forint', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(61, 0, 'ID', 'IDR', 'Indonesia Rupiah', 'Indonesia Rupiah', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(62, 0, 'IL', 'ILS', 'Israel Shekel', 'Israel Shekel', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(63, 0, 'IM', 'IMP', 'Isle of Man Pound', 'Isle of Man ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(64, 0, 'IN', 'INR', 'India Rupee', 'India ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(65, 0, 'IQ', 'IQD', 'Iraq Dinar', 'Iraq ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(66, 0, 'IR', 'IRR', 'Iran Rial', 'Iran ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(67, 0, 'IS', 'ISK', 'Iceland Krona', 'Iceland ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(68, 0, 'JE', 'JEP', 'Jersey Pound', 'Jersey ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(69, 0, 'JM', 'JMD', 'Jamaica Dollar', 'Jamaica ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(70, 0, 'JO', 'JOD', 'Jordan Dinar', 'Jordan ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(71, 0, 'JP', 'JPY', 'Japan Yen', 'Japan Yen', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(72, 0, 'KE', 'KES', 'Kenya Shilling', 'Kenya ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(73, 0, 'KG', 'KGS', 'Kyrgyzstan Som', 'Kyrgyzstan ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(74, 0, 'KH', 'KHR', 'Cambodia Riel', 'Cambodia Riel', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(75, 0, 'KM', 'KMF', 'Comoros Franc', 'Comoros ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(76, 0, 'KP', 'KPW', 'Korea (North) Won', 'Korea (North) Won', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(77, 0, 'KR', 'KRW', 'Korea (South) Won', 'Korea (South) Won', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(78, 0, 'KW', 'KWD', 'Kuwait Dinar', 'Kuwait ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(79, 0, 'KY', 'KYD', 'Cayman Islands Dollar', 'Cayman Islands ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(80, 0, 'KZ', 'KZT', 'Kazakhstan Tenge', 'Kazakhstan Tenge', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(81, 0, 'LA', 'LAK', 'Laos Kip', 'Laos Kip', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(82, 0, 'LB', 'LBP', 'Lebanon Pound', 'Lebanon ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(83, 0, 'LK', 'LKR', 'Sri Lanka Rupee', 'Sri Lanka ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(84, 0, 'LR', 'LRD', 'Liberia Dollar', 'Liberia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(85, 0, 'LS', 'LSL', 'Lesotho Loti', 'Lesotho Loti', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(86, 0, 'LT', 'LTL', 'Lithuania Litas', 'Lithuania Litas', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(87, 0, 'LV', 'LVL', 'Latvia Lat', 'Latvia Lat', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(88, 0, 'LY', 'LYD', 'Libya Dinar', 'Libya ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(89, 0, 'MA', 'MAD', 'Morocco Dirham', 'Morocco ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(90, 0, 'MD', 'MDL', 'Moldova Leu', 'Moldova Leu', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(91, 0, 'MG', 'MGA', 'Madagascar Ariary', 'Madagascar Ariary', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(92, 0, 'MK', 'MKD', 'Macedonia Denar', 'Macedonia Denar', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(93, 0, 'MM', 'MMK', 'Myanmar (Burma) Kyat', 'Myanmar (Burma) Kyat', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(94, 0, 'MN', 'MNT', 'Mongolia Tughrik', 'Mongolia Tughrik', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(95, 0, 'MO', 'MOP', 'Macau Pataca', 'Macau Pataca', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(96, 0, 'MR', 'MRO', 'Mauritania Ouguiya', 'Mauritania Ouguiya', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(97, 0, 'MU', 'MUR', 'Mauritius Rupee', 'Mauritius ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(98, 0, 'MV', 'MVR', 'Maldives (Maldive Islands) Rufiyaa', 'Maldives (Maldive Islands) ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(99, 0, 'MW', 'MWK', 'Malawi Kwacha', 'Malawi Kwacha', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(100, 0, 'MX', 'MXN', 'Mexico Peso', 'Mexico ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(101, 1, 'MY', 'MYR', 'Malaysia Ringgit', 'Malaysia', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(102, 0, 'MZ', 'MZN', 'Mozambique Metical', 'Mozambique', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(103, 0, 'NA', 'NAD', 'Namibia Dollar', 'Namibia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(104, 0, 'NG', 'NGN', 'Nigeria Naira', 'Nigeria Naira', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(105, 0, 'NI', 'NIO', 'Nicaragua Cordoba', 'Nicaragua Cordoba', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(106, 0, 'NO', 'NOK', 'Norway Krone', 'Norway Krone', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(107, 0, 'NP', 'NPR', 'Nepal Rupee', 'Nepal ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(108, 0, 'NZ', 'NZD', 'New Zealand Dollar', 'New Zealand ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(109, 0, 'OM', 'OMR', 'Oman Rial', 'Oman ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(110, 0, 'PA', 'PAB', 'Panama Balboa', 'Panama Balboa', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(111, 0, 'PE', 'PEN', 'Peru Nuevo Sol', 'Peru Nuevo', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(112, 0, 'PG', 'PGK', 'Papua New Guinea Kina', 'Papua New Guinea', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(113, 0, 'PH', 'PHP', 'Philippines Peso', 'Philippines ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(114, 0, 'PK', 'PKR', 'Pakistan Rupee', 'Pakistan ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(115, 0, 'PL', 'PLN', 'Poland Zloty', 'Poland Zloty', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(116, 0, 'PY', 'PYG', 'Paraguay Guarani', 'Paraguay Guarani', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(117, 0, 'QA', 'QAR', 'Qatar Riyal', 'Qatar Riyal', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(118, 0, 'RO', 'RON', 'Romania New Leu', 'Romania New Leu', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(119, 0, 'RS', 'RSD', 'Serbia Dinar', 'Serbia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(120, 0, 'RU', 'RUB', 'Russia Ruble', 'Russia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(121, 0, 'RW', 'RWF', 'Rwanda Franc', 'Rwanda ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(122, 0, 'SA', 'SAR', 'Saudi Arabia Riyal', 'Saudi Arabia Riyal', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(123, 0, 'SB', 'SBD', 'Solomon Islands Dollar', 'Solomon Islands ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(124, 0, 'SC', 'SCR', 'Seychelles Rupee', 'Seychelles ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(125, 0, 'SD', 'SDG', 'Sudan Pound', 'Sudan ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(126, 0, 'SE', 'SEK', 'Sweden Krona', 'Sweden ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(127, 0, 'SG', 'SGD', 'Singapore Dollar', 'Singapore ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(128, 0, 'SH', 'SHP', 'Saint Helena Pound', 'Saint Helena ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(129, 0, 'SL', 'SLL', 'Sierra Leone Leone', 'Sierra Leone Leone', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(130, 0, 'SO', 'SOS', 'Somalia Shilling', 'alia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(131, 0, 'SP', 'SPL*', 'Seborga Luigino', 'Seborga Luigino', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(132, 0, 'SR', 'SRD', 'Suriname Dollar', 'Suriname ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(133, 0, 'ST', 'STD', 'S?o Principe and Tome Dobra', 'S?o Principe and Tome Dobra', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(134, 0, 'SV', 'SVC', 'El Salvador Colon', 'El Salvador Colon', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(135, 0, 'SY', 'SYP', 'Syria Pound', 'Syria ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(136, 0, 'SZ', 'SZL', 'Swaziland Lilangeni', 'Swaziland Lilangeni', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(137, 0, 'TH', 'THB', 'Thailand Baht', 'Thailand Baht', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(138, 0, 'TJ', 'TJS', 'Tajikistan Somoni', 'Tajikistan oni', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(139, 0, 'TM', 'TMT', 'Turkmenistan Manat', 'Turkmenistan Manat', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(140, 0, 'TN', 'TND', 'Tunisia Dinar', 'Tunisia ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(141, 0, 'TO', 'TOP', 'Tonga Pa\'anga', 'Tonga Pa\'anga', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(142, 0, 'TR', 'TRY', 'Turkey Lira', 'Turkey Lira', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(143, 0, 'TT', 'TTD', 'Trinidad and Tobago Dollar', 'Trinidad and Tobago ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(144, 0, 'TV', 'TVD', 'Tuvalu Dollar', 'Tuvalu ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(145, 0, 'TW', 'TWD', 'Taiwan New Dollar', 'Taiwan New ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(146, 0, 'TZ', 'TZS', 'Tanzania Shilling', 'Tanzania ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(147, 0, 'UA', 'UAH', 'Ukraine Hryvna', 'Ukraine Hryvna', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(148, 0, 'UG', 'UGX', 'Uganda Shilling', 'Uganda ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(149, 0, 'US', 'USD', 'United States Dollar', 'United States ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(150, 0, 'UY', 'UYU', 'Uruguay Peso', 'Uruguay ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(151, 0, 'UZ', 'UZS', 'Uzbekistan Som', 'Uzbekistan ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(152, 0, 'VE', 'VEF', 'Venezuela Bolivar Fuerte', 'Venezuela', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(153, 0, 'VN', 'VND', 'Viet Nam Dong', 'Viet Nam ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(154, 0, 'VU', 'VUV', 'Vanuatu Vatu', 'Vanuatu', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(155, 0, 'WS', 'WST', 'Samoa Tala', 'Samoa', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(156, 0, 'XA', 'XAF', 'Communaut‚ FinanciŠre Africaine (BEAC) CFA Franc BEAC', 'Communaut‚ FinanciŠre Africaine (BEAC) CFA  BEAC', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(157, 0, 'XC', 'XCD', 'East Caribbean Dollar', 'East Caribbean ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(158, 0, 'XD', 'XDR', 'International Monetary Fund (IMF) Special Drawing Rights', 'International Monetary Fund (IMF) Special Drawing Rights', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(159, 0, 'XO', 'XOF', 'Communaut‚ FinanciŠre Africaine (BCEAO) Franc', 'Communaut‚ FinanciŠre Africaine (BCEAO) ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(160, 0, 'XP', 'XPF', 'Comptoirs Fran‡ais du Pacifique (CFP) Franc', 'Comptoirs Fran‡ais du Pacifique (CFP) ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(161, 0, 'YE', 'YER', 'Yemen Rial', 'Yemen ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(162, 0, 'ZA', 'ZAR', 'South Africa Rand', 'South Africa Rand', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(163, 0, 'ZM', 'ZMK', 'Zambia Kwacha', 'Zambia Kwacha', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(164, 0, 'ZW', 'ZWD', 'Zimbabwe Dollar', 'Zimbabwe ', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;


# Dumping structure for table icommon.disease
DROP TABLE IF EXISTS `disease`;
CREATE TABLE IF NOT EXISTS `disease` (
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

# Dumping data for table icommon.disease: ~9 rows (approximately)
/*!40000 ALTER TABLE `disease` DISABLE KEYS */;
INSERT INTO `disease` (`diseaseId`, `diseaseSequence`, `diseaseCode`, `diseaseDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, ' ', 'Tiada Penyakit', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(2, 0, ' ', 'Lelah(Asma)', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(3, 0, ' ', 'Darah Tinggi', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(4, 0, ' ', 'Sakit Jantung', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(5, 0, ' ', 'Kencing Manis', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(6, 0, ' ', 'Barah', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(7, 0, ' ', 'Buah Pinggan', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(8, 0, ' ', 'Sakit Tua', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33'),
	(9, 0, ' ', 'lain-lain', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:33');
/*!40000 ALTER TABLE `disease` ENABLE KEYS */;


# Dumping structure for table icommon.district
DROP TABLE IF EXISTS `district`;
CREATE TABLE IF NOT EXISTS `district` (
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

# Dumping data for table icommon.district: ~149 rows (approximately)
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` (`districtId`, `districtSequence`, `districtCode`, `districtDesc`, `countryId`, `stateId`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, '', 'Timur Laut P.Pinang', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(2, 0, '', 'Seberang Prai Utara', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(3, 0, '', 'Seberang Prai Tengah', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(4, 0, '', 'Seberang Prai Selatan', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(5, 0, '', 'Bukit Mertajam', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(6, 0, '', 'Balik Pulau', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(7, 0, '', 'Seberang Jaya', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(8, 0, '', 'Kepala Batas', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(9, 0, '', 'Kinta', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(10, 0, '', 'Larut', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(11, 0, '', 'Matang', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(12, 0, '', 'Selama', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(13, 0, '', 'Hilir Perak', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(14, 0, '', 'Manjung', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(15, 0, '', 'Batang Padang', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(16, 0, '', 'Batu Gajah', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(17, 0, '', 'Sg. Siput', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(18, 0, '', 'Lambor Kanan', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(19, 0, '', 'Seri Manjung', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(20, 0, '', 'Grik', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(21, 0, '', 'Slim River', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(22, 0, '', 'Kampar', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(23, 0, '', 'Kerian', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(24, 0, '', 'Kuala Kangsar', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(25, 0, '', 'Hulu Perak', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(26, 0, '', 'Parit Buntar', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(27, 0, '', 'Perak Tengah', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(28, 0, '', 'Ipoh', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(29, 0, '', 'Tapah', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(30, 0, '', 'Teluk Intan', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(31, 0, '', 'Taiping', 24, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(32, 0, '', 'Gombak', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(33, 0, '', 'Hulu Langat', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(34, 0, '', 'Hulu Selangor', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(35, 0, '', 'Klang', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(36, 0, '', 'Kuala Langat', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(37, 0, '', 'Kuala Selangor', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(38, 0, '', 'Petaling Jaya', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(39, 0, '', 'Sabak Bernam', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(40, 0, '', 'Sepang', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(41, 0, '', 'Shah Alam', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(42, 0, '', 'Putrajaya', 24, 5, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(43, 0, '', 'Jelebu', 24, 6, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(44, 0, '', 'Jempol', 24, 6, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(45, 0, '', 'Kuala Pilah', 24, 6, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(46, 0, '', 'Port Dickson', 24, 6, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(47, 0, '', 'Rembau', 24, 6, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(48, 0, '', 'Seremban', 24, 6, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(49, 0, '', 'Tampin', 24, 6, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(50, 0, '', 'Alor Gajah', 24, 7, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(51, 0, '', 'Central Melaka', 24, 7, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(52, 0, '', 'Jasin', 24, 7, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(53, 0, '', 'Melaka Town', 24, 7, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(54, 0, '', 'Batu Pahat', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(55, 0, '', 'Johor Bharu', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(56, 0, '', 'Kluang', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(57, 0, '', 'Kota Tinggi', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(58, 0, '', 'Kulai', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(59, 0, '', 'Mersing', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(60, 0, '', 'Muar', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(61, 0, '', 'Pontian', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(62, 0, '', 'Segamat', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(63, 0, '', 'Tangkak', 24, 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(64, 0, '', 'Bera', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(65, 0, '', 'Bentong', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(66, 0, '', 'Cameron Highlands', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(67, 0, '', 'Jengka', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(68, 0, '', 'Jerantut', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(69, 0, '', 'Kuantan', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(70, 0, '', 'Kuala Lipis', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(71, 0, '', 'Maran', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(72, 0, '', 'Mentakab', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(73, 0, '', 'Muadzam', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(74, 0, '', 'Pekan', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(75, 0, '', 'Raub', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(76, 0, '', 'Rompin', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(77, 0, '', 'Temerloh', 24, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(78, 0, '', 'Besut', 24, 10, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(79, 0, '', 'Dungun', 24, 10, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(80, 0, '', 'Hulu Terengganu', 24, 10, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(81, 0, '', 'Kemaman', 24, 10, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(82, 0, '', 'Kuala Terengganu', 24, 10, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(83, 0, '', 'Marang', 24, 10, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(84, 0, '', 'Setiu', 24, 10, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(93, 0, '', 'Bandar Tun Razak', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(94, 0, '', 'Batu', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(95, 0, '', 'Bukit Bintang', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(96, 0, '', 'Cheras', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(97, 0, '', 'Kepong', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(98, 0, '', 'Lembah Pantai', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(99, 0, '', 'Segamat', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(100, 0, '', 'Seputeh', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(101, 0, '', 'Setiawangsa', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(102, 0, '', 'Titiwangsa', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(103, 0, '', 'Wangsa Maju', 24, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(104, 0, '', 'Bachok', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(105, 0, '', 'Gua Musang', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(106, 0, '', 'Jeli', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(107, 0, '', 'Kota Bharu', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(108, 0, '', 'Kuala Krai', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(109, 0, '', 'Machang', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(110, 0, '', 'Pasir Mas', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(111, 0, '', 'Pasir Puteh', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(112, 0, '', 'Tanah Merah', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(113, 0, '', 'Tumpat', 24, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(114, 0, '', 'Pantai Barat', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(115, 0, '', 'Kudat', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(116, 0, '', 'Sandakan', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(117, 0, '', 'Tawau', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(118, 0, '', 'Pedalaman', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(119, 0, '', 'Kota Kinabalu', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(120, 0, '', 'Beaufort', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(121, 0, '', 'Beluran', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(122, 0, '', 'Keningau', 24, 12, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(123, 0, '', 'labuan', 24, 13, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(124, 0, '', 'Betong', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(125, 0, '', 'Bintulu', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(126, 0, '', 'Kapit', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(127, 0, '', 'Kuching', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(128, 0, '', 'Limbang', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(129, 0, '', 'Miri', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(130, 0, '', 'Mukah', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(131, 0, '', 'Samarahan', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(132, 0, '', 'Sarikei', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(133, 0, '', 'Sri Aman', 24, 14, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(134, 0, '', 'Arau', 24, 15, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(135, 0, '', 'Chuping', 24, 15, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(136, 0, '', 'Kuala Perlis', 24, 15, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(137, 0, '', 'Sanglang', 24, 15, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(138, 0, '', 'Kangar', 24, 15, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(139, 0, '', 'Alor Setar', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(140, 0, '', 'Baling', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(141, 0, '', 'Bandar Bharu', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(142, 0, '', 'Jitra', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(143, 0, '', 'Kuala Muda', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(144, 0, '', 'Kubang Pasu', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(145, 0, '', 'Kuala Nerang', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(146, 0, '', 'Kulim', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(147, 0, '', 'Langkawi', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(148, 0, '', 'Sik', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(149, 0, '', 'Yan', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(150, 0, '', 'Sungai Petani', 24, 16, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(151, 0, '', 'Kajang', 24, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(152, 0, '', 'Barat Daya P.Pinang', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(153, 0, '', 'Georgetown', 24, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, '0000-00-00 00:00:00'),
	(154, 0, '', 'kambing', 24, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-21 21:54:35'),
	(155, 0, '', 'kambingx', 24, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-21 21:55:10'),
	(156, 0, '', 'kucingx', 24, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-21 21:56:12'),
	(157, 0, '', '78', 24, 7, 0, 0, 0, 1, 0, 1, 0, 0, 0, 2, '2011-11-21 22:21:35');
/*!40000 ALTER TABLE `district` ENABLE KEYS */;


# Dumping structure for table icommon.education
DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
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

# Dumping data for table icommon.education: ~10 rows (approximately)
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` (`educationId`, `educationSequence`, `educationCode`, `educationDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, ' ', 'Tidak Bersekolah', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(2, 0, ' ', 'Pra Persekolahan', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(3, 0, ' ', 'Sekolah Rendah/Setaraf', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(4, 0, ' ', 'Menengah Rendah/Setaraf', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(5, 0, ' ', 'Menengah Tinggi/Setaraf', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(6, 0, ' ', 'Kolej', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(7, 0, ' ', 'Maktab', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(8, 0, ' ', 'Diploma', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(9, 0, ' ', 'Ijazah', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29'),
	(10, 0, ' ', 'PHD', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 11:20:29');
/*!40000 ALTER TABLE `education` ENABLE KEYS */;


# Dumping structure for table icommon.family
DROP TABLE IF EXISTS `family`;
CREATE TABLE IF NOT EXISTS `family` (
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

# Dumping data for table icommon.family: ~21 rows (approximately)
/*!40000 ALTER TABLE `family` DISABLE KEYS */;
INSERT INTO `family` (`familyId`, `familyCode`, `familyDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, '', 'SUAMI', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(2, '', 'ISTERI', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(3, '', 'BAPA', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(4, '', 'IBU', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(5, '', 'ANAK', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(6, '', 'BAPA SAUDARA', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(7, '', 'IBU SAUDARA', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(8, '', 'ANAK ANGKAT', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(9, '', 'BAPA MERTUA', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(10, '', 'IBU MERTUA', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(11, '', 'ANAK SAUDARA', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(12, '', 'CUCU', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(13, '', 'NENEK', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(14, '', 'DATUK', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(15, '', 'SEPUPU', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(16, '', 'ABANG', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(17, '', 'KAKAK', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(18, '', 'ADIK', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(19, '', 'MENANTU', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(20, '', 'ANAK TIRI', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(21, '', 'TIADA', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127);
/*!40000 ALTER TABLE `family` ENABLE KEYS */;


# Dumping structure for table icommon.gender
DROP TABLE IF EXISTS `gender`;
CREATE TABLE IF NOT EXISTS `gender` (
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

# Dumping data for table icommon.gender: ~2 rows (approximately)
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` (`genderId`, `genderSequence`, `genderCode`, `genderDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 1, 'M', 'Lelaki', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:58'),
	(2, 2, 'F', 'Perempuan', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:58');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;


# Dumping structure for table icommon.impair
DROP TABLE IF EXISTS `impair`;
CREATE TABLE IF NOT EXISTS `impair` (
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

# Dumping data for table icommon.impair: ~8 rows (approximately)
/*!40000 ALTER TABLE `impair` DISABLE KEYS */;
INSERT INTO `impair` (`impairId`, `impairSequence`, `impairCode`, `impairDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, ' ', 'Tidak Cacat', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08'),
	(2, 0, ' ', 'Buta', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08'),
	(3, 0, ' ', 'Kurang Penglihatan', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08'),
	(4, 0, ' ', 'Pekak', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08'),
	(5, 0, ' ', 'Kurang Pendengaran', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08'),
	(6, 0, ' ', 'Tidak Bergerak Bebas', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08'),
	(7, 0, ' ', 'Cacat Akal/Jiwa', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08'),
	(8, 0, ' ', 'Lain-lain', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:08');
/*!40000 ALTER TABLE `impair` ENABLE KEYS */;


# Dumping structure for table icommon.marriage
DROP TABLE IF EXISTS `marriage`;
CREATE TABLE IF NOT EXISTS `marriage` (
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

# Dumping data for table icommon.marriage: ~5 rows (approximately)
/*!40000 ALTER TABLE `marriage` DISABLE KEYS */;
INSERT INTO `marriage` (`marriageId`, `marriageSequence`, `marriageCode`, `marriageDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, ' ', 'Belum Berkahwin', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:51'),
	(2, 0, ' ', 'Berkahwin', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:51'),
	(3, 0, ' ', 'Duda', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:51'),
	(4, 0, ' ', 'Janda', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:51'),
	(5, 0, ' ', 'Balu', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, '2011-11-22 17:38:51');
/*!40000 ALTER TABLE `marriage` ENABLE KEYS */;


# Dumping structure for table icommon.race
DROP TABLE IF EXISTS `race`;
CREATE TABLE IF NOT EXISTS `race` (
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

# Dumping data for table icommon.race: ~16 rows (approximately)
/*!40000 ALTER TABLE `race` DISABLE KEYS */;
INSERT INTO `race` (`raceId`, `raceSequence`, `raceCode`, `raceDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(2, 0, 'Mela', 'Melayu', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(3, 0, 'Cina', 'Cina', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(4, 0, 'Inda', 'India', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(5, 0, 'Bdyh', 'Bidayuh', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(6, 0, 'Meln', 'Melanau', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(7, 0, 'Iban', 'Iban', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(8, 0, 'Kdzn', 'Kadazan', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(9, 0, 'Murt', 'Murut', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(10, 0, 'Baja', 'Bajau', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(12, 0, 'Keyn', 'Kedayan', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(15, 0, 'Sulu', 'Sulu', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(17, 0, 'Brni', 'Brunei', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(18, 0, 'Bajr', 'Banjar', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(19, 0, 'Dusn', 'Dusun', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(20, 0, 'Rugs', 'Rungus', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(21, 0, 'SiNa', 'Sino-Native', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127);
/*!40000 ALTER TABLE `race` ENABLE KEYS */;


# Dumping structure for table icommon.religion
DROP TABLE IF EXISTS `religion`;
CREATE TABLE IF NOT EXISTS `religion` (
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

# Dumping data for table icommon.religion: ~9 rows (approximately)
/*!40000 ALTER TABLE `religion` DISABLE KEYS */;
INSERT INTO `religion` (`religionId`, `religionSequence`, `religionCode`, `religionDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 0, 'Is', 'Islam', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(2, 0, 'Kr', 'Kristian', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(3, 0, 'Bu', 'Budha', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(4, 0, 'Hi', 'Hindu', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(5, 0, 'Co', 'Confucius', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(6, 0, 'ASK', 'Agama Suku Kaum', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(7, 0, 'Ta', 'Tiada Agama', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(8, 0, 'LL', 'Lain-lain', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127),
	(9, 0, 'kk', 'jgkgkjgkj', 0, 1, 0, 0, 0, 1, 0, 0, 0, 2, 127);
/*!40000 ALTER TABLE `religion` ENABLE KEYS */;


# Dumping structure for table icommon.salutation
DROP TABLE IF EXISTS `salutation`;
CREATE TABLE IF NOT EXISTS `salutation` (
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

# Dumping data for table icommon.salutation: ~0 rows (approximately)
/*!40000 ALTER TABLE `salutation` DISABLE KEYS */;
/*!40000 ALTER TABLE `salutation` ENABLE KEYS */;


# Dumping structure for table icommon.state
DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
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

# Dumping data for table icommon.state: ~16 rows (approximately)
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
INSERT INTO `state` (`stateId`, `countryId`, `stateSequence`, `stateCode`, `stateDesc`, `isDefault`, `isNew`, `isDraft`, `isUpdate`, `isDelete`, `isActive`, `isApproved`, `isReview`, `isPost`, `executeBy`, `executeTime`) VALUES
	(1, 24, 0, '', 'Pulau Pinang', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(2, 24, 0, '', 'Perak', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(3, 24, 0, '', 'Selangor', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(4, 24, 0, '', 'Wilayah Persekutuan', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(5, 24, 0, '', 'Putrajaya', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(6, 24, 0, '', 'N. Sembilan', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(7, 24, 0, '', 'Melaka', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(8, 24, 0, '', 'Johor', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(9, 24, 0, '', 'Pahang', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(10, 24, 0, '', 'Terengganu', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(11, 24, 0, '', 'Kelantan', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(12, 24, 0, '', 'Sabah', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(13, 24, 0, '', 'W.P Labuan', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(14, 24, 0, '', 'Sarawak', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(15, 24, 0, '', 'Perlis', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0),
	(16, 24, 0, '', 'Kedah', 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0);
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
