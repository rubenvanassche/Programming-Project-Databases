-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2014 at 10:53 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `injured` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=144 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `name`, `injured`) VALUES
(1, 'Iker Casillas Fernández', 0),
(2, 'José Manuel Reina Páez', 0),
(3, 'Víctor Valdés Arribas', 0),
(4, 'Sergio Ramos García', 0),
(5, 'Juan Francisco Torres Belén', 0),
(6, 'Raúl Albiol Tortajada', 0),
(7, 'César Azpilicueta Tanco', 0),
(8, 'Jordi Alba Ramos', 0),
(9, 'Francesc Fàbregas i Soler', 0),
(10, 'Andrés Iniesta Luján', 0),
(11, 'Xabier Alonso Olana', 0),
(12, 'Xavier Hernández Creus', 0),
(13, 'David Josué Jiménez Silva', 0),
(14, 'Javier Martínez Aginaga', 0),
(15, 'Jesús Navas González', 0),
(16, 'Santiago Cazorla González', 0),
(17, 'Sergio Busquets i Burgos', 0),
(18, 'Thiago Alcântara do Nascimiento', 0),
(19, 'Jorge Resurreción Merodio', 0),
(20, 'Álvaro Negredo Sánchez', 0),
(21, 'Diego Da Silva Costa', 0),
(22, 'Pedro Eliezer Rodríguez Ledesma', 0),
(23, 'Roman Weidenfeller', 0),
(24, 'Manuel Neuer', 0),
(25, 'Marcell Jansen', 0),
(26, 'Philipp Lahm', 0),
(27, 'Per Mertesacker', 0),
(28, 'Jérôme Boateng', 0),
(29, 'Marcel Schmelzer', 0),
(30, 'Shkodran Mustafi', 0),
(31, 'Matthias Ginter', 0),
(32, 'Bastian Schweinsteiger', 0),
(33, 'Mesut Özil', 0),
(34, 'Toni Kroos', 0),
(35, 'Kevin Großkreutz', 0),
(36, 'André Hahn', 0),
(37, 'Mario Götze', 0),
(38, 'Miroslav Klose', 0),
(39, 'Lukas Podolski', 0),
(40, 'André Schürrle', 0),
(41, 'Mariano Gonzalo Andújar', 0),
(42, 'Agustín Ignacio Orión', 0),
(43, 'Sergio Germán Romero', 0),
(44, 'Pablo Javier Zabaleta Girod', 0),
(45, 'Ezequiel Marcelo Garay', 0),
(46, 'José María Basanta', 0),
(47, 'Hugo Armando Campagnaro', 0),
(48, 'Federico Fernández', 0),
(49, 'Nicolás Hernán Otamendi', 0),
(50, 'Faustino Marcos Alberto Rojo', 0),
(51, 'Lisandro Ezequiel López', 0),
(52, 'Gino Peruzzi Lucchetti', 0),
(53, 'Javier Alejandro Mascherano', 0),
(54, 'Maximiliano Rubén ''Maxi'' Rodríguez', 0),
(55, 'Lucas Rodrigo Biglia', 0),
(56, 'Fernando Rubén Gago', 0),
(57, 'Augusto Matías Fernández', 0),
(58, 'José Ernesto Sosa', 0),
(59, 'Ángel Fabián di María Hernández', 0),
(60, 'Éver Maximiliano David Banega', 0),
(61, 'Ricardo Gabriel Álvarez', 0),
(62, 'Rodrigo Sebastián Palacio', 0),
(63, 'Lionel Andrés Messi Cuccittini', 0),
(64, 'Sergio Leonel Agüero del Castillo', 0),
(65, 'Gonzalo Gerardo Higuaín', 0),
(66, 'Ezequiel Iván Lavezzi', 0),
(67, 'António Alberto Bastos Pimparel', 0),
(68, 'Eduardo dos Reis Carvalho', 0),
(69, 'Anthony Lopes', 0),
(70, 'Fábio Alexandre da Silva Coentrão', 0),
(71, 'João Pedro da Silva Pereira', 0),
(72, 'Rolando Jorge Pires da Fonseca', 0),
(73, 'Vitorino Gabriel Pacheco Antunes', 0),
(74, 'Hugo Miguel Almeida Costa Lopes', 0),
(75, 'Luis Carlos Novo Neto', 0),
(76, 'Raul José Trindade Meireles', 0),
(77, 'Miguel Luís Pinto Veloso', 0),
(78, 'João Filipe Iria Santos Moutinho', 0),
(79, 'Josue Filipe Soares Pesqueira', 0),
(80, 'William Silva Carvalho', 0),
(81, 'Rafael Alexandre Fernandes Ferreira da Silva', 0),
(82, 'Cristiano Ronaldo dos Santos Aveiro', 0),
(83, 'Arnaldo Edi Lopes da Silva', 0),
(84, 'Silvestre Manuel Gonçalves Varela', 0),
(85, 'Ivan Ricardo Neves Abreu Cavaleiro', 0),
(86, 'Faryd Camilo Mondragón Aly', 0),
(87, 'David Ospina Ramírez', 0),
(88, 'Camilo Andrés Vargas Gil', 0),
(89, 'Mario Alberto Yepes Díaz', 0),
(90, 'Luis Amaranto Perea Mosquera', 0),
(91, 'Cristian Eduardo Zapata Valencia', 0),
(92, 'Pablo Estífer Armero', 0),
(93, 'Santiago Arias Naranjo', 0),
(94, 'John Steffan Medina Ramírez', 0),
(95, 'Eder Fabián Álvarez Balanta', 0),
(96, 'Abel Enrique Aguilar Tapia', 0),
(97, 'Macnelly Torres Berrío', 0),
(98, 'Carlos Alberto Sánchez Moreno', 0),
(99, 'Edwin Armando Valencia Rodríguez', 0),
(100, 'Aldo Leao Ramírez Sierra', 0),
(101, 'Alexander Mejía Sabalsa', 0),
(102, 'Fredy Alejandro Guarín Vásquez', 0),
(103, 'Juan Guillermo Cuadrado Bello', 0),
(104, 'James David Rodríguez Rubio', 0),
(105, 'Juan Fernando Quintero Paniagua', 0),
(106, 'Teófilo Antonio Gutiérrez Roncancio', 0),
(107, 'Gustavo Adrián Ramos Vásquez', 0),
(108, 'Segundo Víctor Ibarbo Guerrero', 0),
(109, 'Carlos Arturo Bacca Ahumada', 0),
(110, 'Luis Fernando Muriel Fruto', 0),
(111, 'Néstor Fernando Muslera Micol', 0),
(112, 'Martín Andrés Silva Leites', 0),
(113, 'Diego Alfredo Lugano Morena', 0),
(114, 'Jorge Ciro Fucile Perdomo', 0),
(115, 'Victorio Maximiliano Pereira Páez', 0),
(116, 'Diego Roberto Godín Leal', 0),
(117, 'Álvaro Daniel Pereira Barragán', 0),
(118, 'José María Giménez de Vargas', 0),
(119, 'Diego Fernando Pérez Aguado', 0),
(120, 'Cristian Gabriel Rodríguez Barrotti', 0),
(121, 'Walter Alejandro Gargano Guevara', 0),
(122, 'Álvaro Rafael González Luengo', 0),
(123, 'Egídio Raúl Arévalo Ríos', 0),
(124, 'Marcelo Nicolás Lodeiro Benítez', 0),
(125, 'Gastón Exequiel Ramírez Pereyra', 0),
(126, 'Alejandro Daniel Silva González', 0),
(127, 'Luis Alberto Suárez Díaz', 0),
(128, 'Diego Forlán Corazo', 0),
(129, 'Cristhian Ricardo Stuani Curbelo', 0),
(130, 'Diego Benaglio', 0),
(131, 'Yann Sommer', 0),
(132, 'Johan Danon Djourou-Gbadjere', 0),
(133, 'Philippe Senderos', 0),
(134, 'Stephan Lichtsteiner', 0),
(135, 'Steve von Bergen', 0),
(136, 'Michael Lang', 0),
(137, 'Ricardo Rodriguez', 0),
(138, 'Tranquillo Barnetta', 0),
(139, 'Valon Behrami', 0),
(140, 'Blerim Džemaili', 0),
(141, 'Pirmin Schwegler', 0),
(142, 'Gelson Fernandes', 0),
(143, 'Gökhan ?nler', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
