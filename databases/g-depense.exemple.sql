-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 18 fév. 2024 à 09:16
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `g-depense`
--

-- --------------------------------------------------------

--
-- Structure de la table `audit`
--

DROP TABLE IF EXISTS `audit`;
CREATE TABLE IF NOT EXISTS `audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `etablissement` int(11) NOT NULL,
  `num_depense` int(11) NOT NULL,
  `ancien_dep` varchar(20) DEFAULT NULL,
  `nouveau_dep` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `audit`
--

INSERT INTO `audit` (`id`, `action`, `date`, `etablissement`, `num_depense`, `ancien_dep`, `nouveau_dep`) VALUES
(1, 'INSERTION', '2024-01-17 15:57:58', 1, 1, NULL, '500'),
(2, 'MODIFICATION', '2024-02-17 15:58:08', 1, 1, '500', '400'),
(3, 'MODIFICATION', '2024-02-17 15:58:36', 1, 1, '400', '600'),
(4, 'INSERTION', '2024-02-17 15:59:26', 2, 2, '600', '2'),
(5, 'SUPPRESSION', '2024-02-17 15:59:39', 2, 2, '2', NULL),
(6, 'INSERTION', '2024-01-17 16:21:44', 2, 3, '600', '1'),
(7, 'INSERTION', '2024-02-17 16:21:44', 1, 4, '1', '64'),
(8, 'INSERTION', '2024-02-17 17:07:41', 1, 5, '64', '10'),
(9, 'INSERTION', '2024-02-17 17:13:21', 1, 6, '10', '1'),
(10, 'SUPPRESSION', '2024-01-17 17:13:34', 1, 6, '1', NULL),
(11, 'SUPPRESSION', '2024-02-17 17:13:38', 1, 5, '10', NULL),
(12, 'SUPPRESSION', '2024-02-17 17:14:37', 1, 4, '64', NULL),
(13, 'INSERTION', '2024-02-17 17:14:45', 1, 7, '1', '4'),
(14, 'MODIFICATION', '2024-01-17 18:34:09', 1, 7, '4', '14'),
(15, 'MODIFICATION', '2024-02-17 18:34:22', 2, 7, '14', '14'),
(16, 'SUPPRESSION', '2024-02-17 18:34:25', 2, 7, '14', NULL),
(17, 'SUPPRESSION', '2024-02-17 18:34:30', 2, 3, '1', NULL),
(18, 'INSERTION', '2024-02-17 18:34:50', 2, 8, '600', '12'),
(19, 'INSERTION', '2024-05-17 19:54:59', 1, 9, '12', '78'),
(20, 'MODIFICATION', '2024-02-18 10:11:25', 1, 8, '12', '12000'),
(21, 'MODIFICATION', '2024-02-18 10:11:38', 1, 9, '78', '7850');

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

DROP TABLE IF EXISTS `depense`;
CREATE TABLE IF NOT EXISTS `depense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etab_id` int(11) NOT NULL,
  `montant` varchar(20) NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `etab_id` (`etab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `depense`
--

INSERT INTO `depense` (`id`, `etab_id`, `montant`, `date_creation`) VALUES
(1, 1, '600', '2024-02-17 14:57:51'),
(8, 1, '12000', '2024-02-17 18:34:50'),
(9, 1, '7850', '2024-02-17 19:54:59');

--
-- Déclencheurs `depense`
--
DROP TRIGGER IF EXISTS `delete_audit_trigger`;
DELIMITER $$
CREATE TRIGGER `delete_audit_trigger` AFTER DELETE ON `depense` FOR EACH ROW INSERT INTO audit VALUES(null,'SUPPRESSION', NOW(), Old.etab_id, Old.id, Old.montant, NULL)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `delete_depense_trigger`;
DELIMITER $$
CREATE TRIGGER `delete_depense_trigger` AFTER DELETE ON `depense` FOR EACH ROW UPDATE etablissement SET budget = budget + Old.montant WHERE id = Old.etab_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_audit_trigger`;
DELIMITER $$
CREATE TRIGGER `insert_audit_trigger` AFTER INSERT ON `depense` FOR EACH ROW BEGIN
    SET @latest_depense = (SELECT montant FROM depense ORDER BY id DESC LIMIT 1 OFFSET 1);
    
    INSERT INTO audit VALUES(null, 'INSERTION', NOW(), New.etab_id, New.id, @latest_depense, New.montant);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_depense_trigger`;
DELIMITER $$
CREATE TRIGGER `insert_depense_trigger` AFTER INSERT ON `depense` FOR EACH ROW UPDATE etablissement SET budget = budget - New.montant WHERE id = New.etab_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_audit_trigger`;
DELIMITER $$
CREATE TRIGGER `update_audit_trigger` AFTER UPDATE ON `depense` FOR EACH ROW INSERT INTO audit VALUES(null,'MODIFICATION', NOW(), New.etab_id, New.id, Old.montant, New.montant)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_depense_trigger`;
DELIMITER $$
CREATE TRIGGER `update_depense_trigger` AFTER UPDATE ON `depense` FOR EACH ROW UPDATE etablissement SET budget = budget - New.montant + Old.montant WHERE id = Old.etab_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `etablissement`
--

DROP TABLE IF EXISTS `etablissement`;
CREATE TABLE IF NOT EXISTS `etablissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `budget` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etablissement`
--

INSERT INTO `etablissement` (`id`, `nom`, `budget`) VALUES
(1, 'NG-tech', '4036'),
(2, 'N-tech', '113012');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `depense`
--
ALTER TABLE `depense`
  ADD CONSTRAINT `depense_ibfk_1` FOREIGN KEY (`etab_id`) REFERENCES `etablissement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
