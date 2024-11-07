-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 07 nov. 2024 à 16:26
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
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `item` varchar(50) NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `item`, `prix`) VALUES
(1, 'Express', 2000.00),
(2, 'Gazouz', 2500.00),
(3, 'Capusin', 2300.00),
(4, 'Direct', 2500.00),
(5, 'Jus dorange', 3500.00),
(6, 'Jus de Fraise', 4200.00);

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
(1, 'Express', 4, 8000.00, 1),
(2, 'Gazouz', 3, 7500.00, 1),
(3, 'Express', 10, 20000.00, 2),
(4, 'Gazouz', 14, 35000.00, 2),
(5, 'Capusin', 1, 2300.00, 3),
(6, 'Gazouz', 2, 5000.00, 3),
(7, 'Jus de Fraise', 1, 4200.00, 3),
(8, 'Direct', 2, 5000.00, 3),
(9, 'Express', 2, 4000.00, 4),
(10, 'Gazouz', 1, 2500.00, 4),
(11, 'Capusin', 1, 2300.00, 4),
(12, 'Jus de Fraise', 4, 16800.00, 4),
(13, 'Express', 5, 10000.00, 10),
(14, 'Gazouz', 4, 10000.00, 10),
(15, 'Capusin', 1, 2300.00, 10),
(16, 'Direct', 1, 2500.00, 10),
(17, 'Jus dorange', 1, 3500.00, 10),
(18, 'Jus de Fraise', 1, 4200.00, 10),
(19, 'Express', 2, 4000.00, 13),
(20, 'Gazouz', 3, 7500.00, 13),
(21, 'Express', 3, 6000.00, 14),
(22, 'Gazouz', 1, 2500.00, 14),
(23, 'Express', 2, 4000.00, 15),
(24, 'Gazouz', 1, 2500.00, 15),
(25, 'Express', 2, 4000.00, 16),
(26, 'Gazouz', 1, 2500.00, 16),
(27, 'Capusin', 1, 2300.00, 16);

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
(1, 'aziz', '2024-11-05 23:58:22', '2024-11-05 22:58:28', 15500.00),
(2, 'ADMIN', '2024-11-06 00:00:35', '2024-11-05 23:00:36', 55000.00),
(3, 'aziz', '2024-11-06 00:19:26', '2024-11-05 23:20:03', 16500.00),
(4, 'aziz', '2024-11-06 00:34:49', '2024-11-05 23:34:57', 25600.00),
(5, 'aziz', '2024-11-07 14:38:40', NULL, 0.00),
(6, 'aziz', '2024-11-07 14:41:20', NULL, 0.00),
(7, 'aziz', '2024-11-07 14:59:38', NULL, 0.00),
(8, 'aziz', '2024-11-07 15:02:53', NULL, 0.00),
(9, 'aziz', '2024-11-07 15:03:50', NULL, 0.00),
(10, 'aziz', '2024-11-07 15:06:05', '2024-11-07 14:06:24', 32500.00),
(11, 'aziz', '2024-11-07 15:36:46', NULL, 0.00),
(12, 'aziz', '2024-11-07 15:41:17', '2024-11-07 14:41:26', 8500.00),
(13, 'aziz', '2024-11-07 15:52:06', '2024-11-07 14:52:11', 11500.00),
(14, 'aziz', '2024-11-07 15:59:00', '2024-11-07 14:59:05', 8500.00),
(15, 'aziz', '2024-11-07 15:59:55', '2024-11-07 14:59:58', 6500.00),
(16, 'aziz', '2024-11-07 16:09:00', '2024-11-07 15:14:20', 8800.00);

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
(2, 'ADMIN', '544564', 'admin');

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
(1, 'Bonn', 3000),
(2, 'Coca', 200);

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
('Bonn', 3000, 14),
('Coca', 200, 14),
('Bonn', 2982, 15),
('Coca', 199, 15),
('Bonn', 2973, 16),
('Coca', 199, 16);

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
('Bonn', 3000, 9),
('Coca', 200, 9),
('aaa', 655, 9),
('Bonn', 3000, 10),
('Coca', 200, 10),
('aaa', 655, 10),
('Bonn', 3000, 11),
('Coca', 200, 11),
('Bonn', 3000, 12),
('Coca', 200, 12),
('Bonn', 3000, 13),
('Coca', 200, 13),
('Bonn', 3000, 14),
('Coca', 200, 14),
('Bonn', 3000, 15),
('Coca', 200, 15),
('Bonn', 3000, 16),
('Coca', 200, 16);

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
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `recete`
--
ALTER TABLE `recete`
  MODIFY `idrecete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `recetes`
--
ALTER TABLE `recetes`
  MODIFY `idrecetes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `serveur`
--
ALTER TABLE `serveur`
  MODIFY `id_serveur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
