-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: projeto_final
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pergunta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resposta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (6,'O que são os Pontos Conquistados?','A aba \"Pontos Conquistados\" permite ao utilizador visualizar todos os pontos turísticos que já encontrou e explorou durante o seu percurso. É uma forma de acompanhar o progresso longo da rota.','2025-07-07 00:03:05','2025-07-11 01:27:19'),(7,'Preciso de estar sempre com internet para usar a aplicação?','Sim, para garantir o bom funcionamento da aplicação, é necessário manter uma ligação ativa à internet. Esta conexão permite o carregamento de mapas, rotas, conteúdos multimédia e a localização em tempo real.','2025-07-11 01:28:27','2025-07-11 01:28:27'),(8,'Porque é que a aplicação precisa de aceder à minha localização?','A aplicação utiliza a sua localização em tempo real para o guiar ao longo das rotas, indicar a proximidade dos pontos turísticos e proporcionar uma experiência personalizada. Sem esta permissão, algumas funcionalidades essenciais, como a navegação no mapa e a deteção automática dos pontos conquistados, não funcionarão corretamente.','2025-07-11 01:30:02','2025-07-11 01:31:12'),(9,'Como posso aceder às rotas disponíveis?','Após iniciar sessão, basta aceder à aba “Rotas”, onde poderá consultar todas as rotas disponíveis. Ao selecionar a rota pretendida, será redirecionado para a página correspondente, onde encontrará um botão para iniciar o percurso e começar a sua exploração.','2025-07-11 01:34:43','2025-07-11 01:34:51');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_04_01_202650_create_rotas_table',1),(5,'2025_04_03_204529_create_pontos_table',1),(6,'2025_04_11_092105_create_faqs_table',1),(7,'2025_04_22_144919_add_tipo_to_users_table',1),(8,'2025_05_05_220200_create_ponto_imagens_table',1),(9,'2025_05_21_160952_create_personal_access_tokens_table',2),(10,'2025_05_28_231204_create_ponto_midias_table',3),(11,'2025_06_12_143712_create_personal_access_tokens_table',4),(12,'2025_06_19_153503_add_detalhes_to_rotas_table',5),(13,'2025_06_19_154125_remove_descricao_longa_from_rotas_table',6),(14,'2025_06_19_154155_add_descricao_longa_to_rotas_table',7),(15,'2025_06_19_163733_remove_descricao_longa_from_rotas_table',8),(16,'2025_06_19_163829_add_descricao_longa_to_rotas_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (27,'App\\Models\\User',3,'auth_token','ea30b65da50611d50405e2ed76250ffca03ebe0194469e02ba8900630220f086','[\"*\"]','2025-07-03 13:47:24',NULL,'2025-06-26 12:31:20','2025-07-03 13:47:24'),(41,'App\\Models\\User',1,'auth_token','38bf01101112863b731807496009bacb9cde04ef38893290a0bf33debd8de341','[\"*\"]',NULL,NULL,'2025-07-03 12:27:00','2025-07-03 12:27:00'),(42,'App\\Models\\User',1,'auth_token','97e041ddfe2c5f0b23f9e7065d01aeab786d423adba4a995ad4ed45945709c0f','[\"*\"]','2025-07-03 12:27:02',NULL,'2025-07-03 12:27:01','2025-07-03 12:27:02'),(43,'App\\Models\\User',1,'auth_token','ebb976197b0fba4c6db15f43c3f356b8ee06e718a61c79a9df5c38e01352c8b0','[\"*\"]','2025-07-04 10:46:03',NULL,'2025-07-03 12:27:01','2025-07-04 10:46:03'),(65,'App\\Models\\User',21,'auth_token','6bde873673d615355021b741a7cffe18d143d845d980c0f62ffe55b30d223e20','[\"*\"]','2025-07-10 13:05:55',NULL,'2025-07-10 12:59:49','2025-07-10 13:05:55'),(88,'App\\Models\\User',26,'auth_token','fcc8bf88feabab61cff8bc1cff1ebe2361f3e77011213ded92e21c1ce80fda78','[\"*\"]','2025-07-17 00:32:12',NULL,'2025-07-16 01:31:32','2025-07-17 00:32:12'),(89,'App\\Models\\User',26,'auth_token','7a1d05fa1c6e36ce0ec0961f082bbd891b72df6c111a418dd0d6d237d7634a18','[\"*\"]','2025-07-17 14:57:06',NULL,'2025-07-17 14:54:42','2025-07-17 14:57:06');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ponto_midias`
--

DROP TABLE IF EXISTS `ponto_midias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ponto_midias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ponto_id` bigint unsigned NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caminho` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ponto_midias_ponto_id_foreign` (`ponto_id`),
  CONSTRAINT `ponto_midias_ponto_id_foreign` FOREIGN KEY (`ponto_id`) REFERENCES `pontos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ponto_midias`
--

LOCK TABLES `ponto_midias` WRITE;
/*!40000 ALTER TABLE `ponto_midias` DISABLE KEYS */;
INSERT INTO `ponto_midias` VALUES (257,119,'video','pontos/videos/mjbfG1C1wI3whSwL5HEahOhlYyY2gllhsyeccWQ2.mov','2025-07-16 15:29:00','2025-07-16 15:29:00'),(262,120,'video','pontos/videos/g7dKaES6i9QWxuICQplSaa3tnWPes7VlvzLhRmxM.mov','2025-07-16 15:29:00','2025-07-16 15:29:00'),(270,119,'imagem','pontos/imagems/4Hzqtd6Nj7xymUN6w9caK3Zec70RjMS1Rn2wsDzd.jpg','2025-07-16 23:07:00','2025-07-16 23:07:00'),(271,119,'imagem','pontos/imagems/0d56nn2UVr3Yf2dXzQjzAzcRTI9bk0x6wLdNr2jI.jpg','2025-07-16 23:07:00','2025-07-16 23:07:00'),(272,120,'imagem','pontos/imagems/QCU8nKC3zDb3du0GCkX8YllJ8gOZpt5mttpoo4ps.jpg','2025-07-16 23:07:20','2025-07-16 23:07:20'),(273,120,'imagem','pontos/imagems/96kNCIcQnbKmZMWlIYkR7GNtU32vIihFgfgEULj3.jpg','2025-07-16 23:07:20','2025-07-16 23:07:20'),(274,120,'imagem','pontos/imagems/ledll27oRzqKv5aLii84wld7eotoJLnffKAhvRZQ.jpg','2025-07-16 23:07:20','2025-07-16 23:07:20'),(276,120,'audio','pontos/audios/q2y36K8jAycLED7GefjIh0D92U3VSbifNE3eC1rz.mp3','2025-07-16 23:10:02','2025-07-16 23:10:02'),(277,119,'audio','pontos/audios/dofAxcher0CyiSW7oYYqSYUl7SJHQJ1arc5HYYHB.mp3','2025-07-16 23:11:09','2025-07-16 23:11:09'),(278,108,'imagem','pontos/imagems/55fu5PZife5BrxcUZRodCoN4hKVZ9mFQ8jhzHBrE.jpg','2025-07-17 16:26:17','2025-07-17 16:26:17'),(279,108,'video','pontos/videos/08ZJZepKR0Y1Gu5NNi3dzNVRjFSKfbmYOaepc8Vn.mp4','2025-07-17 16:26:17','2025-07-17 16:26:17'),(280,108,'audio','pontos/audios/vMN6OWAMuGGBEG1aoNM35xVOvP1GMhCTaMQgJyEt.mp3','2025-07-17 16:26:17','2025-07-17 16:26:17');
/*!40000 ALTER TABLE `ponto_midias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pontos`
--

DROP TABLE IF EXISTS `pontos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pontos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `coordenadas` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rota_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pontos_rota_id_foreign` (`rota_id`),
  CONSTRAINT `pontos_rota_id_foreign` FOREIGN KEY (`rota_id`) REFERENCES `rotas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pontos`
--

LOCK TABLES `pontos` WRITE;
/*!40000 ALTER TABLE `pontos` DISABLE KEYS */;
INSERT INTO `pontos` VALUES (108,'Poço azul','O poço Azul é um pequeno paraíso de águas cristalinas e cor azul intensa, escondido no meio da natureza do Gerês.','\"{\\\"lat\\\":41.73346863132137,\\\"lng\\\":-8.106837272644045}\"','2025-07-14 02:19:41','2025-07-16 22:43:55',51),(119,'Carvalho da Espera','Árvore centenária usada como ponto de encontro por caçadores e viajantes. Hoje, é um símbolo da paisagem local, oferecendo sombra e tranquilidade no coração da natureza.','\"{\\\"lat\\\":39.719413848576714,\\\"lng\\\":-8.760203789260721}\"','2025-07-16 15:29:00','2025-07-16 15:29:00',69),(120,'Cascata da Curvachia','Refrescante e serena, esta cascata é um dos encantos naturais da Rota da Curvachia. Rodeada por verde, é o lugar ideal para uma pausa  e contacto com a tranquilidade da zona','\"{\\\"lat\\\":39.71977257521124,\\\"lng\\\":-8.761104305213468}\"','2025-07-16 15:29:00','2025-07-16 15:29:00',69);
/*!40000 ALTER TABLE `pontos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rotas`
--

DROP TABLE IF EXISTS `rotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rotas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `distancia` decimal(8,2) NOT NULL,
  `zona` enum('Sul','Centro','Norte') COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordenadas` json NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `descricaoLonga` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rotas`
--

LOCK TABLES `rotas` WRITE;
/*!40000 ALTER TABLE `rotas` DISABLE KEYS */;
INSERT INTO `rotas` VALUES (51,'Trilho do Gerês','Trilho da Calcedónia, no Gerês — percurso circular com vistas deslumbrantes e riqueza.',3.97,'Norte','\"[{\\\"lat\\\":41.74442043655339,\\\"lng\\\":-8.110656738281252},{\\\"lat\\\":41.73788800556734,\\\"lng\\\":-8.112973665076053},{\\\"lat\\\":41.73384811462744,\\\"lng\\\":-8.113610724736217},{\\\"lat\\\":41.731130723418325,\\\"lng\\\":-8.111686372013585},{\\\"lat\\\":41.72968950491974,\\\"lng\\\":-8.108080713680021},{\\\"lat\\\":41.730554239898986,\\\"lng\\\":-8.10374743476477},{\\\"lat\\\":41.732027465276374,\\\"lng\\\":-8.0998002099565},{\\\"lat\\\":41.734781665566814,\\\"lng\\\":-8.09731048438487},{\\\"lat\\\":41.736922475956135,\\\"lng\\\":-8.096923179150327},{\\\"lat\\\":41.743139620108494,\\\"lng\\\":-8.093833923339846}]\"','rotas/m20d47hwvxEox2IB8esZoDESPYpmqVm4dnk0hbWC.jpg','2025-07-12 16:35:26','2025-07-16 22:43:26','Este trilho conduz os visitantes por paisagens deslumbrantes do Parque Nacional da Peneda-Gerês, com miradouros naturais e zonas de vegetação densa. O percurso termina no famoso Poço Azul, um dos locais mais bonitos da região, perfeito para relaxar e apreciar a natureza.'),(69,'Rota da Curvachia','Caminho linear por trilhos naturais que liga a Cascata da Curvachia ao majestoso Carvalho da Espera, passando por paisagens verdes e zonas de sombra ideais para caminhada tranquila.',0.93,'Centro','\"[{\\\"lat\\\":39.7261871364885,\\\"lng\\\":-8.763346421748663},{\\\"lat\\\":39.726079940995184,\\\"lng\\\":-8.763319620678638},{\\\"lat\\\":39.72590677869237,\\\"lng\\\":-8.76330354003662},{\\\"lat\\\":39.72581607445545,\\\"lng\\\":-8.763266018538593},{\\\"lat\\\":39.72576659936685,\\\"lng\\\":-8.763212416398547},{\\\"lat\\\":39.725725370099205,\\\"lng\\\":-8.76309985190446},{\\\"lat\\\":39.72566352615153,\\\"lng\\\":-8.762960486340331},{\\\"lat\\\":39.72556045278213,\\\"lng\\\":-8.762799679920192},{\\\"lat\\\":39.725420272752494,\\\"lng\\\":-8.762687115426106},{\\\"lat\\\":39.725238862879316,\\\"lng\\\":-8.762574550932019},{\\\"lat\\\":39.72502034580744,\\\"lng\\\":-8.76249414772195},{\\\"lat\\\":39.72490077956933,\\\"lng\\\":-8.762445905795897},{\\\"lat\\\":39.72476884416941,\\\"lng\\\":-8.76237622301385},{\\\"lat\\\":39.72460804755944,\\\"lng\\\":-8.762344061729817},{\\\"lat\\\":39.72445961958665,\\\"lng\\\":-8.762322620873805},{\\\"lat\\\":39.72422873099393,\\\"lng\\\":-8.762338701515803},{\\\"lat\\\":39.724072056151385,\\\"lng\\\":-8.762408384297867},{\\\"lat\\\":39.72392775006044,\\\"lng\\\":-8.76245126600991},{\\\"lat\\\":39.723754582352676,\\\"lng\\\":-8.762478067079932},{\\\"lat\\\":39.72355255281063,\\\"lng\\\":-8.762488787507937},{\\\"lat\\\":39.72346184547677,\\\"lng\\\":-8.76245126600991},{\\\"lat\\\":39.7233711380236,\\\"lng\\\":-8.762381583227844},{\\\"lat\\\":39.72297581190501,\\\"lng\\\":-8.762136728707745},{\\\"lat\\\":39.722654209947585,\\\"lng\\\":-8.761911599719552},{\\\"lat\\\":39.72238208404288,\\\"lng\\\":-8.761857997579506},{\\\"lat\\\":39.72210171077546,\\\"lng\\\":-8.761890158863523},{\\\"lat\\\":39.72182958269047,\\\"lng\\\":-8.76198664271561},{\\\"lat\\\":39.721598685291376,\\\"lng\\\":-8.762072406139692},{\\\"lat\\\":39.721310062455295,\\\"lng\\\":-8.762179610419766},{\\\"lat\\\":39.721112148955264,\\\"lng\\\":-8.762222492131807},{\\\"lat\\\":39.72092248131808,\\\"lng\\\":-8.762190330847792},{\\\"lat\\\":39.72063385565186,\\\"lng\\\":-8.762040244855656},{\\\"lat\\\":39.720468926157416,\\\"lng\\\":-8.761911599719552},{\\\"lat\\\":39.72041944723217,\\\"lng\\\":-8.761740072871408},{\\\"lat\\\":39.72039470775621,\\\"lng\\\":-8.761600707307279},{\\\"lat\\\":39.72028750325791,\\\"lng\\\":-8.761557825595258},{\\\"lat\\\":39.72018854511158,\\\"lng\\\":-8.761472062171176},{\\\"lat\\\":39.7200153680138,\\\"lng\\\":-8.761289814895024},{\\\"lat\\\":39.719999719723056,\\\"lng\\\":-8.761244646111452},{\\\"lat\\\":39.71990900771579,\\\"lng\\\":-8.761271447181475},{\\\"lat\\\":39.719863651667424,\\\"lng\\\":-8.761271447181475},{\\\"lat\\\":39.719818295589214,\\\"lng\\\":-8.761185683757413},{\\\"lat\\\":39.719744076487814,\\\"lng\\\":-8.761051678407297},{\\\"lat\\\":39.719789432614824,\\\"lng\\\":-8.76093911391319},{\\\"lat\\\":39.719739953202044,\\\"lng\\\":-8.760842630061122},{\\\"lat\\\":39.71968635046484,\\\"lng\\\":-8.760735425781029},{\\\"lat\\\":39.719640994270016,\\\"lng\\\":-8.760671103212978},{\\\"lat\\\":39.719529665301756,\\\"lng\\\":-8.760590700002908},{\\\"lat\\\":39.71938534970502,\\\"lng\\\":-8.760488855936806},{\\\"lat\\\":39.71930288351418,\\\"lng\\\":-8.760456694652792},{\\\"lat\\\":39.71931113013768,\\\"lng\\\":-8.760370931228708},{\\\"lat\\\":39.719348239931364,\\\"lng\\\":-8.760285167804645},{\\\"lat\\\":39.71943070606796,\\\"lng\\\":-8.760231565664599},{\\\"lat\\\":39.71951317210598,\\\"lng\\\":-8.760204764594576}]\"','rotas/ujeStWHnJfeBZlCk5yT3kNB7Jk1L2Oe407syj4za.jpg','2025-07-16 15:29:00','2025-07-16 15:29:00','Percurso linear por trilhos naturais que liga a Cascata da Curvachia ao centenário Carvalho da Espera. Ao longo do caminho, paisagens tranquilas, vegetação autóctone e zonas de sombra criam um ambiente ideal para uma caminhada serena. A rota é perfeita para quem procura contacto com a natureza, longe do movimento urbano. Ideal para passeios a pé em qualquer estação do ano.');
/*!40000 ALTER TABLE `rotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('oN55PEqtXvQ5orWt8O6BjyO9pp76Tt1AhdoJr8N1',33,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaEVaZDViZjB2b0cwMjdma1Q3OVVyaE5qdnRqRjM2R1VkMk5ma0NYYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9iYWNrb2ZmaWNlLnRlc3QvdXNlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMzt9',1752780519);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (32,'user','teste','user@gmail.com','user',NULL,'$2y$12$hHweGWkv5bwqKJBTqhhu.e7XvuquTajToN8dn/ZdKqyFLcuf7SvlG',NULL,'2025-07-17 16:02:26','2025-07-17 16:02:26'),(33,'admin','teste','admin@gmail.com','admin',NULL,'$2y$12$QLYeZh9b0N4lwhWIaRE57OiAQU7zjanta0jh93..zxZEh71rskh2q',NULL,'2025-07-17 16:03:29','2025-07-17 16:03:29');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-17 20:29:20
