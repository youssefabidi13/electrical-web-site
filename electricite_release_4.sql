-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: electricite_release_4
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `zone_number` int NOT NULL,
  `fournisseur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fournisseur_id` (`fournisseur_id`),
  CONSTRAINT `agent_ibfk_1` FOREIGN KEY (`fournisseur_id`) REFERENCES `manager` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent`
--

LOCK TABLES `agent` WRITE;
/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
INSERT INTO `agent` VALUES (1,'youssef','abidi','youssef@gmail.com','123456',1,1),(2,'ucef','ucef','ucef@gmail.com','123456',2,1),(3,'mohamed','mohamed','mohamed@gmail.com','123456',3,1),(4,'mohcine','mohcine','mohcine@gmail.com','123456',4,2),(5,'mouad','mouad','mouad@gmail.com','123456',5,2),(6,'reda','reda','reda@gmail.com','123456',6,3);
/*!40000 ALTER TABLE `agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `agent_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `agent_id` (`agent_id`),
  CONSTRAINT `client_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'yacine','yacine123','123456','yacine@gmail.com',1),(2,'youssef','alla','123456','youssefyoussef@gmail.com',2),(3,'leo ','messi','123456','leo@gmail.com',1),(4,'diego','maradona','123456','diego@gmail.com',1),(5,'juan','riquelmi','123456','juan@gmail.com',1),(6,'cristiano','ronaldo','123456','cr7@gmail.com',2),(7,'luka','modric','123456','luka@gmail.com',2),(8,'toni','kroos','123456','toni@gmail.com',2),(9,'philipo','inzaghi','123456','philipo@gmail.com',3),(10,'andrea','pirlo','123456','andrea@gmail.com',3),(11,'paolo','maldini','123456','paolo@gmail.com',3),(12,'franko','barezzi','123456','barezzi@gmail.com',3),(13,'khalil','khalil','123456','khalil@gmail.com',3),(14,'leo','messi','123456','leo@gmail.com',1),(15,'diego','maradona','123456','diego@gmail.com',1),(16,'cristiano','ronaldo','123456','cr7@gmail.com',2),(17,'luka','modric','123456','luka@gmail.com',2),(18,'filipo','inzaghi','123456','philipo@gmail.com',3),(19,'andrea','pirlo','123456','andrea@gmail.com',3);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consommation_annuelle`
--

DROP TABLE IF EXISTS `consommation_annuelle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consommation_annuelle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `consommation` decimal(10,2) NOT NULL,
  `annee` int NOT NULL,
  `agent_ID` int DEFAULT NULL,
  `status` enum('egale','superieur','inferieur') DEFAULT NULL,
  `date_saisie` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `decalage` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `agent_ID` (`agent_ID`),
  CONSTRAINT `consommation_annuelle_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`ID`),
  CONSTRAINT `consommation_annuelle_ibfk_2` FOREIGN KEY (`agent_ID`) REFERENCES `agent` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consommation_annuelle`
--

LOCK TABLES `consommation_annuelle` WRITE;
/*!40000 ALTER TABLE `consommation_annuelle` DISABLE KEYS */;
/*!40000 ALTER TABLE `consommation_annuelle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facture`
--

DROP TABLE IF EXISTS `facture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `consommation_monsuelle` decimal(10,2) NOT NULL,
  `mois` int NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `date_saisie` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status_f` enum('payee','non_payee') NOT NULL DEFAULT 'non_payee',
  `prix_HT` decimal(10,2) DEFAULT NULL,
  `prix_TTC` decimal(10,2) DEFAULT NULL,
  `annee` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facture`
--

LOCK TABLES `facture` WRITE;
/*!40000 ALTER TABLE `facture` DISABLE KEYS */;
INSERT INTO `facture` VALUES (4,1,1800.00,12,'640471b18419a6.47972294.jpg','2023-03-05 10:49:15','non_payee',453.00,500.00,2022),(8,3,1800.00,12,'640471b18419a6.47972294.jpg','2023-03-05 12:09:11','non_payee',500.00,620.00,2022),(9,4,1850.00,12,'640471b18419a6.47972294.jpg','2023-03-05 12:09:11','non_payee',490.00,500.00,2022),(10,5,2600.00,12,'640471b18419a6.47972294.jpg','2023-03-05 12:09:11','non_payee',700.00,720.00,2022);
/*!40000 ALTER TABLE `facture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manager` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` int NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manager`
--

LOCK TABLES `manager` WRITE;
/*!40000 ALTER TABLE `manager` DISABLE KEYS */;
INSERT INTO `manager` VALUES (1,'admin@gmail.com',61900000,'123456'),(2,'admin2@gmail.com',12421314,'123456'),(3,'admin3@gmail.com',12321343,'123456');
/*!40000 ALTER TABLE `manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reclamation`
--

DROP TABLE IF EXISTS `reclamation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reclamation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `contenue` longtext NOT NULL,
  `date_saisie` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fournisseur_id` int DEFAULT NULL,
  `status` enum('false','true') DEFAULT 'false',
  `contenue_reponse` longtext,
  `type_rec` enum('Fuite externe','Fuite interne','Facture','Autre') NOT NULL,
  `autre_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `fournisseur_id` (`fournisseur_id`),
  CONSTRAINT `reclamation_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`ID`),
  CONSTRAINT `reclamation_ibfk_2` FOREIGN KEY (`fournisseur_id`) REFERENCES `manager` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reclamation`
--

LOCK TABLES `reclamation` WRITE;
/*!40000 ALTER TABLE `reclamation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reclamation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-05 13:17:33
