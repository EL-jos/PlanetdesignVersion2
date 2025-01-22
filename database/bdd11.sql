-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: planetdesign
-- ------------------------------------------------------
-- Server version	8.0.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article_cart`
--

DROP TABLE IF EXISTS `article_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_cart` (
  `article_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `article_cart_article_id_foreign` (`article_id`),
  KEY `article_cart_cart_id_foreign` (`cart_id`),
  CONSTRAINT `article_cart_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `article_cart_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_cart`
--

LOCK TABLES `article_cart` WRITE;
/*!40000 ALTER TABLE `article_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_color`
--

DROP TABLE IF EXISTS `article_color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_color` (
  `article_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `article_color_article_id_foreign` (`article_id`),
  KEY `article_color_color_id_foreign` (`color_id`),
  CONSTRAINT `article_color_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `article_color_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_color`
--

LOCK TABLES `article_color` WRITE;
/*!40000 ALTER TABLE `article_color` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_material`
--

DROP TABLE IF EXISTS `article_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_material` (
  `article_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `article_material_article_id_foreign` (`article_id`),
  KEY `article_material_material_id_foreign` (`material_id`),
  CONSTRAINT `article_material_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `article_material_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_material`
--

LOCK TABLES `article_material` WRITE;
/*!40000 ALTER TABLE `article_material` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_subcategory`
--

DROP TABLE IF EXISTS `article_subcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_subcategory` (
  `article_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `article_subcategory_article_id_foreign` (`article_id`),
  KEY `article_subcategory_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `article_subcategory_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `article_subcategory_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_subcategory`
--

LOCK TABLES `article_subcategory` WRITE;
/*!40000 ALTER TABLE `article_subcategory` DISABLE KEYS */;
INSERT INTO `article_subcategory` VALUES ('01861c59-6672-4e32-97b6-12524d2bf410',1,NULL,NULL),('01861c59-6672-4e32-97b6-12524d2bf410',3,NULL,NULL),('0b597483-a9f6-4c96-895b-62af22ef789c',1,NULL,NULL);
/*!40000 ALTER TABLE `article_subcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_wishlist`
--

DROP TABLE IF EXISTS `article_wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_wishlist` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_wishlist_user_id_unique` (`user_id`),
  CONSTRAINT `article_wishlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_wishlist`
--

LOCK TABLES `article_wishlist` WRITE;
/*!40000 ALTER TABLE `article_wishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_wishlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ugs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `articles_availability_id_foreign` (`availability_id`),
  CONSTRAINT `articles_availability_id_foreign` FOREIGN KEY (`availability_id`) REFERENCES `availabilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES ('01861c59-6672-4e32-97b6-12524d2bf410',1,'stylo promotionnel en plastique et bois','PL112160','stylo-promotionnel-en-plastique-et-bois','<p style=\"margin: 0px; padding: 0px; box-sizing: border-box; color: rgb(104, 104, 109); font-weight: 300; font-size: var(--font-size-text); line-height: var(--line-height); font-family: var(--font-text) !important; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><strong style=\"margin: 0px; padding: 0px; box-sizing: border-box;\">Stylo à bille en plastique corps coloré avec attributs en bois</strong></p><ul style=\"margin: 0px; padding: 0px 2rem; box-sizing: border-box; color: rgb(94, 93, 93); font-weight: 300; line-height: var(--line-height); font-family: var(--font-text) !important; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><li style=\"margin: 0px; padding: 0px; box-sizing: border-box;\">Matère:&nbsp; Plastique, Bois&nbsp;</li><li style=\"margin: 0px; padding: 0px; box-sizing: border-box;\">Fonction: Bouton à poussoir</li><li style=\"margin: 0px; padding: 0px; box-sizing: border-box;\">Mine: bleu</li><li style=\"margin: 0px; padding: 0px; box-sizing: border-box;\">Refill: 1,0 mm</li><li style=\"margin: 0px; padding: 0px; box-sizing: border-box;\">Impression recommandée:&nbsp; Impression Digitale UV , Impression tampographie</li></ul>',0,NULL,'2025-01-20 19:25:09','2025-01-20 19:46:40'),('0b597483-a9f6-4c96-895b-62af22ef789c',1,'stylo en plastique avec touch pen','PL112149','stylo-en-plastique-avec-touch-pen','<p><strong>Stylo à bille en plastique corps blanc avec attributs colorés et touch pen inclus&nbsp;</strong></p><ul><li>Matère:&nbsp; Plastique&nbsp;</li><li>Fonction: Bouton à poussoir</li><li>Mine: bleu</li><li>Refill: 1,0 mm</li><li>Pièces par carton:&nbsp;1000 pcs</li><li>Dimension carton:&nbsp; 48x31x20 cm</li><li>Poids carton:&nbsp; 9,15 kg</li><li>Impression recommandée:&nbsp; Impression Digitale UV , Impression tampographie</li></ul>',0,NULL,'2025-01-21 20:46:28','2025-01-21 20:46:28');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availabilities`
--

DROP TABLE IF EXISTS `availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `availabilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availabilities`
--

LOCK TABLES `availabilities` WRITE;
/*!40000 ALTER TABLE `availabilities` DISABLE KEYS */;
INSERT INTO `availabilities` VALUES (1,'en stock',NULL,'2025-01-18 17:25:49','2025-01-18 17:25:49'),(3,'sur commande',NULL,'2025-01-18 17:26:43','2025-01-18 17:26:43'),(4,'en déstockage',NULL,'2025-01-18 17:26:50','2025-01-18 17:26:50'),(5,'deal',NULL,'2025-01-18 17:26:58','2025-01-18 17:26:58'),(6,'en rupture',NULL,'2025-01-18 17:30:57','2025-01-18 17:30:57');
/*!40000 ALTER TABLE `availabilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cartable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cartable_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cartable_type_cartable_id_index` (`cartable_type`,`cartable_id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_unique` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogs`
--

DROP TABLE IF EXISTS `catalogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogs` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `catalogs_user_id_foreign` (`user_id`),
  KEY `catalogs_article_id_foreign` (`article_id`),
  CONSTRAINT `catalogs_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogs`
--

LOCK TABLES `catalogs` WRITE;
/*!40000 ALTER TABLE `catalogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'écriture','ecriture',0,NULL,'2025-01-18 13:40:00','2025-01-22 08:16:20'),(2,'bureau & event','bureau-event',0,NULL,'2025-01-18 13:21:06','2025-01-22 08:18:17'),(3,'pause gourmande','pause-gourmande',0,NULL,'2025-01-18 13:22:38','2025-01-18 13:22:38'),(4,'téchnologie','technologie',0,NULL,'2025-01-18 13:22:51','2025-01-22 08:18:43'),(5,'loisirs','loisirs',0,NULL,'2025-01-18 13:23:07','2025-01-18 13:23:07'),(6,'textile','textile',0,NULL,'2025-01-18 13:23:20','2025-01-18 13:23:20');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (45,'argenté',NULL,'2025-01-18 16:35:07','2025-01-18 16:35:07'),(46,'beige',NULL,'2025-01-18 16:35:56','2025-01-18 16:35:56'),(47,'blanc',NULL,'2025-01-18 16:36:24','2025-01-18 16:36:24'),(48,'bleu',NULL,'2025-01-18 16:36:47','2025-01-18 16:36:47'),(49,'bleu ciel',NULL,'2025-01-18 16:37:13','2025-01-18 16:37:13'),(50,'bordeaux',NULL,'2025-01-18 16:37:39','2025-01-18 16:37:39'),(51,'champagne',NULL,'2025-01-18 16:38:06','2025-01-18 16:38:06'),(52,'doré',NULL,'2025-01-18 16:38:25','2025-01-18 16:38:25'),(53,'gris',NULL,'2025-01-18 16:38:43','2025-01-18 16:38:43'),(54,'jaune',NULL,'2025-01-18 16:38:57','2025-01-18 16:38:57'),(55,'jeans',NULL,'2025-01-18 16:39:38','2025-01-18 16:39:38'),(56,'multicouleur',NULL,'2025-01-18 16:40:21','2025-01-18 16:40:21'),(57,'naturel',NULL,'2025-01-18 16:41:10','2025-01-18 16:41:10'),(58,'noir',NULL,'2025-01-18 16:41:23','2025-01-18 16:41:23'),(59,'orange',NULL,'2025-01-18 16:41:48','2025-01-18 16:41:48'),(60,'rose',NULL,'2025-01-18 16:42:05','2025-01-18 16:42:05'),(61,'rouge',NULL,'2025-01-18 16:42:24','2025-01-18 16:42:24'),(62,'rouge vif',NULL,'2025-01-18 16:43:06','2025-01-18 16:43:06'),(63,'transparent',NULL,'2025-01-18 16:43:30','2025-01-18 16:43:30'),(64,'Turquoise',NULL,'2025-01-18 16:44:00','2025-01-18 16:44:00'),(65,'vert',NULL,'2025-01-18 16:44:17','2025-01-18 16:44:17'),(66,'vert pistache',NULL,'2025-01-18 16:44:39','2025-01-18 16:44:39'),(67,'violet',NULL,'2025-01-18 16:45:44','2025-01-18 16:45:44'),(68,'Marron',NULL,'2025-01-18 16:46:06','2025-01-18 16:46:06'),(69,'mauve',NULL,'2025-01-18 16:46:23','2025-01-18 16:46:23'),(70,'bleu marine',NULL,'2025-01-18 16:46:40','2025-01-18 16:46:40'),(71,'bleu royal',NULL,'2025-01-18 16:46:55','2025-01-18 16:46:55'),(72,'jaune-fluo',NULL,'2025-01-18 16:47:13','2025-01-18 16:47:13'),(73,'bronze',NULL,'2025-01-18 16:47:35','2025-01-18 16:47:35'),(74,'vert foncé',NULL,'2025-01-18 16:47:52','2025-01-18 16:47:52'),(75,'bois',NULL,'2025-01-18 16:48:07','2025-01-18 16:48:07'),(76,'Vert sarcelle',NULL,'2025-01-18 16:48:58','2025-01-18 16:48:58'),(77,'ARM',NULL,'2025-01-18 16:49:12','2025-01-18 16:49:12'),(78,'miroité',NULL,'2025-01-18 16:49:33','2025-01-18 16:49:33');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','file','other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `documentable_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `documentable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES ('011f8271-5721-4fc1-8acf-bcc6e4bfadbb','image','assets/resources/subcategories/89e799a4-0c66-4056-aaff-6afdc5e4d173.png','7','App\\Models\\Subcategory','2025-01-18 14:56:31','2025-01-18 14:56:31'),('0331334f-beb9-4dd4-a2d6-e37795ff32bf','image','assets/resources/offers/73b84c23-e261-4c5d-9a3c-34aabe60280d.png','5','App\\Models\\Offer','2025-01-21 21:33:06','2025-01-21 21:33:06'),('03c9d203-f906-41d8-bb2a-8f5ac076d49f','image','assets/resources/colors/8861b6c2-0305-4a7c-9d58-0c252ba5789c.jpg','72','App\\Models\\Color','2025-01-18 16:47:13','2025-01-18 16:47:13'),('04f7c482-f2c4-42ad-b298-fa1c31263a15','image','assets/resources/variants/cf1e63b4-a738-4e6c-98b1-a81dc048536a.png','cd6dda65-e675-40b5-92c3-a9e6b4bb995e','App\\Models\\Variant','2025-01-21 20:39:49','2025-01-21 20:39:49'),('07abd99d-e949-456c-853b-833c9eb4f1aa','image','assets/resources/colors/cb5da595-2774-481a-a992-a0395069e50e.jpg','65','App\\Models\\Color','2025-01-18 16:44:17','2025-01-18 16:44:17'),('11621952-4e56-497e-a0d9-59b49ee3117e','image','assets/resources/colors/1878d515-2143-4188-8f8f-f01f157abc1f.jpg','56','App\\Models\\Color','2025-01-18 16:40:21','2025-01-18 16:40:21'),('13858785-1710-46cc-8a07-9fbbd193e182','image','assets/resources/colors/9ea3256f-5fd9-4781-b8ef-e0945739caf6.jpg','78','App\\Models\\Color','2025-01-18 16:49:33','2025-01-18 16:49:33'),('138a6354-9cc4-4d41-b235-1585cd36d3b0','image','assets/resources/subcategories/cf7e3be2-fa0e-4ee9-974f-dd0d6480d8b1.png','32','App\\Models\\Subcategory','2025-01-18 15:21:43','2025-01-18 15:21:43'),('14c6df1d-dfb1-4320-bd79-04d5cc1450e8','image','assets/resources/subcategories/ab60a56c-ea48-4fa2-b921-1ba9fbd6285a.png','22','App\\Models\\Subcategory','2025-01-18 15:14:18','2025-01-18 15:14:18'),('17e1fe92-1091-42a9-a2b1-1f874f30a81a','image','assets/resources/colors/24b6a70c-cc4c-4465-9bf2-0ed8f643a46a.jpg','57','App\\Models\\Color','2025-01-18 16:41:10','2025-01-18 16:41:10'),('1ad01c7d-3d37-4fd6-89b0-c0282199ab3b','image','assets/resources/colors/8e9bc82e-1105-44ac-ac0e-528b2a63e5d7.jpg','49','App\\Models\\Color','2025-01-18 16:37:13','2025-01-18 16:37:13'),('1db0d621-afe7-4e07-b28a-f38146b118ee','image','assets/resources/offers/e6161956-d93e-460b-9099-1e5177d58ef7.png','12','App\\Models\\Offer','2025-01-21 21:35:03','2025-01-21 21:35:03'),('1f1217d1-6bbd-445d-ba91-7013236c9c23','image','assets/resources/subcategories/d391ed5c-42c9-4273-8ea3-c1f9090d659a.png','6','App\\Models\\Subcategory','2025-01-18 14:55:54','2025-01-18 14:55:54'),('214c985b-9131-45fc-8e16-f3eccc5fea5b','image','assets/resources/subcategories/ff711010-dc58-4acc-91b4-5a5f191b62fb.png','2','App\\Models\\Subcategory','2025-01-18 14:52:25','2025-01-18 14:52:25'),('224ff8b5-6834-415f-a4c7-3be026bd5d81','image','assets/resources/subcategories/53cc9873-9fb8-413b-b0a6-503c5ffcf51a.png','10','App\\Models\\Subcategory','2025-01-18 15:00:44','2025-01-18 15:00:44'),('23189cee-3df5-4938-89f9-d47cc570a325','image','assets/resources/colors/e4a37d9b-0270-4f2d-a5e9-2fd4643f5b15.jpg','59','App\\Models\\Color','2025-01-18 16:41:48','2025-01-18 16:41:48'),('24c97906-ea61-48ff-9ec7-5b482b8d9eee','image','assets/resources/colors/9bec3a1c-5383-42df-b3b6-77926fe5d519.jpg','53','App\\Models\\Color','2025-01-18 16:38:44','2025-01-18 16:38:44'),('2519c061-09ad-4399-b911-3dee5c47db5e','image','assets/resources/colors/5fbfbdca-34e1-4386-b9d6-5c8a389f4343.jpg','60','App\\Models\\Color','2025-01-18 16:42:05','2025-01-18 16:42:05'),('29bdbb61-5687-424b-8171-8480153b9a0b','image','assets/resources/offers/ffe6cd3f-2788-40b3-99e8-5af3320d4cd0.png','9','App\\Models\\Offer','2025-01-21 21:34:14','2025-01-21 21:34:14'),('2e1ac45d-d0e5-484f-8f26-76314ce2a107','image','assets/resources/subcategories/8b881171-56a7-4cfb-87e8-77f8e85cf375.png','17','App\\Models\\Subcategory','2025-01-18 15:08:55','2025-01-18 15:08:55'),('373c4d4e-5ff8-4396-8dee-78664a8e3eda','image','assets/resources/colors/b0a6c9bd-c4e4-4935-acfd-f32b7d003a00.jpg','45','App\\Models\\Color','2025-01-18 16:35:07','2025-01-18 16:35:07'),('37bbe0c2-7c1c-4527-99b2-2128efd8bb5a','image','assets/resources/articles/2ce6af73-ce0c-4a32-83d2-4aface7e36aa.png','01861c59-6672-4e32-97b6-12524d2bf410','App\\Models\\Article','2025-01-20 19:25:09','2025-01-20 19:25:09'),('3a35e18c-b30c-47eb-bbc8-7d2c32a96f4b','image','assets/resources/colors/730304c6-9716-46a7-a096-ce77aa132c02.jpg','71','App\\Models\\Color','2025-01-18 16:46:55','2025-01-18 16:46:55'),('3bbc2608-90fe-437a-a52a-a879c1bd0e43','image','assets/resources/colors/5ce8cee3-7b95-4141-9a42-4006929b0e26.jpg','58','App\\Models\\Color','2025-01-18 16:41:23','2025-01-18 16:41:23'),('3cae059e-fe84-4d14-8133-4b959565375c','image','assets/resources/variants/c0be5bfa-2d4a-4709-a109-f96abcb4fdb7.png','37a29f31-989e-4222-b608-17bca731a73c','App\\Models\\Variant','2025-01-21 20:52:24','2025-01-21 20:52:24'),('3fcde5b2-136d-4640-943a-56475f3fe846','image','assets/resources/variants/06eb0504-f752-472f-a859-2f68318886ff.png','7ec3f151-175c-4186-ad50-4e1c75e4b56a','App\\Models\\Variant','2025-01-21 20:38:35','2025-01-21 20:38:35'),('44818145-cfbd-4fdb-bcc2-3763a28bd232','image','assets/resources/variants/181fdc37-4ebc-4c26-a937-902a5ecbea5f.png','711f005b-2bcc-4288-a6e3-c694ba7c8da2','App\\Models\\Variant','2025-01-21 20:39:16','2025-01-21 20:39:16'),('47c74372-0f77-4f7a-8f2c-7193a4cfbfae','image','assets/resources/colors/1775c394-5ee9-4bb7-8b57-fd3249d748a9.jpg','62','App\\Models\\Color','2025-01-18 16:43:06','2025-01-18 16:43:06'),('48428aa1-e618-4f91-a80e-49ed647d8021','image','assets/resources/subcategories/2da12257-8ee1-4d63-87e1-90acd651438b.png','19','App\\Models\\Subcategory','2025-01-18 15:11:33','2025-01-18 15:11:33'),('4b380b49-f8bd-4c00-9f18-1f2ca44bc08f','image','assets/resources/offers/96d6ca7e-fc6b-4597-b680-d6a379a4e51d.png','6','App\\Models\\Offer','2025-01-21 21:33:15','2025-01-21 21:33:15'),('4bc8e960-3026-42d9-808e-818c64089050','image','assets/resources/colors/303f5fa1-14ce-452a-8b1e-ccc7ed93b674.jpg','66','App\\Models\\Color','2025-01-18 16:44:39','2025-01-18 16:44:39'),('4c08a032-315c-408a-b929-ea7d9d6161cc','image','assets/resources/variants/d1a8e1b8-2a7d-4c06-838e-6bd7c918c4f0.png','a42cf69d-3204-4ebe-8724-f684acb7a108','App\\Models\\Variant','2025-01-21 20:48:38','2025-01-21 20:48:38'),('4d8b84bb-27ad-497d-8432-2f29e88174d9','image','assets/resources/offers/be887d6e-bf14-4052-8be9-45f283324461.png','2','App\\Models\\Offer','2025-01-21 21:32:00','2025-01-21 21:32:00'),('4ed51934-ea38-4a95-aabd-d5946bc9f456','image','assets/resources/colors/57ef507c-67c6-4dda-81cb-6a99d8c7e4b4.jpg','75','App\\Models\\Color','2025-01-18 16:48:07','2025-01-18 16:48:07'),('50d55f78-76ae-435a-bba2-af1509c7f299','image','assets/resources/variants/71c76672-d4f3-471b-8b4e-3d8583f7de46.png','629d8ed0-243c-4096-a9cf-efa7c139d997','App\\Models\\Variant','2025-01-21 20:49:07','2025-01-21 20:49:07'),('51fda310-94a5-450b-8754-1ff54ed7e040','image','assets/resources/colors/6fcab065-0ddb-4fe4-81ef-a93d5abe8afb.jpg','52','App\\Models\\Color','2025-01-18 16:38:25','2025-01-18 16:38:25'),('54321661-690b-49ad-9a9a-447b500296f5','image','assets/resources/subcategories/04266da2-54ff-4d3b-ac2a-ba59e9afdcf1.png','34','App\\Models\\Subcategory','2025-01-18 15:25:27','2025-01-18 15:25:27'),('5511410a-eee6-4b59-b572-ce1951057d01','image','assets/resources/colors/9ffc091c-edc3-4144-833f-7acd2464008c.jpg','54','App\\Models\\Color','2025-01-18 16:38:57','2025-01-18 16:38:57'),('5772fde9-cbeb-415a-a42c-430493208ec4','image','assets/resources/subcategories/9e4a001c-2abc-48f6-9cfd-1c2a3e487250.jpg','18','App\\Models\\Subcategory','2025-01-18 15:09:50','2025-01-18 15:09:50'),('57fc113e-9c58-4db0-827d-9eb6be11992f','image','assets/resources/colors/f1f1fbb0-3c9a-459b-bf03-6ed569bebf35.jpg','76','App\\Models\\Color','2025-01-18 16:48:58','2025-01-18 16:48:58'),('5e76ed44-a492-4c97-9294-e49308d1abc1','image','assets/resources/subcategories/37719e40-7ce4-428b-b7d7-4b125486d2fc.png','30','App\\Models\\Subcategory','2025-01-18 15:20:25','2025-01-18 15:20:25'),('663e3a80-9713-4531-9571-6002a90e63a9','image','assets/resources/colors/2f977cf3-b4f9-4894-a3e1-c94da64c1dd6.jpg','47','App\\Models\\Color','2025-01-18 16:36:24','2025-01-18 16:36:24'),('66f861c8-d912-41a3-adc1-661c535f357e','image','assets/resources/categories/58a5fc8c-54db-4994-afe0-4ca8e93d5ba5.png','4','App\\Models\\Category','2025-01-22 08:18:43','2025-01-22 08:18:43'),('673275fe-c327-465a-b9b1-d030e7299036','image','assets/resources/variants/d4825967-9c7b-4ddb-b309-ff41188c3973.png','e6787218-ee87-4bfe-8adf-d50c127530b3','App\\Models\\Variant','2025-01-21 20:49:36','2025-01-21 20:49:36'),('6b1054e6-53ee-4ea6-b2c5-dbd6acaf6d65','image','assets/resources/variants/96c2da87-948c-4405-b5b2-a8e85957bd14.png','f03a9ba7-628b-4d56-a447-401f72cb623e','App\\Models\\Variant','2025-01-21 20:37:22','2025-01-21 20:37:22'),('6b972c64-fb37-42a0-be0f-d782bab47245','image','assets/resources/colors/b1d491e2-1fb6-443c-a465-4f2c2a8f84c7.jpg','73','App\\Models\\Color','2025-01-18 16:47:35','2025-01-18 16:47:35'),('6e93a85a-817a-4086-83c3-d2b84d2a4cd9','image','assets/resources/colors/4d938a4d-4130-492a-b22f-ede2c08e3a66.jpg','64','App\\Models\\Color','2025-01-18 16:44:00','2025-01-18 16:44:00'),('71f23243-5c68-49ab-9fc6-516d87ebcccd','image','assets/resources/subcategories/79112daf-98b9-4c61-9bf1-7213044b3cd3.jpg','20','App\\Models\\Subcategory','2025-01-18 15:12:16','2025-01-18 15:12:16'),('72198e5b-bae5-4cbf-9303-5d318552e2c6','image','assets/resources/categories/50a86c0e-5ac0-4f57-94da-54733644231c.png','1','App\\Models\\Category','2025-01-22 08:16:46','2025-01-22 08:16:46'),('76744c93-7ef2-4c69-a003-1f9934ff8c7d','image','assets/resources/subcategories/cfaaf189-7e91-441c-b24f-0637eff30bbe.png','3','App\\Models\\Subcategory','2025-01-18 14:53:25','2025-01-18 14:53:25'),('77a05245-329a-4cef-9975-7c731d9748d9','image','assets/resources/subcategories/2da07563-9120-473c-a8b2-8efbae2ebbe8.png','12','App\\Models\\Subcategory','2025-01-18 15:02:42','2025-01-18 15:02:42'),('7d9f70dd-cdae-4806-924d-e66b5feac214','image','assets/resources/categories/67d09564-a5cb-4b2a-9d61-e4c44bb37a41.png','3','App\\Models\\Category','2025-01-22 08:18:28','2025-01-22 08:18:28'),('81c9b59b-e794-4321-9492-15d7d0e62e05','image','assets/resources/subcategories/0da1f7ad-801b-4510-811d-6ea11268a43e.jpg','4','App\\Models\\Subcategory','2025-01-18 14:53:57','2025-01-18 14:53:57'),('84c38130-7dca-43e5-bfc8-25382eefff4a','image','assets/resources/categories/9dde85f2-64fd-4b10-ba14-9ab87884827d.png','5','App\\Models\\Category','2025-01-22 08:18:53','2025-01-22 08:18:53'),('85f189ec-984e-41de-baf4-7c9dd74f1e87','image','assets/resources/categories/93167eff-d9cf-4dce-a7b6-e413fdb69482.jpg','6','App\\Models\\Category','2025-01-22 08:19:06','2025-01-22 08:19:06'),('8acfa84b-4cd2-488f-8046-c228ac3ca3ce','image','assets/resources/variants/338bf4dc-c278-4009-9970-ff6cf38ce124.png','1c2d5f0c-c411-4dc5-b7e7-6ea6b46cb90b','App\\Models\\Variant','2025-01-21 20:50:44','2025-01-21 20:50:44'),('94142f6c-7364-4c18-965a-9b0fbd64c653','image','assets/resources/colors/55f4ab58-8300-4cc8-81a0-931a662c5d2c.jpg','70','App\\Models\\Color','2025-01-18 16:46:40','2025-01-18 16:46:40'),('96cda8e6-617f-4daa-aec3-8f5d380c59f3','image','assets/resources/offers/f737309a-e932-4839-a708-86a9fa77d08e.png','4','App\\Models\\Offer','2025-01-21 21:32:25','2025-01-21 21:32:25'),('976b7414-0024-4e29-8b05-4753339d4914','image','assets/resources/variants/425569d7-874c-4058-831e-c14bcbdf58d2.png','90934c43-635b-4add-a371-05c93b1578f5','App\\Models\\Variant','2025-01-21 20:53:11','2025-01-21 20:53:11'),('9a1fcf94-c65c-46e2-9627-c74774bd5eaa','image','assets/resources/colors/3a38a06c-dfce-4858-b2ba-5cc1dbabad5b.jpg','48','App\\Models\\Color','2025-01-18 16:36:47','2025-01-18 16:36:47'),('9b08d1de-d7d7-4be2-a83d-7147e79448d9','image','assets/resources/colors/3cf410f2-28fd-4059-97e5-41b56c1954ff.jpg','74','App\\Models\\Color','2025-01-18 16:47:52','2025-01-18 16:47:52'),('9dd48ab5-bf29-41dc-915a-1e663e952243','image','assets/resources/variants/7b1ec1da-3e40-43db-b872-7e2c6218aff4.png','c27efc80-aa12-44ea-ae11-c0d608e84136','App\\Models\\Variant','2025-01-21 20:35:03','2025-01-21 20:35:03'),('9fb73f50-eef6-4a7e-bbe6-2cccaa4c87e2','image','assets/resources/subcategories/608c19ee-7f3b-444e-9f04-92989578a932.png','26','App\\Models\\Subcategory','2025-01-18 15:16:40','2025-01-18 15:16:40'),('a14dbdff-ecd9-41e1-b33e-bd78d4aa7e2d','image','assets/resources/subcategories/1b197bc3-45c3-4773-9c9a-c8995573f7d4.png','23','App\\Models\\Subcategory','2025-01-18 15:14:50','2025-01-18 15:14:50'),('a20a9d22-8420-4b59-bb79-8fb65413dd23','image','assets/resources/subcategories/59067c40-15f9-4b1e-827e-ebc82c483c78.png','1','App\\Models\\Subcategory','2025-01-21 20:47:18','2025-01-21 20:47:18'),('a257fa9b-f63d-4da7-8e56-b571c6c7f01d','image','assets/resources/offers/b47019d8-21d9-4a2c-8143-d9d9b6d9a40f.png','3','App\\Models\\Offer','2025-01-21 21:32:10','2025-01-21 21:32:10'),('a5665aa5-ab75-4ae4-bb31-45312734e9d9','image','assets/resources/subcategories/1067552d-6337-4f59-bb0a-adcbc1977bbe.png','13','App\\Models\\Subcategory','2025-01-18 15:03:26','2025-01-18 15:03:26'),('a5d4dd37-3964-4c2c-bc19-8289046ca706','image','assets/resources/offers/0b51a9a7-d512-4f23-8cb5-31168bfa32b6.png','1','App\\Models\\Offer','2025-01-21 21:31:38','2025-01-21 21:31:38'),('a61b1362-0df4-4522-90a0-a469af8fc0a4','image','assets/resources/subcategories/99c4c49b-128c-49f4-b576-1a27bbc9cf93.jpg','36','App\\Models\\Subcategory','2025-01-18 15:26:29','2025-01-18 15:26:29'),('a6fb0b9f-a1bf-4542-9075-e3883a8b73d1','image','assets/resources/subcategories/2276093c-5dbb-46d7-9f15-4d8c6a8a53fb.jpg','15','App\\Models\\Subcategory','2025-01-18 15:06:20','2025-01-18 15:06:20'),('ab0adc71-679e-456a-8eb4-4a71e4a53eec','image','assets/resources/subcategories/c2fd935b-6f8b-4dca-8335-e8de7c15fccd.png','9','App\\Models\\Subcategory','2025-01-18 14:59:36','2025-01-18 14:59:36'),('ad3305a1-a94d-4700-ab75-97dca533ff90','image','assets/resources/variants/514bdc95-6fd3-439e-add1-5d7293777732.png','e3241efe-dfab-4c99-8620-103730adf270','App\\Models\\Variant','2025-01-21 20:36:46','2025-01-21 20:36:46'),('ad4d58d9-d53e-484c-bd16-12f05c47841d','image','assets/resources/variants/5463f3b2-5bd7-4337-a291-af54ed865946.png','21a5b6ad-8b38-474a-8555-f8ad66482556','App\\Models\\Variant','2025-01-21 20:37:52','2025-01-21 20:37:52'),('b3432ad2-53c6-469f-aa97-97a0eae8dad3','image','assets/resources/colors/31e7a3cc-d7db-4ff3-9f07-59bdfefe5528.jpg','50','App\\Models\\Color','2025-01-18 16:37:39','2025-01-18 16:37:39'),('b7e8af44-6108-4f94-823f-a7244c1d4080','image','assets/resources/colors/a0755c3f-309c-4444-8a7f-b8c6b8a1e467.jpg','69','App\\Models\\Color','2025-01-18 16:46:23','2025-01-18 16:46:23'),('b9dbc372-ec8b-4882-8250-95c8ef802ed3','image','assets/resources/articles/2d53a7d8-d237-4c57-b72a-1074b407badd.png','0b597483-a9f6-4c96-895b-62af22ef789c','App\\Models\\Article','2025-01-21 20:46:28','2025-01-21 20:46:28'),('ba6ec5bd-023b-4d4a-ae49-c8b52388ffb1','image','assets/resources/subcategories/1ee01216-3aeb-465c-9a58-40fb83902722.png','33','App\\Models\\Subcategory','2025-01-18 15:24:36','2025-01-18 15:24:36'),('bb49a2e2-bd7e-4a35-a1d1-3f2d91dfeaf8','image','assets/resources/categories/e15359eb-ccdb-43d8-a14a-56b26be77cd4.png','2','App\\Models\\Category','2025-01-22 08:18:17','2025-01-22 08:18:17'),('bd07573a-e31f-4068-b612-99ffe0b3d9e2','image','assets/resources/colors/7c7d7675-b65b-4484-bbe4-61aed0d8a6a6.jpg','68','App\\Models\\Color','2025-01-18 16:46:06','2025-01-18 16:46:06'),('bddbabb3-22d8-4303-86ba-7e832926cb5e','image','assets/resources/offers/f2688a5b-026a-4081-9e2a-e3ba4bf3ccd4.png','10','App\\Models\\Offer','2025-01-21 21:34:23','2025-01-21 21:34:23'),('becbca4f-d09b-43ef-869a-735ddaded16d','image','assets/resources/subcategories/41e620c0-d13b-43c8-ae63-fb4f2a5e77e1.png','29','App\\Models\\Subcategory','2025-01-18 15:19:47','2025-01-18 15:19:47'),('bfb33b42-7257-41b9-8596-ed128067670b','image','assets/resources/subcategories/436fa438-ca7c-4945-961f-ec6ccb9cf256.png','11','App\\Models\\Subcategory','2025-01-18 15:01:34','2025-01-18 15:01:34'),('c1690b47-0023-4eef-816e-5a5d54e26854','image','assets/resources/subcategories/d5deb98e-fd07-4bd1-9c68-7f68e6104792.png','25','App\\Models\\Subcategory','2025-01-18 15:16:13','2025-01-18 15:16:13'),('c173df1c-d903-4fa0-a3d0-becd9aaa98f1','image','assets/resources/subcategories/98e4d105-7a30-4837-adec-3f8530823c71.png','8','App\\Models\\Subcategory','2025-01-18 14:58:03','2025-01-18 14:58:03'),('c40ee6f1-4653-4119-abed-c850cb220b78','image','assets/resources/subcategories/1bac0543-79a1-4f7d-87b5-99a57a2f8f98.png','28','App\\Models\\Subcategory','2025-01-18 15:19:23','2025-01-18 15:19:23'),('c4e869ee-e6a6-4faf-9828-90d577ec3e59','image','assets/resources/variants/4fca82d4-d2ca-4377-b416-100939bf5153.png','f2ebf419-5b90-4969-b333-a41c63b0085e','App\\Models\\Variant','2025-01-21 20:48:09','2025-01-21 20:48:09'),('c73a1b8b-5321-4e80-b8b3-d071ab0d521b','image','assets/resources/colors/2162d8d0-e96e-40d4-b554-38684b383a0b.jpg','77','App\\Models\\Color','2025-01-18 16:49:12','2025-01-18 16:49:12'),('ca21fd76-3af0-4490-8793-f72ff7d91c1e','image','assets/resources/subcategories/4e869096-2305-4c5c-93ef-95e5f536be3a.png','5','App\\Models\\Subcategory','2025-01-18 14:55:09','2025-01-18 14:55:09'),('cd485de3-f027-4fa2-8d93-9d2ca6e09472','image','assets/resources/colors/7693fe8c-47c9-41a0-a5c7-7b40632a64dc.jpg','61','App\\Models\\Color','2025-01-18 16:42:24','2025-01-18 16:42:24'),('cf2f7392-5328-4c99-9ee2-ae190c697f4e','image','assets/resources/subcategories/cee7047a-6d3c-44be-871f-818d36b07fb7.png','14','App\\Models\\Subcategory','2025-01-18 15:04:23','2025-01-18 15:04:23'),('cfec83aa-1d7f-4b19-ac45-6d3b9285e3fc','image','assets/resources/colors/52da30d2-31d9-4df6-8978-d7a7cef571ab.jpg','55','App\\Models\\Color','2025-01-18 16:39:38','2025-01-18 16:39:38'),('d2081bea-d66a-473f-9b59-aae40c0767eb','image','assets/resources/subcategories/cd5f98f9-139f-40db-9380-adc9b7ee373a.png','24','App\\Models\\Subcategory','2025-01-18 15:15:31','2025-01-18 15:15:31'),('de50651b-d205-40fd-94ff-d514950c92ec','image','assets/resources/colors/f562efd0-f09c-46aa-b8a9-c21542a167e5.jpg','51','App\\Models\\Color','2025-01-18 16:38:07','2025-01-18 16:38:07'),('e3423cc9-7efe-47b7-ac3b-78ce1be2e611','image','assets/resources/colors/d66e75e8-95bb-4f0f-b349-82c79361946e.jpg','63','App\\Models\\Color','2025-01-18 16:43:30','2025-01-18 16:43:30'),('e5cdc5f6-c1b1-4d75-bdb1-6a1de652880a','image','assets/resources/offers/724ec7ca-e5f8-4b25-aa28-4020516bbc59.png','7','App\\Models\\Offer','2025-01-21 21:33:25','2025-01-21 21:33:25'),('e6276ce5-3f8f-4d28-ab99-f21636a50492','image','assets/resources/subcategories/769bbded-63d4-43fe-9a9d-4a05f2835a7a.png','27','App\\Models\\Subcategory','2025-01-18 15:18:46','2025-01-18 15:18:46'),('e83ba162-be4a-45a6-a298-02dfd4684e75','image','assets/resources/subcategories/0fad2f26-46d4-4f8a-85fc-495b0c140adb.png','31','App\\Models\\Subcategory','2025-01-18 15:20:57','2025-01-18 15:20:57'),('e83e3fb7-0342-40b6-8ca0-57026a2356c5','image','assets/resources/subcategories/3d0f541b-a411-4db7-a12e-cc02f0abd326.png','16','App\\Models\\Subcategory','2025-01-18 15:07:36','2025-01-18 15:07:36'),('ea4bd71d-130b-45d3-97c2-3a33e0fe454e','image','assets/resources/subcategories/580bb287-c534-4387-9079-6e9d44aad273.png','21','App\\Models\\Subcategory','2025-01-18 15:13:28','2025-01-18 15:13:28'),('ed0ae843-b801-4501-8070-b998d3643c59','image','assets/resources/subcategories/dc4f8564-f2de-439f-bdab-fa91156cd97a.jpg','35','App\\Models\\Subcategory','2025-01-18 15:25:55','2025-01-18 15:25:55'),('edf3ffbf-945c-4bd6-abaf-372049e59f4d','image','assets/resources/offers/14f249b1-10b2-4ba9-9468-29aaed62874d.png','13','App\\Models\\Offer','2025-01-21 21:34:51','2025-01-21 21:34:51'),('f17bd5e9-39ff-4460-baee-ca9334ce31c3','image','assets/resources/colors/dc2f444f-bcf7-4d8b-95a4-3b06e6eea266.jpg','67','App\\Models\\Color','2025-01-18 16:45:44','2025-01-18 16:45:44'),('f2d87d5f-2975-4fd5-b0dc-a27e95015f42','image','assets/resources/offers/5868035d-c770-4956-978f-edabdb942489.png','8','App\\Models\\Offer','2025-01-21 21:33:36','2025-01-21 21:33:36'),('f9560077-3c47-4056-af30-41e4b99f62bb','image','assets/resources/variants/eb7fe4f7-a268-4067-a7de-6b328b977b36.png','1d8bf83b-0bd1-4db2-91c3-7e94b40e8e22','App\\Models\\Variant','2025-01-21 20:50:07','2025-01-21 20:50:07'),('fc4e388f-f1c3-45c2-8b20-15ce7a7262eb','image','assets/resources/colors/28d2e12f-b9a9-4e72-be7f-ebcc22affd8d.jpg','46','App\\Models\\Color','2025-01-18 16:35:56','2025-01-18 16:35:56'),('fe1368be-6093-4242-8377-68d7cf49cda0','image','assets/resources/variants/d9087c33-0576-456e-bc3b-26333cd899b1.png','abbea9ad-c36a-42f5-9c1a-bbbc5431f763','App\\Models\\Variant','2025-01-21 20:52:11','2025-01-21 20:52:11');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `materials_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (1,'aluminium',NULL,'2025-01-22 08:05:49','2025-01-22 08:05:49'),(2,'bamboo',NULL,'2025-01-22 08:05:58','2025-01-22 08:05:58'),(3,'bois',NULL,'2025-01-22 08:06:06','2025-01-22 08:06:06'),(4,'carton',NULL,'2025-01-22 08:06:12','2025-01-22 08:06:12'),(5,'liège',NULL,'2025-01-22 08:06:18','2025-01-22 08:06:18'),(6,'métal',NULL,'2025-01-22 08:06:26','2025-01-22 08:06:26'),(7,'papier',NULL,'2025-01-22 08:06:32','2025-01-22 08:06:32'),(8,'plastique',NULL,'2025-01-22 08:06:39','2025-01-22 08:06:39'),(9,'simili cuir',NULL,'2025-01-22 08:06:46','2025-01-22 08:06:46'),(10,'soft touch',NULL,'2025-01-22 08:06:53','2025-01-22 08:06:53'),(11,'silicone',NULL,'2025-01-22 08:06:59','2025-01-22 08:06:59'),(12,'Tissu',NULL,'2025-01-22 08:07:06','2025-01-22 08:07:06'),(13,'mousse',NULL,'2025-01-22 08:07:14','2025-01-22 08:07:14'),(14,'plexiglass',NULL,'2025-01-22 08:07:59','2025-01-22 08:07:59'),(15,'porcelaine',NULL,'2025-01-22 08:08:06','2025-01-22 08:08:06'),(16,'verre',NULL,'2025-01-22 08:08:13','2025-01-22 08:08:13'),(17,'inox',NULL,'2025-01-22 08:08:21','2025-01-22 08:08:21'),(18,'Cristal',NULL,'2025-01-22 08:08:28','2025-01-22 08:08:28');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1),(2,'2025_01_18_124352_create_categories_table',1),(3,'2025_01_18_124736_create_subcategories_table',1),(4,'2025_01_18_124938_create_colors_table',1),(5,'2025_01_18_125032_create_availabilities_table',1),(6,'2025_01_18_125230_create_sizes_table',1),(7,'2025_01_18_125259_create_articles_table',1),(8,'2025_01_18_125946_create_pivot_table_article_color',1),(9,'2025_01_18_130038_create_pivot_table_article_subcategory',1),(10,'2025_01_18_130254_create_documents_table',1),(11,'2025_01_18_130408_create_variants_table',1),(12,'2025_01_18_131150_create_users_table',1),(13,'2025_01_18_131250_create_wishlists_table',1),(14,'2025_01_18_131610_create_carts_table',1),(15,'2025_01_18_131656_create_pivot_table_article_wishlist',1),(16,'2025_01_18_131925_create_pivot_table_article_cart',1),(17,'2025_01_18_132436_create_wishlist_items_table',1),(18,'2025_01_18_132535_create_cart_items_table',1),(19,'2025_01_18_132642_create_quotes_table',1),(20,'2025_01_18_132802_create_quote_items_table',1),(21,'2025_01_18_203317_add_ugs_column_in_articles_table',2),(22,'2025_01_20_205727_add_ugs_column_in_variants_table',3),(23,'2025_01_21_220110_create_offers_table',4),(24,'2025_01_22_083328_create_catalogs_table',5),(25,'2025_01_22_085243_create_materials_table',6),(26,'2025_01_22_085518_create_pivot_table_article_material',7),(27,'2025_01_22_100546_update_all_column_to_null_in_users_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `priority` int NOT NULL DEFAULT '0',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offers`
--

LOCK TABLES `offers` WRITE;
/*!40000 ALTER TABLE `offers` DISABLE KEYS */;
INSERT INTO `offers` VALUES (1,'écriture','<p>PLANET DESIGN vous propose une gamme &eacute;toff&eacute;e de stylos publicitaires indispensables au quotidien et en toutes circonstances.<br />\r\nD&eacute;couvrez notre s&eacute;lection de ce gadget populaire avec plusieurs fonctionnalit&eacute;s utiles :</p>\r\n\r\n<ul>\r\n	<li>Les stylos promotionnels pas cher (stylos en plastique, stylos en m&eacute;tal, stylos &eacute;cologiques, stylos comptoir, parure de stylos, stylos porte t&eacute;l&eacute;phone, stylos torche, stylos pointeur&hellip;)</li>\r\n	<li>Les crayons et crayons de couleurs avec logo</li>\r\n	<li>Les surligneurs et fluorescents personnalis&eacute;s</li>\r\n</ul>\r\n\r\n<p>Et pour mieux vous servir, nous mettons &agrave; votre disposition notre parc de machines d&rsquo;impressions d&eacute;di&eacute; &agrave; l&rsquo;impression digital / UV (impression quadri), la tampographie et le marquage laser qui sont les techniques d&rsquo;impressions utilis&eacute;es pour les stylos publicitaires de toute cat&eacute;gorie.</p>',1,'https://planetdesign.ma/category/ecriture','2023-09-14 08:34:44','2024-04-23 16:06:40'),(2,'bureau & event','<p>Nous vous proposons dans cette cat&eacute;gorie d&rsquo;objets publicitaires, un large choix de cadeaux d&rsquo;affaires &agrave; offrir pour des &eacute;v&egrave;nements entreprises mais aussi gadgets personnalis&eacute;s &agrave; poser sur le bureau de votre partenaire ou un accessoire personnalisable d&rsquo;une grande utilit&eacute; et portable partout o&ugrave; votre partenaire s&rsquo;y rend.<br />\r\nDans BUREAU &amp; EVENTS vous aurez &agrave; votre disposition plusieurs id&eacute;es cadeaux originaux dans la cat&eacute;gorie COFFRETS publicitaires, des gadgets publicitaire de budget abordables pour le bureau tels les cubes &agrave; papier personnalisables, des pots &agrave; crayons publicitaires, des antistress&hellip;, et des gadgets accessoires de poche comme les porte-cl&eacute;s publicitaires et porte-cartes de visite. Nous vous offrons un choix de notebooks personnalisables et conf&eacute;renciers publicitaires. Ainsi, pour les &eacute;v&egrave;nements de grandes envergures, nous avons aussi s&eacute;lectionn&eacute; pour vous une gamme vari&eacute;e de troph&eacute;es &agrave; personnaliser et sacs publicitaires.</p>',2,'https://planetdesign.ma/category/bureau-event','2023-09-14 09:04:24','2024-04-23 16:07:01'),(3,'agenda & note book','<p>PLANET DESIGN a s&eacute;lectionn&eacute; pour vous des gammes diversifi&eacute;es de notebooks personnalis&eacute;s : des notebooks technologiques avec power-bank de la nouvelle g&eacute;n&eacute;ration avec et sans induction, des notebooks personnalisables avec USB, des notebook A5 avec couverture en similicuir personnalisable, des notebooks &eacute;cologiques, des notebooks avec post-it int&eacute;gr&eacute;s, des notebooks de type moleskine, des notebooks de prestige en coffret avec stylo.<br />\r\nConcernant les agendas personnalis&eacute;s, nous vous proposons chaque ann&eacute;e des mod&egrave;les sur production avec les sp&eacute;cificit&eacute;s demand&eacute;es.</p>',3,'https://planetdesign.ma/category/bureau-event/note-books-agendas','2023-09-14 09:05:25','2024-04-23 16:07:36'),(4,'coffret publicitaire','<p>Le coffret publicitaire est le cadeau d&rsquo;affaires id&eacute;al pour remercier vos partenaires pour votre collaboration. PLANET DESIGN vous propose une gamme diversifi&eacute;e de coffrets vari&eacute;s et compos&eacute;s de 2 pi&egrave;ces, 3 pi&egrave;ces, 4 pi&egrave;ces et plus tels que : des coffrets porte-cartes de visite, stylo publicitaire, porte-cl&eacute;s promotionnel, coffrets technologiques, des coffrets notebooks haut de gamme&hellip;<br />\r\nD&eacute;filez l&rsquo;ensemble des coffrets corporate disponibles en stock.</p>',4,'https://planetdesign.ma/category/bureau-event/coffret-publicitaire','2023-09-14 09:06:23','2024-04-23 16:08:03'),(5,'pause gourmande','<p>PLANET DESIGN vous propose une gamme diversifi&eacute;e de mugs et thermos pour profiter des temps de repos des &eacute;quipes, et m&ecirc;me en dehors des bureaux afin de mettre en valeur une identit&eacute; visuelle et de l&rsquo;associer au bien &ecirc;tre que peut pr&eacute;senter le caf&eacute; ou le th&eacute; ou n&rsquo;importe quelle boisson appr&eacute;ci&eacute;s. Aussi, vous pouvez proposer &agrave; vos clients des sacs isothermes ou des boites &agrave; repas qui permettront de transporter leurs repas dans les meilleures des conditions.</p>',5,'https://planetdesign.ma/category/pause-gourmande','2023-09-14 09:07:07','2024-04-23 16:08:25'),(6,'Mug & thermo','<p>A tout moment de l&rsquo;ann&eacute;e nous appr&eacute;cions boire nos boissons chaudes assez chaudes. Voil&agrave; l&rsquo;int&eacute;r&ecirc;t de proposer des mugs et des thermos pendant toute l&rsquo;ann&eacute;e avec la personnalisation appropri&eacute;e.<br />\r\nConsultez-nous pour tous les objets publicitaires disponibles sur notre site et m&ecirc;me vos demandes sp&eacute;ciales sur importation. Nous serons &agrave; votre disposition !!</p>',6,'https://planetdesign.ma/category/pause-gourmande/thermos-mugs-publicitaires','2023-09-14 09:08:53','2024-04-23 16:08:52'),(7,'téchnologie','<p>La technologie aujourd&rsquo;hui est au c&oelig;ur de toutes les discussions, c&rsquo;est pourquoi PLANET DESIGN fait en sorte de proposer des gadgets High-Tech &agrave; la pointe des derni&egrave;res tendances technologiques mondiales.<br />\r\nNous avons une large offre de familles des gadgets technologiques afin de satisfaire tous les go&ucirc;ts en respectant les budgets. Allant d&rsquo;un simple accessoire t&eacute;l&eacute;phonique, jusqu&rsquo;&agrave; des coffrets prestigieux et innovants en passant par des Power-Banks, USB et Haut-parleurs et m&ecirc;me une gamme d&eacute;di&eacute;e &agrave; l&rsquo;horlogerie.<br />\r\nEt pour mieux vous servir, nous vous proposons de consulter notre &eacute;quipe commerciale pour mieux vous orienter sur les techniques d&rsquo;impressions et marquage pour que vos objets high-tech apportent satisfaction &agrave; l&rsquo;&oelig;il ainsi qu&rsquo;&agrave; son utilit&eacute;.</p>',7,'https://planetdesign.ma/category/technologie','2023-09-14 09:16:15','2024-04-23 16:09:09'),(8,'usb publicitaire','<p>L&rsquo;outil technologique le plus populaire, pratique et utile dans le monde o&ugrave; nous &eacute;voluons. L&rsquo;USB publicitaire permet d&rsquo;&eacute;changer les donn&eacute;es et les documents de travail volumineux d&rsquo;un poste &agrave; un autre et d&rsquo;un endroit &agrave; un autre en toute vitesse.<br />\r\nPLANET DESIGN, dispose d&rsquo;un stock d&rsquo;USB de diff&eacute;rentes capacit&eacute;s (8GB &ndash; 16GB &ndash; autres sur commande) et de multi-usages (Android type B, Type C, &agrave; mousqueton, &agrave; porte-cl&eacute;s&hellip;.) &agrave; personnaliser avec nos possibilit&eacute;s d&rsquo;impression pour chaque mod&egrave;le.<br />\r\nNous avons aussi la possibilit&eacute; sur importation de vous proposer des USB publicitaire personnalisable &agrave; l&rsquo;extr&ecirc;me en forme de coupe, marque, message, visuel, objet&hellip;</p>',8,'https://planetdesign.ma/category/technologie/cles-usb-publicitaires','2023-09-14 09:17:25','2024-04-23 16:09:35'),(9,'loisire & bien être','<p>PLANET DESIGN vous sugg&egrave;re des objets publicitaires destin&eacute;s aux activit&eacute;s sportives, au bricolage,<br />\r\ndes gadgets pour voiture, des goodies utilis&eacute;s en voyage et sur la route, les vacances d&rsquo;&eacute;t&eacute; avec la<br />\r\nfamille et les amis pour joindre l&rsquo;utile &agrave; l&rsquo;agr&eacute;able et profiter des bons moments de d&eacute;tente pour<br />\r\nam&eacute;liorer la visibilit&eacute; de vos partenaires.</p>',9,'https://planetdesign.ma/category/loisirs','2023-09-14 09:18:24','2024-04-23 16:09:55'),(10,'textile','<p>Le textile publicitaire restera pour toujours un excellent moyen de communication pour les Les T-shirts promotionnels, les polos publicitaires, les casquettes sont souvent utilis&eacute;s dans des &eacute;v&eacute;nements mais aussi &agrave; offrir aux clients. C&rsquo;est l&rsquo;objet publicitaire le plus remarqu&eacute; et il permet une visibilit&eacute; mobile sans pr&eacute;c&eacute;dente.<br />\r\nLes v&ecirc;tements de travail habilleront une &eacute;quipe de fa&ccedil;on harmonieuse et professionnelle ainsi leur permettant une s&eacute;curit&eacute; au quotidien. D&eacute;couvrez notre gamme personnalisable en s&eacute;rigraphie, transfert ou broderie pour donner un booste &agrave; la notori&eacute;t&eacute;.</p>',10,'https://planetdesign.ma/category/textile','2023-09-14 09:19:11','2024-04-23 16:10:13'),(12,'déstockage','<p>Des prix exceptionnels sur une s&eacute;lection d&rsquo;articles</p>',12,'https://planetdesign.ma/destocking','2023-09-14 09:20:55','2024-02-06 15:31:28'),(13,'PowerBanks & Chargeur','...',11,'https://planetdesign.ma/category/technologie/powerbank-chargeurs','2024-02-06 13:26:14','2025-01-21 21:34:51');
/*!40000 ALTER TABLE `offers` ENABLE KEYS */;
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
-- Table structure for table `quote_items`
--

DROP TABLE IF EXISTS `quote_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quote_items` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quote_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quoteable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quoteable_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quote_items_quoteable_type_quoteable_id_index` (`quoteable_type`,`quoteable_id`),
  KEY `quote_items_quote_id_foreign` (`quote_id`),
  CONSTRAINT `quote_items_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quote_items`
--

LOCK TABLES `quote_items` WRITE;
/*!40000 ALTER TABLE `quote_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `quote_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotes` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('en attente','validée','annulé','En cours','terminée','remboursée','échouée','remise en banque','paiement différé','partiellement remboursé','brouillon') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotes_user_id_foreign` (`user_id`),
  CONSTRAINT `quotes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotes`
--

LOCK TABLES `quotes` WRITE;
/*!40000 ALTER TABLE `quotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `quotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizes`
--

LOCK TABLES `sizes` WRITE;
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;
INSERT INTO `sizes` VALUES (1,'l',NULL,'2025-01-18 17:10:29','2025-01-18 17:10:29'),(2,'m',NULL,'2025-01-18 17:11:27','2025-01-18 17:11:27'),(3,'s',NULL,'2025-01-18 17:11:32','2025-01-18 17:11:32'),(4,'xl',NULL,'2025-01-18 17:11:39','2025-01-18 17:11:39'),(5,'xxl',NULL,'2025-01-18 17:11:46','2025-01-18 17:11:46');
/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategories_category_id_foreign` (`category_id`),
  CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (1,1,'stylos en plastique','stylos-en-plastique',0,NULL,'2025-01-18 14:40:23','2025-01-21 20:47:18'),(2,1,'stylos métallique','stylos-mtallique',0,NULL,'2025-01-18 14:43:13','2025-01-18 14:52:24'),(3,1,'stylos bois & écologique','stylos-bois--cologique',0,NULL,'2025-01-18 14:53:25','2025-01-18 14:53:25'),(4,1,'stylos comptoire','stylos-comptoire',0,NULL,'2025-01-18 14:53:57','2025-01-18 14:54:19'),(5,1,'stylos torche & laser','stylos-torche--laser',0,NULL,'2025-01-18 14:55:09','2025-01-18 14:55:09'),(6,1,'surligneurs publicitaires','surligneurs-publicitaires',0,NULL,'2025-01-18 14:55:54','2025-01-18 14:55:54'),(7,1,'parures de stylos','parures-de-stylos',0,NULL,'2025-01-18 14:56:31','2025-01-18 14:56:31'),(8,1,'crayons publicitaires','crayons-publicitaires',0,NULL,'2025-01-18 14:58:03','2025-01-18 14:58:03'),(9,2,'accessoires de poche','accessoires-de-poche',0,NULL,'2025-01-18 14:59:36','2025-01-18 14:59:36'),(10,2,'badgets & tours de cou','badgets--tours-de-cou',0,NULL,'2025-01-18 15:00:44','2025-01-18 15:00:44'),(11,2,'coffret publicitaire','coffret-publicitaire',0,NULL,'2025-01-18 15:01:34','2025-01-18 15:01:34'),(12,2,'conférenciers porte-document','confrenciers-portedocument',0,NULL,'2025-01-18 15:02:42','2025-01-18 15:02:42'),(13,2,'gadgets de bureau','gadgets-de-bureau',0,NULL,'2025-01-18 15:03:26','2025-01-18 15:03:26'),(14,2,'note books & agendas','note-books--agendas',0,NULL,'2025-01-18 15:04:23','2025-01-18 15:04:23'),(15,2,'sacs shopping publicitaires','sacs-shopping-publicitaires',0,NULL,'2025-01-18 15:06:20','2025-01-18 15:06:20'),(16,2,'trophées & médailles','trophes--mdailles',0,NULL,'2025-01-18 15:07:36','2025-01-18 15:07:36'),(17,3,'thermos & mugs publicitaires','thermos--mugs-publicitaires',0,NULL,'2025-01-18 15:08:55','2025-01-18 15:08:55'),(18,3,'gourdes & bouteilles','gourdes--bouteilles',0,NULL,'2025-01-18 15:09:50','2025-01-18 15:09:50'),(19,3,'sacs isothermes & boîtes repas','sacs-isothermes--botes-repas',0,NULL,'2025-01-18 15:11:33','2025-01-18 15:11:33'),(20,3,'mugs en porcelaine','mugs-en-porcelaine',0,NULL,'2025-01-18 15:12:16','2025-01-18 15:12:16'),(21,4,'powerbank & chargeurs','powerbank--chargeurs',0,NULL,'2025-01-18 15:13:28','2025-01-18 15:13:28'),(22,4,'coffret high-tech','coffret-hightech',0,NULL,'2025-01-18 15:14:18','2025-01-18 15:14:18'),(23,4,'clés usb publicitaires','cls-usb-publicitaires',0,NULL,'2025-01-18 15:14:50','2025-01-18 15:14:50'),(24,4,'haut parleurs & casques','haut-parleurs--casques',0,NULL,'2025-01-18 15:15:31','2025-01-18 15:15:31'),(25,4,'accessoires high-tech','accessoires-hightech',0,NULL,'2025-01-18 15:16:13','2025-01-18 15:16:13'),(26,4,'horlogeries publicitaires','horlogeries-publicitaires',0,NULL,'2025-01-18 15:16:40','2025-01-18 15:16:40'),(27,5,'voitures & bricolages','voitures--bricolages',0,NULL,'2025-01-18 15:18:46','2025-01-18 15:18:46'),(28,5,'sacs shopping & voyages','sacs-shopping--voyages',0,NULL,'2025-01-18 15:19:23','2025-01-18 15:19:23'),(29,5,'accessoires femmes','accessoires-femmes',0,NULL,'2025-01-18 15:19:47','2025-01-18 15:19:47'),(30,5,'enfants','enfants',0,NULL,'2025-01-18 15:20:23','2025-01-18 15:20:23'),(31,5,'été & plage','t--plage',0,NULL,'2025-01-18 15:20:57','2025-01-18 15:20:57'),(32,5,'sports & voyages','sports--voyages',0,NULL,'2025-01-18 15:21:43','2025-01-18 15:21:43'),(33,5,'déco & maison','dco--maison',0,NULL,'2025-01-18 15:24:36','2025-01-18 15:24:36'),(34,6,'autres textiles','autres-textiles',0,NULL,'2025-01-18 15:25:27','2025-01-18 15:25:27'),(35,6,'t-shirts & polos','tshirts--polos',0,NULL,'2025-01-18 15:25:55','2025-01-18 15:25:55'),(36,6,'vêtements de travail','vtements-de-travail',0,NULL,'2025-01-18 15:26:29','2025-01-18 15:26:29');
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('047f997d-9977-4eec-a6a0-edc889f06e55',NULL,NULL,NULL,NULL,'2025-01-22 10:01:55','2025-01-22 10:01:55'),('04d870da-6651-47cb-a9eb-aaa8c4926d91',NULL,NULL,NULL,NULL,'2025-01-22 11:36:17','2025-01-22 11:36:17'),('063d9cb9-4fec-4e33-932b-090010cbcd6d',NULL,NULL,NULL,NULL,'2025-01-22 12:06:26','2025-01-22 12:06:26'),('0fefbf71-d2d4-48f3-8ebf-4b3579d6bcc3',NULL,NULL,NULL,NULL,'2025-01-22 10:08:33','2025-01-22 10:08:33'),('16a47f53-9359-4e50-8c96-9ea8afc5e662',NULL,NULL,NULL,NULL,'2025-01-22 10:12:49','2025-01-22 10:12:49'),('1b7c9b0e-428d-4a83-acca-1ac86bc9211e',NULL,NULL,NULL,NULL,'2025-01-22 10:35:50','2025-01-22 10:35:50'),('1e0e1df7-b138-48c4-8106-bb185f5c1d4c',NULL,NULL,NULL,NULL,'2025-01-22 10:01:08','2025-01-22 10:01:08'),('2d5748f6-1fbc-407c-9e2f-1de65167f8d9',NULL,NULL,NULL,NULL,'2025-01-22 09:26:01','2025-01-22 09:26:01'),('357be6c0-cfb9-4fcb-a72f-3da03e3dd873',NULL,NULL,NULL,NULL,'2025-01-22 09:30:04','2025-01-22 09:30:04'),('375c373f-d97e-4b07-b5eb-80eabcd6253e',NULL,NULL,NULL,NULL,'2025-01-22 10:12:52','2025-01-22 10:12:52'),('3c5d7faf-7e4b-4c19-8c6b-347ab1ebdf5f',NULL,NULL,NULL,NULL,'2025-01-22 11:38:45','2025-01-22 11:38:45'),('3df025ab-b3f6-4a4e-96df-662741269af6',NULL,NULL,NULL,NULL,'2025-01-22 11:32:22','2025-01-22 11:32:22'),('45c428bf-7e2b-45fb-bdaa-d9cc674779aa',NULL,NULL,NULL,NULL,'2025-01-22 11:42:40','2025-01-22 11:42:40'),('49eeeac6-0cc2-4987-8477-d976210340f0',NULL,NULL,NULL,NULL,'2025-01-22 11:15:58','2025-01-22 11:15:58'),('4e0e9d22-f01d-4d28-90ba-e89d7fe68a08',NULL,NULL,NULL,NULL,'2025-01-22 11:15:54','2025-01-22 11:15:54'),('4f45f30a-08d9-4887-bb6f-b41a6cd4f8a3',NULL,NULL,NULL,NULL,'2025-01-22 11:38:41','2025-01-22 11:38:41'),('64c7cd5a-ec9c-4e66-902c-c918921d79ca',NULL,NULL,NULL,NULL,'2025-01-22 10:08:37','2025-01-22 10:08:37'),('6a6d232e-fd67-4df9-90d2-7301ed5d7a0a',NULL,NULL,NULL,NULL,'2025-01-22 11:15:40','2025-01-22 11:15:40'),('6df8def4-cd2c-44af-8889-b70ef032c1a6',NULL,NULL,NULL,NULL,'2025-01-22 10:16:12','2025-01-22 10:16:12'),('6f835626-605e-47d5-af02-b559f8858e47',NULL,NULL,NULL,NULL,'2025-01-22 10:32:48','2025-01-22 10:32:48'),('75f49a8d-9403-413f-a168-de9ea5189cc1',NULL,NULL,NULL,NULL,'2025-01-22 10:14:43','2025-01-22 10:14:43'),('783a446c-276d-4e95-9916-3b93b6333354',NULL,NULL,NULL,NULL,'2025-01-22 11:24:51','2025-01-22 11:24:51'),('7eea72cc-9df3-4040-b227-62e14c68e0b8',NULL,NULL,NULL,NULL,'2025-01-22 10:27:39','2025-01-22 10:27:39'),('861fd478-33d7-41ce-8e3e-ccf1696e50da',NULL,NULL,NULL,NULL,'2025-01-22 11:32:18','2025-01-22 11:32:18'),('877de05a-487e-476f-b608-3cd87f5507b8',NULL,NULL,NULL,NULL,'2025-01-22 11:18:38','2025-01-22 11:18:38'),('912c30c6-c71d-4e12-b235-33a425d1382f',NULL,NULL,NULL,NULL,'2025-01-22 11:15:41','2025-01-22 11:15:41'),('95b776b6-c9ad-4fd2-a57a-b7a3b13da989',NULL,NULL,NULL,NULL,'2025-01-22 11:14:40','2025-01-22 11:14:40'),('9c5691aa-102d-485c-9b93-4ec9e8b6c3b4',NULL,NULL,NULL,NULL,'2025-01-22 11:39:45','2025-01-22 11:39:45'),('9c90f01d-27e4-412d-a256-72d45a53df9e',NULL,NULL,NULL,NULL,'2025-01-22 11:15:49','2025-01-22 11:15:49'),('aa7e5a18-5c19-4f1d-8af1-fbc0538b65db',NULL,NULL,NULL,NULL,'2025-01-22 11:55:20','2025-01-22 11:55:20'),('afbc951b-023c-4c74-ba3b-b4a2a5fc5b20',NULL,NULL,NULL,NULL,'2025-01-22 10:32:32','2025-01-22 10:32:32'),('b6bada23-98a7-4336-9ffc-49ffa6852152',NULL,NULL,NULL,NULL,'2025-01-22 11:55:14','2025-01-22 11:55:14'),('b6f8cc74-3d22-4604-b53a-7251acc43105',NULL,NULL,NULL,NULL,'2025-01-22 10:01:59','2025-01-22 10:01:59'),('bb992a31-f8ae-43c0-9065-702d607de463',NULL,NULL,NULL,NULL,'2025-01-22 10:01:15','2025-01-22 10:01:15'),('bdb7ce42-c1af-48a8-b5f4-2fee55937946',NULL,NULL,NULL,NULL,'2025-01-22 11:45:04','2025-01-22 11:45:04'),('becd78cc-7fab-4108-ae5f-1c849e67aaae',NULL,NULL,NULL,NULL,'2025-01-22 09:41:19','2025-01-22 09:41:19'),('c4ece33d-d644-4683-b928-90ae984b3003',NULL,NULL,NULL,NULL,'2025-01-22 11:45:00','2025-01-22 11:45:00'),('c9a39fb9-c3f8-4c9d-8e7d-f903b302a240',NULL,NULL,NULL,NULL,'2025-01-22 11:39:42','2025-01-22 11:39:42'),('cc701d83-9917-4b59-8e0d-ef82c2656550',NULL,NULL,NULL,NULL,'2025-01-22 11:39:43','2025-01-22 11:39:43'),('cea92b3f-121e-4641-ae77-2c97b4f51c85',NULL,NULL,NULL,NULL,'2025-01-22 11:36:10','2025-01-22 11:36:10'),('d4e969b6-d0f6-417f-86fb-341feda5dd8a',NULL,NULL,NULL,NULL,'2025-01-22 11:24:46','2025-01-22 11:24:46'),('d8b73ae6-f38c-4fb0-850f-e359e069bd95',NULL,NULL,NULL,NULL,'2025-01-22 09:58:45','2025-01-22 09:58:45'),('da34eecd-df27-40bd-b1e2-f5fc04db9e35',NULL,NULL,NULL,NULL,'2025-01-22 10:25:41','2025-01-22 10:25:41'),('da806f93-5631-4834-832b-2317fea08de8',NULL,NULL,NULL,NULL,'2025-01-22 11:05:02','2025-01-22 11:05:02'),('dbdcc2e5-9a9d-4a8b-825a-0581881a482c',NULL,NULL,NULL,NULL,'2025-01-22 10:32:50','2025-01-22 10:32:50'),('dc8a51a4-90e8-4719-9d24-b590e9961182',NULL,NULL,NULL,NULL,'2025-01-22 10:01:06','2025-01-22 10:01:06'),('dd1e9e5e-c1e9-4a0e-a4e5-9c97ce55f0c7',NULL,NULL,NULL,NULL,'2025-01-22 11:32:34','2025-01-22 11:32:34'),('ea038e3d-c5d9-40d1-ba2b-013ac3197b43',NULL,NULL,NULL,NULL,'2025-01-22 11:24:56','2025-01-22 11:24:56'),('eb83dc34-8df7-4355-9aaa-e7ac83e57c50',NULL,NULL,NULL,NULL,'2025-01-22 10:10:23','2025-01-22 10:10:23'),('f3faa2cb-b21e-448d-9939-e441993a3b21',NULL,NULL,NULL,NULL,'2025-01-22 11:42:45','2025-01-22 11:42:45'),('f5732d70-4e22-4a82-8740-8d3dc823a12a',NULL,NULL,NULL,NULL,'2025-01-22 11:37:56','2025-01-22 11:37:56'),('f5a8319b-b349-4eea-a19c-10d3a5e630eb',NULL,NULL,NULL,NULL,'2025-01-22 10:36:32','2025-01-22 10:36:32'),('f84543d1-2a8b-4d0c-a9cd-003e99a19e3e',NULL,NULL,NULL,NULL,'2025-01-22 11:18:33','2025-01-22 11:18:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `variants` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ugs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `article_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability_id` bigint unsigned DEFAULT NULL,
  `color_id` bigint unsigned DEFAULT NULL,
  `size_id` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variants_availability_id_foreign` (`availability_id`),
  KEY `variants_article_id_foreign` (`article_id`),
  KEY `variants_color_id_foreign` (`color_id`),
  KEY `variants_size_id_foreign` (`size_id`),
  CONSTRAINT `variants_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `variants_availability_id_foreign` FOREIGN KEY (`availability_id`) REFERENCES `availabilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `variants_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `variants_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variants`
--

LOCK TABLES `variants` WRITE;
/*!40000 ALTER TABLE `variants` DISABLE KEYS */;
INSERT INTO `variants` VALUES ('1c2d5f0c-c411-4dc5-b7e7-6ea6b46cb90b',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,61,NULL,NULL,'2025-01-21 20:50:44','2025-01-21 20:50:44'),('1d8bf83b-0bd1-4db2-91c3-7e94b40e8e22',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',3,60,NULL,NULL,'2025-01-21 20:50:07','2025-01-21 20:50:07'),('21a5b6ad-8b38-474a-8555-f8ad66482556',NULL,'01861c59-6672-4e32-97b6-12524d2bf410',1,58,NULL,NULL,'2025-01-21 20:37:52','2025-01-21 20:37:52'),('37a29f31-989e-4222-b608-17bca731a73c',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,65,NULL,NULL,'2025-01-21 20:51:06','2025-01-21 20:51:06'),('629d8ed0-243c-4096-a9cf-efa7c139d997',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,58,NULL,NULL,'2025-01-21 20:49:07','2025-01-21 20:49:07'),('711f005b-2bcc-4288-a6e3-c694ba7c8da2',NULL,'01861c59-6672-4e32-97b6-12524d2bf410',1,61,NULL,NULL,'2025-01-21 20:39:16','2025-01-21 20:39:16'),('7ec3f151-175c-4186-ad50-4e1c75e4b56a',NULL,'01861c59-6672-4e32-97b6-12524d2bf410',1,59,NULL,NULL,'2025-01-21 20:38:35','2025-01-21 20:38:35'),('90934c43-635b-4add-a371-05c93b1578f5',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,67,NULL,NULL,'2025-01-21 20:53:11','2025-01-21 20:53:11'),('a42cf69d-3204-4ebe-8724-f684acb7a108',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,54,NULL,NULL,'2025-01-21 20:48:38','2025-01-21 20:48:38'),('abbea9ad-c36a-42f5-9c1a-bbbc5431f763',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,66,NULL,NULL,'2025-01-21 20:51:25','2025-01-21 20:51:25'),('c27efc80-aa12-44ea-ae11-c0d608e84136',NULL,'01861c59-6672-4e32-97b6-12524d2bf410',1,47,NULL,NULL,'2025-01-21 20:27:42','2025-01-21 20:27:42'),('cd6dda65-e675-40b5-92c3-a9e6b4bb995e',NULL,'01861c59-6672-4e32-97b6-12524d2bf410',1,65,NULL,NULL,'2025-01-21 20:39:49','2025-01-21 20:39:49'),('e3241efe-dfab-4c99-8620-103730adf270',NULL,'01861c59-6672-4e32-97b6-12524d2bf410',1,49,NULL,NULL,'2025-01-21 20:36:46','2025-01-21 20:36:46'),('e6787218-ee87-4bfe-8adf-d50c127530b3',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,59,NULL,NULL,'2025-01-21 20:49:36','2025-01-21 20:49:36'),('f03a9ba7-628b-4d56-a447-401f72cb623e',NULL,'01861c59-6672-4e32-97b6-12524d2bf410',1,48,NULL,NULL,'2025-01-21 20:35:51','2025-01-21 20:35:51'),('f2ebf419-5b90-4969-b333-a41c63b0085e',NULL,'0b597483-a9f6-4c96-895b-62af22ef789c',1,48,NULL,NULL,'2025-01-21 20:48:09','2025-01-21 20:48:09');
/*!40000 ALTER TABLE `variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist_items`
--

DROP TABLE IF EXISTS `wishlist_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist_items` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wishlist_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wishlistable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wishlistable_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlist_items_wishlistable_type_wishlistable_id_index` (`wishlistable_type`,`wishlistable_id`),
  KEY `wishlist_items_wishlist_id_foreign` (`wishlist_id`),
  CONSTRAINT `wishlist_items_wishlist_id_foreign` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist_items`
--

LOCK TABLES `wishlist_items` WRITE;
/*!40000 ALTER TABLE `wishlist_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlists_user_id_unique` (`user_id`),
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-22 18:30:48
