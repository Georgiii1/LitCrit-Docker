CREATE DATABASE  IF NOT EXISTS `litCrit` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `litCrit`;
-- MySQL dump 10.13  Distrib 8.0.38, for macos14 (arm64)
--
-- Host: 127.0.0.1    Database: litCrit
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
-- Table structure for table `Books`
--

DROP TABLE IF EXISTS `Books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Books` (
  `bookID` int(11) NOT NULL AUTO_INCREMENT,
  `bookTitle` varchar(70) NOT NULL,
  `bookAuthor` varchar(80) NOT NULL,
  `yearOfPublishing` int(11) NOT NULL,
  `bookGenre` int(11) DEFAULT NULL,
  `bookAnnotation` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `bookCover` varchar(1000) DEFAULT NULL,
  `dateAdded` datetime DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `status` enum('pending','approved','declined') DEFAULT 'pending',
  PRIMARY KEY (`bookID`),
  KEY `bookGenre` (`bookGenre`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`bookGenre`) REFERENCES `genre` (`genreID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Books`
--

LOCK TABLES `Books` WRITE;
/*!40000 ALTER TABLE `Books` DISABLE KEYS */;
INSERT INTO `Books` VALUES (1,'Пипи Дългото чорапче','Астрид Линдгрен',2013,4,'Pippi Longstocking is the fictional main character in a series of children\'s books by Swedish author Astrid Lindgren. Pippi was named by Lindgren\'s daughter Karin, who asked her mother for a get-well story when she was off school.                                        ','images/covers/67fe2674ee24f.jpg','2025-01-16 11:48:00',0,'pending'),(2,'Ян Бибиян','Елин Пелин',2014,4,'Yan Bibiyan is the first Bulgarian fantasy novel for children by the Bulgarian writer Elin Pelin and the name of its protagonist. The novel is described as \"the most celebrated children’s fantasy novel\".','images/677ff21de03cc.jpg','2025-01-16 11:48:00',0,'pending'),(3,'The idea of you','Robinne Lee',2019,5,'Solène Marchand, the thirty-nine-year-old owner of an art gallery in Los Angeles, is reluctant to take her daughter, Isabelle, to meet her favorite boy band. But since her divorce, she\'s more eager than ever to be close to Isabelle.','images/677ff36ccd983.jpg','2025-01-16 11:48:00',0,'pending'),(4,'Библия','Последователите на Исус <3',100,1,'The Bible is a collection of religious texts and scriptures that are held to be sacred in Christianity, and partly in Judaism, Samaritanism, Islam, the Baháʼí Faith, and other Abrahamic religions. The Bible is an anthology originally written in Hebrew, Aramaic, and Koine Greek.','images/677ff4495bb11.jpg','2025-01-16 11:48:00',0,'pending'),(5,'Book','Booker',2012,2,'aaaa','images/6780bbe346489.jpg','2025-01-16 11:48:00',0,'pending'),(6,'Book','Booker',2012,2,'aaaa','images/6780bbe843645.jpg','2025-01-16 11:48:00',0,'pending'),(7,'To Kill a Mockingbird','Harper Lee',1960,2,'A novel about the serious issues of race and rape in 1930s America, told through the eyes of young Scout Finch.','6787817854b7e.jpg','2025-01-16 11:48:00',0,'pending'),(8,'1984','George Orwell',1949,7,'A dystopian novel set in a totalitarian regime controlled by the Party and its leader, Big Brother.','6787817854b7e.jpg','2025-01-16 11:48:00',0,'pending'),(9,'Harry Potter and the Philosopher\'s Stone','J.K. Rowling',1997,4,'The story of a young wizard discovering his magical heritage and his battle against the dark wizard Voldemort.','6787817854b7e.jpg','2025-01-16 11:48:00',0,'pending'),(10,'Charlotte\'s Web','E.B. White',1952,4,'A tender story of friendship between a pig named Wilbur and a spider named Charlotte.','6787817854b7e.jpg','2025-01-16 11:48:00',1,'pending'),(11,'TEST Book','TEST TESTED',2025,8,'TEST','images/67e3af900bdaf.jpg','2025-03-26 09:41:04',10,'pending'),(13,'TEST','TEST',2025,1,'FGSGJA','images/67e4f22e96c87.jpg','2025-03-27 08:37:34',10,'approved'),(14,'This is test book','Written by a test author',2025,1,'Test notation','images/681af0983fe28.jpg','2025-05-07 08:33:12',9,'pending'),(15,'TEst PIPI','TEst author',2025,4,'Aaaaaasasasaasas','images/681c4a421d4bd.jpg','2025-05-08 09:08:02',14,'approved');
/*!40000 ALTER TABLE `Books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reviews`
--

DROP TABLE IF EXISTS `Reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reviews` (
  `reviewID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(160) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `review` text DEFAULT NULL,
  `bookReviewID` int(11) DEFAULT NULL,
  `dateAdded` date DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `status` enum('pending','approved','declined') DEFAULT 'pending',
  PRIMARY KEY (`reviewID`),
  KEY `fk_reviews_user` (`userID`),
  CONSTRAINT `fk_reviews_user` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reviews`
--

LOCK TABLES `Reviews` WRITE;
/*!40000 ALTER TABLE `Reviews` DISABLE KEYS */;
INSERT INTO `Reviews` VALUES (10,NULL,'Edited\r\n',1,'2025-03-05',10,'declined'),(11,NULL,'The best!',4,'2025-03-05',10,'approved'),(12,NULL,'Comment.',9,'2025-03-05',10,'approved'),(13,NULL,'ahshahshasvahbs',1,'2025-03-05',10,'approved'),(14,NULL,'This is a test message!',2,'2025-03-26',10,'approved'),(15,NULL,'TEST TEST TEST TEST TEST',3,'2025-03-26',10,'approved'),(16,NULL,'TEСТЕТСТСЙ йсдхфкайсцхву е',3,'2025-03-26',10,'approved'),(17,NULL,'TEST TES TETSTSTSTSTSSTST TESTTS',11,'2025-03-26',10,'approved'),(18,NULL,'COPMMMEJAUTSUGHMYGIEUKH',1,'2025-03-26',10,'approved'),(19,'TITLE','TETETTE',12,'2025-03-26',10,'approved'),(20,'TEST Book','TEST COMMENT',11,'2025-03-27',10,'approved'),(21,'Пипи Дългото чорапче','testTESTtestTEst',1,'2025-05-07',9,'approved'),(22,'This is test book','this is a test comment for the test book.',14,'2025-05-07',9,'approved'),(23,'Библия','Perfecto\r\n',4,'2025-05-07',14,'approved'),(24,'TITLE','This is the worst book. Fuck it I hate it! ',12,'2025-05-07',14,'approved'),(25,'TITLE','EWWWW, dum fucking book, I hate it!',12,'2025-05-07',14,'declined'),(26,'Библия','I love this book, it\'s amazing and fulfilling!',4,'2025-05-07',14,'declined'),(27,'Библия','I love love love this book!',4,'2025-05-07',14,'declined'),(28,'Библия','I am in love with this book! the Bible is truly remarkable book!',4,'2025-05-07',14,'declined'),(29,'TITLE','I absolutely hate this miserable book! Fuck it!',12,'2025-05-07',14,'declined'),(30,'TITLE','I absolutely hate this disgusting book. Fuck it!',12,'2025-05-07',14,'declined'),(31,'Библия','What a lovely book! It\'s truly remarkable!',4,'2025-05-07',14,'approved'),(32,'TEST','An amazing book! You should defenetly read it.',13,'2025-05-08',14,'approved'),(33,'TEST','This is a really bad book... Fuck it I hate it.',13,'2025-05-08',14,'declined'),(34,'TEst PIPI','COMMENT',15,'2025-05-08',14,'approved'),(35,'TEST','THIS Is an amazing book, love it!',13,'2025-05-08',14,'approved'),(36,'TEST','I hate this book, it\'s awful.... Fuck it!!!!!',13,'2025-05-08',14,'declined'),(37,'TEST','YEYEYEYEEY wowowowowo super! ',13,'2025-05-08',14,'approved'),(38,'TEST','NOooooooo, I hate this book!\r\n',13,'2025-05-08',14,'declined'),(39,'TEST','YEYEYEYEEY wowowowowo super!\r\n',13,'2025-05-08',14,'approved'),(40,'TEST','NOooooooo, I hate this book!\r\n',13,'2025-05-08',14,'declined');
/*!40000 ALTER TABLE `Reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `passwordHashed` varchar(100) DEFAULT NULL,
  `favouriteGenre` varchar(100) DEFAULT NULL,
  `profilePicture` varchar(1000) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `role` enum('administrator','admin','user') DEFAULT 'user',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'name','name@ex.com','$2y$10$QhrE6XslFTnVl70966zBLekg2BLCXmvrQnMli8/OVQVAS4fcQnG5G',NULL,'',NULL,'user'),(2,'username','user@ex.com','$2y$10$xieX5P8xeqXThqZaPepsi.OAKkYLcPwOcrPoSMvopqUnWoWBjaCd.',NULL,'',NULL,'user'),(3,'username','user@ex.com','$2y$10$UOC1UA.qRT6Cu9ycEiVaI.J7WJbfyKh57fuJWMVHm5czFthYNWjXO',NULL,'',NULL,'user'),(4,'123','123@example.com','$2y$10$hr1BrY0/lLgiwimY2nOHZ.4hAdtaDb3SR2Eimkt6KraZpaCauNV2q',NULL,'',NULL,'user'),(5,'123','email@ex.com','$2y$10$7ykBq5naoeicCUuQrshTl.N8RM68KbrdqlUqcN3hQ/zGd8i2HjYJ2',NULL,NULL,NULL,'user'),(6,'123','email@ex.com','$2y$10$GAKDEEsP7lj8PGBW1K0BY.dXgGxRLytc.noTDQbEqmIBjV5JyH96C',NULL,'Array',NULL,'user'),(7,'123','e@e.com','$2y$10$Hg4WoT85.V/nYtzUK2GIw.FhlVZ28xLAI2eRcupD9WYa4ziG5QdT6',NULL,'Array',NULL,'user'),(8,'123a','ex@ex.com','$2y$10$QlkLo5acUsBVukbNRmlZPukSAYeAxn8ZPiM0ocOFRFEX104bw6ObC',NULL,'Array',NULL,'user'),(9,'123aq','ex@ex.com','$2y$10$is0fK6/OCmfYAOcg7MIrAO0Kuk2bl0XLIXJzF8I4zUxzexqLpl.7S',NULL,'otherBreakfast.jpg',NULL,'user'),(10,'NEW USERNAME211212','em@ex.co','$2y$10$YGHru2SzUwiah203EWmNLecWK2Cc2Zzb91mCyCwPwQ9mH6oqIjYTe',NULL,'otherBreakfast.jpg',NULL,'user'),(11,'testTest','test@example.com','$2y$10$.1pjK2xQOAGOqtQmJd.L5OE0x3iyNVNfV/tC5dXub16H8GZ8s1gEG',NULL,'otherBreakfast.jpg',NULL,'user'),(12,'123user','user123@example.com','$2y$10$R2LwwkLpKYLLHuVMwro5ueBZ.I/GOdtzmb7PxnfXISesH5B14wwiS',NULL,'moobCaseIconHome-removebg-preview.png',NULL,'user'),(13,'123user','user123@example.com','$2y$10$e9AYXvn3WiBJXjxLce0u2eMn6zwT1SCvw6JYqCWf0mjktHpaW1XCG',NULL,'moobCaseIconHome-removebg-preview.png',NULL,'user'),(14,'Georgi21207','testG@example.com','$2y$10$sLnXR4Szgz5igBxDKHDQUuCJf7M9HBQbKShneuT7jso5aAp/Z9nHe','Поезия,Проза,Роман,Детска Литература','user_681b345836e305.60243727.png',NULL,'user'),(16,'Gabi','gabi212@gmail.com','$2y$10$mIrIT/M95YgGgwQf4QX0AOuiYJljD4BarUx1vFYhAeKszdctDhcKK','Поезия,Романтика,Комедия,Криминалистика','default-profile-picture.png',NULL,'admin');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genre` (
  `genreID` int(11) NOT NULL AUTO_INCREMENT,
  `genreOrder` int(11) DEFAULT NULL,
  `bookGenre` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`genreID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,1,'Поезия'),(2,2,'Проза'),(3,3,'Роман'),(4,4,'Детска Литература'),(5,5,'Романтика'),(6,6,'Комедия'),(7,7,'Криминалистика'),(8,8,'Фантастика');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-03 10:40:58
