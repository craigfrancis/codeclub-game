-- MariaDB dump 10.19-11.3.2-MariaDB, for osx10.19 (x86_64)
--
-- Host: localhost    Database: s-codeclub-game
-- ------------------------------------------------------
-- Server version	11.3.2-MariaDB

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
-- Table structure for table `world_boa`
--

DROP TABLE IF EXISTS `world_boa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_boa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `army` tinytext NOT NULL,
  `owner` tinytext NOT NULL,
  `battalions` tinytext NOT NULL,
  `created` datetime NOT NULL,
  `edited` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_boa`
--

LOCK TABLES `world_boa` WRITE;
/*!40000 ALTER TABLE `world_boa` DISABLE KEYS */;
INSERT INTO `world_boa` VALUES
(1,'Brittons','Queen Elizabeth II \'s family','12','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,'Minoans','Minors','6500','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,'Mongolains','Mongos','-1','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(4,'Babylonians','Babies','484686','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(5,'Saxons','Potato Sacks','16','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(6,'Greeks','Greedy People','76768767','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(7,'Vikings','People With Horn Helmets','15','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(8,'Aztects','Aztecnical Stuff','78463658','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `world_boa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_game_army`
--

DROP TABLE IF EXISTS `world_game_army`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_game_army` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `army_colour` varchar(6) NOT NULL DEFAULT '',
  `army_name` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `army_colour` (`army_colour`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_game_army`
--

LOCK TABLES `world_game_army` WRITE;
/*!40000 ALTER TABLE `world_game_army` DISABLE KEYS */;
INSERT INTO `world_game_army` VALUES
(1,'0000DD','Brittons'),
(2,'005080','Minoans'),
(3,'007000','Mongolians'),
(4,'08B828','Babylonians'),
(5,'500864','Saxons'),
(6,'9090E4','Greeks'),
(7,'940437','Vikings'),
(8,'C88624','Aztecs'),
(9,'D00808','Romans'),
(10,'D0D0D0','Huns'),
(11,'F0B080','Phoenicians'),
(12,'FF6040','Persians'),
(13,'FF90FF','Japanese'),
(14,'FFA811','Egyptians'),
(15,'FFFF00','Byzantines'),
(16,'00acff','Maniacs');
/*!40000 ALTER TABLE `world_game_army` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_owner`
--

DROP TABLE IF EXISTS `world_owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_owner` (
  `territory_id` int(11) NOT NULL,
  `army_id` int(11) NOT NULL,
  `battalions` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  UNIQUE KEY `territory_id` (`territory_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_owner`
--

LOCK TABLES `world_owner` WRITE;
/*!40000 ALTER TABLE `world_owner` DISABLE KEYS */;
INSERT INTO `world_owner` VALUES
(1,3,30,'2024-05-16 17:53:51','0000-00-00 00:00:00'),
(2,5,40,'2024-05-16 17:59:24','0000-00-00 00:00:00'),
(5,5,40,'2024-05-16 18:00:40','0000-00-00 00:00:00'),
(5,5,40,'2024-05-16 18:00:11','2024-05-16 18:00:38'),
(7,1,70,'2024-05-16 18:03:40','0000-00-00 00:00:00'),
(8,1,91,'2024-05-16 18:04:55','2024-05-16 18:06:57');
/*!40000 ALTER TABLE `world_owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_territories`
--

DROP TABLE IF EXISTS `world_territories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_territories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `battalions` int(10) unsigned NOT NULL,
  `owner` tinytext NOT NULL,
  `army` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_territories`
--

LOCK TABLES `world_territories` WRITE;
/*!40000 ALTER TABLE `world_territories` DISABLE KEYS */;
INSERT INTO `world_territories` VALUES
(1,'Great Britain',10,'Craig','MyArmy'),
(2,'Western Europe',5,'Craig','MyArmy'),
(3,'Southern Europe',5,'Craig','MyArmy'),
(4,'Northern Europe',5,'Craig','MyArmy'),
(5,'Ukraine',5,'Craig','MyArmy'),
(6,'Scandinavia',5,'Craig','MyArmy'),
(7,'Iceland',5,'Craig','MyArmy'),
(8,'Afghanistan',5,'Craig','MyArmy'),
(9,'Middle East',5,'Craig','MyArmy'),
(10,'India',5,'Craig','MyArmy'),
(11,'China',5,'Craig','MyArmy'),
(12,'Mongolia',5,'Craig','MyArmy'),
(13,'Ural',5,'Craig','MyArmy'),
(14,'Siberia',5,'Craig','MyArmy'),
(15,'Irkutsk',5,'Craig','MyArmy'),
(16,'Kamchatka',5,'Craig','MyArmy'),
(17,'Yakutsk',5,'Craig','MyArmy'),
(18,'Japan',5,'Craig','MyArmy'),
(19,'Siam',5,'Craig','MyArmy'),
(20,'Egypt',5,'Craig','MyArmy'),
(21,'North Africa',5,'Craig','MyArmy'),
(22,'East Africa',5,'Craig','MyArmy'),
(23,'Congo',5,'Craig','MyArmy'),
(24,'South Africa',5,'Craig','MyArmy'),
(25,'Madagascar',5,'Craig','MyArmy'),
(26,'Indonesia',5,'Craig','MyArmy'),
(27,'New Guinea',5,'Craig','MyArmy'),
(28,'Eastern Australia',5,'Craig','MyArmy'),
(29,'Western Australia',5,'Craig','MyArmy'),
(30,'Greenland',5,'Craig','MyArmy'),
(31,'Quebec',5,'Craig','MyArmy'),
(32,'Eastern United States',5,'Craig','MyArmy'),
(33,'Ontario',5,'Craig','MyArmy'),
(34,'Northwest Territory',5,'Craig','MyArmy'),
(35,'Alberta',5,'Craig','MyArmy'),
(36,'Western United States',5,'Craig','MyArmy'),
(37,'Alaska',5,'Craig','MyArmy'),
(38,'Central America',5,'Craig','MyArmy'),
(39,'Venezuela',5,'Craig','MyArmy'),
(40,'Brazil',5,'Craig','MyArmy'),
(41,'Peru',5,'Craig','MyArmy'),
(42,'Argentina',5,'Craig','MyArmy');
/*!40000 ALTER TABLE `world_territories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-16 22:31:05
