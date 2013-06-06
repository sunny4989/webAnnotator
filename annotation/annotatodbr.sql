-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2013 at 01:01 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `annotator`
--

-- --------------------------------------------------------

--
-- Table structure for table `antr_essay`
--

CREATE TABLE IF NOT EXISTS `antr_essay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `studentname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subdate` int(10) unsigned NOT NULL,
  `annotext` text COLLATE utf8_unicode_ci NOT NULL,
  `grade` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=pending,1=In Progress,2=Annotated,3=mailed',
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=132 ;

--
-- Dumping data for table `antr_essay`
--

INSERT INTO `antr_essay` (`id`, `filename`, `studentname`, `email`, `subdate`, `annotext`, `grade`, `status`, `comments`) VALUES
(79, 'F:/annotationdata/Ajeet kumar-ajeet@gmail.com/anno.doc', 'Ajeet kumar', 'ajeet@gmail.com', 1366707480, '', 0, 0, ''),
(88, 'F:/annotationdata/Mallappa k-mallappa@elearn10.com/anno.doc', 'Mallappa k', 'mallappa@elearn10.com', 1366710900, '', 0, 0, ''),
(95, 'F:/annotationdata/tina-tina@gmail.com/new.txt', 'tina', 'tina@gmail.com', 1366713540, '', 0, 0, ''),
(113, 'F:/annotationdata/Mihir-mihir@moodleofindai.com/anno.doc', 'Mihir', 'mihir@moodleofindai.com', 1366714860, 'Munrize and the Little Drum with the Giant VoiceBy Skywalker Storyteller In a time not of this time a little girl named Munrize lived in a town called Umoja. The town sat near the seashore, surrounded by a rich forest. Munrize lived happily with her mother, father, and two older brothers. The sound of drums was the earliest memory of this wide-eyed girl. Her mother loved to tell the story of her daughters birth. When you began to kick in my belly your brothers began drumming. They played a rhythm like the rolling of the sea, like waves dancing to shore so I felt no pain. Before she could walk Munrize danced to her rhythm. When she took her first step her second step was a dance. By the age of three, Munrize was the featured dancer for the harvest festival. Her brown legs moved in perfect rhythm to the beat of her brothers drums while her long beaded braids created floating rainbows. Munrize lived to dance. She studied hard and did well in school so she could join the older dancers and perform for every festival, wedding, and special event. As each year passed her dancing became better and when she was ten she was chosen to be the principal dancer for the New Years celebration. The following spring her whole world changed. The rain began gently but it grew stronger as the days passed. Then one morning, the house shook like a giant rattle and Munrize tumbled from her bed. A loud, piercing sound roared all around her as a strong, cold wet wind blew breaking the windows. She tried to get up but something hard and sharp hit her legs and she fell into darkness. A bright light pierced through the forest as Munrize danced along to her brothers drums. Walking ahead with her parents, they turned and looked at her. Her mother and father smiled as her brothers drummed with an intensity she had never before heard. In a flash they disappeared. Slowly Munrize opened her eyes and saw Aunt Damali. She smiled and said, Munrize, can you see me, do you know who I am Her hand gently stroked her nieces forehead. Why, Auntie, why are you crying Then, Munrize saw that her legs were wrapped in thick plaster casts that hung from the ceiling and she suddenly felt a sharp pain like a fire run through her entire body and heart. Where is Mama Where is Daddy Where are my brothers     Y, dXiJ(x(I_TS1EZBmU/xYy5g/GMGeD3Vqq8K)fw9\r\nxrxwrTZaGy8IjbRcXI\r\nu3KGnD1NIBs\r\nRuKV.ELM2fiVvlu8zH\r\n(W )6-rCSj id	DAIqbJx6kASht(QpmcaSlXP1Mh9MVdDAaVBfJP8AVf 6Q ', 95, 0, 'well done'),
(128, 'F:/annotationdata/mallu-abc@gmail.com/new.txt', 'mallu', 'abc@gmail.com', 1366719840, 'what is annnotation and laaa ', 100, 0, 'dsdfd'),
(129, 'F:/annotationdata/fd-katir@gmail.com/new.txt', 'fd', 'katir@gmail.com', 1366720020, 'what is annnotation and laaa ', 90, 0, 'ewwew');

-- --------------------------------------------------------

--
-- Table structure for table `antr_user`
--

CREATE TABLE IF NOT EXISTS `antr_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `antr_user`
--

INSERT INTO `antr_user` (`id`, `firstname`, `lastname`, `email`, `username`, `password`) VALUES
(1, 'Mallappa', 'k', 'mallappa@elearn10.com', 'mallu048', 'e10adc3949ba59abbe56e057f20f883e');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
