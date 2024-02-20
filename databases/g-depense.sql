-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 20 fév. 2024 à 10:17
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
  `utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `audit`
--

INSERT INTO `audit` (`id`, `action`, `date`, `etablissement`, `num_depense`, `ancien_dep`, `nouveau_dep`, `utilisateur`) VALUES
(25, 'INSERTION', '2024-02-20 12:10:46', 2, 10, NULL, '2500', 1),
(26, 'INSERTION', '2024-02-20 12:10:46', 1, 11, '2500', '3000', 2),
(27, 'INSERTION', '2024-02-20 12:23:52', 2, 12, '3000', '200', 1),
(28, 'MODIFICATION', '2024-02-20 12:24:23', 1, 12, '200', '300', 1),
(29, 'SUPPRESSION', '2024-02-20 12:24:35', 1, 12, '300', NULL, 1),
(30, 'INSERTION', '2024-02-20 12:25:24', 1, 13, '3000', '500', 1),
(31, 'MODIFICATION', '2024-02-20 12:26:37', 1, 13, '500', '5000', 1),
(32, 'SUPPRESSION', '2024-02-20 12:33:55', 2, 10, '2500', NULL, 1),
(33, 'INSERTION', '2024-02-20 12:34:11', 2, 14, NULL, '300', 2),
(34, 'MODIFICATION', '2024-02-20 12:51:33', 1, 14, '300', '350', 1),
(35, 'MODIFICATION', '2024-02-20 13:13:22', 1, 14, '350', '300', 2);

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

DROP TABLE IF EXISTS `depense`;
CREATE TABLE IF NOT EXISTS `depense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etab_id` int(11) NOT NULL,
  `montant` varchar(20) NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `etab_id` (`etab_id`),
  KEY `utilisateur` (`utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `depense`
--

INSERT INTO `depense` (`id`, `etab_id`, `montant`, `utilisateur`, `date_creation`) VALUES
(11, 1, '3000', 2, '2024-02-20 09:10:16'),
(13, 1, '5000', 2, '2024-02-20 12:25:24'),
(14, 1, '300', 2, '2024-02-20 12:34:11');

--
-- Déclencheurs `depense`
--
DROP TRIGGER IF EXISTS `delete_audit_trigger`;
DELIMITER $$
CREATE TRIGGER `delete_audit_trigger` AFTER DELETE ON `depense` FOR EACH ROW INSERT INTO audit VALUES(null,'SUPPRESSION', NOW(), Old.etab_id, Old.id, Old.montant, NULL, Old.utilisateur)
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
    SET @latest_depense = (SELECT montant FROM depense WHERE etab_id = New.etab_id ORDER BY id DESC LIMIT 1 OFFSET 1);
    
    INSERT INTO audit VALUES(null, 'INSERTION', NOW(), New.etab_id, New.id, @latest_depense, New.montant, New.utilisateur);
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
CREATE TRIGGER `update_audit_trigger` AFTER UPDATE ON `depense` FOR EACH ROW INSERT INTO audit VALUES(null,'MODIFICATION', NOW(), New.etab_id, New.id, Old.montant, New.montant, New.utilisateur)
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etablissement`
--

INSERT INTO `etablissement` (`id`, `nom`, `budget`) VALUES
(1, 'NG-tech', '16836'),
(2, 'Google', '112362');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `mot_de_passe` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `nom`, `prenom`, `mot_de_passe`) VALUES
(1, 'mitch@mail.com', 'Mitch', 'Spiron', 'Azerty-123'),
(2, 'malala@mail.com', 'Malala', 'Nirina', 'Azerty-123');

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
