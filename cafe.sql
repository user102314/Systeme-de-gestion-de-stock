-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 27 nov. 2024 à 06:26
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

-- --------------------------------------------------------

--
-- Structure de la table `lastlogin`
--

CREATE TABLE `lastlogin` (
  `id` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(30, 'Legere', 350.00, 'dokhan'),
(31, 'Paket Legere', 6500.00, 'dokhan'),
(32, 'MontiCarlo', 450.00, 'dokhan'),
(33, 'Paket MontiCarlo', 8500.00, 'dokhan'),
(34, 'Mars Legere', 300.00, 'dokhan'),
(35, 'Paket Mars Legere', 5000.00, 'dokhan'),
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
(50, 'Cristal', 150.00, 'dokhan'),
(51, 'Paket Cristal', 2500.00, 'dokhan'),
(59, 'Paket Calillia Slims', 3500.00, 'dokhan'),
(60, 'Karillia Slimse', 200.00, 'dokhan');

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
(5, 'oussema ', '44321987', 'aaa');

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
(1, 'Bonn', 1957),
(2, 'Canette', 152),
(5, 'Gateau', 38),
(7, 'Paket Legere', 2),
(8, 'Paket MontiCarlo', -7),
(9, 'Paket Danhit', 6),
(10, 'Paket Kamel', 6),
(11, 'Paket Mirit / Malboro', 2),
(12, 'Paket Oris / Karillia / قوافل', 9),
(13, 'Paket Oris Double Fusion', 10),
(14, 'Paket Safir', 6),
(15, 'Paket Cristal', 7),
(16, 'Paket Calillia Slims', 8),
(17, 'Mars Legere', 14),
(18, 'Legere', 16),
(19, 'Karillia Slimse', 8),
(20, 'Cristal', 8),
(21, 'Safir', 19),
(22, 'Oris Double Fusion', 7),
(23, 'Oris / Karillia / قوافل', 7),
(24, 'Mirit / Malboro', 15),
(25, 'Kamel', 7),
(26, 'Danhit', 16),
(27, 'MontiCarlo', 19),
(28, 'Paket Mars Legere', 6);

-- --------------------------------------------------------

--
-- Structure de la table `stockfinale`
--

CREATE TABLE `stockfinale` (
  `nomproduitstock` varchar(255) NOT NULL,
  `quantite` int(255) NOT NULL,
  `idrecetes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `recete`
--
ALTER TABLE `recete`
  MODIFY `idrecete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recetes`
--
ALTER TABLE `recetes`
  MODIFY `idrecetes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT pour la table `serveur`
--
ALTER TABLE `serveur`
  MODIFY `id_serveur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
