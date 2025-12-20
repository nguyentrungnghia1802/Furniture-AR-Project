CREATE DATABASE  IF NOT EXISTS `furniture_shop_ar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `furniture_shop_ar`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: furniture_shop_ar
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ward` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `cache` VALUES ('luna_shop_cache_products_index_en_73d826709b1648950769c48490954c3c','a:3:{s:8:\"products\";O:42:\"Illuminate\\Pagination\\LengthAwarePaginator\":11:{s:8:\"\0*\0items\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:10:{i:0;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:30;s:4:\"name\";s:18:\"Saqris Bar Cabinet\";s:12:\"descriptions\";s:315:\"Nâng tầm không gian giải trí với thiết kế Saqris Bar Cabinet hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ cao cấp và mặt kính tinh tế. Sản phẩm mang lại sự sang trọng, bền bỉ và giải pháp lưu trữ rượu, ly tách ngăn nắp cho ngôi nhà của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:20;s:10:\"view_count\";i:0;s:9:\"image_url\";s:14:\"1765978706.jpg\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:0;s:12:\"ar_model_glb\";N;s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";N;s:9:\"height_cm\";N;s:8:\"depth_cm\";N;s:10:\"created_at\";s:19:\"2025-12-17 13:38:26\";s:10:\"updated_at\";s:19:\"2025-12-17 13:38:26\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:30;s:4:\"name\";s:18:\"Saqris Bar Cabinet\";s:12:\"descriptions\";s:315:\"Nâng tầm không gian giải trí với thiết kế Saqris Bar Cabinet hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ cao cấp và mặt kính tinh tế. Sản phẩm mang lại sự sang trọng, bền bỉ và giải pháp lưu trữ rượu, ly tách ngăn nắp cho ngôi nhà của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:20;s:10:\"view_count\";i:0;s:9:\"image_url\";s:14:\"1765978706.jpg\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:0;s:12:\"ar_model_glb\";N;s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";N;s:9:\"height_cm\";N;s:8:\"depth_cm\";N;s:10:\"created_at\";s:19:\"2025-12-17 13:38:26\";s:10:\"updated_at\";s:19:\"2025-12-17 13:38:26\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:27:\"App\\Models\\Product\\Category\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:3;s:4:\"name\";s:8:\"Storages\";s:11:\"description\";s:59:\"Tủ quần áo, kệ sách, tủ giày, tủ trang trí...\";s:10:\"image_path\";s:14:\"1765950816.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:53:36\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:3;s:4:\"name\";s:8:\"Storages\";s:11:\"description\";s:59:\"Tủ quần áo, kệ sách, tủ giày, tủ trang trí...\";s:10:\"image_path\";s:14:\"1765950816.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:53:36\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:10:\"image_path\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:7:\"\0*\0date\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:1;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:29;s:4:\"name\";s:6:\"ROLLER\";s:12:\"descriptions\";s:309:\"Nâng tầm không gian làm việc với thiết kế ROLLER hiện đại, kết hợp hoàn hảo giữa chất liệu lưới thoáng khí và khung chân xoay linh hoạt. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thoải mái tuyệt đối cho suốt ngày dài làm việc.\";s:5:\"price\";s:5:\"90.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:10;s:10:\"view_count\";i:0;s:9:\"image_url\";s:14:\"1765978661.jpg\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:0;s:12:\"ar_model_glb\";N;s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";N;s:9:\"height_cm\";N;s:8:\"depth_cm\";N;s:10:\"created_at\";s:19:\"2025-12-17 13:37:41\";s:10:\"updated_at\";s:19:\"2025-12-17 13:37:41\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:29;s:4:\"name\";s:6:\"ROLLER\";s:12:\"descriptions\";s:309:\"Nâng tầm không gian làm việc với thiết kế ROLLER hiện đại, kết hợp hoàn hảo giữa chất liệu lưới thoáng khí và khung chân xoay linh hoạt. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thoải mái tuyệt đối cho suốt ngày dài làm việc.\";s:5:\"price\";s:5:\"90.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:10;s:10:\"view_count\";i:0;s:9:\"image_url\";s:14:\"1765978661.jpg\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:0;s:12:\"ar_model_glb\";N;s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";N;s:9:\"height_cm\";N;s:8:\"depth_cm\";N;s:10:\"created_at\";s:19:\"2025-12-17 13:37:41\";s:10:\"updated_at\";s:19:\"2025-12-17 13:37:41\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:69;}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:2;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:28;s:4:\"name\";s:14:\"Hayama Cabinet\";s:12:\"descriptions\";s:321:\"Nâng tầm không gian lưu trữ với thiết kế Hayama Cabinet hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên tối màu và các chi tiết kim loại tinh tế. Sản phẩm mang lại sự sang trọng, bền bỉ và vẻ đẹp gọn gàng, ngăn nắp cho ngôi nhà của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:0;s:14:\"stock_quantity\";i:10;s:10:\"view_count\";i:0;s:9:\"image_url\";s:15:\"1765978597.webp\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:0;s:12:\"ar_model_glb\";N;s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";N;s:9:\"height_cm\";N;s:8:\"depth_cm\";N;s:10:\"created_at\";s:19:\"2025-12-17 13:36:37\";s:10:\"updated_at\";s:19:\"2025-12-17 13:36:37\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:28;s:4:\"name\";s:14:\"Hayama Cabinet\";s:12:\"descriptions\";s:321:\"Nâng tầm không gian lưu trữ với thiết kế Hayama Cabinet hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên tối màu và các chi tiết kim loại tinh tế. Sản phẩm mang lại sự sang trọng, bền bỉ và vẻ đẹp gọn gàng, ngăn nắp cho ngôi nhà của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:0;s:14:\"stock_quantity\";i:10;s:10:\"view_count\";i:0;s:9:\"image_url\";s:15:\"1765978597.webp\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:0;s:12:\"ar_model_glb\";N;s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";N;s:9:\"height_cm\";N;s:8:\"depth_cm\";N;s:10:\"created_at\";s:19:\"2025-12-17 13:36:37\";s:10:\"updated_at\";s:19:\"2025-12-17 13:36:37\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:69;}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:3;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:27;s:4:\"name\";s:8:\"TV Stand\";s:12:\"descriptions\";s:300:\"Nâng tầm không gian giải trí với thiết kế TV Stand Furniture hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ bền bỉ và các ngăn lưu trữ thông minh. Sản phẩm mang lại sự sang trọng, tinh tế và vẻ đẹp gọn gàng cho phòng khách của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:10;s:14:\"stock_quantity\";i:10;s:10:\"view_count\";i:6;s:9:\"image_url\";s:14:\"1765978414.jpg\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:51:\"storages/tv_stand_ar_2025_12_17_13_33_34_YLrn2P.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"160.00\";s:9:\"height_cm\";s:5:\"50.00\";s:8:\"depth_cm\";s:5:\"40.00\";s:10:\"created_at\";s:19:\"2025-12-17 13:33:34\";s:10:\"updated_at\";s:19:\"2025-12-17 14:20:20\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:27;s:4:\"name\";s:8:\"TV Stand\";s:12:\"descriptions\";s:300:\"Nâng tầm không gian giải trí với thiết kế TV Stand Furniture hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ bền bỉ và các ngăn lưu trữ thông minh. Sản phẩm mang lại sự sang trọng, tinh tế và vẻ đẹp gọn gàng cho phòng khách của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:10;s:14:\"stock_quantity\";i:10;s:10:\"view_count\";i:6;s:9:\"image_url\";s:14:\"1765978414.jpg\";s:11:\"category_id\";i:3;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:51:\"storages/tv_stand_ar_2025_12_17_13_33_34_YLrn2P.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"160.00\";s:9:\"height_cm\";s:5:\"50.00\";s:8:\"depth_cm\";s:5:\"40.00\";s:10:\"created_at\";s:19:\"2025-12-17 13:33:34\";s:10:\"updated_at\";s:19:\"2025-12-17 14:20:20\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:69;}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:4;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:26;s:4:\"name\";s:13:\"TV Cabinet v1\";s:12:\"descriptions\";s:314:\"Nâng tầm không gian giải trí với thiết kế TV Cabinet v1 hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ công nghiệp cao cấp và khung chân chắc chắn. Sản phẩm mang lại sự sang trọng, bền bỉ và giải pháp lưu trữ ngăn nắp cho phòng khách của bạn.\";s:5:\"price\";s:5:\"55.00\";s:16:\"discount_percent\";i:8;s:14:\"stock_quantity\";i:8;s:10:\"view_count\";i:13;s:9:\"image_url\";s:14:\"1765977651.jpg\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:54:\"tables/tv_cabinet_v1_ar_2025_12_17_13_20_51_LUVOla.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"180.00\";s:9:\"height_cm\";s:5:\"45.00\";s:8:\"depth_cm\";s:5:\"40.00\";s:10:\"created_at\";s:19:\"2025-12-17 13:20:51\";s:10:\"updated_at\";s:19:\"2025-12-17 14:31:41\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:26;s:4:\"name\";s:13:\"TV Cabinet v1\";s:12:\"descriptions\";s:314:\"Nâng tầm không gian giải trí với thiết kế TV Cabinet v1 hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ công nghiệp cao cấp và khung chân chắc chắn. Sản phẩm mang lại sự sang trọng, bền bỉ và giải pháp lưu trữ ngăn nắp cho phòng khách của bạn.\";s:5:\"price\";s:5:\"55.00\";s:16:\"discount_percent\";i:8;s:14:\"stock_quantity\";i:8;s:10:\"view_count\";i:13;s:9:\"image_url\";s:14:\"1765977651.jpg\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:54:\"tables/tv_cabinet_v1_ar_2025_12_17_13_20_51_LUVOla.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"180.00\";s:9:\"height_cm\";s:5:\"45.00\";s:8:\"depth_cm\";s:5:\"40.00\";s:10:\"created_at\";s:19:\"2025-12-17 13:20:51\";s:10:\"updated_at\";s:19:\"2025-12-17 14:31:41\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:27:\"App\\Models\\Product\\Category\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:2;s:4:\"name\";s:6:\"Tables\";s:11:\"description\";s:52:\"Bàn ăn, bàn trà, bàn làm việc, bàn học...\";s:10:\"image_path\";s:14:\"1765950732.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:52:12\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:2;s:4:\"name\";s:6:\"Tables\";s:11:\"description\";s:52:\"Bàn ăn, bàn trà, bàn làm việc, bàn học...\";s:10:\"image_path\";s:14:\"1765950732.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:52:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:10:\"image_path\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:7:\"\0*\0date\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:5;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:25;s:4:\"name\";s:9:\"Wood desk\";s:12:\"descriptions\";s:316:\"Nâng tầm không gian làm việc với thiết kế Wood Desk hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên cao cấp và đường nét tinh xảo. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác cảm hứng tuyệt đối cho mọi nhiệm vụ hàng ngày.\";s:5:\"price\";s:5:\"40.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:33;s:10:\"view_count\";i:14;s:9:\"image_url\";s:14:\"1765977419.png\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:50:\"tables/wood_desk_ar_2025_12_17_13_16_59_0Trog6.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"140.00\";s:9:\"height_cm\";s:5:\"75.00\";s:8:\"depth_cm\";s:5:\"70.00\";s:10:\"created_at\";s:19:\"2025-12-17 13:16:59\";s:10:\"updated_at\";s:19:\"2025-12-17 14:30:06\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:25;s:4:\"name\";s:9:\"Wood desk\";s:12:\"descriptions\";s:316:\"Nâng tầm không gian làm việc với thiết kế Wood Desk hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên cao cấp và đường nét tinh xảo. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác cảm hứng tuyệt đối cho mọi nhiệm vụ hàng ngày.\";s:5:\"price\";s:5:\"40.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:33;s:10:\"view_count\";i:14;s:9:\"image_url\";s:14:\"1765977419.png\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:50:\"tables/wood_desk_ar_2025_12_17_13_16_59_0Trog6.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"140.00\";s:9:\"height_cm\";s:5:\"75.00\";s:8:\"depth_cm\";s:5:\"70.00\";s:10:\"created_at\";s:19:\"2025-12-17 13:16:59\";s:10:\"updated_at\";s:19:\"2025-12-17 14:30:06\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:482;}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:6;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:24;s:4:\"name\";s:30:\"Modern Elegant Chair and Table\";s:12:\"descriptions\";s:276:\"Nâng tầm không gian với bộ Modern Elegant Chair and Table, kết hợp hoàn hảo giữa khung kim loại thanh mảnh và mặt gỗ cao cấp. Sản phẩm mang lại sự sang trọng, bền bỉ và vẻ đẹp tinh tế, hiện đại cho ngôi nhà của bạn.\";s:5:\"price\";s:5:\"60.00\";s:16:\"discount_percent\";i:12;s:14:\"stock_quantity\";i:26;s:10:\"view_count\";i:3;s:9:\"image_url\";s:14:\"1765973223.png\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:71:\"tables/modern_elegant_chair_and_table_ar_2025_12_17_12_07_03_v3wuWh.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"120.00\";s:9:\"height_cm\";s:5:\"75.00\";s:8:\"depth_cm\";s:5:\"60.00\";s:10:\"created_at\";s:19:\"2025-12-17 12:07:03\";s:10:\"updated_at\";s:19:\"2025-12-17 14:30:23\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:24;s:4:\"name\";s:30:\"Modern Elegant Chair and Table\";s:12:\"descriptions\";s:276:\"Nâng tầm không gian với bộ Modern Elegant Chair and Table, kết hợp hoàn hảo giữa khung kim loại thanh mảnh và mặt gỗ cao cấp. Sản phẩm mang lại sự sang trọng, bền bỉ và vẻ đẹp tinh tế, hiện đại cho ngôi nhà của bạn.\";s:5:\"price\";s:5:\"60.00\";s:16:\"discount_percent\";i:12;s:14:\"stock_quantity\";i:26;s:10:\"view_count\";i:3;s:9:\"image_url\";s:14:\"1765973223.png\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:71:\"tables/modern_elegant_chair_and_table_ar_2025_12_17_12_07_03_v3wuWh.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"120.00\";s:9:\"height_cm\";s:5:\"75.00\";s:8:\"depth_cm\";s:5:\"60.00\";s:10:\"created_at\";s:19:\"2025-12-17 12:07:03\";s:10:\"updated_at\";s:19:\"2025-12-17 14:30:23\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:482;}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:7;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:23;s:4:\"name\";s:12:\"Dining Table\";s:12:\"descriptions\";s:311:\"Nâng tầm không gian bếp với thiết kế Dining Table hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên cao cấp và bề mặt hoàn thiện tinh xảo. Sản phẩm mang lại sự sang trọng, bền bỉ và không gian ấm cúng tuyệt đối cho bữa ăn gia đình.\";s:5:\"price\";s:5:\"60.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:18;s:10:\"view_count\";i:3;s:9:\"image_url\";s:14:\"1765959929.jpg\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:53:\"tables/dining_table_ar_2025_12_17_08_25_29_awLc7U.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"160.00\";s:9:\"height_cm\";s:5:\"75.00\";s:8:\"depth_cm\";s:5:\"80.00\";s:10:\"created_at\";s:19:\"2025-12-17 08:25:29\";s:10:\"updated_at\";s:19:\"2025-12-17 13:41:39\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:23;s:4:\"name\";s:12:\"Dining Table\";s:12:\"descriptions\";s:311:\"Nâng tầm không gian bếp với thiết kế Dining Table hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên cao cấp và bề mặt hoàn thiện tinh xảo. Sản phẩm mang lại sự sang trọng, bền bỉ và không gian ấm cúng tuyệt đối cho bữa ăn gia đình.\";s:5:\"price\";s:5:\"60.00\";s:16:\"discount_percent\";i:5;s:14:\"stock_quantity\";i:18;s:10:\"view_count\";i:3;s:9:\"image_url\";s:14:\"1765959929.jpg\";s:11:\"category_id\";i:2;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:53:\"tables/dining_table_ar_2025_12_17_08_25_29_awLc7U.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"160.00\";s:9:\"height_cm\";s:5:\"75.00\";s:8:\"depth_cm\";s:5:\"80.00\";s:10:\"created_at\";s:19:\"2025-12-17 08:25:29\";s:10:\"updated_at\";s:19:\"2025-12-17 13:41:39\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:482;}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:8;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:22;s:4:\"name\";s:12:\"Smooth Chair\";s:12:\"descriptions\";s:285:\"Nâng tầm góc thư giãn với thiết kế Smooth Chair hiện đại, kết hợp hoàn hảo giữa chất liệu vải cao cấp và đệm mút êm ái. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thư giãn tuyệt đối cho không gian của bạn.\";s:5:\"price\";s:5:\"55.00\";s:16:\"discount_percent\";i:15;s:14:\"stock_quantity\";i:37;s:10:\"view_count\";i:11;s:9:\"image_url\";s:14:\"1765957106.jpg\";s:11:\"category_id\";i:1;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:55:\"seatings/smooth_chair_ar_2025_12_17_07_38_26_r7Cd96.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:5:\"70.00\";s:9:\"height_cm\";s:5:\"85.00\";s:8:\"depth_cm\";s:5:\"75.00\";s:10:\"created_at\";s:19:\"2025-12-17 07:38:26\";s:10:\"updated_at\";s:19:\"2025-12-17 15:44:27\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:22;s:4:\"name\";s:12:\"Smooth Chair\";s:12:\"descriptions\";s:285:\"Nâng tầm góc thư giãn với thiết kế Smooth Chair hiện đại, kết hợp hoàn hảo giữa chất liệu vải cao cấp và đệm mút êm ái. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thư giãn tuyệt đối cho không gian của bạn.\";s:5:\"price\";s:5:\"55.00\";s:16:\"discount_percent\";i:15;s:14:\"stock_quantity\";i:37;s:10:\"view_count\";i:11;s:9:\"image_url\";s:14:\"1765957106.jpg\";s:11:\"category_id\";i:1;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:55:\"seatings/smooth_chair_ar_2025_12_17_07_38_26_r7Cd96.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:5:\"70.00\";s:9:\"height_cm\";s:5:\"85.00\";s:8:\"depth_cm\";s:5:\"75.00\";s:10:\"created_at\";s:19:\"2025-12-17 07:38:26\";s:10:\"updated_at\";s:19:\"2025-12-17 15:44:27\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";O:27:\"App\\Models\\Product\\Category\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:1;s:4:\"name\";s:8:\"Seatings\";s:11:\"description\";s:52:\"Ghế sofa, ghế đơn, ghế bành, ghế đôn...\";s:10:\"image_path\";s:14:\"1765950646.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:50:46\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:1;s:4:\"name\";s:8:\"Seatings\";s:11:\"description\";s:52:\"Ghế sofa, ghế đơn, ghế bành, ghế đôn...\";s:10:\"image_path\";s:14:\"1765950646.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:50:46\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:10:\"image_path\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:7:\"\0*\0date\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}}}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}i:9;O:26:\"App\\Models\\Product\\Product\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:20:{s:2:\"id\";i:21;s:4:\"name\";s:12:\"Classic Sofa\";s:12:\"descriptions\";s:296:\"Nâng tầm phòng khách với thiết kế Classic Sofa cổ điển, kết hợp hoàn hảo giữa chất liệu da bò sang trọng và đệm mút cao cấp. Sản phẩm mang lại sự đẳng cấp, bền bỉ và cảm giác thư giãn tuyệt đối cho không gian sống của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:15;s:14:\"stock_quantity\";i:24;s:10:\"view_count\";i:2;s:9:\"image_url\";s:14:\"1765956638.jpg\";s:11:\"category_id\";i:1;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:55:\"seatings/classic_sofa_ar_2025_12_17_07_30_38_KnjLSN.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"240.00\";s:9:\"height_cm\";s:5:\"80.00\";s:8:\"depth_cm\";s:5:\"75.00\";s:10:\"created_at\";s:19:\"2025-12-17 07:30:38\";s:10:\"updated_at\";s:19:\"2025-12-17 13:40:36\";s:18:\"reviews_avg_rating\";N;}s:11:\"\0*\0original\";a:20:{s:2:\"id\";i:21;s:4:\"name\";s:12:\"Classic Sofa\";s:12:\"descriptions\";s:296:\"Nâng tầm phòng khách với thiết kế Classic Sofa cổ điển, kết hợp hoàn hảo giữa chất liệu da bò sang trọng và đệm mút cao cấp. Sản phẩm mang lại sự đẳng cấp, bền bỉ và cảm giác thư giãn tuyệt đối cho không gian sống của bạn.\";s:5:\"price\";s:6:\"120.00\";s:16:\"discount_percent\";i:15;s:14:\"stock_quantity\";i:24;s:10:\"view_count\";i:2;s:9:\"image_url\";s:14:\"1765956638.jpg\";s:11:\"category_id\";i:1;s:10:\"ar_enabled\";i:1;s:12:\"ar_model_glb\";s:55:\"seatings/classic_sofa_ar_2025_12_17_07_30_38_KnjLSN.glb\";s:13:\"ar_model_usdz\";N;s:13:\"ar_model_size\";N;s:25:\"ar_placement_instructions\";N;s:8:\"width_cm\";s:6:\"240.00\";s:9:\"height_cm\";s:5:\"80.00\";s:8:\"depth_cm\";s:5:\"75.00\";s:10:\"created_at\";s:19:\"2025-12-17 07:30:38\";s:10:\"updated_at\";s:19:\"2025-12-17 13:40:36\";s:18:\"reviews_avg_rating\";N;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"category\";r:895;}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:16:{i:0;s:4:\"name\";i:1;s:12:\"descriptions\";i:2;s:5:\"price\";i:3;s:14:\"stock_quantity\";i:4;s:9:\"image_url\";i:5;s:11:\"category_id\";i:6;s:16:\"discount_percent\";i:7;s:10:\"view_count\";i:8;s:10:\"ar_enabled\";i:9;s:12:\"ar_model_glb\";i:10;s:13:\"ar_model_usdz\";i:11;s:13:\"ar_model_size\";i:12;s:25:\"ar_placement_instructions\";i:13;s:8:\"width_cm\";i:14;s:9:\"height_cm\";i:15;s:8:\"depth_cm\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:8:\"\0*\0dates\";a:1:{i:0;s:10:\"created_at\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"\0*\0perPage\";i:10;s:14:\"\0*\0currentPage\";i:1;s:7:\"\0*\0path\";s:29:\"http://127.0.0.1:8000/product\";s:8:\"\0*\0query\";a:7:{s:4:\"sort\";N;s:1:\"q\";N;s:8:\"category\";N;s:13:\"category_name\";N;s:7:\"ar_only\";N;s:9:\"min_price\";N;s:9:\"max_price\";N;}s:11:\"\0*\0fragment\";N;s:11:\"\0*\0pageName\";s:4:\"page\";s:10:\"onEachSide\";i:3;s:10:\"\0*\0options\";a:2:{s:4:\"path\";s:29:\"http://127.0.0.1:8000/product\";s:8:\"pageName\";s:4:\"page\";}s:8:\"\0*\0total\";i:14;s:11:\"\0*\0lastPage\";i:2;}s:10:\"categories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:27:\"App\\Models\\Product\\Category\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:8:\"Seatings\";s:11:\"description\";s:52:\"Ghế sofa, ghế đơn, ghế bành, ghế đôn...\";s:10:\"image_path\";s:14:\"1765950646.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:50:46\";s:13:\"product_count\";i:6;}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:4:\"name\";s:8:\"Seatings\";s:11:\"description\";s:52:\"Ghế sofa, ghế đơn, ghế bành, ghế đôn...\";s:10:\"image_path\";s:14:\"1765950646.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:50:46\";s:13:\"product_count\";i:6;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:10:\"image_path\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:7:\"\0*\0date\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}}i:1;O:27:\"App\\Models\\Product\\Category\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:6:\"Tables\";s:11:\"description\";s:52:\"Bàn ăn, bàn trà, bàn làm việc, bàn học...\";s:10:\"image_path\";s:14:\"1765950732.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:52:12\";s:13:\"product_count\";i:4;}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:4:\"name\";s:6:\"Tables\";s:11:\"description\";s:52:\"Bàn ăn, bàn trà, bàn làm việc, bàn học...\";s:10:\"image_path\";s:14:\"1765950732.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:52:12\";s:13:\"product_count\";i:4;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:10:\"image_path\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:7:\"\0*\0date\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}}i:2;O:27:\"App\\Models\\Product\\Category\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:3;s:4:\"name\";s:8:\"Storages\";s:11:\"description\";s:59:\"Tủ quần áo, kệ sách, tủ giày, tủ trang trí...\";s:10:\"image_path\";s:14:\"1765950816.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:53:36\";s:13:\"product_count\";i:4;}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:3;s:4:\"name\";s:8:\"Storages\";s:11:\"description\";s:59:\"Tủ quần áo, kệ sách, tủ giày, tủ trang trí...\";s:10:\"image_path\";s:14:\"1765950816.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:53:36\";s:13:\"product_count\";i:4;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:10:\"image_path\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:7:\"\0*\0date\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}}i:3;O:27:\"App\\Models\\Product\\Category\":31:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:4;s:4:\"name\";s:7:\"Decores\";s:11:\"description\";s:53:\"Đèn, tranh, cây cảnh, phụ kiện trang trí...\";s:10:\"image_path\";s:14:\"1765950870.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:54:30\";s:13:\"product_count\";i:0;}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:4;s:4:\"name\";s:7:\"Decores\";s:11:\"description\";s:53:\"Đèn, tranh, cây cảnh, phụ kiện trang trí...\";s:10:\"image_path\";s:14:\"1765950870.jpg\";s:10:\"created_at\";s:19:\"2025-10-09 23:05:43\";s:10:\"updated_at\";s:19:\"2025-12-17 05:54:30\";s:13:\"product_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:11:\"description\";i:2;s:10:\"image_path\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:7:\"\0*\0date\";a:2:{i:0;s:10:\"created_at\";i:1;s:10:\"updated_at\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:9:\"pageTitle\";s:18:\"Luna Shop Products\";}',1765987345);
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
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  KEY `carts_session_id_index` (`session_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (3,2,'YFzYu9m2L1QpKvLpCDMxJC9OL9wOp4rSfPX1N8kB',22,1,'2025-12-17 07:49:45','2025-12-17 07:49:45'),(4,2,'YFzYu9m2L1QpKvLpCDMxJC9OL9wOp4rSfPX1N8kB',21,1,'2025-12-17 07:49:50','2025-12-17 07:49:50'),(5,2,'YFzYu9m2L1QpKvLpCDMxJC9OL9wOp4rSfPX1N8kB',20,1,'2025-12-17 07:49:54','2025-12-17 07:49:54'),(6,2,'YFzYu9m2L1QpKvLpCDMxJC9OL9wOp4rSfPX1N8kB',19,1,'2025-12-17 07:49:56','2025-12-17 07:49:56'),(7,2,'YFzYu9m2L1QpKvLpCDMxJC9OL9wOp4rSfPX1N8kB',29,1,'2025-12-17 07:49:59','2025-12-17 07:49:59'),(8,2,'YFzYu9m2L1QpKvLpCDMxJC9OL9wOp4rSfPX1N8kB',23,1,'2025-12-17 07:50:04','2025-12-17 07:50:04');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Seatings','Ghế sofa, ghế đơn, ghế bành, ghế đôn...','1765950646.jpg','2025-10-09 16:05:43','2025-12-16 22:50:46'),(2,'Tables','Bàn ăn, bàn trà, bàn làm việc, bàn học...','1765950732.jpg','2025-10-09 16:05:43','2025-12-16 22:52:12'),(3,'Storages','Tủ quần áo, kệ sách, tủ giày, tủ trang trí...','1765950816.jpg','2025-10-09 16:05:43','2025-12-16 22:53:36'),(4,'Decores','Đèn, tranh, cây cảnh, phụ kiện trang trí...','1765950870.jpg','2025-10-09 16:05:43','2025-12-16 22:54:30');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_10_09_111635_create_all_tables_and_admin_user',1),(2,'2024_12_05_000001_create_product_material_variants_table',2),(3,'2024_12_05_000002_create_ar_room_planner_tables',2),(4,'2024_12_09_000001_create_ar_advanced_features_tables',3),(5,'2024_12_09_000001_create_ar_guided_tours_tables',4),(6,'2025_12_16_091747_drop_unused_ar_tables',5),(7,'2025_12_16_110251_add_session_id_to_carts_table',6),(8,'2025_12_17_144037_add_slug_to_posts_table',7),(9,'2025_12_17_144403_add_image_to_posts_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_details_order_id_foreign` (`order_id`),
  KEY `order_details_product_id_foreign` (`product_id`),
  CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipped','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `address_id` bigint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_address_id_foreign` (`address_id`),
  CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash_on_delivery','bank_transfer','credit_card') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `transaction_id` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Bàn Làm Việc Gỗ Tự Nhiên – Nguồn Cảm Hứng Cho Góc Sáng Tạo','ban-lam-viec-go-tu-nhien-nguon-cam-hung-cho-goc-sang-tao','<p data-path-to-node=\"3\">Nếu bạn l&agrave; một lập tr&igrave;nh vi&ecirc;n hay một người thường xuy&ecirc;n l&agrave;m việc tại nh&agrave;, chiếc b&agrave;n l&agrave;m việc ch&iacute;nh l&agrave; \"người bạn đồng h&agrave;nh\" quan trọng nhất. Thay v&igrave; những mẫu b&agrave;n nhựa hay kim loại lạnh lẽo, một chiếc b&agrave;n bằng gỗ tự nhi&ecirc;n sẽ mang lại cảm gi&aacute;c ấm &aacute;p v&agrave; tr&agrave;n đầy cảm hứng.</p>\r\n<p data-path-to-node=\"4\">L&yacute; do đầu ti&ecirc;n khiến b&agrave;n gỗ được y&ecirc;u th&iacute;ch ch&iacute;nh l&agrave; độ bền v&agrave; vẻ đẹp độc bản. Mỗi tấm gỗ đều c&oacute; những đường v&acirc;n kh&aacute;c nhau, kh&ocirc;ng chiếc b&agrave;n n&agrave;o giống hệt chiếc b&agrave;n n&agrave;o. Khi chạm tay v&agrave;o mặt gỗ mịn m&agrave;ng, bạn sẽ cảm thấy thư th&aacute;i hơn, gi&uacute;p giảm bớt căng thẳng trong những giờ chạy dự &aacute;n căng thẳng.</p>\r\n<p data-path-to-node=\"5\">Để g&oacute;c l&agrave;m việc vừa đẹp vừa gọn g&agrave;ng, bạn n&ecirc;n chọn những mẫu b&agrave;n c&oacute; thiết kế tối giản, ch&acirc;n sắt thanh mảnh nhưng chắc chắn. Mặt b&agrave;n rộng r&atilde;i gi&uacute;p bạn thoải m&aacute;i đặt laptop, m&agrave;n h&igrave;nh rời v&agrave; cả một lọ hoa nhỏ từ <strong>Hanaya Shop</strong> để kh&ocirc;ng gian th&ecirc;m phần sinh động.</p>\r\n<p data-path-to-node=\"6\"><strong>Th&ocirc;ng tin k&iacute;ch thước cơ bản để bạn tham khảo:</strong></p>\r\n<ul data-path-to-node=\"7\">\r\n<li>\r\n<p data-path-to-node=\"7,0,0\"><strong>Chiều rộng:</strong> 120 cm (đủ rộng cho hai m&agrave;n h&igrave;nh).</p>\r\n</li>\r\n<li>\r\n<p data-path-to-node=\"7,1,0\"><strong>Chiều cao:</strong> 75 cm (chiều cao chuẩn để ngồi l&agrave;m việc thoải m&aacute;i).</p>\r\n</li>\r\n<li>\r\n<p data-path-to-node=\"7,2,0\"><strong>Chiều s&acirc;u:</strong> 60 cm (gi&uacute;p khoảng c&aacute;ch từ mắt đến m&agrave;n h&igrave;nh hợp l&yacute;).</p>\r\n</li>\r\n</ul>\r\n<p data-path-to-node=\"8\">Một chiếc b&agrave;n tốt kh&ocirc;ng chỉ l&agrave; m&oacute;n đồ nội thất, m&agrave; c&ograve;n l&agrave; nơi nu&ocirc;i dưỡng những &yacute; tưởng mới. Chỉ cần sắp xếp th&ecirc;m một chiếc đ&egrave;n v&agrave;ng dịu nhẹ v&agrave; một t&aacute;ch c&agrave; ph&ecirc;, bạn đ&atilde; c&oacute; ngay một kh&ocirc;ng gian l&agrave;m việc l&yacute; tưởng để tập trung ho&agrave;n th&agrave;nh mọi mục ti&ecirc;u trong ng&agrave;y.</p>','post_featured_20251217144459_qHcRaOEN.png',NULL,1,0,1,'2025-12-17 07:44:59','2025-12-17 07:44:59'),(2,'Ghế Thư Giãn Bọc Vải – Góc Nhỏ Để Nạp Lại Năng Lượng','ghe-thu-gian-boc-vai-goc-nho-de-nap-lai-nang-luong','<p data-path-to-node=\"2\">Sau một ng&agrave;y d&agrave;i bận rộn với những d&ograve;ng code hay việc quản l&yacute; cửa h&agrave;ng, ai cũng cần một g&oacute;c ri&ecirc;ng để tựa lưng v&agrave; nghỉ ngơi. Một chiếc ghế thư gi&atilde;n (Armchair) &ecirc;m &aacute;i đặt cạnh cửa sổ sẽ l&agrave; nơi tuyệt vời nhất để bạn đọc một cuốn s&aacute;ch hoặc nh&acirc;m nhi t&aacute;ch tr&agrave;.</p>\r\n<p data-path-to-node=\"3\">Kh&aacute;c với ghế l&agrave;m việc cần sự cứng c&aacute;p, ghế thư gi&atilde;n thường c&oacute; lớp đệm d&agrave;y v&agrave; bọc vải mềm mại. Những t&ocirc;ng m&agrave;u nhẹ nh&agrave;ng như x&aacute;m nhạt, xanh mint hay kem kh&ocirc;ng chỉ gi&uacute;p kh&ocirc;ng gian tr&ocirc;ng rộng r&atilde;i hơn m&agrave; c&ograve;n mang lại cảm gi&aacute;c dễ chịu cho thị gi&aacute;c. Bạn c&oacute; thể đặt th&ecirc;m một chiếc gối &ocirc;m nhỏ hoặc một chiếc chăn mỏng để tăng th&ecirc;m sự ấm c&uacute;ng.</p>\r\n<p data-path-to-node=\"4\">Để g&oacute;c nhỏ n&agrave;y ho&agrave;n hảo hơn, bạn h&atilde;y thử đặt ghế cạnh một chậu c&acirc;y xanh hoặc một b&igrave;nh hoa tươi. Sự kết hợp giữa chất liệu vải v&agrave; thi&ecirc;n nhi&ecirc;n sẽ biến căn ph&ograve;ng của bạn trở n&ecirc;n tinh tế v&agrave; đậm chất nghệ thuật như một qu&aacute;n c&agrave; ph&ecirc; thu nhỏ.</p>\r\n<p data-path-to-node=\"5\"><strong>K&iacute;ch thước tham khảo để bạn dễ sắp xếp:</strong></p>\r\n<ul data-path-to-node=\"6\">\r\n<li>\r\n<p data-path-to-node=\"6,0,0\"><strong>Chiều rộng:</strong> 80 cm (vừa vặn để ngồi thoải m&aacute;i m&agrave; kh&ocirc;ng chiếm qu&aacute; nhiều diện t&iacute;ch).</p>\r\n</li>\r\n<li>\r\n<p data-path-to-node=\"6,1,0\"><strong>Chiều cao:</strong> 90 cm (tựa đầu thoải m&aacute;i).</p>\r\n</li>\r\n<li>\r\n<p data-path-to-node=\"6,2,0\"><strong>Chiều s&acirc;u:</strong> 75 cm (độ ngả lưng hợp l&yacute; để thư gi&atilde;n).</p>\r\n</li>\r\n</ul>\r\n<p data-path-to-node=\"7\">Đầu tư v&agrave;o một chiếc ghế chất lượng ch&iacute;nh l&agrave; c&aacute;ch bạn chăm s&oacute;c sức khỏe tinh thần của m&igrave;nh. Đ&acirc;y sẽ l&agrave; nơi bạn tạm rời xa m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh để t&igrave;m lại sự c&acirc;n bằng v&agrave; thư th&aacute;i.</p>','post_featured_20251217144647_sBHbiq0D.jpg',NULL,1,0,1,'2025-12-17 07:46:47','2025-12-17 07:46:47'),(3,'Tủ Sách Gỗ Tối Giản – Nơi Lưu Giữ Tri Thức Và Kỷ Niệm','tu-sach-go-toi-gian-noi-luu-giu-tri-thuc-va-ky-niem','<p data-path-to-node=\"3\">Trong mỗi ng&ocirc;i nh&agrave;, tủ s&aacute;ch kh&ocirc;ng đơn thuần l&agrave; nơi để sắp xếp những cuốn s&aacute;ch, m&agrave; c&ograve;n l&agrave; một tấm gương phản chiếu t&acirc;m hồn v&agrave; sở th&iacute;ch của chủ nh&acirc;n. Một chiếc tủ s&aacute;ch gỗ với thiết kế tối giản sẽ gi&uacute;p căn ph&ograve;ng trở n&ecirc;n thanh lịch v&agrave; c&oacute; chiều s&acirc;u hơn rất nhiều.</p>\r\n<p data-path-to-node=\"4\">Thay v&igrave; những mẫu tủ đồ sộ, k&iacute;n m&iacute;t, xu hướng hiện nay l&agrave; những hệ kệ mở với c&aacute;c ngăn &ocirc; c&oacute; k&iacute;ch thước kh&aacute;c nhau. C&aacute;ch thiết kế n&agrave;y gi&uacute;p kh&ocirc;ng gian tr&ocirc;ng th&ocirc;ng tho&aacute;ng, kh&ocirc;ng bị b&iacute; b&aacute;ch. Bạn c&oacute; thể xen kẽ giữa những cuốn s&aacute;ch l&agrave; c&aacute;c m&oacute;n đồ trang tr&iacute; nhỏ như khung ảnh gia đ&igrave;nh, một v&agrave;i bức tượng gốm hay thậm ch&iacute; l&agrave; một b&igrave;nh hoa kh&ocirc; để tạo điểm nhấn.</p>\r\n<p data-path-to-node=\"5\">Chất liệu gỗ s&aacute;ng m&agrave;u như gỗ sồi hay gỗ th&ocirc;ng thường được ưu ti&ecirc;n v&igrave; ch&uacute;ng dễ d&agrave;ng kết hợp với mọi phong c&aacute;ch nội thất từ cổ điển đến hiện đại. Việc ngắm nh&igrave;n những cuốn s&aacute;ch được xếp ngay ngắn tr&ecirc;n kệ gỗ tự nhi&ecirc;n lu&ocirc;n mang lại một cảm gi&aacute;c b&igrave;nh y&ecirc;n v&agrave; th&ocirc;i th&uacute;c ch&uacute;ng ta d&agrave;nh thời gian để đọc nhiều hơn.</p>\r\n<p data-path-to-node=\"6\"><strong>K&iacute;ch thước th&ocirc;ng dụng để bạn tham khảo:</strong></p>\r\n<ul data-path-to-node=\"7\">\r\n<li>\r\n<p data-path-to-node=\"7,0,0\"><strong>Chiều rộng:</strong> 80 cm (dễ d&agrave;ng đặt v&agrave;o c&aacute;c g&oacute;c tường hẹp).</p>\r\n</li>\r\n<li>\r\n<p data-path-to-node=\"7,1,0\"><strong>Chiều cao:</strong> 180 cm (tận dụng kh&ocirc;ng gian ph&iacute;a tr&ecirc;n để chứa được nhiều s&aacute;ch).</p>\r\n</li>\r\n<li>\r\n<p data-path-to-node=\"7,2,0\"><strong>Chiều s&acirc;u:</strong> 30 cm (vừa đủ cho c&aacute;c khổ s&aacute;ch th&ocirc;ng thường m&agrave; kh&ocirc;ng l&agrave;m tốn diện t&iacute;ch ph&ograve;ng).</p>\r\n</li>\r\n</ul>\r\n<p data-path-to-node=\"8\">Một chiếc tủ s&aacute;ch đẹp kh&ocirc;ng chỉ l&agrave;m đẹp ng&ocirc;i nh&agrave;, m&agrave; c&ograve;n l&agrave; nguồn động lực để bạn duy tr&igrave; th&oacute;i quen đọc s&aacute;ch mỗi ng&agrave;y, gi&uacute;p t&acirc;m hồn th&ecirc;m phong ph&uacute; sau những giờ l&agrave;m việc mệt mỏi.</p>','post_featured_20251217144712_YkZ9O867.jpg',NULL,1,0,1,'2025-12-17 07:47:12','2025-12-17 07:47:12');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptions` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_percent` int NOT NULL DEFAULT '0',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `view_count` int NOT NULL DEFAULT '0',
  `image_url` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `ar_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `ar_model_glb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_model_usdz` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_model_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ar_placement_instructions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width_cm` decimal(8,2) DEFAULT NULL,
  `height_cm` decimal(8,2) DEFAULT NULL,
  `depth_cm` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_price_index` (`category_id`,`price`),
  KEY `products_view_count_index` (`view_count`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (17,'1919 Armchair','1919 Armchair được đặt tên theo năm nó được thiết kế, thực tế được lưu trữ với mã “128”. Người ta cho rằng nó được Renzo Frau thiết kế riêng cho Filiberto Ludovico của Savoy, Công tước Pistoia. Mặc dù được ủy quyền bởi một khách hàng cụ thể nhưng nó đã trở thành một trong những thành công đầu tiên và lớn nhất trước công chúng. Việc tái hiện lại mẫu bergère cổ điển, so với mẫu “1919” tiền thân, đã bổ sung thêm sức mạnh của capitonné đặc trưng của nó, được sử dụng cho phần tựa lưng.',80.00,10,22,0,'1765951197.jpg',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-16 22:59:57','2025-12-16 22:59:57'),(18,'Sofa Luna','Nâng tầm phòng khách với thiết kế Sofa Luna hiện đại, kết hợp hoàn hảo giữa chất liệu vải cao cấp và đệm mút êm ái. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thư giãn tuyệt đối cho gia đình bạn.',90.00,15,45,6,'1765951966.png',1,1,'seatings/sofa_luna_ar_2025_12_17_06_40_16_jlZMGx.glb',NULL,NULL,NULL,210.00,80.00,85.00,'2025-12-16 23:12:48','2025-12-17 06:40:30'),(19,'Armchair Haifa','Nâng tầm không gian làm việc hoặc thư giãn với thiết kế Luxury Chair hiện đại, kết hợp hoàn hảo giữa chất liệu da cao cấp và đệm mút đàn hồi. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thư giãn tuyệt đối.',60.00,8,56,35,'1765955346.jpg',1,1,'seatings/armchair_haifa_ar_2025_12_17_13_48_10_OBw2uO.glb',NULL,NULL,NULL,75.00,110.00,70.00,'2025-12-17 00:09:06','2025-12-17 07:48:06'),(20,'Sweety Chair','Nâng tầm không gian sống với thiết kế Sweety Chair hiện đại, kết hợp hoàn hảo giữa chất liệu vải nỉ mềm mại và đệm mút êm ái. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thư giãn tuyệt đối cho người sử dụng.',50.00,0,45,14,'1765956398.jpg',1,1,'seatings/sweety_chair_ar_2025_12_17_07_26_38_A0Z7hN.glb',NULL,NULL,NULL,75.00,110.00,70.00,'2025-12-17 00:26:38','2025-12-17 08:33:33'),(21,'Classic Sofa','Nâng tầm phòng khách với thiết kế Classic Sofa cổ điển, kết hợp hoàn hảo giữa chất liệu da bò sang trọng và đệm mút cao cấp. Sản phẩm mang lại sự đẳng cấp, bền bỉ và cảm giác thư giãn tuyệt đối cho không gian sống của bạn.',120.00,15,24,2,'1765956638.jpg',1,1,'seatings/classic_sofa_ar_2025_12_17_07_30_38_KnjLSN.glb',NULL,NULL,NULL,240.00,80.00,75.00,'2025-12-17 00:30:38','2025-12-17 06:40:36'),(22,'Smooth Chair','Nâng tầm góc thư giãn với thiết kế Smooth Chair hiện đại, kết hợp hoàn hảo giữa chất liệu vải cao cấp và đệm mút êm ái. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thư giãn tuyệt đối cho không gian của bạn.',55.00,15,37,11,'1765957106.jpg',1,1,'seatings/smooth_chair_ar_2025_12_17_07_38_26_r7Cd96.glb',NULL,NULL,NULL,70.00,85.00,75.00,'2025-12-17 00:38:26','2025-12-17 08:44:27'),(23,'Dining Table','Nâng tầm không gian bếp với thiết kế Dining Table hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên cao cấp và bề mặt hoàn thiện tinh xảo. Sản phẩm mang lại sự sang trọng, bền bỉ và không gian ấm cúng tuyệt đối cho bữa ăn gia đình.',60.00,5,18,3,'1765959929.jpg',2,1,'tables/dining_table_ar_2025_12_17_08_25_29_awLc7U.glb',NULL,NULL,NULL,160.00,75.00,80.00,'2025-12-17 01:25:29','2025-12-17 06:41:39'),(24,'Modern Elegant Chair and Table','Nâng tầm không gian với bộ Modern Elegant Chair and Table, kết hợp hoàn hảo giữa khung kim loại thanh mảnh và mặt gỗ cao cấp. Sản phẩm mang lại sự sang trọng, bền bỉ và vẻ đẹp tinh tế, hiện đại cho ngôi nhà của bạn.',60.00,12,26,3,'1765973223.png',2,1,'tables/modern_elegant_chair_and_table_ar_2025_12_17_12_07_03_v3wuWh.glb',NULL,NULL,NULL,120.00,75.00,60.00,'2025-12-17 05:07:03','2025-12-17 07:30:23'),(25,'Wood desk','Nâng tầm không gian làm việc với thiết kế Wood Desk hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên cao cấp và đường nét tinh xảo. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác cảm hứng tuyệt đối cho mọi nhiệm vụ hàng ngày.',40.00,5,33,14,'1765977419.png',2,1,'tables/wood_desk_ar_2025_12_17_13_16_59_0Trog6.glb',NULL,NULL,NULL,140.00,75.00,70.00,'2025-12-17 06:16:59','2025-12-17 07:30:06'),(26,'TV Cabinet v1','Nâng tầm không gian giải trí với thiết kế TV Cabinet v1 hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ công nghiệp cao cấp và khung chân chắc chắn. Sản phẩm mang lại sự sang trọng, bền bỉ và giải pháp lưu trữ ngăn nắp cho phòng khách của bạn.',55.00,8,8,13,'1765977651.jpg',2,1,'tables/tv_cabinet_v1_ar_2025_12_17_13_20_51_LUVOla.glb',NULL,NULL,NULL,180.00,45.00,40.00,'2025-12-17 06:20:51','2025-12-17 07:31:41'),(27,'TV Stand','Nâng tầm không gian giải trí với thiết kế TV Stand Furniture hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ bền bỉ và các ngăn lưu trữ thông minh. Sản phẩm mang lại sự sang trọng, tinh tế và vẻ đẹp gọn gàng cho phòng khách của bạn.',120.00,10,10,6,'1765978414.jpg',3,1,'storages/tv_stand_ar_2025_12_17_13_33_34_YLrn2P.glb',NULL,NULL,NULL,160.00,50.00,40.00,'2025-12-17 06:33:34','2025-12-17 07:20:20'),(28,'Hayama Cabinet','Nâng tầm không gian lưu trữ với thiết kế Hayama Cabinet hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ tự nhiên tối màu và các chi tiết kim loại tinh tế. Sản phẩm mang lại sự sang trọng, bền bỉ và vẻ đẹp gọn gàng, ngăn nắp cho ngôi nhà của bạn.',120.00,0,10,0,'1765978597.webp',3,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-17 06:36:37','2025-12-17 06:36:37'),(29,'ROLLER','Nâng tầm không gian làm việc với thiết kế ROLLER hiện đại, kết hợp hoàn hảo giữa chất liệu lưới thoáng khí và khung chân xoay linh hoạt. Sản phẩm mang lại sự sang trọng, bền bỉ và cảm giác thoải mái tuyệt đối cho suốt ngày dài làm việc.',90.00,5,10,0,'1765978661.jpg',3,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-17 06:37:41','2025-12-17 06:37:41'),(30,'Saqris Bar Cabinet','Nâng tầm không gian giải trí với thiết kế Saqris Bar Cabinet hiện đại, kết hợp hoàn hảo giữa chất liệu gỗ cao cấp và mặt kính tinh tế. Sản phẩm mang lại sự sang trọng, bền bỉ và giải pháp lưu trữ rượu, ly tách ngăn nắp cho ngôi nhà của bạn.',120.00,5,20,0,'1765978706.jpg',3,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-12-17 06:38:26','2025-12-17 06:38:26');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_order_id_foreign` (`order_id`),
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin','manager') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@gmail.com',NULL,'$2y$12$TVzRpKUCu4xc5oizV2fNMuKM8ReifSopIMLLdRxaurO2YZhtwppTC','admin',NULL,'2025-10-09 05:09:37','2025-12-16 22:48:01'),(2,'Nguyen Trung Nghia','assassincreed2k1@gmail.com',NULL,'$2y$12$BjXFJ9zQXnPqHYUVxBVhE.AxEDC/Q0utWgwSgdGh0M4TkSa8R19T6','admin',NULL,'2025-12-16 22:41:00','2025-12-16 22:41:00');
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

-- Dump completed on 2025-12-17 22:50:05
