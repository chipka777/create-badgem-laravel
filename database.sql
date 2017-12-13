-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: badgem
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `visibility` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'testing',NULL,'2017-11-17 09:49:48',1),(2,'sdfsdf',NULL,'2017-11-16 21:09:12',0),(3,'sdfsdf',NULL,'2017-11-16 21:09:15',0),(4,'sdfssfsdfdsf',NULL,NULL,1),(5,'Cartoons',NULL,NULL,1),(6,'The Good Kids',NULL,NULL,1),(7,'Flags',NULL,NULL,1),(8,'Celeb Badges',NULL,NULL,1),(9,'Looney Tunes',NULL,NULL,1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (2,'bradley1.png',1,8,'Name Tag','Bradley Cooper',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(3,'Bradley_Cooper02.png',1,0,'Celebrity Art','Bradley Cooper',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(4,'Leverkusen Border.png',1,0,'Futbol','Leverkusen',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(5,'afc-Bournemouth-Border.png',1,0,'Futbol','Bournemouth',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(6,'Crystal-Palace-FC-Border.png',1,0,'Futbol','Crystal Palace',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(7,'Huddersfield-Town-Border.png',1,0,'Futbol','Huddersfield Town',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(8,'curry1.png',1,8,'Name Tag','Steph Curry',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(9,'kanye02.png',1,0,'Celebrity Art','Kanye',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(10,'portland.png',1,0,'NBA','Portland Trailblazers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(11,'Tiger02.png',1,0,'Celebrity Art','Tiger Woods',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(12,'timberwolves.png',1,0,'NBA','Minnesota Timberwolves',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(13,'wizards07.png',1,0,'NBA','Washington Wizards',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(14,'thunder.png',1,0,'NBA','Oklahoma City Thunder',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(15,'walter1.png',1,8,'Name Tag','Walter White',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(16,'tupac1.png',1,8,'Name Tag','Tupac Shakur',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(17,'ryan1.png',1,8,'Name Tag','Ryan Gosling',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(18,'nph1.png',1,8,'Name Tag','Neil Patrick Harris',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(19,'floyd1.png',1,8,'Name Tag','Floyd Mayweather',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(20,'nicholas1.png',1,8,'Name Tag','Nicholas Cage',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(21,'eminem1.png',1,8,'Name Tag, Eminem','Marshall Mathers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(22,'tiger2.png',1,8,'Name Tag','Tiger Woods',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(23,'gordon1.png',1,8,'Name Tag','Gordon Ramsey',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(24,'suns.png',1,0,'NBA','Phoenix Suns',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(25,'pistons.png',1,0,'NBA','Detroit Pistons',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(26,'spurs.png',1,0,'NBA','San Antonio Spurs',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(27,'jordan4.png',1,0,'Celebrity Art','Michael Jordan',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(28,'rockets.png',1,0,'NBA','Houston Rockets',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(29,'pelicans.png',1,0,'NBA','New Orleans Pelicans',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(30,'kim3.png',1,0,'Celebrity Art','Kim Kardashian',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(31,'Bradley_Cooper-04.png',1,0,'Celebrity Art','Bradly Cooper',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(32,'pacers.png',1,0,'NBA','Indiana Pacer',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(33,'snoop05.png',1,0,'Celebrity Art','Snoop Doggy Dog',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(34,'kanye04.png',1,0,'Celebrity Art','Kanye',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(35,'Heisenberg04.png',1,0,'Celebrity Art','Heisenberg',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(36,'nuggets.png',1,0,'NBA','Denver Nuggets',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(37,'nets.png',1,0,'NBA','Brooklyn Nets',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(38,'mavs.png',1,0,'NBA','Dallas Mavericks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(39,'clippers.png',1,0,'NBA','Los Angeles Clippers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(40,'magic.png',1,0,'NBA','Orlando Magic',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(41,'knicks.png',1,0,'NBA','New York Knicks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(42,'kings.png',1,0,'NBA','Sacramento Kings',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(43,'jazz.png',1,0,'NBA','Utah Jazz',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(44,'hornets.png',1,0,'NBA','Charlotte Hornets',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(45,'heat.png',1,0,'NBA','Miami Heat',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(46,'hawks.png',1,0,'NBA','Atlanta Hawks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(47,'grizzlies.png',1,0,'NBA','Memphis Grizzlies',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(48,'cavaliers.png',1,0,'NBA','Cleveland Cavaliers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(49,'bucks.png',1,0,'NBA','Milwaukee Bucks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(50,'76ers.png',1,0,'NBA','Philadelphia 76ers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(51,'Power_Up01.png',1,0,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(52,'babybugs.png',1,0,'Disney','Baby Bugs',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(53,'celtics.png',1,0,'NBA','Boston Celtics',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(54,'lakers2.png',1,0,'NBA','Los Angeles Lakers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(55,'jiggpuff.png',1,0,'Pokemon','Jigglypuff',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(56,'snorlax.png',1,0,'Pokemon','Snorlax',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(57,'littlepika.png',1,0,'Pokemon','Guitar Pika',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(58,'eevee.png',1,0,'Pokemon','Eevee',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(59,'meowth.png',1,0,'Pokemon','Meowth',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(60,'bulbasaur.png',1,0,'Pokemon','Bulbasaur',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(61,'gorilla.png',1,0,'Animal','Gorilla',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(62,'pussinboots.png',1,0,'Musketeer','Puss in Boots',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(63,'sheep.png',1,0,'Animal','Sheep',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(64,'elephant.png',1,0,'Animal','Elephant',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(65,'Girona-FC-Border.png',1,0,'Futbol','Girona FC',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(67,'Beltis Border.png',1,0,'Futbol','Beltis',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(68,'Celta Border.png',1,0,'Futbol','Celta',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(69,'La-Coruna-Border.png',1,0,'Futbol','La Coruna',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(70,'Las-Palmas-Border.png',1,0,'Futbol','Las Palmas',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(71,'Osasuna-Border.png',1,0,'Futbol','Osasuna',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(72,'Real-Madrid-Border.png',1,0,'Futbol','Real Madrid',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(73,'minnie2.png',1,0,'Disney','Minnie Mouse',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(74,'S.D.-Eibar-Border.png',1,0,'Futbol','S.D. Eibar',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(75,'Sportinggijon Border.png',1,0,'Futbol','Sportinggijon',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(76,'Vallodolid Border.png',1,0,'Futbol','Vallodilad',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(77,'Villarreal Border.png',1,0,'Futbol','Villareal',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(78,'goofy.png',1,0,'Disney','Goofy',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(79,'Manchester-United-Border.png',1,0,'Futbol','Manchester United ',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(80,'Middlesbrough-Border.png',1,0,'Futbol','MIddlesbrough',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(81,'covered.png',1,0,'Fun Adults','I Got You Covered',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(82,'kanye1.png',1,8,'Name Tag','Kanye West',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(83,'drake1.png',1,8,'Name Tag','Drizzy Drake',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(84,'jordan1.png',1,8,'Name Tag','Michael Jordan',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(85,'emilia.png',1,8,'Name Tag','Emilia Clarke',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(86,'duck1.png',1,0,'Disney','Donald Duck',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(87,'pluto1.png',1,0,'Disney','Pluto',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(88,'avalanche.png',1,0,'NHL','Colorado Avalanche',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(89,'badass4.png',1,0,'Pop Art','Badass',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(90,'ducks.png',1,0,'Disney','Ducks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(91,'kinglazyfuck10.png',1,0,'Pop Art','King Lazy Fuck',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(92,'lola.png',1,0,'Disney','Lola Bunny',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(93,'babytaz.png',1,0,'Disney','Baby Taz',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(94,'skunk.png',1,0,'Disney','Skunk',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(95,'raptorshield.png',1,0,'NBA','Toronto Raptors',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(96,'puffwhale.png',1,0,'Pop Art','Puff The Magic Whale',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(97,'blackhawks.png',1,0,'NHL','Chicago Blackhawks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(98,'stars.png',1,0,'NHL','Dallas Stars',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(99,'friendzone_05.png',1,0,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(100,'thrashers.png',1,0,'NHL','Atlanta Thrashers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(101,'coyotes.png',1,0,'NHL','Phoenix Coyotes',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(102,'hurricane1.png',1,0,'NHL','Carolina Hurricane',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(103,'panthers1.png',1,0,'NHL','Florida Panthers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(104,'goldenknights1.png',1,0,'NHL','Las Vegas Golden Knigts',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(105,'blues.png',1,0,'NHL','St Louis Blues',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(106,'sharks.png',1,0,'NHL','San Jose Sharks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(107,'bluejackets.png',1,0,'NHL','Columbus Blue Jackets',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(108,'lightning.png',1,0,'NHL','Tampa Bay Lightning',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(109,'devils.png',1,0,'NHL','New Jersey Devils',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(110,'predators.png',1,0,'NHL','Nashville Predators',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(112,'thegoodkids11.png',1,6,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(113,'thegoodkids12.png',1,6,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(114,'thegoodkids13.png',1,6,'','Thegoodkids',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(115,'lakings.png',1,0,'NHL','Los Angeles Kings',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(116,'wild.png',1,0,'NHL','Minnesota Wild',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(117,'sabres.png',1,0,'NHL','Buffalo Sabres',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(118,'capitals.png',1,0,'NHL','Washington Capitals',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(119,'anaheimducks.png',1,0,'NHL','Anaheim Ducks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(120,'senators.png',1,0,'NHL','Ottawa Senators',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(121,'jets.png',1,0,'NHL','Winnepeg Jets',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(122,'flames.png',1,0,'NHL','Calgary Flames',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(123,'redwings.png',1,0,'NHL','Detroit Red Wings',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(124,'flyers.png',1,0,'NHL','Philadelphia Flyers',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(125,'mapleleafs.png',1,0,'NHL','Toronto Maple Leafs',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(126,'Moghreb-Final-Border.png',1,0,'Futbol','Moghreb',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(127,'canucks.png',1,0,'NHL','Vancouver Canucks',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(128,'liverpool copy 1.png',1,0,'Futbol','Liverpool',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(129,'bostonbruins.png',1,0,'NHL','Boston Bruins',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(130,'thegoodkids18.png',1,6,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(131,'TGK_KKK_05.png',1,6,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(132,'TGK_Halloween_03.png',1,6,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(133,'Bugs-Bunny Final.png',1,9,'Looney Tunes','Bugs Bunny',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(134,'Yosemite-Sam-Final.png',1,9,'Looney Tunes','Yosemite Sam',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(135,'Tweety-Final.png',1,9,'Looney Tunes','Tweety Bird',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(136,'Tazmanian-Devil-Final.png',1,9,'Looney Tunes','Tazmanian Devil',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(137,'Wile-E-Coyote-Final.png',1,9,'Looney Tunes','Wile E Coyote',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(138,'Pepe-Le-Pew-Final.png',1,9,'Looney Tunes','Pepe Le Pew',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(139,'Martin-the-Martian-Final.png',1,9,'Looney Tunes','Martin the Martian ',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(140,'TGK_Dora_05.png',1,6,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(141,'thegoodkids19.png',1,6,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(142,'Von-Vulture-Final.png',1,9,'Looney Tunes','Von Vulture',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(143,'Daffy-Duck-Final.png',1,9,'Looney Tunes','Daffy Duck ',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(144,'Foghorn-Leghorn-Final.png',1,9,'Looney Tunes','Foghorn Leghorn',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(145,'Belgium-Flag-Final.png',1,7,'Flags','Belgium National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(146,'Brazil-Flag-Final.png',1,7,'Flags','Brazil National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(147,'Australia-Flag-Final.png',1,7,'Flags','Australia National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(148,'TGK_Kill_Panda.png',1,0,'','',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(149,'Cambodia-Flag-Final.png',1,7,'Flags','Cambodia National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(150,'Canada-Flag-Final.png',1,7,'Flags','Canada National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(151,'Columbia-Flag-Final.png',1,7,'Flags','Columbia National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(152,'China-Flag-Final.png',1,7,'Flags','China National Flag',1,'2017-11-08 11:17:12','2017-11-19 10:23:57'),(153,'Croatia-Flag-Final.png',1,7,'Flags','Croatia National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(154,'Cuba-Flag-Final.png',1,7,'Flags','Cuba National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(155,'Egypt-Flag-Final.png',1,7,'Flags','Egypt National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(156,'France-Flag-Final.png',1,7,'Flags','France National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(157,'jackiechan.png',1,8,'Name Tag','Jackie Chan',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(158,'marilyn.png',1,8,'Name Tag','Marilyn Monroe ',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(160,'Greece-Flag-Final.png',1,7,'Flags','Greece National Flag',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(161,'bradpitt.png',1,8,'Name Tag','Brad Pitt',1,'2017-11-08 11:17:12','2017-11-08 11:17:12'),(162,'leonardo.png',1,8,'Name Tag','Leonardo DiCaprio',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(163,'tomhardy.png',1,8,'Name Tag','Tom Hardy',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(164,'cena.png',1,8,'Name Tag','John Cena',1,'2017-11-08 11:17:13','2017-11-19 18:20:32'),(165,'India-Flag-Final.png',1,7,'Flags','India National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(166,'Ireland-Flag-Final.png',1,7,'Flags','Ireland National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(167,'Jamaica-Flag-Final.png',1,7,'Flags','Jamaica National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(168,'Japan-Flag-Final.png',1,7,'Flags','Japan National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(169,'Korea-Flag-Final.png',1,7,'Flags','Korea National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(170,'Mexico-Flag-Final.png',1,7,'Flags','Mexico National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(171,'Netherlands-Flag-Final.png',1,7,'Flags','Netherlands National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(172,'Norway-Flag-Final.png',1,7,'Flags','Norway National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(173,'Philippines-Flag-Final.png',1,7,'Flags','Philippines National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(174,'Russia-Flag-Final.png',1,7,'Flags','Russia National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(175,'Spain-Flag-Final.png',1,7,'Flags','Spain National Flag',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(180,'Vietnam-Flag-Final.png',1,7,'Flags','Vietnam National Flag',1,'2017-11-08 11:17:13','2017-11-19 10:39:40'),(181,'Argentina-Flag-Final.png',1,7,'Flags','Argentina National Flag',1,'2017-11-08 11:17:13','2017-11-18 13:54:01'),(183,'TGK_2.0-02.png',1,6,'','',1,'2017-11-08 11:17:13','2017-11-08 11:17:13'),(184,'dzmD3jwQ1L.jpeg',1,5,'','mE2AX7u7H08 - копия.jpg',1,'2017-11-19 16:31:33','2017-11-19 16:31:33'),(185,'Ne4NzXIHq0.jpeg',1,5,'','O42JoApyFOo.jpg',1,'2017-11-19 16:31:34','2017-11-19 16:31:34'),(186,'DtDdab6A4S.jpeg',1,5,'','S0kkD-lrQbE.jpg',1,'2017-11-19 16:31:35','2017-11-19 16:31:35'),(187,'wmmxfOmA5f.png',1,5,'','TGK_KKK_05 - копия.png',1,'2017-11-19 16:31:35','2017-11-19 16:31:35'),(190,'isdhynBF0D.png',1,5,'','site1.png',1,'2017-11-19 16:33:32','2017-11-19 16:33:32'),(192,'rnbUzMJEpx.jpeg',1,2,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 16:34:27','2017-11-19 16:34:27'),(193,'VWwYjnoRHS.png',1,2,'','site1.png',1,'2017-11-19 16:34:28','2017-11-19 16:34:28'),(194,'ejBEDC4W3k.png',1,2,'','TGK_KKK_05.png',1,'2017-11-19 16:34:29','2017-11-19 16:34:29'),(195,'I5x8m0GLXe.jpeg',1,6,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 16:41:10','2017-11-19 16:41:10'),(196,'tRIcqfx4S7.png',1,6,'','site1.png',1,'2017-11-19 16:41:11','2017-11-19 16:41:11'),(197,'g28dIRPQlE.png',1,6,'','TGK_KKK_05.png',1,'2017-11-19 16:41:13','2017-11-19 16:41:13'),(198,'uVBa9qlGrK.jpeg',1,4,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 16:42:29','2017-11-19 16:42:29'),(199,'z3lnYbCZgp.png',1,0,'','site1.png',1,'2017-11-19 16:45:34','2017-11-19 16:45:34'),(200,'AJneD8kwnd.png',1,0,'','TGK_KKK_05.png',1,'2017-11-19 16:47:14','2017-11-19 16:47:14'),(201,'P2iQNNyWFV.jpeg',1,0,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 16:47:58','2017-11-19 16:47:58'),(202,'XHorLSCa1i.png',1,0,'','site1.png',1,'2017-11-19 16:50:32','2017-11-19 16:50:32'),(203,'lxjYWBagKi.png',1,0,'','site1.png',1,'2017-11-19 16:51:16','2017-11-19 16:51:16'),(204,'Hru41BLFSI.png',1,0,'','site1.png',1,'2017-11-19 16:51:30','2017-11-19 16:51:30'),(205,'6sZEmSYUQU.jpeg',1,0,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 16:51:35','2017-11-19 16:51:35'),(206,'C8TDr4Tqtu.jpeg',1,0,'','mE2AX7u7H08.jpg',1,'2017-11-19 16:56:12','2017-11-19 16:56:12'),(207,'QWHoNtCGlR.jpeg',1,0,'','mE2AX7u7H08.jpg',1,'2017-11-19 16:56:37','2017-11-19 16:56:37'),(208,'tbwwUmujbz.png',1,0,'','site1.png',1,'2017-11-19 16:56:50','2017-11-19 16:56:50'),(209,'jfhfyurYWf.png',1,0,'','site1.png',1,'2017-11-19 16:57:26','2017-11-19 16:57:26'),(210,'XgZwVWmCeu.png',1,0,'','site1.png',1,'2017-11-19 16:57:40','2017-11-19 16:57:40'),(211,'65nTcjUEVV.png',1,0,'','site1.png',1,'2017-11-19 16:58:27','2017-11-19 16:58:27'),(212,'ryTRoxAJgQ.png',1,0,'','site1.png',1,'2017-11-19 17:00:52','2017-11-19 17:00:52'),(213,'x9bleOdCc7.png',1,0,'','site1.png',1,'2017-11-19 17:02:09','2017-11-19 17:02:09'),(214,'QLPr9scQcw.jpeg',1,0,'','mE2AX7u7H08.jpg',1,'2017-11-19 17:12:35','2017-11-19 17:12:35'),(215,'87iTeBjMbs.jpeg',1,0,'','O42JoApyFOo.jpg',1,'2017-11-19 17:12:36','2017-11-19 17:12:36'),(217,'xWCY3tsIwr.jpeg',1,0,'','S0kkD-lrQbE.jpg',1,'2017-11-19 17:12:38','2017-11-19 17:12:38'),(218,'LCpbUK961c.png',1,0,'','site1.png',1,'2017-11-19 17:12:39','2017-11-19 17:12:39'),(219,'ehzPW31TQf.jpeg',1,0,'','mE2AX7u7H08 - копия.jpg',1,'2017-11-19 17:13:35','2017-11-19 17:13:35'),(220,'MexbbSuleo.jpeg',1,0,'','mE2AX7u7H08.jpg',1,'2017-11-19 17:13:36','2017-11-19 17:13:36'),(221,'xHVUVnKLjT.jpeg',1,0,'','O42JoApyFOo.jpg',1,'2017-11-19 17:13:37','2017-11-19 17:13:37'),(223,'RT9JfcYlwE.jpeg',1,0,'','S0kkD-lrQbE.jpg',1,'2017-11-19 17:13:39','2017-11-19 17:13:39'),(224,'dllvd2UWKx.png',1,0,'','site1.png',1,'2017-11-19 17:13:41','2017-11-19 17:13:41'),(225,'1xjmI54vbh.jpeg',1,0,'','mE2AX7u7H08 - копия.jpg',1,'2017-11-19 17:14:45','2017-11-19 17:14:45'),(227,'LgIkgCiRNM.jpeg',1,0,'','O42JoApyFOo.jpg',1,'2017-11-19 17:14:49','2017-11-19 17:14:49'),(228,'TCgGsUUWgf.jpeg',1,0,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 17:14:50','2017-11-19 17:14:50'),(229,'a3INY2NWi9.png',1,0,'','site1.png',1,'2017-11-19 17:14:51','2017-11-19 17:14:51'),(230,'FevMSMU9Up.jpeg',1,0,'','mE2AX7u7H08.jpg',1,'2017-11-19 17:17:31','2017-11-19 17:17:31'),(231,'TaljXlCUEK.jpeg',1,0,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 17:17:32','2017-11-19 17:17:32'),(233,'hAg8lDmUwM.png',1,0,'','site1.png',1,'2017-11-19 17:17:34','2017-11-19 17:17:34'),(234,'rcXaUstbk5.png',1,0,'','TGK_KKK_05.png',1,'2017-11-19 17:17:35','2017-11-19 17:17:35'),(235,'5Agh6Am8Km.jpeg',1,0,'','mE2AX7u7H08.jpg',1,'2017-11-19 17:18:05','2017-11-19 17:18:05'),(236,'xrAHNH926O.jpeg',1,0,'','S0kkD-lrQbE - копия.jpg',1,'2017-11-19 17:18:06','2017-11-19 17:18:06'),(238,'dXEvQYPbiL.png',1,0,'','site1.png',1,'2017-11-19 17:18:08','2017-11-19 17:18:08'),(239,'bPoX2GZonP.png',1,0,'','TGK_KKK_05.png',1,'2017-11-19 17:18:09','2017-11-19 17:18:09'),(245,'cP0vszovKA.jpeg',1,1,'','S0kkD-lrQbE - копия - копия.jpg',1,'2017-11-19 17:19:50','2017-11-19 17:19:50'),(247,'OwwkBhBb6L.jpeg',1,1,'','S0kkD-lrQbE.jpg',1,'2017-11-19 17:19:52','2017-11-19 17:19:52'),(248,'BwvlvZ6rUq.png',1,1,'','site1 - копия.png',1,'2017-11-19 17:19:53','2017-11-19 17:19:53'),(249,'nE0HX2Zt4H.png',1,1,'','site1.png',1,'2017-11-19 17:19:54','2017-11-19 17:19:54'),(250,'euRHBcNv3z.jpeg',1,0,'','S0kkD-lrQbE.jpg',1,'2017-11-19 17:21:21','2017-11-19 17:21:21'),(251,'BetpwV5U9p.png',1,0,'','site1.png',1,'2017-11-19 17:21:22','2017-11-19 17:21:22'),(252,'oj2M4SO6Gl.png',1,0,'','TGK_KKK_05 - копия.png',1,'2017-11-19 17:21:23','2017-11-19 17:21:23'),(253,'XEr4xzgJju.png',1,5,'','Badge (7).png',1,'2017-12-12 20:05:14','2017-12-12 20:05:14'),(254,'doCyGoex2z.png',1,5,'','Badge (9).png',1,'2017-12-12 20:05:16','2017-12-12 20:05:16'),(255,'ieVEwoAVGl.png',1,5,'','Badge (11).png',1,'2017-12-12 20:05:18','2017-12-12 20:05:18'),(256,'ic4Hi7feHu.jpeg',1,5,'','bZLw3pNuYhk - копия.jpg',1,'2017-12-12 20:05:20','2017-12-12 20:05:20'),(257,'9bp5ZmGbfS.jpeg',1,5,'','eJCG4y4OY7k.jpg',1,'2017-12-12 20:05:21','2017-12-12 20:05:21');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2017_11_08_110110_create_categories_table',1),(4,'2017_11_08_110931_create_images_table',2),(5,'2017_11_16_202952_add_visibility_field_to_categories_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@badgem.com','$2y$10$rmp4zyGxFvMJWAI/BLYIKeAhsH78Kc/VgLbFh14wIvQv8FWGXoq4S','9GFwd4yUS4NiI0xYecrpBkwLBqcJP0W48kobj0Rk1eyK0udHyLTkX9Ws7sMl','2017-11-12 18:07:57','2017-12-12 20:15:05');
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

-- Dump completed on 2017-12-13 14:28:23
