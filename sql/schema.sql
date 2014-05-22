-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2014 at 05:37 PM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `coachcenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `bet`
--

CREATE TABLE `bet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `hometeam_score` int(5) NOT NULL,
  `awayteam_score` int(5) NOT NULL,
  `first_goal` tinyint(1) DEFAULT NULL,
  `hometeam_yellows` int(5) DEFAULT NULL,
  `hometeam_reds` int(5) DEFAULT NULL,
  `awayteam_yellows` int(5) DEFAULT NULL,
  `awayteam_reds` int(5) DEFAULT NULL,
  `evaluated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `color` tinyint(1) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_ids` (`player_id`),
  KEY `match` (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=201 ;

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE `competition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Table structure for table `continent`
--

CREATE TABLE `continent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `continent_id` int(11) DEFAULT NULL,
  `abbreviation` char(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `continent` (`continent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=262 ;

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE `goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) DEFAULT NULL,
  `time` tinyint(4) DEFAULT NULL,
  `player_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `penaltyphase` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `match` (`match_id`),
  KEY `player` (`player_id`),
  KEY `team` (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3317 ;

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hometeam_id` int(11) DEFAULT NULL,
  `awayteam_id` int(11) DEFAULT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hometeam` (`hometeam_id`),
  KEY `awayteam` (`awayteam_id`),
  KEY `competition` (`competition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1322 ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL COMMENT ' To store status of notification i.e seen or not unseen ',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `injured` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6713 ;

-- --------------------------------------------------------

--
-- Table structure for table `playerPerMatch`
--

CREATE TABLE `playerPerMatch` (
  `player_id` int(11) NOT NULL DEFAULT '0',
  `match_id` int(11) NOT NULL DEFAULT '0',
  `intime` tinyint(4) DEFAULT NULL,
  `outtime` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`player_id`,`match_id`),
  KEY `player_per_match` (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `playerPerTeam`
--

CREATE TABLE `playerPerTeam` (
  `player_id` int(11) NOT NULL DEFAULT '0',
  `team_id` int(11) NOT NULL DEFAULT '0',
  `position` enum('goalkeeper','defender','midfielder','attacker') DEFAULT NULL,
  PRIMARY KEY (`player_id`,`team_id`),
  KEY `player_per_team` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `fifapoints` int(11) DEFAULT NULL,
  `twitterAccount` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country_id`),
  KEY `coach` (`coach_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=219 ;

-- --------------------------------------------------------

--
-- Table structure for table `teamPerCompetition`
--

CREATE TABLE `teamPerCompetition` (
  `team_id` int(11) NOT NULL DEFAULT '0',
  `competition_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`team_id`,`competition_id`),
  KEY `tpc_competition` (`competition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facebookid` varchar(30) NOT NULL,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `country_id` int(10) NOT NULL,
  `session_id` varchar(24) DEFAULT NULL,
  `registrationcode` varchar(24) DEFAULT NULL,
  `betscore` int(11) NOT NULL DEFAULT '0',
  `about` varchar(1024) NOT NULL,
  `recieve_email` tinyint(1) NOT NULL DEFAULT '1',
  `age` int(3) NOT NULL,
  `picture` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `userGroup`
--

CREATE TABLE `userGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `userGroupInvites`
--

CREATE TABLE `userGroupInvites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `usergroupId` int(11) NOT NULL,
  `invitedById` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `userPerUserGroup`
--

CREATE TABLE `userPerUserGroup` (
  `user_id` int(11) NOT NULL,
  `userGroup_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`userGroup_id`),
  KEY `userGroup_id` (`userGroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
