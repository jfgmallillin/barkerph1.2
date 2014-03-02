-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 01, 2014 at 10:23 PM
-- Server version: 5.5.28
-- PHP Version: 5.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `barkerph1.0`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `cat_description` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name_unique` (`cat_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`) VALUES
(1, 'Point 1 to point 2', 'From point 1 to point 2');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `SUG_ID` int(8) DEFAULT NULL,
  `USER_ID` int(8) DEFAULT NULL,
  `DATE_CREATED` date NOT NULL,
  `TIME_CREATED` time NOT NULL,
  `CONTENT` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `SUG_ID` (`SUG_ID`,`USER_ID`),
  KEY `USER_ID` (`USER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `SUG_ID`, `USER_ID`, `DATE_CREATED`, `TIME_CREATED`, `CONTENT`) VALUES
(1, 1, 3, '2014-02-15', '00:00:00', 'Eto ang masabi ko lang'),
(2, 1, 1, '2014-02-16', '00:00:00', 'Kung sabagay. Tama ka.'),
(3, 1, 4, '2014-02-19', '00:00:00', 'reply 3'),
(5, 2, 4, '2014-02-19', '00:00:00', 'reply'),
(6, 2, 5, '2014-02-19', '00:00:00', 'reply'),
(7, 5, 7, '2014-02-19', '00:00:00', 'reply'),
(8, 5, 1, '2014-02-19', '00:00:00', 'reply'),
(9, 4, 1, '2014-02-21', '00:00:00', 'eto naman masasabi ko'),
(10, 6, 1, '2014-02-21', '00:00:00', 'test\n'),
(11, 7, 1, '2014-02-21', '03:23:00', 'test'),
(12, 2, 1, '2014-02-21', '03:40:00', 'yeah!!'),
(13, 5, 1, '2014-02-22', '03:15:00', 'ajfaajfaajfaajfaajfaajfaajfaajfaajfaajfaajfaajfaaj');

-- --------------------------------------------------------

--
-- Table structure for table `commute_det`
--

CREATE TABLE IF NOT EXISTS `commute_det` (
  `SUG_ID` int(8) NOT NULL,
  `COMMUTE_SEQ` int(8) NOT NULL,
  `TRANSPOMODE_ID` int(8) NOT NULL,
  `TRANSPOMODE_DESC` varchar(100) NOT NULL,
  `TRAVEL_DESC` varchar(200) NOT NULL,
  `FARE` double NOT NULL,
  `ETA` int(11) NOT NULL,
  KEY `TRANSPOMODE_ID` (`TRANSPOMODE_ID`),
  KEY `SUG_ID` (`SUG_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commute_det`
--

INSERT INTO `commute_det` (`SUG_ID`, `COMMUTE_SEQ`, `TRANSPOMODE_ID`, `TRANSPOMODE_DESC`, `TRAVEL_DESC`, `FARE`, `ETA`) VALUES
(5, 1, 11, 'sakay', 'hintay ka', 0, 0),
(1, 1, 11, 'sakay', 'hintay ka', 0, 0),
(1, 2, 0, 'wa', 'wa', 0, 0),
(1, 3, 13, 'hanggang bahay', 'hanggang bahay', 0, 0),
(8, 1, 0, 'lakd', 'lakad lang', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `location_ref`
--

CREATE TABLE IF NOT EXISTS `location_ref` (
  `ID` int(8) NOT NULL DEFAULT '0',
  `ID_VARIANT` int(8) NOT NULL DEFAULT '0',
  `NAME` varchar(50) DEFAULT NULL,
  `REMARKS` varchar(250) NOT NULL,
  PRIMARY KEY (`ID`,`ID_VARIANT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_ref`
--

INSERT INTO `location_ref` (`ID`, `ID_VARIANT`, `NAME`, `REMARKS`) VALUES
(1, 1, 'MOA', ''),
(1, 2, 'Mall of Asia', ''),
(2, 1, 'Bangko Sentral ng Pilipinas', ''),
(2, 2, 'BSP-Manila', ''),
(2, 3, 'Central Bank of the Philippines', '');

-- --------------------------------------------------------

--
-- Table structure for table `loc_suggestion`
--

CREATE TABLE IF NOT EXISTS `loc_suggestion` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(8) NOT NULL,
  `LOC_NAME` varchar(50) DEFAULT NULL,
  `TAG` int(8) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `USER_ID` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(8) NOT NULL AUTO_INCREMENT,
  `post_content` text COLLATE utf8_bin NOT NULL,
  `post_date` datetime NOT NULL,
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_topic` (`post_topic`),
  KEY `post_by` (`post_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `ID` int(8) NOT NULL,
  `ROUTE_FROM` int(8) NOT NULL DEFAULT '0',
  `ROUTE_TO` int(8) NOT NULL DEFAULT '0',
  `HIT_COUNT` int(8) NOT NULL DEFAULT '0',
  `DATE_CREATED` date DEFAULT NULL,
  PRIMARY KEY (`ROUTE_FROM`,`ROUTE_TO`),
  KEY `ROUTE_TO` (`ROUTE_TO`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`ID`, `ROUTE_FROM`, `ROUTE_TO`, `HIT_COUNT`, `DATE_CREATED`) VALUES
(1, 1, 2, 0, '2014-02-15'),
(2, 2, 1, 0, '2014-02-15');

-- --------------------------------------------------------

--
-- Stand-in structure for view `route_view`
--
CREATE TABLE IF NOT EXISTS `route_view` (
`SUG_ID` int(8)
,`COMMUTE_SEQ` int(8)
,`TRANSPOMODE_ID` int(8)
,`TRANSPOMODE_DESC` varchar(100)
,`TRAVEL_DESC` varchar(200)
,`FARE` double
,`ETA` int(11)
,`ID` int(8)
,`NAME` varchar(20)
,`COLOR` varchar(10)
);
-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE IF NOT EXISTS `suggestion` (
  `ID` int(8) NOT NULL DEFAULT '0',
  `ROUTE_ID` int(8) NOT NULL DEFAULT '0',
  `USER_ID` int(8) NOT NULL DEFAULT '0',
  `TITLE` varchar(25) DEFAULT NULL,
  `DATE_CREATED` date NOT NULL,
  `DATE_EDITED` date NOT NULL,
  `RATING_AVE` double NOT NULL,
  `RATING_COUNT` int(8) NOT NULL,
  `CONTENT` varchar(500) NOT NULL,
  PRIMARY KEY (`ROUTE_ID`,`USER_ID`),
  KEY `USER_ID` (`USER_ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suggestion`
--

INSERT INTO `suggestion` (`ID`, `ROUTE_ID`, `USER_ID`, `TITLE`, `DATE_CREATED`, `DATE_EDITED`, `RATING_AVE`, `RATING_COUNT`, `CONTENT`) VALUES
(1, 1, 1, 'Title tiley2', '2014-02-15', '2014-02-28', 5, 1, 'Suggestion 1'),
(2, 1, 3, 'Title 2', '2014-02-15', '0000-00-00', 0, 0, 'Suggestion 2'),
(4, 1, 4, 'Title 4', '2014-02-18', '0000-00-00', 0, 0, 'Suggestion 4'),
(5, 1, 5, 'Title 5', '2014-02-19', '0000-00-00', 0, 0, 'Suggestion 5'),
(6, 1, 6, 'Title 6', '2014-02-19', '0000-00-00', 0, 0, 'Suggestion 6'),
(7, 1, 7, 'Title 7', '2014-02-19', '0000-00-00', 0, 0, 'Suggestion 7'),
(8, 2, 1, 'New Suggestion', '2014-02-28', '0000-00-00', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `topic_id` int(8) NOT NULL AUTO_INCREMENT,
  `topic_subject` varchar(255) COLLATE utf8_bin NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_cat` int(8) NOT NULL,
  `topic_by` int(8) NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `topic_cat` (`topic_cat`),
  KEY `topic_by` (`topic_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transpo_mode`
--

CREATE TABLE IF NOT EXISTS `transpo_mode` (
  `ID` int(8) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `COLOR` varchar(10) NOT NULL,
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transpo_mode`
--

INSERT INTO `transpo_mode` (`ID`, `NAME`, `COLOR`) VALUES
(0, 'WALK', '#00FF00'),
(11, 'BUS', '#FF0000'),
(12, 'JEEP', '#0000FF'),
(13, 'TAXI', '#FFFF00'),
(14, 'TRICYCLE', '#00FFFF'),
(15, 'PEDICAB', '#FF00FF');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(0, 'ANONYMOUS', 'anon@nymous@email.com', '1234'),
(1, 'jack', 'jack@email.com', 'e10adc3949ba59abbe56e057f20f883e '),
(3, 'lester', 'lester@email.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(4, 'michelle', 'mich_ren03@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e '),
(5, 'tonio', 'tonio@tonio.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(6, 'mhel', 'mhel@mhel.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(7, 'kevynn', 'kevs@kevs.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(8) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `user_pass` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_date` datetime NOT NULL,
  `user_level` int(8) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name_unique` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_date`, `user_level`) VALUES
(1, 'jack', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'email@email.com', '2014-02-09 19:17:25', 0);

-- --------------------------------------------------------

--
-- Structure for view `route_view`
--
DROP TABLE IF EXISTS `route_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `route_view` AS select `cd`.`SUG_ID` AS `SUG_ID`,`cd`.`COMMUTE_SEQ` AS `COMMUTE_SEQ`,`cd`.`TRANSPOMODE_ID` AS `TRANSPOMODE_ID`,`cd`.`TRANSPOMODE_DESC` AS `TRANSPOMODE_DESC`,`cd`.`TRAVEL_DESC` AS `TRAVEL_DESC`,`cd`.`FARE` AS `FARE`,`cd`.`ETA` AS `ETA`,`tm`.`ID` AS `ID`,`tm`.`NAME` AS `NAME`,`tm`.`COLOR` AS `COLOR` from (`commute_det` `cd` left join `transpo_mode` `tm` on((`cd`.`TRANSPOMODE_ID` = `tm`.`ID`)));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`SUG_ID`) REFERENCES `suggestion` (`ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`id`);

--
-- Constraints for table `commute_det`
--
ALTER TABLE `commute_det`
  ADD CONSTRAINT `commute_det_ibfk_1` FOREIGN KEY (`SUG_ID`) REFERENCES `suggestion` (`ID`),
  ADD CONSTRAINT `commute_det_ibfk_2` FOREIGN KEY (`TRANSPOMODE_ID`) REFERENCES `transpo_mode` (`ID`);

--
-- Constraints for table `loc_suggestion`
--
ALTER TABLE `loc_suggestion`
  ADD CONSTRAINT `loc_suggestion_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_topic`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`ROUTE_FROM`) REFERENCES `location_ref` (`ID`),
  ADD CONSTRAINT `routes_ibfk_2` FOREIGN KEY (`ROUTE_TO`) REFERENCES `location_ref` (`ID`);

--
-- Constraints for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD CONSTRAINT `suggestion_ibfk_1` FOREIGN KEY (`ROUTE_ID`) REFERENCES `routes` (`ID`),
  ADD CONSTRAINT `suggestion_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`id`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`topic_cat`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
