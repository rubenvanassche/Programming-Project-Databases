-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2014 at 09:23 PM
-- Server version: 5.5.36-MariaDB
-- PHP Version: 5.5.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `coachcenter`
--

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`id`, `name`) VALUES
(1, 'Vicente Del Bosque'),
(2, 'Joachim Löw'),
(3, 'Alejandro Javier Sabella'),
(4, 'Paulo Jorge Gomes Bento'),
(5, 'José Néstor Pekerman'),
(6, 'Óscar Washington Tabárez Silva'),
(7, 'Ottmar Hitzfeld'),
(8, 'Claudio Cesare Prandelli'),
(9, 'Luiz Elena Felipe Scolari'),
(10, 'Marc Wilmots'),
(11, 'Louis van Gaal'),
(12, 'Roy Hodgson'),
(13, 'Fernando Manuel Fernandes da Costa Santos'),
(14, 'Jürgen Klinsmann'),
(15, 'Jorge Luis Sampaoli Moya'),
(16, 'Niko Kovač'),
(17, 'Didier Deschamps'),
(18, 'Mikhail Ivanovich Fomenko'),
(19, 'Fabio Capello'),
(20, 'Miguel Ernesto Herrera Aguirre'),
(21, 'Morten Olsen'),
(22, 'Sabri Lamouchi'),
(23, 'Vahid Halilhodžić'),
(24, 'Shawky Garib'),
(25, 'Erik Hamrén'),
(26, 'Ljubinko Drulović'),
(27, 'Julio César Dely Valdés'),
(28, 'Pavel Vrba'),
(29, 'Srečko Katanec'),
(30, 'Victor Piţurcă'),
(31, 'Ulisses Indalécio Silva Antunes'),
(32, 'Jorge Luis Pinto Afanador'),
(33, 'James Kwasi Appiah'),
(34, 'Luis Fernando Suárez Guzman'),
(35, 'Gordon Strachan'),
(36, 'Fatih Terim'),
(37, 'Manuel Plasencia'),
(38, 'Pablo Javier Bengoechea Dutra'),
(39, 'Bernard Challandes'),
(40, 'Carlos Manuel Brito Leal Queiróz'),
(41, 'Attila Pintér'),
(42, 'Nizar Khanfir'),
(43, 'Marcel Koller'),
(44, 'Branko Brnović'),
(45, 'Stephen Okechukwu Keshi'),
(46, 'Alberto Zaccheroni'),
(47, 'Jan Kozák'),
(48, 'Lars Lagerbäck'),
(49, 'Mirjalol Qosimov'),
(50, 'Henryk Kasperczak'),
(51, 'Víctor Genes'),
(52, 'Safet Sušić'),
(53, 'Reinaldo Rueda Rivera'),
(54, 'Myung-Bo Hong'),
(55, 'Paul Put'),
(56, 'Angelos Postecoglou'),
(57, 'Gordon Igesund'),
(58, 'Eli Guttmann'),
(59, 'Hossam Hassan Hussein'),
(60, 'Alain Giresse'),
(61, 'Javier Clemente Lazaro'),
(62, 'Johnny McKinstry'),
(63, 'Adam Nawałka'),
(64, 'Patrice Beaumelle'),
(65, 'Juan Ramón López Caro'),
(66, 'Stephen Hart'),
(67, 'Hassan Benabicha'),
(68, 'Alberto Agustin Castillo Gallardo'),
(69, 'Antonio Israel Blake Cantero'),
(70, 'Winfried Schäfer'),
(71, 'Paul Le Guen'),
(72, 'Georgi Kondratjev'),
(73, 'Jean-Santos Muntubile Ndiela'),
(74, 'Milutin Sredojević'),
(75, 'Michael Andrew Martin O''Neill'),
(76, 'Stéphane Bounguendza'),
(77, 'Didier Six'),
(78, 'Neil Emblen'),
(79, 'Berti Vogts'),
(80, 'Magnus Pehrsson'),
(81, 'Didier Ollé-Nicolle'),
(82, 'Romeu Filemon'),
(83, 'Frank Jericho Nagbe'),
(84, 'Alain Perrin'),
(85, 'Ian Gorowa'),
(86, 'Hakeem Shakir Al Azzawi'),
(87, 'Hervé Lougoundji'),
(88, 'Adel Amrouche'),
(89, 'Marians Pahars'),
(90, 'Andoni Goikoetxea Olaskoaga'),
(91, 'Mohamed Abdallah Ahmed'),
(92, 'Pambos Christodoulou'),
(93, 'Ricardo Mannetti'),
(94, 'Van Phuc Hoang'),
(95, 'Sergio Enrique Pardo Valenzuela'),
(96, 'Mohammad Yousef Kargar'),
(97, 'Yury Krasnozhan'),
(98, 'Lotfy Naseem'),
(99, 'Thomas Dooley'),
(100, 'Roberto Gödeken'),
(101, 'Clark John'),
(102, 'Chris Coleman'),
(103, 'Volker Finke'),
(104, 'Michel Dussuyer'),
(105, 'Giovanni ''Gianni'' De Biasi'),
(106, 'Per-Mathias Høgmo'),
(107, 'Mika Matti ''Mixu'' Paatelainen'),
(108, 'Mahdi Ali Hassan Redha'),
(109, 'Lyuboslav Penev'),
(110, 'Martin O''Neill'),
(111, 'Boško Đurovski'),
(112, 'Temur Ketsbaia'),
(113, 'Djamel Belmadi'),
(114, 'Gernot Rohr'),
(115, 'Ion Caras'),
(116, 'Jorvan Vieira'),
(117, 'Clemente Domingo Hernández Heres'),
(118, 'Giuseppe Giannini'),
(119, 'Kim Poulsen'),
(120, 'Alain Moizan'),
(121, 'Luc Holtz'),
(122, 'Nikola Kavazović'),
(123, 'Jong-Su Yun'),
(124, 'Pietro Ghedin'),
(125, 'Eric Nshimiyimana'),
(126, 'Peter Pierre Benoit Johnson'),
(127, 'Claude Le Roy'),
(128, 'Igoris Pankratjevas'),
(129, 'Anthony Hudson'),
(130, 'Benito Floro Sanz'),
(131, 'João Chissano'),
(132, 'Cornelius Bernard Huggins'),
(133, 'Ýazguly Hojageldiýew'),
(134, 'Rolston Williams'),
(135, 'Pan-Gon Kim'),
(136, 'Walter Benitez'),
(137, 'Ahmad Al Shaar'),
(138, 'Eddy Etaeta'),
(139, 'Ian Andrew Mork'),
(140, 'Ong Kim Swee'),
(141, 'Francis Lastic'),
(142, 'Sergey Dvoryankov'),
(143, 'Surachai Jaturapattarapong'),
(144, 'Bernd Stange'),
(145, 'Jeaustin Campos Madriz'),
(146, 'Rene Pauritsch'),
(147, 'Wim Koevermans'),
(148, 'Alfred Riedl'),
(149, 'Patrice Neveu'),
(150, 'Jeffrey Hazel'),
(151, 'István Urbányi'),
(152, 'Mohammed Al Shamlan'),
(153, 'Giovanni Francesco Zacharias Franken'),
(154, 'Enrique Llena León'),
(155, 'Gary John White'),
(156, 'Percy Avock'),
(157, 'Malo Vaga'),
(158, 'Ali Mbaé Camara'),
(159, 'Kevin Davies'),
(160, 'Sami Hasan Saleh Al Hadi Al Nash'),
(161, 'Sandagdorj Erdenebat'),
(162, 'Franck Rajaonarisamba'),
(163, 'Chris Williams'),
(164, 'Carl Brown'),
(165, 'Avondale Williams'),
(166, 'Jesús Luis Álvarez de Eulate'),
(167, 'Negash Teklit Negassi'),
(168, 'Zoran Đorđević'),
(169, 'Jack Stefanowski'),
(170, 'Lars Christian Olsen'),
(171, 'Lodewijk de Kruif'),
(172, 'Jacob Moli'),
(173, 'Jamal Mahmoud Abed Mahmoud'),
(174, 'Andrew Bascome'),
(175, 'Modou Kouta'),
(176, 'Kuei-jen Chen'),
(177, 'Kokichi Kimura'),
(178, 'Radojko Avramović'),
(179, 'Cláudio Roberto Silveira'),
(180, 'Akbar Ebrahim Patel'),
(181, 'Jan Mak'),
(182, 'Ludwig Alberto'),
(183, 'Harris Bulunga'),
(184, 'Juan Carlos Buzzetti'),
(185, 'Sovannara Prak'),
(186, 'Kenny Dyer'),
(187, 'Ronnie Gustave'),
(188, 'Emerson Ricardo Alcântara'),
(189, 'Eustace Bailey'),
(190, 'Thomas Rongen'),
(191, 'Sui Wing Leung'),
(192, 'Alfred Imonje'),
(193, 'Kazunori Ohara'),
(194, 'Colin Forde'),
(195, 'Gustave Clément Nyoumba'),
(196, 'Oh-Son Kwon'),
(197, 'Colin Johnson');

--
-- Dumping data for table `continent`
--

INSERT INTO `continent` (`id`, `name`) VALUES
(1, '');

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `continent_id`, `abbreviation`) VALUES
(1, 'Afghanistan', 1, 'AFG'),
(2, 'Albania', 1, 'ALB'),
(3, 'Algeria', 1, 'ALG'),
(4, 'Andorra', 1, 'AND'),
(5, 'Angola', 1, 'ANG'),
(6, 'Anguilla', 1, 'AIA'),
(7, 'Antigua and Barbuda', 1, 'ATG'),
(8, 'Argentina', 1, 'ARG'),
(9, 'Armenia', 1, 'ARM'),
(10, 'Aruba', 1, 'ARU'),
(11, 'Austria', 1, 'AUT'),
(12, 'Azerbaijan', 1, 'AZE'),
(13, 'Bahamas', 1, 'BAH'),
(14, 'Bahrain', 1, 'BHR'),
(15, 'Bangladesh', 1, 'BAN'),
(16, 'Barbados', 1, 'BRB'),
(17, 'Belarus', 1, 'BLR'),
(18, 'Belgium', 1, 'BEL'),
(19, 'Belize', 1, 'BLZ'),
(20, 'Benin', 1, 'BEN'),
(21, 'Bermuda', 1, 'BER'),
(22, 'Bhutan', 1, 'BHU'),
(23, 'Bolivia', 1, 'BOL'),
(24, 'Bosnia-Herzegovina', 1, 'BIH'),
(25, 'Botswana', 1, 'BOT'),
(26, 'Brazil', 1, 'BRA'),
(27, 'British Virgin Islands', 1, 'VGB'),
(28, 'Brunei Darussalam', 1, 'BRU'),
(29, 'Bulgaria', 1, 'BUL'),
(30, 'Burkina Faso', 1, 'BFA'),
(31, 'Burundi', 1, 'BDI'),
(32, 'Cambodia', 1, 'CAM'),
(33, 'Cameroon', 1, 'CMR'),
(34, 'Cape Verde Islands', 1, 'CPV'),
(35, 'Cayman Islands', 1, 'CAY'),
(36, 'Central African Republic', 1, 'CTA'),
(37, 'Chad', 1, 'CHA'),
(38, 'Chile', 1, 'CHI'),
(39, 'China PR', 1, 'CHN'),
(40, 'Chinese Taipei', 1, 'TPE'),
(41, 'Colombia', 1, 'COL'),
(42, 'Comoros', 1, 'COM'),
(43, 'Congo', 1, 'CGO'),
(44, 'Congo DR', 1, 'COD'),
(45, 'Cook Islands', 1, 'COK'),
(46, 'Costa Rica', 1, 'CRC'),
(47, 'Côte d''Ivoire', 1, 'CIV'),
(48, 'Croatia', 1, 'CRO'),
(49, 'Cuba', 1, 'CUB'),
(50, 'Curaçao', 1, 'CUW'),
(51, 'Cyprus', 1, 'CYP'),
(52, 'Czech Republic', 1, 'CZE'),
(53, 'Denmark', 1, 'DEN'),
(54, 'Djibouti', 1, 'DJI'),
(55, 'Dominica', 1, 'DMA'),
(56, 'Dominican Republic', 1, 'DOM'),
(57, 'Ecuador', 1, 'ECU'),
(58, 'Egypt', 1, 'EGY'),
(59, 'El Salvador', 1, 'SLV'),
(60, 'England', 1, 'ENG'),
(61, 'Equatorial Guinea', 1, 'EQG'),
(62, 'Eritrea', 1, 'ERI'),
(63, 'Estonia', 1, 'EST'),
(64, 'Ethiopia', 1, 'ETH'),
(65, 'Faroe Islands', 1, 'FRO'),
(66, 'Fiji', 1, 'FIJ'),
(67, 'Finland', 1, 'FIN'),
(68, 'France', 1, 'FRA'),
(69, 'Gabon', 1, 'GAB'),
(70, 'Gambia', 1, 'GAM'),
(71, 'Georgia', 1, 'GEO'),
(72, 'Germany', 1, 'GER'),
(73, 'Ghana', 1, 'GHA'),
(74, 'Greece', 1, 'GRE'),
(75, 'Grenada', 1, 'GRN'),
(76, 'Guam', 1, 'GUM'),
(77, 'Guatemala', 1, 'GUA'),
(78, 'Guinea', 1, 'GUI'),
(79, 'Guinea-Bissau', 1, 'GNB'),
(80, 'Guyana', 1, 'GUY'),
(81, 'Haiti', 1, 'HAI'),
(82, 'Honduras', 1, 'HON'),
(83, 'Hong Kong', 1, 'HKG'),
(84, 'Hungary', 1, 'HUN'),
(85, 'Iceland', 1, 'ISL'),
(86, 'India', 1, 'IND'),
(87, 'Indonesia', 1, 'IDN'),
(88, 'Iran', 1, 'IRN'),
(89, 'Iraq', 1, 'IRQ'),
(90, 'Israel', 1, 'ISR'),
(91, 'Italy', 1, 'ITA'),
(92, 'Jamaica', 1, 'JAM'),
(93, 'Japan', 1, 'JPN'),
(94, 'Jordan', 1, 'JOR'),
(95, 'Kazakhstan', 1, 'KAZ'),
(96, 'Kenya', 1, 'KEN'),
(97, 'Korea DPR', 1, 'PRK'),
(98, 'Korea Republic', 1, 'KOR'),
(99, 'Kuwait', 1, 'KUW'),
(100, 'Kyrgyzstan', 1, 'KGZ'),
(101, 'Laos', 1, 'LAO'),
(102, 'Latvia', 1, 'LVA'),
(103, 'Lebanon', 1, 'LIB'),
(104, 'Lesotho', 1, 'LES'),
(105, 'Liberia', 1, 'LBR'),
(106, 'Libya', 1, 'LBY'),
(107, 'Liechtenstein', 1, 'LIE'),
(108, 'Lithuania', 1, 'LTU'),
(109, 'Luxembourg', 1, 'LUX'),
(110, 'Macao', 1, 'MAC'),
(111, 'Macedonia FYR', 1, 'MKD'),
(112, 'Madagascar', 1, 'MAD'),
(113, 'Malawi', 1, 'MWI'),
(114, 'Malaysia', 1, 'MAS'),
(115, 'Maldives', 1, 'MDV'),
(116, 'Mali', 1, 'MLI'),
(117, 'Malta', 1, 'MLT'),
(118, 'Mauritania', 1, 'MTN'),
(119, 'Mauritius', 1, 'MRI'),
(120, 'Mexico', 1, 'MEX'),
(121, 'Moldova', 1, 'MDA'),
(122, 'Mongolia', 1, 'MNG'),
(123, 'Montenegro', 1, 'MNE'),
(124, 'Montserrat', 1, 'MSR'),
(125, 'Morocco', 1, 'MAR'),
(126, 'Mozambique', 1, 'MOZ'),
(127, 'Myanmar', 1, 'MYA'),
(128, 'Namibia', 1, 'NAM'),
(129, 'Nepal', 1, 'NEP'),
(130, 'Netherlands', 1, 'NED'),
(131, 'New Caledonia', 1, 'NCL'),
(132, 'New Zealand', 1, 'NZL'),
(133, 'Nicaragua', 1, 'NCA'),
(134, 'Niger', 1, 'NIG'),
(135, 'Nigeria', 1, 'NGA'),
(136, 'Northern Ireland', 1, 'NIR'),
(137, 'Norway', 1, 'NOR'),
(138, 'Oman', 1, 'OMA'),
(139, 'Pakistan', 1, 'PAK'),
(140, 'Palestine', 1, 'PLE'),
(141, 'Panama', 1, 'PAN'),
(142, 'Papua New Guinea', 1, 'PNG'),
(143, 'Paraguay', 1, 'PAR'),
(144, 'Peru', 1, 'PER'),
(145, 'Philippines', 1, 'PHI'),
(146, 'Poland', 1, 'POL'),
(147, 'Portugal', 1, 'POR'),
(148, 'Puerto Rico', 1, 'PUR'),
(149, 'Qatar', 1, 'QAT'),
(150, 'Ireland Republic', 1, 'IRL'),
(151, 'Romania', 1, 'ROU'),
(152, 'Russia', 1, 'RUS'),
(153, 'Rwanda', 1, 'RWA'),
(154, 'St. Kitts and Nevis', 1, 'SKN'),
(155, 'St. Lucia', 1, 'LCA'),
(156, 'St. Vincent and the Grenadines', 1, 'VIN'),
(157, 'San Marino', 1, 'SMR'),
(158, 'São Tomé e Príncipe', 1, 'STP'),
(159, 'Saudi Arabia', 1, 'KSA'),
(160, 'Scotland', 1, 'SCO'),
(161, 'Senegal', 1, 'SEN'),
(162, 'Serbia', 1, 'SRB'),
(163, 'Seychelles', 1, 'SEY'),
(164, 'Sierra Leone', 1, 'SLE'),
(165, 'Singapore', 1, 'SIN'),
(166, 'Slovakia', 1, 'SVK'),
(167, 'Slovenia', 1, 'SVN'),
(168, 'Solomon Islands', 1, 'SOL'),
(169, 'Somalia', 1, 'SOM'),
(170, 'South Africa', 1, 'RSA'),
(171, 'Spain', 1, 'ESP'),
(172, 'Sri Lanka', 1, 'SRI'),
(173, 'Sudan', 1, 'SDN'),
(174, 'South Sudan', 1, 'SSD'),
(175, 'Suriname', 1, 'SUR'),
(176, 'Swaziland', 1, 'SWZ'),
(177, 'Sweden', 1, 'SWE'),
(178, 'Switzerland', 1, 'SUI'),
(179, 'Syria', 1, 'SYR'),
(180, 'Tahiti', 1, 'TAH'),
(181, 'Tajikistan', 1, 'TJK'),
(182, 'Tanzania', 1, 'TAN'),
(183, 'Thailand', 1, 'THA'),
(184, 'Timor-Leste', 1, 'TLS'),
(185, 'Togo', 1, 'TOG'),
(186, 'Tonga', 1, 'TGA'),
(187, 'Trinidad and Tobago', 1, 'TRI'),
(188, 'Tunisia', 1, 'TUN'),
(189, 'Turkey', 1, 'TUR'),
(190, 'Turkmenistan', 1, 'TKM'),
(191, 'Turks and Caicos Islands', 1, 'TCA'),
(192, 'Uganda', 1, 'UGA'),
(193, 'Ukraine', 1, 'UKR'),
(194, 'United Arab Emirates', 1, 'UAE'),
(195, 'Uruguay', 1, 'URU'),
(196, 'Uzbekistan', 1, 'UZB'),
(197, 'Vanuatu', 1, 'VAN'),
(198, 'Venezuela', 1, 'VEN'),
(199, 'Vietnam', 1, 'VIE'),
(200, 'Wales', 1, 'WAL'),
(201, 'Yemen', 1, 'YEM'),
(202, 'Zambia', 1, 'ZAM'),
(203, 'Zimbabwe', 1, 'ZIM'),
(204, 'Bonaire', 1, 'BOE'),
(205, 'French Guiana', 1, 'GYF'),
(206, 'Gibraltar', 1, 'GIB'),
(207, 'Guadeloupe', 1, 'GPE'),
(208, 'Martinique', 1, 'MTQ'),
(209, 'Réunion', 1, 'REU'),
(210, 'Sint Maarten', 1, 'SXM'),
(211, 'Tuvalu', 1, 'TUV'),
(212, 'Zanzibar', 1, 'ZAN'),
(213, 'Kosovo', 1, 'KOS'),
(214, 'Federated States of Micronesia', 1, 'FSM'),
(215, 'Niue', 1, 'NIU'),
(216, 'Northern Mariana Islands', 1, 'NMI'),
(217, 'Palau', 1, 'PLW'),
(218, 'Saint-Martin', 1, 'SMT'),
(219, 'Aden', 1, 'ADE'),
(220, 'British Guiana', 1, 'BGU'),
(221, 'British Honduras', 1, 'BHO'),
(222, 'British India', 1, 'BIN'),
(223, 'Bohemia', 1, 'BOH'),
(224, 'Burma', 1, 'BUR'),
(225, 'Ceylon', 1, 'CEY'),
(226, 'Commonwealth of Independent States', 1, 'CIS'),
(227, 'Congo-Kinshasa', 1, 'CKN'),
(228, 'Congo-Brazzaville', 1, 'COB'),
(229, 'Czechoslovakia', 1, 'TCH'),
(230, 'Dahomey', 1, 'DAH'),
(231, 'Dutch East Indies', 1, 'DEI'),
(232, 'East Germany', 1, 'GDR'),
(233, 'Gold Coast', 1, 'GOC'),
(234, 'Ireland', 1, 'EIR'),
(235, 'Netherlands Antilles', 1, 'ANT'),
(236, 'New Hebrides', 1, 'HEB'),
(237, 'North Vietnam', 1, 'VNO'),
(238, 'North Yemen', 1, 'NYE'),
(239, 'Northern Rhodesia', 1, 'NRH'),
(240, 'Palestine, British Mandate', 1, 'PAL'),
(241, 'Rhodesia', 1, 'RHO'),
(242, 'Saar', 1, 'SAA'),
(243, 'Serbia and Montenegro', 1, 'SCG'),
(244, 'Siam', 1, 'SIA'),
(245, 'Southern Rhodesia', 1, 'SRH'),
(246, 'South Vietnam', 1, 'VSO'),
(247, 'South Yemen', 1, 'SYE'),
(248, 'Soviet Union', 1, 'URS'),
(249, 'Tanganyika', 1, 'TAA'),
(250, 'Taiwan', 1, 'TAI'),
(251, 'United Arab Republic', 1, 'UAR'),
(252, 'Upper Volta', 1, 'UPV'),
(253, 'West Germany', 1, 'FRG'),
(254, 'Yugoslavia', 1, 'YUG'),
(255, 'Zaire', 1, 'ZAI'),
(256, 'North Borneo', 1, 'NBO'),
(257, 'American Samoa', 1, 'ASA'),
(258, 'Australia', 1, 'AUS'),
(259, 'Canada', 1, 'CAN'),
(260, 'Samoa', 1, 'SAM'),
(261, 'United States', 1, 'USA'),
(262, 'US Virgin Islands', 1, 'VIR'),
(263, 'Western Samoa', 1, 'WSM'),
(264, 'Bosnia and Herzegovina', 1, 'BIH'),
(265, 'Cape Verde', 1, 'CPV'),
(266, 'North Korea', 1, 'PRK'),
(267, 'South Korea', 1, 'KOR'),
(268, 'Macau', 1, 'MAC'),
(269, 'Macedonia', 1, 'MKD'),
(270, 'Republic of Ireland', 1, 'IRL'),
(271, 'Saint Kitts and Nevis', 1, 'SKN'),
(272, 'Saint Lucia', 1, 'LCA'),
(273, 'Saint Vincent and the Grenadines', 1, 'VIN'),
(274, 'U.S. Virgin Islands', 1, 'VIR'),
(275, 'São Tomé and Príncipe', 1, 'STP'),
(276, 'Brunei', 1, 'BRU');

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `country_id`, `coach_id`, `fifapoints`) VALUES
(1, 'Spain', 171, 1, 1510),
(2, 'Germany', 72, 2, 1336),
(3, 'Argentina', 8, 3, 1234),
(4, 'Portugal', 147, 4, 1199),
(5, 'Colombia', 41, 5, 1183),
(6, 'Uruguay', 195, 6, 1126),
(7, 'Switzerland', 178, 7, 1123),
(8, 'Italy', 91, 8, 1112),
(9, 'Brazil', 26, 9, 1104),
(10, 'Belgium', 18, 10, 1084),
(11, 'Netherlands', 130, 11, 1077),
(12, 'England', 60, 12, 1045),
(13, 'Greece', 74, 13, 1038),
(14, 'United States', 261, 14, 1017),
(15, 'Chile', 38, 15, 998),
(16, 'Croatia', 48, 16, 955),
(17, 'France', 68, 17, 929),
(18, 'Ukraine', 193, 18, 911),
(19, 'Russia', 152, 19, 889),
(20, 'Mexico', 120, 20, 888),
(21, 'Denmark', 53, 21, 858),
(22, 'Côte d''Ivoire', 47, 22, 839),
(23, 'Algeria', 3, 23, 819),
(24, 'Egypt', 58, 24, 790),
(25, 'Sweden', 177, 25, 789),
(26, 'Serbia', 162, 26, 762),
(27, 'Panama', 141, 27, 755),
(28, 'Czech Republic', 52, 28, 748),
(29, 'Slovenia', 167, 29, 746),
(30, 'Romania', 151, 30, 740),
(31, 'Cape Verde Islands', 34, 31, 739),
(32, 'Costa Rica', 46, 32, 732),
(33, 'Ghana', 73, 33, 729),
(34, 'Honduras', 82, 34, 725),
(35, 'Scotland', 160, 35, 721),
(36, 'Turkey', 189, 36, 710),
(37, 'Venezuela', 198, 37, 704),
(38, 'Peru', 144, 38, 703),
(39, 'Armenia', 9, 39, 699),
(40, 'Iran', 88, 40, 692),
(41, 'Hungary', 84, 41, 652),
(42, 'Tunisia', 188, 42, 641),
(43, 'Austria', 11, 43, 641),
(44, 'Montenegro', 123, 44, 639),
(45, 'Nigeria', 135, 45, 626),
(46, 'Japan', 93, 46, 622),
(47, 'Slovakia', 166, 47, 588),
(48, 'Iceland', 85, 48, 582),
(49, 'Uzbekistan', 196, 49, 565),
(50, 'Mali', 116, 50, 561),
(51, 'Paraguay', 143, 51, 554),
(52, 'Bosnia-Herzegovina', 24, 52, 863),
(53, 'Ecuador', 57, 53, 855),
(54, 'Korea Republic', 97, 54, 552),
(55, 'Burkina Faso', 30, 55, 548),
(56, 'Australia', 258, 56, 545),
(57, 'South Africa', 170, 57, 536),
(58, 'Israel', 90, 58, 526),
(59, 'Jordan', 94, 59, 521),
(60, 'Senegal', 161, 60, 512),
(61, 'Libya', 106, 61, 508),
(62, 'Sierra Leone', 164, 62, 481),
(63, 'Poland', 146, 63, 475),
(64, 'Zambia', 202, 64, 458),
(65, 'Saudi Arabia', 159, 65, 453),
(66, 'Trinidad and Tobago', 187, 66, 446),
(67, 'Morocco', 125, 67, 443),
(68, 'El Salvador', 59, 68, 438),
(69, 'Haiti', 81, 69, 430),
(70, 'Jamaica', 92, 70, 429),
(71, 'Oman', 138, 71, 426),
(72, 'Belarus', 17, 72, 420),
(73, 'Congo DR', 44, 73, 392),
(74, 'Uganda', 192, 74, 391),
(75, 'Northern Ireland', 136, 75, 388),
(76, 'Gabon', 69, 76, 381),
(77, 'Togo', 185, 77, 377),
(78, 'New Zealand', 132, 78, 373),
(79, 'Azerbaijan', 12, 79, 369),
(80, 'Estonia', 63, 80, 367),
(81, 'Benin', 20, 81, 357),
(82, 'Angola', 5, 82, 348),
(83, 'Liberia', 105, 83, 347),
(84, 'China PR', 39, 84, 339),
(85, 'Zimbabwe', 203, 85, 328),
(86, 'Iraq', 89, 86, 317),
(87, 'Central African Republic', 36, 87, 310),
(88, 'Kenya', 96, 88, 293),
(89, 'Latvia', 102, 89, 265),
(90, 'Equatorial Guinea', 61, 90, 251),
(91, 'Sudan', 173, 91, 236),
(92, 'Cyprus', 51, 92, 236),
(93, 'Namibia', 128, 93, 227),
(94, 'Vietnam', 199, 94, 224),
(95, 'Guatemala', 77, 95, 219),
(96, 'Afghanistan', 1, 96, 213),
(97, 'Kazakhstan', 95, 97, 213),
(98, 'Burundi', 31, 98, 211),
(99, 'Philippines', 145, 99, 200),
(100, 'Suriname', 175, 100, 197),
(101, 'Grenada', 75, 101, 192),
(102, 'Wales', 200, 102, 609),
(103, 'Cameroon', 33, 103, 588),
(104, 'Guinea', 78, 104, 572),
(105, 'Albania', 2, 105, 569),
(106, 'Norway', 137, 106, 559),
(107, 'Finland', 67, 107, 556),
(108, 'UAE', 194, 108, 550),
(109, 'Bulgaria', 29, 109, 518),
(110, 'Republic of Ireland', 150, 110, 513),
(111, 'Macedonia FYR', 111, 111, 421),
(112, 'Georgia', 71, 112, 333),
(113, 'Qatar', 149, 113, 330),
(114, 'Niger', 134, 114, 315),
(115, 'Moldova', 121, 115, 303),
(116, 'Kuwait', 99, 116, 287),
(117, 'Dominican Republic', 56, 117, 282),
(118, 'Lebanon', 103, 118, 254),
(119, 'Tanzania', 182, 119, 253),
(120, 'New Caledonia', 131, 120, 252),
(121, 'Luxembourg', 109, 121, 242),
(122, 'Tajikistan', 181, 122, 237),
(123, 'Korea DPR', 97, 123, 191),
(124, 'Malta', 117, 124, 186),
(125, 'Rwanda', 153, 125, 186),
(126, 'Gambia', 70, 126, 184),
(127, 'Congo', 43, 127, 382),
(128, 'Lithuania', 108, 128, 314),
(129, 'Bahrain', 14, 129, 312),
(130, 'Canada', 259, 130, 279),
(131, 'Mozambique', 126, 131, 258),
(132, 'St. Vincent / Grenadines', 156, 132, 177),
(133, 'Turkmenistan', 190, 133, 166),
(134, 'Antigua and Barbuda', 7, 134, 159),
(135, 'Hong Kong', 83, 135, 156),
(136, 'Cuba', 49, 136, 362),
(137, 'Syria', 179, 137, 183),
(138, 'Tahiti', 180, 138, 179),
(139, 'Belize', 19, 139, 176),
(140, 'Malaysia', 114, 140, 175),
(141, 'St. Lucia', 155, 141, 155),
(142, 'Kyrgyzstan', 100, 142, 155),
(143, 'Thailand', 183, 143, 151),
(144, 'Singapore', 165, 144, 144),
(145, 'Puerto Rico', 148, 145, 143),
(146, 'Liechtenstein', 107, 146, 139),
(147, 'India', 86, 147, 138),
(148, 'Indonesia', 87, 148, 128),
(149, 'Mauritania', 118, 149, 127),
(150, 'St. Kitts and Nevis', 154, 150, 125),
(151, 'Maldives', 115, 151, 114),
(152, 'Pakistan', 139, 152, 107),
(153, 'Aruba', 10, 153, 87),
(154, 'Nicaragua', 133, 154, 84),
(155, 'Guam', 76, 155, 68),
(156, 'Vanuatu', 197, 156, 55),
(157, 'Samoa', 260, 157, 45),
(158, 'Comoros', 42, 158, 41),
(159, 'Bahamas', 13, 159, 40),
(160, 'Yemen', 201, 160, 40),
(161, 'Mongolia', 122, 161, 38),
(162, 'Madagascar', 112, 162, 30),
(163, 'Tonga', 186, 163, 26),
(164, 'Cayman Islands', 35, 164, 21),
(165, 'British Virgin Islands', 27, 165, 18),
(166, 'Andorra', 4, 166, 15),
(167, 'Eritrea', 62, 167, 11),
(168, 'South Sudan', 174, 168, 10),
(169, 'Nepal', 129, 169, 102),
(170, 'Faroe Islands', 65, 170, 87),
(171, 'Bangladesh', 15, 171, 87),
(172, 'Solomon Islands', 168, 172, 86),
(173, 'Palestine', 140, 173, 85),
(174, 'Bermuda', 21, 174, 83),
(175, 'Chad', 37, 175, 81),
(176, 'Chinese Taipei', 40, 176, 76),
(177, 'Laos', 101, 177, 73),
(178, 'Myanmar', 127, 178, 68),
(179, 'Sri Lanka', 172, 179, 68),
(180, 'Mauritius', 119, 180, 66),
(181, 'Seychelles', 163, 181, 66),
(182, 'Curaçao', 50, 182, 65),
(183, 'Swaziland', 176, 183, 63),
(184, 'Fiji', 66, 184, 47),
(185, 'Cambodia', 32, 185, 33),
(186, 'Montserrat', 124, 186, 33),
(187, 'Dominica', 55, 187, 103),
(188, 'Timor-Leste', 184, 188, 26),
(189, 'US Virgin Islands', 262, 189, 23),
(190, 'American Samoa', 257, 190, 18),
(191, 'Macao', 110, 191, 9),
(192, 'Somalia', 169, 192, 8),
(193, 'Bhutan', 22, 193, 0),
(194, 'Barbados', 16, 194, 101),
(195, 'São Tomé e Príncipe', 158, 195, 86),
(196, 'Brunei', 28, 196, 26),
(197, 'Anguilla', 6, 197, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
