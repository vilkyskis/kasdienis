-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2019 m. Bir 12 d. 00:31
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasdienis`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `liked_count` int(11) NOT NULL,
  `response_comment_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CF675F31B` (`author_id`),
  KEY `IDX_9474526C4B89032C` (`post_id`),
  KEY `IDX_9474526C2B918AF3` (`response_comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `comment`
--

INSERT INTO `comment` (`id`, `author_id`, `post_id`, `date`, `comment`, `liked_count`, `response_comment_id`) VALUES
(31, 1, 25, '2019-05-31 12:25:00', 'bandomasis', 0, NULL);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `comment_user`
--

DROP TABLE IF EXISTS `comment_user`;
CREATE TABLE IF NOT EXISTS `comment_user` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`,`user_id`),
  KEY `IDX_ABA574A5F8697D13` (`comment_id`),
  KEY `IDX_ABA574A5A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190502085609', '2019-05-02 10:35:54'),
('20190502094254', '2019-05-02 10:35:57'),
('20190502101710', '2019-05-02 10:35:57'),
('20190502103339', '2019-05-02 10:35:59'),
('20190502104058', '2019-05-02 10:41:18'),
('20190502115632', '2019-05-02 11:56:51'),
('20190503151443', '2019-05-03 15:15:07'),
('20190508185101', '2019-05-08 18:51:25'),
('20190508200605', '2019-05-08 20:06:15'),
('20190508201940', '2019-05-08 20:19:51'),
('20190508204242', '2019-05-08 21:13:21'),
('20190508210741', '2019-05-08 21:18:04'),
('20190508211018', '2019-05-08 21:18:31'),
('20190508211615', '2019-05-08 21:18:55'),
('20190508212356', '2019-05-08 21:25:09'),
('20190508212732', '2019-05-08 21:28:10'),
('20190524194113', '2019-05-24 19:41:40'),
('20190529124842', '2019-05-29 12:49:04'),
('20190531104006', '2019-05-31 10:40:24');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `topic_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `upvotes` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  KEY `IDX_5A8A6C8DF675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `post`
--

INSERT INTO `post` (`id`, `title`, `date`, `data`, `topic_id`, `author_id`, `upvotes`, `image`) VALUES
(23, 'Avaringiausioje Kauno sankryžoje vėl pažiro automobilių nuolaužos', '2019-05-30 16:49:00', 'Ketvirtadienio popietę smarkus trenksmas nuaidėjo vadinamojoje Aklųjų sankryžoje. Vienoje didžiausių ir avaringiausių Kauno sankirtų stipriai apgadinti trys automobiliai, tačiau sužeidimų nelaimės dalyviams pavyko išvengti.\r\nŠiandien, apie 14 val., skaitytojai pasidalijo kauniečiams gerai žinomu vaizdu – Taikos ir Savanorių prospektų sankryžoje pūpso sudaužytos transporto priemonės, stoja eismas.\r\n\r\n<img class=\"fancybox-image\" src=\"https://kaunas.kasvyksta.lt/wp-content/uploads/2019/05/61819617_2333483310050298_4541986211111108608_o-1024x719.jpg\" alt=\"\">\r\n\r\nKauno apskrities vyriausiojo policijos komisariato budėtojas „Kas vyksta Kaune“ nurodė, kad 14.09 val. pareigūnams pranešta apie „Lexus“, „Volkswagen“ ir „Ford“ susidūrimą Savanorių ir Taikos prospektų sankryžoje.\r\n\r\nPolicijos duomenimis, žmonės čia sužaloti nebuvo. Vairuotojai greičiausiai pildys eismo įvykio deklaracijas, tačiau nesutarė dėl kaltės. Pareigūnai išvyko į nelaimės vietą aiškintis avarijos aplinkybių ir padėti įforminti avariją.\r\n\r\nTuo metu abiejose gatvėse ties sankirta formuojasi nemažos spūstys.\r\n\r\nkaunas.kasvyksta.lt inf.', 22, 2, 1, NULL),
(24, 'Stiprus susidūrimas Raudondvaryje: po „Audi“ ir „Opel“ smūgio – sumaitoti automobiliai', '2019-05-30 16:51:00', 'Trečiadienio vakarą Kaune įvyko nelaimė – stipriai susidūrė „Audi“ ir „Opel“ automobiliai, vienas vairuotojas išvežtas į ligoninę.\r\n\r\nRaudondvaryje esančiame Šilelio kaime susidūrus dviems automobiliams, „Audi A3“ ir „Oper Astra“, pastarojo vairuotojui prireikė medikų pagalbos – vyras išgabentas į gydymo įstaigą.\r\n\r\nKauno kelių policijos valdybos budintis darbuotojas „Kas vyksta Kaune“ nurodė, kad pranešimas apie nelaimę gautas 19:55 val.\r\n\r\nPolicijos budinčio darbuotojo teigimu, abu vairuotojai buvo blaivūs.\r\n\r\n<img itemprop=\"image\" src=\"https://kaunas.kasvyksta.lt/wp-content/uploads/2019/05/61693863_2119038131547532_6123048794725548032_n-1024x563.jpg\">\r\n\r\n kaunas.kasvyksta.lt inf.', 22, 2, 1, NULL),
(25, 'Kauno oro uoste – aukcionas: unikali galimybė įsigyti neįprastų daiktų', '2019-05-30 16:54:00', 'Kauno oro uoste birželio 5 dieną rengiamas aukcionas – turėsite unikalią galimybę įsigyti oro uosto saugumo įrangos, automobilių, baldų bei buitinės technikos, kuri dalyvavo judriame oro uosto gyvenime.\r\n\r\nBirželio 5 dieną vyks Lietuvos oro uostų pakartotinis viešas turto pardavimo aukcionas, kuriame galėsite įsigyti rankinių, arkinių bei batų metalo ieškiklių. Taip pat rasite ir labiau įprastų daiktų – automobilių ir buitinės technikos.\r\n\r\nAukciono pradžia bus paskelbta 10 valandą ryto, o susidomėję dalyviai rinksis Kauno oro uoste.\r\n\r\nLietuvos oro uostų paskelbtame aukcione parduodamų daiktų sąraše galima rasti neeilinių prekių, tokių kaip baras, dviračių stovas, rankinis metalo ieškiklis ar oro uoste sutinkamas arkinis metalo detektorius.\r\n\r\nTiesa, parduodami metalo detektoriai ne tik užims nemažai vietos, bet ir gerokai patuštins neeilinį daiktą nusprendusių įsigyti pirkėjų kišenes – pradinė metalo detektoriaus kaina siekia beveik 3 tūkst. eurų.\r\n\r\nAukcione taip pat bus siūloma ir rimta ratuota technika – sniego valytuvai, barstytuvai ir apledėjimo matuokliai.\r\n\r\nPaprastesnių daiktų medžiotojai taip pat nenusivils, nes aukciono asortimente bus galima rasti stilingų sofų, stalų bei lentynų ar laikraščių stendų.\r\n\r\n<img itemprop=\"image\" src=\"https://kaunas.kasvyksta.lt/wp-content/uploads/2016/07/KVK_0236-1024x683.jpg\">\r\n\r\n kaunas.kasvyksta.lt inf.', 23, 2, 0, NULL),
(26, 'asd', '2019-05-31 11:30:00', 'asd', 22, 1, 0, '100a321cdbbebdd216124f944f083aa7.jpeg'),
(27, 'test', '2019-05-31 11:39:00', 'test', 22, 1, 0, '45f25a912e647ad51f3b5819206e9602.png'),
(29, 'Straipsnis', '2019-05-31 12:50:00', 'Straipsnis', 22, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `post_user`
--

DROP TABLE IF EXISTS `post_user`;
CREATE TABLE IF NOT EXISTS `post_user` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `IDX_44C6B1424B89032C` (`post_id`),
  KEY `IDX_44C6B142A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `post_user`
--

INSERT INTO `post_user` (`post_id`, `user_id`) VALUES
(23, 2),
(24, 1);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BF675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `topic`
--

INSERT INTO `topic` (`id`, `name`, `description`, `author_id`) VALUES
(22, 'Eismas', 'Avarijos, eismo pakeitimai ir kitos aktualijos', 2),
(23, 'Kaunas', 'Naujienos susijusios su Kauno miestu', 2),
(24, 'Bandymas', 'Bandymų tema', 1);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `registered` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `registered`) VALUES
(1, 'armsab', 'armsab', 'arm.sablinskas@gmail.com', 'arm.sablinskas@gmail.com', 1, NULL, '$2y$13$Y/.zfchcCVZ08yD4tAZ/5ul.WU8d4t6VFrzBK3PppIIW0c5c6/SL.', '2019-06-12 00:14:07', NULL, NULL, 'a:1:{i:0;s:14:\"ROLE_MODERATOR\";}', NULL),
(2, 'armsab2', 'armsab2', 'cha0123@gmail.com', 'cha0123@gmail.com', 1, NULL, '$2y$13$w4ClBUHS4okhXDKdb4XL8uAA5Ps5tTUKJyhNfUsUaVUtdT7ZhY4YO', '2019-06-12 00:19:34', NULL, NULL, 'a:0:{}', NULL),
(8, 'armsab3', 'armsab3', 'a@a.lt', 'a@a.lt', 1, NULL, '$2y$13$BTn7tkhCgi49hqzaVe7nTuCx4gU5Gxc4vYH8zSblb6VHGdEDTmJoG', '2019-05-08 20:53:21', NULL, NULL, 'a:0:{}', NULL),
(9, 'barminas', 'barminas', 'b@b.lt', 'b@b.lt', 1, NULL, '$2y$13$7pb6xlarvSvtjEyr3smsi.ips7KqPXbld4a7YFyZiTtQG9EeEqLFa', '2019-06-01 15:04:54', NULL, NULL, 'a:0:{}', NULL),
(10, 'bandymas', 'bandymas', 'c@c.lt', 'c@c.lt', 1, NULL, '$2y$13$MsMg1yEcRRWey0bErKf8ouHPo5PhlyVzgSxa1C6jmh1YC8MoU97O6', '2019-06-11 22:32:28', NULL, NULL, 'a:0:{}', NULL);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `user_post`
--

DROP TABLE IF EXISTS `user_post`;
CREATE TABLE IF NOT EXISTS `user_post` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`post_id`),
  KEY `IDX_200B2044A76ED395` (`user_id`),
  KEY `IDX_200B20444B89032C` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Apribojimai eksportuotom lentelėm
--

--
-- Apribojimai lentelei `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C2B918AF3` FOREIGN KEY (`response_comment_id`) REFERENCES `comment` (`id`),
  ADD CONSTRAINT `FK_9474526C4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Apribojimai lentelei `comment_user`
--
ALTER TABLE `comment_user`
  ADD CONSTRAINT `FK_ABA574A5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ABA574A5F8697D13` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE;

--
-- Apribojimai lentelei `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  ADD CONSTRAINT `FK_5A8A6C8DF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Apribojimai lentelei `post_user`
--
ALTER TABLE `post_user`
  ADD CONSTRAINT `FK_44C6B1424B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_44C6B142A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Apribojimai lentelei `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_9D40DE1BF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Apribojimai lentelei `user_post`
--
ALTER TABLE `user_post`
  ADD CONSTRAINT `FK_200B20444B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_200B2044A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
