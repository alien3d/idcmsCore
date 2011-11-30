
DROP TABLE IF EXISTS `adjustment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment` (
  `adjustmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
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

DROP TABLE IF EXISTS `adjustmentDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustmentDetail` (
  `adjustmentDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `adjustmentId` int(11) NOT NULL,
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `countryCurrencyCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
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

CREATE TABLE `bankBalance` (
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

CREATE TABLE `businessPartner` (
  `businessPartnerId` int(10) NOT NULL AUTO_INCREMENT,
  `businessPartnerCompany` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerLastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerFirstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerEmail` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerJobTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerBusinessPhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerHomePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerMobilePhone` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerFaxNum` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerAddress` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `businessPartnerCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerState` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerPostCode` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerCountry` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `businessPartnerWebPage` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `businessPartnerNotes` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `businessPartnerAttachments` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
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
  KEY `businessPartnerCategoryId` (`businessPartnerCategoryId`),
  CONSTRAINT `businesspartner_ibfk_1` FOREIGN KEY (`businessPartnerCategoryId`) REFERENCES `businesspartnercategory` (`businessPartnerCategoryId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

INSERT INTO `businessPartner` VALUES (1,'Northwind Traders','Freehafer','Nancy','nancy@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 1st Avenue','Seattle','WA','99999','USA','#http://northwindtraders.com#',NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(2,'Northwind Traders','Cencini','Andrew','andrew@northwindtraders.com','Vice President, Sales','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 2nd Avenue','Bellevue','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Joined the company as a sales representative, was promoted to sales manager and was then named vice president of sales.',NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(3,'Northwind Traders','Kotas','Jan','jan@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 3rd Avenue','Redmond','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Was hired as a sales associate and was promoted to sales representative.',NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(4,'Northwind Traders','Sergienko','Mariya','mariya@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 4th Avenue','Kirkland','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#',NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5,'Northwind Traders','Thorpe','Steven','steven@northwindtraders.com','Sales Manager','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 5th Avenue','Seattle','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Joined the company as a sales representative and was promoted to sales manager.  Fluent in French.',NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(6,'Northwind Traders','Neipper','Michael','michael@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 6th Avenue','Redmond','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Fluent in Japanese and can read and write French, Portuguese, and Spanish.',NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(7,'Northwind Traders','Zare','Robert','robert@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 7th Avenue','Seattle','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#',NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(8,'Northwind Traders','Giussani','Laura','laura@northwindtraders.com','Sales Coordinator','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 8th Avenue','Redmond','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Reads and writes French.',NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(9,'Northwind Traders','Hellung-Larsen','Anne','anne@northwindtraders.com','Sales Representative','(123)555-0100','(123)555-0102',NULL,'(123)555-0103','123 9th Avenue','Seattle','WA','99999','USA','http://northwindtraders.com#http://northwindtraders.com/#','Fluent in French and German.',NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(16,'Company A','Bedecs','Anna',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 1st Street','Seattle','WA','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(17,'Company B','Gratacos Solsona','Antonio',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 2nd Street','Boston','MA','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(18,'Company C','Axen','Thomas',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','123 3rd Street','Los Angelas','CA','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(19,'Company D','Lee','Christina',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 4th Street','New York','NY','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(20,'Company E','O’Donnell','Martin',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 5th Street','Minneapolis','MN','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(21,'Company F','Pérez-Olaeta','Francisco',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 6th Street','Milwaukee','WI','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(22,'Company G','Xie','Ming-Yang',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','123 7th Street','Boise','ID','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(23,'Company H','Andersen','Elizabeth',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','123 8th Street','Portland','OR','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(24,'Company I','Mortensen','Sven',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 9th Street','Salt Lake City','UT','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(25,'Company J','Wacker','Roland',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 10th Street','Chicago','IL','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(26,'Company K','Krschne','Peter',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 11th Street','Miami','FL','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(27,'Company L','Edwards','John',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','123 12th Street','Las Vegas','NV','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(28,'Company M','Ludick','Andre',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 13th Street','Memphis','TN','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(29,'Company N','Grilo','Carlos',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 14th Street','Denver','CO','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(30,'Company O','Kupkova','Helena',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','456 15th Street','Honolulu','HI','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(31,'Company P','Goldschmidt','Daniel',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 16th Street','San Francisco','CA','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(32,'Company Q','Bagel','Jean Philippe',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','456 17th Street','Seattle','WA','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(33,'Company R','Autier Miconi','Catherine',NULL,'Purchasing Representative','(123)555-0100',NULL,NULL,'(123)555-0101','456 18th Street','Boston','MA','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(34,'Company S','Eggerer','Alexander',NULL,'Accounting Assistant','(123)555-0100',NULL,NULL,'(123)555-0101','789 19th Street','Los Angelas','CA','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(35,'Company T','Li','George',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 20th Street','New York','NY','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(36,'Company U','Tham','Bernard',NULL,'Accounting Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 21th Street','Minneapolis','MN','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(37,'Company V','Ramos','Luciana',NULL,'Purchasing Assistant','(123)555-0100',NULL,NULL,'(123)555-0101','789 22th Street','Milwaukee','WI','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(38,'Company W','Entin','Michael',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 23th Street','Portland','OR','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(39,'Company X','Hasselberg','Jonas',NULL,'Owner','(123)555-0100',NULL,NULL,'(123)555-0101','789 24th Street','Salt Lake City','UT','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(40,'Company Y','Rodman','John',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 25th Street','Chicago','IL','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(41,'Company Z','Liu','Run',NULL,'Accounting Assistant','(123)555-0100',NULL,NULL,'(123)555-0101','789 26th Street','Miami','FL','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(42,'Company AA','Toh','Karen',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 27th Street','Las Vegas','NV','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(43,'Company BB','Raghav','Amritansh',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 28th Street','Memphis','TN','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(44,'Company CC','Lee','Soo Jung',NULL,'Purchasing Manager','(123)555-0100',NULL,NULL,'(123)555-0101','789 29th Street','Denver','CO','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(47,'Supplier A','Andersen','Elizabeth A.',NULL,'Sales Manager',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(48,'Supplier B','Weiler','Cornelia',NULL,'Sales Manager',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(49,'Supplier C','Kelley','Madeleine',NULL,'Sales Representative',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(50,'Supplier D','Sato','Naoki',NULL,'Marketing Manager',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(51,'Supplier E','Hernandez-Echevarria','Amaya',NULL,'Sales Manager',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(52,'Supplier F','Hayakawa','Satomi',NULL,'Marketing Assistant',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(53,'Supplier G','Glasson','Stuart',NULL,'Marketing Manager',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(54,'Supplier H','Dunton','Bryn Paul',NULL,'Sales Representative',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(55,'Supplier I','Sandberg','Mikael',NULL,'Sales Manager',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(56,'Supplier J','Sousa','Luis',NULL,'Sales Manager',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(62,'Shipping Company A',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'123 Any Street','Memphis','TN','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(63,'Shipping Company B',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'123 Any Street','Memphis','TN','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(64,'Shipping Company C',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'123 Any Street','Memphis','TN','99999','USA',NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00');

CREATE TABLE `businessPartnerCategory` (
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


INSERT INTO `businessPartnerCategory` VALUES (1,'dsfsdfsdf',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00');

CREATE TABLE `documentNoAssign` (
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

CREATE TABLE `documentNoCode` (
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

CREATE TABLE `documentNoSequence` (
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

CREATE TABLE `financialDuration` (
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

CREATE TABLE `generalLedger` (
  `generalLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `invoiceNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `paymentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `adjustmentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `depositNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerDate` date NOT NULL,
  `countryCurrencyCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerAmount` double(12,2) NOT NULL,
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
  `executeBy` int(11) NOT NULL COMMENT 'By|',
  `executeTime` datetime NOT NULL,
  PRIMARY KEY (`generalLedgerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

CREATE TABLE `generalLedgerBudget` (
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
  PRIMARY KEY (`generalLedgerBudgetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

CREATE TABLE `generalLedgerChartOfAccount` (
  `generalLedgerChartOfAccountId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartAccountTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartOfAccountNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartAccountTypeId` int(11) NOT NULL COMMENT ' bank, Accounts Receivable, Other Current Asset, Fixed Asset, Accounts Payable, Credit Card, Other Current Liability, Long Term Liability, Equity, Income, Cost of Goods Sold, Expense, Non-Posting',
  `generalLedgerChartAccountReportType` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '''Balance Sheet'',''P&L Statement''',
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
  PRIMARY KEY (`generalLedgerChartOfAccountId`)
) ENGINE=InnoDB AUTO_INCREMENT=444 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';


INSERT INTO `generalLedgerChartOfAccount` VALUES (9,'ASSETS','ASSETS','1000',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(10,' Checking Account #1',' Checking Account #1','1000',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(11,' Checking Account #2',' Checking Account #2','1010',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(12,' Escrow Account',' Escrow Account','1020',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(13,' Payroll Account',' Payroll Account','1030',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(14,' Reserve Account-Warranty',' Reserve Account-Warranty','1040',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(15,' Savings Account #1',' Savings Account #1','1050',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(16,' Money Market Account #1',' Money Market Account #1','1060',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(17,' Short Term CD\'s',' Short Term CD\'s','1070',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(18,' Costs Pd by Third Parties',' Costs Pd by Third Parties','1080',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(19,' Petty Cash',' Petty Cash','1090',1,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(20,' Accounts Receivable',' Accounts Receivable','1100',2,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(21,' Retainage Receivable',' Retainage Receivable','1110',2,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(22,' Rental Property Leases',' Rental Property Leases','1120',2,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(23,' Due from Subsidary Companies',' Due from Subsidary Companies','1150',2,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(24,' Long Term CD\'s',' Long Term CD\'s','1200',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(25,' [Bank Name - CD #1]',' [Bank Name - CD #1]','1201',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(26,' [Bank Name - CD #2]',' [Bank Name - CD #2]','1202',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(27,' [Bank Name - CD #3]',' [Bank Name - CD #3]','1203',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(28,' Government Securities',' Government Securities','1210',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(29,' [Name - Gov\'t Security #1]',' [Name - Gov\'t Security #1]','1211',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(30,' [Name - Gov\'t Security #2]',' [Name - Gov\'t Security #2]','1212',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(31,' [Name - Gov\'t Security #3]',' [Name - Gov\'t Security #3]','1213',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(32,' Mutual Funds',' Mutual Funds','1220',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(33,' [Name - Mutual Funds #1]',' [Name - Mutual Funds #1]','1221',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(34,' [Name - Mutual Funds #2]',' [Name - Mutual Funds #2]','1222',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(35,' [Name - Mutual Funds #3]',' [Name - Mutual Funds #3]','1223',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(36,' Marketable Stocks',' Marketable Stocks','1230',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(37,' [Name - Stock #1]',' [Name - Stock #1]','1231',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(38,' [Name - Stock #2]',' [Name - Stock #2]','1232',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(39,' [Name - Stock #3]',' [Name - Stock #3]','1233',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(40,' Loans Made To Others',' Loans Made To Others','1300',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(41,' [Name - Loan #1]',' [Name - Loan #1]','1301',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(42,' [Name - Loan #2]',' [Name - Loan #2]','1302',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(43,' [Name - Loan #3]',' [Name - Loan #3]','1303',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(44,' Loans Made To Principles',' Loans Made To Principles','1350',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(45,' [Name - Loan #1]',' [Name - Loan #1]','1351',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(46,' [Name - Loan #2]',' [Name - Loan #2]','1352',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(47,' [Name - Loan #3]',' [Name - Loan #3]','1353',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(48,' Inventory - Land',' Inventory - Land','1400',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(49,' Inventory - Houses',' Inventory - Houses','1500',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(50,' [Street Address - Unit #1]',' [Street Address - Unit #1]','1501',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(51,' [Street Address - Unit #2]',' [Street Address - Unit #2]','1502',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(52,' [Street Address - Unit #3]',' [Street Address - Unit #3]','1503',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(53,' Inventory- Rental Property',' Inventory- Rental Property','1600',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(54,' [Street Address - Unit #1]',' [Street Address - Unit #1]','1601',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(55,' [Street Address - Unit #2]',' [Street Address - Unit #2]','1602',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(56,' [Street Address - Unit #3]',' [Street Address - Unit #3]','1603',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(57,' Business Property',' Business Property','1690',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(58,'Office Building & Land','Office Building & Land','1691',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(59,'Shop Building & Land','Shop Building & Land','1692',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(60,' Work in Progress',' Work in Progress','1700',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(61,' Other Assets',' Other Assets','1710',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(62,' Prepaid Expenses',' Prepaid Expenses','1720',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(63,' Refundable Deposits',' Refundable Deposits','1730',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(64,' Undeposited Funds',' Undeposited Funds','1740',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(65,' Reserve - G/L Insurance',' Reserve - G/L Insurance','1750',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(66,' Reserve - Work Comp',' Reserve - Work Comp','1760',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(67,' Reserve - Warranty',' Reserve - Warranty','1770',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(68,' Shop Inventory',' Shop Inventory','1780',3,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(69,' Fixed Assets-General',' Fixed Assets-General','1800',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(70,' Business Vehicles',' Business Vehicles','1810',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(71,' Tools & Equipment',' Tools & Equipment','1820',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(72,' Office Furninshings & Equip',' Office Furninshings & Equip','1830',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(73,' Model Home Furnishings',' Model Home Furnishings','1835',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(74,' Office/Shop Buildings',' Office/Shop Buildings','1840',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(75,' Leasehold Improvements',' Leasehold Improvements','1845',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(76,' Fixed Assets-Other',' Fixed Assets-Other','1849',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(77,' Accumulated Dep-General',' Accumulated Dep-General','1850',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(78,' Accumulated Dep-Vehicles',' Accumulated Dep-Vehicles','1860',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(79,' Accumulated Dep-Tools',' Accumulated Dep-Tools','1870',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(80,' Accumulated Dep-Office Equipment',' Accumulated Dep-Office Equipment','1880',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(81,' Accumulated Dep-Model Furnishings',' Accumulated Dep-Model Furnishings','1885',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(82,' Accumulated Dep-Buildings',' Accumulated Dep-Buildings','1890',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(83,' Accumulated Dep-Lease Improvements',' Accumulated Dep-Lease Improvements','1895',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(84,' Accumulated Dep-Other',' Accumulated Dep-Other','1899',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(85,' Depreciated Assets-General',' Depreciated Assets-General','1900',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(86,' Depreciated Vehicles',' Depreciated Vehicles','1910',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(87,' Depreciated Tools/Equipment',' Depreciated Tools/Equipment','1920',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(88,' Depreciated Office Equipment',' Depreciated Office Equipment','1930',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(89,' Depreciated Model Furnshings',' Depreciated Model Furnshings','1935',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(90,' Depreciated Buildings',' Depreciated Buildings','1940',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(91,' Depreciated Lease Improvements',' Depreciated Lease Improvements','1945',4,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(92,'LIABILITIES','LIABILITIES','2000',5,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(93,' Accounts Payable',' Accounts Payable','2000',5,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(94,' Retainage Payable',' Retainage Payable','2010',5,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(95,' Business Taxes Payable',' Business Taxes Payable','2020',5,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(96,' Open Purchase Orders',' Open Purchase Orders','2040',5,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(97,' Credit Card #1',' Credit Card #1','2050',6,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(98,' Credit Card #2',' Credit Card #2','2060',6,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(99,' Short Term Loans',' Short Term Loans','2100',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(100,' [Name - Loan #1]',' [Name - Loan #1]','2101',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(101,' [Name - Loan #2]',' [Name - Loan #2]','2102',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(102,' [Name - Loan #3]',' [Name - Loan #3]','2103',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(103,' Loans from Principals',' Loans from Principals','2110',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(104,' [Name - Loan #1]',' [Name - Loan #1]','2111',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(105,' [Name - Loan #2]',' [Name - Loan #2]','2112',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(106,' [Name - Loan #3]',' [Name - Loan #3]','2113',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(107,' Construction Loans',' Construction Loans','2200',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(108,' Other Current Liabilities',' Other Current Liabilities','2300',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(109,' G/L Insurance (on revenue)',' G/L Insurance (on revenue)','2310',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(110,' Contract Deposits',' Contract Deposits','2320',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(111,' Lease Deposits',' Lease Deposits','2330',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(112,' Payroll Liabilities',' Payroll Liabilities','2400',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(113,' Employee Fed Tax Withholdings',' Employee Fed Tax Withholdings','2405',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(114,' Employee Soc. Sec. Withholdings',' Employee Soc. Sec. Withholdings','2410',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(115,' Employee Medicare Withholdings',' Employee Medicare Withholdings','2415',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(116,' Employee State Tax Withholdings',' Employee State Tax Withholdings','2420',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(117,' Employee Local Tax Withholdings',' Employee Local Tax Withholdings','2425',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(118,' Company Soc. Sec. Liability',' Company Soc. Sec. Liability','2430',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(119,' Company Medicare Liability',' Company Medicare Liability','2435',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(120,' Fed Unemployment Tax Liability',' Fed Unemployment Tax Liability','2440',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(121,' St Unemployment Tax Liability',' St Unemployment Tax Liability','2445',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(122,' State Employment Taxes Owed',' State Employment Taxes Owed','2450',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(123,' Local Employment Taxes Owed',' Local Employment Taxes Owed','2455',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(124,' Company Paid Health Insurance',' Company Paid Health Insurance','2460',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(125,' Employee Paid Health Insurance',' Employee Paid Health Insurance','2465',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(126,' W/C Insurance Liability',' W/C Insurance Liability','2470',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(127,' G/L Insurance (on payroll)',' G/L Insurance (on payroll)','2475',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(128,' Company Paid Benefits',' Company Paid Benefits','2476',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(129,' Accrued Vacation/Sick time',' Accrued Vacation/Sick time','2480',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(130,' Retirement Plan Contributions',' Retirement Plan Contributions','2490',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(131,' Contract Draw Liabilities',' Contract Draw Liabilities','2500',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(132,' Vendor Liabilities',' Vendor Liabilities','2550',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(133,'Vendor Insurance Liabilities','Vendor Insurance Liabilities','2555',7,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(134,' Vehicle/Equipment Loans',' Vehicle/Equipment Loans','2600',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(135,' Payee Name - Loan #1',' Payee Name - Loan #1','2601',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(136,' Payee Name - Loan #2',' Payee Name - Loan #2','2602',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(137,' Payee Name - Loan #3',' Payee Name - Loan #3','2603',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(138,' Mortgages Owned',' Mortgages Owned','2700',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(139,' Street Address - Unit #1',' Street Address - Unit #1','2701',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(140,' Street Address - Unit #2',' Street Address - Unit #2','2702',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(141,' Street Address - Unit #3',' Street Address - Unit #3','2703',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(142,'R/E Development Loans','R/E Development Loans','2800',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(143,' Subdivision - Loan #1',' Subdivision - Loan #1','2801',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(144,' Subdivision - Loan #2',' Subdivision - Loan #2','2802',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(145,' Subdivision - Loan #3',' Subdivision - Loan #3','2803',8,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(146,' Owner\'s Equity',' Owner\'s Equity','2900',9,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(147,' Capitol Stock',' Capitol Stock','2910',9,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(148,' Revenue in Excess of Costs',' Revenue in Excess of Costs','2920',9,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(149,' Retained Earnings',' Retained Earnings','2990',9,'Balance Sheet',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(150,'INCOME','INCOME','3000',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(151,' Construction Revenue',' Construction Revenue','3000',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(152,' Construction Loan Draws',' Construction Loan Draws','3050',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(153,' Land / Lot Sales',' Land / Lot Sales','3100',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(154,' Residential Construction',' Residential Construction','3200',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(155,' Residential Remodeling',' Residential Remodeling','3300',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(156,' Commercial Construction',' Commercial Construction','3400',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(157,' Commercial Remodeling',' Commercial Remodeling','3500',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(158,' Shop Projects',' Shop Projects','3600',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(159,' Professional Services',' Professional Services','3700',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(160,' Inspection Services',' Inspection Services','3710',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(161,' Design/Drafting Services',' Design/Drafting Services','3720',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(162,' Estimating Services',' Estimating Services','3730',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(163,' Construction Management',' Construction Management','3740',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(164,' Property Management',' Property Management','3750',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(165,' Referrals & Commissions',' Referrals & Commissions','3790',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(166,' Subcontracting',' Subcontracting','3800',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(167,' Rental Property Income',' Rental Property Income','3900',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(168,' Interest Income',' Interest Income','3950',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(169,' Discounts Taken',' Discounts Taken','3960',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(170,' Gain/Loss Sale of Assets',' Gain/Loss Sale of Assets','3970',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(171,' Miscellaneous Income',' Miscellaneous Income','3980',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(172,' Transferred to Acct #2200 CLD',' Transferred to Acct #2200 CLD','3990',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(173,' Transferred to Acct #2500 CDL',' Transferred to Acct #2500 CDL','3995',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(174,' Perm Uncategorized Income',' Perm Uncategorized Income','3998',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(175,' Temp Uncategorized Income',' Temp Uncategorized Income','3999',10,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(176,'DIRECT EXPENSES (Construction Costs)','DIRECT EXPENSES (Construction Costs)','4000',0,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(177,'OTHER DIRECT EXPENSES','OTHER DIRECT EXPENSES','4400',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(178,' SUBCONTRATING COSTS',' SUBCONTRATING COSTS','4400',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(179,' Subcontracted Costs - Uncategorized',' Subcontracted Costs - Uncategorized','4410',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(180,' Materials - Uncategorized',' Materials - Uncategorized','4420',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(181,' Labor - Uncategorized',' Labor - Uncategorized','4430',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(182,' Rental - Uncategorized',' Rental - Uncategorized','4440',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(183,' [unit cost assembly #1]',' [unit cost assembly #1]','4450',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(184,' [unit cost assembly #2]',' [unit cost assembly #2]','4451',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(185,' [unit cost assembly #3]',' [unit cost assembly #3]','4452',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(186,' SHOP COSTS',' SHOP COSTS','4500',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(187,' Shop Costs-General',' Shop Costs-General','4510',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(188,' Shop Materials',' Shop Materials','4520',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(189,' Shop Labor',' Shop Labor','4530',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(190,' Shop Rental',' Shop Rental','4540',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(191,' Shop Overhead',' Shop Overhead','4550',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(192,' RENTAL PROPERTY COSTS',' RENTAL PROPERTY COSTS','4600',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(193,' Acquisition Costs',' Acquisition Costs','4610',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(194,' Rental Commissions',' Rental Commissions','4615',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(195,' Management Fees',' Management Fees','4620',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(196,' Advertising',' Advertising','4625',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(197,' Credit Checks',' Credit Checks','4630',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(198,' Maintenance & Repairs',' Maintenance & Repairs','4635',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(199,' Cleaning',' Cleaning','4640',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(200,' Pest Control',' Pest Control','4645',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(201,' Insurance',' Insurance','4650',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(202,' Utilities',' Utilities','4655',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(203,' Property Taxes',' Property Taxes','4660',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(204,' Legal Expenses',' Legal Expenses','4665',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(205,' Sales taxes (on leases)',' Sales taxes (on leases)','4670',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(206,' PROFESSIONAL SERVICE COSTS',' PROFESSIONAL SERVICE COSTS','4700',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(207,' DESIGN SERVICE COSTS',' DESIGN SERVICE COSTS','4800',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(208,' Design Fees',' Design Fees','4810',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(209,' Drafting Supplies',' Drafting Supplies','4820',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(210,' Copying & Blueprinting',' Copying & Blueprinting','4830',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(211,' Delivery & Shipping',' Delivery & Shipping','4840',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(212,' MISCELLANEOUS',' MISCELLANEOUS','4900',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(213,' Transferred to Acct #1500 INV',' Transferred to Acct #1500 INV','4990',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(214,' Transferred to Acct #1700 WIP',' Transferred to Acct #1700 WIP','4995',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(215,' Perm Uncategorized Job Costs',' Perm Uncategorized Job Costs','4998',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(216,' Temp Uncategorized Job Costs',' Temp Uncategorized Job Costs','4999',11,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(217,' SALES AND MARKETING',' SALES AND MARKETING','5000',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(218,' Preliminary Designs',' Preliminary Designs','5005',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(219,' Advertising',' Advertising','5010',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(220,' Promotional Events',' Promotional Events','5020',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(221,' Promotional Literature',' Promotional Literature','5030',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(222,' Displays/Product Samples',' Displays/Product Samples','5035',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(223,' Signage',' Signage','5040',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(224,' Model Home Lease',' Model Home Lease','5050',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(225,' Model Home Insurance',' Model Home Insurance','5051',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(226,' Model Home Security',' Model Home Security','5052',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(227,' Model Home Maintenance',' Model Home Maintenance','5053',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(228,' Model Home HOA Fees',' Model Home HOA Fees','5054',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(229,' Model Home Phone',' Model Home Phone','5055',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(230,' Model Home Utilities',' Model Home Utilities','5056',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(231,' Model Home Reception',' Model Home Reception','5057',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(232,' Model Home Furnishings',' Model Home Furnishings','5058',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(233,' Model Home Decorating',' Model Home Decorating','5059',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(234,' Model Home Miscellaneous',' Model Home Miscellaneous','5060',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(235,' Sales & Marketing Expense-Other',' Sales & Marketing Expense-Other','5090',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(236,' PERSONNEL EXPENSES',' PERSONNEL EXPENSES','5100',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(237,' Office/Clerical Personnel',' Office/Clerical Personnel','5105',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(238,' Bookkeeping Personnel',' Bookkeeping Personnel','5110',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(239,' Estimating/Purchasing Personnel',' Estimating/Purchasing Personnel','5115',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(240,' Estimating/Sales Personnel',' Estimating/Sales Personnel','5120',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(241,' Design/Sales Personnel',' Design/Sales Personnel','5125',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(242,' Sales Management Personnel',' Sales Management Personnel','5130',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(243,' Project Management Personnel',' Project Management Personnel','5135',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(244,' Field Supervisory Personnel',' Field Supervisory Personnel','5140',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(245,' Undistributed Field Labor',' Undistributed Field Labor','5145',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(246,' Employee Bonuses',' Employee Bonuses','5150',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(247,' Employee Sick Pay',' Employee Sick Pay','5155',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(248,' Employee Vacation Pay',' Employee Vacation Pay','5156',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(249,' Company Paid Medicare (FICA)',' Company Paid Medicare (FICA)','5160',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(250,' Company Paid Soc. Sec. (FICA)',' Company Paid Soc. Sec. (FICA)','5161',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(251,' Federal Unemployment Tax (FUTA)',' Federal Unemployment Tax (FUTA)','5165',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(252,' State Unemployment Tax (SUTA)',' State Unemployment Tax (SUTA)','5166',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(253,' Local Payroll Taxes',' Local Payroll Taxes','5167',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(254,' Workers Comp Insurance',' Workers Comp Insurance','5170',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(255,' Co. Paid Health Insurance',' Co. Paid Health Insurance','5175',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(256,' Co. Paid Disability Insurance',' Co. Paid Disability Insurance','5176',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(257,' Co. Paid Retirement Plan',' Co. Paid Retirement Plan','5177',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(258,' Employment Advertising',' Employment Advertising','5180',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(259,' Recruiting & Hiring',' Recruiting & Hiring','5181',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(260,' Training & Education',' Training & Education','5182',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(261,' Employee Entertainment',' Employee Entertainment','5183',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(262,' Payroll Service Fees',' Payroll Service Fees','5184',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(263,' Prior Period Payroll Taxes',' Prior Period Payroll Taxes','5190',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(264,' Prior Period FICA',' Prior Period FICA','5191',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(265,' Prior Period FUTA',' Prior Period FUTA','5192',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(266,' Prior Period SUTA',' Prior Period SUTA','5193',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(267,' Prior Period Local Taxes',' Prior Period Local Taxes','5194',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(268,' Prior Period Payroll Tax-Other',' Prior Period Payroll Tax-Other','5195',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(269,' BUSINESS OVERHEAD',' BUSINESS OVERHEAD','5200',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(270,' Accounting Fees',' Accounting Fees','5205',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(271,' Association Dues',' Association Dues','5210',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(272,' Association Functions',' Association Functions','5215',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(273,' Attorney Costs/Expenses',' Attorney Costs/Expenses','5220',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(274,' Attorney Fees',' Attorney Fees','5225',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(275,' Bad Debts',' Bad Debts','5230',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(276,' Bank Account Finance Charges',' Bank Account Finance Charges','5235',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(277,' Bank Account Service Fees',' Bank Account Service Fees','5240',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(278,' Blueprinting',' Blueprinting','5245',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(279,' Bonding',' Bonding','5250',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(280,' Bookkeeping Fees',' Bookkeeping Fees','5255',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(281,' Charitable Contributions',' Charitable Contributions','5260',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(282,' Client Entertainment',' Client Entertainment','5265',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(283,' Computer Software',' Computer Software','5270',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(284,' Consultant-Business',' Consultant-Business','5275',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:17'),(285,' Consultant-Computer',' Consultant-Computer','5280',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(286,' Consultant-PR/Marketing',' Consultant-PR/Marketing','5285',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(287,' Consumable Tools',' Consumable Tools','5290',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(288,' Corporation Fees & Costs',' Corporation Fees & Costs','5295',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(289,' Credit Card Finance Charges',' Credit Card Finance Charges','5300',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(290,' Credit Card Service Fees',' Credit Card Service Fees','5305',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(291,' Equipment Lease-Copier',' Equipment Lease-Copier','5310',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(292,' Equipment Lease-Office',' Equipment Lease-Office','5315',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(293,' Equipment Lease-Postage Meter',' Equipment Lease-Postage Meter','5320',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(294,' Equipment Lease-Tools',' Equipment Lease-Tools','5325',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(295,' Equipment Maintanence & Repairs',' Equipment Maintanence & Repairs','5330',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(296,' Estimating / Selling',' Estimating / Selling','5335',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(297,' Insurance-Bonding',' Insurance-Bonding','5340',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(298,' Insurance-Builders Risk Policy',' Insurance-Builders Risk Policy','5345',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(299,' Insurance-Completed Operations',' Insurance-Completed Operations','5350',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(300,' Insurance-G/L (on payroll)',' Insurance-G/L (on payroll)','5355',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(301,' Insurance-G/L (on revenue)',' Insurance-G/L (on revenue)','5360',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(302,' Insurance-Life (lender req\'d)',' Insurance-Life (lender req\'d)','5365',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(303,' Insurance-Life (on employees)',' Insurance-Life (on employees)','5370',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(304,' Insurance-Other',' Insurance-Other','5375',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(305,' Insurance-Rental Equipment',' Insurance-Rental Equipment','5380',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(306,' Insurance-Vehicles',' Insurance-Vehicles','5385',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(307,' Interest-Inventory Houses',' Interest-Inventory Houses','5390',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(308,' Interest-Inventory Lots',' Interest-Inventory Lots','5395',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(309,' Interest-Loans',' Interest-Loans','5400',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(310,' Internet Service Provider',' Internet Service Provider','5405',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(311,' Internet Web Site',' Internet Web Site','5410',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(312,' Mailbox Rental',' Mailbox Rental','5415',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(313,' Mileage Reimbursement',' Mileage Reimbursement','5420',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(314,' Minor Medical Expenses',' Minor Medical Expenses','5425',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(315,' Miscellaneous Overhead Costs',' Miscellaneous Overhead Costs','5430',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(316,' Mobile Radio Service',' Mobile Radio Service','5435',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(317,' Office Building Maintenance',' Office Building Maintenance','5440',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(318,' Office Cleaning Service',' Office Cleaning Service','5445',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(319,' Office Equip Maint. & Repairs',' Office Equip Maint. & Repairs','5450',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(320,' Office Misc. Expenses',' Office Misc. Expenses','5455',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(321,' Office Rent/Lease',' Office Rent/Lease','5460',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(322,' Office Security Monitoring',' Office Security Monitoring','5465',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(323,' Office Storage',' Office Storage','5470',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(324,' Office Supplies',' Office Supplies','5475',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(325,' Office Utilities',' Office Utilities','5480',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(326,' Packing/Shipping Service',' Packing/Shipping Service','5485',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(327,' Pager Service',' Pager Service','5490',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(328,' Photography',' Photography','5495',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(329,' Postage (USPS)',' Postage (USPS)','5500',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(330,' Printing & Copying',' Printing & Copying','5505',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(331,' Professional Licensing Fees',' Professional Licensing Fees','5510',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(332,' Publications & Subscriptions',' Publications & Subscriptions','5515',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(333,' Shipping (Commercial Carrier)',' Shipping (Commercial Carrier)','5520',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(334,' Shop Bldg Maintenance',' Shop Bldg Maintenance','5525',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(335,' Shop Cleaning Service',' Shop Cleaning Service','5530',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(336,' Shop Equipment Lease(s)',' Shop Equipment Lease(s)','5535',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(337,' Shop Equipment Maintenance',' Shop Equipment Maintenance','5540',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(338,' Shop Misc. Expenses',' Shop Misc. Expenses','5545',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(339,' Shop Property Taxes',' Shop Property Taxes','5550',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(340,' Shop Rent/Lease',' Shop Rent/Lease','5555',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(341,' Shop Utilities',' Shop Utilities','5560',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(342,' Stock Dividends',' Stock Dividends','5565',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(343,' Taxes-Business License',' Taxes-Business License','5570',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(344,' Taxes-Business Property',' Taxes-Business Property','5575',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(345,' Taxes-Corporate Income',' Taxes-Corporate Income','5580',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(346,' Taxes-Gross Sales',' Taxes-Gross Sales','5585',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(347,' Taxes-Inventory',' Taxes-Inventory','5590',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(348,' Taxes-Office Property',' Taxes-Office Property','5595',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(349,' Taxes-Other',' Taxes-Other','5600',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(350,' Taxes-Retail Sales',' Taxes-Retail Sales','5605',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(351,' Taxes-Vehicle',' Taxes-Vehicle','5610',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(352,' Telephone-Answering Service',' Telephone-Answering Service','5615',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(353,' Telephone-Cellular Service',' Telephone-Cellular Service','5620',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(354,' Telephone-ISDN Line',' Telephone-ISDN Line','5625',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(355,' Telephone-Local Service',' Telephone-Local Service','5630',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(356,' Telephone-Long Dist Service',' Telephone-Long Dist Service','5635',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(357,' Tolls & Parking',' Tolls & Parking','5640',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(358,' Tool Maintenance & Repairs',' Tool Maintenance & Repairs','5645',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(359,' Travel',' Travel','5650',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(360,' Travel-Airfare',' Travel-Airfare','5655',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(361,' Travel-Car Rental',' Travel-Car Rental','5660',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(362,' Travel-Hotel',' Travel-Hotel','5665',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(363,' Travel-Food & Entertainment',' Travel-Food & Entertainment','5670',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(364,' Travel-Miscellaneous',' Travel-Miscellaneous','5675',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(365,' Uniforms',' Uniforms','5680',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(366,' Vehicle Fuel & Oil',' Vehicle Fuel & Oil','5685',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(367,' Vehicle Maintenance & Repairs',' Vehicle Maintenance & Repairs','5690',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(368,' Vehicle Leases',' Vehicle Leases','5695',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(369,' Voided Check',' Voided Check','5700',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(370,' Warranty Program Fee',' Warranty Program Fee','5705',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(371,' Workers Comp (policy fees)',' Workers Comp (policy fees)','5710',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(372,' DEPRECIATION & AMORITIZATION',' DEPRECIATION & AMORITIZATION','5900',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(373,' Amortization-Lease Improvements',' Amortization-Lease Improvements','5905',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(374,' Amortization-Organizing Costs',' Amortization-Organizing Costs','5910',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(375,' Depreciation-General',' Depreciation-General','5950',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(376,' Depreciation-Buildings',' Depreciation-Buildings','5955',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(377,' Depreciation-Company Vehicles',' Depreciation-Company Vehicles','5960',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(378,' Depreciation-Model Furnshings',' Depreciation-Model Furnshings','5970',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(379,' Depreciation-Office Equipment',' Depreciation-Office Equipment','5975',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(380,' Depreciation-Tools & Equipment',' Depreciation-Tools & Equipment','5980',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(381,' Perm Uncategorized Overhead',' Perm Uncategorized Overhead','5998',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(382,' Temp Uncategorized Overhead',' Temp Uncategorized Overhead','5999',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(383,'OWNER\'S COMPENSATION','OWNER\'S COMPENSATION','6000',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(384,' Owner\'s Salary (payroll)',' Owner\'s Salary (payroll)','6010',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(385,' Checks Cashed by Owner',' Checks Cashed by Owner','6011',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(386,' Stock Dividend / Profit Dist.',' Stock Dividend / Profit Dist.','6015',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(387,' Checks to Spouse',' Checks to Spouse','6020',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(388,' Checks to Dependents',' Checks to Dependents','6021',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(389,' Checks to Relatives',' Checks to Relatives','6022',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(390,' Checks to Friends',' Checks to Friends','6023',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(391,' Checks to Associates',' Checks to Associates','6024',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(392,' Checks for Spouse',' Checks for Spouse','6025',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(393,' Checks for Dependents',' Checks for Dependents','6026',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(394,' Checks for Relatives',' Checks for Relatives','6027',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(395,' Checks for Friends',' Checks for Friends','6028',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(396,' Checks for Associates',' Checks for Associates','6029',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(397,' Personal Mortgage Payment',' Personal Mortgage Payment','6030',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(398,' Personal Utility Bills',' Personal Utility Bills','6040',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(399,' Personal Credit Cards',' Personal Credit Cards','6050',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(400,' Personal Vehicle Payment',' Personal Vehicle Payment','6060',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(401,' Personal Vehicle Gas & Oil',' Personal Vehicle Gas & Oil','6061',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(402,' Personal Vehicle Repairs',' Personal Vehicle Repairs','6062',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(403,' Personal Vehicle Insurance',' Personal Vehicle Insurance','6063',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(404,' Personal Vehicle Misc.',' Personal Vehicle Misc.','6065',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(405,' Personal Health Insurance',' Personal Health Insurance','6070',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(406,' Personal Life Insurance',' Personal Life Insurance','6071',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(407,' Personal Legal Expenses',' Personal Legal Expenses','6080',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(408,' Personal Accounting Expenses',' Personal Accounting Expenses','6081',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(409,' Personal Tax Payment',' Personal Tax Payment','6085',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(410,' Personal Property Taxes',' Personal Property Taxes','6086',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(411,' [enter additional accounts]',' [enter additional accounts]','6090',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(412,' Misc. Owners Compensation',' Misc. Owners Compensation','6099',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(413,' OWNER #2 COMPENSATION',' OWNER #2 COMPENSATION','6100',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(414,' Owner #2 Salary (payroll)',' Owner #2 Salary (payroll)','6110',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(415,' Checks Cashed by Owner #2',' Checks Cashed by Owner #2','6111',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(416,' Stock Dividend / Profit Dist.',' Stock Dividend / Profit Dist.','6115',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(417,' Checks to Spouse',' Checks to Spouse','6120',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(418,' Checks to Dependents',' Checks to Dependents','6121',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(419,' Checks to Relatives',' Checks to Relatives','6122',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(420,' Checks to Friends',' Checks to Friends','6123',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(421,' Checks to Associates',' Checks to Associates','6124',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(422,' Checks for Spouse',' Checks for Spouse','6125',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(423,' Checks for Dependents',' Checks for Dependents','6126',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(424,' Checks for Relatives',' Checks for Relatives','6127',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(425,' Checks for Friends',' Checks for Friends','6128',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(426,' Checks for Associates',' Checks for Associates','6129',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(427,' Personal Mortgage Payment',' Personal Mortgage Payment','6130',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(428,' Personal Utility Bills',' Personal Utility Bills','6140',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(429,' Personal Credit Cards',' Personal Credit Cards','6150',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(430,' Personal Vehicle Payment',' Personal Vehicle Payment','6160',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(431,' Personal Vehicle Gas & Oil',' Personal Vehicle Gas & Oil','6161',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(432,' Personal Vehicle Repairs',' Personal Vehicle Repairs','6162',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(433,' Personal Health Insurance',' Personal Health Insurance','6170',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(434,' Personal Life Insurance',' Personal Life Insurance','6171',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(435,' Personal Legal Expenses',' Personal Legal Expenses','6180',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(436,' Personal Accounting Expenses',' Personal Accounting Expenses','6181',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(437,' Personal Tax Payment',' Personal Tax Payment','6185',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(438,' Personal Property Taxes',' Personal Property Taxes','6186',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(439,' [enter additional accounts]',' [enter additional accounts]','6190',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(440,' Misc. Owners Compensation',' Misc. Owners Compensation','6199',12,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(441,'NON-POSTING ACCOUNTS','NON-POSTING ACCOUNTS','7000',0,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(442,' Purchase Orders',' Purchase Orders','7000',0,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18'),(443,' Estimates',' Estimates','8000',0,'P&L Statement\n',0,0,0,0,0,0,0,0,0,0,0,2,'2011-11-25 02:09:18');


CREATE TABLE `generalLedgerChartOfAccountDimension` (
  `generalLedgerChartOfAccountDimensionId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartAccountDimensionTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartAccountDimensionDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartAccountIdStart` int(11) NOT NULL,
  `generalLedgerChartAccountIdEnd` int(11) NOT NULL,
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

CREATE TABLE `generalLedgerChartOfAccountSegment` (
  `generalLedgerChartAccountSegmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
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
  PRIMARY KEY (`generalLedgerChartAccountSegmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

CREATE TABLE `generalLedgerChartOfAccountType` (
  `generalLedgerChartAccountTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerChartAccountTypeSequence` int(11) NOT NULL,
  `generalLedgerChartAccountTypeCode` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartAccountTypeDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerChartAccountTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

INSERT INTO `generalLedgerChartOfAccountType` VALUES (1,0,'','bank',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(2,0,'','Accounts Receivable',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(3,0,'','Other Current Asset',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(4,0,'','Fixed Asset',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(5,0,'','Accounts Payable',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(6,0,'','Credit Card',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(7,0,'','Other Current Liability',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(8,0,'','Long Term Liability',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(9,0,'','Equity',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(10,0,'','Income',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(11,0,'','Cost of Goods Sold',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(12,0,'','Expense',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00'),(13,0,'','Non-Posting',0,0,0,0,0,0,0,0,0,0,'0000-00-00 00:00:00');


CREATE TABLE `generalLedgerForecast` (
  `generalLedgerForecastId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerChartAccountDimensionNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerForecastMonth` int(2) NOT NULL,
  `generalLedgerForecastYear` int(4) NOT NULL,
  `generalLedgerForecastAmount` double(12,2) NOT NULL,
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


CREATE TABLE `generalLedgerJournal` (
  `generalLedgerJournalId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerJournalTitle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerJournalDesc` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `generalLedgerJournalDate` date NOT NULL,
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
  PRIMARY KEY (`generalLedgerJournalId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';




CREATE TABLE `generalLedgerJournalDetail` (
  `generalLedgerJournalDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `generalLedgerJournalId` int(11) NOT NULL,
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `countryCurrencyCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`generalLedgerJournalDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

CREATE TABLE `invoiceDetailLedger` (
  `invoiceDetailLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `invoiceLedgerId` int(11) NOT NULL,
  `generalLedgerChartAccountNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
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

CREATE TABLE `invoiceLedger` (
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





CREATE TABLE `invoiceProject` (
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

CREATE TABLE `refund` (
  `adjustmentId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `documentNo` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
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

CREATE TABLE `refundDetail` (
  `refundDetailId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `refundId` int(11) NOT NULL,
  `generalLedgerChartOfAccountId` int(11) NOT NULL,
  `countryCurrencyCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`adjustmentDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='application';

CREATE TABLE `template` (
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

CREATE TABLE `transactionDetailLedger` (
  `transactionDetailLedgerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Accordion|',
  `transactionLedgerId` int(11) NOT NULL,
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

CREATE TABLE `transactionLedger` (
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

