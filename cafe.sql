-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 14 nov. 2024 à 02:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cafe`
--

-- --------------------------------------------------------

--
-- Structure de la table `bonn`
--

CREATE TABLE `bonn` (
  `ididrecetes` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `stockinitial` int(11) NOT NULL,
  `stockdeadmine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `bonn`
--

INSERT INTO `bonn` (`ididrecetes`, `quantite`, `stockinitial`, `stockdeadmine`) VALUES
(51, 4, 3000, 44),
(52, 7, 2964, 0),
(53, 5, 2910, 0),
(54, 34, 2865, 0),
(55, 0, 2739, 0),
(56, 0, 2739, 0),
(57, 0, 2739, 0),
(58, 0, 2739, 0),
(59, 0, 2739, 0),
(60, 0, 2739, 0),
(61, 0, 2739, 0),
(62, 0, 2739, 0),
(63, 0, 2739, 0),
(64, 6, 2739, 0),
(67, 7, 2685, 0),
(69, 6, 2622, 0),
(71, 0, 2568, 0),
(72, 0, 2568, 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `item` varchar(50) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `item`, `prix`, `type`) VALUES
(1, 'Express', 1700.00, 'aboir'),
(2, 'Capucin', 2000.00, 'aboir'),
(3, 'Cafe Creme', 2300.00, 'aboir'),
(4, 'Cappuccino', 4000.00, 'aboir'),
(5, 'Americaine', 2000.00, 'aboir'),
(6, 'Cafe Turc', 2500.00, 'aboir'),
(7, 'Cafe Chokolat', 2200.00, 'aboir'),
(8, 'Chocolat Chaud', 4000.00, 'aboir'),
(9, 'The A La Menthe', 1300.00, 'aboir'),
(10, 'The Aux Menthe', 4000.00, 'aboir'),
(11, 'The Aux Pignons', 5000.00, 'aboir'),
(12, 'Canette', 2500.00, 'aboir'),
(13, 'Eau 1/2L', 1200.00, 'aboir'),
(14, 'Eau 1L', 1800.00, 'aboir'),
(15, 'Citronade', 3500.00, 'aboir'),
(16, 'Citronade Menthe', 4000.00, 'aboir'),
(17, 'Citronade Amenthes', 5000.00, 'aboir'),
(18, 'Mojito', 6000.00, 'aboir'),
(19, 'Lait De Poule', 5000.00, 'aboir'),
(20, 'Jus De Orange', 3000.00, 'aboir'),
(21, 'Cocktail De Fruit', 5000.00, 'aboir'),
(22, 'Cocktail La Zone', 6000.00, 'aboir'),
(23, 'Croissant ', 1500.00, 'manger'),
(24, 'Gateau', 2200.00, 'manger'),
(25, 'Chicha Chikh', 4500.00, 'dokhan'),
(26, 'Chicha Fakher', 6000.00, 'dokhan'),
(27, 'Chicha Turc', 8000.00, 'dokhan'),
(28, 'Chicha Glacon', 10000.00, 'dokhan'),
(29, '', 0.00, ''),
(30, 'Legere', 350.00, 'dokhan'),
(31, 'Paket Legere', 6500.00, 'dokhan'),
(32, 'MontiCarlo', 450.00, 'dokhan'),
(33, 'Paket MontiCarlo', 8500.00, 'dokhan'),
(34, 'Mars Legere', 300.00, 'dokhan'),
(35, 'Paket Mars legere', 5000.00, 'dokhan'),
(36, 'Danhit', 350.00, 'dokhan'),
(37, 'Paket Danhit', 6500.00, 'dokhan'),
(38, 'Kamel', 550.00, 'dokhan'),
(39, 'Paket Kamel', 10000.00, 'dokhan'),
(40, 'Mirit / Malboro', 600.00, 'dokhan'),
(41, 'Paket Mirit / Malboro', 11000.00, 'dokhan'),
(42, 'Oris / Karillia / قوافل', 200.00, 'dokhan'),
(43, 'Paket Oris / Karillia / قوافل', 3500.00, 'dokhan'),
(44, 'Oris Double Fusion', 250.00, 'dokhan'),
(45, 'Paket Oris Double Fusion', 4000.00, 'dokhan'),
(46, 'Safir', 250.00, 'dokhan'),
(47, 'Paket Safir', 5000.00, 'dokhan'),
(48, 'Kamel Slims', 300.00, 'dokhan'),
(49, 'Paket Kamel Slims', 6000.00, 'dokhan'),
(50, 'Cristal', 150.00, 'dokhan'),
(51, 'Paket Cristal', 2500.00, 'dokhan'),
(52, 'Karillia Slimse', 350.00, 'dokhan'),
(53, 'Paket Calillia Slims', 350.00, 'dokhan');

-- --------------------------------------------------------

--
-- Structure de la table `recete`
--

CREATE TABLE `recete` (
  `idrecete` int(11) NOT NULL,
  `nomproduit` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `prix_totale_de_produit` decimal(10,2) NOT NULL,
  `ididrecetes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `recete`
--

INSERT INTO `recete` (`idrecete`, `nomproduit`, `quantity`, `prix_totale_de_produit`, `ididrecetes`) VALUES
(1, 'Express', 2, 3400.00, 51),
(2, 'Cafe Creme', 1, 2300.00, 51),
(3, 'Capucin', 1, 2000.00, 51),
(4, 'The Aux Menthe', 1, 4000.00, 51),
(5, 'Canette', 3, 7500.00, 51),
(6, 'Gateau', 1, 2200.00, 51),
(7, 'Cafe Creme', 1, 2300.00, 52),
(8, 'Express', 3, 5100.00, 52),
(9, 'Capucin', 2, 4000.00, 52),
(10, 'Cappuccino', 1, 4000.00, 52),
(11, 'Cafe Creme', 2, 4600.00, 53),
(12, 'Capucin', 3, 6000.00, 53),
(13, 'Cafe Turc', 5, 12500.00, 53),
(14, 'Chicha Glacon', 4, 40000.00, 53),
(15, 'Chicha Fakher', 5, 30000.00, 53),
(16, 'Chicha Chikh', 5, 22500.00, 54),
(17, 'Legere', 15, 5250.00, 54),
(18, 'Capucin', 2, 4000.00, 54),
(19, 'Cafe Turc', 4, 10000.00, 54),
(20, 'Cafe Creme', 5, 11500.00, 54),
(21, 'Americaine', 8, 16000.00, 54),
(22, 'Express', 7, 11900.00, 54),
(23, 'Cappuccino', 12, 48000.00, 54),
(24, 'The A La Menthe', 1, 1300.00, 54),
(25, 'Paket Legere', 4, 26000.00, 55),
(26, 'Chicha Turc', 1, 8000.00, 55),
(27, 'Paket Legere', 4, 26000.00, 56),
(28, 'Paket Legere', 2, 13000.00, 57),
(29, 'Paket Legere', 5, 32500.00, 58),
(30, 'Mars Legere', 1, 300.00, 59),
(31, 'Paket Danhit', 1, 6500.00, 59),
(32, 'Paket MontiCarlo', 1, 8500.00, 59),
(33, 'Paket MontiCarlo', 2, 17000.00, 60),
(34, 'Paket Kamel', 1, 10000.00, 61),
(35, 'Paket Kamel', 1, 10000.00, 62),
(36, 'Paket Kamel', 1, 10000.00, 63),
(37, 'Capucin', 6, 12000.00, 64),
(38, 'Express', 7, 11900.00, 67),
(39, 'Express', 1, 1700.00, NULL),
(40, 'Express', 2, 3400.00, NULL),
(41, 'Express', 21, 35700.00, 69),
(42, 'Chicha Chikh', 36, 162000.00, 69),
(43, 'Chicha Turc', 120, 960000.00, 69),
(44, 'Cafe Creme', 36, 82800.00, 70),
(45, 'Chicha Chikh', 4, 18000.00, 71),
(46, 'Paket Mirit / Malboro', 1, 11000.00, NULL),
(47, 'Paket Mirit / Malboro', 2, 22000.00, NULL),
(48, 'Paket Mirit / Malboro', 3, 33000.00, 72);

-- --------------------------------------------------------

--
-- Structure de la table `recetes`
--

CREATE TABLE `recetes` (
  `idrecetes` int(11) NOT NULL,
  `nomserveur` varchar(255) NOT NULL,
  `dateentree` datetime NOT NULL,
  `datesortie` datetime DEFAULT NULL,
  `prixtotale` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `recetes`
--

INSERT INTO `recetes` (`idrecetes`, `nomserveur`, `dateentree`, `datesortie`, `prixtotale`) VALUES
(51, 'hamza', '2024-11-12 23:50:51', '2024-11-12 22:51:14', 21400.00),
(52, 'hamza', '2024-11-13 01:29:15', '2024-11-13 00:29:18', 15400.00),
(53, 'aziz', '2024-11-13 02:54:25', '2024-11-13 01:54:36', 93100.00),
(54, 'oussema ', '2024-11-13 03:43:06', '2024-11-13 02:43:30', 130450.00),
(55, 'salah', '2024-11-13 03:49:53', '2024-11-13 02:50:03', 34000.00),
(56, 'salah', '2024-11-13 03:58:50', '2024-11-13 02:59:29', 26000.00),
(57, 'hamza', '2024-11-13 04:04:13', '2024-11-13 03:04:17', 13000.00),
(58, 'aziz', '2024-11-13 04:05:17', '2024-11-13 03:05:22', 32500.00),
(59, 'aziz', '2024-11-13 04:08:34', '2024-11-13 03:08:46', 15300.00),
(60, 'oussema ', '2024-11-13 04:12:01', '2024-11-13 03:12:11', 17000.00),
(61, 'hamza', '2024-11-13 04:16:02', '2024-11-13 03:16:21', 10000.00),
(62, 'hamza', '2024-11-13 04:17:02', '2024-11-13 03:17:09', 10000.00),
(63, 'hamza', '2024-11-13 04:18:06', '2024-11-13 03:18:37', 10000.00),
(64, 'hamza', '2024-11-13 04:43:25', '2024-11-13 03:43:52', 12000.00),
(65, 'hamza', '2024-11-13 04:44:05', NULL, 0.00),
(66, 'hamza', '2024-11-13 04:45:51', NULL, 0.00),
(67, 'hamza', '2024-11-14 01:45:52', '2024-11-14 00:46:16', 11900.00),
(68, 'aziz', '2024-11-14 01:47:18', NULL, 0.00),
(69, 'hamza', '2024-11-14 02:14:19', '2024-11-14 01:14:37', 166200.00),
(70, 'hamza', '2024-11-14 02:15:24', NULL, 0.00),
(71, 'aziz', '2024-11-14 02:16:05', '2024-11-14 01:16:31', 18000.00),
(72, 'aziz', '2024-11-14 02:19:04', '2024-11-14 01:19:35', 33000.00);

-- --------------------------------------------------------

--
-- Structure de la table `serveur`
--

CREATE TABLE `serveur` (
  `id_serveur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `numtel` varchar(15) DEFAULT NULL,
  `motdepasse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `serveur`
--

INSERT INTO `serveur` (`id_serveur`, `nom`, `numtel`, `motdepasse`) VALUES
(1, 'aziz', '1653421', 'ccc'),
(3, 'hamza', '44321987', 'hamza'),
(4, 'salah', '23613313', 'salah'),
(5, 'oussema ', '44321987', 'oussema ');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `idprod` int(11) NOT NULL,
  `nomprod` varchar(50) NOT NULL,
  `quantityprod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`idprod`, `nomprod`, `quantityprod`) VALUES
(1, 'Bonn', 2568),
(2, 'Canette', 164),
(5, 'Gateau', 45),
(7, 'Paket Legere', 5),
(8, 'Paket MontiCarlo', 8),
(9, 'Paket Danhit', 10),
(10, 'Paket Kamel', 9),
(11, 'Paket Mirit/Malboro', 10),
(12, 'Paket Oris / Karillia / قوافل', 30),
(13, 'Paket Oris Double Fusion', 10),
(14, 'Paket Safir', 10),
(15, 'Paket Cristal', 10),
(16, 'Paket Carillia Slimse', 10),
(17, 'Mars Legere', 10);

-- --------------------------------------------------------

--
-- Structure de la table `stockfinale`
--

CREATE TABLE `stockfinale` (
  `nomproduitstock` varchar(255) NOT NULL,
  `quantite` int(255) NOT NULL,
  `idrecetes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `stockfinale`
--

INSERT INTO `stockfinale` (`nomproduitstock`, `quantite`, `idrecetes`) VALUES
('Bonn', 2964, 51),
('Canette', 164, 51),
('Gateau', 45, 51),
('Bonn', 2910, 52),
('Canette', 164, 52),
('Gateau', 45, 52),
('Bonn', 2865, 53),
('Canette', 164, 53),
('Gateau', 45, 53),
('Bonn', 2739, 54),
('Canette', 164, 54),
('Gateau', 45, 54),
('Bonn', 2739, 55),
('Canette', 164, 55),
('Gateau', 45, 55),
('Paket Legere', 10, 55),
('Paket MontiCarlo', 10, 55),
('Paket Danhit', 10, 55),
('Paket Kamel', 10, 55),
('Paket Mirit/Malboro', 10, 55),
('Paket Oris / Karillia / قوافل', 30, 55),
('Paket Oris Double Fusion', 10, 55),
('Paket Safir', 10, 55),
('Paket Cristal', 10, 55),
('Paket Carillia Slimse', 10, 55),
('Bonn', 2739, 56),
('Canette', 164, 56),
('Gateau', 45, 56),
('Paket Legere', 6, 56),
('Paket MontiCarlo', 10, 56),
('Paket Danhit', 10, 56),
('Paket Kamel', 10, 56),
('Paket Mirit/Malboro', 10, 56),
('Paket Oris / Karillia / قوافل', 30, 56),
('Paket Oris Double Fusion', 10, 56),
('Paket Safir', 10, 56),
('Paket Cristal', 10, 56),
('Paket Carillia Slimse', 10, 56),
('Bonn', 2739, 57),
('Canette', 164, 57),
('Gateau', 45, 57),
('Paket Legere', 4, 57),
('Paket MontiCarlo', 10, 57),
('Paket Danhit', 10, 57),
('Paket Kamel', 10, 57),
('Paket Mirit/Malboro', 10, 57),
('Paket Oris / Karillia / قوافل', 30, 57),
('Paket Oris Double Fusion', 10, 57),
('Paket Safir', 10, 57),
('Paket Cristal', 10, 57),
('Paket Carillia Slimse', 10, 57),
('Bonn', 2739, 58),
('Canette', 164, 58),
('Gateau', 45, 58),
('Paket Legere', 5, 58),
('Paket MontiCarlo', 10, 58),
('Paket Danhit', 10, 58),
('Paket Kamel', 10, 58),
('Paket Mirit/Malboro', 10, 58),
('Paket Oris / Karillia / قوافل', 30, 58),
('Paket Oris Double Fusion', 10, 58),
('Paket Safir', 10, 58),
('Paket Cristal', 10, 58),
('Paket Carillia Slimse', 10, 58),
('Bonn', 2739, 59),
('Canette', 164, 59),
('Gateau', 45, 59),
('Paket Legere', 5, 59),
('Paket MontiCarlo', 10, 59),
('Paket Danhit', 10, 59),
('Paket Kamel', 10, 59),
('Paket Mirit/Malboro', 10, 59),
('Paket Oris / Karillia / قوافل', 30, 59),
('Paket Oris Double Fusion', 10, 59),
('Paket Safir', 10, 59),
('Paket Cristal', 10, 59),
('Paket Carillia Slimse', 10, 59),
('Bonn', 2739, 60),
('Canette', 164, 60),
('Gateau', 45, 60),
('Paket Legere', 5, 60),
('Paket MontiCarlo', 8, 60),
('Paket Danhit', 10, 60),
('Paket Kamel', 10, 60),
('Paket Mirit/Malboro', 10, 60),
('Paket Oris / Karillia / قوافل', 30, 60),
('Paket Oris Double Fusion', 10, 60),
('Paket Safir', 10, 60),
('Paket Cristal', 10, 60),
('Paket Carillia Slimse', 10, 60),
('Mars Legere', 10, 60),
('Bonn', 2739, 61),
('Canette', 164, 61),
('Gateau', 45, 61),
('Paket Legere', 5, 61),
('Paket MontiCarlo', 8, 61),
('Paket Danhit', 10, 61),
('Paket Kamel', 10, 61),
('Paket Mirit/Malboro', 10, 61),
('Paket Oris / Karillia / قوافل', 30, 61),
('Paket Oris Double Fusion', 10, 61),
('Paket Safir', 10, 61),
('Paket Cristal', 10, 61),
('Paket Carillia Slimse', 10, 61),
('Mars Legere', 10, 61),
('Bonn', 2739, 62),
('Canette', 164, 62),
('Gateau', 45, 62),
('Paket Legere', 5, 62),
('Paket MontiCarlo', 8, 62),
('Paket Danhit', 10, 62),
('Paket Kamel', 10, 62),
('Paket Mirit/Malboro', 10, 62),
('Paket Oris / Karillia / قوافل', 30, 62),
('Paket Oris Double Fusion', 10, 62),
('Paket Safir', 10, 62),
('Paket Cristal', 10, 62),
('Paket Carillia Slimse', 10, 62),
('Mars Legere', 10, 62),
('Bonn', 2739, 63),
('Canette', 164, 63),
('Gateau', 45, 63),
('Paket Legere', 5, 63),
('Paket MontiCarlo', 8, 63),
('Paket Danhit', 10, 63),
('Paket Kamel', 9, 63),
('Paket Mirit/Malboro', 10, 63),
('Paket Oris / Karillia / قوافل', 30, 63),
('Paket Oris Double Fusion', 10, 63),
('Paket Safir', 10, 63),
('Paket Cristal', 10, 63),
('Paket Carillia Slimse', 10, 63),
('Mars Legere', 10, 63),
('Bonn', 2685, 64),
('Canette', 164, 64),
('Gateau', 45, 64),
('Paket Legere', 5, 64),
('Paket MontiCarlo', 8, 64),
('Paket Danhit', 10, 64),
('Paket Kamel', 9, 64),
('Paket Mirit/Malboro', 10, 64),
('Paket Oris / Karillia / قوافل', 30, 64),
('Paket Oris Double Fusion', 10, 64),
('Paket Safir', 10, 64),
('Paket Cristal', 10, 64),
('Paket Carillia Slimse', 10, 64),
('Mars Legere', 10, 64),
('Bonn', 2622, 67),
('Canette', 164, 67),
('Gateau', 45, 67),
('Paket Legere', 5, 67),
('Paket MontiCarlo', 8, 67),
('Paket Danhit', 10, 67),
('Paket Kamel', 9, 67),
('Paket Mirit/Malboro', 10, 67),
('Paket Oris / Karillia / قوافل', 30, 67),
('Paket Oris Double Fusion', 10, 67),
('Paket Safir', 10, 67),
('Paket Cristal', 10, 67),
('Paket Carillia Slimse', 10, 67),
('Mars Legere', 10, 67),
('Bonn', 2568, 69),
('Canette', 164, 69),
('Gateau', 45, 69),
('Paket Legere', 5, 69),
('Paket MontiCarlo', 8, 69),
('Paket Danhit', 10, 69),
('Paket Kamel', 9, 69),
('Paket Mirit/Malboro', 10, 69),
('Paket Oris / Karillia / قوافل', 30, 69),
('Paket Oris Double Fusion', 10, 69),
('Paket Safir', 10, 69),
('Paket Cristal', 10, 69),
('Paket Carillia Slimse', 10, 69),
('Mars Legere', 10, 69),
('Bonn', 2568, 71),
('Canette', 164, 71),
('Gateau', 45, 71),
('Paket Legere', 5, 71),
('Paket MontiCarlo', 8, 71),
('Paket Danhit', 10, 71),
('Paket Kamel', 9, 71),
('Paket Mirit/Malboro', 10, 71),
('Paket Oris / Karillia / قوافل', 30, 71),
('Paket Oris Double Fusion', 10, 71),
('Paket Safir', 10, 71),
('Paket Cristal', 10, 71),
('Paket Carillia Slimse', 10, 71),
('Mars Legere', 10, 71),
('Bonn', 2568, 72),
('Canette', 164, 72),
('Gateau', 45, 72),
('Paket Legere', 5, 72),
('Paket MontiCarlo', 8, 72),
('Paket Danhit', 10, 72),
('Paket Kamel', 9, 72),
('Paket Mirit/Malboro', 10, 72),
('Paket Oris / Karillia / قوافل', 30, 72),
('Paket Oris Double Fusion', 10, 72),
('Paket Safir', 10, 72),
('Paket Cristal', 10, 72),
('Paket Carillia Slimse', 10, 72),
('Mars Legere', 10, 72);

-- --------------------------------------------------------

--
-- Structure de la table `stockinitial`
--

CREATE TABLE `stockinitial` (
  `nomproduitstock` varchar(255) NOT NULL,
  `quantite` int(255) NOT NULL,
  `idrecetes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `stockinitial`
--

INSERT INTO `stockinitial` (`nomproduitstock`, `quantite`, `idrecetes`) VALUES
('Bonn', 3000, 51),
('Canette', 167, 51),
('Gateau', 46, 51),
('Bonn', 2964, 52),
('Canette', 164, 52),
('Gateau', 45, 52),
('Bonn', 2910, 53),
('Canette', 164, 53),
('Gateau', 45, 53),
('Bonn', 2865, 54),
('Canette', 164, 54),
('Gateau', 45, 54),
('Bonn', 2739, 55),
('Canette', 164, 55),
('Gateau', 45, 55),
('Paket Legere', 10, 55),
('Paket MontiCarlo', 10, 55),
('Paket Danhit', 10, 55),
('Paket Kamel', 10, 55),
('Paket Mirit/Malboro', 10, 55),
('Paket Oris / Karillia / قوافل', 30, 55),
('Paket Oris Double Fusion', 10, 55),
('Paket Safir', 10, 55),
('Paket Cristal', 10, 55),
('Paket Carillia Slimse', 10, 55),
('Bonn', 2739, 56),
('Canette', 164, 56),
('Gateau', 45, 56),
('Paket Legere', 10, 56),
('Paket MontiCarlo', 10, 56),
('Paket Danhit', 10, 56),
('Paket Kamel', 10, 56),
('Paket Mirit/Malboro', 10, 56),
('Paket Oris / Karillia / قوافل', 30, 56),
('Paket Oris Double Fusion', 10, 56),
('Paket Safir', 10, 56),
('Paket Cristal', 10, 56),
('Paket Carillia Slimse', 10, 56),
('Bonn', 2739, 57),
('Canette', 164, 57),
('Gateau', 45, 57),
('Paket Legere', 6, 57),
('Paket MontiCarlo', 10, 57),
('Paket Danhit', 10, 57),
('Paket Kamel', 10, 57),
('Paket Mirit/Malboro', 10, 57),
('Paket Oris / Karillia / قوافل', 30, 57),
('Paket Oris Double Fusion', 10, 57),
('Paket Safir', 10, 57),
('Paket Cristal', 10, 57),
('Paket Carillia Slimse', 10, 57),
('Bonn', 2739, 58),
('Canette', 164, 58),
('Gateau', 45, 58),
('Paket Legere', 10, 58),
('Paket MontiCarlo', 10, 58),
('Paket Danhit', 10, 58),
('Paket Kamel', 10, 58),
('Paket Mirit/Malboro', 10, 58),
('Paket Oris / Karillia / قوافل', 30, 58),
('Paket Oris Double Fusion', 10, 58),
('Paket Safir', 10, 58),
('Paket Cristal', 10, 58),
('Paket Carillia Slimse', 10, 58),
('Bonn', 2739, 59),
('Canette', 164, 59),
('Gateau', 45, 59),
('Paket Legere', 5, 59),
('Paket MontiCarlo', 10, 59),
('Paket Danhit', 10, 59),
('Paket Kamel', 10, 59),
('Paket Mirit/Malboro', 10, 59),
('Paket Oris / Karillia / قوافل', 30, 59),
('Paket Oris Double Fusion', 10, 59),
('Paket Safir', 10, 59),
('Paket Cristal', 10, 59),
('Paket Carillia Slimse', 10, 59),
('Bonn', 2739, 60),
('Canette', 164, 60),
('Gateau', 45, 60),
('Paket Legere', 5, 60),
('Paket MontiCarlo', 10, 60),
('Paket Danhit', 10, 60),
('Paket Kamel', 10, 60),
('Paket Mirit/Malboro', 10, 60),
('Paket Oris / Karillia / قوافل', 30, 60),
('Paket Oris Double Fusion', 10, 60),
('Paket Safir', 10, 60),
('Paket Cristal', 10, 60),
('Paket Carillia Slimse', 10, 60),
('Mars Legere', 10, 60),
('Bonn', 2739, 61),
('Canette', 164, 61),
('Gateau', 45, 61),
('Paket Legere', 5, 61),
('Paket MontiCarlo', 8, 61),
('Paket Danhit', 10, 61),
('Paket Kamel', 10, 61),
('Paket Mirit/Malboro', 10, 61),
('Paket Oris / Karillia / قوافل', 30, 61),
('Paket Oris Double Fusion', 10, 61),
('Paket Safir', 10, 61),
('Paket Cristal', 10, 61),
('Paket Carillia Slimse', 10, 61),
('Mars Legere', 10, 61),
('Bonn', 2739, 62),
('Canette', 164, 62),
('Gateau', 45, 62),
('Paket Legere', 5, 62),
('Paket MontiCarlo', 8, 62),
('Paket Danhit', 10, 62),
('Paket Kamel', 10, 62),
('Paket Mirit/Malboro', 10, 62),
('Paket Oris / Karillia / قوافل', 30, 62),
('Paket Oris Double Fusion', 10, 62),
('Paket Safir', 10, 62),
('Paket Cristal', 10, 62),
('Paket Carillia Slimse', 10, 62),
('Mars Legere', 10, 62),
('Bonn', 2739, 63),
('Canette', 164, 63),
('Gateau', 45, 63),
('Paket Legere', 5, 63),
('Paket MontiCarlo', 8, 63),
('Paket Danhit', 10, 63),
('Paket Kamel', 10, 63),
('Paket Mirit/Malboro', 10, 63),
('Paket Oris / Karillia / قوافل', 30, 63),
('Paket Oris Double Fusion', 10, 63),
('Paket Safir', 10, 63),
('Paket Cristal', 10, 63),
('Paket Carillia Slimse', 10, 63),
('Mars Legere', 10, 63),
('Bonn', 2739, 64),
('Canette', 164, 64),
('Gateau', 45, 64),
('Paket Legere', 5, 64),
('Paket MontiCarlo', 8, 64),
('Paket Danhit', 10, 64),
('Paket Kamel', 9, 64),
('Paket Mirit/Malboro', 10, 64),
('Paket Oris / Karillia / قوافل', 30, 64),
('Paket Oris Double Fusion', 10, 64),
('Paket Safir', 10, 64),
('Paket Cristal', 10, 64),
('Paket Carillia Slimse', 10, 64),
('Mars Legere', 10, 64),
('Bonn', 2685, 65),
('Canette', 164, 65),
('Gateau', 45, 65),
('Paket Legere', 5, 65),
('Paket MontiCarlo', 8, 65),
('Paket Danhit', 10, 65),
('Paket Kamel', 9, 65),
('Paket Mirit/Malboro', 10, 65),
('Paket Oris / Karillia / قوافل', 30, 65),
('Paket Oris Double Fusion', 10, 65),
('Paket Safir', 10, 65),
('Paket Cristal', 10, 65),
('Paket Carillia Slimse', 10, 65),
('Mars Legere', 10, 65),
('Bonn', 2685, 66),
('Canette', 164, 66),
('Gateau', 45, 66),
('Paket Legere', 5, 66),
('Paket MontiCarlo', 8, 66),
('Paket Danhit', 10, 66),
('Paket Kamel', 9, 66),
('Paket Mirit/Malboro', 10, 66),
('Paket Oris / Karillia / قوافل', 30, 66),
('Paket Oris Double Fusion', 10, 66),
('Paket Safir', 10, 66),
('Paket Cristal', 10, 66),
('Paket Carillia Slimse', 10, 66),
('Mars Legere', 10, 66),
('Bonn', 2685, 67),
('Canette', 164, 67),
('Gateau', 45, 67),
('Paket Legere', 5, 67),
('Paket MontiCarlo', 8, 67),
('Paket Danhit', 10, 67),
('Paket Kamel', 9, 67),
('Paket Mirit/Malboro', 10, 67),
('Paket Oris / Karillia / قوافل', 30, 67),
('Paket Oris Double Fusion', 10, 67),
('Paket Safir', 10, 67),
('Paket Cristal', 10, 67),
('Paket Carillia Slimse', 10, 67),
('Mars Legere', 10, 67),
('Bonn', 2622, 68),
('Canette', 164, 68),
('Gateau', 45, 68),
('Paket Legere', 5, 68),
('Paket MontiCarlo', 8, 68),
('Paket Danhit', 10, 68),
('Paket Kamel', 9, 68),
('Paket Mirit/Malboro', 10, 68),
('Paket Oris / Karillia / قوافل', 30, 68),
('Paket Oris Double Fusion', 10, 68),
('Paket Safir', 10, 68),
('Paket Cristal', 10, 68),
('Paket Carillia Slimse', 10, 68),
('Mars Legere', 10, 68),
('Bonn', 2622, 69),
('Canette', 164, 69),
('Gateau', 45, 69),
('Paket Legere', 5, 69),
('Paket MontiCarlo', 8, 69),
('Paket Danhit', 10, 69),
('Paket Kamel', 9, 69),
('Paket Mirit/Malboro', 10, 69),
('Paket Oris / Karillia / قوافل', 30, 69),
('Paket Oris Double Fusion', 10, 69),
('Paket Safir', 10, 69),
('Paket Cristal', 10, 69),
('Paket Carillia Slimse', 10, 69),
('Mars Legere', 10, 69),
('Bonn', 2568, 70),
('Canette', 164, 70),
('Gateau', 45, 70),
('Paket Legere', 5, 70),
('Paket MontiCarlo', 8, 70),
('Paket Danhit', 10, 70),
('Paket Kamel', 9, 70),
('Paket Mirit/Malboro', 10, 70),
('Paket Oris / Karillia / قوافل', 30, 70),
('Paket Oris Double Fusion', 10, 70),
('Paket Safir', 10, 70),
('Paket Cristal', 10, 70),
('Paket Carillia Slimse', 10, 70),
('Mars Legere', 10, 70),
('Bonn', 2568, 71),
('Canette', 164, 71),
('Gateau', 45, 71),
('Paket Legere', 5, 71),
('Paket MontiCarlo', 8, 71),
('Paket Danhit', 10, 71),
('Paket Kamel', 9, 71),
('Paket Mirit/Malboro', 10, 71),
('Paket Oris / Karillia / قوافل', 30, 71),
('Paket Oris Double Fusion', 10, 71),
('Paket Safir', 10, 71),
('Paket Cristal', 10, 71),
('Paket Carillia Slimse', 10, 71),
('Mars Legere', 10, 71),
('Bonn', 2568, 72),
('Canette', 164, 72),
('Gateau', 45, 72),
('Paket Legere', 5, 72),
('Paket MontiCarlo', 8, 72),
('Paket Danhit', 10, 72),
('Paket Kamel', 9, 72),
('Paket Mirit/Malboro', 10, 72),
('Paket Oris / Karillia / قوافل', 30, 72),
('Paket Oris Double Fusion', 10, 72),
('Paket Safir', 10, 72),
('Paket Cristal', 10, 72),
('Paket Carillia Slimse', 10, 72),
('Mars Legere', 10, 72);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `recete`
--
ALTER TABLE `recete`
  ADD PRIMARY KEY (`idrecete`),
  ADD KEY `ididrecetes` (`ididrecetes`);

--
-- Index pour la table `recetes`
--
ALTER TABLE `recetes`
  ADD PRIMARY KEY (`idrecetes`);

--
-- Index pour la table `serveur`
--
ALTER TABLE `serveur`
  ADD PRIMARY KEY (`id_serveur`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idprod`);

--
-- Index pour la table `stockfinale`
--
ALTER TABLE `stockfinale`
  ADD KEY `idrecetes` (`idrecetes`);

--
-- Index pour la table `stockinitial`
--
ALTER TABLE `stockinitial`
  ADD KEY `idrecetes` (`idrecetes`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `recete`
--
ALTER TABLE `recete`
  MODIFY `idrecete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `recetes`
--
ALTER TABLE `recetes`
  MODIFY `idrecetes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `serveur`
--
ALTER TABLE `serveur`
  MODIFY `id_serveur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `recete`
--
ALTER TABLE `recete`
  ADD CONSTRAINT `recete_ibfk_1` FOREIGN KEY (`ididrecetes`) REFERENCES `recetes` (`idrecetes`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stockfinale`
--
ALTER TABLE `stockfinale`
  ADD CONSTRAINT `stockfinale_ibfk_1` FOREIGN KEY (`idrecetes`) REFERENCES `recetes` (`idrecetes`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stockinitial`
--
ALTER TABLE `stockinitial`
  ADD CONSTRAINT `stockinitial_ibfk_1` FOREIGN KEY (`idrecetes`) REFERENCES `recetes` (`idrecetes`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
