-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: caisms
-- ------------------------------------------------------
-- Server version	8.0.26-0ubuntu0.20.04.2

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
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` bigint unsigned DEFAULT NULL,
  `branch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `landlineno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branches_vehicle_id_index` (`vehicle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,1,'Coimbatore','Peelamedu','9514385586','044256345',1,'2021-09-09 06:03:49','2021-09-20 00:59:57'),(2,1,'Erode','Bhavani Main Road','9787766608','4244040800',1,'2021-10-01 07:31:23','2021-10-01 07:31:49'),(3,1,'Pollachi','Kovai Main Road','9787769166','9787766627',1,'2021-10-01 07:32:57','2021-10-01 07:32:57'),(4,1,'Ooty','Ettiness Road','9787766637','9787766637',1,'2021-10-01 07:34:03','2021-10-01 07:34:03');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'tirchy',1,'2021-09-11 03:00:15','2021-09-11 03:04:44');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `branches_id` bigint unsigned DEFAULT NULL,
  `walkin_date` date NOT NULL,
  `cities_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicles_id` bigint unsigned DEFAULT NULL,
  `model_names_id` bigint unsigned DEFAULT NULL,
  `varients_id` bigint unsigned DEFAULT NULL,
  `customer_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `followup_date` date DEFAULT NULL,
  `employees_id` bigint unsigned DEFAULT NULL,
  `remarks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `welcome_sms` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thankyou_sms` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `welcome_at` datetime NOT NULL,
  `thankyou_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_branches_id_index` (`branches_id`),
  KEY `customers_cities_id_index` (`cities_id`),
  KEY `customers_vehicles_id_index` (`vehicles_id`),
  KEY `customers_model_names_id_index` (`model_names_id`),
  KEY `customers_varients_id_index` (`varients_id`),
  KEY `customers_employees_id_index` (`employees_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (2,1,'2021-09-21',1,'Vanitha','9942542524','vanitha@kambaa.com',1,1,1,'Individual','New','Hot','2021-09-23',1,'testing','Sent','Sent','2021-09-21 10:34:30','2021-09-21 13:20:56','2021-09-21 05:04:30','2021-09-21 07:50:56'),(3,NULL,'2021-09-25',1,'vanitha','9942542524',NULL,1,1,1,'Individual','New','Warm','2021-09-30',1,NULL,'Sent','Sent','2021-09-25 13:44:19','2021-09-28 12:35:45','2021-09-25 08:14:19','2021-09-28 12:35:45'),(4,NULL,'2021-09-25',1,'vanitha','7094490069',NULL,1,1,1,'Individual','New','Hot','2021-09-29',1,'test','Sent','Sent','2021-09-25 13:46:17','2021-09-28 12:34:52','2021-09-25 08:16:17','2021-09-28 12:34:52'),(5,NULL,'2021-09-27',1,'sai','8754005989',NULL,1,1,1,'Individual','New','Hot','2021-09-30',1,NULL,'Sent','Sent','2021-09-27 08:49:33','2021-09-28 12:35:24','2021-09-27 03:19:33','2021-09-28 12:35:24'),(6,1,'2021-09-29',1,'vanitha','9942542524',NULL,1,1,1,'Individual','New','Hot','2021-09-30',2,'test','Sent','Sent','2021-09-29 09:57:37','2021-09-29 10:11:29','2021-09-29 09:57:37','2021-09-29 10:11:29'),(7,1,'2021-09-29',1,'vanitha','7094490069',NULL,1,1,1,'Individual','New','Hot','2021-09-30',2,NULL,'Sent','Sent','2021-09-29 10:01:05','2021-09-29 10:22:23','2021-09-29 10:01:05','2021-09-29 10:22:23'),(8,1,'2021-09-29',1,'vanitha','9942542524',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Sent','Pending','2021-09-29 10:12:44',NULL,'2021-09-29 10:12:44','2021-09-29 10:12:44'),(9,1,'2021-09-29',1,'vanitha','9942542524',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Sent','Pending','2021-09-29 10:14:27',NULL,'2021-09-29 10:14:27','2021-09-29 10:14:27'),(10,1,'2021-09-29',1,'vanitha','9942542524',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Sent','Pending','2021-09-29 10:23:31',NULL,'2021-09-29 10:23:31','2021-09-29 10:23:31'),(11,1,'2021-09-29',1,'Raja','9043310555',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Sent','Pending','2021-09-29 10:49:40',NULL,'2021-09-29 10:49:40','2021-09-29 10:49:40');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `desiginations`
--

DROP TABLE IF EXISTS `desiginations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `desiginations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `desigination` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desiginations`
--

LOCK TABLES `desiginations` WRITE;
/*!40000 ALTER TABLE `desiginations` DISABLE KEYS */;
INSERT INTO `desiginations` VALUES (1,'Manager',1,'2021-09-09 07:14:34','2021-09-20 00:42:54'),(2,'Receptionist',1,'2021-09-20 00:43:03','2021-09-20 00:43:03'),(3,'General Manager',1,'2021-09-20 00:43:15','2021-09-20 00:43:15'),(4,'Admin',1,'2021-09-20 00:43:37','2021-09-20 00:43:37'),(5,'FSC',1,'2021-10-07 11:18:58','2021-10-07 11:18:58'),(6,'SSC',1,'2021-10-07 11:19:09','2021-10-07 11:19:09');
/*!40000 ALTER TABLE `desiginations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` bigint unsigned DEFAULT NULL,
  `desigination_id` bigint unsigned DEFAULT NULL,
  `employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `employcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `doj` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `loginname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_branch_id_index` (`branch_id`),
  KEY `employees_desigination_id_index` (`desigination_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,1,1,'tt','123','2021-09-12','Active','gg','$2y$10$s2n.b1NDMgg6Z/TgNwQcvOaphexDU/I/0YkC4qz.jEdiFlSA33E/6',1,'2021-09-10 23:24:44','2021-09-11 03:06:39');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_09_09_094509_create_vehicles_table',2),(6,'2021_09_09_105151_create_branches_table',3),(7,'2021_09_09_121102_create_desiginations_table',4),(8,'2021_09_09_132542_create_employees_table',5),(9,'2021_09_11_060945_create_model_names_table',6),(10,'2021_09_11_063431_create_model_names_table',7),(11,'2021_09_11_063659_create_model_names_table',8),(12,'2021_09_11_074031_create_varients_table',9),(13,'2021_09_11_082343_create_cities_table',10),(14,'2021_09_21_073741_create_customers_table',11),(15,'2021_09_22_000000_create_users_table',12);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_names`
--

DROP TABLE IF EXISTS `model_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_names` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` bigint unsigned DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model_names_vehicle_id_index` (`vehicle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_names`
--

LOCK TABLES `model_names` WRITE;
/*!40000 ALTER TABLE `model_names` DISABLE KEYS */;
INSERT INTO `model_names` VALUES (1,1,'ALTURAS G4',1,'2021-09-11 01:11:01','2021-09-30 05:38:14'),(2,1,'BOLERO',1,'2021-09-30 05:38:26','2021-09-30 05:38:26'),(3,1,'BOLERO NEO',1,'2021-09-30 05:38:40','2021-09-30 05:38:40'),(4,1,'BOLERO P',1,'2021-09-30 05:38:52','2021-09-30 05:38:52'),(5,1,'KUV100 NXT',1,'2021-09-30 05:39:03','2021-09-30 05:39:03'),(6,1,'MARAZZO',1,'2021-09-30 05:39:13','2021-09-30 05:39:13'),(7,1,'NEW SCORPIO',1,'2021-09-30 05:39:24','2021-09-30 05:39:24'),(8,1,'NEW THAR',1,'2021-09-30 05:39:35','2021-09-30 05:39:35'),(9,1,'XUV300',1,'2021-09-30 05:39:46','2021-09-30 05:39:46'),(10,1,'XUV700',1,'2021-09-30 05:39:57','2021-09-30 05:39:57');
/*!40000 ALTER TABLE `model_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `desigination_id` bigint unsigned DEFAULT NULL,
  `employcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `doj` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `loginname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_branch_id_index` (`branch_id`),
  KEY `users_desigination_id_index` (`desigination_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@cai.com','9837823748',NULL,NULL,4,'1001','2021-09-21','Active','admin@cai.com','$2y$10$bLaS3GHzx6djxW/NsD/vfOvngzb5KT4UE.Rv7jYCgM5qLu4jKXJiC',NULL,1,NULL,'2021-09-29 13:05:08'),(2,'Receptionist','reception@cai.com','9875823758',NULL,1,2,'1002','2021-09-21','Active','reception@cai.com','$2y$10$3qqrBDq9S9IoV3mXt6Do5es7j1ZlLimjbLG9O3xSu69zfWEegxvty',NULL,1,'2021-09-21 05:02:10','2021-09-29 10:52:47'),(3,'vanitha','manager@cai.com','9867575464',NULL,1,1,'1003','2021-09-30','Active','manager@cai.com','$2y$10$BsOPdq0eO0TwbJH.D/EbHuMrAGTARxaYM0xXgg7LmJ8tSSmBrBC9e',NULL,1,'2021-09-30 08:09:29','2021-09-30 08:09:29'),(4,'Receptionist','reception@cbeps','9787712345',NULL,1,2,'1234','2021-09-21','Active','reception@cbeps','$2y$10$93NDpVZRTQo9/H3tXfqMCe6XQ3pD0iS2opee2n31roYvHCZCO5Z7.',NULL,1,'2021-10-05 12:04:44','2021-10-05 12:04:44'),(5,'AJAY RAJA NATRAJ','','9786344455',NULL,1,5,'13KQ2665','2021-09-09','Active',NULL,'',NULL,1,'2021-10-07 11:36:49','2021-10-07 11:36:49'),(8,'ASHWANTH RAMACHANDRAN','','9787723883',NULL,1,6,'13EK2236','2016-06-10','Active',NULL,'',NULL,1,'2021-10-07 11:42:43','2021-10-07 11:42:43'),(9,'CHANDRASEKARAN MUTHAIYAN','','9787766648',NULL,1,6,'13EK4908','2016-08-02','Active',NULL,'',NULL,1,'2021-10-07 11:43:23','2021-10-07 11:43:23'),(10,'DEEPAK RAAG HAVEL PRASAD','','9787766653',NULL,1,5,'13KQ2988','2021-09-15','Active',NULL,'',NULL,1,'2021-10-07 11:44:03','2021-10-07 11:44:03'),(11,'DHAYANANDHAN PUNIYAKODI','','9787721288',NULL,1,5,'13CI7406','2021-03-01','Active',NULL,'',NULL,1,'2021-10-07 11:44:42','2021-10-07 11:44:42'),(12,'EASWARARAJ MOHAN DOSS','','9787766719',NULL,1,5,'13EK3262','2021-02-01','Active',NULL,'',NULL,1,'2021-10-07 11:45:22','2021-10-07 11:45:22'),(13,'GOKUL ARUCHAMY','','9787766616',NULL,1,5,'13JP7444','2021-05-03','Active',NULL,'',NULL,1,'2021-10-07 11:45:57','2021-10-07 11:45:57'),(14,'GOPI KRISHNAN NAGENTHIRAN','','9787766605',NULL,1,5,'13JP6643','2021-02-01','Active',NULL,'',NULL,1,'2021-10-07 11:46:34','2021-10-07 11:46:34'),(15,'JUDE PRADEEP MARTIN DAVID','','9787766614',NULL,1,5,'13AE9357','2021-09-01','Active',NULL,'',NULL,1,'2021-10-07 11:47:08','2021-10-07 11:47:08'),(16,'MANIKANDAN KALIRAJ','','9787779950',NULL,1,5,'13JP6669','2021-04-01','Active',NULL,'',NULL,1,'2021-10-07 11:47:47','2021-10-07 11:47:47'),(17,'MANIKANDAN RAJAMANIKKAM','','9787766606',NULL,1,5,'13GM2838','2021-09-22','Active',NULL,'',NULL,1,'2021-10-07 11:48:22','2021-10-07 11:48:22'),(18,'NANDHAKUMAR MURUGAN','','9787726500',NULL,1,5,'13KQ2985','2021-09-15','Active',NULL,'',NULL,1,'2021-10-07 11:48:59','2021-10-07 11:48:59'),(19,'PRAKASH GOVINDARAJ','','9787766607',NULL,1,6,'13AE9719','2021-01-01','Active',NULL,'',NULL,1,'2021-10-07 11:49:33','2021-10-07 11:49:33'),(20,'PRAVIN KUMAR SARAVANAN','','9787766632',NULL,1,5,'13KQ2664','2021-09-01','Active',NULL,'',NULL,1,'2021-10-07 11:50:11','2021-10-07 11:50:11'),(21,'RAGUVARAN SEKARAN','','9787720756',NULL,1,5,'13KQ2983','2021-09-15','Active',NULL,'',NULL,1,'2021-10-07 11:50:46','2021-10-07 11:50:46'),(22,'RAJESH SUNDHARAM','','9787766744',NULL,1,5,'13JP3820','2021-01-01','Active',NULL,'',NULL,1,'2021-10-07 11:51:22','2021-10-07 11:51:22'),(23,'RAJKUMAR ARUMUGAM','','9787764635',NULL,1,6,'13AE9385','2021-09-19','Active',NULL,'',NULL,1,'2021-10-07 11:51:59','2021-10-07 11:51:59'),(24,'RAKESH SANANGAPANI','','9787766617',NULL,1,6,'13AE9189','2021-02-01','Active',NULL,'',NULL,1,'2021-10-07 11:52:32','2021-10-07 11:52:32'),(25,'SARATHKUMAR B BALASUBRAMANIAM N','','9787766720',NULL,1,6,'13EK1149','2016-05-09','Active',NULL,'',NULL,1,'2021-10-07 11:53:07','2021-10-07 11:53:07'),(26,'SARAVANAKUMAR SELVAM','','9787766609',NULL,1,5,'13GM2667','2021-02-06','Active',NULL,'',NULL,1,'2021-10-07 11:53:46','2021-10-07 11:53:46'),(27,'VISHNU PRASAD SASIDHARAN','','9787766736',NULL,1,5,'13JP6792','2021-03-01','Active',NULL,'',NULL,1,'2021-10-07 11:54:19','2021-10-07 11:54:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `varients`
--

DROP TABLE IF EXISTS `varients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `varients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_id` bigint unsigned DEFAULT NULL,
  `varient` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `varients_model_id_index` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `varients`
--

LOCK TABLES `varients` WRITE;
/*!40000 ALTER TABLE `varients` DISABLE KEYS */;
INSERT INTO `varients` VALUES (1,1,'ALTURAS G4 4WD BSVI NEW PEARL WHITE',1,'2021-09-11 02:25:57','2021-09-30 05:40:40'),(2,2,'MAHINDRA BOLERO B4 BS-VI',1,'2021-09-11 02:27:17','2021-09-30 05:40:56'),(3,3,'MAHINDRA BOLERO NEO N8 SILVER',1,'2021-09-30 05:41:12','2021-09-30 05:41:12'),(4,4,'BOLERO POWER+ SLE BS4',1,'2021-09-30 05:49:44','2021-09-30 05:49:44'),(5,5,'KUV100 NXT K2+ MFALCON G80 6S RX',1,'2021-09-30 05:50:01','2021-09-30 05:50:01'),(6,6,'MAHINDRA MARAZZO 7 STR M6+ BLG',1,'2021-09-30 05:50:25','2021-09-30 05:50:25'),(7,6,'MAHINDRA MARAZZO 7 STR M6+ MAR',1,'2021-09-30 05:50:36','2021-09-30 05:50:36'),(8,6,'MAHINDRA MARAZZO 7 STR M4+ BLK',1,'2021-09-30 05:50:48','2021-09-30 05:50:48'),(9,6,'MAHINDRA MARAZZO 8 STR M2 SIL',1,'2021-09-30 05:50:59','2021-09-30 05:50:59'),(10,6,'MAHINDRA MARAZZO 8 STR M6+ MAR',1,'2021-09-30 05:51:09','2021-09-30 05:51:09'),(11,6,'MAHINDRA MARAZZO 8 STR M6+ BLG',1,'2021-09-30 05:51:18','2021-09-30 05:51:18'),(12,7,'MAH SCORPIO S11 MH 2.2MHAWK-140 2WD 7S',1,'2021-09-30 05:51:30','2021-09-30 05:51:30'),(13,8,'THAR LX P AT 4WD 4S HT NAP BLK',1,'2021-09-30 05:51:57','2021-09-30 05:51:57'),(14,8,'THAR LX P AT 4WD 4S HT RED RG',1,'2021-09-30 05:52:09','2021-09-30 05:52:09'),(15,8,'THAR LX D MT 4WD 4S HT NAP BLK',1,'2021-09-30 05:52:28','2021-09-30 05:52:28'),(16,8,'THAR LX D AT 4WD 4S HT RKY BG',1,'2021-09-30 05:52:40','2021-09-30 05:52:40'),(17,8,'THAR LX D AT 4WD 4S HT MYS CPR',1,'2021-09-30 05:52:51','2021-09-30 05:52:51'),(18,8,'THAR LX D AT 4WD 4S HT NAP BLK',1,'2021-09-30 05:53:01','2021-09-30 05:53:01'),(19,8,'THAR LX D AT 4WD 4S HT RED RG',1,'2021-09-30 05:54:07','2021-09-30 05:54:07'),(20,8,'THAR LX D MT 4WD 4S CT RED RG',1,'2021-09-30 05:54:19','2021-09-30 05:54:19'),(21,8,'THAR LX P AT 4WD 4S CT DP GRY',1,'2021-09-30 06:03:04','2021-09-30 06:03:04'),(22,8,'THAR LX P AT 4WD 4S HT RKY BG',1,'2021-09-30 06:03:18','2021-09-30 06:03:18'),(23,8,'THAR LX P AT 4WD 4S CT RED RG',1,'2021-09-30 06:03:49','2021-09-30 06:03:49'),(24,8,'THAR LX P MT 4WD 4S HT NAP BLK',1,'2021-09-30 06:04:18','2021-09-30 06:04:18'),(25,8,'THAR LX P AT 4WD 4S CT AQA MRN',1,'2021-09-30 06:04:33','2021-09-30 06:04:33'),(26,8,'THAR LX P MT 4WD 4S HT DP GRY',1,'2021-09-30 06:04:46','2021-09-30 06:04:46'),(27,8,'THAR LX P AT 4WD 4S CT MYS CPR',1,'2021-09-30 06:05:16','2021-09-30 06:05:16'),(28,8,'THAR LX D AT 4WD 4S CT MYS CPR',1,'2021-09-30 06:05:46','2021-09-30 06:05:46'),(29,8,'THAR LX D MT 4WD 4S HT RED RG',1,'2021-09-30 06:06:20','2021-09-30 06:06:20'),(30,8,'THAR LX D MT 4WD 4S HT AQA MRN',1,'2021-09-30 06:06:35','2021-09-30 06:06:35'),(31,8,'THAR LX P AT 4WD 4S HT MYS CPR',1,'2021-09-30 06:06:53','2021-09-30 06:06:53'),(32,8,'THAR LX P MT 4WD 4S HT RED RG',1,'2021-09-30 06:07:22','2021-09-30 06:07:22'),(33,8,'THAR LX P AT 4WD 4S HT DP GRY',1,'2021-09-30 06:07:51','2021-09-30 06:07:51'),(34,8,'THAR LX D MT 4WD 4S CT NAP BLK',1,'2021-09-30 06:08:08','2021-09-30 06:08:08'),(35,9,'MAHINDRA XUV300 W8 O DS BS6 MT SK',1,'2021-09-30 06:08:52','2021-09-30 06:08:52'),(36,9,'MAHINDRA XUV300 W8 O DS BS6 MT XH',1,'2021-09-30 06:09:04','2021-09-30 06:09:04'),(37,9,'MAHINDRA XUV300 W8 O PM BS6 AS RX',1,'2021-09-30 06:09:17','2021-09-30 06:09:17'),(38,9,'MAHINDRA XUV300 W8 O PM BS6 MT WP',1,'2021-09-30 06:09:32','2021-09-30 06:09:32'),(39,9,'MAHINDRA XUV300 W8 O PM BS6 AS WP',1,'2021-09-30 06:09:45','2021-09-30 06:09:45'),(40,9,'MAHINDRA XUV300 W8 O DS BS6 AS RX',1,'2021-09-30 06:09:59','2021-09-30 06:09:59'),(41,9,'MAHINDRA XUV300 W6 DS BS6 MT WP',1,'2021-09-30 06:10:48','2021-09-30 06:10:48'),(42,9,'MAHINDRA XUV300 W8 O PM BS6 MT SK',1,'2021-09-30 06:11:01','2021-09-30 06:11:01'),(43,9,'MAHINDRA XUV300 W4 DS BS6 MT WP',1,'2021-09-30 06:27:37','2021-09-30 06:27:37'),(44,9,'MAHINDRA XUV300 W8 O DS BS6 MT RX',1,'2021-09-30 06:27:49','2021-09-30 06:27:49'),(45,9,'MAHINDRA XUV300 W8 O DS BS6 AS WP',1,'2021-09-30 06:27:59','2021-09-30 06:27:59'),(46,9,'MAHINDRA XUV300 W8 O PM BS6 MT RX',1,'2021-09-30 06:28:22','2021-09-30 06:28:22'),(47,9,'MAHINDRA XUV300 W6 PM BS6 MT GR',1,'2021-09-30 06:29:14','2021-09-30 06:29:14'),(48,9,'MAHINDRA XUV300 W8 PM BS6 MT RX',1,'2021-09-30 06:29:26','2021-09-30 06:29:26'),(49,9,'MAHINDRA XUV300 W6 PM BS6 MT WP',1,'2021-09-30 06:29:36','2021-09-30 06:29:36'),(50,9,'MAHINDRA XUV300 W8 O DS BS6 MT WP',1,'2021-09-30 06:30:31','2021-09-30 06:30:31'),(51,9,'MAHINDRA XUV300 W8 PM BS6 MT SK',1,'2021-09-30 06:30:41','2021-09-30 06:30:41'),(52,10,'XUV700 AX7 L PET AT 7 SEATER SLR',1,'2021-09-30 06:31:04','2021-09-30 06:31:04'),(53,10,'XUV700 AX7 T DSL MT 7 SEATER SLR',1,'2021-09-30 06:31:15','2021-09-30 06:31:15'),(54,10,'XUV700 AX7 T DSL MT 7 SEATER BLU',1,'2021-09-30 06:31:24','2021-09-30 06:31:24'),(55,10,'XUV700 AX7 T PET MT 7 SEATER BLU',1,'2021-09-30 06:31:46','2021-09-30 06:31:46'),(56,10,'XUV700 AX7 L PET AT 7 SEATER BLK',1,'2021-09-30 06:31:56','2021-09-30 06:31:56'),(57,10,'XUV700 AX7 L PET AT 7 SEATER WHT',1,'2021-09-30 06:32:07','2021-09-30 06:32:07'),(58,10,'XUV700 AX7 L PET AT 7 SEATER RED',1,'2021-09-30 06:32:17','2021-09-30 06:32:17');
/*!40000 ALTER TABLE `varients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,'Personal',1,'2021-09-09 04:47:51','2021-09-28 10:37:53'),(2,'Prosper',1,'2021-09-09 04:54:20','2021-09-28 10:38:01');
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-07 12:01:25
