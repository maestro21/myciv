-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2017 at 06:13 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myciv`
--

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fields` text COLLATE utf8_unicode_ci,
  `split` tinyint(1) DEFAULT NULL,
  `sendmail` tinyint(1) DEFAULT NULL,
  `mail_topic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`name`, `fields`, `split`, `sendmail`, `mail_topic`, `id`) VALUES
('testform', 'a:14:{i:0;a:4:{s:4:"name";s:4:"text";s:4:"type";s:4:"blob";s:6:"widget";s:4:"text";s:8:"required";s:1:"1";}i:1;a:4:{s:4:"name";s:8:"textarea";s:4:"type";s:4:"blob";s:6:"widget";s:8:"textarea";s:8:"required";s:1:"1";}i:2;a:4:{s:4:"name";s:4:"html";s:4:"type";s:4:"blob";s:6:"widget";s:4:"html";s:8:"required";s:1:"1";}i:3;a:4:{s:4:"name";s:6:"bbcode";s:4:"type";s:4:"blob";s:6:"widget";s:6:"bbcode";s:8:"required";s:1:"1";}i:4;a:4:{s:4:"name";s:4:"pass";s:4:"type";s:6:"string";s:6:"widget";s:4:"pass";s:8:"required";s:1:"1";}i:5;a:3:{s:4:"name";s:6:"hidden";s:4:"type";s:4:"text";s:6:"widget";s:6:"hidden";}i:6;a:4:{s:4:"name";s:8:"checkbox";s:4:"type";s:4:"bool";s:6:"widget";s:8:"checkbox";s:8:"required";s:1:"1";}i:7;a:4:{s:4:"name";s:5:"radio";s:4:"type";s:3:"int";s:6:"widget";s:5:"radio";s:8:"required";s:1:"1";}i:8;a:4:{s:4:"name";s:4:"date";s:4:"type";s:4:"date";s:6:"widget";s:4:"date";s:8:"required";s:1:"1";}i:9;a:4:{s:4:"name";s:5:"email";s:4:"type";s:4:"text";s:6:"widget";s:5:"email";s:8:"required";s:1:"1";}i:10;a:4:{s:4:"name";s:6:"number";s:4:"type";s:3:"int";s:6:"widget";s:6:"number";s:8:"required";s:1:"1";}i:11;a:4:{s:4:"name";s:3:"url";s:4:"type";s:6:"string";s:6:"widget";s:3:"url";s:8:"required";s:1:"1";}i:12;a:4:{s:4:"name";s:5:"phone";s:4:"type";s:6:"string";s:6:"widget";s:5:"phone";s:8:"required";s:1:"1";}i:13;a:4:{s:4:"name";s:4:"slug";s:4:"type";s:6:"string";s:6:"widget";s:4:"slug";s:8:"required";s:1:"1";}}', 1, 1, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `forms_messages`
--

CREATE TABLE `forms_messages` (
  `form_id` int(11) DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `sent` datetime DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `forms_messages`
--

INSERT INTO `forms_messages` (`form_id`, `data`, `sent`, `id`) VALUES
(1, 'a:13:{s:4:"text";s:4:"test";s:8:"textarea";s:4:"test";s:6:"bbcode";s:4:"test";s:4:"pass";s:4:"test";s:6:"hidden";s:0:"";s:8:"checkbox";s:1:"1";s:4:"date";s:19:"1970-01-01 01:00:00";s:5:"email";s:12:"test@test.lv";s:6:"number";i:3;s:3:"url";s:14:"http://goha.ru";s:5:"phone";s:11:"43543545666";s:4:"slug";s:7:"test-45";s:4:"html";s:0:"";}', '2017-04-07 16:01:54', 8),
(1, 'a:13:{s:4:"text";s:4:"test";s:8:"textarea";s:4:"test";s:6:"bbcode";s:4:"test";s:4:"pass";s:4:"test";s:6:"hidden";s:0:"";s:8:"checkbox";s:1:"1";s:4:"date";s:19:"1970-01-01 01:00:00";s:5:"email";s:12:"test@test.lv";s:6:"number";i:3;s:3:"url";s:14:"http://goha.ru";s:5:"phone";s:11:"43543545666";s:4:"slug";s:7:"test-45";s:4:"html";s:0:"";}', '2017-04-07 16:03:24', 9),
(1, 'a:13:{s:4:"text";s:4:"test";s:8:"textarea";s:4:"test";s:6:"bbcode";s:4:"test";s:4:"pass";s:4:"test";s:6:"hidden";s:0:"";s:8:"checkbox";s:1:"1";s:4:"date";s:19:"1970-01-01 01:00:00";s:5:"email";s:12:"test@test.lv";s:6:"number";i:3;s:3:"url";s:14:"http://goha.ru";s:5:"phone";s:11:"43543545666";s:4:"slug";s:7:"test-45";s:4:"html";s:0:"";}', '2017-04-07 16:04:03', 10),
(1, 'a:13:{s:4:"text";s:4:"test";s:8:"textarea";s:4:"test";s:6:"bbcode";s:4:"test";s:4:"pass";s:4:"test";s:6:"hidden";s:0:"";s:8:"checkbox";s:1:"1";s:4:"date";s:19:"2017-03-02 00:00:00";s:5:"email";s:12:"test@test.lv";s:6:"number";i:3;s:3:"url";s:14:"http://goha.ru";s:5:"phone";s:11:"43543545666";s:4:"slug";s:7:"test-45";s:4:"html";s:0:"";}', '2017-04-07 16:07:03', 11);

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` int(11) DEFAULT NULL,
  `crdate` datetime DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`name`, `cover`, `crdate`, `id`) VALUES
('Cities', 0, '0000-00-00 00:00:00', 1),
('Units', 0, '0000-00-00 00:00:00', 2),
('Terrain', 0, '0000-00-00 00:00:00', 3),
('Nations', 0, '0000-00-00 00:00:00', 4),
('Icons', 0, '0000-00-00 00:00:00', 5),
('Buildings', 0, '0000-00-00 00:00:00', 6),
('GUI', 0, '0000-00-00 00:00:00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `galleries_images`
--

CREATE TABLE `galleries_images` (
  `gal_id` int(11) DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci,
  `crdate` datetime DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `abbr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`abbr`, `name`, `website`, `active`, `id`) VALUES
('en', 'English', '', 1, 1),
('ru', 'Ñ€ÑƒÑÑÐºÐ¸Ð¹', '', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`name`, `description`, `status`, `id`) VALUES
('i18n', '', 2, 1),
('modules', 'Core module for managing other modules', 2, 2),
('pages', 'Core module for creating website pages', 2, 3),
('system', 'Core module for setting up global settings', 2, 4),
('fileviewer', 'File viewer', 2, 6),
('forms', 'Module for form creation and management', 2, 7),
('langs', '', 2, 8),
('game', 'Main game class that loads game', 0, 9),
('rulesets', 'Ruleset is set of rules including units, tech, cities, graphics, governments, countries,\r\n         etc, that can be later used in games', 2, 11),
('galleries', '', 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `pid` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf16_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf16_unicode_ci DEFAULT NULL,
  `fullurl` varchar(255) COLLATE utf16_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `content` blob,
  `status` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pid`, `name`, `url`, `fullurl`, `type`, `content`, `status`, `id`) VALUES
(0, 'Welcome page', 'en', 'en', NULL, 0x57656c636f6d6520746f20796f7572206e65776c79206372656174656420776562736974652120506f7765726564206279204d61657374726f20456e67696e65207637, 2, 1),
(1, 'About us', 'about', 'en/about', 1, 0x3c703e57656c636f6d6520746f204d61657374726f20456469746f722e207765206861766520736f6d6520636f6f6c207374756666206f76657220686572653a3c2f703e0d0a3c703e3c7374726f6e673e626f6c643c2f7374726f6e673e3c2f703e0d0a3c703e3c656d3e6974616c69633c2f656d3e3c2f703e0d0a3c703e3c7370616e207374796c653d22746578742d6465636f726174696f6e3a20756e6465726c696e653b223e756e6465726c696e653c2f7370616e3e3c2f703e0d0a3c703e3c7370616e207374796c653d22746578742d6465636f726174696f6e3a206c696e652d7468726f7567683b223e737472696b657468726f7567683c2f7370616e3e3c2f703e0d0a3c703e3c7375703e73757065727363726970743c2f7375703e3c2f703e0d0a3c703e3c7375623e7375627363726970743c2f7375623e3c2f703e0d0a3c703e3c636f64653e636f64653c2f636f64653e3c2f703e0d0a3c68313e48656164696e67313c2f68313e0d0a3c68323e48656164696e67323c2f68323e0d0a3c68333e68656164696e67333c2f68333e0d0a3c68343e68656164696e67343c2f68343e0d0a3c68353e68656164696e67353c2f68353e0d0a3c68363e68656164696e67363c2f68363e0d0a3c703e3c7370616e207374796c653d22636f6c6f723a20233333393936363b223e5465787420636f6c6f723c2f7370616e3e20616e64203c7370616e207374796c653d226261636b67726f756e642d636f6c6f723a20236666666630303b223e6261636b67726f756e6420636f6c6f723c2f7370616e3e3c2f703e0d0a3c70207374796c653d22746578742d616c69676e3a206c6566743b223e4c65667420746578743c2f703e0d0a3c70207374796c653d22746578742d616c69676e3a2063656e7465723b223e63656e7472616c20746578743c2f703e0d0a3c70207374796c653d22746578742d616c69676e3a2072696768743b223e726967687420746578743c2f703e0d0a3c70207374796c653d22746578742d616c69676e3a206a7573746966793b223e6a75737469666965642074657874206c6f6e677265616420666f72206d6f7468657220727573736961206a616a616a61266e6273703b3c2f703e0d0a3c756c3e0d0a3c6c69207374796c653d22746578742d616c69676e3a206a7573746966793b223e756c206c6973746974656d20310d0a3c756c3e0d0a3c6c69207374796c653d22746578742d616c69676e3a206a7573746966793b223e7375626974656d0d0a3c756c3e0d0a3c6c69207374796c653d22746578742d616c69676e3a206a7573746966793b223e73756220737562206974656d0d0a3c756c3e0d0a3c6c69207374796c653d22746578742d616c69676e3a206a7573746966793b223e6c696b6520696e20676f6f676c6520796179213c2f6c693e0d0a3c2f756c3e0d0a3c2f6c693e0d0a3c2f756c3e0d0a3c2f6c693e0d0a3c2f756c3e0d0a3c2f6c693e0d0a3c6c69207374796c653d22746578742d616c69676e3a206a7573746966793b223e756c206c6973746974656d323c2f6c693e0d0a3c6c69207374796c653d22746578742d616c69676e3a206a7573746966793b223e756c206c6973746974656d20333c2f6c693e0d0a3c2f756c3e0d0a3c6f6c3e0d0a3c6c693e6f6c206c697374206974656d3c2f6c693e0d0a3c6c693e6f6c206c697374206974656d3c2f6c693e0d0a3c6c693e6f6c206c697374206974656d0d0a3c6f6c3e0d0a3c6c693e746573740d0a3c6f6c3e0d0a3c6c693e746573743c2f6c693e0d0a3c6c693e746573740d0a3c6f6c3e0d0a3c6c693e746573743c2f6c693e0d0a3c2f6f6c3e0d0a3c2f6c693e0d0a3c2f6f6c3e0d0a3c2f6c693e0d0a3c2f6f6c3e0d0a3c2f6c693e0d0a3c2f6f6c3e0d0a3c7461626c653e0d0a3c74626f64793e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c74643e266e6273703b3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e266e6273703b3c2f703e, 2, 2),
(1, 'Contact us', 'contacts', 'en/contacts', NULL, 0x436f6e746163742075732070616765, 2, 3),
(1, 'test', 'test', 'en/test', 1, 0x74657374, 2, 4),
(4, 'subtest', 'subtest', 'en/test/subtest', 1, 0x3c703e3c7370616e207374796c653d22666f6e742d73697a653a2078782d6c617267653b223e537562746573743c2f7370616e3e3c2f703e, 2, 5),
(0, 'Ð”Ð¾Ð±Ñ€Ð¾ Ð¿Ð¾Ð¶Ð°Ð»Ð¾Ð²Ð°Ñ‚ÑŒ!', 'ru', 'ru', 1, 0x3c703ed094d0bed0b1d180d0be20d0bfd0bed0b6d0b0d0bbd0bed0b2d0b0d182d18c213c2f703e, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `rulesets`
--

CREATE TABLE `rulesets` (
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rulesets`
--

INSERT INTO `rulesets` (`name`, `data`, `id`) VALUES
('classic', 0x4e3b, 1);

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`name`, `value`, `deletable`, `id`) VALUES
('langs', '', 0, 1),
('deflang', 'en', 0, 2),
('sitename', 'My Civilization', 0, 3),
('theme', 'maestro', 0, 4),
('defmodule', 'pages', 0, 5),
('db_lastbackup', '1483957168', 0, 6),
('db_backup_frequency', '+1 day', 0, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms_messages`
--
ALTER TABLE `forms_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries_images`
--
ALTER TABLE `galleries_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gal_id` (`gal_id`);

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abbr` (`abbr`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rulesets`
--
ALTER TABLE `rulesets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `forms_messages`
--
ALTER TABLE `forms_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `galleries_images`
--
ALTER TABLE `galleries_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `langs`
--
ALTER TABLE `langs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rulesets`
--
ALTER TABLE `rulesets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms_messages`
--
ALTER TABLE `forms_messages`
  ADD CONSTRAINT `forms_messages_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `galleries_images`
--
ALTER TABLE `galleries_images`
  ADD CONSTRAINT `galleries_images_ibfk_1` FOREIGN KEY (`gal_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
