# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-12-18 23:27:48
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for icalendar
DROP DATABASE IF EXISTS `icalendar`;
CREATE DATABASE IF NOT EXISTS `icalendar` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `icalendar`;


# Dumping structure for table icalendar.calendar
DROP TABLE IF EXISTS `calendar`;
CREATE TABLE IF NOT EXISTS `calendar` (
  `calendarId` int(10) NOT NULL AUTO_INCREMENT,
  `calendarColorId` int(10) DEFAULT '0',
  `calendarTitle` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  `calendarDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `isHidden` tinyint(4) NOT NULL DEFAULT '0',
  `staffId` int(10) DEFAULT NULL,
  PRIMARY KEY (`calendarId`),
  KEY `calendarColorId` (`calendarColorId`),
  KEY `staffId` (`staffId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table icalendar.calendar: ~4 rows (approximately)
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` (`calendarId`, `calendarColorId`, `calendarTitle`, `calendarDesc`, `isHidden`, `staffId`) VALUES
	(1, 1, 'Work', '', 0, 2),
	(2, 2, 'House', '', 0, 2),
	(3, 3, 'unknown', '', 0, 2),
	(4, 4, 'Personel Project', '', 0, 2);
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;


# Dumping structure for table icalendar.calendarcolor
DROP TABLE IF EXISTS `calendarcolor`;
CREATE TABLE IF NOT EXISTS `calendarcolor` (
  `calendarColorId` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`calendarColorId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table icalendar.calendarcolor: ~10 rows (approximately)
/*!40000 ALTER TABLE `calendarcolor` DISABLE KEYS */;
INSERT INTO `calendarcolor` (`calendarColorId`) VALUES
	(1),
	(2),
	(3),
	(4),
	(5),
	(6),
	(7),
	(8),
	(9),
	(10);
/*!40000 ALTER TABLE `calendarcolor` ENABLE KEYS */;


# Dumping structure for table icalendar.event
DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
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
  KEY `calendarId` (`calendarId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table icalendar.event: ~3 rows (approximately)
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` (`eventId`, `calendarId`, `eventTitle`, `eventDesc`, `eventStart`, `eventEnd`, `eventLocation`, `eventNotes`, `eventUrl`, `eventIsAllDay`, `eventIsNew`, `eventReminder`, `staffId`, `executeTime`) VALUES
	(1, 1, 'startin the multi db  system', '', '2011-11-15 00:00:00', '2011-11-15 01:00:00', '', '', '', 0, 0, '', 2, '2011-11-27 14:59:11'),
	(2, 1, 'start mult system update doll b', '', '2011-11-16 00:00:00', '2011-11-16 01:00:00', '', '', '', 0, 0, '', 2, '2011-11-27 14:59:32'),
	(5, 1, 'lalalaa', '', '2011-11-27 00:00:00', '2011-11-27 00:00:00', '', '', '', 0, 0, '', 2, '2011-11-27 15:02:53');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
