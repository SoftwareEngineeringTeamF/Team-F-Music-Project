-- phpMyAdmin SQL Dump
-- version 4.1.14.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2014 at 11:07 AM
-- Server version: 5.6.21
-- PHP Version: 5.4.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teamf`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `memberid` int(11) NOT NULL AUTO_INCREMENT,
  `songid` int(11) NOT NULL,
  `playlistid` int(11) NOT NULL,
  `listindex` int(11) NOT NULL,
  PRIMARY KEY (`memberid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberid`, `songid`, `playlistid`, `listindex`) VALUES
(1, 1, 1, 1),
(2, 3, 1, 0),
(3, 2, 1, 2),
(4, 75, 2, 0),
(5, 76, 2, 1),
(6, 77, 2, 2),
(7, 78, 2, 3),
(8, 79, 2, 4),
(9, 80, 2, 5),
(10, 81, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE IF NOT EXISTS `playlists` (
  `playlistid` int(11) NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(1023) NOT NULL,
  PRIMARY KEY (`playlistid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`playlistid`, `ownerid`, `public`, `title`, `description`) VALUES
(1, 1, 1, 'Title', 'Description'),
(2, 4, 1, 'Seiken Densetsu Sound Collection', 'Soundtrack from a game');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `songid` int(11) NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`songid`),
  UNIQUE KEY `songid` (`songid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`songid`, `ownerid`, `artist`, `title`) VALUES
(1, 1, 'Artist', 'Test1'),
(2, 1, 'Artist', 'Test2'),
(3, 1, 'Artist', 'Test3'),
(75, 4, 'Seiken Densetsu', '1st Chapter - Determination'),
(76, 4, 'Seiken Densetsu', '2nd Chapter - Menace'),
(77, 4, 'Seiken Densetsu', '3rd Chapter - Mission'),
(78, 4, 'Seiken Densetsu', '4th Chapter - Friends'),
(79, 4, 'Seiken Densetsu', '5th Chapter - Parting'),
(80, 4, 'Seiken Densetsu', '6th Chapter - Decisive Battle'),
(81, 4, 'Seiken Densetsu', '7th Chapter - Life');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activated` tinyint(1) NOT NULL,
  `hash_act` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `signup` datetime NOT NULL,
  `lastlogin` datetime NOT NULL,
  PRIMARY KEY (`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `email`, `activated`, `hash_act`, `firstname`, `lastname`, `ip`, `signup`, `lastlogin`) VALUES
(1, 'User', 'Password', 'Email@Mail.com', 1, '', 'Test', 'User', '', '2014-12-09 06:53:27', '2014-12-09 06:53:27'),
(3, 'djscott', 'djscott', 'mail@me.com', 1, '', 'DJ', 'Scot', '', '2014-12-01 20:10:32', '2014-12-01 20:10:32'),
(4, 'tplacek', 'tplacek', 'tplacek@uark.edu', 1, '', 'Travis', 'Placek', '', '2014-12-08 20:55:14', '2014-12-08 20:55:14');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
