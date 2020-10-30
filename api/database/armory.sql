-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: armory
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `deployment_assignment`
--

DROP TABLE IF EXISTS `deployment_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deployment_assignment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post` int DEFAULT NULL,
  `deployer` int DEFAULT NULL,
  `police` int DEFAULT NULL,
  `work_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `weapon` int DEFAULT '0',
  `assigned_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `returned_on` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post` (`post`),
  KEY `deployer` (`deployer`),
  KEY `police` (`police`),
  CONSTRAINT `deployment_assignment_ibfk_1` FOREIGN KEY (`post`) REFERENCES `posts` (`id`),
  CONSTRAINT `deployment_assignment_ibfk_2` FOREIGN KEY (`deployer`) REFERENCES `users` (`id`),
  CONSTRAINT `deployment_assignment_ibfk_3` FOREIGN KEY (`police`) REFERENCES `police` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deployment_assignment`
--

LOCK TABLES `deployment_assignment` WRITE;
/*!40000 ALTER TABLE `deployment_assignment` DISABLE KEYS */;
INSERT INTO `deployment_assignment` VALUES (2,1,3,1,'2020-09-04 00:00:00',2,'2020-09-04 00:00:00','2020-09-04 13:25:48','2020-09-04 13:17:21','2020-09-04 13:17:21'),(3,3,3,1,'2020-09-05 13:23:24',2,'2020-09-05 13:23:50',NULL,'2020-09-04 18:26:27','2020-09-04 18:26:27'),(6,3,3,NULL,'2020-09-08 00:00:00',0,'2020-09-08 08:42:28',NULL,'2020-09-08 08:42:28','2020-09-08 08:42:28'),(7,3,3,4,'2020-09-08 00:00:00',0,'2020-09-08 08:47:59',NULL,'2020-09-08 08:47:59','2020-09-08 08:47:59'),(8,3,3,2,'2020-09-08 00:00:00',0,'2020-09-08 08:53:34',NULL,'2020-09-08 08:53:34','2020-09-08 08:53:34');
/*!40000 ALTER TABLE `deployment_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `police`
--

DROP TABLE IF EXISTS `police`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `police` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `police_id` varchar(15) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `ranks` varchar(70) DEFAULT NULL,
  `deployment` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT '',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `police`
--

LOCK TABLES `police` WRITE;
/*!40000 ALTER TABLE `police` DISABLE KEYS */;
INSERT INTO `police` VALUES (1,'Cyemezo Aimable','RNP012','0784472232','Private','Ready','MTIzNDU=','                                                            ','2020-09-04 12:48:58','2020-09-04 12:48:58'),(2,'Ntaganda Fiston','RNP443','0781234534','Supretendent','Ready','MTIzNDU=','','2020-09-04 15:29:58','2020-09-04 15:29:58'),(3,'Methode Ukundabarezi','RNP321','0789234432','Private','Ready','MTIzNDU=','                                                                                                                                                                                                                                                ','2020-09-07 09:40:12','2020-09-07 09:40:12'),(4,'Manzi Roger','RNP9156','0730123784','Private','Ready','MTIzNDU=','                                                                                                                                                                                    ','2020-09-07 10:27:54','2020-09-07 10:27:54'),(5,'Tuyisenge Gerard','RNP925','0723457812','Private','Not Ready','MTIzNDU=','Ararwaye','2020-09-09 08:24:52','2020-09-09 08:24:52');
/*!40000 ALTER TABLE `police` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `district` varchar(15) NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Gihinga Gacurabwenge','Kamonyi',NULL,'2020-09-04 12:59:02','2020-09-04 12:55:03'),(2,'Gihinga','Kamonyi',NULL,'2020-09-04 12:56:14','2020-09-04 12:56:14'),(3,'Bisheke Munyinya','Karongi',NULL,'2020-09-04 16:37:09','2020-09-04 16:30:44');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `police_id` varchar(15) DEFAULT NULL,
  `ranks` varchar(70) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `level` enum('District','Natiobal') DEFAULT 'District',
  `category` enum('Superadmin','Deployer') DEFAULT 'Superadmin',
  `password` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Manzi','0726183049','RNP09121','Private','Karongi','District','Superadmin','MTIzNDU=','2020-09-04 12:38:07','2020-09-04 12:38:07'),(2,'Igor Emmanuel','0789012390','RNP01232','Supretendent','Karongi','District','Deployer','MTIzNDU=','2020-09-04 12:41:11','2020-09-04 12:41:11'),(3,'iGIHOZO KABAKA Didier','0789012378','RNP564','Supretendent','Karongi','District','Deployer','MTIzNDU=','2020-09-04 12:43:37','2020-09-04 12:43:37'),(4,'Dukunde Alphonse','0731233212','RNP4532','Private','Gasabo','District','Deployer','MTIzNDU=','2020-09-04 15:33:22','2020-09-04 15:33:22'),(5,'Dukundimana Angelique','0789129382','RNP232312','Commissioner of police','Kicukiro',NULL,'Deployer','MTIzNDU=','2020-09-04 15:35:45','2020-09-04 15:35:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weapons`
--

DROP TABLE IF EXISTS `weapons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `weapons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `serial_number` varchar(15) NOT NULL,
  `type` varchar(70) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weapons`
--

LOCK TABLES `weapons` WRITE;
/*!40000 ALTER TABLE `weapons` DISABLE KEYS */;
INSERT INTO `weapons` VALUES (1,'Gihinga','PST0120','Pistol','available','2020-09-04 13:01:38','2020-09-04 13:01:38'),(2,'AK Pistol','PST01223','Pistol','available','2020-09-04 13:04:26','2020-09-04 13:04:26'),(3,'Machine Gun','MCHN123','MACHINE-GUN','available','2020-09-04 17:51:49','2020-09-04 17:51:49'),(4,'MK12','KSD1232','Pistol','available','2020-09-04 17:53:06','2020-09-04 17:53:06'),(5,'AK47','Galmet','AK47','available','2020-09-04 17:55:35','2020-09-04 17:55:35');
/*!40000 ALTER TABLE `weapons` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-09 12:26:14
