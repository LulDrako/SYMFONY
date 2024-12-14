-- MariaDB dump 10.19-11.1.0-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: symfony
-- ------------------------------------------------------
-- Server version	11.1.0-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `symfony`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `symfony` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `symfony`;

--
-- Table structure for table `car`
--

DROP TABLE IF EXISTS `car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_773DE69DA76ED395` (`user_id`),
  CONSTRAINT `FK_773DE69DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car`
--

LOCK TABLES `car` WRITE;
/*!40000 ALTER TABLE `car` DISABLE KEYS */;
/*!40000 ALTER TABLE `car` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES ('DoctrineMigrations\\Version20241103174423','2024-11-03 17:45:02',120),
('DoctrineMigrations\\Version20241103180057','2024-11-03 18:01:01',28),
('DoctrineMigrations\\Version20241113085548','2024-11-13 08:55:53',695),
('DoctrineMigrations\\Version20241114142030','2024-11-14 14:26:09',102),
('DoctrineMigrations\\Version20241204184838','2024-12-04 18:48:44',125);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paiements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `voiture_id` int(11) NOT NULL,
  `methode_paiement` varchar(255) NOT NULL,
  `statut` varchar(50) NOT NULL,
  `numeroCarteBleu` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E1B02E12A76ED395` (`user_id`),
  KEY `IDX_E1B02E12181A8BA` (`voiture_id`),
  CONSTRAINT `FK_E1B02E12181A8BA` FOREIGN KEY (`voiture_id`) REFERENCES `voitures` (`id`),
  CONSTRAINT `FK_E1B02E12A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paiements`
--

LOCK TABLES `paiements` WRITE;
/*!40000 ALTER TABLE `paiements` DISABLE KEYS */;
INSERT INTO `paiements` (`id`, `montant`, `user_id`, `voiture_id`, `methode_paiement`, `statut`, `numeroCarteBleu`) VALUES (1,15000.00,1,1,'carte','en attente','2345678123456'),
(2,15000.00,2,1,'carte','en attente','2345678123456'),
(3,18000.00,3,4,'carte','en attente','2345678123456'),
(4,15500.00,2,2,'carte','en attente','2345678123456'),
(5,25000.00,3,3,'paypal','en attente','12345678'),
(6,22000.00,1,5,'carte','en attente','09876546789'),
(7,30500.00,1,1,'carte','en attente','09876546789'),
(8,70000.00,3,6,'paypal','en attente','09876546789'),
(9,45000.00,1,6,'carte','en attente','32132131321321'),
(10,15000.00,9,1,'carte','en attente','32132131321321');
/*!40000 ALTER TABLE `paiements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(180) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `password`, `email`) VALUES (1,'Alice Dupont','hashed_password1','alice.dupont@example.com'),
(2,'Bob Martin','hashed_password2','bob.martin@example.com'),
(3,'Caroline Leroy','hashed_password3','caroline.leroy@example.com'),
(6,'rosa','$2y$13$8cP2qmOloSuuhkOgj4bf5uwf.mWK2qDlPkTFuiKGNDHp68WrNRKMe','rosa@rosa'),
(7,'Ervin','$2y$13$nkux2cIf3tMALdOkqJ9UbOkZnPJ12F4GqB6rw.Jl/a6lnNw86DEsS','ervin@goby.com'),
(8,'FEKI','$2y$13$8i.nIJfmvC76zz1TZBhRVOr8DYEb2/L7EAXkiqdEFKHY9l7aEjJm.','feki@feki'),
(9,'ilyes','$2y$13$2u66TmQ/AtrlxoQTLhm3kOnewzxvqVuIUjuVr32b5mFcCVpm6hfRi','ilyes@i');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voitures`
--

DROP TABLE IF EXISTS `voitures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voitures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) NOT NULL,
  `annee` int(11) NOT NULL,
  `kilometrage` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image_url` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voitures`
--

LOCK TABLES `voitures` WRITE;
/*!40000 ALTER TABLE `voitures` DISABLE KEYS */;
INSERT INTO `voitures` (`id`, `marque`, `modele`, `annee`, `kilometrage`, `prix`, `image_url`) VALUES (1,'Renault','Clio 5',2023,10000,15000.00,'https://cdnwp.dealerk.com/d0713c4e/uploads/sites/175/2023/04/face-avant-nouvelle-renault-clio-5-480x270.jpg'),
(2,'Peugeot','308',2020,30000,15500.00,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRR7uEbptL3y1bGR-60LWYvGulpvefUEb8z4w&s'),
(3,'BMW','Série 3',2019,50000,25000.00,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTicswMKf4-QNe40y8An8_yZbG3EFoDwrSeBQ&s'),
(4,'Ford','Focus',2021,20000,18000.00,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS22V8u0yhhnmVppjjnZTbAO_Ryun8ShAu6Qw&s'),
(5,'Volkswagen','Golf',2022,10000,22000.00,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9jkhJcrIyQc1lAe9lGm7t-cUkps1KUNGMFQ&s'),
(6,'Nissan','Qashqai',2023,5000,30000.00,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGXYdlgrk-Re8WWmOs0a_ZPFaBz8WXGlP8zQ&s'),
(11,'Toyota','RAV4',2023,10000,35000.00,'https://scene7.toyota.eu/is/image/toyotaeurope/car-chapter-rav4-30-ans:Large-Landscape?ts=1724771486327&resMode=sharp2&op_usm=1.75,0.3,2,0'),
(13,'Ferrari','488 Spider',2021,5000,250000.00,'https://i.postimg.cc/hPz8pDZB/5ea97d2ec5219c37796367f0-05-ferrari-195-inter-touring-coup-488-spider-esterni.avif');
/*!40000 ALTER TABLE `voitures` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-15  0:06:48
