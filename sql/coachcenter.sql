-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 24, 2014 at 04:17 PM
-- Server version: 5.5.37-MariaDB
-- PHP Version: 5.5.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `coachcenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `bet`
--

CREATE TABLE IF NOT EXISTS `bet` (
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
  `betdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `color` enum('yellow','red') DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_ids` (`player_id`),
  KEY `match` (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE IF NOT EXISTS `coach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE IF NOT EXISTS `competition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `continent`
--

CREATE TABLE IF NOT EXISTS `continent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `continent`
--

INSERT INTO `continent` (`id`, `name`) VALUES
(1, 'Asia'),
(2, 'Europe'),
(3, 'Africa'),
(4, 'Oceania'),
(5, 'Americas'),
(6, 'Antarctica'),
(7, 'Atlantic Ocean'),
(8, 'Indian Ocean');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `continent_id` int(11) DEFAULT NULL,
  `abbreviation` char(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `continent` (`continent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=262 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `continent_id`, `abbreviation`) VALUES
(1, 'Afghanistan', 1, 'af'),
(2, 'Albania', 2, 'al'),
(3, 'Algeria', 3, 'dz'),
(4, 'American Samoa', 4, 'as'),
(5, 'Andorra', 2, 'ad'),
(6, 'Angola', 3, 'ao'),
(7, 'Anguilla', 5, 'ai'),
(8, 'Antigua and Barbuda', 5, 'ag'),
(9, 'Argentina', 5, 'ar'),
(10, 'Armenia', 1, 'am'),
(11, 'Aruba', 5, 'aw'),
(12, 'Australia', 4, 'au'),
(13, 'Austria', 2, 'at'),
(14, 'Azerbaijan', 1, 'az'),
(15, 'Bahamas', 5, 'bs'),
(16, 'Bahrain', 1, 'bh'),
(17, 'Bangladesh', 1, 'bd'),
(18, 'Barbados', 5, 'bb'),
(19, 'Belarus', 2, 'by'),
(20, 'Belgium', 2, 'be'),
(21, 'Belize', 5, 'bz'),
(22, 'Benin', 3, 'bj'),
(23, 'Bermuda', 5, 'bm'),
(24, 'Bhutan', 1, 'bt'),
(25, 'Bolivia', 5, 'bo'),
(26, 'Bosnia and Herzegovina', 2, 'ba'),
(27, 'Botswana', 3, 'bw'),
(28, 'Brazil', 5, 'br'),
(29, 'British Virgin Islands', 5, 'vg'),
(30, 'Brunei Darussalam', 1, 'bn'),
(31, 'Bulgaria', 2, 'bg'),
(32, 'Burkina Faso', 3, 'bf'),
(33, 'Burundi', 3, 'bi'),
(34, 'Cambodia', 1, 'kh'),
(35, 'Cameroon', 3, 'cm'),
(36, 'Canada', 5, 'ca'),
(37, 'Cape Verde Islands', 3, 'cv'),
(38, 'Cayman Islands', 5, 'ky'),
(39, 'Central African Republic', 3, 'cf'),
(40, 'Chad', 3, 'td'),
(41, 'Chile', 5, 'cl'),
(42, 'China PR', 1, 'cn'),
(43, 'Christmas Island', 1, 'cx'),
(44, 'Cocos (Keeling) Islands', 1, 'cc'),
(45, 'Colombia', 5, 'co'),
(46, 'Comoros', 3, 'km'),
(47, 'Congo', 3, 'cg'),
(48, 'Cook Islands', 4, 'ck'),
(49, 'Costa Rica', 5, 'cr'),
(50, 'Cote d''Ivoire', 3, 'ci'),
(51, 'Croatia', 2, 'hr'),
(52, 'Cuba', 5, 'cu'),
(53, 'Cyprus', 1, 'cy'),
(54, 'Czech Republic', 2, 'cz'),
(55, 'Denmark', 2, 'dk'),
(56, 'Djibouti', 3, 'dj'),
(57, 'Dominica', 5, 'dm'),
(58, 'Dominican Republic', 5, 'do'),
(59, 'Ecuador', 5, 'ec'),
(60, 'Egypt', 3, 'eg'),
(61, 'El Salvador', 5, 'sv'),
(62, 'Equatorial Guinea', 3, 'gq'),
(63, 'Eritrea', 3, 'er'),
(64, 'Estonia', 2, 'ee'),
(65, 'Ethiopia', 3, 'et'),
(66, 'Falkland Islands (Islas Malvinas)', 5, 'fk'),
(67, 'Faroe Islands', 2, 'fo'),
(68, 'Fiji', 4, 'fj'),
(69, 'Finland', 2, 'fi'),
(70, 'France', 2, 'fr'),
(71, 'French Guiana', 5, 'gf'),
(72, 'Tahiti', 4, 'pf'),
(73, 'Gabon', 3, 'ga'),
(74, 'Gambia', 3, 'gm'),
(75, 'Georgia', 1, 'ge'),
(76, 'Germany', 2, 'de'),
(77, 'Ghana', 3, 'gh'),
(78, 'Gibraltar', 2, 'gi'),
(79, 'Greece', 2, 'gr'),
(80, 'Greenland', 5, 'gl'),
(81, 'Grenada', 5, 'gd'),
(82, 'Guadeloupe', 5, 'gp'),
(83, 'Guam', 4, 'gu'),
(84, 'Guatemala', 5, 'gt'),
(85, 'Guernsey', 2, 'gg'),
(86, 'Guinea', 3, 'gn'),
(87, 'Guinea-Bissau', 3, 'gw'),
(88, 'Guyana', 5, 'gy'),
(89, 'Haiti', 5, 'ht'),
(90, 'Holy See (Vatican City)', 2, 'va'),
(91, 'Honduras', 5, 'hn'),
(92, 'Hungary', 2, 'hu'),
(93, 'Iceland', 2, 'is'),
(94, 'India', 1, 'in'),
(95, 'Indonesia', 1, 'id'),
(96, 'Iran', 1, 'ir'),
(97, 'Iraq', 1, 'iq'),
(98, 'Republic of Ireland', 2, 'ie'),
(99, 'Israel', 1, 'il'),
(100, 'Italy', 2, 'it'),
(101, 'Jamaica', 5, 'jm'),
(102, 'Jan Mayen', 2, 'sj'),
(103, 'Japan', 1, 'jp'),
(104, 'Jersey', 2, 'je'),
(105, 'Jordan', 1, 'jo'),
(106, 'Kazakhstan', 1, 'kz'),
(107, 'Kenya', 3, 'ke'),
(108, 'Kiribati', 4, 'ki'),
(109, 'Korea DPR', 1, 'kp'),
(110, 'Korea Republic', 1, 'kr'),
(111, 'Kuwait', 1, 'kw'),
(112, 'Kyrgyzstan', 1, 'kg'),
(113, 'Laos', 1, 'la'),
(114, 'Latvia', 2, 'lv'),
(115, 'Lebanon', 1, 'lb'),
(116, 'Lesotho', 3, 'ls'),
(117, 'Liberia', 3, 'lr'),
(118, 'Libya', 3, 'ly'),
(119, 'Liechtenstein', 2, 'li'),
(120, 'Lithuania', 2, 'lt'),
(121, 'Luxembourg', 2, 'lu'),
(122, 'Macedonia FYR', 2, 'mk'),
(123, 'Madagascar', 3, 'mg'),
(124, 'Malawi', 3, 'mw'),
(125, 'Malaysia', 1, 'my'),
(126, 'Maldives', 1, 'mv'),
(127, 'Mali', 3, 'ml'),
(128, 'Malta', 2, 'mt'),
(129, 'Man, Isle of', 2, 'im'),
(130, 'Marshall Islands', 4, 'mh'),
(131, 'Martinique', 5, 'mq'),
(132, 'Mauritania', 3, 'mr'),
(133, 'Mauritius', 3, 'mu'),
(134, 'Mayotte', 3, 'yt'),
(135, 'Mexico', 5, 'mx'),
(136, 'Micronesia, Federated States of', 4, 'fm'),
(137, 'Moldova', 2, 'md'),
(138, 'Monaco', 2, 'mc'),
(139, 'Mongolia', 1, 'mn'),
(140, 'Montserrat', 5, 'ms'),
(141, 'Morocco', 3, 'ma'),
(142, 'Mozambique', 3, 'mz'),
(143, 'Myanmar', 1, 'mz'),
(144, 'Namibia', 3, 'na'),
(145, 'Nauru', 4, 'nr'),
(146, 'Nepal', 1, 'np'),
(147, 'Netherlands', 2, 'nl'),
(148, 'Netherlands Antilles', 5, 'an'),
(149, 'New Caledonia', 4, 'nc'),
(150, 'New Zealand', 4, 'nz'),
(151, 'Nicaragua', 5, 'ni'),
(152, 'Niger', 3, 'ne'),
(153, 'Nigeria', 3, 'ng'),
(154, 'Niue', 4, 'nu'),
(155, 'Norfolk Island', 4, 'nf'),
(156, 'Northern Mariana Islands', 4, 'mp'),
(157, 'Norway', 2, 'no'),
(158, 'Oman', 1, 'om'),
(159, 'Pakistan', 1, 'pk'),
(160, 'Palau', 4, 'pw'),
(161, 'Palestine', 1, 'ps'),
(162, 'Panama', 5, 'pa'),
(163, 'Papua New Guinea', 4, 'pg'),
(164, 'Paraguay', 5, 'py'),
(165, 'Peru', 5, 'pe'),
(166, 'Philippines', 1, 'ph'),
(167, 'Pitcairn Islands', 4, 'pn'),
(168, 'Poland', 2, 'pl'),
(169, 'Portugal', 2, 'pt'),
(170, 'Puerto Rico', 5, 'pr'),
(171, 'Qatar', 1, 'qa'),
(172, 'Reunion', 3, 're'),
(173, 'Romania', 2, 'ro'),
(174, 'Russia', 1, 'ru'),
(175, 'Rwanda', 3, 'rw'),
(176, 'St. Kitts and Nevis', 5, 'kn'),
(177, 'St. Lucia', 5, 'lc'),
(178, 'Saint Pierre and Miquelon', 5, 'pm'),
(179, 'St. Vincent and the Grenadines', 5, 'vc'),
(180, 'San Marino', 2, 'sm'),
(181, 'São Tomé e Príncipe', 3, 'st'),
(182, 'Saudi Arabia', 1, 'sa'),
(183, 'Senegal', 3, 'sn'),
(184, 'Serbia and Montenegro', 2, 'cs'),
(185, 'Seychelles', 3, 'sc'),
(186, 'Sierra Leone', 3, 'sl'),
(187, 'Singapore', 1, 'sg'),
(188, 'Slovakia', 2, 'sk'),
(189, 'Slovenia', 2, 'si'),
(190, 'Solomon Islands', 4, 'sb'),
(191, 'Somalia', 3, 'so'),
(192, 'South Africa', 3, 'za'),
(193, 'Spain', 2, 'es'),
(194, 'Sri Lanka', 1, 'lk'),
(195, 'Sudan', 3, 'sd'),
(196, 'Suriname', 5, 'sr'),
(197, 'Svalbard', 2, 'sj'),
(198, 'Swaziland', 3, 'sz'),
(199, 'Sweden', 2, 'se'),
(200, 'Switzerland', 2, 'ch'),
(201, 'Syria', 1, 'sy'),
(202, 'Chinese Taipei', 1, ''),
(203, 'Tajikistan', 1, 'tj'),
(204, 'Tanzania', 3, 'tz'),
(205, 'Thailand', 1, 'th'),
(206, 'Togo', 3, 'tg'),
(207, 'Tokelau', 4, 'tk'),
(208, 'Tonga', 4, 'to'),
(209, 'Trinidad and Tobago', 5, 'tt'),
(210, 'Tunisia', 3, 'tn'),
(211, 'Turkey', 1, 'tr'),
(212, 'Turkmenistan', 1, 'tm'),
(213, 'Turks and Caicos Islands', 5, 'tc'),
(214, 'Tuvalu', 4, 'tv'),
(215, 'Uganda', 3, 'ug'),
(216, 'Ukraine', 2, 'ua'),
(217, 'United Arab Emirates', 1, 'ae'),
(218, 'United Kingdom', 2, 'gb'),
(219, 'USA', 5, 'us'),
(220, 'Uruguay', 5, 'uy'),
(221, 'Uzbekistan', 1, 'uz'),
(222, 'Vanuatu', 4, 'vu'),
(223, 'Venezuela', 5, 've'),
(224, 'Vietnam', 1, 'vn'),
(225, 'US Virgin Islands', 5, 'vi'),
(226, 'Wallis and Futuna', 4, 'wf'),
(227, 'Western Sahara', 3, 'eh'),
(228, 'Western Samoa', 4, 'ws'),
(229, 'Yemen', 1, 'ye'),
(230, 'Congo DR', 3, 'cd'),
(231, 'Zambia', 3, 'zm'),
(232, 'Zimbabwe', 3, 'zw'),
(233, 'Hong Kong', 1, 'hk'),
(234, 'Macao', 1, 'mo'),
(235, 'Antarctica', 6, 'aq'),
(236, 'Bouvet Island', 7, 'bv'),
(237, 'British Indian Ocean Territory', 1, 'io'),
(238, 'Timor-Leste', 1, 'tl'),
(239, 'France, Metropolitan', 2, 'fx'),
(240, 'French Southern and Antarctic Lands', 8, 'tf'),
(241, 'Heard Island and McDonald Islands', 8, 'hm'),
(242, 'Montenegro', 2, 'me'),
(243, 'Saint Helena', 7, 'sh'),
(244, 'South Georgia and the South Sandwich Islands', 7, 'gs'),
(245, 'United States Minor Outlying Islands', 4, 'um'),
(246, 'Yugoslavia', 2, 'yu'),
(247, 'England', 2, 'engl'),
(248, 'Serbia', 2, 'rs'),
(249, 'Montenegro', 2, 'me'),
(250, 'Scotland', 2, 'scot'),
(251, 'Wales', 2, 'wale'),
(252, 'Northern Ireland', 2, 'ie'),
(253, 'South Sudan', 3, 'ss'),
(254, 'Samoa', 4, 'ws'),
(255, 'Curaçao', 5, 'cw'),
(256, 'Serbia and Montenegro', 2, 'cs'),
(257, 'Yugoslavia', 2, 'yu'),
(258, 'Czechoslovakia ', 2, 'cs'),
(259, 'USSR', 2, 'su'),
(260, 'West Germany', 2, 'de'),
(261, 'German DR', 2, 'dd');

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE IF NOT EXISTS `goal` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hometeam_id` int(11) DEFAULT NULL,
  `awayteam_id` int(11) DEFAULT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hometeam` (`hometeam_id`),
  KEY `awayteam` (`awayteam_id`),
  KEY `competition` (`competition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL COMMENT ' To store status of notification i.e seen or not unseen ',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `injured` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `playerPerMatch`
--

CREATE TABLE IF NOT EXISTS `playerPerMatch` (
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

CREATE TABLE IF NOT EXISTS `playerPerTeam` (
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

CREATE TABLE IF NOT EXISTS `team` (
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

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `country_id`, `coach_id`, `fifapoints`, `twitterAccount`) VALUES
(1, 'Spain', 193, 1, 1460, 'sefutbol'),
(2, 'Germany', 76, 2, 1340, 'DFB_Team'),
(3, 'Portugal', 169, 3, 1245, 'SeleoPortuguesa'),
(4, 'Colombia', 45, 4, 1186, 'FCFSeleccionCol'),
(5, 'Uruguay', 220, 5, 1181, 'AUFOficial'),
(6, 'Argentina', 9, 6, 1178, 'InfoFutbolAFA'),
(7, 'Brazil', 28, 7, 1210, 'BrazilStats'),
(8, 'Switzerland', 200, 8, 1161, 'SFV_ASF'),
(9, 'Italy', 100, 9, 1115, 'Vivo_Azzurro'),
(10, 'Greece', 79, 10, 1082, 'EthnikiOmada'),
(11, 'England', 247, 11, 1043, 'FA'),
(12, 'Belgium', 20, 12, 1039, 'belreddevils'),
(13, 'United States', 219, 13, 1015, 'ussoccer'),
(14, 'Chile', 41, 14, 1037, 'ANFPChile'),
(15, 'Netherlands', 147, 15, 967, 'onsoranje'),
(16, 'France', 70, 16, 935, 'fff'),
(17, 'Ukraine', 216, 17, 913, 'FFU_OFFICIAL'),
(18, 'Russia', 174, 18, 903, 'official_rfs'),
(19, 'Mexico', 135, 19, 877, 'FEMEXFUTOFICIAL'),
(20, 'Croatia', 51, 20, 871, 'HNS_CFF'),
(21, 'Côte d''Ivoire', 50, 21, 830, 'FIFCI_tweet'),
(22, 'Scotland', 250, 22, 825, 'scottishfa'),
(23, 'Denmark', 55, 23, 819, 'danskfodboldcom'),
(24, 'Egypt', 60, 24, 798, 'EgyptianPlayers'),
(25, 'Bosnia-Herzegovina', 26, 25, 795, 'nszdk'),
(26, 'Sweden', 199, 26, 795, 'karlerikfotboll'),
(27, 'Algeria', 3, 27, 795, 'footballalgeria'),
(28, 'Ecuador', 59, 28, 794, 'fefecuador'),
(29, 'Slovenia', 189, 29, 787, 'nzs_si'),
(30, 'Serbia', 248, 30, 759, 'FSSrbije'),
(31, 'Romania', 173, 31, 756, 'FRFro'),
(32, 'Honduras', 91, 32, 759, 'FenafuthOrg'),
(33, 'Armenia', 10, 33, 750, 'OfficialArmFF'),
(34, 'Costa Rica', 49, 34, 748, 'FEDEFUTBOL_CR'),
(35, 'Panama', 162, 35, 739, 'fepafut'),
(36, 'Czech Republic', 54, 36, 731, 'fotbalova_repre'),
(37, 'Iran', 96, 37, 715, 'PFDC1'),
(38, 'Ghana', 77, 38, 713, 'ghanafaofficial'),
(39, 'Turkey', 211, 39, 711, 'TFF_Org'),
(40, 'Austria', 13, 40, 673, 'oefb1904'),
(41, 'Venezuela', 223, 41, 666, 'FVF_Oficial'),
(42, 'Cape Verde Islands', 37, 42, 665, ''),
(43, 'Peru', 165, 43, 665, 'FPFPERU'),
(44, 'Hungary', 92, 44, 623, 'MLSZhivatalos'),
(45, 'Nigeria', 153, 45, 631, 'KickOff_Nigeria'),
(46, 'Slovakia', 188, 46, 616, 'sfzofficial'),
(47, 'Japan', 103, 47, 613, 'jfa_en'),
(48, 'Wales', 251, 48, 613, 'fawales'),
(49, 'Tunisia', 210, 49, 597, 'TunisieFoot'),
(50, 'Cameroon', 35, 50, 583, ''),
(51, 'Guinea', 86, 51, 580, 'guineefoot'),
(52, 'Finland', 69, 52, 578, 'Palloliitto'),
(53, 'Uzbekistan', 221, 53, 577, 'theuffdotcom'),
(54, 'Paraguay', 164, 54, 551, 'AsociacionPF'),
(55, 'Montenegro', 242, 55, 555, 'FudbalskiSavez'),
(56, 'Korea Republic', 110, 56, 551, 'thekfa'),
(57, 'Norway', 157, 57, 551, 'LFCNorwegian'),
(58, 'Iceland', 93, 58, 546, 'icelandfootball'),
(59, 'Mali', 127, 59, 545, 'malifootball'),
(60, 'Australia', 12, 60, 545, 'Socceroos'),
(61, 'Burkina Faso', 32, 61, 528, 'BurkinaFasoNT'),
(62, 'Libya', 118, 62, 522, 'LibyaFootball'),
(63, 'Senegal', 183, 63, 511, 'Teranga_Lions'),
(64, 'Jordan', 105, 64, 510, 'JFA_JORDAN'),
(65, 'Republic of Ireland', 98, 65, 504, 'FAIreland'),
(66, 'South Africa', 192, 66, 507, 'SAFA_net'),
(67, 'UAE', 217, 67, 499, 'UAESoccer'),
(68, 'Bolivia', 25, NULL, 497, 'FBFutbol'),
(69, 'El Salvador', 61, 68, 488, 'fesfut_sv'),
(70, 'Albania', 2, 69, 486, 'fatjonpandovski'),
(71, 'Sierra Leone', 186, 70, 484, ''),
(72, 'Poland', 168, 71, 479, 'pzpn_pl'),
(73, 'Bulgaria', 31, 72, 460, 'Bulgariasoccer'),
(74, 'Zambia', 231, 73, 448, 'FAZFootball'),
(75, 'Saudi Arabia', 182, 74, 455, 'SaudiFooty'),
(76, 'Trinidad and Tobago', 209, 75, 457, 'socawarriors'),
(77, 'Morocco', 141, 76, 454, 'afmorocco'),
(78, 'Israel', 99, 77, 450, 'ISRAELFA'),
(79, 'Haiti', 89, 78, 452, 'fhfhaiti'),
(80, 'Macedonia FYR', 122, 79, 443, 'MacedonianFooty'),
(81, 'Oman', 158, 80, 418, ''),
(82, 'Jamaica', 101, 81, 420, 'ItsTheJFF'),
(83, 'Belarus', 19, 82, 404, ''),
(84, 'Northern Ireland', 252, 83, 400, 'OfficialIrishFA'),
(85, 'Azerbaijan', 14, 84, 398, 'azfutbolcom'),
(86, 'Uganda', 215, 85, 395, 'OfficialFUFA'),
(87, 'Gabon', 73, 86, 386, ''),
(88, 'Congo DR', 230, 87, 380, ''),
(89, 'Togo', 206, 88, 374, 'Togo_N_Football'),
(90, 'Cuba', 52, 89, 371, ''),
(91, 'Botswana', 27, NULL, 369, 'BotsFootball'),
(92, 'Congo', 47, 90, 367, ''),
(93, 'Estonia', 64, 91, 366, 'eestijalgpall'),
(94, 'Angola', 6, 92, 347, 'AngolaFootball'),
(95, 'Qatar', 171, 93, 338, 'FootballQatar'),
(96, 'China PR', 42, 94, 333, 'china_football'),
(97, 'Benin', 22, 95, 332, 'BeninFootball'),
(98, 'Zimbabwe', 232, 96, 327, 'ZimFootballFans'),
(99, 'Moldova', 137, 97, 325, ''),
(100, 'Iraq', 97, 98, 321, 'IRQFA'),
(101, 'Ethiopia', 65, 99, 319, 'ethiofleagues'),
(102, 'Niger', 152, 100, 315, ''),
(103, 'Georgia', 75, 101, 303, 'FootballUGA'),
(104, 'Lithuania', 120, 102, 293, 'LTUFootball'),
(105, 'Bahrain', 16, 103, 289, 'bfainfo'),
(106, 'Kenya', 107, 104, 284, 'KenyaFootaNews'),
(107, 'Central African Republic', 39, 105, 284, ''),
(108, 'Kuwait', 111, 106, 283, 'KuwaitFA'),
(109, 'Latvia', 114, 107, 273, 'LV_FOOTBALL_ENG'),
(110, 'Canada', 36, 108, 272, 'CanadaSoccerEN'),
(111, 'New Zealand', 150, 109, 271, 'NZ_Football'),
(112, 'Luxembourg', 121, 110, 266, 'SportLuxembourg'),
(113, 'Equatorial Guinea', 62, 111, 261, ''),
(114, 'Mozambique', 142, 112, 251, ''),
(115, 'Lebanon', 115, 113, 251, 'Lebanesekooora'),
(116, 'Vietnam', 224, 114, 242, ''),
(117, 'Sudan', 195, 115, 241, ''),
(118, 'Kazakhstan', 106, 116, 235, 'kffkz'),
(119, 'Liberia', 117, 117, 234, ''),
(120, 'Namibia', 144, 118, 233, 'NamibiaSoccer'),
(121, 'Malawi', 124, NULL, 227, ''),
(122, 'Tanzania', 204, 119, 227, ''),
(123, 'Afghanistan', 1, 120, 204, 'affafghanistan'),
(124, 'Guatemala', 84, 121, 223, 'guatefut'),
(125, 'Burundi', 33, 122, 215, ''),
(126, 'Dominican Republic', 58, 123, 212, ''),
(127, 'Malta', 128, 124, 204, 'mfootballlive'),
(128, 'Cyprus', 53, 125, 201, 'cyprusfooty'),
(129, 'Suriname', 196, 126, 197, ''),
(130, 'Rwanda', 175, 127, 197, 'RwandaFA'),
(131, 'Gambia', 74, 128, 190, 'FootballGambia'),
(132, 'Syria', 201, 129, 190, ''),
(133, 'Tajikistan', 203, 130, 229, 'fft_official'),
(134, 'Grenada', 81, 131, 188, 'GrenadaFootball'),
(135, 'St. Vincent / Grenadines', 179, 132, 212, ''),
(136, 'New Caledonia', 149, 133, 174, 'ofcfootball'),
(137, 'Korea DPR', 109, 134, 175, ''),
(138, 'Lesotho', 116, NULL, 159, ''),
(139, 'Antigua and Barbuda', 8, 135, 158, 'AntiguaFA'),
(140, 'Thailand', 205, 136, 156, 'FAThailand'),
(141, 'St. Lucia', 177, 137, 191, ''),
(142, 'Malaysia', 125, 138, 149, 'MalaysianFUTBOL'),
(143, 'Belize', 21, 139, 152, 'BelizeFootball'),
(144, 'Philippines', 166, 140, 161, 'philfootball'),
(145, 'Singapore', 187, 141, 144, 'SGfootball'),
(146, 'India', 94, 142, 144, 'football_indian'),
(147, 'Kyrgyzstan', 112, 143, 148, 'FFKR_rus'),
(148, 'Puerto Rico', 170, 144, 143, 'FutbolPR'),
(149, 'Liechtenstein', 119, 145, 139, ''),
(150, 'Guyana', 88, NULL, 137, ''),
(151, 'Indonesia', 95, 146, 135, 'Footballnesia'),
(152, 'Mauritania', 132, 147, 165, ''),
(153, 'Maldives', 126, 148, 124, 'MVFootballTeam'),
(154, 'St. Kitts and Nevis', 176, 149, 124, ''),
(155, 'Aruba', 11, 150, 122, 'avbaruba'),
(156, 'Turkmenistan', 212, 151, 119, 'tmfootball'),
(157, 'Tahiti', 72, 152, 116, 'TahitiFootball'),
(158, 'Hong Kong', 233, 153, 111, ''),
(159, 'Nepal', 146, 154, 102, 'Goal_Nepal'),
(160, 'Dominica', 57, 155, 93, 'DominicaFootbal'),
(161, 'Pakistan', 159, 156, 102, 'FootballPak'),
(162, 'Barbados', 18, 157, 101, 'barbadosFA'),
(163, 'Bangladesh', 17, 158, 98, 'LFCBangladesh'),
(164, 'Palestine', 161, 159, 88, 'FutbolPalestine'),
(165, 'Faroe Islands', 67, 160, 91, ''),
(166, 'São Tomé e Príncipe', 181, 161, 86, ''),
(167, 'Nicaragua', 151, 162, 84, ''),
(168, 'Bermuda', 23, 163, 83, ''),
(169, 'Chad', 40, 164, 88, ''),
(170, 'Chinese Taipei', 202, 165, 78, ''),
(171, 'Guam', 83, 166, 77, 'GuamFootball'),
(172, 'Solomon Islands', 190, 167, 75, 'ofcfootball'),
(173, 'Sri Lanka', 194, 168, 73, 'FFSL_SriLanka'),
(174, 'Laos', 113, 169, 73, ''),
(175, 'Myanmar', 143, 170, 73, 'soccermyanmar'),
(176, 'Mauritius', 133, 171, 55, ''),
(177, 'Seychelles', 185, 172, 66, ''),
(178, 'Curaçao', 255, 173, 65, ''),
(179, 'Swaziland', 198, 174, 64, ''),
(180, 'Yemen', 229, 175, 63, ''),
(181, 'Vanuatu', 222, 176, 55, 'vanuafoot'),
(182, 'Fiji', 68, 177, 47, 'FJ_Football'),
(183, 'Samoa', 254, 178, 45, 'SamoaFootball'),
(184, 'Comoros', 46, 179, 43, ''),
(185, 'Guinea-Bissau', 87, NULL, 43, ''),
(186, 'Bahamas', 15, 180, 40, 'bahamasfa'),
(187, 'Mongolia', 139, 181, 35, ''),
(188, 'Montserrat', 140, 182, 33, ''),
(189, 'Madagascar', 123, 183, 32, ''),
(190, 'Cambodia', 34, 184, 28, ''),
(191, 'Brunei', 30, 185, 26, ''),
(192, 'Timor-Leste', 238, 186, 26, ''),
(193, 'Tonga', 208, 187, 26, 'TongaFootball'),
(194, 'US Virgin Islands', 225, 188, 23, ''),
(195, 'Cayman Islands', 38, 189, 21, 'CIFA'),
(196, 'Papua New Guinea', 163, NULL, 21, ''),
(197, 'British Virgin Islands', 29, 190, 18, ''),
(198, 'American Samoa', 4, 191, 18, ''),
(199, 'Andorra', 5, 192, 16, ''),
(200, 'Eritrea', 63, 193, 11, ''),
(201, 'South Sudan', 253, 194, 10, ''),
(202, 'Somalia', 191, 195, 8, ''),
(203, 'Macao', 234, 196, 8, ''),
(204, 'Djibouti', 56, 197, 6, ''),
(205, 'Cook Islands', 48, 198, 5, ''),
(206, 'Anguilla', 7, 199, 3, ''),
(207, 'Bhutan', 24, 200, 0, ''),
(208, 'San Marino', 180, NULL, 0, 'SanMarinoFA'),
(209, 'Turks and Caicos Islands', 213, NULL, 0, ''),
(210, 'Serbia and Montenegro', 256, NULL, 0, ''),
(211, 'Yugoslavia', 257, NULL, 0, ''),
(212, 'Czechoslovakia', 258, NULL, 0, ''),
(213, 'USSR', 259, NULL, 0, ''),
(214, 'West Germany', 260, NULL, 0, ''),
(215, 'German DR', 261, NULL, 0, ''),
(216, 'Zaire', 230, NULL, 0, ''),
(217, 'Martinique', 131, NULL, 0, ''),
(218, 'Guadeloupe', 82, NULL, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `teamPerCompetition`
--

CREATE TABLE IF NOT EXISTS `teamPerCompetition` (
  `team_id` int(11) NOT NULL DEFAULT '0',
  `competition_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`team_id`,`competition_id`),
  KEY `tpc_competition` (`competition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userGroup`
--

CREATE TABLE IF NOT EXISTS `userGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userGroupInvites`
--

CREATE TABLE IF NOT EXISTS `userGroupInvites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `usergroupId` int(11) NOT NULL,
  `invitedById` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userGroupMessages`
--

CREATE TABLE IF NOT EXISTS `userGroupMessages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usergroup_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userGroupMessagesContent`
--

CREATE TABLE IF NOT EXISTS `userGroupMessagesContent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userPerUserGroup`
--

CREATE TABLE IF NOT EXISTS `userPerUserGroup` (
  `user_id` int(11) NOT NULL,
  `userGroup_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`userGroup_id`),
  KEY `userGroup_id` (`userGroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
